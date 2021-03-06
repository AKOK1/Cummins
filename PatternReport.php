<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Pattern Report</title>
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
<?php
if(!isset($_SESSION)){
			session_start();
		}
	// echo $_SESSION["quizselectedexam"];
	// echo $_SESSION["quizselectedyear"];
	//echo $_SESSION["sesspatid"];
	 ?>
		<br/>
	<center><img class="center" alt="logo" src="images/logo.png"></center>
	<br/>
	<table width="90%" cellpadding="5" cellspacing="0" class="fix-table" style="margin-left: 5%;">
	<TR>
		<td colspan='7' class='th-heading'><center>Pattern Report</center></td>
	</TR>
	</table>
	<br/><br/>
<table width="90%" border="0" cellpadding="5" cellspacing="0" class="fix-table" style="margin-left: 5%;">
	<tr class="th">
		<td width="15%">Academic Year</td>
		<td width="15%">F.E.</td>
		<td width="15%">S.E.</td>
		<td width="15%">T.E.</td>
		<td width="15%">B.E.</td>
		<td width="15%">M.E.</td>
		
	</tr>
	<?php
	if(!isset($_SESSION)){
		session_start();
	} 
		include 'db/db_connect.php';
			$sql = "SELECT acadyear,
					cast(COALESCE(max(CASE WHEN eduyear = 'F.E.' THEN teachingpat END), '') as CHAR),
					cast(COALESCE(max(CASE WHEN eduyear = 'S.E.' THEN teachingpat END), '') as CHAR),
					cast(COALESCE(max(CASE WHEN eduyear = 'T.E.' THEN teachingpat END), '') as CHAR),
					cast(COALESCE(max(CASE WHEN eduyear = 'B.E.' THEN teachingpat END), '') as CHAR),
					cast(COALESCE(max(CASE WHEN eduyear = 'M.E.' THEN teachingpat END), '') as CHAR)
					FROM tblpatternmaster GROUP BY acadyear;";
			$result = $mysqli->query( $sql );
			echo $mysqli->error;
			$num_results = $result->num_rows;
			//echo $sql;
			if( $num_results ){
				while( $row = $result->fetch_assoc() ){

					echo "<tr>";

					foreach($row as $value)  {
				   
						echo "<td>".$value."</td>";
					}

					echo "</tr>";

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
