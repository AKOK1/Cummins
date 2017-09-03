<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Admission Report with Category</title>
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
			<td colspan='16' class='th-heading'><center><h2>Admission Information with Category for Academic Year: <?php echo $_GET['feadmyear'];?></center></td>
		</TR>
		<TR>
			<td colspan='16' class='th-heading'>
			<h3>Year: <?php echo $_GET['year'];?>,&nbsp;Department: <?php echo $_GET['deptname'];?>,&nbsp;Academic Year: <?php echo $_GET['feadmyear'];?>&nbsp;</h3>
			</td>
		</TR>
		<tr class="th">
			<td>No.</td>
			<td>CNUM</td>
			<td>Adm. Year</td>
			<td>Roll No.</td>
			<td>Name</td>
			<td>Mobile No.</td>
			<td>Category</td>
			<td>Remark</td>
			<td>Adm. Status</td>
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
					$sql = "SELECT UniPRN,Caste_subcaste,stdremark,
							SA.StdAdmID, CNUM,Mobno, RollNo,trim(CONCAT(Surname,' ', FirstName, ' ',FatherName)) AS StdName, DM.DeptName, SA.Shift  , Year, `div` as divn,case when COALESCE(SA.stdstatus, '') = 'R' then 'Confirmed' else case when COALESCE(SA.stdstatus, '') = 'P' then '<b>Provisinoal</b>' else '' end end as stdstatus, COALESCE(SA.stdstatus, '') as stdstatus2, Caste_subcaste as admcat,S.feadmyear as feadmyear2
							FROM tblstudent S 
							INNER JOIN tblstdadm SA ON S.StdId = SA.StdID
							INNER JOIN tbldepartmentmaster DM ON S.Dept = DM.DeptName
							WHERE SA.EduYearFrom  = " . $SelYearFrom . " AND SA.EduYearTo = " . $SelYearTo . " AND YEAR <> 'A.L.'";
//COALESCE(SA.AdmConf, 0) = 1 and 
					}
					else{
					$sql = "SELECT UniPRN,Caste_subcaste,stdremark,
							SA.StdAdmID, CNUM,Mobno, RollNo,trim(CONCAT(Surname,' ', FirstName, ' ',FatherName)) AS StdName, DM.DeptName, SA.Shift  , Year, `div` as divn,
							case when COALESCE(SA.stdstatus, '') = 'R' then 'Confirmed' else case when COALESCE(SA.stdstatus, '') = 'P' then '<b>Provisinoal</b>' else '' end end as stdstatus, COALESCE(SA.stdstatus, '') as stdstatus2, Caste_subcaste as admcat,S.feadmyear as feadmyear2
							FROM tblstdadm SA 
							INNER JOIN tblstudent S ON S.StdId = SA.StdID
							INNER JOIN tbldepartmentmaster DM ON SA.Dept = DM.DeptID
							WHERE 
CONCAT(SA.EduYearFrom,'-',SUBSTRING(SA.EduYearTo,3,2)) = '" . $_GET['feadmyear'] . "' 
AND YEAR <> 'A.L.'";
//COALESCE(SA.AdmConf, 0) = 1 and 
					}
//SA.EduYearFrom  = " . $SelYearFrom . " AND SA.EduYearTo = " . $SelYearTo . " AND 
					
					// $sql = "SELECT appid,CNUM,Mobno,
							// SA.mhcetscore as mhcetscore,feadmyear,dteid,Caste_subcaste as admcat, RollNo,seattype,SA.stdremark as stdremark,
							// CONCAT(Surname,' ', FirstName, ' ',FatherName) AS StdName, DM.DeptName as DeptName , SA.Shift as Shift  ,
							// SA.Div as divn,SA.Year as Year,
							// case when COALESCE(SA.AdmConf, 0) = 1 then 'Confirmed' else '' end as stdstatus
							// FROM tblstdadm SA 
							// INNER JOIN tblstudent S ON S.StdId = SA.StdID
							// INNER JOIN tbldepartmentmaster DM ON SA.Dept = DM.DeptID
							// WHERE Year <> 'A.L.'";
							
					If ((isset($_GET['dept'])))
					{
						$sql = $sql . " and DM.DeptID = "  . $_GET['dept']  ;
					}
					If ((isset($_GET['year'])))
					{
						$sql = $sql . " and Year = '"  . $_GET['year'] . "'" ;
					}
					// If ((isset($_GET['feadmyear'])))
					// {
						// $sql = $sql . " and feadmyear = '"  . $_GET['feadmyear'] . "'" ;
					// }
					If ((isset($_GET['divn'])))
					{
						$sql = $sql . " and `div` = '"  . $_GET['divn'] . "'" ;
					}
					
					$sql = $sql . " ORDER BY Year,Cast(RollNo as UNSIGNED)";
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
							echo "<td>{$feadmyear2} </td>";
							echo "<td>{$RollNo} </td>";
							echo "<td>{$StdName} </td>";
							echo "<td>{$Mobno} </td>";
							echo "<td>{$admcat} </td>";
							echo "<td>{$stdremark} </td>";
							echo "<td>{$stdstatus2} </td>";
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