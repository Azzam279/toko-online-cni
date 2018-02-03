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
	<title>CNI-Bjb | Troli</title>
	<?php include("../link-css.php"); ?>
</head>
<body>
	<div class="container">

		<?php 
		include("../navbar.php");
		include("../header.php");
		?>
		<div class="row">
			<h2 style="margin-left:15px;"><b>Troli Belanja Saya <i class="fa fa-cart-arrow-down" style="color:blue;"></i></b></h2><br>
			<?php
			$sql_cart = $db->prepare("SELECT * FROM cart INNER JOIN produk ON cart.id_produk = produk.id_produk AND cart.id_customer = :id_customer ORDER BY cart.tgl DESC");
			$sql_cart->execute(array(":id_customer" => $_SESSION['id_customer']));

			if ($sql_cart->rowCount() == 0) {
				echo '
				<div class="col-md-12">
					<center><img src="'.$host.'/images/cart_empty.png" class="img-responsive"></center>
				</div>';
			}else{
			?>
			<div class="col-md-9">
				<div id="detail-cart-wrapper">
					<div class="table-responsive">
						<table class="table">
							<tr style="font-weight:bold;">
								<td colspan="2"><span id="jml_items"><?php echo $sql_cart->rowCount(); ?></span> PRODUK</td>
								<td>HARGA</td>
								<td>KUANTITAS</td>
								<td>SUBTOTAL</td>
							</tr>
							<?php
							while ($troli = $sql_cart->fetch(PDO::FETCH_OBJ)) {
							?>
							<tr bgcolor="#F8F8F8" id="<?php echo "id_cart$troli->id_cart"; ?>">
								<td>
									<img src="<?php echo "$host/images/produk/$troli->gambar"; ?>" class="img-responsive" style="width:80px;">
								</td>
								<td>
									<?php echo $troli->nama; ?><br>
									<span id="<?php echo "hapus_items$troli->id_cart"; ?>">
									<a href="javascript:void(0)" style="display:inline-block;" onclick="del_items(<?php echo $troli->id_cart; ?>)">
										<div class="trash-cart" data-toggle="tooltip" data-placement="bottom" title="Hapus"><i class="glyphicon glyphicon-trash"></i></div>
									</a>
									</span>
								</td>
								<td>
									<?php echo "Rp ".number_format($troli->harga,0,",","."); ?>
								</td>
								<td>
									<select name="qty" class="form-control" style="width:90px;" onchange="quantity(this.value,<?php echo "$troli->id_cart,$troli->harga"; ?>)">
										<?php
										for ($qty=1; $qty <= $troli->stok; $qty++) {
											if ($troli->kuantitas == $qty) {
												echo "
												<option value='$qty' selected>$qty</option>
												";
											}else{
												echo "
												<option value='$qty'>$qty</option>
												";
											}
										}
										?>
									</select>
								</td>
								<td>
									<span id="<?php echo "sub$troli->id_cart"; ?>">
									<?php echo "Rp ".number_format($troli->subtotal,0,",","."); ?>
									</span>
								</td>
							</tr>
							<?php
							}
							?>
						</table>
					</div>
				</div>
			</div>
			<div class="col-md-3">
				<?php
				$sql_total = $db->prepare("SELECT SUM(subtotal) as total FROM cart WHERE id_customer = :id_customer");
				$sql_total->execute(array(":id_customer" => $_SESSION['id_customer']));
				$total = $sql_total->fetch(PDO::FETCH_OBJ);
				?>
				<div id="total-cart-wrapper">
					<div class="pull-left"><b>TOTAL</b><br> (<i>Belum termasuk ongkir</i>)</div>
					<div class="pull-right" id="total_cart2"><?php echo "Rp ".number_format($total->total,0,",","."); ?></div>
					<div class="clearfix"></div><br>
					<a href="<?php echo "$host/order/checkout.php"; ?>" class="btn btn-primary btn-block"><b>Checkout</b> <i class="glyphicon glyphicon-chevron-right"></i></a>
				</div>
			</div>
			<?php
			}
			?>
		</div>
		<br><br><br>
		<?php
		include("../footer.php");
		?>

	</div>

<?php include("../link-js.php"); ?>
<script>
	//proses tambah kuantitas
	function quantity(val,id,price) {
	    $.ajax({
	        url: 'tambah-kuantitas-ajax.php',
	        type: 'POST',
	        dataType: 'html',
	        data: 'cart='+id+'&qty='+val+'&harga='+price,
	        success: function(hasil){
	            $("#total_cart2").html(hasil);
	        }
	    });

	    $.ajax({
	        url: 'tambah-kuantitas-ajax.php',
	        type: 'POST',
	        dataType: 'html',
	        data: 'select=total',
	        success: function(hasil2){
	            $("#price").html(hasil2);
	        }
	    });

	    $.ajax({
	    	url: 'tambah-kuantitas-ajax.php',
	        type: 'POST',
	        dataType: 'html',
	        data: 'select=subtotal&cart='+id,
	        success: function(hasil3){
	            $("#sub"+id).html(hasil3);
	        }
	    });
	}

	//proses hapus item dikeranjang/cart
	function del_items(id) {
		$.ajax({
			url: 'hapus-items-ajax.php',
	        type: 'POST',
	        dataType: 'html',
	        data: 'nmr='+id,
	        beforeSend: function(){
	            $("#hapus_items"+id).addClass("preloader6");
	        },
	        success: function(hasil){
	        	$("#id_cart"+id).slideUp();
	            $("#cart-wrapper").html(hasil);
	        }
		});

		$.ajax({
			url: 'hapus-items-ajax.php',
	        type: 'POST',
	        dataType: 'html',
	        data: 'gets=total',
	        success: function(hasil2){
	            $("#total_cart2").html(hasil2);
	        }
		});

		$.ajax({
			url: 'hapus-items-ajax.php',
	        type: 'POST',
	        dataType: 'html',
	        data: 'get2=items',
	        success: function(hasil3){
	            $("#jml_items").html(hasil3);
	        }
		});
	}
</script>
</body>
</html>
<?php
}
?>