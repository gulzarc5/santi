<?php
include "../admin_login_system/php_user_session_check.php";
include "../database/connection.php";
header("content-type: application/json");
$request = $_REQUEST;

$sql_count = "SELECT `product`.`id` as p_id,`product`.`name` as name, `product`.`description` AS description,`product`.`price` as price,`product`.`stock` AS stock, `category`.`name` AS category, `sub_category`.`name` AS sub_category  FROM `product` INNER JOIN `category` ON `category`.`id`=`product`.`category_id` LEFT JOIN `sub_category` ON `sub_category`.`id`=`product`.`sub_cat_id` WHERE (`product`.`is_delete`=1)";

//Searching 
if (!empty($request['search']['value'])) {
	$srch_key = $request['search']['value'];
	$sql_count = $sql_count." AND (`product`.`name` LIKE '%$srch_key%' OR `category`.`name`  LIKE '%$srch_key%' OR `sub_category`.`name` LIKE '%$srch_key%' OR `product`.`price` LIKE '%$srch_key%' OR `product`.`stock` LIKE '%$srch_key%')";

}
//End Searching
if ($res_count = $connection->query($sql_count)) {
	$totalData = $res_count->num_rows;
	$totalFilater = $res_count->num_rows;
}


$sql = "SELECT `product`.*,`category`.`name` AS category, `sub_category`.`name` AS sub_category  FROM `product` INNER JOIN `category` ON `category`.`id`=`product`.`category_id` LEFT JOIN `sub_category` ON `sub_category`.`id`=`product`.`sub_cat_id` WHERE (`product`.`is_delete`=1)";

if (!empty($request['search']['value'])) {
	$sql = $sql." AND (`product`.`barcode` LIKE '%$srch_key%' OR `product`.`name` LIKE '%$srch_key%' OR `category`.`name`  LIKE '%$srch_key%' OR `sub_category`.`name` LIKE '%$srch_key%' OR `product`.`price` LIKE '%$srch_key%' OR `product`.`stock` LIKE '%$srch_key%')";
}
	// Ordering
	if($request['order'][0]['column'] != 0){
		$str_ord = $request['order'][0]['column'];
		$en_ord = $request['order'][0]['dir'];
		$sql = $sql."ORDER BY $str_ord $en_ord ";
	}else{
		$sql = $sql." ORDER BY `product`.`id` DESC ";
		// $sql = $sql."ORDER BY IF(`products`.`name` RLIKE '^[a-z]', 1, 2), `products`.`name`";
	}
	$sql = $sql." LIMIT $request[start],$request[length]";



if ($res = $connection->query($sql)) {
	$data = [];
	$count = 1;
	while ($row = $res->fetch_assoc()) {
		$action = '<a href="product_view.php?p_id='.$row['id'].'&page=1005" class="btn btn-info">View</a>';
		if ($row['is_star_product'] == '1') {
			$action .= '<a href="php/product/make_star_product.php?p_id='.$row['id'].'&page=1005" class="btn btn-primary">Make Free Shopping Product</a>';
		}
		$action .= '<a href="product_edit.php?p_id='.$row['id'].'&page=1005" class="btn btn-success">Edit</a>
            <a href="php/product/product_delete.php?p_id='.$row['id'].'&page=1005" class="btn btn-danger">Delete</a>
            <a href="add_stock_form.php?p_id='.$row['id'].'&page=1005" class="btn btn-warning">Add Stock</a>';
        if (!empty($row['barcode'])) {
        	$action .= '<a href="print_bar_code_form.php?p_id='.$row['id'].'" class="btn btn-primary">Print Bar Code</a>';
        }
		$data[] = [
			$count,
			$row['barcode'],
			$row['name'],
			$row['category'],
			$row['sub_category'],
			$row['price'],
			$row['stock'],			
			$action,
		];
		$count++;
	}

	$jsonData = array(
		"draw" => intval(isset($_REQUEST["draw"]) ? $_REQUEST["draw"] : 0),
		"recordsTotal" => intval($totalData),
		"recordsFiltered" => intval($totalFilater),
		"data" => $data
	);

	echo json_encode($jsonData);
}
?>