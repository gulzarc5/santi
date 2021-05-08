<?php
  include "include/header.php";
  function showMessage($msg){
    if ($msg == 1) {
      print "<p class='alert alert-success'>Category Added Successfully</p>";
    }elseif ($msg == 2) {
      print "<p class='alert alert-danger'>Something Went Wrong Please Try Again</p>";
    }elseif ($msg == 6) {
      print "<p class='alert alert-danger'>Image Size Should Be Less Then 1.5 MB</p>";
    }elseif ($msg == 4) {
        print "<p class='alert alert-danger'>Please Upload Image JPG Or PNG Format</p>";
    }
  }
?>      

<div class="right_col" role="main">
  <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>Add New Sub Category</h2>
            <div class="clearfix"></div>
            <?php
                if (isset($_GET['msg'])) {
                  showMessage($_GET['msg']);
                }
              ?>
          </div>
          <div class="x_content"><br />
            <form  class="form-horizontal form-label-left" action="php/product_category/add_category.php" method="post" enctype="multipart/form-data">
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Select Category <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <select class="form-control col-md-7 col-xs-12" name="category" required>
                    <option value="">Please Select Category</option>
                    <?php
                    $sql_category = "SELECT * FROM `category` order by `name` ASC";
                    if ($res_cat = $connection->query($sql_category)) {
                      while ($row_cat = $res_cat->fetch_assoc()) {
                        print "<option value='$row_cat[id]'>$row_cat[name]</option>";
                      }
                    }
                    ?>
                  </select>
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Sub Category Name <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" required="required" class="form-control col-md-7 col-xs-12" name="sub_category">
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Main Category Image <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="file" required="required" class="form-control col-md-7 col-xs-12" name="image">
                </div>
              </div>
             
              <div class="ln_solid"></div>
                <div class="form-group">
                  <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <button type="submit" class="btn btn-success">Submit</button>
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