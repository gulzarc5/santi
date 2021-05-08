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
              <h2>Free Shopping Product List <small></small></h2>
              <div class="clearfix"></div>
              </div>
            

            <div class="x_content table-responsive">

            <table class="table table-striped jambo_table bulk_action" cellspacing="0" width="100%">
              <thead>
                <tr>
                  <th>Sl</th>
                  <th>Name</th>
                  <th>Category</th>
                  <th>Sub-Category</th>
                  <th>Price</th>
                  <th>Stock</th>
                  <th>Added-Date</th>
                  <th>Action</th>
                </tr>
              </thead>
                      
              <tbody id="mainTable">
                <?php             
                  $sql = "SELECT `product`.*,`category`.`name` as cat_name,`sub_category`.`name` as sub_cat_name FROM `product` left join `category` on `category`.`id` = `product`.`category_id` left join `sub_category` on `sub_category`.`id` = `product`.`sub_cat_id`  WHERE `product`.`is_star_product`='2' ORDER BY `product`.`star_added_date` DESC";
                  if ($res = $connection->query($sql)) {
                    $count = 1;
                    while ($row = $res->fetch_assoc()) {
                      print "<tr>
                      <td>$count</td>
                      <td>$row[name]</td>
                      <td>$row[cat_name]</td>
                      <td>$row[sub_cat_name]</td>
                      <td>$row[price]</td>
                      <td>$row[stock]</td>
                      <td>$row[star_added_date]</td>
                      <td><a class='btn btn-info' href='product_view.php?p_id=$row[id]&page=1005'>View</a><a href='php/product/star_product_remove.php?p_id=$row[id]&page=1005' class='btn btn-danger'>Remove</a></td>
                      </tr>";
                      $count++;
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
