<?php
session_start();
require_once 'config/db.php';

if (!isset($_SESSION['user_login'])) {
    $_SESSION['error'] = 'กรุณาเข้าสู่ระบบ!';
    header('location: login.php');
    exit;
}

$user_login = $_SESSION['user_login'];
$order_id = $_GET['order_id']; // รับ order_id จาก URL

$sql = "SELECT COUNT(*) as queue_count
        FROM tbl_orders
        WHERE orders_id < :order_id AND (status = 1 OR status = 2)";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':order_id', $order_id, PDO::PARAM_INT);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);
$queue_count = $result['queue_count'];
?>

<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
    <title>เช็คคิว</title>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #e9ecef; /* เปลี่ยนสีพื้นหลังให้ดูนุ่มนวล */
            margin: 0;
            padding: 0;
        }

        header {
            background: #007bff; /* เปลี่ยนสี header ให้สดใส */
            color: #fff;
            padding: 30px 20px;
            min-height: 70px;
            border-bottom: #e8491d 3px solid;
        }

        header a {
            color: #fff;
            text-decoration: none;
            text-transform: uppercase;
            font-size: 16px;
        }

        .container {
            width: 80%;
            margin: auto;
            overflow: hidden;
            padding: 20px;
        }

        .queue-info {
            text-align: center;
            background: #fff;
            border-radius: 15px; /* ทำมุมโค้งให้มากขึ้น */
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2); /* เพิ่มความลึก */
            padding: 40px;
            margin-top: 50px;
            transition: transform 0.3s, box-shadow 0.3s; /* เพิ่มการเคลื่อนไหว */
        }

        .queue-info:hover {
            transform: translateY(-5px); /* ยกขึ้นเมื่อ hover */
            box-shadow: 0 12px 25px rgba(0, 0, 0, 0.3); /* เพิ่มเงา */
        }

        .queue-info h2 {
            color: #007bff; /* เปลี่ยนสีข้อความให้โดดเด่น */
            font-size: 28px; /* ขยายขนาดข้อความ */
            margin-bottom: 20px;
        }

        .queue-info p {
            color: #555;
            font-size: 20px; /* ขยายขนาดข้อความ */
            margin: 5px 0;
        }

        footer {
            background: #007bff; /* เปลี่ยนสี footer ให้สดใส */
            color: #fff;
            text-align: center;
            padding: 15px 0;
            position: relative;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>

<body>
    <?php include 'header2.php'; ?>
    <div class="main-navigation">
        <?php include 'menuindex.php'; ?>
        <div class="mobile-navigation"></div>
    </div>
    <div class="container">
        <div class="queue-info">
            <?php if ($queue_count == 0): ?>
                <h2>คิวกำลังดำเนินการ</h2>
                <p>คำสั่งซื้อของคุณกำลังดำเนินการ</p>
            <?php else: ?>
                <h2>จำนวนคิวก่อนหน้าของคุณ: <?php echo $queue_count; ?></h2>
                <p>มีคำสั่งซื้อ <?php echo $queue_count; ?> รายการที่กำลังดำเนินการหรือเสร็จสิ้นก่อนคำสั่งซื้อของคุณ</p>
            <?php endif; ?>
        </div>
    </div>
    <?php include 'footerindex.php'; ?>
</body>

</html>
