<?php
  include "include/header.php";
  function showMessage($msg){
    if ($msg == 1) {
      print "<p class='alert alert-success'>Slider Edited Successfully</p>";
    }
    if ($msg == 2) {
      print "<p class='alert alert-danger'>Something Went Wrong Please Try Again</p>";
    }
    if ($msg == 4) {
      print "<p class='alert alert-danger'>Please Check Image Extension</p>";
    }
    if ($msg == 6) {
      print "<p class='alert alert-danger'>Please Upload Image less Then 1.5 MB</p>";
    }
    
  }
?>      

<div class="right_col" role="main">
  <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>Edit Slider</h2>
            <div class="clearfix"></div>
            <?php
                if (isset($_GET['msg'])) {
                  showMessage($_GET['msg']);
                }
              ?>
          </div>
            <div class="x_content"><br />
                <?php
                if (isset($_GET['id']) && !empty($_GET['id'])) {
                    $slider_id = $connection->real_escape_string(mysql_entities_fix_string($_GET['id']));
                    $sql = "SELECT * FROM `slider` WHERE `id` = '$slider_id'";
                    if ($res = $connection->query($sql)) {
                      $slider_row = $res->fetch_assoc();
                    
                ?>
                <form  class="form-horizontal form-label-left" action="php/slider/update_slider.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="slider_id" value="<?=$slider_id?>">
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="image">Title</label>
                    <div class="col-md-5 col-sm-5 col-xs-12">
                    <input type="text" value="<?=$slider_row['title']?>" placeholder="Enter Title" name="title" class="form-control col-md-5 col-xs-12">
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="image">Product Image
                    </label>
                    <div class="col-md-5 col-sm-5 col-xs-12">
                    <input type="file"  name="image" class="form-control col-md-5 col-xs-12" onchange="readURL(this);"><span>Please Upload Image Less Then 1.5 MB</span>
                    </div>
                    <div  class="col-md-12 col-sm-12 col-xs-12">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">
                    </label>
                    <img src="uploads/slider_image/<?=$slider_row['image']?>" id="preview" height="100px" style="padding-left: 5px">
                    </div>
                </div>
                
                <div class="ln_solid"></div>
                    <div class="form-group">
                    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                        <button type="submit" name="submit" class="btn btn-success">Submit</button>
                        <a href="slider_list.php" class="btn btn-warning">Back</a>
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