<?php
session_start();
//include database connection
	include 'db/db_connect.php';
	//if ($_GET['sem'] == '3') {
	if ($_GET['IUD'] == 'D') {
		$sql = "Delete from tblyearstructstdretest where YSID = ? and StdAdmID = ? and sem = ? 
				and examid in (select examid from tblexammaster where ExamName like '%Summer%')";
		$stmt = $mysqli->prepare($sql);
		$stmt->bind_param('iii', $_GET['YSID'], $_GET['StdAdmID'], $_GET['sem']);
		if($stmt->execute()){} else { echo $mysqli->error;}
	} 
	else {
		//insert all summer term exams!!
		include 'db/db_connect.php';
		$sql = "SELECT ExamID FROM  tblexammaster em 
				INNER JOIN tblstdadm sa ON sa.EduYearFrom = em.AcadYearFrom AND sa.StdAdmID = ". $_GET['StdAdmID'] . "
				WHERE CURRENT_TIMESTAMP BETWEEN reteststart AND retestend AND ExamName like '%Summer%'
				AND sem = " . $_GET['sem'] . ""	 ;
		$result = $mysqli->query( $sql );
		$num_results = $result->num_rows;
		if( $num_results ){
			while( $row = $result->fetch_assoc() ){
				extract($row);
				$pos = strpos($ExamName, 'Sem ' . $_GET['sem']);
				$sql = "Insert into tblyearstructstdretest (YSID,StdAdmID,sem,ExamID) Values ( ?, ?, ?, ?);";
				$stmt = $mysqli->prepare($sql);
				$stmt->bind_param('iiii', $_GET['YSID'], $_GET['StdAdmID'], $_GET['sem'], $ExamID);
				if($stmt->execute()){} else { echo $mysqli->error;}
			}
		}
	}
	header('Location: StdSummerMain.php'); 
	// }
	// else{
		// if ($_GET['IUD'] == 'D') {
			// $sql = "Delete from tblyearstructstdretest where YSID = ? and StdAdmID = ? and sem = ? and ExamID = ?";
			// $stmt = $mysqli->prepare($sql);
			// $stmt->bind_param('iiii', $_GET['YSID'], $_GET['StdAdmID'], $_GET['sem'], $_GET['ExamID']);
			// } 
		// else {
			// $sql = "Insert into tblyearstructstdretest (YSID,StdAdmID,sem,ExamID) Values ( ?, ?, ?, ?);";
			// $stmt = $mysqli->prepare($sql);
			// $stmt->bind_param('iiii', $_GET['YSID'], $_GET['StdAdmID'], $_GET['sem'], $_GET['ExamID']);
		// }
		// if($stmt->execute()){
			// header('Location: StdSummerMain.php'); 
		// } else{
			// echo $mysqli->error;
		// //die("Unable to update.");
		// }
	// }
		

?>

<form >
	<h3 class="page-title" style="margin-left:5%">Exam Block Maintenance</h3>
	</form>

