<?php
require('barcode.php');

$barcode = new Barcode(123456789120, 4);
$barcode->display();
?>