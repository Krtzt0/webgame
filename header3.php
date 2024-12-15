<?php
session_start();
   require_once 'config/db.php';
   if (!isset($_SESSION['user_login'])) {
       $_SESSION['error'] = 'กรุณาเข้าสู่ระบบ!';
       header('location: login.php');
   }
   ?>


<?php 
if (isset($_SESSION['user_login'])) {
$member_id = $_SESSION['user_login'];
$stmt = $conn->query("SELECT * FROM tbl_member WHERE member_id = $member_id");
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);
	}	
	?>

<div id="site-content">
			<div class="site-header">
				<div class="container">
					<a href="index.php" id="branding">
						<img src="../images/logoweb.png" alt="" class="logo">
						<div class="logo-text">
							<h1 class="site-title">IDashop</h1>
							<small class="site-description">ไอด้าช็อปรับจ้างเล่นเกมส์</small>
						</div>
					</a> <!-- #branding -->

					<div class="right-section pull-right" align="right">
						
						
						<?php 
							if (isset($_SESSION['user_login'])) {
								$user_id = $_SESSION['user_login'];
									$stmt = $conn->query("SELECT * FROM tbl_member WHERE member_id = $user_id");
										$stmt->execute();
									$row = $stmt->fetch(PDO::FETCH_ASSOC);
	}	
						?>
						<a href="../orders_history.php">ประวัติการจ้างงาน</a>
						<a href="../worker_detail.php">ข้อมูลยืนยันพนักงาน</a>
						<a href="#">Welcome!!&nbsp&nbsp '<?php echo $row['username'] ?>' &nbsp&nbsp</a>
						<a href="logout.php">Logout</a>   
					</div> <!-- .right-section --><link rel="stylesheet" href="style.css">