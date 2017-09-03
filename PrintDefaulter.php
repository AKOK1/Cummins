<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $_GET['ptype']; ?> - DEFAULTER REPORT</title>
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

	<tr><td colspan='8' class='th-heading'><center><h2>Defaulter Report for  <?php echo $_GET['year'] . " - " . $_GET['deptname'] . " - Sem " . $_GET['sem'] . " Div - " . $_GET['divn'] . ", " . $_GET['sdate'] . " to " . $_GET['edate']; ?> 
			<?php
			echo "<br/><br/>";
			if($_GET['ptype'] == 'TH')
				echo 'Theory';
			else if($_GET['ptype'] == 'PR')
				echo 'Practical';
			else
				echo 'Tutorial';
			
		?>
	</h2></center></td></tr>
	
	<tr>
		<td><table width="100%" cellpadding="5" cellspacing="0" class="fix-table" >
		<tr class="th">
			<td >Sr No</td>
			<td >Roll Number</td>
			<td >Name of Student</td>
			<td>Status</td>
			<?php
			
				include 'db/db_connect.php';
				$sql = "SELECT DISTINCT ys.YSID, ys.PaperID, ys.SubjectName, ysp.ProfId ,ysp.btchid,BatchName
						FROM vwhodsubjectsselected ys
						INNER JOIN tblyearstructprof ysp ON ysp.YSID = ys.YSID
						INNER JOIN tblbatchmaster bm ON ysp.btchid = bm.BtchId
						inner join tblcuryear cy on ys.eduyearfrom = cy.EduYearFrom
						WHERE ys.Sem = " . $_GET['sem'] . " AND ys.DeptID = " . $_GET['dept'] . " AND ys.papertype = '" . $_GET['ptype'] . "'
						and EnggYear = '" . str_replace('.','',$_GET['year']) . "'  AND bm.divn =  '" . $_GET['divn'] . "'
						ORDER BY ys.YSID,ysp.btchid ";
				//echo $sql;
				//and Iselective = 0
				$j = 0;
				$result = $mysqli->query( $sql );
				$num_results = $result->num_rows;
				if( $num_results ){
					while( $row = $result->fetch_assoc() ){
						extract($row);
						$ArrYSID[$j] = $YSID;
						$ArrPaperID[$j] = $PaperID;
						$ArrProfId[$j] = $ProfId;
						$Arrbtchid[$j] = $btchid;
						$j = $j +1;
						echo "<td >{$SubjectName} - {$BatchName}</td>";
					}
				}
				echo "<td>Mobile</td>"; 
				echo "<td>Address</td>"; 
				echo "</tr>";
				echo "<tr>";
				echo "<td ></td>";
				echo "<td ></td>";
				echo "<td >Total No. of";
						if($_GET['ptype'] == 'TH')
							echo ' Lectures';
						else if($_GET['ptype'] == 'PR')
							echo ' Practicals';
						else
						echo ' Tutorials';
				echo "</td>";
				echo "<td ></td>";
				
				for ($z = 0 ; $z <= count($ArrYSID) - 1; $z++) {
					include 'db/db_connect.php';
					$sql = "Select count(*) as Cnt 
					FROM tblattmaster 
					WHERE YSID = " . $ArrYSID[$z] . 
					" and attdate between STR_TO_DATE('" . $_GET['sdate'] . "' ,'%d-%M-%Y') and  STR_TO_DATE('" . $_GET['edate'] ."' ,'%d-%M-%Y')
					and batchid in (SELECT btchid FROM tblbatchmaster 
					WHERE  DeptID = " . $_GET['dept'] . " AND papertype = '" . $_GET['ptype'] . "' 
					AND eduyear = '" . str_replace('.','',$_GET['year']) . "'  AND divn =  '" . $_GET['divn'] . "')";

					$sql = "SELECT COUNT(distinct AM.attmasterid) as Cnt
					FROM tblattendance A 
					INNER JOIN tblattmaster AM ON A.attmasterid = AM.attmasterid 
					AND AM.BatchId = " . $Arrbtchid[$z] . "					
					WHERE A.YSID = " . $ArrYSID[$z] . " 
					AND (CAST(AM.attdate AS DATE) BETWEEN STR_TO_DATE('" . $_GET['sdate'] . "' ,'%d-%M-%Y') AND 
					STR_TO_DATE('" . $_GET['edate'] ."' ,'%d-%M-%Y') )";
					//ORDER BY LEFT(CONVERT(AM.attdate, CHAR(10)), 10), starttime, endtime
					//echo $sql . "<br/>";
					$result = $mysqli->query( $sql );
					$num_results = $result->num_rows;
					if( $num_results ){
						while( $row = $result->fetch_assoc() ){
							extract($row);
							echo "<td >{$Cnt}</td>";
							$ArrLecCnt[$z] = $Cnt;
						}
					}
				}
				echo "<td ></td>";
				echo "<td ></td>";
				echo "</tr>";

				echo "<tr>";
				echo "<td ></td>";
				echo "<td ></td>";
				echo "<td >Last Attendance Filled</td>";
				echo "<td ></td>";
				for ($z = 0 ; $z <= count($ArrYSID) - 1; $z++) {
					include 'db/db_connect.php';
					$sql = "Select DATE_FORMAT(max(attdate), '%d-%b-%Y') as AttDate FROM tblattmaster  WHERE YSID = " . $ArrYSID[$z] . 
					" and attdate between STR_TO_DATE('" . $_GET['sdate'] . "' ,'%d-%M-%Y') and  STR_TO_DATE('" . $_GET['edate'] ."' ,'%d-%M-%Y')
					and batchid in (SELECT btchid FROM tblbatchmaster 
					WHERE  DeptID = " . $_GET['dept'] . " AND papertype = '" . $_GET['ptype'] . "'  
					AND eduyear = '" . str_replace('.','',$_GET['year']) . "'  AND divn =  '" . $_GET['divn'] . "')
					order by YSID,batchid";

					$result = $mysqli->query( $sql );
					$num_results = $result->num_rows;
					if( $num_results ){
						while( $row = $result->fetch_assoc() ){
							extract($row);
							echo "<td >{$AttDate}</td>";
						}
					}
				}
				echo "<td ></td>";
				echo "<td ></td>";
				echo "</tr>";

				echo "<tr>";
				echo "<td ></td>";
				echo "<td ></td>";
				echo "<td >Instructor's Name</td>";
				echo "<td ></td>";
				for ($z = 0 ; $z <= count($ArrYSID) - 1; $z++) {
					include 'db/db_connect.php';
					$sql = "Select Concat(Firstname , ' ', Lastname) as ProfName FROM tbluser WHERE userID = " . $ArrProfId[$z];
					$result = $mysqli->query( $sql );
					$num_results = $result->num_rows;
					if( $num_results ){
						while( $row = $result->fetch_assoc() ){
							extract($row);
							echo "<td >{$ProfName}</td>";
						}
					}
				}
				echo "<td ></td>";
				echo "<td ></td>";
				echo "</tr>";
				
				$SrNoCnt = 1;
				include 'db/db_connect.php';
				if($_GET['dept'] <> 1){
				$sql = "SELECT S.StdId, RollNo, CONCAT(FirstName, ' ', FatherName,  ' ', Surname) AS StdName,coalesce(stdstatus,'') as stdstatus,
						mobno,CONCAT(COALESCE(Taluka,''),' ', COALESCE(District,''),' ',COALESCE(State,'')) AS stdaddress
						FROM tblstdadm SA 
						INNER JOIN tblstudent S ON S.StdId = SA.StdID
						INNER JOIN tbldepartmentmaster DM ON SA.Dept = DM.DeptID
						inner join tblcuryearauto cy on cy.EduYearFrom = SA.EduYearFrom
						WHERE SA.AdmConf = 1 and SA.stdstatus = 'R'
						and DM.DeptID = " . $_GET['dept'] . " and Year = '" . $_GET['year'] . "'
						and SA.`div` = '" . $_GET['divn'] . "'
						ORDER BY RollNo ";
				}
				else{
				$sql = "SELECT S.StdId, RollNo, CONCAT(FirstName, ' ', FatherName,  ' ', Surname) AS StdName,coalesce(stdstatus,'') as stdstatus,
						mobno,CONCAT(COALESCE(Taluka,''),' ', COALESCE(District,''),' ',COALESCE(State,'')) AS stdaddress
						FROM tblstdadm SA 
						INNER JOIN tblstudent S ON S.StdId = SA.StdID
						INNER JOIN tbldepartmentmaster DM ON S.Dept = DM.DeptName
						inner join tblcuryearauto cy on cy.EduYearFrom = SA.EduYearFrom
						WHERE SA.AdmConf = 1 and SA.stdstatus = 'R'
						and DM.DeptName = '" . $_GET['deptname'] . "' and Year = '" . $_GET['year'] . "'
						and SA.`div` = '" . $_GET['divn'] . "'
						ORDER BY RollNo ";
				}
				//echo $sql;
				$result = $mysqli->query( $sql );
				$num_results = $result->num_rows;
				if( $num_results ){
					while( $row = $result->fetch_assoc() ){
						extract($row);
						echo "<tr>";
						echo "<td >" . $SrNoCnt . "</td>";
						echo "<td >{$RollNo}</td>";
						echo "<td >{$StdName}</td>";
						echo "<td >{$stdstatus}</td>";						
						$SelStdId = $StdId;

						for ($z = 0 ; $z <= count($ArrYSID) - 1; $z++) {
							include 'db/db_connect.php';
							if  ($ArrLecCnt[$z] == 0 ) {
								$sql = "Select 0 as AttCnt";
							}
							else {
								$sql = "Select cast(count(*) * 100 / " . $ArrLecCnt[$z] . " as UNSIGNED) as AttCnt 
								FROM tblattendance att
								inner join tblattmaster am on am.attmasterid = att.attmasterid
								WHERE am.batchid = " . $Arrbtchid[$z] . " and 
										att.YSID = " . $ArrYSID[$z]  . " and StdId =  " . $SelStdId . " and COALESCE(Attendance, 0) =  1 
									and att.attdate between STR_TO_DATE('" . $_GET['sdate'] . "' ,'%d-%M-%Y') and  STR_TO_DATE('" . $_GET['edate'] ."' ,'%d-%M-%Y')";


							//AND attid IN (
							//SELECT MAX(attid) 
							//FROM tblattendance att 
							//INNER JOIN tblattmaster am ON am.attmasterid = att.attmasterid 
							//WHERE am.batchid = " . $Arrbtchid[$z] . " AND att.YSID = " . $ArrYSID[$z]  . " 
							//AND StdId = " . $SelStdId . "
							//AND att.attdate BETWEEN STR_TO_DATE('" . $_GET['sdate'] . "' ,'%d-%M-%Y') AND STR_TO_DATE('" . $_GET['edate'] ."' ,'%d-%M-%Y')
							//GROUP BY att.attmasterid 
							//)
									


									//echo $sql . "<br/>";
									//die;
							}
							$result1 = $mysqli->query( $sql );
							$num_results1 = $result1->num_rows;
							if( $num_results1 ){
								while( $row = $result1->fetch_assoc() ){
									extract($row);
									echo "<td >{$AttCnt}</td>";
								}
							}
						}
						$SrNoCnt = $SrNoCnt + 1;
						echo "<td>{$mobno}</td>";
						echo "<td>{$stdaddress}</td>";
						echo "</tr>";
					}
				}
				echo "</tr>";
			?>
	  
    </table></td>
  </tr>
</table>
</body>
</html>
