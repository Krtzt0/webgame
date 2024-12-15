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
       

        $sql = "SELECT * FROM tbl_game_details WHERE game_details_id = :id";
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
    $game_details_id = $_POST['game_details_id'];
    $game_details_name = $_POST['game_details_name'];
    $game_details_img = $_POST['game_details_img'];


    // Handle image upload if needed

    try {
        $sql = "UPDATE tbl_game_details 
                SET game_details_id = :game_details_id, 
                    game_details_name = :game_details_name, 
                    game_details_img = :game_details_img, 
                WHERE game_product_id = :id";
        
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':game_details_id', $game_details_id);
        $stmt->bindParam(':game_details_name', $game_details_name);
        $stmt->bindParam(':game_details_img', $game_details_img);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        header('location: ../manage_game_detail.php');
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
</head>
<body>
    <h1>Edit Product</h1>
    <form action="edit_product.php?id=<?php echo $id; ?>" method="post" enctype="multipart/form-data">
        
        <label for="game_details_name">Game Name:</label>
        <input type="text" name="game_details_name" value="<?php echo $product['game_details_name']; ?>" required><br>

        <!-- Add image upload if needed -->

        <button type="submit">Update Product</button>
    </form>
</body>
</html>
