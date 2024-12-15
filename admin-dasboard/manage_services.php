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
                <h1>จัดการงานบริการภายในเว็บ</h1>
                <a href="backend/add_product.php" class="button">Add New Product</a>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Details</th>
                            <th>Price</th>
                            <th>Image</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        try {
                            $sql = "SELECT * FROM tbl_game_product";
                            $stmt = $conn->query($sql);

                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                echo "<tr>";
                                echo "<td>{$row['game_product_id']}</td>";
                                echo "<td>{$row['game_product_name']}</td>";
                                echo "<td>{$row['game_product_details']}</td>";
                                echo "<td>{$row['game_product_price']}</td>";
                                echo "<td><img src='product_img/" . $row["product_img"] . "' alt='Product Image' width='100'></td>";
                                echo "<td>
                                    <a href='backend/edit_product.php?id={$row['game_product_id']}'>Edit</a> |
                                    <a href='backend/delete_product.php?id={$row['game_product_id']}' onclick='return confirm(\"Are you sure?\")'>Delete</a>
                                </td>";
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
