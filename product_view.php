<?php
require_once "include/header.php";
?>

<div class="clearfix"></div>
<div class="right_col" role="main">


<?php
	if (isset($_GET['p_id'])) {
	$p_id = $connection->real_escape_string(mysql_entities_fix_string($_GET['p_id']));
	$sql_p_fetch = "SELECT * FROM `product` WHERE `id`='$p_id'";
	if ($res_p = $connection->query($sql_p_fetch)) {
		$product_row = $res_p->fetch_assoc();
	
?>
<div class="row">
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="x_panel">
		<div class="x_title">
			<h2>Product View</h2>
			<div class="clearfix"></div>
		</div>
		<div class="x_content">
			<div class="col-md-8 col-sm-5 col-xs-12" style="border:0px solid #e5e5e5;">
				<h3 class="prod_title"><?php echo $product_row['name'];?></h3>
				<div class="row product-view-tag">
				<h5 class="col-md-12 col-sm-12 col-xs-12"><strong>Barcode :</strong> 
				<?php
				if (!empty($product_row['barcode'])) {
					print "<img alt='Image' src='php/barcode/barcode_print.php?codetype=code25&size=80&text=$product_row[barcode]&print=true' style='height:93px' />";
				}
				?>
				
				</h5>
					<h5 class="col-md-6 col-sm-6 col-xs-12"><strong>Product Id :</strong> <?php echo $product_row['id'];?> </h5> 
					<h5 class="col-md-6 col-sm-6 col-xs-12"><strong>Catagory:</strong> 
						<?php 
							$sql_cat = "SELECT * FROM `category` WHERE `id`='$product_row[category_id]'";
							if ($res_cat= $connection->query($sql_cat)) {
								$cat_row = $res_cat->fetch_assoc();
								echo $cat_row['name'];
							}						
						?>
					</h5>				  
					<h5 class="col-md-6 col-sm-6 col-xs-12"><strong>Sub Category : </strong>
						<?php 
							$sql_cat = "SELECT * FROM `sub_category` WHERE `id`='$product_row[sub_cat_id]'";
							if ($res_cat= $connection->query($sql_cat)) {
								$cat_row = $res_cat->fetch_assoc();
								echo $cat_row['name'];
							}						
						?>
					</h5>
					<h5 class="col-md-6 col-sm-6 col-xs-12"><strong>HSN Code : </strong><?= $product_row['hsn_code'];?></h5>
					<h5 class="col-md-6 col-sm-6 col-xs-12"><strong>Product Cost : </strong> <?= $product_row['cost'];?>  </h5>
					<h5 class="col-md-6 col-sm-6 col-xs-12"><strong>Product MRP : </strong> <?= $product_row['mrp'];?> </h5>
					<h5 class="col-md-6 col-sm-6 col-xs-12"><strong>Product Price : </strong> <?= $product_row['price'];?> </h5>
					<h5 class="col-md-6 col-sm-6 col-xs-12"><strong>Product Cashback : </strong> <?= $product_row['cash_back'];?> </h5>
					<h5 class="col-md-6 col-sm-6 col-xs-12"><strong>Promotional Bonus : </strong> <?= $product_row['promotional_bonus'];?> </h5>
					<h5 class="col-md-6 col-sm-6 col-xs-12"><strong>Product Stock : </strong> <?= $product_row['stock'];?> </h5>
					<h5 class="col-md-6 col-sm-6 col-xs-12"><strong>SGST Amount : </strong> <?= $product_row['sgst'];?> </h5>
					<h5 class="col-md-6 col-sm-6 col-xs-12"><strong>SGST Percent : </strong> <?= $product_row['sgst_percent'];?> %</h5>
					<h5 class="col-md-6 col-sm-6 col-xs-12"><strong>CGST Amount : </strong> <?= $product_row['cgst'];?> </h5>
					<h5 class="col-md-6 col-sm-6 col-xs-12"><strong>CGST Percent : </strong> <?= $product_row['cgst_percent'];?> %</h5>

					<h5 class="col-md-6 col-sm-6 col-xs-12"><strong>Expiry date : </strong> <?= $product_row['expiry_date'];?> </h5>
					
				</div><br />
			</div>

			<div class="col-md-4 col-sm-7 col-xs-12">
                  <h3 class="prod_title">Images </h3>
                  <div class="product-image">
                    <img src="uploads/product_image/thumb/<?php echo $product_row['image'];?>" " alt="..." />
                  </div>
                </div>

		</div>

		<div class="col-md-12">
			<div class="product_price">
				<h3 style="margin: 0">Product Description</h3><hr style="margin: 10px 0;border-top: 1px solid #ddd;">
				<p><?php echo $product_row['description'];?></p>
			</div>
		</div>
		<div class="col-md-12">
		<!-- <button class="btn btn-danger" onclick="window.close();">Close Window</!-->
		</div>
		</div>
		</div>
	</div>
</div>
<?php
    	}
	 }
?>


<?php

require_once "include/footer.php";
?>