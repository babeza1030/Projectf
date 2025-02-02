<?php
session_start(); // เริ่มต้นเซสชัน
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    
</head>
<body>

    <script src="js/bootstrap.min.js"></script>

    <div class="container">
    <body>

<script src="js/bootstrap.min.js"></script>

<div class="container">

    <header class="box_head">
        <?php if (isset($_SESSION['c_name']) && isset($_SESSION['c_sername'])): ?>
            
           <select id="navigationDropdown">
            <option value="index.php">
            <span>ยินดีต้อนรับ, <?php echo $_SESSION['c_name'] . " " . $_SESSION['c_sername']; ?></span>
            </option>
            <option value="profile.php">แก้ไขโปรไฟล์</option>
            <option value="#">กยศ.</option>
            <option value="#">จิตอาสา</option>
            <option value="logout.php">ออกจากระบบ</option>
           </select>

           <script>
                document.getElementById("navigationDropdown").onchange = function() {
                var selectedLink = this.value;
                if (selectedLink) {
                window.location.href = selectedLink;
                }
            };
            </script>

        <?php else: ?>
                
                <a href="register.php">ลงทะเบียน</a>
                <a href="login.php">เข้าสู่ระบบ</a>
        <?php endif; ?>
    </header>

    <div class="box_logo">
        <img src="all-imh/logo (1).png" alt="">
        <nav>
            <a href="#">หน้าแรก</a>
            <a href="page-1.html">หลักเกณฑ์การกู้ยืม</a>
            <a href="#">ข่าวสาร</a>
            <a href="#">ติดต่อ</a>
        </nav>
    </div>

</body>
</html>

</html>

        <div class="box_menu">
            <img src="all-imh/slide-image-1.jpg" alt="">
            <nav>
                <a href="#">ขอแบบฟอร์มการกู้ยืม</a>
                <a href="#">นักศึกษาเริ่มกู้กับเกษม</a>
                <a href="#">นักศึกษาเก่าในสถาบัน</a>
                <a href="#">ปฏิทินกิจกรรม</a>
            </nav>
        </div>


        <div class="selection">
            <div class="box-face">
                <img src="https://campus.campus-star.com/app/uploads/2015/09/edu.jpg" alt="">
                <p class="box-text">Sample text. Click to select the text box. Click again or double click to start editing the text.</p>
                <a href="#" class="box-button">อ่านต่อ </a>
            </div>
            <div class="box-face">
                <img src="https://campus.campus-star.com/app/uploads/2015/09/edu.jpg" alt="">
                <p class="box-text">Sample text. Click to select the text box. Click again or double click to start editing the text.</p>
                <a href="#" class="box-button">อ่านต่อ </a>
            </div>
            <div class="box-face">
                <img src="https://campus.campus-star.com/app/uploads/2015/09/edu.jpg" alt="">
                <p class="box-text">Sample text. Click to select the text box. Click again or double click to start editing the text.</p>
                <a href="#" class="box-button">อ่านต่อ </a>
            </div>
            <div class="box-face">
                <img src="https://campus.campus-star.com/app/uploads/2015/09/edu.jpg" alt="">
                <p class="box-text">Sample text. Click to select the text box. Click again or double click to start editing the text.</p>
                <a href="#" class="box-button">อ่านต่อ </a>
            </div>
        </div>

        <footer>
            <div class="footer-bar">
                
            </div>
        </footer>

    </div>

</body>
</html>

</html>