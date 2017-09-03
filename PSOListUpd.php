<?php
session_start();
	include 'db/db_connect.php';
	
	$sql = "Delete from tblpso where  psoid = ?";;
	$stmt = $mysqli->prepare($sql);
	$stmt->bind_param('i', $_GET['psoid']);
		
	if($stmt->execute()){} else { echo $mysqli->error;
		//die("Unable to update.");
	}
	
	header('Location: PSOListMain.php'); 

?>

<form >
	
	</form>

