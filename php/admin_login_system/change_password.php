<?php
include "../admin_login_system/php_user_session_check.php";
include "../database/connection.php";

 	if(!empty($_POST['email']) && !empty($_POST['old_password']) && !empty($_POST['password']) && !empty($_POST['cnf_password']) ){
 	    $user_id = $_SESSION['admin_user_id'];
 		$email = $connection->real_escape_string(mysql_entities_fix_string($_POST['email']));
        $old_password = $connection->real_escape_string(mysql_entities_fix_string($_POST['old_password']));
        $password = $connection->real_escape_string(mysql_entities_fix_string($_POST['password']));
        $cnf_password = $connection->real_escape_string(mysql_entities_fix_string($_POST['cnf_password']));
      
        if($password != $cnf_password){
            header("location:../../change_password.php?msg=3");
            die();
        }
    	$user_sql = "SELECT * FROM `users` WHERE `id`='$user_id'";
    	if ($user_res = $connection->query($user_sql)) {
    		$user=$user_res->fetch_assoc();
            if ($user_res->num_rows > 0){
                if (password_verify($old_password,$user['password'])){

                   $password = password_hash($cnf_password, PASSWORD_BCRYPT);

                   $sql_change = "UPDATE `users` SET `password`='$password',`email`='$email' WHERE `id`='$user_id'";
                   if ($res_change = $connection->query($sql_change)) {
                       header("location:../../change_password.php?msg=1");
                        die();
                   }else{
                     header("location:../../change_password.php?msg=2");
                    die();
                   }
                    
                   
                }else{
                    header("location:../../change_password.php?msg=4");
                    die();
                }
            }else{
               	header("location:../../change_password.php?msg=2");
            }
        }else{
            	header("location:../../change_password.php?msg=2");
        }
 	}else{
 	 
 		header("location:../../change_password.php?msg=2");
 	}

function mysql_entities_fix_string($string){return htmlentities(mysql_fix_string($string));}
function mysql_fix_string($string){
    if (get_magic_quotes_gpc()) 
        $string = stripslashes($string);
    return $string;
}


	
?>