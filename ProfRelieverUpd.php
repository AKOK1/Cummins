<?php
//include database connection
	session_start();
	include 'db/db_connect.php';

	if ($_GET['IUD'] == 'U') {
		
		$sql = "SELECT DISTINCT(ExamSchId) FROM tblExamSchedule ES 
				WHERE ExamDate = '". $_GET['ExamDate'] . "' AND ExamSlot = '" . $_GET['ExamSlot'] . "'" ;

		//echo $sql;
		
		// execute the sql query
		$result = $mysqli->query( $sql );
		$num_results = $result->num_rows;

		if( $num_results ){
			while( $row = $result->fetch_assoc() ){
				extract($row);
				$sql1 = "Insert into tblreliever (ExamSchId, ProfId) Values (?,?) ";
				$stmt = $mysqli->prepare($sql1);
				$stmt->bind_param('ii', $ExamSchId, $_GET['ProfID']  );
				if($stmt->execute()){
					header('Location: ProfRelieverMain.php?ExamDate='.$_GET['ExamDate']. '&ExamSlot='.$_GET['ExamSlot']. ''); 
				} else{
					echo $mysqli->error;
					//die("Unable to update.");
				}
			}					
		}
		
	}

	Else {

		$sql2 = "Delete from  tblreliever where RelID = ? ";
		$stmt = $mysqli->prepare($sql2);
		$stmt->bind_param('i', $_GET['RelID']  );
		if($stmt->execute()){
			header('Location: ProfRelieverMain.php?ExamDate='.$_GET['ExamDate']. '&ExamSlot='.$_GET['ExamSlot']. ''); 
		} else{
			echo $mysqli->error;
			//die("Unable to update.");
		}
	}
?>

<form >
	<h3 class="page-title" style="margin-left:5%">Paper Maintenance</h3>
</form>