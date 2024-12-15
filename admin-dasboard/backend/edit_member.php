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

        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$product) {
            echo "Product not found.";
            exit();
        }

    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Product ID not specified.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];

    // Check if the password has changed
    if ($password !== $product['password']) {
        // Hash the new password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    } else {
        $hashedPassword = $product['password'];
    }

    try {
        $sql = "UPDATE tbl_member 
                SET username = :username, 
                    password = :password, 
                    email = :email
                WHERE member_id = :id";
        
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        header('location: ../index.php');
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
    <title>Edit Product</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        form {
            max-width: 400px;
            margin: 0 auto;
        }
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }
        input[type="text"], input[type="password"], input[type="email"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        button[type="submit"] {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <h1>Edit member</h1>
    <form action="edit_member.php?id=<?php echo $id; ?>" method="post" enctype="multipart/form-data">

        <label for="username">ชื่อผู้ใช้:</label>
        <input type="text" name="username" value="<?php echo $product['username']; ?>" required>

        <label for="password">รหัสผ่าน:</label>
        <input type="password" name="password" placeholder="กรุณาใส่รหัสผ่านใหม่">

        <label for="email">อีเมล:</label>
        <input type="email" name="email" value="<?php echo $product['email']; ?>" required>

        <button type="submit">Update member</button>
    </form>
</body>
</html>
