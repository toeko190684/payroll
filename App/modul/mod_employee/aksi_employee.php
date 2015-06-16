<?php
session_start();
include "../../../configuration/connection_inc.php";

$module=$_GET[r];
$act=$_GET[act];

$uploads_dir = "../../../images/";
$tmp_name = $_FILES["foto"]["tmp_name"];
$filename = $_FILES["foto"]["name"];

// Hapus employee
if ($module=='employee' AND $act=='hapus'){
		mysql_query("DELETE FROM employee WHERE nip ='$_GET[id]'");
  header('location:../../index.php?r='.$module);
}

// Input employee
elseif ($module=='employee' AND $act=='input'){
  // Input data employee
  if(empty($filename)){
		  mysql_query("INSERT INTO employee (nip,
											 nama_karyawan,
											 tempat_lahir,
											 tgl_lahir,
											 agama,
											 alamat,
											 no_telp,
											 no_ktp,
											 pendidikan_akhir,
											 tgl_masuk_kerja,
											 tgl_berhenti,
											 jenis_kelamin,
											 status_kawin,
											 no_jamsostek,
											 no_asuransi,
											 golongan_id,
											 id_jabatan,
											 id_departemen,
											 area_id,
											 npwp,
											 tgl_daftarnpwp,
											 no_rek_bank,
											 nama_bank,
											 jumlah_anak,
											 jenis_pegawai) 
								     VALUES ('$_POST[nip]', 
											 '$_POST[nama_karyawan]',
											 '$_POST[tempat_lahir]',
											 '$_POST[tgl_lahir]',
											 '$_POST[agama]',
											 '$_POST[alamat]',
											 '$_POST[no_telp]',
											 '$_POST[no_ktp]',
											 '$_POST[pendidikan_akhir]',
											 '$_POST[tgl_masuk_kerja]',
											 '$_POST[tgl_berhenti]',
											 '$_POST[jenis_kelamin]',
											 '$_POST[status_kawin]',
											 '$_POST[no_jamsostek]',
											 '$_POST[no_asuransi]',
											 '$_POST[golongan_id]',
											 '$_POST[id_jabatan]',
											 '$_POST[id_departemen]',
											 '$_POST[area_id]',
											 '$_POST[npwp]',
											 '$_POST[tgl_daftarnpwp]',
											 '$_POST[no_rek_bank]',
											 '$_POST[nama_bank]',
											 '$_POST[jumlah_anak]',
											 '$_POST[jenis_pegawai]')");
	}else{
		 move_uploaded_file($tmp_name,$uploads_dir.$filename);
		 mysql_query("INSERT INTO employee (nip,
											 nama_karyawan,
											 tempat_lahir,
											 tgl_lahir,
											 agama,
											 alamat,
											 no_telp,
											 no_ktp,
											 pendidikan_akhir,
											 tgl_masuk_kerja,
											 tgl_berhenti,
											 jenis_kelamin,
											 status_kawin,
											 no_jamsostek,
											 no_asuransi,
											 golongan_id,
											 id_jabatan,
											 id_departemen,
											 area_id,
											 npwp,
											 tgl_daftarnpwp,
											 no_rek_bank,
											 nama_bank,
											 jumlah_anak,
											 foto,
											 jenis_pegawai) 
								     VALUES ('$_POST[nip]', 
											 '$_POST[nama_karyawan]',
											 '$_POST[tempat_lahir]',
											 '$_POST[tgl_lahir]',
											 '$_POST[agama]',
											 '$_POST[alamat]',
											 '$_POST[no_telp]',
											 '$_POST[no_ktp]',
											 '$_POST[pendidikan_akhir]',
											 '$_POST[tgl_masuk_kerja]',
											 '$_POST[tgl_berhenti]',
											 '$_POST[jenis_kelamin]',
											 '$_POST[status_kawin]',
											 '$_POST[no_jamsostek]',
											 '$_POST[no_asuransi]',
											 '$_POST[golongan_id]',
											 '$_POST[id_jabatan]',
											 '$_POST[id_departemen]',
											 '$_POST[area_id]',
											 '$_POST[npwp]',
											 '$_POST[tgl_daftarnpwp]',
											 '$_POST[no_rek_bank]',
											 '$_POST[nama_bank]',
											 '$_POST[jumlah_anak]',
											 'images/$filename',
											 '$_POST[jenis_pegawai]')");
	}

  header('location:../../index.php?r='.$module);
}

// Update employee
elseif ($module=='employee' AND $act=='update'){
		if(empty($filename)){
			  mysql_query("UPDATE employee SET  nama_karyawan = '$_POST[nama_karyawan]',
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
		      mysql_query("UPDATE employee SET  nama_karyawan = '$_POST[nama_karyawan]',
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
