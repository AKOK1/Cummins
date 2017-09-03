<?php
//include database connection
	include 'db/db_connect.php';
	
	if ($_GET['IUD'] == 'D') {
		
		$sql = "DELETE FROM tblexamblockstudent WHERE ExamBlockID IN (SELECT  ExamBlockID  FROM tblexamblock WHERE ExamSchId = ? );";
		$stmt = $mysqli->prepare($sql);
		$stmt->bind_param('i', $_GET['ExamBlockId']  );
		if($stmt->execute()){} 
		else{ echo $mysqli->error;}

		$sql1 = "UPDATE  tblexamblock SET FileName = NULL 
				WHERE ExamBlockID IN ( SELECT * FROM (SELECT  ExamBlockID  FROM tblexamblock WHERE ExamSchID = ? ) as A); ";
		$stmt = $mysqli->prepare($sql1);
		$stmt->bind_param('i', $_GET['ExamBlockId']  );

		if($stmt->execute()){
		header("Location: BlockFileMain.php?ExamSchId1=" . $_GET['ExamBlockId'] . "&paperinfo=" . $_GET['PaperInfo'] . ""); 
		} else{
			echo $mysqli->error;
		}
	} 
?>

<form >
	<h3 class="page-title" style="margin-left:5%">File Upload Maintenance</h3>
	</form>

