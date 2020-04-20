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

function getCategory($connection){
  $sql = "SELECT `sub_category`.`name` AS sub_name, `sub_category`.`id` AS sub_cat_id, `category`.`name` AS cat_name FROM `sub_category` INNER JOIN `category` ON `category`.`id`=`sub_category`.`category_id`";
  if ($res = $connection->query($sql)) {
    $sl_count = 1;
    while($category = $res->fetch_assoc()){
      print '<tr>
                <td>'.$sl_count.'</td>
                <td>'.$category['cat_name'].'</td>
                <td>'.$category['sub_name'].'</td>
                <td><a href="edit_cat.php?sub_id='.$category['sub_cat_id'].'" class="btn btn-success">Edit</a>
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
                    <h2>Customer Review<small></small></h2>
                    <div class="clearfix"></div>
                      <?php 
                        if (isset($_GET['msg'])) {
                          showMessage($_GET['msg']);
                        }           
                      ?>
                  </div>
                  <div class="x_content table-responsive">
                    <table id="productTable" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                      <thead>
                        <tr>
                          <th>Sl</th>
                          <th>Customer Id</th>
                          <th>Customer Name</th>
                          <th>Comments</th>
                          <th>Status</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                                              
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
    var dataTable=$("#productTable").DataTable({
      "processing" : true,
      "serverSide" : true,
       "columns": [
          { "orderable": false },
         { "orderable": false },
         { "orderable": false },
          { "orderable": false },
          null,
          null,
        ],
        "pageLength": 50,
      "ajax" :{
        url : "php/ajax/customer_review_fetch.php",
        type : "post"
      }
    });
  });
</script>