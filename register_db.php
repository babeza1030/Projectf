<?php 
    session_start();
    include('server.php');

    $errors = array();
    
    if (isset($_POST['reg_user'])) {
        $c_name= mysqli_real_escape_string($conn, $_POST['c_name']);
        $c_sername= mysqli_real_escape_string($conn, $_POST['c_sername']);
        $c_id = mysqli_real_escape_string($conn, $_POST['c_id']);
        $c_number = mysqli_real_escape_string($conn, $_POST['c_number']);
        $c_password = mysqli_real_escape_string($conn, $_POST['c_password']);

        if (empty($c_name) ) {
            array_push($errors,"Username is required");
        }
        if (empty($c_sername) ) {
            array_push($errors,"Username is required");
        }
        if (empty($c_id) ) {
            array_push($errors,"Username is required");
        }
        if (empty($c_number) ) {
            array_push($errors,"Username is required");
        }
        if (empty($c_password) ) {
            array_push($errors,"Id is required");
        }

        $user_check_query = "SELECT * FROM reg_user WHERE c_name = '$c_name' OR id = 'id' " ;
        $query = mysqli_query($conn, $user_check_query);
        $result = mysqli_fetch_assoc($query);

        if ($result) {
            if ($result['c_name'] === $c_name) {
                array_push($errors, "Username already exists");
            }
            if ($result['c_id'] === $c_id) {
                array_push($errors, "Id already exists");
            }
        }

        if (count($errors) == 0) {
            $password_account = md5($c_password);
            $sql = "INSERT INTO user (c_name,c_sername,c_id,c_number,c_password)" ('$c_name','$c_sername','$c_id','$c_number','$c_password');
            mysqli_query($conn,$sql);

            $_SESSION['username'] = $c_name;
            $_SESSION['success'] = "You are now logged in";
            header('location:index.php');

        }
    }

    ?>