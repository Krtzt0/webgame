<?php
 session_start();
 include('server.php');

    $errors = array();

    if (isset($_POST['login_user'])) {
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);

        if (empty($username)) {
            array_push($errors, "กรุณาใส่ Username");
        }
        if (empty($password)) {
            array_push($errors, "กรุณาใส่ Password");
        }

        if (count($errors) == 0){
            $password = md5($password);
            $query = "SELECT * FROM user WHERE username = '$username' AND password = '$password' ";
            $result = mysqli_query($conn, $query);

            if(mysqli_num_rows($result) == 1){
                $_SESSION['username'] = $username;
                $_SESSION['success'] = "ล็อกอินสำเร็จ";
                header("location: main.php");

                if(mysqli_num_rows($result) == 1){
                    $_SESSION['role'] = $username;
                    $_SESSION['success'] = "ล็อกอินสำเร็จ";
                    header("location: main.php");
                }

            }else{
                array_push($errors,"Username หรือ รหัสผิด");
                $_SESSION['error'] = "Username หรือ รหัสผิด";
                header("location: login.php");
            }
        }
    }

?>