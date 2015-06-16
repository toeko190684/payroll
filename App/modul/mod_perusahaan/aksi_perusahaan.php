<?php
session_start();
include "../../../configuration/connection_inc.php";

$module=$_GET[r];
$act=$_GET[act];

// Hapus perusahaan
if ($module=='perusahaan' AND $act=='hapus'){
		mysql_query("DELETE FROM perusahaan WHERE id_perusahaan ='$_GET[id]'");
  header('location:../../index.php?r='.$module);
}

// Input perusahaan
elseif ($module=='perusahaan' AND $act=='input'){
  // Input data perusahaan
  mysql_query("INSERT INTO perusahaan (id_perusahaan,
                                 nama_perusahaan,
								 nomor_rekening) 
						VALUES ('$_POST[perusahaan_id]', 
						        '$_POST[perusahaan_name]',
								'$_POST[nomor_rekening]')");
								  

  header('location:../../index.php?r='.$module);
}

// Update perusahaan
elseif ($module=='perusahaan' AND $act=='update'){
  mysql_query("UPDATE perusahaan SET nama_perusahaan = '$_POST[perusahaan_name]',
                                     nomor_rekening = '$_POST[nomor_rekening]'
                          WHERE id_perusahaan   = '$_POST[id]'");
  header('location:../../index.php?r='.$module);
}
?>
