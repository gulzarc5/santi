<?php
include "../admin_login_system/php_user_session_check.php";
include "../database/connection.php";

	if (isset($_SESSION['invoice_user'])) {
		unset($_SESSION['invoice_user']);
	}
	if (isset($_SESSION['is_wallet'])) {
		unset($_SESSION['is_wallet']);
	}
	$sql = "DELETE FROM `temp_invoice`";
	if ($res = $connection->query($sql)) {
		header("location:../../make_invoice_form.php");
	} else {
		header("location:../../make_invoice_form.php?msg=2");
	}

?>