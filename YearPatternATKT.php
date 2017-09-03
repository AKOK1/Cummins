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
			AND EduYear = '" . $_GET['eduyear'] . "' AND DeptName = '" . $_GET['deptname'] . "' AND SM.Sem = '" . $_GET['sem'] . "'
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
<title>Top 10</title>
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
	<TR><td colspan='8' class='th-heading'><center><h2>Year-wise Result for Exam: <?php echo $selexamname; ?></h2></center></td></TR>
	<TR><td colspan='8' class='th-heading'><center><h2>Academic Year: <?php echo $_GET['year']; ?><h2></center></td></TR>
	<TR>
		<td colspan='8' class='th-heading'>Department: <?php echo $_GET['deptname']; ?><center></center></td>
	</TR>
	<TR>
	</TR>
	<tr class="th">
		<td>Sr.No.</td>
		<td>Edu Year</td>
		<td>Pattern</td>
		<td>1 KT</td>
		<td>2 KT</td>
		<td>3 KT</td>
		<td>All Clear</td>
		<td>Fail</td>
	</tr>
<?php
	include 'db/db_connect.php';
		$sql="	SELECT Pass.EduYear, Pass.Pattern, KT1, KT2, KT3, CntPass, CntFail
				FROM (
				SELECT COUNT(*) AS CntPass, EduYear, Pattern
				FROM vwstdresultm SM
				INNER JOIN tbldepartmentmaster DM ON DM.DeptID = SM.CDept
				LEFT OUTER JOIN tblstudent S ON SM.UniPRN = S.uniprn
			    LEFT OUTER JOIN tblstdadm sa ON S.StdId = sa.StdID
				WHERE SM.EduYearFr = ". substr($_GET['year'],0,4) .  " 
				AND  SM.EduYearTo = ". substr($_GET['year'],5,4) .  " 
			    AND sa.EduYearFrom = ". substr($_GET['year'],0,4) .  " 
			    AND sa.EduYearTo = ". substr($_GET['year'],5,4) .  " 
			    AND sa.stdstatus = 'R' 
				AND DeptName = '" . $_GET['deptname'] . "' 
				AND (BLine NOT LIKE '%FAILS%' OR BLine IS NULL) 
				GROUP BY EduYear, Pattern) AS Pass

				LEFT OUTER JOIN
				( SELECT COUNT(*) AS KT1, EduYear, Pattern 
				FROM vwstdresultm SM
				INNER JOIN ( SELECT COUNT(PassFail) AS CntPassFail, SM.StdResMID
				FROM vwstdresultm SM
				INNER JOIN tblstdresult SR ON SM.StdResMID = SR.StdResMID
				INNER JOIN tbldepartmentmaster DM ON DM.DeptID = SM.CDept
				LEFT OUTER JOIN tblstudent S ON SM.UniPRN = S.uniprn
			    LEFT OUTER JOIN tblstdadm sa ON S.StdId = sa.StdID
				WHERE SM.EduYearFr = ". substr($_GET['year'],0,4) .  " 
				AND  SM.EduYearTo = ". substr($_GET['year'],5,4) .  " 
			    AND sa.EduYearFrom = ". substr($_GET['year'],0,4) .  " 
			    AND sa.EduYearTo = ". substr($_GET['year'],5,4) .  " 
			    AND sa.stdstatus = 'R' 
				AND DeptName = '" . $_GET['deptname'] . "' 
				AND PassFail = 'F'
				GROUP BY SM.StdResMID HAVING COUNT(PassFail) = 1 ) AS A ON SM.StdResMID = A.StdResMID
				GROUP BY EduYear, Pattern) AS 1KT 
				ON 1KT.EduYear = Pass.EduYear AND 1KT.PAttern = Pass.PAttern

				LEFT OUTER JOIN
				( SELECT COUNT(*) AS KT2, EduYear, Pattern 
				FROM vwstdresultm SM
				INNER JOIN ( SELECT COUNT(PassFail) AS CntPassFail, SM.StdResMID
				FROM vwstdresultm SM
				INNER JOIN tblstdresult SR ON SM.StdResMID = SR.StdResMID
				INNER JOIN tbldepartmentmaster DM ON DM.DeptID = SM.CDept
				LEFT OUTER JOIN tblstudent S ON SM.UniPRN = S.uniprn
			    LEFT OUTER JOIN tblstdadm sa ON S.StdId = sa.StdID
				WHERE SM.EduYearFr = ". substr($_GET['year'],0,4) .  " 
				AND  SM.EduYearTo = ". substr($_GET['year'],5,4) .  " 
			    AND sa.EduYearFrom = ". substr($_GET['year'],0,4) .  " 
			    AND sa.EduYearTo = ". substr($_GET['year'],5,4) .  " 
			    AND sa.stdstatus = 'R' 
				AND DeptName = '" . $_GET['deptname'] . "' 
				AND PassFail = 'F'
				GROUP BY SM.StdResMID HAVING COUNT(PassFail) = 2 ) AS A ON SM.StdResMID = A.StdResMID
				GROUP BY EduYear, Pattern) AS 2KT
				ON 2KT.EduYear = Pass.EduYear AND 2KT.PAttern = Pass.PAttern

				LEFT OUTER JOIN
				( SELECT COUNT(*) AS KT3, EduYear, Pattern 
				FROM vwstdresultm SM
				INNER JOIN ( SELECT COUNT(PassFail) AS CntPassFail, SM.StdResMID
				FROM vwstdresultm SM
				INNER JOIN tblstdresult SR ON SM.StdResMID = SR.StdResMID
				INNER JOIN tbldepartmentmaster DM ON DM.DeptID = SM.CDept
				LEFT OUTER JOIN tblstudent S ON SM.UniPRN = S.uniprn
			    LEFT OUTER JOIN tblstdadm sa ON S.StdId = sa.StdID
				WHERE SM.EduYearFr = ". substr($_GET['year'],0,4) .  " 
				AND  SM.EduYearTo = ". substr($_GET['year'],5,4) .  " 
			    AND sa.EduYearFrom = ". substr($_GET['year'],0,4) .  " 
			    AND sa.EduYearTo = ". substr($_GET['year'],5,4) .  " 
			    AND sa.stdstatus = 'R' 
				AND DeptName = '" . $_GET['deptname'] . "' 
				AND PassFail = 'F'
				GROUP BY SM.StdResMID HAVING COUNT(PassFail) = 3 ) AS A ON SM.StdResMID = A.StdResMID
				GROUP BY EduYear, Pattern) AS 3KT
				ON 3KT.EduYear = Pass.EduYear AND 3KT.PAttern = Pass.PAttern

				LEFT OUTER JOIN 
				( SELECT COUNT(*) AS CntFail, EduYear, Pattern
				FROM vwstdresultm SM
				INNER JOIN tbldepartmentmaster DM ON DM.DeptID = SM.CDept
				LEFT OUTER JOIN tblstudent S ON SM.UniPRN = S.uniprn
			    LEFT OUTER JOIN tblstdadm sa ON S.StdId = sa.StdID
				WHERE SM.EduYearFr = ". substr($_GET['year'],0,4) .  " 
				AND  SM.EduYearTo = ". substr($_GET['year'],5,4) .  " 
			    AND sa.EduYearFrom = ". substr($_GET['year'],0,4) .  " 
			    AND sa.EduYearTo = ". substr($_GET['year'],5,4) .  " 
			    AND sa.stdstatus = 'R' 
				AND BLine LIKE '%FAILS%' AND BLine NOT LIKE '%A.T.K.T.%'
				AND DeptName = '" . $_GET['deptname'] . "'  
				GROUP BY EduYear, Pattern ) AS Fails
				ON Fails.EduYear = Pass.EduYear AND Fails.PAttern = Pass.PAttern

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
					echo "<td>{$EduYear} </td>";
					echo "<td>{$Pattern} </td>";
					echo "<td>{$KT1}</td>";
					echo "<td>{$KT2} </td>";
					echo "<td>{$KT3} </td>";
					echo "<td>{$CntPass} </td>";
					echo "<td>{$CntFail} </td>";
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
