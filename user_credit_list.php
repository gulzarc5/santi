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

?>
<div class="clearfix"></div>
<div class="right_col" role="main">
	<div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
           <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>User Credit<small></small></h2>
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
                          <th>User Name</th>                      
                         <th>Amount</th>
                         <th>Balance History</th>
                          <!-- <th>actions</th> -->
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
         
          
         
        ],
      "ajax" :{
        url : "php/ajax/user_credit_fetch.php",
        type : "get"
      }
    });
  });
</script>