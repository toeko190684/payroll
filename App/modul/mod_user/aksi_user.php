<?php
session_start();
include "../../../configuration/connection_inc.php";

$module=$_GET[r];
$act=$_GET[act];
$password = md5($_POST[password]);

// Hapus users
if ($module=='user' AND $act=='hapus'){
		mysql_query("DELETE FROM users WHERE username ='$_GET[id]'");
  header('location:../../index.php?r='.$module);
}

// Input users
elseif ($module=='user' AND $act=='input'){
  // Input data users
  mysql_query("INSERT INTO users (username,
                                  password,
								  blokir,
								  level) 
						VALUES ('$_POST[username]', 
						        '$password',
								'$_POST[blokir]',
								'$_POST[level]')");
								  

  header('location:../../index.php?r='.$module);
}

// Update users
elseif ($module=='user' AND $act=='update'){
  if($password==''){
	mysql_query("UPDATE users SET blokir = '$_POST[blokir]',
								level = '$_POST[level]'
                           WHERE username   = '$_POST[id]'");
  }else{
    mysql_query("UPDATE users SET password = '$password',
                                blokir = '$_POST[blokir]',
								level = '$_POST[level]'
                           WHERE username   = '$_POST[id]'");
  }
  header('location:../../index.php?r='.$module);
}
?>
