<?php
  include "include/header.php";

  function showMessage($msg){
 
    if ($msg == 1) {
      print "<p class='alert alert-danger'>Email Id Used By Another User</p>";
    }
    if ($msg == 2) {
      print "<p class='alert alert-danger'>Something Wrong Please Try Again</p>";
    }
    if ($msg == 3) {
      print "<p class='alert alert-danger'>Mobile Number Used By Another User</p>";
    }
     
  }
?>      

<div class="right_col" role="main">
  <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>Edit User</h2>
            <div class="clearfix"></div>
             <?php 
              if (isset($_GET['msg'])) {
                showMessage($_GET['msg']);
              }           
            ?>
          </div>
          <div class="x_content"><br />
            <?php
            if (isset($_GET['u_id'])) {
              $user_id = $connection->real_escape_string(mysql_entities_fix_string($_GET['u_id'] ));
              $user_sql = "SELECT * FROM `users` WHERE `id`='$user_id'";
              if ($user_res = $connection->query($user_sql)) {
                $user_row = $user_res->fetch_assoc();
              
            
            ?>
            <form action="php/users/update_user.php" method="post" class="form-horizontal form-label-left">
              <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Name :<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" name="name" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $user_row['name']; ?>">
                </div>
              </div>
          <!--     <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Name <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" id="name" name="last-name" required="required" class="form-control col-md-7 col-xs-12">
                </div>
              </div> -->
              <div class="form-group">
                <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Email :</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input  class="form-control col-md-7 col-xs-12" type="email" name="email" required value="<?php echo $user_row['email']; ?>">
                </div>
              </div>
              <?php
                $user_parmanent = "SELECT * FROM `parmanent_address` WHERE `user_id`='$user_row[id]'";
                if ($res_parmanent = $connection->query($user_parmanent)) {

                  $row_parmanent = $res_parmanent->fetch_assoc();
                }
              ?>
              <div class="form-group">
                <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">State :</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input  class="form-control col-md-7 col-xs-12" type="text" name="state" required value="<?php echo $row_parmanent['state']; ?>">
                </div>
              </div>

              <div class="form-group">
                <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">City :</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input  class="form-control col-md-7 col-xs-12" type="test" name="city" required value="<?php echo $row_parmanent['city']; ?>">
                </div>
              </div>

              <div class="form-group">
                <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Address :</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <textarea name="address" class="form-control col-md-7 col-xs-12"><?php echo $row_parmanent['location']; ?></textarea>
                </div>
              </div>

              <div class="form-group">
                <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Pin :</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input  class="form-control col-md-7 col-xs-12" type="text" name="pin" value="<?php echo $row_parmanent['pin']; ?>">
                </div>
              </div>

              <div class="form-group">
                <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Mobile No :</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input  class="form-control col-md-7 col-xs-12" type="text" name="mobile" required value="<?php echo $user_row['mobile']; ?>">
                </div>
              </div>

              <div class="ln_solid"></div>
                <div class="form-group">
                  <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <input type="submit" class="btn btn-success" name="submit" value="Submit">
                    <a href="user_list.php" class="btn btn-warning">Back</a>
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
