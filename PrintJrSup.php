<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>JR. SUP</title>
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
	line-height:14px;
	height: 13px;
	border: solid 1px #666 ;
	text-align:left;
	text-indent:0px;
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
	  
	<?php
		if(!isset($_SESSION)){
			session_start();
		} 

		include 'db/db_connect.php';
		  $sql = "SELECT substring(EnggYear,1,2) as EnggYear,EnggPattern, DeptName,SubjectName,ES.ExamDate, ES.TimeFrom, ES.TimeTo, 	
				EM.ExamName, BM.BlockName, DATE_FORMAT(STR_TO_DATE(ExamDate,'%m/%d/%Y'), '%d %M %Y') AS ExamDateT, A.StdID AS StdIDMin, B.StdId AS StdIDMax, EB.Allocation,examtype2
					FROM  tblexamschedule ES 
				INNER JOIN tblpapermaster PM ON ES.PaperID = PM.PaperID
				INNER JOIN tblsubjectmaster SM ON PM.SubjectID = SM.SubjectID 
				INNER JOIN tbldepartmentmaster DM ON PM.DeptID = DM.DeptID 
				INNER JOIN tblexamblock AS EB ON ES.ExamSchID = EB.ExamSchID
				INNER JOIN tblexammaster EM ON EM.ExamID = ES.ExamID
				INNER JOIN tblblocksmaster BM ON BM.BlockId = EB.BlockId
				INNER JOIN (SELECT CASE WHEN CAST(StdId AS UNSIGNED) = 0 THEN MIN(StdId) ELSE MIN(CAST(StdId AS UNSIGNED)) END AS  StdId, EBS.ExamBlockId FROM tblexamblockstudent EBS WHERE StdId <> '' GROUP BY EBS.ExamBlockId) AS A ON A.ExamBlockId = EB.ExamBlockID
				INNER JOIN (SELECT CASE WHEN CAST(StdId AS UNSIGNED) = 0 THEN MAX(StdId) ELSE MAX(CAST(StdId AS UNSIGNED)) END AS StdId, EBS.ExamBlockId FROM tblexamblockstudent EBS WHERE StdId <> '' GROUP BY EBS.ExamBlockId) AS B ON B.ExamBlockID = EB.ExamBlockID
				WHERE EB.BlockID = ". $_GET['BlockId'] ." AND ES.ExamDate = '". $_GET['ExDate'] ."'  AND ES.ExamSlot = '". $_GET['ExSlot'] ."'
				 AND ES.ExamId = " . $_SESSION['SESSSelectedExam'] . " ORDER BY EB.ExamBlockID ";
			
			//echo $sql;
			// execute the sql query
			$result = $mysqli->query( $sql );
					echo $mysqli->error;

			$num_results = $result->num_rows;

			$i = 0;
			if( $num_results ){
				while( $row = $result->fetch_assoc() ){
					extract($row);
					if ($i == 0){
						echo "<TR>";
						echo "<td colspan='5' class='th-heading'>JR. SUPERVISOR REPORT FOR EXAM: {$ExamName} </td>";
						echo "<td colspan='2' class='th-heading' >{$BlockName} </td>";
						echo "</TR>";
						echo "<TR>";
						echo "<td colspan='7'><b>Date:</b> " . $ExamDateT . ", ". $_GET['ExSlot'] . " </td>";
						//"&nbsp&nbsp&nbsp<b>Year:</b> " . $EnggYear
						echo "</TR>";
						
						
						echo "<TR class='th'>";
						echo "<td>Yr. (Pat.)</td>";
						echo "<td>Dept.</td>";
						echo "<td>Subject</td>";
						echo "<td>Time</td>";
						echo "<td>Seat From</td>";
						echo "<td>Seat To</td>";
						echo "<td>Students</td>";
						echo "</TR>";

						echo "<TR>";
						echo "<td>{$EnggYear} ({$EnggPattern})</td>";
						echo "<td>{$DeptName}</td>";
						echo "<td>{$SubjectName}</td>";
						echo "<td>{$TimeFrom} to {$TimeTo}</td>";
						echo "<td>{$StdIDMin}</td>";
						echo "<td>{$StdIDMax}</td>";
						echo "<td>{$Allocation}</td>";
						echo "</TR>";
						
						$i += 1;
					}
					else {
						echo "<TR>";
						echo "<td>{$EnggPattern}</td>";
						echo "<td>{$DeptName}</td>";
						echo "<td>{$SubjectName}</td>";
						echo "<td>{$TimeFrom} to {$TimeTo}</td>";
						echo "<td>{$StdIDMin}</td>";
						echo "<td>{$StdIDMax}</td>";
						echo "<td>{$Allocation}</td>";
						echo "</TR>";					}
				}
			}					
			//disconnect from database
			$_SESSION['examtype2'] = $examtype2;
			$result->free();
			$mysqli->close();

	?>
	</tr>

	</table>
	<br/>
	
