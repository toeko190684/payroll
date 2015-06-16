<?php
session_start();
include "../../../configuration/connection_inc.php";

$module=$_GET[r];
$act=$_GET[act];

// Hapus absensi
if ($module=='absensi' AND $act=='hapus'){
		mysql_query("DELETE FROM absensi WHERE id_absen ='$_GET[id]'");
  header('location:../../index.php?r='.$module);
}

// Input absensi
elseif ($module=='absensi' AND $act=='input'){
  // Input data absensi
  mysql_query("INSERT INTO absensi (absensi_id,
                                 absensi_name) 
						VALUES ('$_POST[absensi_id]', 
						        '$_POST[absensi_name]')");
								  

  header('location:../../index.php?r='.$module);
}

// Update absensi
elseif ($module=='absensi' AND $act=='update'){
  mysql_query("UPDATE absensi SET absensi_name = '$_POST[absensi_name]'
                          WHERE absensi_id   = '$_POST[id]'");
  header('location:../../index.php?r='.$module);
}
?>
