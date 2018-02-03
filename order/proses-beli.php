<?php
include_once("../variable.php");
if (isset($_POST['beli'])) {
	//validasi
	if (empty($_POST['nama']) || empty($_POST['email']) || empty($_POST['alamat']) || empty($_POST['provinsi']) || empty($_POST['kota']) || empty($_POST['kecamatan']) || empty($_POST['kodepos']) || empty($_POST['no_hp'])) {
		$_SESSION['peringatan'] = "Semua kolom input harus di-isi.";
		header("location: $host/order/checkout.php");
		exit();
	}else{
		if (!preg_match("/^[a-zA-Z .]*$/",$_POST['nama'])) {
			$_SESSION['peringatan'] = "Nama tidak valid!";
			header("location: $host/order/checkout.php");
			exit();
		}else if (!preg_match("/^[\w .]*$/",$_POST['no_hp'])) {
			$_SESSION['peringatan'] = "No. Handphone harus berupa Angka!";
			header("location: $host/order/checkout.php");
			exit();
		}else if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
			$_SESSION['peringatan'] = "Email tidak valid!";
			header("location: $host/order/checkout.php");
			exit();
		}else if (!preg_match("/^[\w .]*$/",$_POST['alamat'])) {
			$_SESSION['peringatan'] = "Alamat tidak valid!";
			header("location: $host/order/checkout.php");
			exit();
		}else if (!preg_match("/^[0-9]*$/", $_POST['kodepos'])) {
			$_SESSION['peringatan'] = "Kode Pos harus berupa Angka!";
			header("location: $host/order/checkout.php");
			exit();
		}else{
			include_once("../config.php");
			//mengambil data email dari table customer
			$get_email = $db->prepare("SELECT email FROM customer WHERE id_customer = :id_customer");
			$get_email->execute(array(":id_customer" => $_SESSION['id_customer']));
			$email = $get_email->fetch(PDO::FETCH_OBJ);

			//mengecek email apakah sudah terdaftar atau belum
			$cek_email = $db->prepare("SELECT email FROM customer WHERE email = :email1 AND email <> :email2");
			$cek_email->execute(array(
				":email1" => $_POST['email'],
				":email2" => $email->email
				));

			if ($cek_email->rowCount() > 0) {
				$_SESSION['peringatan'] = "Email sudah terdaftar!";
				header("location: $host/order/checkout.php");
				exit();
			}else{
				include_once("../config.php");
				//proses update data customer
				$sql = $db->prepare("UPDATE customer SET 
					nama = :nama,
					email = :email,
					alamat = :alamat,
					provinsi = :provinsi,
					kota = :kota,
					kecamatan = :kecamatan,
					kode_pos = :kode_pos,
					no_hp = :no_hp
					WHERE id_customer = :id_customer");
				$sql->execute(array(
					":nama" => $_POST['nama'],
					":email" => $_POST['email'],
					":alamat" => $_POST['alamat'],
					":provinsi" => $_POST['provinsi'],
					":kota" => $_POST['kota'],
					":kecamatan" => $_POST['kecamatan'],
					":kode_pos" => $_POST['kodepos'],
					":no_hp" => $_POST['no_hp'],
					":id_customer" => $_SESSION['id_customer']
					));
				//tutup koneksi db
				$sql = null;

				//mengambil data dari table cart dan produk
				$sql2 = $db->prepare("SELECT * FROM cart INNER JOIN produk ON cart.id_produk = produk.id_produk AND cart.id_customer = :id_customer ORDER BY cart.tgl DESC");
				$sql2->execute(array(":id_customer" => $_SESSION['id_customer']));

				//mengambil total harga dari table cart
				$sql_total = $db->prepare("SELECT SUM(subtotal) as total FROM cart WHERE id_customer = :id_customer");
				$sql_total->execute(array(":id_customer" => $_SESSION['id_customer']));
				$total = $sql_total->fetch(PDO::FETCH_OBJ);

				$no_p=""; $nama_p=""; $gambar_p=""; $harga_p=""; $qty_p=""; $sub_p="";
				while ($data = $sql2->fetch(PDO::FETCH_OBJ)) {
					$no_p .= $data->id_produk."|";
					$nama_p .= $data->nama."|";
					$gambar_p .= $data->gambar."|";
					$harga_p .= $data->harga."|";
					$qty_p .= $data->kuantitas."|";
					$sub_p .= $data->subtotal."|";
				}
				
				$sql3 = $db->prepare("INSERT INTO order_produk VALUES(:id_order,:id_produk,:id_customer,:produk,:gambar,:harga,:kuantitas,:subtotal,:total,:ongkir,:dikirim,:no_resi,:tanggal)");
				$sql3->execute(array(
					":id_order" => null,
					":id_produk" => substr($no_p,0,-1),
					":id_customer" => $_SESSION['id_customer'],
					":produk" => substr($nama_p,0,-1),
					":gambar" => substr($gambar_p,0,-1),
					":harga" => substr($harga_p,0,-1),
					":kuantitas" => substr($qty_p,0,-1),
					":subtotal" => substr($sub_p,0,-1),
					":total" => $total->total,
					":ongkir" => 0,
					":dikirim" => "N",
					":no_resi" => "",
					":tanggal" => time()
					));

				if ($sql3->rowCount() == 1) {
					//tutup koneksi db
					$sql2 = null;
					$sql3 = null;
					$sql_total = null;

					$sql4 = $db->prepare("DELETE FROM cart WHERE id_customer = :id_customer");
					$sql4->execute(array(":id_customer" => $_SESSION['id_customer']));
					$_SESSION['finish'] = "Finished!";

					header("location: $host/order/ordered-products.php");
				}else{
					//tutup koneksi db
					$sql2 = null;
					$sql3 = null;
					$sql_total = null;
					$_SESSION['gagal'] = "Terjadi Error! silakan coba lagi.";
					header("location: $host/order/checkout.php");
				}
			}
		}
	}

}else{
	header("location: $host/order/checkout.php");
}
?>