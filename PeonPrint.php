<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Peon Duties</title>
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
		<br/>	<br/>	<br/>
	<table width="90%" cellpadding="5" cellspacing="0" class="fix-table" style="margin-left: 5%;">
	<TR><td colspan='6' class='th-heading'><center>SAVITRIBAI PHULE PUNE UNIVERSITY</center></td></TR>
	<TR><td colspan='6' class='th-heading'><center>CENTRE: CUMMINS COLLEGE OF ENGG. FOR WOMEN, PUNE (20)</center></td></TR>
	  
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
				WHERE ES.ExamId = " . $_SESSION["SESSSelectedExam"] . " 
				AND ES.ExamDate = '". $_GET['ExamDate'] ."'  AND ES.ExamSlot = '". $_GET['ExamSlot'] ."' LIMIT 1";
			
			//echo $sql;
			// execute the sql query
			$result = $mysqli->query( $sql );
					echo $mysqli->error;

			$num_results = $result->num_rows;

			if( $num_results ){
				while( $row = $result->fetch_assoc() ){
					extract($row);
					echo "<TR>";
					echo "<td colspan='7' class='th-heading'>{$ExamName} </td>";
					echo "</TR>";
					echo "<TR>";
					echo "<td colspan='7'><b>EXAMINATION:</b> {$EnggYear} </td>";
					echo "</TR>";
					echo "<TR>";
					echo "<td colspan='4'><b>DATE:</b> {$ExamDateT} </td>";
					echo "<td colspan='4'><b>SLOT:</b>  ". $_GET['ExamSlot'] . "</td>";
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
	<TR>
		<td colspan='7' class='th-heading'><center>PEON DUTIES</center></td>
	</TR>
	<tr class="th">
		<td width="8%">Sr. No.</td>
		<td width="40%">Name</td>
		<td width="15%">Sign</td>
		<td width="15%">Reporting Time</td>
		<td width="15%">Remark</td>
	</tr>
	<?php
		include 'db/db_connect.php';
		$sql = "SELECT distinct CONCAT(FirstName, ' ', LastName) AS ProfName, Department, ContactNumber
				FROM tblpeonpref PF
				LEFT OUTER JOIN tbluser U ON U.userID = PF.PeonID
				WHERE PF.ExamId = " . $_SESSION["SESSSelectedExam"] . 
				" AND ExamDate = '". $_GET['ExamDate'] ."'  AND ExamSlot = '". $_GET['ExamSlot'] ."' ";
			//echo $sql;		
			// execute the sql query
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
