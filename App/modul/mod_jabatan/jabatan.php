<?php
$aksi="modul/mod_jabatan/aksi_jabatan.php";
switch($_GET[act]){
  // Tampil jabatan
  default:
	    $per_page = 10;
		if($_POST[key]==''){
			$page_query = mysql_query("SELECT count(*) FROM jabatan ORDER BY nama_jabatan");
		}else{
			$page_query = mysql_query("SELECT count(*) FROM jabatan where nama_jabatan like '%$_POST[key]%'");
		}
		$pages = ceil(mysql_result($page_query,0)/$per_page);
		$page = (isset($_GET[page]))? (int)$_GET[page]:1;
		$start = ($page-1)*$per_page;
		echo "<blockquote>Master jabatan</blockquote>
	          <input type=button class='btn btn-primary' value='Tambah' 
			  onclick=\"window.location.href='index.php?r=jabatan&act=tambahjabatan';\">
			  <form class='form-search' method=post action='?r=jabatan'>	
					<div class='input-append'>
					    <div class='span8'></div>
						<input class='span3 search-query' id='key' name='key' type='text' placeholder='Masukan nama jabatan..!'>
					    <button class='btn' type='submit'>Cari</button>
					</div><br>
			  </form>
	          <table class='table table-condensed table-hover table-bordered' >
	          <tdead>
				<tr class='success'>
					<td>No</td><td>ID jabatan</td><td>Nama jabatan</td><tD>Tnj.Jabatan</td><tD>Transport</tD><tD>Luar Kota</td>
					<td>U.Makan</td><tD>U.Pulsa</td><td>Sewa Motor</td><td>Aksi</td>
				</tr>
			  </tdead>";
	    
		if($_POST[key]==''){
			$tampil=mysql_query("select * from jabatan ORDER BY nama_jabatan limit $start,$per_page");
		}else{
			$tampil=mysql_query("select * from jabatan where nama_jabatan like '%$_POST[key]%' ORDER BY nama_jabatan limit $start,$per_page");
		}
	    $no = 1;
		$no = $no+$start;
		while ($r=mysql_fetch_array($tampil)){
	      echo "<tbody><tr>
		            <td>$no</tD>
		            <td>$r[id_jabatan]</td>
					<td>$r[nama_jabatan]</td>
					<td>".number_format($r[tnj_jabatan],2,',','.')."</td>
					<td>".number_format($r[tnj_transport],2,',','.')."</td>
					<td>".number_format($r[tnj_luarkota],2,',','.')."</td>
					<td>".number_format($r[uang_makan],2,',','.')."</td>
					<td>".number_format($r[uang_pulsa],2,',','.')."</td>
					<td>".number_format($r[sewa_motor],2,',','.')."</td>
		            <td><a href='index.php?r=jabatan&act=editjabatan&id=$r[id_jabatan]'>Edit</a> | 
			              <a href='$aksi?r=jabatan&act=hapus&id=$r[id_jabatan]'>Hapus</a>
		            </td>
				</tr></tbody>";
				$no++;
	    }
	    echo "</table>";
		//memulai paginasi
		echo "<div class='pagination pagination-small pagination-right'><ul><li><a href='?r=jabatan&page=1'>First</a></li>";
		if($pages >= 1 && $page <= $pages){
		    for($x=1; $x<=$pages; $x++){
		        echo ($x == $page) ? '<li><a href="?r=jabatan&page='.$x.'">'.$x.'</a></li> ' : '<li><a href="?r=jabatan&page='.$x.'">'.$x.'</a></li>';
		    }
		}
		$x--;
		echo "<li><a href='?r=jabatan&page=$x'>Last</a></li></ul></div>";
    break;

  case "tambahjabatan":
	    echo "<form class='form-horizontal' method='post' action='$aksi?r=jabatan&act=input' >
		          <fieldset><legend>Tambah Jabatan</legend>
				  <div class='span5'>
						  <div class='control-group'>
								<label class='control-label' for='jabatan_id'>ID Jabatan</label>
								<div class='controls'>
									<input type='text' id='jabatan_id' name='jabatan_id' class='input-small'>
								</div>
						  </div>
						  <div class='control-group'>
								<label class='control-label' for='jabatan_name'>Nama Jabatan</label>
								<div class='controls'>
									<input type='text' id='jabatan_name' name='jabatan_name'>
								</div>
						  </div>
						  <div class='control-group'>
								<label class='control-label' for='tnj_jabatan'>Tunjangan Jabatan</label>
								<div class='controls'>
									<input type='text' id='tnj_jabatan' name='tnj_jabatan'>
								</div>
						  </div>
						  <div class='control-group'>
								<label class='control-label' for='tnj_transport'>Tunjangan Transport</label>
								<div class='controls'>
									<input type='text' id='tnj_transport' name='tnj_transport'>
								</div>
						  </div>
				  </div>
				  <div class='span5'>
						  <div class='control-group'>
								<label class='control-label' for='tnj_luarkota'>Tunjangan Luar Kota</label>
								<div class='controls'>
									<input type='text' id='tnj_luarkota' name='tnj_luarkota'>
								</div>
						  </div>
						  <div class='control-group'>
								<label class='control-label' for='uang_makan'>Uang Makan</label>
								<div class='controls'>
									<input type='text' id='uang_makan' name='uang_makan'>
								</div>
						  </div>
						  <div class='control-group'>
								<label class='control-label' for='uang_pulsa'>Uang Pulsa</label>
								<div class='controls'>
									<input type='text' id='uang_pulsa' name='uang_pulsa'>
								</div>
						  </div>
						  <div class='control-group'>
								<label class='control-label' for='sewa_motor'>Sewa Motor</label>
								<div class='controls'>
									<input type='text' id='sewa_motor' name='sewa_motor'>
								</div>
						  </div>
						  <div class='control-group'>
								<div class='controls'>
									<input type='submit' class='btn btn-primary' value='Simpan'>&nbsp
									<input type='reset' class='btn btn-danger' value='Batal' onclick='history.go(-1)'>
								</div>
						  </div>
				  </div>
				  </div>
			  </form>";
		
     break;
 
  case "editjabatan":
    $edit = mysql_query("SELECT * from jabatan where id_jabatan='$_GET[id]'");
    $r    = mysql_fetch_array($edit);

    echo "<form class='form-horizontal' method='post' action='$aksi?r=jabatan&act=update' >
			      <input type='hidden' name='id' value='$r[id_jabatan]'>
		          <fieldset><legend>Edit Jabatan</legend>
				  <div class='span5'>
						  <div class='control-group'>
								<label class='control-label' for='jabatan_id'>ID Jabatan</label>
								<div class='controls'>
									<input type='text' id='jabatan_id' name='jabatan_id' class='input-small' value='$r[id_jabatan]'>
								</div>
						  </div>
						  <div class='control-group'>
								<label class='control-label' for='jabatan_name'>Nama Jabatan</label>
								<div class='controls'>
									<input type='text' id='jabatan_name' name='jabatan_name' value='$r[nama_jabatan]'>
								</div>
						  </div>
						  <div class='control-group'>
								<label class='control-label' for='tnj_jabatan'>Tunjangan Jabatan</label>
								<div class='controls'>
									<input type='text' id='tnj_jabatan' name='tnj_jabatan' value='$r[tnj_jabatan]'>
								</div>
						  </div>
						  <div class='control-group'>
								<label class='control-label' for='tnj_transport'>Tunjangan Transport</label>
								<div class='controls'>
									<input type='text' id='tnj_transport' name='tnj_transport' value='$r[tnj_transport]'>
								</div>
						  </div>
				  </div>
				  <div class='span5'>
						  <div class='control-group'>
								<label class='control-label' for='tnj_luarkota'>Tunjangan Luar Kota</label>
								<div class='controls'>
									<input type='text' id='tnj_luarkota' name='tnj_luarkota' value='$r[tnj_luarkota]'>
								</div>
						  </div>
						  <div class='control-group'>
								<label class='control-label' for='uang_makan'>Uang Makan</label>
								<div class='controls'>
									<input type='text' id='uang_makan' name='uang_makan' value='$r[uang_makan]'>
								</div>
						  </div>
						  <div class='control-group'>
								<label class='control-label' for='uang_pulsa'>Uang Pulsa</label>
								<div class='controls'>
									<input type='text' id='uang_pulsa' name='uang_pulsa' value='$r[uang_pulsa]'>
								</div>
						  </div>
						  <div class='control-group'>
								<label class='control-label' for='sewa_motor'>Sewa Motor</label>
								<div class='controls'>
									<input type='text' id='sewa_motor' name='sewa_motor' value='$r[sewa_motor]'>
								</div>
						  </div>
						  <div class='control-group'>
								<div class='controls'>
									<input type='submit' class='btn btn-primary' value='Simpan'>&nbsp
									<input type='reset' class='btn btn-danger' value='Batal' onclick='history.go(-1)'>
								</div>
						  </div>
				  </div>
				  </div>
			  </form>";
    break;  
}
?>
