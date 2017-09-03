<?php
//include database connection
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

		
			// if the form was submitted/posted, update the record
			If (isset($_POST['btnSelect']) && (!($_POST['ddlExam'] == 'Select' )))
		{
			
			if($_POST['ddldept'] == '0'){
				echo '<script>alert("Please select a Department!");</script>';
			}
			else{				
					if (isset($_POST['ddldept'])) {
						//$DeptName = $_POST['ddldept'];
						$DeptID = $_POST['ddldept'];
						include 'db/db_connect.php';
						$sql = "SELECT DeptName From tbldepartmentmaster where DeptID = " . $DeptID;
						$result1 = $mysqli->query( $sql );
						while( $row = $result1->fetch_assoc() ) {
							extract($row);
						}
					}					
					
								//header("Location: ResultDownload.php?ddlExam=" . $_POST['ddlExam'] . "&ddlYear=" . $_POST['ddlYear'] . "&Dept=" . $DeptID . "&filename=RA.txt"); 
								$filename = $_POST['ddlYear'] . "_PAT" . $_POST['ddlPattern'] . "_" . $DeptName . "_" . $_POST['ddlAcadYear'] . "_Sem_" . $_POST['ddlSem'] . ".csv";
								$handle = fopen($filename, "w");

								include 'db/db_connect.php';
								ini_set('max_execution_time', 2000);
								$sql = "SELECT DISTINCT ResultSubject, SubType, R.Sem
										FROM tblstdresult R 
										INNER JOIN tblstdresultm RM ON RM.StdResMID = R.StdResMID 
										INNER JOIN tblresultfile RF ON RF.ResFileID = RM.ResFileID
										Where coalesce(ResultSubject,'') <> '' and RM.CDept = " . $DeptID . "
										And Concat(RM.EduYearFr,'-',RM.EduYearTo) = '" . $_POST['ddlAcadYear'] . "' 
										And RM.EduYear = '" . $_POST['ddlYear'] . "'
										And RM.Pattern = '" . $_POST['ddlPattern'] . "'
										ORDER BY R.Sem, ResOrder " ;
										//And RF.ExamID = " . $_POST['ddlExam'] . "
								//echo $sql . "<br/> "; 
								//die;
								$i=0;
								$j = 0;
								$result = $mysqli->query( $sql );
								$num_results = $result->num_rows;
								$TextLine = '';
								if( $num_results ){
									while( $row = $result->fetch_assoc() ){
										extract($row);
										if ($i == 0){
											//echo "Student Name " . " , " ;
											$TextLine = "Student Name , UniPRN, Seat No, Division , CNUM, Roll No , Dept , " ;
											$i = 1;
										}
										//echo $ResultSubject . " , " ;
										$TextLine = $TextLine . $ResultSubject . " , "  ;

										$ResP[$j] = $ResultSubject;
										//$ResOrderP[$j] = $ResOrder;
										$j = $j + 1;
									}
									//echo "</br>";
									$TextLine = $TextLine . ",Total,Out Of, Class" . PHP_EOL;
									fwrite($handle, $TextLine );
									$TextLine = '';
									
								}
								
								
								
								
									
								$sql = "SELECT DISTINCT ResultSubject, SubType, R.Sem
										FROM tblstdresult R 
										INNER JOIN tblstdresultm RM ON RM.StdResMID = R.StdResMID 
										INNER JOIN tblresultfile RF ON RF.ResFileID = RM.ResFileID
										Where coalesce(ResultSubject,'') <> '' and RM.CDept = " . $DeptID . "
										And Concat(RM.EduYearFr,'-',RM.EduYearTo) = '" . $_POST['ddlAcadYear'] . "' 
										And RM.EduYear = '" .  $_POST['ddlYear'] . "'
										And RM.Pattern = '" . $_POST['ddlPattern'] . "'
										ORDER BY R.Sem, ResOrder" ;
										//And RF.ExamID = " . $_POST['ddlExam'] . "
								//echo $sql; 
								$i=0;
								$j = 0;
								$TextLine = '';
								$result = $mysqli->query( $sql );
								$num_results = $result->num_rows;
								if( $num_results ){
									while( $row = $result->fetch_assoc() ){
										extract($row);
										if ($i == 0){
											//echo "Paper Type " . " , " ;
											$TextLine = ", , , , , , Paper Type " . " , " ;
											$i = 1;
										}
										//echo $SubType . " , " ;
										$TextLine = $TextLine . $SubType . " , " ;
										$ResP[$j] = $ResP[$j] . '~' .  $SubType . '~' .  $Sem;
										$j = $j +1;
									}
									//echo "</br>";
									$TextLine = $TextLine . " , " . PHP_EOL;
									fwrite($handle, $TextLine );
									$TextLine = '';									
								}

								
								// $sql = "SELECT DISTINCT(UniPrn), Marks, CONCAT(ResultSubject, '~',  SubType) AS ResultSubject, ResOrder";
								$sql = "SELECT DISTINCT RM.UniPrn, CONCAT(Coalesce(Surname, ''), ' ' , Coalesce(FirstName, ''), ' ', Coalesce(FatherName, '')) AS StdName , CNUM,aicteno,S.dept as dept,trim(BLine) as BLine,
										coalesce(SA.Div) as divn,seatno
										FROM tblstdresult R 
										INNER JOIN tblstdresultm RM ON RM.StdResMID = R.StdResMID 
										INNER JOIN tblresultfile RF ON RF.ResFileID = RM.ResFileID
										LEFT OUTER JOIN tblstudent S on S.uniprn = TRIM(RM.UniPrn)
										LEFT OUTER JOIN tblstdadm SA on SA.StdID = S.StdID and SA.Dept = " . $DeptID  . "
										Where coalesce(ResultSubject,'') <> '' and RM.CDept = " . $DeptID  . " and Concat(RM.EduYearFr,'-',RM.EduYearTo) = '" . $_POST['ddlAcadYear'] . "' 
										And RM.EduYear = '" . $_POST['ddlYear'] . "'
										And RM.Pattern = '" . $_POST['ddlPattern'] . "'
										ORDER BY RM.StdResMID, R.Sem, ResOrder" ;
										//Where RM.CDept = " . $DeptID  . "
										//And RF.ExamID = " . $_POST['ddlExam'] . "
								//echo $sql; 
								//die;
								$result = $mysqli->query( $sql );
								$num_results = $result->num_rows;
								if( $num_results ){
									while( $row = $result->fetch_assoc() ){
										extract($row);
										$TextLine = '';
										//echo $UniPrn . " , " ;
										//$TextLine = $UniPrn . " , " ;
										If (Trim($StdName) == '') {
											$TextLine = $UniPrn . ", , , , , , , " ;
										}
										else {
											$TextLine = $StdName . " , " . $UniPrn . " , " . $seatno . " , " . $divn . " , " . $CNUM . " , " . $aicteno . " , " . $dept . " , ";
										}
										for ($z = 0 ; $z <= count($ResP) - 1; $z++) {
											include 'db/db_connect.php';
											//Case Marks When 'AA' then 0 Else Marks End
											$sqlM = "SELECT coalesce(Marks,'') as Marks,
												coalesce(MidSem,'') as MidSem,
												coalesce(EndSem,'') as EndSem
												FROM tblstdresult R 
												INNER JOIN tblstdresultm RM ON RM.StdResMID = R.StdResMID 
												INNER JOIN tblresultfile RF ON RF.ResFileID = RM.ResFileID
												Where coalesce(ResultSubject,'') <> '' and RM.CDept = " . $DeptID . "
												And RM.Pattern = '" . $_POST['ddlPattern'] . "'
												
												And Concat(RM.EduYearFr,'-',RM.EduYearTo) = '" . $_POST['ddlAcadYear'] . "' 
												And RM.EduYear = '" . $_POST['ddlYear'] . "'
												and UniPrn =  '" . $UniPrn . "' and CONCAT(ResultSubject, '~',  SubType, '~',  R.Sem) = '". $ResP[$z] ."'";
												//And RF.ExamID = " . $_POST['ddlExam'] . "
											//echo $sqlM . "</br>";
											$resultM = $mysqli->query( $sqlM );
											if( $resultM->num_rows ){
												while( $row = $resultM->fetch_assoc() ){
													extract($row);
													//echo $Marks . " , " ;
													If (((($_POST['ddlYear'] == 'TE')  && ($_POST['ddlPattern'] == 2012)) || (($_POST['ddlYear'] == 'BE') && ($_POST['ddlPattern'] == 2012)) ||
															(($_POST['ddlYear'] == 'SE') && ($_POST['ddlPattern'] == 2014)))
															&& ((strpos($ResP[$z], '~PP~') !== false))){
																$TextLine = $TextLine . $Marks . " | " . $MidSem . " | " . $EndSem . " , " ;
													}
													else
													{
																$TextLine = $TextLine . $Marks . " , " ;
													}
													//$TextLine = $TextLine . $Marks													
												}
											}
											Else {
												//echo " , " ;
												$TextLine = $TextLine . "NA , " ;
											}
										}
										//echo "</br>";
										$strbline = substr($BLine,0,strlen($BLine)-1);
										$strbline = str_replace('GRAND TOTAL = ', '', $strbline);
										$strbline = str_replace('/', ',', $strbline);
										$strbline = str_replace('Result : ', '', $strbline);
										$TextLine = $TextLine . " , " . $strbline . PHP_EOL;
										fwrite($handle, $TextLine );
										$TextLine = '';
										
									}
								}
								
								fclose($handle);
								
								ob_clean();
								header('Content-Type: application/octet-stream');
								header('Content-Disposition: attachment; filename='.basename($filename));
								header('Expires: 0');
								header('Cache-Control: must-revalidate');
								header('Pragma: public');
								header('Content-Length: ' . filesize($filename));
								readfile($filename);
								//header('Location: ProfExamAdminMain.php');
								exit;
							}
						}
	
