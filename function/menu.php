<?php
/*
 created by toeko triyanto
 this file is find menu for all user acces
*/
function menu(){
		if($_SESSION[level]=="admin"){
				echo "<div class='navbar navbar-inverse '>
				      <div class='navbar-inner'>
				        <div class='container'>
				          <button type='button' class='btn btn-navbar' data-toggle='collapse' data-target='.nav-collapse'>
				            <span class='icon-bar'></span>
				            <span class='icon-bar'></span>
				            <span class='icon-bar'></span>
				          </button>
				          <a class='brand' href='#'>Payroll</a>
				          <div class='nav-collapse collapse'>
						    <p class='navbar-text pull-right'><a href=\"logout.php\">Logout ( <em>$_SESSION[username]</em>  )</a></p>
				            <ul class='nav'>
							  <li class='active'><a href='?r=home'>Home</a></li>
							  <li class='dropdown'><a href='#' class='dropdown-toggle' data-toggle='dropdown'>Master<b class='caret'></b></a>
									<ul class='dropdown-menu'>
										<li><a href='?r=perusahaan'>Perusahaan</a></li>
										<li><a href='?r=area'>Area</a></li>
										<li><a href='?r=departemen'>Departemen</a></li>
										<li><a href='?r=golongan'>Golongan</a></li>
										<li><a href='?r=jabatan'>Jabatan</a></li>
										<li><a href='?r=employee'>Pegawai</a></li>
										<li><a href='?r=user'>Users</a></li>
									</ul>
							  </li>							  
							  <li class='dropdown'><a href='#' class='dropdown-toggle' data-toggle='dropdown'>Payroll<b class='caret'></b></a>
									<ul class='dropdown-menu'>
									    <li><a href='?r=periode'>Input Periode</a></li>
										<li><a href='?r=payroll'>Input Payroll</a></li>
										<li><a href='?r=exporttxt'>Export TXT</a></li>
									</ul>
							  </li>	
							  <li class='dropdown'><a href='#' class='dropdown-toggle' data-toggle='dropdown'>Laporan<b class='caret'></b></a>
									<ul class='dropdown-menu'>
									    <li><a href='?r=rekapgaji'>Rekap Gaji</a></li>
										<li><a href='?r=laparea'>Lap. Area</a></li>
										<li><a href='?r=lapdepartemen'>Lap. Departemen</a></li>
										<li><a href='?r=lapgolongan'>Lap. Golongan</a></li>
										<li><a href='?r=lapjabatan'>Lap. Jabatan</a></li>
										<li><a href='?r=lappegawai'>Lap. Pegawai</a></li>
									</ul>
							  </li>							  
			                </ul>
				          </div><!--/.nav-collapse -->
				        </div>
				      </div>
				    </div>";
		}else if($_SESSION[level]=="user"){
				echo "<div class='navbar navbar-inverse '>
				      <div class='navbar-inner'>
				        <div class='container'>
				          <button type='button' class='btn btn-navbar' data-toggle='collapse' data-target='.nav-collapse'>
				            <span class='icon-bar'></span>
				            <span class='icon-bar'></span>
				            <span class='icon-bar'></span>
				          </button>
				          <a class='brand' href='#'>Payroll</a>
				          <div class='nav-collapse collapse'>
						    <p class='navbar-text pull-right'><a href=\"logout.php\">Logout ( <em>$_SESSION[username]</em>  )</a></p>
				            <ul class='nav'>
							  <li class='active'><a href='?r=home'>Home</a></li>
							 <li class='dropdown'><a href='#' class='dropdown-toggle' data-toggle='dropdown'>Laporan<b class='caret'></b></a>
									<ul class='dropdown-menu'>
										<li><a href='?r=laparea'>Lap. Area</a></li>
										<li><a href='?r=lapdepartemen'>Lap. Departemen</a></li>
										<li><a href='?r=lapgolongan'>Lap. Golongan</a></li>
										<li><a href='?r=lapjabatan'>Lap. Jabatan</a></li>
										<li><a href='?r=lapkepegawaian'>Lap. Kepegawaian </a></li>
									</ul>
							  </li>	
			                </ul>
				          </div><!--/.nav-collapse -->
				        </div>
				      </div>
				    </div>";
		}else{
		
		}
}
?>

