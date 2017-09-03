<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Hall Ticket</title>
<style type="text/css">
body {
	font-family:Verdana, Geneva, sans-serif;
	font-size: 12px;
	text-align:left;
	margin-left:5px;
	margin-top: 0px;
}
p.solid {border-style: solid;}

.footer {
	font-family:Verdana, Geneva, sans-serif;
	font-size:10px;
	}
.center-text {
	font-family:Verdana, Geneva, sans-serif;
	font-size:13px;
	text-decoration:underline;
	text-align:center;
	}
.simple-table {
	width:100%;
	border-collapse:collapse;
	border:0px;
	line-height:23px;
	}	
.fix-table {
	width:100%;
	border-collapse:collapse;
	border:0px;
	}
	
.fix-table, th, td {
	line-height:23px;
	text-align:left;
	text-indent:5px;
	}
.th {
	font-size:12px;
	}
	
.th-heading {
	font-size:13px;
	font-weight:bold;
	}

.branch-table {
	width:100%;
	border:1px solid #666;
	border-collapse:collapse;
	line-height:22px;
	text-align:center;
	vertical-align:middle;
	font-weight:bold;
	}
	
.branch-table td , th {
	border:1px solid #666;
	}
.simple-table {
	border:2px solid #666;
	 
	}
.textfield {
	font-size:12px;
	font-weight:bold;	
	border:0px solid #666;
	margin:0px;
	padding:10px;
	line-height:22px;
	}
.textfield02 {
	border:1px solid #666;
	font-weight:bold;	
	margin:0px;
	padding:5px;
	line-height:22px;
	}
.textfield03 {
	border-left:0px;
	font-weight:bold;	
	border-right:0px;
	border-top:0px;
	border-bottom:1px solid #666;
	width:300px;
	margin-left:5px;
	}
.textfield04 {
	border-left:0px;
	font-weight:bold;	
	border-right:0px;
	border-top:0px;
	border-bottom:1px solid #666;
	width:500px;
	line-height:22px;
	padding:5px;
	}
.textfield05 {
	border-left:0px;
	font-weight:bold;	
	border-right:0px;
	border-top:0px;
	border-bottom:1px solid #666;
	width:600px;
	height:23px;
	margin-left:5px;
	}
	hr.vertical
{
   width: 0px;
   border-bottom:1px solid #666;
   height: 10%; /* or height in PX */
} 
.hr {
	line-height:2px;
	}
	table.simple-table td.sem {
		line-height:0px;
  text-align: right;
}
</body>
</style>
</head>
<?php
if(!isset($_SESSION)){
	session_start();		
}			
include 'db/db_connect.php';
$sql11 = "SELECT Sem  FROM tblexammaster where ExamID = " . $_SESSION["SESSSelectedExam"] . ";";
$result11 = $mysqli->query( $sql11 );
while( $row11 = $result11->fetch_assoc() ) {
	extract($row11);
}
						
