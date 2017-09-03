<?php
//include database connection
		if(!isset($_SESSION)){
			session_start();
		}
	include 'db/db_connect.php';
	if ($_GET['IUD'] == 'I') {
		include 'db/db_connect.php';
		$sql = "Update tblstdadm Set feespaid = 1, stdstatus = 'R'  where StdAdmID = ?";
		$stmt = $mysqli->prepare($sql);
		$stmt->bind_param('i', $_GET['StdAdmID']);
			
		if($stmt->execute()){} else { echo $mysqli->error;
			//die("Unable to update.");
		}
		
		$sql = "insert into tblexamfee(examid,stdadmid) values(?, ?)";
		$stmt = $mysqli->prepare($sql);
		$stmt->bind_param('ii', $_SESSION["SESSSelectedExam"], $_GET['StdAdmID']);
			
		if($stmt->execute()){} else { echo $mysqli->error;
			//die("Unable to update.");
		}


		header('Location: paidexamfeesstudsMain.php'); 
	}
	if (($_GET['IUD'] == 'CA') || ($_GET['IUD'] == 'C')) {
		include 'db/db_connect.php';
		$sql = "Update tblstdadm Set feespaid = NULL, stdstatus = NULL  where StdAdmID = ?";
		$stmt = $mysqli->prepare($sql);
		$stmt->bind_param('i', $_GET['StdAdmID']);
			
		if($stmt->execute()){} else { echo $mysqli->error;
			//die("Unable to update.");
		}
		
		$sql = "delete from tblexamfee where examid = ? and stdadmid = ?";
		$stmt = $mysqli->prepare($sql);
		$stmt->bind_param('ii', $_SESSION["SESSSelectedExam"], $_GET['StdAdmID']);
			
		if($stmt->execute()){} else { echo $mysqli->error;
			//die("Unable to update.");
		}
		
		header('Location: paidexamfeesstudsMain.php'); 
	}
	if ($_GET['IUD'] == 'D') {
		include 'db/db_connect.php';
		$sql = "Update tblstdadm Set feespaid = NULL,stdstatus = 'D'  where StdAdmID = ?";
		$stmt = $mysqli->prepare($sql);
		$stmt->bind_param('i', $_GET['StdAdmID']);
			
		if($stmt->execute()){} else { echo $mysqli->error;
			//die("Unable to update.");
		}
		
		$sql = "delete from tblexamfee where examid = ? and stdadmid = ?";
		$stmt = $mysqli->prepare($sql);
		$stmt->bind_param('ii', $_SESSION["SESSSelectedExam"], $_GET['StdAdmID']);
			
		if($stmt->execute()){} else { echo $mysqli->error;
			//die("Unable to update.");
		}

		header('Location: StdListCurYearMain.php'); 
	}
	if ($_GET['IUD'] == 'YD') {
		include 'db/db_connect.php';
		$sql = "Update tblstdadm Set feespaid = NULL,stdstatus = 'YD'  where StdAdmID = ?";
		$stmt = $mysqli->prepare($sql);
		$stmt->bind_param('i', $_GET['StdAdmID']);
			
		if($stmt->execute()){} else { echo $mysqli->error; die;
			//die("Unable to update.");
		}
		
		$sql = "delete from tblexamfee where examid = ? and stdadmid = ?";
		$stmt = $mysqli->prepare($sql);
		$stmt->bind_param('ii', $_SESSION["SESSSelectedExam"], $_GET['StdAdmID']);
			
		if($stmt->execute()){} else { echo $mysqli->error;
			//die("Unable to update.");
		}

		header('Location: StdListCurYearMain.php'); 
	}
	if ($_GET['IUD'] == 'R') {
		include 'db/db_connect.php';
		$sql = "Update tblstdadm Set feespaid = 1,stdstatus = 'R'  where StdAdmID = ?";
		$stmt = $mysqli->prepare($sql);
		$stmt->bind_param('i', $_GET['StdAdmID']);
			
		if($stmt->execute()){} else { echo $mysqli->error;
			//die("Unable to update.");
		}
		
		$sql = "insert into tblexamfee(examid,stdadmid) values(?, ?)";
		$stmt = $mysqli->prepare($sql);
		$stmt->bind_param('ii', $_SESSION["SESSSelectedExam"], $_GET['StdAdmID']);
			
		if($stmt->execute()){} else { echo $mysqli->error;
			//die("Unable to update.");
		}
		header('Location: StdListCurYearMain.php'); 
	}

?>

<form >
	<h3 class="page-title" style="margin-left:5%">Peon Maintenance</h3>
</form>

