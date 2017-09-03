<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Teaching Load REPORT</title>
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
include 'db/db_connect.php';
 if(!isset($_SESSION)){
					session_start();
				}
				$sql = "SELECT DeptID,DeptName 
				FROM tbluser U 
				INNER JOIN tbldepartmentmaster DM on U.Department = DM.DeptName
				where userID =  " . $_SESSION["SESSUserID"] . " and coalesce(teaching,0) = 1";
				//echo $sql;
				$result1 = $mysqli->query( $sql );
				while( $row = $result1->fetch_assoc() ) {
				extract($row);
							$_SESSION["SESSRAUserDept"] = $DeptName;
							$_SESSION["SESSRAUserDeptID"] = $DeptID;
				}
?>
	<br/>
	<center><img class="center" alt="logo" src="images/logo.png"></center>
	<br/>

	<table width="100%" border="0" cellpadding="0" cellspacing="0">

	<tr><td colspan='8' class='th-heading'><center><h2>Teaching Load Distribution of Department of   <?php echo $_SESSION['SESSUserDept'] . " Engineering " ; ?> </h2></center></td></tr>
	
	<tr>
		<td><table width="100%" cellpadding="5" cellspacing="0" class="fix-table" >
		<tr class="th">
			<td rowspan="2">Sr No</td>
			<td rowspan="2" >Name of faculty</td>
			<td rowspan="2" >Year</td>
			<td colspan="4">Teaching Hrs per week</td>
			<td rowspan="2" >Total Hrs per week</td>
			<td rowspan="2" >Signature</td>

		</tr>
		<tr class="th">
			<td >Subject</td>
			<td >Theory</td>
			<td >Practical</td>
			<td >Tutorial</td>
		</tr>
			<?php
				include 'db/db_connect.php';
				$sql1 = " Select userID, concat(FirstName, ' ', LastName) as ProfName
						from tbluser U
						inner join tbldepartmentmaster DM on DM.DeptName = U.Department
						inner join tbldesignationmaster DM2 on DM2.DesigID = U.Designation
						where DM.DeptName = '" . $_SESSION["SESSUserDept"] . "'
						and coalesce(currstatus,0) = 1 and  COALESCE(userprofile,'') = 'Teaching'
						order by desigcadre,LastName ";
						//and userType in ('Faculty', 'DeptCoord', 'Ad-hoc', 'TA', 'HOD')
						$i=0;
						// $sql = " Select userID, concat(FirstName, ' ', LastName) as ProfName
						// from tbluser U
						// inner join tbldepartmentmaster DM on DM.DeptName = U.Department
						// where DM.DeptName = '" . $_SESSION["SESSUserDept"] . "'
						// and userType in ('Faculty', 'DeptCoord', 'Ad-hoc', 'TA', 'HOD')
						// order by LastName ";
				//echo $sql1;
				//die;
				$j = 0;
				$result = $mysqli->query( $sql1 );
				$num_results = $result->num_rows;
				$Totrows1 = $num_results ;
					while( $row = $result->fetch_assoc() ){
						extract($row);
						$SeluserID = $userID;
						$SelProfName = $ProfName;
						$j = $j +1;

						include 'db/db_connect.php';
						$sql = " select distinct EnggYear,
							Substring(SubjectName , 1, 
							Length(SubjectName) - 
							POSITION('-' IN REVERSE(SubjectName))
							)  as SubjectName
						from vwhodsubjectsselected ys
						INNER JOIN tblcuryear cy ON cy.eduyearfrom = ys.eduyearfrom
						INNER JOIN tblyearstructprof ysp ON ysp.YSID = ys.YSID
						where ysp.ProfId = " . $SeluserID . "
						order by EnggYear, SubjectName, papertype ";
						//echo $sql;
						$cnt = 0;
						$result1 = $mysqli->query( $sql );
						$num_results1 = $result1->num_rows;
						$Totrows = $num_results1 ;

						echo "<td rowspan=". $Totrows .">". $j. "</td>";
						echo "<td rowspan=". $Totrows .">". $ProfName. "</td>";

						 //echo "<td rowspan=". $Totrows1 .">". $SelProfName. "</td>";
						 if( $num_results ){
							$resultTot = $mysqli->query( $sql1 );
								$num_resultsTot = $resultTot->num_rows;
								if( $num_resultsTot ){
									while( $rowTot = $resultTot->fetch_assoc() ){
										extract($rowTot);
										$prof="";
										break;
									}
								}
						$Total = 0;

						$i = 0;
						if( $num_results1 ){
							while( $row1 = $result1->fetch_assoc() ){
								extract($row1);
								$i = $i +1 ;
								if ($cnt == 0) {
									$cnt = 1;
								 }
								 Else {
									 // echo "<td ></td>";
									 //echo "<td ></td>";
								}
								echo "<td >{$EnggYear}</td>";
								echo "<td >{$SubjectName}</td>";
								$SelSubjectName = $SubjectName;

								include 'db/db_connect.php';
								$sql = " select sum(Hours) as TotalHours
										from vwhodsubjectsselected ys
										INNER JOIN tblcuryear cy ON cy.eduyearfrom = ys.eduyearfrom
										INNER JOIN tblyearstructprof ysp ON ysp.YSID = ys.YSID
										where ysp.ProfId = " . $SeluserID ;
								$resultTot = $mysqli->query( $sql );
								$num_resultsTot = $resultTot->num_rows;
								if( $num_resultsTot ){
									while( $rowTot = $resultTot->fetch_assoc() ){
										extract($rowTot);
										$Total = $TotalHours;
										$Total1 = "";
										break;
									}
								}
								include 'db/db_connect.php';
								$sql = " select sum(Hours) as ThHours
										from vwhodsubjectsselected ys
										INNER JOIN tblcuryear cy ON cy.eduyearfrom = ys.eduyearfrom
										INNER JOIN tblyearstructprof ysp ON ysp.YSID = ys.YSID
										where ysp.ProfId = " . $SeluserID . " 
										and Substring(SubjectName , 1, 
											Length(SubjectName) - 
											POSITION('-' IN REVERSE(SubjectName))
											) = '" . $SelSubjectName . "' and papertype = 'TH' ";
								$result2 = $mysqli->query( $sql );
								$num_results2 = $result2->num_rows;
								if( $num_results2 ){
									while( $row2 = $result2->fetch_assoc() ){
										extract($row2);
										echo "<td >{$ThHours}</td>";
										break;
									}
								}
								else {
										echo "<td ></td>";
										echo "<td ></td>";
								}

								include 'db/db_connect.php';
								$sql = " select sum(Hours) as PrHours
										from vwhodsubjectsselected ys
										INNER JOIN tblcuryear cy ON cy.eduyearfrom = ys.eduyearfrom
										INNER JOIN tblyearstructprof ysp ON ysp.YSID = ys.YSID
										where ysp.ProfId = " . $SeluserID . "  
										and Substring(SubjectName , 1, 
											Length(SubjectName) - 
											POSITION('-' IN REVERSE(SubjectName))
											) = '" . $SelSubjectName . "' and papertype = 'PR' ";
								
								$result3 = $mysqli->query( $sql );
								$num_results3 = $result3->num_rows;
								if( $num_results3 ){
									while( $row3 = $result3->fetch_assoc() ){
										extract($row3);
										echo "<td >{$PrHours}</td>";
										break;
									}
								}
								else {
										echo "<td ></td>";
										echo "<td ></td>";
								}
								include 'db/db_connect.php';
								$sql = " select sum(Hours) as TTHours
										from vwhodsubjectsselected ys
										INNER JOIN tblcuryear cy ON cy.eduyearfrom = ys.eduyearfrom
										INNER JOIN tblyearstructprof ysp ON ysp.YSID = ys.YSID
										where ysp.ProfId = " . $SeluserID . " 
										and Substring(SubjectName , 1, 
											Length(SubjectName) - 
											POSITION('-' IN REVERSE(SubjectName))
											) = '" . $SelSubjectName . "' and papertype = 'TT' ";
								$result4 = $mysqli->query( $sql );
								$num_results4 = $result4->num_rows;
								if( $num_results4 ){
									while( $row4 = $result4->fetch_assoc() ){
										extract($row4);
										echo "<td >{$TTHours}</td>";
										break;
									}
								}
								else {
									echo "<td ></td>";
									echo "<td ></td>";
								}
								
								if ($i == 1) {
									echo "<td rowspan=". $Totrows .">". $Total. "</td>";
									echo "<td rowspan=". $Totrows .">". $prof. "</td>";
								}
								echo "</tr ><tr>";
							}
						}
						else {
							echo "<td ></td>";
							echo "<td ></td>";
							echo "<td ></td>";
							echo "<td ></td>";
							echo "<td ></td>";
							echo "<td ></td>";
							echo "</tr ><tr>";
						}
					}
				}
				echo "</tr>";
			?>

			
    </table></td>
  </tr>
</table>
</body>
</html>
