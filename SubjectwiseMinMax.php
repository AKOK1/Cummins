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
<title>Dept-Wise 1</title>
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
	<TR><td colspan='8' class='th-heading'><center><h2>Subject-wise Result for Exam: <?php echo $selexamname; ?></h2></center></td></TR>
	<TR><td colspan='8' class='th-heading'><center><h2>Academic Year: <?php echo $_GET['year']; ?></h2></center></td></TR>
	<TR>
		<td colspan='3' class='th-heading'>Year: <?php echo $_GET['eduyear']; ?><center></center></td>
		<td colspan='5' class='th-heading'>Department: <?php echo $_GET['dept']; ?><center></center></td>
	</TR>
	<TR>
	</TR>
	<tr class="th">
		<td>Sr.No.</td>
		<td>Subject</td>
		<td>TH/OR/PR</td>
		<td>Max</td>
		<td>Min</td>
		<td>Pass</td>
		<td>Fail</td>
		<td>30-40</td>
	</tr>
<?php
	include 'db/db_connect.php';
		$sql="SELECT REPLACE(MaxMin.ResultSubject,'.','') as ResultSubject, MaxMin.SubType, MaxMarks, MinMarks, CntPass, CntFail, Cnt3040 
				FROM 
				( SELECT MAX(CAST(Marks AS UNSIGNED)) AS MaxMarks, MIN(CAST(Marks AS UNSIGNED)) AS MinMarks, ResultSubject, SubType
				FROM vwstdresultm SM
				INNER JOIN tblstdresult SR ON SM.StdResMID = SR.StdResMID
				INNER JOIN tbldepartmentmaster DM ON DM.DeptID = SM.CDept
				LEFT OUTER JOIN tblstudent S ON SM.UniPRN = S.uniprn
			    LEFT OUTER JOIN tblstdadm sa ON S.StdId = sa.StdID
				WHERE Pattern = '" . $_GET['pattern'] . "' 
				AND SM.EduYearFr = ". substr($_GET['year'],0,4) .  "  
				AND SM.EduYearTo = ". substr($_GET['year'],5,4) .  " 
				AND SM.EduYear = '" . $_GET['eduyear'] . "' 
			    AND sa.EduYearFrom = ". substr($_GET['year'],0,4) .  " 
			    AND sa.EduYearTo = ". substr($_GET['year'],5,4) .  " 
			    AND sa.stdstatus = 'R' AND REPLACE(sa.Year, '.', '') = '". $_GET['eduyear'] .  "'
				AND DeptName = '" . $_GET['dept'] . "' 
				AND SM.Sem = '" . $_GET['sem'] . "'
				GROUP BY ResultSubject, SubType ) AS MaxMin

				LEFT OUTER JOIN
				( SELECT COUNT(*) AS CntPass, ResultSubject, SubType
				FROM vwstdresultm SM
				INNER JOIN tblstdresult SR ON SM.StdResMID = SR.StdResMID
				INNER JOIN tbldepartmentmaster DM ON DM.DeptID = SM.CDept
				LEFT OUTER JOIN tblstudent S ON SM.UniPRN = S.uniprn
			    LEFT OUTER JOIN tblstdadm sa ON S.StdId = sa.StdID
				WHERE Pattern = '" . $_GET['pattern'] . "' 
				AND SM.EduYearFr = ". substr($_GET['year'],0,4) .  "  
				AND SM.EduYearTo = ". substr($_GET['year'],5,4) .  " 
				AND SM.EduYear = '" . $_GET['eduyear'] . "' 
			    AND sa.EduYearFrom = ". substr($_GET['year'],0,4) .  " 
			    AND sa.EduYearTo = ". substr($_GET['year'],5,4) .  " 
			    AND sa.stdstatus = 'R' AND REPLACE(sa.Year, '.', '') = '". $_GET['eduyear'] .  "'
				AND DeptName = '" . $_GET['dept'] . "' 
				AND SM.Sem = '" . $_GET['sem'] . "'
				AND CAST(SR.Marks AS UNSIGNED) >= CAST(SR.Min AS UNSIGNED) 
				GROUP BY ResultSubject, SubType) AS Pass ON MaxMin.ResultSubject = Pass.ResultSubject AND MaxMin.SubType = Pass.SubType

				LEFT OUTER JOIN
				( SELECT COUNT(*) AS CntFail, ResultSubject, SubType
				FROM vwstdresultm SM
				INNER JOIN tblstdresult SR ON SM.StdResMID = SR.StdResMID
				INNER JOIN tbldepartmentmaster DM ON DM.DeptID = SM.CDept
				LEFT OUTER JOIN tblstudent S ON SM.UniPRN = S.uniprn
			    LEFT OUTER JOIN tblstdadm sa ON S.StdId = sa.StdID
				WHERE Pattern = '" . $_GET['pattern'] . "' 
				AND SM.EduYearFr = ". substr($_GET['year'],0,4) .  "  
				AND SM.EduYearTo = ". substr($_GET['year'],5,4) .  " 
				AND SM.EduYear = '" . $_GET['eduyear'] . "' 
			    AND sa.EduYearFrom = ". substr($_GET['year'],0,4) .  " 
			    AND sa.EduYearTo = ". substr($_GET['year'],5,4) .  " 
			    AND sa.stdstatus = 'R' AND REPLACE(sa.Year, '.', '') = '". $_GET['eduyear'] .  "'
				AND DeptName = '" . $_GET['dept'] . "' 
				AND SM.Sem = '" . $_GET['sem'] . "'
				AND CAST(SR.Marks AS UNSIGNED) < CAST(SR.Min AS UNSIGNED)
				GROUP BY ResultSubject, SubType) AS Fails ON MaxMin.ResultSubject = Fails.ResultSubject AND MaxMin.SubType = Fails.SubType

				LEFT OUTER JOIN
				( SELECT COUNT(*) AS Cnt3040, ResultSubject, SubType
				FROM vwstdresultm SM
				INNER JOIN tblstdresult SR ON SM.StdResMID = SR.StdResMID
				INNER JOIN tbldepartmentmaster DM ON DM.DeptID = SM.CDept
				LEFT OUTER JOIN tblstudent S ON SM.UniPRN = S.uniprn
			    LEFT OUTER JOIN tblstdadm sa ON S.StdId = sa.StdID
				WHERE Pattern = '" . $_GET['pattern'] . "' 
				AND SM.EduYearFr = ". substr($_GET['year'],0,4) .  "  
				AND SM.EduYearTo = ". substr($_GET['year'],5,4) .  " 
				AND SM.EduYear = '" . $_GET['eduyear'] . "' 
			    AND sa.EduYearFrom = ". substr($_GET['year'],0,4) .  " 
			    AND sa.EduYearTo = ". substr($_GET['year'],5,4) .  " 
			    AND sa.stdstatus = 'R' AND REPLACE(sa.Year, '.', '') = '". $_GET['eduyear'] .  "'
				AND DeptName = '" . $_GET['dept'] . "' 
				AND SM.Sem = '" . $_GET['sem'] . "'
				AND BLine LIKE '%FAILS%' 
				AND (CAST(Marks AS UNSIGNED) BETWEEN 30 AND 39) AND SubType = 'PP'
				GROUP BY ResultSubject, SubType) AS Marks3040 ON MaxMin.ResultSubject = Marks3040.ResultSubject AND MaxMin.SubType = Marks3040.SubType
				where MaxMin.ResultSubject <> ''
				ORDER BY MaxMin.ResultSubject, MaxMin.SubType
				";
			  
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
					echo "<td>{$ResultSubject} </td>";
					echo "<td>{$SubType} </td>";
					echo "<td>{$MaxMarks}</td>";
					echo "<td>{$MinMarks} </td>";
					echo "<td>{$CntPass} </td>";
					echo "<td>{$CntFail} </td>";
					echo "<td>{$Cnt3040} </td>";
					echo "</TR>";
					$i += 1;
				}
			}					

			//disconnect from database	
			$result->free();
			$mysqli->close();
?>
	</table>
  

</body>
</html>
