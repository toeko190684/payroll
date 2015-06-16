<?php
ses_module();
switch($_GET[act]){
  // Tampil master_users
  default:
    $sql = mysql_query("select * from employee where nip='$_SESSION[user_id]'");
	$r = mysql_fetch_array($sql);
	echo "<h4>Welcome $_SESSION[user_id], to Payroll Systems</h4>
	     <img src='../images/payroll.jpg' >"; 	
  break;

  case "tambah_users":
    $access = create_security();
		if($access == "allow"){
	    echo "<form method=POST action='$aksi?r=sec_users&act=input' enctype='multipart/form-data'>
	          <fieldset><legend>Tambah User</legend>
			  <label>User ID :</label>
			  <input type='text' name='user_id' required><br>
			  <label>Password :</label>
			  <input type='password' name='password' required><br>
			  <label>Nama Lengkap :</label>
			  <input type='text' name='nama_lengkap' required><br>
			  <label>HP :</label>
			  <input type='text' name='hp' required><br>
			  <label>Email :</label>
			  <input type='email' name='email' required><br>
			  <label>Divisi :</label>
			  <select name='divisi' id='divisi' ><option value=''></option>";
			  $sql = mysql_query("select * from master_divisi order by divisi_name");
			  while($r = mysql_fetch_array($sql)){
				echo "<option value='$r[divisi_id]'>$r[divisi_name]</option>";
			  }
		echo "</select><br>
			  <label>Departemen :</label>
			  <select name='departemen' id='departemen'>
			  </select><br>		      
		      <label>Grade :</label>
			  <select name='grade'><option value=''>--Pilih Grade--</option>";
			  $sql = mysql_query("select * from master_grade order by grade_name");
			  while($r = mysql_fetch_array($sql)){
				echo "<option value='$r[grade_id]'>$r[grade_name]</option>";
			  }
		echo "</select><br>
		      <label>Atasan 1 :</label>
			  <select name='atasan1'><option value=''>--Pilih Atasan 1--</option>";
			  $sql = mysql_query("select * from sec_users order by user_id");
			  while($r = mysql_fetch_array($sql)){
				echo "<option value='$r[user_id]'>$r[user_id]</option>";
			  }
		echo "</select><br>
		      <label>Atasan 2 :</label>
			  <select name='atasan2'><option value=''>--Pilih Atasan 2--</option>";
			  $sql = mysql_query("select * from sec_users order by user_id");
			  while($r = mysql_fetch_array($sql)){
				echo "<option value='$r[user_id]'>$r[user_id]</option>";
			  }
		echo "</select><br>
			  <input type='file' name='gambar'><br>
			  <i>size 260 x 180 pixel</i><br><br>
			  <input type='submit' class='btn btn-primary' value='Simpan'>&nbsp
			  <input type='reset' class='btn btn-danger' value='Batal' onclick='history.go(-1)'>
			  </fieldset></form>";
	}else{
		msg_security();
	}
    break;
 
  case "edit_users":
    $access = update_security();
		if($access == "allow"){
	    $edit = mysql_query("SELECT a.*,b.department_name,c.divisi_name,d.grade_name from sec_users a,
		                    master_department b,master_divisi c, master_grade d where a.department_id=b.department_id and
							a.divisi_id=c.divisi_id and a.grade_id=d.grade_id and a.user_id='$_GET[id]' order by a.user_id");
	    $r    = mysql_fetch_array($edit);
		
	    echo "<form method='POST' action=$aksi?r=sec_users&act=update enctype='multipart/form-data'>
	          <input type=hidden name=id value='$r[user_id]'>
	          <fieldset><legend>Edit Aplikasi</legend>
			  <label>User ID :</label>
			  <input type='text' name='user_id' value='$r[user_id]' required><br>
			  <label>Password :</label>
			  <input type='password' name='password'>&nbsp(* Kosongkan bila tidak dirubah<br>
			  <label>Nama Lengkap :</label>
			  <input type='text' name='nama_lengkap' value='$r[full_name]' required><br>
			  <label>HP :</label>
			  <input type='number' name='hp' value='$r[hp]' required><br>
			  <label>Email :</label>
			  <input type='email' name='email' value='$r[email]' required><br>
			  <label>Divisi :</label>
			  <select name='divisi' id='divisi'><option value='$r[divisi_id]'>$r[divisi_name]</option>";
			  $sql = mysql_query("select * from master_divisi order by divisi_name");
			  while($x = mysql_fetch_array($sql)){
				echo "<option value='$x[divisi_id]'>$x[divisi_name]</option>";
			  }
		echo "</select><br>
			  <label>Departemen :</label>
			  <select name='departemen' id=departemen><option value='$r[department_id]'>$r[department_name]</option>
			  </select><br>		      
		      <label>Grade :</label>
			  <select name='grade'><option value='$r[grade_id]'>$r[grade_name]</option>";
			  $sql = mysql_query("select * from master_grade order by grade_name");
			  while($x = mysql_fetch_array($sql)){
				echo "<option value='$x[grade_id]'>$x[grade_name]</option>";
			  }
		echo "</select><br>
			  <label>Atasan 1 :</label>
			  <select name='atasan1'><option value='$r[atasan1]'>$r[atasan1]</option>";
			  $user = mysql_query("select * from sec_users order by user_id");
			  while($ruser = mysql_fetch_array($user)){
				echo "<option value='$ruser[user_id]'>$ruser[user_id]</option>";
			  }
		echo "</select><br>
		      <label>Atasan 2 :</label>
			  <select name='atasan2'><option value='$r[atasan2]'>$r[atasan2]</option>";
			  $user = mysql_query("select * from sec_users order by user_id");
			  while($ruser = mysql_fetch_array($user)){
				echo "<option value='$ruser[user_id]'>$ruser[user_id]</option>";
			  }
		echo "</select><br>
		      <input type='file' name='gambar'><br>
			  <i>size 260 x 180 pixel</i><br><br>
			  <input type='submit' class='btn btn-primary' value='Simpan'>&nbsp
			  <input type='reset' class='btn btn-danger' value='Batal' onclick='history.go(-1)'>
			  </fieldset></form>";
	}else{
		msg_security();
	}
    break;  
}
?>
