<?php
$aksi="modul/mod_departemen/aksi_departemen.php";
switch($_GET[act]){
  // Tampil departemen
  default:
	    $per_page = 10;
		if($_POST[key]==''){
			$page_query = mysql_query("SELECT count(*) FROM departemen ORDER BY nama_departemen");
		}else{
			$page_query = mysql_query("SELECT count(*) FROM departemen where nama_departemen like '%$_POST[key]%'");
		}
		$pages = ceil(mysql_result($page_query,0)/$per_page);
		$page = (isset($_GET[page]))? (int)$_GET[page]:1;
		$start = ($page-1)*$per_page;
		echo "<blockquote>Master departemen</blockquote>
	          <input type=button class='btn btn-primary' value='Tambah' 
			  onclick=\"window.location.href='index.php?r=departemen&act=tambahdepartemen';\">
			  <form class='form-search' method=post action='?r=departemen'>	
					<div class='input-append'>
					    <div class='span8'></div>
						<input class='span3 search-query' id='key' name='key' type='text' placeholder='Masukan Nama Departemen..!'>
					    <button class='btn' type='submit'>Cari</button>
					</div><br>
			  </form>
	          <table class='table table-condensed table-hover table-bordered' >
	          <tdead>
				<tr class='success'>
					<td>No</td><td>ID departemen</td><td>Nama departemen</td><td>Prefix</td><td>Aksi</td>
				</tr>
			  </tdead>";
	    if($_POST[key]==''){
			$tampil=mysql_query("select * from departemen ORDER BY nama_departemen limit $start,$per_page");
		}else{
			$tampil=mysql_query("select * from departemen where nama_departemen like '%$_POST[key]%' ORDER BY nama_departemen limit $start,$per_page");
		}
	    $no = 1;
		$no = $no+$start;
		while ($r=mysql_fetch_array($tampil)){
	      echo "<tbody><tr>
		            <td>$no</tD>
		            <td>$r[id_departemen]</td>
					<td>$r[nama_departemen]</td>
					<td>$r[prefix]</td>
		            <td><a href='index.php?r=departemen&act=editdepartemen&id=$r[id_departemen]'>Edit</a> | 
			              <a href='$aksi?r=departemen&act=hapus&id=$r[id_departemen]'>Hapus</a>
		            </td>
				</tr></tbody>";
				$no++;
	    }
	    echo "</table>";
		//memulai paginasi
		echo "<div class='pagination pagination-small pagination-right'><ul><li><a href='?r=departemen&page=1'>First</a></li>";
		if($pages >= 1 && $page <= $pages){
		    for($x=1; $x<=$pages; $x++){
		        echo ($x == $page) ? '<li><a href="?r=departemen&page='.$x.'">'.$x.'</a></li> ' : '<li><a href="?r=departemen&page='.$x.'">'.$x.'</a></li>';
		    }
		}
		$x--;
		echo "<li><a href='?r=departemen&page=$x'>Last</a></li></ul></div>";
    break;

  case "tambahdepartemen":
	    echo "<form method=POST action='$aksi?r=departemen&act=input'>
	          <fieldset><legend>Tambah departemen</legend>
			  <label>ID departemen :</label>
			  <input type='text' name='departemen_id' class='input-small' required><br>
			  <label>Nama departemen :</label>
			  <input type='text' name='departemen_name'  class='input-xlarge' required><br>
			  <label>Prefix :</label>
			  <input type='text' name='prefix' class='input-small' required><br><br>
			  <input type='submit' class='btn btn-primary' value='Simpan'>&nbsp
			  <input type='reset' class='btn btn-danger' value='Batal' onclick='history.go(-1)'>
			  </fieldset></form>";
     break;
 
  case "editdepartemen":
    $edit = mysql_query("SELECT * from departemen where id_departemen='$_GET[id]'");
    $r    = mysql_fetch_array($edit);

    echo "<form method=POST action=$aksi?r=departemen&act=update>
          <input type=hidden name=id value='$r[id_departemen]'>
          <fieldset><legend>Edit departemen</legend>
		  <label>ID departemen :</label>
		  <input type='text' name='departemen_id' class='input-small' value='$r[id_departemen]' required><br>
		  <label>Nama departemen :</label>
		  <input type='text' name='departemen_name'  class='input-xlarge' value='$r[nama_departemen]' required><br>
		  <label>Prefix :</label>
		  <input type='text' name='prefix' class='input-small' value='$r[prefix]' required><br><br>
		  <input type='submit' class='btn btn-primary' value='Simpan'>&nbsp
		  <input type='reset' class='btn btn-danger' value='Batal' onclick='history.go(-1)'>
		  </fieldset></form>";
    break;  
}
?>
