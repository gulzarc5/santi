<?php


require('barcode.php');

$barcode = new Barcode($_GET['text'], 4);
$barcode->display();

?>