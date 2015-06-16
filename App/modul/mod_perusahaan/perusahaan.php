<script>
$(document).ready(function(){
	$('#example').dataTable();
});
</script>
<?php
$aksi="modul/mod_perusahaan/aksi_perusahaan.php";
switch($_GET[act]){
  // Tampil perusahaan
  default:
	    echo "<a href='index.php?r=perusahaan&act=tambahperusahaan' class='btn btn-primary'>Tambah</a><br><br>";
		
		echo "<table id='example' class='table table-striped table-bordered table-hover' cellspacing='0' with='100%'>
	          <thead>
				<tr>
					<th>ID Perusahaan</th><th>Nama Perusahaan</th><th>Nomor Rekening</th><th>aksi</th>
				</tr>
			  </thead><tbody>";

		$tampil = mysql_query("select * from perusahaan ORDER BY nama_perusahaan");

		while ($r=mysql_fetch_array($tampil)){
	      echo "<tr>
		            <td>$r[id_perusahaan]</td>
					<td>$r[nama_perusahaan]</td>
					<td>$r[nomor_rekening]</td>
		            <td><a href='index.php?r=perusahaan&act=editperusahaan&id=$r[id_perusahaan]'><i class='icon-pencil'></i></a>
			              <a href='$aksi?r=perusahaan&act=hapus&id=$r[id_perusahaan]'><i class='icon-trash'></i></a>
		            </td>
				</tr>";
	    }
	    echo "</tbody></table>";
    break;

  case "tambahperusahaan":
	    echo "<form method=POST action='$aksi?r=perusahaan&act=input'>
	          <fieldset><legend>Tambah perusahaan</legend>
			  <label>ID perusahaan :</label>
			  <input type='text' name='perusahaan_id' class='input-medium' required><br>
			  <label>Nama perusahaan :</label>
			  <input type='text' name='perusahaan_name'  class='input-xlarge' required><br>
			  <label>Nomor Rekening :</label>
			  <input type='text' name='nomor_rekening' class='input-medium' required><br><br>
			  <input type='submit' class='btn btn-primary' value='Simpan'>&nbsp
			  <input type='reset' class='btn btn-danger' value='Batal' onclick='history.go(-1)'>
			  </fieldset></form>";
     break;
 
  case "editperusahaan":
    $edit = mysql_query("SELECT * from perusahaan where id_perusahaan='$_GET[id]'");
    $r    = mysql_fetch_array($edit);

    echo "<form method=POST action=$aksi?r=perusahaan&act=update>
          <input type=hidden name=id value='$r[id_perusahaan]'>
          <fieldset><legend>Edit perusahaan</legend>
		  <label>ID perusahaan :</label>
		  <input type='text' name='perusahaan_id' class='input-medium' value='$r[id_perusahaan]' required><br>
		  <label>Nama perusahaan :</label>
		  <input type='text' name='perusahaan_name'  class='input-xlarge' value='$r[nama_perusahaan]' required><br>
		  <label>Nomor Rekening :</label>
		  <input type='text' name='nomor_rekening' class='input-medium' value='$r[nomor_rekening]' required><br><br>
		  <input type='submit' class='btn btn-primary' value='Simpan'>&nbsp
		  <input type='reset' class='btn btn-danger' value='Batal' onclick='history.go(-1)'>
		  </fieldset></form>";
    break;  
}
?>
