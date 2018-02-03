<?php
include_once("../config.php");

if (isset($_POST['no']) && isset($_POST['ongkir'])) {
	if ($_POST['ongkir'] == "") {
		echo "Ongkir harus di isi!";
	}else if (!preg_match("/^[0-9]*$/", $_POST['ongkir'])) {
		echo "Ongkir harus berupa Angka!";
	}else{
		$sql = $db->prepare("UPDATE order_produk SET ongkir = :ongkir WHERE id_order = :id_order");
		$sql->execute(array(
			":ongkir" => $_POST['ongkir'],
			":id_order" => $_POST['no']
			));
		
		if ($sql->rowCount() == 1) {
			$sql = null;
			echo "Ongkir Updated!";
		}else{
			$sql = null;
			echo "Terjadi Kesalahan. silakan coba lagi";
		}
	}

}else if (isset($_POST['nmr']) && isset($_POST['status'])) {
	$sql = $db->prepare("UPDATE order_produk SET dikirim = :dikirim WHERE id_order = :id_order");
	$sql->execute(array(
		":dikirim" => $_POST['status'],
		":id_order" => $_POST['nmr']
		));
	
	if ($sql->rowCount() == 1) {
		$sql = null;
		if ($_POST['status'] == "N") {
			echo "Status Order Updated!";
		}else{
			$sql2 = $db->prepare("SELECT id_produk,kuantitas FROM order_produk WHERE id_order = :id_order");
			$sql2->execute(array(":id_order" => $_POST['nmr']));
			$data = $sql2->fetch(PDO::FETCH_OBJ);
			$id_p = explode("|",$data->id_produk);
			$qty = explode("|",$data->kuantitas);
			$count = count($id_p);
			for ($x = 0; $x < $count; $x++) {
				$sql3 = $db->prepare("SELECT stok FROM produk WHERE id_produk = :id_produk");
				$sql3->execute(array(":id_produk" => $id_p[$x]));
				$stok = $sql3->fetch(PDO::FETCH_OBJ);
				$stock = $stok->stok - $qty[$x];

				$sql4 = $db->prepare("UPDATE produk SET stok = :stok, terjual = :terjual WHERE id_produk = :id_produk");
				$sql4->execute(array(
					":stok" => $stock,
					":terjual" => $qty[$x],
					":id_produk" => $id_p[$x]
					));
			}
			//tutup koneksi db
			$sql2 = null;
			$sql3 = null;
			$sql4 = null;
			echo "Status Order Updated!";
		}

	}else{
		$sql = null;
		echo "Terjadi Kesalahan. silakan coba lagi";
	}

}else if (isset($_POST['id']) && isset($_POST['noresi'])) {
	if ($_POST['noresi'] == "") {
		echo "No. Resi harus di isi!";
	}else if (!ctype_alnum($_POST['noresi'])) {
		echo "No Resi harus berupa Alfanumerik!";
	}else{
		$sql = $db->prepare("UPDATE order_produk SET no_resi = :no_resi WHERE id_order = :id_order");
		$sql->execute(array(
			":no_resi" => $_POST['noresi'],
			":id_order" => $_POST['id']
			));
		
		if ($sql->rowCount() == 1) {
			$sql = null;
			echo "No. Resi Updated!";
		}else{
			$sql = null;
			echo "Terjadi Kesalahan. silakan coba lagi";
		}
	}
}else if(isset($_POST['rmv'])) {
	echo "
	<button class='btn btn-success' onclick='status($_POST[id_rmv])' id='btn$_POST[id_rmv]'>Save</button>
	";
}else{	
	header("location: ?adm=order");
}
?>