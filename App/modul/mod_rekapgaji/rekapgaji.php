<script>
$(document).ready(function(){
	function tampil(){
		var id = $('#periode_id').combogrid('getValue');
		var area_id = $('#area_id').combogrid('getValue');
		var id_departemen = $('#id_departemen').combogrid('getValue');
		$.post('modul/mod_rekapgaji/aksi_rekapgaji.php?data=cek_periode',{id:id},function(data){
		    var obj = $.parseJSON(data);
			$('#tgl_efektif').datebox('setValue',obj.tgl_efektif);
			$('#tgl_awal').datebox('setValue',obj.tgl_awal);
			$('#tgl_akhir').datebox('setValue',obj.tgl_akhir);				
			$.post('modul/mod_rekapgaji/aksi_rekapgaji.php?data=listview',{id : id, 
																		   area_id : area_id,
																		   id_departemen : id_departemen,
			                                                               tgl_efektif : obj.tgl_efektif,
																		   tgl_awal : obj.tgl_awal,
																		   tgl_akhir : obj.tgl_akhir},function(data){
					$('#tampil').html(data);
			});
		});			
	}
	
	$('#area_id').combogrid({
		panelWidth : 250,
		idField : 'area_id',
		textField : 'area_name',
		url : 'modul/mod_rekapgaji/aksi_rekapgaji.php?data=area',
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
		url : 'modul/mod_rekapgaji/aksi_rekapgaji.php?data=departemen',
		columns : [[
			{field : 'id_departemen',title: 'Departemen ID',width:80},
			{field : 'nama_departemen',title: 'Departemen Name',width:150}			
		]],
		onChange : function(value){
			tampil();
		}
	});
	
	$('#periode_id').combogrid({
		panelWidth : 450,
		idField : 'periode_id',
		textField : 'periode_id',
		url : '../function/get_data.php?data=periode',
		columns : [[
			{field : 'periode_id',title: 'Periode ID',width:120},
			{field : 'tgl_awal',title: 'Tgl Awal',width:100},	
			{field : 'tgl_akhir',title: 'Tgl Akhir',width:100},
			{field : 'tgl_efektif',title: 'Tgl Efektif',width:100}				
		]],
		onChange : function(value){		
			tampil();
			/*var id = $(this).combogrid('getValue');
			$.post('modul/mod_rekapgaji/aksi_rekapgaji.php?data=cek_periode',{id:id},function(data){
			    var obj = $.parseJSON(data);
				$('#tgl_efektif').datebox('setValue',obj.tgl_efektif);
				$('#tgl_awal').datebox('setValue',obj.tgl_awal);
				$('#tgl_akhir').datebox('setValue',obj.tgl_akhir);				
				$.post('modul/mod_rekapgaji/aksi_rekapgaji.php?data=listview',{id : id, 
				                                                               tgl_efektif : obj.tgl_efektif,
																			   tgl_awal : obj.tgl_awal,
																			   tgl_akhir : obj.tgl_akhir},function(data){
						$('#tampil').html(data);
				});
			});	*/		
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
			<a class='btn btn-default' id='download' ><i class='icon-download-alt'></i></a><div id='filter'><form><fieldset><legend>Rekap Pembayaran Gaji</legend>
			 <table>
				<tR><tD>Periode</td><td>:</td>
				<td><input type='text' id='periode_id' name='periode_id' class='input-medium'></td><td>Tgl Efektif</td><td>:</td><td>
				<input type='text' id='tgl_efektif' name='tgl_efektif' class='easyui-datebox input-mini'>
				</td><td>Periode</td><td>:</td><td>
				<input type='text' id='tgl_awal' name='tgl_awal' class='easyui-datebox input-mini'>&nbspS/D&nbsp
				<input type='text' id='tgl_akhir' name='tgl_akhir	' class='easyui-datebox input-mini'>
				</td><td>Area</td><td>:</td><td><input type='text' id='area_id' name='area_id' class='input-medium'></td>
				</td><td>Dept.</td><td>:</td><td><input type='text' id='id_departemen' name='nama_departemen' class='input-medium'></td></tr>	
			 </table>		
		     </fieldset></form><Br><br></div>";
			 
	    echo "<div id='tampil'></div>";
    break;
}
?>
