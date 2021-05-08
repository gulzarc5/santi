<?php
  include "include/header.php";

  function showMessage($msg){
 
    if ($msg == 1) {
      print "<p class='alert alert-success'>Product Added Successfully</p>";
    }elseif ($msg == 2) {
      print "<p class='alert alert-danger'>Something Wrong Please Try Again</p>";
    }elseif ($msg == 3) {
      print "<p class='alert alert-danger'>Sorry Product Does Not Exist</p>";
    }elseif ($msg == 4) {
      print "<p class='alert alert-danger'>Sorry Product Stock Does Not Available</p>";
    }elseif ($msg == 5) {
      print "<p class='alert alert-danger'>Product Already Added In The List</p>";
    }elseif ($msg == 6) {
      print "<p class='alert alert-danger'>Sorry User Not Found</p>";
    }elseif ($msg == 7) {
      print "<p class='alert alert-success'>Order Placed Successfully</p>";
    }elseif ($msg == 8) {
      print "<p class='alert alert-danger'>Please Add Product Before Order</p>";
    }elseif ($msg == 9) {
      print "<p class='alert alert-success'>Service Charge Added Successfully</p>";
    }

  }
?>      

<div class="right_col" role="main">
  <div class="clearfix"></div>
  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel">
        <div class="x_title">
          <h2>Make New Invoice</h2>
          <div class="clearfix"></div>
           <?php 
            if (isset($_GET['msg'])) {
              showMessage($_GET['msg']);
            }           
          ?>
        </div>
        <div class="x_content"><br />
            <div class="col-md-6">
              <form action="php/invoice/add_product.php" method="post" class="form-horizontal form-label-left">  
                <?php
                  if (isset($_SESSION['invoice_user']) && !empty($_SESSION['invoice_user'])) {
                    $search_key = $_SESSION['invoice_user'];
                    if(is_numeric($search_key)){
                      $sql = "SELECT `users`.*,`wallet`.`total_amount` as `amount` FROM `users` INNER JOIN `wallet` ON `wallet`.`user_id` = `users`.`id` WHERE `users`.`mobile` = '$search_key'";
                    }else{
                      $sql = "SELECT `users`.*,`wallet`.`total_amount` as `amount` FROM `users` INNER JOIN `wallet` ON `wallet`.`user_id` = `users`.`id` WHERE `users`.`email` = '$search_key'";
                    }
                      if ($res_sql = $connection->query($sql)) {
                        if ($res_sql->num_rows > 0) {
                          $row = $res_sql->fetch_assoc();
                ?>
                  <div class="form-group">
                      <label class="control-label" for="name">Enter Customer Mobile Number/Email :<span class="required">*</span>
                      </label>
                      <input type="text" name="user_data" required="required" class="form-control col-md-7 col-xs-12" placeholder="Enter Customer Mobile Number/Email"  id="user_data" disabled value="<?=$_SESSION['invoice_user']?>">
                      <br><span id="user_error"></span>
                  </div>
                  
                <?php
                        }
                      }
                  } else {
                ?>
                  <div class="form-group">
                      <label class="control-label" for="name">Enter Customer Mobile Number/Email :<span class="required">*</span>
                      </label>
                      <input type="text" name="user_data" required="required" class="form-control col-md-7 col-xs-12" placeholder="Enter Customer Mobile Number/Email" onblur="userSearch();" id="user_data">
                      <br><span id="user_error"></span>
                      <br><span id="loader_customer" style="display: flex;"></span>
                  </div>
                  <div class="form-group" id="wallet_pay_div">
                  </div>
                <?php  } ?>

                <div class="form-group">
                  <label for="email" class="control-label">Enter Product Barcode :</label>
                  <input  class="form-control" type="number" name="bar_code" id="barcode" required autofocus="" onblur="productSearch();">
                  <br><span id="product_error"></span>                
                  <br><span id="loader_product" style="display: flex;"></span>
                </div>

                <div class="form-group">
                  <label for="email" class="control-label">Enter Quantity :</label>
                  <input  class="form-control" type="number" name="quantity" required >
                </div>

                <div class="form-group">
                    <input type="submit" class="btn btn-success" name="submit" value="Add Product">
                    <a href="php/invoice/clear_invoice.php" class="btn btn-danger">Clear Invoice</a>

                </div> 
              </form>             
            </div>
            
          
                  
            <div class="col-md-6">
            <div class="col-md-12" id="user_info">
              <?php
                if (isset($row) && !empty($row)) {
                  print '<h4>User Info</h4>
                  <div class="col-md-6">     
                    <b>Name : </b> '.$row['name'].'
                  </div>
                  <div class="col-md-6">     
                    <b>Mobile : </b> '.$row['mobile'].'
                    </div>      
                  <div class="col-md-6">     
                    <b>Free Shopping Balance : </b> '.$row['amount'].'
                  </div> ';
                }
              ?>
            </div>

            <div class="col-md-12" id="product_info">
              
            </div>
          </div>

        </div>
      </div>
    </div>

    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_content table-responsive">
        <table class="table table-striped jambo_table bulk_action" cellspacing="0" width="100%">
          <thead>
            <tr>
              <th>Sl</th>
              <th>Product Name</th>
              <th>Sale Price</th>
              <th>Quantity</th>
              <th>Save</th>
              <th>Amount</th>              
              <th style="width: 106px">Action</th>
            </tr>
          </thead>
                        
          <tbody>
            <?php
            $employee_id = $_SESSION['admin_user_id'];
              $sql_user_order = "SELECT `product`.*,`temp_invoice`.`quantity` as quantity_o,`temp_invoice`.`id` as inv_id  FROM `temp_invoice` INNER JOIN `product` ON `product`.`id` = `temp_invoice`.`p_id` WHERE `temp_invoice`.`employee_id`= '$employee_id'";
             
              if ($res_user_order = $connection->query($sql_user_order)) {
                if ($res_user_order->num_rows > 0) {
                  $count =1;
                  $total_cashback = 0;
                  $total_amount = 0;
                  $total_save_amount=0;
                  $discount = 0;
                   while($user_order_row = $res_user_order->fetch_assoc()){                 
                    print "<tr>
                    <td>$count</td>
                    <td>$user_order_row[name]<span style='display:block;'>MRP : $user_order_row[mrp]</span></td>
                    <td>".$user_order_row['price']."</td>
                    <td>".$user_order_row['quantity_o']."</td>
                    <td>".number_format(($user_order_row['mrp']-$user_order_row['price'])*$user_order_row['quantity_o'],2)."</td>
                   
                    <td>".number_format($user_order_row['price']*$user_order_row['quantity_o'],2)."</td>
                    <td><a href='php/invoice/remove_item.php?inv_id=".$user_order_row['inv_id']."' class='btn btn-sm btn-danger'>Remove</a></td>
                    </tr>";
                    $count++;
                    $total_cashback += ($user_order_row['cash_back']*$user_order_row['quantity_o']);
                    $total_amount += ($user_order_row['price']*$user_order_row['quantity_o']);
                    $total_save_amount +=number_format(($user_order_row['mrp']-$user_order_row['price'])*$user_order_row['quantity_o'],2);
                  }

                  $wallet_total_amount =0;
                    if (isset($row['id'])) {
                      $user_wallet_sql = "SELECT * FROM `wallet` WHERE `user_id`='$row[id]'";
                      if ($res_user_wallet = $connection->query($user_wallet_sql)) {
                          $row_user_wallet = $res_user_wallet->fetch_assoc();
                          $wallet_total_amount = $row_user_wallet['total_amount'];
                      }
                    }  

                  $user_credit_amount = 0;
                  if (isset($row['id'])) {
                    $user_credit_sql = "SELECT * FROM `user_credit` WHERE `user_id`='$row[id]'";
                    if ($res_user_credit = $connection->query($user_credit_sql)) {
                        $row_user_credit = $res_user_credit->fetch_assoc();
                        $user_credit_amount = $row_user_credit['amount'];
                      }
                  }  

                 
                  print "<form method='POST' action='php/invoice/order_place.php'>
                        <tr>
                          <td colspan='4' align='right'>Total- </td>
                          <td>".number_format($total_save_amount,2,'.', '')."</td>
                          <td>".number_format($total_amount,2,'.', '')."</td>
                        </tr>
                        <tr>
                          <td colspan='5' align='right'>Free Shopping- </td>
                          <td>";
                          $net_total = 0;
                          if ($wallet_total_amount > $total_amount) {
                            print number_format($total_amount,2,'.', '');
                            $net_total = 0;
                          } else {
                            print number_format($wallet_total_amount,2,'.', '');
                            $net_total = ($total_amount-$wallet_total_amount);
                          }
                          
                          print"</td>
                        </tr>
                        <tr>
                          <td colspan='5' align='right'>Net Total- </td>
                          <td>".number_format(($net_total),2,'.', '')."</td>
                        </tr>
                        <tr>
                          <td colspan='5' align='right'>Previous Balance- </td>
                          <td>".number_format($user_credit_amount ,2,'.', '')."</td>
                        </tr>
                        <tr>
                          <td colspan='5' align='right'>Payment Amount- </td>
                          <td id='pay_val'>".number_format(($net_total+$user_credit_amount),2,'.', '')."</td>
                        </tr>";
                          $net_total = ($net_total+$user_credit_amount);
                        print"<tr>
                          <td colspan='5' align='right'>Service Charge- </td>
                          <td><input type='number' step='.01'name='ser_charge' id='ser_charge' value='0' min='0'></td>
                        </tr>
                        <tr>
                          <td colspan='5' align='right'>Gross Amount- </td>
                          <td id='groce_val'>".number_format($net_total,2,'.', '')."</td>
                        </tr>;
                        <tr>
                          <td colspan='5' align='right'>Cash Payment- </td>
                          <td id='cash_val'>
                            <input type='number' step='.01' name='cash' id='cash_change' value='0' min='0'></td>
                        </tr>;
                        <tr>
                          <td colspan='5' align='right'>Balance- </td>
                          <td id='bal'>".number_format($net_total,2,'.', '')."</td>
                        </tr>";
                  
                  print '<tr>
                          <td align="center" colspan="7">
                            <input type="submit" class="btn btn-info" value="Place Order">
                          </td>
                        </tr> 
                        </form>';
                }else{
                   print '<tr>
                          <td align="center" colspan="6">
                            No Product Added
                          </td>
                        </tr> 
                        </form>';
                }
              }
            ?>   
                            
          </tbody>
        </table>
        <div id="thanks_msg"></div>
      </div>


    </div>
  </div>
