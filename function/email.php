<?
function find_email(){
	$sql = mysql_query("select * from sec_users where user_id in
	                  (select distinct user_id from sec_user_rules WHERE module_id=15 and c=1 and r=1 and d=1 and u=1)
					  or grade_id='*'");
	while($r = mysql_fetch_array($sql)){
	    $email = $email.$char.$r[email];
		if($r[email]<>""){ $char = ","; }else{ $char = "";}
	}
	return $email;
}


function sendmail($subject,$body,$headers){
	$from = 'toeko.triyanto@morinaga-kino.co.id';
	$sql = find_email();
	$to = array();
	while($r = mysql_fetch_array($sql)){
		push_array($to,$r[email]);
	}
	$headers = "From: ".$from."\r\n";
	$headers .= "Reply-to: ".$to."\r\n";
	$headers .= "MIME-Version: 1.0\r\n";
	$headers .= "Content-Type: text/html; charset=UTF-8\r\n";
    //kirim email 
	$mail_sent = @mail($from, $subject, $body, $headers);
	echo $mail_sent ? "Terkirim" : "Gagal";
}
?>