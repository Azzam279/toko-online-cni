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
	<title>CNI-Bjb | Customer</title>
	<?php include("../link-css.php"); ?>
</head>
<body>
	<div class="container">

		<?php
		include("../navbar.php");
		include("../header.php");
		?>
		<div class="row">
		<div class="col-md-12">
		<?php
		include("sidebar.php");
		include("content.php");
		?>
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
			url: host+'/customer/select-alamat-ajax.php',
			type: 'POST',
			datatype: 'php',
			data: 'pick_city='+c+'&sesi='+s,
			success: function(hasil){
				$('#city').html(hasil);
			},
		});
		$("#ko").remove();
		$("#kec").remove();
		$("#city").html("Loading...");
		$("#kcmt").html("Loading...");
	}

	function pilihKecamatan(k,s) {
		$.ajax({
			url: host+'/customer/select-alamat-ajax.php',
			type: 'POST',
			datatype: 'php',
			data: 'pick_kcm='+k+'&sesi2='+s,
			success: function(hasil){
				$('#kcmt').html(hasil);
			},
		});
		$("#kec").remove();
		$("#hpus_kec").remove();
		$("#kcmt").html("Loading...");
	}
</script>
</body>
</html>
<?php
}
?>