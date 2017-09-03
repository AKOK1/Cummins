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
	<tr><td colspan='8' class='th-heading'><center><h2>Attendance Report</h2></center></td></tr>
	<!-- <?php echo $_GET['MonthName'] . " - " . $_GET['SelYear']; ?>  -->
	<tr><td colspan='8' class='th-heading'><center><h3><?php echo substr($_GET['SubName'],0,strlen($_GET['SubName']) - strpos(strrev($_GET['SubName']),' ')); ?> </h3></center></td></tr>
	
	<tr>
		<td><table width="100%" cellpadding="5" cellspacing="0" class="fix-table" >
		<tr class="th">
			<td >Roll No</td>
			<td >Name</td>
			<td>Status</td>
			<?php
				include 'db/db_connect.php';
				$sql = "SELECT DISTINCT LEFT(convert(AM.attdate, char(10)), 10) as AttDate , starttime as AttStartTime, endtime AS AttEndTime
						FROM tblattendance A 
						Inner join tblattmaster AM on A.attmasterid = AM.attmasterid
						AND AM.BatchId = " . strrev(substr(strrev($_GET['SubName']),0,strpos(strrev($_GET['SubName']),' '))) . "
						WHERE A.YSID = " . $_GET['ysid'] . " AND (cast(AM.attdate as date) between '" . date("Y-m-d", strtotime($_GET["startdate"])) . "' and '" . 
						date("Y-m-d", strtotime($_GET["enddate"])). "' )
						ORDER BY LEFT(convert(AM.attdate, char(10)), 10), starttime, endtime ";
				//echo $sql;
				//die;
				$j = 0;
				$result = $mysqli->query( $sql );
				$num_results = $result->num_rows;
				if( $num_results ){
					while( $row = $result->fetch_assoc() ){
						extract($row);
						$ArrAttDate[$j] = $AttDate;
						$ArrAttStartTime[$j] = $AttStartTime;
						$ArrAttEndTime[$j] = $AttEndTime;
						$j = $j +1;
						//echo "<td >{$AttDate}</td>";
						echo "<td >" . date('d-M-Y',strtotime($AttDate)) . "</td>";
					}
				}
				echo "<td >Total</td>";
				echo "<td >%</td>";
				echo "</tr>";
				echo "<tr>";
				echo "<td >";
				echo "<td >";
				echo "<td >";
				for ($z = 0 ; $z <= count($ArrAttDate) - 1; $z++) {
					echo "<td >{$ArrAttStartTime[$z]} - {$ArrAttEndTime[$z]}</td>";
				}
				echo "<td >" . count($ArrAttDate) . "</td>";
				$FULLTOT = count($ArrAttDate);
			?>
		</tr>

		<?php
			include 'db/db_connect.php';
			$sql = " SELECT S.StdId, SA.RollNo, CONCAT(RTRIM(SurName), ' ', RTRIM(FirstName)) AS StdName,coalesce(stdstatus,'') as stdstatus
					FROM tblyearstructstd Y
					INNER JOIN tblstdadm SA ON Y.StdAdmID = SA.StdAdmID
					INNER JOIN tblstudent S ON SA.StdId = S.StdId
					inner join tblbatchmaster bm on bm.btchid = Y.btchid 
					and bm.batchname = SUBSTRING('" . $_GET['SubName'] . "',LOCATE('Batch ', ('" . $_GET['SubName'] . "'))+6,
						LENGTH('" . $_GET['SubName'] . "') - LOCATE('Batch ','" . $_GET['SubName'] . "') - LOCATE(' ',REVERSE('" . $_GET['SubName'] . "')) - 5)
					WHERE YSID = " . $_GET['ysid'] . "
					ORDER BY RollNo ";
			//echo $sql;
			$result = $mysqli->query( $sql );
			echo $mysqli->error;
			$num_results = $result->num_rows;

			if( $num_results ){
				while( $row = $result->fetch_assoc() ){

					extract($row);
					echo "<tr>";
					echo "<td >{$RollNo}</td>";
					echo "<td >{$StdName}</td>";
					echo "<td >{$stdstatus}</td>";
					$Tot = 0 ;
					$p = 0 ;
					
					for ($z = 0 ; $z <= count($ArrAttDate) - 1; $z++) {
						$sqlM = " SELECT CASE COALESCE(Attendance, 0) WHEN 0 THEN 'A' ELSE 'P' END AS Attendance 
								FROM tblattendance A
								Inner join tblattmaster AM on A.attmasterid = AM.attmasterid
								AND AM.BatchId = " . strrev(substr(strrev($_GET['SubName']),0,strpos(strrev($_GET['SubName']),' '))) . "
								WHERE A.ysid = " . $_GET['ysid'] . " and StdID = " . $StdId. " 
								and LEFT(convert(AM.attdate, char(10)), 10) = '" .$ArrAttDate[$z] . "'	
								and AM.starttime = '" . $ArrAttStartTime[$z] . "' and AM.endtime = '" . $ArrAttEndTime[$z] . "' 
								ORDER BY StdID  ASC,AttID DESC LIMIT 1";
						//echo $sqlM;
						$resultM = $mysqli->query( $sqlM );
						if( $resultM->num_rows ){
							while( $row = $resultM->fetch_assoc() ){
								extract($row);
								echo "<td >{$Attendance}</td>";
								If ($Attendance == 'P') {
									$Tot += 1 ;
								}
							}
							$p = round((100*$Tot) / $FULLTOT);
						}
						else {
								echo "<td >A</td>";
						}
					}
					echo "<td >{$Tot}</td>";
					echo "<td >{$p}</td>";
					echo "</tr>";
				}
			}	
			//<br/><b>{$TimeFromTo}</b>				
			//disconnect from database
			$result->free();
			$mysqli->close();
		?>	  
		</tr>
	  
	  
	  
    </table></td>
  </tr>
</table>
</body>
</html>
