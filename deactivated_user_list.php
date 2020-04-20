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

// function getUsers($connection){
//   $sql = "SELECT * FROM `users` WHERE `status`='6' AND `user_type`!= 1";
//   if ($res = $connection->query($sql)) {
//     $sl_count = 1;
//     while($user = $res->fetch_assoc()){
//       print '<tr>
//                 <td>'.$sl_count.'</td>
//                 <td>'.$user['name'].'</td>
//                 <td>'.$user['email'].'</td>';
//       if ($user['user_type'] == 2) {
//          print '<td>Whole Seller</td>';
//       }else{
//         print '<td>Retailer</td>';
//       }
//           print '<td>'.$user['mobile'].'</td>';
//       $state_sql = "SELECT * FROM `state` WHERE `id`='$user[state_id]'";
//       if($state_res = $connection->query($state_sql)){
//         $state_row = $state_res->fetch_assoc();
//          print '<td>'.$state_row['name'].'</td>';
//       }else{
//          print '<td>--</td>';
//       }
//         print '<td>'.$user['city'].'</td>
//               <td>'.$user['address'].'</td>
//                 <td>'.$user['pin'].'</td>
//                 <td>'.$user['dob'].'</td>
//                 <td>'.$user['ann_date'].'</td>
//                 <td>'.$user['trade'].'</td>
//                 <td>'.$user['drug'].'</td>
//                 <td>'.$user['gst'].'</td>
//                 <td>
//                   <a href="edit_user.php?user_id='.$user['id'].'" class="btn btn-success">Edit</a>';
//       if ($user['status'] == 2) {
//          print '<a href="php/users/status_update.php?user_id='.$user['id'].'&status=3&page=1" class="btn btn-danger">Deactivate</a>';
//       }elseif ($user['status'] == 3) {
//         print '<a href="php/users/status_update.php?user_id='.$user['id'].'&status=2&page=2" class="btn btn-success">Activate</a>';
//       }
//         print '<a href="php/users/status_update.php?user_id='.$user['id'].'" class="btn btn-danger">Delete</a>
//                 </td>
//              </tr>';
//       $sl_count++;
//     }

//   }
// }
?>
<div class="clearfix"></div>
<div class="right_col" role="main">
  <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
           <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Deactivated User List<small></small></h2>
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
                          <th>id</th>
                          <th>Name</th>
                          <th>Email</th>
                          <th>Mobile</th>
                          <th>actions</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        // getUsers($connection);
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

<script type="text/javascript">
  $(document).ready(function(){
    var dataTable=$("#users").DataTable({
      "processing" : true,
      "serverSide" : true,
       "columns": [
          { "orderable": false },
          null,
         null,
         null,
          null,
          null,
        ],
      "ajax" :{
        url : "php/ajax/disabled_user_list.php",
        type : "post"
      }
    });
  });
</script>