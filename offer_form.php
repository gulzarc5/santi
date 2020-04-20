<?php
  include "include/header.php";
  function showMessage($msg){
    if ($msg == 1) {
      print "<p class='alert alert-success'>Offer Added Successfully</p>";
    }
    if ($msg == 2) {
      print "<p class='alert alert-danger'>Something Went Wrong Please Try Again</p>";
    }
    if ($msg == 3) {
      print "<p class='alert alert-danger'>Please Check Uploaded Image Size</p>";
    }
     if ($msg == 4) {
      print "<p class='alert alert-danger'>Please Check Uploaded Image Type</p>";
    }
    if ($msg == 5) {
      print "<p class='alert alert-danger'>Package Deleted Successfully</p>";
    }
     if ($msg == 6) {
      print "<p class='alert alert-danger'>Package Deleted Successfully</p>";
    }
  }
?>      

<div class="right_col" role="main">
  <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
           <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>User Business Percentage<small></small></h2>
                    <div class="clearfix"></div>
                      
                  </div>
                  <div class="x_content table-responsive">
          
                    <table class="table table-striped jambo_table bulk_action" cellspacing="0" width="100%">
                      <thead>
                        <tr>
                          <th>Sl</th>
                          <th>Offer Name</th>
                          <th>Percentage</th>
                          <th>Action</th>
                          <!-- <th>Actions</th> -->
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                         $sql_user_offer = "SELECT * FROM `offer` WHERE `status`='1' AND`offer_type`='2'";
                         if ($res_user_offer = $connection->query($sql_user_offer)) {
                          $count = 1;
                            while($user_offer_row = $res_user_offer->fetch_assoc()){
                              print "<tr>
                              <td>$count</td>
                              <td>$user_offer_row[name]</td>
                              <td>$user_offer_row[percentage] %</td>
                              <td><a class='btn btn-success' href='user_offer_edit.php?id=$user_offer_row[id]'>Edit</a></td>
                              </tr>";
                              $count++;
                            }
                         }
                        ?>                        
                      </tbody>
                    </table>
          
          
                  </div>
                </div>
              </div>
        </div>

        <div class="col-md-12 col-sm-12 col-xs-12">
           <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>User Purchase Discount<small></small></h2>
                    <div class="clearfix"></div>
                     
                  </div>
                  <div class="x_content table-responsive">
          
                    <table class="table table-striped jambo_table bulk_action" cellspacing="0" width="100%">
                      <thead>
                        <tr>
                          <th>Sl</th>
                          <th>name</th>
                          <th>Offer</th>
                          <th>Discount Percentage</th>
                          <th>Status</th>
                          <th>Action</th>
                          <!-- <th>Actions</th> -->
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                          $package_sql = "SELECT * FROM `offer` WHERE `offer_type`='1' Order By `id` DESC";
                          if ($res_package = $connection->query($package_sql)) {
                            $count = 1;
                            while ($row_package = $res_package->fetch_assoc()) {
                              print "<tr>
                              <td>$count</td>
                             
                              <td>$row_package[name]</td>
                              <td>Offer from $row_package[offer_start].00 and Above</td>
                              <td>$row_package[percentage] % </td>";
                              if ($row_package['status'] == 1) {
                                print "<td><p class='btn btn-success'>Running</p></td>";
                              }else{
                                print "<td><p class='btn btn-danger'>Stopped</p></td>";
                              }
                              print "
                              <td><a href='edit_offer_form.php?id=$row_package[id]' class='btn btn-success'>Edit</a>
                             ";

                              if ($row_package['status'] == '1') {
                                print "<a href='php/offer/update_package_status.php?id=$row_package[id]&status=2' class='btn btn-danger'>Disable</a>";
                              }else{
                                print "<a href='php/offer/update_package_status.php?id=$row_package[id]&status=1' class='btn btn-success'>Enable</a>";
                              }
                              print "</td>
                              </tr>";
                              $count++;
                            }
                          }
                        ?>                        
                      </tbody>
                    </table>
          
          
                  </div>
                </div>
              </div>
        </div>

        <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
              <div class="x_title">
                <h2>Star Product Min Purchase<small></small></h2>
                <div class="clearfix"></div>
                 
              </div>
              <div class="x_content ">
                <form action="php/offer/star_min_purchase.php" method="post">
                  <table class="table table-striped jambo_table bulk_action" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th>Sl</th>
                        <th>name</th>
                        <th>Min Purchase</th>
                        <th>Status</th>
                        <th>Action</th>
                        <!-- <th>Actions</th> -->
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                        $package_sql = "SELECT * FROM `star_pro_min_purchase_limit` WHERE `id`='1'";
                        if ($res_package = $connection->query($package_sql)) {
                          $row_star = $res_package->fetch_assoc();
                            print "<tr>
                            <td>1</td>
                           
                            <td>Star Product</td>
                            <td>
                              <b id='star_input_div' style='display:none;'>
                                <input type='number' name='star_input' value='$row_star[purchase_limit]' class='form-control'>
                              </b>
                              <b id='star_div'>$row_star[purchase_limit]</b>
                            </td>
                            <td><p class='btn btn-success'>Running</p></td>
                            <td id='star_action'>
                                <button type='button' class='btn btn-warning' onclick='starEdit()'>Edit</a>
                            </td>
                            </tr>";
                          }
                        ?>                        
                    </tbody>
                  </table>
                </form>      
              </div>
            </div>
          </div>
        </div>
      </div>
</div>
<?php
include "include/footer.php";
?>

<script type="text/javascript">
  function starEdit(){
    $("#star_div").hide();
    $("#star_input_div").show();
    $("#star_action").html("<button type='submit' name='star' value='star' class='btn btn-success'>Save</a>");
  }
</script>