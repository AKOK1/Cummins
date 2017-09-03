<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>In-Sem Result</title>
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

	<tr><td colspan='8' class='th-heading'><center><h2>Academic Year: <?php echo $_SESSION["SESSCAPAcadFrom"] . "-" . $_SESSION["SESSCAPAcadTo"] . " Sem " . $_SESSION["SESSCAPAcadSem"] . "&nbsp;&nbsp;"; ?> <?php echo $_SESSION["SESSCAPSelectedExamName"]; ?> Marks Report for <?php echo $_GET['deptname'];?> Division: <?php echo $_GET['div'];?></h2>
	</center></td></tr>
	<!-- <?php echo $_GET['MonthName'] . " - " . $_GET['SelYear']; ?>  -->
	<tr><td colspan='8' class='th-heading'><center><h3><?php echo substr($_GET['SubName'],0,strlen($_GET['SubName']) - strpos(strrev($_GET['SubName']),' ')); ?> </h3></center></td></tr>
	
	<tr>
		<td><table width="100%" cellpadding="5" cellspacing="0" class="fix-table" >
		<tr class="th">
			<td >Roll No</td>
			<td >ESN</td>
			<?php
			
				include 'db/db_connect.php';
				$sql = "SELECT DISTINCT pm.PaperID,sm.SubjectName
						FROM tblexamblock eb 
						INNER JOIN tblpapermaster pm ON pm.PaperID = eb.PaperID 
						INNER JOIN tblsubjectmaster sm ON sm.SubjectID = pm.SubjectID 
						INNER JOIN tblblocksmaster bm ON bm.BlockID = eb.BlockID 
						INNER JOIN tblexamschedule es ON es.ExamSchID = eb.ExamSchID
						WHERE eb.ExamSchID IN (SELECT ExamSchID FROM tblexamschedule WHERE ExamID = " . $_SESSION["SESSCAPSelectedExam"] . ")  and pm.DeptID = " . $_GET['dept'] . "
						ORDER BY sm.SubjectName";
				//echo $sql;
				$j = 0;
				$result = $mysqli->query( $sql );
				$num_results = $result->num_rows;
				if( $num_results ){
					while( $row = $result->fetch_assoc() ){
						extract($row);
						$ArrPapers[$j] = $PaperID;
						$j = $j +1;
						//echo "<td >{$AttDate}</td>";
						echo "<td >" . $SubjectName . "</td>";
					}
				}
				//echo "aaa" . count($ArrPapers) . "bbb";
			?>
		</tr>

		<?php
			include 'db/db_connect.php';
			if($_GET['div'] == 'ALL'){
				if($_GET['year'] == 'F.E.'){
					if((stripos($_SESSION["SESSCAPSelectedExamName"], 'Retest') > 0) || (stripos($_SESSION["SESSCAPSelectedExamName"], 'Summer') > 0 )){
						$sql = "SELECT DISTINCT StdId,RollNo,ESNum
								FROM tblstdadm sa
								INNER JOIN `tblyearstructstdretest` yss ON sa.StdAdmID = yss.StdAdmID
								INNER JOIN `tblyearstruct` ys ON ys.rowid = yss.YSID
								INNER JOIN tblexammaster em ON em.ExamId = yss.ExamId AND yss.Sem = em.Sem AND em.ExamID = " . $_SESSION["SESSCAPSelectedExam"] . "
								 AND em.AcadYearFrom = sa.EduYearFrom 
								WHERE COALESCE(stdstatus,'D') IN('R','P') AND COALESCE(ESNum, '') <> '' AND YEAR = '" . $_GET['year'] . "'  ";
								//INNER JOIN tblcuryearauto cy ON cy.EduYearFrom = ys.eduyearfrom AND yss.Sem = cy.Sem
								//and cy.EduYearFrom = sa.EduYearFrom 
						
					}
					else{
						$sql = "SELECT DISTINCT StdId,RollNo,ESNum
								FROM tblstdadm sa
								INNER JOIN `tblyearstructstd` yss ON sa.StdAdmID = yss.StdAdmID
								INNER JOIN `tblyearstruct` ys ON ys.rowid = yss.YSID
								INNER JOIN tblexammaster em ON em.AcadYearFrom = ys.eduyearfrom 
								AND em.ExamID = " . $_SESSION["SESSCAPSelectedExam"] . "
								WHERE COALESCE(stdstatus,'D') IN('R','P') AND COALESCE(ESNum, '') <> '' AND YEAR = '" . $_GET['year'] . "'  ";
								//INNER JOIN tblcuryearauto cy ON cy.EduYearFrom = ys.eduyearfrom 
								//and cy.EduYearFrom = sa.EduYearFrom 
					}
				}
				else{
					if((stripos($_SESSION["SESSCAPSelectedExamName"], 'Retest') > 0) || (stripos($_SESSION["SESSCAPSelectedExamName"], 'Summer') > 0 )){
						$sql = "SELECT DISTINCT StdId,RollNo,ESNum
								FROM tblstdadm sa
								INNER JOIN `tblyearstructstdretest` yss ON sa.StdAdmID = yss.StdAdmID
								INNER JOIN `tblyearstruct` ys ON ys.rowid = yss.YSID
								INNER JOIN tblexammaster em ON em.ExamId = yss.ExamId AND yss.Sem = em.Sem AND em.ExamID = " . $_SESSION["SESSCAPSelectedExam"] . "
								 AND em.AcadYearFrom = sa.EduYearFrom 
								WHERE COALESCE(stdstatus,'D') IN('R','P') AND COALESCE(ESNum, '') <> '' and Dept = " . $_GET['dept'] . " AND YEAR = '" . $_GET['year'] . "'  ";						
								//INNER JOIN tblcuryearauto cy ON cy.EduYearFrom = ys.eduyearfrom AND yss.Sem = cy.Sem
								//and cy.EduYearFrom = sa.EduYearFrom 
					}
					else{
						$sql = "SELECT DISTINCT StdId,RollNo,ESNum
								FROM tblstdadm sa
								INNER JOIN `tblyearstructstd` yss ON sa.StdAdmID = yss.StdAdmID
								INNER JOIN `tblyearstruct` ys ON ys.rowid = yss.YSID
								INNER JOIN tblexammaster em ON em.AcadYearFrom = sa.EduYearFrom 
								AND em.ExamID = " . $_SESSION["SESSCAPSelectedExam"] . "
								AND COALESCE(stdstatus,'D') IN('R','P') AND COALESCE(ESNum, '') <> '' and Dept = " . $_GET['dept'] . " AND YEAR = '" . $_GET['year'] . "'  ";
								//INNER JOIN tblcuryearauto cy ON cy.EduYearFrom = ys.eduyearfrom 
								//and cy.EduYearFrom = sa.EduYearFrom 
					}
				}
			}
			else{
				if($_GET['year'] == 'F.E.'){
					if((stripos($_SESSION["SESSCAPSelectedExamName"], 'Retest') > 0) || (stripos($_SESSION["SESSCAPSelectedExamName"], 'Summer') > 0 )){
						$sql = "SELECT DISTINCT StdId,RollNo,ESNum
								FROM tblstdadm sa
								INNER JOIN `tblyearstructstdretest` yss ON sa.StdAdmID = yss.StdAdmID
								INNER JOIN `tblyearstruct` ys ON ys.rowid = yss.YSID
								INNER JOIN tblexammaster em ON em.ExamId = yss.ExamId AND yss.Sem = em.Sem AND em.ExamID = " . $_SESSION["SESSCAPSelectedExam"] . "
								 AND em.AcadYearFrom = sa.EduYearFrom 
								WHERE COALESCE(stdstatus,'D') IN('R','P') AND COALESCE(ESNum, '') <> ''AND sa.`div` = '" . $_GET['div'] . "' AND YEAR = '" . $_GET['year'] . "'  ";	
								
								//INNER JOIN tblcuryearauto cy ON cy.EduYearFrom = ys.eduyearfrom AND yss.Sem = cy.Sem
								//and cy.EduYearFrom = sa.EduYearFrom 
					}
					else{
						$sql = "SELECT DISTINCT StdId,RollNo,ESNum
								FROM tblstdadm sa
								INNER JOIN `tblyearstructstd` yss ON sa.StdAdmID = yss.StdAdmID
								INNER JOIN `tblyearstruct` ys ON ys.rowid = yss.YSID
								INNER JOIN tblexammaster em ON em.AcadYearFrom = sa.EduYearFrom AND em.ExamID = " . $_SESSION["SESSCAPSelectedExam"] . "
								WHERE COALESCE(stdstatus,'D') IN('R','P') AND COALESCE(ESNum, '') <> ''AND sa.`div` = '" . $_GET['div'] . "' AND YEAR = '" . $_GET['year'] . "'  ";
								//								INNER JOIN tblcuryearauto cy ON cy.EduYearFrom = ys.eduyearfrom 
								//and cy.EduYearFrom = sa.EduYearFrom 

					}
				}
				else{
					if((stripos($_SESSION["SESSCAPSelectedExamName"], 'Retest') > 0) || (stripos($_SESSION["SESSCAPSelectedExamName"], 'Summer') > 0 )){
						$sql = "SELECT DISTINCT StdId,RollNo,ESNum
								FROM tblstdadm sa
								INNER JOIN `tblyearstructstdretest` yss ON sa.StdAdmID = yss.StdAdmID
								INNER JOIN `tblyearstruct` ys ON ys.rowid = yss.YSID
								INNER JOIN tblexammaster em ON em.ExamId = yss.ExamId AND yss.Sem = em.Sem AND em.ExamID = " . $_SESSION["SESSCAPSelectedExam"] . "
								 AND em.AcadYearFrom = sa.EduYearFrom 
								WHERE Dept = " . $_GET['dept'] . " and COALESCE(stdstatus,'D') IN('R','P') AND COALESCE(ESNum, '') <> ''AND sa.`div` = '" . $_GET['div'] . "' and YEAR = '" . $_GET['year'] . "'  ";						
								//INNER JOIN tblcuryearauto cy ON cy.EduYearFrom = ys.eduyearfrom AND yss.Sem = cy.Sem
								//cy.EduYearFrom = sa.EduYearFrom AND 
					}
					else{
						$sql = "SELECT DISTINCT StdId,RollNo,ESNum
								FROM tblstdadm sa
								INNER JOIN `tblyearstructstd` yss ON sa.StdAdmID = yss.StdAdmID
								INNER JOIN `tblyearstruct` ys ON ys.rowid = yss.YSID
								INNER JOIN tblexammaster em ON em.AcadYearFrom = sa.EduYearFrom 
								AND em.ExamID = " . $_SESSION["SESSCAPSelectedExam"] . "
								WHERE COALESCE(stdstatus,'D') IN('R','P') AND COALESCE(ESNum, '') <> ''AND sa.`div` = '" . $_GET['div'] . "' and YEAR = '" . $_GET['year'] . "'  ";
								//INNER JOIN tblcuryearauto cy ON cy.EduYearFrom = ys.eduyearfrom 
								//cy.EduYearFrom = sa.EduYearFrom AND
					}
				}
			}
			if(stripos($_SESSION["SESSCAPSelectedExamName"], 'ESE') > 0 ){
				$sql = $sql . " order by ESNum";
			}
			else{
				$sql = $sql . " order by RollNo";
			}
			//echo $sql;
			$result = $mysqli->query( $sql );
			echo $mysqli->error;
			$num_results = $result->num_rows;

			if( $num_results ){
				while( $row = $result->fetch_assoc() ){

					extract($row);
					echo "<tr>";
					echo "<td ><center style='font-size:18px'>{$RollNo}</center></td>";
					echo "<td ><center style='font-size:18px'>{$ESNum}</center></td>";
					$Tot = 0 ;
					$p = 0 ;
					
					for ($z = 0 ; $z <= count($ArrPapers) - 1; $z++) {
if($_GET['div'] == 'ALL'){
						$sqlM = "SELECT CASE coalesce(IM.stdstatus,'') WHEN 'A' THEN 'AA' 
ELSE CONVERT((Q1 + Q2 + Q3 + Q4 + Q5 + Q6 + Q7 + Q8 + Q9 + Q10 + Q11 + Q12 + Q13 + Q14 + Q15 + Q16 + Q17 + Q18 + Q19 + Q20) , CHAR(10)) END AS TotMarks,coalesce(revaltotal,0) as revaltotal 
								FROM tblinsemmarks IM 
								INNER JOIN tblcapblockprof CBP ON IM.CapId = CBP.cbpid 
								INNER JOIN tblexamblock EB ON EB.ExamBlockID = CBP.ExamBlockID 
								INNER JOIN tblpapermaster PM ON PM.PaperID = EB.PaperID 
								INNER JOIN tblsubjectmaster SM ON SM.SubjectID = PM.SubjectID 
								INNER JOIN tblstdadm sa ON (sa.ESNum = IM.stdid) or (sa.RollNo = IM.stdid)
								INNER JOIN tblexammaster em ON em.ExamID = CBP.ExamID AND em.ExamID = " . $_SESSION["SESSCAPSelectedExam"] . "
								WHERE sa.stdid = " . $StdId. " AND PM.PaperID = " . $ArrPapers[$z] . 
								"  AND CBP.ExamID =  " . $_SESSION["SESSCAPSelectedExam"] . "";
								//INNER JOIN tblcuryearauto cy ON cy.EduYearFrom = sa.EduYearFrom
}
			else{
						$sqlM = "SELECT CASE coalesce(IM.stdstatus,'') WHEN 'A' THEN 'AA' 
ELSE CONVERT((Q1 + Q2 + Q3 + Q4 + Q5 + Q6 + Q7 + Q8 + Q9 + Q10 + Q11 + Q12 + Q13 + Q14 + Q15 + Q16 + Q17 + Q18 + Q19 + Q20) , CHAR(10)) END AS TotMarks,coalesce(revaltotal,0) as revaltotal 
								FROM tblinsemmarks IM 
								INNER JOIN tblcapblockprof CBP ON IM.CapId = CBP.cbpid 
								INNER JOIN tblexamblock EB ON EB.ExamBlockID = CBP.ExamBlockID 
								INNER JOIN tblpapermaster PM ON PM.PaperID = EB.PaperID 
								INNER JOIN tblsubjectmaster SM ON SM.SubjectID = PM.SubjectID 
								INNER JOIN tblstdadm sa ON (sa.ESNum = IM.stdid) or (sa.RollNo = IM.stdid)
								INNER JOIN tblexammaster em ON em.ExamID = CBP.ExamID AND em.ExamID = " . $_SESSION["SESSCAPSelectedExam"] . "
								WHERE sa.stdid = " . $StdId. " AND PM.PaperID = " . $ArrPapers[$z] . 
								" and EB.ExamSchID in (select ExamSchID from tblexamschedule 
								where ExamID = " . $_SESSION["SESSCAPSelectedExam"] . ")
								order by IM.stdid";
								//INNER JOIN tblcuryearauto cy ON cy.EduYearFrom = sa.EduYearFrom

}
						//echo $sqlM;
						// $sqlM = " SELECT CASE COALESCE(Attendance, 0) WHEN 0 THEN 'A' ELSE 'P' END AS Attendance 
								// FROM tblattendance A
								// Inner join tblattmaster AM on A.attmasterid = AM.attmasterid
								// AND AM.BatchId = " . strrev(substr(strrev($_GET['SubName']),0,strpos(strrev($_GET['SubName']),' '))) . "
								// WHERE A.ysid = " . $_GET['ysid'] . " and StdID = " . $StdId. " 
								// and LEFT(convert(AM.attdate, char(10)), 10) = '" .$ArrAttDate[$z] . "'	
								// and AM.starttime = '" . $ArrAttStartTime[$z] . "' and AM.endtime = '" . $ArrAttEndTime[$z] . "' ORDER BY StdID ";

						//echo $sqlM;
						//die;
						$resultM = $mysqli->query( $sqlM );
						if( $resultM->num_rows ){
							while( $row = $resultM->fetch_assoc() ){
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
									if($TotMarks == '19.5'){
										$TotMarks3New = '20';
									}
									else{
										$TotMarks3New = $TotMarks;
									}
								}
								echo "<td><center style='font-size:18px'>{$TotMarks3New}</center></td>";
								break;
							}
						}
						else
						{
							echo "<td ><center style='font-size:18px'>-</center></td>";
							
						}
					}
					echo "</tr>";
				}
			}	
			//<br/><b>{$TimeFromTo}</b>				
			//disconnect from database
			$result->free();
			$mysqli->close();
		?>	  
		</tr>
	  
	  
	  
    </table></td>
  </tr>
</table>
<br/><br/><br/><br/><br/><br/>
<div>
	<div style="float:left;width:50%">
		<center style='font-size:18px'>Director</center>
	</div>
	<div style="float:right;width:50%">
		<center style='font-size:18px'>Dean Examination</center>
	</div>
</div>
</body>
</html>