if(($_GET['deptid'] <> "") && ($_GET["enggyear"] <> "") && ($_GET["div"] <> "")){
	include 'db/db_connect.php';
		// $edit_record =isset( $_GET['edit']) ? $_GET ['edit'] : $_GET ['edit_form'];
		// $query="SELECT * FROM tblstudent WHERE StdId='$edit_record'";
		if($_GET['deptid'] == "1"){
			if($_GET['div'] <> 'ALL'){
				$query1="SELECT sa.StdAdmID,COALESCE(photopath,'') AS photopath,CNUM,ESNum,CONCAT(s.Surname, ' ', s.FirstName, ' ', s.FatherName) AS NAME, 
							COALESCE(MotherName,'') AS MotherName
							FROM tblstdadm sa 
							INNER JOIN tblstudent s ON s.StdID = sa.StdID 
							inner join tblexamfee ef on ef.stdadmid = sa.stdadmid and ef.examid = " . $_SESSION["SESSSelectedExam"] . "
							INNER JOIN tblexammaster em ON em.AcadYearFrom = sa.EduYearFrom 
							WHERE em.ExamId = ef.ExamID and coalesce(stdstatus,'R') = 'R' and sa.Div = '" . $_GET['div'] . "' AND sa.Year = '" . $_GET['enggyear'] . "' 
							Order by sa.ESNum";
							//and coalesce(sa.feespaid,0) = 1 
			}
			else{
				$query1="SELECT sa.StdAdmID,COALESCE(photopath,'') AS photopath,CNUM,ESNum,CONCAT(s.Surname, ' ', s.FirstName, ' ', s.FatherName) AS NAME, 
							COALESCE(MotherName,'') AS MotherName
							FROM tblstdadm sa 
							INNER JOIN tblstudent s ON s.StdID = sa.StdID 
							inner join tblexamfee ef on ef.stdadmid = sa.stdadmid and ef.examid = " . $_SESSION["SESSSelectedExam"] . "
							INNER JOIN tblexammaster em ON em.AcadYearFrom = sa.EduYearFrom 
							WHERE em.ExamId = ef.ExamID and coalesce(stdstatus,'R') = 'R' AND sa.Year = '" . $_GET['enggyear'] . "' 
							Order by sa.ESNum";
							//and coalesce(sa.feespaid,0) = 1 
			}
		}
		else{
			if($_GET['div'] <> 'ALL'){
				$query1="SELECT sa.StdAdmID,COALESCE(photopath,'') AS photopath,CNUM,ESNum,CONCAT(s.Surname, ' ', s.FirstName, ' ', s.FatherName) AS NAME, 
							COALESCE(MotherName,'') AS MotherName
							FROM tblstdadm sa 
							INNER JOIN tblstudent s ON s.StdID = sa.StdID 
							inner join tblexamfee ef on ef.stdadmid = sa.stdadmid and ef.examid = " . $_SESSION["SESSSelectedExam"] . "
							INNER JOIN tblexammaster em ON em.AcadYearFrom = sa.EduYearFrom 
							WHERE em.ExamId = ef.ExamID and coalesce(stdstatus,'R') = 'R' and sa.Dept = " . $_GET['deptid'] . " AND sa.Div = '" . $_GET['div'] . "' AND sa.Year = '" . $_GET['enggyear'] . "' 
							Order by sa.ESNum";
							//and coalesce(sa.feespaid,0) = 1  
			}
			else{
				$query1="SELECT sa.StdAdmID,COALESCE(photopath,'') AS photopath,CNUM,ESNum,CONCAT(s.Surname, ' ', s.FirstName, ' ', s.FatherName) AS NAME, 
							COALESCE(MotherName,'') AS MotherName
							FROM tblstdadm sa 
							INNER JOIN tblstudent s ON s.StdID = sa.StdID 
							inner join tblexamfee ef on ef.stdadmid = sa.stdadmid and ef.examid = " . $_SESSION["SESSSelectedExam"] . "
							INNER JOIN tblexammaster em ON em.AcadYearFrom = sa.EduYearFrom 
							WHERE em.ExamId = ef.ExamID and coalesce(stdstatus,'R') = 'R' and sa.Dept = " . $_GET['deptid'] . " AND sa.Year = '" . $_GET['enggyear'] . "' 
							Order by sa.ESNum";
							//and coalesce(sa.feespaid,0) = 1  
			}
		}
		//echo $query1;
		$run=mysqli_query($mysqli,$query1);
		$findstr = strpos($_SESSION["SESSSelectedExamName"]," - ");
		$examname = substr($_SESSION["SESSSelectedExamName"],0 , $findstr);
		$num_results = $run->num_rows;
		$cnumcur = '';
		$i = 0;
		while($row=mysqli_fetch_array($run)){
				$ESNum=$row['ESNum'];
				$cnum=$row['CNUM'];
				$name=$row['NAME'];
				$mname=$row['MotherName'];
				$photopath=$row['photopath'];
				$StdAdmID=$row['StdAdmID'];

			echo "<table class='branch-table' style='width:100%;'>";
					echo"<tr>";
						echo "<td><center><img src='images/logo.png' alt='logo' width='577' height='91' /></center></td>";
					echo"</td></tr>";
					echo"<tr>";
						echo"<td>
							<span class='th-heading'>
							<div>
								<div style='float:left'>
									Academic Year : 2016-17
								</div>
								<div style='float:left;margin-left:19%;'>
									Exam Hall Ticket
								</div>
								<div style='float:right'>
									Semester : 1
								</div>						
							</div>
							</span>";
							echo "<br/>";
							echo "<span class='th-heading'>
							<center>
								" . $examname . "
							</center>
							</span>";
						echo"</td>";
					echo"</tr>";
				echo"</table>";
				echo"<table class='branch-table' align='center' style='width:100%;'>";
						echo"<tr>";
							echo"<td style='width:45%;'>ESN : $ESNum</td>";
							echo"<td style='width:45%;'>CNUM : $cnum</td>";
							echo"<td rowspan='4' style='width:10%;'>";
								echo"<img src='";
									if($photopath == '')
										echo "photos/photo.png" . "' alt='photo' width='120' height='125' align='center'  />";
									else
										echo " photos/". $photopath."' alt='photo' width='120' height='125'  />";
							echo"</td>";
						echo"</tr>";
						echo" <tr>";
							echo"<td colspan='2'>Name : $name</td>";
						echo"</tr>";
						echo" <tr>";
							echo"<td colspan='2'>Mother Name : $mname</td>";
						echo" </tr>";
					echo"</table>";
		include 'db/db_connect.php';
		if($_GET['deptid'] == "1"){
			if(stripos($_SESSION["SESSSelectedExamName"], 'Regular') > 0 ){
				$query="SELECT PaperCode AS subjectcode,sm.SubjectName, ys.papertype,
				CASE ys.papertype WHEN 'TH' THEN 'PP' else ys.papertype End as papertype
				FROM `tblsubjectmaster` sm
				INNER JOIN `tblpapermaster` pm ON sm.SubjectID = pm.SubjectID
				INNER JOIN `tblyearstruct` ys ON ys.PaperID = pm.PaperID
				INNER JOIN `tblyearstructstd` yss ON ys.rowid = yss.ysid
				inner join tblexammaster em on em.ExamID = " . $_SESSION["SESSSelectedExam"] . " 
				and ys.eduyearfrom = em.AcadYearFrom  and em.Sem = SUBSTRING(EnggYear,LENGTH(EnggYear),1)
				INNER JOIN tblstdadm sa ON sa.StdAdmID = yss.stdadmid AND ys.EduYearFrom = sa.EduYearFrom
				INNER JOIN tblstudent s ON s.StdID = sa.StdID
				WHERE PaperCode not in ('ES 1102','BS 1104') and ys.papertype <> 'TT'  and coalesce(feespaid,0) = 1
				and sa.StdAdmID =  ". $StdAdmID ." order by CASE ys.papertype WHEN 'TH' THEN 'PP' else ys.papertype End,PaperCode ";
			}
			else{
				$query="SELECT PaperCode AS subjectcode,sm.SubjectName, ys.papertype,
				CASE ys.papertype WHEN 'TH' THEN 'PP' else ys.papertype End as papertype
				FROM `tblsubjectmaster` sm
				INNER JOIN `tblpapermaster` pm ON sm.SubjectID = pm.SubjectID
				INNER JOIN `tblyearstruct` ys ON ys.PaperID = pm.PaperID
				INNER JOIN `tblyearstructstdretest` yss ON ys.rowid = yss.ysid and yss.ExamID = " . $_SESSION["SESSSelectedExam"] . "
				inner join tblexammaster em on em.ExamID = " . $_SESSION["SESSSelectedExam"] . " 
				and ys.eduyearfrom = em.AcadYearFrom  and em.Sem = SUBSTRING(EnggYear,LENGTH(EnggYear),1)
				INNER JOIN tblstdadm sa ON sa.StdAdmID = yss.stdadmid AND ys.EduYearFrom = sa.EduYearFrom
				INNER JOIN tblstudent s ON s.StdID = sa.StdID
				WHERE PaperCode not in ('ES 1102','BS 1104') and ys.papertype <> 'TT'  and coalesce(feespaid,0) = 1
				and sa.StdAdmID =  ". $StdAdmID ." order by CASE ys.papertype WHEN 'TH' THEN 'PP' else ys.papertype End,PaperCode ";
			}
		}
		else{
			if(stripos($_SESSION["SESSSelectedExamName"], 'Regular') > 0 ){
				$query="SELECT PaperCode AS subjectcode,SubjectName, ys.papertype,
				CASE ys.papertype WHEN 'TH' THEN 'PP' else ys.papertype End as papertype
				FROM `tblsubjectmaster` sm
				INNER JOIN `tblpapermaster` pm ON sm.SubjectID = pm.SubjectID
				INNER JOIN `tblyearstruct` ys ON ys.PaperID = pm.PaperID
				INNER JOIN `tblyearstructstd` yss ON ys.rowid = yss.ysid
				inner join tblexammaster em on em.ExamID = " . $_SESSION["SESSSelectedExam"] . " 
				and ys.eduyearfrom = em.AcadYearFrom  and em.Sem = SUBSTRING(EnggYear,LENGTH(EnggYear),1)
				INNER JOIN tblstdadm sa ON sa.StdAdmID = yss.stdadmid AND ys.EduYearFrom = sa.EduYearFrom
				INNER JOIN tblstudent s ON s.StdID = sa.StdID
				WHERE PaperCode not in ('PEECSP1101B','PEECSP1101C') and ys.papertype <> 'TT'  and coalesce(feespaid,0) = 1
				and sa.StdAdmID =  ". $StdAdmID ." order by CASE ys.papertype WHEN 'TH' THEN 'PP' else ys.papertype End,PaperCode ";
			}
			else{
				$query="SELECT PaperCode AS subjectcode,SubjectName, ys.papertype,
				CASE ys.papertype WHEN 'TH' THEN 'PP' else ys.papertype End as papertype
				FROM `tblsubjectmaster` sm
				INNER JOIN `tblpapermaster` pm ON sm.SubjectID = pm.SubjectID
				INNER JOIN `tblyearstruct` ys ON ys.PaperID = pm.PaperID
				INNER JOIN `tblyearstructstdretest` yss ON ys.rowid = yss.ysid and yss.ExamID = " . $_SESSION["SESSSelectedExam"] . "
				inner join tblexammaster em on em.ExamID = " . $_SESSION["SESSSelectedExam"] . " 
				and ys.eduyearfrom = em.AcadYearFrom  and em.Sem = SUBSTRING(EnggYear,LENGTH(EnggYear),1) 
				INNER JOIN tblstdadm sa ON sa.StdAdmID = yss.stdadmid AND ys.EduYearFrom = sa.EduYearFrom
				INNER JOIN tblstudent s ON s.StdID = sa.StdID
				WHERE PaperCode not in ('PEECSP1101B','PEECSP1101C') and ys.papertype <> 'TT'  and coalesce(feespaid,0) = 1
				and sa.StdAdmID =  ". $StdAdmID ." order by CASE ys.papertype WHEN 'TH' THEN 'PP' else ys.papertype End,PaperCode ";
			}
		}
		//echo $query;
		$run2=mysqli_query($mysqli,$query);
		$num_results2 = $run2->num_rows;
		echo"<table class='branch-table' style='width:100%;'>";
			echo" <tr>";
			   echo" <td style='width:15%;'><center>Subject Code</center>";
			   echo"</td>";
			   echo"<td style='width:55%;'><center>Subject Name</center>";
			   echo"</td>";
			   echo"<td style='width:15%;'><center>Type</center>";
			   echo"</td>";
			   echo"<td style='width:15%;'><center>Signature</center></td>";
			echo"</tr>";
				while($row2=mysqli_fetch_array($run2)){
						$subname=$row2['SubjectName'];
						$ptype=$row2['papertype'];
						$pcode=$row2['subjectcode'];
						echo"<tr>";
							echo"<td style='width:60px;'>$pcode</td>";
							echo"<td style='width:60px;'>$subname</td>";
							echo"<td style='width:60px;'><center>$ptype</center></td>";
							echo"<td style='width:60px;'><center></center></td>";
						echo"</tr>";
				}
					echo "</table>";
					echo"<table  class='simple-table'  style='width:100%;border-collapse: separate;'>";
						echo"<tr>";
							echo"<td colspan='3'><h3 style='margin-top:-5px'><b>NOTE: </br> 1. Please ensure that the details like Name, Photo, CNUM, Subjects are correctly printed on the Hall Ticket. Any discrepancies should be reported immediately to the Dean Examination.</br>
							2. Students should carry college I-Card along with the Hall Ticket for the examination.</b>
							</br></br></br></br>
							<div>
								<div style='float:left;margin-left:2%'>
									<span class='th-heading'>Student Signature</span>
								</div>
								<div style='float:right;margin-right:2%'>
									<span class='th-heading'>Dean Examination</span>
								</div>
							</div></h3>";
									
							echo"</td> ";
						echo"</tr>";
					echo"</table>";
					echo"<p  style='page-break-after:always;'></p>";	
		}

}
?>
