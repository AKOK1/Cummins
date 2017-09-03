<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Student Basic Details</title>
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
	<br/>
	<center><img class="center" alt="logo" src="images/logo.png"></center>
	<br/>
	<table width="100%" border="0" cellpadding="5" cellspacing="0" class="fix-table" style="margin-left: 0.5%;">
	<TR><td colspan='21' class='th-heading'><center><h2>Personal Details</center></td></TR>

	<TR>
		<td colspan='21' class='th-heading'>
		Department: <?php echo $_GET['dept'];?>,&nbsp;
		Education Year: <?php echo $_GET['eduyear'];?>&nbsp;
		
		
	</TR>
	<TR>
	</TR>
	<tr class="th">
		<td width="15%">Year</td>
		<td width="05%">Department</td>
		<td width="15%">CNUM</td>
		<td width="15%">Student Name</td>
		<td width="15%">Roll Number</td>
		<td width="15%">Division</td>
		<td width="15%">University PRN</td>
		<td width="10%">Mother's Name</td>
		<td width="05%">Blood Group</td>
		<td width="10%">Mother tongue</td>
		<td width="10%">Marital Status</td>
		<td width="20%">Date Of Birth</td>
		<td width="10%">User Mobile</td>
		<td width="10%">Personal Email Id</td>
		<td width="10%">College Email Id</td>
		<td width="15%">Taluka</td>
		<td width="15%">District</td>
		<td width="15%">State</td>
		<td width="15%">Blood_group</td>
		<td width="15%">Mother_tongue</td>
		<td width="15%">Nationality</td>
		<td width="15%">Religion</td>
		<td width="15%">Caste Subcaste</td>
		<td width="15%">Status</td>
		<td width="15%">Mobile</td>
		<td width="15%">Parent Name</td>
		<td width="15%">Parent Relation</td>
		<td width="15%">Parent Address</td>
		<td width="15%">Parent Taluka</td>
		<td width="15%">Parent District</td>
		<td width="15%">Parent State</td>
		<td width="15%">Pincode</td>
		<td width="15%">Parent Telephone</td>
		<td width="15%">Parent Mobile</td>
		<td width="15%">Local Guardian Name</td>
		<td width="15%">Local Guardian Address</td>
		<td width="15%">Local Guardian Telephone</td>
		<td width="15%">Local Guardian Mobile</td>
		<td width="15%">Hostel Name</td>
		<td width="15%">Hostel Address</td>
		<td width="15%">Hostel Telephone</td>
		<td width="15%">DOB</td>
		<td width="15%">FE Admission Year</td>
		<td width="15%">Uniprn</td>
		<td width="15%">Uni. Eli. No.</td>
		<td width="15%">Dteid</td>
		<td width="15%">Aadhar No.</td>
		<td width="15%">Appid</td>
		<td width="15%">Created Date</td>
		<td width="15%">Admission Category</td>
	</tr>
	
	<?php
	if(!isset($_SESSION)){
		session_start();
	} 
		include 'db/db_connect.php';
		
				$query = "SELECT sa.Year as year,DM.DeptName as dept,CNUM,Concat(FirstName,' ',FatherName, ' ' ,Surname) as userName,
							sa.RollNo as Rollnum,sa.Div as division,uniprn,
							MotherName,Blood_group,Mother_tongue,
							Status,DOB,Mobno as userMobile,Email_id,Pmail ,
							Taluka, District, State, Blood_group, Mother_tongue, Nationality, Religion, Caste_subcaste, Status, Mobno, 
							parent_name, Rel, parent_address, parent_taluka, parent_district, parent_state, pincode, parent_telephone, parent_mobile, lg_name, 
							lg_address, lg_telephone, lg_mobile, hostel_name, hostel_address, hostel_telephone, DOB, feadmyear, uniprn, unieli, dteid, aadharno, 
							appid, createddate, s.admcat
							FROM tblstudent s
							 inner join tblstdadm sa on sa.StdID = s.StdId
							 INNER JOIN tblcuryear cy ON cy.eduyearfrom = sa.EduYearFrom AND cy.eduyearto = sa.EduYearTo
							 INNER JOIN tbldepartmentmaster DM ON DM.DeptName = s.Dept
							where sa.Year = '" . $_GET['eduyear']. "' 
							and DM.DeptName = '" . $_GET['dept'] . "'
							order by CNUM";
							
			if($_GET['dept'] == 'All') {
				$query = "SELECT sa.Year as year,
							DM.DeptName as dept,CNUM,Concat(FirstName,' ',FatherName, ' ' ,Surname) as userName,
							sa.RollNo as Rollnum,sa.Div as division,uniprn,MotherName,Blood_group,Mother_tongue,Status,DOB,
							Mobno as userMobile,Email_id,Pmail  ,
							Taluka, District, State, Blood_group, Mother_tongue, Nationality, Religion, Caste_subcaste, Status, Mobno, 
							parent_name, Rel, parent_address, parent_taluka, parent_district, parent_state, pincode, parent_telephone, parent_mobile, lg_name, 
							lg_address, lg_telephone, lg_mobile, hostel_name, hostel_address, hostel_telephone, DOB, feadmyear, uniprn, unieli, dteid, aadharno, 
							appid, createddate, s.admcat							
							FROM tblstudent s
							 inner join tblstdadm sa on sa.StdID = s.StdId
							 INNER JOIN tbldepartmentmaster DM ON DM.DeptName = s.Dept
							  INNER JOIN tblcuryear cy ON cy.EduYearFrom = sa.EduYearFrom AND cy.EduYearTo = sa.EduYearTo
							  where sa.Year = '" . $_GET['eduyear']. "'
							  order by CNUM";
							
			}
			if($_GET['eduyear'] == 'All' ) {
				$query = "SELECT sa.Year as year,
							DM.DeptName as dept,CNUM,Concat(FirstName,' ',FatherName, ' ' ,Surname) as userName,
							sa.RollNo as Rollnum,sa.Div as division,uniprn,MotherName,Blood_group,Mother_tongue,Status,DOB,
							Mobno as userMobile,Email_id,Pmail  ,
							Taluka, District, State, Blood_group, Mother_tongue, Nationality, Religion, Caste_subcaste, Status, Mobno, 
							parent_name, Rel, parent_address, parent_taluka, parent_district, parent_state, pincode, parent_telephone, parent_mobile, lg_name, 
							lg_address, lg_telephone, lg_mobile, hostel_name, hostel_address, hostel_telephone, DOB, feadmyear, uniprn, unieli, dteid, aadharno, 
							appid, createddate, s.admcat
							FROM tblstudent s
							 inner join tblstdadm sa on sa.StdID = s.StdId
							 INNER JOIN tbldepartmentmaster DM ON DM.DeptName = s.Dept
							  INNER JOIN tblcuryear cy ON cy.EduYearFrom = sa.EduYearFrom AND cy.EduYearTo = sa.EduYearTo
							  where DM.DeptName = '" . $_GET['dept'] . "'
							  order by CNUM";
							
			}
			if($_GET['dept'] == 'All' && $_GET['eduyear'] == 'All' ) {
				$query = "SELECT sa.Year as year,
							DM.DeptName as dept,CNUM,Concat(FirstName,' ',FatherName, ' ' ,Surname) as userName,
							sa.RollNo as Rollnum,sa.Div as division,uniprn,MotherName,Blood_group,Mother_tongue,Status,DOB,
							Mobno as userMobile,Email_id,Pmail  ,
							Taluka, District, State, Blood_group, Mother_tongue, Nationality, Religion, Caste_subcaste, Status, Mobno, 
							parent_name, Rel, parent_address, parent_taluka, parent_district, parent_state, pincode, parent_telephone, parent_mobile, lg_name, 
							lg_address, lg_telephone, lg_mobile, hostel_name, hostel_address, hostel_telephone, DOB, feadmyear, uniprn, unieli, dteid, aadharno, 
							appid, createddate, s.admcat
							FROM tblstudent s
							 inner join tblstdadm sa on sa.StdID = s.StdId
							 INNER JOIN tbldepartmentmaster DM ON DM.DeptName = s.Dept
							  INNER JOIN tblcuryear cy ON cy.EduYearFrom = sa.EduYearFrom AND cy.EduYearTo = sa.EduYearTo
							  order by CNUM";
							
			}
					//echo $query;
			//twohrsduties is not null and otherhrsduties is not null
			// execute the sql query
			//echo $sql;
			$result = $mysqli->query( $query );
			echo $mysqli->error;
			$num_results = $result->num_rows;
			//echo $sql;
			if( $num_results ){
				while( $row = $result->fetch_assoc() ){
					extract($row);
					echo "<TR>";
					echo "<td>{$year} </td>";
					echo "<td>{$dept} </td>";
					echo "<td>{$CNUM} </td>";
					echo "<td>{$userName} </td>";
					echo "<td>{$Rollnum} </td>";
					echo "<td>{$division} </td>";
					echo "<td>{$uniprn} </td>";
					echo "<td>{$MotherName} </td>";
					echo "<td>{$Blood_group} </td>";
					echo "<td>{$Mother_tongue} </td>";
					echo "<td>{$Status} </td>";
					echo "<td>{$DOB} </td>";
					echo "<td>{$userMobile} </td>";
					echo "<td>{$Email_id} </td>";
					echo "<td>{$Pmail} </td>";
					echo "<td>{$Taluka} </td>";
					echo "<td>{$District} </td>";
					echo "<td>{$State} </td>";
					echo "<td>{$Blood_group} </td>";
					echo "<td>{$Mother_tongue} </td>";
					echo "<td>{$Nationality} </td>";
					echo "<td>{$Religion} </td>";
					echo "<td>{$Caste_subcaste} </td>";
					echo "<td>{$Status} </td>";
					echo "<td>{$Mobno} </td>";
					echo "<td>{$parent_name} </td>";
					echo "<td>{$Rel} </td>";
					echo "<td>{$parent_address} </td>";
					echo "<td>{$parent_taluka} </td>";
					echo "<td>{$parent_district} </td>";
					echo "<td>{$parent_state} </td>";
					echo "<td>{$pincode} </td>";
					echo "<td>{$parent_telephone} </td>";
					echo "<td>{$parent_mobile} </td>";
					echo "<td>{$lg_name} </td>";
					echo "<td>{$lg_address} </td>";
					echo "<td>{$lg_telephone} </td>";
					echo "<td>{$lg_mobile} </td>";
					echo "<td>{$hostel_name} </td>";
					echo "<td>{$hostel_address} </td>";
					echo "<td>{$hostel_telephone} </td>";
					echo "<td>{$DOB} </td>";
					echo "<td>{$feadmyear} </td>";
					echo "<td>{$uniprn} </td>";
					echo "<td>{$unieli} </td>";
					echo "<td>{$dteid} </td>";
					echo "<td>{$aadharno} </td>";
					echo "<td>{$appid} </td>";
					echo "<td>{$createddate} </td>";
					echo "<td>{$admcat} </td>";
					echo "</TR>";
				}
			}					

			//disconnect from database	
			$result->free();
			$mysqli->close();
	?>

</table>


</body>
</html>