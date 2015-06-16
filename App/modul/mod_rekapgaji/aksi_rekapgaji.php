<?php
include "../../../configuration/connection_inc.php";

if($_GET[data]=='cek_periode'){
	$sth = mysql_query("select * from periode where periode_id='$_POST[id]'");
		$rows = array();
		while($r = mysql_fetch_assoc($sth)) {
			$rows = $r;
		}
	print json_encode($rows);
}

if($_GET[data]=='departemen'){
	$sth = mysql_query("select * from departemen order by id_departemen");
		$rows = array();
		while($r = mysql_fetch_assoc($sth)) {
			$rows[] = $r;
		}
	print json_encode($rows);
}

if($_GET[data]=='area'){
	$sth = mysql_query("select * from area order by area_name");
		$rows = array();
		while($r = mysql_fetch_assoc($sth)) {
			$rows[] = $r;
		}
	print json_encode($rows);
}

if($_GET[data]=='listview'){
	$day = date('d',strtotime($_POST[tgl_efektif]));
	$bln = date('m',strtotime($_POST[tgl_efektif]));
	$thn = date('Y',strtotime($_POST[tgl_efektif]));
	
	//cari data payroll
	if($_POST[area_id]==''){
		if($_POST[id_departemen]==''){
			$sql = mysql_query("SELECT c.area_name,b.id_departemen,a.* FROM payroll a,employee b,area c WHERE a.nip=b.nip 
	                    and b.area_id=c.area_id and a.periode_id='$_POST[id]'");
		}else{
			$sql = mysql_query("SELECT c.area_name,b.id_departemen,a.* FROM payroll a,employee b,area c WHERE a.nip=b.nip 
	                    and b.area_id=c.area_id and a.periode_id='$_POST[id]' and b.id_departemen='$_POST[id_departemen]'");
		}
	}else{
		if($_POST[id_departemen]==''){
			$sql = mysql_query("SELECT c.area_name,b.id_departemen,a.* FROM payroll a,employee b,area c WHERE a.nip=b.nip 
	                    and b.area_id=c.area_id and a.periode_id='$_POST[id]' and b.area_id='$_POST[area_id]'");
		}else{
			$sql = mysql_query("SELECT c.area_name,b.id_departemen,a.* FROM payroll a,employee b,area c WHERE a.nip=b.nip 
	                    and b.area_id=c.area_id and a.periode_id='$_POST[id]' and b.area_id='$_POST[area_id]'
						and b.id_departemen='$_POST[id_departemen]'");
		}
	}
	$jml = mysql_num_rows($sql);
	//tampilkan dta detailnya 
	echo "<h6>Rekap Pembayaran Gaji<br>Periode : ".date('d M Y',strtotime($_POST[tgl_awal]))." - ".date('d M Y',strtotime($_POST[tgl_akhir]))."</h6><br>
	      <table class='table table-hover table-condensed table-bordered'>
	          <tR class='success'>
				<tD>No</td><tD>NIK</td><tD>Nama Karyawan</td><tD>Area</td><td>Departemen</td><tD>HK</td>
				<td>Gaji</td><tD>T.Jabatan</td><td>U.Makan</td><td>Transport</td><td>Sewa Motor</td>
				<td>Pulsa</td><td>Luar Kota</td><td>Lain-lain</td><td>Insentive</td><td>Potongan</td>
				<td>Jamsostek</tD><td>THP</td>
			  </tr>";
	$no=1;
	if($jml>0){
		while($r = mysql_fetch_array($sql)){
			echo "<tR>
					<tD>$no</td>
					<tD>$r[nip]</td>
					<tD>$r[nama_karyawan]</td>
					<tD>$r[area_name]</td>
					<td>$r[id_departemen]</td>
					<tD>$r[jml_masuk]</td>
					<td>".number_format($r[gaji_pokok],0,'.',',')."</td>
					<td>".number_format($r[tnj_jabatan],0,'.',',')."</td>
					<td>".number_format($r[uang_makan],0,'.',',')."</td>
					<td>".number_format($r[tnj_transport],0,'.',',')."</td>
					<td>".number_format($r[sewa_motor],0,'.',',')."</td>
					<td>".number_format($r[uang_pulsa],0,'.',',')."</td>
					<td>".number_format($r[tnj_luarkota],0,'.',',')."</td>				
					<td>".number_format($r[lain_lain],0,'.',',')."</td>
					<td>".number_format($r[incentif],0,'.',',')."</td>
					<td>".number_format($r[potongan],0,'.',',')."</td>				
					<td>".number_format($r[jamsostek],0,'.',',')."</td>
					<td>".number_format($r[gaji_bersih],0,'.',',')."</td>
				  </tr>";
			$tot_gaji_pokok = $tot_gaji_pokok + $r[gaji_pokok];
			$tot_tnj_jabatan = $tot_tnj_jabatan + $r[tnj_jabatan];
			$tot_uang_makan = $tot_uang_makan + $r[uang_makan];
			$tot_tnj_transport = $tot_tnj_transport + $r[tnj_transport];
			$tot_sewa_motor = $tot_sewa_motor + $r[sewa_motor];
			$tot_uang_pulsa = $tot_uang_pulsa + $r[uang_pulsa];
			$tot_tnj_luarkota = $tot_tnj_luarkota + $r[tnj_luarkota];
			$tot_lain_lain = $tot_lain_lain + $r[lain_lain];
			$tot_incentif = $tot_incentif + $r[incentif];
			$tot_potongan = $tot_potongan + $r[potongan];
			$tot_jamsostek = $tot_jamsostek + $r[jamsostek];
			$tot_gaji_bersih = $tot_gaji_bersih + $r[gaji_bersih];
			$no++;
		}	
		echo "<tR>
				<td colspan=2></td><td colspan=4><b>TOTAL</b></td>
				<td><b>".number_format($tot_gaji_pokok,0,'.',',')."</b></td>
				<td><b>".number_format($tot_tnj_jabatan,0,'.',',')."</b></td>
				<td><b>".number_format($tot_uang_makan,0,'.',',')."</b></td>
				<td><b>".number_format($tot_tnj_transport,0,'.',',')."</b></td>
				<td><b>".number_format($tot_sewa_motor,0,'.',',')."</b></td>
				<td><b>".number_format($tot_uang_pulsa,0,'.',',')."</b></td>
				<td><b>".number_format($tot_tnj_luarkota,0,'.',',')."</b></td>
				<td><b>".number_format($tot_lain_lain,0,'.',',')."</b></td>
				<td><b>".number_format($tot_incentif,0,'.',',')."</b></td>
				<td><b>".number_format($tot_potongan,0,'.',',')."</b></td>
				<td><b>".number_format($tot_jamsostek,0,'.',',')."</b></td>
				<td><b>".number_format($tot_gaji_bersih,0,'.',',')."</b></td>
			 </tr>";
	}else{
		echo "<tr><tD colspan='18'>Tidak ada data ditemukan..!</td></tR>";
	}
	echo "</table>";
}
?>
