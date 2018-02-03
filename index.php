<?php
include_once("variable.php");
include_once("config.php");
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>CNI-Bjb | Home</title>
	<?php include("link-css.php"); ?>
</head>
<body>
	<div class="container">

		<?php
		//jika ada $_GET ak dan kd
		if (isset($_GET['ak']) && isset($_GET['kd'])) {
			//proses aktifasi akun customer
			$aktif = $db->prepare("UPDATE customer SET aktif = :aktif WHERE id_customer = :id_customer AND kode = :kode");
			$aktif->execute(array(
				":aktif" => "Y",
				":id_customer" => $_GET['ak'],
				":kode" => $_GET['kd']
				));
			if ($aktif->rowCount() == 1) {
				echo '
				<div id="info" class="alert alert-success page-alert">
					<i class="glyphicon glyphicon-ok"></i> <strong>Aktifasi Akun Sukses!</strong>
				</div>
				';
			}else{
				echo '
				<div id="info" class="alert alert-danger page-alert">
					<i class="glyphicon glyphicon-remove"></i> <strong>Aktifasi Akun Gagal!</strong>
				</div>
				';
			}
		}
		include("navbar.php");
		include("header.php");
		include("carousel-n-login.php");
		include("produk-list.php");
		include("footer.php");
		?>

	</div>

<?php include("link-js.php"); ?>
</body>
</html>