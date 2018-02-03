<?php
session_start();
if (isset($_POST['no_produk2'])) {
	include("../config.php");
	//mengambil data dari table cart berdasarkan id customer
	$get = $db->prepare("SELECT * FROM cart WHERE id_customer = :id_customer");
	$get->execute(array(":id_customer" => $_SESSION['id_customer']));
	echo $get->rowCount();
	$get = null;
}
?>