<?php
session_start();
//include database connection
	include 'db/db_connect.php';
	//echo $_GET['IUD'];
	//echo $_GET['PaperID'];
	//echo $_GET['BlockCapacity'];
	//echo $_GET['Partial'];
	if ($_GET['type'] == 'b') {
		if ($_GET['IUD'] == 'D') {
			$sql = "Delete from tblcapblockprof where cbpid = ? ";
			$stmt = $mysqli->prepare($sql);
			$stmt->bind_param('i', $_GET['cbpid']);
			} 
		else {
			$sql = "Insert into tblcapblockprof (ExamBlockID, profid, ExamID) Values ( ?, ?, ?);";
			$stmt = $mysqli->prepare($sql);
			$stmt->bind_param('iii', $_GET['ExamBlockID'], $_GET['profid'], $_SESSION["SESSCAPSelectedExam"]);
		}
			
		if($stmt->execute()){
			header("Location: assignblockMain.php?profid={$_GET['profid']}"); 
		} else{
			echo $mysqli->error;
			//die("Unable to update.");
		}
	}	
	else{
		if ($_GET['IUD'] == 'D') {
			$sql = "Delete from tblcapblockprof where cbpid = ? ";
			$stmt = $mysqli->prepare($sql);
			$stmt->bind_param('i', $_GET['cbpid']);
			} 
		else {
			$sql = "Insert into tblcapblockprof (ExamBlockID, profid, ExamID,`div`) Values ( ?, ?, ?, ?);";
			$stmt = $mysqli->prepare($sql);
			$stmt->bind_param('iiis', $_GET['paperid'], $_GET['profid'], $_SESSION["SESSCAPSelectedExam"], $_GET['division']);
		}
			
		if($stmt->execute()){
			header("Location: assigndivisionMain.php?profid={$_GET['profid']}"); 
		} else{
			echo $mysqli->error;
			//die("Unable to update.");
		}
	}

?>

<form >
	<h3 class="page-title" style="margin-left:5%">Exam Block Maintenance</h3>
	</form>

