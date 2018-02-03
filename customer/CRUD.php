<?php

include_once("../variable.php");
include_once("../config.php");

if (isset($_POST['save_profile'])) {
	//validasi
	if (empty($_POST['nama'])) {
		$_SESSION['peringatan'] = "Nama harus di isi!";
		header("location: $host/customer/");
		exit();
	}else if (empty($_POST['no_hp'])) {
		$_SESSION['peringatan'] = "No. Handphone harus di isi!";
		header("location: $host/customer/");
		exit();
	}else if (empty($_POST['email'])) {
		$_SESSION['peringatan'] = "Email harus di isi!";
		header("location: $host/customer/");
		exit();
	}else if (!preg_match("/^[a-zA-Z .]*$/",$_POST['nama'])) {
		$_SESSION['peringatan'] = "Nama tidak valid!";
		header("location: $host/customer/");
		exit();
	}else if (!preg_match("/^[\w .]*$/",$_POST['no_hp'])) {
		$_SESSION['peringatan'] = "No. Handphone harus berupa Angka!";
		header("location: $host/customer/");
		exit();
	}else if (strlen($_POST['no_hp']) > 13) {
		$_SESSION['peringatan'] = "No. Handphone max 13 digit!";
		header("location: $host/customer/");
		exit();
	}else if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
		$_SESSION['peringatan'] = "Email tidak valid!";
		header("location: $host/customer/");
		exit();
	}else{
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
			header("location: $host/customer/");
			exit();
		}else{
			//query update
			$update_profile = $db->prepare("UPDATE customer SET nama = :nama, tgl_lahir = :tgl_lahir, no_hp = :no_hp, sex = :sex, email = :email WHERE id_customer = :id_customer");
			//eksekusi query update
			$update_profile->execute(array(
				":nama" => trim($_POST['nama']),
				":tgl_lahir" => $_POST['tahun']."-".$_POST['bulan']."-".$_POST['tanggal'],
				":no_hp" => $_POST['no_hp'],
				":sex" => $_POST['jkl'],
				":email" => $_POST['email'],
				":id_customer" => $_SESSION['id_customer']
				));
			//cek apakah proses update sukses
			if ($update_profile->rowCount() == 1) {
				$update_profile = null;
				$_SESSION['sukses'] = "Profile berhasil diupdate!";
				header("location: $host/customer/");
			}else{
				$_SESSION['gagal'] = "Profile gagal diupdate!";
				header("location: $host/customer/");
			}
		}
	}

}else if (isset($_POST['save_alamat'])) {
	//validasi
	if (empty($_POST['alamat'])) {
		$_SESSION['peringatan'] = "Alamat harus di isi!";
		header("location: $host/customer/?c=alamat");
		exit();
	}else if (empty($_POST['provinsi'])) {
		$_SESSION['peringatan'] = "Provinsi harus di isi!";
		header("location: $host/customer/?c=alamat");
		exit();
	}else if (empty($_POST['kota'])) {
		$_SESSION['peringatan'] = "Kota harus di isi!";
		header("location: $host/customer/?c=alamat");
		exit();
	}else if (empty($_POST['kecamatan'])) {
		$_SESSION['peringatan'] = "Kecamatan harus di isi!";
		header("location: $host/customer/?c=alamat");
		exit();
	}else if (empty($_POST['kode_pos'])) {
		$_SESSION['peringatan'] = "Kode Pos harus di isi!";
		header("location: $host/customer/?c=alamat");
		exit();
	}else if (!preg_match("/^[\w .]*$/",$_POST['alamat'])) {
		$_SESSION['peringatan'] = "Alamat tidak valid!";
		header("location: $host/customer/?c=alamat");
		exit();
	}else if (!is_numeric($_POST['kode_pos'])) {
		$_SESSION['peringatan'] = "Kode Pos harus berupa Angka!";
		header("location: $host/customer/?c=alamat");
		exit();
	}else{
		//query update
		$update_alamat = $db->prepare("UPDATE customer SET alamat = :alamat, provinsi = :provinsi, kota = :kota, kecamatan = :kecamatan, kode_pos = :kode_pos WHERE id_customer = :id_customer");
		//eksekusi query update
		$update_alamat->execute(array(
			":alamat" => trim(nl2br($_POST['alamat'])),
			":provinsi" => $_POST['provinsi'],
			":kota" => $_POST['kota'],
			":kecamatan" => $_POST['kecamatan'],
			":kode_pos" => $_POST['kode_pos'],
			":id_customer" => $_SESSION['id_customer']
			));
		//cek apakah proses update alamat sukses
		if ($update_alamat->rowCount() == 1) {
			$update_alamat = null;
			$_SESSION['sukses'] = "Alamat berhasil diupdate!";
			header("location: $host/customer/?c=alamat");
		}else{
			$_SESSION['gagal'] = "Alamat gagal diupdate!";
			header("location: $host/customer/?c=alamat");
		}
	}

}else if (isset($_POST['ok'])) {
	//validasi
	if (empty($_POST['old_pass'])) {
		$_SESSION['peringatan'] = "Password Lama harus di isi!";
		header("location: $host/customer/?c=ubah-password");
		exit();
	}else if (empty($_POST['new_pass'])) {
		$_SESSION['peringatan'] = "Password Baru harus di isi!";
		header("location: $host/customer/?c=ubah-password");
		exit();
	}else if (empty($_POST['new_pass2'])) {
		$_SESSION['peringatan'] = "Re-Password Baru harus di isi!";
		header("location: $host/customer/?c=ubah-password");
		exit();
	}else if (!ctype_alnum($_POST['new_pass'])) {
		$_SESSION['peringatan'] = "Password Baru tidak valid!";
		header("location: $host/customer/?c=ubah-password");
		exit();
	}else{
		$sql = $db->prepare("SELECT password FROM customer WHERE id_customer = :id_customer");
		$sql->execute(array(":id_customer" => $_SESSION['id_customer']));
		$old = $sql->fetch(PDO::FETCH_OBJ);
		$old_pw = md5(sha1("q3fg4".md5($_POST['old_pass'])."93jwe"));
		//validasi ke-2
		if ($old_pw != $old->password) {
			$_SESSION['peringatan'] = "Password Lama salah!";
			header("location: $host/customer/?c=ubah-password");
			exit();
		}else if ($_POST['new_pass'] != $_POST['new_pass2']) {
			$_SESSION['peringatan'] = "Password tidak sama! silakan ketik ulang lagi.";
			header("location: $host/customer/?c=ubah-password");
			exit();
		}else{
			$pass = md5(sha1("q3fg4".md5($_POST['new_pass'])."93jwe"));
			//query update
			$sql_pass = $db->prepare("UPDATE customer SET password = :password WHERE id_customer = :id_customer");
			$sql_pass->execute(array(
				":password" => $pass,
				":id_customer" => $_SESSION['id_customer']
				));
			//cek apakah proses update password sukses
			if ($sql_pass->rowCount() == 1) {
				$sql_pass = null;
				$_SESSION['sukses'] = "Password berhasil diperbarui.";
				header("location: $host/customer/?c=ubah-password");
			}else{
				$sql_pass = null;
				$_SESSION['gagal'] = "Password gagal diperbarui.";
				header("location: $host/customer/?c=ubah-password");
			}
		}
	}

}else{
	header("location: $host/customer/");
}

?>