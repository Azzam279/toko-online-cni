<?php
session_start();
include_once("../config.php");
if (isset($_POST['nmr'])) {
	//query hapus data di table cart
	$sql = $db->prepare("DELETE FROM cart WHERE id_cart = :id_cart AND id_customer = :id_customer");
	//eksekusi query
	$sql->execute(array(
		":id_cart" => $_POST['nmr'],
		":id_customer" => $_SESSION['id_customer']
		));
	//jika hapus data sukses
	if ($sql->rowCount() == 1) {
		//tutup koneksi db
		$sql = null;
		//ambil data dari cart dan hitung total dari subtotal
		$sql_sub = $db->prepare("SELECT SUM(subtotal) as total FROM cart WHERE id_customer = :id_customer");
		$sql_sub->execute(array(":id_customer" => $_SESSION['id_customer']));
		$total = $sql_sub->fetch(PDO::FETCH_OBJ);
		$total = number_format($total->total,0,",",".");

		//mengambil data dari cart utk mendapatkan total items
		$sql_items = $db->prepare("SELECT id_cart FROM cart WHERE id_customer = :id_customer");
		$sql_items->execute(array(":id_customer" => $_SESSION['id_customer']));
		$total_items = $sql_items->rowCount();

		echo '
		<a href="javascript:void(0)" data-toggle="modal" data-target="#myCart" onclick="showCart()">
		<div id="price">
			Cart - Rp '.$total.'
		</div>
		<div id="cart">
			<i class="glyphicon glyphicon-shopping-cart"></i>
		</div>
		<div id="items-cart">
			<span class="badge" id="total-item">'.$total_items.'</span>
		</div>
		</a>

		<a href="javascript:void(0)" id="cart-fixed" data-toggle="modal" data-target="#myCart" onclick="showCart()" class="hidden-xs hidden-sm">
			<div id="cart-2">
				<i class="glyphicon glyphicon-shopping-cart"></i>
			</div>
			<div id="items-cart-2">
				<span class="badge">'.$total_items.'</span>
			</div>
		</a>
		';
		//tutup koneksi db
		$sql_sub = null;
		$sql_items = null;

	//jika gagal
	}else{
		echo "Terjadi Error!";
	}
}

if (@$_POST['gets'] == "total") {
	//ambil data dari cart dan hitung total dari subtotal
	$sql_get = $db->prepare("SELECT SUM(subtotal) as total FROM cart WHERE id_customer = :id_customer");
	$sql_get->execute(array(":id_customer" => $_SESSION['id_customer']));
	$total2 = $sql_get->fetch(PDO::FETCH_OBJ);
	$total2 = number_format($total2->total,0,",",".");

	echo "Rp ".$total2;
	$sql_get = null;
}

if (@$_POST['get2'] == "items") {
	//ambil data dari cart dan hitung total dari subtotal
	$sql_get2 = $db->prepare("SELECT id_cart FROM cart WHERE id_customer = :id_customer");
	$sql_get2->execute(array(":id_customer" => $_SESSION['id_customer']));

	echo $sql_get2->rowCount();
	$sql_get2 = null;
}
?>