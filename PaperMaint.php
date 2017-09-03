<?php

 // if the form was submitted/posted, update the record
 if($_POST)
	{

		$selecteddepts = $_POST['chkdept'];
		
		if (isset($_POST['chkActive'])) {
				$tmpchkActive = '1';
			}
			else
				$tmpchkActive = '0';
				
			
			if (isset($_POST['chkInSemapp'])) {
				$tmpchkInsemEnabled = '1';
			}
			else{
				$tmpchkInsemEnabled = '0';
			}
			if (isset($_POST['chkOnlineapp'])) {
				$tmpchkOnlineEnabled = '1';
			}
			else
				$tmpchkOnlineEnabled = '0';
			
			if (isset($_POST['chkPaperapp'])) {
				$tmpchkPaperEnabled = '1';
			}
			else
				$tmpchkPaperEnabled = '0';
			
			
			
			if (isset($_POST['chkTermWorkapp'])) {
				$tmpchkTermworkViewEnabled = '1';
			}
			else
				$tmpchkTermworkViewEnabled = '0';
			
			if (isset($_POST['chkPracticalPRapp'])) {
				$tmpchkPracticalPRViewEnabled = '1';
			}
			else
				$tmpchkPracticalPRViewEnabled = '0';
			
			if (isset($_POST['chkOralORapp'])) {
				$tmpchkOralViewEnabled = '1';
			}
			else
				$tmpchkOralViewEnabled = '0';
			
			if (isset($_POST['chkLectureapp'])) {
				$tmpchkLectureViewEnabled = '1';
			}
			else
				$tmpchkLectureViewEnabled = '0';
			
			if (isset($_POST['chkTutorialapp'])) {
				$tmpchkTutorialViewEnabled = '1';
			}
			else
				$tmpchkTutorialViewEnabled = '0';
			
			if (isset($_POST['chkPracticalapp'])) {
				$tmpchkPracticalViewEnabled = '1';
			}
			else
				$tmpchkPracticalViewEnabled = '0';
			
			if (isset($_POST['chkIsElective'])) {
				$tmpchkIsElective = '1';
			}
			else
				$tmpchkIsElective = '0';

			if (isset($_POST['chkIsopenelective'])) {
				$tmpchkIsopenelective = '1';
			}
			else
				$tmpchkIsopenelective = '0';

			if (isset($_POST['chkEOapp'])) {
				$tmpchkEOapp = '1';
			}
			else
				$tmpchkEOapp = '0';
			
			
			
		if ($_GET['PaperID'] == "I") {
			//include database connection
			include 'db/db_connect.php';
			$sql = "Insert into tblpapermaster ( EnggYear, DeptID, EnggPattern, SubjectID, PaperCode ,Created_On, 
					Created_by, Updated_on,Updated_by,SubDispName,SubShortName,Lecture,Tutorial,Practical,Lectureapp,Tutorialapp,
					Practicalapp,InSem,InSemapp,Onlineapp,Paperapp,TermWorkapp,PracticalPRapp,OralORapp,EndSem,Online,Paper,
					TermWork,PracticalPR,OralOR,Stationary,ExamPaperCode,Active,IsElective,ElectiveNo,IsOpenElective,credits,EO,EOApp,structorder,prorcredits) Values ( ?, ?, ?, ?, ?, 
					CURRENT_TIMESTAMP, 'ADMIN', CURRENT_TIMESTAMP, 'ADMIN',?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
						
			$stmt = $mysqli->prepare($sql);
			$stmt->bind_param('sisisssiiiiiiiiiiiiissssssssiisiiiiii', $_POST['ddlEnggYear'], $_POST['ddlDept'], $_POST['ddlPattern'], 
										$_POST['ddlSubject'],$_POST['txtPaperCode'],$_POST['txtSubDispName'],
										$_POST['txtSubShortName'],$_POST['txtLecture'],$_POST['txtTutorial'],
										$_POST['txtPractical'],$tmpchkLectureViewEnabled,$tmpchkTutorialViewEnabled,
										$tmpchkPracticalViewEnabled,$_POST['txtInSem'],$tmpchkInsemEnabled,
										$tmpchkOnlineEnabled,$tmpchkPaperEnabled,$tmpchkTermworkViewEnabled,$tmpchkPracticalPRViewEnabled,$tmpchkOralViewEnabled,$_POST['txtEndSem'],
										$_POST['txtOnline'],$_POST['txtPaper'],$_POST['txtTermWork'],$_POST['txtPracticalPR'],
										$_POST['txtOralOR'],$_POST['txtStationary'],$_POST['txtExamPaperCode'],$tmpchkActive,
										$tmpchkIsElective,$_POST['ddlElectiveNo'],$tmpchkIsopenelective,$_POST['txtCredits'],$_POST['txtEO'],$tmpchkEOapp,$_POST['ddlstructorder'],
										$_POST['txtPRORCredits']);
			// execute the insert statement
			$stmt->execute();
			
			// get the lastest inserted id
			//include database connection
			include 'db/db_connect.php';
			$sql = " SELECT max(PaperID) as thispaperid FROM tblpapermaster";
			// execute the sql query
			$result = $mysqli->query( $sql );
			$row = $result->fetch_assoc();
			extract($row);
			$_SESSION["thispaperid"] = $thispaperid;
			
			//now insert this into tblpaperdept
			$size = count($selecteddepts);
			//include database connection
			include 'db/db_connect.php';
			for($i = 0 ; $i < $size ; $i++){
				if($selecteddepts[$i] != ''){
					$sql = "Insert into tblpaperdept ( paperid,deptid) Values ( ?, ?)";						
					$stmt = $mysqli->prepare($sql);
					$stmt->bind_param('ii', $_SESSION["thispaperid"],$selecteddepts[$i]);
					// execute the update statement
					$stmt->execute();
				}
			}
			header('Location: PaperListMain.php?'); 
		}
		else {
			$sql = "UPDATE  tblpapermaster
						Set EnggYear = ?
							,DeptID = ?
							,EnggPattern = ?
							,SubjectID = ?
							,PaperCode = ?
							,Created_On = CURRENT_TIMESTAMP
							,Created_by = 'ADMIN'
							,Updated_on = CURRENT_TIMESTAMP
							,Updated_by = 'ADMIN'
							,SubDispName = ?
							,SubShortName = ?
							,Lecture = ?
							,Tutorial = ?
							,Practical = ?
							,Lectureapp = ?
							,Tutorialapp = ?
							,Practicalapp = ?
							,InSem = ?
							,InSemapp = ?
							,Onlineapp = ?
							,Paperapp = ?
							,TermWorkapp = ?
							,PracticalPRapp = ?
							,OralORapp = ?
							,EndSem = ?
							,Online = ?
							,Paper = ?
							,TermWork = ?
							,PracticalPR = ?
							,OralOR = ?
							,Stationary = ?
							,ExamPaperCode = ?
							,Active = ?
							,IsElective = ?
							,ElectiveNo = ?
							,IsOpenElective = ?
							,credits = ?
							,EO = ?
							,EOApp = ?
							,structorder = ?
							,prorcredits = ?
						Where PaperID = ?";
			
				//include database connection
				include 'db/db_connect.php';

				$stmt = $mysqli->prepare($sql);
				$stmt->bind_param('sisisssiiiiiiiiiiiiiiiiiiissiiiiiiiiii', $_POST['ddlEnggYear'], $_POST['ddlDept'], $_POST['ddlPattern'], 
								$_POST['ddlSubject'], $_POST['txtPaperCode'], $_POST['txtSubDispName'], 
								$_POST['txtSubShortName'], $_POST['txtLecture'],$_POST['txtTutorial'], 
								$_POST['txtPractical'],$tmpchkLectureViewEnabled,$tmpchkTutorialViewEnabled,
								$tmpchkPracticalViewEnabled,$_POST['txtInSem'],$tmpchkInsemEnabled,
								$tmpchkOnlineEnabled,$tmpchkPaperEnabled,$tmpchkTermworkViewEnabled,
								$tmpchkPracticalPRViewEnabled,$tmpchkOralViewEnabled, $_POST['txtEndSem'],$_POST['txtOnline'], 
								$_POST['txtPaper'], $_POST['txtTermWork'], $_POST['txtPracticalPR'],$_POST['txtOralOR'],
								$_POST['txtStationary'],$_POST['txtExamPaperCode'],$tmpchkActive,$tmpchkIsElective,
								$_POST['ddlElectiveNo'],
								$tmpchkIsopenelective,$_POST['txtCredits'],
								$_POST['txtEO'],$tmpchkEOapp, $_POST['ddlstructorder'],$_POST['txtPRORCredits'],$_GET['PaperID']);
				$stmt->execute();
				
				//now insert this into tblpaperdept
				//include database connection
				include 'db/db_connect.php';
				$size = count($selecteddepts);
				$sql = "delete from tblpaperdept where paperid = " . $_GET['PaperID'];
				$stmt = $mysqli->prepare($sql);
				$stmt->execute();
				for($i = 0 ; $i < $size ; $i++){
					if($selecteddepts[$i] != ''){
						$sql = "Insert into tblpaperdept ( paperid,deptid) Values ( ?, ?)";						
						$stmt = $mysqli->prepare($sql);
						$stmt->bind_param('ii', $_GET['PaperID'],$selecteddepts[$i]);
						// execute the update statement
						$stmt->execute();
					}
				}
				header('Location: PaperListMain.php?'); 
			}
	}
