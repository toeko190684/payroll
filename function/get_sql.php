<?php
function target($tgl,$category){
	include "../configuration/connection_inc.php";
	$bln = date('m',strtotime($tgl));
	$thn = date('Y',strtotime($tgl));
	$x = mysql_query("SELECT a.value FROM sales_order_target a,master_divisi b WHERE
					 a.divisi_id=b.divisi_id and  a.bulan=$bln and a.tahun=$thn and b.divisi_name='$category'");
	$rx = mysql_fetch_array($x);
	return $rx[value];
}

function lastyear($tgl,$category){
	include "../configuration/connection_inc.php";
	$bln = date('m',strtotime($tgl));
	$thn = date('Y',strtotime($tgl))-1;
	$x = mysql_query("SELECT a.value FROM sales_order_target a,master_divisi b WHERE
					 a.divisi_id=b.divisi_id and  a.bulan=$bln and a.tahun=$thn and b.divisi_name='$category'");
	$rx = mysql_fetch_array($x);
	return $rx[value];
}

function so_divisi($tgl_awal,$tgl_akhir,$category){
    include "../configuration/connection_inc.php";
	$x = "select sum(a.subtotal*(100-b.regular_discount)/100)as total
		from sales_order_item  a,sales_order b where
		a.quotation_id=b.quotation_id  and
		CONVERT(VARCHAR(10), quotation_date, 120) between '$tgl_awal' and '$tgl_akhir' 
		and a.product_id in(select product_id from product where category='$category')";
	$qx = odbc_exec($conn2,$x);
	$rx = odbc_fetch_array($qx);
	return $rx[total];
}

function do_divisi($tgl_awal,$tgl_akhir,$category){
    include "../configuration/connection_inc.php";
	$x = "select sum(a.quantity*b.sale_price*(100-c.regular_discount)/100) as total from kinosentrajit.dbo.do_item a,
		 sales_order_item b,sales_order c
		 where b.quotation_id=c.quotation_id and a.quotation_id=b.quotation_id and a.product_id=b.product_id and 
		 CONVERT(VARCHAR(10), c.quotation_date, 120) between '$tgl_awal' and '$tgl_akhir' and a.product_id in
		(select product_id from product where category='$category')and a.quantity>0";
	$qx = odbc_exec($conn2,$x);
	$rx = odbc_fetch_array($qx);
	return $rx[total];
}


function netsales_divisi($tgl_awal,$tgl_akhir,$category){
    include "../configuration/connection_inc.php";
	$x = "select sum(d.quantity*a.sale_price *(100-b.regular_discount)/100)as total
		from sales_order_item  a,sales_order b, product c, kinosentrajit.dbo.do_item d where
		a.quotation_id=b.quotation_id and a.product_id=c.product_id and a.quotation_id=d.quotation_id and d.product_id=c.product_id and
		CONVERT(VARCHAR(10), b.quotation_date, 120) between '$tgl_awal' and '$tgl_akhir' and c.category='$category'";
	$qx = odbc_exec($conn2,$x);
	$rx = odbc_fetch_array($qx);
	return $rx[total];
}

function so_brand($tgl_awal,$tgl_akhir,$brand){
    include "../configuration/connection_inc.php";
	$x = "select sum(a.subtotal*(100-b.regular_discount)/100)as total
		from sales_order_item  a,sales_order b where
		a.quotation_id=b.quotation_id and 
		CONVERT(VARCHAR(10), quotation_date, 120) between '$tgl_awal' and '$tgl_akhir' and a.product_brand='$brand'";
	$qx = odbc_exec($conn2,$x);
	$rx = odbc_fetch_array($qx);
	return $rx[total];
}

function do_brand($tgl_awal,$tgl_akhir,$brand){
    include "../configuration/connection_inc.php";
	$x = "select sum(a.quantity*b.sale_price*(100-c.regular_discount)/100) as total from kinosentrajit.dbo.do_item a,
		 sales_order_item b,sales_order c
		 where b.quotation_id=c.quotation_id and a.quotation_id=b.quotation_id and a.product_id=b.product_id and 
		 CONVERT(VARCHAR(10), c.quotation_date, 120) between '$tgl_awal' and '$tgl_akhir' and a.product_id in
		(select product_id from product where brand='$brand')and a.quantity>0";
	$qx = odbc_exec($conn2,$x);
	$rx = odbc_fetch_array($qx);
	return $rx[total];
}

function netsales_brand($tgl_awal,$tgl_akhir,$brand){
    include "../configuration/connection_inc.php";
	$x = "select distinct c.brand,sum(d.quantity*a.sale_price *(100-b.regular_discount)/100)as total
		from sales_order_item  a,sales_order b, product c, kinosentrajit.dbo.do_item d where
		a.quotation_id=b.quotation_id and a.product_id=c.product_id and a.quotation_id=d.quotation_id and d.product_id=c.product_id and
		CONVERT(VARCHAR(10), b.quotation_date, 120) between '$tgl_awal' and '$tgl_akhir' and c.brand='$brand'
		group by c.brand";
	$qx = odbc_exec($conn2,$x);
	$rx = odbc_fetch_array($qx);
	return $rx[total];
}

function so_subbrand($tgl_awal,$tgl_akhir,$subbrand){
    include "../configuration/connection_inc.php";
	$x = "select sum(a.subtotal*(100-b.regular_discount)/100)as total
		from sales_order_item  a,sales_order b where
		a.quotation_id=b.quotation_id and
		CONVERT(VARCHAR(10), quotation_date, 120) between '$tgl_awal' and '$tgl_akhir' and a.subrand='$subbrand'";
	$qx = odbc_exec($conn2,$x);
	$rx = odbc_fetch_array($qx);
	return $rx[total];
}

function do_subbrand($tgl_awal,$tgl_akhir,$subbrand){
    include "../configuration/connection_inc.php";
	$x = "select sum(a.quantity*b.sale_price*(100-c.regular_discount)/100) as total from kinosentrajit.dbo.do_item a,
		 sales_order_item b,sales_order c
		 where b.quotation_id=c.quotation_id and a.quotation_id=b.quotation_id and a.product_id=b.product_id and 
		 CONVERT(VARCHAR(10), c.quotation_date, 120) between '$tgl_awal' and '$tgl_akhir' and a.product_id in
		(select product_id from product where subrand='$subbrand')and a.quantity>0";
	$qx = odbc_exec($conn2,$x);
	$rx = odbc_fetch_array($qx);
	return $rx[total];
}

function netsales_subbrand($tgl_awal,$tgl_akhir,$subbrand){
    include "../configuration/connection_inc.php";
	$x = "select distinct c.subrand,sum(d.quantity*a.sale_price *(100-b.regular_discount)/100)as total
		from sales_order_item  a,sales_order b, product c, kinosentrajit.dbo.do_item d where
		a.quotation_id=b.quotation_id and a.product_id=c.product_id and a.quotation_id=d.quotation_id and d.product_id=c.product_id and
		CONVERT(VARCHAR(10), b.quotation_date, 120) between '$tgl_awal' and '$tgl_akhir' and c.subrand='$subbrand'
		group by c.subrand";
	$qx = odbc_exec($conn2,$x);
	$rx = odbc_fetch_array($qx);
	return $rx[total];
}

function so_product($tgl_awal,$tgl_akhir,$product){
    include "../configuration/connection_inc.php";
	$x = "select sum(a.subtotal*(100-b.regular_discount)/100)as total
		from sales_order_item  a,sales_order b where
		a.quotation_id=b.quotation_id and 
		CONVERT(VARCHAR(10), quotation_date, 120) between '$tgl_awal' and '$tgl_akhir' and a.product_id='$product'";
	$qx = odbc_exec($conn2,$x);
	$rx = odbc_fetch_array($qx);
	return $rx[total];
}

function do_product($tgl_awal,$tgl_akhir,$product){
    include "../configuration/connection_inc.php";
	$x = "select sum(a.quantity*b.sale_price*(100-c.regular_discount)/100) as total from kinosentrajit.dbo.do_item a,
		 sales_order_item b,sales_order c
		 where b.quotation_id=c.quotation_id and a.quotation_id=b.quotation_id and a.product_id=b.product_id and 
		 CONVERT(VARCHAR(10), c.quotation_date, 120) between '$tgl_awal' and '$tgl_akhir' and a.product_id in
		(select product_id from product where product_id='$product')and a.quantity>0";
	$qx = odbc_exec($conn2,$x);
	$rx = odbc_fetch_array($qx);
	return $rx[total];
}

function netsales_product($tgl_awal,$tgl_akhir,$product){
    include "../configuration/connection_inc.php";
	$x = "select distinct c.product_id,sum(d.quantity*a.sale_price *(100-b.regular_discount)/100)as total
		from sales_order_item  a,sales_order b, product c, kinosentrajit.dbo.do_item d where
		a.quotation_id=b.quotation_id and a.product_id=c.product_id and a.quotation_id=d.quotation_id and d.product_id=c.product_id and
		CONVERT(VARCHAR(10), b.quotation_date, 120) between '$tgl_awal' and '$tgl_akhir' and c.product_id='$product'
		group by c.product_id";
	$qx = odbc_exec($conn2,$x);
	$rx = odbc_fetch_array($qx);
	return $rx[total];
}

function cari_atasan1($user){
    include "../configuration/connection_inc.php";
	$sql = mysql_query("select * from sec_users where user_id='$user'");
	$r = mysql_fetch_array($sql);
	return $r[atasan1];
}

function cari_email_atasan1($user){
    include "../configuration/connection_inc.php";
	$sql = mysql_query("select email from sec_users where user_id='$user'");
	$r = mysql_fetch_array($sql);
	return $r[email];
}

function cari_user_budget($kode_budget){
	$sql = mysql_query("select * from master_budget where kode_budget='$kode_budget'");
	$r = mysql_fetch_array($sql);
	return $r[user];
}

function cari_password($user){
	$sql = mysql_query("select * from sec_users where user_id='$user'");
	$r = mysql_fetch_array($sql);
	return $r[password];
}

function update_status_reco($id){
    include "../configuration/connection_inc.php";
    //cari kode reco dari tabel detail_reco_budget
	$sql = mysql_query("select distinct kode_reco from detail_reco_budget where id='$id'");
	$r = mysql_fetch_array($sql);
	
	//cari jumlah approval yang masih kosong
	$cek = mysql_query("select * from detail_reco_budget where cek<>2 and kode_reco='$r[kode_reco]'");
	$rcek = mysql_num_rows($cek);
	if($rcek==0){ 
		//jika sudah tidak ada yang di update maka di cek apakah ada status yang rejected
		$cek2 = mysql_query("select * from detail_reco_budget where status1='rejected' or status2='rejected' and kode_reco='$r[kode_reco]'");
		$rcek2 = mysql_num_rows($cek2);
		if($rcek2==0){
			$status = 'approved';
		}else{
			$status = 'rejected';
		}
		//lakukan status update di tabel reco_request
		$info = mysql_query("update reco_request set status='$status' where kode_promo='$r[kode_reco]'");
		return $info;
	}	
}

function ip(){
		$ip = $_SERVER[REMOTE_ADDR];
		return $ip;
}


function host($ip){
		$host = gethostbyaddr($ip);
		return $host;
}

?>