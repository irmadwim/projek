<?php
require 'config/db.php';
if(!isset($_SESSION['login']) || !$_SESSION['login']){
	echo "<script>alert('Silahkan Login terlebih dahulu')</script>";
	echo "<meta http-equiv='refresh' content='0;url=index.php?page=login-user'>";
}
?>