<?php 
if (isset($_SESSION['worker_login'])) {
$member_id = $_SESSION['worker_login'];
$stmt = $conn->query("SELECT * FROM tbl_member WHERE member_id = $member_id");
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);
	}	
	?>
<div class="container">
        <div class="navigation">
            <ul>
                <li>
                    <a href="#">
                        <span class="icon">
                            <ion-icon name="game-controller-outline"></ion-icon>
                        </span>
                        <span class="title">Idashop-worker</span><br>
                        
                    </a>
                   <a href=""> Welcome!!&nbsp&nbsp <?php echo $row['username'] ?></a>
                </li>
                

              

                
              
                <li>
                    <a href="index.php">
                        <span class="icon">
                        <ion-icon name="document-text-outline"></ion-icon>
                        </span>
                        <span class="title">งานทั้งหมด</span>
                    </a>
                <li>
                    <a href="unaccept_work.php">
                        <span class="icon">
                        <ion-icon name="document-text-outline"></ion-icon>
                        </span>
                        <span class="title">งานที่ยังไม่รับ</span>
                    </a>
                </li>
                <li>
                    <a href="unfinished_work.php">
                        <span class="icon">
                            <ion-icon name="close-circle-outline"></ion-icon>
                        </span>
                        <span class="title">งานที่ยังไม่เสร็จ</span>
                    </a>
                </li>

                <li>
                    <a href="finish_work.php">
                        <span class="icon">
                        <ion-icon name="checkmark-circle-outline"></ion-icon>
                        </span>
                        <span class="title">งานที่เสร็จสิ้น</span>
                    </a>
                </li>

                

                <li>
                    <a href="logout_work.php">
                        <span class="icon">
                            <ion-icon name="log-out-outline"></ion-icon>
                        </span>
                        <span class="title">Sign Out</span>
                    </a>
                </li>
            </ul>
        </div>