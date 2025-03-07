<?php  

    session_start();
    require_once 'config/db.php';

    if (isset($_POST['signup'])) {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $c_password = $_POST['c_password'];
        $birthday = $_POST['birthday'];
        $curdate = date("Y.m.d");
        $role = 'user';

        if (empty($username)) {
            $_SESSION['error'] = 'กรุณากรอกชื่อ';
            header("location: register.php");
        } else if (empty($email)) {
            $_SESSION['error'] = 'กรุณากรอกอีเมล';
            header("location: register.php");
        } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error'] = 'รูปแบบอีเมลไม่ถูกต้อง';
            header("location: register.php");
        } else if (empty($password)) {
            $_SESSION['error'] = 'กรุณากรอกรหัสผ่าน';
            header("location: register.php");
        } else if (empty($birthday)) {
            $_SESSION['error'] = 'โปรดกรอกวันเกิด';
            header("location: register.php");
        } else if ($curdate - $birthday < 16) {
            $_SESSION['error'] = "ไม่สามารถสมัครได้เนื่องจากอายุต่ำกว่า 16 ปี";
            header("location: register.php");
        } else if (strlen($_POST['password']) > 20 || strlen($_POST['password']) < 5) {
            $_SESSION['error'] = 'รหัสผ่านต้องมีความยาวระหว่าง 5 ถึง 20 ตัวอักษร';
            header("location: register.php");
        } else if (empty($c_password)) {
            $_SESSION['error'] = 'กรุณายืนยันรหัสผ่าน';
            header("location: register.php");
        } else if ($password != $c_password) {
            $_SESSION['error'] = 'รหัสผ่านไม่ตรงกัน';
            header("location: register.php");
        } else {
            try {
                // ตรวจสอบว่าชื่อผู้ใช้ซ้ำหรือไม่
                $check_username = $conn->prepare("SELECT username FROM tbl_member WHERE username = :username");
                $check_username->bindParam(":username", $username);
                $check_username->execute();
                $row_username = $check_username->fetch(PDO::FETCH_ASSOC);

                // ตรวจสอบว่าอีเมลซ้ำหรือไม่
                $check_email = $conn->prepare("SELECT email FROM tbl_member WHERE email = :email");
                $check_email->bindParam(":email", $email);
                $check_email->execute();
                $row_email = $check_email->fetch(PDO::FETCH_ASSOC);

                if ($row_username['username'] == $username) {
                    $_SESSION['warning'] = "มีชื่อผู้ใช้นี้อยู่ในระบบแล้ว";
                    header("location: register.php");
                } else if ($row_email['email'] == $email) {
                    $_SESSION['warning'] = "มีอีเมลนี้อยู่ในระบบแล้ว <a href='login.php'>คลิ๊กที่นี่</a> เพื่อเข้าสู่ระบบ";
                    header("location: register.php");
                } else if (!isset($_SESSION['error'])) {
                    $passwordHash = password_hash($password, PASSWORD_DEFAULT);
                    $stmt = $conn->prepare("INSERT INTO tbl_member(username, email, password, role, birthday)
                                            VALUES(:username, :email, :password, :role, :birthday)");
                    $stmt->bindParam(":username", $username);
                    $stmt->bindParam(":email", $email);
                    $stmt->bindParam(":password", $passwordHash);
                    $stmt->bindParam(":role", $role);
                    $stmt->bindParam(":birthday", $birthday);
                    $stmt->execute();
                    $_SESSION['success'] = "สมัครสมาชิกเรียบร้อยแล้ว! <a href='login.php' class='alert-link'>คลิ๊กที่นี่</a> เพื่อเข้าสู่ระบบ";
                    header("location: register.php");
                } else {
                    $_SESSION['error'] = "มีบางอย่างผิดพลาด";
                    header("location: register.php");
                }

            } catch(PDOException $e) {
                echo $e->getMessage();
            }
        }
    }
?>
