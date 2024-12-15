
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
								<div class="product">
									<div class="inner-product">
										<div class="figure-image">
											<a href="valorant-product.php"><img src="dummy/valorant-logo.png" alt="Game 1"></a>
										</div>
										<h3 class="product-title"><a href="#">Valorant</a></h3>
										
										
										<a href="valorant-product.php" class="button">Select Game</a>
										
									</div>
								</div> <!-- .product -->

								<div class="product">
									<div class="inner-product">
										<div class="figure-image">
											<a href="genshin-product.php"><img src="dummy/genshin-logo.jpg" alt="Game 2"></a>
										</div>
										<h3 class="product-title"><a href="#">Genshin Impact</a></h3>
										
										
										<a href="genshin-product.php" class="button">Select Game</a>
										
									</div>
								</div> <!-- .product -->

								

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