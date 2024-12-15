<?php
session_start();
require_once '../config/db.php';

if (!isset($_SESSION['admin_login'])) {
    $_SESSION['error'] = 'กรุณาเข้าสู่ระบบ!';
    header('location: login.php');
    exit();
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
            background-color: #f4f6f9; /* สีพื้นหลังเทาอ่อน */
            font-family: Arial, sans-serif;
        }
        .content {
            padding: 20px;
            background-color: #fff; /* พื้นหลังสีขาว */
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            border-radius: 12px;
            margin: 20px;
        }
        h1 {
            font-weight: bold;
            color: #f28ab2; /* สีชมพู */
            text-align: center;
            margin-bottom: 20px;
        }
        .button {
            background-color: #f28ab2;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            margin-bottom: 20px;
            display: inline-block;
        }
        .button:hover {
            background-color: #e02f6a;
        }
        table {
            width: 100%;
            margin-top: 10px;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #f28ab2; /* ขอบตารางสีชมพู */
        }
        th, td {
            padding: 12px;
            text-align: center;
            font-size: 1rem;
            color: #555;
        }
        td img:hover {
    transform: scale(7); 
    transition: transform 0.3s ease; 
    z-index: 10; 
    position: relative;
}
        th {
            background-color: #fce4ec; /* สีชมพูอ่อน */
            font-weight: bold;
            color: #f28ab2; /* สีชมพูเข้ม */
        }
        tr:nth-child(even) {
            background-color: #f9f9f9; /* สีพื้นหลังของแถวที่คู่ */
        }
        tr:hover {
            background-color: #fef2f7; /* สีชมพูอ่อนเมื่อชี้เมาส์ */
        }
        img {
            max-width: 100px;
            border-radius: 8px;
        }
    </style>
</head>
<body>

<?php include 'sidebar.php'; ?>

<div class="container-fluid">
    <div class="row">
        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
            <div class="content">
                <h1>จัดการงานว่าจ้าง</h1>
                <a href="generate_pdf.php" class="button">สรุปยอด PDF</a>
                <table>
                    <thead>
                        <tr>
                            <th>Order ID</th>
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
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        try {
                            $sql = "SELECT o.*, m.username 
                                    FROM tbl_orders o
                                    INNER JOIN tbl_member m ON o.member_id = m.member_id";
                            $stmt = $conn->query($sql);

                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                echo "<tr>";
                                echo "<td>" . $row['orders_id'] . "</td>";
                                switch ($row['game_details_id']) {
                                    case 1:
                                        $game_details_id = 'Valorant';
                                        break;
                                    case 2:
                                        $game_details_id = 'Genshin Impact';
                                        break;                      
                                }
                                echo "<td>" . $game_details_id . "</td>";
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
                                echo "<td>" . $row['game_product'] . "</td>";
                                echo "<td>" . $row['usergame'] . "</td>";
                                echo "<td>" . $row['passgame'] . "</td>";
                                echo "<td><img src='../backend-index/m_img/" . $row["m_img"] . "' alt='Slip' width='100'></td>";
                                echo "<td>" . $row['price'] . "</td>";
                                // Check status value and display appropriate text
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
                                echo "<td>" . $row['orders_time'] . "</td>";
                                echo "<td>" . $row['username'] . "</td>";
                                echo "</tr>";
                            }

                            $conn = null; // ปิดการเชื่อมต่อ

                        } catch(PDOException $e) {
                            echo "Error: " . $e->getMessage();
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
