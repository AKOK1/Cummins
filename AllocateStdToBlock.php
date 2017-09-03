<?php
	if(!isset($_SESSION)){
		session_start();
		//$_SESSION['SESSSelectedExam'] = 5;
	} 

	$sqlInsert = "Insert into tblexamblockstudent 
				(ExamBlockID, StdId, Created_by, Created_on)
				Values (?, ?, 'Admin', CURRENT_TIMESTAMP)";

	include 'db/db_connect.php';

	$querym = "SELECT ExamSchID, UploadedFile FROM tblexamschedule ES 
				WHERE ExamId = " . $_SESSION['SESSSelectedExam'] . " AND ExamDate = '" . $_GET['ExamDate'] . 
				"' AND Examslot = '" . $_GET['ExamSlot'] . "'";

	$resultm = $mysqli->query( $querym );
	$num_resultsm = $resultm->num_rows;
	if( $num_resultsm ){

		while( $rowm = $resultm->fetch_assoc() ){
			extract($rowm);
			$StdinCol = explode(',', $UploadedFile);
		
			$query = "SELECT ExamBlockID, Allocation FROM tblexamblock EB INNER JOIN tblblocksmaster BM ON EB.BlockID = BM.BlockID
					Where ExamSchID = " . $ExamSchID . " ORDER BY ExamBlockID ";
					//colorder , 
			$result = $mysqli->query( $query );
			$num_results = $result->num_rows;

			$i = 0;
			if( $num_results ){
				while( $row = $result->fetch_assoc() ){
					extract($row);

						// and StdId = ? 
						// s		
						//, $StdinCol[$i]
						$sqlDel = "Delete from tblexamblockstudent where ExamBlockID = ?";
						$stmt = $mysqli->prepare($sqlDel);
						$stmt->bind_param('i', $ExamBlockID);
						if($stmt->execute()){
							//header('Location: SubjectList.php?'); 
						} else{
							echo $mysqli->error;
							//die("Unable to update.");
						}					


					for ($k = 0 ; $k < $Allocation ; $k++) {
						
						
						
						
						$stmt = $mysqli->prepare($sqlInsert);
						$stmt->bind_param('is', $ExamBlockID, trim($StdinCol[$i]));
						if($stmt->execute()){
							//header('Location: SubjectList.php?'); 
						} else{
							echo $mysqli->error;
							//die("Unable to update.");
						}
						$i += 1;
					}
				}
			}
		}
	}
	header("Location: SelectPaperBlockMain.php?ExamDate=" . $_GET['ExamDate']  . "&ExamSlot=" . $_GET['ExamSlot'] . ""); 
?>

<html>
<head><title>Uploading Complete</title></head>
<body></body>
</html>