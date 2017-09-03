<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>PRESENT / ABSENT REPORT</title>
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
    <td><table width="100%" cellpadding="5" cellspacing="0" class="fix-table" >
      <tr>
        <td colspan="10" class="th-heading">
	<?php
		include 'db/db_connect.php';
		  $sql = "SELECT ExamName, DATE_FORMAT(STR_TO_DATE(ExamDate,'%m/%d/%Y'), '%d %M %Y') AS ExamDateT
				FROM tblexammaster EM
					INNER JOIN (SELECT DISTINCT ExamID, ExamDate, ExamSlot 
								FROM tblexamschedule 
								WHERE ExamDate = '" . $_GET['ExamDate'] . "' AND ExamSlot = '" . $_GET['ExamSlot'] . "') AS ES
					ON ES.ExamID = EM.ExamID where ES.ExamID = ".$_SESSION["SESSSelectedExam"].""; 
			
			// execute the sql query
			$result = $mysqli->query( $sql );
				echo $mysqli->error;
			$num_results = $result->num_rows;

			if( $num_results ){
				while( $row = $result->fetch_assoc() ){
					extract($row);
					echo "<p align='center'>PRESENT / ABSENT REPORT FOR EXAM: {$ExamName}</p>";
				}
			}			


			echo "</td>";
			echo "</tr>";
			echo "<tr>";
			echo "<td colspan='9'><center style='font-size:14px'><b>DATE: </b>{$ExamDateT}, ".$_GET['ExamSlot']."";

			$sql = "SELECT substring(EnggYear,1,2) as EnggYear
					FROM  tblexamschedule ES 
					INNER JOIN tblpapermaster PM ON ES.paperid = PM.paperid 
					INNER JOIN tblsubjectmaster SM ON PM.SubjectID = SM.SubjectID 
					INNER JOIN tbldepartmentmaster DM ON PM.DeptID = DM.DeptID 
					LEFT OUTER JOIN tblexamblock EB ON ES.ExamSchID = EB.ExamSchID
					INNER JOIN tblexammaster EM ON EM.ExamID = ES.ExamID and ES.ExamID = ".$_SESSION["SESSSelectedExam"]."
					LEFT OUTER JOIN tblblocksmaster BM ON BM.BlockId = EB.BlockId
					LEFT JOIN (SELECT MIN(StdId) AS StdId, EBS.ExamBlockId FROM tblexamblockstudent EBS GROUP BY EBS.ExamBlockId) AS A ON 					A.ExamBlockID = EB.ExamBlockID
					LEFT JOIN (SELECT MAX(StdId) AS StdId, EBS.ExamBlockId FROM tblexamblockstudent EBS GROUP BY EBS.ExamBlockId) AS B ON 					B.ExamBlockID = EB.ExamBlockID
					WHERE ES.ExamSlot = '" . $_GET['ExamSlot'] . "' 
					AND ES.ExamDate = '". $_GET['ExamDate'] . "'
					 ORDER BY colorder, DM.orderno, EnggYear, EnggPattern, DeptName, SubjectName limit 1;"; 
			//echo $sql;
			// execute the sql query
			$result = $mysqli->query( $sql );
				echo $mysqli->error;
			$num_results = $result->num_rows;

			if( $num_results ){
				while( $row = $result->fetch_assoc() ){
					extract($row);
					//echo "&nbsp;&nbsp;&nbsp;<b>Year:</b> {$EnggYear}</center>";
				}
			}			
		
			//disconnect from database
			$result->free();
			$mysqli->close();



			echo "</td>";
			echo "</tr>";
	?>
      <tr>
        <td colspan="10">&nbsp;</td>
      </tr>
      <tr class="th">
        <td width="5%;">Block</td>
        <td width="25%;">Paper</td>
        <td width="5%;">Stds</td>
        <td width="5%;">Pr.</td>
        <td width="5%;">Ab.</td>
        <td width="25%;">Absent Seat No</td>
        <td width="25%;">Absent Barcode Sticker No</td>
        <td width="5%">Sign</td>
      </tr>

		<?php
			include 'db/db_connect.php';
			  $sql = "SELECT substring(EnggYear,1,2) as EnggYear2,substring(EnggYear,6) as EnggYear,EnggPattern, 
					CASE DeptName WHEN 'Allied' THEN 'FE' ELSE DeptName END as DeptName,
					SubjectName,ES.TimeFrom, ES.TimeTo, BM.BlockName as BlockName1, EB.Allocation,
					SUBSTRING(BM.BlockName,1,INSTR(BM.BlockName,'-')-1) as BlockName
					, A.StdID AS StdIDMin, B.StdId AS StdIDMax , SUBSTRING(BlockName,LOCATE('@',BlockName)+1) as TimeFromTo
					FROM  tblexamschedule ES 
					INNER JOIN tblpapermaster PM ON ES.paperid = PM.paperid 
					INNER JOIN tblsubjectmaster SM ON PM.SubjectID = SM.SubjectID 
					INNER JOIN tbldepartmentmaster DM ON PM.DeptID = DM.DeptID 
					LEFT OUTER JOIN tblexamblock EB ON ES.ExamSchID = EB.ExamSchID
					INNER JOIN tblexammaster EM ON EM.ExamID = ES.ExamID
					LEFT OUTER JOIN tblblocksmaster BM ON BM.BlockId = EB.BlockId
					LEFT JOIN (SELECT MIN(StdId) AS StdId, EBS.ExamBlockId FROM tblexamblockstudent EBS GROUP BY EBS.ExamBlockId) AS A ON A.ExamBlockID = EB.ExamBlockID
					LEFT JOIN (SELECT MAX(StdId) AS StdId, EBS.ExamBlockId FROM tblexamblockstudent EBS GROUP BY EBS.ExamBlockId) AS B ON B.ExamBlockID = EB.ExamBlockID
					WHERE ES.ExamSlot = '" . $_GET['ExamSlot'] . "' 
					AND ES.ExamDate = '". $_GET['ExamDate'] . "' and ES.ExamID = ".$_SESSION["SESSSelectedExam"]."
					AND SUBSTRING(BM.BlockName,1,INSTR(BM.BlockName,'-')-1) <> ''
					 ORDER BY colorder ";
				
				// execute the sql query
				$result = $mysqli->query( $sql );
				echo $mysqli->error;
				$num_results = $result->num_rows;

				if( $num_results ){
					while( $row = $result->fetch_assoc() ){
						extract($row);
						echo "<TR>";
							echo "<td ><div style='height:45px'>{$BlockName}</div></td>";
							echo "<td ><b>{$EnggYear2} - {$DeptName} - {$EnggPattern}</b>, {$SubjectName}, {$EnggYear}</td>";
							echo "<td >{$Allocation}</td>";
							echo "<td ></td>";
							echo "<td ></td>";
							echo "<td ></td>";
							echo "<td ></td>";
							echo "<td ></td>";
						echo "</tr>";
					}
				}	
				//<br/><b>{$TimeFromTo}</b>				
				//disconnect from database
				$result->free();
				$mysqli->close();
		?>	  
	  
	  
	  
	  
    </table></td>
  </tr>
</table>
</body>
</html>
