<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Junior Sup Report All Duties</title>
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
		<td colspan='7' class='th-heading'><center>Junior Supervisor All Duty Report - <?php if(!isset($_SESSION)){ session_start(); } echo $_SESSION["SESSSelectedExamName"];?></center></td>
	</TR>
	</table>
	<br/><br/>
	
<table width="90%" border="0" cellpadding="5" cellspacing="0" class="fix-table" style="margin-left: 5%;">
	<tr class="th">
		<td rowspan="2" width="15%">Name of Jr. Sup</td>
		<td rowspan="2" width="15%">Contact No.</td>
		<td rowspan="2" width="15%">Date</td>
		<td rowspan="2" width="10%">Slot</td>
		<td colspan="2" width="20%"><center>No. of Duties</center></td>
		<td rowspan="2" width="15%">Bank Account No.</td>
		<td rowspan="2" width="10%">Sign</td>
	</tr>
	<tr>
	<td class="th">2 hr</td>
	<td class="th">2.5 to 3 hr</td>
	</tr>
	<?php
	if(!isset($_SESSION)){
		session_start();
	} 
		include 'db/db_connect.php';
		
				$sql = "SELECT CONCAT(coalesce(u.FirstName,''),' ',coalesce(u.FatherName,''),' ',coalesce(u.LastName,'')) AS ABC,u.ContactNumber,
							DATE_FORMAT(STR_TO_DATE(ExamDate,'%m/%d/%Y'), '%d %M %Y') AS ExamDate,ExamSlot,
							sum(case when timeto-timefrom = 2 then 1 else 0 end) as twohours,
							sum(case when timeto-timefrom <> 2 then 1 else 0 end) as otherhours
							FROM tblexamblock eb 
							INNER JOIN tbluser u ON u.userid = eb.ProfID
							INNER JOIN tblexamschedule es 
							ON es.ExamSchID = eb.ExamSchID 
							WHERE ProfID IS NOT NULL and ExamID = " . $_SESSION['SESSSelectedExam'] . "
							GROUP BY CONCAT(coalesce(u.FirstName,''),' ',coalesce(u.FatherName,''),' ',coalesce(u.LastName,'')),ExamDate,ExamSlot,u.ContactNumber
							ORDER BY CONCAT(coalesce(u.FirstName,''),' ',coalesce(u.FatherName,''),' ',coalesce(u.LastName,'')),examDATE,ExamSlot";
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
					echo "<td>{$ABC} </td>";
					echo "<td>{$ContactNumber} </td>";
					echo "<td>{$ExamDate} </td>";
					echo "<td>{$ExamSlot} </td>";
					echo "<td>{$twohours} </td>";
					echo "<td>{$otherhours} </td>";
					echo "<td></td>";
					echo "<td></td>";
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
