<?php
//if (empty($_SESSION['admin'])) {
//	header("location: /");
//}
//echo md5(sha1("q3fg4".md5(hash("ripemd160","admin279"))."93jwe"));
//session_start();
//session_regenerate_id();
//echo session_id();
$rand  = rand(1,2);
if ($rand != 1) {
	echo $rand;
}else{
	rand(1,2);
}
?>