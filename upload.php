<?php
include "configuration/connection_inc.php";
$sql = "select * from upload$";
$qsql = odbc_exec($conn2,$sql);
while($r = odbc_fetch_array($qsql)){
	echo "$r[account_id]<br>";
}

?>