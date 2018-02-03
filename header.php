<div class="row">
	<div class="col-md-12 col-lg-12">
		<div class="col-md-6">
			<div id="logo">
				<a href="<?php echo $host; ?>">
					<img src="<?php echo "$host/images/cni-sm.png"; ?>" alt="logo">
					<span> - BJB</span>
				</a>
			</div>
		</div>
		<div class="col-md-6">
		<?php
		if (isset($_SESSION['id_customer'])) {
			//mengambil total record berdasarkan id customer
			$sql_cart = $db->prepare("SELECT * FROM cart WHERE id_customer = :id_customer");
			$sql_cart->execute(array(":id_customer" => $_SESSION['id_customer']));
			$total_items = $sql_cart->rowCount();

			//menghitung subtotal utk mendapatkan total
			$cart = $db->prepare("SELECT SUM(subtotal) as total FROM cart WHERE id_customer = :id_customer");
			$cart->execute(array(":id_customer" => $_SESSION['id_customer']));
			$get_total = $cart->fetch(PDO::FETCH_OBJ);
			$total = number_format($get_total->total,0,",",".");
		}else{
			$subtotal = 0;
			$total_items = 0;
			$total = 0;
		}
		?>
			<div id="cart-wrapper" class="pull-right">
				<?php
				if (preg_match("/order\/checkout.php/", $_SERVER['PHP_SELF']) || preg_match("/cart\/index.php/", $_SERVER['PHP_SELF'])) {
				?>
				<a href="<?php echo "$host/cart/"; ?>">
					<div id="price">
						Cart - Rp <?php echo $total; ?>
					</div>
					<div id="cart">
						<i class="glyphicon glyphicon-shopping-cart"></i>
					</div>
					<div id="items-cart">
						<span class="badge" id="total-item"><?php echo $total_items; ?></span>
					</div>
				</a>
				<?php
				}else{
				?>
				<span id="loading_cart"></span>
				<a href="javascript:void(0)" data-toggle="modal" data-target="#myCart" onclick="showCart()">
					<div id="price">
						Cart - Rp <?php echo $total; ?>
					</div>
					<div id="cart">
						<i class="glyphicon glyphicon-shopping-cart"></i>
					</div>
					<div id="items-cart">
						<span class="badge" id="total-item"><?php echo $total_items; ?></span>
					</div>
				</a>

				<a href="javascript:void(0)" id="cart-fixed" data-toggle="modal" data-target="#myCart" onclick="showCart()" class="hidden-xs hidden-sm">
					<div id="cart-2">
						<i class="glyphicon glyphicon-shopping-cart"></i>
					</div>
					<div id="items-cart-2">
						<span class="badge"><?php echo $total_items; ?></span>
					</div>
				</a>
				<?php
				}
				?>
			</div>
			<div class="pull-right" style="margin-right:15px;">
				<script id="_wau43v">var _wau = _wau || [];
				_wau.push(["colored", "yirb9vvggd2p", "43v", "5ea7ff000000"]);
				(function() {var s=document.createElement("script"); s.async=true;
				s.src="http://widgets.amung.us/colored.js";
				document.getElementsByTagName("head")[0].appendChild(s);
				})();</script>
			</div>
		</div>
	</div>
</div>
<br>

<!-- Show cart modal -->
<div class="modal fade" id="myCart" role="dialog" tabindex="-1" aria-labelledby="myCartLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title" id="myCartLabel"><i class="glyphicon glyphicon-shopping-cart"></i> KERANJANG BELANJA <span class="pull-right" style="margin-right:20px;"><small id="modal-heading-items"><?php echo $total_items; ?></small> <small>Items</small></span></h4>
			</div>
			<div class="modal-body">
				<div id="cartResult">
					<center><div class="preloader5"></div></center>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-link pull-left" data-dismiss="modal">Tambah barang lain</button>
				<a href="<?php echo "$host/order/checkout"; ?>" class="btn btn-primary">Lanjut</a>
			</div>
		</div>
	</div>
</div>