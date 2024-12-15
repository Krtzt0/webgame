<?php
session_start();
require_once 'config/db.php';

// ตรวจสอบการเข้าสู่ระบบของสมาชิก
if (!isset($_SESSION['worker_login'])) {
    $_SESSION['error'] = 'กรุณาเข้าสู่ระบบ!';
    header('location: login.php');
    exit();
}

$worker_id = $_SESSION['worker_login'];

// คิวรี่ข้อมูลสมาชิกจากฐานข้อมูล
try {
    $sql = "SELECT * FROM tbl_member WHERE member_id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $user_id);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        echo "User not found.";
        exit();
    }

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $member_name = $_POST['member_name'];
    $member_sur = $_POST['member_sur'];
    $password = $_POST['password'];

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // จัดการอัปโหลดรูปโปรไฟล์
    $member_img = $user['member_img']; // ตั้งค่าพื้นฐานเป็นรูปเก่าที่มีอยู่
    if (isset($_FILES['member_img']['name']) && $_FILES['member_img']['name'] != "") {
        $target_dir = "../uploads/";
        $target_file = $target_dir . basename($_FILES["member_img"]["name"]);
        if (move_uploaded_file($_FILES["member_img"]["tmp_name"], $target_file)) {
            $member_img = $target_file;
        }
    }

    // จัดการอัปโหลดรูปแรงก์
    $worker_rank = $user['worker_rank']; // ตั้งค่าพื้นฐานเป็นข้อมูลเก่าที่มีอยู่
    if (isset($_FILES['worker_rank']['name']) && $_FILES['worker_rank']['name'] != "") {
        $target_file_rank = $target_dir . basename($_FILES["worker_rank"]["name"]);
        if (move_uploaded_file($_FILES["worker_rank"]["tmp_name"], $target_file_rank)) {
            $worker_rank = $target_file_rank;
        }
    }

    try {
        $sql = "UPDATE tbl_member
                SET username = :username, 
                    member_name = :member_name, 
                    member_sur = :member_sur, 
                    password = :password,
                    member_img = :member_img,
                    worker_rank = :worker_rank
                WHERE member_id = :id";
        
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':member_name', $member_name);
        $stmt->bindParam(':member_sur', $member_sur);
        $stmt->bindParam(':password', $hashed_password);
        $stmt->bindParam(':member_img', $member_img);
        $stmt->bindParam(':worker_rank', $worker_rank);
        $stmt->bindParam(':id', $user_id);
        $stmt->execute();

        $_SESSION['success'] = "Profile updated successfully!";
        header('location: profile.php');
        exit();

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
    <title>Edit Profile</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <h1>Edit Profile</h1>
    <form action="edit_profile.php" method="post" enctype="multipart/form-data">
        <label for="username">Username:</label>
        <input type="text" name="username" value="<?php echo $user['username']; ?>" required><br>

        <label for="password">Password:</label>
        <input type="password" name="password" required><br>

        <label for="member_name">ชื่อ:</label>
        <input type="text" name="member_name" value="<?php echo $user['member_name']; ?>" required><br>

        <label for="member_sur">นามสกุล:</label>
        <input type="text" name="member_sur" value="<?php echo $user['member_sur']; ?>" required><br>

        <label for="member_img">รูปโปรไฟล์:</label>
        <?php if ($user['member_img']): ?>
            <br><img src="<?php echo $user['member_img']; ?>" alt="Profile Image" width="150"><br>
        <?php endif; ?>
        <input type="file" name="member_img"><br>

        <label for="worker_rank">แรงก์ปัจจุบัน:</label>
        <?php if ($user['worker_rank']): ?>
            <br><img src="<?php echo $user['worker_rank']; ?>" alt="Worker Rank" width="150"><br>
        <?php endif; ?>
        <input type="file" name="worker_rank"><br>

        <button type="submit">Update Profile</button>
    </form>
</body>
</html>
