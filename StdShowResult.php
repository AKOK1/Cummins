<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>RESULTS</title>
<style type="text/css">
body {
	margin-left: 0px;
	margin-top: 0px;
	font-family: Courier, Geneva, sans-serif;
	font-size: 16px;
	
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
	<!-- <center><img class="center" alt="logo" src="images/logo.png"></center> -->
	<br/>
	
	<table width="100%" cellpadding="5" cellspacing="0" class="fix-table" >
      <tr>
		<?php
		// Create connection
		include 'db/db_connect.php';
		
		$query = "SELECT EduYear, SM.UniPRN FROM tblstdresultm SM INNER JOIN tblstudent S ON S.uniprn = SM.UNIPRN Where
				EduYearFr = '" . $_GET['YearFrom'] . "' and EduYearTo = '" . $_GET['YearTo'] . "'
				and StdID = " . $_SESSION["SESSStdId"] . "";
		
		//echo $query;
		$result = $mysqli->query( $query );
		$num_results = $result->num_rows;
		if( $num_results ){
			while( $row = $result->fetch_assoc() ){
				extract($row);
					
				$queryRes = "SELECT REPLACE(Hline1, ' ', '&nbsp') AS ResLine FROM tblstdresultm WHERE UniPRN = '{$UniPRN}' AND EduYear = '{$EduYear}'  
					UNION
					SELECT REPLACE(Hline2, ' ', '&nbsp') AS ResLine FROM tblstdresultm WHERE UniPRN = '{$UniPRN}' AND EduYear = '{$EduYear}'  
					UNION
					SELECT REPLACE(Hline3, ' ', '&nbsp') AS ResLine FROM tblstdresultm WHERE UniPRN = '{$UniPRN}' AND EduYear = '{$EduYear}'  
					UNION
					SELECT REPLACE(TLine, ' ', '&nbsp') AS ResLine FROM tblstdresultm WHERE UniPRN = '{$UniPRN}' AND EduYear = '{$EduYear}'  
					UNION
					SELECT REPLACE(CONCAT(A.ResultLine,' ' ,B.ResultLine), ' ', '&nbsp') AS ResLine FROM
					( SELECT ResultLine, ResOrder FROM tblstdresultm RM INNER JOIN tblstdresult R ON RM.StdResMID = R.StdResMID 
					  WHERE Sem = 1 AND UniPRN = '{$UniPRN}' AND EduYear = '{$EduYear}' ) AS A
					LEFT OUTER JOIN ( SELECT ResultLine, ResOrder FROM tblstdresultm RM INNER JOIN tblstdresult R ON RM.StdResMID = R.StdResMID 
					  WHERE Sem = 2 AND UniPRN = '{$UniPRN}' AND EduYear = '{$EduYear}'  ) B 
					ON A.ResOrder = B.ResOrder
					UNION
					SELECT REPLACE(BLine, ' ', '&nbsp') AS ResLine FROM tblstdresultm 
					WHERE UniPRN = '{$UniPRN}' AND EduYear = '{$EduYear}'    						
				";
				//echo $queryRes;
				$resultRes = $mysqli->query( $queryRes );
				$num_results_Res = $resultRes->num_rows;
				if( $num_results_Res ){
					while( $row = $resultRes->fetch_assoc() ){
						extract($row);
						echo "<TR class='odd gradeX'>";
						echo "<td>{$ResLine}</td>";
						echo "</TR>";
					}
					echo "<TR class='odd gradeX'>";
					echo "<td><center><b>*** This is not an Official Trasncript ***</b></center></td>";
					echo "</TR>";
					echo "<TR class='odd gradeX'>";
					echo "<td></td>";
					echo "</TR>";
					echo "<TR class='odd gradeX'>";
					echo "<td></td>";
					echo "</TR>";
				}
				else {
					echo "<TR class='odd gradeX'>";
					echo "<td>No results to display</td>";
				}
				
			}
		}
		else {
			echo "<TR class='odd gradeX'>";
			echo "<td>No results to display</td>";
		}


		echo "</table>";


		?> 
	  
	  
	  
	  
    </table>
  </tr>
</body>
</html>
