<?php
session_start();
	include 'db/db_connect.php';
	
	$sql = "Delete from tblresultfile where ResFileID = ?";
	$stmt = $mysqli->prepare($sql);
	$stmt->bind_param('i', $_GET['ResFileID']);
		
	if($stmt->execute()){} else { echo $mysqli->error;
		//die("Unable to update.");
	}

	$sql = "Delete from tblstdresult where StdResMID in (Select StdResMID from  tblstdresultm where ResFileID = ?)";
	$stmt = $mysqli->prepare($sql);
	$stmt->bind_param('i', $_GET['ResFileID']);
		
	if($stmt->execute()){} else { echo $mysqli->error;
		//die("Unable to update.");
	}

	$sql = "Delete from  tblstdresultm where ResFileID = ?";
	$stmt = $mysqli->prepare($sql);
	$stmt->bind_param('i', $_GET['ResFileID']);
		
	if($stmt->execute()){} else { echo $mysqli->error;
		//die("Unable to update.");
	}
	
	header('Location: UploadResultFileMain.php'); 

?>

<form >
	<h3 class="page-title" style="margin-left:5%">Exam Block Maintenance</h3>
	</form>

