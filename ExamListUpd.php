<?php
//include database connection
	include 'db/db_connect.php';
	echo 'asasa';
	die;

	$sql = "UPDATE tblexammaster SET  timelist = ? WHERE ExamID = ?";
	$stmt = $mysqli->prepare($sql);
	$stmt->bind_param('si', $_GET['batchname'], $_GET['ExamID']  );
	if($stmt->execute()){} 
	else{ echo $mysqli->error;}
	
	$sql = "DELETE FROM tblblocksmaster WHERE examid  = ? ;";
	$stmt = $mysqli->prepare($sql);
	$stmt->bind_param('i', $_GET['ExamID']  );
	if($stmt->execute()){} 
	else{ echo $mysqli->error;}

	
	$sql = " SELECT CONCAT('@', timefrom, ' ', ampmfr, ' ',  'to', ' ', timeto, ' ', ampmto) AS BatchTime FROM tblbatchtimemaster 
			Where batchname = '" .  $_GET['batchname']  . "' ORDER BY timeorder ";
	echo $sql;
	die;
	// execute the sql query
	$result = $mysqli->query( $sql );
	$num_results = $result->num_rows;
	$i = 100;
	if( $num_results ){
		while( $row = $result->fetch_assoc() ){
			extract($row);
			$sql = "INSERT INTO tblblocksmaster (BlockNo, BlockName, BlockType, BlockCapacity, Active, created_on, created_by, updated_on, updated_by, colorder, examid)
			SELECT @a:=@a+1, CONCAT(BlockName, ' " .  $BatchTime. "'), BlockType, BlockCapacity, Active, CURRENT_TIMESTAMP, 'Admin', CURRENT_TIMESTAMP, 'Admin', @a:=@a+1 , ?
			FROM tblblocksmaster , (SELECT @a:= ". $i . ") AS a WHERE BlockType = 'Laboratory' AND examid IS NULL ";
			$stmt = $mysqli->prepare($sql);
			$stmt->bind_param('i', $_GET['ExamID']  );
			if($stmt->execute()){} 
			else{echo $mysqli->error;}

			$i = $i + 100;
		}
	}					
	
	//header("Location: ExamMaintMain.php?ExamID=" . $_GET['ExamID'] . "" ); 
?>

<form >
	<h3 class="page-title" style="margin-left:5%">File Upload Maintenance</h3>
	</form>

