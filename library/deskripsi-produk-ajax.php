<?php

if (isset($_POST['no_produk'])) {
	include("../config.php");
	$sql = $db->prepare("SELECT keterangan FROM produk WHERE id_produk = :id_produk");
	$sql->execute(array(":id_produk" => $_POST['no_produk']));
	$data = $sql->fetch(PDO::FETCH_OBJ);
	echo $data->keterangan;
}

?>