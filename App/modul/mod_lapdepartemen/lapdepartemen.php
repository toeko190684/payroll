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
			 
	    echo "<div id='tampil' class='span6'>		
			  <h3>Laporan Departemen</h3>
			  <table class='table table-bordered table-striped'><tR>
			  <td>No</td><td>Departemen ID</td><td>Departemen Name</td>
			  </tr>";
		$no = 1;
		$sql = mysql_query("select * from departemen order by nama_departemen");
		while($r = mysql_fetch_array($sql)){
			echo "<tr><td>$no</td>
				 <td>$r[id_departemen]</td>
				 <td>$r[nama_departemen]</td>
				 </tr>";
			$no++;
		}
		echo "</table>
			  </div>";
    break;
}
?>
