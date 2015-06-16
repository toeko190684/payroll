<?php
session_start();
include "../../../configuration/connection_inc.php";

$module=$_GET[r];
$act=$_GET[act];

// Hapus periode
if ($module=='periode' AND $act=='hapus'){
		//cari dulu periode di transaksi payroll
		$cari = mysql_query("select * from payroll where periode_id='$_GET[id]'");
		$jml = mysql_num_rows($cari);
		if($jml>0){
			echo "<script>alert('Periode tersebut memiliki transaksi payroll,tidak dapat dihapus!!');
			     window.history.go(-1);
				 </script>";
		}else{
			mysql_query("DELETE FROM periode WHERE periode_id ='$_GET[id]'");
	        header('location:../../index.php?r='.$module);
		}
}

// Input periode
elseif ($module=='periode' AND $act=='input'){
  // Input data periode
  mysql_query("INSERT INTO periode (periode_id,
                                 tgl_awal,
								 tgl_akhir,
								 tgl_efektif) 
						VALUES ('$_POST[periode_id]',						
						        '$_POST[tgl_awal]',
								'$_POST[tgl_akhir]',
								'$_POST[tgl_efektif]')");
								  

  header('location:../../index.php?r='.$module);
}

// Update periode
elseif ($module=='periode' AND $act=='update'){
  mysql_query("UPDATE periode SET tgl_awal = '$_POST[tgl_awal]',
                                  tgl_akhir = '$_POST[tgl_akhir]',
								  tgl_efektif = '$_POST[tgl_efektif]'
                          WHERE periode_id   = '$_POST[id]'");
  header('location:../../index.php?r='.$module);
}
?>
