<?php
	$url = "https://pgi.billdesk.com/pgidsk/PGIMerchantPayment";

	// get student fee data!
	// generate a unique payment txn id!! and store somewhere
	$randstr = substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(14/strlen($x)) )),1,14);
	$feeamt = "2.00";
	$stdphone = "8888833168";
	$stdemail = "mandaroak@gmail.com";
	//store the str in FEE DB for std
	//CCOEWTESTTX002
	$str = 'CUMMINSCOE|' . $randstr . '|NA|' . $feeamt . '|NA|NA|NA|INR|NA|R|cumminscoe|NA|NA|F|' . $stdphone. '|' . $stdemail . '|NA|NA|NA|NA|NA|http://210.212.188.172/ccoew/feeresponse.php';

	$checksum = hash_hmac('sha256',$str,'eu1XgXFPEVnN', false); 
	$checksum = strtoupper($checksum);
	
	$str = $str . "|" . $checksum;

	//$str = $str .  'DDBC0FCDC85CE58617DEA84468518636997492CDF37C979AF37ADE68B94AAE77';
	
?>

<form method="post" action="<?php echo $url; ?>">
<head>
</head>
<body>
	<br /><br />
		<input type="hidden" name="msg" id="msg" value="<?php echo $str; ?>">  
	<br /><br />
		<div style="display:block">
			<h3 class="page-title" style="margin-left:5%">Send BillDesk Request!</h3><br/><br/><br/><br/><br/>
			<div class="v_detail" style="margin-left:5%">
				<input type="submit" name="btnUpdate" value="Submit Payment Request" title="Update" class="btn btn-mini btn-success" />
			</div>
		</div>
</body>
</form>

