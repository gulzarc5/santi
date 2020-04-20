<?php
  include "include/header.php";
  function showMessage($msg){
    if ($msg == 1) {
      print "<p class='alert alert-success'>Order Status Updated Successfully</p>";
    }
    if ($msg == 2) {
      print "<p class='alert alert-danger'>Something Went Wrong Please Try Again</p>";
    }
  }
?>      

<div class="right_col" role="main">
  <div class="clearfix"></div>
    <div class="row">    

      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="x_panel">
            <?php
                if (isset($_GET['msg'])) {
                  showMessage($_GET['msg']);
                }
            ?>
            <div class="x_title">
              <h2>Sales Report<small></small></h2>
              <div class="clearfix"></div>
            
                <form class="form-horizontal form-label-left" method="post" >
                  <div class="form-group">

                    <label class="control-label col-md-4 col-sm-4 col-xs-3">Start Date</label>
                    <div class="col-md-2 col-sm-2 col-xs-3">
                      <input type="date" name="s_date" class="form-control">
                    </div>  


                    <label class="control-label col-md-1 col-sm-1 col-xs-3">End Date</label>
                    <div class="input-group date col-md-2 col-sm-2 col-xs-3">
                      <input type="date" name="e_date" class="form-control">
                    </div>  
                  </div>

                  <center><a class="btn btn-success" name="search" id="serach_id">Search</a></center>
                </form>
              </div>
            

            <div class="x_content table-responsive">

            <table class="table table-striped jambo_table bulk_action" cellspacing="0" width="100%">
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
                  <th>Status</th>
                  <th>Action</th>
                </tr>
              </thead>
                      
              <tbody id="mainTable">
                <?php             

                  if (isset($_GET['s_date']) && isset($_GET['e_date']) && !empty($_GET['s_date']) && !empty($_GET['e_date'])) {
                    $s_date = $connection->real_escape_string(mysql_entities_fix_string($_GET['s_date']));          
                    $e_date = $connection->real_escape_string(mysql_entities_fix_string($_GET['e_date']));
                    $sql_user_order = "SELECT * FROM `orders` WHERE `date` BETWEEN '$s_date' AND '$e_date' ORDER BY `id` DESC";
                    if ($res_user_order = $connection->query($sql_user_order)) {
                      $count = 1;
                      while($user_order_row = $res_user_order->fetch_assoc()){
                        $amount = number_format($user_order_row['amount'],2);
                        $wallet_pay = number_format($user_order_row['wallet_pay'],2);
                        $payable_amount = number_format($user_order_row['total'],2);
                        if ($user_order_row['status'] == 1) {
                          $status = '<p class="btn btn-danger disabled">Pending</p>';
                        }else{
                          $status = '<p class="btn btn-success disabled">Delivered</p>';
                        }
                        $time_format = date("g:i a", strtotime($user_order_row['time']));
                        print "<tr>
                        <td>$count</td>
                        <td>$user_order_row[id]</td>
                        <td>$user_order_row[user_id]</td>
                        <td>$amount</td>
                        <td>$wallet_pay</td>
                        <td>$payable_amount</td>
                        <td>$user_order_row[date]</td>
                        <td>$time_format</td>
                        <td>$status</td><td>";
                        print "<a class='btn btn-success' href='view_orders.php?id=$user_order_row[id]&s_date=$s_date&e_date=$e_date''>View</a>";

                        if ($user_order_row['status'] == 1) {
                          print "<a class='btn btn-success' href='php/orders/order_status_update.php?id=$user_order_row[id]&s_date=$s_date&e_date=$e_date'>Delivered</a></td>";
                        }else{
                           print "<!--<a class='btn btn-success' href='order_status_update.php?id=$user_order_row[id]&s_date=$s_date&e_date=$e_date'>Pending</a>--!>";
                        }
                        
                        "</td></tr>";
                        $count++;
                      }
                    }
                  }else{
                    $s_date = date('Y-m-d');
                    $e_date = date('Y-m-d');

                    $sql_user_order = "SELECT * FROM `orders` WHERE `date` BETWEEN '$s_date' AND '$e_date' ORDER BY `id` DESC";
                    if ($res_user_order = $connection->query($sql_user_order)) {
                      $count = 1;
                      while($user_order_row = $res_user_order->fetch_assoc()){
                        $amount = number_format($user_order_row['amount'],2);
                        $wallet_pay = number_format($user_order_row['wallet_pay'],2);
                        $payable_amount = number_format($user_order_row['total'],2);
                        if ($user_order_row['status'] == 1) {
                          $status = '<p class="btn btn-danger disabled">Pending</p>';
                        }else{
                          $status = '<p class="btn btn-success disabled">Delivered</p>';
                        }
                        $time_format = date("g:i a", strtotime($user_order_row['time']));
                        print "<tr>
                        <td>$count</td>
                        <td>$user_order_row[id]</td>
                        <td>$user_order_row[user_id]</td>
                        <td>$amount</td>
                        <td>$wallet_pay</td>
                        <td>$payable_amount</td>
                        <td>$user_order_row[date]</td>
                        <td>$time_format</td>
                        <td>$status</td><td>";
                        print "<a class='btn btn-success' href='view_orders.php?id=$user_order_row[id]'>View</a>";

                        if ($user_order_row['status'] == 1) {
                          print "<a class='btn btn-success' href='php/orders/order_status_update.php?id=$user_order_row[id]'>Delivered</a></td>";
                        }else{
                           print "<!--<a class='btn btn-success' href='order_status_update.php?id=$user_order_row[id]'>Pending</a>--!>";
                        }
                        
                        "</td></tr>";
                        $count++;
                      }
                    }
                  }
                ?>                        
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php
include "include/footer.php";
?>
<script src="vendors/moment/min/moment.min.js"></script>
<script src="vendors/bootstrap-daterangepicker/daterangepicker.js"></script>
    <!-- bootstrap-datetimepicker -->    
<script src="vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
<script>
    $('#myDatepicker').datetimepicker();
    

    $('#myDatepicker3').datetimepicker({
        format: 'hh:mm A'
    });
    $('#myDatepicker4').datetimepicker({
        format: 'hh:mm A'
    }); 
   
</script>

<script type="text/javascript">
  // $(document).ready(function(){
  //   $("#serach_id").click(function(){
  //     var s_date = $('input[name="s_date"]').val();
  //     var e_date = $('input[name="e_date"]').val();
  //     var s_time = $('input[name="s_time"]').val();
  //     var e_time = $('input[name="e_time"]').val();
      
  //      $.ajax({
  //       type: "POST",
  //       url: "php/ajax/order_search.php",
  //       data:{
  //           s_date : s_date,
  //           e_date : e_date,
  //           s_time : s_time,
  //           e_time : e_time,
  //           search : true,
  //       },
  //        beforeSend: function() {
  //            $("#mainTable").html("<tr><td colspan='10' align='center'><img src='uploads/loading.gif' align='center' height='150'/></td></tr>");
  //       },
  //       success: function(data){
  //         console.log(data);
  //         if (data == 2) {
  //            $("#error").html('<p class = "alert alert-danger">Something Error Occured Please Reload And Try Again</p>');
  //         }else{
  //            $("#mainTable").html(data);
  //         }
  //       }
  //     });
    
  //   });
  // });
</script>