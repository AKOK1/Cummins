<?php
//include database connection
		if(!isset($_SESSION)){
			session_start();
		}
	include 'db/db_connect.php';
	// echo $_GET['IUD'];
	// echo $_GET['ExamDate'];
	// echo $_GET['ExamSlot'];
	// echo $_SESSION["SESSUserID"]; 
	// echo $_SESSION["SESSSelectedExam"];
	// die;
	if ($_GET['IUD'] == 'D') {
			$sql = "Delete from tblpeonpref where PeonPrefID = ?";
			$stmt = $mysqli->prepare($sql);
			$stmt->bind_param('i', $_GET['PeonPrefID']);
			if($stmt->execute()){
				if(isset($_GET['screen']) == 'unassigned')
				{
						header("Location: unassignedPeonblock2Main.php?PeonID={$_GET['PeonID']}&PeonName={$_GET['PeonName']}"); 
				}
				else
				{
						header('Location: PeonPrefMain.php?'); 
				}
			} else{
				 echo $mysqli->error;
				//die("Unable to update.");
			}
	} 
	else {
			$mysqli->query("SET @i_PeonId  = " . $_GET["PeonID"] . "");
			$mysqli->query("SET @i_ExamId   = " .  $_SESSION["SESSSelectedExam"] . "");
			$mysqli->query("SET @i_ExamDate   = '" .  $_GET['ExamDate'] . "'");
			$mysqli->query("SET @i_ExamSlot   = '" .  $_GET['ExamSlot'] . "'");
			$result1 = $mysqli->query("CALL SP_SAVEPEONPREF(@i_PeonId,@i_ExamId,@i_ExamDate,@i_ExamSlot)");
			while( $row = $result1->fetch_assoc() ) {
				extract($row);
				If($SAVESTATUS == 0)
					{
						echo "<script type='text/javascript'>window.onload = function()
						{
							document.getElementById('lblFailure').style.display = 'block';
						}
						</script>";
							header('Location: PeonPrefMain.php?'); 
					}
					else
					{
						if(isset($_GET['screen']) == 'unassigned')
						{
							header("Location: unassignedPeonblock2Main.php?PeonID={$_GET['PeonID']}&PeonName={$_GET['PeonName']}"); 
						}
						else
						{
							header('Location: PeonPrefMain.php?'); 
						}
					}
			}
	}

?>

<form >
	<h3 class="page-title" style="margin-left:5%">Peon Maintenance</h3>
	</form>

