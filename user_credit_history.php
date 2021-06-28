<?php
require_once "include/header.php";

function showMessage($msg){
    if ($msg == 3) {
      print "<p class='alert alert-success'>Batch Updated Successfully</p>";
    }
    if ($msg == 4) {
      print "<p class='alert alert-danger'>Something Wrong Please Try Again</p>";
    }
    if ($msg == 1) {
      print "<p class='alert alert-success'>User Updated Successfully</p>";
    }
    if ($msg == 2) {
      print "<p class='alert alert-danger'>Something Wrong Please Try Again</p>";
    }
    if ($msg == 5) {
      print "<p class='alert alert-success'>Offer Set Successfully</p>";
    }
  }
?>
<div class="clearfix"></div>
<div class="right_col" role="main">
	<div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
           <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Credit History<small></small></h2>
                    <div class="clearfix"></div>
                      <?php 
                        if (isset($_GET['msg'])) {
                          showMessage($_GET['msg']);
                        }           
                      ?>
                  </div>
                  <div class="x_content">
          
                    <table id="users" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                      <thead>
                        <tr>
                          <th>Sl</th>
                          <th>Amount</th> 
                          <th>Transaction Type</th> 
                          <th>Balance</th>                        
                          <th>Date</th>
                        </tr>
                      </thead>
                      <tbody>                        
                        <?php        
                          if (isset($_GET['u_id']) && !empty($_GET['u_id'])) {
                          $u_id = $_GET['u_id'];          
                          
                          $sql_credit = "SELECT * FROM `user_credit_details` WHERE `user_id`=$u_id ORDER BY `id` DESC" ;
                          if ($sql_credit_result = $connection->query($sql_credit)) {
                            if ($sql_credit_result->num_rows > 0) {
                              $cnt = 1;
                              while($sql_credit_row = $sql_credit_result->fetch_assoc()){
                                $date = date('F d, Y h:mA', strtotime($sql_credit_row['date']));
                                print "<tr>
                                        <td>$cnt</td>
                                        <td>$sql_credit_row[amount]</td>";
                                if ($sql_credit_row['type'] == '1') {
                                  print "<td><button type='button' class='btn btn-warning'>Purchased</button></td>";
                                } else {
                                  print "<td><button type='button' class='btn btn-primary'>Paid</button></td>";
                                }                                
                                print"<td>$sql_credit_row[total_amount]</td>
                                  <td>$date</td>
                                  </tr>";                                  
                                $cnt++;
                              }
                            }else{
                              print "<tr>
                              <td colspan='5' align='center'>No Data Found</td></tr>";
                            }
                          }
                        }
                        ?>
                        </tr>                       
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
        </div>
    </div>
</div>








<?php
require_once "include/footer.php";
?>

