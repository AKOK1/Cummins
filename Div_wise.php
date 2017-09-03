<?php

		include 'db/db_connect.php';
	$sql= "SELECT examname 
			FROM vwstdresultm SM
			INNER JOIN tblstdresult SR ON SM.StdResMID = SR.StdResMID
			INNER JOIN tblresultfile rf ON rf.ResFileID = SM.ResFileID
			INNER JOIN tblexammaster EM ON EM.ExamID = rf.ExamID
			INNER JOIN tbldepartmentmaster DM ON DM.DeptID = SM.CDept
			WHERE Pattern = '" . $_GET['pattern'] . "'
			AND EduYearFr = substring('" . $_GET['year'] . "',1,LOCATE('-', '" . $_GET['year'] . "') - 1)
			AND  EduYearTo = substring('" . $_GET['year'] . "',LOCATE('-', '" . $_GET['year'] . "') + 1) 
			AND EduYear = '" . $_GET['eduyear'] . "' AND DeptName = '" . $_GET['dept'] . "'
			AND SM.Sem = '" . $_GET['sem'] . "'
			Limit 1";
		$result = $mysqli->query( $sql );
		//echo $sql;
		$num_results = $result->num_rows;
			if( $num_results ){
				while( $row = $result->fetch_assoc() ){
						extract($row);
						$selexamname = $examname;
				}
			}
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Div-Wise 1</title>
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
	<br/>
	<center><img class="center" alt="logo" src="images/logo.png"></center>
	<br/>
	<table width="90%" border="0" cellpadding="5" cellspacing="0" class="fix-table" style="margin-left: 5%;">
	<TR><td colspan='8' class='th-heading'><center><h2>Division-wise Result for Exam: <?php echo $selexamname; ?> (Top 20 Students)</h2></center></td></TR>
	<TR><td colspan='9' class='th-heading'><center><h2>Academic Year: <?php echo $_GET['year']; ?></h2></center></td></TR>

	<TR>
		<td colspan='7' class='th-heading'>
		Department: <?php echo $_GET['dept'];?>,&nbsp;
		Year: <?php echo $_GET['year']; ?>,&nbsp;
		Education Year: <?php echo $_GET['eduyear'];?>,&nbsp;
		Pattern: <?php echo $_GET['pattern']; ?>,&nbsp;
		Semetser: <?php echo $_GET['sem']; ?>,&nbsp;
		Division: <?php echo $_GET['div']; ?><center></center></td>
		
	</TR>
	<TR>
	</TR>
	<tr class="th">
		<td>Rank</td>
		<td>CNUM</td>
		<td>Name</td>
		<td>Department</td>
		<td>Marks Obtained</td>
		<td>Class</td>
		<td>Percentage</td>
</tr>
<?php
$i=0;
$prevmarks='';
	include 'db/db_connect.php';
		$sql="SELECT COALESCE(CNUM, SM.UniPRN) AS CNUM, CONCAT(FirstName, ' ', FatherName, ' ', Surname) AS NAME , DM.DeptName,
			  CONVERT(TotalLine, UNSIGNED INTEGER) AS MksObtInt,
			  SUBSTRING(BLine, LOCATE(':', BLine) + 2) AS Class,  
			  CONVERT(100 * CONVERT(TotalLine, UNSIGNED  INTEGER) /
			  case when '" . $_GET['sem'] . "' = '1' Then 750 else 1500 end, UNSIGNED  INTEGER)
			  AS TotalPer
			  FROM vwstdresultm SM
			  INNER JOIN tbldepartmentmaster DM ON DM.DeptID = SM.CDept
			  LEFT OUTER JOIN tblstudent S ON SM.UniPRN = S.uniprn
			  LEFT OUTER JOIN tblstdadm sa ON S.StdId = sa.StdID
			  WHERE `Div` = '".  $_GET['div'] .  "'
			  AND Pattern = ". $_GET['pattern'] .  "
			  AND SM.EduYearFr = ". substr($_GET['year'],0,4) .  " 
			  AND  SM.EduYearTo = ". substr($_GET['year'],5,4) .  " 
			  AND sa.EduYearFrom = ". substr($_GET['year'],0,4) .  " 
			  AND  sa.EduYearTo = ". substr($_GET['year'],5,4) .  " 
			  AND sa.stdstatus = 'R' AND REPLACE(sa.Year, '.', '') = '". $_GET['eduyear'] .  "'
			  AND EduYear = '". $_GET['eduyear'] .  "'
			  AND DeptName = '". $_GET['dept'] .  "'
			AND SM.Sem = '" . $_GET['sem'] . "'
			  ORDER BY CONVERT(TotalLine,UNSIGNED INTEGER) DESC ";
			//echo $sql;
			$result = $mysqli->query( $sql );
			echo $mysqli->error;
			$num_results = $result->num_rows;
			
			//echo $sql;
			if( $num_results ){
				while( $row = $result->fetch_assoc() ){
					extract($row);
					if($prevmarks == $MksObtInt) {
						//do nothing	
					}	
					else {
						$i += 1;
					}
					If ($i == 21) {
						break;
					}
					$prevmarks = $MksObtInt;
					echo "<TR>";
					echo "<td>$i</td>";
					echo "<td>{$CNUM}</td>";
					echo "<td>{$NAME} </td>";
					echo "<td>{$DeptName} </td>";
					echo "<td>{$MksObtInt} </td>";
					echo "<td>{$Class} </td>";
					echo "<td>{$TotalPer} </td>";
					echo "</TR>";
				}
			}					

			//disconnect from database	
			$result->free();
			$mysqli->close();
?>
	</table>
  

</body>
</html>
