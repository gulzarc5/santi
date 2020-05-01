<?php
include "../admin_login_system/php_user_session_check.php";
include "../database/connection.php";

date_default_timezone_set('Asia/Kolkata');
include '../../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\RichText\RichText;
use PhpOffice\PhpSpreadsheet\Writer\Csv;

$s_date = $connection->real_escape_string(mysql_entities_fix_string($_GET['s_date']));
$e_date = $connection->real_escape_string(mysql_entities_fix_string($_GET['e_date']));

$s_time = $connection->real_escape_string(mysql_entities_fix_string($_GET['s_time']));
$e_time = $connection->real_escape_string(mysql_entities_fix_string($_GET['e_time']));
$res = null;
if (!empty($s_date) && !empty($e_date) && empty($s_time)) {

    $s_time_24  = "00:00:00";
    $e_time_24  = "23:59:59";
    $sql = "SELECT order_details.* ,
    orders.`id` as order_id,
    `orders`.`status` AS order_status,
    users.`mobile` as mobile, 
    category.`name` as cate_name, 
    product.`name` as p_name,  
    product.`hsn_code` as p_hsn_code,
    product.`cgst_percent` as p_cgst_percent,
    product.`sgst_percent` as p_sgst_percent
     FROM `order_details` 
     INNER JOIN `orders` ON `orders`.`id`=`order_details`.`order_id` 
     INNER JOIN `users` ON `users`.`id`=`order_details`.`user_id` 
     INNER JOIN `product` ON `product`.`id`=`order_details`.`p_id` 
     INNER JOIN `category` ON `category`.`id`=`product`.`category_id` 
     WHERE (order_details.`date` BETWEEN '$s_date' AND '$e_date' ) AND (order_details.`time` BETWEEN '$s_time_24' AND '$e_time_24') AND `orders`.`status`='2' ORDER BY `id` DESC";
    if ($res = $connection->query($sql)) {
        
    }

}elseif (!empty($s_time) && !empty($e_time) && empty($s_date)) {
    $s_time_24  = date("H:i:s", strtotime($s_time));
    $e_time_24  = date("H:i:s", strtotime($e_time));
    $s_date = date('Y-m-d');
    $e_date = date('Y-m-d');

    $sql = "SELECT order_details.* ,
    orders.`id` as order_id,
    `orders`.`status` AS order_status,
    users.`mobile` as mobile, 
    category.`name` as cate_name, 
    product.`name` as p_name,  
    product.`hsn_code` as p_hsn_code,
    product.`cgst_percent` as p_cgst_percent,
    product.`sgst_percent` as p_sgst_percent
     FROM `order_details` 
     INNER JOIN `orders` ON `orders`.`id`=`order_details`.`order_id` 
     INNER JOIN `users` ON `users`.`id`=`order_details`.`user_id` 
     INNER JOIN `product` ON `product`.`id`=`order_details`.`p_id` 
     INNER JOIN `category` ON `category`.`id`=`product`.`category_id` 
      WHERE (order_details.`date` BETWEEN '$s_date' AND '$e_date' ) AND (order_details.`time` BETWEEN '$s_time_24' AND '$e_time_24') AND `orders`.`status`='2' ORDER BY `id` DESC";
    // echo $sql;
    if ($res = $connection->query($sql)) {
        echo $res->num_rows;
    }else{
        echo "2";
    }
}elseif ((!empty($s_date) && !empty($e_date)) && !empty($s_time) && !empty($e_time)) {
    $s_time_24  = date("H:i:s", strtotime($s_time));
    $e_time_24  = date("H:i:s", strtotime($e_time));

    $sql = "SELECT order_details.* ,
    orders.`id` as order_id,
    `orders`.`status` AS order_status,
    users.`mobile` as mobile, 
    category.`name` as cate_name, 
    product.`name` as p_name,  
    product.`hsn_code` as p_hsn_code,
    product.`cgst_percent` as p_cgst_percent,
    product.`sgst_percent` as p_sgst_percent
     FROM `order_details` 
     INNER JOIN `orders` ON `orders`.`id`=`order_details`.`order_id` 
     INNER JOIN `users` ON `users`.`id`=`order_details`.`user_id` 
     INNER JOIN `product` ON `product`.`id`=`order_details`.`p_id` 
     INNER JOIN `category` ON `category`.`id`=`product`.`category_id` 
     WHERE (order_details.`date` BETWEEN '$s_date' AND '$e_date' ) AND (order_details.`time` BETWEEN '$s_time_24' AND '$e_time_24') AND `orders`.`status`='2' ORDER BY `id` DESC";
     if ($res = $connection->query($sql)) {
          
      }else{
        echo "2";
      }
}

