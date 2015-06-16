<script>
$(document).ready(function(){
	function hide(){
	    $('#menu').hide();
		$('#footer').hide();
		$('#download').hide();
		$('#print').hide();	
	}
	
	function show(){
		$('#menu').show();
		$('#footer').show();
		$('#download').show();
		$('#print').show();	
	}
	
	$('#print').click(function(){
		hide();
		window.print();
		show();
	});
	
	$('#download').click(function(e){
		window.open('data:application/vnd.ms-excel,' + encodeURIComponent($('#tampil').html()));
        e.preventDefault();
	});
});
</script>
<?php
$aksi="modul/mod_laparea/aksi_laparea.php";
switch($_GET[act]){
  // Tampil periode
  default:
	    echo "<a class='btn btn-default' id='print' ><i class='icon-print'></i></a>
			<a class='btn btn-default' id='download' ><i class='icon-download-alt'></i></a><br><br>";
			 
	    echo "<div id='tampil' class='span10'>		
			  <h3>Laporan Jabatan</h3>
			  <table class='table table-bordered table-striped'><tR>
			  <td>No</td><td>Id Jab.</td><td>Nama Jab.</td><td>Tnj. Jab.</td><td>Transport</td><td>L.Kota</td>
			  <td>U.Makan</td><td>U.Pulsa</td><td>Sewa Mtr</td>
			  </tr>";
		$no = 1;
		$sql = mysql_query("select * from jabatan order by id_jabatan");
		while($r = mysql_fetch_array($sql)){
			echo "<tr><td>$no</td>
				 <td>$r[id_jabatan]</td>
				 <td>$r[nama_jabatan]</td>
				 <td>".number_format($r[tnj_jabatan],0,'.',',')."</td>
				 <td>".number_format($r[tnj_transport],0,'.',',')."</td>
				 <td>".number_format($r[tnj_luarkota],0,'.',',')."</td>
				 <td>".number_format($r[uang_makan],0,'.',',')."</td>
				 <td>".number_format($r[uang_pulsa],0,'.',',')."</td>
				 <td>".number_format($r[sewa_motor],0,'.',',')."</td>
				 </tr>";
			$no++;
		}
		echo "</table>
			  </div>";
    break;
}
?>
