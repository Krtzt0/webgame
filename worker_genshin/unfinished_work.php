<?php
session_start(); // เริ่มต้น session
require_once 'config/db.php'; // รวมไฟล์การเชื่อมต่อฐานข้อมูล

// ตรวจสอบการเข้าสู่ระบบ
if (!isset($_SESSION['worker_login'])) {
    $_SESSION['error'] = 'กรุณาเข้าสู่ระบบ!'; // แสดงข้อความเตือน
    header('location: login.php'); // เปลี่ยนเส้นทางไปที่หน้าเข้าสู่ระบบ
    exit();
}

$worker_id = $_SESSION['worker_login']; // ดึง worker_id จาก session

// ตรวจสอบการดำเนินการจากฟอร์ม
if (isset($_POST['action']) && isset($_POST['order_id'])) {
    $action = $_POST['action'];
    $order_id = $_POST['order_id'];

    // ตรวจสอบ action และอัปเดตสถานะในตาราง tbl_orders
    switch ($action) {
        case 'accept':
            updateOrderStatus($order_id, 2, $worker_id); // 2 คือ รับงาน
            break;
        case 'complete':
            updateOrderStatus($order_id, 3, $worker_id); // 3 คือ เสร็จสิ้น
            break;
        default:
            break; // กรณีอื่นๆ ที่ไม่ได้ใช้งาน
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

<style>
    /* CSS สำหรับการจัดการตาราง */
    table {
        width: 100%;
        border-collapse: collapse; /* ทำให้เส้นขอบไม่ซ้อนกัน */
    }

    th, td {
        padding: 10px;
        text-align: center; /* จัดกลางข้อความในเซลล์ */
        vertical-align: middle; /* จัดแนวตั้งของข้อความ */
    }

    th {
        background-color: #f2f2f2; /* สีพื้นหลังของหัวตาราง */
    }

    img {
        display: block;
        margin: 0 auto; /* จัดกลางรูปภาพ */
    }

    /* CSS สำหรับปุ่ม */
    button {
        padding: 8px 16px;
        background-color: #4CAF50; /* สีพื้นหลังปุ่ม */
        color: white; /* สีข้อความ */
        border: none; /* ไม่มีเส้นขอบ */
        cursor: pointer; /* แสดงเป็นลูกศรเมื่อชี้ */
        border-radius: 4px; /* มุมมน */
        transition: background-color 0.3s; /* เอฟเฟกต์เมื่อเปลี่ยนสี */
    }

    button:hover {
        background-color: #45a049; /* สีพื้นหลังเมื่อชี้ */
    }

    .cardHeader {
        display: flex; /* ใช้ Flexbox */
        justify-content: space-between; /* จัดระยะห่างให้เท่ากัน */
        align-items: center; /* จัดแนวกลางในแนวตั้ง */
    }

    .cardHeader .btn {
        background-color: #007bff; /* สีพื้นหลังปุ่มที่อยู่ใน cardHeader */
        color: white; /* สีข้อความ */
        padding: 8px 16px; /* ขนาดของปุ่ม */
        border-radius: 4px; /* มุมมน */
        text-decoration: none; /* ไม่มีการขีดเส้นใต้ */
        transition: background-color 0.3s; /* เอฟเฟกต์เมื่อเปลี่ยนสี */
    }

    .cardHeader .btn:hover {
        background-color: #0056b3; /* สีพื้นหลังเมื่อชี้ */
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
    <?php include 'template/sidebar.php'; // รวม sidebar ?>

    <!-- ========================= Main ==================== -->
    <div class="main">
        <div class="topbar">
            <div class="toggle">
                <ion-icon name="menu-outline"></ion-icon> <!-- ไอคอนเมนู -->
            </div>

            <div class="search">
                <label>
                    <ion-icon name="#"></ion-icon> <!-- ช่องค้นหา -->
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
                            // คิวรี่เพื่อดึงข้อมูลจากฐานข้อมูล
                            $sql = "SELECT o.orders_id, g.game_details_name, o.game_product, o.workdetail, 
                                           o.usergame, o.passgame, o.m_img, o.price, o.status, 
                                           o.orders_time, m.username 
                                    FROM tbl_orders o
                                    INNER JOIN tbl_game_details g ON o.game_details_id = g.game_details_id
                                    INNER JOIN tbl_member m ON o.member_id = m.member_id
                                    WHERE o.status = 2 AND o.worker_accept = :worker_id"; // เงื่อนไขการเลือก
                            $stmt = $conn->prepare($sql);
                            $stmt->bindParam(':worker_id', $worker_id, PDO::PARAM_INT); // ผูกค่า worker_id
                            $stmt->execute();
                            $result = $stmt->fetchAll(PDO::FETCH_ASSOC); // ดึงข้อมูลทั้งหมด

                            if ($stmt->rowCount() > 0) {
                                // แสดงข้อมูลในตาราง
                                foreach ($result as $row) {
                                    echo "<tr>";
                                    echo "<td>" . $row["orders_id"] . "</td>";
                                    echo "<td>" . $row["game_details_name"] . "</td>";
                                    echo "<td>" . $row["game_product"] . "</td>";

                                    // แสดงรายละเอียดงานจ้าง
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

                                    // แสดงสถานะการทำงาน
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
                                    echo "<td>" . $row["username"] . "</td>"; // แสดงชื่อสมาชิกที่จ้าง

                                    // ปุ่มการจัดการ
                                    echo "<td>";
                                    if ($row['status'] == 1) { // ถ้าสถานะเป็นรอดำเนินการ
                                        echo "<form method='post'>";
                                        echo "<input type='hidden' name='order_id' value='" . $row["orders_id"] . "'>";
                                        echo "<button type='submit' name='action' value='accept'>รับงาน</button>";
                                        echo "</form>";
                                    } elseif ($row['status'] == 2) { // ถ้าสถานะเป็นกำลังดำเนินการ
                                        echo "<form method='post'>";
                                        echo "<input type='hidden' name='order_id' value='" . $row["orders_id"] . "'>";
                                        echo "<button type='submit' name='action' value='complete'>เสร็จสิ้น</button>";
                                        echo "</form>";
                                    }
                                    echo "</td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='12'>ไม่พบผลลัพธ์</td></tr>"; // ถ้าไม่มีผลลัพธ์
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
