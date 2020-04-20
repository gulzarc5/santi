<?php
require_once "include/header.php";

function showMessage($msg){
    if ($msg == 3) {
      print "<p class='alert alert-success'>Batch Updated Successfully</p>";
    }
    if ($msg == 4) {
      print "<p class='alert alert-danger'>Something Wrong Please Try Again</p>";
    }
    if ($msg == 1) {
      print "<p class='alert alert-success'>Product Deleted Successfully</p>";
    }
    if ($msg == 2) {
      print "<p class='alert alert-danger'>Something Wrong Please Try Again</p>";
    }
    if ($msg == 5) {
      print "<p class='alert alert-success'>Offer Set Successfully</p>";
    }
  }

function getProduct($connection){
  $sql = "SELECT `product`.`id` as p_id,`product`.`name` as name, `product`.`description` AS description,`product`.`price` as price,`product`.`stock` AS stock, `category`.`name` AS category, `sub_category`.`name` AS sub_category  FROM `product` INNER JOIN `category` ON `category`.`id`=`product`.`category_id` INNER JOIN `sub_category` ON `sub_category`.`id`=`product`.`sub_cat_id` WHERE `product`.`catagory_id`='1007'";
  if ($res = $connection->query($sql)) {
    $sl_count = 1;
    while($product = $res->fetch_assoc()){
      print '<tr>
                <td>'.$sl_count.'</td>
                <td>'.$product['name'].'</td>
                <td>'.$product['category'].'</td>
                <td>'.$product['sub_category'].'</td>
                <td>'.$product['price'].'</td>
                <td>'.$product['stock'].'</td>
                <td>
                  <a href="product_view.php?p_id='.$product['p_id'].'" class="btn btn-success">View</a>
                  <a href="product_edit.php?p_id='.$product['p_id'].'" class="btn btn-success">Edit</a>
                  <a href="php/product/product_delete.php?p_id='.$product['p_id'].'" class="btn btn-danger">Delete</a>
                  <a href="set_offer_product_wise.php?p_id='.$product['p_id'].'" class="btn btn-info">Set Offer</a>
                </td>
             </tr>';
      $sl_count++;
    }

  }
}
?>
<div class="clearfix"></div>
<div class="right_col" role="main">
	<div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
           <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Baby Care Products<small></small></h2>
                    <div class="clearfix"></div>
                      <?php 
                        if (isset($_GET['msg'])) {
                          showMessage($_GET['msg']);
                        }           
                      ?>
                  </div>
                  <div class="x_content">
          
                    <table id="productTable" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                      <thead>
                        <tr>
                          <th>Sl</th>
                          <th>Product Name</th>
                          <th>Category</th>
                          <th>Sub Category</th>
                          <th>Price</th>
                          <th>Stock</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                                              
                      </tbody>
                    </table>
          
          
                  </div>
                </div>
              </div>
        </div>
    </div>
</div>








<?php
require_once "include/footer.php";
?>

<script src="vendors/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>

<script type="text/javascript">
  $(document).ready(function(){
    var dataTable=$("#productTable").DataTable({
      "processing" : true,
      "serverSide" : true,
       "columns": [
          { "orderable": false },
          null,
          { "orderable": false },
          { "orderable": false },
          null,
          null,
          null,
        ],
        "pageLength": 50,
      "ajax" :{
        url : "php/ajax/baby_care.php",
        type : "post"
      }
    });
  });
</script>