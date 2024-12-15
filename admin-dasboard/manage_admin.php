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
        a {
            color: #f28ab2;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    
<?php include 'sidebar.php'; ?>

<div class="container-fluid">
    <div class="row">
        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
            <div class="content">
                <h1>จัดการผู้ดูแลระบบ</h1>
                <table>
                    <thead>
                        <tr>
                            <th>Member ID</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Role</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        try {
                            $sql = "SELECT * FROM tbl_member WHERE role = 'admin'";
                            $stmt = $conn->query($sql);

                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                echo "<tr>";
                                echo "<td>{$row['member_id']}</td>";
                                echo "<td>{$row['username']}</td>";
                                echo "<td>{$row['email']}</td>";
                                echo "<td>{$row['role']}</td>";
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
