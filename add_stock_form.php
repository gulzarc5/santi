<?php
  include "include/header.php";
  function showMessage($msg){
    if ($msg == 1) {
      print "<p class='alert alert-success'>Stock Added Successfully</p>";
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
        <div class="x_panel">
          <div class="x_title">
            <h2>Add Product Stock</h2>
            <div class="clearfix"></div>
            <?php
                if (isset($_GET['msg'])) {
                  showMessage($_GET['msg']);
                }
              ?>
          </div>
          <div class="x_content"><br />
            <form  class="form-horizontal form-label-left" action="php/product/add_stock.php" method="post">
              <?php
                if (isset($_GET['p_id'])) {
                  $row_stock = 0.00;
                 $p_id = $connection->real_escape_string(mysql_entities_fix_string($_GET['p_id']));
               
                  $sql_stock = "SELECT stock,name FROM `product` WHERE `id`='$p_id'";
                  if ($res_stock = $connection->query($sql_stock)) {
                    $row_stock = $res_stock->fetch_assoc();
                
              ?>

              <input type="hidden" name="p_id" value="<?php echo $p_id; ?>">
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> 
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <?php  echo "<b style='color:#ff9800;'>Product Name = </b><b style='color:#26B99A;'>".$row_stock['name']."</b> <br>
                  <b style='color:#ff9800;'>Previous Stock = </b><b style='color:#26B99A;'>".$row_stock['stock']."</b>"; ?>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Add More Stock<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="number" required="required" class="form-control col-md-7 col-xs-12" name="stock">
                </div>
              </div>
             
              <div class="ln_solid"></div>
                <div class="form-group">
                  <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <button type="submit" name="submit" value="submit" class="btn btn-success">Add Stock</button>
                    <a href="education.php" class="btn btn-warning" >Back</a>
                  </div>
                </div>

                <?php
                    }
                  }
                ?>
              </form>
            </div>
          </div>
        </div>
      </div>
</div>
<?php
include "include/footer.php";



?>