<script>
$(document).ready(function(){
    function kosong(){
		$('#nip').combogrid('setValue','');
		$('#nama_karyawan').val('');
		$('#id_jabatan').val('');
		$('#jml_hari').val('');
		
	}
	function gaji_kotor(){
		var total_gaji_pokok = $('#total_gaji_pokok').numberbox('getValue');
		var total_tnj_jabatan = $('#total_tnj_jabatan').numberbox('getValue');
		var total_tnj_transport = $('#total_tnj_transport').numberbox('getValue');
		var total_tnj_luarkota = $('#total_tnj_luarkota').numberbox('getValue');
		var total_uang_makan = $('#total_uang_makan').numberbox('getValue');
		var total_uang_pulsa = $('#total_uang_pulsa').numberbox('getValue');
		var total_sewa_motor = $('#total_sewa_motor').numberbox('getValue');
		var total_insentif = $('#total_insentif').numberbox('getValue');
		var total_lain_lain = $('#total_lain_lain').numberbox('getValue');
		var gaji_kotor = eval(total_gaji_pokok) + eval(total_tnj_jabatan) + eval(total_tnj_transport) +
		                 eval(total_tnj_luarkota) + eval(total_uang_makan) + eval(total_uang_pulsa)+
						 eval(total_sewa_motor) + eval(total_insentif) + eval(total_lain_lain);
		$('#gaji_kotor').numberbox('setValue',gaji_kotor);
	}
	
	function gaji_bersih(){
		var gaji_kotor = $('#gaji_kotor').numberbox('getValue');
		var total_potongan = $('#total_potongan').numberbox('getValue');
		var gaji_bersih = eval(gaji_kotor) - eval(total_potongan);
		$('#gaji_bersih').numberbox('setValue',gaji_bersih);
	}	
	
	function hitung(){
		var tnj_jabatan = $('#tnj_jabatan').numberbox('getValue');
		var jml_jabatan = $('#jml_jabatan').val();
		var total_tnj_jabatan = eval(tnj_jabatan)*eval(jml_jabatan);
		$('#total_tnj_jabatan').numberbox('setValue',total_tnj_jabatan);
		
		var tnj_transport = $('#tnj_transport').numberbox('getValue');
		var jml_transport = $('#jml_transport').val();
		var total_tnj_transport = eval(tnj_transport)*eval(jml_transport);
		$('#total_tnj_transport').numberbox('setValue',total_tnj_transport);
		
		var tnj_luarkota = $('#tnj_luarkota').numberbox('getValue');
		var jml_luarkota = $('#jml_luarkota').val();
		var total_tnj_luarkota = eval(tnj_luarkota)*eval(jml_luarkota);
		$('#total_tnj_luarkota').numberbox('setValue',total_tnj_luarkota);
		
		var uang_makan = $('#uang_makan').numberbox('getValue');
		var jml_uangmakan = $('#jml_uangmakan').val();
		var total_uang_makan = eval(uang_makan)*eval(jml_uangmakan);
		$('#total_uang_makan').numberbox('setValue',total_uang_makan);
		
		var uang_pulsa = $('#uang_pulsa').numberbox('getValue');
		var jml_uangpulsa = $('#jml_uangpulsa').val();
		var total_uang_pulsa = eval(uang_pulsa)*eval(jml_uangpulsa);
		$('#total_uang_pulsa').numberbox('setValue',total_uang_pulsa);
		
		var sewa_motor = $('#sewa_motor').numberbox('getValue');
		var jml_sewamotor = $('#jml_sewamotor').val();
		var total_sewa_motor = eval(sewa_motor)*eval(jml_sewamotor);
		$('#total_sewa_motor').numberbox('setValue',total_sewa_motor);
	}
	
	$('#periode_id').combogrid({
		panelWidth : 350,
		idField : 'periode_id',
		textField : 'periode_id',
		url : '../function/get_data.php?data=periode',
		columns : [[
			{field : 'periode_id',title: 'Periode ID',width:120},
			{field : 'tgl_awal',title: 'Tgl Awal',width:100},	
			{field : 'tgl_akhir',title: 'Tgl Akhir',width:100}			
		]],
		onChange : function(value){		
			var id = $(this).combogrid('getValue');
			$.post('../function/get_data.php?data=periode',{id : id},function(data){
				var obj = $.parseJSON(data);
				$('#startday').datebox('setValue',obj.tgl_awal);
				$('#endday').datebox('setValue',obj.tgl_akhir);
				hitung();
				gaji_kotor();
				gaji_bersih();
			});
		}
	});
	
	$('#nip').combogrid({
		panelWidth : 450,
		idField : 'nip',
		textField : 'nip',
		url : '../function/get_data.php?data=employee',
		columns : [[
			{field : 'nip',title: 'NIP',width:120},
			{field : 'nama_karyawan',title: 'Nama Karyawan',width:300}		
		]],
		onChange : function(value){		
			var id = $(this).combogrid('getValue');
			var periode_id = $('#periode_id').combogrid('getValue');
			if(periode_id==''){
				$.messager.alert('Payroll','Perode ID tidak boleh kosong','info');
			}else{
				$.post('../function/get_data.php?data=cek_payroll',{id : id,periode_id : periode_id},function(data){
				    if(data==''){
						$.post('../function/get_data.php?data=employee',{id : id},function(data){
							var obj = $.parseJSON(data);
							$('#nama_karyawan').val(obj.nama_karyawan);
							$('#id_jabatan').val(obj.nama_jabatan);
							$('#gaji_pokok').numberbox('setValue',obj.gaji_pokok);
							$('#total_gaji_pokok').numberbox('setValue',obj.gaji_pokok);
							$('#tnj_jabatan').numberbox('setValue',obj.tnj_jabatan);
							$('#tnj_transport').numberbox('setValue',obj.tnj_transport);
							$('#tnj_luarkota').numberbox('setValue',obj.tnj_luarkota);
							$('#uang_makan').numberbox('setValue',obj.uang_makan);
							$('#uang_pulsa').numberbox('setValue',obj.uang_pulsa);
							$('#sewa_motor').numberbox('setValue',obj.sewa_motor);
							hitung();
							gaji_kotor();
							gaji_bersih();
						});
					}else{
						$.messager.alert('Payroll',data,'info');
					}
				});
			}
		}
	});
	
	$('#jml_hari').keyup(function(e){
		var x = $(e.target).val();
		$('#jml_jabatan').val(x);
		$('#jml_transport').val(x);
		$('#jml_luarkota').val(x);
		$('#jml_uangmakan').val(x);
		$('#jml_uangpulsa').val(x);
		$('#jml_sewamotor').val(x);
		hitung();
		gaji_kotor();
		gaji_bersih();
	});
	
	$('#jml_jabatan').keyup(function(e){
		var x = $(e.target).val();
		var tnj_jabatan = $('#tnj_jabatan').numberbox('getValue');
		var total_tnj_jabatan = eval(x) * eval(tnj_jabatan);
		$('#total_tnj_jabatan').numberbox('setValue',total_tnj_jabatan);
		hitung();
		gaji_kotor();
		gaji_bersih();
	});
	
	$('#jml_transport').keyup(function(e){
		var x = $(e.target).val();
		var tnj_transport = $('#tnj_transport').numberbox('getValue');
		var total_tnj_transport = eval(x) * eval(tnj_transport);
		$('#total_tnj_transport').numberbox('setValue',total_tnj_transport);
		hitung();
		gaji_kotor();
		gaji_bersih();
	});
	
	$('#jml_luarkota').keyup(function(e){
		var x = $(e.target).val();
		var tnj_luarkota = $('#tnj_luarkota').numberbox('getValue');
		var total_tnj_luarkota = eval(x) * eval(tnj_luarkota);
		$('#total_tnj_luarkota').numberbox('setValue',total_tnj_luarkota);
		hitung();
		gaji_kotor();
		gaji_bersih();
	});
	
	$('#jml_uangmakan').keyup(function(e){
		var x = $(e.target).val();
		var uang_makan = $('#uang_makan').numberbox('getValue');
		var total_uang_makan = eval(x) * eval(uang_makan);
		$('#total_uang_makan').numberbox('setValue',total_uang_makan);
		hitung();
		gaji_kotor();
		gaji_bersih();
	});
	
	$('#jml_uangpulsa').keyup(function(e){
		var x = $(e.target).val();
		var uang_pulsa = $('#uang_pulsa').numberbox('getValue');
		var total_uang_pulsa = eval(x) * eval(uang_pulsa);
		$('#total_uang_pulsa').numberbox('setValue',total_uang_pulsa);
		hitung();
		gaji_kotor();
		gaji_bersih();
	});
	
	$('#jml_sewamotor').keyup(function(e){
		var x = $(e.target).val();
		var sewa_motor = $('#sewa_motor').numberbox('getValue');
		var total_sewa_motor = eval(x) * eval(sewa_motor);
		$('#total_sewa_motor').numberbox('setValue',total_sewa_motor);
		hitung();
		gaji_kotor();
		gaji_bersih();
	});
	
	
	
	$('#insentif').keyup(function(e){
		var x = $(e.target).val();
		$('#total_insentif').numberbox('setValue',x);
		gaji_kotor();
		gaji_bersih();
	});
	
	$('#lain_lain').keyup(function(e){
		var x = $(e.target).val();
		$('#total_lain_lain').numberbox('setValue',x);
		gaji_kotor();
		gaji_bersih();
	});
	
	$('#potongan').keyup(function(e){
		var x = $(e.target).val();
		$('#total_potongan').numberbox('setValue',x);
		gaji_bersih();
	});
	
	$('#simpan').click(function(){
	    var periode_id = $('#periode_id').combogrid('getValue');
		var startday = $('#startday').datebox('getValue');
		var endday = $('#endday').datebox('getValue');
		var nip = $('#nip').combogrid('getValue');
		var nama_karyawan = $('#nama_karyawan').val();
		var id_jabatan = $('#id_jabatan').val();
		var jml_hari = $('#jml_hari').numberbox('getValue');
		var gaji_pokok = $('#total_gaji_pokok').numberbox('getValue');
		var tnj_jabatan = $('#total_tnj_jabatan').numberbox('getValue');
		var tnj_transport = $('#total_tnj_transport').numberbox('getValue');
		var tnj_luar_kota = $('#total_tnj_luarkota').numberbox('getValue');
		var uang_makan = $('#total_uang_makan').numberbox('getValue');
		var uang_pulsa = $('#total_uang_pulsa').numberbox('getValue');
		var sewa_motor = $('#total_sewa_motor').numberbox('getValue');
		var insentif = $('#total_insentif').numberbox('getValue');
		var lain_lain = $('#total_lain_lain').numberbox('getValue');
		var potongan = $('#total_potongan').numberbox('getValue');
		var gaji_kotor = $('#gaji_kotor').numberbox('getValue');
		var gaji_bersih = $('#gaji_bersih').numberbox('getValue');
		if(startday==''){
			$.messager.alert('SKProject','Periode awal tidak boleh kosong','info');
		}else if(endday==''){
			$.messager.alert('SKProject','Periode akhir tidak boleh kosong','info');
		}else if(nip==''){
			$.messager.alert('SKProject','NIP tidak boleh kosong','info');
		}
		$.post('../function/get_data.php?data=simpan_payroll',{periode_id : periode_id,
															   startday : startday,
															   endday : endday,
															   nip : nip,
															   nama_karyawan : nama_karyawan,
															   id_jabatan : id_jabatan,
															   jml_hari : jml_hari,
															   gaji_pokok : gaji_pokok,
															   tnj_jabatan : tnj_jabatan,
															   tnj_transport : tnj_transport,
															   tnj_luar_kota : tnj_luar_kota,
															   uang_makan : uang_makan,
															   uang_pulsa : uang_pulsa,
															   sewa_motor : sewa_motor,
															   insentif : insentif,
															   lain_lain : lain_lain,
															   potongan : potongan,
															   gaji_kotor : gaji_kotor,
															   gaji_bersih : gaji_bersih
																},function(data){
					$.messager.alert('Payroll',data,'info');
			
		});
	});
});
</script>

