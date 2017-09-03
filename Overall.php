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
<title>Overall Result</title>
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
	<TR>
		<td colspan='22' class='th-heading'><center><h2>Overall Result for Exam: <?php echo $selexamname; ?></h2></center></td></TR>
	<TR>
		<td colspan='22' class='th-heading'><center><h2>Academic Year: <?php echo $_GET['year']; ?></h2></center></td></TR>
    </tr>
	<tr class="th">
	
		<td rowspan="2"width="10">Year (Total Number Of Students)</td>
		<td rowspan="2"width="10"><center>FE</center></td>
		<td colspan="6"width="80"><center>SE</center></td>
		<td colspan="6"width="80"><center>TE</center></td>
		<td colspan="6"width="80"><center>BE</center></td>
	</tr>

	<tr>
		<td class="th"width="10"><center>Mech</center></td>
		<td class="th"width="10"><center>EnTC</center></td>
		<td class="th"width="10"><center>Instru</center></td>
		<td class="th"width="10"><center>Comp</center></td>
		<td class="th"width="10"><center>IT</center></td>
		<td class="th"width="10"><center>Total</center></td>
		<td class="th"width="10"><center>Mech</center></td>
		<td class="th"width="10"><center>EnTC</center></td>
		<td class="th"width="10"><center>Instru</center></td>
		<td class="th"width="10"><center>Comp</center></td>
		<td class="th"width="10"><center>IT</center></td>
		<td class="th"width="10"><center>Total</center></td>
		<td class="th"width="10"><center>Mech</center></td>
		<td class="th"width="10"><center>EnTC</center></td>
		<td class="th"width="10"><center>Instru</center></td>
		<td class="th"width="10"><center>Comp</center></td>
		<td class="th"width="10"><center>IT</center></td>
		<td class="th"width="10"><center>Total</center></td>
	</tr>
	<?php
		echo "<tr>";
		echo "<td>Appeared</td>";
		
		$sql1 = "SELECT COUNT(*) as RecCnt, EduYear, DM.DeptName, CASE EduYear WHEN  'FE' THEN 1 WHEN  'SE' THEN 2 WHEN  'TE' THEN 3 ELSE 4 END AS EduOrder 
				FROM vwstdresultm SM
				INNER JOIN tbldepartmentmaster DM ON DM.DeptID = SM.CDept
				LEFT OUTER JOIN tblstudent S ON SM.UniPRN = S.uniprn
				LEFT OUTER JOIN tblstdadm sa ON S.StdId = sa.StdID
				WHERE SM.EduYearFr = ". substr($_GET['year'],0,4) .  " 
				AND SM.EduYearTo = ". substr($_GET['year'],5,4) .  " 
				AND  SM.EduYearFr = sa.EduYearFrom 
				AND  SM.EduYearTo = sa.EduYearTo
				AND sa.stdstatus = 'R' 
				AND  Sem = ". $_GET['sem'] .  " 
				AND SM.EduYear = REPLACE(sa.Year, '.', '')
				GROUP BY EduYear, DM.DeptName, EduOrder
				ORDER BY EduOrder, DeptID"; 
				//echo $sql1;
		overall_result($sql1);
		 echo "<tr>";
		 echo "<td>Passed</td>";

		$sql2=	"SELECT COUNT(*) as RecCnt, EduYear, DM.DeptName, CASE EduYear WHEN  'FE' THEN 1 WHEN  'SE' THEN 2 WHEN  'TE' THEN 3 ELSE 4 END AS EduOrder 
				FROM vwstdresultm SM
				INNER JOIN tbldepartmentmaster DM ON DM.DeptID = SM.CDept 
				LEFT OUTER JOIN tblstudent S ON SM.UniPRN = S.uniprn
				LEFT OUTER JOIN tblstdadm sa ON S.StdId = sa.StdID
				WHERE SM.EduYearFr = ". substr($_GET['year'],0,4) .  " 
				AND SM.EduYearTo = ". substr($_GET['year'],5,4) .  " 
				AND  SM.EduYearFr = sa.EduYearFrom 
				AND  SM.EduYearTo = sa.EduYearTo
				AND sa.stdstatus = 'R' 
				AND Sem = ". $_GET['sem'] .  " 
				AND (BLine NOT LIKE '%FAILS%' or BLine is NULL)
				GROUP BY EduYear, DM.DeptName, EduOrder
				ORDER BY EduOrder, DeptID";	
		
		 //echo ($sql2);
		 overall_result($sql2);
				
		 echo "<tr>";
		 echo "<td>Failed</td>";

		$sql3=	"SELECT COUNT(*) as RecCnt, EduYear, DM.DeptName, CASE EduYear WHEN  'FE' THEN 1 WHEN  'SE' THEN 2 WHEN  'TE' THEN 3 ELSE 4 END AS EduOrder 
				FROM vwstdresultm SM
				INNER JOIN tbldepartmentmaster DM ON DM.DeptID = SM.CDept 
				LEFT OUTER JOIN tblstudent S ON SM.UniPRN = S.uniprn
				LEFT OUTER JOIN tblstdadm sa ON S.StdId = sa.StdID
				WHERE SM.EduYearFr = ". substr($_GET['year'],0,4) .  " 
				AND SM.EduYearTo = ". substr($_GET['year'],5,4) .  " 
				AND  SM.EduYearFr = sa.EduYearFrom 
				AND  SM.EduYearTo = sa.EduYearTo
				AND sa.stdstatus = 'R' 
				AND  Sem = ". $_GET['sem'] .  " 
				AND BLine LIKE '%FAILS%' AND BLine NOT LIKE '%A.T.K.T.%'
				GROUP BY EduYear, DM.DeptName, EduOrder
				ORDER BY EduOrder, DeptID";	
		
		 overall_result($sql3);
		 
		 echo "<tr>";
		 echo "<td>First Class With Distinction</td>";

		$sql4=	"SELECT COUNT(*) as RecCnt, EduYear, DM.DeptName, CASE EduYear WHEN  'FE' THEN 1 WHEN  'SE' THEN 2 WHEN  'TE' THEN 3 ELSE 4 END AS EduOrder 
				FROM vwstdresultm SM
				INNER JOIN tbldepartmentmaster DM ON DM.DeptID = SM.CDept 
				LEFT OUTER JOIN tblstudent S ON SM.UniPRN = S.uniprn
				LEFT OUTER JOIN tblstdadm sa ON S.StdId = sa.StdID
				WHERE SM.EduYearFr = ". substr($_GET['year'],0,4) .  " 
				AND SM.EduYearTo = ". substr($_GET['year'],5,4) .  " 
				AND  SM.EduYearFr = sa.EduYearFrom 
				AND  SM.EduYearTo = sa.EduYearTo
				AND sa.stdstatus = 'R' 
				AND  Sem = ". $_GET['sem'] .  " 
				AND BLine LIKE '%FIRST CLASS WITH DISTINCTION%'
				GROUP BY EduYear, DM.DeptName, EduOrder
				ORDER BY EduOrder, DeptID";	
		
		 overall_result($sql4);
		 
		 echo "<tr>";
		 echo "<td>First Class </td>";

		$sql5=	"SELECT COUNT(*) as RecCnt, EduYear, DM.DeptName, CASE EduYear WHEN  'FE' THEN 1 WHEN  'SE' THEN 2 WHEN  'TE' THEN 3 ELSE 4 END AS EduOrder 
				FROM vwstdresultm SM
				INNER JOIN tbldepartmentmaster DM ON DM.DeptID = SM.CDept 
				LEFT OUTER JOIN tblstudent S ON SM.UniPRN = S.uniprn
				LEFT OUTER JOIN tblstdadm sa ON S.StdId = sa.StdID
				WHERE SM.EduYearFr = ". substr($_GET['year'],0,4) .  " 
				AND SM.EduYearTo = ". substr($_GET['year'],5,4) .  " 
				AND  SM.EduYearFr = sa.EduYearFrom 
				AND  SM.EduYearTo = sa.EduYearTo
				AND sa.stdstatus = 'R' 
				AND  Sem = ". $_GET['sem'] .  " 
				AND BLine LIKE '%FIRST CLASS%' 
				AND BLine NOT LIKE '%FIRST CLASS WITH DISTINCTION%'
				GROUP BY EduYear, DM.DeptName, EduOrder
				ORDER BY EduOrder, DeptID";	
		 //echo $sql5;
		 overall_result($sql5);
		 
		 echo "<tr>";
		 echo "<td>Higher Second Class </td>";

		$sql6=	"SELECT COUNT(*) as RecCnt, EduYear, DM.DeptName, CASE EduYear WHEN  'FE' THEN 1 WHEN  'SE' THEN 2 WHEN  'TE' THEN 3 ELSE 4 END AS EduOrder 
				FROM vwstdresultm SM 
				INNER JOIN tbldepartmentmaster DM ON DM.DeptID = SM.CDept 
				LEFT OUTER JOIN tblstudent S ON SM.UniPRN = S.uniprn
				LEFT OUTER JOIN tblstdadm sa ON S.StdId = sa.StdID
				WHERE SM.EduYearFr = ". substr($_GET['year'],0,4) .  " 
				AND SM.EduYearTo = ". substr($_GET['year'],5,4) .  " 
				AND  SM.EduYearFr = sa.EduYearFrom 
				AND  SM.EduYearTo = sa.EduYearTo
				AND sa.stdstatus = 'R' 
				AND  Sem = ". $_GET['sem'] .  " 
				AND BLine LIKE '%HIGHER SECOND CLASS%' 
				GROUP BY EduYear, DM.DeptName, EduOrder
				ORDER BY EduOrder, DeptID";	
		 //echo $sql6;
		 overall_result($sql6);
		 
		 echo "<tr>";
		 echo "<td>Second Class </td>";

		$sql7=	"SELECT COUNT(*) as RecCnt, EduYear, DM.DeptName, CASE EduYear WHEN  'FE' THEN 1 WHEN  'SE' THEN 2 WHEN  'TE' THEN 3 ELSE 4 END AS EduOrder 
				FROM vwstdresultm SM 
				INNER JOIN tbldepartmentmaster DM ON DM.DeptID = SM.CDept 
				LEFT OUTER JOIN tblstudent S ON SM.UniPRN = S.uniprn
				LEFT OUTER JOIN tblstdadm sa ON S.StdId = sa.StdID
				WHERE SM.EduYearFr = ". substr($_GET['year'],0,4) .  " 
				AND SM.EduYearTo = ". substr($_GET['year'],5,4) .  " 
				AND  SM.EduYearFr = sa.EduYearFrom 
				AND  SM.EduYearTo = sa.EduYearTo
				AND sa.stdstatus = 'R' 
				AND  Sem = ". $_GET['sem'] .  " 
				AND BLine LIKE '%SECOND CLASS%' 
				AND BLine NOT LIKE '%HIGHER SECOND CLASS%' 
				GROUP BY EduYear, DM.DeptName, EduOrder 
				ORDER BY EduOrder, DeptID";	 
		//echo $sql7;
		 overall_result($sql7);

		 echo "<tr>";
		 echo "<td>Pass Class </td>";

		$sql8=	"SELECT COUNT(*) as RecCnt, EduYear, DM.DeptName, CASE EduYear WHEN  'FE' THEN 1 WHEN  'SE' THEN 2 WHEN  'TE' THEN 3 ELSE 4 END AS EduOrder 
				FROM vwstdresultm SM
				INNER JOIN tbldepartmentmaster DM ON DM.DeptID = SM.CDept 
				LEFT OUTER JOIN tblstudent S ON SM.UniPRN = S.uniprn
				LEFT OUTER JOIN tblstdadm sa ON S.StdId = sa.StdID
				WHERE SM.EduYearFr = ". substr($_GET['year'],0,4) .  " 
				AND SM.EduYearTo = ". substr($_GET['year'],5,4) .  " 
				AND  SM.EduYearFr = sa.EduYearFrom 
				AND  SM.EduYearTo = sa.EduYearTo
				AND sa.stdstatus = 'R' 
				AND  Sem = ". $_GET['sem'] .  " 
				AND BLine LIKE '%PASS CLASS%' 
				GROUP BY EduYear, DM.DeptName, EduOrder
				ORDER BY EduOrder, DeptID";	
		 //echo $sql8;
		 overall_result($sql8);
		 
		 echo "<tr>";
		 echo "<td>ATKT </td>";

		$sql9=	"SELECT COUNT(*) as RecCnt, EduYear, DM.DeptName, CASE EduYear WHEN  'FE' THEN 1 WHEN  'SE' THEN 2 WHEN  'TE' THEN 3 ELSE 4 END AS EduOrder 
				FROM vwstdresultm SM
				INNER JOIN tbldepartmentmaster DM ON DM.DeptID = SM.CDept 
				LEFT OUTER JOIN tblstudent S ON SM.UniPRN = S.uniprn
				LEFT OUTER JOIN tblstdadm sa ON S.StdId = sa.StdID
				WHERE SM.EduYearFr = ". substr($_GET['year'],0,4) .  " 
				AND SM.EduYearTo = ". substr($_GET['year'],5,4) .  " 
				AND  SM.EduYearFr = sa.EduYearFrom 
				AND  SM.EduYearTo = sa.EduYearTo
				AND sa.stdstatus = 'R' 
				AND  Sem = ". $_GET['sem'] .  " 
				AND BLine LIKE '%A.T.K.T.%' 
				GROUP BY EduYear, DM.DeptName, EduOrder
				ORDER BY EduOrder, DeptID";	
		 //echo $sql9;
		 overall_result($sql9);
