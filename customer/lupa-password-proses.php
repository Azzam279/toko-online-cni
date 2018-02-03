<?php

include("../variable.php");
if (isset($_POST['update'])) {
	//validate
	if (empty($_POST['email'])) {
		$_SESSION['peringatan'] = "Email harus di isi!";
		header("location: $host/?p=lupa-password");
		exit();
	}else if (empty($_POST['password'])) {
		$_SESSION['peringatan'] = "Password harus di isi!";
		header("location: $host/?p=lupa-password");
		exit();
	}else if (empty($_POST['password2'])) {
		$_SESSION['peringatan'] = "Ketik Ulang Password harus di isi!";
		header("location: $host/?p=lupa-password");
		exit();
	}else if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
		$_SESSION['peringatan'] = "Email tidak valid!";
		header("location: $host/?p=lupa-password");
		exit();
	}else if (!ctype_alnum($_POST['password'])) {
		$_SESSION['peringatan'] = "Password tidak valid!";
		header("location: $host/?p=lupa-password");
		exit();
	}else{
		include("../config.php");
		$sql = $db->prepare("SELECT email FROM customer WHERE email = :email");
		$sql->execute(array(":email" => $_POST['email']));
		if ($sql->rowCount() == 1) {
			if ($_POST['password'] != $_POST['password2']) {
				$_SESSION['peringatan'] = "Password tidak sama! silakan ulangi lagi.";
				header("location: $host/?p=lupa-password");
				exit();
			}else{
				$pass = md5(sha1("q3fg4".md5($_POST['password'])."93jwe"));
				$sql2 = $db->prepare("UPDATE customer SET password = :password WHERE email = :email");
				$sql2->execute(array(
					":password" => $pass,
					":email" => $_POST['email']
					));
				if ($sql2->rowCount() == 1) {
					$sql2 = null;
					$_SESSION['sukses'] = "Password berhasil diperbarui.";
					header("location: $host");
				}else{
					$sql2 = null;
					$_SESSION['gagal'] = "Password gagal diperbarui.";
					header("location: $host");
				}
			}
		}else{
			$sql = null;
			$_SESSION['peringatan'] = "Email tidak terdaftar dalam database Kami.";
			header("location: $host/?p=lupa-password");
			exit();
		}
	}
}else{
	header("location: $host");
}

?>