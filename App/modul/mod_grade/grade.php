<?php
$aksi="modul/mod_grade/aksi_grade.php";
switch($_GET[act]){
  // Tampil grade
  default:
	    $per_page = 10;
		$page_query = mysql_query("SELECT count(*) FROM grade ORDER BY grade_name");
		$pages = ceil(mysql_result($page_query,0)/$per_page);
		$page = (isset($_GET[page]))? (int)$_GET[page]:1;
		$start = ($page-1)*$per_page;
		echo "<blockquote>Master grade</blockquote>
	          <input type=button class='btn btn-primary' value='Tambah' 
			  onclick=\"window.location.href='index.php?r=grade&act=tambahgrade';\"><br><bR>
	          <table class='table table-condensed table-hover table-bordered' >
	          <tdead>
				<tr class='success'>
					<td>No</td><td>ID grade</td><td>Nama grade</td><td>Aksi</td>
				</tr>
			  </tdead>";
	    
		$tampil=mysql_query("select * from grade ORDER BY grade_name limit $start,$per_page");
	    $no = 1;
		$no = $no+$start;
		while ($r=mysql_fetch_array($tampil)){
	      echo "<tbody><tr>
		            <td>$no</tD>
		            <td>$r[grade_id]</td>
					<td>$r[grade_name]</td>
		            <td><a href='index.php?r=grade&act=editgrade&id=$r[grade_id]'>Edit</a> | 
			              <a href='$aksi?r=grade&act=hapus&id=$r[grade_id]'>Hapus</a>
		            </td>
				</tr></tbody>";
				$no++;
	    }
	    echo "</table>";
		//memulai paginasi
		echo "<div class='pagination pagination-small pagination-right'><ul><li><a href='?r=grade&page=1'>First</a></li>";
		if($pages >= 1 && $page <= $pages){
		    for($x=1; $x<=$pages; $x++){
		        echo ($x == $page) ? '<li><a href="?r=grade&page='.$x.'">'.$x.'</a></li> ' : '<li><a href="?r=grade&page='.$x.'">'.$x.'</a></li>';
		    }
		}
		$x--;
		echo "<li><a href='?r=grade&page=$x'>Last</a></li></ul></div>";
    break;

  case "tambahgrade":
	    echo "<form method=POST action='$aksi?r=grade&act=input'>
	          <fieldset><legend>Tambah grade</legend>
			  <label>grade ID :</label>
			  <input type='text' name='grade_id' class='input-small' required><br>
			  <label>Nama grade :</label>
			  <input type='text' name='grade_name'  class='input-xlarge' required><br><br>
			  <input type='submit' class='btn btn-primary' value='Simpan'>&nbsp
			  <input type='reset' class='btn btn-danger' value='Batal' onclick='history.go(-1)'>
			  </fieldset></form>";
     break;
 
  case "editgrade":
    $edit = mysql_query("SELECT * from grade where grade_id='$_GET[id]'");
    $r    = mysql_fetch_array($edit);

    echo "<form method=POST action=$aksi?r=grade&act=update>
          <input type=hidden name=id value='$r[grade_id]'>
          <fieldset><legend>Edit grade</legend>
		  <label>grade ID :</label>
		  <input type='text' name='grade_id' class='input-small' value='$r[grade_id]' required><br>
		  <label>Nama grade :</label>
		  <input type='text' name='grade_name'  class='input-xlarge' value='$r[grade_name]' required><br><br>
		  <input type='submit' class='btn btn-primary' value='Simpan'>&nbsp
		  <input type='reset' class='btn btn-danger' value='Batal' onclick='history.go(-1)'>
		  </fieldset></form>";
    break;  
}
?>
