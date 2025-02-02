import mysql.connector
from mysql.connector import Error

try:
    # Database connection details
    connection = mysql.connector.connect(
        host="localhost",
        user="freedb_adminbabe",
        password="h#45J2g62WHayeB",
        database="freedb_Project_Final"
    )

    if connection.is_connected():
        print("เชื่อมต่อสำเร็จ")  # Connected successfully

except Error as e:
    print(f"เชื่อมต่อไม่ได้: {e}")  # Unable to connect

finally:
    if 'connection' in locals() and connection.is_connected():
        connection.close()
        print("ปิดการเชื่อมต่อ")  # Connection close