<br>
<div class="pull-left">
	<h3><b>Produk CNI</b></h3>
</div>
<div class="pull-right">
	<?php
	$total_produk = $db->prepare("SELECT * FROM produk");
	$total_produk->execute();
	$total = $total_produk->rowCount();
	$total_produk = null;
	?>
	<small><?php echo $total; ?> Produk</small>
</div>
<div class="clearfix"></div>

<div class="row produk-list">
	<?php
	$sql_produk = $db->prepare("SELECT * FROM produk ORDER BY id_produk DESC");
	$sql_produk->execute();

	$count = 0;
	while ($produk = $sql_produk->fetch(PDO::FETCH_OBJ)) {
		if ($count == 2) {
			echo "
			</div>
			<div class='row produk-list'>
			";
			$count = 0;
		}

		if (strlen($produk->keterangan) > 100) {
			$ket = substr($produk->keterangan, 0,100)."... - <a href='javascript:void(0)' onclick='readmore($produk->id_produk)' id='loading$produk->id_produk'>Selengkapnya</a>";
		}else{
			$ket = $produk->keterangan;
		}
	?>
	<div class="col-md-6 produk-wrapper">
		<div class="thumbnail">
			<div class="col-md-6">
				<center>
					<img src="<?php echo "$host/images/produk/$produk->gambar"; ?>" alt="produk" class="img-responsive">
				</center>
			</div>
			<div class="col-md-6">
				<p class="caption">
					<h4><?php echo $produk->nama; ?></h4>
					<h5>Rp <?php echo number_format($produk->harga,0,",","."); ?></h5>
					<span class="ket-produk" id="<?php echo "id$produk->id_produk"; ?>"><?php echo $ket; ?></span>
				</p>
				<?php
				if (empty($_SESSION['id_customer'])) {
				?>
				<button class="btn btn-primary" style="margin-bottom:10px;" data-toggle="tooltip" data-placement="right" title="Anda harus login">Beli</button>
				<?php
				}else if ($produk->stok == 0) {
				?>
				<button class="btn btn-primary" style="margin-bottom:10px;" id="stok-kosong">Beli</button>
				<?php	
				}else{
				?>
				<button class="btn btn-primary" style="margin-bottom:10px;" onclick="beliProduk(<?php echo $produk->id_produk; ?>,<?php echo $produk->harga; ?>,<?php echo $produk->stok; ?>,'<?php echo $produk->nama; ?>')" id="<?php echo "waiting$produk->id_produk"; ?>">Beli</button>
				<?php
				}
				?>
			</div>
		</div>
	</div>
	<?php
		$count++;
	}
	$sql_produk = null;
	?>
</div>