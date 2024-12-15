<?php
session_start();
require_once 'config/db.php';

if (!isset($_SESSION['worker_login'])) {
    $_SESSION['error'] = 'กรุณาเข้าสู่ระบบ!';
    header('location: login.php');
    exit();
}

if (isset($_POST['action']) && isset($_POST['order_id'])) {
    $action = $_POST['action'];
    $order_id = $_POST['order_id'];
    $worker_id = $_SESSION['worker_login']; // เก็บ worker_id จาก session

    // ตรวจสอบ action และอัปเดตสถานะในตาราง tbl_orders
    switch ($action) {
        case 'accept':
            updateOrderStatus($order_id, 2, $worker_id); // 2 คือ รับงาน
            break;
        case 'complete':
            updateOrderStatus($order_id, 3, $worker_id); // 3 คือ เสร็จสิ้น
            break;
        default:
            // กรณีอื่นๆ ที่ไม่ได้ใช้งานในที่นี้
            break;
    }
}

function updateOrderStatus($order_id, $status, $worker_id) {
    global $conn;
    try {
        $sql = "UPDATE tbl_orders SET status = :status, worker_accept = :worker_accept WHERE orders_id = :order_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':status', $status, PDO::PARAM_INT);
        $stmt->bindParam(':worker_accept', $worker_id, PDO::PARAM_INT);
        $stmt->bindParam(':order_id', $order_id, PDO::PARAM_INT);
        $stmt->execute();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<style>
    /* Additional CSS for centering table content */
    table {
        width: 100%;
        border-collapse: collapse;
    }

    th,
    td {
        padding: 10px;
        text-align: center;
        vertical-align: middle;
    }

    th {
        background-color: #f2f2f2;
    }

    td img:hover {
        transform: scale(3); /* ขยาย 1.5 เท่า */
        transition: transform 0.3s ease; /* ใส่ effect transition */
        z-index: 10; /* เพื่อให้ภาพแสดงอยู่ข้างหน้า */
        position: relative;
    }

    img {
        display: block;
        margin: 0 auto;
    }

    /* Styling for buttons */
    button {
        padding: 8px 16px;
        background-color: #4CAF50;
        color: white;
        border: none;
        cursor: pointer;
        border-radius: 4px;
        transition: background-color 0.3s;
    }

    button:hover {
        background-color: #45a049;
    }

    .cardHeader {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .cardHeader .btn {
        background-color: #007bff;
        color: white;
        padding: 8px 16px;
        border-radius: 4px;
        text-decoration: none;
        transition: background-color 0.3s;
    }

    .cardHeader .btn:hover {
        background-color: #0056b3;
    }
</style>

<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>หน้าหลักผู้รับจ้าง</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
    <!-- =============== Navigation ================ -->
    <?php include 'template/sidebar.php'; ?>

    <!-- ========================= Main ==================== -->
    <div class="main">
        <div class="topbar">
            <div class="toggle">
                <ion-icon name="menu-outline"></ion-icon>
            </div>

            <div class="search">
                <label>
                    <ion-icon name="#"></ion-icon>
                </label>
            </div>
        </div>

        <!-- ================ Order Details List ================= -->
        <div class="details">
            <div class="recentOrders">
                <div class="cardHeader">
                    <h2>รายการสั่งซื้อล่าสุด</h2>
                </div>

                <table>
                    <thead>
                        <tr>
                            <th>รหัสคำสั่งซื้อ</th>
                            <th>ประเภทเกม</th>
                            <th>งานจ้าง</th>
                            <th>รายละเอียดงานจ้าง</th>
                            <th>Usergame</th>
                            <th>Passgame</th>
                            <th>สลิปโอนเงิน</th>
                            <th>ราคา</th>
                            <th>สถานะการทำงาน</th>
                            <th>วันเวลาที่สั่ง</th>
                            <th>สมาชิกที่จ้าง</th>
                            <th>การจัดการ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        try {
                            $worker_id = $_SESSION['worker_login']; // เก็บ worker_id จาก session
                            
                            // คิวรี่เพื่อดึงคำสั่งซื้อที่ยังไม่ได้รับการยอมรับ และสถานะเป็น 1
                            $sql = "SELECT o.orders_id, g.game_details_name, o.game_product, o.workdetail, 
                                           o.usergame, o.passgame, o.m_img, o.price, o.status, 
                                           o.orders_time, m.username, w.username as worker_username 
                                    FROM tbl_orders o
                                    INNER JOIN tbl_game_details g ON o.game_details_id = g.game_details_id
                                    INNER JOIN tbl_member m ON o.member_id = m.member_id
                                    LEFT JOIN tbl_member w ON o.worker_accept = w.member_id
                                    WHERE o.worker_accept = :worker_id AND o.status = 1
                                    ORDER BY o.orders_id ASC"; // เรียงคำสั่งซื้อจาก orders_id น้อยที่สุด
                            $stmt = $conn->prepare($sql);
                            $stmt->execute();
                            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

                            // ค้นหา orders_id ที่น้อยที่สุด
                            $min_order_id = null;
                            if ($stmt->rowCount() > 0) {
                                $min_order_id = $result[0]['orders_id']; // กำหนดคำสั่งซื้อที่ orders_id น้อยที่สุด
                            }

                            // แสดงรายการคำสั่งซื้อ
                            foreach ($result as $row) {
                                echo "<tr>";
                                echo "<td>" . $row["orders_id"] . "</td>";
                                echo "<td>" . $row["game_details_name"] . "</td>";
                                echo "<td>" . $row["game_product"] . "</td>";
                                switch ($row['workdetail']) {
                                    case 1:
                                        $detail_text = 'Rank 1-2';
                                        break;
                                    case 2:
                                        $detail_text = 'Rank 2-3';
                                        break;
                                    case 3:
                                        $detail_text = 'Rank 1-3';
                                        break;
                                    default:
                                        $detail_text = 'ไม่ทราบสถานะ';
                                        break;
                                }
                                echo "<td>" . $detail_text . "</td>";
                                echo "<td>" . $row["usergame"] . "</td>";
                                echo "<td>" . $row["passgame"] . "</td>";
                                echo "<td><img src='../backend-index/m_img/" . $row["m_img"] . "' alt='Slip' width='100'></td>";
                                echo "<td>" . $row["price"] . "</td>";
                                switch ($row['status']) {
                                    case 1:
                                        $status_text = 'รอดำเนินการ';
                                        break;
                                    case 2:
                                        $status_text = 'กำลังดำเนินการ';
                                        break;
                                    case 3:
                                        $status_text = 'ดำเนินการเสร็จสิ้น';
                                        break;
                                    default:
                                        $status_text = 'ไม่ทราบสถานะ';
                                        break;
                                }
                                echo "<td>" . $status_text . "</td>";
                                echo "<td>" . $row["orders_time"] . "</td>";
                                echo "<td>" . $row["username"] . "</td>";

                                // ปุ่มรับงานจะปรากฏเฉพาะในแถวที่มี orders_id น้อยที่สุด
                                echo "<td>";
                                if ($row['orders_id'] == $min_order_id && $row['status'] == 1) {
                                    echo "<form method='post'>";
                                    echo "<input type='hidden' name='order_id' value='" . $row["orders_id"] . "'>";
                                    echo "<button type='submit' name='action' value='accept'>รับงาน</button>";
                                    echo "</form>";
                                }
                                echo "</td>";
                                echo "</tr>";
                            }
                        } catch (PDOException $e) {
                            echo "Error: " . $e->getMessage();
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- =========== Scripts =========  -->
    <script src="assets/js/main.js"></script>

    <!-- ====== IonIcons ======= -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.3/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.3/dist/ionicons/ionicons.js"></script>
</body>

</html>
