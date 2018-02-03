<?php
include_once("../variable.php");
if (isset($_SESSION['id_customer'])) {
	include_once("../config.php");
	//mengambil data dari table cart dan produk
	$data_items = $db->prepare("SELECT * FROM cart INNER JOIN produk ON cart.id_produk = produk.id_produk AND cart.id_customer = :id_customer ORDER BY cart.tgl DESC");
	$data_items->execute(array(":id_customer" => $_SESSION['id_customer']));

	//mengambil total data cart berdasarkan id customer
	$get_items = $db->prepare("SELECT id_cart FROM cart WHERE id_customer = :id_customer");
	$get_items->execute(array(":id_customer" => $_SESSION['id_customer']));
	$get = $get_items->rowCount();
	$get_items = null;
?>
<div class="row">
	<div class="col-md-12">
		<div id="cart-loading">
			<div class="preloader5" style="left:50%;top:50%;margin:-15px 0 0 -15px;position:absolute"></div>
		</div>
		<?php
		if ($get == 0) {
		echo "
		<div>
			<h4><center>Keranjang Anda kosong! Silakan berberlanja.</center></h4>
		</div>
		";
		}else{

		while ($items = $data_items->fetch(PDO::FETCH_OBJ)) {
		?>
		<div class="isi-semua-produk" id="id<?php echo $items->id_cart; ?>">
			<div>
				<img src="<?php echo "$host/images/produk/$items->gambar"; ?>" class="img-responsive">
			</div>
			<div>
				<h5>
				<?php
				if ($items->nama > 20) {
					echo substr($items->nama,0,20)."...";
				}else{
					echo $items->nama;
				}
				?>
				</h5>
				<h6><?php echo "Rp ".number_format($items->harga,0,",","."); ?></h6>
			</div>
			<div>
				<select class="form-control" onchange="quantity(this.value,<?php echo "$items->id_cart,$items->harga"; ?>)">
					<?php
					for ($x=1; $x <= $items->stok; $x++) {
						if ($items->kuantitas == $x) {
							echo '
							<option value="'.$x.'" selected>'.$x.'</option>
							';
						}else{
							echo '
							<option value="'.$x.'">'.$x.'</option>
							';
						}
					}
					?>
				</select>
			</div>
			<div id="<?php echo "hapus_item$items->id_cart";?>">
				<a href="javascript:void(0)" title="Hapus" onclick="del_item(<?php echo $items->id_cart;?>)">
					<div id="trash-cart"><i class="glyphicon glyphicon-trash"></i></div>
				</a>
			</div>
			<div class="clearfix"></div>
		</div>
		<?php
		}
		$data_items = null;
		?>

		<div class="info-total-harga clearfix">
			<ul>
				<li>
					<?php
					$sql_total = $db->prepare("SELECT SUM(subtotal) as total FROM cart WHERE id_customer = :id_customer");
					$sql_total->execute(array(":id_customer" => $_SESSION['id_customer']));
					$total = $sql_total->fetch(PDO::FETCH_OBJ);
					?>
					<div class="pull-left">Total Harga Barang :</div>
					<div class="pull-right" id="total_cart">Rp <?php echo number_format($total->total,0,",","."); ?></div>
					<?php $sql_total = null; ?>
				</li>
			</ul>
		</div>
		<?php
		}
		?>
	</div>
</div>
<?php
}else{
	echo "
	<div>
		<h4><center>Keranjang Anda kosong! Silakan berberlanja.</center></h4>
	</div>
	";
}
?>

<script>
	//proses tambah kuantitas
	function quantity(val,id,price) {
	    $.ajax({
	        url: 'library/tambah-kuantitas-ajax.php',
	        type: 'POST',
	        dataType: 'html',
	        data: 'cart='+id+'&qty='+val+'&harga='+price,
	        beforeSend: function(){
	            $("#cart-loading").css("display","block");
	        },
	        success: function(hasil){
	            $("#total_cart").html(hasil);
	            $("#cart-loading").hide();
	        }
	    });

	    $.ajax({
	        url: 'library/tambah-kuantitas-ajax.php',
	        type: 'POST',
	        dataType: 'html',
	        data: 'select=total',
	        success: function(hasil2){
	            $("#price").html(hasil2);
	        }
	    });
	}

	//proses hapus item dikeranjang/cart
	function del_item(id) {
		$.ajax({
			url: 'library/hapus-items-ajax.php',
	        type: 'POST',
	        dataType: 'html',
	        data: 'nmr='+id,
	        beforeSend: function(){
	            $("#loading_cart").addClass("preloader5");
	            $("#hapus_item"+id).addClass("preloader6");
	        },
	        success: function(hasil){
	        	$("#id"+id).slideUp();
	            $("#cart-wrapper").html(hasil);
	        }
		});

		$.ajax({
			url: 'library/hapus-items-ajax.php',
	        type: 'POST',
	        dataType: 'html',
	        data: 'get=total',
	        success: function(hasil2){
	            $("#total_cart").html(hasil2);
	        }
		});

		$.ajax({
			url: 'library/hapus-items-ajax.php',
	        type: 'POST',
	        dataType: 'html',
	        data: 'get2=items',
	        success: function(hasil3){
	            $("#modal-heading-items").html(hasil3);
	        }
		});
	}
</script>