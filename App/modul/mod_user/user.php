<?php
$aksi="modul/mod_user/aksi_user.php";
if($_SESSION[level]=='admin'){
switch($_GET[act]){
  // Tampil users
  default:
	    $per_page = 10;
		if($_POST[key]==''){
			$page_query = mysql_query("SELECT count(*) FROM users");
		}else{
			$page_query = mysql_query("SELECT count(*) FROM users where username like '%$_POST[key]%'");
		}
		$pages = ceil(mysql_result($page_query,0)/$per_page);
		$page = (isset($_GET[page]))? (int)$_GET[page]:1;
		$start = ($page-1)*$per_page;
		echo "<blockquote>Master users</blockquote>
	          <input type=button class='btn btn-primary' value='Tambah' 
			  onclick=\"window.location.href='index.php?r=user&act=tambahusers';\">
		      <form class='form-search' method=post action='?r=user'>	
					<div class='input-append'>
					    <div class='span8'></div>
						<input class='span3 search-query' id='key' name='key' type='text' placeholder='Masukan Username..!'>
					    <button class='btn' type='submit'>Cari</button>
					</div><br>
			  </form>
	          <table class='table table-condensed table-hover table-bordered' >
	          <tdead>
				<tr class='success'>
					<td>No</td><td>Username</td><td>Blokir</td><tD>Level</td><td>Aksi</td>
				</tr>
			  </tdead>";
	    
		if($_POST[key]==''){
			$tampil=mysql_query("select * from users ORDER BY username limit $start,$per_page");
		}else{
			$tampil=mysql_query("select * from users where username like '%$_POST[key]%' limit $start,$per_page");
		}
	    $no = 1;
		$no = $no+$start;
		while ($r=mysql_fetch_array($tampil)){
	      echo "<tbody><tr>
		            <td>$no</tD>
		            <td>$r[username]</td>
					<td>$r[blokir]</td>
					<td>$r[level]</td>
		            <td><a href='index.php?r=user&act=editusers&id=$r[username]'>Edit</a> | 
			              <a href='$aksi?r=user&act=hapus&id=$r[username]'>Hapus</a>
		            </td>
				</tr></tbody>";
				$no++;
	    }
	    echo "</table>";
		//memulai paginasi
		echo "<div class='pagination pagination-small pagination-right'><ul><li><a href='?r=users&page=1'>First</a></li>";
		if($pages >= 1 && $page <= $pages){
		    for($x=1; $x<=$pages; $x++){
		        echo ($x == $page) ? '<li><a href="?r=users&page='.$x.'">'.$x.'</a></li> ' : '<li><a href="?r=users&page='.$x.'">'.$x.'</a></li>';
		    }
		}
		$x--;
		echo "<li><a href='?r=user&page=$x'>Last</a></li></ul></div>";
    break;

  case "tambahusers":
	    echo "<form method=POST action='$aksi?r=user&act=input'>
	          <fieldset><legend>Edit users</legend>
			  <label>Username :</label>
			  <input type='text' name='username' class='input-small' required><br>
			  <label>Password :</label>
			  <input type='password' name='password'  class='input-medium' required><br>
			  <label>Blokir :</label>
			  <select name='blokir'  class='input-small' required>
				<option value='0'>Tidak</option>
				<option value='1'>Ya</option>
			  </select><br>
			  <label>Level :</label>
			  <select name='level'  class='input-small' required>
				<option value='admin'>Admin</option>
				<option value='user'>User</option>
			  </select><br><br>
			  <input type='submit' class='btn btn-primary' value='Simpan'>&nbsp
			  <input type='reset' class='btn btn-danger' value='Batal' onclick='history.go(-1)'>
			  </fieldset></form>";
     break;
 
  case "editusers":
    $edit = mysql_query("SELECT * from users where username='$_GET[id]'");
    $r    = mysql_fetch_array($edit);

    echo "<form method=POST action='$aksi?r=user&act=update'>
	      <fieldset><legend>Edit users</legend>
		  <input type='hidden' name='id' value='$r[username]'>
		  <label>Username :</label>
		  <input type='text' name='username' class='input-small' value='$r[username]' required><br>
		  <label>Password :</label>
		  <input type='password' name='password'  class='input-medium' required>*Jika tidak diganti kosongkan saja<br>
		  <label>Blokir :</label>
		  <select name='blokir'  class='input-small'  required>";
		  if($r[blokir]==0){ $blokir ='Tidak'; }else{ $blokir = 'Ya';}
	echo "	<option value='$r[blokir]'>$blokir</option>
			<option value='0'>Tidak</option>
			<option value='1'>Ya</option>
		  </select><br>
		  <label>Level :</label>
		  <select name='level'  class='input-small' required>
			<option value='$r[level]'>$r[level]</option> 
			<option value='admin'>Admin</option>
			<option value='user'>User</option>
		  </select><br><br>
		  <input type='submit' class='btn btn-primary' value='Simpan'>&nbsp
		  <input type='reset' class='btn btn-danger' value='Batal' onclick='history.go(-1)'>
		  </fieldset></form>";
    break;  
}
}else{
	$edit = mysql_query("SELECT * from users where username='$_SESSION[username]'");
    $r    = mysql_fetch_array($edit);

    echo "<form method=POST action='$aksi?r=user&act=update'>
	      <fieldset><legend>Edit users</legend>
		  <input type='hidden' name='id' value='$r[username]'>
		  <label>Username :</label>
		  <input type='text' name='username' class='input-small' value='$r[username]' required><br>
		  <label>Password :</label>
		  <input type='password' name='password'  class='input-medium' required>*Jika tidak diganti kosongkan saja<br>
		  <label>Blokir :</label>
		  <select name='blokir'  class='input-small'  required>";
		  if($r[blokir]==0){ $blokir ='Tidak'; }else{ $blokir = 'Ya';}
	echo "	<option value='$r[blokir]'>$blokir</option>
		  </select><br>
		  <label>Level :</label>
		  <select name='level'  class='input-small' required>
			<option value='$r[level]'>$r[level]</option> 
		  </select><br><br>
		  <input type='submit' class='btn btn-primary' value='Simpan'>&nbsp
		  <input type='reset' class='btn btn-danger' value='Batal' onclick='history.go(-1)'>
		  </fieldset></form>";
}
?>
