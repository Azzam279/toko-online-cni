<div class="row">
	<div class="col-md-6">
		<div>
			<h2><center><b>Informasi Alamat</b></center></h2><hr>
			<?php
			$sql = $db->prepare("SELECT*FROM customer WHERE id_customer = :id_customer");
			$sql->execute(array(":id_customer" => $_SESSION['id_customer']));
			$alamat = $sql->fetch(PDO::FETCH_OBJ);
			?>
			<form action="<?php echo htmlspecialchars("$host/customer/CRUD.php"); ?>" method="post">
				<div class="form-group">
					<label>Alamat <span class="redstar">*</span></label>
					<textarea name="alamat" rows="5" class="form-control" required><?php echo trim($alamat->alamat); ?></textarea><br>
					<label>Provinsi <span class="redstar">*</span></label>
					<?php pvs($db); ?>
					<label style="display:block;">Kota <span class="redstar">*</span></label>
					<span id="city"></span>
					<?php kt($db); ?>
					<label style="display:block;">Kecamatan <span class="redstar">*</span></label>
					<span id="kcmt"></span>
					<?php kcm($db); ?>
					<br>
					<label>Kode Pos <span class="redstar">*</span></label>
					<?php $kodepos = ($alamat->kode_pos==0) ? "" : $alamat->kode_pos; ?>
					<input type="number" class="form-control" name="kode_pos" value="<?php echo $kodepos; ?>" required><br>
					<button class="btn btn-primary" name="save_alamat" value="save_alamat">Simpan</button><br>
				</div>
			</form>
			<?php
			//tutup koneksi db
			$sql = null;
			?>
		</div>
	</div>
</div>
<?php
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