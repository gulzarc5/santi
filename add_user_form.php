<?php
  include "include/header.php";

  function showMessage($msg){
 
    if ($msg == 1) {
      print "<p class='alert alert-success'>User Created Successfully</p>";
    }
    if ($msg == 2) {
      print "<p class='alert alert-danger'>Something Wrong Please Try Again</p>";
    }
    if ($msg == 3) {
      print "<p class='alert alert-danger'>Email Id Already Exist</p>";
    }
    if ($msg == 4) {
      print "<p class='alert alert-danger'>Mobile Number Already Exist</p>";
    }
  }
?>      

<div class="right_col" role="main">
  <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>Add New User</h2>
            <div class="clearfix"></div>
             <?php 
              if (isset($_GET['msg'])) {
                showMessage($_GET['msg']);
              }           
            ?>
          </div>
          <div class="x_content"><br />
            <form action="php/users/add_users.php" method="post" class="form-horizontal form-label-left">

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Name :<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" name="name" required="required" class="form-control col-md-7 col-xs-12">
                </div>
              </div>

              <div class="form-group">
                <label for="email" class="control-label col-md-3 col-sm-3 col-xs-12">Email :</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input  class="form-control col-md-7 col-xs-12" type="email" name="email" required>
                </div>
              </div>

              <div class="form-group">
                <label for="mobile" class="control-label col-md-3 col-sm-3 col-xs-12">Mobile :</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input  class="form-control col-md-7 col-xs-12" type="text" name="mobile" required>
                </div>
              </div>

              <div class="form-group">
                 <label for="mobile" class="control-label col-md-3 col-sm-3 col-xs-12">State :</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input  class="form-control col-md-7 col-xs-12" type="text" name="state" required>
                </div>
              </div>

              <div class="form-group">
                <label for="city" class="control-label col-md-3 col-sm-3 col-xs-12">City :</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input  class="form-control col-md-7 col-xs-12" type="text" name="city" required>
                </div>
              </div>

              <div class="form-group">
                <label for="address" class="control-label col-md-3 col-sm-3 col-xs-12">Address :</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <textarea name="address" class="form-control col-md-7 col-xs-12"></textarea>
                </div>
              </div>

              <div class="form-group">
                <label for="pin" class="control-label col-md-3 col-sm-3 col-xs-12">Pin :</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input  class="form-control col-md-7 col-xs-12" type="text" name="pin" required>
                </div>
              </div>

              <div class="ln_solid"></div>
                <div class="form-group">
                  <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <input type="submit" class="btn btn-success" name="submit" value="Submit">
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