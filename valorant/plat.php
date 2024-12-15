<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0,maximum-scale=1">
		
		<title>Valorant | Platinum</title>

		<!-- Loading third party fonts -->
		<link href="http://fonts.googleapis.com/css?family=Roboto:100,300,400,700|" rel="stylesheet" type="text/css">
		<link href="fonts/font-awesome.min.css" rel="stylesheet" type="text/css">
		<link href="fonts/lineo-icon/style.css" rel="stylesheet" type="text/css">

		<!-- Loading main css file -->
		<link rel="stylesheet" href="../style.css">
		
		<!--[if lt IE 9]>
		<script src="js/ie-support/html5.js"></script>
		<script src="js/ie-support/respond.js"></script>
		<![endif]-->

	</head>


	<body>
		
		<div id="site-content">
		<?php include'../header3.php';?>

					<div class="main-navigation">
						<button class="toggle-menu"><i class="fa fa-bars"></i></button>
						
						<?php include'../menuindex.php';?>


						<div class="mobile-navigation"></div> <!-- .mobile-navigation -->
					</div> <!-- .main-navigation -->

					<div class="breadcrumbs">
						<div class="container">
							<a href="../index-logged.php">Home</a>
							<a href="../valorant-product.php">Valorant</a>
							<span>บูสแรงก์ Platinum</span>
						</div>
					</div>
				</div> <!-- .container -->
			</div> <!-- .site-header -->
			
			<main class="main-content">
				<div class="container">
					<div class="page">
						
						<div class="entry-content">
							<div class="row">
								<div class="col-sm-6 col-md-4">
									<div class="product-images">
										<figure class="large-image">
										<img src="../images/Platinum_3_Rank.png" alt="Game 5">
										</figure>
										
									</div>
								</div>
								<div class="col-sm-6 col-md-8">
									<h2 class="entry-title">บูสแรงก์ Plat ขั้นละ 100</h2>
									<small class="price">100 THB</small>

									
									

									<div class="addtocart-bar">
									<form action="../backend-index/saveorder.php" method="post" enctype="multipart/form-data">
											<h2><b>กรอกรายละเอียดข้อมูล</b></h2>
											<input type="text" name="Rank valo" value="Boost Rank Plat" placeholder="Boost Rank Plat" readonly>
										
											<select name="Work_detail" onchange="totalbronze(this.value)">
												<option value="">เลือกระดับที่ต้องการ</option>
												<option value="1">Platinum1-Platinum2</option>
												<option value="1">Platinum2-Platinum3</option>
												<option value="3">Platinum1-Platinum3</option>
											</select>
											<br><br>
											<div class="form-group">
											<input type="text" name="usergame" placeholder="กรอก Username" >
												</div>
												<div class="form-group">
											<input type="text" name="passgame" placeholder="กรอก Password">	
												</div>
												อัพโหลดหลักฐานการชำระเงิน
											  <div class="form-group">	
                          					<input type="file" name="m_img" class="form-control" placeholder="สลิป" required="" >
												</div>
											   <div class="form-group">	
											<input type="text" id="total" name="price" readonly>&nbsp;บาท <br>
											    </div>
												<div class="form-group">
											<input type="submit" value="ซื้อเลย" id="buy" name="PlatBuy">
											   </div>
										</form>
										<script>
											function totalbronze(val)
												{
 												 var t=val*100;  
  													document.getElementById("total") . value=t;
												}
										</script>

										
									</div>
								</div>
							</div>
						</div>
						
						<section>
						

						
					</div>
				</div> <!-- .container -->
			</main> <!-- .main-content -->
			<?php include'../footerindex.php';?>
			
		<script src="js/jquery-1.11.1.min.js"></script>
		<script src="js/plugins.js"></script>
		<script src="js/app.js"></script>
		
	</body>

</html>