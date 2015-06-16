<script>
$(document).ready(function(){
	$('#example').dataTable();
});
</script>

<?php
$aksi="modul/mod_area/aksi_area.php";
switch($_GET[act]){
  // Tampil area
  default:
		echo "<a href='index.php?r=area&act=tambaharea' class='btn btn-primary'>Tambah</a><br><br>";
		
		echo "<table id='example' class='table table-striped table-bordered table-hover' cellspacing='0' with='100%'>
	          <thead>
				<tr>
					<th>Area ID</th><th>Area Name</th><th>aksi</th>
				</tr>
			  </thead><tbody>";

		$tampil = mysql_query("select * from area ORDER BY area_name");

		while ($r=mysql_fetch_array($tampil)){
	      echo "<tr>
		            <td>$r[area_id]</td>
					<td>$r[area_name]</td>
		            <td><a href='index.php?r=area&act=editarea&id=$r[area_id]'><i class='icon-pencil'></i></a>
			              <a href='$aksi?r=area&act=hapus&id=$r[area_id]'><i class='icon-trash'></i></a>
		            </td>
				</tr>";
	    }
	    echo "</tbody></table>";
    break;

  case "tambaharea":
	    echo "<form method=POST action='$aksi?r=area&act=input'>
	          <fieldset><legend>Tambah area</legend>
			  <label>area ID :</label>
			  <input type='text' name='area_id' class='input-small' required><br>
			  <label>Nama area :</label>
			  <input type='text' name='area_name'  class='input-xlarge' required><br><br>
			  <input type='submit' class='btn btn-primary' value='Simpan'>&nbsp
			  <input type='reset' class='btn btn-danger' value='Batal' onclick='history.go(-1)'>
			  </fieldset></form>";
     break;
 
  case "editarea":
    $edit = mysql_query("SELECT * from area where area_id='$_GET[id]'");
    $r    = mysql_fetch_array($edit);

    echo "<form method=POST action=$aksi?r=area&act=update>
          <input type=hidden name=id value='$r[area_id]'>
          <fieldset><legend>Edit area</legend>
		  <label>area ID :</label>
		  <input type='text' name='area_id' class='input-small' value='$r[area_id]' required><br>
		  <label>Nama area :</label>
		  <input type='text' name='area_name'  class='input-xlarge' value='$r[area_name]' required><br><br>
		  <input type='submit' class='btn btn-primary' value='Simpan'>&nbsp
		  <input type='reset' class='btn btn-danger' value='Batal' onclick='history.go(-1)'>
		  </fieldset></form>";
    break;  
}
?>
