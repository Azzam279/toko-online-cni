<div class="col-md-9 col-sm-9" style="padding-left:0;padding-right:0;">
	<div id="content-customer-wrapper">
		<?php
		if (isset($_GET['c'])) {
			if (is_file("$_GET[c].php")) {
				include("$_GET[c].php");
			}else{
				header("location: $host/customer/");
			}
		}else if (empty($_GET['c'])) {
			include("profile.php");
		}
		?>
	</div>
</div>