else 
	{
		if ($_GET['PaperID'] == "I") {
			$sql = "SELECT 'I' as PaperID, '' as EnggYear,'' as DeptID, '' as EnggPattern, '' as SubjectID,'' as PaperCode,'' as  		
				SubDispName,'' as SubShortName,'' as  Lecture,'' as  Tutorial,'' as  Practical, '' as Lectureapp, 
				'' as Tutorialapp, '0', '0' as Practicalapp, '' as  InSem, '0' as InSemapp, '' as Onlineapp, 
				'' as Paperapp, '' as TermWorkapp, '' as PracticalPRapp, '' as OralORapp, '' as EndSem,'' as  Online,
				'' as  Paper,'' as TermWork,'' as  PracticalPR,'' as  OralOR,'' as  Stationary, 
				'' as ExamPaperCode, '0' as  Active ,'0' as IsElective,0 as ElectiveNo,0 as Isopenelective,'' as credits,
				'0' as EO,'0' as EOApp , 0 as structorder,'' as prorcredits
				FROM tblpapermaster" ;
		}
		Else
		{
			$sql = " SELECT PaperID, EnggYear, DeptID, EnggPattern, SubjectID, PaperCode, SubDispName, SubShortName, 			
					Coalesce(Lecture, 0) as Lecture, Coalesce(Tutorial, 0) as Tutorial,
					Coalesce(Practical, 0) as Practical,Lectureapp,Tutorialapp,Practicalapp,Coalesce(InSem, 0) as InSem,InSemapp, Onlineapp,Paperapp,TermWorkapp,PracticalPRapp,OralORapp,Coalesce(EndSem, 0) as EndSem, Coalesce(Online, 0) as Online, Coalesce(Paper, 0) as Paper,
					Coalesce(TermWork, 0) as TermWork, Coalesce(PracticalPR, 0) as PracticalPR, Coalesce(OralOR, 0) as OralOR,
					Stationary, ExamPaperCode, Active,IsElective,ElectiveNo,IsOpenElective ,credits,EO,EOApp, structorder,prorcredits
					FROM tblpapermaster  Where PaperID = " . $_GET['PaperID']   ;
		} 
		//echo $sql;
		
		
		// execute the sql query
		$result = $mysqli->query( $sql );
		$row = $result->fetch_assoc();
		extract($row);
		 
		//disconnect from database
		$result->free();
		$mysqli->close();
	}
