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
	line-height:15px;
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
		if(!isset($_SESSION)) {
			session_start();				
		}
		include 'db/db_connect.php';
		if($_GET['year'] == 'F.E.'){
			if(stripos($_SESSION["SESSCAPSelectedExamName"], 'Regular') > 0 ){
				$sqlstd = "SELECT distinct CONCAT(Surname,' ', FirstName, ' ', FatherName) AS stdname, MotherName,s.CNUM as cnum,sa.ESNum as examseatno,
						sa.StdId,dm.deptname,CONCAT(em.AcadYearFrom,'-',SUBSTRING(em.AcadYearTo,3,2)) as acadyear
						FROM tblstdadm sa
						INNER JOIN tblstudent s ON s.StdID = sa.StdID 
						inner join tblexamfee ef on ef.stdadmid = sa.stdadmid and ef.examid = " . $_SESSION["SESSCAPSelectedExam"] . "
						INNER JOIN tbldepartmentmaster dm on dm.DeptID = sa.Dept
						INNER JOIN `tblyearstructstd` yss ON sa.StdAdmID = yss.StdAdmID
						INNER JOIN `tblyearstruct` ys ON ys.rowid = yss.YSID
						INNER JOIN tblexammaster em ON em.AcadYearFrom = ys.eduyearfrom and em.examid = " . $_SESSION["SESSCAPSelectedExam"] . "
						WHERE COALESCE(stdstatus,'D') IN('R','P') AND COALESCE(ESNum, '') <> '' and em.AcadYearFrom = sa.EduYearFrom 
						AND YEAR = '" . $_GET['year'] . "' 
						ORDER BY ESNum";			
			}
			else{
				$sqlstd = "SELECT distinct CONCAT(Surname,' ', FirstName, ' ', FatherName) AS stdname, MotherName,s.CNUM as cnum,sa.ESNum as examseatno,
						sa.StdId,dm.deptname,CONCAT(em.AcadYearFrom,'-',SUBSTRING(em.AcadYearTo,3,2)) as acadyear
						FROM tblstdadm sa
						INNER JOIN tblstudent s ON s.StdID = sa.StdID 
						inner join tblexamfee ef on ef.stdadmid = sa.stdadmid and ef.examid = " . $_SESSION["SESSCAPSelectedExam"] . "
						INNER JOIN tbldepartmentmaster dm on dm.DeptID = sa.Dept
						INNER JOIN `tblyearstructstdretest` yss ON sa.StdAdmID = yss.StdAdmID
						INNER JOIN `tblyearstruct` ys ON ys.rowid = yss.YSID
						INNER JOIN tblexammaster em ON em.AcadYearFrom = ys.eduyearfrom and em.examid = " . $_SESSION["SESSCAPSelectedExam"] . "
						WHERE COALESCE(stdstatus,'D') IN('R','P') AND COALESCE(ESNum, '') <> '' and em.AcadYearFrom = sa.EduYearFrom
						AND YEAR = '" . $_GET['year'] . "' 
						ORDER BY ESNum";					
						//and coalesce(sa.feespaid,0) = 1  
						//AND yss.Sem = 1
			}
		}
		else{
			if(stripos($_SESSION["SESSCAPSelectedExamName"], 'Regular') > 0 ){
				$sqlstd = "SELECT distinct CONCAT(Surname,' ', FirstName, ' ', FatherName) AS stdname, MotherName,s.CNUM as cnum,sa.ESNum as examseatno,
						sa.StdId,dm.deptname,CONCAT(em.AcadYearFrom,'-',SUBSTRING(em.AcadYearTo,3,2)) as acadyear
						FROM tblstdadm sa
						INNER JOIN tblstudent s ON s.StdID = sa.StdID 
						inner join tblexamfee ef on ef.stdadmid = sa.stdadmid
						INNER JOIN tbldepartmentmaster dm on dm.DeptID = sa.Dept
						INNER JOIN `tblyearstructstd` yss ON sa.StdAdmID = yss.StdAdmID
						INNER JOIN `tblyearstruct` ys ON ys.rowid = yss.YSID
						INNER JOIN tblexammaster em ON em.AcadYearFrom = ys.eduyearfrom and em.examid = " . $_SESSION["SESSCAPSelectedExam"] . "
						WHERE COALESCE(stdstatus,'D') IN('R','P') AND COALESCE(ESNum, '') <> '' and em.AcadYearFrom = sa.EduYearFrom 
						AND YEAR = '" . $_GET['year'] . "' and sa.Dept = " . $_GET['dept'] . "  
						ORDER BY ESNum";			
			}
			else{
				$sqlstd = "SELECT distinct CONCAT(Surname,' ', FirstName, ' ', FatherName) AS stdname, MotherName,s.CNUM as cnum,sa.ESNum as examseatno,
						sa.StdId,dm.deptname,CONCAT(em.AcadYearFrom,'-',SUBSTRING(em.AcadYearTo,3,2)) as acadyear
						FROM tblstdadm sa
						INNER JOIN tblstudent s ON s.StdID = sa.StdID 
						inner join tblexamfee ef on ef.stdadmid = sa.stdadmid
						INNER JOIN tbldepartmentmaster dm on dm.DeptID = sa.Dept
						INNER JOIN `tblyearstructstdretest` yss ON sa.StdAdmID = yss.StdAdmID
						INNER JOIN `tblyearstruct` ys ON ys.rowid = yss.YSID
						INNER JOIN tblexammaster em ON em.AcadYearFrom = ys.eduyearfrom and em.examid = " . $_SESSION["SESSCAPSelectedExam"] . "
						and yss.Sem = em.Sem
						WHERE COALESCE(stdstatus,'D') IN('R','P') AND COALESCE(ESNum, '') <> '' and em.AcadYearFrom = sa.EduYearFrom 
						AND YEAR = '" . $_GET['year'] . "' and sa.Dept = " . $_GET['dept'] . "
						ORDER BY ESNum";					
						//and coalesce(sa.feespaid,0) = 1 
			}
		}
