<?php
include "../admin_login_system/php_user_session_check.php";
include "../database/connection.php";
date_default_timezone_set('Asia/Kolkata');

if (isset($_POST['bar_code']) && !empty($_POST['bar_code'])) {

	if (!isset($_SESSION['invoice_user'])) {
		$_SESSION['invoice_user'] = $_POST['user_data'];
	}else{
		if (empty($_SESSION['invoice_user'])) {
			$_SESSION['invoice_user'] = $_POST['user_data'];
		}
	}
	
	$bar_code = $connection->real_escape_string(mysql_entities_fix_string($_POST['bar_code']));
	$quantity = $connection->real_escape_string(mysql_entities_fix_string($_POST['quantity']));
	$date = date('Y-m-d');
	$numlength = strlen((string)$bar_code);
    if($numlength > 12){
        $bar_code = substr($bar_code, 0, 12);
    }
	$check_product_sql = "SELECT * FROM `product` WHERE LEFT(`barcode`,12)='$bar_code'";

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

	$employee_id = $_SESSION['admin_user_id'];

	$check_temp_product_sql = "SELECT * FROM `temp_invoice` WHERE LEFT(`bar_code`,12)='$bar_code' WHERE `employee_id`= '$employee_id'";
	if ($res_temp_check_product = $connection->query($check_temp_product_sql)) {
		if ($res_temp_check_product->num_rows > 0) {
			header("location:../../make_invoice_form.php?msg=5");
			die();
		}
	}


	$sql = "INSERT INTO `temp_invoice`(`id`,`employee_id`, `bar_code`,`p_id`,`quantity`, `date`) VALUES (null,'$employee_id','$bar_code','$row_product_check[id]','$quantity','$date')";
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

?>