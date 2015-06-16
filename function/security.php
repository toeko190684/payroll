<?php
function open_security(){
	$auth = mysql_query("select * from v_sec_user_rules where user_id='$_SESSION[user_id]' and password='$_SESSION[password]' and app_name='$_SESSION[app]'");
	$cauth = mysql_num_rows($auth);	
	if($cauth == 0){
       $ip = $_SERVER[REMOTE_ADDR];
	   $host = gethostbyaddr($ip);
	   echo "<p align='center'><b>Percobaan Ilegal ke system</b><br><br>IP Anda : $ip<br>Nama Komputer : $host<br><br>
	        <a href='../../login.php?r=$_SESSION[app]'>Klik disini untuk Login</a></p>";
	}else{
}
}

function close_security(){

}

function create_security(){
    if($_SESSION[grade_id]=='*'){
	    $access = "allow";
	}else{
		$cek = mysql_query("select * from sec_user_rules where user_id='$_SESSION[user_id]' and module_id='$_SESSION[mod]' and c='1'");
		$rcek = mysql_num_rows($cek);
		if($rcek>0){ $access = "allow"; }else{ $access = "deny"; }
	}
	return $access;
}

function read_security(){
    if($_SESSION[grade_id]=='*'){
	    $access = "allow";
	}else{
		$cek = mysql_query("select * from sec_user_rules where user_id='$_SESSION[user_id]' and module_id='$_SESSION[mod]' and r='1'");
		$rcek = mysql_num_rows($cek);
		if($rcek>0){ $access = "allow"; }else{ $access = "deny"; }
	}
	return $access;
}

function update_security(){
    if($_SESSION[grade_id]=='*'){
	    $access = "allow";
	}else{
		$cek = mysql_query("select * from sec_user_rules where user_id='$_SESSION[user_id]' and module_id='$_SESSION[mod]' and u='1'");
		$rcek = mysql_num_rows($cek);
		if($rcek>0){ $access = "allow"; }else{ $access = "deny"; }
	}
	return $access;
}

function delete_security(){
    if($_SESSION[grade_id]=='*'){
	    $access = "allow";
	}else{
		$cek = mysql_query("select * from sec_user_rules where user_id='$_SESSION[user_id]' and module_id='$_SESSION[mod]' and d='1'");
		$rcek = mysql_num_rows($cek);
		if($rcek>0){ $access = "allow"; }else{ $access = "deny"; }
	}
	return $access;
}

function msg_security(){
	echo "Anda tidak berhak mengakses halaman ini !!";
}

function ses_module(){
    if($_SESSION[mod]==""){ $_SESSION[mod]=$_GET[mod]; } else { $_SESSION[mod]=$_SESSION[mod]; }
}





?>