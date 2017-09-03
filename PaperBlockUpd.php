<?php
session_start();
//include database connection
	include 'db/db_connect.php';
	//echo $_GET['IUD'];
	//echo $_GET['PaperID'];
	//echo $_GET['BlockCapacity'];
	//echo $_GET['Partial'];
	
	if ($_GET['IUD'] == 'D') {
		$sql = "Delete from tblexamblock where ExamBlockID = ?";
		$stmt = $mysqli->prepare($sql);
		$stmt->bind_param('i', $_GET['ExamBlockID']);
		} 
	else {
		if($_GET['Partial'] == 1){
			/*
			$sql1 = "delete from tblexamblock where paperid = " .$_GET['PaperID']. " and ExamSchID = " .$_SESSION["SESSSelectedExam"]. " and BlockID = ".$_GET['ExamBlockID']. ";";
			$stmt1 = $mysqli->prepare($sql1);
			$stmt1->execute();
			*/
			$sql = "Insert into tblexamblock ( ExamSchID,BlockID,PaperID,Capacity,Allocation,IsPartial) Values ( ?, ?, ?, ?, ?, 1);";
			$stmt = $mysqli->prepare($sql);
			$stmt->bind_param('iiiii', $_GET['ExamSchID'], $_GET['ExamBlockID1'], $_GET['PaperID'], $_GET['BlockCapacity'], $_GET['BlockCapacityAvailable']);
		}
		else
		{
			$sql = "Insert into tblexamblock ( ExamSchID,BlockID,PaperID,Capacity,Allocation,IsPartial) Values ( ?, ?, ?, ?, ?, 0);";
			$stmt = $mysqli->prepare($sql);
			$stmt->bind_param('iiiii', $_GET['ExamSchID'], $_GET['ExamBlockID1'], $_GET['PaperID'], $_GET['BlockCapacity'], $_GET['BlockCapacityAvailable']);
		}
	}
		
	if($stmt->execute()){
		header('Location: PaperBlockMain.php'); 
	} else{
		echo $mysqli->error;
		//die("Unable to update.");
	}

?>

<form >
	<h3 class="page-title" style="margin-left:5%">Exam Block Maintenance</h3>
	</form>

