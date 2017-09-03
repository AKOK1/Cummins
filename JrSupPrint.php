<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Junior Supervisor Duties</title>
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
	<table width="90%" cellpadding="5" cellspacing="0" class="fix-table" style="margin-left: 5%;">
	  
	<?php
		if(!isset($_SESSION)){
		session_start();
	} 
		include 'db/db_connect.php';
		$sql = "SELECT TimeFrom, TimeTo, DATE_FORMAT(STR_TO_DATE(ExamDate,'%m/%d/%Y'), '%d %M %Y') AS ExamDateT, ExamName, 				
				SUBSTRING(EnggYear,1,2) AS EnggYear
				FROM tblexamschedule ES
				INNER JOIN tblexammaster EM ON EM.ExamId = ES.ExamId
				INNER JOIN tblpapermaster PM ON PM.PaperID = ES.PaperID 
				WHERE ES.ExamDate = '". $_GET['ExamDate'] ."'  AND ES.ExamSlot = '". $_GET['ExamSlot'] ."'  
				AND ES.ExamID = " . $_SESSION["SESSSelectedExam"]. " LIMIT 1";
			
			//echo $sql;
			// execute the sql query
			$result = $mysqli->query( $sql );
					echo $mysqli->error;

			$num_results = $result->num_rows;

			if( $num_results ){
				while( $row = $result->fetch_assoc() ){
					extract($row);
					echo "<TR>";
					echo "<td colspan='7' class='th-heading'><center>JUNIOR SUPERVISOR DUTIES FOR: {$ExamName} </center></td>";
					echo "</TR>";
					echo "<TR>";
					echo "<td colspan='7'><center><b>EXAMINATION:</b>{$EnggYear} </center></td>";
					echo "</TR>";
					echo "<TR>";
					echo "<td colspan='7'><center style='font-size:14px'><b>DATE: </b>{$ExamDateT}, ".$_GET['ExamSlot']."";
					echo "</TR>";
					
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
		<td width="8%">Sr. No.</td>
		<td width="30%">Name</td>
		<td width="25%">Block No (Total Students)</td>
		<td width="15%">Sign</td>
		<td width="15%">Reporting Time</td>
		<td width="15%">Remark</td>
	</tr>
	<?php
		include 'db/db_connect.php';
		$sql = "SELECT distinct CONCAT(FirstName, ' ', LastName) AS ProfName, Department, ContactNumber, BlockName ,colorder,
				SUM(EB.Allocation) AS Allocation
				FROM tblexamblock EB
				LEFT OUTER JOIN tbluser U ON U.userID = EB.ProfID
				INNER JOIN tblblocksmaster BM ON BM.BlockID = EB.BlockID
				INNER JOIN tblexamschedule ES ON EB.ExamSchID = ES.ExamSchID
				WHERE ES.ExamDate = '". $_GET['ExamDate'] ."'  AND ES.ExamSlot = '". $_GET['ExamSlot'] ."' 
				 and EB.ProfID is not null	 AND ES.ExamID = ".$_SESSION["SESSSelectedExam"]. " 			
				GROUP BY ProfName, Department, ContactNumber, BlockName
				UNION
				SELECT distinct CONCAT(FirstName, ' ', LastName) AS ProfName, Department, 
				ContactNumber, Case Duty When 'RC' then 'RC' Else 'Reliever' End as BlockName,999 as colorder, 0 AS Allocation
				FROM tblrelccduties RELCC
				LEFT OUTER JOIN tbluser U ON U.userID = RELCC.ProfID
				INNER JOIN tblexamschedule ES ON RELCC.ExamSchID = ES.ExamSchID	
				WHERE ES.ExamDate = '". $_GET['ExamDate'] ."'  AND ES.ExamSlot = '". $_GET['ExamSlot'] ."' 
				 AND ES.ExamID = ".$_SESSION["SESSSelectedExam"] ;
				
				if ($_SESSION["SESSSelectedExamType"] ==  'Online') {
					$sql = $sql . " order by ProfName,colorder";
				}
				else {
					$sql = $sql . " order by colorder";
				}
			// execute the sql query
			//echo $sql;
			$result = $mysqli->query( $sql );
			echo $mysqli->error;
			$num_results = $result->num_rows;
			$i = 1;
			//echo $sql;
			if( $num_results ){
				while( $row = $result->fetch_assoc() ){
					extract($row);
					echo "<TR>";
					echo "<td>$i</td>";
					echo "<td>{$ProfName} - {$Department} - {$ContactNumber} </td>";
					echo "<td>{$BlockName} ({$Allocation})</td>";
					echo "<td></td>";
					echo "<td></td>";
					echo "<td></td>";
					echo "</TR>";
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