// echo $sql;
// die();

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="order_list.Xlsx"');
header('Cache-Control: max-age=0');

$file = new Spreadsheet();
$active_sheet = $file->getActiveSheet();

$active_sheet->getStyle("A1:A2")->getFont()->setBold( true );
$active_sheet->getColumnDimension("A")->setAutoSize(true);
$active_sheet->getStyle('A1:A2')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
$active_sheet->mergeCells('A1:A2')->setCellValue('A1', 'Sl No');

$active_sheet->getStyle("B1:B2")->getFont()->setBold( true );
$active_sheet->getColumnDimension("B")->setAutoSize(true);
$active_sheet->getStyle('B1:B2')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
$active_sheet->mergeCells('B1:B2')->setCellValue('B1', 'Order Id');

$active_sheet->getStyle("C1:C2")->getFont()->setBold( true );
$active_sheet->getColumnDimension("C")->setAutoSize(true);
$active_sheet->getStyle('C1:C2')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
$active_sheet->mergeCells('C1:C2')->setCellValue('C1', 'Customer Mobile');

$active_sheet->getStyle("D1:D2")->getFont()->setBold( true );
$active_sheet->getColumnDimension("D")->setAutoSize(true);
$active_sheet->getStyle('D1:D2')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
$active_sheet->mergeCells('D1:D2')->setCellValue('D1', 'Product Category');

$active_sheet->getStyle("E1:E2")->getFont()->setBold( true );
$active_sheet->getColumnDimension("E")->setAutoSize(true);
$active_sheet->getStyle('E1:E2')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
$active_sheet->mergeCells('E1:E2')->setCellValue('E1', 'Product');

$active_sheet->getStyle("F1:F2")->getFont()->setBold( true );
$active_sheet->getColumnDimension("F")->setAutoSize(true);
$active_sheet->getStyle('F1:F2')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
$active_sheet->mergeCells('F1:F2')->setCellValue('F1', 'HSN / SAC');

$active_sheet->getStyle("G1:G2")->getFont()->setBold( true );
$active_sheet->getColumnDimension("G")->setAutoSize(true);
$active_sheet->getStyle('G1:G2')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
$active_sheet->mergeCells('G1:G2')->setCellValue('G1', 'Sale Price');

$active_sheet->getStyle("H1:H2")->getFont()->setBold( true );
$active_sheet->getColumnDimension("H")->setAutoSize(true);
$active_sheet->getStyle('H1:H2')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
$active_sheet->mergeCells('H1:H2')->setCellValue('H1', 'Sale Quantity');

$active_sheet->getStyle("I1:I2")->getFont()->setBold( true );
$active_sheet->getColumnDimension("I")->setAutoSize(true);
$active_sheet->getStyle('I1:I2')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
$active_sheet->mergeCells('I1:I2')->setCellValue('I1', 'Total Amount');

$active_sheet->getStyle("J1:K1")->getFont()->setBold( true );
$active_sheet->getColumnDimension("J")->setAutoSize(true);
$active_sheet->getColumnDimension("K")->setAutoSize(true);
$active_sheet->getStyle('J1:K1')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
$active_sheet->mergeCells('J1:K1')->setCellValue('J1', 'CGST');

$active_sheet->getStyle("J2")->getFont()->setBold( true );
$active_sheet->getStyle('J2')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
$active_sheet->setCellValue('J2', '%');

$active_sheet->getStyle("K2")->getFont()->setBold( true );
$active_sheet->getStyle('K2')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
$active_sheet->setCellValue('K2', 'Amount');

