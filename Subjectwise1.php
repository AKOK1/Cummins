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
			AND EduYear = '" . $_GET['eduyear'] . "' AND DeptName = '" . $_GET['dept'] . "' AND SM.Sem = '" . $_GET['sem'] . "'
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
<title>Subject Wise</title>
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
	<center><img class="center" alt="logo" src="images/logo.png"></center>
	<table width="90%" border="0" cellpadding="0" cellspacing="0" class="fix-table" style="margin-left: 5%;">
	<TR><td colspan='8' class='th-heading'><center><h2>Subject-wise Result for Exam: <?php echo $selexamname; ?> (Top 5 Students)</h2></center></td></TR>
	<TR><td colspan='7' class='th-heading'><center><h2>Academic Year: <?php echo $_GET['year']; ?></h2></center></td></TR>
	<TR>
		<td colspan='2' class='th-heading'>Year: <?php echo $_GET['eduyear']; ?><center></center></td>
		<td colspan='5' class='th-heading'>Department: <?php echo $_GET['dept']; ?><center></center></td>

	</TR>
	
	
<?php

	$sql= "SELECT CONCAT(ResultSubject,'  (',SubType,')') AS sub, COALESCE(CNUM, SM.UniPRN) AS CNUM, CONCAT(FirstName,
			' ', FatherName, ' ', Surname) AS NAME , DM.DeptName,
			MArks,SUBSTRING(BLine, LOCATE(':', BLine) + 2) AS Class,
			Cast(( SUBSTRING(TotalLine, 1,LOCATE('/', TotalLine) -1) * 100 / SUBSTRING(TotalLine, LOCATE('/', TotalLine) + 1))  AS DECIMAL(5,2)) AS Per
			FROM vwstdresultm SM
			INNER JOIN tblstdresult SR ON SM.StdResMID = SR.StdResMID
			INNER JOIN tbldepartmentmaster DM ON DM.DeptID = SM.CDept
			LEFT OUTER JOIN tblstudent S ON SM.UniPRN = S.uniprn
			LEFT OUTER JOIN tblstdadm sa ON S.StdId = sa.StdID
			WHERE Pattern = '" . $_GET['pattern'] . "' AND ResultSubject <> '' 
			AND SM.EduYearFr = substring('" . $_GET['year'] . "',1,LOCATE('-', '" . $_GET['year'] . "') - 1)
			AND  SM.EduYearTo = substring('" . $_GET['year'] . "',LOCATE('-', '" . $_GET['year'] . "') + 1) 
			AND SM.EduYear = '" . $_GET['eduyear'] . "' 
			AND sa.EduYearFrom = ". substr($_GET['year'],0,4) .  " 
			AND  sa.EduYearTo = ". substr($_GET['year'],5,4) .  " 
			AND sa.stdstatus = 'R' AND REPLACE(sa.Year, '.', '') = '". $_GET['eduyear'] .  "'
			AND DeptName = '" . $_GET['dept'] . "' 
			AND SM.Sem = '" . $_GET['sem'] . "'
			ORDER BY sub,  CAST(Marks AS UNSIGNED) DESC
			-- Limit 5 ";
			//echo $sql;
			//AND ResFileID IN (SELECT ResFileID FROM tblresultfile WHERE ExamID = 3)
			//result_h($sql);
?>


    
<?php
		include 'db/db_connect.php';
		
		$result = $mysqli->query( $sql );
		//echo $sql;
		$num_results = $result->num_rows;
		// $arr=array();
		// $arrcnt=0;
		
		$i = 1;
		
		// $res ='';
		$PrevSub='';
		$prevtype='';
		$prevmarks='';
		
		//echo $sql;
			if( $num_results ){
			while( $row = $result->fetch_assoc() ){
					extract($row);
					if($i == 5) {
						//die;
						if ($sub == $PrevSub ) {
							 //$ResultSubject;
							$PrevSub = $sub;
							
							// $prevmarks = $MArks;
							// $prevtype = $SubType;
							 //echo '$SubType';
							continue;
							
						}
					}
					if($sub != $PrevSub) {
						echo "<TR><td colspan='8' class='th-heading'></td></TR>";
						$i=0;
						echo "<TR>
						<td colspan='8' class='th-heading'><left>Subject Name:  $sub</left></td>
						</TR>";
						//if($MArks != $prevmarks) {
						echo "<tr class='th'>";	
						echo "<td>Rank</td>";
						echo "<td>CNUM</td>";
						echo "<td>Name of Student</td>";
						echo "<td>Department</td>";
						echo "<td>Marks Obtained</td>";
						echo "<td>Class</td>";
						echo "<td>Percentage</td>";
						echo "</TR>";
						$PrevSub= $sub;
					} 
					if ($prevmarks == $MArks) {
						//do nothing	
					}	
					else {
						$i += 1;
					}
					$prevmarks = $MArks;
					//echo $prevmarks;
					echo "<TR>";
					echo "<td>$i</td>";
					echo "<td>{$CNUM} </td>";
					echo "<td>{$NAME} </td>";
					echo "<td>{$DeptName} </td>";
					echo "<td>{$MArks} </td>";
					echo "<td>{$Class} </td>";
					echo "<td>{$Per}</td>";
					echo "</TR>";
				
									
				}
			}			
			$result->free();
			$mysqli->close();
	
?>
</table>
</body>
</html>
	

