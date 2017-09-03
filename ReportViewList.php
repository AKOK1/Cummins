<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>SEATING ARRANGEMENT</title>
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
	
		include 'db/db_connect.php';

		$reportId = $_GET['reportId'];
					
		$query="SELECT reportId, reportTitle FROM tblreport WHERE  reportId = " . $_GET['reportId'];
		//echo $query;
		
		$getif=mysqli_query($mysqli,$query);
		while($row=mysqli_fetch_array($getif)) {
			$reportTitle=$row['reportTitle'];
		}
		
	?>

	<br/><br/><br/>
	<center><img class="center" alt="logo" src="images/logo.png"></center>
	<br/>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td><table width="100%" cellpadding="5" cellspacing="0" class="fix-table" >
      <tr>
        <td colspan="7">
			<h1><center><?php echo $reportTitle; ?>
			</center>
			</h1>
		</td>
      </tr>
			<?php
					include 'db/db_connect.php';
					$query="SELECT reportsql,colwidth FROM tblreport WHERE  reportId = " . $_GET['reportId'];
					
					//echo $query;
					$result1 = $mysqli->query( $query );
					$num_results1 = $result->num_rows;
					if( $num_results ){
						while( $row = $result1->fetch_assoc() ){
							extract($row);
							$lcolwidth=explode(',', $row['colwidth']);//what will do here
							$reportsql=$row['reportsql'];
						}
					}
					
					$result = $mysqli->query( $reportsql );
					$num_results = $result->num_rows;
					$finfo = mysqli_fetch_fields($result);
					$i=0;
					foreach ($finfo as $val) {
							echo "<th style='width:$lcolwidth[$i]px'><strong>$val->name</strong></th>";
							  $i = $i + 1;
						}
					
					while ($row=mysqli_fetch_row($result)) {
						echo "<tr>";
						$i=0;
						foreach($row as $_column) {
							echo "<td style='width:$lcolwidth[$i]px'>{$_column}</td>";
							$i= $i + 1;
						}
						echo "</tr>";
					 }


					echo "</tr>";
					?>
			
			</table>
		
		</div>
	</div>

</form>
	  </table>
	</td>
  </tr>
</table>
</body>
</html>
