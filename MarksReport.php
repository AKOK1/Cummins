<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Marks Report</title>
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
	line-height:14px;
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
.cen {
    margin: auto;
    width: 90%;
}
</style>
</head>
<body>
	<br/>
	<center><img class="center" alt="logo" src="images/logo.png"></center>
	<br/>
	<center>
		<h2>Marks Report for Div. <?php echo $_GET['subjname']; ?></h2>
			<?php
					if(!isset($_SESSION)){
						session_start();
					}
					include 'db/db_connect.php';
					$sql = "SELECT (MAX(EduYearTo) - 1) AS YearFrom, MAX(EduYearTo) as YearTo FROM tblcuryear";
					$result = $mysqli->query($sql);
					$num_results = $result->num_rows;
					If( $num_results ){
						while( $row = $result->fetch_assoc() ){
							extract($row);
							$SelYearFrom = $YearFrom;
							$SelYearTo = $YearTo;
						}
					}
					else {
							echo "Error";
							die;
					}		
					$result->free();
					if(stripos($_SESSION["SESSCAPSelectedExamName"], 'Regular') > 0 ){
						$sql = "SELECT distinct RollNo,ESNum,sa.StdAdmID,CONCAT(FirstName, ' ',FatherName , ' ', Surname) AS StdName,marks
								FROM tblstdadm sa
								INNER JOIN tblstudent s ON s.StdID = sa.StdID
								INNER JOIN tblyearstructstd yss ON yss.StdAdmID = sa.StdAdmID
								INNER JOIN tblyearstruct ys ON ys.rowid = yss.YSID
								INNER JOIN tblpapermaster pm ON SUBSTRING(pm.EnggYear,1,2) = REPLACE(YEAR,'.','') AND COALESCE(StdStatus,'') IN ('R','P')
								AND pm.PaperID = ys.PaperID
								INNER JOIN tbldivmaster dm ON REPLACE(dm.Year,'.','') = SUBSTRING(pm.EnggYear,1,2) 
								INNER JOIN tblcuryearauto cy ON cy.EduYearFrom = dm.EduYearFrom AND SUBSTRING(EnggYear,LENGTH(EnggYear),1) = cy.Sem
								INNER JOIN `tblpatternmaster` patm ON patm.acadyear = CONCAT(cy.EduYearFrom,'-',SUBSTRING(cy.EduYearTo,3,2)) AND dm.year = patm.eduyear 
								AND pm.EnggPattern = patm.teachingpat 
								INNER JOIN tblcapblockprof cpb ON cpb.ExamBlockID = pm.PaperID AND cpb.`div` = dm.DivName AND sa.Div = cpb.div
								LEFT OUTER JOIN tblprormarks prormarks ON cpb.cbpid = prormarks.cbpid AND prormarks.stdadmid = sa.StdAdmID
								WHERE (COALESCE(PracticalPRapp,0) = 1 OR COALESCE(OralORapp,0) = 1  OR COALESCE(TermWorkapp,0) = 1) 
								AND cpb.cbpid = " . $_GET["cbpid"] . "
								AND cy.EduYearFrom = sa.EduYearFrom 
								and cpb.ExamID = " . $_SESSION["SESSCAPSelectedExam"] . "
								Order by RollNo";
					}
					else{
						$sql = "SELECT distinct RollNo,ESNum,sa.StdAdmID,CONCAT(FirstName, ' ',FatherName , ' ', Surname) AS StdName,marks
								FROM tblstdadm sa
								INNER JOIN tblstudent s ON s.StdID = sa.StdID
								INNER JOIN tblyearstructstdretest yss ON yss.StdAdmID = sa.StdAdmID
								INNER JOIN tblyearstruct ys ON ys.rowid = yss.YSID
								INNER JOIN tblpapermaster pm ON SUBSTRING(pm.EnggYear,1,2) = REPLACE(YEAR,'.','') AND COALESCE(StdStatus,'') IN ('R','P')
								AND pm.PaperID = ys.PaperID
								INNER JOIN tbldivmaster dm ON REPLACE(dm.Year,'.','') = SUBSTRING(pm.EnggYear,1,2) 
								INNER JOIN tblcuryearauto cy ON cy.EduYearFrom = dm.EduYearFrom AND SUBSTRING(EnggYear,LENGTH(EnggYear),1) = cy.Sem
								INNER JOIN `tblpatternmaster` patm ON patm.acadyear = CONCAT(cy.EduYearFrom,'-',SUBSTRING(cy.EduYearTo,3,2)) AND dm.year = patm.eduyear 
								AND pm.EnggPattern = patm.teachingpat 
								INNER JOIN tblcapblockprof cpb ON cpb.ExamBlockID = pm.PaperID 
								LEFT OUTER JOIN tblprormarks prormarks ON cpb.cbpid = prormarks.cbpid AND prormarks.stdadmid = sa.StdAdmID
								WHERE (COALESCE(PracticalPRapp,0) = 1 OR COALESCE(OralORapp,0) = 1  OR COALESCE(TermWorkapp,0) = 1) 
								AND cpb.cbpid = " . $_GET["cbpid"] . "
								AND cy.EduYearFrom = sa.EduYearFrom 
								and cpb.ExamID = " . $_SESSION["SESSCAPSelectedExam"] . "
								Order by RollNo";
//AND cpb.`div` = dm.DivName AND sa.Div = cpb.div
					}
					//echo $sql;
					// Prepare IN parameters
					//echo $sql;
					//die;
					$result = $mysqli->query($sql);
					$num_results = $result->num_rows;
					$srno = 1;
echo" <div class='cen'>";
	for($i= 1;$i<=3 ;$i++) {
		echo "<div style='float:left'>";
		echo"<table border='0' style='float:left;width:auto;' cellpadding='5'  cellspacing='0' class='fix-table'>";
				echo"<tr>";
					echo"<th>Sr. No.</th>";
					echo"<th>Roll No.</th>";
					echo"<th>ESN</th>";
					echo"<th>Marks</th>";
				echo"</tr>";
				$counter = 0;
				$max = 30;
				if( $num_results ){
					while( $row = $result->fetch_assoc()){
						//echo $row;
						extract($row);
						echo "<TR class='odd gradeX'>";
						echo "<td>{$srno} </td>";
						echo "<td>{$RollNo} </td>";
						echo "<td>{$ESNum} </td>";
						echo "<td>{$marks} </td>";
						echo "</TR>";
						$counter++;
						if($counter == $max)
						{
							$srno = $srno  + 1;
							break;
						}
						$srno = $srno  + 1;
					}
					while($counter < 30){
						echo "<TR class='odd gradeX'>";
						echo "<td></td>";
						echo "<td></td>";
						echo "<td></td>";
						echo "<td></td>";
						echo "</TR>";
						$counter++;
					}
					//$counter =0;
				}
				if($i == 3){
					$srno = 60 + $counter  +1;
					while(($srno < 91) && ($srno > 59)){
						echo "<TR class='odd gradeX'>";
						echo "<td></td>";
						echo "<td></td>";
						echo "<td></td>";
						echo "<td></td>";
						echo "</TR>";
						$srno = $srno  + 1;
					}
				}
		echo"</table>";
		echo "</div>";
	}
echo"</div>";
					$result->free();
					//disconnect from database
					$mysqli->close();
		?>
	</center>
</body>
</html>