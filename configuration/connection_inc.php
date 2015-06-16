<?php
/*
 created by toeko triyanto 
 date : 21-10-2013
 this file is consist of configuration to connect with server database, which can be used and call other php file, so there is no rewrite script for
 connect to the database server

*/

$host = "localhost";
$username = "root";
$password = "m0r1n@g@";
$database = "payroll";

$conn = mysql_connect($host,$username,$password) or die("couldn't connect to mysql server");
mysql_select_db($database)or die("couldn't connect to database skproject");


?>