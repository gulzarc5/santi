<?php
  include "include/header.php";
  function showMessage($msg){
    if ($msg == 1) {
      print "<p class='alert alert-success'>Category Added Successfully</p>";
    }
    if ($msg == 2) {
      print "<p class='alert alert-danger'>Something Went Wrong Please Try Again</p>";
    }
  }

  function mysql_entities_fix_string($string){return htmlentities(mysql_fix_string($string));}
  function mysql_fix_string($string){
      if (get_magic_quotes_gpc()) 
          $string = stripslashes($string);
      return $string;
  }
?>      

<div class="right_col" role="main">
  <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>Set Offer Product Wise</h2>
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
                 $sql_product = "SELECT * FROM `products` WHERE `id`='$p_id'";
                 if ($res_product = $connection->query($sql_product)) {
                    $product_row = $res_product->fetch_assoc();
                
            ?>

            <form  class="form-horizontal form-label-left" action="php/product/add_product_offer.php" method="post">
              <input type="hidden" id="product_id" name="product_id" value="<?php echo $p_id; ?>">
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="p_name">Product Name <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" class="form-control col-md-7 col-xs-12" name="p_name" value="<?php echo $product_row['name']; ?>" disabled>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="p_cat">Product Category <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                 <?php 
                    $sql_cat_name = "SELECT * FROM `product_category` WHERE `id`='$product_row[category_id]'"; 
                    if($res_cat_name = $connection->query($sql_cat_name)){
                      $row_cat_name = $res_cat_name->fetch_assoc();
                      print '<input type="text" class="form-control col-md-7 col-xs-12" name="p_cat" disabled value="'.
                      $row_cat_name['name'].'">';
                    }
                  ?>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="p_comp">Product Composition <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" class="form-control col-md-7 col-xs-12" name="p_comp" disabled value="<?php echo $product_row['composition']; ?>">
                </div>
              </div>
              
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="p_comp">Select Size <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <select  class="form-control col-md-7 col-xs-12" name="size" required id="size_select_box">
                    <option value="">Please Select Size</option>
                    <?php
                    $sql_fetch_size = "SELECT `size`.`id` as size_id, `size`.`size` as size, `size_type`.`name` as size_name FROM `size` INNER JOIN `size_type` ON `size_type`.`id`=`size`.`size_type_id` WHERE `product_id`='$p_id'";
                    if ($res_fetch_size = $connection->query($sql_fetch_size)) {
                        while ($row_fetch_size = $res_fetch_size->fetch_assoc()) {
                          if (isset($_GET['size_id'])) {
                            if ($_GET['size_id'] == $row_fetch_size['size_id']) {
                              print '<option value="'.$row_fetch_size['size_id'].'" selected>'.$row_fetch_size['size'].' '.$row_fetch_size['size_name'].'</option>';
                            }else{
                              print '<option value="'.$row_fetch_size['size_id'].'">'.$row_fetch_size['size'].' '.$row_fetch_size['size_name'].'</option>';
                            }
                          }else{
                            print '<option value="'.$row_fetch_size['size_id'].'">'.$row_fetch_size['size'].' '.$row_fetch_size['size_name'].'</option>';
                          }
                          
                        }
                    }
                    ?>
                  </select>
                </div>
              </div>

              <?php
              if (isset($_GET['size_id']) && isset($_GET['p_id'])) {
                $p_id = $connection->real_escape_string(mysql_entities_fix_string($_GET['p_id']));
                $size_id = $connection->real_escape_string(mysql_entities_fix_string($_GET['size_id']));
                $sql_size = "SELECT `size`.`id` as size_id, `size`.`size` as size, `size_type`.`name` as size_name, `size`.`quantity` as min_order, `packing_type`.`name` as min_order_name, `size`.`price` as price, `size`.`stock` as stock FROM `size` INNER JOIN `size_type` ON `size_type`.`id`=`size`.`size_type_id` INNER JOIN `packing_type` ON `packing_type`.`id`= `size`.`quantity_type_id` WHERE `size`.`product_id`='$p_id' AND `size`.`id`='$size_id'";
                if ($res_size = $connection->query($sql_size)) {
                   $size_row = $res_size->fetch_assoc();
                
              ?>

               <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="p_comp">Min Order Quantity<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" class="form-control col-md-7 col-xs-12" name="p_comp" disabled value="<?php echo $size_row ['min_order'].' '.$size_row ['min_order_name']; ?>">
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="p_comp">Price<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" class="form-control col-md-7 col-xs-12" name="p_comp" disabled value="<?php echo $size_row ['price']; ?>">
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="p_comp">In Stock<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" class="form-control col-md-7 col-xs-12" name="p_comp" disabled value="<?php echo $size_row ['stock']; ?>">
                </div>
              </div>

              <?php
                }
              }
              ?>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="p_comp">Offer Type<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <select id="offer_types" class="form-control col-md-7 col-xs-12" name="offer_type" required>
                    <option value="">Please Select Offer Type</option>
                    <option value="1">Quantity</option>
                    <option value="2">Price</option>
                  </select>
                </div>
              </div>

              <div id="offer_div">
                
              </div>

              <div class="ln_solid"></div>
                <div class="form-group">
                  <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <button type="submit" class="btn btn-success">Submit</button>
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
  $(document).ready(function(){
    $("#size_select_box").change(function(){
      var size_id = $("#size_select_box").val();
      var prod_id = $("#product_id").val();
      if(size_id) {
        window.location.href = 'set_offer_product_wise.php?p_id='+prod_id+'&size_id='+size_id;
        // alert(url_size);
      }
    });


    $("#offer_types").change(function(){
      var offer_type = $("#offer_types").val();
      // alert(offer_type);
      if (offer_type) {
        if (offer_type == 1) {
          var offer_html = '<div class="form-group">'+
                '<label class="control-label col-md-3 col-sm-3 col-xs-12" for="p_comp">Buy Quantity<span class="required">*</span>'+
                '</label>'+
                '<div class="col-md-6 col-sm-6 col-xs-12">'+
                  '<input type="text" class="form-control col-md-7 col-xs-12" name="buy" required >'+
                '</div>'+
              '</div>'+

               '<div class="form-group">'+
                '<label class="control-label col-md-3 col-sm-3 col-xs-12" for="p_comp">Offer Quantity<span class="required">*</span>'+
               '</label>'+
                '<div class="col-md-6 col-sm-6 col-xs-12">'+
                  '<input type="text" class="form-control col-md-7 col-xs-12" name="offer" required>'+
                '</div>'+
              '</div>';
          $("#offer_div").html(offer_html);
        }else if (offer_type == 2) {
          var offer_html = '<div class="form-group">'+
                '<label class="control-label col-md-3 col-sm-3 col-xs-12" for="p_comp">Buy Quantity<span class="required">*</span>'+
                '</label>'+
                '<div class="col-md-6 col-sm-6 col-xs-12">'+
                  '<input type="text" class="form-control col-md-7 col-xs-12" name="buy" required >'+
                '</div>'+
              '</div>'+

               '<div class="form-group">'+
                '<label class="control-label col-md-3 col-sm-3 col-xs-12" for="p_comp">Offer Price<span class="required">*</span>'+
               '</label>'+
                '<div class="col-md-6 col-sm-6 col-xs-12">'+
                  '<input type="text" class="form-control col-md-7 col-xs-12" name="offer" required>'+
                '</div>'+
              '</div>';
          $("#offer_div").html(offer_html);
        }
      }
    })
  });
</script>