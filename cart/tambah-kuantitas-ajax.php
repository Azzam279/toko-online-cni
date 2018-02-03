<?php
include_once("../variable.php");
include_once("../config.php");

if (isset($_POST['qty']) && isset($_POST['cart']) && isset($_POST['harga'])) {

	$subtotal = $_POST['harga'] * $_POST['qty'];
	$sql = $db->prepare("UPDATE cart SET kuantitas = :kuantitas, subtotal = :subtotal WHERE id_customer = :id_customer AND id_cart = :id_cart");
	$sql->execute(array(
		":kuantitas" => $_POST['qty'],
		":subtotal" => $subtotal,
		":id_customer" => $_SESSION['id_customer'],
		":id_cart" => $_POST['cart']
		));

	if ($sql->rowCount() == 1) {
		$sql = null;
		$sql2 = $db->prepare("SELECT SUM(subtotal) as sub FROM cart WHERE id_customer = :id_customer");
		$sql2->execute(array(":id_customer" => $_SESSION['id_customer']));
		$data = $sql2->fetch(PDO::FETCH_OBJ);
		echo "Rp ".number_format($data->sub,0,",",".");
		$sql2 = null;
	}else{
		echo "Terjadi error! ".$sql->rowCount();
	}
}

if (@$_POST['select'] == "total") {
	$sql_total = $db->prepare("SELECT SUM(subtotal) as sub2 FROM cart WHERE id_customer = :id_customer");
	$sql_total->execute(array(":id_customer" => $_SESSION['id_customer']));
	$total = $sql_total->fetch(PDO::FETCH_OBJ);
	echo "Cart - Rp ".number_format($total->sub2,0,",",".");
	$sql_total = null;
}

if (@$_POST['select'] == "subtotal") {
	$sql_sub = $db->prepare("SELECT subtotal FROM cart WHERE id_customer = :id_customer AND id_cart = :id_cart");
	$sql_sub->execute(array(
		":id_customer" => $_SESSION['id_customer'],
		":id_cart" => $_POST['cart']
		));
	$sub = $sql_sub->fetch(PDO::FETCH_OBJ);
	echo "Rp ".number_format($sub->subtotal,0,",",".");
	$sql_sub = null;
}
?>