<?php
require_once("../configuration/connection_inc.php");
if($_GET[data]=='periode'){
	if($_POST[id]==''){
		$sth = mysql_query("select * from periode order by periode_id desc");
		$rows = array();
		while($r = mysql_fetch_assoc($sth)) {
			$rows[] = $r;
		}
	}else{
		$sth = mysql_query("select * from periode where periode_id='$_POST[id]'");
		$rows = array();
		while($r = mysql_fetch_assoc($sth)) {
			$rows = $r;
		}
	}	
	print json_encode($rows);
}

if($_GET[data]=='cek_payroll'){
	$sql = mysql_query("select * from payroll where periode_id = '$_POST[periode_id]' and nip='$_POST[id]'");
	$r = mysql_num_rows($sql);
	if($r>0){
		echo "NIP $_POST[id] sudah pernah dimasukan ke payrol periode : $_POST[periode_id]";
	}
}

if($_GET[data]=='employee'){
    if($_POST[id]==''){
		$sth = mysql_query("SELECT a.nip,a.nama_karyawan,a.id_jabatan,b.nama_jabatan FROM employee a,jabatan b where a.id_jabatan=b.id_jabatan  
		                   and a.jenis_pegawai='aktif' order by a.nama_karyawan");
		$rows = array();
		while($r = mysql_fetch_assoc($sth)) {
			$rows[] = $r;
		}
	}else{
		$sth = mysql_query("SELECT a.nip,a.nama_karyawan,c.golongan_id,b.*,c.gaji_pokok FROM employee a,jabatan b, golongan c 
		                   where a.id_jabatan=b.id_jabatan and a.golongan_id=c.golongan_id  
		                   and a.jenis_pegawai='aktif' and a.nip='$_POST[id]' order by a.nama_karyawan");
		$rows = array();
		while($r = mysql_fetch_assoc($sth)) {
			$rows = $r;
		}
	}	
	print json_encode($rows);
}

if($_GET[data]=='simpan_payroll'){
    $prefix = 'PYL'.date('y',strtotime($_POST[endday])).date('m',strtotime($_POST[endday]));
	$periode = date('y',strtotime($_POST[endday])).date('m',strtotime($_POST[endday]));
	$number = mysql_query("select ifnull(max(substring(payroll_id,8,4)),0)+1 as no from payroll where substring(payroll_id,4,4)='$periode'");
	$rnumber = mysql_fetch_array($number);
	$pn = strlen($rnumber[no]);
	switch  ($pn){
		case 1 : $nomor = $prefix.'00'.$rnumber[no]; 
		         break;
		case 2 : $nomor = $prefix.'0'.$rnumber[no]; 
		         break;
		case 3 : $nomor = $prefix.$rnumber[no]; 
		         break;
	}

	$sql = mysql_query("insert into payroll(payroll_id,
	                                        nip,
											nama_karyawan,
											jml_masuk,
											date,
											periode_id,
											startday,
											endday,
											gaji_pokok,
											tnj_jabatan,
											tnj_transport,
											tnj_luarkota,
											uang_makan,
											uang_pulsa,
											sewa_motor,
											incentif,
											lain_lain,
											potongan,
											gaji_kotor,
											gaji_bersih)
									values('$nomor',
									       '$_POST[nip]',
										   '$_POST[nama_karyawan]',
										   '$_POST[jml_hari]',
										   curdate(),
										   '$_POST[periode_id]',
										   '$_POST[startday]',
										   '$_POST[endday]',
										   '$_POST[gaji_pokok]',
										   '$_POST[tnj_jabatan]',
										   '$_POST[tnj_transport]',
										   '$_POST[tnj_luar_kota]',
										   '$_POST[uang_makan]',
										   '$_POST[uang_pulsa]',
										   '$_POST[sewa_motor]',
										   '$_POST[insentif]',
										   '$_POST[lain_lain]',
										   '$_POST[potongan]',
										   '$_POST[gaji_kotor]',
										   '$_POST[gaji_bersih]')");
	if($sql){
		echo "Payroll no : $nomor berhasil disimpan";
	}else{
		echo "Payroll no : $nomor gagal disimpan";
	}
}

if($_GET[data]=='simpan_absen'){
	//cari dulu di tabel absensi apakah tanggal tersebut sudah pernah diinputkan
	$cek = mysql_query("select * from absensi where nip='$_POST[nip]' and tgl_absen ='$_POST[tgl]'");
	$rcek =  mysql_num_rows($cek);
	if($rcek>0){
		$sql = mysql_query("update absensi set keterangan='$_POST[absen]', surat_dokter = '$_POST[suratdokter]' 
		                   where tgl_absen ='$_POST[tgl]' and nip='$_POST[nip]' ");
		if($sql){
			echo "Data Absensi berhasil diupdate ..!";
		}else{
			echo "Data Absensi gagal diupdate..!";
		}
	}else{
		$sql = mysql_query("insert into absensi(tgl_absen, nip, keterangan, surat_dokter)
		                   values('$_POST[tgl]','$_POST[nip]','$_POST[absen]','$_POST[suratdokter]')");
		if($sql){
			echo "Data Absensi berhasil disimpan ..!";
		}else{
			echo "Data Absensi gagal disimpan..!";
		}
	}
}

if($_GET[data]=='absensi'){
	$sql = mysql_query("select a.*,b.nama_lengkap from absensi a,employee b where a.nip=b.nip and a.tgl_absen='$_POST[tgl]' and a.nip in(
	                   select nip from employee where atasan='$_POST[user]') order by b.nama_lengkap");
	$cek = mysql_num_rows($sql);
	
	echo "<table class='table table-bordered table-hover table-condensed'>
	            <tr class='success'><td>No.</td><td>NIP</td><td>Nama Lengkap</td><tD>Absensi</td><td>Surat Dokter</td><td></td></tr>";
	if($cek>0){
	    $no = 1;
		while($r = mysql_fetch_array($sql)){
			echo "<tr>
					<td>$no</td><tD>$r[nip]</td><td>$r[nama_lengkap]</td>
					<td>$r[keterangan]</tD></td><td>$r[surat_dokter]</td>
					<td><input type='checkbox' name='id_absen' value='$r[id_absen]'></td>
				 </tR>";
			$no++;
		}
	}else{
		echo "<tR><td colspan='6'>Data tidak ditemukan..!</tD></tR>";
	}	
	echo "</table>";
}

if($_GET[data]=='hapus'){
	$sql = mysql_query("delete from absensi where id_absen='$_POST[id]'");
	if($sql){
		echo "Data absensi berhasil di hapus..!";
	}else{
	    echo "Data absensi gagal di hapus..!";
	}
}


?>