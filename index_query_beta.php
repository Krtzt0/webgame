<?php
session_start();
require_once 'config/db.php';


try {
    $sql = "SELECT game_details_id, game_details_name, game_details_img FROM tbl_game_details";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $games = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0,maximum-scale=1">
		
		<title>IDashop-Main</title>

		<!-- Loading third party fonts -->
		<link href="http://fonts.googleapis.com/css?family=Roboto:100,300,400,700|" rel="stylesheet" type="text/css">
		<link href="fonts/font-awesome.min.css" rel="stylesheet" type="text/css">
		<link href="fonts/lineo-icon/style.css" rel="stylesheet" type="text/css">

		<!-- Loading main css file -->
		<link rel="stylesheet" href="style.css">
		
		<!--[if lt IE 9]>
		<script src="js/ie-support/html5.js"></script>
		<script src="js/ie-support/respond.js"></script>
		<![endif]-->

	</head>


	<body class="slider-collapse">

		<?php include'header.php';?>
		

					<div class="main-navigation">
					

						<?php include 'menuindex.php'; ?>
					

						<div class="mobile-navigation"></div> <!-- .mobile-navigation -->
					</div> <!-- .main-navigation -->
				</div> <!-- .container -->
			</div> <!-- .site-header -->

		<div class="home-slider">
			<div class="slide-container">
				
      <div class="slideshow-container">
        <div class="mySlides fade">
         <img src="dummy/slide-k4.png" style="width:100%">
        </div>
        
        <div class="mySlides fade">
          <img src="dummy/slide-k2.png" style="width:100%">
        </div>
        
       
    </div>
        </div>
        <br>
       
			</div> <!-- .home-slider -->

			<main class="main-content">
				<div class="container">
					<div class="page">
						<section>
							<header>
								<h2 class="section-title">Game Catalogs</h2>
								<a href="#" class="all">Show All</a>
							</header>

							<div class="product-list">
        						<?php foreach ($games as $game): ?>
            						<div class="product">
                						<div class="inner-product">
                  						  <div class="figure-image">
                       						 <a href="product.php?id=<?php echo $game['game_details_id']; ?>">
												<img src="admin-dasboard/game_details_img/<?php echo htmlspecialchars($game['game_details_img']); ?>" alt="<?php echo htmlspecialchars($game['game_details_name']); ?>">
                       							 </a>
                    								</div>
                    							<h3 class="product-title">
                       						 <a href="product.php?id=<?php echo $game['game_details_id']; ?>">
                           				 <?php echo htmlspecialchars($game['game_details_name']); ?>
                       				 </a>
                    				</h3>
                   				 <a href="product.php?id=<?php echo $game['game_details_id']; ?>" class="button">Select Game</a>
                				</div>
            					</div> <!-- .product -->
        					<?php endforeach; ?>
    					</div> <!-- .product-list -->
							</div> <!-- .product-list -->
						</section>

						
								
								
								

						</section>
					</div>
				</div> <!-- .container -->
			</main> <!-- .main-content -->

			<?php include 'footerindex.php'; ?>

	
		<script src="js/jquery-1.11.1.min.js"></script>
		<script src="js/plugins.js"></script>
		<script src="js/script.js"></script>
	</body>

</html>