</div>
<?php
include "include/footer.php";
?>

<script type="text/javascript">
  function userSearch() {
    var search_key = $("#user_data").val();

    if (search_key) {
      $.ajax({
          type: "POST",
          url: "php/ajax/invoice/user_search.php",
          data:{ search_key : search_key,},
          beforeSend: function() {
              // setting a timeout
              $("#loader_customer").html('<i class="fa fa-circle-o-notch fa-spin" style="font-size: 30px;color: #00dcff;text-align: center;margin-top: -18px;"></i>');
          },
          success: function(data){
            
            $("#loader_customer").html('');
            if (data == '2' || data == '3') {
              if(data == "2"){              
                $("#user_error").html('<b style="color:red">Something Went Wrong Please Try Again</b>');
                $("#user_data").val('');
              }else if(data == "3"){              
                $("#user_error").html('<b style="color:red">User Not Found Please Register This User First</b>');
                $("#user_data").val('');
              }
            }else{
              console.log(data);
              $("#user_info").html(data.data);
            }               
          }
      });
    }
  }

  function productSearch() {
    var barcode = $("#barcode").val();

    if (barcode) {
      $.ajax({
          type: "POST",
          url: "php/ajax/invoice/product_search.php",
          data:{ search_key : barcode,},      
          beforeSend: function() {
              // setting a timeout
              $("#loader_product").html('<i class="fa fa-circle-o-notch fa-spin" style="font-size: 30px;color: #00dcff;text-align: center;margin-top: -18px;"></i>');
          },
          success: function(data){
            $("#loader_product").html('');
            if (data != "2" && data != "3") {
              $("#product_info").html(data);
              $("#product_error").html('');
            }else if(data == "2"){              
              $("#product_error").html('<b style="color:red">Something Went Wrong Please Try Again</b>');
              $("#product_info").html('');
              $("#search_key").val('');
            }else if(data == "3"){              
              $("#product_error").html('<b style="color:red">Product Not Found </b>');
              $("#search_key").val('');
              $("#product_info").html('');
            }              
          }
      });
    }
  }

  $('#ser_charge').change(function(){
    var ser_value = $(this).val();
    var pay_val = $('#pay_val').html();
    
    var groce_val = parseFloat(pay_val)+parseFloat(ser_value);
    $('#groce_val').html(groce_val.toFixed(2));
    
    $('#cash_change').val('0');
    $('#bal').html(groce_val.toFixed(2));
  });

  $('#cash_change').change(function(){
    var cash_value = parseFloat($(this).val());
    var groce_val = parseFloat($('#groce_val').html());
    if (cash_value > groce_val) {
      $(this).val('');
      alert('Cash Amount can Not Be Greater Then Gross Value');
    }else{
      var bal = parseFloat(groce_val)-parseFloat(cash_value);
      $('#bal').html(bal.toFixed(2));
    }
   
  });
</script>