<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Transfer Certificate</title>
<style type="text/css">
body {
	font-family:Verdana, Geneva, sans-serif;
	font-size: 12px;
	text-align:left;
	margin-left:5px;
	margin-top: 0px;
}
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
.hr {
	line-height:2px;
	}
</style>
</head>

<body>
<?php
	if(!isset($_SESSION)){
		session_start();
	}
	include 'db/db_connect.php';
	$query = "SELECT StdId,upper(coalesce(namefortransfer,concat(Surname,' ', FirstName,' ', FatherName))) as  stdname,upper(MotherName) as MotherName,upper(coalesce(pob,concat(Taluka,' ',District,' ',State))) as pob,Blood_group,
		Mother_tongue,upper(Nationality) as Nationality,Religion,Status,Mobno,Email_id,Lastattended,parent_name,parent_address,
		parent_taluka,parent_district,parent_state,pincode,parent_telephone,parent_mobile,
		father_income,mother_income,org_name,org_address,org_telephone,org_mobile,lg_name,lg_address,lg_telephone,lg_mobile,hostel_name,
		hostel_address,hostel_telephone,details,upper(DOB) as DOB,upper(convertdatetowords(STR_TO_DATE(DOB,'%d-%b-%Y'))) as DOBWORDS,SUBSTRING(Pmail,1,LOCATE('@',Pmail)-1) as Pmail,Rel,CNUM,msname,stdpass,uniprn,unieli,dteid,uniprn,aicteno,seatno,dept,coalesce(CFLAG,0) as CFLAG,
		doa,upper(coalesce(pandc,'GOOD')) as pandc,dol,upper(coalesce(reasonofleaving,'PASSED FINAL YEAR EXAM')) as reasonofleaving,upper(coalesce(leavingremarks,'COMPLETED THE COURSE SUCCESSFULLY')) as leavingremarks,upper(registerno) as registerno,upper(castesubcaste) as castesubcaste,upper(aadharno) as aadharno
		FROM tblstudent WHERE StdId = " . $_SESSION["SESSStdId"] ;					 
	//echo $query;
	$result = $mysqli->query( $query );
	$num_results = $result->num_rows;					
	if( $num_results ){
			$row = $result->fetch_assoc();
			extract($row);
	}
	
		$sql2 = "SELECT upper(name) as instname
				FROM stdqual WHERE StdId= " . $_SESSION["SESSStdId"]. " and Exam = '12th'" ;
		// execute the sql query
		$result2 = $mysqli->query( $sql2 );
		$num_results2 = $result2->num_rows;
		if( $num_results2 ){
			while( $row2 = $result2->fetch_assoc() ){
				extract($row2);
			}
		}
	
		//-------------------	for dept and year ---------------------------------------------------------
		$sql3 = 'SELECT EduYearFrom, EduYearTo FROM tblcuryear WHERE EduYearTo = (SELECT MAX(EduYearTo) FROM tblcuryear)';
		//echo $sql;
		$result3 = $mysqli->query( $sql3 );
		$num_results3 = $result3->num_rows;
		if( $num_results3 ){
			while( $row3 = $result3->fetch_assoc() ){
				extract($row3);
			}
		}
		$query4="SELECT upper(DeptUnivName) as DeptName,upper(Year) as Year FROM tblstdadm sa, tbldepartmentmaster DM 
					WHERE sa.Dept = DM.DeptID and
					EduYearFrom = '$EduYearFrom' 
					and EduYearTo = '$EduYearTo' and StdID=" . $_SESSION["SESSStdId"];
		$result4=mysqli_query($mysqli,$query4);
		while($row4=mysqli_fetch_array($result4))
		{
			extract($row4);
		}

	
?>
<table class="simple-table">
      <tr>
        <td colspan="3" class="center-text"><img src="images/logo.png" alt="logo" width="577" height="91" /></td>
      </tr>
	  <tr>
        <td colspan="3" width="15%" class="txt2"><center>Approved by AICTE & affiliated to University of Pune, No. PU/PN/ENGG/087/1991,INDIA</center></label></td>
      </tr>
      <tr>
	    <td colspan="3"><span class="th-heading"><center><h2>TRANSFER CERTIFICATE</h2></center></span><hr/>
		No change in any entry in this certificate shall be made except by the authority issuinbg it and any of the requirement is liable to involve imposition of penalty.
		<table class="branch-table" style="border:none;margin-bottom:20px;margin-top:20px;">
			  <tr>
				<td style="float:left">Register Number :
				<?php echo $registerno; ?></td>
				<td style="float:right">C-Number :
				<?php echo $CNUM; ?></td>
			  </tr>
		</table>
		</td>
      </tr>
      <tr>
      <tr>
        <td colspan="3" bgcolor="#FFFFFF">
			<table class="branch-table">
			<?php
						  echo "<TR class='odd gradeX'>";
						  echo "<td style='width:40%'>Name of the Student in full</td>";
						  echo "<td> $stdname</td>";
						  echo "</TR>";
						  echo "<TR class='odd gradeX'>";
						  echo "<td>Mother's Name</td>";
						  echo "<td> $MotherName</td>";
						  echo "</TR>";
						  echo "<TR class='odd gradeX'>";
						  echo "<td>Caste and subcaste</td>";
						  echo "<td> $castesubcaste</td>";
						  echo "</TR>";
						  echo "<TR class='odd gradeX'>";
						  echo "<td>Nationality</td>";
						  echo "<td> $Nationality</td>";
						  echo "</TR>";
						  echo "<TR class='odd gradeX'>";
						  echo "<td>Place of birth</td>";
						  echo "<td> $pob</td>";
						  echo "</TR>";
						  echo "<TR class='odd gradeX'>";
						  echo "<td>Date of birth <br/> (according to the Christian era) in words:</td>";
						  echo "<td> $DOB <br/> ($DOBWORDS)</td>";
						  echo "</TR>";
						  echo "<TR class='odd gradeX'>";
						  echo "<td>Last school attended</td>";
						  echo "<td> $instname</td>";
						  echo "</TR>";
						  echo "<TR class='odd gradeX'>";
						  echo "<td>Date of Admission (DD-MON-YYYY)</td>";
						  echo "<td> $doa</td>";
						  echo "<TR class='odd gradeX'>";
						  echo "<td>University PRN Number</td>";
						  echo "<td> $uniprn</td>";
						  echo "</TR>";
						  echo "<TR class='odd gradeX'>";
						  echo "<td>Progress and Conduct</td>";
						  echo "<td> $pandc</td>";
						  echo "<TR class='odd gradeX'>";
						  echo "<td>Date of leaving the college</td>";
						  echo "<td> $dol</td>";
						  echo "</TR>";
						  echo "<TR class='odd gradeX'>";
						  echo "<td>Class from which left</td>";
						  echo "<td> $Year $DeptName</td>";
						  echo "</TR>";
						  echo "<TR class='odd gradeX'>";
						  echo "<td>Reason of leaving the college</td>";
						  echo "<td> $reasonofleaving</td>";
						  echo "<TR class='odd gradeX'>";
						  echo "<td>Remarks if any</td>";
						  echo "<td> $leavingremarks</td>";
						  echo "</TR>";
			?>
			</table>
		</td>
	</tr>
</table>
Certified that the above information is in accordance with the college register.
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<div>
<div style="float:left">Checked by</div><div style="margin-left:30%">Seal</div>
<div style="float:right"><center>Principal / Registrar <br/>MKSSS's Cummins College of Engineering for Women<br/>Karve Nagar, Pune 411052</center></div>
</div>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
Place - Pune
</body>