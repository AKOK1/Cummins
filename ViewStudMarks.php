<?php
		if(!isset($_SESSION)){
			session_start();
		}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Student Marks</title>
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
		<td colspan='7' class='th-heading'><center>Uploaded Marks for <?php echo $_SESSION["qblockname"]; ?></center></td>
	</TR>
	</table>
	<br/><br/>
	
<table width="90%" border="0" cellpadding="5" cellspacing="0" class="fix-table" style="margin-left: 5%;">
	<tr class="th">
		<td width="5%">Sr. No.</td>
		<td width="10%">ESN</td>
		<td width="10%">Total</td>
		<td width="10%">Q1</td>
		<td width="10%">Q2</td>
		<td width="10%">Q3</td>
		<td width="10%">Q4</td>
		<td width="10%">Q5</td>
		<td width="10%">Q6</td>
		<td width="10%">Q7</td>
		<td width="10%">Q8</td>
		<td width="10%">Q9</td>
		<td width="10%">Q10</td>
		<td width="10%">Q11</td>
		<td width="10%">Q12</td>
		<td width="10%">Q13</td>
		<td width="10%">Q14</td>
		<td width="10%">Q15</td>
		<td width="10%">Q16</td>
		<td width="10%">Q17</td>
		<td width="10%">Q18</td>
		<td width="10%">Q19</td>
		<td width="10%">Q20</td>
		<?php
			if(!isset($_SESSION)){
					session_start();
			}
	if(isset($_GET['cbpid']))
	{
		include 'db/db_connect.php';
		ini_set('max_execution_time', 2000);
	}
	else
		exit;
?>
	</tr>
	<?php
		$j = 1;
		include 'db/db_connect.php';
		$sql = "SELECT StdId,Q1,Q2,Q3,Q4,Q5,Q6,Q7,Q8,Q9,Q10,Q11,Q12,Q13,Q14,Q15,Q16,Q17,Q18,Q19,Q20,
				CASE coalesce(stdstatus,'') WHEN 'A' THEN 'AA' 
ELSE CONVERT((Q1+Q2+Q3+Q4+Q5+Q6+Q7+Q8+Q9+Q10+Q11+Q12+Q13+Q14+Q15+Q16+Q17+Q18+Q19+Q20) , CHAR(10)) END AS  tot
				FROM tblinsemmarks
				WHERE CapID = " . $_GET["cbpid"]. " ";
//echo $sql;		
	// execute the sql query
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
					echo "<td>{$StdId} </td>";
					echo "<td>{$tot} </td>";
					echo "<td>{$Q1} </td>";
					echo "<td>{$Q2} </td>";
					echo "<td>{$Q3} </td>";
					echo "<td>{$Q4} </td>";
					echo "<td>{$Q5} </td>";
					echo "<td>{$Q6} </td>";
					echo "<td>{$Q7} </td>";
					echo "<td>{$Q8} </td>";
					echo "<td>{$Q9} </td>";
					echo "<td>{$Q10} </td>";
					echo "<td>{$Q11} </td>";
					echo "<td>{$Q12} </td>";
					echo "<td>{$Q13} </td>";
					echo "<td>{$Q14} </td>";
					echo "<td>{$Q15} </td>";
					echo "<td>{$Q16} </td>";
					echo "<td>{$Q17} </td>";
					echo "<td>{$Q18} </td>";
					echo "<td>{$Q19} </td>";
					echo "<td>{$Q20} </td>";
					
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
