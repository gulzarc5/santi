<?php
// include "../admin_login_system/php_user_session_check.php";
include "../database/connection.php";
header("content-type: application/json");
$request = $_REQUEST;


$sql_count = "SELECT * FROM `users` WHERE `status` = '1' AND `user_type` != '1'";

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


$sql = "SELECT * FROM `users` WHERE `status` = '1' AND `user_type` != '1'";

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
        $amount = 0;
        
		while ($row_user = $res->fetch_assoc()) {
   
			$action = '<a href="user_credit_history.php?u_id='.$row_user['id'].'" class="btn btn-success">View</a>';
            
            $credit_sql = "SELECT * FROM `user_credit` WHERE `user_id`='$row_user[id]' ORDER BY `user_id` ASC";
             if ($res_credit = $connection->query($credit_sql)) {
             	if ($res_credit->num_rows > 0) {
                     $row_credit = $res_credit->fetch_assoc();
                    
                     if(isset($row_credit['amount']) && !empty($row_credit['amount'])){
                        $amount = number_format($row_credit['amount'],2);
                     }else{
						$amount = 0;
					}
                     
                }
             	
             }
             
             $user_name = $row_user['name'];
            
            
			$data[] = [
                $count,
                $row_user['id'],
                $user_name,
                $amount,
                $action
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