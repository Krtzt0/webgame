<?php
session_start();
require_once '../config/db.php';

// ตรวจสอบการเข้าสู่ระบบของ admin
if (!isset($_SESSION['admin_login'])) {
    $_SESSION['error'] = 'กรุณาเข้าสู่ระบบ!';
    header('location: login.php');
    exit();
}

// คิวรี่เพื่อนับจำนวนผู้ใช้งาน
try {
    $stmt = $conn->prepare("SELECT COUNT(*) AS user_count FROM tbl_member WHERE role = 'user'");
    $stmt->execute();
    $user_data = $stmt->fetch(PDO::FETCH_ASSOC);
    $user_count = $user_data['user_count'];
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

// คิวรี่เพื่อนับจำนวนคำสั่งจ้างงาน
try {
    $stmt = $conn->prepare("SELECT COUNT(*) AS orders_count FROM tbl_orders");
    $stmt->execute();
    $orders_data = $stmt->fetch(PDO::FETCH_ASSOC);
    $orders_count = $orders_data['orders_count'];
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

// คิวรี่เพื่อนับจำนวนพนักงาน
try {
    $stmt = $conn->prepare("SELECT COUNT(*) AS worker_count FROM tbl_member WHERE role = 'worker'");
    $stmt->execute();
    $worker_data = $stmt->fetch(PDO::FETCH_ASSOC);
    $worker_count = $worker_data['worker_count'];
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

// คิวรี่เพื่อนำข้อมูลกิจกรรมล่าสุดจาก tbl_orders
$recent_activities = [];
try {
    $stmt = $conn->prepare("
        SELECT 
            o.orders_id, 
            o.game_product, 
            o.price, 
            o.status, 
            m1.username AS member_name, 
            m2.member_name AS worker_name
        FROM 
            tbl_orders o
        JOIN 
            tbl_member m1 ON o.member_id = m1.member_id
        LEFT JOIN 
            tbl_member m2 ON o.worker_accept = m2.member_id
        ORDER BY 
            o.orders_id DESC 
        LIMIT 10
    ");
    $stmt->execute();
    $recent_activities = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <style>
        body {
            background-color: #f4f6f9;
            font-family: Arial, sans-serif;
        }
        .card {
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            background: linear-gradient(145deg, #fff, #e0e0e0);
        }
        .card-title {
            font-size: 1.5rem;
            color: #333;
        }
        .card-text {
            font-size: 1.2rem;
            color: #666;
        }
        h4 {
            font-weight: bold;
            color: #555;
            margin-top: 20px;
        }
        .table th, .table td {
            font-size: 0.95rem;
            color: #555;
            padding: 12px 15px;
        }
        .overview-icon {
            font-size: 1.8rem;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
        <?php include 'sidebar.php'; ?>

            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Dashboard</h1>
                </div>

                <!-- ข้อมูลสรุป (Overview) -->
                <h4>Overview</h4>
                <div class="row">
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body text-center">
                                <div class="overview-icon">👥</div>
                                <h5 class="card-title">Users</h5>
                                <p class="card-text">จำนวนสมาชิก: <?php echo $user_count; ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body text-center">
                                <div class="overview-icon">🛒</div>
                                <h5 class="card-title">Orders</h5>
                                <p class="card-text">จำนวนการจ้างงาน: <?php echo $orders_count; ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body text-center">
                                <div class="overview-icon">👦🏼</div>
                                <h5 class="card-title">Employee</h5>
                                <p class="card-text">จำนวนพนักงาน: <?php echo $worker_count; ?></p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- กิจกรรมล่าสุด (Recent Activities) -->
                <h4 class="mt-4">Recent Activities</h4>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Game Product</th>
                            <th>Price</th>
                            <th>Status</th>
                            <th>Member</th>
                            <th>Worker</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($recent_activities as $activity): ?>
                            <tr>
                                <td><?php echo $activity['orders_id']; ?></td>
                                <td><?php echo $activity['game_product']; ?></td>
                                <td><?php echo $activity['price']; ?></td>
                                <td>
                                    <?php 
                                        if ($activity['status'] == 1) {
                                            echo "รอดำเนินการ";
                                        } elseif ($activity['status'] == 2) {
                                            echo "กำลังดำเนินการ";
                                        } elseif ($activity['status'] == 3) {
                                            echo "ดำเนินการเสร็จสิ้น";
                                        } else {
                                            echo "ไม่ทราบสถานะ";
                                        }
                                    ?>
                                </td>
                                <td><?php echo $activity['member_name']; ?></td>
                                <td><?php echo $activity['worker_name']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </main>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