// and ef.examid = " . $_SESSION["SESSCAPSelectedExam"] . "
				// limit 10
				//echo $sqlstd;
				//die;
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
	
<center><img class="center" alt="logo" src="images/logo.png"></center>
<br/>
<h2><center>Provisional Mark Sheet</center></h2><br/>
	<div>
		<div style="float:left;margin-left:5%">
			Name of Student: <?php echo $studname;?>
		</div>
		<div style="float:right;margin-right:5%">
			C-Number: <?php echo $cno;?>
		</div>
	</div>
	</br></br>
	<div>
		<div style="float:left;margin-left:5%">
			Mother's Name: <?php echo $mothername;?>
		</div>
		<div style="float:right;margin-right:5%">
			Exam Seat Number: <?php echo $seatno;?>
		</div>
	</div>
	</br></br>
	<div>
		<div style="float:left;margin-left:5%">
			<?php 
					if(!isset($_SESSION)) {
			session_start();				
		}
			echo  substr($_SESSION["SESSCAPSelectedExamName"],0,strpos($_SESSION["SESSCAPSelectedExamName"],' '))  . " Sem " . $_SESSION["SESSCAPAcadSem"] .  " " . $deptname; ?>
		</div>
		<div style="float:right;margin-right:5%">
			Academic Year: <?php echo $acadyear;?>
		</div>
	</div>
	</br>
	<br/>
<table width="90%" border="0" cellpadding="5" cellspacing="0" class="fix-table" style="margin-left: 5%;">
	<tr class="th">
		<td width="9%">Course Code</td>
		<td width="32%">Course Name</td>
		<td width="8%">Head Type</td>
		<td width="7%">T1</td>
		<td width="7%">T2</td>
		<td width="7%">ESE</td>
		<td width="7%">Total</td>
		<td width="7%">Out Of</td>
		<td width="7%">Grade *</td>
		<td width="9%">Earned Credits</td>
	</tr>
	<?php
		if(!isset($_SESSION)) {
			session_start();				
		}
		include 'db/db_connect.php';
//INNER JOIN tblcuryearauto cy ON cy.EduYearFrom = sa.EduYearFrom  and cy.Sem = SUBSTRING(PM.EnggYear,LENGTH(PM.EnggYear),1)
//INNER JOIN tblcuryearauto cy ON cy.EduYearFrom = sa.EduYearFrom and cy.Sem = SUBSTRING(PM.EnggYear,LENGTH(PM.EnggYear),1)
//coalesce(TotMarks4,'999')
	$sql = "SELECT distinct sub.SubjectName,COALESCE(t1.TotMarks1,0) AS TotMarks1,COALESCE(T2.TotMarks2,0) AS TotMarks2
	,COALESCE(T3.TotMarks3,0) AS TotMarks3 ,PaperCode,marksall1,marksall2,marksall3,revaltotal, 
	coalesce(coalesce(revaltotal2,TotMarks4),'999') as TotMarks4,sub.Credits
	
