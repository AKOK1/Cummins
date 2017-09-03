
<?php
			
	include 'db/db_connect.php';

	$sql = "Delete from tblquestionanswer where  qansid = ?";
	$stmt = $mysqli->prepare($sql);
	$stmt->bind_param('i', $_GET['qansid']);
		
	if($stmt->execute()){} else { echo $mysqli->error;
		//die("Unable to update.");
	}
	
	header("Location: QuestionMaintMain.php?QID=" . $_GET["QID"] . "");  

?>

<form >
	<h3 class="page-title" style="margin-left:5%">Exam Block Maintenance</h3>
	</form>

