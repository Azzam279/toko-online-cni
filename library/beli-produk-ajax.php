<?php
session_start();
include_once("../config.php");

if (isset($_POST['no_produk']) && isset($_POST['harga']) && isset($_POST['nama']) && isset($_POST['stock'])) {

	$sql_cek = $db->prepare("SELECT * FROM cart WHERE id_produk = :id_produk AND id_customer = :id_customer");
	$sql_cek->execute(array(
		":id_produk" => $_POST['no_produk'],
		":id_customer" => $_SESSION['id_customer']
		));
	$data = $sql_cek->fetch(PDO::FETCH_OBJ);
	
	//jika tidak ada produk yg sama dlm table cart
	if ($sql_cek->rowCount() == 0) {
		$sql_cek = null;
		//proses insert data produk ke table cart (keranjang)
		$sql = $db->prepare("INSERT INTO cart VALUES(:id_cart,:id_produk,:id_customer,:kuantitas,:subtotal,:tgl)");
		$sql->execute(array(
			":id_cart" => null,
			":id_produk" => $_POST['no_produk'],
			":id_customer" => $_SESSION['id_customer'],
			":kuantitas" => 1,
			":subtotal" => $_POST['harga'],
			":tgl" => time()
			));
		//jika proses insert berhasil
		if ($sql->rowCount() == 1) {
			$sql = null;
			//mengambil data dari table cart berdasarkan id customer
			$get = $db->prepare("SELECT * FROM cart WHERE id_customer = :id_customer");
			$get->execute(array(":id_customer" => $_SESSION['id_customer']));

			//menghitung subtotal utk mendapatkan total
			$cart = $db->prepare("SELECT SUM(subtotal) as total FROM cart WHERE id_customer = :id_customer");
			$cart->execute(array(":id_customer" => $_SESSION['id_customer']));
			$get_total = $cart->fetch(PDO::FETCH_OBJ);
			$total = number_format($get_total->total,0,",",".");

			//membuat variable info sukses
			$sukses = "Produk $_POST[nama] berhasil ditambahkan ke Troli.";

			echo '
			<a href="javascript:void(0)" data-toggle="modal" data-target="#myCart" onclick="showCart()">
			<div id="price">
				Cart - Rp '.$total.'
			</div>
			<div id="cart">
				<i class="glyphicon glyphicon-shopping-cart"></i>
			</div>
			<div id="items-cart">
				<span class="badge" id="total-item">'.$get->rowCount().'</span>
			</div>
			</a>

			<a href="javascript:void(0)" id="cart-fixed" data-toggle="modal" data-target="#myCart" onclick="showCart()" class="hidden-xs hidden-sm">
				<div id="cart-2">
					<i class="glyphicon glyphicon-shopping-cart"></i>
				</div>
				<div id="items-cart-2">
					<span class="badge">'.$get->rowCount().'</span>
				</div>
			</a>

			<div id="info2" class="alert alert-success page-alert">
				<!--<button type="button" class="close"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>-->
				<i class="glyphicon glyphicon-ok"></i> <strong>'.$sukses.'</strong>
			</div>
			<script>$(".page-alert").delay(4500).fadeOut();</script>
			';

			//tutup koneksi db
			$get = null;
			$cart = null;
		}else{
			echo "Terjadi Error!";
		}
	//jika ada produk yg sama
	}else{
		if ($data->kuantitas == $_POST['stock']) {
			$qty = $_POST['stock'];
		}else{
			$qty = $data->kuantitas + 1;
		}
		$sub = $_POST['harga'] * $qty;
		//proses update table cart
		$sql2 = $db->prepare("UPDATE cart SET kuantitas = :kuantitas, subtotal = :subtotal WHERE id_produk = :id_produk AND id_customer = :id_customer");
		$sql2->execute(array(
			":kuantitas" => $qty,
			":subtotal" => $sub,
			":id_produk" => $_POST['no_produk'],
			":id_customer" => $_SESSION['id_customer']
			));
		//tutup koneksi db
		$sql_cek = null;
		$sql2 = null;

		//mengambil data dari table cart berdasarkan id customer
		$get = $db->prepare("SELECT * FROM cart WHERE id_customer = :id_customer");
		$get->execute(array(":id_customer" => $_SESSION['id_customer']));

		//menghitung subtotal utk mendapatkan total
		$cart = $db->prepare("SELECT SUM(subtotal) as total FROM cart WHERE id_customer = :id_customer");
		$cart->execute(array(":id_customer" => $_SESSION['id_customer']));
		$get_total = $cart->fetch(PDO::FETCH_OBJ);
		$total = number_format($get_total->total,0,",",".");

		//membuat variable info sukses
		$sukses = "Produk $_POST[nama] berhasil ditambahkan ke Troli.";

		echo '
		<a href="javascript:void(0)" data-toggle="modal" data-target="#myCart" onclick="showCart()">
		<div id="price">
			Cart - Rp '.$total.'
		</div>
		<div id="cart">
			<i class="glyphicon glyphicon-shopping-cart"></i>
		</div>
		<div id="items-cart">
			<span class="badge" id="total-item">'.$get->rowCount().'</span>
		</div>
		</a>

		<a href="javascript:void(0)" id="cart-fixed" data-toggle="modal" data-target="#myCart" onclick="showCart()" class="hidden-xs hidden-sm">
			<div id="cart-2">
				<i class="glyphicon glyphicon-shopping-cart"></i>
			</div>
			<div id="items-cart-2">
				<span class="badge">'.$get->rowCount().'</span>
			</div>
		</a>

		<div id="info2" class="alert alert-success page-alert">
			<!--<button type="button" class="close"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>-->
			<i class="glyphicon glyphicon-ok"></i> <strong>'.$sukses.'</strong>
		</div>
		<script>$(".page-alert").delay(4500).fadeOut();</script>
		';

		//tutup koneksi db
		$get = null;
		$cart = null;
	}
}

?>
