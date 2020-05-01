<?php
include "../admin_login_system/php_user_session_check.php";
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

            $sql = "SELECT `product`.`cash_back` AS p_cash_back,`product`.`sgst` AS p_sgst,`product`.`cgst` AS p_cgst,`product`.`cost` AS p_cost,`product`.`hsn_code` AS hsn_code,`product`.`name` AS p_name, `category`.`name` AS c_name, `order_details`.`p_id` as `p_id`,SUM(`order_details`.`quantity`) as quantity,SUM(`order_details`.`total_amount`) as total_amount FROM `order_details` INNER JOIN `product` ON `product`.`id`=`order_details`.`p_id` INNER JOIN `category` ON `category`.`id`=`product`.`category_id` WHERE `order_details`.`date` BETWEEN '$s_date' AND '$e_date' AND `order_details`.`time` BETWEEN '$s_time_24' AND '$e_time_24' GROUP BY `order_details`.`p_id` ORDER BY quantity DESC";
            //echo $sql;
            if ($res = $connection->query($sql)) {
                
            }else{
              echo "2";
            }

        }elseif (!empty($s_time) && !empty($e_time) && empty($s_date)) {
            $s_time_24  = date("H:i:s", strtotime($s_time));
            $e_time_24  = date("H:i:s", strtotime($e_time));
            $s_date = date('Y-m-d');
            $e_date = date('Y-m-d');

            $sql = "SELECT `product`.`cash_back` AS p_cash_back,`product`.`sgst` AS p_sgst,`product`.`cgst` AS p_cgst,`product`.`cost` AS p_cost,`product`.`hsn_code` AS hsn_code,`product`.`name` AS p_name, `category`.`name` AS c_name, `order_details`.`p_id` as `p_id`,SUM(`order_details`.`quantity`) as quantity,SUM(`order_details`.`total_amount`) as total_amount FROM `order_details` INNER JOIN `product` ON `product`.`id`=`order_details`.`p_id` INNER JOIN `category` ON `category`.`id`=`product`.`category_id` WHERE `order_details`.`date` BETWEEN '$s_date' AND '$e_date' AND `order_details`.`time` BETWEEN '$s_time_24' AND '$e_time_24' GROUP BY `order_details`.`p_id` ORDER BY quantity DESC";
            //echo $sql;
            if ($res = $connection->query($sql)) {
                
            }else{
              echo "2";
            }
        }elseif ((!empty($s_date) && !empty($e_date)) && !empty($s_time) && !empty($e_time)) {
          $s_time_24  = date("H:i:s", strtotime($s_time));
          $e_time_24  = date("H:i:s", strtotime($e_time));

          $sql = "SELECT `product`.`cash_back` AS p_cash_back,`product`.`sgst` AS p_sgst,`product`.`cgst` AS p_cgst,`product`.`cost` AS p_cost,`product`.`hsn_code` AS hsn_code,`product`.`name` AS p_name, `category`.`name` AS c_name, `order_details`.`p_id` as `p_id`,SUM(`order_details`.`quantity`) as quantity,SUM(`order_details`.`total_amount`) as total_amount FROM `order_details` INNER JOIN `product` ON `product`.`id`=`order_details`.`p_id` INNER JOIN `category` ON `category`.`id`=`product`.`category_id` WHERE `order_details`.`date` BETWEEN '$s_date' AND '$e_date' AND `order_details`.`time` BETWEEN '$s_time_24' AND '$e_time_24' GROUP BY `order_details`.`p_id` ORDER BY quantity DESC";
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
              $html = $html."<tr>
                      <td>$count</td>
                      <td>$row[p_id]</td>
                      <td>$row[c_name]</td>
                      <td>$row[p_name]</td> 
                      <td>$row[hsn_code]</td>
                      <td>".$row['quantity']*$row['p_cost']."</td>
                      <td>".$row['quantity']*$row['p_cgst']."</td>
                      <td>".$row['quantity']*$row['p_sgst']."</td>
                      <td>".$row['quantity']*$row['p_cash_back']."</td>
                      <td>$row[quantity]</td>                        
                      <td>".$row['total_amount']."</td>
                      </tr>";
                      $count++;
              }
              $html = $html.'<td align="center" colspan="11">
                    <button class="btn btn-info" onclick="printDiv()">Print</button>
                  </td>';
          }else{
              $html = $html."<tr><td colspan='11' align='center'>No Orders Found</td></tr>";
          }
        }else{
              $html = $html."<tr><td colspan='11' align='center'>No Orders Found</td></tr>";
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