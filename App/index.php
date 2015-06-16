<?php
/*
created by toeko triyanto
index.php for security application 
*/
session_start();
require_once("../configuration/connection_inc.php");
require_once("../function/security.php");
require_once("../function/menu.php");
require_once("../function/get_sql.php");

//bagian pengecekan 
$auth = mysql_query("select * from users where username='$_SESSION[username]' and password='$_SESSION[password]' and blokir=$_SESSION[blokir]");
$cauth = mysql_num_rows($auth);	

if($cauth == 0){
	$ip = ip();
    $host = host($ip);
    echo "<p align='center'><br><bR><b>Percobaan Ilegal ke system</b><br><br>IP Anda : $ip<br>Nama Komputer : $host<br><br>
         <a href='../index.php'>Klik disini untuk Login</a></p>";
}else{
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Payroll</title>
		<link href='../bootstrap/css/bootstrap.min.css' rel='stylesheet'>
		<link rel="stylesheet" type="text/css" href="../jeasyui/themes/default/easyui.css">
	    <link rel="stylesheet" type="text/css" href="../jeasyui/themes/icon.css">
	    <link rel="stylesheet" type="text/css" href="=../jeasyui/demo/demo.css">
		<link rel="stylesheet" type="text/css" href="../media/css/jquery.dataTables.css">
		<script type="text/javascript" src="../jquery-1.10.2.js"></script>
	    <script type="text/javascript" src="../jeasyui/jquery.easyui.min.js"></script>
		<script type="text/javascript" src="../media/js/jquery.dataTables.js"></script>
		<script type="text/javascript">
			$(window).load(function() { $("#loading").fadeOut("slow"); })
		</script>
		<style>
			.container{ font-size:12px;}
			#loading {
				position: fixed;
				left: 0px;
				top: 0px;
				width: 100%;
				height: 100%;
				z-index: 9999;
				background: url(../images/loading.gif) 50% 50% no-repeat #ede9df;
			}
		</style>
</head>
<body style='font-size:8px'>
		<div id="loading"></div>
        <div class="container">
				<p class="text-right"><br><img src='../images/logo_company.jpg' width=150></p>
                <div id='menu'><?php menu();?></div><br>
		</div>
		<div class="container">
				<?php include "content.php"; ?> 
		</div><br><BR>
		<div class="container" id='footer'>
				<pre style='text-align:center'>Copyright <?php echo date('Y');?> PT Morinaga Kino Indonesia</pre>
		</div>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src='../bootstrap/js/bootstrap.min.js'></script>
</body>
</html>
<?php } ?>
