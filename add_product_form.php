Purchase <?php
  include "include/header.php";

  function showMessage($msg){
    if ($msg == 1) {
      print "<p class='alert alert-success'>Product Added Successfully</p>";
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
<style>
.required{
  color:red;
}
</style>
<div class="right_col" role="main">
  <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>Add New Product</h2>
            <div class="clearfix"></div>
            <?php 
              if (isset($_GET['msg'])) {
                showMessage($_GET['msg']);
              }           
            ?>
          </div>
          <div class="x_content"><br />
            <form action="php/product/add_product.php" method="post" class="form-horizontal form-label-left" enctype="multipart/form-data" onsubmit="return validate();">
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="product_name">Enter Bar Code Number / Scan Barcode if Available
                </label>
                <div class="col-md-8 col-sm-8 col-xs-12">
                  <input type="text" placeholder="Enter Bar Code" class="form-control col-md-7 col-xs-12" name="bar_code" id="bar_code" onblur="checkBarcode();">
                  <span id="bar_code_msg"></span>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="product_name">Product Name <span class="required">*</span>
                </label>
                <div class="col-md-8 col-sm-8 col-xs-12">
                  <input type="text" placeholder="Enter Product Name" required="required" class="form-control col-md-7 col-xs-12" name="name">
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
                        print '<option value="'.$cat_row['id'].'">'.$cat_row['name'].'</option>';
                      }
                    }
                    ?>
                  </select>
                  
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="composition">Sub Category<!-- <span class="required">*</span> -->
                </label>
                <div class="col-md-8 col-sm-8 col-xs-12">
                  <select name="sub_category" class="form-control col-md-7 col-xs-12" id="sub_category">
                    <option value="" selected>Please Select Sub Category</option>
                  </select>
                  
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="description">Product Description
                </label>
                <div class="col-md-8 col-sm-8 col-xs-12">
                  <textarea placeholder="Enter Product Description" name="description" class="form-control col-md-7 col-xs-12"></textarea>
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="description">HSN / SAC Code
                </label>
                <div class="col-md-8 col-sm-8 col-xs-12">
                  <input type="text"  name="hsn_code" placeholder="Enter HSN / SAC Code"  class="form-control col-md-7 col-xs-12">
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="description">Purchase Cost <span class="required">*</span>
                </label>
                <div class="col-md-8 col-sm-8 col-xs-12">
                  <input type="number" step="any"  name="cost" placeholder="Enter Purchase Cost"  class="form-control col-md-7 col-xs-12" required>
                </div>
              </div>

		          <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="price">M.R.P. <span class="required">*</span>
                </label>
                <div class="col-md-8 col-sm-8 col-xs-12">
                  <input type="number" step="any"  name="mrp" placeholder="Enter Product MRP" class="form-control col-md-7 col-xs-12" required>
                </div>
              </div>
              
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="price">Price <span class="required">*</span>
                </label>
                <div class="col-md-8 col-sm-8 col-xs-12">
                  <input type="number" step="any" placeholder="Enter Sale Price"  name="price"  class="form-control col-md-7 col-xs-12" required>
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="description">CGST
                </label>
                <div class="col-md-4 col-sm-4 col-xs-12">
                  <input type="number" step="any"  name="cgst" placeholder="Enter CGST Amount"  class="form-control col-md-7 col-xs-12">
                </div>

                <div class="col-md-4 col-sm-4 col-xs-12">
                  <input type="number" step="any"  name="cgst_percent" placeholder="Enter CGST In %"  class="form-control col-md-7 col-xs-12">
                </div>

              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="description">SGST
                </label>
                <div class="col-md-4 col-sm-4 col-xs-12">
                  <input type="number" step="any"  name="sgst" placeholder="Enter SGST"  class="form-control col-md-7 col-xs-12">
                </div>

                <div class="col-md-4 col-sm-4 col-xs-12">
                  <input type="number" step="any"  name="sgst_percent" placeholder="Enter SGST In %"  class="form-control col-md-7 col-xs-12">
                </div>

              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="description">Cashback
                </label>
                <div class="col-md-8 col-sm-8 col-xs-12">
                  <input type="number" step="any" placeholder="Enter Cash Back"  name="cash_back"  class="form-control col-md-7 col-xs-12">
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="description">Promotional Bonus
                </label>
                <div class="col-md-8 col-sm-8 col-xs-12">
                  <input type="number" step="any" placeholder="Enter Promotional Bonus"  name="promotional_bonus"  class="form-control col-md-7 col-xs-12">
                </div>
              </div>

               <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="stock">Stock</label>
                <div class="col-md-8 col-sm-8 col-xs-12">
                  <input type="number" placeholder="Enter Stock"  name="stock" class="form-control col-md-7 col-xs-12">
                </div>
              </div>


               <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="expiry_date">Expiry Date</label>
                <div class="col-md-8 col-sm-8 col-xs-12">
                  <input type="date"   name="expiry_date" class="form-control col-md-7 col-xs-12">
                </div>
              </div>

              <div class="form-group">
                <label for="star" class="control-label col-md-3 col-sm-3 col-xs-12">Star Product</label>
                <div class="col-md-8 col-sm-8 col-xs-12">
                  Yes:
                  <input type="radio" class="flat" name="star" value="2" checked="" /> No:
                  <input type="radio" class="flat" name="star" value="1" />
                </div>
              </div> 

             <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="image">Product Image <span class="required">*</span></label>
                <div class="col-md-5 col-sm-5 col-xs-12">
                  <input type="file"  name="image" class="form-control col-md-5 col-xs-12 demoInputBox" id="file"  onchange="fileTest(this);" required><span id="file_error"></span><br><span>Please Upload Image Less Then 1.5 MB</span>
                </div>
                <div  class="col-md-12 col-sm-12 col-xs-12">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">
                </label>
                  <img src="" id="preview" style="padding-left: 5px">
                </div>
              </div>
              <div class="ln_solid"></div>
                <div class="form-group">
                  <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <button type="submit" name="add_product" value="add_product" class="btn btn-success">Submit</button>
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

<script>
  function checkBarcode() {
    var code = $("#bar_code").val();
    if (code) {
      if (code.length == 13) {
        $("#bar_code_msg").html('');
        $.ajax({
            type: "POST",
            url: "php/ajax/check_bar_code.php",
            data:{ code : code,},
              success: function(data){
                  console.log(data);
                  if (data != "1") {
                    $("#bar_code_msg").html('<b style="color:red">Bar Code Already Exist Please Choose Another Bar Code</b>');
                    $("#bar_code").val('');
                  }
                   
              }
        });
      }else{
        $("#bar_code_msg").html('<b style="color:red">Bar Code Digit Must Be 13 Digit</b>');
        $("#bar_code").val('');
      }
    }    
  }
  function validate() {
   // check if input is bigger than 3
   var value = document.getElementById('bar_code').value;
   if (value) {
       alert(value.length);
    if (value.length == 13) {
       return true;
      $("#bar_code_msg").html('df'); 
     }else{    
      $("#bar_code_msg").html('<b style="color:red">Bar Code Digit Must Be 13 Digit</b>');
       return false; // keep form from submitting
     }
   }else{
      $("#bar_code_msg").html('g');
   }
 
  }
</script>