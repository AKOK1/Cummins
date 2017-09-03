<?php
session_start();
	include 'db/db_connect.php';
	
	$sql = "Delete from tblquestionmaster where  QID = ?";;
	$stmt = $mysqli->prepare($sql);
	$stmt->bind_param('i', $_GET['QID']);
		
	if($stmt->execute()){} else { echo $mysqli->error;
		//die("Unable to update.");
	}
	$sql = "Delete from tblquestionanswer where  QID = ?";
	$stmt = $mysqli->prepare($sql);
	$stmt->bind_param('i', $_GET['QID']);
		
	if($stmt->execute()){} else { echo $mysqli->error;
		//die("Unable to update.");
	}
	header('Location: QuestionListMain.php'); 

?>

<form >
	<h3 class="page-title" style="margin-left:5%">Exam Block Maintenance</h3>
	</form>

