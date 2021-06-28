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



  $sql = "SELECT `product`.`name` as p_name, `product`.`cost` as cost, `product`.`price` as sale_price, `product`.`regular_customer_price` as r_price, `product`.`stock` as stock, `category`.`name` as category_name  FROM `product` INNER JOIN `category` ON `category`.`id` = `product`.`category_id` WHERE `product`.`is_delete`=1 ORDER BY `product`.`stock` DESC";
$res = $connection->query($sql);




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
$active_sheet->mergeCells('D1:D2')->setCellValue('D1', 'Cost');

$active_sheet->getStyle("E1:E2")->getFont()->setBold( true );
$active_sheet->getColumnDimension("E")->setAutoSize(true);
$active_sheet->getStyle('E1:E2')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
$active_sheet->mergeCells('E1:E2')->setCellValue('E1', 'Quantity');

$active_sheet->getStyle("F1:F2")->getFont()->setBold( true );
$active_sheet->getColumnDimension("F")->setAutoSize(true);
$active_sheet->getStyle('F1:F2')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
$active_sheet->mergeCells('F1:F2')->setCellValue('F1', 'Sale Rate');

$active_sheet->getStyle("G1:G2")->getFont()->setBold( true );
$active_sheet->getColumnDimension("G")->setAutoSize(true);
$active_sheet->getStyle('G1:G2')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
$active_sheet->mergeCells('G1:G2')->setCellValue('G1', 'Regular Customer Rate');


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
        $active_sheet->setCellValue($category,$row['category_name']);

        $category = "C".$row_count;
        $active_sheet->getStyle($category)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $active_sheet->setCellValue($category,$row['p_name']);

        $category = "D".$row_count;
        $active_sheet->getStyle($category)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $active_sheet->setCellValue($category,$row['cost']);

        $category = "E".$row_count;
        $active_sheet->getStyle($category)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $active_sheet->setCellValue($category,$row['stock']);

        $category = "F".$row_count;
        $active_sheet->getStyle($category)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $active_sheet->setCellValue($category,$row['sale_price']);

        $category = "G".$row_count;
        $active_sheet->getStyle($category)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $active_sheet->setCellValue($category,$row['r_price']);
      
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