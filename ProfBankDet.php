<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Bank Details</title>
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
	<center>
	<table border="0" cellpadding="5" cellspacing="0" class="fix-table">
		<TR>
			<td colspan='8' class='th-heading'><center><h2>Bank Details</center></td>
		</TR>
		<TR>
			<td colspan='8' class='th-heading'>
			Department: <?php echo $_GET['dept'];?>&nbsp;
			</td>
		</TR>
		<tr class="th">
			<td>Name</td>
			<td>Dept.</td>
			<td>Bank Name</td>
			<td>Branch Name</td>
			<td>Account Number</td>
			<td>IFSC Code</td>
			<td>MICR</td>
			<td>PF Number</td>
		</tr>	
		<?php
		if(!isset($_SESSION)){
			session_start();
		} 
			include 'db/db_connect.php';
			
					$query = "SELECT bank_name,branch_name,acc_no,IFSC_code,MICR_no,PF_no,
								Concat(tu.FirstName, ' ' ,tu.LastName) as userName,tu.Department
								FROM profbankdet PD
								 INNER JOIN tbluser tu ON tu.userID = PD.profId
								 where tu.Department = '" . $_GET['dept'] . "' and coalesce(bank_name,'') <> ''";
				//echo $query;
				if($_GET['dept'] == 'All') {
					 $query = "SELECT bank_name,branch_name,acc_no,IFSC_code,MICR_no,PF_no,
								Concat(tu.FirstName, ' ' ,tu.LastName) as userName,tu.Department
								FROM profbankdet PD 
								 INNER JOIN tbluser tu ON tu.userID = PD.profId
								where coalesce(bank_name,'') <> ''";
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
						echo "<td>{$Department} </td>";
						echo "<td>{$bank_name} </td>";
						echo "<td>{$branch_name} </td>";
						echo "<td>{$acc_no} </td>";
						echo "<td>{$IFSC_code} </td>";
						echo "<td>{$MICR_no} </td>";
						echo "<td>{$PF_no} </td>";
						echo "</TR>";
					}
				}					
				//disconnect from database	
				$result->free();
				$mysqli->close();
		?>
    </table>
	</center>
</body>
</html>