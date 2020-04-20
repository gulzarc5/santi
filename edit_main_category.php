<?php
  include "include/header.php";
  function showMessage($msg){
    if ($msg == 1) {
      print "<p class='alert alert-success'>Main Category Updated Successfully</p>";
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
            <h2>Edit Main Category</h2>
            <div class="clearfix"></div>
            <?php
                if (isset($_GET['msg'])) {
                  showMessage($_GET['msg']);
                }
              ?>
          </div>
          <div class="x_content"><br />
            <?php
              if (isset($_GET['main_id'])) {
                $category = $connection->real_escape_string(mysql_entities_fix_string($_GET['main_id']));
                $fetch_cat = "SELECT * FROM `category` WHERE `id`='$category'";
                if ($fetch_cat_res = $connection->query($fetch_cat)) {
                  $fetch_cat_row = $fetch_cat_res->fetch_assoc();
               
            ?>
            <form  class="form-horizontal form-label-left" action="php/product_category/update_main_category.php" method="post" enctype="multipart/form-data" >
              <input type="hidden" name="main_id" value="<?php echo $fetch_cat_row['id']; ?>">

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Main Category Name <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" required="required" class="form-control col-md-7 col-xs-12" name="category" value="<?php echo $fetch_cat_row['name'] ?>">
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Main Category Image <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="file" class="form-control col-md-7 col-xs-12" name="image" onchange="readURL(this);">
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <img src="uploads/main_category/thumb/<?php echo $fetch_cat_row['image'] ?>" alt="" height="100" id="preview"> 
                </div>
              </div>
             
              <div class="ln_solid"></div>
                <div class="form-group">
                  <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <button type="submit" class="btn btn-success">Submit</button>
                    <a href="main_category_list.php" class="btn btn-warning">Back</a>
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

<script>
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