?>


<style type="text/css">
      #loadingmsg {
      color: black;
      background: #fff; 
      padding: 10px;
      position: fixed;
      top: 50%;
      left: 50%;
      z-index: 100;
      margin-right: -25%;
      margin-bottom: -25%;
      }
      #loadingover {
      background: black;
      z-index: 99;
      width: 100%;
      height: 100%;
      position: fixed;
      top: 0;
      left: 0;
      -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=80)";
      filter: alpha(opacity=80);
      -moz-opacity: 0.8;
      -khtml-opacity: 0.8;
      opacity: 0.8;
    }
</style>

<div id='loadingmsg' style='display: none;'>Please wait...</div>
<div id='loadingover' style='display: none;'></div>

<form action="ProfExamAdminMain.php" method="post" onsubmit='showLoading();'>
<body>
<script>
function sendToprofQual()
{
		var subvalue = document.getElementById("ddldept");
		var subtext = ddldept.options[ddldept.selectedIndex].text;

	window.open('profQual.php?dept=' + subtext);
}
function sendtoProfPersDet()
{
	var subvalue = document.getElementById("ddldept");
	var subtext = ddldept.options[ddldept.selectedIndex].text;
	window.open('Profbasicdetails.php?dept=' + subtext);
}
function sendtoprofbankdet()
{
	var subvalue = document.getElementById("ddldept");
	var subtext = ddldept.options[ddldept.selectedIndex].text;
	window.open('ProfBankDet.php?dept=' + subtext);
}
function sendtoJournal()
{
	var subvalue = document.getElementById("ddldept");
	var subtext = ddldept.options[ddldept.selectedIndex].text;
	window.open('pubjournal.php?dept=' + subtext);
}
function sendtobook()
{
	var subvalue = document.getElementById("ddldept");
	var subtext = ddldept.options[ddldept.selectedIndex].text;
	window.open('pubbook.php?dept=' + subtext);
}
function sendopetant()
{
	var subvalue = document.getElementById("ddldept");
	var subtext = ddldept.options[ddldept.selectedIndex].text;
	window.open('pubpetant.php?dept=' + subtext);
}
  $(document).ready(function() {
    $("#ddlExamID").change(function(){
		var skillsSelect = document.getElementById("ddlExamID");
		var selectedText = skillsSelect.options[skillsSelect.selectedIndex].text;
		$("#examname_hidden").val(selectedText);
    });
    $("#ddlYear").change(function(){
		var YearSelect = document.getElementById("ddlYear");
		var selectedText = YearSelect.options[YearSelect.selectedIndex].text;
		$("#year_hidden").val(selectedText);
    });
  });
  function hideLoading() {
    document.getElementById('loadingmsg').style.display = 'none';
    document.getElementById('loadingover').style.display = 'none';
	alert('File downloaded successfully.');
}
  function showLoading() {
    document.getElementById('loadingmsg').style.display = 'block';
    document.getElementById('loadingover').style.display = 'block';
	setTimeout(hideLoading,12000);
  }
