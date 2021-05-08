<!DOCTYPE html>
<html lang='en' >
<head>
  <meta charset='UTF-8'>
  <title>Santirekha</title>
  <style>body{font-family:"Arial"}.text-center{text-align:center}.text-right{text-align:right}.service td:last-child,.payment,.Rate{text-align:right;padding-left:0;padding-right:10px}body{margin:0;background:#5d5858}#invoice-POS{padding:2mm;width:3in;background:#FFF}#invoice-POS ::selection{background:#f31544;color:#FFF}#invoice-POS ::moz-selection{background:#f31544;color:#FFF}#invoice-POS h1{font-size:1.5em;color:#222}#invoice-POS h2{font-size: 1.1em;margin: 0;font-weight: 500;}#invoice-POS h3{font-size:1.2em;font-weight:300;line-height:2em}#invoice-POS p{font-size:.7em;color: #000;line-height:1.2em;margin:0;}#invoice-POS #mid{border-bottom:1px solid #EEE}#invoice-POS #mid{min-height:80px}#invoice-POS #bot{min-height:50px}#invoice-POS #top .logo img{width:100%}#invoice-POS .clientlogo{float:left;height:60px;width:60px;background:url(../../uploads/santirekhalogo.png) no-repeat;background-size:60px 60px;border-radius:50px}#invoice-POS .info{display:block;margin-bottom:5px;border:1px solid #eee;padding:5px}#invoice-POS .title{float:right}#invoice-POS .title p{text-align:right}#invoice-POS table{width:100%;border-collapse:collapse}#invoice-POS .tabletitle{font-size:.5em;border-bottom:1px solid #eee}#invoice-POS .service{border-bottom:1px solid #EEE}#invoice-POS .item{width:24mm}#invoice-POS .itemtext{font-size: 12px;letter-spacing: 1.2px;}#invoice-POS #legalcopy{margin-top:2mm;border-top:1px solid #ddd;padding-top:1mm}table tr td{padding:5px 0 5px 10px;border-left:1px solid #eee}.font-700{font-weight:700}#table h2{font-size: 13px;font-weight: 500;}table .tabletitle:first-child td{border-bottom:1px solid #eee}#table .botton-tail h2{font-size:12px;font-weight: 500;}#table .botton-tail td{padding-top:1.5px;padding-bottom:1.5px;border-right:1px solid #eee}.top-table tr td{padding:0;font-size:10px}</style>

</head>
<body>
<?php include_once 'php/database/connection.php';?>
	<!-- partial:index.partial.html -->
	<?php
		if(isset($_GET['id'])){
			$o_id = $_GET['id'];
		}
		$sql_order = "SELECT * FROM `orders` WHERE `id`='$o_id'";
		if ($res_order = $connection->query($sql_order)) {
			$row_order = $res_order->fetch_assoc();
			$sql_customer = "SELECT * FROM `users` WHERE `id`='$row_order[user_id]'";
			if ($res_customer = $connection->query($sql_customer)) {
				$row_customer = $res_customer->fetch_assoc();
				
	?>
	<div id='invoice-POS'>		
		<div>
			<table class='top-table'>
				<tr>
					<td><strong>Order Date</strong> :<?= $row_order['date']?> </td>
					<td class='text-right'><strong>Order ID</strong> :<?= $row_order['id'] ?></td>
				</tr>
			</table>
		</div>
		<div class='text-center' id='top'>
			<div class='logo'><h1 style="text-transform: uppercase;font-size: 21px;letter-spacing: 4px;font-weight: 300;margin: 7px 0;">Santirekha</h1></div>
		</div><!--End InvoiceTop-->
		
		<div id='mid'>
			<div class='info'>
				<h2>Billing Info</h2>
				<p> 
				<?php echo $row_customer['name']; ?> </br>
				<?php echo $row_customer['email']; ?> </br>
				<?php echo $row_customer['mobile']; ?>
				</p>
			</div>
			<?php
			$sql_s_address = "SELECT * FROM `shipping_address` WHERE `id`='$row_order[shipping_address_id]'";
                  // echo $sql_s_address;
			if ($res_s_address = $connection->query($sql_s_address)) {
				if ($res_s_address->num_rows > 0) {
				$row_s_address = $res_s_address->fetch_assoc(); 
			?>
				
			<div class='info'>
				<h2>Shipping Info</h2>
				<p> 
					Address : <?php echo $row_s_address['location']?></br>
					City   : <?php echo $row_s_address['city']?></br>
					State   : <?php echo $row_s_address['state']?></br>
					Pin   : <?php echo $row_s_address['pin']?></br>
					Email   : <?php echo $row_s_address['email']?></br>
					Mobile   : <?php echo $row_s_address['mobile']?></br>
				</p>
			</div>
			<?php } } ?>
		</div><!--End Invoice Mid-->
		
		<div id='bot'>
			<div id='table'>
				<table>
				<tr class='tabletitle'>
						<td class='item'><h2>Item</h2></td>
						<td class='Hours'><h2>Sale Price</h2></td>
						<td class='Hours'><h2>Qty</h2></td>
						<td class='Hours'><h2>Save</h2></td>
						<td style='text-align:center'><h2>Amount</h2></td>
					</tr>
				<?php
				
				$sql_user_order = "SELECT `orders`.`cash_payment` as cash_payment,`orders`.`user_id` as userr_id ,`orders`.`service_charge` as service_charge,`product`.`name` AS p_name,`product`.`mrp` AS mrp, `order_details`.`price` AS o_price, `order_details`.`quantity` AS o_quantity,`order_details`.`price` AS o_price  FROM `order_details` INNER JOIN `product` ON `product`.`id` = `order_details`.`p_id`   INNER JOIN `orders` ON `orders`.`id` = `order_details`.`order_id` WHERE `order_details`.`order_id` ='$o_id'";
				if ($res_user_order = $connection->query($sql_user_order)) {
					$count = 1;
					$total_save_amount = 0;
					$total_amount=0;
					$cash_payment = 0;
					while($user_order_row = $res_user_order->fetch_assoc()){
					  $price = $user_order_row['o_quantity'] * floatval($user_order_row['o_price']);
					  $save_amount = ($user_order_row['mrp']-$user_order_row['o_price'])*$user_order_row['o_quantity'];
					  $service_charge= 0;
					?>				
					

					<tr class='service'>
						<td class='tableitem'><p class='itemtext'><span><?=$user_order_row['p_name']?></span> <br>MRP :<?= $user_order_row['mrp']?></p></td>
						<td class='tableitem text-center'><p class='itemtext'><?=$user_order_row['o_price']?></p></td>					
						<td class='tableitem text-center'><p class='itemtext'><?=$user_order_row['o_quantity']?></p></td>				
						<td class='tableitem text-center'><p class='itemtext'><?=$save_amount?></p></td>
						<td class='tableitem'><p class='itemtext'><?=$price?></p></td>
					</tr>
					<?php
						$total_amount += ($user_order_row['o_price']*$user_order_row['o_quantity']);
						$service_charge +=$user_order_row['service_charge'];
						$cash_payment+=$user_order_row['cash_payment'];
						
						$total_save_amount +=number_format(($user_order_row['mrp']-$user_order_row['o_price'])*$user_order_row['o_quantity'],2);
						$count++;
					}
					?>
					<tr class='tabletitle botton-tail'>
						<td class='Rate text-right' colspan=3><h2>Total</h2></td>
						<td class='payment'><h2><?php echo number_format($total_save_amount,2,'.', '')?></h2></td>
						<td class='payment'><h2><?php echo number_format($total_amount,2,'.', '')?></h2></td>
					</tr>
					<tr class='tabletitle botton-tail'>
						<td class='Rate text-right' colspan=4><h2>Free shopping</h2></td>
						<td class='payment'><h2><?php  echo number_format($row_order['wallet_pay'],2,'.', '')?></h2></td>
					</tr>
					<tr class='tabletitle botton-tail'>
						<td class='Rate text-right' colspan=4><h2>Net total</h2></td>
						<td class='payment'><h2><?php echo number_format(($total_amount-$row_order['wallet_pay']),2,'.', '')?></h2></td>
					</tr>
					<tr class='tabletitle botton-tail'>
						<td class='Rate text-right' colspan=4><h2>Previous balance </h2></td>
						<td class='payment'><h2><?php echo number_format(($row_order['prev_balance']),2,'.', '')?></h2></td>
					</tr>
					<tr class='tabletitle botton-tail'>
						<td class='Rate text-right' colspan=4><h2>Payment Amount  </h2></td>
						<td class='payment'><h2><?php echo number_format(($row_order['prev_balance']+($total_amount-$row_order['wallet_pay'])),2,'.', '')?></h2></td>
					</tr>
					<tr class='tabletitle botton-tail'>
						<td class='Rate text-right' colspan=4><h2>Service Charge</h2></td>
						<td class='payment'><h2><?php echo $service_charge?></h2></td>
					</tr>  
					<tr class='tabletitle botton-tail'>
						<td class='Rate text-right' colspan=4><h2>Gross Amount</h2></td>
						<td class='payment'><h2><?php echo number_format ((($row_order['prev_balance']+($total_amount-$row_order['wallet_pay']))+$service_charge),2,'.', '')?></h2></td>
					</tr>  
					<tr class='tabletitle botton-tail'>
						<td class='Rate text-right' colspan=4><h2>Cash payment </h2></td>
						<td class='payment'><h2><?php echo number_format($row_order['cash_payment'],2,'.', '')?></h2></td>
					</tr>  
					<tr class='tabletitle botton-tail'>
						<td class='Rate text-right' colspan=4><h2>Balance</h2></td>
						<td class='payment'><h2><?php echo number_format(((($row_order['prev_balance']+($total_amount-$row_order['wallet_pay']))+$service_charge)-$row_order['cash_payment']),2,'.', '')?></h2></td>
					</tr>  
					<?php
					}}
					?>
				</table>
			</div>
				<!--End Table-->

			<div id='legalcopy'>
				<p class='legal text-center'><strong>Thank You For Shopping With Us!</strong> </p>
				<p class='legal'>If any query call us on +91 6033062996 / 03817960917 </p>
			</div>
		</div>
		<!--End InvoiceBot-->
	</div>
	<?php } ?>
<!--End Invoice-->
	<!-- partial -->
  
</body>
</html>


<script>
	window.print();
    window.onafterprint = function(event) {
      window.location.href="make_invoice_form.php?msg=7";
    };
</script>
