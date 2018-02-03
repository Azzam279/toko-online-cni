<?php

include_once("../variable.php");

if (isset($_POST['daftar'])) {

	include_once("../config.php");
	//validasi
	if (empty($_POST['nama'])) {
		$_SESSION['peringatan'] = "Nama harus di isi!";
		header("location: $host/register/daftar.php");
		exit();
	}else if (empty($_POST['email'])) {
		$_SESSION['peringatan'] = "Email harus di isi!";
		header("location: $host/register/daftar.php");
		exit();
	}else if (empty($_POST['pass'])) {
		$_SESSION['peringatan'] = "Password harus di isi!";
		header("location: $host/register/daftar.php");
		exit();
	}else if (empty($_POST['pass2'])) {
		$_SESSION['peringatan'] = "Re-Password harus di isi!";
		header("location: $host/register/daftar.php");
		exit();
	}else if (empty($_POST['jkl'])) {
		$_SESSION['peringatan'] = "Jenis Kelamin harus di isi!";
		header("location: $host/register/daftar.php");
		exit();
	}else if (!preg_match("/^[a-zA-Z .]*$/",$_POST['nama'])) {
		$_SESSION['peringatan'] = "Nama tidak valid!";
		header("location: $host/register/daftar.php");
		exit();
	}else if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
		$_SESSION['peringatan'] = "Email tidak valid!";
		header("location: $host/register/daftar.php");
		exit();
	}else if (!ctype_alnum($_POST['pass'])) {
		$_SESSION['peringatan'] = "Password hanya boleh karakter Alfanumerik!";
		header("location: $host/register/daftar.php");
		exit();
	}else if ($_POST['pass'] != $_POST['pass2']) {
		$_SESSION['peringatan'] = "Password tidak sama!";
		header("location: $host/register/daftar.php");
		exit();
	}else{
		//mengecek email apakah sudah terdaftar atau belum
		$cek_email = $db->prepare("SELECT email FROM customer WHERE email = :email");
		$cek_email->execute(array(":email" => $_POST['email']));

		if ($cek_email->rowCount() > 0) {
			$_SESSION['peringatan'] = "Email sudah terdaftar! gunakan email yang lain.";
			header("location: $host/register/daftar.php");
			exit();
		}else{
			//membuat kode karakter alfanumerik
			$codelength = 25;
			$newcode_length = 0;
			while($newcode_length < $codelength){
				$x = 1;
				$y = 3;
				$part = rand($x,$y);
				if($part==1){$a=48; $b=57;}
				if($part==2){$a=65; $b=90;}
				if($part==3){$a=97; $b=122;}
				$code_part = chr(rand($a,$b));
				$newcode_length = $newcode_length + 1;
				@$newcode = $newcode.$code_part;
			}

			//query insert
			$sql = $db->prepare("INSERT INTO customer(id_customer,nama,email,password,sex,tgl_lahir,kode,aktif) VALUES(:id_customer,:nama,:email,:password,:sex,:tgl_lahir,:kode,:aktif)");

			//eksekusi
			$pass = md5(sha1("q3fg4".md5($_POST['pass'])."93jwe"));
			$sql->execute(array(
				":id_customer" => null,
				":nama" => trim($_POST['nama']),
				":email" => $_POST['email'],
				":password" => $pass,
				":sex" => $_POST['jkl'],
				":tgl_lahir" => $_POST['tahun']."-".$_POST['bulan']."-".$_POST['tanggal'],
				":kode" => $newcode,
				":aktif" => "N",
				));

			//cek apakah insert data sukses
			if ($sql->rowCount() == 1) {
				$sql = null;
				$_SESSION['sukses'] = "Daftar Sukses! Silakan lakukan aktivasi akun melalui email Anda.";

				$get_nmr = $db->prepare("SELECT id_customer FROM customer WHERE email = :email");
				$get_nmr->execute(array(":email" => $_POST['email']));
				$nmr_customer = $get_nmr->fetch(PDO::FETCH_OBJ);

				include_once("../class.phpmailer.php");
				$sendmail = new PHPMailer();
				$sendmail->From = 'admin@cni-bjb.16mb.com';
				$sendmail->FromName = 'CNI-Bjb';
				$sendmail->addAddress($_POST['email'],$_POST['nama']);
				$sendmail->addReplyTo('admin@cni-bjb.16mb.com','Azzam');
				$sendmail->Subject = 'Email aktivasi: Aktifkan akun CNI-Bjb Anda melalui Email ini!';
				$sendmail->Body = 'Terima kasih atas kepercayaan Anda bergabung sebagai member di cni-bjb.16mb.com! Silakan klik tombol di bawah ini untuk mengaktifkan akun Anda:<br><br>
					<a href="http://cni-bjb.16mb.com/?ak='.$nmr_customer->id_customer.'&kd='.$newcode.'" style="padding:10px;background:#4096EE;color:white;text-decoration:none;font-weight:bold;">Aktifkan & Belanja Sekarang</a><br><br><br>
					Jika tombol di atas tidak mengarahkan ke halaman baru, copy URL di bawah ini ke browser Anda:<br>
					<a href="http://cni-bjb.16mb.com/?ak='.$nmr_customer->id_customer.'&kd='.$newcode.'">http://cni-bjb.16mb.com/?ak='.$nmr_customer->id_customer.'&kd='.$newcode.'</a>
					<br><br>Jika Anda memiliki pertanyaan lebih lanjut, hubungi kami melalui email: admin@cni-bjb.16mb.com<br/><br/><b>Selamat bergabung & selamat berbelanja!</b><br/><a href="cni-bjb.16mb.com" style="color:#4096EE;text-decoration:none;font-weight:bold;">Cni-bjb.16mb.com</a>';
				$sendmail->isHTML(true);
				$sendmail->Send();

				header("location: $host/");
			}else{
				$sql = null;
				$_SESSION['gagal'] = "Daftar gagal! Silakan coba lagi.";
				header("location: $host/register/daftar.php");
			}
		}
	}

}else{
	header("location: $host/register/daftar.php");
}

?>