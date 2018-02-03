<?php
include_once("class.phpmailer.php");
$email = "s4git4rius2@gmail.com";
$nama = "Customer";
$sendmail = new PHPMailer();
$sendmail->From = 'admin@cni-bjb.16mb.com';
$sendmail->FromName = 'CNI-Bjb';
$sendmail->addAddress($email,$nama);
$sendmail->addReplyTo('admin@cni-bjb.16mb.com','Azzam');
$sendmail->Subject = 'Email aktivasi: Aktifkan akun CNI-Bjb Anda melalui Email ini!';
$sendmail->Body = 'Terima kasih atas kepercayaan Anda bergabung sebagai member di cni-bjb.16mb.com! Silakan klik tombol di bawah ini untuk mengaktifkan akun Anda:<br><br>
	<a href="http://cni-bjb.16mb.com/?ak=nmr_customer&kd=newcode" style="padding:10px;background:#4096EE;color:white;text-decoration:none;font-weight:bold;">Aktifkan & Belanja Sekarang</a><br><br><br>
	Jika tombol di atas tidak mengarahkan ke halaman baru, copy URL di bawah ini ke browser Anda:<br>
	<a href="http://cni-bjb.16mb.com/?ak=nmr_customer&kd=newcode">http://cni-bjb.16mb.com/?ak=nmr_customer&kd=newcode</a>
	<br><br>Jika Anda memiliki pertanyaan lebih lanjut, hubungi kami melalui email: admin@cni-bjb.16mb.com<br/><br/><b>Selamat bergabung & selamat berbelanja!</b><br/><a href="cni-bjb.16mb.com" style="color:#4096EE;text-decoration:none;font-weight:bold;">Cni-bjb.16mb.com</a>';
$sendmail->isHTML(true);

if ($sendmail->Send()) {
	echo "Berhasil kirim gan! :D";
}else{
	echo "Gagal kirim bro! :( " . $sendmail->ErrorInfo;
}

/*require 'PHPMailerAutoload.php';

//Create a new PHPMailer instance
$mail = new PHPMailer;
//Set who the message is to be sent from
$mail->setFrom('from@example.com', 'First Last');
//Set an alternative reply-to address
$mail->addReplyTo('replyto@example.com', 'John Doe');
//Set who the message is to be sent to
$mail->addAddress('s4git4rius2@gmail.com', 'Customer');
//Set the subject line
$mail->Subject = 'PHPMailer mail() test';
//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body
$mail->Body = 'Terima kasih atas kepercayaan Anda bergabung sebagai member di cni-bjb.';
//Replace the plain text body with one created manually
$mail->AltBody = 'This is a plain-text message body';

//send the message, check for errors
if (!$mail->send()) {
    echo "Mailer Error: " . $mail->ErrorInfo;
} else {
    echo "Message sent!";
}*/

/*
$to = "s4git4rius2@gmail.com";
$subject = "Testing Doang";
$message = "<html><body>
			<a href='http://eratekno-shop.16mb.com/'><img src='http://eratekno-shop.16mb.com/image/ets-title.png'></a><br><br>
			Kepada Customer .,<br><br>
			Dengan ini kami informasikan bahwa Eratekno-shop.16mb.com telah menerima pemesanan Anda. Berikut kami sertakan detail pemesanan:<br><br>
			<table>
			<tr><td>Nomor Pesanan</td><td>:</td><td>715883</td></tr>
			<tr><td>Tanggal Pemesanan</td><td>:</td>17/06/2015</tr>
			<tr><td>Status</td><td>:</td><td>Menunggu Pembayaran</td></tr>
			<table>

			Bila Anda telah teregistrasi menjadi member di Eratekno-shop.16mb.com, Anda dapat melihat status pemesanan melalui kolom Pesanan Saya. 
			</body></html>";
$header = "To: s4git4rius2@gmail.com"."From: EraTekno-Shop <azzam@eratekno-shop.16mb.com>\n"."MIME-Version: 1.0\n"."Content-type: text/html; charset=iso-8859-1";

$sent_mail = mail($to,$subject,$message,$header);
echo $sent_mail ? "Berhasil kirim" : "Gagal kirim";*/
?>