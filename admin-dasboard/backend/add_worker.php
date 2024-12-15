<?php
session_start();
require_once '../../config/db.php';

if (!isset($_SESSION['admin_login'])) {
    $_SESSION['error'] = 'กรุณาเข้าสู่ระบบ!';
    header('location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $member_name = $_POST['member_name'];
    $member_sur = $_POST['member_sur'];
    $email = $_POST['email'];
    $worker_rank = '../../uploads/' . basename($_FILES['worker_rank']['name']);
    $member_idcard = '../../uploads/' . basename($_FILES['member_idcard']['name']);
    $role = $_POST['role'];

    try {
        $sql = "INSERT INTO tbl_member (username, member_name, member_sur, email, member_idcard, worker_rank, birthday, role)
                VALUES (:username, :member_name, :member_sur, :email, :birthday, :member_idcard, worker_rank, :role)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->bindParam(':member_name', $member_name, PDO::PARAM_STR);
        $stmt->bindParam(':member_sur', $member_sur, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':worker_rank', $worker_rank);
        $stmt->bindParam(':member_idcard', $member_idcard);
        $stmt->bindParam(':role', $role, PDO::PARAM_STR);

        if ($stmt->execute()) {
            header('location: ../manage_worker.php');
            exit();
        } else {
            $errorInfo = $stmt->errorInfo();
            echo "Error: " . $errorInfo[2];
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Worker</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <h1>Add New Worker</h1>
    <form action="add_worker.php" method="post" enctype="multipart/form-data">
        <label for="username">Username:</label>
        <input type="text" name="username" required><br>

        <label for="member_name">ชื่อ:</label>
        <input type="text" name="member_name" required><br>

        <label for="member_sur">นามสกุล:</label>
        <input type="text" name="member_sur" required><br>

        <label for="email">อีเมล:</label>
        <input type="text" name="email" required><br>

        <label for="member_idcard">บัตรประชาชน:</label>
        <input type="file" name="member_idcard" required><br>

        <label for="worker_rank">แรงก์ปัจจุบัน:</label>
        <input type="file" name="worker_rank" required><br>
        
        <label for="role">role:</label>
        <input type="role" name="role" value="worker" readonly><br><br>

        <button type="submit">Add Worker</button>
    </form>
</body>
</html>
