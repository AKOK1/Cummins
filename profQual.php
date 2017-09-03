<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Qualifications</title>
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
	<table width="99.5%" cellpadding="5" cellspacing="0" class="fix-table" style="margin-left: 0.5%;">
	<TR>
		<td colspan='10' class='th-heading'><center>Qualifications</center></td>
	</TR>
	<TR>		
		<td colspan='2' class='th-heading'>Department: <?php echo $_GET['dept']; ?><center></center></td>
		</TR>
	</table>
		
<table border="0" cellpadding="5" cellspacing="0" class="fix-table" style="margin-left: 0.5%;">
	<tr class="th">
		<td width="20%">Name</td>
		<td width="10%">Exam / Degree</td>
		<td width="10%">Year</td>
		<td width="10%">Class</td>
		<td width="10%">Branch</td>
		<td width="10%">Institution / University</td>
		<td width="10%">Marks Obtained</td>
		<td width="10%">Marks Out of</td>
		<td width="10%">Percentage</td>
		<td width="10%">Date of Registration</td>
		<td width="10%">Date of Declaration</td>
		<td width="10%">Guide Name</td>
	</tr>
	
	<?php
	if(!isset($_SESSION)){
		session_start();
	} 
		include 'db/db_connect.php';

			$query = "SELECT Concat(tu.FirstName, ' ' ,tu.LastName) as userName,
			pq.Exam_name as Exam_name,pq.year,pq.class,'' as Branch,pq.insti_name as UNINAME,mobt,mout,pq.percentage
			,'' as DofReg ,'' as dofdec, '' as guidename
			,1 as myorder
			FROM profqual2 pq
			INNER JOIN tbluser tu ON tu.userID = pq.ProfId
			where pq.Exam_name = '10th' and coalesce(pq.year,'') <> '' and tu.userType IN ('HOD','Faculty','TA','Ad-hoc')
			and tu.Department = '" . $_GET['dept'] . "'
			UNION
			SELECT Concat(tu.FirstName, ' ' ,tu.LastName) as userName,
			pq.Exam_name as Exam_name,pq.year,pq.class,'' as Branch,pq.insti_name as UNINAME,mobt,mout,pq.percentage
			,'' as DofReg ,'' as dofdec,'' as guidename
			,2 as myorder
			FROM profqual2 pq
			INNER JOIN tbluser tu ON tu.userID = pq.ProfId
			where pq.Exam_name = '12th' and coalesce(pq.year,'') <> '' and tu.userType IN ('HOD','Faculty','TA','Ad-hoc') 
			and tu.Department = '" . $_GET['dept'] . "'
			UNION
			SELECT Concat(tu.FirstName, ' ' ,tu.LastName) as userName,
			pq.Exam_name as Exam_name,pq.year,pq.class,'' as Branch,pq.insti_name as UNINAME,mobt,mout,pq.percentage
			,'' as DofReg ,'' as dofdec,'' as guidename
			,3 as myorder
			FROM profqual2 pq
			INNER JOIN tbluser tu ON tu.userID = pq.ProfId
			where pq.Exam_name = 'Diploma' and coalesce(pq.year,'') <> '' and tu.userType IN ('HOD','Faculty','TA','Ad-hoc') 
			and tu.Department = '" . $_GET['dept'] . "'
			UNION
			SELECT Concat(tu.FirstName, ' ' ,tu.LastName) as userName,
			pq.degtype as Exam_name,pq.yearofpassing as year,pq.class,Branch,pq.nameofuni as  UNINAME,mobt,mout,pq.percentage
			,'' as DofReg ,'' as dofdec,'' as guidename
			,4 as myorder
			FROM profqual pq
			INNER JOIN tbluser tu ON tu.userID = pq.ProfId
			where pq.degtype = 'UG' and coalesce(pq.yearofpassing,'') <> '' and tu.userType IN ('HOD','Faculty','TA','Ad-hoc')
			and tu.Department = '" . $_GET['dept'] . "'
			UNION
			SELECT Concat(tu.FirstName, ' ' ,tu.LastName) as userName,
			pq.degtype as Exam_name,pq.yearofpassing as year,pq.class,Branch,pq.nameofuni as  UNINAME,mobt,mout,pq.percentage
			,'' as DofReg ,'' as dofdec,'' as guidename
			,5 as myorder
			FROM profqual pq
			INNER JOIN tbluser tu ON tu.userID = pq.ProfId
			where pq.degtype = 'PG' and coalesce(pq.yearofpassing,'') <> '' and tu.userType IN ('HOD','Faculty','TA','Ad-hoc')
			and tu.Department = '" . $_GET['dept'] . "'
			UNION
			SELECT Concat(tu.FirstName, ' ' ,tu.LastName) as userName,
			pq.degtype as Exam_name,'' as year,'' as class,branch,pq.university as  UNINAME,'' as mobt, '' as mout,'' as percentage
			,DofReg ,dofdec,guidename
			,6 as myorder
			FROM phdqual pq
			INNER JOIN tbluser tu ON tu.userID = pq.ProfId
			where pq.degtype = 'PHD' and coalesce(pq.branch,'') <> '' and tu.userType IN ('HOD','Faculty','TA','Ad-hoc')
			and tu.Department = '" . $_GET['dept'] . "'
			order by userName,myorder";
		
		//echo $query;
				 if($_GET['dept'] == 'All') {					 
					 $query = "SELECT Concat(tu.FirstName, ' ' ,tu.LastName) as userName,
						pq.Exam_name as Exam_name,pq.year,pq.class,'' as Branch,pq.insti_name as UNINAME,mobt,mout,pq.percentage
						,'' as DofReg ,'' as dofdec,'' as guidename
						,1 as myorder
						FROM profqual2 pq
						INNER JOIN tbluser tu ON tu.userID = pq.ProfId
						where pq.Exam_name = '10th' and coalesce(pq.year,'') <> '' 
						UNION
						SELECT Concat(tu.FirstName, ' ' ,tu.LastName) as userName,
						pq.Exam_name as Exam_name,pq.year,pq.class,'' as Branch,pq.insti_name as UNINAME,mobt,mout,pq.percentage
						,'' as DofReg ,'' as dofdec,'' as guidename
						,2 as myorder
						FROM profqual2 pq
						INNER JOIN tbluser tu ON tu.userID = pq.ProfId
						where pq.Exam_name = '12th' and coalesce(pq.year,'') <> '' and tu.userType IN ('HOD','Faculty','TA','Ad-hoc')
						UNION
						SELECT Concat(tu.FirstName, ' ' ,tu.LastName) as userName,
						pq.Exam_name as Exam_name,pq.year,pq.class,'' as Branch,pq.insti_name as UNINAME,mobt,mout,pq.percentage
						,'' as DofReg ,'' as dofdec,'' as guidename
						,3 as myorder
						FROM profqual2 pq
						INNER JOIN tbluser tu ON tu.userID = pq.ProfId
						where pq.Exam_name = 'Diploma' and coalesce(pq.year,'') <> '' and tu.userType IN ('HOD','Faculty','TA','Ad-hoc')
						UNION
						SELECT Concat(tu.FirstName, ' ' ,tu.LastName) as userName,
						pq.degtype as Exam_name,pq.yearofpassing as year,pq.class,Branch,pq.nameofuni as  UNINAME,mobt,mout,pq.percentage
						,'' as DofReg ,'' as dofdec,'' as guidename
						,4 as myorder
						FROM profqual pq
						INNER JOIN tbluser tu ON tu.userID = pq.ProfId
						where pq.degtype = 'UG' and coalesce(pq.yearofpassing,'') <> '' and tu.userType IN ('HOD','Faculty','TA','Ad-hoc')
						UNION
						SELECT Concat(tu.FirstName, ' ' ,tu.LastName) as userName,
						pq.degtype as Exam_name,pq.yearofpassing as year,pq.class,Branch,pq.nameofuni as  UNINAME,mobt,mout,pq.percentage
						,'' as DofReg ,'' as dofdec,'' as guidename
						,5 as myorder
						FROM profqual pq
						INNER JOIN tbluser tu ON tu.userID = pq.ProfId
						where pq.degtype = 'PG' and coalesce(pq.yearofpassing,'') <> '' and tu.userType IN ('HOD','Faculty','TA','Ad-hoc') 
						UNION
						SELECT Concat(tu.FirstName, ' ' ,tu.LastName) as userName,
						pq.degtype as Exam_name,'' as year,'' as class,branch,pq.university as  UNINAME,'' as mobt, '' as mout,'' as percentage
						,DofReg ,dofdec,guidename
						,6 as myorder
						FROM phdqual pq
						INNER JOIN tbluser tu ON tu.userID = pq.ProfId
						where pq.degtype = 'PHD' and coalesce(pq.branch,'') <> '' and tu.userType IN ('HOD','Faculty','TA','Ad-hoc')
						order by userName,myorder";
					 
					 
					 
					 // $query = "SELECT Concat(tu.FirstName, ' ' ,tu.LastName) as userName,
					 // pq.Exam_name,pq.insti_name,pq.year,pq.mobt,pq.mout,pq.class,pq.percentage,
					// pq1.degtype as deg,pq1.Degree,pq1.Branch,pq1.class,pq1.mobt,pq1.mout,pq1.Percentage,pq1.YearOfPassing,
					// pq1.nameofuni,pq1.nameofcollage,
					// ph.degtype,ph.branch,ph.university,ph.guidename,ph.DofReg,ph.dofdec 
					// FROM profqual2 pq
								 // INNER JOIN phdqual ph ON ph.profId = pq.ProfId and branch is not null
								 // INNER JOIN profqual pq1 ON pq1.profId = pq.ProfId and pq1.mobt is not null
								 // INNER JOIN tbluser tu ON tu.userID = pq.ProfId
					// where pq.mobt is not null order by userName,myorder";
				}
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
					echo "<td>{$userName} </td>";
					echo "<td>{$Exam_name} </td>";
					echo "<td>{$year} </td>";
					echo "<td>{$class} </td>";
					echo "<td>{$Branch} </td>";
					echo "<td>{$UNINAME} </td>";
					echo "<td>{$mobt} </td>";
					echo "<td>{$mout} </td>";
					echo "<td>{$percentage} </td>";
					echo "<td>{$DofReg} </td>";
					echo "<td>{$dofdec} </td>";
					echo "<td>{$guidename} </td>";
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