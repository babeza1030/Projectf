import hashlib
from flask import Flask, render_template, request, session, redirect, url_for, flash
import pymysql
from pymysql import Error
from flask_sqlalchemy import SQLAlchemy
from sqlalchemy import text

# Initialize Flask app
app = Flask(__name__)
app.config.from_pyfile("config.py")
app.secret_key = "your_secret_key_here"  # ตั้งค่า secret key สำหรับ session

# Initialize Database
db = SQLAlchemy(app)

# Function to establish MySQL connection using PyMySQL
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


# 🔹 ตรวจสอบการเชื่อมต่อฐานข้อมูล
@app.route("/check_dbb")
def check_db():
    try:
        db.session.execute(text("SELECT 1"))
        return "Database Connected Successfully!"
    except Exception as e:
        return f"Database Connection Failed: {str(e)}"



# 🔹 หน้า Login ของ Admin
@app.route("/adminlogin", methods=["GET", "POST"])
def adminlogin():
    print('Hi art')
    if request.method == "POST":
        username = request.form["username"]
        password = request.form["password"]
        hashed_password = hashlib.md5(password.encode()).hexdigest()

        conn = get_mysql_connection()
        if conn:
            try:
                cursor = conn.cursor()
                cursor.execute("SELECT * FROM user WHERE u_id = %s AND p_id = %s", (username, hashed_password))
                user = cursor.fetchone()

                if user:
                    print('GIBI')
                    # session["c_id"] = user["c_id"]
                    # session["c_name"] = user["c_name"]
                    # session["c_sername"] = user["c_sername"]
                    return redirect(url_for("index"))
                else:
                    flash("Invalid account ID or password.", "error")
            except Error as err:
                flash(f"Database error: {err}", "error")
            finally:
                cursor.close()
                conn.close()
        # if username == "admin" and password == "123":
        #     return redirect(url_for("admin_dashboard"))
        # else:
        #     flash("Invalid username or password.", "error")

    return render_template("adminlogin.html")


# 🔹 หน้า Dashboard Admin
@app.route("/dashboard")
def admin_dashboard():
    return "Welcome to the Admin Dashboard!"


# 🔹 Admin Register
@app.route("/adminregister", methods=["GET", "POST"])
def adminregister():
    errors = []
    conn1 = get_mysql_connection()
    cursor1 = conn1.cursor()
    print('HIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIII')
    print(cursor1.execute("SELECT * FROM user"))
    print(cursor1.fetchall())
    print('HIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIII')
    if request.method == "POST":
        u_id = request.form["username"]
        p_id = request.form["password"]

        if not u_id:
            errors.append("Username is required")
        if not p_id:
            errors.append("Password is required")

        if not errors:
            print("Tenlnwza")
            conn = get_mysql_connection()
            if conn:
                print('Babe')
                print(conn)
                try:
                    cursor = conn.cursor()

                    # ตรวจสอบว่าผู้ใช้มีอยู่แล้วหรือไม่
                    cursor.execute("SELECT * FROM user WHERE u_id = %s", (u_id,))
                    user = cursor.fetchone()

                    if user:
                        print('Art')
                        errors.append("Username already exists")
                    else:
                        print('Pet')
                        hashed_password = hashlib.md5(p_id.encode()).hexdigest()
                        cursor.execute("INSERT INTO user (u_id, p_id) VALUES (%s, %s)", (u_id, hashed_password))
                        conn.commit()

                        session["username"] = u_id
                        session["success"] = "You are now logged in"
                        return redirect("/")

                except pymysql.Error as e:
                    print('ไอ้เย็ดแม่')
                    print(conn)
                    errors.append(f"Database error: {e}")
                finally:
                    cursor.close()
                    conn.close()

    return render_template("adminregister.html", errors=errors)


# 🔹 User Login
@app.route("/login", methods=["GET", "POST"])
def login():
    if request.method == "POST":
        c_id = request.form["c_id"]
        c_password = request.form["c_password"]

        conn = get_mysql_connection()
        if conn:
            try:
                cursor = conn.cursor()
                cursor.execute("SELECT * FROM reg_user WHERE c_id = %s AND c_password = %s", (c_id, c_password))
                user = cursor.fetchone()

                if user:
                    session["c_id"] = user["c_id"]
                    session["c_name"] = user["c_name"]
                    session["c_sername"] = user["c_sername"]
                    return redirect(url_for("index"))
                else:
                    flash("Invalid account ID or password.", "error")
            except Error as err:
                flash(f"Database error: {err}", "error")
            finally:
                cursor.close()
                conn.close()

    return render_template("login.html")


# 🔹 User Register
@app.route("/register", methods=["GET", "POST"])
def register():
    errors = []

    if request.method == "POST":
        c_name = request.form["c_name"]
        c_sername = request.form["c_sername"]
        c_id = request.form["c_id"]
        c_number = request.form["c_number"]
        c_password = request.form["c_password"]

        if not all([c_name, c_sername, c_id, c_number, c_password]):
            errors.append("All fields are required")

        if not errors:
            conn = get_mysql_connection()
            if conn:
                try:
                    cursor = conn.cursor()
                    cursor.execute("SELECT * FROM reg_user WHERE c_name = %s OR c_id = %s", (c_name, c_id))
                    user = cursor.fetchone()

                    if user:
                        errors.append("Username or ID already exists")
                    else:
                        hashed_password = hashlib.md5(c_password.encode()).hexdigest()
                        cursor.execute(
                            "INSERT INTO reg_user (c_name, c_sername, c_id, c_number, c_password) VALUES (%s, %s, %s, %s, %s)",
                            (c_name, c_sername, c_id, c_number, hashed_password),
                        )
                        conn.commit()

                        session["username"] = c_name
                        session["success"] = "You are now logged in"
                        return redirect("/")

                except Error as e:
                    errors.append(f"Database error: {e}")
                finally:
                    cursor.close()
                    conn.close()

    return render_template("register.html", errors=errors)


# 🔹 หน้าแรก (ต้อง Login ก่อน)
@app.route("/")
def index():
    if "c_name" in session and "c_sername" in session:
        return render_template("index.html", name=session["c_name"], sername=session["c_sername"])
    return redirect(url_for("login"))


# 🔹 Logout
@app.route("/logout")
def logout():
    session.clear()
    return redirect(url_for("login"))


# 🔹 Test Database Connection
@app.route("/connectdb")
def connectdb():
    conn = get_mysql_connection()
    if conn:
        flash("Database connected successfully.", "success")
        conn.close()
    else:
        flash("Failed to connect to the database.", "error")
    return redirect(url_for("index"))


# 🔹 Start Flask App
if __name__ == "__main__":
    app.run(debug=True)
