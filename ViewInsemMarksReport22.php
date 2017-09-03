<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Semester Result</title>
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
			include 'db/db_connect.php';
	$sqlstd = "SELECT CONCAT(Surname,' ', FirstName, ' ', FatherName) AS stdname, MotherName,s.CNUM as cnum,sa.ESNum as examseatno,
				sa.StdId,dm.deptname
				from tblstdadm sa
				INNER JOIN tblstudent s ON s.StdID = sa.StdID 
				INNER JOIN tbldepartmentmaster dm on dm.DeptID = sa.Dept
				INNER JOIN tblcuryearauto cy ON cy.EduYearFrom = sa.EduYearFrom
				where  YEAR = 'F.E.' and COALESCE(stdstatus,'D') IN('R','P')  
				ORDER BY ESNum";
				// limit 10
				//echo $sqlstd;
			$resultstd = $mysqli->query( $sqlstd );
			echo $mysqli->error;
			$num_resultsstd = $resultstd->num_rows;
			//echo $sql;
			if( $num_resultsstd ){
				while( $rowstd = $resultstd->fetch_assoc() ){
					extract($rowstd);
					$studname = $stdname;
					$seatno = $examseatno;
					$mothername = $MotherName;
					$cno = $cnum;
		?>
<table width="90%" border="0" cellpadding="5" cellspacing="0" class="fix-table" style="margin-left: 5%;">
	<?php
		if(!isset($_SESSION)) {
			session_start();				
		}
		include 'db/db_connect.php';
	$sql = "SELECT sub.SubjectName,COALESCE(t1.TotMarks1,0) AS TotMarks1,COALESCE(T2.TotMarks2,0) AS TotMarks2
	,COALESCE(T3.TotMarks3,0) AS TotMarks3 ,PaperCode,examname,marksall1,marksall2,marksall3
FROM 
(SELECT DISTINCT SubjectName ,PaperCode
FROM tblinsemmarks IM 
INNER JOIN tblcapblockprof CBP ON IM.CapId = CBP.cbpid 
INNER JOIN tblexamblock EB ON EB.ExamBlockID = CBP.ExamBlockID 
INNER JOIN tblpapermaster PM ON PM.PaperID = EB.PaperID 
INNER JOIN tblsubjectmaster SM ON SM.SubjectID = PM.SubjectID 
INNER JOIN tblstdadm sa ON sa.rollno = IM.stdid 
INNER JOIN tblcuryearauto cy ON cy.EduYearFrom = sa.EduYearFrom 
WHERE sa.stdid = " . $StdId . " ORDER BY SubjectName) AS sub
LEFT OUTER JOIN 
(SELECT distinct SubjectName, CASE COALESCE(IM.stdstatus,'') WHEN 'A' THEN 'AA' ELSE CONVERT((Q1 + Q2 + Q3 + Q4 + Q5 + Q6 + Q7 + Q8 + Q9 + Q10 + Q11 + Q12 + Q13 + Q14 + Q15 + Q16 + Q17 + Q18 + Q19 + Q20) , CHAR(10)) END AS TotMarks1,InSem as marksall1
FROM tblinsemmarks IM 
INNER JOIN tblcapblockprof CBP ON IM.CapId = CBP.cbpid 
INNER JOIN tblexamblock EB ON EB.ExamBlockID = CBP.ExamBlockID 
INNER JOIN tblpapermaster PM ON PM.PaperID = EB.PaperID 
INNER JOIN tblsubjectmaster SM ON SM.SubjectID = PM.SubjectID 
INNER JOIN tblstdadm sa ON sa.rollno = IM.stdid 
INNER JOIN tblcuryearauto cy ON cy.EduYearFrom = sa.EduYearFrom 
INNER JOIN tblexammaster em ON em.ExamID = CBP.ExamId 
WHERE sa.stdid = " . $StdId . " AND examname LIKE '%T1%' 
ORDER BY SubjectName) AS t1 ON sub.SubjectName = t1.SubjectName
LEFT OUTER JOIN 
(SELECT SubjectName, CASE COALESCE(IM.stdstatus,'') WHEN 'A' THEN 'AA' ELSE CONVERT((Q1 + Q2 + Q3 + Q4 + Q5 + Q6 + Q7 + Q8 + Q9 + Q10 + Q11 + Q12 + Q13 + Q14 + Q15 + Q16 + Q17 + Q18 + Q19 + Q20) , CHAR(10)) END AS TotMarks2,InSem as marksall2
FROM tblinsemmarks IM 
INNER JOIN tblcapblockprof CBP ON IM.CapId = CBP.cbpid 
INNER JOIN tblexamblock EB ON EB.ExamBlockID = CBP.ExamBlockID 
INNER JOIN tblpapermaster PM ON PM.PaperID = EB.PaperID 
INNER JOIN tblsubjectmaster SM ON SM.SubjectID = PM.SubjectID 
INNER JOIN tblstdadm sa ON sa.rollno = IM.stdid 
INNER JOIN tblcuryearauto cy ON cy.EduYearFrom = sa.EduYearFrom 
INNER JOIN tblexammaster em ON em.ExamID = CBP.ExamId 
WHERE sa.stdid = " . $StdId . " AND examname LIKE '%T2%' 
ORDER BY SubjectName) AS T2 ON sub.SubjectName = T2.SubjectName
LEFT OUTER JOIN (SELECT SubjectName, CASE COALESCE(IM.stdstatus,'') WHEN 'A' THEN 'AA' 
			ELSE CONVERT((Q1 + Q2 + Q3 + Q4 + Q5 + Q6 + Q7 + Q8 + Q9 + Q10 + Q11 + Q12 + Q13 + Q14 + Q15 + Q16 + Q17 + Q18 + Q19 + Q20) , CHAR(10)) END 
			AS TotMarks3,coalesce(Paper,0) as marksall3 ,examname
			FROM tblinsemmarks IM 
			INNER JOIN tblcapblockprof CBP ON IM.CapId = CBP.cbpid 
			INNER JOIN tblexamblock EB ON EB.ExamBlockID = CBP.ExamBlockID 
			INNER JOIN tblpapermaster PM ON PM.PaperID = EB.PaperID 
			INNER JOIN tblsubjectmaster SM ON SM.SubjectID = PM.SubjectID 
			INNER JOIN tblstdadm sa ON sa.ESNum = IM.stdid 
			INNER JOIN tblcuryearauto cy ON cy.EduYearFrom = sa.EduYearFrom 
			INNER JOIN tblexammaster em ON em.ExamID = CBP.ExamId WHERE sa.stdid = " . $StdId . " AND examname LIKE '%ESE%' 
			ORDER BY SubjectName) AS T3 ON sub.SubjectName = T3.SubjectName";

			// execute the sql query
			//echo $sql;
			$result = $mysqli->query( $sql );
			echo $mysqli->error;
			$num_results = $result->num_rows;
			//echo $sql;
			if( $num_results ){
				while( $row = $result->fetch_assoc() ){
					extract($row);
					if($TotMarks3 == '19.5'){
						$TotMarks3New = '20';
					}
					else{
						$TotMarks3New = $TotMarks3;
					}
					$sum = round($TotMarks1 + $TotMarks2 + $TotMarks3New);
					// set result based on total!!
					$finalresult = 'P';
					if($marksall1 == '')
							$marksall1 = 0;
					if($marksall2 == '')
							$marksall2 = 0;
					if($marksall3 == '')
							$marksall3 = 1000;
					if($marksall3 == 1000){
						$marlsall = $marksall1 ;
						//+ $marksall2
					}
					else{
						$marlsall = $marksall1 + $marksall3;
						// + $marksall2
					}
					//echo "M" . $marksall3 ."<BR/>";
					//if(stripos($examname, 'ESE') !== FALSE){
						if($marksall3 <> 1000){
							if(round(($TotMarks3New * 100)/$marksall3) < 40){
								$finalresult = 'F';
							}
						}
						else{
							if(round((($TotMarks1 + $TotMarks2) * 100)/$marlsall) < 40){
								$finalresult = 'F';
							}
						}
						if($TotMarks3New == 'AA'){
							$finalresult = 'F';
						}
						if($finalresult == 'P'){
							if(round(($sum * 100)/$marlsall) < 40){
									$finalresult = 'F';
							}
						}
					//}
					echo "<TR>";
					echo "<td>{$PaperCode}</td>";
					echo "<td>{$SubjectName}</td>";
					echo "<td>PP</td>";
					echo "<td>{$TotMarks1}</td>";
					echo "<td>{$TotMarks2}</td>";
					if($PaperCode == 'ES 1102'){
						echo "<td>-</td>";
					}
					else{
						echo "<td>{$TotMarks3New}</td>";
					}
					echo "<td>{$sum}</td>";
					echo "<td>{$marlsall} </td>";
					if($finalresult == 'P'){
						if(round(($sum * 100)/$marlsall) >= 90){
									$finalresult = 'O';
						}
						else if(round(($sum * 100)/$marlsall) > 79 &&  round(($sum * 100)/$marlsall) < 90){
									$finalresult = 'A+';
						}
						else if(round(($sum * 100)/$marlsall) > 69 &&  round(($sum * 100)/$marlsall) < 80){
									$finalresult = 'A';
						}
						else if(round(($sum * 100)/$marlsall) > 59 &&  round(($sum * 100)/$marlsall) < 70){
									$finalresult = 'B+';
						}
						else if(round(($sum * 100)/$marlsall) > 49 &&  round(($sum * 100)/$marlsall) < 60){
									$finalresult = 'B';
						}
						else if(round(($sum * 100)/$marlsall) > 39 &&  round(($sum * 100)/$marlsall) < 50){
									$finalresult = 'C';
						}
						echo "<td>{$finalresult}</td>";
					}
					else{
						echo "<td>{$finalresult}</td>";
					}
					echo "</TR>";
				}
			}					
			//disconnect from database	
			$result->free();
			
			$sql2 = "SELECT PaperCode,SM.SubjectName AS SubjectName,'-' AS M1,'-' AS M2,'-' AS M3,marks AS TotMarks,
					CASE WHEN COALESCE(PracticalPRapp,0) = 1 THEN PracticalPR ELSE 
					CASE WHEN COALESCE(OralORapp,0) = 1 THEN OralOR 
					ELSE CASE WHEN COALESCE(TermWorkapp,0) = 1 THEN TermWork ELSE 1
					END END END AS marksall,
					CASE WHEN COALESCE(PracticalPRapp,0) = 1 THEN 'PR' ELSE 
					CASE WHEN COALESCE(OralORapp,0) = 1 THEN 'OR' 
					ELSE CASE WHEN COALESCE(TermWorkapp,0) = 1 THEN 'TW' 
					END END END as headtype
					FROM tblstdadm sa 
					INNER JOIN tblpapermaster pm ON SUBSTRING(pm.EnggYear,1,2) = REPLACE(YEAR,'.','') AND COALESCE(StdStatus,'') IN ('R','P') 
					INNER JOIN tblsubjectmaster SM ON SM.SubjectID = pm.SubjectID 
					INNER JOIN tbldivmaster dm ON REPLACE(dm.Year,'.','') = SUBSTRING(pm.EnggYear,1,2) 
					INNER JOIN tblcuryearauto cy ON cy.EduYearFrom = dm.EduYearFrom AND cy.Sem = SUBSTRING(EnggYear,LENGTH(EnggYear),1) 
					INNER JOIN `tblpatternmaster` patm ON patm.acadyear = CONCAT(cy.EduYearFrom,'-',SUBSTRING(cy.EduYearTo,3,2)) AND 
					dm.year = patm.eduyear AND pm.EnggPattern = patm.teachingpat 
					INNER JOIN tblcapblockprof cpb ON cpb.ExamBlockID = pm.PaperID AND cpb.`div` = dm.DivName 
					INNER JOIN tblprormarks prormarks ON cpb.cbpid = prormarks.cbpid AND prormarks.stdadmid = sa.StdAdmID 
					WHERE (COALESCE(PracticalPRapp,0) = 1 OR COALESCE(OralORapp,0) = 1 OR COALESCE(TermWorkapp,0) = 1 ) 
					AND sa.stdid = " . $StdId . " 
					AND cpb.ExamID IN (SELECT ExamID FROM tblexammaster WHERE examname LIKE '%ESE%')";
					$result2 = $mysqli->query( $sql2 );
			echo $mysqli->error;
			$num_results2 = $result2->num_rows;
			//echo $sql;
			if( $num_results2 ){
				while( $row2 = $result2->fetch_assoc() ){
					extract($row2);
					$finalresult = 'P';
						if(round(($TotMarks * 100)/$marksall) < 40){
							$finalresult = 'F';
						}
						if($TotMarks == 'AA'){
							$finalresult = 'F';
						}						
					echo "<TR>";
					echo "<td>{$PaperCode}</td>";
					echo "<td>{$SubjectName} </td>";
					echo "<td>{$headtype} </td>";
					echo "<td>{$M1} </td>";
					echo "<td>{$M2} </td>";
					echo "<td>{$M3} </td>";
					echo "<td>{$TotMarks} </td>";
					echo "<td>{$marksall} </td>";
					if($finalresult == 'P'){
						if(round(($TotMarks * 100)/$marksall) >= 90){
									$finalresult = 'O';
						}
						else if(round(($TotMarks * 100)/$marksall) > 79 &&  round(($TotMarks * 100)/$marksall) < 90){
									$finalresult = 'A+';
						}
						else if(round(($TotMarks * 100)/$marksall) > 69 &&  round(($TotMarks * 100)/$marksall) < 80){
									$finalresult = 'A';
						}
						else if(round(($TotMarks * 100)/$marksall) > 59 &&  round(($TotMarks * 100)/$marksall) < 70){
									$finalresult = 'B+';
						}
						else if(round(($TotMarks * 100)/$marksall) > 49 &&  round(($TotMarks * 100)/$marksall) < 60){
									$finalresult = 'B';
						}
						else if(round(($TotMarks * 100)/$marksall) > 39 &&  round(($TotMarks * 100)/$marksall) < 50){
									$finalresult = 'C';
						}
						echo "<td>{$finalresult}</td>";
					}
					else{
						echo "<td>{$finalresult}</td>";
					}
					echo "</TR>";
				}
			}					
			//disconnect from database	
			$result2->free();
			$mysqli->close();
    echo "</table>";
				}
			}
	?>
</body>
</html>
