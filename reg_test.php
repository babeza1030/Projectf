<?php
include "server.php";

// ตรวจสอบการเชื่อมต่อฐานข้อมูล
if (!$conn) {
    die("Connection error: " . mysqli_connect_error());
}

// Debugging: ตรวจสอบข้อมูลที่ได้รับจากฟอร์ม
echo '<pre>';
print_r($_POST);
echo '</pre>';

// ตรวจสอบค่าว่ามีการส่งเข้ามาหรือไม่
$c_id = !empty($_POST['c_id']) ? $_POST['c_id'] : null;
$c_name = !empty($_POST['c_name']) ? $_POST['c_name'] : null;
$c_sername = !empty($_POST['c_sername']) ? $_POST['c_sername'] : null;
$c_number = !empty($_POST['c_number']) ? $_POST['c_number'] : null;
$c_password = !empty($_POST['c_password']) ? $_POST['c_password'] : null;

// ตรวจสอบค่าว่ามีการส่งเข้ามาครบหรือไม่
if ($c_id && $c_name && $c_sername && $c_number && $c_password) {
    
    // ใช้ Prepared Statements เพื่อป้องกัน SQL Injection
    $sql = "INSERT INTO reg_user (c_id, c_name, c_sername, c_number, c_password) VALUES (?, ?, ?, ?, ?)";
    
    // เตรียม SQL statement
    $stmt = mysqli_prepare($conn, $sql);

    // ตรวจสอบว่า statement ถูกสร้างสำเร็จหรือไม่
    if ($stmt === false) {
        die("Error preparing statement: " . mysqli_error($conn));
    }

    // ผูกค่าเข้ากับคำสั่ง SQL
    mysqli_stmt_bind_param($stmt, "sssss", $c_id, $c_name, $c_sername, $c_number, $c_password);

    // ดำเนินการคำสั่ง SQL
    if (mysqli_stmt_execute($stmt)) {
        echo "บันทึกข้อมูลสำเร็จ!";
    } else {
        echo "เกิดข้อผิดพลาดในการบันทึกข้อมูล: " . mysqli_error($conn);
    }

    // ปิดการเชื่อมต่อ
    mysqli_stmt_close($stmt);

} else {
    echo "กรุณากรอกข้อมูลให้ครบถ้วน!";
}

// ปิดการเชื่อมต่อฐานข้อมูล
mysqli_close($conn);
?>
