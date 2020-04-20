<?php
function showMessage($msg){
    if ($msg == 3) {
      print "<p class='alert alert-danger'>Password Does Not Matched</p>";
    }
    if ($msg == 2) {
      print "<p class='alert alert-danger'>Email Id Not Exist In Our Database</p>";
    }
    if ($msg == 4) {
      print "<p class='alert alert-danger'>Something Went Wrong Please Try Again</p>";
    }
  }
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Santirekha</title>
    <link rel="icon" type="image/ico" href="uploads/icon.png">

    <!-- Bootstrap -->
    <link href="vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- Animate.css -->
    <link href="vendors/animate.css/animate.min.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="build/css/custom.min.css" rel="stylesheet">
  </head>

  <body class="login">
    <div>
      <a class="hiddenanchor" id="signup"></a>
      <a class="hiddenanchor" id="signin"></a>

      <div class="login_wrapper">
          <section class="login_content">
            <form action="php/admin_login_system/user_login_check.php" method="post">
              <h1>Login Form</h1>
              <?php
                if (isset($_GET['msg'])) {
                  showMessage($_GET['msg']);
                }
              ?>
              <div>
                <input type="text" name="email" class="form-control" placeholder="Enter Email" required />
              </div>
              <div>
                <input type="password" name="password" class="form-control" placeholder="Enter Password" required />
              </div>
              <div>
                <!-- <a class="btn btn-default submit" href="index.html">Log in</a> -->
                <input class="btn btn-default submit" type="submit" name="Log_in" value="Log in" style="margin-left: 139px;">
              </div>

              <div class="clearfix"></div>

              <div class="separator">
                

                <div class="clearfix"></div>
                <br />

                <div>
                  <h1><img src="uploads/santirekhalogo.png" height="50"></h1>
                  <p>©2016 All Rights Reserved.Santirekha!</p>
                </div>
              </div>
            </form>
          </section>


        
      </div>
    </div>
  </body>
</html>
