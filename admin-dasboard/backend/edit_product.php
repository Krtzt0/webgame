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
       

        $sql = "SELECT * FROM tbl_game_product WHERE game_product_id = :id";
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
    $game_product_name = $_POST['game_product_name'];
    $game_product_details = $_POST['game_product_details'];
    $game_product_price = $_POST['game_product_price'];

    // Handle image upload if needed

    try {
        $sql = "UPDATE tbl_game_product 
                SET game_details_id = :game_details_id, 
                    game_product_name = :game_product_name, 
                    game_product_details = :game_product_details, 
                    game_product_price = :game_product_price
                WHERE game_product_id = :id";
        
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':game_details_id', $game_details_id);
        $stmt->bindParam(':game_product_name', $game_product_name);
        $stmt->bindParam(':game_product_details', $game_product_details);
        $stmt->bindParam(':game_product_price', $game_product_price);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        header('location: ../manage_services.php');
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
        <label for="game_details_id">Game Details ID valo=1 genshin=2:</label>
        <input type="text" name="game_details_id"  value="<?php echo $product['game_details_id']; ?>" required><br>

        <label for="game_product_name">Product Name:</label>
        <input type="text" name="game_product_name" value="<?php echo $product['game_product_name']; ?>" required><br>

        <label for="game_product_details">Product Details:</label>
        <textarea name="game_product_details" required><?php echo $product['game_product_details']; ?></textarea><br>

        <label for="game_product_price">Product Price:</label>
        <input type="number" name="game_product_price" value="<?php echo $product['game_product_price']; ?>" required><br>

        <!-- Add image upload if needed -->

        <button type="submit">Update Product</button>
    </form>
</body>
</html>
