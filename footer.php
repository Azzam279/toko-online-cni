<footer class="row">
	<div class="col-md-12 col-lg-12 col-sm-12" id="footer">
		<div class="well well-sm">
			<div class="metode">
				<h5>METODE PEMBAYARAN</h5>
				<div class="transfer">
					<div class="metode-title">TRANSFER: </div>
					<div><img src="<?php echo "$host/images/bank/BCA-small.png"; ?>"></div>
					<div><img src="<?php echo "$host/images/bank/Mandiri-small.png"; ?>"></div>
					<div class="metode-title">COD: </div>
					<div><img src="<?php echo "$host/images/metode-bayar/cod_logo-small.png"; ?>"></div>
					<div class="metode-title">JASA PENGIRIMAN: </div>
					<div><img src="<?php echo "$host/images/kurir/JNE2.png"; ?>"></div>
					<div><img src="<?php echo "$host/images/kurir/TIKI2.png"; ?>"></div>
				</div>
			</div>
			<hr>
			<div class="footer1">
				<div class="main-footer">
					<div class="part-footer">
						<h4>CNI-Bjb</h4>
						<p class="caption">
							CNI-Bjb adalah toko online yang menjual produk-produk Makanan Kesehatan, Makanan dan Minuman, dan Perawatan Diri. 
						</p>
					</div>
					<div class="part-footer">
						<h4><i class="glyphicon glyphicon-earphone"></i> Hubungi Kami</h4>
						<p class="caption">
							Anda dapat menghubungi kami melalui kontak kami dibawah ini atau anda dapat juga bertanya melalui halaman <a href="<?php echo "$host/contact.php"; ?>" title="contact us">Contact Us</a> yang ada di website Kami.
						</p>
						<ul>
							<li><i class="glyphicon glyphicon-phone"></i> No. Handphone | 089698594961</li>
							<li><i class="glyphicon glyphicon-envelope"></i> Email | muhammad.azzam2579@gmail.com</li>
						</ul>
					</div>
				</div>
			</div>
			<div id="copyright">
				<div>
					Copyright @ 2015 by <a href="#">Azzam</a>
				</div>
			</div>
		</div>
	</div>

	<input type='hidden' value='<?php echo $host;?>' id='host'>
</footer>

<?php
if (isset($_SESSION['sukses'])) {
	echo '
	<div id="info" class="alert alert-success page-alert">
		<i class="glyphicon glyphicon-ok"></i> <strong>'.$_SESSION['sukses'].'</strong>
	</div>
	';
	unset($_SESSION['sukses']);
}else if (isset($_SESSION['gagal'])) {
	echo '
	<div id="info" class="alert alert-danger page-alert">
		<i class="glyphicon glyphicon-remove"></i> <strong>'.$_SESSION['gagal'].'</strong>
	</div>
	';
	unset($_SESSION['gagal']);
}else if (isset($_SESSION['peringatan'])) {
	echo '
	<div id="info" class="alert alert-warning page-alert">
		<i class="glyphicon glyphicon-alert"></i> <strong>'.$_SESSION['peringatan'].'</strong>
	</div>
	';
	unset($_SESSION['peringatan']);
}
ob_end_flush();
?>