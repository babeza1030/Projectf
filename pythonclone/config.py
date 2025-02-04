import os

DB_USERNAME = "freedb_adminbabe"
DB_PASSWORD = "h#45J2g62WHayeB"
DB_NAME = "freedb_Project_Final"
DB_HOST = "sql.freedb.tech"
DB_PORT = "3306"

SQLALCHEMY_DATABASE_URI = f"mysql+pymysql://{DB_USERNAME}:{DB_PASSWORD}@{DB_HOST}:{DB_PORT}/{DB_NAME}"
SQLALCHEMY_TRACK_MODIFICATIONS = False
