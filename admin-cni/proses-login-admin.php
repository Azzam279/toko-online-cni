<?php
if ($_POST['login']) {
	include("../variable.php");
	if (empty($_POST['user'])) {
		$_SESSION['peringatan'] = "Username harus di isi!";
		header("location: login");
		exit();
	}else if (empty($_POST['pass'])) {
		$_SESSION['peringatan'] = "Password harus di isi!";
		header("location: login");
		exit();
	}else if (!ctype_alnum($_POST['user'])) {
		$_SESSION['peringatan'] = "Username tidak valid!";
		header("location: login");
		exit();
	}else if (!ctype_alnum($_POST['pass'])) {
		$_SESSION['peringatan'] = "Password tidak valid!";
		header("location: login");
		exit();
	}else{
		include("../config.php");
		$sql = $db->prepare("SELECT * FROM admin WHERE username = :username AND password = :password");
		$pass = md5(sha1("q3fg4".md5(hash("ripemd160",$_POST['pass']))."93jwe"));
		$sql->execute(array(
			":username" => $_POST['user'],
			":password" => $pass
			));
		$data = $sql->fetch(PDO::FETCH_OBJ);

		if ($sql->rowCount() == 1) {
			$_SESSION['admin'] = $data->id_admin;
			$_SESSION['nama'] = $data->nama_admin;
			header("location: ./");
		}else{
			$_SESSION['gagal'] = "Username atau Password salah!";
			header("location: login");
			exit();
		}
	}
}else{
	header("location: $host");
}
?>