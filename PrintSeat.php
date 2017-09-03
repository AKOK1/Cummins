<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>SEATING ARRANGEMENT</title>
<style type="text/css">
body {
	margin-left: 0px;
	margin-top: 0px;
	font-family:Verdana, Geneva, sans-serif;
	font-size: 12px;
	
}
.th-heading {
	font-size:13px;
	font-weight:bold;	
	}
.fix-table, th, td {
	line-height:20px;
	height: 14px;
	border: solid 1px #666 ;
	text-align:left;
	text-indent:10px;
	}
.th {
	font-size:13px;
	font-weight: bold;
	background-color:#CCC;
	}
</style>
</head>

<body>
		<br/>
		<center><img class="center" alt="logo" src="images/logo.png"></center>
		<br/>	<br/>	<br/>
	<table width="90%" cellpadding="5" cellspacing="0" class="fix-table" style="margin-left: 5%;">
	  
	<?php
		if(!isset($_SESSION)){
			session_start();
		} 

		include 'db/db_connect.php';
		  $sql = "SELECT substring(EnggYear,1,2) as EnggYear,EnggPattern, DeptName,SubjectName,ES.ExamDate, ES.TimeFrom, ES.TimeTo, 	
				EM.ExamName, BM.BlockName, DATE_FORMAT(STR_TO_DATE(ExamDate,'%m/%d/%Y'), '%d %M %Y') AS ExamDateT, A.StdID AS StdIDMin, B.StdId AS StdIDMax, EB.Allocation
					FROM  tblexamschedule ES 
				INNER JOIN tblpapermaster PM ON ES.PaperID = PM.PaperID
				INNER JOIN tblsubjectmaster SM ON PM.SubjectID = SM.SubjectID 
				INNER JOIN tbldepartmentmaster DM ON PM.DeptID = DM.DeptID 
				INNER JOIN tblexamblock AS EB ON ES.ExamSchID = EB.ExamSchID
				INNER JOIN tblexammaster EM ON EM.ExamID = ES.ExamID
				INNER JOIN tblblocksmaster BM ON BM.BlockId = EB.BlockId
				INNER JOIN (SELECT CASE WHEN CAST(StdId AS UNSIGNED) = 0 THEN MIN(StdId) ELSE MIN(CAST(StdId AS UNSIGNED)) END AS StdId, EBS.ExamBlockId FROM tblexamblockstudent EBS  WHERE COALESCE(StdID,'') <> '' GROUP BY EBS.ExamBlockId) AS A ON A.ExamBlockId = EB.ExamBlockID
				INNER JOIN (SELECT CASE WHEN CAST(StdId AS UNSIGNED) = 0 THEN MAX(StdId) ELSE MAX(CAST(StdId AS UNSIGNED)) END AS StdId, EBS.ExamBlockId FROM tblexamblockstudent EBS  WHERE COALESCE(StdID,'') <> '' GROUP BY EBS.ExamBlockId) AS B ON B.ExamBlockID = EB.ExamBlockID
				WHERE EB.BlockID = ". $_GET['BlockId'] ." AND ES.ExamDate = '". $_GET['ExDate'] ."'  AND ES.ExamSlot = '". $_GET['ExSlot'] ."'
				 AND ES.ExamId = " . $_SESSION['SESSSelectedExam'] . " 
				ORDER BY EB.ExamBlockID, StdIDMin,PaperCode, EnggPattern, DM.DeptID ";
			
			//echo $sql;
			// execute the sql query
			$result = $mysqli->query( $sql );
					echo $mysqli->error;

			$num_results = $result->num_rows;

			$i = 0;
			if( $num_results ){
				while( $row = $result->fetch_assoc() ){
					extract($row);
					if ($i == 0){
						echo "<TR>";
						echo "<td colspan='5' class='th-heading'>SEATING ARRANGEMENT FOR EXAM: {$ExamName} </td>";
						echo "<td colspan='2' class='th-heading' >{$BlockName} </td>";
						echo "</TR>";
						echo "<TR>";
						echo "<td colspan='7'><b>Date:</b> " . $ExamDateT . ", ". $_GET['ExSlot'] . "</td>";
						echo "</TR>";
						
						echo "<TR><td colspan='7'></td></TR>";
						
						echo "<TR class='th'>";
						echo "<td>Yr. (Pat.)</td>";
						echo "<td>Dept.</td>";
						echo "<td>Subject</td>";
						echo "<td>Time</td>";
						echo "<td>Seat From</td>";
						echo "<td>Seat To</td>";
						echo "<td>Students</td>";
						echo "</TR>";

						echo "<TR>";
						echo "<td>{$EnggYear} ({$EnggPattern})</td>";
						echo "<td>{$DeptName}</td>";
						echo "<td>{$SubjectName}</td>";
						echo "<td>{$TimeFrom} to {$TimeTo}</td>";
						echo "<td>{$StdIDMin}</td>";
						echo "<td>{$StdIDMax}</td>";
						echo "<td>{$Allocation}</td>";
						echo "</TR>";
						
						$i += 1;
					}
					else {
						echo "<TR>";
						echo "<td>{$EnggYear} ({$EnggPattern})</td>";
						echo "<td>{$DeptName}</td>";
						echo "<td>{$SubjectName}</td>";
						echo "<td>{$TimeFrom} to {$TimeTo}</td>";
						echo "<td>{$StdIDMin}</td>";
						echo "<td>{$StdIDMax}</td>";
						echo "<td>{$Allocation}</td>";
						echo "</TR>";					}
				}
			}					
			//disconnect from database
			$result->free();
			$mysqli->close();

	?>
	</tr>

	</table>
	<br/><br/>
	
