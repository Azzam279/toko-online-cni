<div class="col-md-9">
	<br>
	<?php
	$adm = @$_GET['adm'];
	if (empty($adm)) {
		include_once("set-produk.php");
	}else if (!empty($adm)) {
		if(is_file("$adm.php")){
			include("$adm.php");
		}else{
			echo "Halaman tidak ditemukan!";
		}
	}
	?>
</div>