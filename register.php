<?php include('server.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="register.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>

    <script src="js/bootstrap.min.js"></script>

    <div class="container">
        <div class="box-black"></div>
        <nav class="header">

            <img src="all-imh/logo (1).png" alt="">
            <h1>ลงทะเบียน</h1>
            <form action="reg_test.php" method="POST">
                <div class="input-box">
                    <label for="id_account"></label>
                    <input type="text" id="c_id" name="c_id" required  placeholder="เลขบัตรประจำตัวประชาชน">
                </div>
                
                <div class="input-box">
                    <label for="username_account"></label>
                    <input type="text" id="c_name" name="c_name" required  placeholder="ชื่อ">

                </div>
                
                <div class="input-box">
                    <label for="sername_account"></label>
                    <input type="text" id="c_sername" name="c_sername" required  placeholder="นามสกุล">
                </div>

                <div class="input-box">
                    <label for="number_account"></label>
                    <input type="text" id="c_number" name="c_number" required  placeholder="เบอร์โทรศัพท์">

                </div>

                <div class="input-box">
                    <label for="password_account"></label>
                    <input type="password" id="c_password" name="c_password" required  placeholder="รหัสผ่าน">

                <button type="submit" class="btn">ลงทะเบียน</button>


                <div class="register-link">
                    <p>มีบัญชีเข้าใช้งานแล้ว
                        <a href="login.php">เข้าใช้งาน</a>
                    </p> 
                </div>
            </form>
        </nav>
    </div>

    
</body>
</html>