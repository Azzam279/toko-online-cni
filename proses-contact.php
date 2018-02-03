<?php
if (isset($_POST['kirim'])) {
	include("variable.php");
	if (empty($_POST['name'])) {
		$_SESSION['peringatan'] = "Nama harus di isi!";
		header("location: contact.php");
		exit();
	}else if (empty($_POST['email'])) {
		$_SESSION['peringatan'] = "Email harus di isi!";
		header("location: contact.php");
		exit();
	}else if (empty($_POST['message'])) {
		$_SESSION['peringatan'] = "Pesan harus di isi!";
		header("location: contact.php");
		exit();
	}else if (!preg_match("/^[a-zA-Z .]*$/",$_POST['name'])) {
		$_SESSION['peringatan'] = "Karakter Nama tidak valid!";
		header("location: contact.php");
		exit();
	}else if (!filter_var($_POST['email'],FILTER_VALIDATE_EMAIL)) {
		$_SESSION['peringatan'] = "Email tidak valid!";
		header("location: contact.php");
		exit();
	}else{
		include("config.php");
		$sql = $db->prepare("INSERT INTO contact VALUES(:id_contact,:nama,:email,:subjek,:pesan,:tgl)");
		$sql->execute(array(
			":id_contact" => null,
			":nama" => $_POST['name'],
			":email" => $_POST['email'],
			":subjek" => $_POST['subject'],
			":pesan" => trim(nl2br(htmlentities($_POST['message']))),
			":tgl" => time()
			));
		if ($sql->rowCount() == 1) {
			$sql = null;
			$_SESSION['sukses'] = "Pesan terkirim!";
			header("location: contact.php");
		}else{
			$sql = null;
			$_SESSION['gagal'] = "Pesan gagal terkirim!";
			header("location: contact.php");
		}
	}
}else{
	header("location: contact.php");
}
?>