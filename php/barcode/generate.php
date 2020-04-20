<?php
include "../admin_login_system/php_user_session_check.php";
include "../database/connection.php";

if(isset($_POST['submit']) && isset($_POST['total_bar_code']) && isset($_POST['p_id']))
{
	$total=$connection->real_escape_string(mysql_entities_fix_string($_POST['total_bar_code']));
	$p_id = $connection->real_escape_string(mysql_entities_fix_string($_POST['p_id']));
               
    $sql_stock = "SELECT * FROM `product` WHERE `id`='$p_id'";
  	if ($res_stock = $connection->query($sql_stock)) {
    	$row_stock = $res_stock->fetch_assoc();
    	if (isset($row_stock['barcode']) && !empty($row_stock['barcode'])) {
    		for ($i=0; $i < $total; $i++) { 
    			echo "<img alt='Image' src='barcode.php?codetype=Code39&size=50&text=".$row_stock['barcode']."&print=true' />";
    		}
    	}
    }
	
}

function mysql_entities_fix_string($string){return htmlentities(mysql_fix_string($string));}
function mysql_fix_string($string){
    if (get_magic_quotes_gpc()) 
        $string = stripslashes($string);
    return $string;
}
?>

<script type="text/javascript">
  window.print();
  window.onafterprint = function(event) {
    window.location.href="../../education.php";
  };
  
</script>