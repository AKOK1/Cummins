<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Senior Supervisor Report</title>
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
<?php
		if(!isset($_SESSION)){
			session_start();
		}
?>		
	<table width="90%" cellpadding="5" cellspacing="0" class="fix-table" style="margin-left: 5%;">
	<TR><td colspan='7' class='th-heading'><center>SAVITRIBAI PHULE PUNE UNIVERSITY</center></td>
	<td><h2 align="right">CENTER CODE</h2></td>
	</TR>
	<TR><td colspan='7' class='th-heading'><center>SENIOR SUPERVISOR'S REPORT</center></td>
	<td><h2 align="right">4020</h2></td>
	</TR>
	<TR><td colspan='7' class='th-heading'><center>CENTRE: CUMMINS COLLEGE OF ENGG. FOR WOMEN, PUNE (4020)</center></td>
	<td rowspan="3">
	     <div style="float:right">
		 <img alt="logo" src="images/srsuplogo.jpg">
		</div>
	</td>
	</TR>
	  
	<?php
		include 'db/db_connect.php';
		$sql = "SELECT TimeFrom, TimeTo, DATE_FORMAT(STR_TO_DATE(ExamDate,'%m/%d/%Y'), '%d %M %Y') AS ExamDateT, ExamName, 				
				SUBSTRING(EnggYear,1,2) AS EnggYear
				FROM tblexamschedule ES
				INNER JOIN tblexammaster EM ON EM.ExamId = ES.ExamId
				INNER JOIN tblpapermaster PM ON PM.PaperID = ES.PaperID 
				WHERE ES.ExamDate = '". $_GET['ExDate'] ."'  AND ES.ExamSlot = '". $_GET['ExSlot'] ."' LIMIT 1";
			
			//echo $sql;
			// execute the sql query
			$result = $mysqli->query( $sql );
					echo $mysqli->error;

			$num_results = $result->num_rows;

			if( $num_results ){
				while( $row = $result->fetch_assoc() ){
					extract($row);
					echo "<TR>";
					echo "<td><b>DATE: </b>{$ExamDateT} " . $_GET['ExSlot'] . "</td>";
					echo "<td><right><b>EXAMINATION: </b> {$EnggYear}</right> </td>";
					echo "</TR>";
				
				}
			}					
			//disconnect from database
			$result->free();
			$mysqli->close();

			echo"<tr><td colspan='2' class='th-heading'><left>COURSE: ". $_GET['Pattern'] . "</left></td></tr>";

	?>
	</tr>

	</table>
	<br/><br/>
	
<table width="90%" border="0" cellpadding="5" cellspacing="0" class="fix-table" style="margin-left: 5%;">
	<tr class="th">
		<td rowspan="2" width="8%">Sr. No.</td>
		<td rowspan="2" width="15%">BRANCH</td>
		<td rowspan="2" width="25%">Full Name of Subject</td>
		<td rowspan="2" width="15%">Block No.</td>
		<td width="22%" colspan="2">Number of Candidates Present</td>
		<td rowspan="2" width="12%">Total Papers</td>
	</tr>
	<tr >
		<td class="th">Section - I</td>
		<td class="th">Section - II</td>
	</tr>
	<?php
		include 'db/db_connect.php';
		$sql = "SELECT Distinct DM.DeptName, SM.SubjectName, SUBSTRING_INDEX(BM.BlockName,'-',1) as BlockName  ,BM.BlockNo
				FROM tblexamschedule ES
				INNER JOIN tblpapermaster PM ON ES.PaperID = PM.PaperID
				INNER JOIN tblsubjectmaster SM ON PM.SubjectID = SM.SubjectID
				INNER JOIN tbldepartmentmaster DM ON PM.DeptID = DM.DeptID
				LEFT OUTER JOIN tblexamblock EB ON EB.ExamSchID = ES.ExamSchID
				INNER JOIN tblblocksmaster BM ON BM.BlockID = EB.BlockID
				WHERE ExamDate = '". $_GET['ExDate'] ."' 
				AND ExamSlot = '". $_GET['ExSlot'] ."' AND ExamID = ". $_SESSION["SESSSelectedExam"] . "
				 AND PM.EnggPattern = ". $_GET['Pattern']  . " ORDER BY CAST(BM.BlockNo AS UNSIGNED)";
			
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
					echo "<td>{$DeptName} </td>";
					echo "<td>{$SubjectName}</td>";
					echo "<td>{$BlockName}</td>";
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

<br/><br/><br/><br/>
<table width="90%" border="0" cellpadding="5" cellspacing="0" class="fix-table" style="margin-left: 5%;">
	<tr>
		<td>INTERNAL SENIOR SUPERVISOR</td>
		<td>EXTERNAL SENIOR SUPERVISOR</td>
	</tr>
</table>

</body>
</html>
