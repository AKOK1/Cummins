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

	<tr><td colspan='8' class='th-heading'><center><h2>Academic Year: <?php echo $_SESSION["SESSCAPAcadFrom"] . "-" . $_SESSION["SESSCAPAcadTo"] . " Sem " . $_SESSION["SESSCAPAcadSem"] . "&nbsp;&nbsp;"; ?> <?php echo $_SESSION["SESSCAPSelectedExamName"]; ?>  PR / OR / TW Marks Report <?php echo $_GET['deptname'];?> for Division: <?php echo $_GET['div'];?></h2>
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
				$sql = "SELECT DISTINCT pm.PaperID,CONCAT(sm.SubjectName , 
							CASE WHEN COALESCE(PracticalPRapp,0) = 1 THEN ' - PR' ELSE 
							CASE WHEN COALESCE(OralORapp,0) = 1 THEN ' - OR' 
										ELSE CASE WHEN COALESCE(TermWorkapp,0) = 1 THEN ' - TW' 
								END END END) AS SubjectName
						FROM tblpapermaster pm 
						INNER JOIN tbldivmaster dm ON REPLACE(dm.Year,'.','') = SUBSTRING(pm.EnggYear,1,2)
						INNER JOIN tblexammaster em ON em.AcadYearFrom = dm.EduYearFrom AND SUBSTRING(EnggYear,LENGTH(EnggYear),1) = em.Sem
						 AND em.ExamID = " . $_SESSION["SESSCAPSelectedExam"] . "
						INNER JOIN `tblpatternmaster` patm ON patm.acadyear = CONCAT(em.AcadYearFrom,'-',SUBSTRING(em.AcadYearTo,3,2)) AND dm.year = patm.eduyear
						AND pm.EnggPattern = patm.teachingpat
						INNER JOIN tblsubjectmaster sm ON sm.SubjectID = pm.SubjectID 
						WHERE 
						(COALESCE(PracticalPRapp,0) = 1 OR COALESCE(OralORapp,0) = 1 OR COALESCE(TermWorkapp,0) = 1 )
						AND CONCAT(PaperID,dm.DivName) IN (SELECT CONCAT(ExamBlockID,COALESCE(`div`,'')) 
						FROM tblcapblockprof WHERE ExamID = " . $_SESSION["SESSCAPSelectedExam"] . ")
						 and pm.DeptID = " . $_GET['dept'] . " 
						ORDER BY sm.SubjectName";
						//INNER JOIN tblcuryearauto cy ON cy.EduYearFrom = dm.EduYearFrom AND SUBSTRING(EnggYear,LENGTH(EnggYear),1) = cy.Sem
						
					
						//
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
					if(stripos($_SESSION["SESSCAPSelectedExamName"], 'Retest') > 0 ){
						$sql = "SELECT DISTINCT StdId,RollNo,ESNum
								FROM tblstdadm sa
								INNER JOIN `tblyearstructstdretest` yss ON sa.StdAdmID = yss.StdAdmID
								INNER JOIN `tblyearstruct` ys ON ys.rowid = yss.YSID
								INNER JOIN tblexammaster em ON em.AcadYearFrom = ys.eduyearfrom AND yss.Sem = em.Sem
								 AND em.ExamID = " . $_SESSION["SESSCAPSelectedExam"] . "
								WHERE COALESCE(stdstatus,'D') IN('R','P') AND COALESCE(ESNum, '') <> '' and em.AcadYearFrom = sa.EduYearFrom AND YEAR = '" . $_GET['year'] . "'  ORDER BY RollNo";						
								//INNER JOIN tblcuryearauto cy ON cy.EduYearFrom = ys.eduyearfrom AND yss.Sem = cy.Sem
					}
					else{
						$sql = "SELECT DISTINCT StdId,RollNo,ESNum
								FROM tblstdadm sa
								INNER JOIN `tblyearstructstd` yss ON sa.StdAdmID = yss.StdAdmID
								INNER JOIN `tblyearstruct` ys ON ys.rowid = yss.YSID
								INNER JOIN tblexammaster em ON em.AcadYearFrom = ys.eduyearfrom
								 AND em.ExamID = " . $_SESSION["SESSCAPSelectedExam"] . "
								WHERE COALESCE(stdstatus,'D') IN('R','P') AND COALESCE(ESNum, '') <> '' and em.AcadYearFrom = sa.EduYearFrom AND YEAR = '" . $_GET['year'] . "'  ORDER BY RollNo";
								//INNER JOIN tblcuryearauto cy ON cy.EduYearFrom = ys.eduyearfrom 
					}
				}
				else{
					if(stripos($_SESSION["SESSCAPSelectedExamName"], 'Retest') > 0 ){
						$sql = "SELECT DISTINCT StdId,RollNo,ESNum
								FROM tblstdadm sa
								INNER JOIN `tblyearstructstdretest` yss ON sa.StdAdmID = yss.StdAdmID
								INNER JOIN `tblyearstruct` ys ON ys.rowid = yss.YSID
								INNER JOIN tblexammaster em ON em.AcadYearFrom = ys.eduyearfrom AND yss.Sem = em.Sem
								 AND em.ExamID = " . $_SESSION["SESSCAPSelectedExam"] . "
								WHERE COALESCE(stdstatus,'D') IN('R','P') AND COALESCE(ESNum, '') <> '' and Dept = " . $_GET['dept'] . " and em.AcadYearFrom = sa.EduYearFrom AND YEAR = '" . $_GET['year'] . "'  ORDER BY RollNo";						
								//INNER JOIN tblcuryearauto cy ON cy.EduYearFrom = ys.eduyearfrom AND yss.Sem = cy.Sem
					}
					else{
						$sql = "SELECT DISTINCT StdId,RollNo,ESNum
								FROM tblstdadm sa
								INNER JOIN `tblyearstructstd` yss ON sa.StdAdmID = yss.StdAdmID
								INNER JOIN `tblyearstruct` ys ON ys.rowid = yss.YSID
								INNER JOIN tblexammaster em ON em.AcadYearFrom = ys.eduyearfrom 
								 AND em.ExamID = " . $_SESSION["SESSCAPSelectedExam"] . "
								WHERE COALESCE(stdstatus,'D') IN('R','P') AND COALESCE(ESNum, '') <> '' and Dept = " . $_GET['dept'] . " and em.AcadYearFrom = sa.EduYearFrom AND YEAR = '" . $_GET['year'] . "'  ORDER BY RollNo";
								//INNER JOIN tblcuryearauto cy ON cy.EduYearFrom = ys.eduyearfrom 
					}
				}
			}
			else{
				if($_GET['year'] == 'F.E.'){
					if(stripos($_SESSION["SESSCAPSelectedExamName"], 'Retest') > 0 ){
						$sql = "SELECT DISTINCT StdId,RollNo,ESNum
								FROM tblstdadm sa
								INNER JOIN `tblyearstructstdretest` yss ON sa.StdAdmID = yss.StdAdmID
								INNER JOIN `tblyearstruct` ys ON ys.rowid = yss.YSID
								INNER JOIN tblexammaster em ON em.AcadYearFrom = ys.eduyearfrom AND yss.Sem = em.Sem
								 AND em.ExamID = " . $_SESSION["SESSCAPSelectedExam"] . "
								WHERE COALESCE(stdstatus,'D') IN('R','P') AND COALESCE(ESNum, '') <> '' AND sa.`div` = '" . $_GET['div'] . "' and em.AcadYearFrom = sa.EduYearFrom AND YEAR = '" . $_GET['year'] . "'  ORDER BY RollNo";						
								//INNER JOIN tblcuryearauto cy ON cy.EduYearFrom = ys.eduyearfrom AND yss.Sem = cy.Sem
					}
					else{
						$sql = "SELECT DISTINCT StdId,RollNo,ESNum
								FROM tblstdadm sa
								INNER JOIN `tblyearstructstd` yss ON sa.StdAdmID = yss.StdAdmID
								INNER JOIN `tblyearstruct` ys ON ys.rowid = yss.YSID
								INNER JOIN tblexammaster em ON em.AcadYearFrom = ys.eduyearfrom 
								 AND em.ExamID = " . $_SESSION["SESSCAPSelectedExam"] . "
								WHERE COALESCE(stdstatus,'D') IN('R','P') AND COALESCE(ESNum, '') <> '' AND sa.`div` = '" . $_GET['div'] . "' and em.AcadYearFrom = sa.EduYearFrom AND YEAR = '" . $_GET['year'] . "'  ORDER BY RollNo";
								//INNER JOIN tblcuryearauto cy ON cy.EduYearFrom = ys.eduyearfrom 
					}
				}
				else{
					if(stripos($_SESSION["SESSCAPSelectedExamName"], 'Retest') > 0 ){
						$sql = "SELECT DISTINCT StdId,RollNo,ESNum
								FROM tblstdadm sa
								INNER JOIN `tblyearstructstdretest` yss ON sa.StdAdmID = yss.StdAdmID
								INNER JOIN `tblyearstruct` ys ON ys.rowid = yss.YSID
								INNER JOIN tblexammaster em ON em.AcadYearFrom = ys.eduyearfrom AND yss.Sem = em.Sem
								 AND em.ExamID = " . $_SESSION["SESSCAPSelectedExam"] . "
								WHERE Dept = " . $_GET['dept'] . " and COALESCE(stdstatus,'D') IN('R','P') AND COALESCE(ESNum, '') <> '' AND sa.`div` = '" . $_GET['div'] . "' and em.AcadYearFrom = sa.EduYearFrom AND YEAR = '" . $_GET['year'] . "'  ORDER BY RollNo";						
								//INNER JOIN tblcuryearauto cy ON cy.EduYearFrom = ys.eduyearfrom AND yss.Sem = cy.Sem
					}
					else{
						$sql = "SELECT DISTINCT StdId,RollNo,ESNum
								FROM tblstdadm sa
								INNER JOIN `tblyearstructstd` yss ON sa.StdAdmID = yss.StdAdmID
								INNER JOIN `tblyearstruct` ys ON ys.rowid = yss.YSID
								INNER JOIN tblexammaster em ON em.AcadYearFrom = ys.eduyearfrom 
								 AND em.ExamID = " . $_SESSION["SESSCAPSelectedExam"] . "
								WHERE COALESCE(stdstatus,'D') IN('R','P') AND COALESCE(ESNum, '') <> '' AND sa.`div` = '" . $_GET['div'] . "' and em.AcadYearFrom = sa.EduYearFrom AND YEAR = '" . $_GET['year'] . "'  ORDER BY RollNo";
								//INNER JOIN tblcuryearauto cy ON cy.EduYearFrom = ys.eduyearfrom 
					}
				}
			}
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
						$sqlM = "SELECT marks AS TotMarks 
							FROM tblstdadm sa
							INNER JOIN tblpapermaster pm ON SUBSTRING(pm.EnggYear,1,2) = REPLACE(YEAR,'.','') AND COALESCE(StdStatus,'') IN ('R','P')
							INNER JOIN tbldivmaster dm ON REPLACE(dm.Year,'.','') = SUBSTRING(pm.EnggYear,1,2) 
							INNER JOIN tblexammaster em ON em.AcadYearFrom = dm.eduyearfrom AND SUBSTRING(EnggYear,LENGTH(EnggYear),1)  = em.Sem
							 AND em.ExamID = " . $_SESSION["SESSCAPSelectedExam"] . "
							INNER JOIN `tblpatternmaster` patm ON patm.acadyear = CONCAT(em.AcadYearFrom,'-',SUBSTRING(em.AcadYearTo,3,2)) AND dm.year = patm.eduyear 
							AND pm.EnggPattern = patm.teachingpat 
							INNER JOIN tblcapblockprof cpb ON cpb.ExamBlockID = pm.PaperID AND cpb.`div` = dm.DivName 
							INNER JOIN tblprormarks prormarks 	ON cpb.cbpid = prormarks.cbpid AND prormarks.stdadmid = sa.StdAdmID
							WHERE (COALESCE(PracticalPRapp,0) = 1 OR COALESCE(OralORapp,0) = 1 OR COALESCE(TermWorkapp,0) = 1 ) 
							and sa.stdid = " . $StdId. " AND pm.PaperID = " . $ArrPapers[$z] . 
								"  AND cpb.ExamID =  " . $_SESSION["SESSCAPSelectedExam"] . "";
							//INNER JOIN tblcuryearauto cy ON cy.EduYearFrom = dm.EduYearFrom AND SUBSTRING(EnggYear,LENGTH(EnggYear),1)  = cy.Sem
}
			else{
						$sqlM = "SELECT marks AS TotMarks 
								FROM tblstdadm sa
							INNER JOIN tblpapermaster pm ON SUBSTRING(pm.EnggYear,1,2) = REPLACE(YEAR,'.','') AND COALESCE(StdStatus,'') IN ('R','P')
							INNER JOIN tbldivmaster dm ON REPLACE(dm.Year,'.','') = SUBSTRING(pm.EnggYear,1,2) 
							INNER JOIN tblexammaster em ON em.AcadYearFrom = dm.eduyearfrom AND SUBSTRING(EnggYear,LENGTH(EnggYear),1)  = em.Sem
							 AND em.ExamID = " . $_SESSION["SESSCAPSelectedExam"] . "
							INNER JOIN `tblpatternmaster` patm ON patm.acadyear = CONCAT(dm.eduyearfrom,'-',SUBSTRING(dm.eduyearto,3,2)) AND dm.year = patm.eduyear 
							AND pm.EnggPattern = patm.teachingpat 
							INNER JOIN tblcapblockprof cpb ON cpb.ExamBlockID = pm.PaperID AND cpb.`div` = dm.DivName 
							INNER JOIN tblprormarks prormarks 	ON cpb.cbpid = prormarks.cbpid AND prormarks.stdadmid = sa.StdAdmID
							WHERE (COALESCE(PracticalPRapp,0) = 1 OR COALESCE(OralORapp,0) = 1 OR COALESCE(TermWorkapp,0) = 1 ) 
								and sa.stdid = " . $StdId. " AND pm.PaperID = " . $ArrPapers[$z] . 
								" and cpb.ExamID = " . $_SESSION["SESSCAPSelectedExam"] . "";
							//INNER JOIN tblcuryearauto cy ON cy.EduYearFrom = dm.EduYearFrom AND SUBSTRING(EnggYear,LENGTH(EnggYear),1)  = cy.Sem

}
						//echo $sqlM;
						//die;
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
								echo "<td><center style='font-size:18px'>{$TotMarks}</center></td>";
								break;
							}
						}
						else
						{
							echo "<td ><center style='font-size:18px'>0</center></td>";
							
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
