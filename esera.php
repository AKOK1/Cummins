<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ESE Result Analysis</title>
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
<?php
	if(!isset($_SESSION)){
		session_start();
	}
		if(!isset($_SESSION)){
			session_start();
		}
		$_SESSION["SESSSelectedExam"] = $_POST['ddlExam'];
		$_SESSION["SESSSelectedExamName"] = $_POST['hdnexamname'];		
		include 'db/db_connect.php';
		$sql2 = "SELECT CONCAT(AcadYearFrom,' - ', AcadYearTo) AS acadyear,Sem FROM tblexammaster WHERE examid = " . $_SESSION["SESSCAPSelectedExam"] ."";
		$result2 = $mysqli->query( $sql2 );
		while( $row = $result2->fetch_assoc() ) {
			extract($row);
		}
		//echo $sql2;
?>

	<table class='branch-table' style='width:100%;'>
		<tr>
			<td><center><img src='images/logo.png' alt='logo' width='577' height='91' /></center></td>
		</tr>
	</table>
		<br/>
	<br/>
	<table width="90%" cellpadding="5" cellspacing="0" class="fix-table" style="margin-left: 5%;">
	<TR>
		<td colspan='7' class='th-heading'><center>Result Analysis</center><br/>
		<center><?php echo "Academic Year: " . $acadyear . "&nbsp;Department: " . $_GET['deptname'] . "&nbsp;Year: " . $_GET['year'] . "&nbsp;Sem " . $Sem; ?></center></td>
	</TR>
	</table>
	<br/><br/>
