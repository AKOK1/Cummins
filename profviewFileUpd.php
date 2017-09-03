<?php
session_start();
	include 'db/db_connect.php';
	
	if(isset($_GET['patid'])){
		$sql = "Delete from tblpubpatent where  bookpubid = ?";
		$stmt = $mysqli->prepare($sql);
		$stmt->bind_param('i', $_GET['patid']);
			
		if($stmt->execute()){} else { echo $mysqli->error;
			//die("Unable to update.");
		}
	}
	if(isset($_GET['bookpubid'])){
		$sql = "Delete from tblpublbook where  bookpubid = ?";
		$stmt = $mysqli->prepare($sql);
		$stmt->bind_param('i', $_GET['bookpubid']);
			
		if($stmt->execute()){} else { echo $mysqli->error;
			//die("Unable to update.");
		}
	}

	if(isset($_GET['publicationid'])){
		$sql = "Delete from tblpublications where  bookpubid = ?";
		$stmt = $mysqli->prepare($sql);
		$stmt->bind_param('i', $_GET['publicationid']);
			
		if($stmt->execute()){} else { echo $mysqli->error;
			//die("Unable to update.");
		}
	}

	if(isset($_GET['industryid'])){
		$sql = "Delete from tblprofexp where  industryid = ?";
		$stmt = $mysqli->prepare($sql);
		$stmt->bind_param('i', $_GET['industryid']);
			
		if($stmt->execute()){} else { echo $mysqli->error;
			//die("Unable to update.");
		}
	}

	if(isset($_GET['conid'])){
		$sql = "Delete from tblconservices where  conid = ?";
		$stmt = $mysqli->prepare($sql);
		$stmt->bind_param('i', $_GET['conid']);
			
		if($stmt->execute()){} else { echo $mysqli->error;
			//die("Unable to update.");
		}
	}

	if(isset($_GET['projid'])){
		$sql = "Delete from tblsponsoredprojs where  projid = ?";
		$stmt = $mysqli->prepare($sql);
		$stmt->bind_param('i', $_GET['projid']);
			
		if($stmt->execute()){} else { echo $mysqli->error;
			//die("Unable to update.");
		}
	}

	if(isset($_GET['rconid'])){
		$sql = "Delete from tblresearchcon where  rconid = ?";
		$stmt = $mysqli->prepare($sql);
		$stmt->bind_param('i', $_GET['rconid']);
			
		if($stmt->execute()){} else { echo $mysqli->error;
			//die("Unable to update.");
		}
	}
	header('Location: profviewmain.php'); 

?>

<form >
	<h3 class="page-title" style="margin-left:5%">Exam Block Maintenance</h3>
	</form>

