<?php
session_start();
//include database connection
	include 'db/db_connect.php';
	if ($_GET['IUD'] == 'D') {
		$sql = "Delete from tblyearstructstdretest where YSID = ? and StdAdmID = ? and sem = ? and ExamID = ?";
		$stmt = $mysqli->prepare($sql);
		$stmt->bind_param('iiii', $_GET['YSID'], $_GET['StdAdmID'], $_GET['sem'], $_GET['ExamID']);
		} 
	else {
		$sql = "Insert into tblyearstructstdretest (YSID,StdAdmID,sem,ExamID) Values ( ?, ?, ?, ?);";
		$stmt = $mysqli->prepare($sql);
		$stmt->bind_param('iiii', $_GET['YSID'], $_GET['StdAdmID'], $_GET['sem'], $_GET['ExamID']);
	}
		
	if($stmt->execute()){
			header('Location: StdRetestMain.php'); 
	} else{
		echo $mysqli->error;
		//die("Unable to update.");
	}

?>

<form >
	<h3 class="page-title" style="margin-left:5%">Exam Block Maintenance</h3>
	</form>

