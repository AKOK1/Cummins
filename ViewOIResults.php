<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Online / In-sem Results</title>
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
	<br/>
	<table width="90%" cellpadding="5" cellspacing="0" class="fix-table" style="margin-left: 5%;">
	<TR>
		<td colspan='7' class='th-heading'><center>Online / In-sem Result for Exam: <?php echo $_GET["examname"]; ?></center></td>
	</TR>
	</table>
	<br/><br/>
	
<table width="90%" border="0" cellpadding="5" cellspacing="0" class="fix-table" style="margin-left: 5%;">
	<tr class="th">
		<td width="5%">Sr. No.</td>
		<td width="10%">CNUM</td>
		<td width="15%">Name</td>
		<td width="10%">Roll No.</td>
		<?php
										if(!isset($_SESSION)){
									session_start();
								}

			include 'db/db_connect.php';
				ini_set('max_execution_time', 2000);
				$sql = "SELECT DISTINCT subjectname 
						FROM tblexamschedule es
						INNER JOIN tblpapermaster pm ON pm.paperid = es.paperid
						INNER JOIN tblsubjectmaster sm ON sm.subjectid = pm.subjectid
						WHERE ExamID = " . $_GET["ExamID"] . " AND students <> 0 
						ORDER BY examdate,examslot";
				//echo $sql . "<br/> "; 
				//die;
				$result = $mysqli->query( $sql );
				$num_results = $result->num_rows;
				$i = 0;
				if( $num_results ){
					while( $row = $result->fetch_assoc() ){
						extract($row);
						//echo $ResultSubject . " , " ;
						echo "<td width='7%'>$subjectname</td> ";
						$i = $i + 1;
					}
					$_SESSION["subcount"] = $i;
				}
?>
	</tr>
	<?php
		$_SESSION["subcount"] = $i;
		$sublist = '';
		$j = 1;
		while ($i>0){
			if($sublist == '')
				$sublist = "Subject" . $j;
			else
				$sublist = $sublist . "," . "Subject" . $j;
			$j = $j + 1;
			$i = $i - 1;
		}
		include 'db/db_connect.php';
		$sql = "SELECT CNUM,StdName,RollNo," . $sublist . " FROM tbloiresults
				WHERE ExamID = " . $_GET["ExamID"] . " and 
				trim(CNUM) = '" . $_SESSION["loginid"] . "'";
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
					echo "<td>{$CNUM} </td>";
					echo "<td>{$StdName} </td>";
					echo "<td>{$RollNo} </td>";
					if(isset($Subject1))
						echo "<td>{$Subject1} </td>";
					if(isset($Subject2))
						echo "<td>{$Subject2} </td>";
					if(isset($Subject3))
						echo "<td>{$Subject3} </td>";
					if(isset($Subject4))
						echo "<td>{$Subject4} </td>";
					if(isset($Subject5))
						echo "<td>{$Subject5} </td>";
					if(isset($Subject6))
						echo "<td>{$Subject6} </td>";
					if(isset($Subject7))
						echo "<td>{$Subject7} </td>";
					if(isset($Subject8))
						echo "<td>{$Subject8} </td>";
					if(isset($Subject9))
						echo "<td>{$Subject9} </td>";
					if(isset($Subject10))
						echo "<td>{$Subject10} </td>";
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
