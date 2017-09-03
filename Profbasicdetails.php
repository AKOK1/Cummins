<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Faculty Personal Details</title>
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
	<table border="0" cellpadding="5" cellspacing="0" class="fix-table" style="margin-left: 0.5%;">
		<TR>
			<td colspan='31' class='th-heading'><center><h2>Personal Details</center></td>
		</TR>
		<TR>
			<td colspan='31' class='th-heading'>
			Department: <?php echo $_GET['dept'];?>
			</td>
		</TR>
		<tr class="th">
			<td width="30%">User Name</td>
			<td width="10%">Father's Name</td>
			<td width="10%">Mother's Name</td>
			<td width="10%">Father / Husband Name</td>
			<td width="30%">Date of Birth</td>
			<td width="30%">Mother's Full Name</td>
			<td width="5%">Blood Group</td>
			<td width="5%">Status</td>
			<td width="5%">Gender</td>
			<td width="5%">Dept</td>
			<td width="5%">User Type</td>
			<td width="5%">Nationality</td>
			<td width="5%">Religion</td>
			<td width="5%">Category</td>
			<td width="5%">Permanent Address</td>
			<td width="5%">City</td>
			<td width="5%">District</td>
			<td width="5%">Village</td>
			<td width="5%">Pincode</td>
			<td width="5%">Present Address</td>
			<td width="5%">City</td>
			<td width="5%">District</td>
			<td width="5%">Village</td>
			<td width="5%">Pincode</td>
			<td width="10%">Mobile Number</td>
			<td width="10%">Emergency Contact Number</td>
			<td width="10%">Landline Number</td>
			<td width="10%">College Ext. Number</td>
			<td width="15%">College Email Id</td>
			<td width="15%">Personal Email Id</td>
		</tr>
		<?php
		if(!isset($_SESSION)){
			session_start();
		} 
			include 'db/db_connect.php';
					$query = "SELECT tu.userID, Concat(FirstName, ' ', LastName) as userName,FatherName,MotherName,HusbandName,
					DOB,MothrFullName,Blood_group,Status,Gender,Department,userType,Nationality,Religion,
					Caste_subcaste,addr1,City1,District1,Village1,Pincode1,addr2,City2,District2,Village2,Pincode2,ContactNumber,
					emerg_cntactnum,LandlineNo,collgext,Email,Pmail FROM tbluser tu 
					where tu.Department = '" . $_GET['dept'] . "' 
					and userType IN ('HOD','Faculty','TA','Ad-hoc')
					order by userName";
					//echo $query;
					if($_GET['dept'] == 'All') {
						$query = "SELECT tu.userID,Concat(FirstName, ' ', LastName) as userName,FatherName,MotherName,HusbandName,
					DOB,MothrFullName,Blood_group,Status,Gender,Department,userType,Nationality,Religion,Caste_subcaste,
					addr1,City1,District1,Village1,Pincode1,addr2,City2,District2,Village2,Pincode2,
					ContactNumber,emerg_cntactnum,LandlineNo,collgext,Email,Pmail FROM tbluser tu 
					where userType IN ('HOD','Faculty','TA','Ad-hoc')
					order by Department, userName";
					}
				//echo $query;
				$result = $mysqli->query( $query );
				echo $mysqli->error;
				$num_results = $result->num_rows;
				if( $num_results ){
					while( $row = $result->fetch_assoc() ){
						extract($row);
						echo "<TR>";
						echo "<td>{$userName}</td>";
						echo "<td>{$FatherName}</td>";
						echo "<td>{$MotherName}</td>";
						echo "<td>{$HusbandName}</td>";
						echo "<td>{$DOB}</td>";
						echo "<td>{$MothrFullName}</td>";
						echo "<td>{$Blood_group}</td>";
						echo "<td>{$Status}</td>";
						echo "<td>{$Gender}</td>";
						echo "<td>{$Department}</td>";
						echo "<td>{$userType}</td>";
						echo "<td>{$Nationality}</td>";
						echo "<td>{$Religion}</td>";
						echo "<td>{$Caste_subcaste}</td>";
						echo "<td>{$addr1}</td>";
						echo "<td>{$City1}</td>";
						echo "<td>{$District1}</td>";
						echo "<td>{$Village1}</td>";
						echo "<td>{$Pincode1}</td>";
						echo "<td>{$addr2}</td>";
						echo "<td>{$City2}</td>";
						echo "<td>{$District2}</td>";
						echo "<td>{$Village2}</td>";
						echo "<td>{$Pincode2}</td>";
						echo "<td>{$ContactNumber}</td>";
						echo "<td>{$emerg_cntactnum}</td>";
						echo "<td>{$LandlineNo}</td>";
						echo "<td>{$collgext}</td>";
						echo "<td>{$Email}</td>";
						echo "<td>{$Pmail}</td>";
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