<?php
$aksi="modul/mod_payroll/aksi_payroll.php";
switch($_GET[act]){
  // Tampil payroll
  default:
	    $per_page = 10;
		if($_POST[key]==''){
			$page_query = mysql_query("SELECT count(*) FROM payroll ORDER BY nip");
		}else{
			$page_query = mysql_query("SELECT count(*) FROM payroll where nama_karyawan like '%$_POST[key]%'");
		}
		$pages = ceil(mysql_result($page_query,0)/$per_page);
		$page = (isset($_GET[page]))? (int)$_GET[page]:1;
		$start = ($page-1)*$per_page;
		echo "<blockquote>Payroll</blockquote>
	          <input type=button class='btn btn-primary' value='Tambah' 
			  onclick=\"window.location.href='index.php?r=payroll&act=tambahpayroll';\">
			  <form class='form-search' method=post action='?r=payroll'>	
					<div class='input-append'>
					    <div class='span8'></div>
						<input class='span3 search-query' id='key' name='key' type='text' placeholder='Masukan Nama Karyawan.!'>
					    <button class='btn' type='submit'>Cari</button>
					</div><br>
			  </form>
	          <table class='table table-condensed table-hover table-bordered' >
	          <tdead>
				<tr class='success'>
					<td>No</td><tD>Periode ID</td><td>Payroll ID</td><tD>Nama Karyawan</tD><td>Start Date</td><td>End Date</td>
					<td>Gaji Kotor</td><td>Gaji Bersih</td><td>Aksi</td>
				</tr>
			  </tdead>";
	    if($_POST[key]==''){
			$tampil=mysql_query("SELECT b.periode_id,a.payroll_id,a.nama_karyawan,b.tgl_awal,b.tgl_akhir, a.gaji_kotor,a.gaji_bersih
			                    FROM payroll a,periode b where a.periode_id=b.periode_id
								order by b.periode_id,b.tgl_awal,b.tgl_akhir  limit $start,$per_page");
		}else{
			$tampil=mysql_query("SELECT b.periode_id,a.payroll_id,a.nama_karyawan,b.tgl_awal,b.tgl_akhir, a.gaji_kotor,a.gaji_bersih
			                    FROM payroll a,periode b where a.periode_id=b.periode_id and a.nama_karyawan like '%$_POST[key]%'
								order by b.periode_id,b.tgl_awal,b.tgl_akhir  limit $start,$per_page");
		}
	    $no = 1;
		$no = $no+$start;
		while ($r=mysql_fetch_array($tampil)){
	      echo "<tbody><tr>
		            <td>$no</tD>
					<td>$r[periode_id]</td>
					<td>$r[payroll_id]</td>
					<tD>$r[nama_karyawan]</td>
		            <td>$r[tgl_awal]</td>
					<td>$r[tgl_akhir]</td>
					<td>".number_format($r[gaji_kotor],2,',','.')."</td>
					<td>".number_format($r[gaji_bersih],2,',','.')."</td>
		            <td><i class='icon-trash'></i><a href='$aksi?r=payroll&act=hapus&id=$r[payroll_id]'>Hapus</a>
		            </td>
				</tr></tbody>";
				$no++;
	    }
	    echo "</table>";
		//memulai paginasi
		echo "<div class='pagination pagination-small pagination-right'><ul><li><a href='?r=payroll&page=1'>First</a></li>";
		if($pages >= 1 && $page <= $pages){
		    for($x=1; $x<=$pages; $x++){
		        echo ($x == $page) ? '<li><a href="?r=payroll&page='.$x.'">'.$x.'</a></li> ' : '<li><a href="?r=payroll&page='.$x.'">'.$x.'</a></li>';
		    }
		}
		$x--;
		echo "<li><a href='?r=payroll&page=$x'>Last</a></li></ul></div>";
    break;

  case "tambahpayroll":
		echo "<form><fieldset><legend>Tambah Payroll</legend>
				      <table>
						<tR>
							<td>Periode ID</td><tD> : </td>
							<td><input type='text' id='periode_id' name='periode_id' class='input-medium'  ></td>
						</tr>
						<tr><td colspan='5'></td></tr>
						<tR>
							<td>Tgl Periode</td><tD> : </td>
							<tD><input type='text' id='startday' name='startday' class='easyui-datebox input-mini'  >&nbspS/D&nbsp
							<input type='text' id='endday' name='endday' class='easyui-datebox input-mini'  ></td>
						</tr>
						<tr><td colspan='5'></td></tr>
						<tR>
							<td>NIP</td><tD> : </td>
							<td><select id='nip' name='nip'><option value=''>--Karyawan--</option>";
							$nip = mysql_query("select nip,nama_karyawan from employee where jenis_pegawai='aktif' order by nama_karyawan");
							while($rnip = mysql_fetch_array($nip)){
								echo "<option value='$rnip[nip]'>$rnip[nip]</option>";
							}
		echo "				</select></td>
						</tr>
						<tr><td colspan='5'></td></tr>
						<tR>
							<td>Nama Karyawan</td><tD> : </td>
							<td><input type='text' id='nama_karyawan' name='nama_karyawan' disabled></td>
						</tr>
						<tr><td colspan='5'></td></tr>
						<tr>
							<td>Jabatan</td><tD> : </td>
							<td><input type='text' id='id_jabatan' name='id_jabatan' class='input-medium' disabled></td>
							<td>Jml. Hari</td><td>:</td><td><input type='text' id='jml_hari' name='jml_hari' value=0 class='easyui-numberbox input-mini' groupSeparator=',' data-options='min:0'  ></td>
						</tr>
						<tr><td colspan='5'></td></tr>
						<tR>
							<td>Gaji Pokok</td><tD> : </td>
							<td><input  type='text' id='gaji_pokok' name='gaji_pokok' value=0 class='easyui-numberbox input-medium' groupSeparator=',' data-options='min:0'  disabled></td>
							<tD colspan=2>/bulan</td>
							<td> = Rp</td>
							<td><input  type='text' id='total_gaji_pokok' name='total_gaji_pokok' value=0 class='easyui-numberbox input-medium' groupSeparator=',' data-options='min:0'  disabled></td>
						</tr>
						<tr><td colspan='5'></td></tr>
						<tR>
							<td>Tunjangan Jabatan</td><tD> : </td>
							<td><input  type='text' id='tnj_jabatan' name='tnj_jabatan' value=0 class='easyui-numberbox input-medium' groupSeparator=',' data-options='min:0' disabled ></td>
							<tD>X</td>
							<tD><input type='text' id='jml_jabatan' value=0 class='easyui-numberbox input-mini' groupSeparator=',' data-options='min:0'  ></td>
							<td> = Rp</td>
							<td><input  type='text' id='total_tnj_jabatan' name='total_tnj_jabatan' value=0 class='easyui-numberbox input-medium' groupSeparator=',' data-options='min:0' disabled ></td>
						</tr>
						<tr><td colspan='5'></td></tr>
						<tR>
							<td>Tunjangan Transport</td><tD> : </td>
							<td><input  type='text' id='tnj_transport' name='tnj_transport' value=0 class='easyui-numberbox input-medium' groupSeparator=',' data-options='min:0' disabled></td>
							<tD>X</td>
							<tD><input type='text' id='jml_transport' value=0 class='easyui-numberbox input-mini' groupSeparator=',' data-options='min:0' ></td>
							<td> = Rp</td>
							<td><input  type='text' id='total_tnj_transport' name='total_tnj_transport' value=0 class='easyui-numberbox input-medium' groupSeparator=',' data-options='min:0'  disabled></td>
						</tr>
						<tr><td colspan='5'></td></tr>
						<tR>
							<td>Tunjangan Luar Kota</td><tD> : </td>
							<td><input  type='text' id='tnj_luarkota' name='tnj_luarkota' value=0 class='easyui-numberbox input-medium' groupSeparator=',' data-options='min:0' disabled></td>
							<tD>X</td>
							<tD><input type='text' id='jml_luarkota' value=0 class='easyui-numberbox input-mini' groupSeparator=',' data-options='min:0' ></td>
							<td> = Rp</td>
							<td><input  type='text' id='total_tnj_luarkota' name='total_tnj_luarkota' value=0 class='easyui-numberbox input-medium' groupSeparator=',' data-options='min:0' disabled></td>
						</tr>
						<tr><td colspan='5'></td></tr>
						<tR>
							<td>Uang Makan</td><tD> : </td>
							<td><input  type='text' id='uang_makan' name='uang_makan' value=0 class='easyui-numberbox input-medium' groupSeparator=',' data-options='min:0' disabled></td>
							<tD>X</td>
							<tD><input type='text' id='jml_uangmakan' value=0 class='easyui-numberbox input-mini' groupSeparator=',' data-options='min:0' ></td>
							<td> = Rp</td>
							<td><input  type='text' id='total_uang_makan' name='total_uang_makan' value=0 class='easyui-numberbox input-medium' groupSeparator=',' data-options='min:0' disabled></td>
						</tr>
						<tr><td colspan='5'></td></tr>
						<tR>
							<td>Uang Pulsa</td><tD> : </td>
							<td><input  type='text' id='uang_pulsa' name='uang_pulsa' value=0 class='easyui-numberbox input-medium' groupSeparator=',' data-options='min:0' disabled></td>
							<tD>X</td>
							<tD><input type='text' id='jml_uangpulsa' value=0 class='easyui-numberbox input-mini' groupSeparator=',' data-options='min:0' ></td>
							<td> = Rp</td>
							<td><input  type='text' id='total_uang_pulsa' name='total_uang_pulsa' value=0 class='easyui-numberbox input-medium' groupSeparator=',' data-options='min:0'  disabled></td>
						</tr>
						<tr><td colspan='5'></td></tr>
						<tR>
							<td>Sewa Motor</td><tD> : </td>
							<td><input  type='text' id='sewa_motor' name='sewa_motor' value=0 class='easyui-numberbox input-medium' groupSeparator=',' data-options='min:0' disabled></td>
							<tD>X</td>
							<tD><input type='text' id='jml_sewamotor' value=0 class='easyui-numberbox input-mini' groupSeparator=',' data-options='min:0' ></td>
							<td> = Rp</td>
							<td><input  type='text' id='total_sewa_motor' name='total_sewa_motor' value=0 class='easyui-numberbox input-medium' groupSeparator=',' data-options='min:0' disabled></td>
						</tr>
						<tr><td colspan='5'></td></tr>
						<tR>
							<td>Insentive</td><tD> : </td>
							<td colspan=3><input  type='text' id='insentif' name='insentif' value=0 class='easyui-numberbox input-medium' groupSeparator=',' data-options='min:0'></td>
							<td> = Rp</td>
							<td><input  type='text' id='total_insentif' name='total_insentif' value=0 class='easyui-numberbox input-medium' groupSeparator=',' data-options='min:0'  disabled></td>
						</tr>
						<tr><td colspan='5'></td></tr>
						<tR>
							<td>Lain-lain</td><tD> : </td>
							<td colspan=3><input  type='text' id='lain_lain' name='lain_lain' value=0 class='easyui-numberbox input-medium' groupSeparator=',' data-options='min:0' ></td>
							<td> = Rp</td>
							<td><input  type='text' id='total_lain_lain' name='total_lain_lain' value=0 class='easyui-numberbox input-medium' groupSeparator=',' data-options='min:0'  disabled></td>
						</tr>
						<tr><td colspan='5'></td></tr><tr><td colspan='5'></td></tr>
						<tR>
							<td colspan='4'></td><td><b> Gaji Kotor </b></td><td>= Rp</td>
							<td><input  type='text' id='gaji_kotor' name='gaji_kotor' value=0 class='easyui-numberbox input-medium' groupSeparator=',' data-options='min:0'  disabled></td>
						</tr>
						<tr><td colspan='5'></td></tr>
						<tR>
							<td>Potongan</td><tD> : </td>
							<td colspan=3><input  type='text' id='potongan' name='potongan' value=0 class='easyui-numberbox input-medium' groupSeparator=',' data-options='min:0'  ></td>
							<td> = Rp</td>
							<td><input  type='text' id='total_potongan' name='total_potongan' value=0 class='easyui-numberbox input-medium' groupSeparator=',' data-options='min:0' disabled></td>
						</tr>
						<tr><td colspan='5'></td></tr><tr><td colspan='5'></td></tr>
						<tR>
							<td colspan='4'></td><td><b> Gaji Bersih </b></td><td>= Rp</td>
							<td><input  type='text' id='gaji_bersih' name='gaji_bersih' value=0 class='easyui-numberbox input-medium' groupSeparator=',' data-options='min:0' disabled ></td>
						</tr>
					  </table>		
						<div class='control-group'>
									<div class='controls'>
										<input type='button' id='simpan' class='btn btn-primary' value='Simpan'>
										<input type ='button' id='batal' class='btn btn-danger'  value='Batal' onclick='window.history.go(-1)'>
									</div>
						</div>
	      </form>";
     break;
 
  case "editpayroll":
    $edit = mysql_query("SELECT a.*,b.gaji_pokok, c.nama_jabatan,d.nama_departemen,e.area_name FROM payroll a,golongan b,jabatan c, departemen d, area e 
	                    where a.golongan_id=b.golongan_id  and a.id_jabatan=c.id_jabatan and a.id_departemen=d.id_departemen 
						and a.area_id=e.area_id   and a.nip='$_GET[id]'");
    $r    = mysql_fetch_array($edit);

    echo "<form class='form-horizontal' method='post' action='$aksi?r=payroll&act=update' enctype='multipart/form-data'>
	          <fieldset><legend>Edit Pegawai</legend>
			        <div class='span5'>
					  <div class='control-group'>
							<label class='control-label' for='nip'>NIP</label>
							<div class='controls'>
								<input type='text' id='nip' name='nip' class='input-small' value='$r[nip]' >
							</div>
					  </div>
					  <div class='control-group'>
							<label class='control-label' for='nama_karyawan'>Nama Karyawan</label>
							<div class='controls'>
								<input type='text' id='nama_karyawan' name='nama_karyawan' value='$r[nama_karyawan]'>
							</div>
					  </div>
					  <div class='control-group'>
							<label class='control-label' for='tempat_lahir'>Tempat Lahir</label>
							<div class='controls'>
								<input type='text' id='tempat_lahir' name='tempat_lahir' value='$r[tempat_lahir]'>
							</div>
					  </div>
					  <div class='control-group'>
							<label class='control-label' for='tgl_lahir'>Tgl Lahir</label>
							<div class='controls'>
								<input  type='text' id='tgl_lahir' name='tgl_lahir' class='easyui-datebox input-small' value='$r[tgl_lahir]' >
							</div>
					  </div>	
                      <div class='control-group'>
							<label class='control-label' for='npwp'>No. NPWP</label>
							<div class='controls'>
								<input type='text' id='npwp' name='npwp' value='$r[npwp]'>
							</div>
					  </div>	
                      <div class='control-group'>
							<label class='control-label' for='tgl_daftarnpwp'>Tgl.Daftar NPWP</label>
							<div class='controls'>
								<input  type='text' id='tgl_daftarnpwp' name='tgl_daftarnpwp' class='easyui-datebox input-small'  value='$r[tgl_daftarnpwp]'>
							</div>
					  </div>	
					  <div class='control-group'>
							<label class='control-label' for='alamat'>Alamat</label>
							<div class='controls'>
								<textarea id='alamat' name='alamat' >$r[alamat]</textarea>
							</div>
					  </div>	
                      <div class='control-group'>
							<label class='control-label' for='no_telp'>No. Telp</label>
							<div class='controls'>
								<input type='text' id='no_telp' name='no_telp' value='$r[no_telp]' >
							</div>
					  </div>
                      <div class='control-group'>
							<label class='control-label' for='no_ktp'>No. KTP</label>
							<div class='controls'>
								<input type='text' id='no_ktp' name='no_ktp' value='$r[no_ktp]'>
							</div>
					  </div>
					  <div class='control-group'>
							<label class='control-label' for='pendidikan_akhir'>Pendidikan Akhir</label>
							<div class='controls'>
								<select id='pendidikan_akhir' name='pendidikan_akhir' class='input-medium'>
								    <option value='$r[pendidikan_akhir]'>$r[pendidikan_akhir]</option>
									<option value='SD'>SD</option>
									<option value='SLTP'>SLTP</option>
									<option value='SLTA'>SLTA</option>
									<option value='Diploma 1'>Diploma 1</option>
									<option value='Diploma 3'>Diploma 3</option>
									<option value='Strata 1'>Strata 1</option>
									<option value='Pasca Sarjana'>Pasca Sarjana</option>
									<option value='Doktor'>Doktor</option>
								</select>
							</div>
					  </div>						  
					  <div class='control-group'>
							<label class='control-label' for='agama'>Agama</label>
							<div class='controls'>
								<select id='agama' name='agama' class='input-medium'>
									<option value='$r[agama]'>$r[agama]</option>
									<option value='Islam'>Islam</option>
									<option value='Protestan'>Protestan</option>
									<option value='Katholik'>Katholik</option>
									<option value='Hindu'>Hindu</option>
									<option value='Budha'>Budha</option>
									<option value='Lainnya'>Lainnya</option>
								</select>
							</div>
					  </div>
					  <div class='control-group'>
							<label class='control-label' for='tgl_masuk_kerja'>Tgl Masuk Kerja</label>
							<div class='controls'>
								<input  type='text' id='tgl_masuk_kerja' name='tgl_masuk_kerja' class='easyui-datebox input-small' value='$r[tgl_masuk_kerja]' >
							</div>
					  </div>
					  <div class='control-group'>
							<label class='control-label' for='tgl_berhenti'>Tgl Berhenti</label>
							<div class='controls'>
								<input  type='text' id='tgl_berhenti' name='tgl_berhenti' class='easyui-datebox input-small'  value='$r[tgl_berhenti]'>
							</div>
					  </div>
				</div>
				<div class='span7'>
				      <div class='control-group'>
							<label class='control-label' for='area_id'>Area</label>
							<div class='controls'>
								<select id='area_id' name='area_id' class='input-medium'>
									<option value='$r[area_id]'>$r[area_name]</option>";
									$area = mysql_query("select * from area");
									while($rarea = mysql_fetch_array($area)){
										echo "<option value='$rarea[area_id]'>$rarea[area_name]</option>";
									}
			echo "				</select>
							</div>
					  </div>
					  <div class='control-group'>
							<label class='control-label' for='id_departemen'>Departemen</label>
							<div class='controls'>
								<select id='id_departemen' name='id_departemen' class='input-large'>
									<option value='$r[id_departemen]'>$r[nama_departemen]</option>";
									$departemen = mysql_query("select * from departemen");
									while($rdepartemen = mysql_fetch_array($departemen)){
										echo "<option value='$rdepartemen[id_departemen]'>$rdepartemen[nama_departemen]</option>";
									}
			echo "				</select>
							</div>
					  </div>
					  <div class='control-group'>
								<label class='control-label' for='jenis_kelamin'>Jenis Kelamin</label>
								<div class='controls'>";
								if($r[jenis_kelamin]=='Pria'){
									echo "  <label class='radio inline'>
												<input type='radio' name='jenis_kelamin' value='Pria' checked >Pria
											</label>
											<label class='radio inline'>
												<input type='radio' name='jenis_kelamin'  value='Wanita'>Wanita
											</label>";
								}else{
									echo " <label class='radio inline'>
												<input type='radio' name='jenis_kelamin' value='Pria' >Pria
											</label>
											<label class='radio inline'>
												<input type='radio' name='jenis_kelamin'  value='Wanita' checked>Wanita
											</label>";
								}									
			echo "				</div>
					  </div>
					  <div class='control-group'>
								<label class='control-label' for='jenis_pegawai'>Status Pegawai</label>
								<div class='controls'>";
								if($r[jenis_pegawai]=='aktif'){
									echo "  <label class='radio inline'>
												<input type='radio' name='jenis_pegawai' value='aktif' checked >Aktif
											</label>
											<label class='radio inline'>
												<input type='radio' name='jenis_pegawai'  value='tidak aktif'>Tidak aktif
											</label>";
								}else{
									echo " <label class='radio inline'>
												<input type='radio' name='jenis_pegawai' value='aktif'>Aktif
											</label>
											<label class='radio inline'>
												<input type='radio' name='jenis_pegawai'  value='tidak aktif' checked >Tidak aktif
											</label>";
								}
			echo "				</div>
			     	  </div>
					  <div class='control-group'>
								<label class='control-label' for='status_kawin'>Status Pernikahan</label>
								<div class='controls'>";
								if($r[status_kawin]=='Lajang'){
									echo "  <label class='radio inline'>
											<input type='radio' name='status_kawin' value='Lajang' checked >Lajang
											</label>
											<label class='radio inline'>
													<input type='radio' name='status_kawin'  value='Menikah'>Menikah
											</label>
											<label class='radio inline'>
													<input type='radio' name='status_kawin'  value='Janda/Duda'>Janda/Duda
											</label>";
								}else if($r[status_kawin]=='Menikah'){
									echo "  <label class='radio inline'>
											<input type='radio' name='status_kawin' value='Lajang'>Lajang
											</label>
											<label class='radio inline'>
													<input type='radio' name='status_kawin'  value='Menikah' checked >Menikah
											</label>
											<label class='radio inline'>
													<input type='radio' name='status_kawin'  value='Janda/Duda'>Janda/Duda
											</label>";
								}else{
									echo "  <label class='radio inline'>
											<input type='radio' name='status_kawin' value='Lajang'>Lajang
											</label>
											<label class='radio inline'>
													<input type='radio' name='status_kawin'  value='Menikah'>Menikah
											</label>
											<label class='radio inline'>
													<input type='radio' name='status_kawin'  value='Janda/Duda' checked >Janda/Duda
											</label>";
								}
			echo "				</div>
					  </div>
					  <div class='control-group'>
							<label class='control-label' for='no_jamsostek'>No. Jamsostek</label>
							<div class='controls'>
								<input type='text' id='no_jamsostek' name='no_jamsostek' value='$r[no_jamsostek]' >
							</div>
					  </div>
					  <div class='control-group'>
							<label class='control-label' for='no_asuransi'>No. Asuransi</label>
							<div class='controls'>
								<input type='text' id='no_asuransi' name='no_asuransi' value='$r[no_asuransi]'>
							</div>
					  </div>
					  <div class='control-group'>
							<label class='control-label' for='id_jabatan'>Jabatan</label>
							<div class='controls'>
								<select id='id_jabatan' name='id_jabatan' class='input-medium'>
									<option value='$r[id_jabatan]'>$r[nama_jabatan]</option>";
									$jabatan = mysql_query("select * from jabatan");
									while($rjabatan = mysql_fetch_array($jabatan)){
										echo "<option value='$rjabatan[id_jabatan]'>$rjabatan[nama_jabatan]</option>";
									}
			echo "				</select>
							</div>
					  </div>
					  <div class='control-group'>
							<label class='control-label' for='golongan_id'>Golongan</label>
							<div class='controls'>
								<select id='golongan_id' name='golongan_id' class='input-medium'>
									<option value='$r[golongan_id]'>$r[golongan_id] => ".number_format($r[gaji_pokok],2,',','.')."</option>";
									$golongan = mysql_query("select * from golongan");
									while($rgolongan = mysql_fetch_array($golongan)){
										echo "<option value='$rgolongan[golongan_id]'>$rgolongan[golongan_id] => ".number_format($rgolongan[gaji_pokok],2,',','.')."</option>";
									}
			echo "				</select>
							</div>
					  </div>
					  <div class='control-group'>
							<label class='control-label' for='no_rek_bank'>No. Rekening Bank</label>
							<div class='controls'>
								<input  type='text' id='no_rek_bank' name='no_rek_bank' value='$r[no_rek_bank]' >
							</div>
					  </div>
					  <div class='control-group'>
							<label class='control-label' for='nama_bank'>Nama Bank</label>
							<div class='controls'>
								<input  type='text' id='nama_bank' name='nama_bank'  class='input-xlarge' value='$r[nama_bank]'>
							</div>
					  </div>
					  <div class='control-group ui-widget'>
							<label class='control-label' for='jumlah_anak'>Jumlah Anak</label>
							<div class='controls'>
								<select id='jumlah_anak' name='jumlah_anak' class='input-mini'>
								   <option value='$r[jumlah_anak]'>$r[jumlah_anak]</option>";
									for($i=0;$i<=12;$i++){
										echo "<option value='$i'>$i</option>";
									}
			echo "				</select>
							</div>
					  </div>
					  <div class='control-group'>
							<label class='control-label' for='foto'>Foto</label>
							<div class='controls'>
								<input  type='file' id='foto' name='foto'  >
							</div>
					  </div>
					  <div class='control-group'>
							<div class='controls'>
								<input type='submit' id='simpan' class='btn btn-primary' value='Simpan'>
								<input type ='button' id='batal' class='btn btn-danger'  value='Batal' onclick='window.history.go(-1)'>
							</div>
					  </div>
				</div>
	      </form>";
    break;  
}
?>
