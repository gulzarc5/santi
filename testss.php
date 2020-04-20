<?php
require_once "include/header.php";

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

function getCenters($connection){
  $sql = "SELECT * FROM `batch` WHERE `end_date` >= '2019-01-09' ORDER BY `id` DESC";
  if ($res = $connection->query($sql)) {
    $sl_count = 1;
    while($batch = $res->fetch_assoc()){
      print '<tr>
                <td>'.$sl_count.'</td>
                <td>'.$batch['name'].'</td>';
        $sql_center_name = "SELECT `name` FROM `center` WHERE `id` = '$batch[center_id]'";
        if ($res_center_name = $connection->query($sql_center_name)) {
           $center_row = $res_center_name->fetch_assoc();
           $center_name = $center_row['name'];
        }
      print '<td>'.$center_name.'</td>
                <td>'.$batch['start_date'].'</td>
                <td>'.$batch['end_date'].'</td>
                <td>'.$batch['start_time'].'</td>
                <td>'.$batch['end_time'].'</td>
                <td><a href="edit_batch.php?b_id='.$batch['id'].'" class="btn btn-success">Edit</a>
                    <a href="php/course/batch_delete.php?b_id='.$batch['id'].'" class="btn btn-danger">Delete</a>
                </td>
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
                    <h2>All Batches<small></small></h2>
                    <div class="clearfix"></div>
                      <?php 
                        if (isset($_GET['msg'])) {
                          showMessage($_GET['msg']);
                        }           
                      ?>
                  </div>
                  <div class="x_content">
          
                    <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                      <thead>
                        <tr>
                          <th>Sl</th>
                          <th>Batch Name</th>
                          <th>Center Name</th>
                          <th>Start Date</th>
                          <th>End Date</th>
                          <th>Start Time</th>
                          <th>End Time</th>
                          <th>Actions</th>
                        </tr>
                      </thead>
                      <tbody>
                  <tr>
                <td>1</td>
                <td>Master of Computer Application#January(01:15 AM-01:15 PM)</td><td >HAilakandi Center of Education</td>
                <td >2019-01-16</td>
                <td >2019-01-31</td>
                <td >01:15 AM</td>
                <td >01:15 PM</td>
                <td ><a href="edit_batch.php?b_id=5" class="btn btn-success">Edit</a>
                    <a href="php/course/batch_delete.php?b_id=5" class="btn btn-danger">Delete</a>
                </td>
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

<script src="vendors/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>

    <script src="vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
