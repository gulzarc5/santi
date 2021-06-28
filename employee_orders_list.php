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
              <h2>Employee Orders<small></small></h2>
              <div class="clearfix"></div>
            
                <form class="form-horizontal form-label-left" method="post" >
                  <div class="form-group"> 
                    <label class="control-label col-md-4 col-sm-4 col-xs-3">Select Employee</label>
                    <div class="col-md-5 col-sm-5 col-xs-5">
                        <select name="employee_id" id="employee_id" class="form-control" required>
                            <option value="">Please Select Employee</option>
                            <?php
                                $sql_employee = "SELECT `id`,`name` FROM `users` WHERE `user_type` = 3";
                                if ($res_employee = $connection->query($sql_employee)) {
                                    while ($employee = $res_employee->fetch_assoc()){
                                        print "<option value='$employee[id]'>$employee[name]</option>";
                                    }
                                }
                            ?>
                        </select>
                    </div> 
                  </div>

                  <div class="form-group">
                    <label class="control-label col-md-4 col-sm-4 col-xs-3">Start Date</label>
                    <div class="col-md-2 col-sm-2 col-xs-3">
                      <input type="date" name="s_date" class="form-control">
                    </div>  


                    <label class="control-label col-md-1 col-sm-1 col-xs-3" for="start_time">Start Time</label>
                    <div class="input-group date col-md-2 col-sm-2 col-xs-3" id="myDatepicker3">
                      <input type="text" name="s_time" class="form-control">
                        <span class="input-group-addon">
                          <span class="glyphicon glyphicon-calendar"></span>
                        </span> 
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="control-label col-md-4 col-sm-4 col-xs-3">End Date</label>
                    <div class="col-md-2 col-sm-2 col-xs-3">
                      <input type="date" name="e_date" class="form-control">
                    </div>   

                     <label class="control-label col-md-1 col-sm-1 col-xs-3" for="start_time">End Time</label>
                    <div class="input-group date col-md-2 col-sm-2 col-xs-3" id="myDatepicker4">
                      <input type="text" name="e_time" class="form-control">
                        <span class="input-group-addon">
                          <span class="glyphicon glyphicon-calendar"></span>
                        </span> 
                    </div>          
                  </div>

                  <center>
                    <a class="btn btn-success" name="search" id="serach_id">Search</a>
                  </center>
                  
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
                  <th>Order From</th>
                  <th>Action</th>
                </tr>
              </thead>
                      
              <tbody id="mainTable">
                                    
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
      var employee_id = $('#employee_id').val();
      
       $.ajax({
        type: "POST",
        url: "php/ajax/employee/order_search.php",
        data:{
            s_date : s_date,
            e_date : e_date,
            s_time : s_time,
            e_time : e_time,
            employee_id : employee_id,
            search : true,
        },
         beforeSend: function() {
             $("#mainTable").html("<tr><td colspan='10' align='center'><img src='uploads/loading.gif' align='center' height='150'/></td></tr>");
        },
        success: function(data){
          console.log(data);
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

<script type="text/javascript">
  $(document).ready(function(){
    $("#export_excel").click(function(){
      var s_date = $('input[name="s_date"]').val();
      var e_date = $('input[name="e_date"]').val();
      var s_time = $('input[name="s_time"]').val();
      var e_time = $('input[name="e_time"]').val();
      window.location.href = "php/export/excel_orders_list.php?s_date="+s_date+"&e_date="+e_date+"&s_time="+s_time+"&e_time="+e_time+"";
    });
  });
</script>