//							<option value="ME - Sem 1" <?php if($EnggYear == "ME - Sem 1") echo "selected"; ?>>ME - Sem 1</option>
//							<option value="ME - Sem 2" <?php if($EnggYear == "ME - Sem 2") echo "selected"; ?>>ME - Sem 2</option>

?>
 
<form action="PaperMaintMain.php?PaperID=<?php echo $_GET['PaperID']; ?>" method="post">
	<head>	
		<script type="text/javascript">
		// onclick="showdiv(this);"
			function showdiv(btn){
				if(btn.checked)
					document.getElementById('divDepts').style.display = 'block';
				else
					document.getElementById('divDepts').style.display = 'none';
				//return false;
			}
		</script>
	</head>
	<br /><br />
	<h3 class="page-title" style="margin-left:5%">Paper Maintenance</h3>
	<div class="row-fluid">
		<div class="v_detail" style="margin-left:5%;height:120%">
			<table cellpadding="10" cellspacing="0" border="0" width="50%" class="tab_split">
				<tr>
					<td class="form_sec span4">&nbsp;</td>
					<td>
						<div class="span10">
							<input type="hidden" name="txtPaperID" value="<?php echo "{$PaperID}" ?>" />
							<?php 
							if(($_SESSION["ReadAccess"] == "Yes") && ($_SESSION["WriteAccess"] == "Yes")){
								if ($_GET['PaperID'] == "I") {
								echo "<input type='submit' onclick=\"return confirm('Edu. Year,Sem,Dept,Pattern and Subject can not be edited later. Are you sure?');\" name='btnUpdate' value='Save' title='Update' class='btn btn-mini btn-success' />";
								}
								else{
									echo "<input type='submit' name='btnUpdate' value='Save' title='Update' class='btn btn-mini btn-success' />";
								}
							}
							?>
							<a href="PaperListMain.php" class="btn btn-mini btn-warning">Cancel</a>
						</div>
					</td>								
				</tr>
				<tr>
					<td class="form_sec span4">Edu. Year - Sem</td>
					<td>
						<select name="ddlEnggYear" required <?php if ($_GET['PaperID'] != "I") {echo " readonly";} ?> >
							<option value="Select" <?php if($EnggYear == "Select") echo "selected"; ?>>Select</option>
							<option value="FE - Sem 1" <?php if($EnggYear == "FE - Sem 1") echo "selected"; ?>>FE - Sem 1</option>
							<option value="FE - Sem 2" <?php if($EnggYear == "FE - Sem 2") echo "selected"; ?>>FE - Sem 2</option>
							<option value="SE - Sem 1" <?php if($EnggYear == "SE - Sem 1") echo "selected"; ?>>SE - Sem 1</option>
							<option value="SE - Sem 2" <?php if($EnggYear == "SE - Sem 2") echo "selected"; ?>>SE - Sem 2</option>
							<option value="TE - Sem 1" <?php if($EnggYear == "TE - Sem 1") echo "selected"; ?>>TE - Sem 1</option>
							<option value="TE - Sem 2" <?php if($EnggYear == "TE - Sem 2") echo "selected"; ?>>TE - Sem 2</option>
							<option value="BE - Sem 1" <?php if($EnggYear == "BE - Sem 1") echo "selected"; ?>>BE - Sem 1</option>
							<option value="BE - Sem 2" <?php if($EnggYear == "BE - Sem 2") echo "selected"; ?>>BE - Sem 2</option>
							<option value="FY - Sem 1" <?php if($EnggYear == "FY - Sem 1") echo "selected"; ?>>FYMTech - Sem 1</option>
							<option value="FY - Sem 2" <?php if($EnggYear == "FY - Sem 2") echo "selected"; ?>>FYMTech - Sem 2</option>
							<option value="SY - Sem 1" <?php if($EnggYear == "SY - Sem 1") echo "selected"; ?>>SYMTech - Sem 1</option>
							<option value="SY - Sem 2" <?php if($EnggYear == "SY - Sem 2") echo "selected"; ?>>SYMTech - Sem 2</option>
						</select>
					</td>
				</tr>
				<tr>
					<td class="form_sec span4">Department</td>
					<td>
						<select name="ddlDept" style="width:30%;margin-top:10px" required <?php if ($_GET['PaperID'] != "I") {echo " readonly";} ?>>
							<?php
							include 'db/db_connect.php';
							$sql = "SELECT 0 as MDeptId, 'Select '  as DeptName, -1 as orderno UNION SELECT DeptID as MDeptId, DeptName , orderno From tbldepartmentmaster where COALESCE(Teaching,0) = 1 order by orderno ;";
							$result1 = $mysqli->query( $sql );
							while( $row = $result1->fetch_assoc() ) {
							extract($row);
							 if ($DeptID == $MDeptId){
									echo "<option value={$MDeptId} selected>{$DeptName}</option>"; 
								}
								else{
									echo "<option value={$MDeptId}>{$DeptName}</option>"; 
								}
							}
							?>
						</select>
					</td>
				</tr>						
				<tr>
					<td class="form_sec span4">Pattern</td>
					<td>
						<select  id="ddlPattern" name="ddlPattern" required <?php if ($_GET['PaperID'] != "I") {echo " readonly";} ?>>
							<?php
							include 'db/db_connect.php';
							echo "<option value=''>Select</option>"; 
							$sql = "SELECT distinct teachingpat as PatternText FROM tblpatternmaster order by teachingpat;";
							$result1 = $mysqli->query( $sql );
							while( $row = $result1->fetch_assoc() ) {
							extract($row);
							if((isset($EnggPattern) && $EnggPattern== $PatternText)){
									echo "<option value={$PatternText} selected>{$PatternText}</option>"; 
								}
								else{
									echo "<option value={$PatternText}>{$PatternText}</option>"; 
								}
							}
							
							?>
						</select>

					</td>
				</tr>
				<tr>
					<td class="form_sec span4">Subject</td>
					<td>
						<select name="ddlSubject" style="width:99%;margin-top:10px" required <?php if ($_GET['PaperID'] != "I") {echo " readonly";} ?> >
							<?php
							include 'db/db_connect.php';
							$sql = "SELECT 0 as MSubjectId, 'Select '  as SubjectName UNION SELECT SubjectID as MSubjectId, SubjectName 
									From tblsubjectmaster order by SubjectName;";
							$result1 = $mysqli->query( $sql );
							while( $row = $result1->fetch_assoc() ) {
							extract($row);
							 if ($SubjectID == $MSubjectId){
									echo "<option value={$MSubjectId} selected>{$SubjectName}</option>"; 
								}
								else{
									echo "<option value={$MSubjectId}>{$SubjectName}</option>"; 
								}
							}
							?>
						</select>
						<b>Is Elective?</b>
						<input type="checkbox" name="chkIsElective" style=margin-left class="checked" <?php echo ($IsElective == '1' ? 'checked' : ''); ?>/>
						<select name="ddlElectiveNo" style="margin-top:10px">
							<option value="0" <?php if($ElectiveNo == "0") echo "selected"; ?>>Select</option>
							<option value="1" <?php if($ElectiveNo == "1") echo "selected"; ?>>I</option>
							<option value="2" <?php if($ElectiveNo == "2") echo "selected"; ?>>II</option>
							<option value="3" <?php if($ElectiveNo == "3") echo "selected"; ?>>III</option>
							<option value="4" <?php if($ElectiveNo == "4") echo "selected"; ?>>IV</option>
						</select>
						</br><b>Is Open elective?</b>
							<input type="checkbox" name="chkIsopenelective" class="checked" 
							<?php echo ($IsOpenElective == '1' ? 'checked' : ''); ?>/>
							</br>
							<div id="divDepts">
							Select Departments:<br/>
							<?php
							include 'db/db_connect.php';
							$query2 = "SELECT dm.DeptID, DeptName AS Department2 ,
										COALESCE(pd.deptid,0) AS PaperDeptID
										FROM tbldepartmentmaster dm
										LEFT OUTER JOIN tblpaperdept pd ON dm.DeptID = pd.deptid 
										AND PaperID = " . $_GET['PaperID'] . "
										WHERE COALESCE(Teaching,0) = 1 ORDER BY dm.DeptID";
									$result2 = $mysqli->query( $query2 );
									$num_results2 = $result2->num_rows;
									if( $num_results2 ){
										while( $row2 = $result2->fetch_assoc() ){
											extract($row2);
											echo "{$Department2}<input value='$DeptID' onclick='return deptcheck(this);' id='chkdept[]' name='chkdept[]' 
											class='checkbox-class' type='checkbox' " .
											($PaperDeptID == $DeptID ?  'checked' : '') . 
											" />&nbsp;&nbsp;&nbsp;&nbsp;";
										}
									}
							?>
							</div>
					</td>
				</tr>						
				<tr>
					<td class="form_sec span4">Paper Subject Code</td><td>
						<div class="span10">
							<input type="text" maxlength="20" name="txtPaperCode" class="textfield" required style="width:250px;"
 value="<?php echo "{$PaperCode}" ?>"/>
						</div>
					</td>
				</tr>						
				<tr>
					<td class="form_sec span4">Subject Display Name</td><td>
						<div class="span10">
							<input type="text" maxlength="35" name="txtSubDispName" class="textfield" value="<?php echo "{$SubDispName}" ?>"/>
						</div>
					</td>
				</tr>
				<tr>
					<td class="form_sec span4">Subject Short Name</td><td>
						<div class="span10">
							<input type="text" maxlength="10" name="txtSubShortName" class="textfield" value="<?php echo "{$SubShortName}" ?>"/>
						</div>
					</td>
				</tr>
				<tr>
					<td class="form_sec span4">Structure Order</td><td>
						<div class="span10">
							<select name="ddlstructorder" style="margin-top:10px">
								<option value="0" <?php if($structorder == "0") echo "selected"; ?>>Select</option>
								<option value="1" <?php if($structorder == "1") echo "selected"; ?>>1</option>
								<option value="2" <?php if($structorder == "2") echo "selected"; ?>>2</option>
								<option value="3" <?php if($structorder == "3") echo "selected"; ?>>3</option>
								<option value="4" <?php if($structorder == "4") echo "selected"; ?>>4</option>
								<option value="5" <?php if($structorder == "5") echo "selected"; ?>>5</option>
								<option value="6" <?php if($structorder == "6") echo "selected"; ?>>6</option>
								<option value="7" <?php if($structorder == "7") echo "selected"; ?>>7</option>
								<option value="8" <?php if($structorder == "8") echo "selected"; ?>>8</option>
								<option value="9" <?php if($structorder == "9") echo "selected"; ?>>9</option>
								<option value="10" <?php if($structorder == "10") echo "selected"; ?>>10</option>
								<option value="11" <?php if($structorder == "11") echo "selected"; ?>>11</option>
								<option value="12" <?php if($structorder == "12") echo "selected"; ?>>12</option>
								<option value="13" <?php if($structorder == "13") echo "selected"; ?>>13</option>
								<option value="14" <?php if($structorder == "14") echo "selected"; ?>>14</option>
								<option value="15" <?php if($structorder == "15") echo "selected"; ?>>15</option>
								<option value="16" <?php if($structorder == "16") echo "selected"; ?>>16</option>
								<option value="17" <?php if($structorder == "17") echo "selected"; ?>>17</option>
								<option value="18" <?php if($structorder == "18") echo "selected"; ?>>18</option>
								<option value="19" <?php if($structorder == "19") echo "selected"; ?>>19</option>
								<option value="20" <?php if($structorder == "20") echo "selected"; ?>>20</option>
							</select>
						</div>
					</td>
				</tr>
				<tr>
					<td class="form_sec span4">Theory Credits</td><td>
						<div class="span10">
							<input type="text" maxlength="10" name="txtCredits" class="textfield" value="<?php echo "{$credits}" ?>" required/>
						</div>
					</td>
				</tr>
				<tr>
					<td class="form_sec span4">PR / OR Credits</td><td>
						<div class="span10">
							<input type="text" maxlength="10" name="txtPRORCredits" class="textfield" value="<?php echo "{$prorcredits}" ?>"/>
						</div>
					</td>
				</tr>
				<tr>
					<td class="form_sec span4" colspan="2"><center>Teaching Scheme</center></td>
				</tr>
				<tr>
					<td class="form_sec span4">Lecture</td><td>
						<div class="span10">
							<input type="checkbox" name="chkLectureapp" style=margin-left class="checked" <?php echo ($Lectureapp == '1' ? 'checked' : ''); ?>/>
							<input type="text" maxlength="7" name="txtLecture" class="input-mini" value="<?php echo "{$Lecture}" ?>"/>
						</div>
					</td>
				</tr>
				<tr>
					<td class="form_sec span4">Tutorial</td><td>
						<div class="span10">
							<input type="checkbox" name="chkTutorialapp" style=margin-left class="checked" <?php echo ($Tutorialapp == '1' ? 'checked' : ''); ?>/>
							<input type="text" maxlength="7" name="txtTutorial" class="input-mini" value="<?php echo "{$Tutorial}" ?>"/>
						</div>
					</td>
				</tr>
				<tr>
					<td class="form_sec span4">Practical</td><td>
						<div class="span10">
						<input type="checkbox" name="chkPracticalapp" style=margin-left class="checked" <?php echo ($Practicalapp == '1' ? 'checked' : ''); ?>/>
						<input type="text" maxlength="7" name="txtPractical" class="input-mini" value="<?php echo "{$Practical}" ?>"/>
						</div>
					</td>
				</tr>
				<tr>
					<td class="form_sec span4">Exam Only</td><td>
						<div class="span10">
						<input type="checkbox" name="chkEOapp" style=margin-left class="checked" <?php echo ($EOApp == '1' ? 'checked' : ''); ?>/>
						<input type="text" maxlength="7" name="txtEO" class="input-mini" value="<?php echo "{$EO}" ?>"/>
						</div>
					</td>
				</tr>
				<tr>
					<td class="form_sec span4" colspan="2"><center>Examination Scheme (Marks)</center></td>
				</tr>
				<tr>
					<td class="form_sec span4">In-Sem</td><td>
						<div class="span10">
						<input type="checkbox" name="chkInSemapp" style=margin-left class="checked" <?php echo ($InSemapp == '1' ? 'checked' : ''); ?>/>
						<input type="text" maxlength="7" name="txtInSem" class="input-mini" value="<?php echo "{$InSem}" ?>"/>
						</div>
					</td>
				</tr>
				<tr>
					<td class="form_sec span4">Online</td><td>
						<div class="span10">
						<input type="checkbox" name="chkOnlineapp" style=margin-left class="checked" <?php echo ($Onlineapp == '1' ? 'checked' : ''); ?>/>
						<input type="text" maxlength="7" name="txtOnline" class="input-mini" value="<?php echo "{$Online}" ?>"/>	
						</div>
					</td>
				</tr>
				<tr>
					<td class="form_sec span4">Paper (PP)</td><td>
						<div class="span10">
						<input type="checkbox" name="chkPaperapp" style=margin-left class="checked" <?php echo ($Paperapp == '1' ? 'checked' : ''); ?>/>
						<input type="text" maxlength="7" name="txtPaper" class="input-mini" value="<?php echo "{$Paper}" ?>"/>
							</div>
					</td>
				</tr>
				<tr>
					<td class="form_sec span4">Term Work (TW)</td><td>
						<div class="span10">
						<input type="checkbox" name="chkTermWorkapp" style=margin-left class="checked" <?php echo ($TermWorkapp == '1' ? 'checked' : ''); ?>/>
						<input type="text" maxlength="7" name="txtTermWork" class="input-mini" value="<?php echo "{$TermWork}" ?>"/>
						</div>
					</td>
				</tr>
				<tr>
					<td class="form_sec span4">Practical (PR)</td><td>
						<div class="span10">
						<input type="checkbox" name="chkPracticalPRapp" style=margin-left class="checked" <?php echo ($PracticalPRapp == '1' ? 'checked' : ''); ?>/>
						<input type="text" maxlength="7" name="txtPracticalPR" class="input-mini" value="<?php echo "{$PracticalPR}" ?>"/>
						</div>
					</td>
				</tr>
				<tr>
					<td class="form_sec span4">Oral (OR)</td><td>
						<div class="span10">
						<input type="checkbox" name="chkOralORapp" style=margin-left class="checked" <?php echo ($OralORapp == '1' ? 'checked' : ''); ?>/>
						<input type="text" maxlength="7" name="txtOralOR" class="input-mini" value="<?php echo "{$OralOR}" ?>"/>
						</div>
					</td>
				</tr>
				<tr>
					<td class="form_sec span4" colspan="2"><center></center></td>
				</tr>
				<tr>
					<td class="form_sec span4">Stationary</td><td>
						<div class="span10">
							<input type="text" maxlength="50" name="txtStationary" class="input-mini" value="<?php echo "{$Stationary}" ?>"/>
						</div>
					</td>
				</tr>				
				<tr>
					<td class="form_sec span4">Marklist Subject Code</td><td>
						<div class="span10">
							<input type="text" maxlength="20" name="txtExamPaperCode" class="textfield" value="<?php echo "{$ExamPaperCode}" ?>"/>
						</div>
					</td>
				</tr>	
				<tr>
					<td class="form_sec span4">Active</td>
					<td>
							<input type="checkbox" name="chkActive" class="checked" <?php echo ($Active == '1' ? 'checked' : ''); ?>/>
					</td>
				</tr>				
			</table>
		</div>
	</div>
</form>

