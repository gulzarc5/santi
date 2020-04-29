<?php
require_once "include/header.php";
date_default_timezone_set('Asia/Kolkata');

function showMessage($msg){
    if ($msg == 3) {
      print "<p class='alert alert-success'>Batch Updated Successfully</p>";
    }
    if ($msg == 4) {
      print "<p class='alert alert-danger'>Something Wrong Please Try Again</p>";
    }
    if ($msg == 5) {
      print "<p class='alert alert-danger'>Batch Deleted Successfully</p>";
    }
    if ($msg == 6) {
      print "<p class='alert alert-danger'>Something Wrong Please Try Again</p>";
    }
  }

function getSliders($connection){
  $sql = "SELECT * FROM `slider`";
  if ($res = $connection->query($sql)) {
    $sl_count = 1;
    while($slider_row = $res->fetch_assoc()){
      print '<tr>
                <td>'.$sl_count.'</td>
                <td><img src="uploads/slider_image/'.$slider_row['image'].'" height="100px"></td>
                <td>'.$slider_row['title'].'</td>';
      if ($slider_row['status'] == '1') {
        print '<td><a class="btn btn-primary" disabled>Enabled</a></td>';
      }else{
         print '<td><a class="btn btn-danger" disabled>Disabled</a></td>';
      }

        print '<td><a href="php/slider/delete_slider.php?id='.$slider_row['id'].'" class="btn btn-danger">Delete</a>
        <a href="edit_slider.php?id='.$slider_row['id'].'" class="btn btn-warning">Edit</a>';
        if ($slider_row['status'] == '1') {
          print '<a href="php/slider/update_slider_status.php?id='.$slider_row['id'].'&status=2" class="btn btn-danger">Deactivate</a>';
        }else{
          print '<a href="php/slider/update_slider_status.php?id='.$slider_row['id'].'&status=1" class="btn btn-primary">Activate</a>';
        }
        print '</td>
             </tr>';
      $sl_count++;
    }

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
                    <h2>Application Sliders<small></small></h2>
                    <div class="clearfix"></div>
                      <?php 
                        if (isset($_GET['msg'])) {
                          showMessage($_GET['msg']);
                        }           
                      ?>
                  </div>
                  <div class="x_content table-responsive">
          
                    <table class="table table-striped jambo_table bulk_action" cellspacing="0" width="100%">
                      <thead>
                        <tr>
                          <th>Sl</th>
                          <th>Image</th>                          
                          <th>Slider Title</th>
                          <th>Status</th>
                          <th>Action</th>
                          <!-- <th>Actions</th> -->
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        getSliders($connection);
                        ?>                        
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

<script src="vendors/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>

    <script src="vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
