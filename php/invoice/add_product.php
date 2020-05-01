<?php
include "../admin_login_system/php_user_session_check.php";
include "../database/connection.php";
date_default_timezone_set('Asia/Kolkata');

if (isset($_POST['bar_code']) && !empty($_POST['bar_code'])) {

	if (!isset($_SESSION['invoice_user'])) {
		$_SESSION['invoice_user'] = $_POST['user_data'];
		$row_user_wallet_check = fetchUserWallet($_POST['user_data'],$connection);
		if ($row_user_wallet_check) {
			if (($row_user_wallet_check['wallet_amount'] > 0) && ($row_user_wallet_check['is_star'] == '2')) {
				if (isset($_POST['is_wallet']) && !EMPTY($_POST['is_wallet'])) {
					$_SESSION['is_wallet'] = $_POST['is_wallet'];
				}
			}
		}else {
			header("location:../../make_invoice_form.php?msg=2");
		}	
	}else{
		if (empty($_SESSION['invoice_user'])) {
			$_SESSION['invoice_user'] = $_POST['user_data'];
			$row_user_wallet_check = fetchUserWallet($_POST['user_data'],$connection);
			if ($row_user_wallet_check) {
				if (($row_user_wallet_check['wallet_amount'] > 0) && ($row_user_wallet_check['is_star'] == '2')) {
					if (isset($_POST['is_wallet']) && !EMPTY($_POST['is_wallet'])) {
						$_SESSION['is_wallet'] = $_POST['is_wallet'];
					}
				}
			}else {
				header("location:../../make_invoice_form.php?msg=2");
			}
		}else{
			$row_user_wallet_check = fetchUserWallet($_SESSION['invoice_user'],$connection);
			if ($row_user_wallet_check) {
				if (($row_user_wallet_check['wallet_amount'] > 0) && ($row_user_wallet_check['is_star'] == '2')) {
					if (isset($_POST['is_wallet']) && !EMPTY($_POST['is_wallet'])) {
						$_SESSION['is_wallet'] = $_POST['is_wallet'];
					}
				}
			}else {
				header("location:../../make_invoice_form.php?msg=2");
			}
		}
	}


	
	$bar_code = $connection->real_escape_string(mysql_entities_fix_string($_POST['bar_code']));
	$quantity = $connection->real_escape_string(mysql_entities_fix_string($_POST['quantity']));
	$date = date('Y-m-d');
	$check_product_sql = "SELECT * FROM `product` WHERE `barcode`='$bar_code'";
	if ($res_check_product = $connection->query($check_product_sql)) {
		if ($res_check_product->num_rows < 1) {
			header("location:../../make_invoice_form.php?msg=3");
			die();
		}else {
			$row_product_check = $res_check_product->fetch_assoc();
			if ($row_product_check['stock'] < 1) {
				header("location:../../make_invoice_form.php?msg=4");
				die();
			}
		}
	}

	$check_temp_product_sql = "SELECT * FROM `temp_invoice` WHERE `bar_code`='$bar_code'";
	if ($res_temp_check_product = $connection->query($check_temp_product_sql)) {
		if ($res_temp_check_product->num_rows > 0) {
			header("location:../../make_invoice_form.php?msg=5");
			die();
		}
	}


	$sql = "INSERT INTO `temp_invoice`(`id`, `bar_code`,`p_id`,`quantity`, `date`) VALUES (null,'$bar_code','$row_product_check[id]','$quantity','$date')";
	if ($res = $connection->query($sql)) {
		header("location:../../make_invoice_form.php?msg=1");
	} else {
		header("location:../../make_invoice_form.php?msg=2");
	}
	
} else {
	header("location:../../make_invoice_form.php?msg=2");
}


function mysql_entities_fix_string($string){return htmlentities(mysql_fix_string($string));}
function mysql_fix_string($string){
    if (get_magic_quotes_gpc()) 
        $string = stripslashes($string);
    return $string;
}

function fetchUserWallet($user_data,$connection)
{
	if(is_numeric($user_data)){ 
		$user_wallet_check_sql = "SELECT `wallet`.`amount` AS wallet_amount,`users`.`is_star` AS is_star FROM `users` INNER JOIN `wallet` ON `wallet`.`user_id` = `users`.`id` WHERE `users`.`mobile`='$user_data'" ;				
	}else{
		$user_wallet_check_sql = "SELECT `wallet`.`amount` AS wallet_amount,`users`.`is_star` AS is_star FROM `users` INNER JOIN `wallet` ON `wallet`.`user_id` = `users`.`id` WHERE `users`.`email`='$user_data'" ;	
	}
	
	if ($res_user_wallet_check = $connection->query($user_wallet_check_sql)) {
		$row_user_wallet_check = $res_user_wallet_check->fetch_assoc();
		return $row_user_wallet_check;			
	}else{
		return false;
	}
}

?>