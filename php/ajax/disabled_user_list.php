<?php
include "../admin_login_system/php_user_session_check.php";
include "../database/connection.php";
header("content-type: application/json");
$request = $_REQUEST;


$sql_count = "SELECT * FROM `users` WHERE `status` = '2'";

//Searching 
if (!empty($request['search']['value'])) {
	$srch_key = $request['search']['value'];
	$sql_count = $sql_count." AND (`name` LIKE '%$srch_key%' OR `email`  LIKE '%$srch_key%' OR `mobile` LIKE '%$srch_key%')";

}

//End Searching
if ($res_count = $connection->query($sql_count)) {
	$totalData = $res_count->num_rows;
	$totalFilater = $res_count->num_rows;
}


$sql = "SELECT * FROM `users` WHERE `status` = '2'";

if (!empty($request['search']['value'])) {
	$sql = $sql."  AND (`name` LIKE '%$srch_key%' OR `email`  LIKE '%$srch_key%' OR `mobile` LIKE '%$srch_key%')";
}
	//Ordering
	if($request['order'][0]['column'] != 0){
		$str_ord = $request['order'][0]['column'];
		$en_ord = $request['order'][0]['dir'];
		$sql = $sql."ORDER BY $str_ord $en_ord ";
	}else{
		$sql = $sql."ORDER BY `id` DESC ";
	}
	$sql = $sql."LIMIT $request[start],$request[length]";


	if ($res = $connection->query($sql)) {
		$data = [];
		$count = 1;
		while ($row_user = $res->fetch_assoc()) {
			
             if ($row_user['status'] == 1) {
             	$action ='<a href=php/users/user_status_update.php?u_id='.$row_user['id'].'&status=2" class="btn btn-danger">Deactivate</a>';
             }elseif ($row_user['status'] == 2) {
             	$action ='<a href="php/users/user_status_update.php?u_id='.$row_user['id'].'&status=1" class="btn btn-success">Activate</a>';
             }
			$data[] = [
				$count,
				$row_user['id'],
				$row_user['name'],
				$row_user['email'],
				$row_user['mobile'],
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