<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Semester Report</title>
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
	text-indent:0px;
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

	<table class='branch-table' style='width:100%;'>
		<tr>
			<td><center><img src='images/logo.png' alt='logo' width='577' height='91' /></center></td>
		</tr>
	</table>
		<br/>
	<br/>
	<table width="90%" cellpadding="5" cellspacing="0" class="fix-table" style="margin-left: 5%;">
	<TR>
		<td colspan='7' class='th-heading'><center>Semester Report</center><br/>
		<center><?php echo "Academic Year: " . $_GET['acadyear'] . "&nbsp;Department: " . $_GET['deptname'] . "&nbsp;Year: " . $_GET['year'] . "&nbsp;Sem " . $Sem; ?></center></td>
	</TR>
	</table>
	<br/><br/>
<table width="100%" border="0" cellpadding="5" cellspacing="0" class="fix-table" style="margin-left: 0%;">
	<tr class="th">
		<td>Sr. No.</td>
		<td>CNUM</td>
		<td>Roll No</td>
		<td>Seat Number</td>
		<td>Student Name</td>
		<td>Division</td>
		
		<?php
			
				include 'db/db_connect.php';
				$sql1 = "SELECT DISTINCT pm.PaperID,sm.SubjectName,eb.papertype,eb.Sem
						FROM tblgradereport eb 
						INNER JOIN tblpapermaster pm ON pm.PaperID = eb.PaperID 
						INNER JOIN tblsubjectmaster sm ON sm.SubjectID = pm.SubjectID 
						WHERE eb.AcadYear = " . $_GET['acadyear'] . "  
						ORDER BY eb.Sem, sm.SubjectName";
				$j = 0;
				$result1 = $mysqli->query( $sql1 );
				$num_results1 = $result1->num_rows;
				if( $num_results1 ){
					while( $row1 = $result1->fetch_assoc() ){
						extract($row1);
						$ArrPapers[$j] = $PaperID;
						$j = $j +1;
						//echo "<td >{$AttDate}</td>";
						for($i= 1;$i<=5 ;$i++) {
							echo "<td>". $SubjectName . "</td>";
							if($papertype <> 'TH'){
								break;
							}
						}
					}
				}
			?>
			<td>Sem1 Credits</td>
			<td>Sem1 SGPA</td>
			<td>Sem2 Credits</td>
			<td>Sem2 SGPA</td>
			<td>Total Credits</td>
			<td>CGPA</td>
			<td>Result</td>
			<td>TH Credits</td>
			<td>PROR Credits</td>
			<td>Theory Failure Count</td>
	</tr>
	<tr>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<?php
				$z = 0;
				$m = 0;
				$result = $mysqli->query( $sql1);
				$num_results = $result->num_rows;
				if( $num_results ){
					while( $row = $result->fetch_assoc() ){
						extract($row);
						$ArrPapers[$j] = $PaperID;
							if($papertype == 'TH'){
								echo"<td>Sem " . $Sem . " - T1</td>";
								echo"<td>Sem " . $Sem . " - T2</td>";	
								echo"<td>Sem " . $Sem . " - ESE</td>";	
								echo"<td>Sem " . $Sem . " - Total</td>";	
								echo"<td>Sem " . $Sem . " - Grade</td>";	
							}
							else{
								echo"<td>Sem " . $Sem . " - Total</td>";	
							}
								// - - add code get the PR OR TW or blank and show here.....then also show marks below!!
								//if($paperidArrayorpr[$m] == $PaperID){
								//	echo"<td>{$Arrayorpr[$m]}</td>";	
								//	$m = $m + 1;
								//}
								//echo"<td>Grand Total</td>";	
						$paperidArray[] = $PaperID;
						$subjectArray[] = $SubjectName;
						$z = $z  + 1;
					}
				}
				echo"<td></td>";	
				echo"<td></td>";	
				echo"<td></td>";	
				echo"<td></td>";	
				echo"<td></td>";	
				echo"<td></td>";	
				echo"<td></td>";	
				echo"<td></td>";	
				echo"<td></td>";	
				echo"<td></td>";	

	?>
	</tr>
	<?php
		if(!isset($_SESSION)) {
			session_start();				
		}
		$theoryfailures = 0;
		$totcreditssem1 = 0;
		$totcreditssem2 = 0;
		$totcreditscum = 0;
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
		$sqlstd = "SELECT DISTINCT gr.StdId,sa.div AS division,CNUM,CONCAT(Surname,' ', FirstName, ' ',FatherName) AS StdName,sa.ESNum,RollNo 
					FROM (SELECT DISTINCT StdId,AcadYear FROM tblgradereport) gr 
					INNER JOIN tblstdadm sa ON sa.StdID = gr.StdID AND sa.EduYearFrom = gr.AcadYear AND sa.Year = 'F.E.'
					INNER JOIN tblstudent s ON s.StdID = gr.StdID 
					ORDER BY sa.ESNum";
				// limit 10
					//echo $sqlstd;
			$resultstd = $mysqli->query( $sqlstd );
			echo $mysqli->error;
			$num_resultsstd = $resultstd->num_rows;
 			$j = 1;
			//echo $sql;
			if( $num_resultsstd ){
				while( $rowstd = $resultstd->fetch_assoc() ){
					extract($rowstd);
					echo "<TR>";
					echo "<td>$j</td>";
					echo "<td>{$CNUM} </td>";
					echo "<td>{$RollNo} </td>";
					echo "<td>{$ESNum} </td>";
					echo "<td>{$StdName} </td>";
					echo "<td>{$division} </td>";
					$j += 1;
					for($l= 0;$l<$z ;$l++) {
						$sql = "SELECT (COALESCE(T1,0)) AS TotMarks1,(COALESCE(T2,0)) AS TotMarks2,(COALESCE(ESE,0)) AS esemarks,(COALESCE(Total,0)) AS total,
										Credits,OutOf as marksall,sem,examname,papertype,ESEOUTOF,T1OUTOF,T2OUTOF,prortwall,PaperCode,PaperID
						FROM tblgradereport where StdID = " . $StdId . " and PaperID = " . $paperidArray[$l] ;
						// execute the sql query
						$result = $mysqli->query( $sql );
						echo $mysqli->error;
						$num_results = $result->num_rows;
						if( $num_results ){
							while( $row = $result->fetch_assoc() ){
								extract($row);
								//credits and result calc start
								if(stripos($subjectArray[$l], 'alue Education') <> ''){
									$finalresult = 'AC';
									$Credits = 0;
								}
								else if($subjectArray[$l] == 'Fundamentals of Programming Language - I'){
									if((round($TotMarks1 + $TotMarks2)) * 100/(($T1OUTOF)) < 40){
										$finalresult = 'F';
										$Credits = 0;
										$theoryfailures = $theoryfailures  +1;
									}
									$esemarks = 0;
									$sum = round($TotMarks1 + $TotMarks2);
								}
								else{
									$finalresult = 'P';
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
										if(((round($esemarks) * 100)/$ESEOUTOF) < 40){
											$finalresult = 'F';
											$Credits = 0;
											$theoryfailures = $theoryfailures  +1;
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
													$theoryfailures = $theoryfailures  +1;
												}
											}
											else{
												if(((round($sum) * 100)/$marlsall) < 40){
													$finalresult = 'F';
													$zerosgpa = 0;
													$theoryfailures = $theoryfailures  +1;
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
											$theoryfailures = $theoryfailures  +1;
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
													$theoryfailures = $theoryfailures  +1;
												}
											}
											else{
												if(((round($sum) * 100)/$marlsall) < 40){
													$finalresult = 'F';
													$zerosgpa = 0;
													$theoryfailures = $theoryfailures  +1;
												}
											}										
										}
									}
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
											else if((round($sum) * 100)/($marksall) > 39 &&  (round($sum) * 100)/($marksall) < 50){
														$finalresult = 'D';
														$gp = 9;
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
										}
									}
									else{
										$Credits = 0;
									}
								}
								if($papertype == 'TH'){
									echo "<td>{$TotMarks1} </td>";
									echo "<td>{$TotMarks2} </td>";
									echo "<td>{$esemarks} </td>";
									echo "<td>{$sum}</td>";
									echo "<td>{$finalresult}</td>";
								}
								else{
									if(stripos($subjectArray[$l], 'alue Education') <> ''){
										echo "<td>AC</td>";
									}
									else{
										echo "<td>{$sum}</td>";
									}
								}

								if($papertype == 'TH'){
										$thcredits = $thcredits + $Credits;
								}
								else{
									if($subjectArray[$l] == 'Fundamentals of Programming Language - II'){
										$thcredits = $thcredits + $Credits;
									}
									else{
										$prorcredits = $prorcredits + $Credits;
									}
								}

								//calc part 20px			
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
								//credits and result calc end
							}
						}		
					}
					$totcreditscumALL = 48;
					$sgpasem1 = $topsem1 / ($totcreditscumALL/2);
					$sgpasem2 = $topsem2 / ($totcreditscumALL/2);
					$sgpacum = $topcum / $totcreditscumALL;
					echo "<td>{$totcreditssem1}</td>";
					echo "<td>" . number_format((float)$sgpasem1, 4, '.', '') . "</td>";
					echo "<td>{$totcreditssem2}</td>";
					echo "<td>" . number_format((float)$sgpasem2, 4, '.', '') . "</td>";
					echo "<td>{$totcreditscum}</td>";
					echo "<td>" . number_format((float)$sgpacum, 4, '.', '') . "</td>";
					if($totcreditscum >= 48){
						echo "<td>PASS</td>";
					}
					else if(($totcreditscum < 48) && ($thcredits >= 23) && ($prorcredits >= 6)){
						echo "<td>A.T.K.T.</td>";
					}
					else{
						echo "<td>FAIL</td>";
					}
					echo "<td>{$thcredits}</td>";
					echo "<td>{$prorcredits}</td>";
					echo "<td>{$theoryfailures}</td>";

					echo "</TR>";
					$totcreditssem1 = 0;
					$totcreditssem2 = 0;
					$totcreditscum = 0;
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
					$theoryfailures = 0;
				}
			}

			//disconnect from database	
			$result->free();
			$mysqli->close();
	?>
    </table>
</body>
</html>
