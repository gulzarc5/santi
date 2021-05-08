<?php include("include/header.php"); ?>

<?php
function showMessage($msg){
    if ($msg == 1) {
      print "<p class='alert alert-success'>Password Changed  Successfully</p>";
    }elseif ($msg == 2) {
      print "<p class='alert alert-danger'>Something Went Wrong Please Try Again</p>";
    }elseif ($msg == 3) {
      print "<p class='alert alert-danger'>Confirm Password Does Not Matched</p>";
    }elseif ($msg == 4) {
        print "<p class='alert alert-danger'>Sorry Old Password Wrong</p>";
    }
}
?>
  <!-- Page -->
 <div class="clearfix"></div>
<div class="right_col" role="main">
	<div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
      
      <div class="col-md-6 col-lg-4">
              <!-- Example Icon Addon -->
        <div class="example-wrap">
          <h4 class="example-title">Change Password</h4>
          <?php
                if (isset($_GET['msg'])) {
                  showMessage($_GET['msg']);
                }
              ?>
         <?php
         $user_id = $_SESSION['admin_user_id'];
         $sql_admin = "SELECT * FROM `users` WHERE `id`='$user_id'";
         if($res_admin = $connection->query($sql_admin)){
             $row_admin = $res_admin->fetch_assoc();

         ?>
          
        <form action="php/admin_login_system/change_password.php" method="post">
          <div class="form-group">
            <div class="input-group input-group-icon">
              <span class="input-group-addon">
                <span class="icon wb-user" aria-hidden="true"></span>
              </span>
              <input type="text" name="email" class="form-control" placeholder="Enter Email" value="<?=$row_admin['email']?>" required>
            </div>
          </div>
          <div class="form-group">
            <div class="input-group input-group-icon">
              <span class="input-group-addon">
                <span class="icon wb-lock" aria-hidden="true"></span>
              </span>
              <input type="password" class="form-control" name="old_password" placeholder="Old Password" required>
            </div>
          </div>
           <div class="form-group">
            <div class="input-group input-group-icon">
              <span class="input-group-addon">
                <span class="icon wb-lock" aria-hidden="true"></span>
              </span>
              <input type="password" class="form-control" name="password" placeholder="New Password" required>
            </div>
          </div>
           <div class="form-group">
            <div class="input-group input-group-icon">
              <span class="input-group-addon">
                <span class="icon wb-lock" aria-hidden="true"></span>
              </span>
              <input type="password" class="form-control" name="cnf_password" placeholder="Confirm Password" required>
            </div>
          </div>
          <div class="example example-buttons">
                  <button type="submit" name="submit" class="btn btn-animate btn-animate-side btn-success">
                    <span><i class="icon wb-pencil" aria-hidden="true"></i>Save Changes</span>
                  </button>
                
          </div>
        </form>   
        <?php
         }
        ?>
        </div>
        <!-- End Example Icon Addon -->
      </div>
    </div>
  </div></div></div></div>
  <!-- End Page -->

<?php include("include/footer.php"); ?>



