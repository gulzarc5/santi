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
                      <td><?php echo $row_s_address['location'] ?></td>
                    </tr>
                    <tr>
                      <th>City : </th>
                      <td><?php echo $row_s_address['city'] ?></td>
                    </tr>
              			<tr>
              				<th>State : </th>
              				<td><?php echo $row_s_address['state'] ?></td>
              			</tr>
                    <tr>
                      <th>Pin : </th>
                      <td><?php echo $row_s_address['pin'] ?></td>
                    </tr>
                    <tr>
                      <th>Email : </th>
                      <td><?php echo $row_s_address['email'] ?></td>
                    </tr>
                    <tr>
                      <th>Mobile : </th>
                      <td><?php echo $row_s_address['mobile'] ?></td>
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
                    <th>Quantity</th>
                    <th>Rate</th>
                    <th>Price</th>
                  </tr>
                </thead>
                        
                <tbody>
                  <?php
                    $sql_user_order = "SELECT `product`.`name` AS p_name,`order_details`.`price` AS o_price, `order_details`.`quantity` AS o_quantity,`order_details`.`price` AS o_price  FROM `order_details` INNER JOIN `product` ON `product`.`id` = `order_details`.`p_id` WHERE `order_details`.`order_id` ='$order_id'";
                    if ($res_user_order = $connection->query($sql_user_order)) {
                      $count = 1;
                      while($user_order_row = $res_user_order->fetch_assoc()){
                        $price = $user_order_row['o_quantity'] * floatval($user_order_row['o_price']);
                       
                        print "<tr>
                        <td>$count</td>
                        <td>$user_order_row[p_name]</td>
                        <td>$user_order_row[o_quantity]</td>
                        <td>$user_order_row[o_price]</td>
                        <td>$price</td>";
                        
                        "</tr>";
                        $count++;
                      }

              
                      print "<tr>
                              <td colspan='4' align='right'>Total : </td>
                              <td>".number_format($row_order['amount'],2)."</td>
                            </tr>
                            
                            <tr>
                              <td colspan='4' align='right' >Wallet Pay : </td>
                              <td>".number_format($row_order['wallet_pay'],2)."</td>
                            </tr>
                          
                            <tr>
                              <td colspan='4' align='right' >Net Payable Amount : </td>
                              <td>".number_format($row_order['total'],2)."</td>
                            </tr>
                            
                            <tr>
                              <td colspan='4' align='right' >Cashback : </td>
                              <td>".number_format($row_order['cashback'],2)."</td>
                            </tr>";
                    }
                  ?>   
                                    
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
     var printContents = document.getElementById("printable").innerHTML;
     var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;
     document.getElementById("thanks_msg").innerHTML = "Thanks For Shopping With Us";

     //document.getElementById("backprint").hide();

    window.print();
    window.onafterprint = function(event) {
        window.location.href="make_invoice_form.php?msg=7";
    };

</script>