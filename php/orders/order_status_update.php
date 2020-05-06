<?php
    include "../admin_login_system/php_user_session_check.php";
	include "../database/connection.php";

    date_default_timezone_set('Asia/Kolkata');
    
	if (isset($_GET['id'])) {
    	$order_id = $connection->real_escape_string(mysql_entities_fix_string($_GET['id']));
        $s_date = $connection->real_escape_string(mysql_entities_fix_string($_GET['s_date']));
        $e_date = $connection->real_escape_string(mysql_entities_fix_string($_GET['e_date'])); 
        date_default_timezone_set('Asia/Kolkata');
        $date = date('Y-m-d');
        $time = date('H:i:s');

        
        /////////////////////////////////////////////////////////////////////////////
        //Parent Cashback
        $sql_orders = "SELECT * FROM `orders` WHERE `id`='$order_id'";
        if ($res_orders = $connection->query($sql_orders)) {
            $row_orders = $res_orders->fetch_assoc();
            if (!empty($row_orders['user_id']) && ($row_orders['cashback'] > 0 )) {
                cashbackCredit($row_orders['user_id'],$row_orders['cashback'],$connection);
            }
        }


        /// Product Purchase Cash Back Credit To User Walle
        $total_promotional_bonus = 0;

        $order_detail_sql = "SELECT 
        `order_details`.`user_id` AS u_id, 
        `order_details`.`id` AS order_detail_id,
        `order_details`.`p_id` AS p_id,
        `order_details`.`quantity` AS quantity,
        `product`.`promotional_bonus` AS promotional_bonus,
        `product`.`name` AS p_name,
        `wallet`.`id` AS wallet_id,
         `wallet`.`amount` AS wallet_amount FROM `order_details` 
         LEFT JOIN `product` ON `product`.`id` = `order_details`.`p_id` 
         LEFT JOIN `wallet` ON `wallet`.`user_id`=`order_details`.`user_id`
          WHERE `order_details`.`order_id`='$order_id'";
        if ($res_order_detail = $connection->query($order_detail_sql)) {
            while ($row_order_detail = $res_order_detail->fetch_assoc()) {

                if (isset($row_order_detail['promotional_bonus']) && ($row_order_detail['promotional_bonus'] > 0)) {
                    $total_promotional_bonus+=($row_order_detail['promotional_bonus']*$row_order_detail['quantity']);
                }

                $check_star_sql = "SELECT * FROM `product` WHERE `id`='$row_order_detail[p_id]' AND `is_star_product` = '2'";
                if ($res_check_star = $connection->query($check_star_sql)) {
                    if ($res_check_star->num_rows > 0) {
                        $month = date('m');
                        $year = date('Y');

                        // Check product is already addedd in star order of current month or not
                        $check_current_month_star_sql = "SELECT * FROM `orders_star` WHERE MONTH(created_at) = '$month' AND YEAR(created_at) = '$year' AND `p_id`='$row_order_detail[p_id]' AND `user_id`='$row_order_detail[u_id]'";
                        if ($res_check_current_month_star = $connection->query($check_current_month_star_sql)) {
                            if ($res_check_current_month_star->num_rows == 0) {
                                // Add Product User Star Product Purchase List if product is star product
                                $star_sql = "INSERT INTO `orders_star`(`id`, `user_id`, `order_detail_id`, `p_id`, `created_at`) VALUES (null,'$row_order_detail[u_id]','$row_order_detail[order_detail_id]','$row_order_detail[p_id]','$date')";
                                if ($res_star = $connection->query($star_sql)) {}
                            } 
                        }                     
                    }
                }
                
            }
        } 

        $sql_parent = "SELECT 
        `users`.`parent_id` AS parent_id FROM `orders`
         LEFT JOIN `users` ON `users`.`id`=`orders`.`user_id`
         WHERE `orders`.`id`='$order_id'
        ";
        if ($res_parent = $connection->query($sql_parent)) {
            $row_parent = $res_parent->fetch_assoc();
            if (!empty($row_parent['parent_id']) && !empty( $total_promotional_bonus > 0)) {
                promotionalCredit($row_parent['parent_id'],$total_promotional_bonus,$connection);
            }
        }
        

        //////////////////////// Parent Cashback End //////////////////////////////////

    	$sql = "UPDATE `orders` SET `status`='2' WHERE `id`='$order_id'";
    	if ($res = $connection->query($sql)) {
    		header("location:../../order_list.php?msg=1&s_date=$s_date&e_date=$e_date");
         	die();
    	}else{
    		header("location:../../order_list.php?msg=2&s_date=$s_date&e_date=$e_date");
         die();
    	}

	}else{
		header("location:../../order_list.php?msg=2&s_date=$s_date&e_date=$e_date");
         die();
	}

function mysql_entities_fix_string($string){return htmlentities(mysql_fix_string($string));}
function mysql_fix_string($string){
    if (get_magic_quotes_gpc()) 
        $string = stripslashes($string);
    return $string;
}

function cashbackCredit($user_id,$amount,$connection){
	
    date_default_timezone_set('Asia/Kolkata');
    $date = date('Y-m-d');
    $time = date('H:i:s');

    $wallet_amount_sql = "SELECT * FROM `wallet` WHERE `user_id`='$user_id'";
    if ($res_wallet_amount = $connection->query($wallet_amount_sql)) {
        if ($res_wallet_amount->num_rows > 0) {
            $wallet_amount_row = $res_wallet_amount->fetch_assoc();
            $wallet_amount = $wallet_amount_row['current_cashback_amount']+$amount;
            $wallet_total_amount = floatval($wallet_amount) + floatval($wallet_amount_row['total_amount']);

            $sql_update_wallet = "UPDATE `wallet` SET `current_cashback_amount`='$wallet_amount',`total_amount`='$wallet_total_amount' WHERE `user_id` = '$user_id'";
            if ($res_wallet_update = $connection->query($sql_update_wallet)) {
                $sql_wallet_history = "INSERT INTO `wallet_history`(`id`, `user_id`,`wallet_id`, `transaction_type`, `amount`,`total`, `comments`, `date`, `time`) VALUES (null,'$user_id','$wallet_amount_row[id]','2','$amount','$wallet_total_amount','Product Purchased Cashback Credited','$date','$time')";
                if ($res_wallet_history = $connection->query($sql_wallet_history)) {}
            }
        }
    }
    return true;
}

function promotionalCredit($user_id,$amount,$connection){
    date_default_timezone_set('Asia/Kolkata');
    $date = date('Y-m-d');
    $time = date('H:i:s');

    $wallet_amount_sql = "SELECT * FROM `wallet` WHERE `user_id`='$user_id'";
    if ($res_wallet_amount = $connection->query($wallet_amount_sql)) {
        if ($res_wallet_amount->num_rows > 0) {
            $wallet_amount_row = $res_wallet_amount->fetch_assoc();
            $wallet_amount = $wallet_amount_row['amount']+$amount;
            $sql_update_wallet = "UPDATE `wallet` SET `amount`='$wallet_amount' WHERE `user_id` = '$user_id'";
            if ($res_wallet_update = $connection->query($sql_update_wallet)) {
                $sql_wallet_history = "INSERT INTO `wallet_history`(`id`, `user_id`,`wallet_id`, `transaction_type`, `amount`,`total`, `comments`, `date`, `time`) VALUES (null,'$user_id','$wallet_amount_row[id]','2','$amount','$wallet_amount','Promotional Bonus Credited Against Your Downline Purchase','$date','$time')";
                if ($res_wallet_history = $connection->query($sql_wallet_history)) {}
            }
        }
    }

    return true;
 }
?>