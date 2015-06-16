<?php
if ($_GET[r]=='home'){
    include "modul/mod_home/home.php";
}elseif (($_GET[r])=='perusahaan'){
	include "modul/mod_perusahaan/perusahaan.php";
}elseif (($_GET[r])=='area'){
	include "modul/mod_area/area.php";
}elseif (($_GET[r])=='departemen'){
	include "modul/mod_departemen/departemen.php";
}elseif (($_GET[r])=='grade'){
	include "modul/mod_grade/grade.php";
}elseif (($_GET[r])=='golongan'){
	include "modul/mod_golongan/golongan.php";
}elseif (($_GET[r])=='jabatan'){
	include "modul/mod_jabatan/jabatan.php";
}elseif (($_GET[r])=='employee'){
	include "modul/mod_employee/employee.php";
}elseif (($_GET[r])=='user'){
	include "modul/mod_user/user.php";
}elseif (($_GET[r])=='periode'){
	include "modul/mod_periode/periode.php";
}elseif (($_GET[r])=='payroll'){
	include "modul/mod_payroll/payroll.php";
}elseif (($_GET[r])=='exporttxt'){
	include "modul/mod_exporttxt/exporttxt.php";
}elseif (($_GET[r])=='report'){
	include "modul/mod_report/report.php";
}elseif (($_GET[r])=='rekapgaji'){
	include "modul/mod_rekapgaji/rekapgaji.php";
}elseif (($_GET[r])=='laparea'){
	include "modul/mod_laparea/laparea.php";
}elseif (($_GET[r])=='lapdepartemen'){
	include "modul/mod_lapdepartemen/lapdepartemen.php";
}elseif (($_GET[r])=='lapgolongan'){
	include "modul/mod_lapgolongan/lapgolongan.php";
}elseif (($_GET[r])=='lapjabatan'){
	include "modul/mod_lapjabatan/lapjabatan.php";
}elseif (($_GET[r])=='lappegawai'){
	include "modul/mod_lappegawai/lappegawai.php";
}elseif (($_GET[r])=='lapkepegawaian'){
	include "modul/mod_lapkepegawaian/lapkepegawaian.php";
}else{
    
}
?>











