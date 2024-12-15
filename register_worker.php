<?php
 session_start(); 
 require_once 'config/db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>สมัครสมาชิก</title>
    <link rel="stylesheet" href="regis.css">
</head>
<body>
    <div class="container">
        <h2>สมัครสมาชิก</h2>
        <form action="register_workerdb.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="member_name">ชื่อ:</label>
                <input type="text" id="member_name" name="member_name" required>
            </div>
            <div class="form-group">
                <label for="member_sur">นามสกุล:</label>
                <input type="text" id="member_sur" name="member_sur" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="game_details_id">เกมที่ประจำ:</label>
                <select id="game_details_id" name="game_details_id" required>
                    <option value="1">Valorant</option>
                    <option value="2">Genshin Impact</option>
                </select>
            </div>
            <div class="form-group">
                <label for="birthday">วันเกิด:</label>
                <input type="date" id="birthday" name="birthday" required>
            </div>
            <div class="form-group">
                <label for="member_img">รูปโปรไฟล:</label>
                <input type="file" id="member_img" name="member_img" accept="image/*" required>
            </div>
            <div class="form-group">
                <label for="member_idcard">รูปบัตรประชาชน:</label>
                <input type="file" id="member_idcard" name="member_idcard" accept="image/*" required>
            </div>
            <div class="form-group">
                <label for="worker_rank">รูป level&rank ปัจจุบัน:</label>
                <input type="file" id="worker_rank" name="worker_rank" accept="image/*" required>
            </div>
            <button type="submit">สมัครสมาชิก</button>
        </form>
    </div>
</body>
</html>
