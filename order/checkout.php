<?php
include_once("../variable.php");
include_once("../config.php");
if (empty($_SESSION['id_customer'])) {
	header("location: $host");
}else{
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
			<div class="col-md-12 col-lg-12">
				<div class="col-md-8">
					<div id="data-pembelian-wrapper">
						<h2>Isi Data Pembelian</h2><hr>
<?php
$sql_data = $db->prepare("SELECT * FROM customer WHERE id_customer = :id_customer");
$sql_data->execute(array(":id_customer" => $_SESSION['id_customer']));
$data = $sql_data->fetch(PDO::FETCH_OBJ);

function pvs($db) {
$qry = $db->prepare("SELECT * FROM customer WHERE id_customer = :id_customer");
$qry->execute(array(":id_customer" => $_SESSION['id_customer']));
$get = $qry->fetch(PDO::FETCH_ASSOC);
$sql_p = $db->prepare("SELECT * FROM master_provinsi");
$sql_p->execute();
echo "<select name='provinsi' class='form-control' id='pro' onchange='pilihKota(this.value,\"$_SESSION[id_customer]\")'>";
echo "<option value=''>-Pilih Provinsi-</option>";
while ($x = $sql_p->fetch(PDO::FETCH_ASSOC)) {
	if ($x['provinsi_id'] == $get['provinsi']) {
		echo "<option value='".$x['provinsi_id']."' selected>".$x['provinsi_nama']."</option>";
	}else{
		echo "<option value='".$x['provinsi_id']."'>".$x['provinsi_nama']."</option>";
	}
}
echo "</select>";

//tutup koneksi db
$qry = null;
$sql_p = null;
}

function kt($db) {
$qry2 = $db->prepare("SELECT * FROM customer WHERE id_customer = :id_customer");
$qry2->execute(array(":id_customer" => $_SESSION['id_customer']));
$get2 = $qry2->fetch(PDO::FETCH_ASSOC);
$sql_k = $db->prepare("SELECT * FROM master_kokab");
$sql_k->execute();
echo "<div id='ko'>";
echo "<select class='form-control' disabled='disabled'>";
echo "<option value=''>-Pilih Kota-</option>";
while ($y = $sql_k->fetch(PDO::FETCH_ASSOC)) {
	if ($y['kota_id'] == $get2['kota']) {
		echo "<option value='".$y['kota_id']."' selected>".$y['kokab_nama']."</option>";
	}else{
		echo "<option value='".$y['kota_id']."'>".$y['kokab_nama']."</option>";
	}
}
echo "</select>";
echo "<input type='hidden' value='".$get2['kota']."' name='kota'>";
echo "</div>";

//tutup koneksi db
$qry2 = null;
$sql_k = null;
}

function kcm($db) {
$qry3 = $db->prepare("SELECT * FROM customer WHERE id_customer = :id_customer");
$qry3->execute(array(":id_customer" => $_SESSION['id_customer']));
$get3 = $qry3->fetch(PDO::FETCH_ASSOC);
$sql_kc = $db->prepare("SELECT * FROM master_kecam WHERE kota_id = :kota_id");
$sql_kc->execute(array(":kota_id" => $get3['kota']));
echo "<div id='kec'>";
echo "<select class='form-control' disabled='disabled'>";
echo "<option value=''>-Pilih Kecamatan-</option>";
while ($z = $sql_kc->fetch(PDO::FETCH_ASSOC)) {
	if ($z['kecam_id'] == $get3['kecamatan']) {
		echo "<option value='".$z['kecam_id']."' selected>".$z['nama_kecam']."</option>";
	}else{
		echo "<option value='".$z['kecam_id']."'>".$z['nama_kecam']."</option>";
	}
}
echo "</select>";
echo "<input type='hidden' value='".$get3['kecamatan']."' name='kecamatan'>";
echo "</div>";

//tutup koneksi db
$qry3 = null;
$sql_kc = null;
}
?>			
						<form action="<?php echo htmlspecialchars("proses-beli.php") ?>" method="post" class="form-horizontal">
							<div class="form-group">
								<label class="col-md-3">Nama Pembeli :</label>
								<div class="col-md-7">
									<input type="text" name="nama" class="form-control" value="<?php echo $data->nama; ?>" autofocus required>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3">Email Pembeli :</label>
								<div class="col-md-7">
									<input type="email" name="email" class="form-control" value="<?php echo $data->email; ?>" required><span><small>Pastikan email yang Anda tuliskan valid. <i class="glyphicon glyphicon-question-sign"></i></small></span>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3">Alamat :</label>
								<div class="col-md-7">
									<textarea name="alamat" class="form-control" rows="4" placeholder="Contoh: Jl.Kemuning Ujung no.17 RT.009 RW.002 Gg. Intan" required><?php echo $data->alamat; ?></textarea>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3">Provinsi :</label>
								<div class="col-md-7">
									<?php pvs($db); ?>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3">Kota :</label>
								<div class="col-md-7">
									<span id="city"></span>
									<?php kt($db); ?>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3">Kecamatan :</label>
								<div class="col-md-7">
									<span id="kcmt"></span>
									<?php kcm($db); ?>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3">Kode Pos :</label>
								<div class="col-md-7">
									<?php
									$kodepos = ($data->kode_pos == 0) ? "" : $data->kode_pos;
									?>
									<input type="number" name="kodepos" class="form-control" value="<?php echo $kodepos; ?>" required>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3">No. Handphone :</label>
								<div class="col-md-7">
									<input type="number" name="no_hp" class="form-control" placeholder="08123456789" value="<?php echo $data->no_hp; ?>" required>
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-offset-3 col-md-7">
									<button class="btn btn-success" name="beli" value="beli">Konfirmasi Beli</button>
								</div>
							</div>
						</form>
					</div>
					<br>
				</div>
				<div class="col-md-4">
					<div id="daftar-belanja-wrapper">
<?php
//mengambil data dari table cart dan produk
$sql_items = $db->prepare("SELECT * FROM cart INNER JOIN produk ON cart.id_produk = produk.id_produk AND cart.id_customer = :id_customer ORDER BY cart.tgl DESC");
$sql_items->execute(array(":id_customer" => $_SESSION['id_customer']));
if ($sql_items->rowCount() == 0) {
	header("location: $host");
	exit();
}

//mengambil dan menghitung total dari subtotal
$sql_total = $db->prepare("SELECT SUM(subtotal) as total FROM cart WHERE id_customer = :id_customer");
$sql_total->execute(array(":id_customer" => $_SESSION['id_customer']));
$total = $sql_total->fetch(PDO::FETCH_OBJ);
?>
						<h2>Daftar Belanja</h2><hr>
						<div class="table-responsive">
							<table class="table table-condensed">
								<thead>
									<tr>
										<th>Barang</th>
										<th><span class="pull-right">Subtotal</span></th>
									</tr>
								</thead>
								<tbody>
									<?php
									while ($item = $sql_items->fetch(PDO::FETCH_OBJ)) {
									?>
									<tr>
										<td class="daftar-barang">
											<div class="pull-left">
												<img src="<?php echo "$host/images/produk/$item->gambar"; ?>" style="width:50px;">
											</div>
											<div class="pull-left">
												<div>
												<?php
												if(strlen($item->nama) > 15) {
													$nama_items = substr($item->nama, 0,15)." ...";
												}else{
													$nama_items = $item->nama;
												}
												echo $nama_items;
												?>
												</div>
												<div><?php echo $item->kuantitas; ?> barang</div>
												<div>Rp <?php echo number_format($item->harga,0,",","."); ?></div>
											</div>
										</td>
										<td align="right" class="subtotal-barang">
											Rp <?php echo number_format($item->subtotal,0,",","."); ?>
										</td>
									</tr>
									<?php
									}
									?>
									<tr>
										<td><span id="total-caption">TOTAL :</span></td>
										<td><span id="harga-caption" class="pull-right">Rp <?php echo number_format($total->total,0,",","."); ?></span></td>
									</tr>
									<tr>
										<td colspan="2">
											<font color="red"><i>Belum Termasuk Biaya Kirim</i></font>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
						<div class="clearfix"></div>
					</div>
				</div>
			</div>
		</div>
		<br><br>

		<?php
		include("../footer.php");
		?>

	</div>

<?php include("../link-js.php"); ?>
<script>
	var host = "<?php echo $host; ?>";
	function pilihKota(c,s) {
		$.ajax({
			url: host+'/order/select-alamat-ajax.php',
			type: 'POST',
			datatype: 'php',
			data: 'pick_city='+c+'&sesi='+s,
			beforeSend: function(){
				$("#ko").remove();
				$("#kec").remove();
				$("#city").html("Loading...");
				$("#kcmt").html("Loading...");
			},
			success: function(hasil){
				$('#city').html(hasil);
			}
		});
	}

	function pilihKecamatan(k,s) {
		$.ajax({
			url: host+'/order/select-alamat-ajax.php',
			type: 'POST',
			datatype: 'php',
			data: 'pick_kcm='+k+'&sesi2='+s,
			beforeSend: function(){
				$("#kec").remove();
				$("#hpus_kec").remove();
				$("#kcmt").html("Loading...");
			},
			success: function(hasil){
				$('#kcmt').html(hasil);
			}
		});
	}
</script>
</body>
</html>
<?php
}
?>