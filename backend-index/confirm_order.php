<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirm Order</title>
    <link rel="stylesheet" href="../style.css">
    <style>
        body {
            background-color: #f4f4f4;
            font-family: 'Roboto', sans-serif;
        }

        .container {
            max-width: 800px;
            margin: auto;
            padding: 20px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .order-details {
            margin-bottom: 20px;
        }

        .order-details div {
            margin-bottom: 10px;
        }

        .order-details label {
            font-weight: bold;
        }

        .form-group input[type="file"],
        .form-group input[type="text"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .form-group input[type="submit"] {
            width: 100%;
            background-color: #28a745;
            color: #fff;
            border: none;
            padding: 15px;
            cursor: pointer;
            font-size: 16px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .form-group input[type="submit"]:hover {
            background-color: #218838;
        }

        .qr-code {
            text-align: center;
            margin: 20px 0;
        }

        .qr-code img {
            max-width: 200px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>ยืนยันการจ้างงาน</h2>

    <div class="order-details">
        <div>
            <label>สินค้าที่เลือก:</label> <?php echo htmlspecialchars($_POST['Rank_valo']); ?>
        </div>
        <div>
            <label>รายละเอียดการทำงาน:</label> <?php echo htmlspecialchars($_POST['Work_detail']); ?>
        </div>
        <div>
            <label>ราคา:</label> <?php echo htmlspecialchars($_POST['price']); ?> บาท
        </div>
        <div>
            <label>Username:</label> <?php echo htmlspecialchars($_POST['usergame']); ?>
        </div>
        <div>
            <label>Password:</label> <?php echo htmlspecialchars($_POST['passgame']); ?>
        </div>
        <div>
            <label>พนักงานที่เลือก:</label> <?php echo htmlspecialchars($_POST['worker_name']); ?>
        </div>
    </div>

    <div class="qr-code">
        <p>กรุณาสแกน QR Code เพื่อชำระเงิน:</p>
        <img src="../images/download.jpg" alt="QR Code">
    </div>

   
    <form action="saveorder.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="Rank_valo" value="<?php echo htmlspecialchars($_POST['Rank_valo']); ?>">
        <input type="hidden" name="Work_detail" value="<?php echo htmlspecialchars($_POST['Work_detail']); ?>">
        <input type="hidden" name="price" value="<?php echo htmlspecialchars($_POST['price']); ?>">
        <input type="hidden" name="usergame" value="<?php echo htmlspecialchars($_POST['usergame']); ?>">
        <input type="hidden" name="passgame" value="<?php echo htmlspecialchars($_POST['passgame']); ?>">
        <input type="hidden" name="worker_id" value="<?php echo htmlspecialchars($_POST['worker_id']); ?>"> 

        <div class="form-group">
            <label>แนบสลิปการชำระเงิน:</label>
            <input type="file" name="m_img" required> 
        </div>

        <div class="form-group">
            <input type="submit" name="confirmOrder" value="ยืนยันการชำระเงิน">
        </div>
    </form>
</div>

</body>
</html>