FROM 
(SELECT DISTINCT SubjectName ,PaperCode,Credits
FROM tblinsemmarks IM 
INNER JOIN tblcapblockprof CBP ON IM.CapId = CBP.cbpid 
INNER JOIN tblexamblock EB ON EB.ExamBlockID = CBP.ExamBlockID 
INNER JOIN tblpapermaster PM ON PM.PaperID = EB.PaperID 
INNER JOIN tblsubjectmaster SM ON SM.SubjectID = PM.SubjectID 
INNER JOIN tblstdadm sa ON sa.rollno = IM.stdid 
INNER JOIN tblexammaster em ON em.AcadYearFrom = sa.EduYearFrom  AND em.Sem = SUBSTRING(PM.EnggYear,LENGTH(PM.EnggYear),1)
WHERE em.examid = " . $_SESSION["SESSCAPSelectedExam"] . " AND sa.stdid = " . $StdId . " ORDER BY SubjectName) AS sub
LEFT OUTER JOIN 
(SELECT distinct SubjectName, CASE COALESCE(IM.stdstatus,'') WHEN 'A' THEN 'AA' ELSE CONVERT((Q1 + Q2 + Q3 + Q4 + Q5 + Q6 + Q7 + Q8 + Q9 + Q10 + Q11 + Q12 + Q13 + Q14 + Q15 + Q16 + Q17 + Q18 + Q19 + Q20) , CHAR(10)) END AS TotMarks1,InSem as marksall1
FROM tblinsemmarks IM 
INNER JOIN tblcapblockprof CBP ON IM.CapId = CBP.cbpid 
INNER JOIN tblexamblock EB ON EB.ExamBlockID = CBP.ExamBlockID 
INNER JOIN tblpapermaster PM ON PM.PaperID = EB.PaperID 
INNER JOIN tblsubjectmaster SM ON SM.SubjectID = PM.SubjectID 
INNER JOIN tblstdadm sa ON sa.rollno = IM.stdid 
INNER JOIN tblexammaster em ON em.ExamID = CBP.ExamId and em.AcadYearFrom = sa.EduYearFrom  and em.Sem = SUBSTRING(PM.EnggYear,LENGTH(PM.EnggYear),1)
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
INNER JOIN tblexammaster em ON em.ExamID = CBP.ExamId and em.AcadYearFrom = sa.EduYearFrom  and em.Sem = SUBSTRING(PM.EnggYear,LENGTH(PM.EnggYear),1) 
WHERE sa.stdid = " . $StdId . " AND examname LIKE '%T2%' 
ORDER BY SubjectName) AS T2 ON sub.SubjectName = T2.SubjectName
LEFT OUTER JOIN (SELECT SubjectName, CASE COALESCE(IM.stdstatus,'') WHEN 'A' THEN 'AA' 
			ELSE CONVERT((Q1 + Q2 + Q3 + Q4 + Q5 + Q6 + Q7 + Q8 + Q9 + Q10 + Q11 + Q12 + Q13 + Q14 + Q15 + Q16 + Q17 + Q18 + Q19 + Q20) , CHAR(10)) END 
			AS TotMarks3,coalesce(Paper,0) as marksall3 ,coalesce(revaltotal,0) as revaltotal
			FROM tblinsemmarks IM 
			INNER JOIN tblcapblockprof CBP ON IM.CapId = CBP.cbpid 
			INNER JOIN tblexamblock EB ON EB.ExamBlockID = CBP.ExamBlockID 
			INNER JOIN tblpapermaster PM ON PM.PaperID = EB.PaperID 
			INNER JOIN tblsubjectmaster SM ON SM.SubjectID = PM.SubjectID 
			INNER JOIN tblstdadm sa ON sa.ESNum = IM.stdid 
			INNER JOIN tblexammaster em ON em.ExamID = CBP.ExamId and em.AcadYearFrom = sa.EduYearFrom  and em.Sem = SUBSTRING(PM.EnggYear,LENGTH(PM.EnggYear),1)
			WHERE sa.stdid = " . $StdId . " AND examname LIKE '%Regular%' 
			ORDER BY SubjectName) AS T3 ON sub.SubjectName = T3.SubjectName
