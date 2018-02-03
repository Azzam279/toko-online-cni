<a name="top"></a>

<div class="row">
	<div class="col-md-12 col-sm-12" style="padding:0;width:100%;">
		<nav class="navbar navbar-default">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#slider" aria-expanded="false">
					<span class="sr-only">Toggle Navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
			</div>

			<div class="collapse navbar-collapse" id="slider">
				<ul class="nav navbar-nav">
					<?php
					if (isset($_SESSION['id_customer'])) {
					?>
					<li><a href="<?php echo "$host/cart/"; ?>"><i class="glyphicon glyphicon-shopping-cart"></i> My Cart</a></li>
					<li><a href="<?php echo "$host/order/checkout"; ?>"><i class="glyphicon glyphicon-ok"></i> Checkout</a></li>
					<li class="dropdown"><a href="#" class="dropdown-toggle" id="dropdownAkun" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"><i class="glyphicon glyphicon-user"></i> <?php echo ucfirst($_SESSION['nm_customer']) ?> <span class="caret"></span></a>
						<ul class="dropdown-menu" aria-labelledby="dropdownAkun">
							<li><a href="<?php echo "$host/customer/"; ?>"><i class="glyphicon glyphicon-user"></i> My Profile</a></li>
							<li><a href="<?php echo "$host/customer/?c=pesanan-saya"; ?>"><i class="fa fa-cube"></i> Pesanan Saya</a></li>
							<li><a href="<?php echo "$host/customer/logout.php"; ?>"><i class="glyphicon glyphicon-log-out"></i> Logout</a></li>
						</ul>
					</li>
					<?php
					}else{
					?>
					<li><a href="javascript:void(0)" onclick="warning()"><i class="glyphicon glyphicon-shopping-cart"></i> My Cart</a></li>
					<li><a href="javascript:void(0)" onclick="warning()"><i class="glyphicon glyphicon-ok"></i> Checkout</a></li>
					<?php
					}
					?>
				</ul>
				<ul class="nav navbar-nav navbar-right">
					<li><a href="<?php echo $host; ?>"><i class="glyphicon glyphicon-home"></i> Home <span class="sr-only"></span></a></li>
					<li><a href="<?php echo "$host/contact"; ?>"><i class="glyphicon glyphicon-earphone"></i> Hubungi Kami</a></li>
					<li class="dropdown" id="no-rek">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"><i class="glyphicon glyphicon-info-sign"></i> Info Rek.<i class="caret"></i></a>
						<ul class="dropdown-menu">
							<li><img src="<?php echo "$host/images/bank/Mandiri-small.png";?>"> <span style="color:white;">No. Rek 031 0004 669 787</span></li>
						</ul>
					</li>
				</ul>
			</div>
		</nav>
	</div>
</div>