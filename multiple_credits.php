<?php

include "php/database/connection.php";
$user_ids = "SELECT `id` FROM `users`";

if ($res_ids = $connection->query($user_ids)) {
    date_default_timezone_set('Asia/Kolkata');
    $date = date('Y-m-d');
    while ($row_user_ids = $res_ids->fetch_assoc()){
    $credit_sql = "INSERT INTO `user_credit` (`id`,`user_id`,`amount`,`date`) VALUES(null,'$row_user_ids[id]','0','$date')";
    
    if ($res_credits= $connection->query($credit_sql)) {

    }
}
    
}

?>