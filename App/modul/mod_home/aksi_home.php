<?php
session_start();
include "../../../configuration/connection_inc.php";
include "../../../function/security.php";

$users=$_GET[r];
$act=$_GET[act];
$password = md5($_POST[user_id]."@".$_POST[password]);

	$uploads_dir = "../../../images/";
	$tmp_name = $_FILES["gambar"]["tmp_name"];
	$filename = $_FILES["gambar"]["name"];

// Hapus users
if ($users=='sec_users' AND $act=='hapus'){
  $access = delete_security();
  if($access == "allow"){
		mysql_query("DELETE FROM sec_users WHERE user_id ='$_GET[id]'");
  }
  header('location:../../index.php?r='.$users.'&mod='.$_SESSION[mod]);
}

// Input users
elseif ($users=='sec_users' AND $act=='input'){
  // Input data users
        move_uploaded_file($tmp_name,$uploads_dir.$filename);
		
		mysql_query("INSERT INTO sec_users (user_id,
											password,
											full_name,
											hp,
											email,
											department_id,
											divisi_id,
											grade_id,
											atasan1,
											atasan2,
											foto) 
			                       VALUES('$_POST[user_id]',
								          '$password',
										  '$_POST[nama_lengkap]',
								          '$_POST[hp]',
										  '$_POST[email]',
										  '$_POST[departemen]',
										  '$_POST[divisi]',
										  '$_POST[grade]',
										  '$_POST[atasan1]',
										  '$_POST[atasan2]',
										  'images/$filename')");
   header('location:../../index.php?r='.$users);
}

// Update users
elseif ($users=='sec_users' AND $act=='update'){
    if ($_POST[password] == ""){
	    if(empty($filename)){
				mysql_query("UPDATE sec_users SET   full_name = '$_POST[nama_lengkap]',
													hp   = '$_POST[hp]',
													email = '$_POST[email]',
													department_id = '$_POST[departemen]',
													divisi_id = '$_POST[divisi]',
													grade_id = '$_POST[grade]',
													atasan1 = '$_POST[atasan1]',
													atasan2 = '$_POST[atasan2]'
		                          WHERE user_id   = '$_POST[user_id]'");
		}else{
				mysql_query("UPDATE sec_users SET   full_name = '$_POST[nama_lengkap]',
													hp   = '$_POST[hp]',
													email = '$_POST[email]',
													department_id = '$_POST[departemen]',
													divisi_id = '$_POST[divisi]',
													grade_id = '$_POST[grade]',
													atasan1 = '$_POST[atasan1]',
													atasan2 = '$_POST[atasan2]',
													foto = 'images/$filename'
		                          WHERE user_id   = '$_POST[user_id]'");
								  
				move_uploaded_file($tmp_name,$uploads_dir.$filename);			
		}
	}else{
	    if(empty($filename)){
				mysql_query("UPDATE sec_users SET   password = '$password',
													full_name = '$_POST[nama_lengkap]',
													hp   = '$_POST[hp]',
													email = '$_POST[email]',
													department_id = '$_POST[departemen]',
													divisi_id = '$_POST[divisi]',
													grade_id = '$_POST[grade]',
													atasan1 = '$_POST[atasan1]',
													atasan2 = '$_POST[atasan2]'
		                          WHERE user_id   = '$_POST[user_id]'");
		}else{
				mysql_query("UPDATE sec_users SET   password = '$password',
													full_name = '$_POST[nama_lengkap]',
													hp   = '$_POST[hp]',
													email = '$_POST[email]',
													department_id = '$_POST[departemen]',
													divisi_id = '$_POST[divisi]',
													grade_id = '$_POST[grade]',
													atasan1 = '$_POST[atasan1]',
													atasan2 = '$_POST[atasan2]',
													foto = 'images/$filename'
		                          WHERE user_id   = '$_POST[user_id]'");
				move_uploaded_file($tmp_name,$uploads_dir.$filename);									  
		}
	}
  header('location:../../index.php?r='.$users);
}
?>