<table width="90%" border="0" cellpadding="5" cellspacing="0" class="fix-table" style="margin-left: 5%;font-size:smaller">
      <tr class="th">
        <td width="2%">Sr.</td>
        <td width="8%">ESN/Roll No.</td>
        <td width="26%">Name</td>
        <td width="10%">Sign</td>
        <td width="3%">Suppl.</td>
        <td width="2%"></td>
        <td width="2%">Sr.</td>
        <td width="8%">ESN/Roll No.</td>
        <td width="25%">Name</td>
        <td width="10%">Sign</td>
        <td width="3%">Suppl.</td>
      </tr>
	<?php
			if(!isset($_SESSION)){
			session_start();
		} 
		include 'db/db_connect.php';
		//$StdSeat= array(40);
		
		$i = 0;
		//echo $sql;
		for ($i = 0 ; $i <= 40; $i++) {
			$StdSeat[$i] = '';
			$StdNameArr[$i] = '';
		}

			
/*		  $sql = "SELECT StdSeat1, StdSeat2, StdSeat3, StdSeat4, StdSeat5 
				FROM  tblexamblockstudent Where ExamBlockID = '" .  $_GET['ExamBlockId1']. "'";
*/
		if(stripos($_SESSION['examtype2'], 'In-Sem') >= 0 ){ 
			$sql = "SELECT EBS.ExamBlockID, TRIM(EBS.StdId)AS StdID,CONCAT(s.SurName, ' ', s.FirstName) AS stdname
					FROM tblexamblockstudent EBS 
					INNER JOIN tblexamblock EB ON EB.ExamBlockID = EBS.ExamblockID
					INNER JOIN tblexamschedule ES ON ES.ExamSchId = EB.ExamSchID
					INNER JOIN tblstdadm sa ON coalesce(sa.ESNum,sa.RollNo)  = TRIM(EBS.StdId)
					INNER JOIN tblexammaster em ON em.AcadYearFrom = sa.EduYearFrom
					INNER JOIN tblstudent s ON s.StdID = sa.StdID
					WHERE BlockID = ". $_GET['BlockId'] ."  AND ES.ExamDate = '". $_GET['ExDate'] ."'  AND ES.ExamSlot = '". $_GET['ExSlot'] ."'
					AND ES.ExamId = " . $_SESSION['SESSSelectedExam'] . " 
					and em.ExamId = ES.ExamId
					AND COALESCE(EBS.StdID,'') <> ''
					ORDER BY EBS.ExamBlockID, ExamBlockStdId ";
		}
		else{
			$sql = "SELECT EBS.ExamBlockID, TRIM(EBS.StdId)AS StdID,CONCAT(s.SurName, ' ', s.FirstName) AS stdname
					FROM tblexamblockstudent EBS 
					INNER JOIN tblexamblock EB ON EB.ExamBlockID = EBS.ExamblockID
					INNER JOIN tblexamschedule ES ON ES.ExamSchId = EB.ExamSchID
					INNER JOIN tblstdadm sa ON coalesce(sa.ESNum,sa.RollNo) = TRIM(EBS.StdId)
					INNER JOIN tblexammaster em ON em.AcadYearFrom = sa.EduYearFrom
					INNER JOIN tblstudent s ON s.StdID = sa.StdID
					WHERE BlockID = ". $_GET['BlockId'] ."  AND ES.ExamDate = '". $_GET['ExDate'] ."'  AND ES.ExamSlot = '". $_GET['ExSlot'] ."'
					AND ES.ExamId = " . $_SESSION['SESSSelectedExam'] . " 
					and em.ExamId = ES.ExamId
					AND COALESCE(EBS.StdID,'') <> ''
					ORDER BY EBS.ExamBlockID, ExamBlockStdId ";
		}
			//replace(year,'.','') = '". $EnggYear ."' AND 
			//echo $sql;
			
			// execute the sql query
			$result = $mysqli->query( $sql );
			echo $mysqli->error;
			$num_results = $result->num_rows;
			
			$i = 0;
			$l = 0;
			if( $num_results ){
				while( $row = $result->fetch_assoc() ){
					extract($row);
					$StdSeat[$i] = $StdID;
					$StdNameArr[$i] = $stdname;
					$i += 1;
					$l = $l + 1;
				}
			}					
			?>
					<?php 		
						$j = 1;
						$k = 21;
						while( $j < 21 ){
							echo "<TR>";
							echo "<td width='4%'>$j</td><td width='6%'>{$StdSeat[$j-1]}</td><td width='28%'>{$StdNameArr[$j-1]}</td><td width='10%'></td><td width='3%'></td><td width='1%'></td>";
							echo "<td width='4%'>$k</td><td width='6%'>{$StdSeat[$k-1]}</td><td width='27%'>{$StdNameArr[$k-1]}</td><td width='10%'></td><td width='3%'></td>";
							echo "</TR>";
							$j = $j + 1;
							$k = $k + 1;
						}					
			
					?>
				</table>
			<?php 		
					//disconnect from database	
					$result->free();
					$mysqli->close();
					
			?>

<table width="90%" border="0" cellpadding="5" cellspacing="0" class="fix-table" style="margin-left: 5%;">
	<tr>
		<td>Total Stundents:<?php echo $l;?></td>
		<td>Total Present:</td>
		<td>Total Absent:</td>
	</tr>
</table>
<br/><br/>
<table width="90%" border="0" cellpadding="5" cellspacing="0" class="fix-table" style="margin-left: 5%;">
	<tr>
		<td><center>Name and Signature of Junior Supervisor</center></td>
		<td width="2%"></td>
		<td><center>Name and Signature of Senior Supervisor</center></td>
	</tr>
</table>
</body>
</html>
