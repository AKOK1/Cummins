<?php
session_start();
	include 'db/db_connect.php';
	
	$sql = "Delete from tblsyllaprereq where  prereqid = ?";;
	$stmt = $mysqli->prepare($sql);
	$stmt->bind_param('i', $_GET['prereqid']);
		
	if($stmt->execute()){} else { echo $mysqli->error;
		//die("Unable to update.");
	}
	$sql = "Delete from tblsyllaobj where  courseobjid = ?";
	$stmt = $mysqli->prepare($sql);
	$stmt->bind_param('i', $_GET['courseobjid']);
		
	if($stmt->execute()){} else { echo $mysqli->error;
		//die("Unable to update.");
	}
	$sql = "Delete from tblsyllaoutcome where  courseoutid = ?";
	$stmt = $mysqli->prepare($sql);
	$stmt->bind_param('i', $_GET['courseoutid']);
		
	if($stmt->execute()){} else { echo $mysqli->error;
		//die("Unable to update.");
	}
	$sql = "Delete from tblsyllacontents where  syllabusID = ?";
	$stmt = $mysqli->prepare($sql);
	$stmt->bind_param('i', $_GET['syllabusID']);
		
	if($stmt->execute()){} else { echo $mysqli->error;
		//die("Unable to update.");
	}
	$sql = "Delete from tblsyllaexpts where  expid = ?";
	$stmt = $mysqli->prepare($sql);
	$stmt->bind_param('i', $_GET['expid']);
		
	if($stmt->execute()){} else { echo $mysqli->error;
		//die("Unable to update.");
	}
	$sql = "Delete from tblsyllabooks where  bookid = ?";
	$stmt = $mysqli->prepare($sql);
	$stmt->bind_param('i', $_GET['bookid']);
		
	if($stmt->execute()){} else { echo $mysqli->error;
		//die("Unable to update.");
	}
	$sql = "Delete from tblsyllaprebycourse where  prereqidbycourse = ?";
	$stmt = $mysqli->prepare($sql);
	$stmt->bind_param('i', $_GET['prereqidbycourse']);
		
	if($stmt->execute()){} else { echo $mysqli->error;
		//die("Unable to update.");
	}
	$sql = "Delete from tblsyllarefbooks where  refbookid = ?";
	$stmt = $mysqli->prepare($sql);
	$stmt->bind_param('i', $_GET['refbookid']);
		
	if($stmt->execute()){} else { echo $mysqli->error;
		//die("Unable to update.");
	}
	$sql = "Delete from tblsyllarefmatbooks where  refmatbookid = ?";
	$stmt = $mysqli->prepare($sql);
	$stmt->bind_param('i', $_GET['refmatbookid']);
		
	if($stmt->execute()){} else { echo $mysqli->error;
		//die("Unable to update.");
	}
	header('Location: StructureViewMain.php'); 

?>

<form >
	<h3 class="page-title" style="margin-left:5%">Exam Block Maintenance</h3>
	</form>

