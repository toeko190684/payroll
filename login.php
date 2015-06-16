 <?php
/*
 created by toeko triyanto
 this file is used to login user
*/

?>

<!doctype html>
<html lang="en">
<head>
	<title>Login - Payroll - PT Morinaga Kino Indonesia</title>
	<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
	<script language="javascript" type="script/javascript" src="bootstrap/js/bootstrap.min.js" ></script>
</head>
<body>
    <div class="container">
		<div class="page-header" align="center"><img src='images/logo_company.jpg' width='300px'></div>
		    <div class='span6'>
				<form class="form-horizontal" method="post" action="cek_login.php">
					<fieldset><legend>Payroll - Login</legend>
						<div class="control-group">
							<label class="control-label" for="username">Username</label>
							<div class="controls">
								<input type="text" id="username" name="username" placeholder="Type your username..!" required>
								<input type='hidden' id='pro_id' name='pro_id' value=<?php echo $_GET[r]; ?>>
								<input type='hidden' id='pro_name' name='pro_name' value=<?php echo $_GET[n]; ?>>
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="password">Password</label>
							<div class="controls">
								<input type="password" id="password" name="password" placeholder="Type your password" required>
							</div>
						</div>
						<div class="control-group">
							<div class="controls">
									<input type="submit" class="btn btn-primary" value="Login">&nbsp
									<input type="reset" class="btn btn-danger" onClick="window.location = 'index.php'" value="Cancel">
							</div>
						</div>
					</fieldset>
				</form>
			</div>
			<div class='span3'></div>
			<div class='span4'>
			    <h4>Visi & Misi</h4>
				<blockquote><em>"Menciptakan produk makanan & minuman yang enak, menyenangkan dan sehat..!"</em></blockquote>	
				<br><h4>Support</h4>
				<blockquote><em>"Jika ada problem IT silahkan kontak ke IT support"</em></blockquote>
			</div>
	</div>
	<div class="container" align="center"><pre>Copyright 2013</pre></div>		
</body>
</html>
