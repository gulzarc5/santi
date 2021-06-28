<?php
  include "include/header.php";
  date_default_timezone_set('Asia/Kolkata');
  function showMessage($msg){
    if ($msg == 1) {
      print "<p class='alert alert-success'>Order Status Updated Successfully</p>";
    }
    if ($msg == 2) {
      print "<p class='alert alert-danger'>Something Went Wrong Please Try Again</p>";
    }
    // if ($msg == 3) {
    //   print "<p class='alert alert-danger'>Please Check Uploaded Image Size</p>";
    // }
    //  if ($msg == 4) {
    //   print "<p class='alert alert-danger'>Please Check Uploaded Image Type</p>";
    // }
    // if ($msg == 5) {
    //   print "<p class='alert alert-danger'>Package Deleted Successfully</p>";
    // }
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
              <h2>Ordered Item List<small></small></h2>
              <div class="clearfix"></div>
            
                <form class="form-horizontal form-label-left" method="post" action="php/orders/order_search.php">
                  <div class="form-group">

                    <label class="control-label col-md-3 col-sm-3 col-xs-3">Start Date</label>
                    <div class="col-md-3 col-sm-3 col-xs-3">
                      <input type="date" name="s_date" class="form-control">
                    </div>  


                    <label class="control-label col-md-1 col-sm-1 col-xs-3" for="start_time">Start Time</label>
                    <div class="input-group date col-md-3 col-sm-3 col-xs-3" id="myDatepicker3">
                      <input type="text" name="s_time" class="form-control">
                        <span class="input-group-addon">
                          <span class="glyphicon glyphicon-calendar"></span>
                        </span> 
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-3">End Date</label>
                    <div class="col-md-3 col-sm-3 col-xs-3">
                      <input type="date" name="e_date" class="form-control">
                    </div>   

                     <label class="control-label col-md-1 col-sm-1 col-xs-3" for="start_time">End Time</label>
                    <div class="input-group date col-md-3 col-sm-3 col-xs-3" id="myDatepicker4">
                      <input type="text" name="e_time" class="form-control">
                        <span class="input-group-addon">
                          <span class="glyphicon glyphicon-calendar"></span>
                        </span> 
                    </div>          
                  </div>

                  <center><a class="btn btn-success" name="search" id="serach_id">Search</a>
                  <a class="btn btn-info"  id="export_excel">Export Excel</a></center>
                </form>
              </div>
            

            <div class="x_content table-responsive" id="printable">
              <div id="headlinetab">
                
              </div>
            <table class="table table-striped jambo_table bulk_action" cellspacing="0" width="100%">
              <thead>
                <tr>
                  <th>Sl</th>
                  <th>Product Id</th>
                  <th>Product Category</th>
                  <th>Product Name</th>
                  <th>HSN/SAC</th>
                  <th>Purchase Cost</th>
                  <th>CGST</th>
                  <th>SGST</th>
                  <th>Cashback</th>
                  <th>Sale Quantity</th>
                  <th>Total Amount</th>
                </tr>
              </thead>
                      
              <tbody id="mainTable">
                <?php
               
                  $s_time_24  = "00:00:00";
                  $e_time_24  = "23:59:59";
                  $s_date = date('Y-m-d');
                  $e_date = date('Y-m-d');
                  $sql_user_order = "SELECT `product`.`cash_back` AS p_cash_back,`product`.`sgst` AS p_sgst,`product`.`cgst` AS p_cgst,`product`.`cost` AS p_cost,`product`.`hsn_code` AS hsn_code,`product`.`name` AS p_name, `category`.`name` AS c_name, `order_details`.`p_id` as `p_id`,SUM(`order_details`.`quantity`) as quantity,SUM(`order_details`.`total_amount`) as total_amount FROM `order_details` INNER JOIN `product` ON `product`.`id`=`order_details`.`p_id` INNER JOIN `category` ON `category`.`id`=`product`.`category_id` WHERE `order_details`.`date` BETWEEN '$s_date' AND '$e_date' AND `order_details`.`time` BETWEEN '$s_time_24' AND '$e_time_24' GROUP BY `order_details`.`p_id` ORDER BY quantity DESC";

                  // if (isset($_GET['s_date']) && isset($_GET['e_date']) && empty($_GET['s_time'])) {
                  //   # code...
                  // }elseif (isset($_GET['s_time']) && isset($_GET['e_time']) && empty($_GET['s_date'])) {
                  //   # code...
                  // }elseif (isset($_GET['s_time']) && isset($_GET['e_time']) && !empty($_GET['s_date']) && !empty($_GET['e_date'])) {
                  //   # code...
                  // }
                  if ($res_user_order = $connection->query($sql_user_order)) {

                    if ($res_user_order->num_rows > 0) {
                      $count = 1;
                      while($user_order_row = $res_user_order->fetch_assoc()){
                      
                        print "<tr>
                        <td>$count</td>
                        <td>$user_order_row[p_id]</td>
                        <td>$user_order_row[c_name]</td>
                        <td>$user_order_row[p_name]</td>
                        <td>$user_order_row[hsn_code]</td>
                        <td>".$user_order_row['quantity']*$user_order_row['p_cost']."</td>
                        <td>".$user_order_row['quantity']*$user_order_row['p_cgst']."</td>
                        <td>".$user_order_row['quantity']*$user_order_row['p_sgst']."</td>
                        <td>".$user_order_row['quantity']*$user_order_row['p_cash_back']."</td>
                        <td>$user_order_row[quantity]</td>                        
                        <td>".$user_order_row['total_amount']."</td>
                        </tr>";
                        $count++;
                      }
                      print '<tr>
                              <td align="center" colspan="11">
                                <button class="btn btn-info" onclick="printDiv()">Print</button>
                              </td>
                            </tr>';
                    }else{
                      print '<tr>
                              <td align="center" colspan="11">
                                No Orders Found
                              </td>
                            </tr>';
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
  $(document).ready(function(){
    $("#serach_id").click(function(){
      var s_date = $('input[name="s_date"]').val();
      var e_date = $('input[name="e_date"]').val();
      var s_time = $('input[name="s_time"]').val();
      var e_time = $('input[name="e_time"]').val();
      
       $.ajax({
        type: "POST",
        url: "php/ajax/order_item_search.php",
        data:{
            s_date : s_date,
            e_date : e_date,
            s_time : s_time,
            e_time : e_time,
            search : true,
        },
         beforeSend: function() {
             $("#mainTable").html("<tr><td colspan='10' align='center'><img src='uploads/loading.gif' align='center' height='150'/></td></tr>");
        },
        success: function(data){
          //console.log(data);
          if (data == 2) {
             $("#error").html('<p class = "alert alert-danger">Something Error Occured Please Reload And Try Again</p>');
          }else{
             $("#mainTable").html(data);
          }
        }
      });
    
    });
  });
</script>


<!-- for excel export -->

<script type="text/javascript">
  $(document).ready(function(){
    $("#export_excel").click(function(){
      var s_date = $('input[name="s_date"]').val();
      var e_date = $('input[name="e_date"]').val();
      var s_time = $('input[name="s_time"]').val();
      var e_time = $('input[name="e_time"]').val();
      window.location.href = "php/export/excel_order_item_list.php?s_date="+s_date+"&e_date="+e_date+"&s_time="+s_time+"&e_time="+e_time+"";
    });
  });
</script>

<script type="text/javascript">
 function printDiv() {
     var printContents = document.getElementById("printable").innerHTML;
     var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;
     document.getElementById("headlinetab").innerHTML = "<h1><center>Ordered Item List</center></h1>";

     

     window.print();

     
     document.getElementById("headlinetab").innerHTML ="";
     document.body.innerHTML = originalContents;
  }
</script>