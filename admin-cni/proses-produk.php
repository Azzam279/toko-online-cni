<?php
include_once("../variable.php");

if (isset($_POST['add'])) {

	//validasi
	$gb = strtolower($_FILES['gb_produk']['name']);
	$cut = explode(".", $gb);
	$nmr = count($cut) - 1;
	if (empty($_POST['nm_produk'])) {
		$_SESSION['peringatan'] = "Nama produk harus di isi!";
		header("location: $host/admin-cni/?adm=set-produk");
		exit();
	}else if (empty($_FILES['gb_produk']['name'])) {
		$_SESSION['peringatan'] = "Gambar produk harus di upload!";
		header("location: $host/admin-cni/?adm=set-produk");
		exit();
	}else if (empty($_POST['ket_produk'])) {
		$_SESSION['peringatan'] = "Deskripsi produk harus di isi!";
		header("location: $host/admin-cni/?adm=set-produk");
		exit();
	}else if (empty($_POST['stok_produk'])) {
		$_SESSION['peringatan'] = "Stok produk harus di isi!";
		header("location: $host/admin-cni/?adm=set-produk");
		exit();
	}else if (empty($_POST['harga_produk'])) {
		$_SESSION['peringatan'] = "Harga produk harus di isi!";
		header("location: $host/admin-cni/?adm=set-produk");
		exit();
	}else if (empty($_POST['berat_produk'])) {
		$_SESSION['peringatan'] = "Berat produk harus di isi!";
		header("location: $host/admin-cni/?adm=set-produk");
		exit();
	}else if ($cut[$nmr] != "jpeg" && $cut[$nmr] != "jpg" && $cut[$nmr] != "png") {
		$_SESSION['peringatan'] = "Upload File Gambar JPEG|JPG|PNG!";
		header("location: $host/admin-cni/?adm=set-produk");
		exit();
	}else if (!preg_match("/^[a-zA-Z .-]*$/", $_POST['nm_produk'])) {
		$_SESSION['peringatan'] = "Karakter Nama Produk tidak valid";
		header("location: $host/admin-cni/?adm=set-produk");
		exit();
	}else if (!preg_match("/[^\'\"<>]/", $_POST['ket_produk'])) {
		$_SESSION['peringatan'] = "Karakter Deskripsi Produk tidak valid";
		header("location: $host/admin-cni/?adm=set-produk");
		exit();
	}else if (!is_numeric($_POST['stok_produk'])) {
		$_SESSION['peringatan'] = "Stok Produk hanya boleh berupa Angka";
		header("location: $host/admin-cni/?adm=set-produk");
		exit();
	}else if (!is_numeric($_POST['harga_produk'])) {
		$_SESSION['peringatan'] = "Harga Produk hanya boleh berupa Angka";
		header("location: $host/admin-cni/?adm=set-produk");
		exit();
	}else if (!is_numeric($_POST['berat_produk'])) {
		$_SESSION['peringatan'] = "Berat Produk hanya boleh berupa Angka";
		header("location: $host/admin-cni/?adm=set-produk");
		exit();
	}else{
		$new = time().".jpg";
		$dir = "$doc/images/produk/";
		$file = "gb_produk";
		$lebar = 196;
		include("upload_image.php");
		//proses upload gambar
		img_resize_upload($new,$dir,$file,$lebar,$cut[$nmr]);

		include_once("../config.php");
		$sql = $db->prepare("INSERT INTO produk VALUES(:id_produk,:nama,:gambar,:keterangan,:stok,:harga,:berat,:tanggal,:terjual)");

		$sql->execute(array(
					":id_produk" => null,
					":nama" => $_POST['nm_produk'],
					":gambar" => $new,
					":keterangan" => trim(nl2br($_POST['ket_produk'])),
					":stok" => $_POST['stok_produk'],
					":harga" => $_POST['harga_produk'],
					":berat" => $_POST['berat_produk'],
					":tanggal" => time(),
					":terjual" => 0
					));

		if ($sql->rowCount() == 1) {
			$sql = null;
			$_SESSION['sukses'] = "Produk baru berhasil ditambahkan!";
			header("location: $host/admin-cni/?adm=set-produk");
		}else{
			$sql = null;
			$_SESSION['gagal'] = "Produk baru gagal ditambahkan!";
			header("location: $host/admin-cni/?adm=set-produk");
		}
	}
	
}else if (isset($_POST['edit'])) {
	//validasi
	if (empty($_FILES['gb_produk']['name'])) {
		$gambar = $_POST['gb_produk2'];
	}else{
		$gb = strtolower($_FILES['gb_produk']['name']);
		$cut = explode(".", $gb);
		$nmr = count($cut) - 1;
		if ($cut[$nmr] != "jpeg" && $cut[$nmr] != "jpg" && $cut[$nmr] != "png") {
			$_SESSION['peringatan'] = "Upload File Gambar JPEG|JPG|PNG!";
			header("location: $host/admin-cni/?adm=set-produk");
			exit();
		}else{
			$new = time().".jpg";
			$dir = "$doc/images/produk/";
			$file = "gb_produk";
			$lebar = 196;
			include("upload_image.php");
			//proses upload gambar
			img_resize_upload($new,$dir,$file,$lebar,$cut[$nmr]);
			$gambar = $new;
		}
	}

	include_once("../config.php");
	$sql = $db->prepare("UPDATE produk SET 
		nama = :nama,
		gambar = :gambar,
		keterangan = :keterangan,
		stok = :stok,
		harga = :harga,
		berat = :berat WHERE id_produk = :id_produk");

	$sql->execute(array(
				":nama" => $_POST['nm_produk'],
				":gambar" => $gambar,
				":keterangan" => $_POST['ket_produk'],
				":stok" => $_POST['stok_produk'],
				":harga" => $_POST['harga_produk'],
				":berat" => $_POST['berat_produk'],
				":id_produk" => $_POST['id_product']
				));

	if ($sql->rowCount() == 1) {
		$sql = null;
		$_SESSION['sukses'] = "Produk berhasil diupdate!";
		header("location: $host/admin-cni/?adm=set-produk");
	}else{
		$sql = null;
		$_SESSION['gagal'] = "Produk gagal diupdate!";
		header("location: $host/admin-cni/?adm=set-produk");
	}

}else if (isset($_GET['del'])) {
	
	include_once("../config.php");
	$sql = $db->prepare("DELETE FROM produk WHERE id_produk = :id_produk");
	$sql->execute(array(":id_produk" => $_GET['del']));
	
	if ($sql->rowCount() == 1) {
		$sql = null;
		$_SESSION['sukses'] = "Produk berhasil dihapus!";
		header("location: $host/admin-cni/?adm=set-produk");
	}else{
		$sql = null;
		$_SESSION['gagal'] = "Produk gagal dihapus!";
		header("location: $host/admin-cni/?adm=set-produk");
	}

}else{
	header("location: $host/admin-cni/?adm=set-produk");
}
?>