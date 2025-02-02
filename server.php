<?php 

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "project11";

    $conn = mysqli_connect($servername,$username,$password,$dbname);

    if (!$conn) {
        die("เชื่อมต่อไม่ได้" . mysqli_connect_error());
    }

    
?>