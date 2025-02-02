import hashlib
from flask import Flask, render_template, request, session, redirect, url_for, flash
import mysql.connector
from mysql.connector import Error
import pymysql
import pymysql.cursors
app = Flask(__name__)

# Configure the database connection
def get_mysql_connection():
    try:
        return pymysql.connect(
            host="sql.freedb.tech",
            port=3306,
            user="freedb_adminbabe",
            password="h#45J2g62WHayeB",
            database="freedb_Project_Final",
            cursorclass=pymysql.cursors.DictCursor
        )
    except Error as e:
        print(f"Error connecting to MySQL: {e}")
        return None
#admin

@app.route("/adminlogin", methods=["GET", "POST"])
def adminlogin():
    if request.method == "POST":
        # รับค่าจากฟอร์ม
        username = request.form["username"]
        password = request.form["password"]

        # ตรวจสอบ username และ password (ในที่นี้ใช้ค่าตัวอย่าง)
        if username == "admin" and password == "password123":
            return redirect(url_for("admin_dashboard"))
        else:
            return "Invalid username or password. Please try again."

    return render_template("adminlogin.html")

# หน้า Admin Dashboard (หลังจาก login สำเร็จ)
@app.route("/dashboard")
def admin_dashboard():
    return "Welcome to the Admin Dashboard!"



@app.route("/adminregister", methods=["GET", "POST"])
def adminregister():
    errors = []

    if request.method == 'POST':
        u_id = request.form['username']
        p_id = request.form['password']

        # Validate input
        if not u_id:
            errors.append("Username is required")
        if not p_id:
            errors.append("Password is required")

        if not errors:
            conn = get_mysql_connection()
            if not conn:
                errors.append("Database connection error")
            else:
                try:
                    cursor = conn.cursor()

                    # Check if user already exists
                    query = "SELECT * FROM user WHERE u_id = %s"
                    cursor.execute(query, (u_id,))  # ✅ Corrected tuple syntax
                    user = cursor.fetchone()

                    if user:
                        errors.append("Username already exists")

                    # Register new user if no errors
                    if not errors:
                        hashed_password = hashlib.md5(p_id.encode()).hexdigest()
                        insert_query = """
                            INSERT INTO reg_user (u_id, p_id)
                            VALUES (%s, %s)
                        """
                        cursor.execute(insert_query, (u_id, hashed_password))  # ✅ Corrected hashed password
                        conn.commit()

                        # Store user in session and redirect
                        session['username'] = u_id
                        session['success'] = "You are now logged in"
                        return redirect('/')

                except pymysql.Error as e:  # ✅ Fixed Error handling
                    errors.append(f"Database error: {e}")
                finally:
                    cursor.close()
                    conn.close()

    return render_template('adminregister.html', errors=errors)







@app.route('/login', methods=['GET', 'POST'])
def login():
    if request.method == 'POST':
        c_id = request.form['c_id']
        c_password = request.form['c_password']

        # Connect to the database
        conn = get_mysql_connection()
        if not conn:
            flash('Unable to connect to the database.', 'error')
            return render_template('login.html')

        try:
            cursor = conn.cursor(dictionary=True)  # Use dictionary cursor to access rows as dicts

            # Query to check the user
            query = "SELECT * FROM reg_user WHERE c_id = %s AND c_password = %s"
            cursor.execute(query, (c_id, c_password))
            user = cursor.fetchone()

            if user:
                # Store user details in session
                session['c_id'] = user['c_id']
                session['c_name'] = user['c_name']
                session['c_sername'] = user['c_sername']
                return redirect(url_for('index'))
            else:
                flash('Invalid account ID or password.', 'error')
        except Error as err:
            flash(f"Database error: {err}", 'error')
        finally:
            if conn.is_connected():
                cursor.close()
                conn.close()

    return render_template('login.html')

@app.route('/register', methods=['GET', 'POST'])
def register():
    errors = []

    if request.method == 'POST':
        c_name = request.form['c_name']
        c_sername = request.form['c_sername']
        c_id = request.form['c_id']
        c_number = request.form['c_number']
        c_password = request.form['c_password']

        # Validate input
        if not c_name:
            errors.append("First name is required")
        if not c_sername:
            errors.append("Last name is required")
        if not c_id:
            errors.append("ID is required")
        if not c_number:
            errors.append("Phone number is required")
        if not c_password:
            errors.append("Password is required")

        if not errors:
            conn = get_mysql_connection()
            if not conn:
                errors.append("Database connection error")
            else:
                try:
                    cursor = conn.cursor(dictionary=True)
                
                    # Check if user already exists
                    query = "SELECT * FROM reg_user WHERE c_name = %s OR c_id = %s"
                    cursor.execute(query, (c_name, c_id))
                    user = cursor.fetchone()

                    if user:
                        if user['c_name'] == c_name:
                            errors.append("Username already exists")
                        if user['c_id'] == c_id:
                            errors.append("ID already exists")

                    # Register new user if no errors
                    if not errors:
                        hashed_password = hashlib.md5(c_password.encode()).hexdigest()
                        insert_query = """
                            INSERT INTO reg_user (c_name, c_sername, c_id, c_number, c_password)
                            VALUES (%s, %s, %s, %s, %s)
                        """
                        cursor.execute(insert_query, (c_name, c_sername, c_id, c_number, hashed_password))
                        conn.commit()

                        # Store user in session and redirect
                        session['username'] = c_name
                        session['success'] = "You are now logged in"
                        return redirect('/')

                except Error as e:
                    errors.append(f"Database error: {e}")
                finally:
                    if conn.is_connected():
                        cursor.close()
                        conn.close()

    return render_template('register.html', errors=errors)

@app.route('/')
def index():
    if 'c_name' in session and 'c_sername' in session:
        return render_template('index.html', name=session['c_name'], sername=session['c_sername'])
    return redirect(url_for('login'))

@app.route('/logout')
def logout():
    session.clear()
    return redirect(url_for('login'))

@app.route('/connectdb')
def connectdb():
    conn = get_mysql_connection()
    if conn:
        flash("Database connected successfully.", "success")
        conn.close()
    else:
        flash("Failed to connect to the database.", "error")
    return redirect(url_for('index'))

if __name__ == '__main__':
    app.run(debug=True)
