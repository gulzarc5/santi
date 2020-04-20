<?php
require_once "include/header.php";
?>

<div class="clearfix"></div>
<div class="right_col" role="main">

  <?php
   if (isset($_GET['u_id'])) {
    $u_id = $connection->real_escape_string(mysql_entities_fix_string($_GET['u_id']));     
    
  ?>

  <div class="row">
        <div class="col-md-12">
            <div class="x_panel">
                <div class="x_content">
          <section class="content invoice">
                      <!-- title row -->
                        <div class="row">
                          <div class="col-xs-12 invoice-header">
                              <h1>
                                    <i class="fa fa-globe"></i> Downline
                                    <small class="pull-right"></small>
                                </h1>
                          </div>
                          <!-- /.col -->
                        </div>
                        <!-- info row -->
                        <div class="row invoice-info">
                          <div class="col-sm-4 invoice-col">
                            
                          </div>
                        </div>
                        <!-- /.row -->
                        <hr>
                      
  
                      
                        <div class="row">
                          <div class="col-xs-12 table">
                            <h2>Shipping Address</h2>
                              <table class="table table-striped jambo_table bulk_action">
                                <thead>

                                    <tr>
                                      <th>Sl</th>
                                      <th>Id</th>
                                      <th>Name</th>
                                      <th>Email</th>
                                      <th>Mobile</th>
                                      
                                  </tr>
                                </thead>
                                <tbody>

                                  <?php 
                                  $sql_u_fetch = "SELECT * FROM `users` WHERE `parent_id`='$u_id'";
                                  if ($res_u = $connection->query($sql_u_fetch)) {
                                    $count = 1;
                                    while($user_row = $res_u->fetch_assoc()){
                                      print"<tr>
                                        <td>$count</td>
                                        <td>$user_row[id]</td>
                                        <td>$user_row[name]</td>
                                        <td>$user_row[email]</td>
                                        <td>$user_row[mobile]</td>
                                        
                                      </tr>";
                                      $count++;
                                    } 
                                  }                                
                                  ?>
                                </tbody>
                              </table>
                          </div>
                          <!-- /.col -->
                        </div>
                        <!-- /.row -->
            <!-- this row will not appear when printing -->
                        <div class="row no-print">
                          <div class="col-xs-12">
                            <a href="user_list.php" class="btn btn-primary pull-right" style="margin-right: 5px;"><i class="fa fa-download"></i> Back</a>
                          </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
    <?php
     
   }
    ?>
</div>


<?php

require_once "include/footer.php";
?>