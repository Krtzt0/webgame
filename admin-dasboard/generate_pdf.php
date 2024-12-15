<?php
session_start();
require_once '../config/db.php';
require('fpdf186/fpdf.php');

if (!isset($_SESSION['admin_login'])) {
    $_SESSION['error'] = 'กรุณาเข้าสู่ระบบ!';
    header('location: login.php');
    exit();
}

class PDF extends FPDF
{
    function Header()
    {
        // Add Thai font before using it
        $this->AddFont('THSarabunNew', '', 'THSarabunNew.php');
        $this->AddFont('THSarabunNew', 'B', 'THSarabunNew_b.php');
        
        // Set font for title
        $this->SetFont('THSarabunNew', 'B', 14);
        $this->Cell(0, 10, iconv('UTF-8', 'cp874', 'สรุปยอดงานจ้างทั้งหมด'), 0, 1, 'C');
        $this->Ln(10);
        
        // Set font for table header
        $this->SetFont('THSarabunNew', '', 12);
        
        // Table headers with proper encoding
        $this->Cell(20, 10, iconv('UTF-8', 'cp874', 'Order ID'), 1, 0, 'C');
        $this->Cell(30, 10, iconv('UTF-8', 'cp874', 'ประเภทเกม'), 1, 0, 'C');
		$this->Cell(30, 10, iconv('UTF-8', 'cp874', 'รายละเอียดงานจ้าง'), 1, 0, 'C'); // เพิ่มคอลัมน์เกมผลิตภัณฑ์
        $this->Cell(50, 10, iconv('UTF-8', 'cp874', 'ลำดับขั้นที่จ้าง'), 1, 0, 'C');
        $this->Cell(30, 10, iconv('UTF-8', 'cp874', 'ราคา'), 1, 0, 'C');
        $this->Cell(30, 10, iconv('UTF-8', 'cp874', 'สถานะ'), 1, 0, 'C');
       
        $this->Ln();
    }

    function Footer()
    {
        $this->SetY(-15);
        $this->AddFont('THSarabunNew', '', 'THSarabunNew.php');
        $this->SetFont('THSarabunNew', '', 8); // Changed from 'I' to '' as there's no italic version
        $this->Cell(0, 10, 'Page ' . $this->PageNo(), 0, 0, 'C');
    }
}

// Create new PDF instance
$pdf = new PDF();
$pdf->AddPage();

// Add Thai fonts (moved after PDF instance creation)
$pdf->AddFont('THSarabunNew', '', 'THSarabunNew.php');
$pdf->AddFont('THSarabunNew', 'B', 'THSarabunNew_b.php');

// Fetch data from database
try {
    // เพิ่มการดึงข้อมูล game_product จาก tbl_orders
    $sql = "SELECT o.*, m.username, o.game_product
            FROM tbl_orders o
            INNER JOIN tbl_member m ON o.member_id = m.member_id
            WHERE o.status = 3"; // กรองเฉพาะสถานะที่เป็น 3
    $stmt = $conn->query($sql);

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $game_details = '';
        switch ($row['game_details_id']) {
            case 1:
                $game_details = 'Valorant';
                break;
            case 2:
                $game_details = 'Genshin Impact';
                break;
        }
        
        $work_detail = '';
        switch ($row['workdetail']) {
            case 1:
                $work_detail = 'Rank 1-2';
                break;
            case 2:
                $work_detail = 'Rank 2-3';
                break;
            case 3:
                $work_detail = 'Rank 1-3';
                break;
        }

        $status = '';
        switch ($row['status']) {
            case 1:
                $status = 'รอดำเนินการ';
                break;
            case 2:
                $status = 'กำลังดำเนินการ';
                break;
            case 3:
                $status = 'ดำเนินการเสร็จสิ้น';
                break;
        }

        
        $pdf->SetFont('THSarabunNew', '', 12);
        
    
        $pdf->Cell(20, 10, $row['orders_id'], 1, 0, 'C');
        $pdf->Cell(30, 10, $game_details, 1, 0, 'C');
		$pdf->Cell(30, 10, iconv('UTF-8', 'cp874', $row['game_product']), 1, 0, 'C'); 
        $pdf->Cell(50, 10, $work_detail, 1, 0, 'C');
        $pdf->Cell(30, 10, number_format($row['price'], 2), 1, 0, 'C');
        $pdf->Cell(30, 10, iconv('UTF-8', 'cp874', $status), 1, 0, 'C');
        
        $pdf->Ln();
    }

    // Output PDF
    $pdf->Output('I', 'order_summary.pdf');

} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}

$conn = null;
?>
