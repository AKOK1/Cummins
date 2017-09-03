<?php
session_start();
//include database connection
	include 'db/db_connect.php';
	// echo $_GET['IUD'];
	// echo $_GET['PaperID'];
	 //echo $_GET['partialloc'];
	 echo $_GET['txtPA'][0];
	die;
	if ($_GET['IUD'] == 'P') {
		$sql = "update tblexamblock set IsPartial = 1,Allocation = ? where ExamBlockID = ?";
		$stmt = $mysqli->prepare($sql);
		$stmt->bind_param('ii', $_GET['txtPA'][0], $_GET['ExamBlockID']);
		} 
	else {
		$sql = "Insert into tblexamblock ( ExamSchID,BlockID,PaperID) Values ( 1, ?, ?)";
		$stmt = $mysqli->prepare($sql);
		$stmt->bind_param('ii', $_GET['ExamBlockID'], $_GET['PaperID']);
	}
	
	
	if($stmt->execute()){
		$_SESSION["SESSPaperID"] = $_GET['PaperID'];
		$_SESSION["SESSPatId"] = $_GET['PatID'];
		header('Location: PaperBlockMain.php'); 
	} else{
		echo $mysqli->error;
		//die("Unable to update.");
	}

?>

<form >
	<h3 class="page-title" style="margin-left:5%">Exam Block Maintenance</h3>
	</form>

