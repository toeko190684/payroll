<?php
$aksi="modul/mod_employee/aksi_employee.php";
switch($_GET[act]){
  // Tampil employee
  default:
	    $per_page = 10;
		if($_POST[key]==''){
			$page_query = mysql_query("SELECT count(*) FROM employee ORDER BY nip");
		}else{
			$page_query = mysql_query("SELECT count(*) FROM employee where nama_karyawan like '%$_POST[key]%'");
		}
		$pages = ceil(mysql_result($page_query,0)/$per_page);
		$page = (isset($_GET[page]))? (int)$_GET[page]:1;
		$start = ($page-1)*$per_page;
		echo "<blockquote>Master Pegawai</blockquote>
	          <input type=button class='btn btn-primary' value='Tambah' 
			  onclick=\"window.location.href='index.php?r=employee&act=tambahemployee';\">
			  <form class='form-search' method=post action='?r=employee'>	
					<div class='input-append'>
					    <div class='span8'></div>
						<input class='span3 search-query' id='key' name='key' type='text' placeholder='Masukan Nama Karyawan..!'>
					    <button class='btn' type='submit'>Cari</button>
					</div><br>
			  </form>
	          <table class='table table-condensed table-hover table-bordered' >
	          <tdead>
				<tr class='success'>
					<td>No</td><td>NIK</td><td>Nama karyawan</td><td>Telp</td><td>Alamat</td><td>Aksi</td>
				</tr>
			  </tdead>";
	    
		if($_POST[key]==''){
			$tampil=mysql_query("select * from employee ORDER BY nip limit $start,$per_page");
		}else{
			$tampil=mysql_query("select * from employee where nama_karyawan like '%$_POST[key]%' ORDER BY nip limit $start,$per_page");
		}
	    $no = 1;
		$no = $no+$start;
		while ($r=mysql_fetch_array($tampil)){
	      echo "<tbody><tr>
		            <td>$no</tD>
		            <td>$r[nip]</td>
					<td>$r[nama_karyawan]</td>
					<td>$r[no_telp]</td>
					<td>$r[alamat]</td>
		            <td><a href='index.php?r=employee&act=editemployee&id=$r[nip]'>Edit</a> | 
			            <a href='$aksi?r=employee&act=hapus&id=$r[nip]'>Hapus</a>
		            </td>
				</tr></tbody>";
				$no++;
	    }
	    echo "</table>";
		//memulai paginasi
		echo "<div class='pagination pagination-small pagination-right'><ul><li><a href='?r=employee&page=1'>First</a></li>";
		if($pages >= 1 && $page <= $pages){
		    for($x=1; $x<=$pages; $x++){
		        echo ($x == $page) ? '<li><a href="?r=employee&page='.$x.'">'.$x.'</a></li> ' : '<li><a href="?r=employee&page='.$x.'">'.$x.'</a></li>';
		    }
		}
		$x--;
		echo "<li><a href='?r=employee&page=$x'>Last</a></li></ul></div>";
    break;

  case "tambahemployee":
		echo "<form class='form-horizontal' method='post' action='$aksi?r=employee&act=input' enctype='multipart/form-data'>
	          <fieldset><legend>Tambah Pegawai</legend>
			        <div class='span5'>
					  <div class='control-group'>
							<label class='control-label' for='nip'>NIP</label>
							<div class='controls'>
								<input type='text' id='nip' name='nip' class='input-small' >
							</div>
					  </div>
					  <div class='control-group'>
							<label class='control-label' for='nama_karyawan'>Nama Karyawan</label>
							<div class='controls'>
								<input type='text' id='nama_karyawan' name='nama_karyawan' >
							</div>
					  </div>
					  <div class='control-group'>
							<label class='control-label' for='tempat_lahir'>Tempat Lahir</label>
							<div class='controls'>
								<input type='text' id='tempat_lahir' name='tempat_lahir' >
							</div>
					  </div>
					  <div class='control-group'>
							<label class='control-label' for='tgl_lahir'>Tgl Lahir</label>
							<div class='controls'>
								<input  type='text' id='tgl_lahir' name='tgl_lahir' class='easyui-datebox input-small'  >
							</div>
					  </div>	
                      <div class='control-group'>
							<label class='control-label' for='npwp'>No. NPWP</label>
							<div class='controls'>
								<input type='text' id='npwp' name='npwp' >
							</div>
					  </div>	
                      <div class='control-group'>
							<label class='control-label' for='tgl_daftarnpwp'>Tgl.Daftar NPWP</label>
							<div class='controls'>
								<input  type='text' id='tgl_daftarnpwp' name='tgl_daftarnpwp' class='easyui-datebox input-small'  >
							</div>
					  </div>	
					  <div class='control-group'>
							<label class='control-label' for='alamat'>Alamat</label>
							<div class='controls'>
								<textarea id='alamat' name='alamat' ></textarea>
							</div>
					  </div>	
                      <div class='control-group'>
							<label class='control-label' for='no_telp'>No. Telp</label>
							<div class='controls'>
								<input type='text' id='no_telp' name='no_telp' >
							</div>
					  </div>
                      <div class='control-group'>
							<label class='control-label' for='no_ktp'>No. KTP</label>
							<div class='controls'>
								<input type='text' id='no_ktp' name='no_ktp' >
							</div>
					  </div>
					  <div class='control-group'>
							<label class='control-label' for='pendidikan_akhir'>Pendidikan Akhir</label>
							<div class='controls'>
								<select id='pendidikan_akhir' name='pendidikan_akhir' class='input-medium'>
								    <option value=''>--Pendidikan--</option>
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
									<option value=''>--Pilih Agama--</option>
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
								<input  type='text' id='tgl_masuk_kerja' name='tgl_masuk_kerja' class='easyui-datebox input-small'  >
							</div>
					  </div>
					  <div class='control-group'>
							<label class='control-label' for='tgl_berhenti'>Tgl Berhenti</label>
							<div class='controls'>
								<input  type='text' id='tgl_berhenti' name='tgl_berhenti' class='easyui-datebox input-small'  >
							</div>
					  </div>
				</div>
				<div class='span7'>
				      <div class='control-group'>
							<label class='control-label' for='area_id'>Area</label>
							<div class='controls'>
								<select id='area_id' name='area_id' class='input-medium'>
									<option value=''>--Area--</option>";
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
									<option value=''>--Departemen--</option>";
									$departemen = mysql_query("select * from departemen");
									while($rdepartemen = mysql_fetch_array($departemen)){
										echo "<option value='$rdepartemen[id_departemen]'>$rdepartemen[nama_departemen]</option>";
									}
			echo "				</select>
							</div>
					  </div>
					  <div class='control-group'>
								<label class='control-label' for='jenis_kelamin'>Jenis Kelamin</label>
								<div class='controls'>
								    <label class='radio inline'>
											<input type='radio' name='jenis_kelamin' value='Pria' checked >Pria
									</label>
									<label class='radio inline'>
											<input type='radio' name='jenis_kelamin'  value='Wanita'>Wanita
									</label>
								</div>
					  </div>
					  <div class='control-group'>
								<label class='control-label' for='jenis_pegawai'>Status Pegawai</label>
								<div class='controls'>
								    <label class='radio inline'>
											<input type='radio' name='jenis_pegawai' value='aktif' checked >aktif
									</label>
									<label class='radio inline'>
											<input type='radio' name='jenis_pegawai'  value='tidak aktif'>tidak aktif
									</label>
								</div>
					  </div>
					  <div class='control-group'>
								<label class='control-label' for='status_kawin'>Status Pernikahan</label>
								<div class='controls'>
								    <label class='radio inline'>
											<input type='radio' name='status_kawin' value='Lajang' checked >Lajang
									</label>
									<label class='radio inline'>
											<input type='radio' name='status_kawin'  value='Menikah'>Menikah
									</label>
									<label class='radio inline'>
											<input type='radio' name='status_kawin'  value='Janda/Duda'>Janda/Duda
									</label>
								</div>
					  </div>
					  <div class='control-group'>
							<label class='control-label' for='no_jamsostek'>No. Jamsostek</label>
							<div class='controls'>
								<input type='text' id='no_jamsostek' name='no_jamsostek' >
							</div>
					  </div>
					  <div class='control-group'>
							<label class='control-label' for='no_asuransi'>No. Asuransi</label>
							<div class='controls'>
								<input type='text' id='no_asuransi' name='no_asuransi' >
							</div>
					  </div>
					  <div class='control-group'>
							<label class='control-label' for='id_jabatan'>Jabatan</label>
							<div class='controls'>
								<select id='id_jabatan' name='id_jabatan' class='input-medium'>
									<option value=''>--Jabatan--</option>";
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
									<option value=''>--Golongan--</option>";
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
								<input  type='text' id='no_rek_bank' name='no_rek_bank'  >
							</div>
					  </div>
					  <div class='control-group'>
							<label class='control-label' for='nama_bank'>Nama Bank</label>
							<div class='controls'>
								<input  type='text' id='nama_bank' name='nama_bank'  class='input-xlarge'>
							</div>
					  </div>
					  <div class='control-group ui-widget'>
							<label class='control-label' for='jumlah_anak'>Jumlah Anak</label>
							<div class='controls'>
								<select id='jumlah_anak' name='jumlah_anak' class='input-mini'>";
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
 
  case "editemployee":
    $edit = mysql_query("SELECT a.*,b.gaji_pokok, c.nama_jabatan,d.nama_departemen,e.area_name FROM employee a,golongan b,jabatan c, departemen d, area e 
	                    where a.golongan_id=b.golongan_id  and a.id_jabatan=c.id_jabatan and a.id_departemen=d.id_departemen 
						and a.area_id=e.area_id   and a.nip='$_GET[id]'");
    $r    = mysql_fetch_array($edit);

    echo "<form class='form-horizontal' method='post' action='$aksi?r=employee&act=update' enctype='multipart/form-data'>
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
