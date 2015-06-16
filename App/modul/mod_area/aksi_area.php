<?php
session_start();
include "../../../configuration/connection_inc.php";

$module=$_GET[r];
$act=$_GET[act];

// Hapus area
if ($module=='area' AND $act=='hapus'){
		mysql_query("DELETE FROM area WHERE area_id ='$_GET[id]'");
  header('location:../../index.php?r='.$module);
}

// Input area
elseif ($module=='area' AND $act=='input'){
  // Input data area
  mysql_query("INSERT INTO area (area_id,
                                 area_name) 
						VALUES ('$_POST[area_id]', 
						        '$_POST[area_name]')");
								  

  header('location:../../index.php?r='.$module);
}

// Update area
elseif ($module=='area' AND $act=='update'){
  mysql_query("UPDATE area SET area_name = '$_POST[area_name]'
                          WHERE area_id   = '$_POST[id]'");
  header('location:../../index.php?r='.$module);
}
?>