</script>
	<br /><br />	<br />
	<h3 class="page-title">Faculty Reports</h3>
	<h3 class="page-title" style="float:right;margin-top:-40px;"><a href="MainMenuMain.php">Back</a></h3>
		<table cellpadding="05" cellspacing="0" border="0" class="tab_split" style="width:40%">
			<tr >
				<td class="form_sec span1"><b>Dept</b></td>
				<td class="form_sec span1">
					<?php
					$setdisabled = '0';
					$strSelect1 = '';
					$strSelect2 = '';
					include 'db/db_connect.php';
					$strSelect1 = "<select id='ddldept' onchange='showdept();' name='ddldept' style='margin-top:10px;width:120px;'";
						//if($_SESSION["SESSRAUserDept"] == $Department) 
						//	echo ' disabled';
					$strSelect2 = "<option value='0'>All</option>";
					$query = "SELECT DeptID,DeptName AS Department FROM tbldepartmentmaster where coalesce(teaching,0) = 1 ";
							//echo $query;
							$result = $mysqli->query( $query );
							$num_results = $result->num_rows;
							if( $num_results ){
								while( $row = $result->fetch_assoc() ){
									extract($row);
								$strSelect2 = $strSelect2 . "<option ";
								if(isset($_SESSION["SESSRAUserDept"]))
								{ 
									if($_SESSION["SESSRAUserDept"] == $Department) {
										$strSelect2 = $strSelect2 . ' selected ';
										$strSelect1 = $strSelect1 . " disabled";
									}
								} 
									$strSelect2 = $strSelect2 . " value='{$DeptID}'>{$Department}</option>";
								}
							}
					$strSelect1 = $strSelect1 . " >";
					$strSelect1 = $strSelect1 . $strSelect2;
					$strSelect1 = $strSelect1 .  "</select>";
					echo $strSelect1;
					?>
				<input type="hidden" name="hdnyear" id="year_hidden">
				</td>
				
			</tr>						
		</table>
		<br/>
		<table cellpadding="10" cellspacing="0" border="0" class="tab_split" style="width:110%">
			<tr >
				<td class="form_sec span1">
					<input type="button" name="btnProfPersonalDetails" value="Personal Details" class="btn btn btn-success" onclick="sendtoProfPersDet();" />
				</td>								
				<td class="form_sec span1">
					<input type="button" name="btnprofQual" value="Qualifications" class="btn btn btn-success" onclick="sendToprofQual();" />
				</td>								
				<!--<td class="form_sec span1">
					<input type="button" name="btnprofQual1" value=" Degree Qualifications" class="btn btn btn-success" onclick="sendToprofQual1();" />
				</td>	-->							
				<td class="form_sec span1">
					<input type="button" name="btnprofbankdetails" value="Bank Details" class="btn btn btn-success" onclick="sendtoprofbankdet();" />
				</td>								
				<!--<td class="form_sec span1">
					<input type="button" name="btnprofphdqual" value="Professor PHD Qualifications" class="btn btn btn-success" onclick="sendtoprofphdqual();" />
				</td>	-->							
				<td class="form_sec span1">
					<input type="button" name="btnJournal" value="Journal / Conference" class="btn btn btn-success" onclick="sendtoJournal();" />
				</td>
				<!--
				<td class="form_sec span1">
					<input type="button" name="btnBook" value="Books" class="btn btn btn-success" onclick="sendtobook();" />
				</td>	
				<td class="form_sec span1">
					<input type="button" name="btnpetant" value="Petants" class="btn btn btn-success" onclick="sendopetant();" />
				</td>
				-->
			</tr>
		</table>
		
	<br />
	<br />
</body>	
</form>
