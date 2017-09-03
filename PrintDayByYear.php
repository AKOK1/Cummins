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
    <td>
	<table width="100%" cellpadding="5" cellspacing="0" class="fix-table" >
      <tr>
        <td colspan="11" class="th-heading">
			<h1><center>Selected Year: 
			<?php 	if($_GET['Year']=='FE') {
						echo 'F.Y.B.Tech.';
					}
					else{
						echo $_GET['Year'];
					}
			?>
			</center></h1>
		</td>
	</tr>
      <tr>
        <td colspan="8">&nbsp;</td>
      </tr>
      <tr class="th">
        <td>Year</td>
        <td>Dept.</td>
        <td>Pattern</td>
        <td>Subject</td>
        <td>Date</td>
        <td>Day</td>
        <td>Time</td>
        <td>Students</td>
      </tr>
		<?php
			include 'db/db_connect.php';
			if($_GET['Year'] == 'ALL')
				$stryearname = 'SUBSTRING(EnggYear,1,2)';				
			else
				$stryearname = "'" . $_GET['Year'] . "'";
			
			if ($_SESSION["SESSSelectedExamType"] == 'Online') {
			  $sql = "SELECT EnggYear,EnggPattern, DeptName,SubjectName,DATE_FORMAT(STR_TO_DATE(ExamDate, '%m/%d/%Y'),'%d-%b-%Y') as ExamDate,DAYNAME(STR_TO_DATE(ExamDate, '%m/%d/%Y')) as Day, SUBSTRING(BlockName,LOCATE('@',BlockName)+1) as TimeFromTo,  SUBSTRING(BlockName, 1, LOCATE('@',BlockName)-1) as BlockName, coalesce(EB.Allocation,Students) as Allocation
					, A.StdID AS StdIDMin, B.StdId AS StdIDMax
					FROM  tblexamschedule ES 
					INNER JOIN tblpapermaster PM ON ES.paperid = PM.paperid 
					INNER JOIN tblsubjectmaster SM ON PM.SubjectID = SM.SubjectID 
					INNER JOIN tbldepartmentmaster DM ON PM.DeptID = DM.DeptID 
					LEFT OUTER JOIN tblexamblock EB ON ES.ExamSchID = EB.ExamSchID
					INNER JOIN tblexammaster EM ON EM.ExamID = ES.ExamID
					LEFT OUTER JOIN tblblocksmaster BM ON BM.BlockId = EB.BlockId
					LEFT JOIN (SELECT CASE WHEN CAST(StdId AS UNSIGNED) = 0 THEN MIN(StdId) ELSE MIN(CAST(StdId AS UNSIGNED)) END AS StdId, EBS.ExamBlockId FROM tblexamblockstudent EBS GROUP BY EBS.ExamBlockId) AS A ON A.ExamBlockID = EB.ExamBlockID
					LEFT JOIN (SELECT CASE WHEN CAST(StdId AS UNSIGNED) = 0 THEN MAX(StdId) ELSE MAX(CAST(StdId AS UNSIGNED)) END AS StdId, EBS.ExamBlockId FROM tblexamblockstudent EBS GROUP BY EBS.ExamBlockId) AS B ON B.ExamBlockID = EB.ExamBlockID
					WHERE SUBSTRING(EnggYear,1,2) = ". $stryearname . "
					AND ES.ExamID = " . $_SESSION["SESSSelectedExam"] ."
					AND coalesce(EB.Allocation,Students) <> 0
					ORDER BY SUBSTRING(PaperCode,1,1),SUBSTRING(EnggYear,length(EnggYear),1),EnggPattern,
					ExamDate,DM.orderno, BM.colorder "; 
			}
			Else {
			  $sql = "SELECT EnggYear,EnggPattern, DeptName,SubjectName,DATE_FORMAT(STR_TO_DATE(ExamDate, '%m/%d/%Y'),'%d-%b-%Y') as ExamDate,DAYNAME(STR_TO_DATE(ExamDate, '%m/%d/%Y')) as Day,ES.TimeFrom, ES.TimeTo, sum(coalesce(EB.Allocation,Students)) as Allocation
					FROM  tblexamschedule ES 
					INNER JOIN tblpapermaster PM ON ES.paperid = PM.paperid 
					INNER JOIN tblsubjectmaster SM ON PM.SubjectID = SM.SubjectID 
					INNER JOIN tbldepartmentmaster DM ON PM.DeptID = DM.DeptID 
					LEFT OUTER JOIN tblexamblock EB ON ES.ExamSchID = EB.ExamSchID
					INNER JOIN tblexammaster EM ON EM.ExamID = ES.ExamID
					WHERE coalesce(ExamDate,'') <> '' AND 
					SUBSTRING(EnggYear,1,2) = ". $stryearname . "
					AND ES.ExamID = " . $_SESSION["SESSSelectedExam"] ."
					AND coalesce(EB.Allocation,Students) <> 0
					Group By EnggYear,EnggPattern, DeptName,SubjectName,ExamDate,ES.TimeFrom, ES.TimeTo
					ORDER BY DM.orderno,EnggPattern,
					DATE_FORMAT(STR_TO_DATE(ExamDate, '%m/%d/%Y'),'%d-%b-%Y'),  EnggYear, SubjectName "; 
					//SUBSTRING(PaperCode,1,1),SUBSTRING(EnggYear,length(EnggYear),1)
					//DM.orderno,
			}
				//echo $sql;
				//DeptName, 
				//AND coalesce(EB.Allocation,Students) <> 0
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
							echo "<td>{$ExamDate}</td>";
							echo "<td>{$Day}</td>";
							if ($_SESSION["SESSSelectedExamType"] == 'Online') {
								echo "<td>{$TimeFromTo}</td>";
							}
							Else {
								echo "<td>{$TimeFrom} to {$TimeTo}</td>";
							}
							echo "<td>{$Allocation}</td>";
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
