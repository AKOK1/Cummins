<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Retest Subjects</title>
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
			$query1="SELECT sa.StdAdmID,COALESCE(photopath,'') AS photopath,CNUM,ESNum,CONCAT(s.Surname, ' ', s.FirstName, ' ', s.FatherName) AS NAME, 
						COALESCE(MotherName,'') AS MotherName
						FROM tblstdadm sa 
						INNER JOIN tblstudent s ON s.StdID = sa.StdID 
						INNER JOIN tblcuryearauto cy ON cy.EduYearFrom = sa.EduYearFrom 
						WHERE coalesce(stdstatus,'R') = 'R' and sa.StdID = " . $_SESSION["SESSStdId"];
		//echo $query1;
		$run=mysqli_query($mysqli,$query1);
		//$findstr = strpos($_SESSION["SESSSelectedExamName"]," - ");
		//$examname = substr($_SESSION["SESSSelectedExamName"],0 , $findstr);
		$examname = "F.Y.B.Tech./M.Tech. (ESE) [Retest]";
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
									Retest Subjects
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
						echo"</tr>";
						echo" <tr>";
							echo"<td colspan='2'>Name : $name</td>";
						echo"</tr>";
						echo" <tr>";
							echo"<td colspan='2'>Mother Name : $mname</td>";
						echo" </tr>";
					echo"</table>";
		include 'db/db_connect.php';
			$query="SELECT PaperCode AS subjectcode,sm.SubjectName, ys.papertype
					FROM tblyearstructstdretest yss
					INNER JOIN tblyearstruct ys ON ys.rowid = yss.YSID
					INNER JOIN tblpapermaster pm ON pm.PaperID = ys.PaperID 
					AND ys.papertype <> 'TT'
					INNER JOIN tblsubjectmaster sm ON sm.SubjectID = pm.SubjectID
					INNER JOIN tblcuryearauto cy ON cy.EduYearFrom = ys.eduyearfrom AND cy.Sem = SUBSTRING(EnggYear,LENGTH(EnggYear),1)
					WHERE yss.sem = cy.Sem and yss.StdAdmID = ". $StdAdmID ." order by sm.SubjectName ";
		
		//echo $query;
		$run2=mysqli_query($mysqli,$query);
		$num_results2 = $run2->num_rows;
		echo"<table class='branch-table' style='width:100%;'>";
			echo" <tr>";
			   echo" <td style='width:5%;'><center>Sr. No.</center>";
			   echo"</td>";
			   echo" <td style='width:15%;'><center>Subject Code</center>";
			   echo"</td>";
			   echo"<td style='width:50%;'><center>Subject Name</center>";
			   echo"</td>";
			   echo"<td style='width:15%;'><center>Type</center>";
			   echo"</td>";
			   echo"<td style='width:15%;'><center>Fees</center></td>";
			echo"</tr>";
				$i = 0;
				while($row2=mysqli_fetch_array($run2)){
						$i = $i + 1;
						$subname=$row2['SubjectName'];
						$ptype=$row2['papertype'];
						$pcode=$row2['subjectcode'];
						echo"<tr>";
							echo"<td style='width:60px;'>$i</td>";
							echo"<td style='width:60px;'>$pcode</td>";
							echo"<td style='width:60px;'>$subname</td>";
							echo"<td style='width:60px;'><center>$ptype</center></td>";
							echo"<td style='width:60px;'><center></center></td>";
						echo"</tr>";
				}
						echo"<tr>";
							echo"<td style='width:60px;'></td>";
							echo"<td style='width:60px;'></td>";
							echo"<td style='width:60px;'></td>";
							echo"<td style='width:60px;'><center>Total</center></td>";
							echo"<td style='width:60px;'><center></center></td>";
						echo"</tr>";
					echo "</table>";
					echo"<table  class='simple-table'  style='width:100%;border-collapse: separate;'>";
						echo"<tr>";
							echo"<td colspan='3'><h3 style='margin-top:-5px'><br/><b>Kindly print and submit this form to Exam Section. <br/>Pay Rs. 250 for theory and Rs. 150 for Practical / Oral.</b>
							</br></br></br></br>
							<div>
								<div style='float:left;margin-left:2%'>
									<span class='th-heading'>Student Signature</span>
								</div>
								<div style='float:right;margin-right:2%'>
									<span class='th-heading'>Received</span>
								</div>
							</div></h3>";
									
							echo"</td> ";
						echo"</tr>";
					echo"</table>";
					echo"<p  style='page-break-after:always;'></p>";	
		}

?>
