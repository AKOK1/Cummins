<?php
//include database connection
		if(!isset($_SESSION)){
			session_start();
		}
	include 'db/db_connect.php';
	 //echo $_GET['BlockID'];
	//die;
	if ($_GET['IUD'] == 'D') {
			$sql = "update tblexamblock set ProfID = NULL where ExamBlockID = ?";
			$stmt = $mysqli->prepare($sql);
			$stmt->bind_param('i', $_GET['ExamBlockID']);
			if($stmt->execute()){
						header("Location: unassignedProfblock2Main.php?BlockName={$_GET['BlockName']}&PaperInfo={$_GET['PaperInfo']}&ExamDate={$_GET['ExamDate']}&ExamSlot={$_GET['ExamSlot']}&BlockID={$BlockID}&ExamBlockID={$ExamBlockID}"); 
			} else{
				 echo $mysqli->error;
				//die("Unable to update.");
			}
	} 
	else {
			$sql = "update tblexamblock set ProfID = ? where ExamBlockID = ?";
			$stmt = $mysqli->prepare($sql);
			$stmt->bind_param('ii', $_GET['ProfID'],$_GET['ExamBlockID']);
			if($stmt->execute()){
						header("Location: unassignedProfblock2Main.php?BlockName={$_GET['BlockName']}&PaperInfo={$_GET['PaperInfo']}&ExamDate={$_GET['ExamDate']}&ExamSlot={$_GET['ExamSlot']}&BlockID={$BlockID}&ExamBlockID={$ExamBlockID}"); 
			} else{
				 echo $mysqli->error;
				//die("Unable to update.");
			}
	}
	
	
?>

<form >
	<h3 class="page-title" style="margin-left:5%">Prof Block Maintenance</h3>
	</form>

