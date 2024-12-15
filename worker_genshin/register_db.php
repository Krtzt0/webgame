+<?php 

    session_start();
    require_once 'config/db.php';

    if (isset($_POST['signup'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $c_password = $_POST['c_password'];
        $name = $_POST['name'];
        $surname = $_POST['surname'];

        if (empty($username)) {
            $_SESSION['error'] = 'กรุณากรอกชื่อ';
            header("location: register.php");
        } else if (empty($password)) {
            $_SESSION['error'] = 'กรุณากรอกรหัสผ่าน';
            header("location: register.php");
        }else if (empty($name)) {
            $_SESSION['error'] = 'โปรดกรอกชื่อของท่าน';
            header("location: register.php");
        }else if (empty($surname)) {
            $_SESSION['error'] = 'โปรดกรอกนามสกุลของท่าน';
            header("location: register.php");}
      
        
         else if (strlen($_POST['password']) > 20 || strlen($_POST['password']) < 5) {
            $_SESSION['error'] = 'รหัสผ่านต้องมีความยาวระหว่าง 5 ถึง 20 ตัวอักษร';
            header("location: register.php");
        } else if (empty($c_password)) {
            $_SESSION['error'] = 'กรุณายืนยันรหัสผ่าน';
            header("location: register.php");
        } else if ($password != $c_password) {
            $_SESSION['error'] = 'รหัสผ่านไม่ตรงกัน';
            header("location: register.php");
        } else {
            
                    $passwordHash = password_hash($password, PASSWORD_DEFAULT);
                    $stmt = $conn->prepare("INSERT INTO users(username, password, name, surname, card_img) 
                                            VALUES(:username, :password, :name, :surname,)");
                    $stmt->bindParam(":username",$username);
                    $stmt->bindParam(":password", $passwordHash);
                    $stmt->bindParam(":name", $name);
                    $stmt->bindParam(":surname", $surname);
                    $stmt->bindParam(":card_img", $img);
                    $stmt->execute();
                    $_SESSION['success'] = "สมัครสมาชิกเรียบร้อยแล้ว! <a href='login.php' class='alert-link'>คลิ๊กที่นี่</a> เพื่อเข้าสู่ระบบ";
                    header("location: register.php");
            } 
        }
    


?>