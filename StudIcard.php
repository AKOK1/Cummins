<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Student Numbers</title>
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
	<TR><td colspan='17' class='th-heading'><center><h2>Student I-Card</center></td></TR>
<TR>
		<td colspan='17' class='th-heading'>
		Department: <?php echo $_GET['dept'];?>,&nbsp;
		Education Year: <?php echo $_GET['eduyear'];?>&nbsp;
		Academic Year: <?php echo $_GET['feadmyear'];?>&nbsp;
		
		
	</TR>
	<TR>
	</TR>
	<tr class="th">
		<td>Sr.No.</td>
		<td>Student Name</td>
		<td>Department</td>
		<td>CNUM</td>
		<td>DOB</td>
		<td>Blood Group</td>
		<td>Permanent Address</td>
		<td>Parent's Mobile Number</td>
		<td>Photopath</td>
	</tr>
	<?php
	if(!isset($_SESSION)){
		session_start();
	} 
		include 'db/db_connect.php';
		
				$query = "SELECT DM.DeptName as dept,
							Concat(FirstName, ' ', Surname) as userName,DOB,Replace(Replace(Blood_group,'positive','+ve'),'negative','-ve') as  Blood_group,TRIM(CONCAT(parent_address,' ', parent_taluka, ', ', parent_district,', ', parent_state,', ',  pincode)) AS parent_address,parent_mobile,
							CNUM as uniprn,photopath ,TRIM(CONCAT(Taluka, ', ', District,', ', State,', ',  pincode)) AS stdaddress
							FROM tblstudent s
							inner join tblstdadm sa on sa.StdID = s.StdId
							INNER JOIN tbldepartmentmaster DM ON DM.DeptID = sa.Dept
							INNER JOIN tblcuryear cy on cy.EduYearFrom = sa.EduYearFrom and cy.EduYearTo = sa.EduYearTo
							 where sa.Year = '" . $_GET['eduyear']. "' 
							and DM.DeptName = '" . $_GET['dept'] . "'
							and feadmyear = '"  . $_GET['feadmyear'] . "'
							order by userName";
			
			if($_GET['dept'] == 'All') {
				$query = "SELECT DM.DeptName as dept,
							Concat(FirstName, ' ', Surname) as userName,DOB,Replace(Replace(Blood_group,'positive','+ve'),'negative','-ve') as  Blood_group,TRIM(CONCAT(parent_address,' ', parent_taluka, ', ', parent_district,', ', parent_state,', ',  pincode)) AS parent_address,parent_mobile, 
							CNUM as uniprn,photopath ,TRIM(CONCAT(Taluka, ', ', District,', ', State,', ',  pincode)) AS stdaddress
FROM tblstudent s
							inner join tblstdadm sa on sa.StdID = s.StdId
							INNER JOIN tbldepartmentmaster DM ON DM.DeptID = sa.Dept
							INNER JOIN tblcuryear cy on cy.EduYearFrom = sa.EduYearFrom and cy.EduYearTo = sa.EduYearTo
							where  sa.Year = '" . $_GET['eduyear']. "'
							and feadmyear = '"  . $_GET['feadmyear'] . "'
							 order by userName"; 	
			}
			if($_GET['eduyear'] == 'All') {
				$query = "SELECT DM.DeptName as dept,
						Concat(FirstName, ' ', Surname) as userName,DOB,Replace(Replace(Blood_group,'positive','+ve'),'negative','-ve') as Blood_group,TRIM(CONCAT(parent_address,' ', parent_taluka, ', ', parent_district,', ', parent_state,', ',  pincode)) AS parent_address,parent_mobile,
						  CNUM as uniprn,photopath ,TRIM(CONCAT(Taluka, ', ', District,', ', State,', ',  pincode)) AS stdaddress
							FROM tblstudent s
						  inner join tblstdadm sa on sa.StdID = s.StdId
						  INNER JOIN tbldepartmentmaster DM ON DM.DeptID = sa.Dept
							INNER JOIN tblcuryear cy on cy.EduYearFrom = sa.EduYearFrom and cy.EduYearTo = sa.EduYearTo
						  where DM.DeptName = '" . $_GET['dept'] . "'
							and feadmyear = '"  . $_GET['feadmyear'] . "'
						  order by userName";
			}
			if($_GET['dept'] == 'All' && $_GET['eduyear'] == 'All') {
				$query = "SELECT DM.DeptName as dept,
						 Concat(FirstName, ' ', Surname) as userName,DOB,Replace(Replace(Blood_group,'positive','+ve'),'negative','-ve') as Blood_group,TRIM(CONCAT(parent_address,' ', parent_taluka, ', ', parent_district,', ', parent_state,', ',  pincode)) AS parent_address,parent_mobile,
						  CNUM as uniprn,photopath ,TRIM(CONCAT(Taluka, ', ', District,', ', State,', ',  pincode)) AS stdaddress
						FROM tblstudent s
						  inner join tblstdadm sa on sa.StdID = s.StdId
						  INNER JOIN tbldepartmentmaster DM ON DM.DeptID = sa.Dept
							INNER JOIN tblcuryear cy on cy.EduYearFrom = sa.EduYearFrom and cy.EduYearTo = sa.EduYearTo
							and feadmyear = '"  . $_GET['feadmyear'] . "'
						  order by userName";
		}
			 //echo $query;
			//twohrsduties is not null and otherhrsduties is not null
			// execute the sql query
			//echo $sql;
			$result = $mysqli->query( $query );
			echo $mysqli->error;
			$num_results = $result->num_rows;
			$i = 1;
			//echo $sql;
			if( $num_results ){
				while( $row = $result->fetch_assoc() ){
					extract($row);
					echo "<TR>";
					echo "<td>$i</td>";
					echo "<td>{$userName} </td>";
					echo "<td>{$dept} </td>";
					echo "<td>{$uniprn} </td>";
					echo "<td>{$DOB} </td>";
					echo "<td>{$Blood_group} </td>";
					echo "<td>{$parent_address} </td>";
					echo "<td>{$parent_mobile} </td>";
					echo "<td>{$photopath} </td>";
					
					echo "</TR>";
					$i += 1;
				}
			}					

			//disconnect from database	
			$result->free();
			$mysqli->close();
	?>

	</table>


</body>
</html>