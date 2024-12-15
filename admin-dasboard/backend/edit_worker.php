<?php
session_start();
require_once '../../config/db.php';

if (!isset($_SESSION['admin_login'])) {
    $_SESSION['error'] = 'กรุณาเข้าสู่ระบบ!';
    header('location: login.php');
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    try {
        $sql = "SELECT * FROM tbl_member WHERE member_id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        $worker = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$worker) {
            echo "Worker not found.";
            exit();
        }

    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Worker ID not specified.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $member_name = $_POST['member_name'];
    $member_sur = $_POST['member_sur'];
    $email = $_POST['email'];
    $member_idcard = $_FILES['member_idcard']['name']; 
    $member_idcard_tmp = $_FILES['member_idcard']['tmp_name']; 
    $worker_rank = $_FILES['worker_rank']['name']; 
    $worker_rank_tmp = $_FILES['worker_rank']['tmp_name']; 
    $birthday = $_POST['birthday'];
    $password = $_POST['password'];

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

  

    try {
        $sql = "UPDATE tbl_member
                SET username = :username, 
                    member_name = :member_name, 
                    member_sur = :member_sur, 
                    email = :email, 
                    member_idcard = :member_idcard,
                    worker_rank = :worker_rank,
                    birthday = :birthday, 
                    password = :password
                WHERE member_id = :id";
        
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':member_name', $member_name);
        $stmt->bindParam(':member_sur', $member_sur);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':birthday', $birthday);
        $stmt->bindParam(':worker_rank', $worker_rank);
        $stmt->bindParam(':member_idcard', $member_idcard);
        $stmt->bindParam(':password', $hashed_password); // ใช้รหัสผ่านที่ถูกแฮช
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        move_uploaded_file($member_idcard_tmp, "../../uploads" . $member_idcard);
        // อัพโหลดไฟล์ worker_rank
        move_uploaded_file($worker_rank_tmp, "../../uploads" . $worker_rank);

        header('location: ../manage_worker.php');
        exit();

    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Worker</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <h1>Edit Worker</h1>
    <form action="edit_worker.php?id=<?php echo $id; ?>" method="post" enctype="multipart/form-data">
        <label for="username">Username:</label>
        <input type="text" name="username" value="<?php echo $worker['username']; ?>" required><br>

        <label for="password">Password:</label>
        <input type="text" name="password" required><br> 

        <label for="member_name">ชื่อ:</label>
        <input type="text" name="member_name" value="<?php echo $worker['member_name']; ?>" required><br>

        <label for="member_sur">นามสกุล:</label>
        <input type="text" name="member_sur" value="<?php echo $worker['member_sur']; ?>" required><br>

        <label for="email">อีเมล:</label>
        <input type="text" name="email" value="<?php echo $worker['email']; ?>" required><br>

        <label for="member_idcard">บัตรประชาชน:</label>
        <?php if ($worker['member_idcard']): ?>
            <br><img src="<?php echo $worker['member_idcard']; ?>" alt="ID Card" width="150"><br>
        <?php endif; ?>
        <input type="file" name="member_idcard"><br>

        <label for="worker_rank">แรงก์ปัจจุบัน:</label>
        <?php if ($worker['worker_rank']): ?>
            <br><img src="<?php echo $worker['worker_rank']; ?>" alt="Worker Rank" width="150"><br>
        <?php endif; ?>
        <input type="file" name="worker_rank"><br>

        <label for="birthday">วันเกิด:</label>
        <input type="date" name="birthday" value="<?php echo $worker['birthday']; ?>" required><br>

        <button type="submit">Update Worker</button>
    </form>
</body>
</html>
