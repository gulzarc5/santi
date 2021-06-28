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
  }
?>      

<div class="right_col" role="main">
  <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>Edit Discount </h2>
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
              $package_id = $connection->real_escape_string(mysql_entities_fix_string($_GET['id']));

              $sql_package = "SELECT * FROM `offer` WHERE `id`='$package_id'";
              if ($res_package = $connection->query($sql_package)) {
                $row_package = $res_package->fetch_assoc();
              
            ?>

            <form  class="form-horizontal form-label-left" action="php/offer/package_edit.php" method="post" enctype="multipart/form-data">
              <input type="hidden" name="package_id" value="<?php echo $package_id ?>">
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Offer name <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" required="required" class="form-control col-md-7 col-xs-12" name="name" value="<?php echo $row_package['name'] ?>">
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="description">Discount  Description
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <textarea type="text" name="description"  class="form-control col-md-7 col-xs-12"><?php echo $row_package['description'] ?></textarea>
                </div>
              </div>

              <div class="form-group">
                <!--<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Offer From Price 111<span class="required">*</span>-->
                <!--</label>-->
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="hidden" required="required" class="form-control col-md-7 col-xs-12" name="start_offer" value="<?php echo $row_package['offer_start'] ?>">
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Discount Percentage <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" required="required" class="form-control col-md-7 col-xs-12" name="percentage" value="<?php echo $row_package['percentage'] ?>">
                </div>
              </div>

             <!--  <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Offer Up to<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" required="required" class="form-control col-md-7 col-xs-12" name="end_offer" value="<?php //echo $row_package['offer_end'] ?>">
                </div>
              </div> -->

              <!-- <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Offer <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" required="required" class="form-control col-md-7 col-xs-12" name="start_offer">
                </div>
              </div> -->
             
          <!--    <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="image">Product Image
                </label>
                <div class="col-md-5 col-sm-5 col-xs-12">
                  <input type="file"  name="image" class="form-control col-md-5 col-xs-12" onchange="readURL(this);"><span>Please Upload Image Less Then 1.5 MB</span>
                </div>
                <div  class="col-md-12 col-sm-12 col-xs-12">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">
                </label>
                  <img src="uploads/package_image/thumb/<?php //echo $row_package['image'] ?>" id="preview" style="padding-left: 5px">
                </div>
              </div> -->

              <div class="ln_solid"></div>
                <div class="form-group">
                  <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <button type="submit" name="package_add" value="package_add" class="btn btn-success">Submit</button>
                    <a href="offer_form.php" class="btn btn-warning"> Back </a>
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

<script type="text/javascript">
  function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#preview')
                        .attr('src', e.target.result)
                        .height(120);
                };

                reader.readAsDataURL(input.files[0]);
            }
     }
</script>