<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Pending Details - All Students</title>
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
	<table width="90%" cellpadding="5" cellspacing="0" class="fix-table" style="margin-left: 5%;">
	<TR>
		<td colspan='7' class='th-heading'><center>Student Details Pending - All Students</center></td>
	</TR>
	</table>
	<br/><br/>
	
<table width="90%" border="0" cellpadding="5" cellspacing="0" class="fix-table" style="margin-left: 5%;">
	<tr class="th">
		<td width="5%">Sr. No.</td>
		<td width="10%">CNUM</td>
		<td width="15%">Name</td>
		<td width="10%">Dept</td>
		<td width="10%">Mobile</td>
		<td width="10%">Year</td>
		<td width="10%">Personal</td>
		<td width="10%">Qualifications</td>
		<td width="10%">Parent</td>
		<td width="10%">My Numbers</td>
	</tr>
	<?php
		include 'db/db_connect.php';
		$sql = "SELECT CNUM,CONCAT(COALESCE(FirstName,''),' ',COALESCE(Surname,'')) AS NAME,S.dept,mobno ,sa.year AS stdyear,
				CASE WHEN trim(COALESCE(Pmail,'')) = '' THEN 'N' ELSE 'Y' END AS Personal,
				CASE WHEN trim(COALESCE(SQ.name,'')) = '' THEN 'N' ELSE 'Y' END AS Qualifications,
				CASE WHEN trim(COALESCE(parent_name,'')) = '' THEN 'N' ELSE 'Y' END AS Parent,
				'Y' AS MyNumbers
				FROM tblstudent S
				LEFT JOIN stdqual SQ ON S.stdid = SQ.stdid AND Exam = '10th'
				LEFT JOIN tblstdadm sa ON sa.StdID = S.StdID
				INNER JOIN tblcuryear cy on cy.EduYearFrom = sa.EduYearFrom and cy.EduYearTo = sa.EduYearTo
				WHERE sa.year <> 'A.L.'
				ORDER BY Personal,Qualifications,Parent,MyNumbers,S.dept;";
			// execute the sql query
			//echo $sql;
			//CASE WHEN trim(COALESCE(unieli,'')) = '' THEN 'N' ELSE 'Y' END
			$result = $mysqli->query( $sql );
			echo $mysqli->error;
			$num_results = $result->num_rows;
			$i = 1;
			//echo $sql;
			if( $num_results ){
				while( $row = $result->fetch_assoc() ){
					extract($row);
					echo "<TR>";
					echo "<td>$i</td>";
					echo "<td>{$CNUM} </td>";
					echo "<td>{$NAME} </td>";
					echo "<td>{$dept} </td>";
					echo "<td>{$mobno} </td>";
					echo "<td>{$stdyear} </td>";
					echo "<td>{$Personal} </td>";
					echo "<td>{$Qualifications} </td>";
					echo "<td>{$Parent} </td>";
					echo "<td>{$MyNumbers} </td>";
					echo "</TR>";
					$i += 1;
				}
			}					

			//disconnect from database	
			$result->free();
			$mysqli->close();
	?>

    </table></td>
  </tr>
</table>
</body>
</html>
