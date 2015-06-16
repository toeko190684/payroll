<script>
$(document).ready(function(){
	$('#cc').calendar({
		current:new Date(),
		onSelect: function(date){
		    var tgl = ((date.getMonth()+1)+"/"+date.getDate()+"/"+date.getFullYear());
			$('#tgl').datebox('setValue',tgl);
			var user = '<?php echo $_SESSION[user_id]; ?>';
		    var tgl = $('#tgl').datebox('getValue');
			get_absen(tgl,user);
	    }
    });

	$('#hapus').click(function(){
		var x = $('input[name=id_absen]:checked').val();
		if(x!=''){
			$.messager.confirm('Payroll','Yakin akan menghapus absensi ini ?',function(r){
				if(r){
					$.post('../function/get_data.php?data=hapus',{id : x },function(data){
						$.messager.alert('Payroll',data,'info');
						var user = '<?php echo $_SESSION[user_id]; ?>';
						var tgl = $('#tgl').datebox('getValue');
						get_absen(tgl,user);
					});
				}
			});
		}
	});
	
	function get_absen(tgl,user){
		$.post('../function/get_data.php?data=absensi',{tgl : tgl,user : user},function(data){
			$('#tampil').html(data);
		});
	}
	
	$('#simpan').click(function(){
		var user = '<?php echo $_SESSION[user_id]; ?>';
		var tgl = $('#tgl').datebox('getValue');
		var nip = $('#nip').val();
		var absen = $('input[name=absen]:checked').val();
		var suratdokter = $('input[name=suratdokter]:checked').val();
		if(tgl ==''){
			$.messager.alert('Payroll','Tanggal tidak boleh kosong..!','error');
		}else if(nip ==''){
			$.messager.alert('Payroll','NIP tidak boleh kosong..!','error');
		}else if(absen ==''){
			$.messager.alert('Payroll','Absen tidak boleh kosong..!','error');
		}else{
			$.post('../function/get_data.php?data=simpan_absen',{tgl : tgl, nip : nip, absen : absen, suratdokter : suratdokter},function(data){
				$.messager.alert('Payroll',data,'info');
				get_absen(tgl,user);
			});
		}
	});
	
});
</script>
<?php
$aksi="modul/mod_absensi/aksi_absensi.php";
switch($_GET[act]){
  // Tampil absensi
  default:
		echo "<div id='calendar' class='span3'>
		         <div id='cc' class='easyui-calendar' style='width:180px;height:180px;'></div>
			  </div>";
		echo "<div class='span8'><form class='form-horizontal' >
	          <fieldset><legend>Tambah Absensi</legend>
			        <div class='span7'>
					  <div class='control-group'>
							<label class='control-label' for='tgl'>Tanggal</label>
							<div class='controls'>
								<input id='tgl' type='text' class='easyui-datebox input-small'>
							</div>
					  </div>
					  <div class='control-group'>
							<label class='control-label' for='nip'>NIP</label>
							<div class='controls'>
								<select name='nip' id='nip'>
									<option value=''>--Pilih Sales--</option>";
									$nip = mysql_query("select * from employee where atasan = '$_SESSION[user_id]' and status='aktif'");
									while ($rnip = mysql_fetch_array($nip)){
										echo "<option value='$rnip[nip]'>$rnip[nama_lengkap]</option>";
									}
		echo "					</select>
							</div>
					  </div>
					  <div class='control-group'>
								<label class='control-label' for='absen'>Absensi</label>
								<div class='controls'>
								    <label class='radio inline'>
											<input type='radio' name='absen' value='H' checked>Hadir
									</label>
									<label class='radio inline'>
											<input type='radio' name='absen'  value='A'>Tidak Hadir
									</label>
								</div>
					  </div>
					  <div class='control-group'>
								<label class='control-label' for='suratdokter'>Surat Dokter</label>
								<div class='controls'>
								    <label class='radio inline'>
											<input type='radio' name='suratdokter' value='Y' checked>Ya
									</label>
									<label class='radio inline'>
											<input type='radio' name='suratdokter'  value='T'>Tidak
									</label>
								</div>
					  </div>
					  <div class='control-group'>
							<div class='controls'>
								<input type='button' id='simpan' class='btn btn-primary' value='Simpan'>
								<input type ='reset' id='batal' class='btn btn-success'  value='Batal' >
								<input type ='button' id='hapus' class='btn btn-danger'  value='Hapus' >
							</div>
					  </div>
					</div>
			  </fieldset>
			  </form>
			  
			  <div id='tampil'>
				 <table class='table table-bordered table-hover table-condensed'>
				 <tr class='success'><td>No.</td><td>NIP</td><td>Nama Lengkap</td><tD>Absensi</td><td>Surat Dokter</td></tr>
				 <tR><td colspan='5'>Data tidak ditemukan..!</tD></tR>				 
				 </table>
			  </div>
			  
			</div>";
	break;

  case "tambahabsensi":
	$access = create_security();
	if($access =="allow"){
	    echo "<form method=POST action='$aksi?r=absensi&act=input'>
	          <fieldset><legend>Tambah absensi</legend>
			  <label>absensi ID :</label>
			  <input type='text' name='absensi_id' class='input-small' required><br>
			  <label>Nama absensi :</label>
			  <input type='text' name='absensi_name'  class='input-xlarge' required><br><br>
			  <input type='submit' class='btn btn-primary' value='Simpan'>&nbsp
			  <input type='reset' class='btn btn-danger' value='Batal' onclick='history.go(-1)'>
			  </fieldset></form>";
	}else{
		msg_security();
	}
     break;
 
  case "editabsensi":
    $edit = mysql_query("SELECT * from absensi where absensi_id='$_GET[id]'");
    $r    = mysql_fetch_array($edit);

    echo "<form method=POST action=$aksi?r=absensi&act=update>
          <input type=hidden name=id value='$r[absensi_id]'>
          <fieldset><legend>Edit absensi</legend>
		  <label>absensi ID :</label>
		  <input type='text' name='absensi_id' class='input-small' value='$r[absensi_id]' required><br>
		  <label>Nama absensi :</label>
		  <input type='text' name='absensi_name'  class='input-xlarge' value='$r[absensi_name]' required><br><br>
		  <input type='submit' class='btn btn-primary' value='Simpan'>&nbsp
		  <input type='reset' class='btn btn-danger' value='Batal' onclick='history.go(-1)'>
		  </fieldset></form>";
    break;  
}
?>

