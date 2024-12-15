<?php
require_once('TCPDF/tcpdf.php');
require_once('../config/db.php'); // เชื่อมต่อกับฐานข้อมูล

// สร้างคลาสใหม่โดยสืบทอดจาก TCPDF
class PDF extends TCPDF {

    // เมธอดสำหรับสร้างเนื้อหา PDF
    public function generatePDF($orders) {
        // กำหนดขนาดและรูปแบบของหน้ากระดาษ
        $this->SetMargins(10, 10, 10);
        $this->AddPage();

        // เนื้อหาที่ต้องการเพิ่มเข้าไปใน PDF
        $content = '<h1 style="text-align:center;">รายงานยอดซื้อสินค้า</h1>';
        $content .= '<table border="1" cellpadding="5">';
        $content .= '<tr><th>Order ID</th><th>Game Details ID</th><th>Game Product</th><th>Work Detail</th><th>User Game</th><th>Pass Game</th><th>Image</th><th>Price</th><th>Status</th><th>Order Time</th><th>Member ID</th></tr>';

        // วนลูปเพื่อเพิ่มข้อมูลแต่ละรายการ
        foreach ($orders as $order) {
            $content .= '<tr>';
            $content .= '<td>' . $order['orders_id'] . '</td>';
            $content .= '<td>' . $order['game_details_id'] . '</td>';
            $content .= '<td>' . $order['game_product'] . '</td>';
            $content .= '<td>' . $order['workdetail'] . '</td>';
            $content .= '<td>' . $order['usergame'] . '</td>';
            $content .= '<td>' . $order['passgame'] . '</td>';
            $content .= '<td>' . $order['m_img'] . '</td>';
            $content .= '<td>' . $order['price'] . '</td>';
            $content .= '<td>' . $order['status'] . '</td>';
            $content .= '<td>' . $order['orders_time'] . '</td>';
            $content .= '<td>' . $order['member_id'] . '</td>';
            $content .= '</tr>';
        }

        $content .= '</table>';

        // เพิ่มเนื้อหาลงใน PDF
        $this->writeHTML($content, true, false, true, false, '');

        // สุดท้ายคืนค่าเอกสาร PDF ที่สร้างไว้
        return $this;
    }
}

// เรียกใช้คลาส PDF
$pdf = new PDF();
$pdf->SetTitle('รายงานยอดซื้อสินค้า');
$pdf->SetHeaderData('', 0, 'IDashop', '');
$pdf->SetHeaderMargin(5);
$pdf->SetTopMargin(20);
$pdf->SetAutoPageBreak(true, 10);

// คำสั่ง SQL เพื่อดึงข้อมูลจากฐานข้อมูล
$sql = "SELECT * FROM tbl_orders";
$stmt = $pdo->query($sql);
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

// เรียกใช้เมธอดสร้าง PDF และส่งข้อมูล orders เข้าไป
$pdf->generatePDF($orders);

// สร้างไฟล์ PDF และส่งไปยังผู้ใช้
$pdf->Output('orders_report.pdf', 'D');