LEFT OUTER JOIN (SELECT SubjectName, CASE COALESCE(IM.stdstatus,'') WHEN 'A' THEN 'AA' 
			ELSE CONVERT((Q1 + Q2 + Q3 + Q4 + Q5 + Q6 + Q7 + Q8 + Q9 + Q10 + Q11 + Q12 + Q13 + Q14 + Q15 + Q16 + Q17 + Q18 + Q19 + Q20) , CHAR(10)) END 
			AS TotMarks4,case when coalesce(revaltotal,0) = 0 Then Null else revaltotal end as revaltotal2
			FROM tblinsemmarks IM 
			INNER JOIN tblcapblockprof CBP ON IM.CapId = CBP.cbpid 
			INNER JOIN tblexamblock EB ON EB.ExamBlockID = CBP.ExamBlockID 
			INNER JOIN tblpapermaster PM ON PM.PaperID = EB.PaperID 
			INNER JOIN tblsubjectmaster SM ON SM.SubjectID = PM.SubjectID 
			INNER JOIN tblstdadm sa ON sa.ESNum = IM.stdid 
			INNER JOIN tblexammaster em ON em.ExamID = CBP.ExamId  and em.AcadYearFrom = sa.EduYearFrom  and em.Sem = SUBSTRING(PM.EnggYear,LENGTH(PM.EnggYear),1)
			WHERE sa.stdid = " . $StdId . " AND examname LIKE '%Retest%' 
			ORDER BY SubjectName) AS T4 ON sub.SubjectName = T4.SubjectName";

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
					if($revaltotal > 0){						
						if($revaltotal == '19.5'){
							$TotMarks3New = '20';
						}
						else{
							$TotMarks3New = $revaltotal;
						}					
					}
					else{
						if($TotMarks3 == '19.5'){
							$TotMarks3New = '20';
						}
						else{
							$TotMarks3New = $TotMarks3;
						}
					}
					if(($TotMarks4 <> '999') AND ((stripos($_SESSION["SESSCAPSelectedExamName"], 'Retest') > 0 ))){
						if($TotMarks4 == '19.5'){
							$TotMarks4New = '20';
						}
						else{
							$TotMarks4New = $TotMarks4;
						}
						$TotMarks3New = $TotMarks4New;
					}
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
					//if TotMarks3 +1 is > 50% for retest then add 1!!!!
					$sum = round($TotMarks1 + $TotMarks2 + $TotMarks3New);
					if(($TotMarks4 <> '999') AND ((stripos($_SESSION["SESSCAPSelectedExamName"], 'Retest') > 0 ))){
						if(((($sum * 100)/$marlsall) < 50) and (((($sum + 1) * 100)/$marlsall) >= 50)){
							$sum = $sum + 1;
							$TotMarks3New = $TotMarks3New + 1;
						}
					}
					
					if($marksall3 <> 1000){
							if(((round($TotMarks3New) * 100)/$marksall3) < 40){
								$finalresult = 'F';
							}
						}
						else{
							if($PaperCode == 'ES 1102'){
								if((round($TotMarks1 + $TotMarks2)) * 100/(($marksall1)) < 40){
									$finalresult = 'F';
								}
							}							
							else if(((round($TotMarks1 + $TotMarks2) * 100)/$marlsall) < 40){
								$finalresult = 'F';
							}
						}
						if($TotMarks3New == 'AA'){
							$finalresult = 'F';
						}
						if($finalresult == 'P'){
							if(($TotMarks4 <> '999') AND ((stripos($_SESSION["SESSCAPSelectedExamName"], 'Retest') > 0 ))){
								if((($sum * 100)/$marlsall) < 50){
										$finalresult = 'F';
								}
							}
							else{
								if((($sum * 100)/$marlsall) < 40){
										$finalresult = 'F';
								}
							}
						}
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
						if(($TotMarks4 <> '999') AND ((stripos($_SESSION["SESSCAPSelectedExamName"], 'Retest') > 0 ))){
							if((($sum * 100)/($marlsall)) >= 90){
										$finalresult = 'A+';
							}
							else if((($sum * 100)/($marlsall)) > 79 &&  (($sum * 100)/($marlsall)) < 90){
										$finalresult = 'A';
							}
							else if((($sum * 100)/($marlsall)) > 69 &&  ($sum * 100)/($marlsall) < 80){
										$finalresult = 'B+';
							}
							else if(($sum * 100)/($marlsall) > 59 &&  ($sum * 100)/($marlsall) < 70){
										$finalresult = 'B';
							}
							else if(($sum * 100)/($marlsall) > 49 &&  ($sum * 100)/($marlsall) < 60){
										$finalresult = 'C';
							}
							//else if(($sum * 100)/($marlsall) > 39 &&  ($sum * 100)/($marlsall) < 50){
							//			$finalresult = 'C';
							//}
						}
						else{
							if((($sum * 100)/($marlsall)) >= 90){
										$finalresult = 'O';
							}
							else if((($sum * 100)/($marlsall)) > 79 &&  (($sum * 100)/($marlsall)) < 90){
										$finalresult = 'A+';
							}
							else if((($sum * 100)/($marlsall)) > 69 &&  ($sum * 100)/($marlsall) < 80){
										$finalresult = 'A';
							}
							else if(($sum * 100)/($marlsall) > 59 &&  ($sum * 100)/($marlsall) < 70){
										$finalresult = 'B+';
							}
							else if(($sum * 100)/($marlsall) > 49 &&  ($sum * 100)/($marlsall) < 60){
										$finalresult = 'B';
							}
							else if(($sum * 100)/($marlsall) > 39 &&  ($sum * 100)/($marlsall) < 50){
										$finalresult = 'C';
							}
						}
						echo "<td>{$finalresult}";
					}
					else{
						echo "<td>{$finalresult}";
					}
					if(($TotMarks4 <> '999') AND ((stripos($_SESSION["SESSCAPSelectedExamName"], 'Retest') > 0 ))){
						if(strlen($finalresult) == 2){
							echo "&nbsp&nbsp&nbsp#";
						}
						else{
							echo "&nbsp&nbsp&nbsp&nbsp&nbsp#";
						}
					}
					echo "</td>";
					if($finalresult == 'F'){
						echo "<td>0</td>";
					}
					else{
						echo "<td>{$Credits}</td>";
					}
					echo "</TR>";
				}
			}					
			//disconnect from database				
			$result->free();
			
			$sql2 = "SELECT distinct PaperCode,SM.SubjectName AS SubjectName,'-' AS M1,'-' AS M2,'-' AS M3,marks AS TotMarks,
			CASE WHEN COALESCE(PracticalPRapp,0) = 1 THEN PracticalPR ELSE 
			CASE WHEN COALESCE(OralORapp,0) = 1 THEN OralOR 
			ELSE CASE WHEN COALESCE(TermWorkapp,0) = 1 THEN TermWork ELSE 1
			END END END AS marksall,
			CASE WHEN COALESCE(PracticalPRapp,0) = 1 THEN 'PR' ELSE 
			CASE WHEN COALESCE(OralORapp,0) = 1 THEN 'OR' 
			ELSE CASE WHEN COALESCE(TermWorkapp,0) = 1 THEN 'TW' 
			END END END as headtype,Credits
			FROM tblstdadm sa 
			INNER JOIN tblpapermaster pm ON SUBSTRING(pm.EnggYear,1,2) = REPLACE(YEAR,'.','') AND COALESCE(StdStatus,'') IN ('R','P') 
			INNER JOIN tblsubjectmaster SM ON SM.SubjectID = pm.SubjectID 
			INNER JOIN tbldivmaster dm ON REPLACE(dm.Year,'.','') = SUBSTRING(pm.EnggYear,1,2) 
			INNER JOIN tblexammaster em ON em.AcadYearFrom = dm.eduyearfrom and em.examid = " . $_SESSION["SESSCAPSelectedExam"] . "
			AND SUBSTRING(EnggYear,LENGTH(EnggYear),1)  = em.Sem
			INNER JOIN `tblpatternmaster` patm ON patm.acadyear = CONCAT(em.AcadYearFrom,'-',SUBSTRING(em.AcadYearTo,3,2)) AND 
			dm.year = patm.eduyear AND pm.EnggPattern = patm.teachingpat 
			INNER JOIN tblcapblockprof cpb ON cpb.ExamBlockID = pm.PaperID AND cpb.`div` = dm.DivName 
			INNER JOIN tblprormarks prormarks ON cpb.cbpid = prormarks.cbpid AND prormarks.stdadmid = sa.StdAdmID 
			WHERE (COALESCE(PracticalPRapp,0) = 1 OR COALESCE(OralORapp,0) = 1 OR COALESCE(TermWorkapp,0) = 1 ) 
			AND sa.stdid = " . $StdId . " 
			AND cpb.ExamID  = ". $_SESSION["SESSCAPSelectedExam"];
					
			$sql2 = "SELECT DISTINCT A.Sem,PaperCode,A.SubjectName,M1,M2,M3,COALESCE(TotMarks,0) AS TotMarks,marksall,headtype,COALESCE(TotMarks2,'999') AS TotMarks2,(coalesce(A.Credits,0) + Coalesce(A.prorcredits,0)) AS  CreditsPROR
					FROM 
					(SELECT DISTINCT em.Sem,PaperCode,SM.SubjectName AS SubjectName,'-' AS M1,'-' AS M2,'-' AS M3,marks AS TotMarks, 
					CASE WHEN COALESCE(PracticalPRapp,0) = 1 THEN PracticalPR ELSE CASE WHEN COALESCE(OralORapp,0) = 1 THEN OralOR ELSE 
					CASE WHEN COALESCE(TermWorkapp,0) = 1 THEN TermWork ELSE 1 END END END AS marksall, 
					CASE WHEN COALESCE(PracticalPRapp,0) = 1 THEN 'PR' ELSE CASE WHEN COALESCE(OralORapp,0) = 1 THEN 'OR' ELSE 
					CASE WHEN COALESCE(TermWorkapp,0) = 1 THEN 'TW' END END END AS headtype ,Credits,prorcredits
					FROM tblstdadm sa 
					INNER JOIN tblpapermaster pm ON SUBSTRING(pm.EnggYear,1,2) = REPLACE(YEAR,'.','') AND COALESCE(StdStatus,'') IN ('R','P') 
					INNER JOIN tblsubjectmaster SM ON SM.SubjectID = pm.SubjectID INNER JOIN tbldivmaster dm ON REPLACE(dm.Year,'.','') = SUBSTRING(pm.EnggYear,1,2) 
					INNER JOIN tblexammaster em ON em.AcadYearFrom = dm.eduyearfrom
					AND SUBSTRING(EnggYear,LENGTH(EnggYear),1)  = em.Sem AND em.Sem = case when " . $_SESSION["SESSCAPSelectedExam"] . " in(26,29) Then 1 Else 2 End 
					INNER JOIN `tblpatternmaster` patm ON patm.acadyear = CONCAT(em.AcadYearFrom,'-',SUBSTRING(em.AcadYearTo,3,2)) AND dm.year = patm.eduyear 
					AND pm.EnggPattern = patm.teachingpat INNER JOIN tblcapblockprof cpb ON cpb.ExamBlockID = pm.PaperID AND cpb.`div` = dm.DivName 
					and em.ExamID = cpb.ExamId
					INNER JOIN tblprormarks prormarks ON cpb.cbpid = prormarks.cbpid AND prormarks.stdadmid = sa.StdAdmID 
					WHERE (COALESCE(PracticalPRapp,0) = 1 OR COALESCE(OralORapp,0) = 1 OR COALESCE(TermWorkapp,0) = 1 ) AND sa.stdid = " . $StdId . "
					AND examname LIKE '%Regular%' and SM.SubjectName not like '%value education%'
					) AS A
					LEFT OUTER JOIN 
					(
					SELECT DISTINCT em.Sem,SM.SubjectName AS SubjectName,marks AS TotMarks2
					FROM tblstdadm sa 
					INNER JOIN tblpapermaster pm ON SUBSTRING(pm.EnggYear,1,2) = REPLACE(YEAR,'.','') AND COALESCE(StdStatus,'') IN ('R','P') 
					INNER JOIN tblsubjectmaster SM ON SM.SubjectID = pm.SubjectID INNER JOIN tbldivmaster dm ON REPLACE(dm.Year,'.','') = SUBSTRING(pm.EnggYear,1,2) 
					INNER JOIN tblexammaster em ON em.AcadYearFrom = dm.eduyearfrom and em.examid = " . $_SESSION["SESSCAPSelectedExam"] . "
					AND SUBSTRING(EnggYear,LENGTH(EnggYear),1)  = em.Sem
					INNER JOIN `tblpatternmaster` patm ON patm.acadyear = CONCAT(em.AcadYearFrom,'-',SUBSTRING(em.AcadYearTo,3,2)) AND dm.year = patm.eduyear 
					AND pm.EnggPattern = patm.teachingpat INNER JOIN tblcapblockprof cpb ON cpb.ExamBlockID = pm.PaperID AND cpb.`div` = dm.DivName 
					and em.ExamID = cpb.ExamId
					INNER JOIN tblprormarks prormarks ON cpb.cbpid = prormarks.cbpid AND prormarks.stdadmid = sa.StdAdmID 
					WHERE (COALESCE(PracticalPRapp,0) = 1 OR COALESCE(OralORapp,0) = 1 OR COALESCE(TermWorkapp,0) = 1 ) AND sa.stdid = " . $StdId . "
					 AND examname LIKE '%Retest%' and SM.SubjectName not like '%value education%'
					) AS B ON  A.SubjectName = B.SubjectName";
			// and em.examid = " . $_SESSION["SESSCAPSelectedExam"] . "
			//echo $sql2;
			$result2 = $mysqli->query( $sql2 );
			echo $mysqli->error;
			$num_results2 = $result2->num_rows;
			//echo $sql2;
			if( $num_results2 ){
				while( $row2 = $result2->fetch_assoc() ){
					extract($row2);
					$finalresult = 'P';
					if(($TotMarks2 <> '999') AND ((stripos($_SESSION["SESSCAPSelectedExamName"], 'Retest') > 0 ))){
						$TotMarks = $TotMarks2;
					}
					if(($TotMarks2 <> '999') AND ((stripos($_SESSION["SESSCAPSelectedExamName"], 'Retest') > 0 ))){
						if(((round($TotMarks) * 100)/$marksall) < 50){
							$finalresult = 'F';
						}
					}
					else{
						if(((round($TotMarks) * 100)/$marksall) < 40){
							$finalresult = 'F';
						}
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
						if(($TotMarks2 <> '999') AND ((stripos($_SESSION["SESSCAPSelectedExamName"], 'Retest') > 0 ))){
							if((round($TotMarks) * 100)/($marksall) >= 90){
										$finalresult = 'A+';
							}
							else if((round($TotMarks) * 100)/($marksall) > 79 &&  (round($TotMarks) * 100)/($marksall) < 90){
										$finalresult = 'A';
							}
							else if((round($TotMarks) * 100)/($marksall) > 69 &&  (round($TotMarks) * 100)/($marksall) < 80){
										$finalresult = 'B+';
							}
							else if((round($TotMarks) * 100)/($marksall) > 59 &&  (round($TotMarks) * 100)/($marksall) < 70){
										$finalresult = 'B';
							}
							else if((round($TotMarks) * 100)/($marksall) > 49 &&  (round($TotMarks) * 100)/($marksall) < 60){
										$finalresult = 'C';
							}
							else if((round($TotMarks) * 100)/($marksall) > 39 &&  (round($TotMarks) * 100)/($marksall) < 50){
										$finalresult = 'D';
							}
						}
						else{
							if((round($TotMarks) * 100)/($marksall) >= 90){
										$finalresult = 'O';
							}
							else if((round($TotMarks) * 100)/($marksall) > 79 &&  (round($TotMarks) * 100)/($marksall) < 90){
										$finalresult = 'A+';
							}
							else if((round($TotMarks) * 100)/($marksall) > 69 &&  (round($TotMarks) * 100)/($marksall) < 80){
										$finalresult = 'A';
							}
							else if((round($TotMarks) * 100)/($marksall) > 59 &&  (round($TotMarks) * 100)/($marksall) < 70){
										$finalresult = 'B+';
							}
							else if((round($TotMarks) * 100)/($marksall) > 49 &&  (round($TotMarks) * 100)/($marksall) < 60){
										$finalresult = 'B';
							}
							else if((round($TotMarks) * 100)/($marksall) > 39 &&  (round($TotMarks) * 100)/($marksall) < 50){
										$finalresult = 'C';
							}							
						}
						echo "<td>{$finalresult}";
					}
					else{
						echo "<td>{$finalresult}";
					}
					if(($TotMarks2 <> '999') AND ((stripos($_SESSION["SESSCAPSelectedExamName"], 'Retest') > 0 ))){
						if(strlen($finalresult) == 2){
							echo "&nbsp&nbsp&nbsp#";
						}
						else{
							echo "&nbsp&nbsp&nbsp&nbsp&nbsp#";
						}
					}
					echo "</td>";
					if($finalresult == 'F'){
						echo "<td>0</td>";
					}
					else{
						echo "<td>{$CreditsPROR}</td>";
					}
					echo "</TR>";
				}
			}

			//code for value education!!!!
			$sql2 = "SELECT DISTINCT examname,PaperCode,A.SubjectName,M1,M2,M3,COALESCE(TotMarks,0) AS TotMarks,marksall,headtype,COALESCE(TotMarks,'999') AS TotMarks2,A.Credits
					FROM 
					(SELECT DISTINCT examname,PaperCode,SM.SubjectName AS SubjectName,'-' AS M1,'-' AS M2,'-' AS M3,marks AS TotMarks, 
					CASE WHEN COALESCE(PracticalPRapp,0) = 1 THEN PracticalPR ELSE CASE WHEN COALESCE(OralORapp,0) = 1 THEN OralOR ELSE 
					CASE WHEN COALESCE(TermWorkapp,0) = 1 THEN TermWork ELSE 1 END END END AS marksall, 
					CASE WHEN COALESCE(PracticalPRapp,0) = 1 THEN 'PR' ELSE CASE WHEN COALESCE(OralORapp,0) = 1 THEN 'OR' ELSE 
					CASE WHEN COALESCE(TermWorkapp,0) = 1 THEN 'TW' END END END AS headtype ,Credits
					FROM tblstdadm sa 
					INNER JOIN tblpapermaster pm ON SUBSTRING(pm.EnggYear,1,2) = REPLACE(YEAR,'.','') AND COALESCE(StdStatus,'') IN ('R','P') 
					INNER JOIN tblsubjectmaster SM ON SM.SubjectID = pm.SubjectID INNER JOIN tbldivmaster dm ON REPLACE(dm.Year,'.','') = SUBSTRING(pm.EnggYear,1,2) 
					INNER JOIN tblexammaster em ON em.AcadYearFrom = dm.eduyearfrom
					AND SUBSTRING(EnggYear,LENGTH(EnggYear),1)  = em.Sem 
					INNER JOIN `tblpatternmaster` patm ON patm.acadyear = CONCAT(em.AcadYearFrom,'-',SUBSTRING(em.AcadYearTo,3,2)) AND dm.year = patm.eduyear 
					AND pm.EnggPattern = patm.teachingpat INNER JOIN tblcapblockprof cpb ON cpb.ExamBlockID = pm.PaperID AND cpb.`div` = dm.DivName 
					and em.ExamID = cpb.ExamId
					LEFT OUTER JOIN tblprormarks prormarks ON cpb.cbpid = prormarks.cbpid AND prormarks.stdadmid = sa.StdAdmID 
					WHERE (COALESCE(PracticalPRapp,0) = 1 OR COALESCE(OralORapp,0) = 1 OR COALESCE(TermWorkapp,0) = 1 ) AND sa.stdid = " . $StdId . "
					AND examname LIKE '%Retest%' and SM.SubjectName like '%value education%'
					) AS A ";
			// and em.examid = " . $_SESSION["SESSCAPSelectedExam"] . "
