<?php
include_once "php/admin_login_system/page_user_session_check.php";
include_once "php/database/connection.php";

function mysql_entities_fix_string($string){return htmlentities(mysql_fix_string($string));}
function mysql_fix_string($string){
    if (get_magic_quotes_gpc()) 
        $string = stripslashes($string);
    return $string;
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

    <title>Shantirekha</title>
    <link rel="icon" type="image/ico" href="uploads/icon.png">
    <!-- Bootstrap -->
    <link href="vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- bootstrap-progressbar -->
    <link href="vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet">
    <!-- bootstrap-daterangepicker -->
    <link href="vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
    <link href="vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
    <link href="vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
    <link href="vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
    <link href="vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">
    
    <!-- Custom Theme Style -->
    <link href="build/css/custom.min.css" rel="stylesheet">
  </head>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
              <a href="deshboard.php" class="site_title"><img src="uploads/santirekhalogo.png" height="50" width="200"></a>
            </div>

            <div class="clearfix"></div>

            <!-- menu profile quick info -->
            <div class="profile clearfix">
              <div class="profile_info">
                <h2>Welcome <?=$_SESSION['admin_name']?></h2>
              </div>
            </div>
            <!-- /menu profile quick info -->

            <br />

            <!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
                <h3>General</h3>
                <ul class="nav side-menu">
                  <li><a href="deshboard.php"><i class="fa fa-home"></i> Home </a></li>
                  <li><a href="make_invoice_form.php"><i class="fa fa-print"></i> Order Invoice </span>
                  <li><a><i class="fa fa-users"></i> Users <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="add_user_form.php">Add User</a></li>
                      <li><a href="user_list.php">Activated User List</a></li>
                      <li><a href="user_regular_list.php">Regular Customer List</a></li>
                      <?php 
                        if (isset($_SESSION['user_type']) && $_SESSION['user_type'] == 1) {
                      ?>
                      <li><a href="deactivated_user_list.php">DeActivated User List</a></li>
                      <li><a href="user_wallet_list.php">User Wallet List</a></li> 
                      <li><a href="user_credit_list.php">User Credit List</a></li>     
                      <?php } ?>                 
                    </ul>
                  </li>
                  <?php 
                    if (isset($_SESSION['user_type']) && $_SESSION['user_type'] == 1) {
                  ?>
                  <li><a><i class="fa fa-empire"></i> Employee <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="add_employee_form.php">Add Employee</a></li>
                      <li><a href="employee_list.php">Employee List</a></li>                  
                    </ul>
                  </li>
                  <li><a><i class="fa fa-product-hunt"></i> Products <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="add_product_form.php">Add Product</a></li>
                      <li><a href="education.php">Product List</a></li>
                      <li><a href="star_product_list.php">Free Shopping Product</a></li>
                      
                    </ul>
                  </li>
                  <?php } ?>
                   <li><a><i class="fa fa-list-ol"></i>All Orders <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="order_list.php">Order List</a></li>
                      <?php 
                        if (isset($_SESSION['user_type']) && $_SESSION['user_type'] == 1) {
                      ?>
                      <li><a href="ordered_item.php">Ordered Item List</a></li>
                      <?php } ?>
                    </ul>
                  </li>

                  <?php 
                    if (isset($_SESSION['user_type']) && $_SESSION['user_type'] == 1) {
                  ?>

                   <li><a><i class="fa fa-folder-o"></i>Employee Orders <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="employee_orders_list.php">Order List</a></li>
                    </ul>
                  </li>

                 

                  <li><a><i class="fa fa-heart-o"></i> Discount <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="offer_form.php"> Discount </a></li>
                    </ul>
                  </li>

                  <li><a><i class="fa fa-object-group"></i> Product Category <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="add_main_category_form.php">Add Main Category</a></li>
                      <li><a href="main_category_list.php">Main Category List</a></li>
                      <li><a href="add_category_form.php">Add Sub Category</a></li>
                      <li><a href="category_list.php">Sub Category List</a></li>
                    </ul>
                  </li>
                  <li><a><i class="fa fa-wpforms"></i> App Slider <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="add_slider_form.php">Add Slider</a></li>
                      <li><a href="slider_list.php">Sliders</a></li>
                    </ul>
                 </li>
                 <li><a href="customer_review.php"><i class="fa fa-exclamation-triangle"></i> Customers Review </span></a></li>
                 <li><a href="php/corn/regular_customer_check.php"><i class="fa fa-edit"></i> Regular Customer Check </span></a></li>
                 <?php } ?>
                  <!-- <li><a href="star_member_chk.php?page=1" onclick="javascript:return confirm('Are you sure ?? you want to scan manually in the database. if maunaly scan it will not scan automatically in this month')"><i class="fa fa-edit"></i> Star Member Scan</span></a></li> -->
                
                  <li><a href="change_password.php"><i class="fa fa-key"></i>  Change Password </span></a></li>
                </ul>
              </div>
            </div>
            <!-- /sidebar menu -->
          </div>
        </div>

        <!-- top navigation -->
        <div class="top_nav">
          <div class="nav_menu">
            <nav>
              <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
              </div>
              <h2 style="display:inline-block;line-height:2.1">Welcome <?=$_SESSION['admin_name']?></h2>

              <ul class="nav navbar-nav navbar-right">
                <li class="">
                  <a href="php/admin_login_system/user_logout.php"><i class="fa fa-sign-out"></i> Log Out</a>
                </li>

               <!--  <li role="presentation" class="dropdown">
                  <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
                    <i class="fa fa-envelope-o"></i>
                    <span class="badge bg-green">6</span>
                  </a>
                  <ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu">
                    <li>
                      <a>
                        <span class="image"><img src="images/img.jpg" alt="Profile Image" /></span>
                        <span>
                          <span>John Smith</span>
                          <span class="time">3 mins ago</span>
                        </span>
                        <span class="message">
                          Film festivals used to be do-or-die moments for movie makers. They were where...
                        </span>
                      </a>
                    </li>
                    <li>
                      <a>
                        <span class="image"><img src="images/img.jpg" alt="Profile Image" /></span>
                        <span>
                          <span>John Smith</span>
                          <span class="time">3 mins ago</span>
                        </span>
                        <span class="message">
                          Film festivals used to be do-or-die moments for movie makers. They were where...
                        </span>
                      </a>
                    </li>
                    <li>
                      <a>
                        <span class="image"><img src="images/img.jpg" alt="Profile Image" /></span>
                        <span>
                          <span>John Smith</span>
                          <span class="time">3 mins ago</span>
                        </span>
                        <span class="message">
                          Film festivals used to be do-or-die moments for movie makers. They were where...
                        </span>
                      </a>
                    </li>
                    <li>
                      <a>
                        <span class="image"><img src="images/img.jpg" alt="Profile Image" /></span>
                        <span>
                          <span>John Smith</span>
                          <span class="time">3 mins ago</span>
                        </span>
                        <span class="message">
                          Film festivals used to be do-or-die moments for movie makers. They were where...
                        </span>
                      </a>
                    </li>
                    <li>
                      <div class="text-center">
                        <a>
                          <strong>See All Alerts</strong>
                          <i class="fa fa-angle-right"></i>
                        </a>
                      </div>
                    </li>
                  </ul>
                </li> -->
              </ul>
            </nav>
          </div>
        </div>
        <!-- /top navigation -->