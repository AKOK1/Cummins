<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Semester Result</title>
<style type="text/css">
<!-- 	font-family:Verdana, Geneva, sans-serif; -->
body {
	margin-left: 20px;
	margin-top: 0px;
}
</style>
</head>
<body style="font-family:Calibri;font-size:16px">
	<?php
	if(!isset($_SESSION)) {
		session_start();				
	}
	include 'db/db_connect.php';
	if($_GET['year'] = 'FE'){
		$sqlstd = "SELECT DISTINCT CONCAT(Surname,' ', FirstName, ' ', FatherName) AS stdname, MotherName,s.CNUM AS CNUM,sa.ESNum AS examseatno,
				sa.StdId,dm.deptname as dn,CONCAT(gr.AcadYear,'-',SUBSTRING(gr.AcadYear+1,3,2)) AS acadyear,COUNT(gr.PaperID) AS papercount,
				DeptUnivName as deptname,ESEOUTOF,T1OUTOF,T2OUTOF,prortwall
				FROM tblgradereport gr
				INNER JOIN tblstudent s ON s.StdID = gr.StdId
				INNER JOIN tblstdadm sa ON sa.StdId = s.StdId 
				AND sa.EduYearFrom = Substring('" . $_GET['eduyear'] . "',1,4)
				AND Replace(sa.Year,'.','') = '" . $_GET['year'] . "'
				AND sa.Div = '" . $_GET['div'] . "'
				INNER JOIN tblpapermaster pm ON pm.PaperId = gr.PaperId
				INNER JOIN tbldepartmentmaster dm ON dm.DeptId = sa.Dept 
				GROUP BY gr.StdId,gr.AcadYear";			
	}
	else{
		$sqlstd = "SELECT DISTINCT CONCAT(Surname,' ', FirstName, ' ', FatherName) AS stdname, MotherName,s.CNUM AS CNUM,sa.ESNum AS examseatno,
				sa.StdId,dm.deptname as dn,CONCAT(gr.AcadYear,'-',SUBSTRING(gr.AcadYear+1,3,2)) AS acadyear,COUNT(gr.PaperID) AS papercount,
				DeptUnivName as deptname,ESEOUTOF,T1OUTOF,T2OUTOF,prortwall
				FROM tblgradereport gr
				INNER JOIN tblstudent s ON s.StdID = gr.StdId
				INNER JOIN tblstdadm sa ON sa.StdId = s.StdId 
				AND sa.EduYearFrom = Substring('" . $_GET['eduyear'] . "',1,4)
				AND Replace(sa.Year,'.','') = '" . $_GET['year'] . "'
				AND sa.Div = '" . $_GET['div'] . "'
				INNER JOIN tblpapermaster pm ON pm.PaperId = gr.PaperId
				INNER JOIN tbldepartmentmaster dm ON dm.DeptId = sa.Dept and sa.Dept = " . $_GET['deptid'] . "
				GROUP BY gr.StdId,gr.AcadYear";			
	}
				//WHERE gr.StdId = 14156
	//echo $sqlstd;
	$resultstd = $mysqli->query( $sqlstd );
	echo $mysqli->error;
	$num_resultsstd = $resultstd->num_rows;
	//echo $sqlstd;
	if( $num_resultsstd ){
		while( $rowstd = $resultstd->fetch_assoc() ){
			extract($rowstd);
	?>
	<div>
		<table style="width:100%;margin-left:248px;margin-top:208px;margin-bottom:30px">
			<tr>
				<td style="width:10%"><?php echo $stdname;?></td>
				<td></td>
			</tr>
			<tr>
				<td style="width:44%;line-height:20px"><?php echo $MotherName;?></td>
				<td style="width:14%"></td>
			</tr>
			<tr>
				<td style="width:14%;line-height:18px"><?php echo $CNUM;?></td>
				<td style="width:44%;margin-top:-9px"><?php echo $examseatno;?></td>
			</tr>
		</table>
	</div>
	<table style="width:100%;margin-left:48px;margin-top:60px;margin-bottom:20px;">
		<tr>
			<td style="width:12%"><?php echo 'B.Tech.';?></td>
			<td style="width:42%"><?php echo $deptname;?></td>
			<td style="width:16%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo 'First Year';?></td>
			<td style="width:12%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php if($papercount > 12) echo 'I & II'; else echo 'I';?></td>
			<td style="width:20%">&nbsp;&nbsp;<?php echo $acadyear;?></td>
		</tr>
	</table>
	
	</br></br></br></br></br>
	<table  style="width:100%;margin-left:40px;margin-top:-20px">
	<tr>
		<td colspan="2"><center>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Semester I</center></td>
	</tr>
	<?php
	if(!isset($_SESSION)) {
		session_start();				
	}
	include 'db/db_connect.php';
	$sqlsub = "SELECT DISTINCT gr.PaperCode, SubjectName,gr.Credits,Total as TotMarks,OutOf as marksall,sem,examname,gr.papertype,
				(COALESCE(T1,0)) AS TotMarks1,(COALESCE(T2,0)) AS TotMarks2,ESEOUTOF,T1OUTOF,T2OUTOF,prortwall,(COALESCE(ESE,0)) AS esemarks,
				(COALESCE(Total,0)) AS total
				FROM tblgradereport gr
				INNER JOIN tblstudent s ON s.StdID = gr.StdId
				INNER JOIN tblstdadm sa ON sa.StdId = s.StdId AND sa.EduYearFrom = Substring('" . $_GET['eduyear'] . "',1,4) 
				AND sa.Year = Replace(sa.Year,'.','') = '" . $_GET['year'] . "' 
				AND sa.Div = '" . $_GET['div'] . "'
				INNER JOIN tblpapermaster pm ON pm.PaperId = gr.PaperId
				INNER JOIN tblsubjectmaster sm ON sm.SubjectId = pm.SubjectId
				INNER JOIN tbldepartmentmaster dm ON dm.DeptId = sa.Dept
				WHERE gr.StdId = " . $StdId . "
				ORDER BY sem,structorder";			
	/*$sqlsub = "SELECT (COALESCE(T1,0)) AS TotMarks1,(COALESCE(T2,0)) AS TotMarks2,(COALESCE(ESE,0)) AS esemarks,(COALESCE(Total,0)) AS total,
				Credits,OutOf as marksall,sem,examname,papertype,ESEOUTOF,T1OUTOF,T2OUTOF,prortwall,PaperCode,PaperID
				FROM tblgradereport where StdID = " . $StdId;
	*/
	//echo $sqlsub;
	$resultsub = $mysqli->query( $sqlsub );
	echo $mysqli->error;
	$num_resultssub = $resultsub->num_rows;
	//echo $sql;
	$sem2check = 0;
	$totcreditssem1 = 0;
	$totcreditssem2 = 0;
	$totcreditscum = 0;
	$totcreditscumALL = 0;
	$gpsem1 = 0;
	$gpsem2 = 0;
	$gpcum = 0;
	$sgpasem1 = 0;
	$sgpasem2 = 0;
	$sgpacum = 0;
	$topsem1 = 0;
	$bottomsem1 = 0;
	$topsem2 = 0;
	$bottomsem2 = 0;
	$topcum = 0;
	$bottomcum = 0;
	$thcredits = 0;
	$prorcredits = 0;
	
	
	if( $num_resultsstd ){
		while( $rowsub = $resultsub->fetch_assoc() ){
			extract($rowsub);
			$totcreditscumALL = $totcreditscumALL + $Credits;
			//calcuate grade!!
			if(stripos($SubjectName, 'alue Education') <> ''){
				$finalresult = 'AC';
				$Credits = 0;
				$gp = 0;
			}
			else{
				$finalresult = 'P';
				if($SubjectName == 'Fundamentals of Programming Language - I'){
					if((round($TotMarks1 + $TotMarks2)) * 100/(($T1OUTOF)) < 40){
						$finalresult = 'F';
						$Credits = 0;
					}
					$esemarks = 0;
					$sum = round($TotMarks1 + $TotMarks2);
				}
				//------		FROM SEMREPORT START
				if($papertype == 'TH'){
					$marlsall = $ESEOUTOF + $T1OUTOF;
					if($esemarks > 0){						
						if($esemarks == '19.5'){
							$esemarks = '20';
						}
					}
					$sum = round($TotMarks1 + $TotMarks2 + $esemarks);
					//if TotMarks3 +1 is > 50% for retest then add 1!!!!
					if((stripos($examname, 'Retest') <> '' ) || (stripos($examname, 'Summer') <> '' )){
						if(((($sum * 100)/$marlsall) < 50) and (((($sum + 1) * 100)/$marlsall) >= 50)){
							$sum = $sum + 1;
							$esemarks = $esemarks + 1;
						}
					}
					if($ESEOUTOF <> 0){
						if(((round($esemarks) * 100)/$ESEOUTOF) < 40){
							$finalresult = 'F';
							$Credits = 0;
						}
					}
					/*if($esemarks == 'AA'){
						$finalresult = 'F';
						$Credits = 0;
					}*/
					if($finalresult == 'P'){
						if((stripos($examname, 'Retest') <> '' ) || (stripos($examname, 'Summer') <> '' )){
							if(((round($sum) * 100)/$marlsall) < 50){
								$finalresult = 'F';
								$zerosgpa = 0;
							}
						}
						else{
							if(((round($sum) * 100)/$marlsall) < 40){
								$finalresult = 'F';
								$zerosgpa = 0;
							}
						}										
					}
				}
				else{
					$marlsall = $prortwall;
					$sum = round($total);
					if(((round($sum) * 100)/$marlsall) < 40){
						$finalresult = 'F';
						$Credits = 0;
					}
					/*if($esemarks == 'AA'){
						$finalresult = 'F';
						$Credits = 0;
					}*/
					if($finalresult == 'P'){
						if((stripos($examname, 'Retest') <> '' ) || (stripos($examname, 'Summer') <> '' )){
							if(((round($sum) * 100)/$marlsall) < 50){
								$finalresult = 'F';
								$zerosgpa = 0;
							}
						}
						else{
							if(((round($sum) * 100)/$marlsall) < 40){
								$finalresult = 'F';
								$zerosgpa = 0;
							}
						}										
					}
				}
				//------		FROM SEMREPORT END
				$marksall = $marlsall;
				$gp = 0;
				if($finalresult == 'P'){
					if((stripos($examname, 'Retest') <> '' ) || (stripos($examname, 'Summer') <> '' )){
						if((round($sum) * 100)/($marksall) >= 90){
									$finalresult = 'A+';
									$gp = 9;
						}
						else if((round($sum) * 100)/($marksall) > 79 &&  (round($sum) * 100)/($marksall) < 90){
									$finalresult = 'A';
									$gp = 8;
						}
						else if((round($sum) * 100)/($marksall) > 69 &&  (round($sum) * 100)/($marksall) < 80){
									$finalresult = 'B+';
									$gp = 7;
						}
						else if((round($sum) * 100)/($marksall) > 59 &&  (round($sum) * 100)/($marksall) < 70){
									$finalresult = 'B';
									$gp = 6;
						}
						else if((round($sum) * 100)/($marksall) > 49 &&  (round($sum) * 100)/($marksall) < 60){
									$finalresult = 'C';
									$gp = 5;
						}
						else if((round($sum) * 100)/($marksall) < 50){
									$finalresult = 'F';
									$gp = 0;
						}
					}
					else{
						if((round($sum) * 100)/($marksall) >= 90){
									$finalresult = 'O';
									$gp = 10;
						}
						else if((round($sum) * 100)/($marksall) > 79 &&  (round($sum) * 100)/($marksall) < 90){
									$finalresult = 'A+';
									$gp = 9;
						}
						else if((round($sum) * 100)/($marksall) > 69 &&  (round($sum) * 100)/($marksall) < 80){
									$finalresult = 'A';
									$gp = 8;
						}
						else if((round($sum) * 100)/($marksall) > 59 &&  (round($sum) * 100)/($marksall) < 70){
									$finalresult = 'B+';
									$gp = 7;
						}
						else if((round($sum) * 100)/($marksall) > 49 &&  (round($sum) * 100)/($marksall) < 60){
									$finalresult = 'B';
									$gp = 6;
						}
						else if((round($sum) * 100)/($marksall) > 39 &&  (round($sum) * 100)/($marksall) < 50){
									$finalresult = 'C';
									$gp = 5;
						}							
						else if((round($sum) * 100)/($marksall) < 40){
									$finalresult = 'F';
									$gp = 0;
						}
					}
				}
				else{
					$Credits = 0;
				}
			}
			if($papertype == 'TH'){
					$thcredits = $thcredits + $Credits;
			}
			else{
				if($SubjectName == 'Fundamentals of Programming Language - II'){
					$thcredits = $thcredits + $Credits;
				}
				else{
					$prorcredits = $prorcredits + $Credits;
				}
			}

	if(($sem == 2) && ($sem2check == 0)){
		echo "<tr>";
		echo "<td colspan='2'><center>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Semester II</center></td>";
		echo "</tr>";
		$sem2check = 1;
	}
	?>
	<tr>
		<td style="width:16%"><?php echo $PaperCode;?></td>
		<td style="width:58%"><?php echo $SubjectName;?></td>
		<td style="width:12%"><?php echo $Credits;?></td>
		<td style="width:24%"><?php echo $finalresult;?></td>
	</tr>
	<?php 
			if($sem == 1){
				$totcreditssem1 = $totcreditssem1 + $Credits;
				$gpsem1 = $gpsem1 + $gp;
				$topsem1 = $topsem1 + ($Credits * $gp);
				$bottomsem1 = $bottomsem1 + $Credits;
			}
			else{
				$totcreditssem2 = $totcreditssem2 + $Credits;
				$gpsem2 = $gpsem2 + $gp;
				$topsem2 = $topsem2 + ($Credits * $gp);
				$bottomsem2 = $bottomsem2 + $Credits;
			}
			$totcreditscum = $totcreditscum + $Credits;
			$gpcum = $gpcum + $gp;
			$topcum = $topcum + ($Credits * $gp);
			$bottomcum = $bottomcum + $Credits;
			$gp = 0;
			
		}
		$totcreditscumALL = 48;
		$sgpasem1 = $topsem1 / ($totcreditscumALL/2);
		$sgpasem2 = $topsem2 / ($totcreditscumALL/2);
		$sgpacum = $topcum / $totcreditscumALL;
	}
	?>		
	</table>
	<table style="width:100%;;margin-left:-5px;margin-top:195px;margin-bottom:20px">
			<tr>
			<td style="width:11%;text-align:center;"><?php echo $totcreditssem1;?></td>
			<td style="width:11%;text-align:center;"><?php echo $gpsem1;?></td>  
			<td style="width:11%;text-align:center;"><?php echo number_format((float)$sgpasem1, 2, '.', '');?></td>
			<td style="width:11%;text-align:center;"><?php echo $totcreditssem2;?></td>
			<td style="width:11%;text-align:center;"><?php echo $gpsem2;?></td>
			<td style="width:11%;text-align:center;"><?php echo number_format((float)$sgpasem2, 2, '.', ''); ?></td>
			<td style="width:11%;text-align:center;"><?php echo $totcreditscum; ?></td>
			<td style="width:11%;text-align:center;"><?php echo $gpcum; ?></td>
			<td style="width:11%;text-align:center;"><?php echo number_format((float)$sgpacum, 2, '.', '');?></td>
			<td style="width:1%">&nbsp;</td>
		</tr>
	</table>
	<table style="width:100%;margin-left:108px;line-height:10px;margin-top:40px">
		<tr>
			<td style="width:11%"><?php  
					if($totcreditscum >= 48){
						echo "PASS";
					}
					else if(($totcreditscum < 48) && ($thcredits >= 23) && ($prorcredits >= 6)){
						echo "A.T.K.T.";
					}
					else{
						echo "FAIL";
					}
			?></td>
		</tr>
	</table>
	<table style="width:100%;margin-left:108px;line-height:10px;margin-top:23px">
		<tr>
			<td style="width:11%"><?php echo date("d-M-y");?></td>
		</tr>
	</table>
	<?php
		echo"<p  style='page-break-after:always;'></p>";	
			}
	}
	?>		

	</body>
</html>
