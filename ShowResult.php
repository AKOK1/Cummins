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

		//$query = "SELECT s.UNIPRN as StdAdmID 
		//			FROM tblstdadm sa 
		//			LEFT JOIN tblstudent s ON s.StdID = sa.StdID
		//		where EduYearFrom = '" . $_GET['YearFrom'] . "' and EduYearTo = '" . $_GET['YearTo'] . "'
		//		and sa.StdID = " . $_SESSION["SESSStdId"] . "";
		//echo $query;
		//echo "<br/>";
		//echo "<br/>";
		if($_SESSION["SESSStdId"] > 13953){
			$query = "SELECT distinct StdAdmID 
					FROM tblstdadm SM
					INNER JOIN tblstudent s ON s.stdid = SM.stdid
					INNER JOIN stdqual SQ ON s.stdid = SQ.stdid AND Exam = '10th'
					AND COALESCE(Pmail,'') <> '' AND COALESCE(SQ.name,'') <> '' AND COALESCE(parent_name,'') <> '' 
					WHERE SM.StdID = " . $_SESSION["SESSStdId"] . "
					ORDER BY EduYearTo DESC" ;
		}
		else{
			$query = "SELECT distinct s.UNIPRN as StdAdmID 
					FROM tblstdadm SM
					INNER JOIN tblstudent s ON s.stdid = SM.stdid
					INNER JOIN stdqual SQ ON s.stdid = SQ.stdid AND Exam = '10th'
					AND COALESCE(Pmail,'') <> '' AND COALESCE(SQ.name,'') <> '' AND COALESCE(parent_name,'') <> '' 
					WHERE SM.StdID = " . $_SESSION["SESSStdId"] . "
					ORDER BY EduYearTo DESC" ;
		}
		//echo $query;
		$result = $mysqli->query( $query );
		$num_results = $result->num_rows;
		if( $num_results ){
			while( $row = $result->fetch_assoc() ){
				extract($row);
				if($_SESSION["SESSStdId"] > 13953){

				}
				else{
					$queryRes = "SELECT 1 as ao,1 AS SEQ,StdResMid,REPLACE(Hline1, ' ', '&nbsp') AS ResLine FROM tblstdresultm WHERE EduYearFr = '" . $_GET['YearFrom'] . "' and EduYearTo = '" . $_GET['YearTo'] . "'
						AND LTRIM(RTRIM(UniPRN)) = '{$StdAdmID}'  
						UNION
						SELECT 1 as ao,2 AS SEQ,StdResMid,REPLACE(Hline2, ' ', '&nbsp') AS ResLine FROM tblstdresultm WHERE EduYearFr = '" . $_GET['YearFrom'] . "' and EduYearTo = '" . $_GET['YearTo'] . "'
						AND LTRIM(RTRIM(UniPRN)) = '{$StdAdmID}'  
						UNION
						SELECT 1 as ao,3 AS SEQ,StdResMid,REPLACE(Hline3, ' ', '&nbsp') AS ResLine FROM tblstdresultm WHERE EduYearFr = '" . $_GET['YearFrom'] . "' and EduYearTo = '" . $_GET['YearTo'] . "'
						AND LTRIM(RTRIM(UniPRN)) = '{$StdAdmID}'  
						UNION
						SELECT 1 as ao,4 AS SEQ,StdResMid,REPLACE(TLine, ' ', '&nbsp') AS ResLine FROM tblstdresultm WHERE EduYearFr = '" . $_GET['YearFrom'] . "' and EduYearTo = '" . $_GET['YearTo'] . "'
						AND LTRIM(RTRIM(UniPRN)) = '{$StdAdmID}'  
						UNION
						SELECT coalesce(A.ResOrder,B.ResOrder) as ao,5 AS SEQ,coalesce(B.StdResMid,A.StdResMid) as StdResMid,REPLACE(CONCAT(coalesce(A.ResultLine,''),' ' ,coalesce(B.ResultLine,'')), ' ', '&nbsp') AS ResLine FROM
						( SELECT RM.StdResMid,ResultLine, ResOrder FROM tblstdresultm RM INNER JOIN tblstdresult R ON RM.StdResMID = R.StdResMID 
						  WHERE R.Sem = 1 AND EduYearFr = '" . $_GET['YearFrom'] . "' and EduYearTo = '" . $_GET['YearTo'] . "'
						AND LTRIM(RTRIM(UniPRN)) = '{$StdAdmID}' ) AS A
						LEFT OUTER JOIN ( SELECT RM.StdResMid,ResultLine, ResOrder FROM tblstdresultm RM INNER JOIN tblstdresult R ON RM.StdResMID = R.StdResMID 
						  WHERE R.Sem = 2 AND EduYearFr = '" . $_GET['YearFrom'] . "' and EduYearTo = '" . $_GET['YearTo'] . "'
						AND LTRIM(RTRIM(UniPRN)) = '{$StdAdmID}'  ) B 
						ON coalesce(B.ResOrder,A.ResOrder) = A.ResOrder  AND A.StdResMid = B.StdResMid
						UNION
						SELECT 1 as ao,6 AS SEQ,StdResMid,REPLACE(BLine, ' ', '&nbsp') AS ResLine FROM tblstdresultm 
						WHERE EduYearFr = '" . $_GET['YearFrom'] . "' and EduYearTo = '" . $_GET['YearTo'] . "'
						AND LTRIM(RTRIM(UniPRN)) = '{$StdAdmID}'					
						UNION
						SELECT 1 as ao,1 AS SEQ,StdResMid,REPLACE(Hline1, ' ', '&nbsp') AS ResLine FROM tblstdresultm WHERE EduYearFr = '" . $_GET['YearFrom'] . "' and EduYearTo = '" . $_GET['YearTo'] . "'
						AND LTRIM(RTRIM(UniPRN)) = '{$StdAdmID}'  
						UNION
						SELECT 1 as ao,2 AS SEQ,StdResMid,REPLACE(Hline2, ' ', '&nbsp') AS ResLine FROM tblstdresultm WHERE EduYearFr = '" . $_GET['YearFrom'] . "' and EduYearTo = '" . $_GET['YearTo'] . "'
						AND LTRIM(RTRIM(UniPRN)) = '{$StdAdmID}'  
						UNION
						SELECT 1 as ao,3 AS SEQ,StdResMid,REPLACE(Hline3, ' ', '&nbsp') AS ResLine FROM tblstdresultm WHERE EduYearFr = '" . $_GET['YearFrom'] . "' and EduYearTo = '" . $_GET['YearTo'] . "'
						AND LTRIM(RTRIM(UniPRN)) = '{$StdAdmID}'  
						UNION
						SELECT 1 as ao,4 AS SEQ,StdResMid,REPLACE(TLine, ' ', '&nbsp') AS ResLine FROM tblstdresultm WHERE EduYearFr = '" . $_GET['YearFrom'] . "' and EduYearTo = '" . $_GET['YearTo'] . "'
						AND LTRIM(RTRIM(UniPRN)) = '{$StdAdmID}'  
						UNION
						SELECT coalesce(A.ResOrder,B.ResOrder) as ao,5 AS SEQ,coalesce(A.StdResMid,B.StdResMid) as StdResMid,REPLACE(CONCAT(coalesce(A.ResultLine,'                                                                          '),' ' ,coalesce(B.ResultLine,'')), ' ', '&nbsp') AS ResLine FROM
						( SELECT RM.StdResMid,ResultLine, ResOrder FROM tblstdresultm RM INNER JOIN tblstdresult R ON RM.StdResMID = R.StdResMID 
						  WHERE R.Sem = 1 AND EduYearFr = '" . $_GET['YearFrom'] . "' and EduYearTo = '" . $_GET['YearTo'] . "'
						AND LTRIM(RTRIM(UniPRN)) = '{$StdAdmID}'  order by ResOrder) AS A
						RIGHT OUTER JOIN ( SELECT RM.StdResMid,ResultLine, ResOrder FROM tblstdresultm RM INNER JOIN tblstdresult R ON RM.StdResMID = R.StdResMID 
						  WHERE R.Sem = 2 AND EduYearFr = '" . $_GET['YearFrom'] . "' and EduYearTo = '" . $_GET['YearTo'] . "'
						AND LTRIM(RTRIM(UniPRN)) = '{$StdAdmID}'  order by ResOrder) B 
						ON coalesce(A.ResOrder, B.ResOrder) = B.ResOrder  AND A.StdResMid = B.StdResMid
						UNION
						SELECT 1 as ao,6 AS SEQ,StdResMid,REPLACE(BLine, ' ', '&nbsp') AS ResLine FROM tblstdresultm 
						WHERE EduYearFr = '" . $_GET['YearFrom'] . "' and EduYearTo = '" . $_GET['YearTo'] . "'
						AND LTRIM(RTRIM(UniPRN)) = '{$StdAdmID}'
						ORDER BY StdResMid,SEQ,ao";					
				}

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
				}
				else {
					echo "<TR class='odd gradeX'>";
					echo "<td>No results to display</td>";					
				}
				
			}
		}
		else {

echo "<TR class='odd gradeX'>";
					echo "<td>No results to display.<br/>";
					echo "<br/>Fill-in all the information by clicking 'My Profile'. Click on every tab and fill all the * fields.<br/>";
					echo "<br/>Please go to 'My Numbers' under 'My Profile' tab and check your University PRN (this no. starts with 7 and ends with capital letter. You will find this number on your previous marksheet), and change/edit if required. (This step is mandatory).<br/>";
					echo "<br/>If your University PRN is correct, don't change anything!!!<br/>";
					echo "<br/>For F.E. / direct S.E. admission in 2015, your University PRN will be updated by college.</td>";
		}


		echo "</table>";


		?> 
	  
	  
	  
	  
    </table>
  </tr>
</body>
</html>
