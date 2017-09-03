<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Semester Marks</title>
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
		include 'db/db_connect.php';
		$query1 = "SELECT CONCAT(Surname, ' ', FirstName) AS NAME,sa.RollNo, s.CNUM, sa.ESNum,DM.DeptUnivName as DeptName
		FROM tblstudent s
		INNER JOIN tblstdadm sa ON s.stdid = sa.stdid
		INNER JOIN tbldepartmentmaster DM ON sa.Dept = DM.DeptID
		WHERE s.StdID = ". $_SESSION["SESSStdId"] . " order by sa.StdAdmID desc limit 1";
		//echo $query1;
		$result1 = $mysqli->query( $query1 );
		$num_results1 = $result1->num_rows;
		if( $num_results1 ){
			while( $row1 = $result1->fetch_assoc() ){
				extract($row1);
			}
		}
	?>
	<br/><br/>
	<table width="90%" cellpadding="5" cellspacing="0" class="fix-table" style="margin-left: 5%;">
	<TR>
		<td class='th-heading'>Student Name</td>
		<td class='th-heading'>CNUM</td>
		<td class='th-heading'>Exam Seat Number</td>
		<td class='th-heading'>Department</td>
	</TR>
	<TR>
		<td class='th-heading'><?php echo $NAME; ?></td>
		<td class='th-heading'><?php echo $CNUM; ?></td>
		<td class='th-heading'><?php echo $ESNum; ?></td>
		<td class='th-heading'><?php echo $DeptName; ?></td>
	</TR>
	</table>
	<br/><br/>
	<?php
	if(!isset($_SESSION)){
		session_start();
	}
	include 'db/db_connect.php';
	$query1 = "SELECT DISTINCT em.ExamID,examname,sa.stdid,em.Sem
	FROM tblstudent s
	INNER JOIN tblstdadm sa ON s.stdid = sa.stdid
	INNER JOIN tblexamblockstudent ebs ON ebs.StdID = sa.ESNum
	INNER JOIN tblexamblock eb ON eb.ExamBlockID = ebs.ExamBlockID
	INNER JOIN tblexamschedule es ON es.ExamSchID = eb.ExamSchID
	INNER JOIN tblexammaster em ON em.ExamID = es.ExamID AND em.AcadYearFrom = sa.EduYearFrom AND examtype2 IN('End-Sem','Retest')
	and COALESCE(publishresult,0) = 1
	LEFT OUTER JOIN tbldepartmentmaster DM ON sa.Dept = DM.DeptID
	WHERE s.StdID = ". $_SESSION["SESSStdId"] . " order by ExamID";
	
	//echo $query1;
	$result1 = $mysqli->query( $query1 );
	$num_results1 = $result1->num_rows;
	if( $num_results1 ){
		while( $row1 = $result1->fetch_assoc() ){
			extract($row1);
			$_SESSION["SESSCAPSelectedExamName"] = $examname;
			if(stripos($_SESSION["SESSCAPSelectedExamName"], 'Summer') > 0 ){
				$_SESSION["hassummerterm"] = 1;
			}
			{
				$_SESSION["hassummerterm"] = 0;
			}
	?>
	
	<table width="90%" cellpadding="5" cellspacing="0" class="fix-table" style="margin-left: 5%;">
	<TR>
		<td colspan='7' class='th-heading'><center><?php echo $examname; ?> Statement of Marks</center></td>
	</TR>
	</table>
	<br/><br/>
<table width="90%" border="0" cellpadding="5" cellspacing="0" class="fix-table" style="margin-left: 5%;">
	<tr class="th">
		<td width="7%">Course Code</td>
		<td width="30%">Course Name</td>
		<td width="7%">Head Type</td>
		<td width="8%">T1</td>
		<td width="8%">T2</td>
		<td width="8%">ESE</td>
		<td width="8%">Total</td>
		<td width="8%">Out Of</td>
		<td width="8%">Grade *</td>
		<td width="8%">Credits</td>
	</tr>
	<?php
		if(!isset($_SESSION)) {
			session_start();				
		}
		include 'db/db_connect.php';
	if(stripos($_SESSION["SESSCAPSelectedExamName"], 'Summer') > 0 ){
		$sql = "SELECT distinct sub.SubjectName,COALESCE(t1.TotMarks1,0) AS TotMarks1,COALESCE(T2.TotMarks2,0) AS TotMarks2
		,COALESCE(T3.TotMarks3,0) AS TotMarks3 ,PaperCode,examname,marksall1,marksall2,marksall3,revaltotal, '999' as TotMarks4,Credits
		FROM 
		(SELECT DISTINCT SubjectName ,PaperCode,Credits
		FROM tblinsemmarks IM 
		INNER JOIN tblcapblockprof CBP ON IM.CapId = CBP.cbpid AND CBP.examid = {$ExamID} 
		INNER JOIN tblexamblock EB ON EB.ExamBlockID = CBP.ExamBlockID 
		INNER JOIN tblpapermaster PM ON PM.PaperID = EB.PaperID 
		INNER JOIN tblsubjectmaster SM ON SM.SubjectID = PM.SubjectID 
		INNER JOIN tblstdadm sa ON COALESCE(sa.ESNum,sa.rollno) = IM.stdid 
		WHERE sa.stdid = " . $_SESSION["SESSUserID"] . " ORDER BY SubjectName) AS sub
		INNER JOIN 
		(SELECT distinct SubjectName, CASE COALESCE(IM.stdstatus,'') WHEN 'A' THEN 'AA' ELSE CONVERT((Q1 + Q2 + Q3 + Q4 + Q5 + Q6 + Q7 + Q8 + Q9 + Q10 + Q11 + Q12 + Q13 + Q14 + Q15 + Q16 + Q17 + Q18 + Q19 + Q20) , CHAR(10)) END AS TotMarks1 ,examname,InSem as marksall1
		FROM tblinsemmarks IM 
		INNER JOIN tblcapblockprof CBP ON IM.CapId = CBP.cbpid 
		INNER JOIN tblexamblock EB ON EB.ExamBlockID = CBP.ExamBlockID 
		INNER JOIN tblpapermaster PM ON PM.PaperID = EB.PaperID 
		INNER JOIN tblsubjectmaster SM ON SM.SubjectID = PM.SubjectID 
		INNER JOIN tblstdadm sa ON COALESCE(sa.ESNum,sa.rollno) = IM.stdid 
		INNER JOIN tblexammaster em ON em.ExamID = CBP.ExamId and em.AcadYearFrom = sa.EduYearFrom  and em.Sem = {$Sem}
		WHERE sa.stdid = " . $_SESSION["SESSUserID"] . " AND examname LIKE '%T1%' AND examname LIKE '%Summer%'
		ORDER BY SubjectName) AS t1 ON sub.SubjectName = t1.SubjectName
		INNER JOIN 
		(SELECT SubjectName, CASE COALESCE(IM.stdstatus,'') WHEN 'A' THEN 'AA' ELSE CONVERT((Q1 + Q2 + Q3 + Q4 + Q5 + Q6 + Q7 + Q8 + Q9 + Q10 + Q11 + Q12 + Q13 + Q14 + Q15 + Q16 + Q17 + Q18 + Q19 + Q20) , CHAR(10)) END AS TotMarks2,InSem as marksall2
		FROM tblinsemmarks IM 
		INNER JOIN tblcapblockprof CBP ON IM.CapId = CBP.cbpid 
		INNER JOIN tblexamblock EB ON EB.ExamBlockID = CBP.ExamBlockID 
		INNER JOIN tblpapermaster PM ON PM.PaperID = EB.PaperID 
		INNER JOIN tblsubjectmaster SM ON SM.SubjectID = PM.SubjectID 
		INNER JOIN tblstdadm sa ON COALESCE(sa.ESNum,sa.rollno) = IM.stdid 
		INNER JOIN tblexammaster em ON em.ExamID = CBP.ExamId and em.AcadYearFrom = sa.EduYearFrom  and em.Sem = {$Sem}
		WHERE sa.stdid = " . $_SESSION["SESSUserID"] . " AND examname LIKE '%T2%' AND examname LIKE '%Summer%'
		ORDER BY SubjectName) AS T2 ON sub.SubjectName = T2.SubjectName
		INNER JOIN (SELECT SubjectName, CASE COALESCE(IM.stdstatus,'') WHEN 'A' THEN 'AA' 
					ELSE CONVERT((Q1 + Q2 + Q3 + Q4 + Q5 + Q6 + Q7 + Q8 + Q9 + Q10 + Q11 + Q12 + Q13 + Q14 + Q15 + Q16 + Q17 + Q18 + Q19 + Q20) , CHAR(10)) END 
					AS TotMarks3,Paper as marksall3,coalesce(revaltotal,0) as revaltotal
					FROM tblinsemmarks IM 
					INNER JOIN tblcapblockprof CBP ON IM.CapId = CBP.cbpid 
					INNER JOIN tblexamblock EB ON EB.ExamBlockID = CBP.ExamBlockID 
					INNER JOIN tblpapermaster PM ON PM.PaperID = EB.PaperID 
					INNER JOIN tblsubjectmaster SM ON SM.SubjectID = PM.SubjectID 
					INNER JOIN tblstdadm sa ON COALESCE(sa.ESNum,sa.rollno) = IM.stdid 
					INNER JOIN tblexammaster em ON em.ExamID = CBP.ExamId and em.AcadYearFrom = sa.EduYearFrom  and em.Sem = {$Sem}
					WHERE sa.stdid = " . $_SESSION["SESSUserID"] . " AND examname LIKE '%ESE%' AND examname LIKE '%Summer%' 
					ORDER BY SubjectName) AS T3 ON sub.SubjectName = T3.SubjectName";		
					//echo $sql;
	}
	else{
		$sql = "SELECT distinct sub.SubjectName,COALESCE(t1.TotMarks1,0) AS TotMarks1,COALESCE(T2.TotMarks2,0) AS TotMarks2
		,COALESCE(T3.TotMarks3,0) AS TotMarks3 ,PaperCode,examname,marksall1,marksall2,marksall3,revaltotal, 
		coalesce(coalesce(revaltotal2,TotMarks4),'999') as TotMarks4,Credits
		FROM 
		(SELECT DISTINCT SubjectName ,PaperCode,Credits
		FROM tblinsemmarks IM 
		INNER JOIN tblcapblockprof CBP ON IM.CapId = CBP.cbpid AND CBP.examid = {$ExamID} 
		INNER JOIN tblexamblock EB ON EB.ExamBlockID = CBP.ExamBlockID 
		INNER JOIN tblpapermaster PM ON PM.PaperID = EB.PaperID 
		INNER JOIN tblsubjectmaster SM ON SM.SubjectID = PM.SubjectID 
		INNER JOIN tblstdadm sa ON COALESCE(sa.ESNum,sa.rollno) = IM.stdid 
		WHERE sa.stdid = " . $_SESSION["SESSUserID"] . " ORDER BY SubjectName) AS sub
		LEFT OUTER JOIN 
		(SELECT distinct SubjectName, CASE COALESCE(IM.stdstatus,'') WHEN 'A' THEN 'AA' ELSE CONVERT((Q1 + Q2 + Q3 + Q4 + Q5 + Q6 + Q7 + Q8 + Q9 + Q10 + Q11 + Q12 + Q13 + Q14 + Q15 + Q16 + Q17 + Q18 + Q19 + Q20) , CHAR(10)) END AS TotMarks1 ,examname,InSem as marksall1
		FROM tblinsemmarks IM 
		INNER JOIN tblcapblockprof CBP ON IM.CapId = CBP.cbpid 
		INNER JOIN tblexamblock EB ON EB.ExamBlockID = CBP.ExamBlockID 
		INNER JOIN tblpapermaster PM ON PM.PaperID = EB.PaperID 
		INNER JOIN tblsubjectmaster SM ON SM.SubjectID = PM.SubjectID 
		INNER JOIN tblstdadm sa ON sa.rollno = IM.stdid 
		INNER JOIN tblexammaster em ON em.ExamID = CBP.ExamId and em.AcadYearFrom = sa.EduYearFrom  and em.Sem = {$Sem}
		WHERE sa.stdid = " . $_SESSION["SESSUserID"] . " AND examname LIKE '%T1%' 
		ORDER BY SubjectName) AS t1 ON sub.SubjectName = t1.SubjectName
		LEFT OUTER JOIN 
		(SELECT SubjectName, CASE COALESCE(IM.stdstatus,'') WHEN 'A' THEN 'AA' ELSE CONVERT((Q1 + Q2 + Q3 + Q4 + Q5 + Q6 + Q7 + Q8 + Q9 + Q10 + Q11 + Q12 + Q13 + Q14 + Q15 + Q16 + Q17 + Q18 + Q19 + Q20) , CHAR(10)) END AS TotMarks2,InSem as marksall2
		FROM tblinsemmarks IM 
		INNER JOIN tblcapblockprof CBP ON IM.CapId = CBP.cbpid 
		INNER JOIN tblexamblock EB ON EB.ExamBlockID = CBP.ExamBlockID 
		INNER JOIN tblpapermaster PM ON PM.PaperID = EB.PaperID 
		INNER JOIN tblsubjectmaster SM ON SM.SubjectID = PM.SubjectID 
		INNER JOIN tblstdadm sa ON sa.rollno = IM.stdid 
		INNER JOIN tblexammaster em ON em.ExamID = CBP.ExamId and em.AcadYearFrom = sa.EduYearFrom  and em.Sem = {$Sem}
		WHERE sa.stdid = " . $_SESSION["SESSUserID"] . " AND examname LIKE '%T2%' 
		ORDER BY SubjectName) AS T2 ON sub.SubjectName = T2.SubjectName
		LEFT OUTER JOIN (SELECT SubjectName, CASE COALESCE(IM.stdstatus,'') WHEN 'A' THEN 'AA' 
					ELSE CONVERT((Q1 + Q2 + Q3 + Q4 + Q5 + Q6 + Q7 + Q8 + Q9 + Q10 + Q11 + Q12 + Q13 + Q14 + Q15 + Q16 + Q17 + Q18 + Q19 + Q20) , CHAR(10)) END 
					AS TotMarks3,Paper as marksall3,coalesce(revaltotal,0) as revaltotal
					FROM tblinsemmarks IM 
					INNER JOIN tblcapblockprof CBP ON IM.CapId = CBP.cbpid 
					INNER JOIN tblexamblock EB ON EB.ExamBlockID = CBP.ExamBlockID 
					INNER JOIN tblpapermaster PM ON PM.PaperID = EB.PaperID 
					INNER JOIN tblsubjectmaster SM ON SM.SubjectID = PM.SubjectID 
					INNER JOIN tblstdadm sa ON sa.ESNum = IM.stdid 
					INNER JOIN tblexammaster em ON em.ExamID = CBP.ExamId and em.AcadYearFrom = sa.EduYearFrom  and em.Sem = {$Sem}
					WHERE sa.stdid = " . $_SESSION["SESSUserID"] . " AND examname LIKE '%Regular%' 
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
					INNER JOIN tblexammaster em ON em.ExamID = CBP.ExamId and em.AcadYearFrom = sa.EduYearFrom  and em.Sem = {$Sem}
					WHERE sa.stdid = " . $_SESSION["SESSUserID"] . " AND examname LIKE '%Retest%' 
					ORDER BY SubjectName) AS T4 ON sub.SubjectName = T4.SubjectName";		
	}
		
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
					if(($TotMarks4 <> '999') AND ((stripos($_SESSION["SESSCAPSelectedExamName"], 'Retest') > 0 ) || (stripos($_SESSION["SESSCAPSelectedExamName"], 'Summer') > 0 ))){
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
					if(((stripos($_SESSION["SESSCAPSelectedExamName"], 'Retest') > 0 ) || (stripos($_SESSION["SESSCAPSelectedExamName"], 'Summer') > 0 ))){
						if(((($sum * 100)/$marlsall) < 50) and (((($sum + 1) * 100)/$marlsall) >= 50)){
							$sum = $sum + 1;
							$TotMarks3New = $TotMarks3New + 1;
						}
					}
					
					if($marksall3 <> 1000){
							if(((round($TotMarks3New) * 100)/$marksall3) < 40){
								$finalresult = 'F';
								$Credits = 0;
							}
						}
						else{
							if($PaperCode == 'ES 1102'){
								if((round($TotMarks1 + $TotMarks2)) * 100/(($marksall1)) < 40){
									$finalresult = 'F';
									$Credits = 0;
								}
							}
							else if(((round($TotMarks1 + $TotMarks2) * 100)/$marlsall) < 40){
								$finalresult = 'F';
								$Credits = 0;
							}
						}
						if($TotMarks3New == 'AA'){
							$finalresult = 'F';
							$Credits = 0;
						}
						if($finalresult == 'P'){
							if(((stripos($_SESSION["SESSCAPSelectedExamName"], 'Retest') > 0 ) || (stripos($_SESSION["SESSCAPSelectedExamName"], 'Summer') > 0 ))){
								if((($sum * 100)/$marlsall) < 50){
										$finalresult = 'F';
										$Credits = 0;
								}
							}
							else{
								if((($sum * 100)/$marlsall) < 40){
										$finalresult = 'F';
										$Credits = 0;
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
						if(($TotMarks4 <> '999') AND ((stripos($_SESSION["SESSCAPSelectedExamName"], 'Retest') > 0 ) || (stripos($_SESSION["SESSCAPSelectedExamName"], 'Summer') > 0 ))){
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
							//			$finalresult = 'D';
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
					if(((stripos($_SESSION["SESSCAPSelectedExamName"], 'Retest') > 0 ) || (stripos($_SESSION["SESSCAPSelectedExamName"], 'Summer') > 0 ))){
						if(strlen($finalresult) == 2){
							echo "&nbsp&nbsp&nbsp#";
						}
						else{
							echo "&nbsp&nbsp&nbsp&nbsp&nbsp#";
						}
					}
					echo "</td>";
					echo "<td>{$Credits}</td>";
					echo "</TR>";
				}
			}					
			//disconnect from database	
			$result->free();
			
			$sql2 = "SELECT distinct PaperCode,SM.SubjectName AS SubjectName,'-' AS M1,'-' AS M2,'-' AS M3,marks AS TotMarks,
					CASE WHEN COALESCE(PracticalPRapp,0) = 1 THEN PracticalPR ELSE 
					CASE WHEN COALESCE(OralORapp,0) = 1 THEN OralOR 
					ELSE CASE WHEN COALESCE(TermWorkapp,0) = 1 THEN TermWork
					END END END AS marksall,
					CASE WHEN COALESCE(PracticalPRapp,0) = 1 THEN 'PR' ELSE 
					CASE WHEN COALESCE(OralORapp,0) = 1 THEN 'OR' 
					ELSE CASE WHEN COALESCE(TermWorkapp,0) = 1 THEN 'TW' 
					END END END as headtype
					FROM tblstdadm sa 
					INNER JOIN tblpapermaster pm ON SUBSTRING(pm.EnggYear,1,2) = REPLACE(YEAR,'.','') AND COALESCE(StdStatus,'') IN ('R','P') 
					INNER JOIN tblsubjectmaster SM ON SM.SubjectID = pm.SubjectID 
					INNER JOIN tbldivmaster dm ON REPLACE(dm.Year,'.','') = SUBSTRING(pm.EnggYear,1,2) 
					INNER JOIN `tblpatternmaster` patm ON patm.acadyear = CONCAT(sa.EduYearFrom,'-',SUBSTRING(sa.EduYearTo,3,2)) AND 
					dm.year = patm.eduyear AND pm.EnggPattern = patm.teachingpat 
					INNER JOIN tblcapblockprof cpb ON cpb.ExamBlockID = pm.PaperID AND cpb.`div` = dm.DivName 
					INNER JOIN tblprormarks prormarks ON cpb.cbpid = prormarks.cbpid AND prormarks.stdadmid = sa.StdAdmID 
					WHERE (COALESCE(PracticalPRapp,0) = 1 OR COALESCE(OralORapp,0) = 1 OR COALESCE(TermWorkapp,0) = 1 ) 
					AND sa.EduYearFrom = dm.EduYearFrom
					AND sa.stdid = " . $_SESSION["SESSUserID"] . " 
					AND cpb.ExamID = {$ExamID}  and em.Sem = {$Sem}";

					//INNER JOIN tblcuryearauto cy ON cy.EduYearFrom = dm.EduYearFrom AND SUBSTRING(EnggYear,LENGTH(EnggYear),1) = cy.Sem 
					//INNER JOIN tblcuryearauto cy ON cy.EduYearFrom = dm.EduYearFrom AND SUBSTRING(EnggYear,LENGTH(EnggYear),1) =  = cy.Sem

					$sql2 = "SELECT DISTINCT PaperCode,A.SubjectName,M1,M2,M3,COALESCE(TotMarks,0) AS TotMarks,marksall,headtype,COALESCE(TotMarks2,'999') AS TotMarks2
					FROM 
					(SELECT DISTINCT PaperCode,SM.SubjectName AS SubjectName,'-' AS M1,'-' AS M2,'-' AS M3,marks AS TotMarks, 
					CASE WHEN COALESCE(PracticalPRapp,0) = 1 THEN PracticalPR ELSE CASE WHEN COALESCE(OralORapp,0) = 1 THEN OralOR ELSE 
					CASE WHEN COALESCE(TermWorkapp,0) = 1 THEN TermWork ELSE 1 END END END AS marksall, 
					CASE WHEN COALESCE(PracticalPRapp,0) = 1 THEN 'PR' ELSE CASE WHEN COALESCE(OralORapp,0) = 1 THEN 'OR' ELSE 
					CASE WHEN COALESCE(TermWorkapp,0) = 1 THEN 'TW' END END END AS headtype FROM tblstdadm sa 
					INNER JOIN tblpapermaster pm ON SUBSTRING(pm.EnggYear,1,2) = REPLACE(YEAR,'.','') 
					
					INNER JOIN tblsubjectmaster SM ON SM.SubjectID = pm.SubjectID INNER JOIN tbldivmaster dm ON REPLACE(dm.Year,'.','') = SUBSTRING(pm.EnggYear,1,2) 
					INNER JOIN tblexammaster em ON em.AcadYearFrom = dm.eduyearfrom AND SUBSTRING(EnggYear,LENGTH(EnggYear),1)  = em.Sem 
					AND em.ExamID = {$ExamID}
					INNER JOIN `tblpatternmaster` patm ON patm.acadyear = CONCAT(sa.EduYearFrom,'-',SUBSTRING(sa.EduYearTo,3,2)) AND dm.year = patm.eduyear 
					AND pm.EnggPattern = patm.teachingpat 
					INNER JOIN tblcapblockprof cpb ON cpb.ExamBlockID = pm.PaperID AND cpb.`div` = dm.DivName and em.ExamID = cpb.ExamId
					INNER JOIN tblprormarks prormarks ON cpb.cbpid = prormarks.cbpid AND prormarks.stdadmid = sa.StdAdmID 
					WHERE (COALESCE(PracticalPRapp,0) = 1 OR COALESCE(OralORapp,0) = 1 OR COALESCE(TermWorkapp,0) = 1 ) 
					AND sa.stdid = " . $_SESSION["SESSUserID"] . "
					and SM.SubjectName not like '%value education%'
					) AS A
					LEFT OUTER JOIN 
					(
					SELECT DISTINCT SM.SubjectName AS SubjectName,marks AS TotMarks2
					FROM tblstdadm sa 
					INNER JOIN tblpapermaster pm ON SUBSTRING(pm.EnggYear,1,2) = REPLACE(YEAR,'.','') 
					INNER JOIN tblsubjectmaster SM ON SM.SubjectID = pm.SubjectID INNER JOIN tbldivmaster dm ON REPLACE(dm.Year,'.','') = SUBSTRING(pm.EnggYear,1,2) 
					INNER JOIN tblexammaster em ON em.AcadYearFrom = dm.eduyearfrom AND SUBSTRING(EnggYear,LENGTH(EnggYear),1)  = em.Sem
					INNER JOIN `tblpatternmaster` patm ON patm.acadyear = CONCAT(sa.EduYearFrom,'-',SUBSTRING(sa.EduYearTo,3,2)) AND dm.year = patm.eduyear 
					AND pm.EnggPattern = patm.teachingpat INNER JOIN tblcapblockprof cpb ON cpb.ExamBlockID = pm.PaperID AND cpb.`div` = dm.DivName 
					and em.ExamID = cpb.ExamId
					INNER JOIN tblprormarks prormarks ON cpb.cbpid = prormarks.cbpid AND prormarks.stdadmid = sa.StdAdmID 
					WHERE (COALESCE(PracticalPRapp,0) = 1 OR COALESCE(OralORapp,0) = 1 OR COALESCE(TermWorkapp,0) = 1 ) 
					AND sa.stdid = " . $_SESSION["SESSUserID"] . "
					AND examname LIKE '%Retest%' 
					AND em.Sem = {$Sem}  and SM.SubjectName not like '%value education%'
					) AS B ON  A.SubjectName = B.SubjectName";

//AND SUBSTRING(pm.EnggYear,LENGTH(pm.EnggYear),1) = {$Sem}
//AND sa.EduYearFrom = dm.EduYearFrom
//AND COALESCE(StdStatus,'') IN ('R','P') 
// AND COALESCE(StdStatus,'') IN ('R','P') 
			//echo $sql2;
			$result2 = $mysqli->query( $sql2 );
			echo $mysqli->error;
			$num_results2 = $result2->num_rows;
			if( $num_results2 ){
				while( $row2 = $result2->fetch_assoc() ){
					extract($row2);
					$finalresult = 'P';
					if(($TotMarks2 <> '999') AND ((stripos($_SESSION["SESSCAPSelectedExamName"], 'Retest') > 0 ) || (stripos($_SESSION["SESSCAPSelectedExamName"], 'Summer') > 0 ))){
						$TotMarks = $TotMarks2;
					}
					if(($TotMarks2 <> '999') AND ((stripos($_SESSION["SESSCAPSelectedExamName"], 'Retest') > 0 ) || (stripos($_SESSION["SESSCAPSelectedExamName"], 'Summer') > 0 ))){
						if(((round($TotMarks) * 100)/$marksall) < 50){
							$finalresult = 'F';
							$Credits = 0;
						}
					}
					else{
						if(((round($TotMarks) * 100)/$marksall) < 40){
							$finalresult = 'F';
							$Credits = 0;
						}
					}
						if($TotMarks == 'AA'){
							$finalresult = 'F';
							$Credits = 0;
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
						if(($TotMarks2 <> '999') AND ((stripos($_SESSION["SESSCAPSelectedExamName"], 'Retest') > 0 ) || (stripos($_SESSION["SESSCAPSelectedExamName"], 'Summer') > 0 ))){
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
					if(($TotMarks2 <> '999') AND ((stripos($_SESSION["SESSCAPSelectedExamName"], 'Retest') > 0 ) || (stripos($_SESSION["SESSCAPSelectedExamName"], 'Summer') > 0 ))){
						if(strlen($finalresult) == 2){
							echo "&nbsp&nbsp&nbsp#";
						}
						else{
							echo "&nbsp&nbsp&nbsp&nbsp&nbsp#";
						}
					}
					echo "</td>";
					echo "<td>{$Credits}</td>";
					echo "</TR>";
				}
			}					
			//disconnect from database	
			$result2->free();
			$mysqli->close();
	?>
    </table>
	<br/><br/>
	<?php
			}
	}
	?>
	

			<br/>
	<br/>
	<table width="90%" cellpadding="5" cellspacing="0" class="fix-table" style="margin-left: 5%;">
	<TR>
		<td colspan='7' class='th-heading'><center>*** This is not an Official marksheet. ***</center></td>
	</TR>
	<TR>
		<td colspan='7' class='th-heading'><center>* Refer Sr. No. 10.1, Page No.15 of rule book.  # Appeared for Re-examination.</center></td>
	</TR>
	</table>
</body>
</html>
