<?php
  include "include/header.php";

  function showMessage($msg){
    if ($msg == 1) {
      print "<p class='alert alert-success'>Product Updated Successfully</p>";
    }
    if ($msg == 2) {
      print "<p class='alert alert-danger'>Something Wrong Please Try Again</p>";
    }
    if ($msg == 3) {
      print "<p class='alert alert-danger'>Something Wrong Please Try Again</p>";
    }
    if ($msg == 4) {
      print "<p class='alert alert-danger'>Please Check Image Type</p>";
    }
    if ($msg == 5) {
      print "<p class='alert alert-danger'>Product Already Exist</p>";
    }
    if ($msg == 6) {
      print "<p class='alert alert-danger'>Image Size is Larger Then The Upload Size</p>";
    }
    if ($msg == 7) {
      print "<p class='alert alert-danger'>Bar Code Already Exist Please Try With Another Bar Code</p>";
    }
  }
?>      

<div class="right_col" role="main">
  <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>Edit Product</h2>
            <div class="clearfix"></div>
            <?php 
              if (isset($_GET['msg'])) {
                showMessage($_GET['msg']);
              }           
            ?>
          </div>
          <div class="x_content"><br />

             <?php
              if (isset($_GET['p_id'])) {
                 $p_id = $connection->real_escape_string(mysql_entities_fix_string($_GET['p_id']));
                  $sql_get_p = "SELECT * FROM `product` WHERE `id`='$p_id'";
                  if ($res_get_p = $connection->query($sql_get_p)) {
                     $product_row = $res_get_p->fetch_assoc();

                
            ?>

            <form action="php/product/update_product.php" method="post" class="form-horizontal form-label-left" enctype="multipart/form-data">
              <input type="hidden" name="p_id" value="<?php echo $p_id ?>">

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="product_name">Enter Bar Code Number / Scan Barcode if Available
                </label>
                <div class="col-md-8 col-sm-8 col-xs-12">
                  <input type="text" placeholder="Enter Bar Code" class="form-control col-md-7 col-xs-12" name="bar_code" value="<?php echo  $product_row['barcode']; ?>">
                  <span id="bar_code_msg"></span>
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="product_name">Product Name <span class="required">*</span>
                </label>
                <div class="col-md-8 col-sm-8 col-xs-12">
                  <input type="text"  required="required" class="form-control col-md-7 col-xs-12" name="name" value="<?php echo  $product_row['name']; ?>">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="composition">Product Category<span class="required">*</span>
                </label>
                <div class="col-md-8 col-sm-8 col-xs-12">
                  <select name="category" required="required" class="form-control col-md-7 col-xs-12" id="category">
                    <option value="" selected>Please Select Category</option>

                    <?php
                    $sql_category = "SELECT * FROM `category` Order by `name` ASC";
                    if ($res_cat = $connection->query($sql_category)) {
                      while($cat_row = $res_cat->fetch_assoc()){
                        if ( $product_row['category_id'] == $cat_row['id']) {
                           print '<option value="'.$cat_row['id'].'" selected>'.$cat_row['name'].'</option>';
                        }else{
                          print '<option value="'.$cat_row['id'].'">'.$cat_row['name'].'</option>';
                        }
                      }
                    }
                    ?>
                  </select>
                  
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="composition">Sub Category
                </label>
                <div class="col-md-8 col-sm-8 col-xs-12">
                  <select name="sub_category" class="form-control col-md-7 col-xs-12" id="sub_category">
                    <option value="" selected>Please Select Sub Category</option>
                    <?php
                      $sql_sub_category = "SELECT * FROM `sub_category` WHERE `category_id`='$product_row[category_id]' Order by `name` ASC";
                      if ($res_sub_cat = $connection->query($sql_sub_category)) {
                        while($sub_cat_row = $res_sub_cat->fetch_assoc()){
                          if ( $product_row['sub_cat_id'] == $sub_cat_row['id']) {
                             print '<option value="'.$sub_cat_row['id'].'" selected>'.$sub_cat_row['name'].'</option>';
                          }else{
                            print '<option value="'.$sub_cat_row['id'].'">'.$sub_cat_row['name'].'</option>';
                          }
                        }
                      }
                    ?>
                  </select>
                  
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="description">Product Description
                </label>
                <div class="col-md-8 col-sm-8 col-xs-12">
                  <textarea type="text" name="description"   class="form-control col-md-7 col-xs-12"><?php echo $product_row['description'] ?></textarea>
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="description">HSN / SAC Code
                </label>
                <div class="col-md-8 col-sm-8 col-xs-12">
                  <input type="text"  name="hsn_code" value="<?=$product_row['hsn_code']?>"  class="form-control col-md-7 col-xs-12">
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="description">Purchase Cost
                </label>
                <div class="col-md-8 col-sm-8 col-xs-12">
                  <input type="number" cast="any"  name="cost" value="<?=$product_row['cost']?>" class="form-control col-md-7 col-xs-12">
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="price">M.R.P.<span class="required">*</span>
                </label>
                <div class="col-md-8 col-sm-8 col-xs-12">
                  <input type="number" cast="any"  name="mrp" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $product_row['mrp']; ?>">
                </div>
              </div>
              
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="price">Price<span class="required">*</span>
                </label>
                <div class="col-md-8 col-sm-8 col-xs-12">
                  <input type="number" cast="any"  name="price" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $product_row['price']; ?>">
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="description">CGST
                </label>
                <div class="col-md-4 col-sm-4 col-xs-12">
                  <input type="number" cast="any"  name="cgst" value="<?=$product_row['cgst']?>"  class="form-control col-md-7 col-xs-12">
                  <span>CGST Amount</span>
                </div>
                <div class="col-md-4 col-sm-4 col-xs-12">
                  <input type="number" cast="any"  name="cgst_percent" value="<?=$product_row['cgst_percent']?>"  class="form-control col-md-7 col-xs-12">
                  <span>CGST Percent</span>
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="description">SGST
                </label>
                <div class="col-md-4 col-sm-4 col-xs-12">
                  <input type="number" cast="any"  name="sgst" value="<?=$product_row['sgst']?>"  class="form-control col-md-7 col-xs-12">
                  <span>SGST Amount</span>
                </div>
                <div class="col-md-4 col-sm-4 col-xs-12">
                  <input type="number" cast="any"  name="sgst_percent" value="<?=$product_row['sgst_percent']?>"  class="form-control col-md-7 col-xs-12">
                  <span>SGST Percent</span>
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="description">Cashback
                </label>
                <div class="col-md-8 col-sm-8 col-xs-12">
                  <input type="number" cast="any"  name="cash_back" value="<?=$product_row['cash_back']?>"  class="form-control col-md-7 col-xs-12">
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="description">Promotional Bonus
                </label>
                <div class="col-md-8 col-sm-8 col-xs-12">
                  <input type="number" cast="any"  name="promotional_bonus" value="<?=$product_row['promotional_bonus']?>"  class="form-control col-md-7 col-xs-12">
                </div>
              </div>

               <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="stock">Stock<span class="required">*</span>
                </label>
                <div class="col-md-8 col-sm-8 col-xs-12">
                  <input type="number"   name="stock" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $product_row['stock']; ?>">
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="expiry_date">Expiry Date
                </label>
                <div class="col-md-8 col-sm-8 col-xs-12">
                  <input type="date" value="<?php echo $product_row['expiry_date']; ?>"  name="expiry_date" class="form-control col-md-7 col-xs-12">
                </div>
              </div>


             <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="image">Product Image
                </label>
                <div class="col-md-5 col-sm-5 col-xs-12">
                  <input type="file"  name="image" class="form-control col-md-5 col-xs-12 demoInputBox"  onchange="fileTest(this);" id="file"><span id="file_error"></span><br><span>Please Upload Image Less Then 1.5 MB</span>
                </div>
                <div  class="col-md-12 col-sm-12 col-xs-12">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">
                </label>
                  <img src="uploads/product_image/thumb/<?php echo $product_row['image'] ?>" id="preview" style="padding-left: 5px">
                </div>
              </div>
              <div class="ln_solid"></div>
                <div class="form-group">
                  <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <button type="submit" name="update_product" value="update_product" class="btn btn-success">Submit</button>
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
    var product_size_add_more_count = 1;
    var size_type_select_box = $("#size_type_select_box").html();
    var qtty_type_select_box = $("#qtty_type_select_box").html();
     $("#product_size_add_more").click(function(){
            var size_div_id = "size"+product_size_add_more_count;
            var size_html = '<div class="form-group" id="'+size_div_id+'">'+
                  '<label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">'+
                  '</label>'+
                  '<div class="col-md-2 col-sm-2 col-xs-12">'+
                    '<input type="text" id="composition" name="product_size[]" required="required" class="form-control col-md-7 col-xs-12" placeholder="Enter Size">'+
                  '</div>'+
                  '<div class="col-12 col-md-2 col-sm-2" id="size_type_select_box">'+
                            size_type_select_box                             
                    +
                   '</div>'+
                   '<div class="col-md-2 col-sm-2 col-xs-12">'+
                    '<input type="text" id="composition" name="product_rate[]" required="required" class="form-control col-md-7 col-xs-12" placeholder="Enter Price">'+
                  '</div>'+
                  '<div class="col-md-2 col-sm-2 col-xs-12">'+
                    '<input type="text"  name="product_stock[]" required="required" class="form-control col-md-7 col-xs-12" placeholder="Enter Stock">'+
                  '</div>'+
                  '<br><br>'+
                  '<label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">        </label>'+

                  '<div class="col-md-2 col-sm-2 col-xs-12">'+
                    '<input type="text" id="composition" name="min_order[]" required="required" class="form-control col-md-7 col-xs-12" placeholder="Enter Min Order Qtty">'+
                  '</div>'+

                  '<div class="col-12 col-md-2 col-sm-2">'+
                    qtty_type_select_box+
                   '</div>'+
                    '<div class="col-12 col-md-2 col-sm-2"></div>'+
                   '<div class="col-12 col-md-2"><button type="button" class="btn btn-link" class="form-control" onclick="removeDiv(this.id)" id="'+size_div_id+'"><i class="fa fa-link"></i>&nbsp;Remove</button></div>'+

                '</div>';
            // var product_image_add_more = "<div class='row form-group' id = '"+image_id+"'><div class='col col-md-3'><label for='product_image' class=' form-control-label'> </label></div>"+
            //           "<div class='col-12 col-md-7' id = '"+image_id+"' onclick='getImageBoxId(this.id)'><input type='file' id = 'input"+image_id+"' name='product_image[]'  class='form-control' onChange='validate(this.value)'></div>"+
            //            "<div class='col-12 col-md-2'><button type='button' class='btn btn-link'  class='form-control' id='"+image_id+"' onclick='removeImageDiv(this.id)'><i class='fa fa-link'></i>&nbsp;Remove</button></div></div>";

           $("#more_sizes").append(size_html);
           product_size_add_more_count = product_size_add_more_count+1;
        
    });


     function removeDiv(elem) {
         // alert(elem);
         $("#"+elem).remove();
    }
</script>

<script type="text/javascript">
 function fileTest(input) {
    readURL(input);
    validateFile();
  }
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

  function validateFile(input) {
    $("#file_error").html("");
    $(".demoInputBox").css("border-color","#F0F0F0");
    var file_size = $('#file')[0].files[0].size;
    if(file_size>2097152) {
      $("#file_error").html("<b style='color:red'>File size is greater than 1.5 MB</b>");
      $(".demoInputBox").css("border-color","#FF0000");
      $('#file').val('');
      return false;
    } 
    return true;
  }
</script>


<script type="text/javascript">
  $(document).ready(function(){
    $("#category").change(function(){
      var cat_id = $("#category").val();

       $.ajax({
        type: "POST",
        url: "php/ajax/fetch_sub_cat.php",
        data:{ cat_id : cat_id,},
          success: function(data){
              console.log(data);
              if (data != "2") {
                $("#sub_category").html(data);
              }
               
          }
        });
    })
  })
</script>