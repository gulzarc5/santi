<?php
require_once "include/header.php";
?>

<div class="clearfix"></div>
<div class="right_col" role="main">

	<?php
	 if (isset($_GET['u_id'])) {
	 	$u_id = $connection->real_escape_string(mysql_entities_fix_string($_GET['u_id']));
	 	$sql_u_fetch = "SELECT * FROM `users` WHERE `id`='$u_id'";
	 	if ($res_u = $connection->query($sql_u_fetch)) {
	 		$user_row = $res_u->fetch_assoc();
	 	
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
                                    <i class="fa fa-globe"></i> User Detail
                                    <small class="pull-right"></small>
                                </h1>
                        	</div>
                        	<!-- /.col -->
                      	</div>
                      	<!-- info row -->
                      	<div class="row invoice-info">
	                        <div class="col-sm-4 invoice-col">
	                      		<address>
	                      			
	                      			<b>Id :</b><?php echo $user_row['id'];?>
		                            <br><strong>Name : <?php echo $user_row['name'];?></strong>
		                            <br><b>Mobile :</b><?php echo $user_row['mobile'];?>
		                            <br><b>Email :</b><?php echo $user_row['email'];?>
		                            <br><b>Parmanent Address :</b>
		                            
		                            <br><b>Shipping Address :</b><br>
		                           
		                            
	                        	</address>
	                        </div>
	                        <div class="col-sm-4 invoice-col">
	                        	
	                        </div>
                      	</div>
                      	<!-- /.row -->
                      	<hr>
                      
                      	<!-- Table row -->
                      	<div class="row">
                        	<div class="col-xs-12 table">
                        		<h2>Parmanent Address</h2>
                          		<table class="table table-striped jambo_table bulk_action">
                            		<thead>

                              			<tr>
			                                <th>Address</th>
			                                <th>City</th>
			                                <th>State</th>
			                                <th>Pin</th>
			                            </tr>
                            		</thead>
                            		<tbody>

                            			<?php 
			                            	$sql_add = "SELECT * FROM `parmanent_address` WHERE `user_id`='$user_row[id]'";
										 	if ($res_add= $connection->query($sql_add)) {
										 		$add_row = $res_add->fetch_assoc();
										 		print"<tr>
										 			<td>$add_row[location]</td>
										 			<td>$add_row[city]</td>
										 			<td>$add_row[state]</td>
										 			<td>$add_row[pin]</td>
										 		</tr>";
										 	}
			                            
			                            ?>
                            		</tbody>
                          		</table>
                        	</div>
                        	<!-- /.col -->
                      	</div>
                      
                      	<div class="row">
                        	<div class="col-xs-12 table">
                        		<h2>Shipping Address</h2>
                          		<table class="table table-striped jambo_table bulk_action">
                            		<thead>

                              			<tr>
			                                <th>Address</th>
			                                <th>City</th>
			                                <th>State</th>
			                                <th>Mobile</th>
			                                <th>Email</th>
			                                <th>Pin</th>
			                                <th>Action</th>
			                            </tr>
                            		</thead>
                            		<tbody>

                            			<?php 
			                            	$sql_s_add = "SELECT * FROM `shipping_address` WHERE `user_id`='$user_row[id]'";
										 	if ($res_s_add= $connection->query($sql_s_add)) {
										 		while($add_s_row = $res_s_add->fetch_assoc()){
										 			print"<tr>
											 			<td>$add_s_row[location]</td>
											 			<td>$add_s_row[city]</td>
											 			<td>$add_s_row[state]</td>
											 			<td>$add_s_row[mobile]</td>
											 			<td>$add_s_row[email]</td>
											 			<td>$add_s_row[pin]</td>
											 			<td><a href='edit_shipping.php?s_id=$add_s_row[id]' class='btn btn-success'> Edit</a></td>
										 			</tr>";
										 		}
										 		
										 	}
			                            
			                            ?>
                            		</tbody>
                          		</table>
                        	</div>
                        	<!-- /.col -->
                      	</div>
                      	<!-- /.row -->
						<!-- this row will not appear when printing -->
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
	 }
    ?>
</div>


<?php

require_once "include/footer.php";
?>