?>  
	</table></td>
</table>
</body>
</html>
<?php
		
	function overall_result($sql) {	
		include 'db/db_connect.php';
		for ($i = 0; $i <=18; $i++) {
			$arr[$i]='0';
		}
		
		// echo $sql;
		// execute the sql query
		//echo $sql . "<br/>";
		$result = $mysqli->query( $sql );
		$num_results = $result->num_rows;
		if( $num_results ){
			//$arr=array();
			$arrcnt=0;
			while( $row = $result->fetch_assoc() ){
				extract($row);
				if ( $EduYear == 'FE'  ) { $arr[0]=$RecCnt;}
				if ( $EduYear == 'SE' && $DeptName == 'Mech'  ) 	{ $arr[1]=$RecCnt; }
				if ( $EduYear == 'SE' && $DeptName == 'EnTC'  ) 	{ $arr[2]=$RecCnt; }
				if ( $EduYear == 'SE' && $DeptName == 'Instru'  ) 	{ $arr[3]=$RecCnt; }
				if ( $EduYear == 'SE' && $DeptName == 'Comp'  ) 	{ $arr[4]=$RecCnt; }
				if ( $EduYear == 'SE' && $DeptName == 'IT'  ) 		{ $arr[5]=$RecCnt; }
				if ( $EduYear == 'TE' && $DeptName == 'Mech'  ) 	{ $arr[6]=$RecCnt; }
				if ( $EduYear == 'TE' && $DeptName == 'EnTC'  ) 	{ $arr[7]=$RecCnt; }
				if ( $EduYear == 'TE' && $DeptName == 'Instru'  ) 	{ $arr[8]=$RecCnt; }
				if ( $EduYear == 'TE' && $DeptName == 'Comp'  ) 	{ $arr[9]=$RecCnt; }
				if ( $EduYear == 'TE' && $DeptName == 'IT'  ) 		{ $arr[10]=$RecCnt; }
				if ( $EduYear == 'BE' && $DeptName == 'Mech'  ) 	{ $arr[11]=$RecCnt; }
				if ( $EduYear == 'BE' && $DeptName == 'EnTC'  ) 	{ $arr[12]=$RecCnt; }
				if ( $EduYear == 'BE' && $DeptName == 'Instru'  ) 	{ $arr[13]=$RecCnt; }
				if ( $EduYear == 'BE' && $DeptName == 'Comp'  ) 	{ $arr[14]=$RecCnt; }
				if ( $EduYear == 'BE' && $DeptName == 'IT'  ) 		{ $arr[15]=$RecCnt; }
				$arr[16] = $arr[1] + $arr[2] + $arr[3] + $arr[4] + $arr[5];
				$arr[17] = $arr[6] + $arr[7] + $arr[8] + $arr[9] + $arr[10];
				$arr[18] = $arr[11] + $arr[12] + $arr[13] + $arr[14] + $arr[15];
				//$arrcnt++;
			}
		}
		//disconnect from database
		$result->free();
		$mysqli->close();
		echo "<td><center>".$arr[0]."</center></td>";  // FE
		echo "<td><center>".$arr[1]."</center></td>";  // SE Mech
		echo "<td><center>".$arr[2]."</center></td>";  // SE EnTC
		echo "<td><center>".$arr[3]."</center></td>";  // SE Instru
		echo "<td><center>".$arr[4]."</center></td>";  // SE Comp
		echo "<td><center>".$arr[5]."</center></td>";  // SE IT
		echo "<td><center>".$arr[16]."</center></td>";  // SE Total
		echo "<td><center>".$arr[6]."</center></td>";  // TE Mech
		echo "<td><center>".$arr[7]."</center></td>";  // TE EnTC
		echo "<td><center>".$arr[8]."</center></td>";  // TE Instru
		echo "<td><center>".$arr[9]."</center></td>";  // TE Comp
		echo "<td><center>".$arr[10]."</center></td>"; // TE IT
		echo "<td><center>".$arr[17]."</center></td>";  // TE Total
		echo "<td><center>".$arr[11]."</center></td>"; // BE Mech
		echo "<td><center>".$arr[12]."</center></td>"; // BE EnTC
		echo "<td><center>".$arr[13]."</center></td>"; // BE Instru
		echo "<td><center>".$arr[14]."</center></td>"; // BE Comp
		echo "<td><center>".$arr[15]."</center></td>"; // BE IT
		echo "<td><center>".$arr[18]."</center></td>";  // BE Total
		echo "</tr>";
		
	}
?>