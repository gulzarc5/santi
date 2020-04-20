<?php
  include "include/header.php";

  function showMessage($msg){
 
    if ($msg == 1) {
      print "<p class='alert alert-danger'>Email Id Used By Another User</p>";
    }
    if ($msg == 2) {
      print "<p class='alert alert-danger'>Something Wrong Please Try Again</p>";
    }
     
  }
?>      

<div class="right_col" role="main">
  <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>Edit Shipping Address</h2>
            <div class="clearfix"></div>
             <?php 
              if (isset($_GET['msg'])) {
                showMessage($_GET['msg']);
              }           
            ?>
          </div>
          <div class="x_content"><br />
            <?php
            if (isset($_GET['s_id'])) {
              $s_id = $connection->real_escape_string(mysql_entities_fix_string($_GET['s_id'] ));
              $s_addr_sql = "SELECT * FROM `shipping_address` WHERE `id`='$s_id'";
              if ($shipping_res = $connection->query($s_addr_sql)) {
                $shipping_row = $shipping_res->fetch_assoc();
            ?>
            <form action="php/users/update_s_addr.php" method="post" class="form-horizontal form-label-left">
              <input type="hidden" name="s_id" value="<?php echo $s_id; ?>">
              <input type="hidden" name="user_id" value="<?php echo $shipping_row['user_id'] ?>">

             
          <!--     <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Name <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" id="name" name="last-name" required="required" class="form-control col-md-7 col-xs-12">
                </div>
              </div> -->
              <div class="form-group">
                <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Email :</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input  class="form-control col-md-7 col-xs-12" type="email" name="email" required value="<?php echo $shipping_row['email']; ?>">
                </div>
              </div>
              <div class="form-group">
                <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">State :</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input  class="form-control col-md-7 col-xs-12" type="text" name="state" required value="<?php echo $shipping_row['state']; ?>">
                </div>
              </div>

              <div class="form-group">
                <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">City :</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input  class="form-control col-md-7 col-xs-12" type="test" name="city" required value="<?php echo $shipping_row['city']; ?>">
                </div>
              </div>

              <div class="form-group">
                <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Address :</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <textarea name="address" class="form-control col-md-7 col-xs-12"><?php echo $shipping_row['location']; ?></textarea>
                </div>
              </div>

              <div class="form-group">
                <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Pin :</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input  class="form-control col-md-7 col-xs-12" type="text" name="pin" value="<?php echo $shipping_row['pin']; ?>">
                </div>
              </div>

              <div class="form-group">
                <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Mobile No :</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input  class="form-control col-md-7 col-xs-12" type="text" name="mobile" required value="<?php echo $shipping_row['mobile']; ?>">
                </div>
              </div>

              <div class="ln_solid"></div>
                <div class="form-group">
                  <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <input type="submit" class="btn btn-success" name="submit" value="Submit">
                    <a href="user_list.php" class="btn btn-warning">Back</a>
                  </div>
                </div>
              </form>

              <?php
                }
            }
              ?>

            </div>
          </div>
        </div>
      </div>
</div>
<?php
include "include/footer.php";

?>
