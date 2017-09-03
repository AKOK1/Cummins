<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Junior Sup Report</title>
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
		<td colspan='7' class='th-heading'><center>Junior Supervisor Duty Report</center></td>
	</TR>
	</table>
	<br/><br/>
	
<table width="90%" border="0" cellpadding="5" cellspacing="0" class="fix-table" style="margin-left: 5%;">
	<tr class="th">
		<td width="5%">profid</td>
		<td width="15%">Name</td>
		<td width="40%">Exam Date</td>
		<td width="20%">Time From</td>
		<td width="20%">Max(Time To)</td>
	</tr>
	<?php
	if(!isset($_SESSION)){
		session_start();
	} 
		include 'db/db_connect.php';
		
		
		$sql = "SELECT profid , CONCAT(u.FirstName,' ',u.LastName,'-',u.Department,'-',u.ContactNumber) as ABC ,
		examDATE,TimeFrom,MAX(TimeTo) as TimeTo
		FROM tblexamblock EB
		LEFT JOIN tblexamschedule ES ON EB.examschid = ES.examschid AND examid =  " . $_SESSION['SESSSelectedExam'] . "
		LEFT JOIN tbluser u ON u.userid = EB.ProfID
		WHERE profid IS NOT NULL AND examDATE IS NOT NULL
		GROUP BY profid , CONCAT(u.FirstName,' ',u.LastName), examDATE,TimeFrom
		ORDER BY examDATE,CONCAT(u.FirstName,' ',u.LastName)";
			// execute the sql query
			//echo $sql;
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
					echo "<td>{$ABC} </td>";
					echo "<td>{$examDATE} </td>";
					echo "<td>{$TimeFrom} </td>";
					echo "<td>{$TimeTo} </td>";
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
