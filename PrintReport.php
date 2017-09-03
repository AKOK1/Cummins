<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Paper Printing Report</title>
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
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td><table width="100%" cellpadding="5" cellspacing="0" class="fix-table" >
      <tr>
        <td colspan="10" class="th-heading">
	<?php
	if(!isset($_SESSION)){
		session_start();
	}
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
					echo "<p align='center'>PAPER PRINTING REPORT FOR EXAM: {$ExamName}</p>";
				}
			}			


			echo "</td>";
			echo "</tr>";
			echo "<tr>";
			echo "<td colspan='9'><center><b>DATE: </b>{$ExamDateT}, ".$_GET['ExamSlot']."";


$sql = "SELECT substring(EnggYear,1,2) as EnggYear,COUNT(DISTINCT EB.BlockId) AS BLOCKCOUNT
					FROM  tblexamschedule ES 
					INNER JOIN tblpapermaster PM ON ES.paperid = PM.paperid 
					INNER JOIN tblsubjectmaster SM ON PM.SubjectID = SM.SubjectID 
					INNER JOIN tbldepartmentmaster DM ON PM.DeptID = DM.DeptID 
					LEFT OUTER JOIN tblexamblock EB ON ES.ExamSchID = EB.ExamSchID
					INNER JOIN tblexammaster EM ON EM.ExamID = ES.ExamID
					LEFT OUTER JOIN tblblocksmaster BM ON BM.BlockId = EB.BlockId
					LEFT JOIN (SELECT MIN(StdId) AS StdId, EBS.ExamBlockId FROM tblexamblockstudent EBS GROUP BY EBS.ExamBlockId) AS A ON 					A.ExamBlockID = EB.ExamBlockID
					LEFT JOIN (SELECT MAX(StdId) AS StdId, EBS.ExamBlockId FROM tblexamblockstudent EBS GROUP BY EBS.ExamBlockId) AS B ON 					B.ExamBlockID = EB.ExamBlockID
					WHERE ES.ExamSlot = '" . $_GET['ExamSlot'] . "' 
					AND ES.ExamDate = '". $_GET['ExamDate'] . "'
					AND ES.ExamID = ".$_SESSION["SESSSelectedExam"]."
					ORDER BY colorder, DM.orderno, EnggYear, EnggPattern, DeptName, SubjectName limit 1;";

			//echo $sql;
			// execute the sql query
			$result = $mysqli->query( $sql );
				echo $mysqli->error;
			$num_results = $result->num_rows;

			if( $num_results ){
				while( $row = $result->fetch_assoc() ){
					extract($row);
					echo "&nbsp;&nbsp;&nbsp;<b>Blocks:</b> {$BLOCKCOUNT}</center>";
				}
			}			
			//<b>Year:</b> {$EnggYear}, 
			//disconnect from database
			$result->free();
			$mysqli->close();



			echo "</td>";
			echo "</tr>";
	?>
      <tr class="th">
        <td width="2%">Yr</td>
        <td width="29%">Paper</td>
        <td width="3%">Stds</td>
        <td width="4%">Prints</td>
        <td width="29%">Password</td>
        <td width="28%">Block Assignment</td>
        <td width="5%">Stationary</td>
      </tr>

		<?php
			include 'db/db_connect.php';
			  			  $sql = "SELECT CONCAT(CASE DeptName WHEN 'Allied' THEN 'FE' ELSE DeptName END,' - ',EnggPattern) as PAPER1,CONCAT(', ',SubjectName,', ',SUBSTRING(EnggYear,6)) AS Paper,SUM(EB.Allocation) AS STDS, 
								GROUP_CONCAT(CONCAT(SUBSTRING(BM.BlockName,1,INSTR(BM.BlockName,'-')-1),' - ',EB.Allocation) ORDER BY colorder SEPARATOR ', ') AS BlockAssignment,
								COUNT(BM.BlockName) AS BLOCKCOUNT, SUM(EB.Allocation) + COUNT(BM.BlockName) + 4 AS PRINTS,
								substring(EnggYear,1,2) as EnggYear,Stationary
								FROM tblexamschedule ES 
								INNER JOIN tblpapermaster PM ON ES.paperid = PM.paperid 
								INNER JOIN tblsubjectmaster SM ON PM.SubjectID = SM.SubjectID 
								INNER JOIN tbldepartmentmaster DM ON PM.DeptID = DM.DeptID 
								LEFT OUTER JOIN tblexamblock EB ON ES.ExamSchID = EB.ExamSchID 
								INNER JOIN tblexammaster EM ON EM.ExamID = ES.ExamID 
								LEFT OUTER JOIN tblblocksmaster BM ON BM.BlockId = EB.BlockId  
						WHERE ES.ExamSlot = '" . $_GET['ExamSlot'] . "' 
					AND ES.ExamDate = '". $_GET['ExamDate'] . "' and ES.ExamID = ".$_SESSION["SESSSelectedExam"]."
					GROUP BY SubjectName,EnggPattern,EnggYear,Paper ,DM.DeptID
					ORDER BY PaperCode ,DM.orderno,EnggPattern,colorder;"; 
				//echo $sql;
				// execute the sql query
				$result = $mysqli->query( $sql );
				echo $mysqli->error;
				$num_results = $result->num_rows;
				$temppaper = '';

				if( $num_results ){
					while( $row = $result->fetch_assoc() ){
						extract($row);
						echo "<TR>";
							echo "<td >{$EnggYear}</td>";
							echo "<td ><b>{$PAPER1}</b>{$Paper}</td>";
							echo "<td >{$STDS}</td>";
							echo "<td >{$PRINTS}</td>";
							echo "<td ></td>";
							echo "<td ><b>{$BlockAssignment}</b></td>";
							echo "<td >{$Stationary}</td>";
						echo "</tr>";
						$temppaper = $Paper;
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
