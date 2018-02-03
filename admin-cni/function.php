<?php
function provinsi($db,$id) {
	$sql = $db->prepare("SELECT * FROM master_provinsi WHERE provinsi_id = :provinsi_id");
	$sql->execute(array(":provinsi_id" => $id));
	$prov = $sql->fetch(PDO::FETCH_OBJ);
	return $prov->provinsi_nama;
}

function kota($db,$id) {
	$sql = $db->prepare("SELECT * FROM master_kokab WHERE kota_id = :kota_id");
	$sql->execute(array(":kota_id" => $id));
	$kota = $sql->fetch(PDO::FETCH_OBJ);
	return $kota->kokab_nama;
}

function kecamatan($db,$id) {
	$sql = $db->prepare("SELECT * FROM master_kecam WHERE kecam_id = :kecam_id");
	$sql->execute(array(":kecam_id" => $id));
	$kecam = $sql->fetch(PDO::FETCH_OBJ);
	return $kecam->nama_kecam;
}

function time_since($original) {
	date_default_timezone_set('Asia/Singapore');
	$chunks = array(
		array(60 * 60 * 24 * 365, 'tahun'),
		array(60 * 60 * 24 * 30, 'bulan'),
		array(60 * 60 * 24 * 7, 'minggu'),
		array(60 * 60 * 24, 'hari'),
		array(60 * 60, 'jam'),
		array(60, 'menit'),
		);

	$today = time();
	$since = $today - $original;

	if ($since > 604800) {
		$print = date("M jS", $original);
		if ($since > 31536000) {
			$print .= ", " . date("Y", $original);
		}
		return $print;
	}

	for ($i = 0, $j = count($chunks); $i < $j; $i++) {
		$seconds = $chunks[$i][0];
		$name = $chunks[$i][1];

		if (($count = floor($since / $seconds)) != 0) {
			break;
		}
	}

	$print = ($count == 1) ? '1 ' . $name : "$count $name";
	return $print . ' yang lalu';
}
?>