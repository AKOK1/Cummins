<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>PRESENT / ABSENT REPORT</title>
<style type="text/css">
body {
	margin-left: 0px;
	margin-top: 0px;
	font-family: Verdana, Geneva, sans-serif;
	font-size: 12px;
	
}
.th-heading {
	font-size:13px;
	font-weight: bold;	
	}
.fix-table, th, td {
	line-height:20px;
	height: 14px;
	border: solid 1px #666 ;
	text-align: left;
	}
.th {
	font-size: 13px;
	font-weight: bold;
	background-color: #CCC;
	}
</style>
</head>

<body>
<?php
	if(!isset($_SESSION)){
		session_start();
	}
?>

	<br/>
	<center><img class="center" alt="logo" src="images/logo.png"></center>
	<br/>

	<table width="100%" border="0" cellpadding="0" cellspacing="0">

	<?php
		include 'db/db_connect.php';
		$query4="SELECT DeptUnivName as DeptName from tbldepartmentmaster where DeptName = '" . $_SESSION["SESSUserDept"] . "'";
		//echo $query4;
		$result4=mysqli_query($mysqli,$query4);
		while($row4=mysqli_fetch_array($result4))
		{
			extract($row4);
		}

	?>
	<tr><td colspan='8' class='th-heading'><center><h2>Department of <?php echo $DeptName; ?></h2></center></td></tr>
	<tr><td colspan='8' class='th-heading'><center><h2>Lecture Plan</h2></center></td></tr>
	<!-- <?php echo $_GET['MonthName'] . " - " . $_GET['SelYear']; ?>  -->
	<tr><td colspan='8' class='th-heading'><center><h3><?php echo substr($_GET['SubName'],0,strlen($_GET['SubName']) - strpos(strrev($_GET['SubName']),' ')); ?> </h3></center></td></tr>
	
	<tr>
		<td><table width="100%" cellpadding="5" cellspacing="0" class="fix-table" >
		<tr class="th">
			<td >Sr No</td>
			<td >Date</td>
			<td >Time</td>
			<td >Plan</td>
			<td >Remarks</td>
			<?php
			
				include 'db/db_connect.php';
				$sql = "SELECT DISTINCT LEFT(convert(AM.attdate, char(10)), 10) as AttDate , starttime as AttStartTime, endtime AS AttEndTime
						FROM tblattendance A 
						Inner join tblattmaster AM on A.attmasterid = AM.attmasterid
						AND AM.BatchId = " . strrev(substr(strrev($_GET['SubName']),0,strpos(strrev($_GET['SubName']),' '))) . "
						WHERE A.YSID = " . $_GET['ysid'] . " AND (cast(AM.attdate as date) between '2016-06-13' and cast(CURRENT_TIMESTAMP as date) )
						ORDER BY LEFT(convert(AM.attdate, char(10)), 10), starttime, endtime ";

				$j = 0;
				$result = $mysqli->query( $sql );
				$num_results = $result->num_rows;
				if( $num_results ){
					while( $row = $result->fetch_assoc() ){
						extract($row);
						$j = $j +1;
						echo "<tr>";
						echo "<td >{$j}</td>";
						echo "<td >" . date('d-M-Y',strtotime($AttDate)) . "</td>";
						echo "<td >{$AttStartTime} -  {$AttEndTime}</td>";

						include 'db/db_connect.php';
						$sqlM = " SELECT lectplan, remark
								from tblattmaster AM 
								WHERE  AM.BatchId = " . strrev(substr(strrev($_GET['SubName']),0,strpos(strrev($_GET['SubName']),' '))) . "
								and LEFT(convert(AM.attdate, char(10)), 10) = '" .$AttDate . "'	
								and AM.starttime = '" . $AttStartTime . "' and AM.endtime = '" . $AttEndTime . "' LIMIT 1 ";
						//echo $sqlM;
						//die;
						
						$resultM = $mysqli->query( $sqlM );
						if( $resultM->num_rows ){
							while( $row = $resultM->fetch_assoc() ){
								extract($row);
								echo "<td >{$lectplan}</td>";
								echo "<td >{$remark}</td>";
							}
						}
						else {
								echo "<td ></td>";
								echo "<td ></td>";
						}
						echo "</tr>";
					}
				}
				die;

			?>

		</tr>
	  
	  
	  
    </table></td>
  </tr>
</table>
</body>
</html>
