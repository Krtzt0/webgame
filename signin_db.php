<?php 
    session_start();
    require_once 'config/db.php';

    if (isset($_POST['signin'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

      
        if (empty($username)) {
            $_SESSION['error'] = 'กรุณากรอก username';
            header("location: login.php");
        } else if (empty($password)) {
            $_SESSION['error'] = 'กรุณากรอกรหัสผ่าน';
            header("location: login.php");
        } else if (strlen($_POST['password']) > 20 || strlen($_POST['password']) < 5) {
            $_SESSION['error'] = 'รหัสผ่านต้องมีความยาวระหว่าง 5 ถึง 20 ตัวอักษร';
            header("location: login.php");
        } else {
            try {

                $check_data = $conn->prepare("SELECT * FROM tbl_member WHERE username = :username");
                $check_data->bindParam(":username", $username);
                $check_data->execute();
                $row = $check_data->fetch(PDO::FETCH_ASSOC);

                if ($check_data->rowCount() > 0) {

                    if ($username == $row['username']) {
                        if (password_verify($password, $row['password'])) {
                            if ($row['role'] == 'admin') {
                                $_SESSION['admin_login'] = $row['member_id'];
                                header("location: ./admin-dasboard/index.php");
                            } 
                            elseif ($row['game_details_id'] == '1'){
                                $_SESSION['worker_login'] = $row['member_id'];
                                header("location: worker/index.php");
                            }

                            elseif ($row['game_details_id'] == '2'){
                                $_SESSION['worker_login'] = $row['member_id'];
                                header("location: worker/index.php");
                            }
                            
                            else {
                                $_SESSION['user_login'] = $row['member_id'];
                                header("location: index-logged.php");
                            }
                        } else {
                            $_SESSION['error'] = 'รหัสผ่านผิด';
                            header("location: login.php");
                        }
                    } else {
                        $_SESSION['error'] = 'อีเมลผิด';
                        header("location: login.php");
                    }
                } else {
                    $_SESSION['error'] = "ไม่มี Username นี้ในระบบ";
                    header("location: login.php");
                }

            } catch(PDOException $e) {
                echo $e->getMessage();
            }
        }
    }


?>