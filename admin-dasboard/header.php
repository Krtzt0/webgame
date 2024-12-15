<header>
    <div class="container">
        <div class="logo">
            <a href="admin-dashboard.php">
            <img src="../images/logoweb.png" alt="" class="logo">IDashop รับเล่นเกม
            </a>
        </div>
        <nav>
            <ul>
                <!-- Add dynamic username display -->
                <li>Welcome, 
                    <?php 
							if (isset($_SESSION['admin_login'])) {
								$user_id = $_SESSION['admin_login'];
									$stmt = $conn->query("SELECT * FROM tbl_member WHERE member_id = $user_id");
										$stmt->execute();
									$row = $stmt->fetch(PDO::FETCH_ASSOC);
	}	
						?>
                        </li>
                <li><a href="../logout.php">Logout</a></li>
            </ul>
        </nav>
    </div>
</header>