<?php
/*
created by toeko triyanto
cek login.php adalah file untuk mengecek login dna menuliskan session yang akan digunakan untuk masuk keseluruh aplikasi
*/
session_start();
require_once("configuration/connection_inc.php");
$password = md5($_POST[password]);
$sql = mysql_query("select * from users where username='$_POST[username]' and password='$password' and blokir=0");
$cek = mysql_num_rows($sql);
$r = mysql_fetch_array($sql);
if($cek>0){
	$_SESSION[username] = $r[username];
	$_SESSION[password] = $r[password];
	$_SESSION[level] = $r[level];
	//$_SESSION[status] = $r[status];
	$_SESSION[blokir] = $r[blokir];
	//$_SESSION[lokasi] = $r[lokasi];
	header('location:app/index.php?r=home');
}else{
	echo "<script>alert(\"username atau password yang anda masukan salah .!\");window.history.go(-1);</script>";
}
?>