<?php
session_start();
include "../../../configuration/connection_inc.php";

$module=$_GET[r];
$act=$_GET[act];

// Hapus grade
if ($module=='grade' AND $act=='hapus'){
		mysql_query("DELETE FROM grade WHERE grade_id ='$_GET[id]'");
  header('location:../../index.php?r='.$module);
}

// Input grade
elseif ($module=='grade' AND $act=='input'){
  // Input data grade
  mysql_query("INSERT INTO grade (grade_id,
                                 grade_name) 
						VALUES ('$_POST[grade_id]', 
						        '$_POST[grade_name]')");
								  

  header('location:../../index.php?r='.$module);
}

// Update grade
elseif ($module=='grade' AND $act=='update'){
  mysql_query("UPDATE grade SET grade_name = '$_POST[grade_name]'
                          WHERE grade_id   = '$_POST[id]'");
  header('location:../../index.php?r='.$module);
}
?>
