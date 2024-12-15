<?php
session_start();
require_once 'config/db.php';

if (!isset($_SESSION['user_login'])) {
    $_SESSION['error'] = 'กรุณาเข้าสู่ระบบ!';
    header('location: login.php');
    exit;
}

$user_login = $_SESSION['user_login'];

// จำนวนข้อมูลต่อหน้า
$records_per_page = 5;

// ตรวจสอบว่าหน้าเว็บปัจจุบันที่ผู้ใช้กำลังดูคือหน้าใด
$current_page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int) $_GET['page'] : 1;

// คำนวณตำแหน่งเริ่มต้นของข้อมูลสำหรับ query
$start_from = ($current_page - 1) * $records_per_page;

// ดึงข้อมูลเฉพาะหน้าปัจจุบัน
$sql = "SELECT o.*, m.username AS member_username, w.username AS worker_username 
        FROM tbl_orders o
        LEFT JOIN tbl_member m ON o.member_id = m.member_id
        LEFT JOIN tbl_member w ON o.worker_accept = w.member_id
        WHERE o.member_id = :user_login
        ORDER BY o.orders_id DESC
        LIMIT :start_from, :records_per_page";

$stmt = $conn->prepare($sql);
$stmt->bindParam(':user_login', $user_login, PDO::PARAM_INT);
$stmt->bindParam(':start_from', $start_from, PDO::PARAM_INT);
$stmt->bindParam(':records_per_page', $records_per_page, PDO::PARAM_INT);
$stmt->execute();
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

// คำนวณจำนวนหน้าทั้งหมด
$total_records_sql = "SELECT COUNT(*) FROM tbl_orders WHERE member_id = :user_login";
$total_records_stmt = $conn->prepare($total_records_sql);
$total_records_stmt->bindParam(':user_login', $user_login, PDO::PARAM_INT);
$total_records_stmt->execute();
$total_records = $total_records_stmt->fetchColumn();
$total_pages = ceil($total_records / $records_per_page);
?>

<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
    <title>ประวัติการซื้อขาย</title>
    <!-- Loading third party fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            color: #333;
        }

        .container {
            width: 90%;
            margin: 40px auto;
            background: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        header {
            background: #50b3a2;
            color: #fff;
            padding: 20px 0;
            text-align: center;
        }

        header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 300;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        table th, table td {
            padding: 15px;
            text-align: left;
            border: 1px solid #ddd;
        }

        table th {
            background-color: #50b3a2;
            color: white;
        }

        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .pagination {
            text-align: center;
            margin: 20px 0;
        }

        .pagination a {
            color: #50b3a2;
            padding: 10px 20px;
            margin: 0 5px;
            text-decoration: none;
            border: 1px solid #50b3a2;
            border-radius: 5px;
        }

        .pagination a.active {
            background-color: #50b3a2;
            color: white;
        }

        .pagination a:hover {
            background-color: #ddd;
        }

        .no-orders {
            text-align: center;
            font-size: 18px;
            color: #888;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <header>
        <h1>ประวัติการซื้อขาย</h1>
    </header>
    
    <div class="container">
        <?php if (count($orders) > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>รหัสคำสั่งซื้อ</th>
                        <th>สินค้า</th>
                        <th>รายละเอียดงาน</th>
                        <th>Username</th>
                        <th>Password</th>
                        <th>ราคา</th>
                        <th>สถานะ</th>
                        <th>วันที่สั่งซื้อ</th>
                        <th>ผู้รับงาน</th>
                        <th>เช็คคิว</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $row): ?>
                        <tr>
                            <td><?= $row['orders_id'] ?></td>
                            <td><?= $row['game_product'] ?></td>
                            <td>
                                <?php 
                                    switch ($row['workdetail']) {
                                        case 1: echo 'Rank 1-2'; break;
                                        case 2: echo 'Rank 2-3'; break;
                                        case 3: echo 'Rank 1-3'; break;
                                        default: echo '-'; 
                                    } 
                                ?>
                            </td>
                            <td><?= $row['usergame'] ?></td>
                            <td><?= $row['passgame'] ?></td>
                            <td><?= $row['price'] ?></td>
                            <td>
                                <?php 
                                    switch ($row['status']) {
                                        case 1: echo 'รอดำเนินการ'; break;
                                        case 2: echo 'กำลังดำเนินการ'; break;
                                        case 3: echo 'ดำเนินการเสร็จสิ้น'; break;
                                        default: echo '-'; 
                                    } 
                                ?>
                            </td>
                            <td><?= $row['orders_time'] ?></td>
                            <td><?= $row['worker_username'] ?></td>
                            <td>
                                <?php if ($row['status'] == 1 || $row['status'] == 2): ?>
                                    <a href="check_queue.php?order_id=<?= $row['orders_id'] ?>">เช็คคิว</a>
                                <?php else: ?>
                                    -
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="no-orders">ไม่มีประวัติการซื้อขาย</p>
        <?php endif; ?>
        
        <div class="pagination">
            <?php for ($page = 1; $page <= $total_pages; $page++): ?>
                <a href="orders_history.php?page=<?= $page ?>" class="<?= ($page == $current_page) ? 'active' : '' ?>">
                    <?= $page ?>
                </a>
            <?php endfor; ?>
        </div>
    </div>
</body>

</html>
