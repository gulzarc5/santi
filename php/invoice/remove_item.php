<?php
include "../admin_login_system/php_user_session_check.php";
include "../database/connection.php";
if (isset($_GET['inv_id']) && !empty($_GET['inv_id'])) {
	$invoice_id = $_GET['inv_id'];
	$sql = "DELETE FROM `temp_invoice` WHERE `id` = '$invoice_id'";
	if ($res = $connection->query($sql)) {
		header("location:../../make_invoice_form.php");
	} else {
		header("location:../../make_invoice_form.php?msg=2");
	}
} else {
	header("location:../../make_invoice_form.php?msg=2");
}

?>