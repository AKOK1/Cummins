<?php
//include database connection
	if ($_GET['IUD'] == 'D') {
		include 'db/db_connect.php';
		$sql = "Delete from tblquizques WHERE quizqueid = ? ;";
		$stmt = $mysqli->prepare($sql);
		$stmt->bind_param('i', $_GET['queid']);
		if($stmt->execute()){
		header("Location: selectsubexamMaintMain.php?quizid=" . $_GET['quizid'] . "&paperid=" . $_GET['paperid']); 
		} else{
			echo $mysqli->error;
		}
	}

	if ($_GET['IUD'] == 'IQ') {
		include 'db/db_connect.php';
		$maxqnoorder = 0;
		$sql = "SELECT (COALESCE(MAX(qnoorder), 0) + 1) AS qnoorder  FROM tblquizques WHERE quizid = " .  $_GET['quizid'] ;
		//echo $sql;
		
		$resultmaxQueno = $mysqli->query( $sql );
		$num_results = $resultmaxQueno->num_rows;
		if( $num_results ){
			while( $row = $resultmaxQueno->fetch_assoc() ){
				extract($row);
					$maxqnoorder = $qnoorder;
				}
		}
		else {
			echo $mysqli->error;
			die("Issue.");
		}

		//disconnect from database
		$resultmaxQueno->free();
		$mysqli->close();

		include 'db/db_connect.php';
		$stmt = $mysqli->prepare("INSERT INTO tblquizques (quizid, qid,instno ,qtype, qnoorder,qmarks) 
									VALUES (" . $_GET['quizid'] . ", " . $_GET['QID'] . "," . $_GET['quizno'] . ", 'Q', ?," . $_GET['qmarks'] . ")");
		$stmt->bind_param('i', $maxqnoorder);
		if($stmt->execute()) {
			header("Location: selectsubexamMaintMain.php?quizid=" . $_GET['quizid'] . "&paperid=" . $_GET['paperid']); 
		}
		else {
			echo $mysqli->error;
			die("Unable to update.");
		}
	}

	
	if ($_GET['IUD'] == 'Up') {
		include 'db/db_connect.php';
		$oldquizqueid = 0;
		$oldqnoorder = 0;
		
		$sql = "Select quizqueid, qnoorder from tblquizques where quizid = " . $_GET['quizid'] . " and qnoorder < " . $_GET['qnoorder'] . " ORDER BY qnoorder DESC LIMIT 1 "  ;
		
		$resultoldquizqueid = $mysqli->query( $sql );
		$num_results = $resultoldquizqueid->num_rows;
		if( $num_results ){
			while( $row = $resultoldquizqueid->fetch_assoc() ){
				extract($row);
					$oldquizqueid = $quizqueid;
					$oldqnoorder = $qnoorder;
				}
		}
		
		include 'db/db_connect.php';
		$sql = "Update tblquizques set qnoorder = ? WHERE quizqueid = ? ;";
		$stmt = $mysqli->prepare($sql);
		$stmt->bind_param('ii', $oldqnoorder, $_GET['queid']);
		if($stmt->execute()){} 
		else{ echo $mysqli->error;}

		include 'db/db_connect.php';
		$sql = "Update tblquizques set qnoorder = ? WHERE quizqueid = ? ;";
		$stmt = $mysqli->prepare($sql);
		$stmt->bind_param('ii', $_GET['qnoorder'], $oldquizqueid);

		if($stmt->execute()){
		header("Location: selectsubexamMaintMain.php?quizid=" . $_GET['quizid'] . "&paperid=" . $_GET['paperid']); 
		} else{
			echo $mysqli->error;
		}

	}

	
	if ($_GET['IUD'] == 'Down') {
		include 'db/db_connect.php';
		$oldquizqueid = 0;
		$oldqnoorder = 0;
		
		$sql = "Select quizqueid, qnoorder from tblquizques where quizid = " . $_GET['quizid'] . " and qnoorder > " . $_GET['qnoorder'] . " ORDER BY qnoorder LIMIT 1 "  ;
		
		$resultoldquizqueid = $mysqli->query( $sql );
		$num_results = $resultoldquizqueid->num_rows;
		if( $num_results ){
			while( $row = $resultoldquizqueid->fetch_assoc() ){
				extract($row);
					$oldquizqueid = $quizqueid;
					$oldqnoorder = $qnoorder;
				}
		}
		
		include 'db/db_connect.php';
		$sql = "Update tblquizques set qnoorder = ? WHERE quizqueid = ? ;";
		$stmt = $mysqli->prepare($sql);
		$stmt->bind_param('ii', $oldqnoorder, $_GET['queid']);
		if($stmt->execute()){} 
		else{ echo $mysqli->error;}

		include 'db/db_connect.php';
		$sql = "Update tblquizques set qnoorder = ? WHERE quizqueid = ? ;";
		$stmt = $mysqli->prepare($sql);
		$stmt->bind_param('ii', $_GET['qnoorder'], $oldquizqueid);

		if($stmt->execute()){
		header("Location: selectsubexamMaintMain.php?quizid=" . $_GET['quizid'] . "&paperid=" . $_GET['paperid']); 
		} else{
			echo $mysqli->error;
		}
	}
	
	?>

<form >
	<h3 class="page-title" style="margin-left:5%">File Upload Maintenance</h3>
	</form>


	