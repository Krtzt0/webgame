<?php
session_start(); // เริ่มต้น session
require_once 'config/db.php'; // รวมไฟล์การเชื่อมต่อฐานข้อมูล

// ตรวจสอบการเข้าสู่ระบบ
if (!isset($_SESSION['worker_login'])) {
    $_SESSION['error'] = 'กรุณาเข้าสู่ระบบ!'; // แสดงข้อความเตือน
    header('location: login.php'); // เปลี่ยนเส้นทางไปที่หน้าเข้าสู่ระบบ
    exit();
}

// ตรวจสอบการดำเนินการจากฟอร์ม
if (isset($_POST['action']) && isset($_POST['order_id'])) {
    $action = $_POST['action'];
    $order_id = $_POST['order_id'];
    $worker_id = $_SESSION['worker_login']; // ดึง worker_id จาก session

    // ดำเนินการตาม action ที่ได้รับ
    switch ($action) {
        case 'accept':
            updateOrderStatus($order_id, 2, $worker_id); // เปลี่ยนสถานะเป็น 'accepted'
            break;
        case 'complete':
            updateOrderStatus($order_id, 3, $worker_id); // เปลี่ยนสถานะเป็น 'completed'
            break;
        default:
            break;
    }
}

// ฟังก์ชันสำหรับอัปเดตสถานะคำสั่งซื้อ
function updateOrderStatus($order_id, $status, $worker_id) {
    global $conn; // ใช้ตัวแปรเชื่อมต่อฐานข้อมูล
    try {
        $sql = "UPDATE tbl_orders SET status = :status, worker_accept = :worker_accept WHERE orders_id = :order_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':status', $status, PDO::PARAM_INT);
        $stmt->bindParam(':worker_accept', $worker_id, PDO::PARAM_INT);
        $stmt->bindParam(':order_id', $order_id, PDO::PARAM_INT);
        $stmt->execute(); // ดำเนินการอัปเดต
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage(); // แสดงข้อความผิดพลาด
    }
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>หน้าหลักผู้รับจ้าง</title>
    <!-- ======= Styles ====== -->
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        /* CSS สำหรับการจัดการตาราง */
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 10px;
            text-align: center;
            vertical-align: middle;
        }
        th {
            background-color: #f2f2f2;
        }
        img {
            display: block;
            margin: 0 auto; /* จัดกลางรูปภาพ */
        }
    </style>
</head>

<body>
    <!-- =============== Navigation ================ -->
    <?php include 'template/sidebar.php'; // รวม sidebar ?>

    <!-- ========================= Main ==================== -->
    <div class="main">
        <div class="topbar">
            <div class="toggle">
                <ion-icon name="menu-outline"></ion-icon> <!-- ไอคอนเมนู -->
            </div>

            <div class="search">
                <label>
                    <input type="text" placeholder="ค้นหา"> <!-- ช่องค้นหา -->
                    <ion-icon name="search-outline"></ion-icon> <!-- ไอคอนค้นหา -->
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
                            <th>ผู้รับงาน</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        try {
                            // ดึงข้อมูลคำสั่งซื้อจากฐานข้อมูล
                            $sql = "SELECT o.orders_id, g.game_details_name, o.game_product, o.workdetail, 
                                           o.usergame, o.passgame, o.m_img, o.price, o.status, 
                                           o.orders_time, m.username, w.username as worker_username 
                                    FROM tbl_orders o
                                    INNER JOIN tbl_game_details g ON o.game_details_id = g.game_details_id
                                    INNER JOIN tbl_member m ON o.member_id = m.member_id
                                    LEFT JOIN tbl_member w ON o.worker_accept = w.member_id
                                    WHERE o.game_details_id = 2
                                    ORDER BY o.status = 1 DESC"; // จัดเรียงตามสถานะ
                            $stmt = $conn->prepare($sql);
                            $stmt->execute();
                            $result = $stmt->fetchAll(PDO::FETCH_ASSOC); // ดึงข้อมูลทั้งหมด

                            if ($stmt->rowCount() > 0) {
                                // แสดงข้อมูลในตาราง
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
                                    echo "<td><img src='../backend-index/m_img/" . $row["m_img"] . "' alt='Slip' width='100'></td>"; // แสดงสลิปโอนเงิน
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
                                    echo "<td>" . $row["worker_username"] . "</td>"; // แสดงชื่อผู้รับงาน
                                    echo "</tr>"; // ปิดแถว
                                }
                            } else {
                                echo "<tr><td colspan='13'>ไม่พบผลลัพธ์</td></tr>"; // แสดงข้อความหากไม่มีข้อมูล
                            }
                        } catch (PDOException $e) {
                            echo "Error: " . $e->getMessage(); // แสดงข้อความผิดพลาด
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- =========== Scripts =========  -->
    <script src="assets/js/main.js"></script>
    <!-- ====== ionicons ======= -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>
</html>
