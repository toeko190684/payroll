<?php
/*
created by toeko triyanto
logout.php is a file that used for destroy session user in web browser
*/
  session_start();
  session_destroy();
  header('location:../index.php');

// Apabila setelah logout langsung menuju halaman utama website, aktifkan baris di bawah ini:

//  header('location:http://www.alamatwebsite.com');
?>
