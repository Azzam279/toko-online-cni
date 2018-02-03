<?php

include_once("../variable.php");

if (isset($_POST['login'])) {

	if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
		$_SESSION['peringatan'] = "Email tidak valid!";
		header("location: $host");
		exit();
	}else if (!ctype_alnum($_POST['password'])) {
		$_SESSION['peringatan'] = "Password tidak valid!";
		header("location: $host");
		exit();
	}else{
		session_start();
		include_once("../config.php");
		//query
		$sql = $db->prepare("SELECT email,password FROM customer WHERE email = :email AND password = :password");
		$pass = md5(sha1("q3fg4".md5($_POST['password'])."93jwe"));
		$sql->execute(array(":email" => $_POST['email'], ":password" => $pass));
		if ($sql->rowCount() == 1) {
			$sql = null;
			$sql2 = $db->prepare("SELECT * FROM customer WHERE email = :email AND password = :password AND aktif = :aktif");
			$sql2->execute(array(":email" => $_POST['email'], ":password" => $pass, ":aktif" => "Y"));
			if ($sql2->rowCount() == 1) {
				$data = $sql2->fetch(PDO::FETCH_OBJ);
				$_SESSION['id_customer'] = $data->id_customer;
				$_SESSION['nm_customer'] = $data->nama;
				$sql2 = null;
				header("location: $host");
			}else{
				$sql2 = null;
				$_SESSION['peringatan'] = "Akun Anda belum aktif! Silakan cek email Anda untuk aktivasi akun.";
				header("location: $host");	
			}
		}else{
			$sql = null;
			$_SESSION['gagal'] = "Email atau Password Salah!";
			header("location: $host");	
		}
	}

}else{
	header("location: $host");
}

?>