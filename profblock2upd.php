<?php
//include database connection
		if(!isset($_SESSION)){
			session_start();
		}
	include 'db/db_connect.php';
$Slot = '';
if ($_SESSION["SESSSelectedExamType"] == 'Online') {
						$pos = strpos($_GET['BlockName'], '@');
						//$Slot = substr($_GET['BlockName'], $pos+1);
						$Slot = $_GET['ExamSlot'];
}
else
{
						$Slot = $_GET['ExamSlot'];
}

	
	if ($_GET['IUD'] == 'D') 
	{
			//if this is a REL or CC..then delete!
			if(($_GET['BlockID'] == "1000") or ($_GET['BlockID'] == "2000"))
			{
				$sql = "delete from tblrelccduties where ProfID = ? and  
						Duty = ? AND ExamSchID IN (SELECT ExamSchID FROM tblexamschedule
						WHERE ExamID = ? AND ExamDate = ? AND ExamSlot = ?);";
				$stmt = $mysqli->prepare($sql);
				$stmt->bind_param('isiss', $_GET['ProfID'],$_GET['BlockName'], $_SESSION["SESSSelectedExam"], $_GET['ExamDate'], $Slot);
				if($stmt->execute()){
							header("Location: profblock2Main.php?BlockID={$_GET['BlockID']}&BlockName={$_GET['BlockName']}&ExamDate={$_GET['ExamDate']}&ExamSlot={$_GET['ExamSlot']}"); 
				} else{
					 echo $mysqli->error;
					//die("Unable to update.");
				}
			}
			else
			{
				$sql = "UPDATE tblexamblock SET ProfID = NULL 
							WHERE BlockID = ? AND ExamSchID IN (SELECT ExamSchID FROM tblexamschedule
							WHERE ExamID = ? AND ExamDate = ? AND ExamSlot = ?);";
					$stmt = $mysqli->prepare($sql);
					$stmt->bind_param('iiss', $_GET['BlockID'], $_SESSION["SESSSelectedExam"], $_GET['ExamDate'], $Slot);
					if($stmt->execute()){
								header("Location: profblock2Main.php?BlockID={$_GET['BlockID']}&BlockName={$_GET['BlockName']}&ExamDate={$_GET['ExamDate']}&ExamSlot={$_GET['ExamSlot']}"); 
					} else{
						 echo $mysqli->error;
						//die("Unable to update.");
					}
			}
	}
	else 
	{
		if(($_GET['BlockID'] == "1000") or ($_GET['BlockID'] == "2000"))
		{

				$sql = "delete from tblrelccduties where ProfID = ? and  
						Duty = ? AND ExamSchID IN (SELECT ExamSchID FROM tblexamschedule
						WHERE ExamID = ? AND ExamDate = ? AND ExamSlot = ?);";
				$stmt = $mysqli->prepare($sql);
				$stmt->bind_param('isiss', $_GET['ProfID'],$_GET['BlockName'], $_SESSION["SESSSelectedExam"], $_GET['ExamDate'], $Slot);
				if($stmt->execute()){
							//header("Location: profblock2Main.php?BlockID={$_GET['BlockID']}&BlockName={$_GET['BlockName']}&ExamDate={$_GET['ExamDate']}&ExamSlot={$_GET['ExamSlot']}"); 
				} else{
					 echo $mysqli->error;
					//die("Unable to update.");
				}
				$sql = "INSERT INTO tblrelccduties(ExamSchID,ProfID,Duty) 
						SELECT ExamSchID," . $_GET['ProfID'] . ",'" . $_GET['BlockName'] . "' 
						 FROM tblexamschedule WHERE ExamID = ".$_SESSION["SESSSelectedExam"]." 
						 AND ExamDate = '".$_GET['ExamDate']."' AND ExamSlot = '". $Slot ."' limit 1;";
				 $stmt = $mysqli->prepare($sql);
				 //echo $sql;
				 //die;
				$stmt->bind_param('isiss', $_GET['ProfID'],$_GET['BlockName'], $_SESSION["SESSSelectedExam"], $_GET['ExamDate'], $Slot);
				if($stmt->execute()){
							header("Location: profblock2Main.php?BlockID={$_GET['BlockID']}&BlockName={$_GET['BlockName']}&ExamDate={$_GET['ExamDate']}&ExamSlot={$_GET['ExamSlot']}"); 
				} else{
					 echo $mysqli->error;
					//die("Unable to update.");
				}
		}
		else
		{
				$sql = "UPDATE tblexamblock SET ProfID = ? 
					WHERE BlockID = ? AND ExamSchID IN (SELECT ExamSchID FROM tblexamschedule
					WHERE ExamID = ? AND ExamDate = ? AND ExamSlot = ?);";
			$stmt = $mysqli->prepare($sql);
			$stmt->bind_param('iiiss', $_GET['ProfID'], $_GET['BlockID'], $_SESSION["SESSSelectedExam"], $_GET['ExamDate'], $Slot);
			if($stmt->execute()){
						header("Location: profblock2Main.php?BlockID={$_GET['BlockID']}&BlockName={$_GET['BlockName']}&ExamDate={$_GET['ExamDate']}&ExamSlot={$_GET['ExamSlot']}"); 
			} else{
				 echo $mysqli->error;
				//die("Unable to update.");
			}
		}
	}
?>

<form >
	<h3 class="page-title" style="margin-left:5%">Prof Block Maintenance</h3>
	</form>

