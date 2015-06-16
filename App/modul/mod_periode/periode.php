<?php
$aksi="modul/mod_periode/aksi_periode.php";
switch($_GET[act]){
  // Tampil periode
  default:
	    $per_page = 10;
		if($_POST[key]==''){
			$page_query = mysql_query("SELECT count(*) FROM periode ORDER BY periode_id");
		}else{
			$page_query = mysql_query("SELECT count(*) FROM periode where periode_id like '%$_POST[key]%'");
		}
		$pages = ceil(mysql_result($page_query,0)/$per_page);
		$page = (isset($_GET[page]))? (int)$_GET[page]:1;
		$start = ($page-1)*$per_page;
		echo "<blockquote>Master periode</blockquote>
	          <input type=button class='btn btn-primary' value='Tambah' 
			  onclick=\"window.location.href='index.php?r=periode&act=tambahperiode';\">
			  <form class='form-search' method=post action='?r=periode'>	
					<div class='input-append'>
					    <div class='span8'></div>
						<input class='span3 search-query' id='key' name='key' type='text' placeholder='Masukan Periode.!'>
					    <button class='btn' type='submit'>Cari</button>
					</div><br>
			  </form>
	          <table class='table table-condensed table-hover table-bordered' >
	          <tdead>
				<tr class='success'>
					<td>No</td><td>ID periode</td><td>Tgl. Awal</td><td>Tgl.Akhir</td><td>Tgl.Efektif</td><td>Aksi</td>
				</tr>
			  </tdead>";
	    
		if($_POST[key]==''){
			$tampil=mysql_query("select * from periode ORDER BY periode_id limit $start,$per_page");
		}else{
			$tampil=mysql_query("select * from periode where periode_id like '%$_POST[key]%' ORDER BY periode_id limit $start,$per_page");
		}
	    $no = 1;
		$no = $no+$start;
		while ($r=mysql_fetch_array($tampil)){
	      echo "<tbody><tr>
		            <td>$no</tD>
		            <td>$r[periode_id]</td>
					<td>$r[tgl_awal]</td>
					<td>$r[tgl_akhir]</td>
					<td>$r[tgl_efektif]</td>
		            <td><a href='index.php?r=periode&act=editperiode&id=$r[periode_id]'>Edit</a> | 
			              <a href='$aksi?r=periode&act=hapus&id=$r[periode_id]'>Hapus</a>
		            </td>
				</tr></tbody>";
				$no++;
	    }
	    echo "</table>";
		//memulai paginasi
		echo "<div class='pagination pagination-small pagination-right'><ul><li><a href='?r=periode&page=1'>First</a></li>";
		if($pages >= 1 && $page <= $pages){
		    for($x=1; $x<=$pages; $x++){
		        echo ($x == $page) ? '<li><a href="?r=periode&page='.$x.'">'.$x.'</a></li> ' : '<li><a href="?r=periode&page='.$x.'">'.$x.'</a></li>';
		    }
		}
		$x--;
		echo "<li><a href='?r=periode&page=$x'>Last</a></li></ul></div>";
    break;

  case "tambahperiode":
	    echo "<form method=POST action='$aksi?r=periode&act=input'>
	          <fieldset><legend>Tambah periode</legend>
			  <label>periode ID :</label>
			  <input type='text' id='periode_id' name='periode_id' class='input-small' required>&nbspContoh Periode ID: PERIOD1402 <br>
			  <label>Periode :</label>
			  <input type='text' name='tgl_awal'  class='easyui-datebox input-mini'>&nbspS/D&nbsp
			  <input type='text' name='tgl_akhir'  class='easyui-datebox input-mini'><br>
			  <label>Tgl Efektif :</label>
			  <input type='text' name='tgl_efektif'  class='easyui-datebox input-mini'><bR><br>
			  <input type='submit' class='btn btn-primary' value='Simpan'>&nbsp
			  <input type='reset' class='btn btn-danger' value='Batal' onclick='history.go(-1)'>
			  </fieldset></form>";
     break;
 
  case "editperiode":
    $edit = mysql_query("SELECT * from periode where periode_id='$_GET[id]'");
    $r    = mysql_fetch_array($edit);

    echo "<form method=POST action=$aksi?r=periode&act=update>
          <input type=hidden name=id value='$r[periode_id]'>
          <fieldset><legend>Edit periode</legend>
		  <label>periode ID :</label>
			  <input type='text' id='periode_id' name='periode_id' class='input-small' value='$r[periode_id]' required>&nbspContoh Periode ID: PERIOD1402 <br>
			  <label>Periode :</label>
			  <input type='text' name='tgl_awal'  class='easyui-datebox input-mini' value='$r[tgl_awal]'>&nbspS/D&nbsp
			  <input type='text' name='tgl_akhir'  class='easyui-datebox input-mini' value='$r[tgl_akhir]'><br>
			  <label>Tgl Efektif :</label>
			  <input type='text' name='tgl_efektif'  class='easyui-datebox input-mini' value='$r[tgl_efektif]'><bR><br>
		  <input type='submit' class='btn btn-primary' value='Simpan'>&nbsp
		  <input type='reset' class='btn btn-danger' value='Batal' onclick='history.go(-1)'>
		  </fieldset></form>";
    break;  
}
?>
