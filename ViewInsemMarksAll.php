<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>In-Sem Marks</title>
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
	<br/>
	<table width="90%" cellpadding="5" cellspacing="0" class="fix-table" style="margin-left: 5%;">
	<TR>
		<td colspan='7' class='th-heading'><center>All Marks Report</center></td>
	</TR>
	</table>
	<br/><br/>
<table width="90%" border="0" cellpadding="5" cellspacing="0" class="fix-table" style="margin-left: 5%;">
	<tr class="th">
		<td width="5%">Sr. No.</td>
		<td width="5%">CNUM</td>
		<td width="5%">Seat Number</td>
		<td width="10%">Student Name</td>
		<td width="05%">T1</td>
		<td width="05%">T2</td>
		<td width="05%">ESE</td>
	</tr>
	<?php
		if(!isset($_SESSION)) {
			session_start();				
		}
		include 'db/db_connect.php';
	$sql = "SELECT CNUM,CONCAT(Surname,' ', FirstName, ' ',FatherName) AS StdName,sa.ESNum, sub.StdID,(COALESCE(t1.TotMarks1,0)) AS TotMarks1,(COALESCE(T2.TotMarks2,0)) AS TotMarks2,(COALESCE(ese.esemarks,0)) AS esemarks
FROM (SELECT DISTINCT sa.StdID
FROM tblinsemmarks IM 
INNER JOIN tblcapblockprof CBP ON IM.CapId = CBP.cbpid 
INNER JOIN tblexamblock EB ON EB.ExamBlockID = CBP.ExamBlockID 
INNER JOIN tblstdadm sa ON sa.rollno = IM.stdid AND YEAR = 'F.E.'
INNER JOIN tblcuryear cy ON cy.EduYearFrom = sa.EduYearFrom) AS sub 
LEFT OUTER JOIN (SELECT sa.StdID, CASE COALESCE(IM.stdstatus,'') WHEN 'A' THEN 'AA' 
ELSE CONVERT(SUM(Q1 + Q2 + Q3 + Q4 + Q5 + Q6 + Q7 + Q8 + Q9 + Q10 + Q11 + Q12 + Q13 + Q14 + Q15 + Q16 + Q17 + Q18 + Q19 + Q20) , CHAR(10)) END 
	AS TotMarks1 FROM tblinsemmarks IM 
INNER JOIN tblcapblockprof CBP ON IM.CapId = CBP.cbpid 
INNER JOIN tblexamblock EB ON EB.ExamBlockID = CBP.ExamBlockID 
INNER JOIN tblstdadm sa ON sa.rollno = IM.stdid  AND YEAR = 'F.E.'
INNER JOIN tblcuryear cy ON cy.EduYearFrom = sa.EduYearFrom 
INNER JOIN tblexammaster em ON em.ExamID = CBP.ExamId 
WHERE examname LIKE '%T1%' GROUP BY sa.StdID) AS t1 ON 
sub.StdID = t1.StdID 
LEFT OUTER JOIN (SELECT sa.StdID, 
CASE COALESCE(IM.stdstatus,'') WHEN 'A' THEN 'AA' 
ELSE CONVERT(SUM(Q1 + Q2 + Q3 + Q4 + Q5 + Q6 + Q7 + Q8 + Q9 + Q10 + Q11 + Q12 + Q13 + Q14 + Q15 + Q16 + Q17 + Q18 + Q19 + Q20) , 
CHAR(10)) END AS TotMarks2 
FROM tblinsemmarks IM 
INNER JOIN tblcapblockprof CBP ON IM.CapId = CBP.cbpid 
INNER JOIN tblexamblock EB ON EB.ExamBlockID = CBP.ExamBlockID 
INNER JOIN tblstdadm sa ON sa.rollno = IM.stdid  AND YEAR = 'F.E.'
INNER JOIN tblcuryear cy ON cy.EduYearFrom = sa.EduYearFrom 
INNER JOIN tblexammaster em ON em.ExamID = CBP.ExamId WHERE examname LIKE '%T2%' GROUP BY sa.StdID) AS T2 ON 
sub.StdID = T2.StdID
LEFT OUTER JOIN 
(SELECT sa.StdID, CASE COALESCE(IM.stdstatus,'') WHEN 'A' THEN 'AA' 
			ELSE CONVERT(SUM(Q1 + Q2 + Q3 + Q4 + Q5 + Q6 + Q7 + Q8 + Q9 + Q10 + 
Q11 + Q12 + Q13 + Q14 + Q15 + Q16 + Q17 + Q18 + Q19 + Q20) , CHAR(10)) END 
	AS esemarks 
	FROM tblinsemmarks IM 
INNER JOIN tblcapblockprof CBP ON IM.CapId = CBP.cbpid 
INNER JOIN tblexamblock EB ON EB.ExamBlockID = CBP.ExamBlockID 
INNER JOIN tblstdadm sa ON sa.ESNum = IM.stdid  AND YEAR = 'F.E.'
INNER JOIN tblcuryear cy ON cy.EduYearFrom = sa.EduYearFrom
INNER JOIN tblexammaster em ON em.ExamID = CBP.ExamId WHERE examname LIKE '%ese%' GROUP BY sa.StdID) AS ese ON 
sub.StdID = ese.StdID
INNER JOIN tblstdadm sa ON sa.StdID = sub.StdID
INNER JOIN tblstudent s ON s.StdID = sa.StdID
INNER JOIN tblcuryear cy ON cy.EduYearFrom = sa.EduYearFrom
ORDER BY sub.StdID";

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
					echo "<td>{$CNUM} </td>";
					echo "<td>{$ESNum} </td>";
					echo "<td>{$StdName} </td>";
					echo "<td>{$TotMarks1} </td>";
					echo "<td>{$TotMarks2} </td>";
					echo "<td>{$esemarks} </td>";
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
