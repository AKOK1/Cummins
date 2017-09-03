<?php
//include database connection
		if(!isset($_SESSION)){
			session_start();
		}
	include 'db/db_connect.php';
	 //echo $_GET['IUD'];
	 //echo $_GET['ExamDate'];
	 //echo $_GET['ExamSlot'];
	 //echo $_SESSION["SESSUserID"]; 
	 //echo $_SESSION["SESSSelectedExam"];
	 //die;
	if ($_GET['IUD'] == 'D') {
			$sql = "Delete from tblprofessorpref where ProfPrefID = ?";
			$stmt = $mysqli->prepare($sql);
			$stmt->bind_param('i', $_GET['ProfPrefID']);
			if($stmt->execute()){
				if(isset($_GET['screen']) == 'unassigned')
				{
						header("Location: unassignedProfblock2Main.php?ProfID={$_GET['ProfID']}&ProfName={$_GET['ProfName']}"); 
				}
				else
				{
						header('Location: ProfPrefMain.php?'); 
				}
			} else{
				 echo $mysqli->error;
				//die("Unable to update.");
			}
	} 
	else {
			include 'db/db_connect.php';
			$sql = "SELECT  ExamType FROM tblexammaster WHERE ExamId = " . $_SESSION["SESSSelectedExam"] ;
			$result = $mysqli->query( $sql );
			$num_results = $result->num_rows;
			if( $num_results ){
				while( $row = $result->fetch_assoc() ){
					extract($row);
					$_SESSION["SESSSelectedExamType"] = $ExamType;
				}
			}
			if(isset($_GET['screen']) == 'unassigned')
			{
				$mysqli->query("SET @i_ProfId  = " . $_GET["ProfID"] . "");
			}
			else
			{
				$mysqli->query("SET @i_ProfId  = " . $_SESSION["SESSUserID"] . "");
			}
			$mysqli->query("SET @i_ExamId   = " .  $_SESSION["SESSSelectedExam"] . "");
			$mysqli->query("SET @i_ExamDate   = '" .  $_GET['ExamDate'] . "'");
			$mysqli->query("SET @i_ExamSlot   = '" .  $_GET['ExamSlot'] . "'");
			if($_SESSION["SESSSelectedExamType"] ==  'Online'){
				$result1 = $mysqli->query("CALL SP_BLOCKBLOCKONLINE(@i_ProfId,@i_ExamId,@i_ExamDate,@i_ExamSlot)");
			}
			else
			{
				$result1 = $mysqli->query("CALL SP_BLOCKBLOCK(@i_ProfId,@i_ExamId,@i_ExamDate,@i_ExamSlot)");
			}
			while( $row = $result1->fetch_assoc() ) {
				extract($row);
				If($SAVESTATUS == 0)
					{
						echo "<script type='text/javascript'>window.onload = function()
						{
							document.getElementById('lblFailure').style.display = 'block';
						}
						</script>";
							header('Location: ProfPrefMain.php?'); 
					}
					else
					{
						if(isset($_GET['screen']) == 'unassigned')
						{
							header("Location: unassignedProfblock2Main.php?ProfID={$_GET['ProfID']}&ProfName={$_GET['ProfName']}"); 
						}
						else
						{
							header('Location: ProfPrefMain.php?'); 
						}
					}
			}
	}
	
	// if($stmt->execute()){
		// //$sql = "update tblprofessorpref set active = 0 where ProfID = ? and ExamID = ?";
		// //$stmt = $mysqli->prepare($sql);
		// //$stmt->bind_param('ii', $_SESSION["SESSUserID"], $_SESSION["SESSSelectedExam"]);
		// //$stmt->execute();
		// if(isset($_GET['abc']) == 'd')
		// {
			// header('Location: UnassignedMain.php?'); 
		// }
		// else
		// {
			// header('Location: ProfPrefMain.php?'); 
		// }
	// } else{
		// echo $mysqli->error;
		// //die("Unable to update.");
	// }

?>

<form >
	<h3 class="page-title" style="margin-left:5%">Paper Maintenance</h3>
	</form>

