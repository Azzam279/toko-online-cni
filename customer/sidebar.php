<div class="col-md-3 col-sm-3" style="padding-right:0;padding-left:0;">
	<div id="sidebar-customer-wrapper">
		<ul class="nav nav-pills nav-stacked">
			<?php $c = @$_GET['c']; ?>
			<li role="presentation" class="<?php if(empty($c)){echo "active";}else{"";}?>">
				<a href="<?php echo "$host/customer/"; ?>">Profile</a>
			</li>
			<li role="presentation" class="<?php if($c=="alamat"){echo "active";}else{"";}?>">
				<a href="<?php echo "$host/customer/?c=alamat"; ?>">Alamat</a>
			</li>
			<li role="presentation" class="<?php if($c=="pesanan-saya"){echo "active";}else{"";}?>">
				<a href="<?php echo "$host/customer/?c=pesanan-saya"; ?>">Pesanan Saya</a>
			</li>
			<li role="presentation" class="<?php if($c=="ubah-password"){echo "active";}else{"";}?>">
				<a href="<?php echo "$host/customer/?c=ubah-password"; ?>">Ubah Password</a>
			</li>
			<li role="presentation">
				<a href="logout.php"><i class="glyphicon glyphicon-log-out"></i> Logout</a>
			</li>
		</ul>
	</div>
</div>