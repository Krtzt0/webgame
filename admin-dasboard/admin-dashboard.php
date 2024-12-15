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
    <link rel="stylesheet" href="css/style.css">
    <style>
     
    </style>
</head>
<body>
    

   
<?php include 'sidebar.php'; ?>
    <div class="content">
        <h1>Admin Dashboard</h1>
        <a href="add_product.php" class="button">Add New Product</a>
        <a href="orders_pdf.php" class="button">สรุปยอด PDF</a>
        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Details</th>
                <th>Price</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>
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
                    echo "<td><img src='{$row['product_img']}' width='50'></td>";
                    echo "<td>
                        <a href='edit_product.php?id={$row['game_product_id']}'>Edit</a> |
                        <a href='delete_product.php?id={$row['game_product_id']}' onclick='return confirm(\"Are you sure?\")'>Delete</a>
                    </td>";
                    echo "</tr>";
                }

                $conn = null; // ปิดการเชื่อมต่อ

            } catch(PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
            ?>
        </table>
    </div>
</body>
</html>
