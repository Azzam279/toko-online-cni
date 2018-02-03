<?php
session_start();
session_destroy();
include("../variable.php");
//unset($_SESSION['id_customer']);
//unset($_SESSION['nm_customer']);
header("location: $host/");
?>