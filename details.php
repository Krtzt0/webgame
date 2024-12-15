<?php
session_start(); // ให้เป็นบรรทัดแรกของไฟล์
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
    <title>Valorant</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,700" rel="stylesheet">
    <link href="../fonts/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../style.css">
    <style>
        body {
            background-color: #f4f4f4;
            font-family: 'Roboto', sans-serif;
        }

        .container {
            max-width: 1200px;
            margin: auto;
            padding: 20px;
        }

        .breadcrumbs {
            padding: 10px 0;
            font-size: 14px;
            color: #333;
        }

        .breadcrumbs a {
            color: #007bff;
            text-decoration: none;
        }

        .page {
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.1);
            padding: 30px;
            margin-top: 20px;
        }

        .product-images {
            text-align: center;
        }

        .product-images img {
            max-width: 100%;
            border-radius: 10px;
        }

        .addtocart-bar {
            background-color: #f9f9f9;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
        }

        .addtocart-bar form input[type="text"],
        .addtocart-bar form select,
        .addtocart-bar form input[type="file"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .addtocart-bar form input[type="submit"] {
            width: 100%;
            background-color: #28a745;
            color: #fff;
            border: none;
            padding: 15px;
            cursor: pointer;
            font-size: 16px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .addtocart-bar form input[type="submit"]:hover {
            background-color: #218838;
        }

        .show-workers-btn {
            margin-top: 20px;
            text-align: center;
        }

        .show-workers-btn button {
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        .show-workers-btn button:hover {
            background-color: #0056b3;
        }

        .container-workers {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            margin-top: 20px;
            justify-content: center;
        }

        .container-workers .card {
            background-color: #fff;
            width: 300px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            padding: 20px;
            text-align: center;
            transition: transform 0.3s ease, border-color 0.3s ease;
            cursor: pointer;
            border: 2px solid transparent;
        }

        .container-workers .card:hover {
            transform: scale(1.05);
        }

        .container-workers .card img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 50%;
            margin-bottom: 15px;
        }

        .container-workers .card h3 {
            font-size: 18px;
            margin-bottom: 10px;
        }

        .container-workers .card p {
            font-size: 14px;
            color: #555;
        }

        .container-workers .card.selected {
            border-color: #28a745;
        }

        /* New styles for the image display */
        .image-display {
            margin-top: 20px;
            text-align: center;
        }

        .image-display img {
            max-width: 100%;
            border-radius: 10px;
            display: none; /* Initially hidden */
        }

        /* Popup styles */
.popup {
    display: none; /* Initially hidden */
    position: fixed;
    left: 0;
    top: 0;
    width: 20;
    height: 30;
    background-color: rgba(0, 0, 0, 0.7);
    justify-content: center;
    align-items: center;
}

.popup img {
    max-width: 60%; /* ปรับขนาดรูปภาพให้เล็กลง */
    max-height: 60%; /* ปรับขนาดรูปภาพให้เล็กลง */
    border-radius: 10px;
}

.popup.active {
    display: flex; /* Show when active */
}

.popup-close {
    position: absolute;
    top: 20px;
    right: 20px;
    color: white;
    font-size: 24px;
    cursor: pointer;
}
    </style>
</head>
<body>
    <div id="site-content">
        <?php include 'header.php'; ?>
        <div class="main-navigation">
            <button class="toggle-menu"><i class="fa fa-bars"></i></button>
            <?php include 'menuindex.php'; ?>
            <div class="mobile-navigation"></div>
        </div>
        <div class="breadcrumbs container">
            <a href="index-logged.php">Home</a> &gt; 
            <a href="valorant-product.php">Valorant</a> &gt; 
            <span><?php echo htmlspecialchars($_GET['game_product_name']); ?></span>
        </div>
    </div> 

    <main class="main-content">
        <div class="container">
            <div class="page">
                <div class="entry-content">
                    <div class="row" style="display: flex; flex-wrap: wrap;">
                        <div class="col-sm-6 col-md-4" style="flex: 1; min-width: 300px; padding: 10px;">
                            <div class="product-images">
                                <figure class="large-image">
                                    <img src="admin-dasboard/product_img/<?php echo htmlspecialchars($_GET['product_img']); ?>" alt="<?php echo htmlspecialchars($_GET['game_product_name']); ?>">
                                </figure>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-8" style="flex: 2; min-width: 300px; padding: 10px;">
                            <div class="addtocart-bar">
                                <form action="backend-index/confirm_order.php" method="post" enctype="multipart/form-data">
                                    <h2><b>กรอกรายละเอียดข้อมูล</b></h2>
                                    <input type="text" name="Rank valo" value="<?php echo htmlspecialchars($_GET['game_product_details']); ?>" placeholder="<?php echo htmlspecialchars($_GET['game_product_name']); ?>" readonly>
                                            <select name="Work_detail" id="work-detail" onchange="totalbronze(this.value)">
                                    <option value="">เลือกระดับที่ต้องการ</option>
                                    <option value="1" data-price="<?php echo htmlspecialchars($_GET['game_product_price']); ?>">Rank1-Rank2</option>
                                    <option value="1" data-price="<?php echo htmlspecialchars($_GET['game_product_price']); ?>">Rank2-Rank3</option>
                                    <option value="3" data-price="<?php echo htmlspecialchars($_GET['game_product_price']); ?>">Rank1-Rank3</option>
                                            </select>
                                    <div class="form-group">
                                        <input type="text" name="usergame" placeholder="กรอก Username">
                                    </div>
                                    <div class="form-group">
                                        <input type="text" name="passgame" placeholder="กรอก Password">    
                                    </div>
                                    
                                    <div class="form-group">    
                                        <input type="text" id="total" name="price" readonly>&nbsp;บาท <br>
                                    </div>
                                    <input type="hidden" id="selected-worker-id" name="worker_id" value="">
                                    <div class="form-group">
                                        <input type="text" id="selected-worker-name" name="worker_name" placeholder="เลือกพนักงาน" readonly>
                                    </div>
                                    <div class="form-group">
                                        <input type="submit" value="จ้างเลย" id="buy" name="IronBuy" onclick="return validateForm();">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="image-display">
                        <img id="displayed-image" src="images/download.jpg" alt="Download Image">
                    </div>

                    <!-- Button to show workers -->
                    <div class="show-workers-btn">
                        <button onclick="toggleWorkers()">แสดงพนักงาน</button>
                    </div>

                    <!-- Workers container -->
                    <div id="workers-container" class="container-workers">
                        <?php
                        $sql = "SELECT member_id, username, member_name, member_sur, worker_rank, game_details_id, member_img, member_idcard 
                                FROM tbl_member 
                                WHERE role = 'worker' AND game_details_id = 1";
                        $stmt = $conn->prepare($sql);
                        $stmt->execute();
                        $workers = $stmt->fetchAll(PDO::FETCH_ASSOC);

                        foreach ($workers as $worker):
                        ?>
                            <div class="card" id="worker-<?php echo $worker['member_id']; ?>" onclick="selectWorker('<?php echo $worker['member_id']; ?>', '<?php echo htmlspecialchars($worker['member_name'] . " " . $worker['member_sur']); ?>')">
                                <img src="uploads/<?php echo $worker['member_img']; ?>" alt="Profile Image">
                                <h3><?php echo $worker['member_name'] . " " . $worker['member_sur']; ?></h3>
                                <p>Username: <?php echo $worker['username']; ?></p>
                                <p>เกมที่ประจำ: 
                                    <?php
                                    switch ($worker['game_details_id']) {
                                        case 1:
                                            echo 'Valorant';
                                            break;
                                        case 2:
                                            echo 'Genshin Impact';
                                            break;
                                        default:
                                            echo '-';
                                            break;
                                    }
                                    ?>
                                </p>
                                <p>Rank ปัจจุบัน: <img src="uploads/<?php echo $worker['worker_rank']; ?>" alt="Rank Image"></p>
                                <p>บัตรยืนยันตัว: <img src="uploads/<?php echo $worker['member_idcard']; ?>" alt="ID Card Image"></p>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <!-- Popup for image -->
                    <div id="image-popup" class="popup">
                        <span class="popup-close" onclick="closePopup()">&times;</span>
                        <img id="popup-image" src="" alt="Popup Image">
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
        function toggleWorkers() {
            var workersContainer = document.getElementById('workers-container');
            workersContainer.style.display = workersContainer.style.display === 'none' || workersContainer.style.display === '' ? 'flex' : 'none';
        }

        function selectWorker(workerId, workerName) {
            
            document.getElementById('selected-worker-id').value = workerId;
            document.getElementById('selected-worker-name').value = workerName;

            
            var cards = document.querySelectorAll('.card');
            cards.forEach(card => {
                card.classList.remove('selected');
            });
            document.getElementById('worker-' + workerId).classList.add('selected');
        }

        function validateForm() {
            var workerId = document.getElementById('selected-worker-id').value;
            if (workerId === '') {
                alert('กรุณาเลือกพนักงานก่อน');
                return false;
            }
            return true;
        }

        function showImage() {
            var img = document.getElementById('popup-image');
            img.src = "images/download.jpg"; // Set the image source
            var popup = document.getElementById('image-popup');
            popup.classList.add('active'); // Show the popup
        }

        function closePopup() {
            var popup = document.getElementById('image-popup');
            popup.classList.remove('active'); // Hide the popup
        }

        function totalbronze(selectedValue) {
    var selectElement = document.getElementById("work-detail");
    var selectedOption = selectElement.options[selectElement.selectedIndex];

    // ดึงค่า price จาก data-price
    var game_product_price = parseFloat(selectedOption.getAttribute('data-price'));
    
    // คำนวณค่ารวม
    var total = selectedValue * game_product_price;

    // แสดงผลใน input total
    document.getElementById("total").value = total.toFixed(2); // แสดงผลให้มี 2 ทศนิยม
        }
    </script>
</body>
</html>
