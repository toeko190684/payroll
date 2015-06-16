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

if($_GET[data]=='listview'){
	$day = date('d',strtotime($_POST[tgl_efektif]));
	$bln = date('m',strtotime($_POST[tgl_efektif]));
	$thn = date('Y',strtotime($_POST[tgl_efektif]));
	
	//cari total salary
	$total = mysql_query("select sum(gaji_bersih)as total_salary from payroll where periode_id='$_POST[id]' 
	                     and nip in(select nip from employee where jenis_pegawai='aktif' and no_rek_bank<>'')");
	$rtotal = mysql_fetch_array($total);
	
	//cari data payroll
	$sql = mysql_query("SELECT a.periode_id,b.no_rek_bank,a.gaji_bersih,a.nip,b.nama_karyawan,b.id_departemen 
	                    FROM payroll a,employee b where a.nip=b.nip and a.periode_id='$_POST[id]' 
						and b.jenis_pegawai='aktif' and b.no_rek_bank<>''");
	$jml = mysql_num_rows($sql);
	
	//cari perusahaan
	$prsh = mysql_query("select * from perusahaan");
	$rprsh = mysql_fetch_array($prsh);
	
	echo "<table class='table table-hover table-condensed table-bordered'>
	        <tR class='success'>
				<td>Kode Perusahaan</td><tD>Tgl.Efektif(Day)</td><td>No.Rek.Prsh</td>
				<td>Non BCA</td><td>Transfer Date</td><td>Jumlah Record</td><td>Total Salary</td>
				<td>Tgl.Efektif(month)</td><td>Tgl.Efektif(year)</td>
			</tr>
			<tR>
				<td>$rprsh[id_perusahaan]</td><tD>$day</td><td>$rprsh[nomor_rekening]</td>
				<td>1</td><td>0</td><td>$jml</td><td>".number_format($rtotal[total_salary],2,',','.')."</td>
				<td>$bln</td><td>$thn</td>
			</tr>";
	
	echo "</table><br><bR>";
	
	//tampilkan dta detailnya 
	echo "<table class='table table-hover table-condensed table-bordered'>
	          <tR class='success'>
				<tD>No</td><tD>No.Rekening</td><tD>Nilai Gaji</td><tD>NIP</td><td>Nama Karyawan</td><tD>Departemen</td>
			  </tr>";
	$no=1;
	while($r = mysql_fetch_array($sql)){
		echo "<tR>
				<tD>$no</td>
				<tD>$r[no_rek_bank]</td>
				<tD>".number_format($r[gaji_bersih],2,',','.')."</td>
				<tD>$r[nip]</td>
				<td>$r[nama_karyawan]</td>
				<tD>$r[id_departemen]</td>
			  </tr>";
		$no++;
	}	
	echo "</table>";
}

if($_GET[data]=='export'){
	$day = date('d',strtotime($_POST[tgl_efektif]));
	$bln = date('m',strtotime($_POST[tgl_efektif]));
	$thn = date('Y',strtotime($_POST[tgl_efektif]));
	
	//cari total salary
	$total = mysql_query("select sum(gaji_bersih)as total_salary from payroll where periode_id='$_POST[id]' 
	                     and nip in(select nip from employee where jenis_pegawai='aktif' and no_rek_bank<>'')");
	$rtotal = mysql_fetch_array($total);
	
	//cari data payroll
	$sql = mysql_query("SELECT a.periode_id,b.no_rek_bank,a.gaji_bersih,a.nip,b.nama_karyawan,b.id_departemen 
	                    FROM payroll a,employee b where a.nip=b.nip and a.periode_id='$_POST[id]' 
						and b.jenis_pegawai='aktif' and b.no_rek_bank<>''");
	$jml = mysql_num_rows($sql);
	
	//buat file txt 
    $nama_file = $_POST[id].'.txt';
	$berkas =fopen($nama_file,"w");
	echo "<input type='hidden' id='nama_file' value='$nama_file'>";
	
	//cari perusahaan
	$prsh = mysql_query("select * from perusahaan");
	$rprsh = mysql_fetch_array($prsh);
	
	switch (strlen($jml)){
		case 0 : $jml = '00000';
                 break;
		case 1 : $jml = '0000'.$jml;
                 break;
		case 2 : $jml = '000'.$jml;
                 break;
		case 3 : $jml = '00'.$jml;
                 break;
		case 4 : $jml = '0'.$jml;
                 break;
		case 5 : $jml = $jml;
                 break;
	}
	
	switch (strlen($rtotal[total_salary])){
		case 0 : $total_salary = '00000000000000.00';
                 break;
		case 1 : $total_salary = '0000000000000'.$rtotal[total_salary].'.00';
                 break;
		case 2 : $total_salary = '000000000000'.$rtotal[total_salary].'.00';
                 break;
		case 3 : $total_salary = '00000000000'.$rtotal[total_salary].'.00';
                 break;
		case 4 : $total_salary = '0000000000'.$rtotal[total_salary].'.00';
                 break;
		case 5 : $total_salary = '000000000'.$rtotal[total_salary].'.00';
                 break;
		case 6 : $total_salary = '00000000'.$rtotal[total_salary].'.00';
                 break;
		case 7 : $total_salary = '0000000'.$rtotal[total_salary].'.00';
                 break;
		case 8 : $total_salary = '000000'.$rtotal[total_salary].'.00';
                 break;
		case 9 : $total_salary = '00000'.$rtotal[total_salary].'.00';
                 break;
		case 10 : $total_salary = '0000'.$rtotal[total_salary].'.00';
                 break;
		case 11 : $total_salary = '000'.$rtotal[total_salary].'.00';
                 break;
		case 12 : $total_salary = '00'.$rtotal[total_salary].'.00';
                 break;
		case 13 : $total_salary = '0'.$rtotal[total_salary].'.00';
                 break;
		case 14 : $total_salary = $rtotal[total_salary].'.00';
	}
	
	$header =  '00000000000'.$rprsh[id_perusahaan].$day.'01'.$rprsh[nomor_rekening]."1"."0"."MF".$jml.$total_salary.$bln.$thn;
	fputs($berkas, $header . "\r\n");
	
	while($r = mysql_fetch_array($sql)){
		switch (strlen($r[no_rek_bank])){
			case 0 : $rek = '0000000000';
	                 break;
			case 1 : $rek = '000000000'.$r[no_rek_bank];
	                 break;
			case 2 : $rek = '00000000'.$r[no_rek_bank];
	                 break;
			case 3 : $rek = '0000000'.$r[no_rek_bank];
	                 break;
			case 4 : $rek = '000000'.$r[no_rek_bank];
	                 break;
			case 5 : $rek = '00000'.$r[no_rek_bank];
	                 break;
			case 6 : $rek = '0000'.$r[no_rek_bank];
	                 break;
			case 7 : $rek = '000'.$r[no_rek_bank];
	                 break;
			case 8 : $rek = '00'.$r[no_rek_bank];
	                 break;
			case 9 : $rek = '0'.$r[no_rek_bank];
	                 break;
			case 10 : $rek = $r[no_rek_bank];
	                 break;
		}
		
		switch (strlen($r[gaji_bersih])){
			case 0 : $nilai_gaji = '000000000000000';
	                 break;
			case 1 : $nilai_gaji = '000000000000'.$r[gaji_bersih].'00';
	                 break;
			case 2 : $nilai_gaji = '00000000000'.$r[gaji_bersih].'00';
	                 break;
			case 3 : $nilai_gaji = '0000000000'.$r[gaji_bersih].'00';
	                 break;
			case 4 : $nilai_gaji = '000000000'.$r[gaji_bersih].'00';
	                 break;
			case 5 : $nilai_gaji = '00000000'.$r[gaji_bersih].'00';
	                 break;
			case 6 : $nilai_gaji = '0000000'.$r[gaji_bersih].'00';
	                 break;
			case 7 : $nilai_gaji = '000000'.$r[gaji_bersih].'00';
	                 break;
			case 8 : $nilai_gaji = '00000'.$r[gaji_bersih].'00';
	                 break;
			case 9 : $nilai_gaji = '0000'.$r[gaji_bersih].'00';
	                 break;
			case 10 : $nilai_gaji = '000'.$r[gaji_bersih].'00';
	                 break;
			case 11 : $nilai_gaji = '00'.$r[gaji_bersih].'00';
	                 break;
			case 12 : $nilai_gaji = '0'.$r[gaji_bersih].'00';
	                 break;
			case 13 : $nilai_gaji = $r[gaji_bersih].'00';
		}
		
		switch (strlen($r[nip])){
			case 0 : $nip = '0000000000';
	                 break;
			case 1 : $nip = '000000000'.$r[nip];
	                 break;
			case 2 : $nip = '00000000'.$r[nip];
	                 break;
			case 3 : $nip = '0000000'.$r[nip];
	                 break;
			case 4 : $nip = '000000'.$r[nip];
	                 break;
			case 5 : $nip = '00000'.$r[nip];
	                 break;
			case 6 : $nip = '0000'.$r[nip];
	                 break;
			case 7 : $nip = '000'.$r[nip];
	                 break;
			case 8 : $nip = '00'.$r[nip];
	                 break;
			case 9 : $nip = '0'.$r[nip];
	                 break;
			case 10 : $nip = $r[nip];
	                 break;
		}
		
		switch (strlen($r[nama_karyawan])){
			case 0 : $nama_karyawan = "                              ";
	                 break;
			case 1 : $nama_karyawan = "$r[nama_karyawan]                             ";
	                 break;
			case 2 : $nama_karyawan = "$r[nama_karyawan]                            ";
	                 break;
			case 3 : $nama_karyawan = "$r[nama_karyawan]                           ";
	                 break;
			case 4 : $nama_karyawan = "$r[nama_karyawan]                          ";
	                 break;
			case 5 : $nama_karyawan = "$r[nama_karyawan]                         ";
	                 break;
			case 6 : $nama_karyawan = "$r[nama_karyawan]                        ";
	                 break;
			case 7 : $nama_karyawan = "$r[nama_karyawan]                       ";
	                 break;
			case 8 : $nama_karyawan = "$r[nama_karyawan]                      ";
	                 break;
			case 9 : $nama_karyawan = "$r[nama_karyawan]                     ";
	                 break;
			case 10 : $nama_karyawan = "$r[nama_karyawan]                    ";
	                 break;
			case 11 : $nama_karyawan = "$r[nama_karyawan]                   ";
	                 break;
			case 12 : $nama_karyawan = "$r[nama_karyawan]                  ";
	                 break;
			case 13 : $nama_karyawan = "$r[nama_karyawan]                 ";
	                 break;
			case 14 : $nama_karyawan = "$r[nama_karyawan]                ";
	                 break;
			case 15 : $nama_karyawan = "$r[nama_karyawan]               ";
	                 break;
			case 16 : $nama_karyawan = "$r[nama_karyawan]              ";
	                 break;
			case 17 : $nama_karyawan = "$r[nama_karyawan]             ";
	                 break;
			case 18 : $nama_karyawan = "$r[nama_karyawan]            ";
	                 break;
			case 19 : $nama_karyawan = "$r[nama_karyawan]           ";
	                 break;
			case 20 : $nama_karyawan = "$r[nama_karyawan]          ";
	                 break;
			case 21 : $nama_karyawan = "$r[nama_karyawan]         ";
	                 break;
			case 22 : $nama_karyawan = "$r[nama_karyawan]        ";
	                 break;
			case 23 : $nama_karyawan = "$r[nama_karyawan]       ";
	                 break;
			case 24 : $nama_karyawan = "$r[nama_karyawan]     ";
	                 break;
			case 25 : $nama_karyawan = "$r[nama_karyawan]    ";
	                 break;
			case 26 : $nama_karyawan = "$r[nama_karyawan]    ";
	                 break;
			case 27 : $nama_karyawan = "$r[nama_karyawan]  ";
	                 break;
			case 28 : $nama_karyawan = "$r[nama_karyawan] ";
	                 break;
			case 29 : $nama_karyawan = "$r[nama_karyawan]";
	                 break;
		}
		
		$detail =  "0".$rek.$nilai_gaji.$nip.$nama_karyawan.trim($r[id_departemen]);
		fputs($berkas, $detail . "\r\n");
	}	
	fclose($berkas);
	
}
?>
