<?php
session_start();
//include database connection
	include 'db/db_connect.php';
	if ($_GET['IUD'] == 'D') {
		$sql = "Delete from tblyearstructstd where YSID = ? and StdAdmID = ?";
		$stmt = $mysqli->prepare($sql);
		$stmt->bind_param('ii', $_GET['YSID'], $_GET['StdAdmID']);
		} 
	else {
		$sql = "Insert into tblyearstructstd (YSID,StdAdmID) Values ( ?, ?);";
		$stmt = $mysqli->prepare($sql);
		$stmt->bind_param('ii', $_GET['YSID'], $_GET['StdAdmID']);
	}
		
	if($stmt->execute()){
		if(isset($_GET['fromadmin']))
			header('Location: StdElectiveMapMain.php?fromadmin=1'); 
		else
			header('Location: StdElectiveMapMain.php'); 
	} else{
		echo $mysqli->error;
		//die("Unable to update.");
	}

?>

<form >
	<h3 class="page-title" style="margin-left:5%">Exam Block Maintenance</h3>
	</form>

