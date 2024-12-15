<?php
session_start();
require_once 'config/db.php'; 


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $member_name = $_POST['member_name'];
    $member_sur = $_POST['member_sur'];
    $email = $_POST['email'];
    $game_details_id = $_POST['game_details_id'];
    $member_img = $_FILES['member_img']['name']; 
    $member_img_tmp = $_FILES['member_img']['tmp_name']; 
    $member_idcard = $_FILES['member_idcard']['name']; 
    $member_idcard_tmp = $_FILES['member_idcard']['tmp_name']; 
    $worker_rank = $_FILES['worker_rank']['name']; 
    $worker_rank_tmp = $_FILES['worker_rank']['tmp_name']; 
    $birthday = $_POST['birthday'];

  
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

   
    $sql = "INSERT INTO tbl_member (username, password, member_name, member_sur, email, game_details_id, member_img, member_idcard, worker_rank, birthday, role)
            VALUES (:username, :password, :member_name, :member_sur, :email, :game_details_id, :member_img, :member_idcard, :worker_rank, :birthday, 'worker')";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':password', $hashed_password); 
    $stmt->bindParam(':member_name', $member_name);
    $stmt->bindParam(':member_sur', $member_sur);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':game_details_id', $game_details_id);
    $stmt->bindParam(':member_img', $member_img);
    $stmt->bindParam(':member_idcard', $member_idcard);
    $stmt->bindParam(':worker_rank', $worker_rank); 
    $stmt->bindParam(':birthday', $birthday);

    // อัพโหลดไฟล์รูปประจำตัว
    move_uploaded_file($member_img_tmp, "uploads/" . $member_img);
    // อัพโหลดไฟล์รูปบัตรประชาชน
    move_uploaded_file($member_idcard_tmp, "uploads/" . $member_idcard);
    // อัพโหลดไฟล์ worker_rank
    move_uploaded_file($worker_rank_tmp, "uploads/" . $worker_rank);

    if ($stmt->execute()) {
        echo "บันทึกข้อมูลเรียบร้อยแล้ว";
        header("location: login.php");
        exit; 
    } else {
        echo "เกิดข้อผิดพลาดในการบันทึกข้อมูล: " . implode(", ", $stmt->errorInfo());
    }
}
?>
