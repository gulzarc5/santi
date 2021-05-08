<?php
include "include/header.php";
?>

        <!-- page content -->
        <div class="right_col" role="main">

        <?php 
        $employee_id = $_SESSION['admin_user_id'];
        $s_date = date('Y-m-d');
        $e_date = date('Y-m-d');
          if (isset($_SESSION['user_type']) && $_SESSION['user_type'] == 1) {
        ?>
          <!-- top tiles -->
          <div class="row tile_count">
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-user"></i> Total Users</span>
              <div class="count green">
                <?php
                  $t_user_c_sql ="SELECT * FROM `users` WHERE `user_type` != '1'";
                  if ($res_t_user_count = $connection->query($t_user_c_sql)) {
                   echo "$res_t_user_count->num_rows";
                  }
                ?>
              </div>
              <!-- <span class="count_bottom"><i class="green">4% </i> From last Week</span> -->
            </div>
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-clock-o"></i> Total Products </span>
              <div class="count green">
                 <?php
                  $t_user_c_sql ="SELECT * FROM `product`";
                  if ($res_t_user_count = $connection->query($t_user_c_sql)) {
                   echo "$res_t_user_count->num_rows";
                  }
                ?>
              </div>
              <!-- <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>3% </i> From last Week</span> -->
            </div>
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-user"></i> Total Category</span>
              <div class="count green">
                 <?php
                  $t_user_c_sql ="SELECT * FROM `category`";
                  if ($res_t_user_count = $connection->query($t_user_c_sql)) {
                   echo "$res_t_user_count->num_rows";
                  }
                ?>
                <!--  -->
              </div>
              <!-- <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>34% </i> From last Week</span> -->
            </div>
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-user"></i> Total Sub Category</span>
              <div class="count green">
                 <?php
                  $t_user_c_sql ="SELECT * FROM `sub_category`";
                  if ($res_t_user_count = $connection->query($t_user_c_sql)) {
                   echo "$res_t_user_count->num_rows";
                  }
                ?>
              </div>
              <!-- <span class="count_bottom"><i class="red"><i class="fa fa-sort-desc"></i>12% </i> From last Week</span> -->
            </div>
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-user"></i> Total Pending Orders</span>
              <div class="count green">
                <?php
                  $t_order_sql ="SELECT * FROM `orders` WHERE `status`='1'";
                  if ($res_order_count = $connection->query($t_order_sql)) {
                   echo "$res_order_count->num_rows";
                  }
                ?>
              </div>
              
            </div>
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-user"></i> Total Delivered Orders</span>
              <div class="count green">
                <?php
                  $t_order_sql ="SELECT * FROM `orders` WHERE `status`='2'";
                  if ($res_order_count = $connection->query($t_order_sql)) {
                   echo "$res_order_count->num_rows";
                  }
                ?>
                  
                </div>
              <!-- <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>34% </i> From last Week</span> -->
            </div>
          </div>
          <!-- /top tiles -->
        <?php }else{ ?>
           <!-- top tiles -->
          <div class="row tile_count">
            <div class="col-md-4 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-user"></i> Total Orders Today</span>
              <div class="count green">
                <?php
                  $order_count_sql ="SELECT `id`  FROM `orders` WHERE `employee_id` = '$employee_id'  AND (`date` BETWEEN '$s_date' AND '$e_date')";
                  if ($res_order_count_sql = $connection->query($order_count_sql)) {
                    echo "$res_order_count_sql->num_rows";
                  }
                ?>
              </div>
              <!-- <span class="count_bottom"><i class="green">4% </i> From last Week</span> -->
            </div>
            <div class="col-md-4 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-clock-o"></i> Total Order Amount Today </span>
              <div class="count green">
                 <?php
                  $order_amount_sql ="SELECT SUM(`amount`) as amount FROM `orders`  WHERE `employee_id` = '$employee_id'  AND (`date` BETWEEN '$s_date' AND '$e_date')";
                  if ($res_order_amount = $connection->query($order_amount_sql)) {
                    $order_amount_row = $res_order_amount->fetch_assoc();
                   echo $order_amount_row['amount'];
                  }
                ?>
              </div>
              <!-- <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>3% </i> From last Week</span> -->
            </div>
            <div class="col-md-4 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-user"></i> Total Cash Receive Today</span>
              <div class="count green">
                 <?php
                 $order_amount_sql ="SELECT SUM(`cash_payment`) as amount FROM `orders`  WHERE `employee_id` = '$employee_id'  AND (`date` BETWEEN '$s_date' AND '$e_date')";
                 if ($res_order_amount = $connection->query($order_amount_sql)) {
                   $order_amount_row = $res_order_amount->fetch_assoc();
                  echo $order_amount_row['amount'];
                 }
                ?>
                <!--  -->
              </div>
              <!-- <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>34% </i> From last Week</span> -->
            </div>

          <!-- /top tiles -->
        <? } ?>
          <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div style="color: red; font-weight: bold; font-size: 20px;">Last 10 Orders</div>
                <table class="table table-striped jambo_table bulk_action">
                  <thead>
                    <tr>
                      <th>Sl</th>
                      <th>Order Id</th>
                      <th>Customer Id</th>
                      <th>Amount</th>
                      <th>Wallet Pay</th>
                      <th>Payable Amount</th>
                      <th>Date</th>
                      <th>Time</th>
                    </tr>
                  </thead>
                  <tbody>
                       <?php
                       if (isset($_SESSION['user_type']) && $_SESSION['user_type'] == 1) {
                          $sql_user_order = "SELECT * FROM `orders` ORDER BY `id` DESC LIMIT 10";
                        }else{
                         $sql_user_order = "SELECT * FROM `orders` WHERE `employee_id` = '$employee_id' ORDER BY `id` DESC LIMIT 10";

                       }
                  if ($res_user_order = $connection->query($sql_user_order)) {
                    $count = 1;
                    while($user_order_row = $res_user_order->fetch_assoc()){
                      $amount = number_format($user_order_row['amount'],2);
                      $wallet_pay = number_format($user_order_row['wallet_pay'],2);
                      $payable_amount = number_format($user_order_row['total'],2);
                      $service_charge = number_format($user_order_row['service_charge'],2);
                      $total_payable_amount = $payable_amount+$service_charge;
                      $time_format = date("g:i a", strtotime($user_order_row['time']));
                      print "<tr>
                      <td>$count</td>
                      <td>$user_order_row[id]</td>
                      <td>$user_order_row[user_id]</td>
                      <td>$amount</td>
                      <td>$wallet_pay</td>
                      <td>$total_payable_amount</td>
                      <td>$user_order_row[date]</td>
                      <td>$time_format</td></tr>";
                      $count++;
                     
                    }
                  }
                        ?> 
                  </tbody>
                </table>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div style="color: red; font-weight: bold; font-size: 20px;">Last 10 Added Products</div>
                <table class="table table-striped jambo_table bulk_action">
                  <thead>
                    <tr>
                      <th>Sl</th>
                      <th>Id</th>
                      <th>Product Name</th>
                      <th>Product Category</th>
                      <th>Product Sub Category</th>
                    </tr>
                  </thead>
                  <tbody>
                       <?php
                            $sql_last = "SELECT `product`.`id` as p_id,`product`.`name` as name, `product`.`description` AS description,`product`.`price` as price,`product`.`stock` AS stock, `category`.`name` AS category, `sub_category`.`name` AS sub_category FROM `product` INNER JOIN `category` ON `category`.`id`=`product`.`category_id` INNER JOIN `sub_category` ON `sub_category`.`id`=`product`.`sub_cat_id` WHERE `product`.`is_delete`='1' ORDER BY `product`.`id` DESC LIMIT 10";
                            if ($res_last = $connection->query($sql_last)) {
                              $count = 1;
                              if ($res_last->num_rows > 0) {
                                
                              while($row_last = $res_last->fetch_assoc()){
                                print "<tr>";
                                print "<td>$count</td>";
                                print "<td>$row_last[p_id]</td>";
                                print "<td>$row_last[name]</td>";
                                print "<td>$row_last[category]</td>";
                                print "<td>$row_last[sub_category]</td>";
                                print "</tr>";
                                $count++;
                              }
                            }else{
                              print "<tr><td colspan='6'>No Products</td>";
                                print "</tr>";
                            }
                          }
                        ?> 
                  </tbody>
                </table>
            </div>
          </div>
          <br />

        </div>
        <!-- /page content -->

<?php
include "include/footer.php";
?>