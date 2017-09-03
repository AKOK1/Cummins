<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>SEATING ARRANGEMENT</title>
<style type="text/css">
body {
	margin-left: 0px;
	margin-top: 0px;
	font-family: Verdana, Geneva, sans-serif;
	font-size: 12px;
	
}
.th-heading {
	font-size:13px;
	font-weight: bold;	
	}
.fix-table, th, td {
	line-height:20px;
	height: 14px;
	border: solid 1px #666 ;
	text-align: left;
	}
.th {
	font-size: 13px;
	font-weight: bold;
	background-color: #CCC;
	}
</style>
</head>

<body>
<?php
	if(!isset($_SESSION)){
		session_start();
	}
?>
	<br/>
	<center><img class="center" alt="logo" src="images/logo.png"></center>
	<br/>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td><table width="100%" cellpadding="5" cellspacing="0" class="fix-table" >
      <tr>
        <td colspan="9" class="th-heading">
	<?php
		include 'db/db_connect.php';
		  $sql = "SELECT ExamName, DATE_FORMAT(STR_TO_DATE(ExamDate,'%m/%d/%Y'), '%d %M %Y') AS ExamDateT,DAYNAME(ExamDate) as exday
				FROM tblexammaster EM
					INNER JOIN (SELECT DISTINCT ExamID, ExamDate, ExamSlot 
								FROM tblexamschedule 
								WHERE ExamID = " . $_SESSION["SESSSelectedExam"] ." and ExamDate = '" . $_GET['ExamDate'] . "' 
								AND ExamSlot = '" . $_GET['ExamSlot'] . "') AS ES
					ON ES.ExamID = EM.ExamID"; 
			//echo $sql;
			// execute the sql query
			$result = $mysqli->query( $sql );
				echo $mysqli->error;
			$num_results = $result->num_rows;

			if( $num_results ){
				while( $row = $result->fetch_assoc() ){
					extract($row);
					echo "<h2><p align='center'>SEATING ARRANGEMENT FOR EXAM: {$ExamName}</p></h2>";
				}
			}					
			//disconnect from database
			$result->free();
			$mysqli->close();
			echo "</td>";
			echo "</tr>";
			echo "<tr>";
			echo "<td colspan='9'><h2><center><b>{$ExamDateT}, ".$_GET['ExamSlot']."</b></center></h2>";
			//if ($_SESSION["SESSSelectedExamType"] == 'Online') {
			//	echo "<h2><center><b style='color:red'>Report in Mech Auditorium, 30 Minutes before your timing, for university attendance.</b></center></h2>";
			//}
			echo "</td>";
			echo "</tr>";
	?>
      <tr>
        <td colspan="9">&nbsp;</td>
      </tr>
      <tr class="th">
        <td rowspan="2">Year</td>
        <td rowspan="2">Dept.</td>
        <td rowspan="2">Pattern</td>
        <td rowspan="2">Subject</td>
        <td rowspan="2">Time From - To</td>
        <td rowspan="2">Block</td>
        <td rowspan="2">Students</td>
        <td colspan="2"><center>Exam Seat No</center></td>
      </tr>
      <tr>
        <td class="th">From</td>
        <td class="th">To</td>
      </tr>

		<?php
			include 'db/db_connect.php';
			if ($_SESSION["SESSSelectedExamType"] == 'Online') {
			  $sql = "SELECT EnggYear,EnggPattern, DeptName,SubjectName, SUBSTRING(BlockName,LOCATE('@',BlockName)+1) as TimeFromTo,  SUBSTRING(BlockName, 1, LOCATE('@',BlockName)-1) as BlockName, coalesce(EB.Allocation,Students) as Allocation
					, A.StdID AS StdIDMin, B.StdId AS StdIDMax
					FROM  tblexamschedule ES 
					INNER JOIN tblpapermaster PM ON ES.paperid = PM.paperid 
					INNER JOIN tblsubjectmaster SM ON PM.SubjectID = SM.SubjectID 
					INNER JOIN tbldepartmentmaster DM ON PM.DeptID = DM.DeptID 
					LEFT OUTER JOIN tblexamblock EB ON ES.ExamSchID = EB.ExamSchID
					INNER JOIN tblexammaster EM ON EM.ExamID = ES.ExamID
					LEFT OUTER JOIN tblblocksmaster BM ON BM.BlockId = EB.BlockId
					LEFT JOIN (SELECT CASE WHEN CAST(StdId AS UNSIGNED) = 0 THEN MIN(StdId) ELSE MIN(CAST(StdId AS UNSIGNED)) END AS StdId, EBS.ExamBlockId FROM tblexamblockstudent EBS WHERE StdId <> '' GROUP BY EBS.ExamBlockId) AS A ON A.ExamBlockID = EB.ExamBlockID
					LEFT JOIN (SELECT CASE WHEN CAST(StdId AS UNSIGNED) = 0 THEN MAX(StdId) ELSE MAX(CAST(StdId AS UNSIGNED)) END AS StdId, EBS.ExamBlockId FROM tblexamblockstudent EBS WHERE StdId <> '' GROUP BY EBS.ExamBlockId) AS B ON B.ExamBlockID = EB.ExamBlockID
					WHERE ES.ExamSlot = '" . $_GET['ExamSlot'] . "' 
					AND ES.ExamDate = '". $_GET['ExamDate'] . "'
					AND ES.ExamID = " . $_SESSION["SESSSelectedExam"] ."
					AND coalesce(EB.Allocation,Students) <> 0
					ORDER BY BM.colorder "; 
			}
			Else {
			  $sql = "SELECT EnggYear,EnggPattern, DeptName,SubjectName,ES.TimeFrom, ES.TimeTo, BM.BlockName, coalesce(EB.Allocation,Students) as Allocation
					, A.StdID AS StdIDMin, B.StdId AS StdIDMax
					FROM  tblexamschedule ES 
					INNER JOIN tblpapermaster PM ON ES.paperid = PM.paperid 
					INNER JOIN tblsubjectmaster SM ON PM.SubjectID = SM.SubjectID 
					INNER JOIN tbldepartmentmaster DM ON PM.DeptID = DM.DeptID 
					LEFT OUTER JOIN tblexamblock EB ON ES.ExamSchID = EB.ExamSchID
					INNER JOIN tblexammaster EM ON EM.ExamID = ES.ExamID
					LEFT OUTER JOIN tblblocksmaster BM ON BM.BlockId = EB.BlockId
					LEFT JOIN (SELECT CASE WHEN CAST(StdId AS UNSIGNED) = 0 THEN MIN(StdId) ELSE MIN(CAST(StdId AS UNSIGNED)) END AS StdId, EBS.ExamBlockId FROM tblexamblockstudent EBS WHERE StdId <> '' GROUP BY EBS.ExamBlockId) AS A ON A.ExamBlockID = EB.ExamBlockID
					LEFT JOIN (SELECT CASE WHEN CAST(StdId AS UNSIGNED) = 0 THEN MAX(StdId) ELSE MAX(CAST(StdId AS UNSIGNED)) END AS StdId, EBS.ExamBlockId FROM tblexamblockstudent EBS WHERE StdId <> '' GROUP BY EBS.ExamBlockId) AS B ON B.ExamBlockID = EB.ExamBlockID
					WHERE ES.ExamSlot = '" . $_GET['ExamSlot'] . "' 
					AND ES.ExamDate = '". $_GET['ExamDate'] . "'
					AND ES.ExamID = " . $_SESSION["SESSSelectedExam"] ."
					AND coalesce(EB.Allocation,Students) <> 0
					ORDER BY DM.orderno, EnggYear, EnggPattern, DeptName, SubjectName, EB.ExamBlockID "; 
			}
				//echo $sql;
				// execute the sql query
				$result = $mysqli->query( $sql );
				echo $mysqli->error;
				$num_results = $result->num_rows;
				$i = 1;
				if( $num_results ){
					while( $row = $result->fetch_assoc() ){
						extract($row);
						echo "<TR>";
							echo "<td>{$EnggYear}</td>";
							echo "<td>{$DeptName}</td>";
							echo "<td>{$EnggPattern}</td>";
							echo "<td>{$SubjectName}</td>";
							if ($_SESSION["SESSSelectedExamType"] == 'Online') {
								echo "<td>{$TimeFromTo}</td>";
							}
							Else {
								echo "<td>{$TimeFrom} to {$TimeTo}</td>";
							}
							echo "<td>{$BlockName}</td>";
							echo "<td>{$Allocation}</td>";
							echo "<td>{$StdIDMin}</td>";
							echo "<td>{$StdIDMax}</td>";
						echo "</tr>";
						$i += 1;
					}
				}					
				//disconnect from database
				$result->free();
				$mysqli->close();
		?>	  
	  
	  
	  
	  
    </table></td>
  </tr>
</table>
</body>
</html>
