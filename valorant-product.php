<?php
session_start();
require_once 'config/db.php';

if (!isset($_SESSION['user_login'])) {
    $_SESSION['error'] = 'กรุณาเข้าสู่ระบบ!';
    header('location: login.php');
}

// Query products from database
$stmt = $conn->prepare("SELECT * FROM tbl_game_product WHERE game_details_id = 1");
$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0,maximum-scale=1">
    <title>IDashop-valorant | Products</title>
    <link href="http://fonts.googleapis.com/css?family=Roboto:100,400,700|" rel="stylesheet" type="text/css">
    <link href="fonts/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="fonts/lineo-icon/style.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="style.css">
</head>
<body class="slider-collapse">
    <?php include 'header2.php'; ?>
    <div class="main-navigation">
        <?php include 'menuindex.php'; ?>
        <div class="mobile-navigation"></div>
    </div>
    <div class="breadcrumbs">
        <div class="container">
            <a href="index-logged.php">Home</a>
            <span>Valorant</span>
        </div>
    </div>

	</div> 
	</div> 
    <main class="main-content">
        <div class="container">
            <div class="page">
                <div class="product-list">
                    <?php foreach ($products as $product): ?>
                        <div class="product">
                            <div class="inner-product">
                                <div class="figure-image">
                                    <a href="#"><img src="admin-dasboard/product_img/<?php echo htmlspecialchars($product['product_img']); ?>" alt="<?php echo htmlspecialchars($product['game_product_name']); ?>"></a>
                                </div>
                                <h3 class="product-title"><a href="#"><?php echo htmlspecialchars($product['game_product_name']); ?></a></h3>
                                <p><?php echo htmlspecialchars($product['game_product_details']); ?> <br> <b>ราคา <?php echo htmlspecialchars($product['game_product_price']); ?> บาท/ขั้น</b></p>
                                <a href="details.php?product_img=<?php echo urlencode($product['product_img']); ?>&game_product_name=<?php echo urlencode($product['game_product_name']); ?>&game_product_details=<?php echo urlencode($product['game_product_details']); ?>&game_product_price=<?php echo urlencode($product['game_product_price']); ?>" class="button">Buy now</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </main>
    <?php include 'footerindex.php'; ?>
    <script src="js/jquery-1.11.1.min.js"></script>
    <script src="js/plugins.js"></script>
    <script src="js/app.js"></script>
</body>
</html>
