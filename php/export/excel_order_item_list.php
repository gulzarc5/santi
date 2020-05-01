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

    $sql = "SELECT `product`.`cash_back` AS p_cash_back,`product`.`sgst` AS p_sgst,`product`.`cgst` AS p_cgst,`product`.`cost` AS p_cost,`product`.`hsn_code` AS hsn_code,`product`.`name` AS p_name, `category`.`name` AS c_name, `order_details`.`p_id` as `p_id`,SUM(`order_details`.`quantity`) as quantity,SUM(`order_details`.`total_amount`) as total_amount FROM `order_details` INNER JOIN `product` ON `product`.`id`=`order_details`.`p_id` INNER JOIN `category` ON `category`.`id`=`product`.`category_id` WHERE `order_details`.`date` BETWEEN '$s_date' AND '$e_date' AND `order_details`.`time` BETWEEN '$s_time_24' AND '$e_time_24' GROUP BY `order_details`.`p_id` ORDER BY quantity DESC";
    //echo $sql;
    if ($res = $connection->query($sql)) {
        
    }else{
      echo "2";
    }

}elseif (!empty($s_time) && !empty($e_time) && empty($s_date)) {
    $s_time_24  = date("H:i:s", strtotime($s_time));
    $e_time_24  = date("H:i:s", strtotime($e_time));
    $s_date = date('Y-m-d');
    $e_date = date('Y-m-d');

    $sql = "SELECT `product`.`cash_back` AS p_cash_back,`product`.`sgst` AS p_sgst,`product`.`cgst` AS p_cgst,`product`.`cost` AS p_cost,`product`.`hsn_code` AS hsn_code,`product`.`name` AS p_name, `category`.`name` AS c_name, `order_details`.`p_id` as `p_id`,SUM(`order_details`.`quantity`) as quantity,SUM(`order_details`.`total_amount`) as total_amount FROM `order_details` INNER JOIN `product` ON `product`.`id`=`order_details`.`p_id` INNER JOIN `category` ON `category`.`id`=`product`.`category_id` WHERE `order_details`.`date` BETWEEN '$s_date' AND '$e_date' AND `order_details`.`time` BETWEEN '$s_time_24' AND '$e_time_24' GROUP BY `order_details`.`p_id` ORDER BY quantity DESC";
    //echo $sql;
    if ($res = $connection->query($sql)) {
        
    }else{
      echo "2";
    }
}elseif ((!empty($s_date) && !empty($e_date)) && !empty($s_time) && !empty($e_time)) {
  $s_time_24  = date("H:i:s", strtotime($s_time));
  $e_time_24  = date("H:i:s", strtotime($e_time));

  $sql = "SELECT `product`.`cash_back` AS p_cash_back,`product`.`sgst` AS p_sgst,`product`.`cgst` AS p_cgst,`product`.`cost` AS p_cost,`product`.`hsn_code` AS hsn_code,`product`.`name` AS p_name, `category`.`name` AS c_name, `order_details`.`p_id` as `p_id`,SUM(`order_details`.`quantity`) as quantity,SUM(`order_details`.`total_amount`) as total_amount FROM `order_details` INNER JOIN `product` ON `product`.`id`=`order_details`.`p_id` INNER JOIN `category` ON `category`.`id`=`product`.`category_id` WHERE `order_details`.`date` BETWEEN '$s_date' AND '$e_date' AND `order_details`.`time` BETWEEN '$s_time_24' AND '$e_time_24' GROUP BY `order_details`.`p_id` ORDER BY quantity DESC";
    if ($res = $connection->query($sql)) {
        
    }else{
      echo "2";
    }
}



header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="order_item_list.Xlsx"');
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
$active_sheet->mergeCells('B1:B2')->setCellValue('B1', 'Product Category');

$active_sheet->getStyle("C1:C2")->getFont()->setBold( true );
$active_sheet->getColumnDimension("C")->setAutoSize(true);
$active_sheet->getStyle('C1:C2')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
$active_sheet->mergeCells('C1:C2')->setCellValue('C1', 'Product');

$active_sheet->getStyle("D1:D2")->getFont()->setBold( true );
$active_sheet->getColumnDimension("D")->setAutoSize(true);
$active_sheet->getStyle('D1:D2')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
$active_sheet->mergeCells('D1:D2')->setCellValue('D1', 'HSN / SAC');

$active_sheet->getStyle("E1:E2")->getFont()->setBold( true );
$active_sheet->getColumnDimension("E")->setAutoSize(true);
$active_sheet->getStyle('E1:E2')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
$active_sheet->mergeCells('E1:E2')->setCellValue('E1', 'Cost');

$active_sheet->getStyle("F1:F2")->getFont()->setBold( true );
$active_sheet->getColumnDimension("F")->setAutoSize(true);
$active_sheet->getStyle('F1:F2')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
$active_sheet->mergeCells('F1:F2')->setCellValue('F1', 'Sale Quantity');

$active_sheet->getStyle("G1:G2")->getFont()->setBold( true );
$active_sheet->getColumnDimension("G")->setAutoSize(true);
$active_sheet->getStyle('G1:G2')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
$active_sheet->mergeCells('G1:G2')->setCellValue('G1', 'Total Amount');

$active_sheet->getStyle("H1:I1")->getFont()->setBold( true );
$active_sheet->getColumnDimension("H")->setAutoSize(true);
$active_sheet->getColumnDimension("I")->setAutoSize(true);
$active_sheet->getStyle('H1:I1')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
$active_sheet->mergeCells('H1:I1')->setCellValue('H1', 'CGSt');

$active_sheet->getStyle("H2")->getFont()->setBold( true );
$active_sheet->getStyle('H2')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
$active_sheet->setCellValue('H2', '%');

$active_sheet->getStyle("I2")->getFont()->setBold( true );
$active_sheet->getStyle('I2')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
$active_sheet->setCellValue('I2', 'Amount');

$active_sheet->getStyle("J1:K1")->getFont()->setBold( true );
$active_sheet->getColumnDimension("J")->setAutoSize(true);
$active_sheet->getColumnDimension("K")->setAutoSize(true);
$active_sheet->getStyle('J1:K1')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
$active_sheet->mergeCells('J1:K1')->setCellValue('J1', 'SGST');

$active_sheet->getStyle("J2")->getFont()->setBold( true );
$active_sheet->getStyle('J2')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
$active_sheet->setCellValue('J2', '%');

$active_sheet->getStyle("K2")->getFont()->setBold( true );
$active_sheet->getStyle('K2')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
$active_sheet->setCellValue('K2', 'Amount');



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
        $active_sheet->setCellValue($category,$row['c_name']);

        $category = "C".$row_count;
        $active_sheet->getStyle($category)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $active_sheet->setCellValue($category,$row['p_name']);

        $category = "D".$row_count;
        $active_sheet->getStyle($category)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $active_sheet->setCellValue($category,$row['hsn_code']);

        $category = "E".$row_count;
        $active_sheet->getStyle($category)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $active_sheet->setCellValue($category,$row['p_cost']);

        $category = "F".$row_count;
        $active_sheet->getStyle($category)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $active_sheet->setCellValue($category,$row['quantity']);

        $category = "G".$row_count;
        $active_sheet->getStyle($category)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $active_sheet->setCellValue($category,$row['total_amount']);
      
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