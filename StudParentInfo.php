<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Parent Information Details</title>
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
<table width="160%" border="0" cellpadding="5" cellspacing="0" class="fix-table" style="margin-left: 0.5%;">
	<TR><td colspan='17' class='th-heading'><center><h2>Parent Information Details</center></td></TR>
	<TR>
		<td colspan='17' class='th-heading'>
		Department: <?php echo $_GET['dept'];?>,&nbsp;
		Education Year: <?php echo $_GET['eduyear'];?>&nbsp;
	</TR>
	<TR>
	</TR>
	
	<tr class="th">
		<td width="05%">Year</td>
		<td width="05%">Department</td>
		<td width="15%">CNUM</td>
		<td width="20%">Student Name</td>
		<td width="10%">Roll Number</td>
		<td width="05%">Division</td>
		<td width="15%">University PRN</td>
		<td width="15%">Parent Name</td>
		<td width="05%">Relation</td>
		<td width="15%">Address</td>
		<td width="15%">Telephone number</td>
		<td width="15%">Mobile Number</td>
		<td width="15%">Total Income Of Father</td>
		<td width="15%">Total Income Of Mother</td>
	</tr>
	<?php
	if(!isset($_SESSION)){
		session_start();
	} 
		include 'db/db_connect.php';
		
				$query = "SELECT sa.Year as year,DM.DeptName as dept,CNUM,Concat(FirstName,' ',FatherName, ' ' ,Surname) as userName,
							sa.RollNo as Rollnum,sa.Div as division,uniprn,parent_name,
							Rel,parent_address,parent_taluka,parent_district,parent_state,pincode,parent_telephone,
							parent_mobile,father_income,mother_income,org_name,org_address,org_telephone,org_mobile FROM tblstudent s
							 inner join tblstdadm sa on sa.StdID = s.StdId
							 INNER JOIN tbldepartmentmaster DM ON DM.DeptName = s.Dept
							  INNER JOIN tblcuryear cy ON cy.EduYearFrom = sa.EduYearFrom AND cy.EduYearTo = sa.EduYearTo
							where sa.Year = '" . $_GET['eduyear']. "' 
							and DM.DeptName = '" . $_GET['dept'] . "'
							order by CNUM";
				if($_GET['dept'] == 'All') {
					$query = "SELECT sa.Year as year,DM.DeptName as dept,CNUM,Concat(FirstName,' ',FatherName, ' ' ,Surname) as userName,
							sa.RollNo as Rollnum,sa.Div as division,uniprn,parent_name,
							Rel,parent_address,parent_taluka,parent_district,parent_state,pincode,parent_telephone,
							parent_mobile,father_income,mother_income,org_name,org_address,org_telephone,org_mobile FROM tblstudent s
							 inner join tblstdadm sa on sa.StdID = s.StdId
							 INNER JOIN tbldepartmentmaster DM ON DM.DeptName = s.Dept
							  INNER JOIN tblcuryear cy ON cy.EduYearFrom = sa.EduYearFrom AND cy.EduYearTo = sa.EduYearTo
							  where sa.Year = '" . $_GET['eduyear']. "'
							  order by CNUM";
				}
				if($_GET['eduyear'] == 'All' ) {
					$query = "SELECT sa.Year as year,DM.DeptName as dept,CNUM,Concat(FirstName,' ',FatherName, ' ' ,Surname) as userName,
							sa.RollNo as Rollnum,sa.Div as division,uniprn,parent_name,
							Rel,parent_address,parent_taluka,parent_district,parent_state,pincode,parent_telephone,
							parent_mobile,father_income,mother_income,org_name,org_address,org_telephone,org_mobile FROM tblstudent s
							 inner join tblstdadm sa on sa.StdID = s.StdId
							 INNER JOIN tbldepartmentmaster DM ON DM.DeptName = s.Dept
							  INNER JOIN tblcuryear cy ON cy.EduYearFrom = sa.EduYearFrom AND cy.EduYearTo = sa.EduYearTo
							  where DM.DeptName = '" . $_GET['dept'] . "'
							  order by CNUM";
				}
				if( $_GET['dept'] == 'All' && $_GET['eduyear'] == 'All' ) {
					$query = "SELECT sa.Year as year,DM.DeptName as dept,CNUM,Concat(FirstName,' ',FatherName, ' ' ,Surname) as userName,
							sa.RollNo as Rollnum,sa.Div as division,uniprn,parent_name,
							Rel,parent_address,parent_taluka,parent_district,parent_state,pincode,parent_telephone,
							parent_mobile,father_income,mother_income,org_name,org_address,org_telephone,org_mobile FROM tblstudent s
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
					echo "<td>{$parent_name} </td>";
					echo "<td>{$Rel} </td>";
					echo "<td>{$parent_address} </td>";
					echo "<td>{$parent_telephone} </td>";
					echo "<td>{$parent_mobile} </td>";
					echo "<td>{$father_income} </td>";
					echo "<td>{$mother_income} </td>";
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