//AND em.Sem = case when " . $_SESSION["SESSCAPSelectedExam"] . " in(26,29) Then 1 Else 2 End 			
			$result2 = $mysqli->query( $sql2 );
			echo $mysqli->error;
			$num_results2 = $result2->num_rows;
			//echo $sql2;
			if( $num_results2 ){
				while( $row2 = $result2->fetch_assoc() ){
					extract($row2);
					$finalresult = 'AC';
					if(($TotMarks2 <> '999') AND ((stripos($_SESSION["SESSCAPSelectedExamName"], 'Retest') > 0 ))){
						$TotMarks = $TotMarks2;
					}
					if(($TotMarks2 <> '999') AND ((stripos($_SESSION["SESSCAPSelectedExamName"], 'Retest') > 0 ))){
						if(((round($TotMarks) * 100)/$marksall) < 50){
							$finalresult = $TotMarks;
						}
					}
					if($Sem == 1){
					}
					else if($finalresult == 'AC' and $num_results2 == 2){				
					echo "<TR>";
					echo "<td>{$PaperCode}</td>";
					echo "<td>{$SubjectName} </td>";
					echo "<td>NC </td>";
					echo "<td>{$M1} </td>";
					echo "<td>{$M2} </td>";
					echo "<td>{$M3} </td>";
					echo "<td>- </td>";
					echo "<td>- </td>";					
					echo "<td>{$finalresult}";
					echo "</td>";
					echo "<td>- </td>";
					echo "</TR>";
					}
					else if($num_results2 == 1){	
					echo "<TR>";
					echo "<td>{$PaperCode}</td>";
					echo "<td>{$SubjectName} </td>";
					echo "<td>NC </td>";
					echo "<td>{$M1} </td>";
					echo "<td>{$M2} </td>";
					echo "<td>{$M3} </td>";
					echo "<td>- </td>";
					echo "<td>- </td>";					
					echo "<td>{$finalresult}";
					echo "</td>";
					echo "<td>- </td>";
					echo "</TR>";
					}
				}
			}					
								
					
			//disconnect from database	
			$result2->free();
			$mysqli->close();
	?>
    </table>
	<br/>
	<br/>
								<div style='float:left;margin-left:5%'>
									<span class='th-heading'>* Refer Sr.No. 10.1, Page Nos. 15,16 of Rulebook.  # Appeared for Re-examination.</span>
								</div>
					<br/><br/><br/><br/>
					<br/><br/>
						<div style='float:right;margin-right:5%'>
							</h3>
								<span class='th-heading'>Dr. A. A. Bhosale</span>
								</br>
								<span class='th-heading'>Dean Examination</span>
							</h3>
						</div>
	<?php
		echo"<p  style='page-break-after:always;'></p>";	
				}
			}
	?>
</body>
</html>
