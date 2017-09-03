<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Fee Report</title>
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
			<td colspan='17' class='th-heading'><center><h2>Fee Information for Academic Year: <?php echo $_GET['feadmyear'];?></center></td>
		</TR>
		<TR>
			<td colspan='17' class='th-heading'>
			<h3>Year: <?php echo $_GET['year'];?>,&nbsp;Department: <?php echo $_GET['deptname'];?>,&nbsp;Academic Year: <?php echo $_GET['feadmyear'];?>&nbsp;</h3>
			</td>
		</TR>
		<tr class="th">
			<td>Sr. No.</td>
			<td>CNUM</td>
			<td>Roll No.</td>
			<td>Mobile No.</td>
			<td>Name</td>
			<td>Admission Year</td>
			<td>Admission Category</td>
			<td>Department</td>
			<td>Shift</td>
			<td>Division</td>
			<td>Edu Year</td>
			<td>Cummins Seat Type</td>
			<td>Fee</td>
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
	
					if($_GET['deptname'] == 'BSH'){
					$sql = "SELECT CNUM,Mobno, feadmyear,admcat, RollNo,S.seattype,CONCAT(Surname,' ', FirstName, ' ',FatherName) AS StdName, DM.DeptName AS DeptName , SA.Shift AS Shift , SA.Div AS divn,SA.Year AS EduYear, S.cseattype, Fee
							FROM tblstdadm SA 
							INNER JOIN tblstudent S ON S.StdId = SA.StdID 
							INNER JOIN tbldepartmentmaster DM ON SA.Dept = DM.DeptName
							LEFT OUTER JOIN (SELECT CalYear, AdmYear, AdmType, EduYear, SUM(Fee) AS Fee, SeatType 
							FROM tblseattypefeedetail STFD
							INNER JOIN tblseattype ST ON STFD.SeatTypeId = ST.SeatTypeId
							GROUP BY CalYear, AdmYear, AdmType, EduYear, SeatType ) AS SFTD ON  CONCAT(SA.eduyearfrom,'-',SUBSTRING(SA.eduyearto,3,2)) = CalYear AND SA.Year = EduYear 
							AND case when ((coalesce(castcert,0) = 0) OR (coalesce(creamycert,0) = 0)) Then 'OPEN' Else cseattype End 
							= SFTD.SeatType AND feadmyear = AdmYear
							WHERE YEAR <> 'A.L.'";
					}
					else{
					$sql = "SELECT CNUM,Mobno, feadmyear,admcat, RollNo,S.seattype,CONCAT(Surname,' ', FirstName, ' ',FatherName) AS StdName, DM.DeptName AS DeptName , SA.Shift AS Shift , SA.Div AS divn,SA.Year AS EduYear, S.cseattype, Fee
							FROM tblstdadm SA 
							INNER JOIN tblstudent S ON S.StdId = SA.StdID 
							INNER JOIN tbldepartmentmaster DM ON SA.Dept = DM.DeptID 
							LEFT OUTER JOIN (SELECT CalYear, AdmYear, AdmType, EduYear, SUM(Fee) AS Fee, SeatType 
							FROM tblseattypefeedetail STFD
							INNER JOIN tblseattype ST ON STFD.SeatTypeId = ST.SeatTypeId
							GROUP BY CalYear, AdmYear, AdmType, EduYear, SeatType ) AS SFTD ON  CONCAT(SA.eduyearfrom,'-',SUBSTRING(SA.eduyearto,3,2)) = CalYear AND SA.Year = EduYear 
							AND case when ((coalesce(castcert,0) = 0) OR (coalesce(creamycert,0) = 0)) Then 'OPEN' Else cseattype End 
							 = SFTD.SeatType AND feadmyear = AdmYear
							WHERE YEAR <> 'A.L.'";
					}	
					If ((isset($_GET['dept'])))
					{
						$sql = $sql . " and DM.DeptID = "  . $_GET['dept']  ;
					}
					If ((isset($_GET['year'])))
					{
						$sql = $sql . " and Year = '"  . $_GET['year'] . "'" ;
					}
					If ((isset($_GET['feadmyear'])))
					{
						$sql = $sql . " and CONCAT(SA.eduyearfrom,'-',SUBSTRING(SA.eduyearto,3,2)) = '"  . $_GET['feadmyear'] . "'" ;
					}
					
					$sql = $sql . " ORDER BY Year, cast(RollNo as UNSIGNED), CNUM ";
					// Prepare IN parameters
					 //echo $sql;
					// die;
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
							echo "<td>{$Mobno} </td>";
							echo "<td>{$StdName} </td>";
							echo "<td>{$feadmyear} </td>";
							echo "<td>{$seattype} </td>";
							echo "<td>{$DeptName} </td>";
							echo "<td>{$Shift} </td>";
							echo "<td>{$divn} </td>";
							echo "<td>{$EduYear} </td>";
							echo "<td>{$cseattype} </td>";
							echo "<td style='text-align: right;'>{$Fee} </td>";
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