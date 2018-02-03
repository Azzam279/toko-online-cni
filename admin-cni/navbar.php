<?php
if (isset($_SESSION['sukses'])) {
	echo '
	<div id="info" class="alert alert-success page-alert">
		<strong>'.$_SESSION['sukses'].'</strong> <i class="glyphicon glyphicon-ok"></i>
	</div>
	';
	unset($_SESSION['sukses']);
}else if (isset($_SESSION['gagal'])) {
	echo '
	<div id="info" class="alert alert-danger page-alert">
		<strong>'.$_SESSION['gagal'].'</strong> <i class="glyphicon glyphicon-remove"></i>
	</div>
	';
	unset($_SESSION['gagal']);
}else if (isset($_SESSION['peringatan'])) {
	echo '
	<div id="info" class="alert alert-warning page-alert">
		<strong>'.$_SESSION['peringatan'].'</strong> <i class="glyphicon glyphicon-alert"></i>
	</div>
	';
	unset($_SESSION['peringatan']);
}
?>

<nav class="navbar navbar-findcond">
    <div class="container">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="<?php echo "$host/admin-cni/"; ?>">Administrator</a>
		</div>
		<div class="collapse navbar-collapse" id="navbar">
			<ul class="nav navbar-nav navbar-right">
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><?php echo ucfirst($_SESSION['nama']); ?> <span class="caret"></span></a>
					<ul class="dropdown-menu" role="menu">
						<li><a href="<?php echo $host; ?>">Homepage</a></li>
						<li class="divider"></li>
						<li><a href="logout.php">Logout</a></li>
					</ul>
				</li>
			</ul>
			<form class="navbar-form navbar-right search-form" role="search">
				<input type="text" class="form-control" placeholder="Search" />
			</form>
		</div>
	</div>
</nav>