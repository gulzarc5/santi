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
                    $sql = "SELECT * FROM `users` WHERE `mobile` = '$search_key'";
                  }else{
                    $sql = "SELECT * FROM `users` WHERE `email` = '$search_key'";
                  }
                    if ($res_sql = $connection->query($sql)) {
                      if ($res_sql->num_rows > 0) {
                        $row = $res_sql->fetch_assoc();
              ?>
                <div class="form-group">
                    <label class="control-label" for="name">Enter Customer Mobile Number/Email :<span class="required">*</span>
                    </label>
                    <input type="text" name="user_data" required="required" class="form-control col-md-7 col-xs-12" placeholder="Enter Customer Mobile Number/Email" onblur="userSearch();" id="user_data" disabled value="<?=$_SESSION['invoice_user']?>">
                    <br><span id="user_error"></span>
                </div>
                <?php if ($row['is_star'] == '2' && isset($_SESSION['is_wallet']) && !empty($_SESSION['is_wallet'])) { ?>
                  <div class="form-group" id="wallet_pay_div">
                    <label class="control-label" for="name" style="padding-right: 28px;">Use Wallet Balance :</label>
                    <?php 
                      if ($_SESSION['is_wallet'] == '1'){
                    ?>
                      Yes <input type="radio" name="is_wallet" value="1" checked="">
                      No <input type="radio" name="is_wallet" value="2" >
                    <?php
                      }else{
                    ?>
                      Yes <input type="radio" name="is_wallet" value="1">
                      No <input type="radio" name="is_wallet" value="2" checked="">
                    <?php
                      }
                     ?>
                   
                  </div>
                <?php } ?>
                 
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
                  if ($row['is_star'] == '1') {
                    print '<h4>User Info</h4>
                          <div class="col-md-6">     
                            <b>Name : </b> '.$row['name'].'
                          </div>
                          <div class="col-md-6">     
                            <b>Mobile : </b> '.$row['mobile'].'
                            </div>      
                          <div class="col-md-6">     
                            <b>Is Star : </b> No 
                          </div> ';
                         
                  } else {
                    $sql_wallet = "SELECT * FROM `wallet` WHERE `user_id`='$row[id]'";
                    $balance = 0;
                    if ($res_wallet = $connection->query($sql_wallet)) {
                      $row_wallet = $res_wallet->fetch_assoc();
                      $balance = $row_wallet['amount'];
                    }
                    print '<h4>User Info</h4>
                          <div class="col-md-6">     
                            <b>Name : </b> '.$row['name'].'
                          </div>
                          <div class="col-md-6">     
                            <b>Mobile : </b> '.$row['mobile'].'
                            </div>      
                          <div class="col-md-6">     
                            <b>Is Star : </b> Yes 
                          </div> 
                          <div class="col-md-6">                
                            <b>Wallet : </b> '.$balance.'
                          </div>';
                  }
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
              <th>Quantity</th>
              <th>Rate</th>
              <th>Total</th>              
              <th style="width: 106px">Action</th>
            </tr>
          </thead>
                        
          <tbody>
            <?php
              $sql_user_order = "SELECT `product`.*,`temp_invoice`.`quantity` as quantity_o,`temp_invoice`.`id` as inv_id  FROM `temp_invoice` INNER JOIN `product` ON `product`.`barcode` = `temp_invoice`.`bar_code` ";
              if ($res_user_order = $connection->query($sql_user_order)) {
                if ($res_user_order->num_rows > 0) {
                  $count =1;
                  $total_cashback = 0;
                  $total_amount = 0;
                  $discount = 0;
                   while($user_order_row = $res_user_order->fetch_assoc()){                 
                    print "<tr>
                    <td>$count</td>
                    <td>$user_order_row[name]</td>
                    <td>".$user_order_row['quantity_o']."</td>
                    <td>$user_order_row[price]</td>
                    <td>".number_format($user_order_row['price']*$user_order_row['quantity_o'],2)."</td>
                    <td><a href='php/invoice/remove_item.php?inv_id=".$user_order_row['inv_id']."' class='btn btn-sm btn-danger'>Remove</a></td>
                    </tr>";
                    $count++;
                    $total_cashback += ($user_order_row['cash_back']*$user_order_row['quantity_o']);
                    $total_amount += ($user_order_row['price']*$user_order_row['quantity_o']);
                  }

                  $wallet_deduct = 0;
                  if (isset($_SESSION['is_wallet']) && !empty($_SESSION['is_wallet'])  && $_SESSION['is_wallet'] == '1'){
                    if (isset($row['id'])) {
                      $user_wallet_sql = "SELECT * FROM `wallet` WHERE `user_id`='$row[id]'";
                      if ($res_user_wallet = $connection->query($user_wallet_sql)) {
                          $row_user_wallet = $res_user_wallet->fetch_assoc();
                          $wallet_deduct = $row_user_wallet['amount'];
                      }
                    }  
                  }
                  print "<tr>
                          <td colspan='4' align='right'>Total : </td>
                          <td>".number_format($total_amount,2)."</td>
                        </tr>
                        <tr>
                          <td colspan='4' align='right' >Wallet Pay : </td>
                          <td>";
                          if ($wallet_deduct > 0) {
                            $payable = $total_amount;
                            if ($payable < $wallet_deduct ) {
                              print number_format($payable,2);
                            } else {
                              print number_format($wallet_deduct,2);
                            }
                            
                          } else {
                            print "0.00";
                          }
                          
                  print "</td>
                        </tr>";
                  print "<tr>
                          <td colspan='4' align='right' >Net Payable Amount : </td>
                          <td>";
                          if ($wallet_deduct > 0) {
                            $payable = ($total_amount);
                            if ($payable < $wallet_deduct ) {
                              print number_format(0,2);
                            } else {
                              print number_format(($payable-$wallet_deduct),2);
                            }
                            
                          } else {
                           print number_format($total_amount,2);
                          }
                    print "</td>
                        </tr>
                        <tr>
                          <td colspan='4' align='right' >Cashback : </td>
                          <td>".number_format($total_cashback,2)."</td>
                        </tr>";
                  print '<tr>
                          <td align="center" colspan="7">
                            <a href="php/invoice/order_place.php" class="btn btn-info" >Place Order</a>
                          </td>
                        </tr> ';
                }else{
                   print '<tr>
                          <td align="center" colspan="6">
                            No Product Added
                          </td>
                        </tr> ';
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
            if (data != "2" && data != "3" && data != "4") {
              if (data.status == '1') {
                 $("#user_info").html(data.html);
              }else{
                 $("#user_info").html(data.html);
                 $("#wallet_pay_div").html('<label class="control-label" for="name" style="padding-right: 28px;">Use Wallet Balance :</label>Yes <input type="radio" name="is_wallet" value="1">No <input type="radio" name="is_wallet" value="2" checked="">');
              }
             
              $("#user_error").html('');
            }else if(data == "2"){              
              $("#user_error").html('<b style="color:red">Something Went Wrong Please Try Again</b>');
              $("#user_data").val('');
            }else if(data == "3"){              
              $("#user_error").html('<b style="color:red">User Not Found Please Register This User First</b>');
              $("#user_data").val('');
            }else if(data == "4"){              
              $("#user_error").html('<b style="color:red">Sorry The User Is Disabled Please Enable This User First</b>');
              $("#user_data").val('');
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
</script>