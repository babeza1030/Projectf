<?php
session_start(); // เริ่มต้นเซสชัน มีหน้าที่ในการรับส่งข้อมูลโดยขึ้นอยู่กับตัวแปร
require 'server.php';

if ($_SESSION['c_id'] == "") {
    $_SESSION['error'] = 'กรุณาเข้าสู่ระบบ!';
    header("location: login.php");
} else {
    ?>


    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
        <link rel="stylesheet" href="profile.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="stylesheet" href="css/bootstrap.min.css">
    </head>

    <body>
        <div class="container">

            <?php include('Template/header.php'); ?>

            <div class="db_form">

                <?php

                $c_id = $_SESSION['c_id'];
                $sql = "SELECT * FROM `reg_user` WHERE c_id = '$c_id'";
                $result = $conn->query($sql);
                // print_r($result);
            
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        // print_r($row);
            
                        ?>
                        <!-- แสดงฟอร์มข้อมูล -->
                        <form action="profile_edit.php" method="POST">
                            <h2>ข้อมูลส่วนตัว</h2>
                            <label for="c_title">คำนำหน้า :</label>
                            <select name="c_title">
                                <option value="นาย">นาย</option>
                                <option value="นาง">นาง</option>
                                <option value="นางสาว">นางสาว</option>
                            </select><br>

                            <label for="c_name">ชื่อ :</label>
                            <input type="text" name="c_name" value="<?php echo $row['c_name']; ?>" required><br>

                            <label for="c_sername">นามสกุล :</label>
                            <input type="text" name="c_sername" value="<?php echo $row['c_sername']; ?>" required><br>

                            <label for="c_id">เลขบัตรประจำตัวประชาชน :</label>
                            <?php echo $row['c_id']; ?><br>

                            <label for="c_brithday">วัน-เดือน-ปีเกิด :</label>
                            <input type="date" name="c_brithday" value="<?php echo $row['c_brithday']; ?>" required><br>


                            <button type="submit" name="submit" id="submit" class="btn btn-success">บันทึกข้อมูล</button>
                        </form>

                        <?php
                    }
                }
                ?>

            </div>
        </div>
        </div>
    </body>

    </html>

    <?php
}
?>