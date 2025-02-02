<?php

    session_start();
    require ('server.php');


    if(isset($_POST['submit'])) {
        $c_name = $_POST['c_name'];
        // print_r($c_name);
        $c_sername = $_POST['c_sername'];
        // print_r($c_sername);
        $c_brithday = $_POST['c_brithday'];

        $sql = "UPDATE reg_user SET c_name = '$c_name', c_sername = '$c_sername', c_brithday = '$c_brithday'WHERE c_id = '$c_id' ";
        if ($conn->query($sql) === TRUE) { // เรียกใช้db
            echo "<script>alert('อัพเดทสำเร็จ!');</script>";
            echo "<script>window.location.href='profile.php'</script>";
        } else {
            echo "Error updating record: " . $conn->error;
        }
    }

?>