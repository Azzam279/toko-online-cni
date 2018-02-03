<?php
include("../variable.php");
if (isset($_SESSION['admin'])) {
	header("location: $host/admin-cni/");
}else{
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Login Admin</title>
	<?php include("link-css.php"); ?>
	<style>
@import url(http://fonts.googleapis.com/css?family=Droid+Sans:400,700);
@import url(http://fonts.googleapis.com/css?family=Cabin:700);

/* latin */
@font-face {
  font-family: 'Droid Sans';
  font-style: normal;
  font-weight: 400;
  src: local('Droid Sans'), local('DroidSans'), url(http://fonts.gstatic.com/s/droidsans/v6/s-BiyweUPV0v-yRb-cjciPk_vArhqVIZ0nv9q090hN8.woff2) format('woff2');
  unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2212, U+2215, U+E0FF, U+EFFD, U+F000;
}
/* latin */
@font-face {
  font-family: 'Droid Sans';
  font-style: normal;
  font-weight: 700;
  src: local('Droid Sans Bold'), local('DroidSans-Bold'), url(http://fonts.gstatic.com/s/droidsans/v6/EFpQQyG9GqCrobXxL-KRMYWiMMZ7xLd792ULpGE4W_Y.woff2) format('woff2');
  unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2212, U+2215, U+E0FF, U+EFFD, U+F000;
}
/* latin */
@font-face {
  font-family: 'Cabin';
  font-style: normal;
  font-weight: 700;
  src: local('Cabin Bold'), local('Cabin-Bold'), url(http://fonts.gstatic.com/s/cabin/v7/82B-3YlzWJm8zbCrVEmc_vesZW2xOQ-xsNqO47m55DA.woff2) format('woff2');
  unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2212, U+2215, U+E0FF, U+EFFD, U+F000;
}

body {
    background: #eee;
}

#wrapper {
    -webkit-perspective: 800px;
    -moz-perspective: 800px;
    -o-perspective: 800px;
    perspective: 800px;
    -webkit-transition: -webkit-transform 1s;
    -moz-transition: -moz-transform 1s;
    -o-transition: -o-transform 1s;
    transition: transform 1s;
    -webkit-transform-style: preserve-3d;
    -moz-transform-style: preserve-3d;
    -o-transform-style: preserve-3d;
    transform-style: preserve-3d;
    margin: 100px auto;
    width: 300px;
    position: relative;
}

.box {
    background: #fff;
	  -webkit-box-sizing: border-box;
	  -moz-box-sizing: border-box;
	  box-sizing: border-box;
    -webkit-transform-style: preserve-3d;
    -webkit-backface-visibility: hidden;
    padding: 25px;
    width: 100%;
    position: absolute;
    top: 0;
    border-radius: 5px;
    box-shadow: 0 2px 1px #e9e9e9;
}

#login input[type="text"], #login input[type="password"], #login button, .back button {
    outline: none;
    -webkit-transition: all 0.3s ease-in-out;
    -moz-transition: all 0.3s ease-in-out;
    -ms-transition: all 0.3s ease-in-out;
    -o-transition: all 0.3s ease-in-out;
    transition: all 0.3s ease-in-out;
    background: #ecf2f4;
    color: #bbc0c2;
    border: none;
    -webkit-box-sizing: border-box;
	-moz-box-sizing: border-box;
	box-sizing: border-box;
    width: 100%;
    padding: 20px 25px;
    font-size: 16px;
    margin: 0 0 15px;
    font-family: droid sans;
    border-radius: 5px;
}

#login button, .back button {
    background: #8eb5e2;
    color: white;
    margin: 0;
    font-size: 24px;
    cursor: pointer;
}

#login button:hover {
    background: #9dc2ed;
}

#login button:active {
    background: #719bcc;
}

[placeholder]:focus::-webkit-input-placeholder {
    -webkit-transition: all 0.2s ease-in-out;
    -moz-transition: all 0.2s ease-in-out;
    -ms-transition: all 0.2s ease-in-out;
    -o-transition: all 0.2s ease-in-out;
    transition: all 0.2s ease-in-out;
    -webkit-transform: translate(120px, 0);
    -moz-transform: translate(120px, 0);
    -ms-transform: translate(120px, 0);
    -o-transform: translate(120px, 0);
    transform: translate(120px, 0);
    opacity: 0;
}

.flip .front {
    -webkit-transform: rotateY(180deg);
    -moz-transform: rotateY(180deg);
    right: 250px;
    top: 50px;
}

.flip .back {
    -webkit-transform: rotateX(0deg) rotateY(0deg);
    -moz-transform: rotateX(0deg) rotateY(0deg);
    z-index: 10;
    right: 0;
    top: 50px;
}

.front {
    -webkit-transform: rotateX(0deg) rotateY(0deg);
    -webkit-transform-style: preserve-3d;
    -webkit-backface-visibility: hidden;
    -moz-transform: rotateX(0deg) rotateY(0deg);
    -moz-transform-style: preserve-3d;
    -moz-backface-visibility: hidden;
    -o-transition: all .4s ease-in-out;
    -ms-transition: all .4s ease-in-out;
    -moz-transition: all .4s ease-in-out;
    -webkit-transition: all .4s ease-in-out;
    transition: all .4s ease-in-out;
  right:0;
}


.default {
    text-align: center;
    margin: 25px 0;
}

.default i {
    color: #f96145;
    font-size: 100px;
    margin: 0 0 10px;
    display: block;
}

.default h1 {
    font-family: Cabin;
    font-weight: 700;
    margin: 0;
    color: #aaaaaa;
}

.back {
    -webkit-transform: rotateY(-180deg);
    -webkit-transform-style: preserve-3d;
    -webkit-backface-visibility: hidden;
    -moz-transform: rotateY(-180deg);
    -moz-transform-style: preserve-3d;
    -moz-backface-visibility: hidden;
    -o-transition: all .4s ease-in-out;
    -ms-transition: all .4s ease-in-out;
    -moz-transition: all .4s ease-in-out;
    -webkit-transition: all .4s ease-in-out;
    transition: all .4s ease-in-out;
    right: 250px;
}

.back h2 {
    font-family: droid sans;
    color: #aaa;
    margin: 0;
}

.back img {
    border-radius: 5px;
    margin: 0 0 15px;
}

.back button {
    background: #f96145;
}

.back button:hover {
    background: #ff7a61;
}

.back button:active {
    background: #e7593f;
}

.back ul {
    color: #aaaaaa;
    padding: 0;
    margin: 0 0 15px;
}

.back ul li {
    cursor: pointer;
    border-bottom: 1px solid #ececec;
    list-style-type: none;
    font-family: Droid Sans;
    margin: 0 0 15px;
    font-size: 13px;
    padding: 0 0 15px;
}

.back ul li i {
    margin-right: 5px;
    color: #ccc;
}

.back ul li span {
    -o-transition: all .2s ease-in-out;
    -ms-transition: all .2s ease-in-out;
    -moz-transition: all .2s ease-in-out;
    -webkit-transition: all .2s ease-in-out;
    transition: all .2s ease-in-out;
    padding: 2px 5px;
    display: block;
    font-size: 12px;
    float: right;
    border: 1px solid #ececec;
    border-radius: 10px;
}

.back ul li:hover span {
    color: white;
    border-color: #444;
    background: #444;
}
	</style>
</head>
<body>
	
	<div class="container">
		<div class="row">
			<div class="col-md-12 col-sm-12">
				<div id="wrapper">
					<form id="login" class="front box" method="post" action="<?php echo htmlspecialchars("proses-login-admin.php") ?>">
					  <div class="default"><i class="fa fa-user"></i><h1>Admin login</h1></div>
					<input type="text" name="user" placeholder="username" required />
					<input type="password" name="pass" placeholder="password" required />
					<button class="login" type="submit" name="login" value="login"><i class="fa fa-sign-in"></i></button>
					</form>

					<!--<div class="back box">
					<center>
					<div style="color:orange;"><i class="fa fa-user fa-5x"></i></div>
					<div style="font-size:17px;font-family:Cabin;font-weight:700;">
						<p>Kolom input username dan Password harus di isi.</p>
					</div>
					</center>
					<button class="logout"><i class="fa fa-undo"></i></button>
					</div>-->

				</div>
			</div>
		</div>
	</div>

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

<?php include("link-js.php"); ?>
<script>
	/*$(".login").click(function() {
	  $("#wrapper").addClass('flip');
	});

	$(".logout").click(function() {
	  $("#wrapper").removeClass('flip');
	});*/
</script>
</body>
</html>
<?php
}
?>