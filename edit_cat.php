<?php
  include "include/header.php";
  function showMessage($msg){
    if ($msg == 1) {
      print "<p class='alert alert-success'>Sub Category Updated Successfully</p>";
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
            <h2>Edit Sub Category</h2>
            <div class="clearfix"></div>
            <?php
                if (isset($_GET['msg'])) {
                  showMessage($_GET['msg']);
                }
              ?>
          </div>
          <div class="x_content"><br />
            <?php
              if (isset($_GET['sub_id'])) {
                $sub_category = $connection->real_escape_string(mysql_entities_fix_string($_GET['sub_id']));
                $fetch_sub_cat = "SELECT * FROM `sub_category` WHERE `id`='$sub_category'";
                if ($fetch_sub_res = $connection->query($fetch_sub_cat)) {
                  $fetch_sub_row = $fetch_sub_res->fetch_assoc();
               
            ?>
            <form  class="form-horizontal form-label-left" action="php/product_category/update_category.php" method="post" enctype="multipart/form-data">
              <input type="hidden" name="sub_id" value="<?php echo $fetch_sub_row['id']; ?>">
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
                        if ($row_cat['id'] == $fetch_sub_row['category_id'] ) {
                          print "<option value='$row_cat[id]' selected>$row_cat[name]</option>";
                        }else{
                          print "<option value='$row_cat[id]'>$row_cat[name]</option>";
                        }
                        
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
                  <input type="text" required="required" class="form-control col-md-7 col-xs-12" name="sub_category" value="<?php echo $fetch_sub_row['name'] ?>">
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
                  <img src="uploads/sub_category/thumb/<?php echo $fetch_sub_row['image'] ?>" alt="" height="100" id="preview"> 
                </div>
              </div>
             
              <div class="ln_solid"></div>
                <div class="form-group">
                  <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <button type="submit" class="btn btn-success">Submit</button>
                    <a href="category_list.php" class="btn btn-warning">Back</a>
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