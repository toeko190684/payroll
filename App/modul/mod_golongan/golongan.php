<?php
$aksi="modul/mod_golongan/aksi_golongan.php";
switch($_GET[act]){
  // Tampil golongan
  default:
	    $per_page = 10;
		if($_POST[key]==''){
			$page_query = mysql_query("SELECT count(*) FROM golongan ORDER BY golongan_id");
		}else{
			$page_query = mysql_query("SELECT count(*) FROM golongan where golongan_id='$_POST[key]'");
		}
		$pages = ceil(mysql_result($page_query,0)/$per_page);
		$page = (isset($_GET[page]))? (int)$_GET[page]:1;
		$start = ($page-1)*$per_page;
		echo "<blockquote>Master golongan</blockquote>
	          <input type=button class='btn btn-primary' value='Tambah' 
			  onclick=\"window.location.href='index.php?r=golongan&act=tambahgolongan';\">
			  <form class='form-search' method=post action='?r=golongan'>	
					<div class='input-append'>
					    <div class='span8'></div>
						<input class='span3 search-query' id='key' name='key' type='text' placeholder='Masukan Golongan ID..!'>
					    <button class='btn' type='submit'>Cari</button>
					</div><br>
			  </form>
	          <table class='table table-condensed table-hover table-bordered' >
	          <tdead>
				<tr class='success'>
					<td>No</td><td>ID golongan</td><td>Gaji Pokok</td><td>Aksi</td>
				</tr>
			  </tdead>";
		if($_POST[key]==''){
			$tampil=mysql_query("select * from golongan ORDER BY golongan_id limit $start,$per_page");
		}else{
			$tampil=mysql_query("select * from golongan where golongan_id='$_POST[key]' ORDER BY golongan_id limit $start,$per_page");
		}
	    $no = 1;
		$no = $no+$start;
		while ($r=mysql_fetch_array($tampil)){
	      echo "<tbody><tr>
		            <td>$no</tD>
		            <td>$r[golongan_id]</td>
					<td>".number_format($r[gaji_pokok],2,',','.')."</td>
		            <td><a href='index.php?r=golongan&act=editgolongan&id=$r[golongan_id]'>Edit</a> | 
			              <a href='$aksi?r=golongan&act=hapus&id=$r[golongan_id]'>Hapus</a>
		            </td>
				</tr></tbody>";
				$no++;
	    }
	    echo "</table>";
		//memulai paginasi
		echo "<div class='pagination pagination-small pagination-right'><ul><li><a href='?r=golongan&page=1'>First</a></li>";
		if($pages >= 1 && $page <= $pages){
		    for($x=1; $x<=$pages; $x++){
		        echo ($x == $page) ? '<li><a href="?r=golongan&page='.$x.'">'.$x.'</a></li> ' : '<li><a href="?r=golongan&page='.$x.'">'.$x.'</a></li>';
		    }
		}
		$x--;
		echo "<li><a href='?r=golongan&page=$x'>Last</a></li></ul></div>";
    break;

  case "tambahgolongan":
	    echo "<form method=POST action='$aksi?r=golongan&act=input'>
	          <fieldset><legend>Tambah golongan</legend>
			  <label>golongan ID :</label>
			  <input type='text' name='golongan_id' class='input-medium' required><br>
			  <label>Gaji Pokok :</label>
			  <input type='text' name='gaji_pokok'  class='input-large' required><br><br>
			  <input type='submit' class='btn btn-primary' value='Simpan'>&nbsp
			  <input type='reset' class='btn btn-danger' value='Batal' onclick='history.go(-1)'>
			  </fieldset></form>";
     break;
 
  case "editgolongan":
    $edit = mysql_query("SELECT * from golongan where golongan_id='$_GET[id]'");
    $r    = mysql_fetch_array($edit);

    echo "<form method=POST action=$aksi?r=golongan&act=update>
          <input type=hidden name=id value='$r[golongan_id]'>
          <fieldset><legend>Edit golongan</legend>
		  <label>golongan ID :</label>
		  <input type='text' name='golongan_id' class='input-medium' value='$r[golongan_id]' required><br>
		  <label>Gaji Pokok :</label>
		  <input type='text' name='gaji_pokok'  class='input-large' value='$r[gaji_pokok]' required><br><br>
		  <input type='submit' class='btn btn-primary' value='Simpan'>&nbsp
		  <input type='reset' class='btn btn-danger' value='Batal' onclick='history.go(-1)'>
		  </fieldset></form>";
    break;  
}
?>
