<?php
session_start();
include("../config/db.php");  

date_default_timezone_set("Asia/Bangkok");

function handleOrder($rank, $price, $worker_id) {
    global $conn;
    $game_detail_id = '2';
    $game_product = $_POST["Rank_valo"];
    $workdetail = $_POST["Work_detail"];
    $usergame = $_POST["usergame"];
    $passgame = $_POST["passgame"];
    $status = '1';
    $member_id = $_SESSION["user_login"];
    $file_name = uploadImage();

    $iquery = "INSERT INTO tbl_orders (game_details_id, game_product, workdetail, usergame, passgame, m_img, price, status, member_id, worker_accept) 
               VALUES ('$game_detail_id', '$game_product', '$workdetail', '$usergame', '$passgame', '$file_name', '$price', '$status', '$member_id', '$worker_id');";
    
    if ($conn->query($iquery) === TRUE) {
        echo '<script>alert("สมัครเข้าใช้งานสำเร็จ!"); window.location="../index-logged.php";</script>';
    } else {
        echo '<script>alert("การสั่งซื้อสำเร็จ!!!"); window.location="../index-logged.php";</script>';
    }
}

function uploadImage() {
    if (isset($_FILES['m_img']) && $_FILES['m_img']['error'] === UPLOAD_ERR_OK) {
        $targetDirectory = "m_img/";
        $file_name = $_FILES['m_img']['name'];
        $extension = pathinfo($file_name, PATHINFO_EXTENSION);
        
        if (in_array($extension, ["jpg", "png", "jpeg"])) {
            if (move_uploaded_file($_FILES['m_img']['tmp_name'], $targetDirectory . $file_name)) {
                return $file_name;
            } else {
                echo '<script>alert("การอัพโหลดไฟล์ล้มเหลว"); window.location="../valorant/iron.php";</script>';
                exit;
            }
        } else {
            echo '<script>alert("ต้องการไฟล์ JPG, PNG, หรือ JPEG ในช่อง Logo."); window.location="../valorant/iron.php";</script>';
            exit;
        }
    }
    return "";
}

if (isset($_POST['IronBuy'])) handleOrder('Iron', $_POST["price"], $_POST["worker_id"]);
if (isset($_POST['BronzeBuy'])) handleOrder('Bronze', $_POST["price"], $_POST["worker_id"]);
if (isset($_POST['SilBuy'])) handleOrder('Silver', $_POST["price"], $_POST["worker_id"]);
if (isset($_POST['GoldBuy'])) handleOrder('Gold', $_POST["price"], $_POST["worker_id"]);
if (isset($_POST['PlatBuy'])) handleOrder('Platinum', $_POST["price"], $_POST["worker_id"]);
if (isset($_POST['DiaBuy'])) handleOrder('Diamond', $_POST["price"], $_POST["worker_id"]);
if (isset($_POST['AscBuy'])) handleOrder('Ascendant', $_POST["price"], $_POST["worker_id"]);
if (isset($_POST['ImmoBuy'])) handleOrder('Immortal', $_POST["price"], $_POST["worker_id"]);
?>