$active_sheet->getStyle("L1:M1")->getFont()->setBold( true );
$active_sheet->getColumnDimension("L")->setAutoSize(true);
$active_sheet->getColumnDimension("M")->setAutoSize(true);
$active_sheet->getStyle('L1:M1')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
$active_sheet->mergeCells('L1:M1')->setCellValue('L1', 'SGST');

$active_sheet->getStyle("L2")->getFont()->setBold( true );
$active_sheet->getStyle('L2')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
$active_sheet->setCellValue('L2', '%');

$active_sheet->getStyle("M2")->getFont()->setBold( true );
$active_sheet->getStyle('M2')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
$active_sheet->setCellValue('M2', 'Amount');


$active_sheet->getStyle("N1:N2")->getFont()->setBold( true );
$active_sheet->getColumnDimension("N")->setAutoSize(true);
$active_sheet->getStyle('N1:N2')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
$active_sheet->mergeCells('N1:N2')->setCellValue('N1', 'Total CGST');


$active_sheet->getStyle("O1:O2")->getFont()->setBold( true );
$active_sheet->getColumnDimension("O")->setAutoSize(true);
$active_sheet->getStyle('O1:O2')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
$active_sheet->mergeCells('O1:O2')->setCellValue('O1', 'Total SGST');

$active_sheet->getStyle("P1:P2")->getFont()->setBold( true );
$active_sheet->getColumnDimension("P")->setAutoSize(true);
$active_sheet->getStyle('P1:P2')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
$active_sheet->mergeCells('P1:P2')->setCellValue('P1', 'Date');


$count = 1;
$row_count = 3;

if (!empty($res)) {
  if ($res->num_rows > 0) {
      while ($row = $res->fetch_assoc()) {
        $sl_no = "A".$row_count;
        $active_sheet->getStyle($sl_no)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $active_sheet->setCellValue($sl_no, $count);

        $category = "B".$row_count;
        $active_sheet->getStyle($category)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $active_sheet->setCellValue($category,$row['order_id']);

        $category = "C".$row_count;
        $active_sheet->getStyle($category)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $active_sheet->setCellValue($category,$row['mobile']);

        $category = "D".$row_count;
        $active_sheet->getStyle($category)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $active_sheet->setCellValue($category,$row['cate_name']);

        $category = "E".$row_count;
        $active_sheet->getStyle($category)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $active_sheet->setCellValue($category,$row['p_name']);

        $category = "F".$row_count;
        $active_sheet->getStyle($category)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $active_sheet->setCellValue($category,$row['p_hsn_code']);

        $category = "G".$row_count;
        $active_sheet->getStyle($category)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $active_sheet->setCellValue($category,$row['price']);

        $category = "H".$row_count;
        $active_sheet->getStyle($category)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $active_sheet->setCellValue($category,$row['quantity']);

        $category = "I".$row_count;
        $active_sheet->getStyle($category)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $active_sheet->setCellValue($category,$row['total_amount']);

        $category = "J".$row_count;
        $active_sheet->getStyle($category)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $active_sheet->setCellValue($category,$row['p_cgst_percent']);

        $category = "K".$row_count;
        $active_sheet->getStyle($category)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $active_sheet->setCellValue($category,$row['cgst']);

        $category = "L".$row_count;
        $active_sheet->getStyle($category)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $active_sheet->setCellValue($category,$row['p_sgst_percent']);

        $category = "M".$row_count;
        $active_sheet->getStyle($category)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $active_sheet->setCellValue($category,$row['sgst']);

        $category = "N".$row_count;
        $active_sheet->getStyle($category)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $active_sheet->setCellValue($category,$row['total_cgst']);

        $category = "O".$row_count;
        $active_sheet->getStyle($category)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $active_sheet->setCellValue($category,$row['total_sgst']);

        $category = "P".$row_count;
        $active_sheet->getStyle($category)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $active_sheet->setCellValue($category,$row['date']);
      
        $count++;
        $row_count++;
      }
  }
}





$writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($file, 'Xlsx');
$writer->save('php://output');


function mysql_entities_fix_string($string){return htmlentities(mysql_fix_string($string));}
function mysql_fix_string($string){
    if (get_magic_quotes_gpc()) 
        $string = stripslashes($string);
    return $string;
}
?>