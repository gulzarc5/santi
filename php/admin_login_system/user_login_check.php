<?php
session_start();
include "../database/connection.php";

if(isset($_POST['email']) && !empty($_POST['email']) && !empty($_POST['password'])){
	$email = $connection->real_escape_string(mysql_entities_fix_string($_POST['email']));
    $password = $connection->real_escape_string(mysql_entities_fix_string($_POST['password']));
    // $password = password_hash($password, PASSWORD_BCRYPT);
    // echo $password;
    // die();
    $sql ="SELECT * FROM `users` WHERE `email` = '$email' AND `user_type` ='1'";
    if ($result=$connection->query($sql)){
        if($result->num_rows > 0) {
        	$user=$result->fetch_assoc();
            if (password_verify($password,$user['password'])) {
                $_SESSION['admin_user_id'] = $user['id'];
                $_SESSION['email'] = $email;
                $_SESSION['user_type'] = 1;

                if (!empty($_POST['page'])) {
                    header("location:../../deshboard.php");
                }else{
                    header("location:../../deshboard.php");
                }
                
	        }else{
	        	 header("location:../../index.php?msg=3");
	        }
	    }else{
    		header("location:../../index.php?msg=2");
    	}
	}else{
		header("location:../../index.php?msg=4");
	}
}




function mysql_entities_fix_string($string){return htmlentities(mysql_fix_string($string));}
function mysql_fix_string($string){
    if (get_magic_quotes_gpc()) 
        $string = stripslashes($string);
    return $string;
}
?>