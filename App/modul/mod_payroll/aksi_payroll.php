<?php
session_start();
include "../../../configuration/connection_inc.php";

$module=$_GET[r];
$act=$_GET[act];


// Hapus payroll
if ($module=='payroll' AND $act=='hapus'){
		mysql_query("DELETE FROM payroll WHERE payroll_id ='$_GET[id]'");
        header('location:../../index.php?r='.$module);
}elseif ($module=='payroll' AND $act=='update'){
		if(empty($filename)){
			  mysql_query("UPDATE payroll SET  nama_karyawan = '$_POST[nama_karyawan]',
												tempat_lahir = '$_POST[tempat_lahir]',
												tgl_lahir = '$_POST[tgl_lahir]',
												agama = '$_POST[agama]',
												alamat = '$_POST[alamat]',
												no_telp = '$_POST[no_telp]',
												no_ktp = '$_POST[no_ktp]',
												pendidikan_akhir = '$_POST[pendidikan_akhir]',
												tgl_masuk_kerja = '$_POST[tgl_masuk_kerja]',
												tgl_berhenti = '$_POST[tgl_berhenti]',
												jenis_kelamin = '$_POST[jenis_kelamin]',
												status_kawin = '$_POST[status_kawin]',
												no_jamsostek = '$_POST[no_jamsostek]',
												no_asuransi = '$_POST[no_asuransi]',
												golongan_id = '$_POST[golongan_id]',
												id_jabatan = '$_POST[id_jabatan]',
												id_departemen = '$_POST[id_departemen]',
												area_id = '$_POST[area_id]',
												npwp = '$_POST[npwp]',
												tgl_daftarnpwp = '$_POST[tgl_daftarnpwp]',
												no_rek_bank = '$_POST[no_rek_bank]',
												nama_bank = '$_POST[nama_bank]',
												jumlah_anak = '$_POST[jumlah_anak]',
												jenis_pegawai = '$_POST[jenis_pegawai]'
			                              WHERE nip = '$_POST[nip]'");
		}elseif(!empty($filename)){
		      mysql_query("UPDATE payroll SET  nama_karyawan = '$_POST[nama_karyawan]',
												tempat_lahir = '$_POST[tempat_lahir]',
												tgl_lahir = '$_POST[tgl_lahir]',
												agama = '$_POST[agama]',
												alamat = '$_POST[alamat]',
												no_telp = '$_POST[no_telp]',
												no_ktp = '$_POST[no_ktp]',
												pendidikan_akhir = '$_POST[pendidikan_akhir]',
												tgl_masuk_kerja = '$_POST[tgl_masuk_kerja]',
												tgl_berhenti = '$_POST[tgl_berhenti]',
												jenis_kelamin = '$_POST[jenis_kelamin]',
												status_kawin = '$_POST[status_kawin]',
												no_jamsostek = '$_POST[no_jamsostek]',
												no_asuransi = '$_POST[no_asuransi]',
												golongan_id = '$_POST[golongan_id]',
												id_jabatan = '$_POST[id_jabatan]',
												id_departemen = '$_POST[id_departemen]',
												area_id = '$_POST[area_id]',
												npwp = '$_POST[npwp]',
												tgl_daftarnpwp = '$_POST[tgl_daftarnpwp]',
												no_rek_bank = '$_POST[no_rek_bank]',
												nama_bank = '$_POST[nama_bank]',
												jumlah_anak = '$_POST[jumlah_anak]',
												foto = 'images/$filename',
												jenis_pegawai = '$_POST[jenis_pegawai]'
			                              WHERE nip = '$_POST[nip]'");
			  move_uploaded_file($tmp_name,$uploads_dir.$filename);	
		}
	
  header('location:../../index.php?r='.$module);
}
?>
