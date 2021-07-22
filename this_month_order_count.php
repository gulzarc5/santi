<?php
require_once "include/header.php";
?>

<div class="clearfix"></div>
<div class="right_col" role="main">

  <?php
   if (isset($_GET['u_id'])) {
    $u_id = $connection->real_escape_string(mysql_entities_fix_string($_GET['u_id']));     
    $sql_u_fetch = "SELECT * FROM `users` WHERE `id`='$u_id'";
    $res_u = $connection->query($sql_u_fetch);
    $user_row = $res_u->fetch_assoc();

    function getUserOrderCount($connection,$user_id)
    {
        date_default_timezone_set('Asia/Kolkata');
        $date = date('m');

        $order_count = 0;
        $orders_sql = "SELECT COUNT(DISTINCT(order_details.p_id)) as order_count FROM `order_details` LEFT JOIN `orders` ON `orders`.`id` = `order_details`.`order_id` WHERE month(orders.date)=$date AND orders.user_id=$user_id";
        if ($res_count = $connection->query($orders_sql)) {
            $row_count = $res_count->fetch_assoc();
            $order_count = $row_count['order_count'];
        }
        return $order_count;
    }
  ?>

  <div class="row">
        <div class="col-md-12">
            <div class="x_panel">
                <div class="x_content">
          <section class="content invoice">
                      <!-- title row -->
                        <div class="row">
                          <div class="col-xs-12 invoice-header">
                              <h1>
                                     <?=date('F')?> Order Counting Details
                                    <small class="pull-right"></small>
                                </h1>
                          </div>
                          <!-- /.col -->

                          <div class="x_content table-responsive">

                            <table class="table table-striped jambo_table bulk_action" cellspacing="0" width="100%">
                                <!-- <thead>
                                    <tr>
                                        <th></th>
                                    </tr>
                                </thead> -->
                                <tbody>
                                    <tr>
                                        <td>Name : </td>
                                        <td><?=$user_row['name']?></td>
                                    </tr>
                                    <tr>
                                        <td>Mobile : </td>
                                        <td><?=$user_row['mobile']?></td>
                                    </tr>
                                    <tr>
                                        <td>Total Ordered Product : </td>
                                        <td><?=getUserOrderCount($connection,$u_id)?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
        
                        <div class="row no-print">
                          <div class="col-xs-12">
                            <a href="user_list.php" class="btn btn-primary pull-right" style="margin-right: 5px;"><i class="fa fa-download"></i> Back</a>
                          </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
    <?php
     
   }
    ?>
</div>


<?php

require_once "include/footer.php";
?>