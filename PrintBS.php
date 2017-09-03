<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Bonifide Certificate</title>
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
	width:120%;
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
	$query = "SELECT StdId,coalesce(namefortransfer,concat(Surname,' ', FirstName,' ', FatherName)) as  stdname,upper(MotherName) as MotherName,upper(coalesce(pob,concat(Taluka,' ',District,' ',State))) as pob,Blood_group,
		Mother_tongue,upper(Nationality) as Nationality,Religion,Status,Mobno,Email_id,Lastattended,parent_name,parent_address,
		parent_taluka,parent_district,parent_state,pincode,parent_telephone,parent_mobile,
		father_income,mother_income,org_name,org_address,org_telephone,org_mobile,lg_name,lg_address,lg_telephone,lg_mobile,hostel_name,
		hostel_address,hostel_telephone,details,upper(DOB) as DOB,upper(convertdatetowords(STR_TO_DATE(DOB,'%d-%b-%Y'))) as DOBWORDS,SUBSTRING(Pmail,1,LOCATE('@',Pmail)-1) as Pmail,Rel,CNUM,msname,stdpass,uniprn,unieli,dteid,uniprn,aicteno,seatno,dept,coalesce(CFLAG,0) as CFLAG,
		doa,upper(coalesce(pandc,'GOOD')) as pandc,dol,upper(coalesce(reasonofleaving,'PASSED FINAL YEAR EXAM')) as reasonofleaving,upper(coalesce(leavingremarks,'COMPLETED THE COURSE SUCCESSFULLY')) as leavingremarks,upper(registerno) as registerno,upper(castesubcaste) as castesubcaste,upper(aadharno) as aadharno, coalesce(bonapurpose,'') as bonapurpose
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
		$query4="SELECT DeptUnivName as DeptName,upper(Year) as Year FROM tblstdadm sa, tbldepartmentmaster DM 
					WHERE sa.Dept = DM.DeptID and
					EduYearFrom = '$EduYearFrom' 
					and EduYearTo = '$EduYearTo' and StdID=" . $_SESSION["SESSStdId"];
		$result4=mysqli_query($mysqli,$query4);
		while($row4=mysqli_fetch_array($result4))
		{
			extract($row4);
		}

	
?>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<table class="simple-table">

      <tr>
	  <td>			
			<div><br/><br/>
			<div style="float:left;margin-left:100px;font-size:large">Ref. No. _____________</div>
			<div style="float:right;margin-right:120px;font-size:large">Date: <?php echo date("d/m/Y"); ?></div>
			</div>
	  </td>
	  </tr>
	  <tr>
	    <td colspan="3"><span class="th-heading"><br/><br/><br/><center><h1>Bonafide Certificate</h1></center></span>
		</td>
      </tr>
      <tr>
      <tr>
        <td colspan="3" bgcolor="#FFFFFF" style="font-size:large">
		<table style="margin-left:100px;border:none;margin-right:100px;text-align:left">
		<tr>
		<td>
			<?php echo "<p style='line-height:25px;text-align:justify;'>This is to certify that Miss " . $stdname . " is a bonafide student of this College Studying in " . $Year . " Year Engineering of the four Year Degree Course in " . $DeptName . " during the academic year " . $EduYearFrom . "-" . $EduYearTo . ". <br/><br/> Her conduct and progress are satisfactory and to the best of my knowledge she bears a good moral character.
			</p><br/>
			Purpose: " . $bonapurpose;
			?>
		</td>
		</tr>
		</table>
		</td>
      </tr>
</table>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<center style="font-size:large">Director / Registrar</center>
</body>

<!--
      <tr>
        <td colspan="3" class="center-text"><img src="images/logo.png" alt="logo" width="577" height="91" /></td>
      </tr>
	  <tr>
        <td colspan="3" width="15%" class="txt2"><center>Approved by AICTE & affiliated to University of Pune, No. PU/PN/ENGG/087/1991,INDIA</center></label></td>
      </tr>
	  <tr>
		<td colspan="3"><hr/></td>
	  </tr>
-->