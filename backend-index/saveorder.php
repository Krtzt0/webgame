<?php
session_start();
include("../config/db.php");  

date_default_timezone_set("Asia/Bangkok");


function handleOrder($rank, $price, $worker_id) {
    global $conn;

    $game_detail_id = '1'; 
    $game_product = $_POST["Rank_valo"]; 
    $workdetail = $_POST["Work_detail"]; 
    $usergame = $_POST["usergame"]; 
    $passgame = $_POST["passgame"]; 
    $status = '1'; 
    $member_id = $_SESSION["user_login"]; 
    $file_name = uploadImage(); 


    $iquery = "INSERT INTO tbl_orders 
        (game_details_id, game_product, workdetail, usergame, passgame, m_img, price, status, member_id, worker_accept) 
        VALUES ('$game_detail_id', '$game_product', '$workdetail', '$usergame', '$passgame', '$file_name', '$price', '$status', '$member_id', '$worker_id');";


    if ($conn->query($iquery) === TRUE) {
        echo '<script>alert("การจ้างงานเสร็จสิ้น!"); window.location="../index-logged.php";</script>';
    } else {
        echo '<script>alert("การจ้างงานเสร็จสิ้น!"); window.location="../index-logged.php";</script>';
    }
}

// ฟังก์ชันสำหรับการอัพโหลดรูปภาพ
function uploadImage() {
    if (isset($_FILES['m_img']) && $_FILES['m_img']['error'] === UPLOAD_ERR_OK) {
        $targetDirectory = "m_img/"; // โฟลเดอร์ที่เก็บรูปภาพ
        $file_name = $_FILES['m_img']['name'];
        $extension = pathinfo($file_name, PATHINFO_EXTENSION);

        // ตรวจสอบนามสกุลไฟล์ที่อนุญาต (jpg, png, jpeg)
        if (in_array($extension, ["jpg", "png", "jpeg"])) {
            // ย้ายไฟล์ที่อัพโหลดไปยังโฟลเดอร์เป้าหมาย
            if (move_uploaded_file($_FILES['m_img']['tmp_name'], $targetDirectory . $file_name)) {
                return $file_name;
            } else {
                echo '<script>alert("การอัพโหลดไฟล์ล้มเหลว"); window.location="../confirm_order.php";</script>';
                exit;
            }
        } else {
            echo '<script>alert("กรุณาอัพโหลดไฟล์ JPG, PNG หรือ JPEG เท่านั้น"); window.location="../confirm_order.php";</script>';
            exit;
        }
    }
    return "";
}


if (isset($_POST['confirmOrder'])) {
    handleOrder($_POST["Rank_valo"], $_POST["price"], $_POST["worker_id"]);
}
?>
