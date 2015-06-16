<script>
$(document).ready(function(){
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
			var id = $(this).combogrid('getValue');
			$.post('modul/mod_exporttxt/aksi_exporttxt.php?data=cek_periode',{id:id},function(data){
			    var obj = $.parseJSON(data);
				$('#tgl_efektif').datebox('setValue',obj.tgl_efektif);
				$('#tgl_awal').datebox('setValue',obj.tgl_awal);
				$('#tgl_akhir').datebox('setValue',obj.tgl_akhir);
				
				$.post('modul/mod_exporttxt/aksi_exporttxt.php?data=listview',{id : id, tgl_efektif : obj.tgl_efektif},function(data){
						$('#tampil').html(data);
				});
			});			
		}
	});
	
	$('#totxt').click(function(){
		var id = $('#periode_id').combogrid('getValue');
		var tgl_efektif = $('#tgl_efektif').datebox('getValue');
		if(id==''){
			$.messager.alert('Payroll','Periode ID tidak boleh kosong','info');
		}else if(tgl_efektif==''){
			$.messager.alert('Payroll','Tgl Efektif tidak boleh kosong','info');
		}else{
			$.post('modul/mod_exporttxt/aksi_exporttxt.php?data=export',{id : id,tgl_efektif :tgl_efektif},function(data){
					$('#tampil').html(data);
					var x = $('#nama_file').val();
					var url = 'http://192.168.21.4/payroll/app/modul/mod_exporttxt/'+x;
					location.href = url;
					
					/*window.location = 'modul/mod_exporttxt/'+x;
					
					//perintah untuk menampilkan txt ke div
					$.ajax({
			            url : 'modul/mod_exporttxt/'+x,
			            dataType: "text",
			            success : function (data) {
			                $("#txt").html(data);
			            }
			        });*/
			});
		}
	});
});
</script>
<?php
$aksi="modul/mod_periode/aksi_periode.php";
switch($_GET[act]){
  // Tampil periode
  default:
	    echo "<form><fieldset><legend>Periode</legend>
			 <table>
				<tR><tD>Periode</td><td>:</td>
				<td><input type='text' id='periode_id' name='periode_id' class='input-medium'></td><td>Tgl Efektif</td><td>:</td><td>
				<input type='text' id='tgl_efektif' name='tgl_efektif' class='easyui-datebox input-mini'>
				</td><td>Periode</td><td>:</td><td>
				<input type='text' id='tgl_awal' name='tgl_awal' class='easyui-datebox input-mini'>&nbspS/D&nbsp
				<input type='text' id='tgl_akhir' name='tgl_akhir	' class='easyui-datebox input-mini'>
				</td><tD>&nbsp&nbsp<input type='button' id='totxt' value='Export' class='btn btn-success btn-small'></td></tr>	
			 </table>		
		     </fieldset></form><Br>";
			 
	    echo "<div id='tampil'></div>";
		
		echo "<div id='txt'></div>";
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
			  <input type='text' name='tgl_efektif'  class='easyui-datebox input-mini'><bR><br>
		  <input type='submit' class='btn btn-primary' value='Simpan'>&nbsp
		  <input type='reset' class='btn btn-danger' value='Batal' onclick='history.go(-1)'>
		  </fieldset></form>";
    break;  
}
?>
