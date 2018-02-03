<div class="panel panel-default">
	<div class="panel-heading">Orderan Masuk</div>
	<div class="panel-body">
	    <div id="accordion">
		<?php
		date_default_timezone_set('Asia/Singapore');

		$sql = $db->prepare("SELECT * FROM order_produk INNER JOIN customer ON order_produk.id_customer = customer.id_customer ORDER BY order_produk.tanggal DESC");
		$sql->execute();

		while ($data = $sql->fetch(PDO::FETCH_OBJ)) {
			$bgcolor = ($data->dikirim == "Y") ? "background:#D4FFAA;" : "";
			$checked = ($data->dikirim == "Y") ? "<i class='glyphicon glyphicon-ok'></i>" : "";
		?>
	   		<h3 style="padding:15px 33px; margin-bottom:10px; <?php echo $bgcolor; ?>">
	   			<span class="pull-left"><?php echo "$data->nama ($data->email) $checked"; ?></span>
	   			<span class="pull-right"><?php echo date("D-m-Y H:i:s",$data->tanggal); ?></span>
	   			<span class="clearfix"></span>
	   		</h3>
	   		<div style="background:white;">
	   			<div class="table-responsive">
	   				<table class="table table-condensed table-hover">
	   					<thead>
	   						<tr>
	   							<th style="color:#F46C44;" colspan="2">Produk</th>
	   							<th style="color:#F46C44;">Harga</th>
	   							<th style="color:#F46C44;">Kuantitas</th>
	   							<th style="color:#F46C44;" width="140"><center>Subtotal</center></th>
	   						</tr>
	   					</thead>
	   					<tbody>
		   					<?php
		   					$produk = explode("|",$data->produk);
		   					$gambar = explode("|",$data->gambar);
		   					$harga = explode("|",$data->harga);
		   					$qty = explode("|",$data->kuantitas);
		   					$sub = explode("|",$data->subtotal);
		   					$count = count($produk);
		   					for ($x = 0; $x < $count; $x++) {
		   					?>
	   						<tr>
	   							<td>
	   								<img src="<?php echo "$host/images/produk/$gambar[$x]"; ?>" class="img-responsive" style="width:70px;">
	   							</td>
	   							<td>
	   								<?php echo $produk[$x]; ?>
	   							</td>
	   							<td>
	   								<?php echo "Rp ".number_format($harga[$x],0,",","."); ?>
	   							</td>
	   							<td>
	   								<?php echo $qty[$x]; ?>
	   							</td>
	   							<td align="center">
	   								<?php echo "Rp ".number_format($sub[$x],0,",","."); ?>
	   							</td>
	   						</tr>
	   						<?php
	   						}
	   						?>
	   						<tr>
	   							<td colspan="4">
	   								<b>TOTAL</b>
	   							</td>
	   							<td align="center">
	   								<b><?php echo "Rp ".number_format($data->total,0,",","."); ?></b>
	   							</td>
	   						</tr>
	   						<tr>
	   							<td>
	   								<b>TUJUAN</b>
	   							</td>
	   							<td colspan="4" align="right">
	   								<?php
	   								include_once("function.php");
	   								echo kecamatan($db,$data->kecamatan)." - ".kota($db,$data->kota)." - ".provinsi($db,$data->provinsi);
	   								?>
	   							</td>
	   						</tr>
	   						<tr>
	   							<td colspan="3">
	   								<b>ONGKOS KIRIM</b>
	   							</td>
	   							<td colspan="2">
	   								<?php
	   								$ong_kir = ($data->ongkir == 0) ? "" : $data->ongkir;
	   								?>
	   								<input type="number" id="<?php echo "ongkir$data->id_order"; ?>" style="padding:5px;" value="<?php echo $ong_kir; ?>" placeholder="Masukkan Angka Saja" required>
	   								<button class="btn btn-info" onclick="ongkir(<?php echo $data->id_order; ?>)">Save</button>
	   							</td>
	   						</tr>
	   						<tr>
	   							<td colspan="3">
	   								<b>Status Order</b>
	   							</td>
	   							<td colspan="2">
	   								<select id="<?php echo "status$data->id_order"; ?>" style="padding:8px; width:184px;" onchange="removeDisabled(<?php echo $data->id_order; ?>)" class="status" required>
	   									<?php
	   									$wait = ($data->dikirim == "N") ? "selected" : "";
	   									$send = ($data->dikirim == "Y") ? "selected" : "";
	   									?>
	   									<option value="N" <?php echo $wait; ?>>Menunggu</option>
	   									<option value="Y" <?php echo $send; ?>>Dikirim</option>
	   								</select>
	   								<span id="<?php echo "remove$data->id_order"; ?>">
	   								<button class="btn btn-success" onclick="status(<?php echo $data->id_order; ?>)" id="<?php echo "btn$data->id_order"; ?>">Save</button>
	   								</span>
	   								<script>
	   								var stat = document.getElementById('<?php echo "status$data->id_order"; ?>');
	   								var btn = document.getElementById('<?php echo "btn$data->id_order"; ?>');
	   								if (stat.value == "Y") {
	   									btn.disabled = "disabled";
	   								}
	   								/*function stat_order() {
	   								var stat = document.getElementById('<?php echo "status$data->id_order"; ?>');
	   								var btn = document.getElementById('<?php echo "btn$data->id_order"; ?>');
		   								if (stat.value == "Y") {
		   									btn.disabled = "disabled";
		   								}else{
		   									btn.removeAttribute("disabled");
		   								}
	   								}
	   								setInterval(stat_order, 1000);*/
	   								</script>
	   							</td>
	   						</tr>
	   						<tr>
	   							<td colspan="3">
	   								<b>Nomor Resi</b>
	   							</td>
	   							<td colspan="2">
	   								<?php
	   								$noresi = ($data->no_resi != "") ? $data->no_resi : "";
	   								?>
	   								<input type="text" id="<?php echo "resi$data->id_order"; ?>" style="padding:5px;" placeholder="Masukkan No. Resi" value="<?php echo $noresi; ?>" required>
	   								<button class="btn btn-primary" onclick="resi(<?php echo $data->id_order; ?>)">Save</button>
	   							</td>
	   						</tr>
	   					</tbody>
	   				</table>
	   			</div>
	   			<hr>
	   			<div class="pull-left">
	   				<h4>Alamat</h4>
	   				<p>
	   					<?php echo $data->alamat; ?>
	   				</p>
	   				<h4>Kode Pos</h4>
	   				<p>
	   					<?php echo $data->kode_pos; ?>
	   				</p>
	   				<h4>No. Handphone</h4>
	   				<p>
	   					<?php echo $data->no_hp; ?>
	   				</p>
	   			</div>
	   			<div class="pull-right">
	   				<br>
	   				<p>Nama : <?php echo $data->nama; ?></p>
	   				<p>Jenis Kelamin : <?php echo $data->sex; ?></p>
	   				<p>Tanggal Lahir : <?php echo $data->tgl_lahir; ?></p>
	   			</div>
	   			<div class="clearfix"></div>
	   		</div>
	   	<?php
	   	}
	   	$sql = null;
	   	?>
	    </div>
	</div>
</div>