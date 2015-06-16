<?php
include "../../../configuration/connection_inc.php";


if($_GET[data]=='area'){
	$sth = mysql_query("select * from area order by area_name");
		$rows = array();
		while($r = mysql_fetch_assoc($sth)) {
			$rows[] = $r;
		}
	print json_encode($rows);
}


if($_GET[data]=='listview'){
	//cari data payroll
	if($_POST[area_id]==''){
		if(($_POST[tgl_awal]=='')||($_POST[tgl_akhir]=='')){
			$sql = mysql_query("select * from employee");
		}else{
			$sql = mysql_query("select * from employee where tgl_masuk_kerja between '$_POST[tgl_awal]' and '$_POST[tgl_akhir]'");
		}
	}else{
		if(($_POST[tgl_awal]=='')||($_POST[tgl_akhir]=='')){
			$sql = mysql_query("select * from employee where area_id='$_POST[area_id]'");
		}else{
			$sql = mysql_query("select * from employee where tgl_masuk_kerja between '$_POST[tgl_awal]' and '$_POST[tgl_akhir]'
			                    and area_id='$_POST[area_id]'");
		}
	}
	
	
	$jml = mysql_num_rows($sql);
	//tampilkan dta detailnya 
	echo "<h6>Laporan Pegawai</h6><br>
	      <table class='table table-hover table-condensed table-bordered'>
	          <tR class='success'>
				<tD>No</td><tD>Area</td><td>Jabatan</td><tD>NIP</td><tD>Nama</td><td>JK</td><td>No.KTP</td><td>Alamat KTP</td>
				<td>Tgl Lahir</td><td>Tgl Join</td><tD>Tgl Resign</td></tr>";
	$no=1;
	if($jml>0){
		while($r = mysql_fetch_array($sql)){
			echo "<tR>
					<tD>$no</td>
					<tD>$r[area_id]</td>
					<tD>$r[id_jabatan]</td>
					<tD>$r[nip]</td>
					<td>$r[nama_karyawan]</td>
					<td>$r[jenis_kelamin]</td>
					<td>$r[no_ktp]</td>
					<td>$r[alamat]</td>
					<td>$r[tgl_lahir]</td>
					<td>$r[tgl_masuk_kerja]</td>
					<tD>$r[tgl_berhenti]</td>
				  </tr>";
			$no++;
		}	
	}else{
		echo "<tr><tD colspan='18'>Tidak ada data ditemukan..!</td></tR>";
	}
	echo "</table>";
}
?>
