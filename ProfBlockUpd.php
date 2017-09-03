<?php
//include database connection
	include 'db/db_connect.php';
	
	if ($_GET['IUD'] == 'U') {
		$sql = "Update tblexamblock set ProfID = ? where ExamBlockID = ?";
		$stmt = $mysqli->prepare($sql);
		$stmt->bind_param('ii', $_GET['userID'], $_GET['ExamBlockId']  );
		} 
	
	
	if($stmt->execute()){
		header('Location: DayListMain.php?'); 
	} else{
		echo $mysqli->error;
		//die("Unable to update.");
	}

?>

<form >
	<h3 class="page-title" style="margin-left:5%">Paper Maintenance</h3>
	</form>

