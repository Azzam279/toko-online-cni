<?php
include("../variable.php");
include("../config.php");
if (empty($_SESSION['admin'])) {
	header("location: /");
}else{
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Administrator</title>
	<?php include("link-css.php"); ?>
</head>
<body>
	
	<?php
	include("navbar.php");
	?>
	<div class="row-fluid">
	<?php
	include("sidebar.php");
	include("content.php");
	?>
	</div>
	
<?php include("link-js.php"); ?>
<script>
	function hapus_produk(val) {
	    swal({
	        title: "Yakin Ingin Hapus Produk Ini?",
	        type: "warning",
	        showCancelButton: true,
	        confirmButtonColor: "#DD6B55",
	        confirmButtonText: "Ya, hapus!",
	        closeOnConfirm: false },
	        function(){
	            window.location = "<?php echo $host.'/admin-cni/proses-produk.php?del="+val+"'; ?>";
	        });
	}	
</script>
</body>
</html>
<?php
}
?>