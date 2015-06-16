<script>
$(document).ready(function(){
	function tampil(){
		var area_id = $('#area_id').combogrid('getValue');
		var id_departemen = $('#id_departemen').combogrid('getValue');
		var golongan_id = $('#golongan_id').combogrid('getValue');
		var id_jabatan = $('#id_jabatan').combogrid('getValue');
		$.post('modul/mod_lappegawai/aksi_lappegawai.php?data=listview',{area_id : area_id,
																	   id_departemen : id_departemen,
		                                                               golongan_id : golongan_id,
																	   id_jabatan : id_jabatan},function(data){
				$('#tampil').html(data);
		});
	}
	
	$('#area_id').combogrid({
		panelWidth : 250,
		idField : 'area_id',
		textField : 'area_name',
		url : 'modul/mod_lappegawai/aksi_lappegawai.php?data=area',
		columns : [[
			{field : 'area_id',title: 'Area ID',width:80},
			{field : 'area_name',title: 'Area Name',width:150}			
		]],
		onChange : function(value){
			tampil();
		}
	});
	
	$('#id_departemen').combogrid({
		panelWidth : 250,
		idField : 'id_departemen',
		textField : 'nama_departemen',
		url : 'modul/mod_lappegawai/aksi_lappegawai.php?data=departemen',
		columns : [[
			{field : 'id_departemen',title: 'Departemen ID',width:80},
			{field : 'nama_departemen',title: 'Departemen Name',width:150}			
		]],
		onChange : function(value){
			tampil();
		}
	});
	
	$('#golongan_id').combogrid({
		panelWidth : 250,
		idField : 'golongan_id',
		textField : 'golongan_id',
		url : 'modul/mod_lappegawai/aksi_lappegawai.php?data=golongan',
		columns : [[
			{field : 'golongan_id',title: 'Golongan ID',width:80},
			{field : 'gaji_pokok',title: 'Gaji Pokok',width:150}			
		]],
		onChange : function(value){
			tampil();
		}
	});
	
	$('#id_jabatan').combogrid({
		panelWidth : 250,
		idField : 'id_jabatan',
		textField : 'id_jabatan',
		url : 'modul/mod_lappegawai/aksi_lappegawai.php?data=jabatan',
		columns : [[
			{field : 'id_jabatan',title: 'Jabatan ID',width:80},
			{field : 'nama_jabatan',title: 'Nama Jabatan',width:150}			
		]],
		onChange : function(value){
			tampil();
		}
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
				</td><td>Dept.</td><td>:</td><td><input type='text' id='id_departemen' name='id_departemen' class='input-medium'></td>
				</td><td>Golongan.</td><td>:</td><td><input type='text' id='golongan_id' name='golongan_id' class='input-medium'></td>
				</td><td>Jabatan.</td><td>:</td><td><input type='text' id='id_jabatan' name='nama_id_jabatan' class='input-medium'></td></tr>	
			 </table>		
		     </fieldset></form><Br><br></div>";
			 
	    echo "<div id='tampil'></div>";
    break;
}
?>
