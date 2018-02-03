<?php
if (isset($_POST['kota'])) {
	include_once("../config.php");
	$sql_k = $db->prepare("SELECT * FROM master_kokab WHERE provinsi_id = :provinsi_id");
	$sql_k->execute(array(":provinsi_id" => $_POST['kota']));

	echo '<select name="kota" class="form-control" onchange="kecam(this.value)" required>';

		if (@$_POST['kota'] != "") {
				echo '<option value="">-Pilih Kota-</option>';
			while ($kota = $sql_k->fetch(PDO::FETCH_ASSOC)) {
				echo "<option value='$kota[kota_id]'>$kota[kokab_nama]</option>";
			}
			$sql_k = null;
		}else{
			echo '<option value="">-Pilih Kota-</option>';
		}

	echo '</select>';

	echo "<script>$('#kecamatan').html(\"<select  id='hpus_kec' class='form-control' disabled='disabled' required><option value=''>-Pilih Kecamatan-</option></select>\")</script>";
}

if (isset($_POST['kecam'])) {
	include_once("../config.php");
	$sql_c = $db->prepare("SELECT * FROM master_kecam WHERE kota_id = :kota_id");
	$sql_c->execute(array(":kota_id" => $_POST['kecam']));

	echo '<select name="kecamatan" class="form-control" required>';

		if (@$_POST['kecam'] != "") {
				echo '<option value="">-Pilih Kecamatan-</option>';
			while ($kecam = $sql_c->fetch(PDO::FETCH_ASSOC)) {
				echo "<option value='$kecam[kecam_id]'>$kecam[nama_kecam]</option>";
			}
			$sql_c = null;
		}else{
			echo '<option value="">-Pilih Kecamatan-</option>';
		}

	echo '</select>';
}
?>