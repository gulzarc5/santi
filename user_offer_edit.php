<?php
  include "include/header.php";
  function showMessage($msg){
    if ($msg == 1) {
      print "<p class='alert alert-success'>Offer Updated Successfully</p>";
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
            <h2>Edit User Offer</h2>
            <div class="clearfix"></div>
            <?php
                if (isset($_GET['msg'])) {
                  showMessage($_GET['msg']);
                }
              ?>
          </div>
          <div class="x_content"><br />

            <?php
              if (isset($_GET['id'])) {

                $sql = "SELECT * FROM `offer` WHERE `id`='$_GET[id]'";
                if ($res = $connection->query($sql)) {
                  $offer = $res->fetch_assoc();
                
            ?>
            <form  class="form-horizontal form-label-left" action="php/offer/user_offer_upadte.php" method="post">
              
              <input type="hidden" name="offer_id" value="<?php echo $_GET['id'] ?>">

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Offer Name <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" required="required" class="form-control col-md-7 col-xs-12" name="name" value="<?php echo $offer['name'] ?>">
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Percentage <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="number" step="any" class="form-control col-md-7 col-xs-12" name="percentage" value="<?php echo $offer['percentage'] ?>" required>
                </div>
              </div>
             
              <div class="ln_solid"></div>
                <div class="form-group">
                  <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <button type="submit" class="btn btn-success">Submit</button>
                    <a href="offer_form.php" class="btn btn-warning">Back</a>
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