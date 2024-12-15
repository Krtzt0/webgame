<?php
session_start();
require_once 'config/db.php'; // เชื่อมต่อฐานข้อมูล

$sql = "SELECT username, member_name, member_sur, worker_rank, game_details_id, member_img, member_idcard 
        FROM tbl_member 
        WHERE role = 'worker'";
$stmt = $conn->prepare($sql);
$stmt->execute();
$workers = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>พนักงานของเรา</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2; /* เปลี่ยนสีพื้นหลังเป็นเทาอ่อน */
            margin: 0;
            padding: 20px;
        }
        .container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }
        .card {
            background-color: #fff; /* สีพื้นหลังการ์ดเป็นสีขาว */
            width: 300px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            padding: 20px;
            text-align: center;
        }
        .card img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 50%;
            margin-bottom: 10px;
        }
        .card h3 {
            margin: 10px 0;
            color: #333;
        }
        .card p {
            margin: 5px 0;
            color: #666;
        }
    </style>
</head>
<body>
    <h2>พนักงานประจำเว็บของเรา</h2>
    <div class="container">
        <?php foreach ($workers as $worker): ?>
            <div class="card">
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
</body>
</html>