<table width="100%" border="0" cellpadding="5" cellspacing="0" class="fix-table" style="margin-left: 0%;">
	<tr class="th">
		<td>Sr. No.</td>
		<td>CNUM</td>
		<td>Roll No</td>
		<td>Seat Number</td>
		<td>Student Name</td>
		<td>Division</td>
		
		<?php
			
				include 'db/db_connect.php';
				$sql1 = "SELECT DISTINCT pm.PaperID,sm.SubjectName
						FROM tblexamblock eb 
						INNER JOIN tblpapermaster pm ON pm.PaperID = eb.PaperID 
						INNER JOIN tblsubjectmaster sm ON sm.SubjectID = pm.SubjectID 
						INNER JOIN tblblocksmaster bm ON bm.BlockID = eb.BlockID 
						INNER JOIN tblexamschedule es ON es.ExamSchID = eb.ExamSchID
						WHERE eb.ExamSchID IN (SELECT ExamSchID FROM tblexamschedule WHERE ExamID = " . $_SESSION["SESSCAPSelectedExam"] . ")  and coalesce(Paperapp,0) = 1 and pm.DeptID = " . $_GET['dept'] . "
						ORDER BY sm.SubjectName";
				//echo $sql;
				$j = 0;
				$result1 = $mysqli->query( $sql1 );
				$num_results1 = $result1->num_rows;
				if( $num_results1 ){
					while( $row1 = $result1->fetch_assoc() ){
						extract($row1);
						$ArrPapers[$j] = $PaperID;
						$j = $j +1;
						//echo "<td >{$AttDate}</td>";
						for($i= 1;$i<=4 ;$i++) {
						echo "<td >" . $SubjectName . "</td>";
					}
				}
			}				//echo "aaa" . count($ArrPapers) . "bbb";
			?>
	</tr>
	<tr>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<?php
				// $paperidArrayorpr = []; 
				// include 'db/db_connect.php';
				// $sqlorpr = "SELECT DISTINCT pm.PaperID,CASE WHEN COALESCE(PracticalPRapp,0) = 1 THEN 'PR' ELSE CASE WHEN COALESCE(OralORapp,0) = 1 THEN 'OR' ELSE 
				// CASE WHEN COALESCE(TermWorkapp,0) = 1 THEN 'TW' ELSE '' END END END AS subtype 
				// FROM tblpapermaster pm 
				// LEFT OUTER JOIN tbldivmaster dm ON REPLACE(dm.Year,'.','') = SUBSTRING(pm.EnggYear,1,2) 
				// LEFT OUTER JOIN tblcuryear cy ON cy.EduYearFrom = dm.EduYearFrom AND cy.Sem = SUBSTRING(EnggYear,LENGTH(EnggYear),1) 
				// LEFT OUTER JOIN `tblpatternmaster` patm ON patm.acadyear = CONCAT(cy.EduYearFrom,'-',SUBSTRING(cy.EduYearTo,3,2)) 
				// AND dm.year = patm.eduyear AND pm.EnggPattern = patm.teachingpat 
				// LEFT OUTER JOIN tblsubjectmaster sm ON sm.SubjectID = pm.SubjectID 
				// WHERE (COALESCE(PracticalPRapp,0) = 1 OR COALESCE(OralORapp,0) = 1 OR COALESCE(TermWorkapp,0) = 1 ) AND CONCAT(PaperID,dm.DivName) 
				// IN (SELECT CONCAT(ExamBlockID,COALESCE(`div`,'')) 
				// FROM tblcapblockprof WHERE ExamID = " . $_SESSION["SESSCAPSelectedExam"] . ") 
				// ORDER BY sm.SubjectName";
				// $resultorpr = $mysqli->query( $sqlorpr );
				// $num_resultsorpr = $resultorpr->num_rows;
				// if( $num_resultsorpr ){
					// while( $roworpr = $resultorpr->fetch_assoc() ){
						// extract($roworpr);
						// $paperidArrayorpr[] = $PaperID;
						// $Arrayorpr[] = $subtype;
					// }
				// }

				//$paperidArray = []; 
				$sql = "SELECT DISTINCT pm.PaperID,sm.SubjectName
						FROM tblexamblock eb 
						INNER JOIN tblpapermaster pm ON pm.PaperID = eb.PaperID 
						INNER JOIN tblsubjectmaster sm ON sm.SubjectID = pm.SubjectID 
						INNER JOIN tblblocksmaster bm ON bm.BlockID = eb.BlockID 
						INNER JOIN tblexamschedule es ON es.ExamSchID = eb.ExamSchID
						WHERE eb.ExamSchID IN (SELECT ExamSchID FROM tblexamschedule WHERE ExamID = " . $_SESSION["SESSCAPSelectedExam"] . ") and coalesce(Paperapp,0) = 1 and pm.DeptID = " . $_GET['dept'] . "
						ORDER BY sm.SubjectName";
				//echo $sql;
				$z = 0;
				$m = 0;
				$result = $mysqli->query( $sql );
				$num_results = $result->num_rows;
				if( $num_results ){
					while( $row = $result->fetch_assoc() ){
						extract($row);
						$ArrPapers[$j] = $PaperID;
								echo"<td>T1</td>";
								echo"<td>T2</td>";	
								echo"<td>ESE</td>";	
								echo"<td>Total</td>";	
								// - - add code get the PR OR TW or blank and show here.....then also show marks below!!
								//if($paperidArrayorpr[$m] == $PaperID){
								//	echo"<td>{$Arrayorpr[$m]}</td>";	
								//	$m = $m + 1;
								//}
								//echo"<td>Grand Total</td>";	
						$paperidArray[] = $PaperID;
						$z = $z  + 1;
					}
				}
	?>
	</tr>
	<?php
		if(!isset($_SESSION)) {
			session_start();				
		}
		if($_GET['year'] == 'F.E.'){
			if(stripos($_SESSION["SESSCAPSelectedExamName"], 'Regular') > 0 ){
				$sqlstd = "SELECT DISTINCT sa.StdId,sa.div as division,CNUM,CONCAT(Surname,' ', FirstName, ' ',FatherName) AS StdName,sa.ESNum,RollNo
						FROM tblstdadm sa
						INNER JOIN tblstudent s ON s.StdID = sa.StdID 
						INNER JOIN `tblyearstructstd` yss ON sa.StdAdmID = yss.StdAdmID
						INNER JOIN `tblyearstruct` ys ON ys.rowid = yss.YSID
						INNER JOIN tblcuryearauto cy ON cy.EduYearFrom = ys.eduyearfrom 
						WHERE COALESCE(stdstatus,'D') IN('R','P') AND COALESCE(ESNum, '') <> '' and cy.EduYearFrom = sa.EduYearFrom AND YEAR = '" . $_GET['year'] . "'  ORDER BY sa.ESNum";
			}
			else{
				$sqlstd = "SELECT DISTINCT sa.StdId,sa.div as division,CNUM,CONCAT(Surname,' ', FirstName, ' ',FatherName) AS StdName,sa.ESNum,RollNo
						FROM tblstdadm sa
						INNER JOIN tblstudent s ON s.StdID = sa.StdID 
						INNER JOIN `tblyearstructstdretest` yss ON sa.StdAdmID = yss.StdAdmID
						INNER JOIN `tblyearstruct` ys ON ys.rowid = yss.YSID
						INNER JOIN tblcuryearauto cy ON cy.EduYearFrom = ys.eduyearfrom AND yss.Sem = " . $Sem . "
						WHERE COALESCE(stdstatus,'D') IN('R','P') AND COALESCE(ESNum, '') <> '' and cy.EduYearFrom = sa.EduYearFrom AND YEAR = '" . $_GET['year'] . "'  ORDER BY sa.ESNum";						
			}
		}
		else{
			if(stripos($_SESSION["SESSCAPSelectedExamName"], 'Regular') > 0 ){
				$sqlstd = "SELECT DISTINCT sa.StdId,sa.div as division,CNUM,CONCAT(Surname,' ', FirstName, ' ',FatherName) AS StdName,sa.ESNum,RollNo
						FROM tblstdadm sa
						INNER JOIN tblstudent s ON s.StdID = sa.StdID 
						INNER JOIN `tblyearstructstd` yss ON sa.StdAdmID = yss.StdAdmID
						INNER JOIN `tblyearstruct` ys ON ys.rowid = yss.YSID
						INNER JOIN tblcuryearauto cy ON cy.EduYearFrom = ys.eduyearfrom 
						WHERE COALESCE(stdstatus,'D') IN('R','P') AND COALESCE(ESNum, '') <> '' and sa.Dept = " . $_GET['dept'] . " and cy.EduYearFrom = sa.EduYearFrom AND YEAR = '" . $_GET['year'] . "'  ORDER BY sa.ESNum";
			}
			else{
				$sqlstd = "SELECT DISTINCT sa.StdId,sa.div as division,CNUM,CONCAT(Surname,' ', FirstName, ' ',FatherName) AS StdName,sa.ESNum,RollNo
						FROM tblstdadm sa
						INNER JOIN tblstudent s ON s.StdID = sa.StdID 
						INNER JOIN `tblyearstructstdretest` yss ON sa.StdAdmID = yss.StdAdmID
						INNER JOIN `tblyearstruct` ys ON ys.rowid = yss.YSID
						INNER JOIN tblcuryearauto cy ON cy.EduYearFrom = ys.eduyearfrom AND yss.Sem = " . $Sem . "
						WHERE COALESCE(stdstatus,'D') IN('R','P') AND COALESCE(ESNum, '') <> '' and sa.Dept = " . $_GET['dept'] . " and cy.EduYearFrom = sa.EduYearFrom AND YEAR = '" . $_GET['year'] . "'  ORDER BY sa.ESNum";						
			}
		}

				// limit 10
					//echo $sqlstd;
			$resultstd = $mysqli->query( $sqlstd );
			echo $mysqli->error;
			$num_resultsstd = $resultstd->num_rows;
 			$j = 1;
			//echo $sql;
			if( $num_resultsstd ){
				while( $rowstd = $resultstd->fetch_assoc() ){
					extract($rowstd);
					echo "<TR>";
					echo "<td>$j</td>";
					echo "<td>{$CNUM} </td>";
					echo "<td>{$RollNo} </td>";
					echo "<td>{$ESNum} </td>";
					echo "<td>{$StdName} </td>";
					echo "<td>{$division} </td>";
					$j += 1;
					for($l= 0;$l<$z ;$l++) {
						$sql = "SELECT (COALESCE(t1.TotMarks1,0)) AS TotMarks1,(COALESCE(T2.TotMarks2,0)) AS TotMarks2,(COALESCE(ese.esemarks,0)) AS esemarks
						FROM (SELECT sa.StdID, CASE COALESCE(IM.stdstatus,'') WHEN 'A' THEN 'AA' 
						ELSE CONVERT(SUM(Q1 + Q2 + Q3 + Q4 + Q5 + Q6 + Q7 + Q8 + Q9 + Q10 + Q11 + Q12 + Q13 + Q14 + Q15 + Q16 + Q17 + Q18 + Q19 + Q20) , CHAR(10)) END 
							AS TotMarks1 FROM tblinsemmarks IM 
						INNER JOIN tblcapblockprof CBP ON IM.CapId = CBP.cbpid 
						INNER JOIN tblexamblock EB ON EB.ExamBlockID = CBP.ExamBlockID 
						INNER JOIN tblstdadm sa ON sa.rollno = IM.stdid  AND YEAR = '" . $_GET['year'] . "'
						INNER JOIN tblcuryearauto cy ON cy.EduYearFrom = sa.EduYearFrom 
						INNER JOIN tblexammaster em ON em.ExamID = CBP.ExamId 
						WHERE examname LIKE '%T1%' and EB.PaperID = " . $paperidArray[$l] . " and sa.StdID = " . $StdId . "
						GROUP BY sa.StdID) AS t1 
						LEFT OUTER JOIN (SELECT sa.StdID, 
						CASE COALESCE(IM.stdstatus,'') WHEN 'A' THEN 'AA' 
						ELSE CONVERT(SUM(Q1 + Q2 + Q3 + Q4 + Q5 + Q6 + Q7 + Q8 + Q9 + Q10 + Q11 + Q12 + Q13 + Q14 + Q15 + Q16 + Q17 + Q18 + Q19 + Q20) , 
						CHAR(10)) END AS TotMarks2 
						FROM tblinsemmarks IM 
						INNER JOIN tblcapblockprof CBP ON IM.CapId = CBP.cbpid 
						INNER JOIN tblexamblock EB ON EB.ExamBlockID = CBP.ExamBlockID 
						INNER JOIN tblstdadm sa ON sa.rollno = IM.stdid  AND YEAR = '" . $_GET['year'] . "'
						INNER JOIN tblcuryearauto cy ON cy.EduYearFrom = sa.EduYearFrom 
						INNER JOIN tblexammaster em ON em.ExamID = CBP.ExamId 
						WHERE examname LIKE '%T2%'  and EB.PaperID = " . $paperidArray[$l] . " and sa.StdID = " . $StdId . "
						GROUP BY sa.StdID) AS T2 ON 
						t1.StdID = T2.StdID
						LEFT OUTER JOIN 
						(SELECT sa.StdID,sa.div as division, CASE COALESCE(IM.stdstatus,'') WHEN 'A' THEN 'AA' 
									ELSE CONVERT(SUM(Q1 + Q2 + Q3 + Q4 + Q5 + Q6 + Q7 + Q8 + Q9 + Q10 + 
						Q11 + Q12 + Q13 + Q14 + Q15 + Q16 + Q17 + Q18 + Q19 + Q20) , CHAR(10)) END 
							AS esemarks 
							FROM tblinsemmarks IM 
						INNER JOIN tblcapblockprof CBP ON IM.CapId = CBP.cbpid 
						INNER JOIN tblexamblock EB ON EB.ExamBlockID = CBP.ExamBlockID 
						INNER JOIN tblstdadm sa ON sa.ESNum = IM.stdid  AND YEAR = '" . $_GET['year'] . "'
						INNER JOIN tblcuryearauto cy ON cy.EduYearFrom = sa.EduYearFrom
						INNER JOIN tblexammaster em ON em.ExamID = CBP.ExamId ";
						if(stripos($_SESSION["SESSCAPSelectedExamName"], 'Regular') > 0 ){
							$sql = $sql . " WHERE examname LIKE '%regular%'  and EB.PaperID = " . $paperidArray[$l] . " and sa.StdID = " . $StdId . "";
						}
						else{
							$sql = $sql . " WHERE examname LIKE '%retest%'  and EB.PaperID = " . $paperidArray[$l] . " and sa.StdID = " . $StdId . "";
						}
						$sql = $sql . " GROUP BY sa.StdID) AS ese ON t1.StdID = ese.StdID";

						// execute the sql query
						//echo $sql;
						//die;
						$result = $mysqli->query( $sql );
						echo $mysqli->error;
						$num_results = $result->num_rows;
						//echo $sql;
						if( $num_results ){
							while( $row = $result->fetch_assoc() ){
								extract($row);
								$total = round($TotMarks1 + $TotMarks2 + $esemarks);
								echo "<td>{$TotMarks1} </td>";
								echo "<td>{$TotMarks2} </td>";
								echo "<td>{$esemarks} </td>";
								echo "<td>{$total}</td>";
							}
						}		
					}
					echo "</TR>";
				}
			}

			//disconnect from database	
			$result->free();
			$mysqli->close();
	?>
    </table>
</body>
</html>
