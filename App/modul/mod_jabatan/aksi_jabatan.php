<?php
session_start();
include "../../../configuration/connection_inc.php";

$module=$_GET[r];
$act=$_GET[act];

// Hapus jabatan
if ($module=='jabatan' AND $act=='hapus'){
		mysql_query("DELETE FROM jabatan WHERE id_jabatan ='$_GET[id]'");
  header('location:../../index.php?r='.$module);
}

// Input jabatan
elseif ($module=='jabatan' AND $act=='input'){
  // Input data jabatan
  mysql_query("INSERT INTO jabatan (id_jabatan,
                                 nama_jabatan,
								 tnj_jabatan,
								 tnj_transport,
								 tnj_luarkota,
								 uang_makan,
								 uang_pulsa,
								 sewa_motor) 
						VALUES ('$_POST[jabatan_id]', 
						        '$_POST[jabatan_name]',
								'$_POST[tnj_jabatan]',
								'$_POST[tnj_transport]',
								'$_POST[tnj_luarkota]',
								'$_POST[uang_makan]',
								'$_POST[uang_pulsa]',
								'$_POST[sewa_motor]')");
								  

  header('location:../../index.php?r='.$module);
}

// Update jabatan
elseif ($module=='jabatan' AND $act=='update'){
  mysql_query("UPDATE jabatan SET nama_jabatan = '$_POST[jabatan_name]', 
                                  tnj_jabatan = '$_POST[tnj_jabatan]',
								  tnj_transport = '$_POST[tnj_transport]',
								  tnj_luarkota = '$_POST[tnj_luarkota]',
								  uang_makan = '$_POST[uang_makan]',
								  uang_pulsa = '$_POST[uang_pulsa]',
								  sewa_motor = '$_POST[sewa_motor]'
                          WHERE id_jabatan   = '$_POST[id]'");
  header('location:../../index.php?r='.$module);
}
?>
