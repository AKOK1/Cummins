<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Show Fee</title>
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
			
?>
	<br/>
	<center><img class="center" alt="logo" src="images/logo.png"></center>
	<br/>
	<table width="90%" border="0" cellpadding="5" cellspacing="0" class="fix-table" style="margin-left: 5%;">

		<TR>
		<?php
			include 'db/db_connect.php';
			$sql = "SELECT count(DISTINCT(AdmYear)) as AdmYearCnt FROM tblseattypefeedetail WHERE CalYear = '" . $_GET['CalYear']. "' AND EduYear = '" . $_GET['EduYear'] . "' ORDER BY AdmYear DESC" ;
			$result1 = $mysqli->query( $sql );
			while ( $row = $result1->fetch_assoc() ) {
				extract($row);
				$AdmCount = $AdmYearCnt * 5 + 1;
				echo "<td colspan='" . $AdmCount . " ' class='th-heading'><center><h2>Fee's For : " . $_GET['EduYear'] . " " . $_GET['CalYear'] ." </h2></center></td>";
			}
		?>

		</TR>
		<tr class="th">
			<td rowspan="2"><?php echo $_GET['EduYear']; ?> <?php echo $_GET['CalYear']; ?></td>
			<?php
				include 'db/db_connect.php';
				$sql = "SELECT DISTINCT(AdmYear) as AdmYear FROM tblseattypefeedetail WHERE CalYear = '" . $_GET['CalYear']. "' AND EduYear = '" . $_GET['EduYear'] . "' ORDER BY AdmYear DESC" ;
				$result1 = $mysqli->query( $sql );
				while ( $row = $result1->fetch_assoc() ) {
					extract($row);
					$sql = "SELECT DISTINCT(AdmYear) as AdmYear FROM tblseattypefeedetail WHERE CalYear = '" . $_GET['CalYear']. "' AND EduYear = '" . $_GET['EduYear'] . "' ORDER BY AdmYear DESC" ;
					$result1 = $mysqli->query( $sql );
					while ( $row = $result1->fetch_assoc() ) {
						extract($row);
						echo "<td colspan='5' style='text-align:center' >Admission Year - {$AdmYear}</td>";
							}
				}
			?>
		</tr>
		
		<tr class="th">
			<?php
				include 'db/db_connect.php';
				$sql = "SELECT DISTINCT(AdmYear) as AdmYear FROM tblseattypefeedetail WHERE CalYear = '" . $_GET['CalYear']. "' AND EduYear = '" . $_GET['EduYear'] . "' ORDER BY AdmYear DESC" ;
				$result1 = $mysqli->query( $sql );
				while ( $row = $result1->fetch_assoc() ) {
					extract($row);
					$sql = "SELECT DISTINCT(AdmYear) as AdmYear FROM tblseattypefeedetail WHERE CalYear = '" . $_GET['CalYear']. "' AND EduYear = '" . $_GET['EduYear'] . "' ORDER BY AdmYear DESC" ;
					$result1 = $mysqli->query( $sql );
					while ( $row = $result1->fetch_assoc() ) {
						extract($row);
						echo "<td>Open</td>";
						echo "<td>SC</td>";
						echo "<td>ST/VJ/NT/SBC/TFWS</td>";
						echo "<td>OBC</td>";
						echo "<td>J&K/GOI</td>";
						}
				}
			?>
		</tr>

		<tr>
			<?php
				include 'db/db_connect.php';
				$sql = "SELECT FeeTypeId, FeeType FROM tblfeetype " ;
				$result = $mysqli->query( $sql );
				while ( $row = $result->fetch_assoc() ) {
					extract($row);
					echo "<td>{$FeeType}</td>";
					$sql = "SELECT DISTINCT(AdmYear) as AdmYear FROM tblseattypefeedetail WHERE CalYear = '" . $_GET['CalYear']. "' AND EduYear = '" . $_GET['EduYear'] . "' ORDER BY AdmYear DESC" ;
					$result1 = $mysqli->query( $sql );
					while ( $row1 = $result1->fetch_assoc() ) {
						extract($row1);
						$i = 0;
						// Open
						$i = $i + 1;
						$sql = "SELECT Fee FROM tblseattypefeedetail 
								WHERE SeatTypeId = ". $i . " and FeeTypeId = " . $FeeTypeId . " and AdmYear = '{$AdmYear}' 
								AND CalYear = '" . $_GET['CalYear']. "' AND EduYear = '" . $_GET['EduYear'] . "'" ;
						$result2 = $mysqli->query( $sql );
						if ($result2->num_rows){
							while ( $row2 = $result2->fetch_assoc() ) {
								extract($row2);
								echo "<td style='text-align:right'>{$Fee}</td>";
							}
						}
						else {
							echo "<td style='text-align:right'>0</td>";
						}
						
						// SC
						$i = $i + 1;
						$sql = "SELECT Fee FROM tblseattypefeedetail 
								WHERE SeatTypeId = ". $i . " and FeeTypeId = " . $FeeTypeId . " and AdmYear = '{$AdmYear}' 
								AND CalYear = '" . $_GET['CalYear']. "' AND EduYear = '" . $_GET['EduYear'] . "'" ;
						$result2 = $mysqli->query( $sql );
						if ($result2->num_rows){
							while ( $row2 = $result2->fetch_assoc() ) {
								extract($row2);
								echo "<td style='text-align:right'>{$Fee}</td>";
							}
						}
						else {
							echo "<td style='text-align:right'>0</td>";
						}
						
						//ST
						$i = $i + 1;
						$sql = "SELECT Fee FROM tblseattypefeedetail 
								WHERE SeatTypeId = ". $i . " and FeeTypeId = " . $FeeTypeId . " and AdmYear = '{$AdmYear}' 
								AND CalYear = '" . $_GET['CalYear']. "' AND EduYear = '" . $_GET['EduYear'] . "'" ;
						$result2 = $mysqli->query( $sql );
						if ($result2->num_rows){
							while ( $row2 = $result2->fetch_assoc() ) {
								extract($row2);
								echo "<td style='text-align:right'>{$Fee}</td>";
							}
						}
						else {
							echo "<td style='text-align:right'>0</td>";
						}
						
						// OBC
						$i = $i + 1;
						$sql = "SELECT Fee FROM tblseattypefeedetail 
								WHERE SeatTypeId = ". $i . " and FeeTypeId = " . $FeeTypeId . " and AdmYear = '{$AdmYear}' 
								AND CalYear = '" . $_GET['CalYear']. "' AND EduYear = '" . $_GET['EduYear'] . "'" ;
						$result2 = $mysqli->query( $sql );
						if ($result2->num_rows){
							while ( $row2 = $result2->fetch_assoc() ) {
								extract($row2);
								echo "<td style='text-align:right'>{$Fee}</td>";
							}
						}
						else {
							echo "<td style='text-align:right'>0</td>";
						}
						
						// GOI
						$i = $i + 1;
						$sql = "SELECT Fee FROM tblseattypefeedetail 
								WHERE SeatTypeId = ". $i . " and FeeTypeId = " . $FeeTypeId . " and AdmYear = '{$AdmYear}' 
								AND CalYear = '" . $_GET['CalYear']. "' AND EduYear = '" . $_GET['EduYear'] . "'" ;
						$result2 = $mysqli->query( $sql );
						if ($result2->num_rows){
							while ( $row2 = $result2->fetch_assoc() ) {
								extract($row2);
								echo "<td style='text-align:right'>{$Fee}</td>";
							}
						}
						else {
							echo "<td style='text-align:right'>0</td>";
						}
					}
					echo "</tr>";
				}
			?>

		<tr>
			<?php
				echo "<td><b>Total</b></td>";
				$sql = "SELECT DISTINCT(AdmYear) as AdmYear FROM tblseattypefeedetail WHERE CalYear = '" . $_GET['CalYear']. "' AND EduYear = '" . $_GET['EduYear'] . "' ORDER BY AdmYear DESC" ;
				$result1 = $mysqli->query( $sql );
				while ( $row1 = $result1->fetch_assoc() ) {
					extract($row1);
					$i = 0;
					// Open
					$i = $i + 1;
					$sql = "SELECT Coalesce(Sum(Fee), 0) as Fee FROM tblseattypefeedetail 
							WHERE SeatTypeId = ". $i . " and AdmYear = '{$AdmYear}' 
							AND CalYear = '" . $_GET['CalYear']. "' AND EduYear = '" . $_GET['EduYear'] . "'" ;
					$result2 = $mysqli->query( $sql );
					while ( $row2 = $result2->fetch_assoc() ) {
						extract($row2);
						echo "<td style='text-align:right'><b>{$Fee}</b></td>";
					}
					
					// SC
					$i = $i + 1;
					$sql = "SELECT Coalesce(Sum(Fee), 0) as Fee FROM tblseattypefeedetail 
							WHERE SeatTypeId = ". $i . " and AdmYear = '{$AdmYear}' 
							AND CalYear = '" . $_GET['CalYear']. "' AND EduYear = '" . $_GET['EduYear'] . "'" ;
					$result2 = $mysqli->query( $sql );
					while ( $row2 = $result2->fetch_assoc() ) {
						extract($row2);
						echo "<td style='text-align:right'><b>{$Fee}</b></td>";
					}
					
					//ST
					$i = $i + 1;
					$sql = "SELECT Coalesce(Sum(Fee), 0) as Fee FROM tblseattypefeedetail 
							WHERE SeatTypeId = ". $i . " and AdmYear = '{$AdmYear}' 
							AND CalYear = '" . $_GET['CalYear']. "' AND EduYear = '" . $_GET['EduYear'] . "'" ;
					$result2 = $mysqli->query( $sql );
					while ( $row2 = $result2->fetch_assoc() ) {
						extract($row2);
						echo "<td style='text-align:right'><b>{$Fee}</b></td>";
					}
					
					// OBC
					$i = $i + 1;
					$sql = "SELECT Coalesce(Sum(Fee), 0) as Fee FROM tblseattypefeedetail 
							WHERE SeatTypeId = ". $i . " and AdmYear = '{$AdmYear}' 
							AND CalYear = '" . $_GET['CalYear']. "' AND EduYear = '" . $_GET['EduYear'] . "'" ;
					$result2 = $mysqli->query( $sql );
					while ( $row2 = $result2->fetch_assoc() ) {
						extract($row2);
						echo "<td style='text-align:right'><b>{$Fee}</b></td>";
					}
					
					// GOI
					$i = $i + 1;
					$sql = "SELECT Coalesce(Sum(Fee), 0) as Fee FROM tblseattypefeedetail 
							WHERE SeatTypeId = ". $i . " and AdmYear = '{$AdmYear}' 
							AND CalYear = '" . $_GET['CalYear']. "' AND EduYear = '" . $_GET['EduYear'] . "'" ;
					$result2 = $mysqli->query( $sql );
					while ( $row2 = $result2->fetch_assoc() ) {
						extract($row2);
						echo "<td style='text-align:right'><b>{$Fee}</b></td>";
					}
				}
				echo "</tr>";
			?>
		</tr>
		
		<tr><td colspan='8'>&nbsp;</td></tr>
		<tr><td colspan='8' >The rules about fees may be changed as per the directives of competent Authority from time to time and also applicable to all the students.</td></tr>
		<tr>&nbsp;</tr>
		<tr><td colspan='8'>Fees may be paid by the <b>Demand Draft</b> of above Fees in favour of <b>"Principal, Cummins College of Engineering for Women, Pune"</b></td>		</tr>
		<tr>
			<td colspan='8'>Date of Admission :-  <b>17th July, 2017.</b></td>
			<td colspan='4' style='text-align:center'><b>Director</b></td>
		</tr>
		<tr>
			<td colspan='8'>&nbsp;</td>
			<td colspan='4' style='text-align:center'><b>MKSSS'S Cummins College of Engineering</b></td>
		</tr>
		<tr>
			<td colspan='8'>&nbsp;</td>
			<td colspan='4' style='text-align:center'><b>Karvenagar, Pune - 411052</b></td>
		</tr>

		<tr><td colspan='8'>&nbsp;</td></tr>
		<tr><td colspan='8'>Important : - Without Valid Income Certificate or Form 16 ( as on 31st March, 2017 ), the benefit of the fees concession will not be considered.</td></tr>
		
	</table>
  

</body>
</html>
