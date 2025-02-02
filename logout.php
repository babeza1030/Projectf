<?php
session_start(); // เริ่มต้นเซสชัน
session_unset(); // ล้างข้อมูลทั้งหมดในเซสชัน
session_destroy(); // ทำลายเซสชัน
header("Location: index.php"); // เปลี่ยนเส้นทางไปหน้า index.php
exit();
?>