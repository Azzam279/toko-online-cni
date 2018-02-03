<div class="row">
	<div class="col-md-12">
		<div>
			<h2><b>Pesanan Saya</b></h2><br>
			<?php
			$sql = $db->prepare("SELECT * FROM order_produk WHERE id_customer = :id_customer");
			$sql->execute(array(":id_customer" => $_SESSION['id_customer']));

			if ($sql->rowCount() == 0) {
				echo "<br>";
				echo "<center><img src='$host/images/empty-new.jpg'></center>";
			}

			while ($data = $sql->fetch(PDO::FETCH_OBJ)) {
			?>
			<div class="table-responsive" style="border-radius:4px">
				<table class="table table-condensed">
					<thead>
						<tr bgcolor="#7FAAFF">
							<th colspan="2">Produk</th>
							<th>Harga</th>
							<th>Kuantitas</th>
							<th>Subtotal</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$produk = explode("|", $data->produk);
						$gambar = explode("|", $data->gambar);
						$harga = explode("|", $data->harga);
						$qty = explode("|", $data->kuantitas);
						$sub = explode("|", $data->subtotal);
						$count = count($produk);
						for ($x = 0; $x < $count; $x++) {
						?>
						<tr>
							<td>
								<img src="<?php echo "$host/images/produk/$gambar[$x]"; ?>" style="width:60px;" class="img-responsive">
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
							<td>
								<?php echo "Rp ".number_format($sub[$x],0,",","."); ?>
							</td>
						</tr>
						<?php
						}
						?>
						<tr>
							<td colspan="4"><b>Subtotal</b></td>
							<td><b><?php echo "Rp ".number_format($data->total,0,",","."); ?></b></td>
						</tr>
						<?php
						$ongkir = ($data->ongkir == 0) ? "Menunggu" : "Rp ".number_format($data->ongkir,0,",",".");
						?>
						<tr>
							<td colspan="4"><b>Ongkir</b></td>
							<td><b><?php echo $ongkir; ?></b></td>
						</tr>
						<tr>
						<?php
						$total1 = $data->total + $data->ongkir;
						$total  = ($data->ongkir == 0) ? "Menunggu" : "Rp ".number_format($total1,0,",",".");
						?>
							<td colspan="4"><b>Total</b></td>
							<td><b><?php echo $total; ?></b></td>
						</tr>
						<?php
						$status = ($data->dikirim == "Y") ? "<font color='#55FF2A'>Dikirim</font>" : "Menunggu";
						?>
						<tr>
							<td colspan="4"><b>Status Order</b></td>
							<td><b><?php echo $status; ?></b></td>
						</tr>
						<tr>
						<?php
						$resi = (!empty($data->no_resi)) ? $data->no_resi : "-";
						?>
							<td colspan="4"><b>Nomor Resi</b></td>
							<td><b><?php echo $resi; ?></b></td>
						</tr>
					</tbody>
				</table>
			</div>
			<div style="margin-top:10px;">
				<div class="pull-left">
					<?php
					if (!empty($data->ongkir) && $data->dikirim == "N") {
					?>
					<p style="color:#F46C44;font-weight:700;">Segera lakukan pembayaran ke rekening dibawah ini:</p>
					<!--<p style="color:#F46C44;font-weight:700;">Segera lakukan pembayaran ke salah satu rekening dibawah ini:</p>
					<div class="bank-wrapper">
						<span><img src="<?php echo "$host/images/bank/BCA-small.png"; ?>" class="img-responsive"></span>
						<span>No. Rek 676 023 0xxx</span>
					</div>-->
					<div class="clearfix"></div>
					<div class="bank-wrapper">
						<span><img src="<?php echo "$host/images/bank/Mandiri-small.png"; ?>" class="img-responsive"></span>
						<span>No. Rek 031 0004 669 787</span>
					</div>
					<?php
					}
					?>
				</div>
				<div class="pull-right">
					<?php
					date_default_timezone_set('Asia/Singapore');
					echo date("d-m-Y H:i:s",$data->tanggal);
					?>
				</div>
				<div class="clearfix"></div>
			</div>
			<hr><br>
			<?php
			}
			?>
		</div>
	</div>
</div>