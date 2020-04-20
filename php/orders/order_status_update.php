<?php
    include "../admin_login_system/php_user_session_check.php";
	include "../database/connection.php";

	if (isset($_GET['id'])) {
    	$order_id = $connection->real_escape_string(mysql_entities_fix_string($_GET['id']));
        $s_date = $connection->real_escape_string(mysql_entities_fix_string($_GET['s_date']));
        $e_date = $connection->real_escape_string(mysql_entities_fix_string($_GET['e_date'])); 
        date_default_timezone_set('Asia/Kolkata');
        $date = date('Y-m-d');
        $time = date('H:i:s');

        
        /////////////////////////////////////////////////////////////////////////////
        //Parent Cashback
        $sql_user = "SELECT * FROM `orders` WHERE `id`='$order_id'";
        if ($res_user = $connection->query($sql_user)) {
            $row_user = $res_user->fetch_assoc();

            if ($row_user['discountable_amount'] > 0) {
               $parent_sql = "SELECT `parent_id` FROM `users` WHERE `parent_id` != 'NULL' AND `id`='$row_user[user_id]'";
                if ($res_parent = $connection->query($parent_sql)) {
                    if ($res_parent->num_rows > 0) {
                        $row_parent = $res_parent->fetch_assoc();

                        $sql_parent_cashback = "SELECT `percentage` FROM `offer` WHERE `offer_type`='2' ORDER BY `id` DESC LIMIT 1";
                        if ($res_parent_cashback = $connection->query($sql_parent_cashback)) {
                            $row_parent_cashback = $res_parent_cashback->fetch_assoc();
                            $cashback = (floatval($row_user['discountable_amount']) * floatval($row_parent_cashback['percentage']) ) / 100;

                            $sql_parent_wallet = "SELECT * FROM `wallet` WHERE `user_id`='$row_parent[parent_id]' LIMIT 1";
                            if ($res_parent_wallet = $connection->query($sql_parent_wallet)) {
                                $row_parent_wallet = $res_parent_wallet->fetch_assoc();

                                $parent_wallet = floatval($row_parent_wallet['amount']) + $cashback;

                                $update_parent_wallet = "UPDATE `wallet` SET `amount`='$parent_wallet' WHERE `user_id`='$row_parent[parent_id]'";

                                if ($connection->query($update_parent_wallet)) {
                                    $sql_wallet_history = "INSERT INTO `wallet_history`(`id`, `user_id`,`wallet_id`, `transaction_type`, `amount`,`total`, `comments`, `date`, `time`) VALUES (null,'$row_parent[parent_id]','$row_parent_wallet[id]','2','$cashback','$parent_wallet','Cashback Credited Against Your Downline Purchase','$date','$time')";
                                    if ($res_wallet_history = $connection->query($sql_wallet_history)) {}
                                }

                            }
                        }
                    }
                }
            }           
        }


        /// Product Purchase Cash Back Credit To User Walle

        $order_detail_sql = "SELECT `order_details`.`user_id` AS u_id, `order_details`.`id` AS order_detail_id,`order_details`.`p_id` AS p_id,`product`.`cash_back` AS cash_back,`product`.`name` AS p_name,`wallet`.`id` AS wallet_id, `wallet`.`amount` AS wallet_amount FROM `order_details` LEFT JOIN `product` ON `product`.`id` = `order_details`.`p_id` LEFT JOIN `wallet` ON `wallet`.`user_id`=`order_details`.`user_id` WHERE `order_details`.`order_id`='$order_id'";
        if ($res_order_detail = $connection->query($order_detail_sql)) {
            while ($row_order_detail = $res_order_detail->fetch_assoc()) {

                if (isset($row_order_detail['cash_back']) && ($row_order_detail['cash_back'] > 0)) {
                    $update_wallet = "UPDATE `wallet` SET `amount`=(`amount`+'$row_order_detail[cash_back]') WHERE `id`='$row_order_detail[wallet_id]'";
                    $amount = $row_order_detail['wallet_amount'] + $row_order_detail['cash_back'];

                    if ($connection->query($update_wallet)) {
                        $sql_wallet_history = "INSERT INTO `wallet_history`(`id`, `user_id`,`wallet_id`, `transaction_type`, `amount`,`total`, `comments`, `date`, `time`) VALUES (null,'$row_order_detail[u_id]','$row_order_detail[wallet_id]','2','$row_order_detail[cash_back]','$amount','Cashback Credited Against Your Purchase of $row_order_detail[p_name]','$date','$time')";
                        if ($res_wallet_history = $connection->query($sql_wallet_history)) {}
                    }
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
?>