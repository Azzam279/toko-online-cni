<?php
include_once("variable.php");
include_once("config.php");
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>CNI-Bjb | Contact</title>
	<?php include("link-css.php"); ?>
	<style>
.jumbotron {
background: #358CCE;
color: #FFF;
border-radius: 0px;
}
.jumbotron-sm { padding-top: 24px;
padding-bottom: 24px; }
.jumbotron small {
color: #FFF;
}
.h1 small {
font-size: 24px;
}

.red{
	color:red;
}
	</style>
</head>
<body>
	<div class="container">

		<?php 
		include("navbar.php");
		include("header.php");
		?>

	<div class="jumbotron jumbotron-sm">
	    <div class="container">
	        <div class="row">
	            <div class="col-sm-12 col-lg-12" style="background:#358CCE;">
	                <h1 class="h1" style="background:#358CCE;">
	                    Contact us <small>Feel free to contact us</small>
	                </h1>
	            </div>
	        </div>
	    </div>
	</div>
    <div class="row">
        <div class="col-md-8">
            <div class="well well-sm">
                <form action="<?php echo htmlspecialchars("proses-contact.php") ?>" method="post">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">
                                Name</label>
                            <input type="text" class="form-control" id="name" placeholder="Masukkan nama" required="required" name="name" maxlength="100" autofocus />
                        </div>
                        <div class="form-group">
                            <label for="email">
                                Email Address</label>
                            <div class="input-group">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span>
                                </span>
                                <input type="email" class="form-control" id="email" placeholder="Masukkan email" name="email" maxlength="150" required="required" /></div>
                        </div>
                        <div class="form-group">
                            <label for="subject">
                                Subject</label>
                            <input type="text" name="subject" class="form-control" placeholder="Masukkan subjek" maxlength="60">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">
                                Message</label>
                            <textarea name="message" id="message" class="form-control" rows="9" cols="25" required="required"
                                placeholder="Pesan" maxlength="250"></textarea>
                            <div id="characterLeft"></div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary pull-right" id="btnContactUs" name="kirim">
                            <i class="glyphicon glyphicon-send"></i> Kirim Pesan
                        </button>
                    </div>
                </div>
                </form>
            </div>
        </div>
        <div class="col-md-4">
            <form>
            <legend><span class="glyphicon glyphicon-globe"></span> Our Address</legend>
            <address>
                <strong>Banjarbaru.</strong><br>
                Jl. Kemuning ujung no.17 RT.009 RW.002 Gg.Intan<br>
                Banjarbaru, 70713<br>
                <abbr title="Phone">
                    P:</abbr>
                (0896) 9859-4961
            </address>
            <address>
                <strong>Email</strong><br>
                <a href="mailto:#">muhammad.azzam2579@gmail.com</a>
            </address>
            </form>
        </div>
    </div>
    <br><br><br>

		<?php
		include("footer.php");
		?>

	</div>

<?php include("link-js.php"); ?>
<script>
$(document).ready(function(){
    $('#characterLeft').text('250 karakter tersisa');
    $('#message').keydown(function () {
        var max = 250;
        var len = $(this).val().length;
        if (len >= max) {
            $('#characterLeft').text('Anda telah mencapai batas maksimal!');
            $('#characterLeft').addClass('red');
            $('#btnContactUs').attr('disabled','disabled');            
        } 
        else {
            var ch = max - len;
            $('#characterLeft').text(ch + ' karakter tersisa');
            $('#btnContactUs').removeAttr('disabled');
            $('#characterLeft').removeClass('red');            
        }
    });    
});	
</script>
</body>
</html>