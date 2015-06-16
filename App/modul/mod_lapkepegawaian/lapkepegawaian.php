<script>
$(document).ready(function(){
	function tampil(){
		var area_id = $('#area_id').combogrid('getValue');
		var tgl_awal = $('#tgl_awal').datebox('getValue');
		var tgl_akhir = $('#tgl_akhir').datebox('getValue');
		$.post('modul/mod_lapkepegawaian/aksi_lapkepegawaian.php?data=listview',{area_id : area_id,
																	   tgl_awal : tgl_awal,
		                                                               tgl_akhir : tgl_akhir},function(data){
				$('#tampil').html(data);
		});
	}
	
	$('#cari').click(function(){
		tampil();
	});
	
	$('#area_id').combogrid({
		panelWidth : 250,
		idField : 'area_id',
		textField : 'area_name',
		url : 'modul/mod_lapkepegawaian/aksi_lapkepegawaian.php?data=area',
		columns : [[
			{field : 'area_id',title: 'Area ID',width:80},
			{field : 'area_name',title: 'Area Name',width:150}			
		]]
	});
	
	function hide(){
	    $('#menu').hide();
		$('#footer').hide();
		$('#filter').hide();
		$('#download').hide();
		$('#print').hide();	
	}
	
	function show(){
		$('#menu').show();
		$('#footer').show();
		$('#filter').show();
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
$aksi="modul/mod_periode/aksi_periode.php";
switch($_GET[act]){
  // Tampil periode
  default:
	    echo "<a class='btn btn-default' id='print' ><i class='icon-print'></i></a>
			<a class='btn btn-default' id='download' ><i class='icon-download-alt'></i></a><div id='filter'><form><fieldset><legend>Laporan Pegawai</legend>
			 <table>
				<tr></td><td>Area</td><td>:</td><td><input type='text' id='area_id' name='area_id' class='input-medium'></td>
				</td><td>Tgl Masuk</td><td>:</td><td>
				&nbsp<input type='text' id='tgl_awal' name='tgl_awal' class='input-small easyui-datebox'>s/d
				<input type='text' id='tgl_akhir' name='tgl_akhir' class='input-small easyui-datebox'>
				<input type='button' id='cari' class='easyui-button' value='Cari'></td></tr>	
			 </table>		
		     </fieldset></form><Br><br></div>";
			 
	    echo "<div id='tampil'></div>";
    break;
}
?>
