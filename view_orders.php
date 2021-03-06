<?php
  include "include/header.php";
  function showMessage($msg){
    if ($msg == 1) {
      print "<p class='alert alert-success'>Offer Added Successfully</p>";
    }
    if ($msg == 2) {
      print "<p class='alert alert-danger'>Something Went Wrong Please Try Again</p>";
    }
    if ($msg == 3) {
      print "<p class='alert alert-danger'>Please Check Uploaded Image Size</p>";
    }
     if ($msg == 4) {
      print "<p class='alert alert-danger'>Please Check Uploaded Image Type</p>";
    }
    if ($msg == 5) {
      print "<p class='alert alert-danger'>Package Deleted Successfully</p>";
    }
  }
?>      

<style type="text/css">
 @media print {
   a[href]:after {
      display: none;
      visibility: hidden;
   }
}
</style>
<div class="right_col" role="main">

    <div class="row">    

      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="x_panel" id="printable">
            <?php
                // if (isset($_GET['msg'])) {
                //   showMessage($_GET['msg']);
                // }
            ?>
            <div class="x_title" style="border-bottom: white;">
              

              
              <div class="col-xs-12 col-sm-12 col-md-12">
              	<?php
            		if (isset($_GET['id'])) {
            			$order_id = $connection->real_escape_string(mysql_entities_fix_string($_GET['id']));    
                  
            			
	            		$sql_order = "SELECT * FROM `orders` WHERE `id`='$order_id'";
	            		if ($res_order = $connection->query($sql_order)) {
	            			$row_order = $res_order->fetch_assoc();
	            			$sql_customer = "SELECT * FROM `users` WHERE `id`='$row_order[user_id]'";
		            		if ($res_customer = $connection->query($sql_customer)) {
		            			$row_customer = $res_customer->fetch_assoc();

		        ?>
            <div style="text-align: center"><h1>SANTIREKHA</h1></div>

              	<div class="col-md-8 col-sm-8 col-xs-6">
              		<h2>Order Details<small></small></h2><br><br>
		        	<table>
                <tr>
                  <th>Order Id :</th>
                  <td><?php echo $row_order['id']; ?></td>
                </tr>
               <!--  <tr>
                  <th>Total Amount :</th>
                  <td><?php 
                  //echo number_format($row_order['amount'],2); 
                  ?></td>
                </tr>
                <tr>
                  <th>Wallet Pay :</th>
                  <td><?php 
                  //echo number_format($row_order['wallet_pay'],2); 
                  ?></td>
                </tr>
                <tr>
                  <th>Net Payable Amount :</th>
                  <td><?php 
                  // echo number_format($row_order['total'],2); 
                  ?></td>
                </tr> -->
		        		<tr>
		        			<th>Name :</th>
		        			<td><?php echo $row_customer['name']; ?></td>
		        		</tr>
		        		<tr>
		        			<th>Email :</th>
		        			<td><?php echo $row_customer['email']; ?></td>
		        		</tr>
		        		<tr>
		        			<th>Mobile :</th>
		        			<td><?php echo $row_customer['mobile']; ?></td>
		        		</tr>
		        		<?php
		        			if (!empty($row_customer['state'])) {
		        				print "<tr>
			        				<th>State :</th>
			        				<td>$row_customer[state]</td>
			        			</tr>";
		        			}
		        			if (!empty($row_customer['city'])) {
		        				print "<tr>
			        				<th>City :</th>
			        				<td>$row_customer[city]</td>
			        				</tr>";
		        			}
		        			if (!empty($row_customer['address'])) {
		        				print "<tr>
			        				<th>Address :</th>
			        				<td>$row_customer[address]</td>
			        				</tr>";
		        			}
		        		?> 	
		        	</table>
		        </div>

              	<div class="col-md-4 col-sm-4 col-xs-6">
              		<h2>Shipping Address<small></small></h2><br><br>
              		<?php
              		$sql_s_address = "SELECT * FROM `shipping_address` WHERE `id`='$row_order[shipping_address_id]'";
                  // echo $sql_s_address;
              		if ($res_s_address = $connection->query($sql_s_address)) { 
              			$row_s_address = $res_s_address->fetch_assoc(); ?>
              		<table>
                    <tr>
                      <th>Address : </th>
                      <td><?php if(!empty($row_s_address['location'])){  echo $row_s_address['location'];} ?></td>
                    </tr>
                    <tr>
                      <th>City : </th>
                      <td><?php if(!empty($row_s_address['city'])){echo $row_s_address['city'];} ?></td>
                    </tr>
              			<tr>
              				<th>State : </th>
              				<td><?php if(!empty($row_s_address['state'])){echo $row_s_address['state'];} ?></td>
              			</tr>
                    <tr>
                      <th>Pin : </th>
                      <td><?php if(!empty($row_s_address['pin'])){echo $row_s_address['pin'];} ?></td>
                    </tr>
                    <tr>
                      <th>Email : </th>
                      <td><?php if(!empty($row_s_address['email'])){echo $row_s_address['email'];} ?></td>
                    </tr>
                    <tr>
                      <th>Mobile : </th>
                      <td><?php if(!empty($row_s_address['mobile'])){echo $row_s_address['mobile'];} ?></td>
                    </tr>
              		</table>
              		<?php } ?>
              	</div>
              	<?php

		            		}
	            		}
	            		
            		}
            	?>
              </div>
            	
		        		
              </div>
            

            <div class="x_content table-responsive">
              <table class="table table-striped jambo_table bulk_action" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>Sl</th>
                    <th>Product Name</th>
                    <th>Sale Price</th>
                    <th>Quantity</th>
                    <th>Save</th>
                    <th>Amount</th>
                  </tr>
                </thead>
                        
                <tbody>
                  <?php
                    $sql_user_order = "SELECT `orders`.`cash_payment` as cash_payment,`orders`.`user_id` as userr_id ,`orders`.`service_charge` as service_charge,`product`.`name` AS p_name,`product`.`mrp` AS mrp, `order_details`.`price` AS o_price, `order_details`.`quantity` AS o_quantity,`order_details`.`price` AS o_price  FROM `order_details` INNER JOIN `product` ON `product`.`id` = `order_details`.`p_id`   INNER JOIN `orders` ON `orders`.`id` = `order_details`.`order_id` WHERE `order_details`.`order_id` ='$order_id'";
                    if ($res_user_order = $connection->query($sql_user_order)) {
                      $count = 1;
                      $total_save_amount = 0;
                      $total_amount=0;
                      $cash_payment = 0;
                      while($user_order_row = $res_user_order->fetch_assoc()){
                        $price = $user_order_row['o_quantity'] * floatval($user_order_row['o_price']);
                        $save_amount = ($user_order_row['mrp']-$user_order_row['o_price'])*$user_order_row['o_quantity'];
                        $service_charge= 0;
                        print "<tr>
                        <td>$count</td>
                        <td>$user_order_row[p_name]<span style='display:block;'>MRP : $user_order_row[mrp]</span></td>
                        <td>$user_order_row[o_price]</td>
                        <td>$user_order_row[o_quantity]</td>
                        <td>$save_amount</td>
                        <td>$price</td>";
                        
                        "</tr>";
                        $total_amount += ($user_order_row['o_price']*$user_order_row['o_quantity']);
                        $service_charge +=$user_order_row['service_charge'];
                        $cash_payment+=$user_order_row['cash_payment'];
                        
                        $total_save_amount +=number_format(($user_order_row['mrp']-$user_order_row['o_price'])*$user_order_row['o_quantity'],2);
                        $count++;
                      }

                      print "<tr>
                      <td colspan='4' align='right'>Total : </td>
                      <td>".number_format($total_save_amount,2,'.', '')."</td>
                      <td>".number_format($total_amount,2,'.', '')."</td>
                    </tr>
                    <tr>
                      <td colspan='5' align='right'>Free Shopping- </td>
                      <td>".number_format($row_order['wallet_pay'],2,'.', '')."</td>                             
                    </tr>
                    <tr>
                      <td colspan='5' align='right'>Net Total- </td>
                      <td>".number_format(($total_amount-$row_order['wallet_pay']),2,'.', '')."</td>                             
                    </tr>
                    <tr>
                      <td colspan='5' align='right'>Previous Balance- </td>
                      <td>".number_format(($row_order['prev_balance']),2,'.', '')."</td>                             
                    </tr>
                    <tr>
                      <td colspan='5' align='right'>Payment Amount- </td>
                      <td>".number_format(($row_order['prev_balance']+($total_amount-$row_order['wallet_pay'])),2,'.', '')."</td>                             
                    </tr>
                    <tr>
                      <td colspan='5' align='right'>Service Charge- </td>
                      <td>".number_format($service_charge,2,'.', '')."</td>
                    </tr>
                    <tr>
                      <td colspan='5' align='right'>Gross Amount- </td>
                      <td>".number_format ((($row_order['prev_balance']+($total_amount-$row_order['wallet_pay']))+$service_charge),2,'.', '')."</td>
                    </tr>
                      <td colspan='5' align='right' >Cash Payment : </td>
                      <td>".number_format($row_order['cash_payment'],2,'.', '')."</td>
                    </tr>
                  
                    <tr>
                      <td colspan='5' align='right'>Balance : </td>
                      <td>".number_format(((($row_order['prev_balance']+($total_amount-$row_order['wallet_pay']))+$service_charge)-$row_order['cash_payment']),2,'.', '')."</td>
                    </tr>
                    
                    ";
                    }
                  ?>   
                  <tr>
                    <td align="center" colspan="5">
                      <a class="btn btn-info" target ="_blank" href="print.php?id=<?php echo $row_order['id']?>" >Print</a>
                      <?php
                      if (isset($_GET['s_date']) && isset($_GET['e_date'])) {
                        $s_date = $connection->real_escape_string(mysql_entities_fix_string($_GET['s_date']));          
                        $e_date = $connection->real_escape_string(mysql_entities_fix_string($_GET['e_date'])); 
                        print '<a class="btn btn-warning" href="order_list.php?s_date='.$s_date.'&e_date='.$e_date.'" id="backprint">Back</a>';
                      }else{
                        print '<a class="btn btn-warning" href="order_list.php" id="backprint">Back</a>';
                      }
                      ?>
                      
                    </td>
                  </tr>                     
                </tbody>
              </table>
              <div id="thanks_msg"></div>
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

      if (s_date) {
        alert(s_date);
        alert(e_date);
        alert(s_time);
        alert(e_time);
      }
    });
  });
</script>

<script type="text/javascript">
  function printDiv() {
     var printContents = document.getElementById("printable").innerHTML;
     var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;
     document.getElementById("thanks_msg").innerHTML = "Thanks For Shopping With Us";

     //document.getElementById("backprint").hide();
     element = document.getElementById('backprint');
     element.style.display = "none";

     window.print();

     element.style.display = "";
     document.getElementById("thanks_msg").innerHTML ="";
     document.body.innerHTML = originalContents;
  }
</script>