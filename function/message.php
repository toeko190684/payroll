<?php
/*
 created by toeko triyanto
 this file is find menu for all user acces
*/
function message(){
		if($_SESSION[grade_id]=="*"){
		    $menu = mysql_query("select * from sec_app_module where app_id in(select app_id from sec_app where app_name='$_SESSION[app]') 
			                     order by module_name");
		}else{
		    $menu = mysql_query("select * from v_sec_user_rules where app_name='$_SESSION[app]' and user_id='$_SESSION[user_id]' and r=1 
			                    order by module_name");

		}
		$cek = mysql_num_rows($menu);
		if($cek>0){
			echo "<ul class='nav-inline'>
					    <li><a href='index.php?r=home'>Home</a></li>";
						while($r = mysql_fetch_array($menu)){
							echo "<li><a href='index.php$r[link]&mod=$r[module_id]'>$r[module_name]</a></li>";
						}
			echo "	    <li><a href='logout.php'>Logout ( <em>$_SESSION[user_id]</em>  )</a></li>
				    </ul>";    
		}else{
			echo "<ul class=nav-inline>
					    <li><a href='index.php?r=home'>Home</a></li>
						<li><a href='logout.php'>Logout ( <em>$_SESSION[user_id]</em>  )</a></li>
				    </ul>";    
		}
}
?>
