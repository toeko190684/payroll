<?php
include "../../../configuration/connection_inc.php";

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

if($_GET[data]=='golongan'){
	$sth = mysql_query("select * from golongan order by golongan_id");
		$rows = array();
		while($r = mysql_fetch_assoc($sth)) {
			$rows[] = $r;
		}
	print json_encode($rows);
}

if($_GET[data]=='jabatan'){
	$sth = mysql_query("select * from jabatan order by id_jabatan");
		$rows = array();
		while($r = mysql_fetch_assoc($sth)) {
			$rows[] = $r;
		}
	print json_encode($rows);
}

if($_GET[data]=='listview'){
	//cari data payroll
	if($_POST[area_id]==''){
		if($_POST[id_departemen]==''){
			if($_POST[golongan_id]==''){
				if($_POST[id_jabatan]==''){
					$sql = mysql_query("select * from employee");
				}else{
					$sql = mysql_query("select * from employee where id_jabatan='$_POST[id_jabatan]'");
				}
			}else{
				if($_POST[id_jabatan]==''){
					$sql = mysql_query("select * from employee where golongan_id='$_POST[golongan_id]'");
				}else{
					$sql = mysql_query("select * from employee where id_jabatan='$_POST[id_jabatan]' and golongan_id='$_POST[golongan_id]'");
				}
			}
		}else{
			if($_POST[golongan_id]==''){
				if($_POST[id_jabatan]==''){
					$sql = mysql_query("select * from employee where id_departemen='$_POST[id_departemen]'");
				}else{
					$sql = mysql_query("select * from employee where id_jabatan='$_POST[id_jabatan]'
					                    and id_departemen='$_POST[id_departemen]'");
				}
			}else{
				if($_POST[id_jabatan]==''){
					$sql = mysql_query("select * from employee where golongan_id='$_POST[golongan_id]'
					                    and id_departemen='$_POST[id_departemen]'");
				}else{
					$sql = mysql_query("select * from employee where id_jabatan='$_POST[id_jabatan]' and 
					                    golongan_id='$_POST[golongan_id]' and id_departemen='$_POST[id_departemen]'");
				}
			}
		}
	}else{
		if($_POST[id_departemen]==''){
			if($_POST[golongan_id]==''){
				if($_POST[id_jabatan]==''){
					$sql = mysql_query("select * from employee where area_id='$_POST[area_id]'");
				}else{
					$sql = mysql_query("select * from employee where id_jabatan='$_POST[id_jabatan]'
					                    and area_id='$_POST[area_id]'");
				}
			}else{
				if($_POST[id_jabatan]==''){
					$sql = mysql_query("select * from employee where golongan_id='$_POST[golongan_id]'
					                    and area_id='$_POST[area_id]'");
				}else{
					$sql = mysql_query("select * from employee where id_jabatan='$_POST[id_jabatan]' 
					                    and golongan_id='$_POST[golongan_id]' and area_id='$_POST[area_id]'");
				}
			}
		}else{
			if($_POST[golongan_id]==''){
				if($_POST[id_jabatan]==''){
					$sql = mysql_query("select * from employee where id_departemen='$_POST[id_departemen]' 
					                    and area_id='$_POST[area_id]'");
				}else{
					$sql = mysql_query("select * from employee where id_jabatan='$_POST[id_jabatan]'
					                    and id_departemen='$_POST[id_departemen]' and
										area_id='$_POST[area_id]'");
				}
			}else{
				if($_POST[id_jabatan]==''){
					$sql = mysql_query("select * from employee where golongan_id='$_POST[golongan_id]'
					                    and id_departemen='$_POST[id_departemen]' and 
										area_id='$_POST[area_id]'");
				}else{
					$sql = mysql_query("select * from employee where id_jabatan='$_POST[id_jabatan]' and 
					                    golongan_id='$_POST[golongan_id]' and id_departemen='$_POST[id_departemen]'
										and area_id='$_POST[area_id]'");
				}
			}
		}
	}
	
	
	$jml = mysql_num_rows($sql);
	//tampilkan dta detailnya 
	echo "<h6>Laporan Pegawai</h6><br>
	      <table class='table table-hover table-condensed table-bordered'>
	          <tR class='success'>
				<tD>No</td><tD>Area</td><tD>NIP</td><tD>Nama</td><td>Tgl Join</td><tD>Tgl Resign</td>
				<td>Departemen</td><tD>Jabatan</td><td>No.NPWP</td><td>No.Rek BCA</td></tr>";
	$no=1;
	if($jml>0){
		while($r = mysql_fetch_array($sql)){
			echo "<tR>
					<tD>$no</td>
					<tD>$r[area_id]</td>
					<tD>$r[nip]</td>
					<tD>$r[nama_karyawan]</td>
					<td>$r[tgl_masuk_kerja]</td>
					<tD>$r[tgl_berhenti]</td>
					<td>$r[id_departemen]</td>
					<td>$r[id_jabatan]</td>
					<td>$r[npwp]</td>
					<td>$r[no_rek_bank]</td>
				  </tr>";
			$no++;
		}	
	}else{
		echo "<tr><tD colspan='18'>Tidak ada data ditemukan..!</td></tR>";
	}
	echo "</table>";
}
?>
