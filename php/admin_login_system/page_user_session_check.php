<?php
session_start();

if (empty($_SESSION['admin_user_id']) || empty($_SESSION['email']) || empty($_SESSION['user_type'])) {
	header("location:index.php");
}

// if (!empty($_SESSION['admin_user_id']) || !empty($_SESSION['email']) || !empty($_SESSION['user_type'])) {
// // 	if ($_SESSION['admin_user_id'] != 1 || $_SESSION['user_type'] != 1) {
// // 		header("location:index.php");
// // 	}
	
// }