<?php

session_start();

include 'server.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $c_id = $_POST['c_id'];
    $c_password = $_POST['c_password'];

    // print_r($c_id);
    // print_r($password_id);

    // สร้างคำสั่ง SQL
    $sql = "SELECT * FROM reg_user WHERE c_id = '$c_id' AND c_password = '$c_password'";

    // รันคำสั่ง SQL
    $result = $conn->query($sql);

    print_r($result);

    if ($result->num_rows > 0) {
        // เก็บข้อมูลผู้ใช้ในเซสชัน
        $user = $result->fetch_assoc();
        $_SESSION['c_id'] = $c_id;
        $_SESSION['c_name'] = $user['c_name'];
        $_SESSION['c_sername'] = $user['c_sername'];
        // เปลี่ยนเส้นทางไปหน้า index.php
        header("Location: index.php");
        exit(); // สิ้นสุดการทำงานของสคริปต์
    } else {
        echo "Invalid account ID or password.";
    }

    // ปิดการเชื่อมต่อ
    $conn->close();
}


    
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>กองทุน</title>
    <link rel="stylesheet" href="login.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>

    <script src="js/bootstrap.min.js"></script>

    <div class="container">
        <nav class="header">
            <img src="logo (1).png" alt="">
            <h1>เข้าสู่ระบบ</h1>
                
                <form method="POST" action="">
                    <div class="input-box">
                        <label for="c_id"></label>
                        <input type="text" name="c_id" placeholder="เลขบัตรประจำตัวประชาชน" required>
                    </div>

                    <div class="input-box">
                        <label for="c_password"></label>
                        <input type="password" name="c_password" placeholder="รหัสผ่าน" required>
                    </div>

                    <button type="submit" class="btn">เข้าสู่ระบบ</button>
                </form>

                <div class="remember-forgot">
                    <label> <input type="checkbox">จดจำฉันไว้</label>
                    <a href="#">ลืมรหัสผ่าน</a>
                </div>


                <div class="register-link">
                    <p>ยังไม่มีชื่อผู้ใช้งาน
                        <a href="register.php">ลงทะเบียนขอสิทธิ์เข้าใช้งาน</a>
                    </p> 
                </div>

                <div class="register-link-2">
                    <a href="#">เข้าสู่ระบบสำหรับเจ้าหน้าที่</a>
                </div>

        </nav>
        <div class="box-black"></div>
    </div>
</body>
</html>
