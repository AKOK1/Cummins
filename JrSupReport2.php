<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Junior Sup Report Slot-wise</title>
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
	<br/>
	<table width="90%" cellpadding="5" cellspacing="0" class="fix-table" style="margin-left: 5%;">
	<TR>
		<td colspan='7' class='th-heading'><center>Supervision Duty Report - <?php if(!isset($_SESSION)){ session_start(); } echo $_SESSION["SESSSelectedExamName"];?></center></td>
	</TR>
	</table>
	<br/><br/>
	
<table width="90%" border="0" cellpadding="5" cellspacing="0" class="fix-table" style="margin-left: 5%;">
	<tr class="th">
		<td width="8%">Day</td>
		<td width="12%">Date</td>
		<td width="8%">Slot</td>
		<td width="12%">No. of Blocks</td>
		<td width="12%">Jr. Sup</td>
		<td width="12%">RC</td>
		<td width="12%">REL</td>
		<td width="12%">2 hr</td>
		<td width="12%">2.5 to 3 hr</td>
	</tr>
	<?php
	if(!isset($_SESSION)){
		session_start();
	} 
		include 'db/db_connect.php';
		
				$sql = "SELECT DAYNAME(STR_TO_DATE(ebc.ExamDate,'%m/%d/%Y')) as dayname,ebc.examid,DATE_FORMAT(STR_TO_DATE(ebc.ExamDate,'%m/%d/%Y'), '%d %M %Y') AS ExamDate,ebc.ExamSlot,blocks,supcount,cccount,relcount,twohrsduties,otherhrsduties
				FROM tblexamblockcount ebc
				LEFT JOIN (SELECT ExamDate,ExamSlot,ExamID,COUNT(distinct ProfID)  AS twohrsduties
						FROM tblexamblock eb INNER JOIN tblexamschedule es ON es.ExamSchID = eb.ExamSchID
						WHERE ProfID IS NOT NULL AND timeto-timefrom = 2 
						GROUP BY ExamDate,ExamSlot,ExamID) TWOHRS
						ON TWOHRS.examid = ebc.examid AND TWOHRS.ExamDate = ebc.ExamDate AND TWOHRS.ExamSlot = ebc.ExamSlot
				LEFT JOIN (SELECT ExamDate,ExamSlot,ExamID,COUNT(distinct ProfID)  AS otherhrsduties
						FROM tblexamblock eb INNER JOIN tblexamschedule es ON es.ExamSchID = eb.ExamSchID
						WHERE ProfID IS NOT NULL AND timeto-timefrom <> 2 
						GROUP BY ExamDate,ExamSlot,ExamID) OTHERHRS
						ON OTHERHRS.examid = ebc.examid AND OTHERHRS.ExamDate = ebc.ExamDate AND OTHERHRS.ExamSlot = ebc.ExamSlot
				where blocks <> 0 AND ebc.examid =  " . $_SESSION['SESSSelectedExam'] . "
				Order by ebc.ExamDate,ebc.ExamSlot";
			//twohrsduties is not null and otherhrsduties is not null
			// execute the sql query
			//echo $sql;
			$result = $mysqli->query( $sql );
			echo $mysqli->error;
			$num_results = $result->num_rows;
			//echo $sql;
			if( $num_results ){
				while( $row = $result->fetch_assoc() ){
					extract($row);
					echo "<TR>";
					echo "<td>{$dayname} </td>";
					echo "<td>{$ExamDate} </td>";
					echo "<td>{$ExamSlot} </td>";
					echo "<td>{$blocks} </td>";
					echo "<td>{$supcount} </td>";
					echo "<td>{$cccount} </td>";
					echo "<td>{$relcount} </td>";
					echo "<td>{$twohrsduties} </td>";
					echo "<td>{$otherhrsduties} </td>";
					echo "</TR>";
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
