<div class="row">
	<div class="col-md-12 col-lg-12">
		<div class="col-md-8 col-lg-8">
			<div id="myCarousel" class="carousel slide hidden-xs" data-ride="carousel">
			    
		        <!-- Wrapper for slides -->
		        <div class="carousel-inner">
			      
			        <div class="item active">
						<center>
			        	<img src="<?php echo "$host/images/carousel/1.jpg"; ?>">
			        	</center>
			        </div><!-- End Item -->
			 
			         <div class="item">
						<center>
			        	<img src="<?php echo "$host/images/carousel/2.jpg"; ?>">
			        	</center>
			        </div><!-- End Item -->
			        
			        <div class="item">
						<center>
			        	<img src="<?php echo "$host/images/carousel/3.jpg"; ?>">
			        	</center>
			        </div><!-- End Item -->
			        
			        <div class="item">
						<center>
			        	<img src="<?php echo "$host/images/carousel/4.jpg"; ?>">
			        	</center>
			        </div><!-- End Item -->

			        <div class="item">
						<center>
			        	<img src="<?php echo "$host/images/carousel/5.jpg"; ?>">
			        	</center>
			        </div><!-- End Item -->
			                
			    </div><!-- End Carousel Inner -->

			    <ul class="list-group col-sm-4">
			      <li data-target="#myCarousel" data-slide-to="0" class="list-group-item active"><div class="slider-img-wrapper"><img src="<?php echo "$host/images/carousel/1.jpg"; ?>"></div><div class="slider-captions">CNI Ester C Plus</div></li>
			      <li data-target="#myCarousel" data-slide-to="1" class="list-group-item"><div class="slider-img-wrapper"><img src="<?php echo "$host/images/carousel/2.jpg"; ?>"></div><div class="slider-captions">Up Hot Chocolate</div></li>
			      <li data-target="#myCarousel" data-slide-to="2" class="list-group-item"><div class="slider-img-wrapper"><img src="<?php echo "$host/images/carousel/3.jpg"; ?>"></div><div class="slider-captions">UP GREEN TEA</div></li>
			      <li data-target="#myCarousel" data-slide-to="3" class="list-group-item"><div class="slider-img-wrapper"><img src="<?php echo "$host/images/carousel/4.jpg"; ?>"></div><div class="slider-captions">CNI Ginseng Coffee</div></li>
			      <li data-target="#myCarousel" data-slide-to="4" class="list-group-item"><div class="slider-img-wrapper"><img src="<?php echo "$host/images/carousel/5.jpg"; ?>"></div><div class="slider-captions">Up Honey Lemon Tea</div></li>
			    </ul>

				<!-- Controls -->
				<div class="carousel-controls">
				  <a class="left carousel-control" href="#myCarousel" data-slide="prev">
				    <span class="glyphicon glyphicon-chevron-left"></span>
				  </a>
				  <a class="right carousel-control" href="#myCarousel" data-slide="next">
				    <span class="glyphicon glyphicon-chevron-right"></span>
				  </a>
				</div>

			</div><!-- End Carousel -->
		</div>
		<div class="col-md-4 col-lg-4">
			<div id="login-form">
				<?php
				if (isset($_SESSION['id_customer']) && isset($_SESSION['nm_customer'])) {
					echo "<h3>Halo <b>$_SESSION[nm_customer]</b>.</h3>";
				?>
				<a href="<?php echo "$host/customer/"; ?>" class="btn btn-primary btn-block"><i class="glyphicon glyphicon-user"></i> My Profile</a>
				<a href="<?php echo "$host/customer/?c=pesanan-saya"; ?>" class="btn btn-primary btn-block"><i class="fa fa-cube"></i> Pesanan Saya</a>
				<a href="<?php echo "$host/cart/"; ?>" class="btn btn-primary btn-block"><i class="glyphicon glyphicon-shopping-cart"></i> My Cart</a>
				<a href="<?php echo "$host/customer/logout.php"; ?>" class="btn btn-default btn-block"><i class="glyphicon glyphicon-log-out"></i> Logout</a>
				<?php
				}else if (@$_GET['p'] == "lupa-password") {
				?>
				<legend><center><h3><i class="glyphicon glyphicon-user"></i> Perbarui Password</h3></center></legend>
				<form action="<?php echo htmlspecialchars("$host/customer/lupa-password-proses.php"); ?>" method="post">
					<div class="form-group">
						<div class="input-group">
							<span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span><input type="email" name="email" class="form-control" placeholder="Masukkan Email Anda Disini.." autofocus required>
						</div>
					</div>
					<div class="form-group">
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-key"></i></span><input type="password" name="password" class="form-control" placeholder="Masukkan Password Baru Disini.." required>
						</div>
					</div>
					<div class="form-group">
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-key"></i></span><input type="password" name="password2" class="form-control" placeholder="Ketik Ulang Password Disini.." required>
						</div>
					</div>
					<button class="btn btn-default" name="update" value="update"><i class="glyphicon glyphicon-log-in"></i> Update Password</button>
					<a href="<?php echo $host; ?>" class="btn btn-link pull-right"><i class="glyphicon glyphicon-repeat"></i> Kembali</a>
				</form>
				<?php	
				}else{
				?>
				<legend><center><h3><i class="glyphicon glyphicon-user"></i> Sign In</h3></center></legend>
				<form action="<?php echo htmlspecialchars("$host/customer/login-proses.php"); ?>" method="post">
					<div class="form-group">
						<div class="input-group">
							<span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span><input type="email" name="email" class="form-control" placeholder="Masukkan Email Disini.." required>
						</div>
					</div>
					<div class="form-group">
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-key"></i></span><input type="password" name="password" class="form-control" placeholder="Masukkan Password Disini.." required>
						</div>
					</div>
					<button class="btn btn-default" name="login" value="login"><i class="glyphicon glyphicon-log-in"></i> Login</button>
					<a href="<?php echo "$host/register/daftar.php"; ?>" class="btn btn-link"><b>Daftar</b></a>
					<a href="<?php echo "$host/?p=lupa-password"; ?>" class="btn btn-link pull-right">Lupa Password?</a>
				</form>
				<?php
				}
				?>
			</div>
		</div>			
	</div>
</div>
<hr>