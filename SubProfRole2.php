<?php
session_start();
//include database connection
	include 'db/db_connect.php';
	if($_GET['op'] == 'I'){
		$sql = "delete from tblsubprofrole where profid = ? and paperid = ? and roleid = ?;";
		$stmt = $mysqli->prepare($sql);
		$stmt->bind_param('iii', $_GET['profid'], $_GET['PaperID'], $_GET['role']);
		if($stmt->execute()){
			$sql = "Insert into tblsubprofrole (profid,paperid,roleid) Values ( ?, ?, ?);";
			$stmt = $mysqli->prepare($sql);
			$stmt->bind_param('iii', $_GET['profid'], $_GET['PaperID'], $_GET['role']);
		}
	}
	else{
		$sql = "delete from tblsubprofrole where profid = ? and paperid = ? and roleid = ?;";
		$stmt = $mysqli->prepare($sql);
		$stmt->bind_param('iii', $_GET['profid'], $_GET['PaperID'], $_GET['role']);
	}
	if($stmt->execute()){
			header('Location: SubRoleMapMain.php?deptname=' . $_GET['deptname'] . '&PaperID=' . $_GET['PaperID'] . '&subname=' . $_GET['subname']); 
	} else{
		echo $mysqli->error;
		//die("Unable to update.");
	}

?>

<form >
	<h3 class="page-title" style="margin-left:5%">Prof Sub Role Maintenance</h3>
	</form>

