<?php
// get_worker_details.php
require_once 'config/db.php';

if (isset($_GET['worker_id'])) {
    $worker_id = $_GET['worker_id'];

    $sql = "SELECT member_name, member_sur, member_img FROM tbl_member WHERE member_id = :worker_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':worker_id', $worker_id, PDO::PARAM_INT);
    $stmt->execute();
    $worker = $stmt->fetch(PDO::FETCH_ASSOC);

    echo json_encode($worker); // ส่งข้อมูลในรูปแบบ JSON กลับไปยัง JavaScript
}
?>
