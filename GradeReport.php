<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Grade Report</title>
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

	//ini_set('MAX_EXECUTION_TIME', -1);
	set_time_limit(16000);

	if(!isset($_SESSION)) {
		session_start();				
	}
	
	/*
	// delete existing record for student! - FOR SELECTED CRITERIA!!!!!!!!!!
	include 'db/db_connect.php';
	$sql = "truncate table tblgradereport";
	$stmt = $mysqli->prepare($sql);
	if($stmt->execute()){} 
	else{echo $mysqli->error;}
	*/

	include 'db/db_connect.php';
	$sql = "UPDATE tblinsemmarks SET revaltotal = NULL WHERE COALESCE(revaltotal,'9999') = 0";
	$stmt = $mysqli->prepare($sql);
	if($stmt->execute()){} 
	else{echo $mysqli->error;}
	
	
	
	//Get studnts
	if( $_GET['dept'] == 1){
		$sqlstd = "SELECT StdId , ESNum,RollNo,stdadmid
					FROM tblstdadm where YEAR = '" . $_GET['year'] . "' 
					and EduYearFrom = " . $_GET['acadyear'] . "
					and ESNum is not null
					and coalesce(stdstatus,'') IN('R','P')
					AND Stdid IN (14526)
					ORDER BY ESNum";
					//and COALESCE(stdstatus,'D') IN('R','P')
	}
	else{
		$sqlstd = "SELECT StdId, ESNum,RollNo ,stdadmid
					FROM tblstdadm where YEAR = '" . $_GET['year'] . "' 
					and Dept =  " . $_GET['dept'] . " 
					and EduYearFrom = " . $_GET['acadyear'] . "
					and COALESCE(stdstatus,'D') IN('R','P')
					and ESNum is not null
					ORDER BY ESNum";
	}
	include 'db/db_connect.php';
	$resultstd = $mysqli->query( $sqlstd );
	echo $mysqli->error;
	$num_resultsstd = $resultstd->num_rows;
	if( $num_resultsstd ){
		while( $rowstd = $resultstd->fetch_assoc() ){
			extract($rowstd);				
			// insert all papers in tblgradereport for this student
			include 'db/db_connect.php';
			$sqlsub = "INSERT INTO tblgradereport (StdId, AcadYear,Sem,PaperID,credits,papertype,ESEOUTOF,T1OUTOF,T2OUTOF,prortwall,PaperCode)
						SELECT  DISTINCT " . $StdId . "," . $_GET['acadyear'] . ",SUBSTRING(PM.EnggYear,10,1), PM.PaperID,
								Credits,
								CASE WHEN COALESCE(PracticalPRapp,0) = 1 THEN 'PR' ELSE 
									CASE WHEN COALESCE(OralORapp,0) = 1 THEN 'OR' ELSE 
										CASE WHEN COALESCE(TermWorkapp,0) = 1 THEN 'TW' ELSE 'TH'
												END END END as papertype, Paper, Insem,Insem,
												CASE WHEN COALESCE(PracticalPRapp,0) = 1 THEN PracticalPR ELSE CASE WHEN COALESCE(OralORapp,0) = 1 THEN OralOR ELSE 
													CASE WHEN COALESCE(TermWorkapp,0) = 1 THEN TermWork ELSE NULL END END END as prortwall,PM.PaperCode
						FROM tblpapermaster PM
						INNER JOIN tblsubjectmaster SM ON SM.SubjectID = PM.SubjectID 
						INNER JOIN tblyearstruct ys ON ys.PaperID = PM.PaperID AND ys.eduyearfrom = " . $_GET['acadyear'] . "
						WHERE SUBSTRING(PM.EnggYear,1,2) = Replace('" . $_GET['year'] . "','.','')  AND DeptID = " . $_GET['dept'] . "
						ORDER BY SUBSTRING(PM.EnggYear,10,1),SubjectName";

			$resultsub = $mysqli->query( $sqlsub );
			echo $mysqli->error;		
			// get exams!! - get T1
			include 'db/db_connect.php';
			$sqlexam = "SELECT ExamId,examname,sem as examsem FROM tblexammaster 
			WHERE AcadYearFrom = " . $_GET['acadyear'] . " AND examcat = 'Autonomy' 
			AND COALESCE(processresult,0) = 1 
			ORDER BY ExamId";	
			$resultexam = $mysqli->query( $sqlexam );
			echo $mysqli->error;
			$num_resultsexam = $resultexam->num_rows;
			if( $num_resultsexam ){
				while( $rowexam = $resultexam->fetch_assoc() ){
					extract($rowexam);
					$sqlsub = "select papertype,sem,PaperID from tblgradereport 
								where StdId = " . $StdId . " and AcadYear = " . $_GET['acadyear'] . "
								and Sem = " . $examsem . "
									ORDER BY PaperID";
					$resultsub = $mysqli->query( $sqlsub );
					echo $mysqli->error;
					$num_resultsub = $resultsub->num_rows;
					if( $num_resultsub ){
						while( $rowsub = $resultsub->fetch_assoc() ){
							extract($rowsub);
							include 'db/db_connect.php';
							
							if(
								(strpos($examname, 'T1') !== false) OR 
								(strpos($examname, 'T2') !== false)
								){
								if($papertype == 'TH'){
									if(strpos($examname, 'Summer') !== false){
										$sqlmarks = "SELECT 
													coalesce(revaltotal,(Q1 + Q2 + Q3 + Q4 + Q5 + Q6 + Q7 + Q8 + Q9 + Q10 + Q11 + Q12 + Q13 + Q14 + Q15 + Q16 + Q17 + Q18 + Q19 + Q20))
													AS tot
													FROM tblinsemmarks ism
													INNER JOIN tblcapblockprof cbp ON cbp.cbpid = ism.CapId AND StdId = '" . $ESNum . "'
													INNER JOIN tblexammaster em ON em.ExamId = cbp.ExamId AND em.ExamId = " . $ExamId . "
													INNER JOIN tblexamblock EB ON EB.ExamBlockID = cbp.ExamBlockID
													WHERE EB.PaperID = " . $PaperID;	
													//echo $sqlmarks . "<BR/>";
									}
									else{
										$sqlmarks = "SELECT 
													coalesce(revaltotal,(Q1 + Q2 + Q3 + Q4 + Q5 + Q6 + Q7 + Q8 + Q9 + Q10 + Q11 + Q12 + Q13 + Q14 + Q15 + Q16 + Q17 + Q18 + Q19 + Q20))
													AS tot
													FROM tblinsemmarks ism
													INNER JOIN tblcapblockprof cbp ON cbp.cbpid = ism.CapId AND StdId = '" . $RollNo . "'
													INNER JOIN tblexammaster em ON em.ExamId = cbp.ExamId AND em.ExamId = " . $ExamId . "
													INNER JOIN tblexamblock EB ON EB.ExamBlockID = cbp.ExamBlockID
													WHERE EB.PaperID = " . $PaperID;	
									}
								}
								else{
									$sqlmarks = "SELECT marks AS tot
												FROM tblprormarks prormarks
												INNER JOIN tblcapblockprof cbp ON cbp.cbpid = prormarks.cbpid
												WHERE ExamId = " . $ExamId . " and cbp.ExamBlockID = " . $PaperID . " AND stdadmid = " . $stdadmid;	
								}
							}
							else{
								if($papertype == 'TH'){
									$sqlmarks = "SELECT 
												coalesce(revaltotal,(Q1 + Q2 + Q3 + Q4 + Q5 + Q6 + Q7 + Q8 + Q9 + Q10 + Q11 + Q12 + Q13 + Q14 + Q15 + Q16 + Q17 + Q18 + Q19 + Q20))
												AS tot
												FROM tblinsemmarks ism
												INNER JOIN tblcapblockprof cbp ON cbp.cbpid = ism.CapId AND StdId = '" . $ESNum . "'
												INNER JOIN tblexammaster em ON em.ExamId = cbp.ExamId AND em.ExamId = " . $ExamId . "
												INNER JOIN tblexamblock EB ON EB.ExamBlockID = cbp.ExamBlockID
												WHERE EB.PaperID = " . $PaperID;	
								}
								else{
									$sqlmarks = "SELECT marks AS tot
												FROM tblprormarks prormarks
												INNER JOIN tblcapblockprof cbp ON cbp.cbpid = prormarks.cbpid
												WHERE ExamId = " . $ExamId . " and cbp.ExamBlockID = " . $PaperID . " AND stdadmid = " . $stdadmid;	
								}
							}
							
							$resultmarks = $mysqli->query( $sqlmarks );
							echo $mysqli->error;
							$num_resultmarks = $resultmarks->num_rows;
							if( $num_resultmarks ){
								$rowmarks = $resultmarks->fetch_assoc();
								extract($rowmarks);
								if($tot <> ''){
									
									include 'db/db_connect.php';
									if($papertype == 'TH'){
										if(strpos($examname, 'T1') !== false){
											$sqlmarksinsert = "update tblgradereport set T1 = ?,examname = ? where StdId = ? and Sem = ? and PaperID = ? 
																and AcadYear = ?";									
										}
										else if(strpos($examname, 'T2') !== false){
											$sqlmarksinsert = "update tblgradereport set T2 = ?,examname = ? where StdId = ? and Sem = ? and PaperID = ? 
																and AcadYear = ?";									
										}
										else{
											$sqlmarksinsert = "update tblgradereport set ESE = ?,examname = ? where StdId = ? and Sem = ? and PaperID = ? 
																and AcadYear = ?";									
										}
									}
									else{
										$sqlmarksinsert = "update tblgradereport set Total = ?,examname = ? where StdId = ? and Sem = ? and PaperID = ? 
															and AcadYear = ?";									
									}
									$stmt = $mysqli->prepare($sqlmarksinsert);
									$stmt->bind_param('ssssii',$tot,$examname, $StdId,$sem,$PaperID,$_GET['acadyear']);
									if($stmt->execute()){} 
									else{echo $mysqli->error;}
								}
							}
						}
					}
				}
			}
			$sqlsub = "update tblgradereport set Total = coalesce(T1,0) + coalesce(T2,0) + coalesce(ESE,0) 
						where  Total is null and StdId = " . $StdId . " and AcadYear = " . $_GET['acadyear'];
			$resultsub = $mysqli->query( $sqlsub );
			echo $mysqli->error;
		}
	}
		echo 'Processing is done.' . "<BR/>";
		include 'db/db_connect.php';
		$sqlsub = "update tblgradereport set credits = 1  where PaperType <> 'TH' and coalesce(credits,0) = 0";
		$resultsub = $mysqli->query( $sqlsub );
		echo $mysqli->error;

		echo 'Updated Credits. Please check Semester Report.';
		die;
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
INNER JOIN tblexamblock EB ON EB.ExamBlockID = cbp.ExamBlockID 
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
			INNER JOIN tblexamblock EB ON EB.ExamBlockID = cbp.ExamBlockID 
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
			INNER JOIN tblexamblock EB ON EB.ExamBlockID = cbp.ExamBlockID 
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
					
			$sql2 = "SELECT DISTINCT A.Sem,PaperCode,A.SubjectName,M1,M2,M3,COALESCE(TotMarks,0) AS TotMarks,marksall,headtype,COALESCE(TotMarks2,'999') AS TotMarks2,A.Credits
					FROM 
					(SELECT DISTINCT em.Sem,PaperCode,SM.SubjectName AS SubjectName,'-' AS M1,'-' AS M2,'-' AS M3,marks AS TotMarks, 
					CASE WHEN COALESCE(PracticalPRapp,0) = 1 THEN PracticalPR ELSE CASE WHEN COALESCE(OralORapp,0) = 1 THEN OralOR ELSE 
					CASE WHEN COALESCE(TermWorkapp,0) = 1 THEN TermWork ELSE 1 END END END AS marksall, 
					CASE WHEN COALESCE(PracticalPRapp,0) = 1 THEN 'PR' ELSE CASE WHEN COALESCE(OralORapp,0) = 1 THEN 'OR' ELSE 
					CASE WHEN COALESCE(TermWorkapp,0) = 1 THEN 'TW' END END END AS headtype ,Credits
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
										$finalresult = 'F';
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
						echo "<td>{$Credits}</td>";
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
					$finalresult = 'NAC';
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
				//}
			//}
	?>
</body>
</html>
