<?php
session_start();
require_once '../../config/db.php';

if (!isset($_SESSION['admin_login'])) {
    $_SESSION['error'] = 'กรุณาเข้าสู่ระบบ!';
    header('location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $game_details_id = $_POST['game_details_id'];
    $game_product_name = $_POST['game_product_name'];
    $game_product_details = $_POST['game_product_details'];
    $game_product_price = $_POST['game_product_price'];
    $product_img = '../product_img/' . basename($_FILES['product_img']['name']);
    
    if (move_uploaded_file($_FILES['product_img']['tmp_name'], $product_img)) {
        try {
            $sql = "INSERT INTO tbl_game_product (game_details_id, game_product_name, game_product_details, game_product_price, product_img)
                    VALUES (:game_details_id, :game_product_name, :game_product_details, :game_product_price, :product_img)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':game_details_id', $game_details_id);
            $stmt->bindParam(':game_product_name', $game_product_name);
            $stmt->bindParam(':game_product_details', $game_product_details);
            $stmt->bindParam(':game_product_price', $game_product_price);
            $stmt->bindParam(':product_img', $product_img);

            if ($stmt->execute()) {
                $_SESSION['success'] = "Product added successfully!";
                header('location: ../manage_services.php');
                exit();
            } else {
                $errorInfo = $stmt->errorInfo();
                echo "Error: " . $errorInfo[2];
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    } else {
        echo "Failed to upload image.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <h1>Add New Product</h1>
    <form action="add_product.php" method="post" enctype="multipart/form-data">
        <label for="game_details_id">Game Details ID:</label>
        <input type="text" name="game_details_id" placeholder="1= valo 2=genshin" required><br>

        <label for="game_product_name">Product Name:</label>
        <input type="text" name="game_product_name" required><br>

        <label for="game_product_details">Product Details:</label>
        <textarea name="game_product_details" required></textarea><br>

        <label for="game_product_price">Product Price:</label>
        <input type="number" name="game_product_price" required><br>

        <label for="product_img">Product Image:</label>
        <input type="file" name="product_img" required><br>

        <button type="submit">Add Product</button>
    </form>
</body>
</html>
