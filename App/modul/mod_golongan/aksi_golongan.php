<?php
session_start();
include "../../../configuration/connection_inc.php";

$module=$_GET[r];
$act=$_GET[act];

// Hapus golongan
if ($module=='golongan' AND $act=='hapus'){
		mysql_query("DELETE FROM golongan WHERE golongan_id ='$_GET[id]'");
  header('location:../../index.php?r='.$module);
}

// Input golongan
elseif ($module=='golongan' AND $act=='input'){
  // Input data golongan
  mysql_query("INSERT INTO golongan (golongan_id,
                                 gaji_pokok) 
						VALUES ('$_POST[golongan_id]',						
						        '$_POST[gaji_pokok]')");
								  

  header('location:../../index.php?r='.$module);
}

// Update golongan
elseif ($module=='golongan' AND $act=='update'){
  mysql_query("UPDATE golongan SET gaji_pokok = '$_POST[gaji_pokok]'
                          WHERE golongan_id   = '$_POST[id]'");
  header('location:../../index.php?r='.$module);
}
?>
