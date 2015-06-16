<?php
session_start();
include "../../../configuration/connection_inc.php";

$module=$_GET[r];
$act=$_GET[act];

// Hapus departemen
if ($module=='departemen' AND $act=='hapus'){
		mysql_query("DELETE FROM departemen WHERE id_departemen ='$_GET[id]'");
  header('location:../../index.php?r='.$module);
}

// Input departemen
elseif ($module=='departemen' AND $act=='input'){
  // Input data departemen
  mysql_query("INSERT INTO departemen (id_departemen,
                                 nama_departemen,
								 prefix) 
						VALUES ('$_POST[departemen_id]', 
						        '$_POST[departemen_name]',
								'$_POST[prefix]')");
								  

  header('location:../../index.php?r='.$module);
}

// Update departemen
elseif ($module=='departemen' AND $act=='update'){
  mysql_query("UPDATE departemen SET nama_departemen = '$_POST[departemen_name]',
									 prefix = '$_POST[prefix]'
                          WHERE id_departemen   = '$_POST[id]'");
  header('location:../../index.php?r='.$module);
}
?>
