<?php
include_once("../variable.php");
include_once("../config.php");
if (isset($_SESSION['id_customer'])) {
	header("location: $host");
}else{
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>CNI-Bjb | Register</title>
	<?php include("../link-css.php"); ?>
</head>
<body>
	<div class="container">

		<?php 
		include("../navbar.php");
		?>

		<div class="row">
			<div class="col-md-12 col-sm-12">
				<div id="daftar-bg" class="hidden-xs hidden-sm">
					<img src="../images/register.png">
				</div>
				<div id="daftar-wrapper">
					<legend><center><h3><b>Buat Akun</b></h3></center></legend>
					<form action="<?php echo htmlspecialchars("$host/register/proses-daftar.php"); ?>" method="post">
						<div class="form-group">
							<label>Nama :</label>
							<input type="text" name="nama" class="form-control" maxlength="150" placeholder="Masukkan Nama Anda" autofocus required>
							<label>Email :</label>
							<input type="email" name="email" class="form-control" placeholder="Masukkan Email" required>
							<label>Password :</label>
							<input type="password" name="pass" class="form-control" placeholder="Masukkan Password" required>
							<label>Konfirmasi Password :</label>
							<input type="password" name="pass2" class="form-control" placeholder="Ketik Ulang Password" required>
							<label>Jenis Kelamin :</label><br>
							<input type="radio" name="jkl" value="Laki-laki" id="L" required> <label for="L" style="font-weight:normal;">Laki-laki</label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<input type="radio" name="jkl" value="Perempuan" id="P" required> <label for="P" style="font-weight:normal;">Perempuan</label><br>
							<label>Tanggal Lahir :</label><br>
							<select name="tahun" style="padding:7px;" required>
				        		<?php
				        		for ($t=1945;$t<=2015;$t++) {
				        			echo "<option value='$t'>$t</option>";
				        		}
				        		?>
				        	</select>
				        	<select name="bulan" style="width:120px;padding:7px;" required>
				        		<?php
				        		$arr_bulan = array("Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
				        		foreach ($arr_bulan as $key_bln => $val_bln) {
				        			$key = $key_bln+1;
				        			echo "<option value='$key'>$val_bln</option>";
				        		}
				        		?>
				        	</select>
				        	<select name="tanggal" style="padding:7px;" required>
				        		<?php
				        		$tgl = 1;
				        		while ($tgl <= 31) {
				        			echo "<option value='$tgl'>$tgl</option>";
				        			$tgl++;
				        		}
				        		?>
				        	</select>
							<br><br>
							<button class="btn btn-primary" name="daftar" value="daftar">Daftar</button>
							<input type="reset" class="btn btn-warning" value="Cancel">
						</div>
					</form>
					<br><br>
				</div>
			</div>
		</div>

		<?php
		include("../footer.php");
		?>

	</div>

<?php include("../link-js.php"); ?>
</body>
</html>
<?php
}
?>