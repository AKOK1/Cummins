<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Roll Call</title>
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
	text-indent:0px;
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
	<center>
	<table border="0" cellpadding="5" cellspacing="0" class="fix-table">
		<TR>
			<td colspan='8' class='th-heading'><center><h2>Roll Call for Academic Year: <?php echo "2017 - 2018"; ?></center></td>
		</TR>
		<TR>
			<td colspan='8' class='th-heading'>
			<h3>Year: <?php echo $_GET['year'];?>,&nbsp;Department: <?php echo $_GET['deptname'];?>,&nbsp;Division: <?php echo $_GET['divn'];?>&nbsp;</h3>
			</td>
		</TR>
		<tr class="th">
			<td>Sr. No.</td>
			<td>CNUM</td>
			<td>Roll No.</td>
			<td>Name</td>
			<td>Admission Status</td>
		</tr>	
		<?php
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
	//cast(RollNo as UNSIGNED) as 
					if($_GET['deptname'] == 'BSH'){
					$sql = "SELECT UniPRN,Caste_subcaste,stdremark,
							SA.StdAdmID, CNUM, RollNo,CONCAT(Surname,' ', FirstName, ' ',FatherName) AS StdName, DM.DeptName, SA.Shift  , Year, `div` as divn,case when COALESCE(SA.stdstatus, '') = 'R' then 'Confirmed' else case when COALESCE(SA.stdstatus, '') = 'P' then 'Provisinoal' else case when COALESCE(SA.stdstatus, '') = 'YD' then 'Year Down'  
else case when COALESCE(SA.stdstatus, '') = 'C' then 'Cancelled'  else 'Not Taken' end end end end as stdstatus
							FROM tblstudent S 
							INNER JOIN tblstdadm SA ON S.StdId = SA.StdID
							INNER JOIN tbldepartmentmaster DM ON S.Dept = DM.DeptName
							WHERE SA.EduYearFrom  = " . $SelYearFrom . " AND SA.EduYearTo = " . $SelYearTo . " AND YEAR <> 'A.L.' ";
//COALESCE(SA.AdmConf, 0) = 1 and 
					}
					else{
					$sql = "SELECT UniPRN,Caste_subcaste,stdremark,
							SA.StdAdmID, CNUM, RollNo,CONCAT(Surname,' ', FirstName, ' ',FatherName) AS StdName, DM.DeptName, SA.Shift  , Year, `div` as divn,case when COALESCE(SA.stdstatus, '') = 'R' then 'Confirmed' else case when COALESCE(SA.stdstatus, '') = 'P' then 'Provisinoal' else case when COALESCE(SA.stdstatus, '') = 'YD' then 'Year Down' 
else case when COALESCE(SA.stdstatus, '') = 'C' then 'Cancelled'  else 'Not Taken' end end end end as stdstatus
							FROM tblstdadm SA 
							INNER JOIN tblstudent S ON S.StdId = SA.StdID
							INNER JOIN tbldepartmentmaster DM ON SA.Dept = DM.DeptID
							WHERE SA.EduYearFrom  = " . $SelYearFrom . " AND SA.EduYearTo = " . $SelYearTo . " AND YEAR <> 'A.L.'  ";
//COALESCE(SA.AdmConf, 0) = 1 and 
					}
					if($_GET['deptname'] == 'BSH'){
						If ((isset($_GET['dept'])))
						{
							$sql = $sql . " and S.Dept = '"  . $_GET['deptname']  . "' ";
						}
					}
					else{
						If ((isset($_GET['dept'])))
						{
							$sql = $sql . " and DM.DeptName = '"  . $_GET['deptname']  . "' ";
						}
					}
					If ((isset($_GET['year'])))
					{
						$sql = $sql . " and Year = '"  . $_GET['year'] . "'" ;
					}
					If ((isset($_GET['divn'])))
					{
						$sql = $sql . " and `div` = '"  . $_GET['divn'] . "'" ;
					}
					
					$sql = $sql . " ORDER BY cast(RollNo as UNSIGNED), YEAR, S.Dept, SA.Shift, StdName";
					
					// Prepare IN parameters
					//echo $sql;
					//die;
					$result = $mysqli->query($sql);
					$num_results = $result->num_rows;
					//echo $num_results;

					if( $num_results ){
						$srno = 1;
						while( $row = $result->fetch_assoc() ){
							extract($row);
							echo "<TR class='odd gradeX'>";
							echo "<td>{$srno} </td>";
							echo "<td>{$CNUM} </td>";
							echo "<td>{$RollNo} </td>";
							echo "<td>{$StdName} </td>";
							echo "<td>{$stdstatus} </td>";
							echo "</TR>";
							$srno = $srno  + 1;
						}
					}											
					$result->free();

					//disconnect from database
					$mysqli->close();
		?>
    </table>
	</center>
</body>
</html>