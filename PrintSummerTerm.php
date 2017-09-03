<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Summer Term Student Report</title>
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
	<br/>
	<center><img class="center" alt="logo" src="images/logo.png"></center>
	<br/>

	<table width="100%" border="0" cellpadding="0" cellspacing="0">

	<tr><td colspan='8' class='th-heading'><center><h2>Summer Term Student Report</h2></center></td></tr>
	
	<tr>
		<td><table width="100%" cellpadding="5" cellspacing="0" class="fix-table" >
		<tr class="th">
			<td>Sr No</td>
			<td>Exam Seat No</td>
			<td>CNUM</td>
			<td>Roll No</td>
			<td>Student Name</td>
			<td>Sem 1</td>
			<td>Sem 2</td>
		</tr>
			<?php
				include 'db/db_connect.php';
				$sql = "SELECT CNUM, ESNum,RollNo,CONCAT(Surname,' ', FirstName, ' ',FatherName) AS StdName,
						MAX(CASE WHEN yss.Sem = 1 THEN 'Y' ELSE 'N' END) AS Sem1,
						MAX(CASE WHEN yss.Sem = 2 THEN 'Y' ELSE 'N' END) AS Sem2
						FROM tblyearstructstdretest yss 
						INNER JOIN tblyearstruct ys ON ys.rowid = yss.YSID 
						INNER JOIN tblpapermaster pm ON pm.PaperID = ys.PaperID 
						INNER JOIN tblsubjectmaster sm ON sm.SubjectID = pm.SubjectID 
						INNER JOIN tblexammaster em ON em.ExamID = yss.ExamID AND em.acadyearfrom = ys.eduyearfrom 
						INNER JOIN tblstdadm sa ON sa.stdadmid = yss.StdAdmid
						INNER JOIN tblstudent s ON s.Stdid = sa.Stdid
						WHERE examname LIKE '%Summer%' 
						GROUP BY CNUM, ESNum,RollNo,CONCAT(Surname,' ', FirstName, ' ',FatherName)";
				$result = $mysqli->query( $sql );
				$num_results = $result->num_rows;
				if($num_results > 0){
					$j = 1;
					while( $row = $result->fetch_assoc() ){
						extract($row);
						echo "<tr>";
						echo "<td>$j</td>";
						echo "<td>$ESNum</td>";
						echo "<td>$CNUM</td>";
						echo "<td>$RollNo</td>";
						echo "<td>$StdName</td>";
						echo "<td>$Sem1</td>";
						echo "<td>$Sem2</td>";
						echo "</tr>";
						$j = $j + 1;
					}
				}
				else{
					echo "<tr>";
					echo "<td colspan='7'>No records found.</td>";
					echo "</tr>";
				}
				
			?>

			
    </table></td>
  </tr>
</table>
</body>
</html>
