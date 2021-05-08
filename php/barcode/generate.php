<?php
include "../admin_login_system/php_user_session_check.php";
include "../database/connection.php";?>

        
        <!--<img alt="Image" src="barcode_print.php?codetype=Code39&amp;size=50&amp;text=8901361303729&amp;print=true">-->
        <!--<img alt="Image" src="barcode_print.php?codetype=Code39&amp;size=50&amp;text=8901361303729&amp;print=true">-->
        <!--<img alt="Image" src="barcode_print.php?codetype=Code39&amp;size=50&amp;text=8901361303729&amp;print=true">-->

    <style>img{width:143.62px;height:94.48px;margin-bottom:5.66px;float:left}img:nth-child(odd){margin-left:5.66px;margin-right:2.83px}img:nth-child(even){margin-right:5.66px;margin-left:2.83px}img:nth-child(1), img:nth-child(2){margin-top:5.66px}img:nth-last-child(1), img:nth-last-child(2){margin-bottom:0}</style>

<?php
if(isset($_POST['submit']) && isset($_POST['total_bar_code']) && isset($_POST['p_id']))
{
	$total=$connection->real_escape_string(mysql_entities_fix_string($_POST['total_bar_code']));
	$p_id = $connection->real_escape_string(mysql_entities_fix_string($_POST['p_id']));
               
    $sql_stock = "SELECT * FROM `product` WHERE `id`='$p_id'";
  	if ($res_stock = $connection->query($sql_stock)) {
    	$row_stock = $res_stock->fetch_assoc();
    	if (isset($row_stock['barcode']) && !empty($row_stock['barcode'])) {
    	    print '<section style="">
                    <div style="width:304.22px;display:block;">';
    		for ($i=0; $i < $total; $i++) { 
    		    print '<img alt="Image" src="barcode_print.php?codetype=code25&size=80&text='.$row_stock['barcode'].'&print=true">';
    		}
    		print '</div></section>';
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