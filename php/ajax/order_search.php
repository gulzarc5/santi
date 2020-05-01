<?php
// include "../admin_login_system/php_user_session_check.php";
include "../database/connection.php";
date_default_timezone_set('Asia/Kolkata');

	if (isset($_POST['search'])) {
        $s_date = $connection->real_escape_string(mysql_entities_fix_string($_POST['s_date']));
        $e_date = $connection->real_escape_string(mysql_entities_fix_string($_POST['e_date']));

        $s_time = $connection->real_escape_string(mysql_entities_fix_string($_POST['s_time']));
        $e_time = $connection->real_escape_string(mysql_entities_fix_string($_POST['e_time']));
        $res = null;
        if (!empty($s_date) && !empty($e_date) && empty($s_time)) {
          $s_time_24  = "00:00:00";
          $e_time_24  = "23:59:59";
          $sql = "SELECT * FROM `orders` WHERE (`date` BETWEEN '$s_date' AND '$e_date' ) AND (`time` BETWEEN '$s_time_24' AND '$e_time_24') ORDER BY `id` DESC";
           if ($res = $connection->query($sql)) {
                
            }else{
              echo "2";
            }

        }elseif (!empty($s_time) && !empty($e_time) && empty($s_date)) {
            $s_time_24  = date("H:i:s", strtotime($s_time));
            $e_time_24  = date("H:i:s", strtotime($e_time));
            $s_date = date('Y-m-d');
            $e_date = date('Y-m-d');

            $sql = "SELECT * FROM `orders` WHERE (`date` BETWEEN '$s_date' AND '$e_date' ) AND (`time` BETWEEN '$s_time_24' AND '$e_time_24') ORDER BY `id` DESC";
            // echo $sql;
            if ($res = $connection->query($sql)) {
               echo $res->num_rows;
            }else{
              echo "2";
            }
        }elseif ((!empty($s_date) && !empty($e_date)) && !empty($s_time) && !empty($e_time)) {
          $s_time_24  = date("H:i:s", strtotime($s_time));
          $e_time_24  = date("H:i:s", strtotime($e_time));

          $sql = "SELECT * FROM `orders` WHERE (`date` BETWEEN '$s_date' AND '$e_date' ) AND (`time` BETWEEN '$s_time_24' AND '$e_time_24') ORDER BY `id` DESC";
           if ($res = $connection->query($sql)) {
                
            }else{
              echo "2";
            }
        }
        $html = null;
        $count = 1;
        if (!empty($res)) {
          if ($res->num_rows > 0) {
             while ($row = $res->fetch_assoc()) {
              $action = null;
              $amount = number_format($row['amount'],2);
              $wallet_pay = number_format($row['wallet_pay'],2);
              $payable_amount = number_format($row['total'],2);
              $time_format = date("g:i a", strtotime($row['time']));
              if ($row['status'] == 1) {
                  $status = '<p class="btn btn-danger disabled">Pending</p>';
              }else{
                  $status = '<p class="btn btn-success disabled">Delivered</p>';
              }

             $action = "<a class='btn btn-success' href='view_orders.php?id=$row[id]&s_date=$s_date&e_date=$e_date'>View</a>";
            if ($row['status'] == 1) {
              $action = $action."<a class='btn btn-success' href='php/orders/order_status_update.php?id=$row[id]&s_date=$s_date&e_date=$e_date'>Delivered</a></td>";
            }else{
               $action = $action."<!--<a class='btn btn-success' href='order_status_update.php?id=$row[id]'>Pending</a>--!>";
            }

            if ($row['order_from'] == 2) {
              $orderFrom = '<p">Offline</p">';
            }else{
              $orderFrom = '<p">App</p">';
            }

              $html = $html."<tr>
                        <td>$count</td>
                        <td>$row[id]</td>
                        <td>$row[user_id]</td>
                        <td>$amount</td>
                        <td>$wallet_pay</td>
                        <td>$payable_amount</td>
                        <td>$row[date]</td>
                        <td>$time_format</td>
                        <td>$status</td>
                        <td>$orderFrom</td>
                        <td>$action</td></tr>";
              $count++;
            }
          }else{
              $html = $html."<tr><td>No Orders Found</td></tr>";
          }
        }else{
              $html = $html."<tr><td>No Orders Found</td></tr>";
          }
        
        echo $html;
	}else{
		echo 2;
	}

function mysql_entities_fix_string($string){return htmlentities(mysql_fix_string($string));}
function mysql_fix_string($string){
    if (get_magic_quotes_gpc()) 
        $string = stripslashes($string);
    return $string;
}
?>