<?php
  include "include/header.php";
  function showMessage($msg){
    if ($msg == 1) {
      print "<p class='alert alert-success'>Balance Added Successfully</p>";
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
            <h2>Add Service Charge</h2>
            <div class="clearfix"></div>
            <?php
                if (isset($_GET['id'])) {
                  $id = $_GET['id'];
                }
              ?>
          </div>
          <div class="x_content"><br />
            <form  class="form-horizontal form-label-left" action="php/orders/add_service_charge.php?id=<?php echo $id ?>" method="post">
             

              
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> 
                </label>
               
              </div>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Amount in Rs. <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="number" step="any" required="required" class="form-control col-md-7 col-xs-12" name="amount">
                </div>
              </div>
             
              <div class="ln_solid"></div>
                <div class="form-group">
                  <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <button type="submit" name="submit" value="submit" class="btn btn-success">Add</button>
                    <a href="order_list.php" class="btn btn-warning" >Back</a>
                  </div>
                </div>

              
              </form>
            </div>
          </div>
        </div>
      </div>
</div>
<?php
include "include/footer.php";



?>