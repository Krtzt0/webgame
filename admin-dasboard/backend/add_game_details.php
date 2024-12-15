<?php
session_start();
require_once '../../config/db.php';

if (!isset($_SESSION['admin_login'])) {
    $_SESSION['error'] = 'กรุณาเข้าสู่ระบบ!';
    header('location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   
    $game_details_name = $_POST['game_details_name'];
    $game_details_img = '../game_details_img/' . basename($_FILES['game_details_img']['name']);
    
    if (move_uploaded_file($_FILES['game_details_img']['tmp_name'], $game_details_img)) {
        try {
            $sql = "INSERT INTO tbl_game_details (game_details_name, game_details_img)
                    VALUES (:game_details_name, :game_details_img)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':game_details_name', $game_details_name);
            $stmt->bindParam(':game_details_img', $game_details_img);

            if ($stmt->execute()) {
                $_SESSION['success'] = "Game added successfully!";
                header('location: ../index.php');
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
    <title>Add Game</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <h1>Add New Game</h1>
    <form action="add_game_details.php" method="post" enctype="multipart/form-data">
        
        <label for="game_details_name">Game Name:</label>
        <input type="text" name="game_details_name" required><br>

        <label for="game_details_img">Game Image:</label>
        <input type="file" name="game_details_img" required><br>

        <button type="submit">Add Game</button>
    </form>
</body>
</html>
