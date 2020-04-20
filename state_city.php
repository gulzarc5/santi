<?php 
include "php/database/connection.php";
$assam = ['Baksa','Barpeta','Sonitpur','Bongaigaon','Cachar','Sivasagar','Chirang','Darrang','Dhemaji','Dhubri','Dibrugarh','Dima Hasao','Goalpara','Golaghat','Hailakandi','Nagaon','Jorhat','Kamrup','Kamrup','Karbi Anglong']
	$sql = "";
if ($res = $connection->query($sql)) {
	echo "inserted";
}else{
	echo "not Inserted";
}
?>