<table width="90%" border="0" cellpadding="5" cellspacing="0" class="fix-table" style="margin-left: 5%;">
      <tr class="th">
        <td width="20%">Row 1 </td>
        <td width="20%">Row 2</td>
        <td width="20%">Row 3</td>
        <td width="20%">Row 4</td>
        <td width="20%">Row 5</td>
      </tr>
	<?php
		include 'db/db_connect.php';
		//$StdSeat= array(40);
		
		$i = 0;
		//echo $sql;
		for ($i = 0 ; $i <= 40; $i++) {
			$StdSeat[$i] = '';
		}

			
/*		  $sql = "SELECT StdSeat1, StdSeat2, StdSeat3, StdSeat4, StdSeat5 
				FROM  tblexamblockstudent Where ExamBlockID = '" .  $_GET['ExamBlockId1']. "'";
*/
		$sql = "SELECT EBS.ExamBlockID, StdId FROM tblexamblockstudent EBS 
				INNER JOIN tblexamblock EB ON EB.ExamBlockID = EBS.ExamblockID
				INNER JOIN tblexamschedule ES ON ES.ExamSchId = EB.ExamSchID
				WHERE coalesce(StdId,'0') <> '0' and BlockID = ". $_GET['BlockId'] ."  AND ES.ExamDate = '". $_GET['ExDate'] ."'  AND 
				ES.ExamSlot = '". $_GET['ExSlot'] ."'
				AND ES.ExamId = " . $_SESSION['SESSSelectedExam'] . "  AND COALESCE(StdID,'') <> '' 
					ORDER BY EBS.ExamBlockID, ExamBlockStdId ";
			
			//echo $sql;
			// execute the sql query
			$result = $mysqli->query( $sql );
			echo $mysqli->error;
			$num_results = $result->num_rows;
			
			$i = 0;
			//echo $sql;
			if( $num_results ){
				while( $row = $result->fetch_assoc() ){
					extract($row);
					$StdSeat[$i] = $StdId;
					$i += 1;
				}
			}					

			echo "<TR>";
			echo "<td >{$StdSeat[0]} </td><td>{$StdSeat[15]} </td><td>{$StdSeat[16]} </td><td>{$StdSeat[31]} </td><td>{$StdSeat[32]}</td>";
			echo "<TR><td>{$StdSeat[1]} </td><td>{$StdSeat[14]} </td><td>{$StdSeat[17]} </td><td>{$StdSeat[30]} </td><td>{$StdSeat[33]}</td>";
			echo "<TR><td>{$StdSeat[2]} </td><td>{$StdSeat[13]} </td><td>{$StdSeat[18]} </td><td>{$StdSeat[29]} </td><td>{$StdSeat[34]}</td>";
			echo "<TR><td>{$StdSeat[3]} </td><td>{$StdSeat[12]} </td><td>{$StdSeat[19]} </td><td>{$StdSeat[28]} </td><td>{$StdSeat[35]}</td>";
			echo "<TR><td>{$StdSeat[4]} </td><td>{$StdSeat[11]} </td><td>{$StdSeat[20]} </td><td>{$StdSeat[27]} </td><td>{$StdSeat[36]}</td>";
			echo "<TR><td>{$StdSeat[5]} </td><td>{$StdSeat[10]} </td><td>{$StdSeat[21]} </td><td>{$StdSeat[26]} </td><td>{$StdSeat[37]}</td>";
			echo "<TR><td>{$StdSeat[6]} </td><td>{$StdSeat[9]} </td><td>{$StdSeat[22]} </td><td>{$StdSeat[25]} </td><td>{$StdSeat[38]}</td>";
			echo "<TR><td>{$StdSeat[7]} </td><td>{$StdSeat[8]} </td><td>{$StdSeat[23]} </td><td>{$StdSeat[24]} </td><td>{$StdSeat[39]}</td>";
			echo "</TR>";
			echo "<tr>";
			echo "<td colspan='5'><b>Total No. of Students = " .$i ."</b></td>";
			echo "</tr>";
			//disconnect from database	
			$result->free();
			$mysqli->close();
	?>

    </table></td>
  </tr>
</table>
</body>
</html>
