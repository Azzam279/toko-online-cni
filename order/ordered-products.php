<?php
include_once("../variable.php");
include_once("../config.php");
if (empty($_SESSION['id_customer'])) {
	header("location: $host");
}else{
	if (empty($_SESSION['finish'])) {
		header("location: $host");
		exit();
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>CNI-Bjb | Order</title>
	<?php include("../link-css.php"); ?>
</head>
<body>
	<div class="container">

		<?php
		include("../navbar.php");
		include("../header.php");
		?>

		<div class="row">
			<div class="col-md-12 col-sm-12">
				<div id="ordered-product-wrapper">
					<div class="title-grateful"><b>Terima Kasih</b> telah berbelanja di toko Kami.</div>
					<p>
						Kami akan segera mengecek ketersediaan barang yang dipesan serta ongkos kirim dan segera menghubungi Anda.
					</p>
					<p>
						Segera lakukan pembayaran setelah Kami mengkonfirmasi ongkos kirim dan barang yang dipesan.
					</p>
					<br><br>

					<h4>Barang yang dipesan :</h4>
					<div class="table-responsive">
					<?php
					$sql = $db->prepare("SELECT * FROM order_produk WHERE id_customer = :id_customer ORDER BY tanggal DESC LIMIT 0,1");
					$sql->execute(array(":id_customer" => $_SESSION['id_customer']));
					$data = $sql->fetch(PDO::FETCH_OBJ);
					$nama = explode("|",$data->produk);
					$img = explode("|",$data->gambar);
					$harga = explode("|",$data->harga);
					$qty = explode("|",$data->kuantitas);
					$sub = explode("|",$data->subtotal);
					$count = count($nama);
					?>
						<table class="table table-hover">
							<thead>
								<tr bgcolor="#7FAAFF">
									<th colspan="2">Produk</th>
									<th>Harga</th>
									<th>Kuantitas</th>
									<th>Subtotal</th>
								</tr>
							</thead>
							<tbody>
								<?php
								for ($x = 0; $x < $count; $x++) {
								?>
								<tr>
									<td>
										<img src="<?php echo "$host/images/produk/$img[$x]"; ?>" class="img-responsive" style="width:80px;">
									</td>
									<td>
										<?php echo $nama[$x]; ?>
									</td>
									<td>
										<?php echo "Rp ".number_format($harga[$x],0,",","."); ?>
									</td>
									<td>
										<?php echo $qty[$x]; ?>
									</td>
									<td>
										<?php echo "Rp ".number_format($sub[$x],0,",","."); ?>
									</td>
								</tr>
								<?php
								}
								?>
								<tr bgcolor="#EBEBEB">
									<td colspan="4"><b>TOTAL</b></td>
									<td><b><?php echo "Rp ".number_format($data->total,0,",","."); ?></b></td>
								</tr>
							</tbody>
						</table>
						<div class="pull-left">
						<?php
						date_default_timezone_set('Asia/Singapore');
						echo "Tanggal: ".date("d-m-Y H:i:s",$data->tanggal);
						?>
						</div>
						<div class="pull-right"><a href="<?php echo "$host/customer/?c=pesanan-saya"; ?>" class="btn btn-primary" style="margin-right:20px;"><b><i class="glyphicon glyphicon-eye-open"></i> Pesanan Saya</b></a></div>
						<div class="clearfix"></div>
					</div>
				</div>
			</div>
		</div>

		<div class="clearfix"><br><br><br></div>

		<?php
		include("../footer.php");
		?>

	</div>

<?php include("../link-js.php"); ?>
</body>
</html>
<?php
//hapus session finish
unset($_SESSION['finish']);
}
?>