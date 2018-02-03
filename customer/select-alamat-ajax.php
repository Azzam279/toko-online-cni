<?php
if (isset($_POST['pick_city'])) {
	include_once("../config.php");
	$sql_k = $db->prepare("SELECT * FROM master_kokab WHERE provinsi_id = :provinsi_id");
	$sql_k->execute(array(":provinsi_id" => $_POST['pick_city']));
	
	$qry = $db->prepare("SELECT * FROM customer WHERE id_customer = :id_customer");
	$qry->execute(array(":id_customer" => $_POST['sesi']));
	$get = $qry->fetch(PDO::FETCH_ASSOC);

	echo '<select name="kota" class="form-control" onchange="pilihKecamatan(this.value,\''.$_POST['sesi'].'\')" required>';

		if (@$_POST['pick_city'] != "") {
			while ($kota = $kt = $sql_k->fetch(PDO::FETCH_ASSOC)) {
				if ($get['kota'] == $kota['kota_id']) {
					echo "<option value='$kota[kota_id]' selected>$kota[kokab_nama]</option>";
				}else{
					echo "<option value='$kota[kota_id]'>$kota[kokab_nama]</option>";
				}
			}
		}else{
			echo '<option value="">-Pilih Kota-</option>';
		}

	echo '</select>';

	echo "<script>$('#kcmt').html(\"<select name='kecamatan' id='hpus_kec' class='form-control' disabled='disabled' required><option value='0'>-Pilih Kecamatan-</option></select>\")</script>";

	//tutup koneksi db
	$sql_k = null;
	$qry = null;
}

if (isset($_POST['pick_kcm'])) {
	include_once("../config.php");
	$sql_c = $db->prepare("SELECT * FROM master_kecam WHERE kota_id = :kota_id");
	$sql_c->execute(array(":kota_id" => $_POST['pick_kcm']));
	$qry2 = $db->prepare("SELECT * FROM customer WHERE :id_customer = :id_customer");
	$qry2->execute(array(":id_customer" => $_POST['sesi2']));
	$get2 = $qry2->fetch(PDO::FETCH_ASSOC);

	echo '<select name="kecamatan" class="form-control" required>';

		if (@$_POST['pick_kcm'] != "") {
			while ($kecam = $sql_c->fetch(PDO::FETCH_ASSOC)) {
				if ($get2['kecamatan'] == $kecam['kecam_id']) {
					echo "<option value='$kecam[kecam_id]'>$kecam[nama_kecam]</option>";
				}else{
					echo "<option value='$kecam[kecam_id]'>$kecam[nama_kecam]</option>";
				}
			}
		}else{
			echo '<option value="">-Pilih Kecamatan-</option>';
		}

	echo '</select>';

	//tutup koneksi db
	$sql_c = null;
	$qry2 = null;
}
?>