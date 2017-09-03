<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Access List</title>
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
		<?php
					if(isset($_GET['RoleID'])){
						include 'db/db_connect.php';
						$query = "SELECT RoleName FROM tblrolemaster where RoleID = " . $_GET['RoleID'];
						//echo $query;
						$result = $mysqli->query( $query );
						$num_results = $result->num_rows;
						if( $num_results ){
							while( $row = $result->fetch_assoc() ){
								extract($row);
							  echo "<td colspan='7' class='th-heading'><center>Access List - ". $RoleName . "</center></td>";
							}
						}
					}
		?>
	</TR>
	</table>
	<br/><br/>
	
<table width="90%" border="0" cellpadding="5" cellspacing="0" class="fix-table" style="margin-left: 5%;">
	<tr class="th">
		<td width="10%">Sr. No.</td>
		<td width="50%">Screen Name</td>
		<td width="20%">Read Access</td>
		<td width="20%">Write Access</td>
	</tr>
	<?php
					if(isset($_GET['RoleID'])){
						include 'db/db_connect.php';
						$query = "SELECT @a:=@a+1 AS SrNo,RoleID,SM.ScreenID,ScreenName,COALESCE(ReadAccess,0) AS ReadAccess,COALESCE(WriteAccess,0) AS WriteAccess
									FROM (SELECT @a:= 0) AS a , tblscreenmaster SM
									LEFT OUTER JOIN tblrolescreens RS ON RS.ScreenID = SM.ScreenID AND RoleID = " . $_GET['RoleID'] . " where coalesce(Showonscreen,0) = 1
									
									order by SM.ScreenID";
						//echo $query;
//and coalesce(WriteAccess,'No') = 'Yes'
						$result = $mysqli->query( $query );
						$num_results = $result->num_rows;
						if( $num_results ){
							while( $row = $result->fetch_assoc() ){
								extract($row);
							  echo "<TR class='odd gradeX'>";
							  echo "<td>$SrNo</td>";
							  echo "<td>$ScreenName</td>";
							  echo "<td>$ReadAccess</td>";
							  echo "<td>$WriteAccess</td>";
							  echo "</TR>";
							}
						}
						else{
							echo "No records found.";
							echo "<TR class='odd gradeX'>";
							echo "<td>No records found.</td>";
							echo "<td></td>";
							echo "<td></td>";
							echo "<td></td>";
							echo "</TR>";
						}
						echo "</table>";
					}
				?> 

    </table></td>
  </tr>
</table>
</body>
</html>
