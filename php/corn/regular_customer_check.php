<?php
include "../admin_login_system/php_user_session_check.php";
include "../database/connection.php";

if(checkCorn($connection) == 0){
    runCorn($connection);
    makeCustomerNormal($connection);
    $sql_users = "SELECT * FROM `users` WHERE `user_type`=2 AND `status`=1";
    if ($res_users = $connection->query($sql_users)) {

        if ($res_users->num_rows > 0) {
        
            while ($row_user = $res_users->fetch_assoc()) {
                $order_count = getUserOrderCount($connection,$row_user['id']);
                userOrderUpdate($connection,$row_user['id'],$order_count);
                if ($order_count >= 50) {
                    makeRegularCustomer($connection,$row_user['id']);
                }           
            }
        }

    }
    print "<h1 style='text-align:center'>Regular Customer Checked Successfully</h1>";
}else{
    print "<h1 style='text-align:center'>Sorry This Month Checking already Completed</h1>";
}

function getUserOrderCount($connection,$user_id)
{
    date_default_timezone_set('Asia/Kolkata');
 	$date = date('m')-1;
    $order_count = 0;
    $orders_sql = "SELECT COUNT(DISTINCT(order_details.p_id)) as order_count FROM `order_details` LEFT JOIN `orders` ON `orders`.`id` = `order_details`.`order_id` WHERE month(orders.date)=$date AND orders.user_id=$user_id";
    if ($res_count = $connection->query($orders_sql)) {
        $row_count = $res_count->fetch_assoc();
        $order_count = $row_count['order_count'];
    }
    return $order_count;
}

function makeRegularCustomer($connection,$user_id)
{
    $sql = "UPDATE `users` SET `is_regular`=2 WHERE `id`=$user_id";
    $connection->query($sql);
}
function makeCustomerNormal($connection)
{
    $sql = "UPDATE `users` SET `is_regular`=1 WHERE `user_type`=2";
    $connection->query($sql);
}

function runCorn($connection)
{
    date_default_timezone_set('Asia/Kolkata');
 	$month = date('m')-1;
 	$date = date('Y-m-d');

    $sql = "INSERT INTO `corn_run_entry`(`id`, `month`, `date`) VALUES (null,'$month','$date')";
    $connection->query($sql);
}

function checkCorn($connection)
{
    date_default_timezone_set('Asia/Kolkata');
 	$month = date('m')-1;

    $count = 0;

    $sql_count = "SELECT count(*) as total_count FROM `corn_run_entry` WHERE `month`= '$month'";
    if($res_count = $connection->query($sql_count)){
        $row_count = $res_count->fetch_assoc();
        $count = $row_count['total_count'];
    }
    return $count;
}

function userOrderUpdate($connection,$user,$order_count)
{
    $sql = "UPDATE `users` SET `prev_month_order_count` = '$order_count' WHERE `id`='$user'";
    $connection->query($sql);
}