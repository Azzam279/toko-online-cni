<?php
include_once("../variable.php");
if (empty($_SESSION['id_customer'])) {
	header("location: $host");
}else{
	header("location: $host/order/checkout.php");
}
?>