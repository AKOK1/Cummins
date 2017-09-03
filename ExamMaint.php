<?php
//include database connection
include 'db/db_connect.php';
/*

	SELECT @a:=@a+1, CONCAT(BlockName, '@10.00 AM to 10.30 AM'), BlockType, BlockCapacity, Active, CURRENT_TIMESTAMP, 'Admin', CURRENT_TIMESTAMP, 'Admin', @a:=@a+1 
	FROM tblblocksmaster , (SELECT @a:= 100) AS a WHERE BlockType = 'Laboratory' AND examid IS NULL 

	SELECT CONCAT('@', timefrom, ' ', ampmfr, ' ',  'to', ' ', timeto, ' ', ampmto) FROM tblbatchtimemaster ORDER BY timeorder

*/ 
 
// if the form was suSr1Startbmitted/posted, update the record
	If (isset($_POST['btnUpdateList'])){
 	if ($_GET['ExamID'] == 'I') {}
		else {
			If ($_POST['TL'] == ''){}
			else {
				//header("Location: ExamListUpd.php?ExamID=" . $_GET['ExamID'] . "&batchname=" . $_POST['TL'] . ""); 
				//------------				
				$sql = "UPDATE tblexammaster SET  timelist = ? WHERE ExamID = ?";

				$stmt = $mysqli->prepare($sql);
				$stmt->bind_param('si', $_POST['TL'], $_GET['ExamID']  );
				if($stmt->execute()){} 
				else{ echo $mysqli->error;}
				
				$sql = "DELETE FROM tblblocksmaster WHERE examid  = ? ;";
				$stmt = $mysqli->prepare($sql);
				$stmt->bind_param('i', $_GET['ExamID']  );
				if($stmt->execute()){} 
				else{ echo $mysqli->error;}

				
				$sql = " SELECT CONCAT('@', timefrom, ' ', ampmfr, ' ',  'to', ' ', timeto, ' ', ampmto) AS BatchTime FROM tblbatchtimemaster 
						Where batchname = '" .  $_POST['TL']  . "' ORDER BY timeorder ";
				// execute the sql query
				$result = $mysqli->query( $sql );
				$num_results = $result->num_rows;
				$i = 100;
				if( $num_results ){
					while( $row = $result->fetch_assoc() ){
						extract($row);
						$sql = "INSERT INTO tblblocksmaster (BlockNo, BlockName, BlockType, BlockCapacity, Active, created_on, created_by, updated_on, updated_by, colorder, examid)
						SELECT @a:=@a+1, CONCAT(BlockName, ' " .  $BatchTime. "'), BlockType, BlockCapacity, Active, CURRENT_TIMESTAMP, 'Admin', CURRENT_TIMESTAMP, 'Admin', @a:=@a+1 , ?
						FROM tblblocksmaster , (SELECT @a:= ". $i . ") AS a WHERE coalesce(active,0) = 1 and BlockType = 'Laboratory' AND examid IS NULL ORDER BY colorder ";
						$stmt = $mysqli->prepare($sql);
						$stmt->bind_param('i', $_GET['ExamID']  );
						if($stmt->execute()){} 
						else{echo $mysqli->error;}

						$i = $i + 100;
					}
				}	
				//---------------
				
				
				
			}
		}
	}

 if($_POST)
	{
		if($_POST['dtretestStart'] != ''){
			//$dt1 = date('m/d/Y', strtotime($_POST['dtretestStart']));
			$dt1re = $_POST['dtretestStart'];
		}
		if($_POST['dtretestEnd'] != ''){
			//$dt2 = date('m/d/Y', strtotime($_POST['dtretestEnd']));
			$dt2re = $_POST['dtretestEnd'];
		}
		if($_POST['dtPubStart'] != ''){
			//$dt1 = date('m/d/Y', strtotime($_POST['dtPubStart']));
			$dt1 = $_POST['dtPubStart'];
		}
		if($_POST['dtPubEnd'] != ''){
			//$dt2 = date('m/d/Y', strtotime($_POST['dtPubEnd']));
			$dt2 = $_POST['dtPubEnd'];
		}
		if($_POST['Sr1Start'] != ''){
			//$Sr1 = date('m/d/Y', strtotime($_POST['Sr1Start']));
			$Sr1 = $_POST['Sr1Start'];
		}
		if($_POST['Sr1End'] != ''){
			//$Sr1 = date('m/d/Y', strtotime($_POST['Sr1Start']));
			$Sr1E = $_POST['Sr1End'];
		}
		if($_POST['Sr2Start'] != ''){
			//$Sr1 = date('m/d/Y', strtotime($_POST['Sr1Start']));
			$Sr2 = $_POST['Sr2Start'];
		}
		if($_POST['Sr2End'] != ''){
			//$Sr1 = date('m/d/Y', strtotime($_POST['Sr1Start']));
			$Sr2E = $_POST['Sr2End'];
		}
				
		if($_POST['Cus1Start'] != ''){
			//$Sr1 = date('m/d/Y', strtotime($_POST['Sr1Start']));
			$Cus1 = $_POST['Cus1Start'];
		}
		if($_POST['Cus1End'] != ''){
			//$Sr1 = date('m/d/Y', strtotime($_POST['Sr1Start']));
			$Cus1E = $_POST['Cus1End'];
		}
		if($_POST['Cus2Start'] != ''){
			//$Sr1 = date('m/d/Y', strtotime($_POST['Sr1Start']));
			$Cus2 = $_POST['Cus2Start'];
		}
		if($_POST['Cus2End'] != ''){
			//$Sr1 = date('m/d/Y', strtotime($_POST['Sr1Start']));
			$Cus2E = $_POST['Cus2End'];
		}
			
		if($_POST['SK1Start'] != ''){
			//$Sr1 = date('m/d/Y', strtotime($_POST['Sr1Start']));
			$SK1 = $_POST['SK1Start'];
		}
		if($_POST['SK1End'] != ''){
			//$Sr1 = date('m/d/Y', strtotime($_POST['Sr1Start']));
			$SK1E = $_POST['SK1End'];
		}
		if($_POST['SK2Start'] != ''){
			//$Sr1 = date('m/d/Y', strtotime($_POST['Sr1Start']));
			$SK2 = $_POST['SK2Start'];
		}
		if($_POST['SK2End'] != ''){
			//$Sr1 = date('m/d/Y', strtotime($_POST['Sr1Start']));
			$SK2E = $_POST['SK2End'];
		}			
		// if($_POST['txtAcadYearFrom'] != ''){
			// //$Sr1 = date('m/d/Y', strtotime($_POST['Sr1Start']));
			// $AcadYearFrom = $_POST['txtAcadYearFrom'];
		// }			
		// if($_POST['txtAcadYearTo'] != ''){
			// //$Sr1 = date('m/d/Y', strtotime($_POST['Sr1Start']));
			// $AcadYearTo = $_POST['txtAcadYearTo'];
		// }			
		// if($_POST['txtSem'] != ''){
			// //$Sr1 = date('m/d/Y', strtotime($_POST['Sr1Start']));
			// $Sem = $_POST['txtSem'];
		// }			
		if($_POST['txtRTM'] != ''){
			//$Sr1 = date('m/d/Y', strtotime($_POST['Sr1Start']));
			$RTM = $_POST['txtRTM'];
		}			
		if($_POST['txtRTE'] != ''){
			//$Sr1 = date('m/d/Y', strtotime($_POST['Sr1Start']));
			$RTE = $_POST['txtRTE'];
		}			
		if($_POST['TA'] != ''){
			//$Sr1 = date('m/d/Y', strtotime($_POST['Sr1Start']));
			$TA = $_POST['TA'];
		}			

		if($_POST['TAStart'] != ''){
			//$Sr1 = date('m/d/Y', strtotime($_POST['Sr1Start']));
			$TAStart = $_POST['TAStart'];
		}			
		if($_POST['TAEnd'] != ''){
			//$Sr1 = date('m/d/Y', strtotime($_POST['Sr1Start']));
			$TAEnd = $_POST['TAEnd'];
		}			
		if($_POST['AC'] != ''){
			//$Sr1 = date('m/d/Y', strtotime($_POST['Sr1Start']));
			$AC = $_POST['AC'];
		}			
		if($_POST['ACStart'] != ''){
			//$Sr1 = date('m/d/Y', strtotime($_POST['Sr1Start']));
			$ACStart = $_POST['ACStart'];
		}			
		if($_POST['ACEnd'] != ''){
			//$Sr1 = date('m/d/Y', strtotime($_POST['Sr1Start']));
			$ACEnd = $_POST['ACEnd'];
		}			

		if($_POST['TL'] != ''){
			//$Sr1 = date('m/d/Y', strtotime($_POST['Sr1Start']));
			$TL = $_POST['TL'];
		}			
		
		if ($_GET['ExamID'] == "I") {
		$sql = "Insert into tblexammaster ( ExamName, ExamType,  ProfViewEnabled, SatCount, EveCount,PubStart, PubEnd,Sr1Start,Sr1End,Sr2Start,Sr2End,Cus1Start,Cus1End,Cus2Start,Cus2End,SK1Start,SK1End,SK2Start,SK2End, MinPrefCount, MaxPrefCount, Sr1Name,
		Sr2Name,Cus1Name,Cus2Name,SK1Name,SK2Name, created_by, created_on, updated_by, Updated_on,ListID,Sem,examcat,
		examtype2,AcadYearFrom,AcadYearTo,studdiv,RTM,RTE,TA,TAStart,TAEnd,AC,ACStart,ACEnd,timelist,reteststart,retestend,publishresult,processresult) 
				Values ( ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?, 
				'Admin', CURRENT_TIMESTAMP, 'Admin', CURRENT_TIMESTAMP,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";

			$stmt = $mysqli->prepare($sql);
			$stmt->bind_param('ssiiissssssssssssssiiisssssississssssssssssssii', $_POST['txtExamName'], $_POST['ddlExamType'], 
			$_POST['chkProfViewEnabled'],  $_POST['txtSatCount'], $_POST['txtEveCount'], $dt1, $dt2,$Sr1,$Sr1E,$Sr2,$Sr2E,
			$Cus1,$Cus1E,$Cus2,$Cus2E,  $SK1,$SK1E,$SK2,$SK2E,  $_POST['txtMinPrefCount'] , $_POST['txtMaxPrefCount'], $_POST['ddlsrsup1'],
			$_POST['Sr2Name'],$_POST['Cus1Name'],$_POST['Cus2Name'],$_POST['SK1Name'],$_POST['SK2Name'],$_POST['ddlList'],$_POST['ddlsem']
			,$_POST['ddlexamcat'],$_POST['ddlexamtype2'],substr($_POST['ddlAcadYear'],0,4),substr($_POST['ddlAcadYear'],5,4),$_POST['ddlstuddiv'],$RTM,$RTE,
			$TA,$TAStart,$TAEnd,$AC,$ACStart,$ACEnd, $TL,$dt1re,$dt2re,$_POST['chkpublishresult'],$_POST['chkprocessresult']);

		}
		else {
			if (isset($_POST['chkpublishresult'])) {
				$tmpchkpublishresult = '1';
			}
			else
				$tmppublishresult = '0';

			if (isset($_POST['chkprocessresult'])) {
				$tmpchkprocessresult = '1';
			}
			else
				$tmpprocessresult = '0';
			
			if (isset($_POST['chkProfViewEnabled'])) {
				$tmpchkProfViewEnabled = '1';
			}
			else
				$tmpchkProfViewEnabled = '0';
			
			$sql = "UPDATE  tblexammaster
					Set ExamName = ?
						,ExamType = ?
						,ProfViewEnabled = ?
						,SatCount = ?
						,EveCount = ?
						,PubStart = ?
						,PubEnd = ?
						,Sr1Start = ?
						,Sr1End = ?
						,Sr2Start = ?
						,Sr2End = ?
						,Cus1Start = ?
						,Cus1End = ?
						,Cus2Start = ?
						,Cus2End = ?						
						,SK1Start = ?
						,SK1End = ?
						,SK2Start = ?
						,SK2End = ?
						,MinPrefCount = ?
						,MaxPrefCount = ?
						,Sr1Name = ?
						,Sr2Name = ?
						,Cus1Name = ?
						,Cus2Name = ?
						,SK1Name = ?
						,SK2Name = ?						
						,updated_by = 'Admin'
						,updated_on = CURRENT_TIMESTAMP
						,ListID = ?
						,Sem = ?
						,examcat = ?
						,examtype2 = ?
						,AcadYearFrom = ?
						,AcadYearTo = ?
						,studdiv = ?
						,RTM = ?
						,RTE = ?
						,TA = ?
						,TASTART = ?
						,TAEND = ?
						,AC = ?
						,ACStart = ?
						,ACEnd = ?
						,timelist = ?
						,reteststart = ?
						,retestend = ?
						,publishresult = ?
						,processresult = ?
					Where ExamID = ?";
					
			
			$stmt = $mysqli->prepare($sql);
			$stmt->bind_param('ssiiissssssssssssssiiisssssiissssssssssssssssiii', $_POST['txtExamName'], $_POST['ddlExamType'],$tmpchkProfViewEnabled, 
			$_POST['txtSatCount'], $_POST['txtEveCount'], $dt1, $dt2,$Sr1,$Sr1E, $Sr2,$Sr2E,$Cus1,$Cus1E, $Cus2,$Cus2E,$SK1,$SK1E, 
			$SK2,$SK2E,$_POST['txtMinPrefCount'], $_POST['txtMaxPrefCount'], $_POST['ddlsrsup1'] ,$_POST['ddlsrsup2'],$_POST['ddlCus1Name'],
			$_POST['ddlCus2Name'],$_POST['ddlSK1Name'] ,$_POST['ddlSK2Name'],$_POST['ddlList'],
			$_POST['ddlsem'],$_POST['ddlexamcat'],$_POST['ddlexamtype2'],substr($_POST['ddlAcadYear'],0,4),substr($_POST['ddlAcadYear'],5,4),$_POST['ddlstuddiv'],
			$RTM,$RTE,$TA,$TAStart,$TAEnd,$AC,$ACStart,$ACEnd,$TL,$dt1re,$dt2re,$tmpchkpublishresult,$tmpchkprocessresult,
			$_POST['txtExamID'] );
			
		}
		//echo $sql;
		// execute the update statement
		if($stmt->execute()){
			echo $mysqli->error;
			header('Location: ExamListMain.php?'); 
			// close the prepared statement
		}else{
			echo $mysqli->error;
			die("Unable to update2.");
		}	

	}
else 
	{
		if ($_GET['ExamID'] == "I") {
			$sql = "Select '' as ExamID, '' as ExamName,'' as Sr1Name,'' as Sr2Name,'' as Cus1Name,'' as Cus2Name,'' as SK1Name,
			'' as SK2Name, '' as Sr1NameL, '' as Sr2NameL,'' as Cus1NameL,'' as Cus2NameL,'' as SK1NameL,
			'' as SK2NameL,'Select ' as ExamType, '0' as ProfViewEnabled, '0' as SatCount, '0' as EveCount, '' as PubStart, 
			'' as PubEnd,'' as Sr1Start,'' as Sr1End,'' as Sr2Start,'' as Sr2End, '' as Cus1Start,'' as Cus1End,'' as Cus2Start,
			'' as Cus2End, '' as SK1Start,'' as SK1End,'' as SK2Start,'' as SK2End, '0' as MinPrefCount, '0' as MaxPrefCount, 
			'0' as ListID,'' as Sem,'' as examcat,'' as examtype2,'' as acadyear,'' as studdiv, '' as RTM, '' as RTE, '' as TA, '' as TAStart, '' as TAEnd, 
			'' as AC, '' as ACStart, '' as ACEnd, '' as TL,'' as reteststart,'' as retestend, '0' as publishresult , '0' as processresult " ;
		}
		Else
		{
			$sql = " SELECT ExamID, ExamName, Sr1Name,Sr2Name,Cus1Name,Cus2Name,SK1Name,SK2Name,CONCAT(u1.FirstName,' ',u1.LastName) AS Sr1NameL,CONCAT(u2.FirstName,' ',u2.LastName) AS Sr2NameL,
					CONCAT(u3.FirstName,' ',u3.LastName) AS Cus1NameL,CONCAT(u4.FirstName,' ',u4.LastName) AS Cus2NameL,
					CONCAT(u5.FirstName,' ',u5.LastName) AS SK1NameL,CONCAT(u6.FirstName,' ',u6.LastName) AS SK2NameL, 
					CONCAT(u7.FirstName,' ',u7.LastName) AS TAL,
					CONCAT(u8.FirstName,' ',u8.LastName) AS ACL,
					ExamType, COALESCE(ProfViewEnabled,0) AS ProfViewEnabled, SatCount, EveCount, PubStart, PubEnd,Sr1Start,Sr1End,Sr2Start,
					Sr2End, Cus1Start,Cus1End,Cus2Start,Cus2End,SK1Start,SK1End,SK2Start,SK2End, MinPrefCount, MaxPrefCount,ListID ,
					Sem,examcat,examtype2,CONCAT(AcadYearFrom,'-',AcadYearTo) as acadyear,studdiv,RTM,RTE,TA,TAStart,TAEnd,AC,ACStart,ACEnd, COALESCE(timelist, 'TL') as TL,
					reteststart,retestend, coalesce(publishresult,0) as publishresult, coalesce(processresult,0) as processresult
					FROM tblexammaster em 
					LEFT OUTER JOIN tbluser u1 ON u1.userID = em.Sr1Name
					LEFT OUTER JOIN tbluser u2 ON u2.userID = em.Sr2Name
					LEFT OUTER JOIN tbluser u3 ON u3.userID = em.Cus1Name
					LEFT OUTER JOIN tbluser u4 ON u4.userID = em.Cus2Name
					LEFT OUTER JOIN tbluser u5 ON u5.userID = em.SK1Name
					LEFT OUTER JOIN tbluser u6 ON u6.userID = em.SK2Name
					LEFT OUTER JOIN tbluser u7 ON u7.userID = em.TA
					LEFT OUTER JOIN tbluser u8 ON u8.userID = em.AC
					WHERE ExamID = " . $_GET['ExamID'] ;
		} 
		
		// execute the sql query
		$result = $mysqli->query( $sql );
		$row = $result->fetch_assoc();
		extract($row);
		 
		//disconnect from database
		$result->free();
		$mysqli->close();
	}
	
?>

<form action="ExamMaintMain.php?ExamID=<?php echo $_GET['ExamID']; ?>" method="post">
	<script>
  
		//$(function(){
			//$('*[name=date]').appendDtpicker();
		//});
		$(function() {
		//$( "#datepicker1" ).datepicker({ dateFormat: 'dd-M-yy' });
		//$( "#datepicker2" ).datepicker({ dateFormat: 'dd-M-yy' });
		$( "#datepicker1" ).appendDtpicker();
		$( "#datepicker2" ).appendDtpicker();
		$( "#datepicker3" ).appendDtpicker();
		$( "#datepicker4" ).appendDtpicker();
		$( "#datepicker5" ).appendDtpicker();
		$( "#datepicker6" ).appendDtpicker();
		$( "#datepicker7" ).appendDtpicker();
		$( "#datepicker8" ).appendDtpicker();
		$( "#datepicker9" ).appendDtpicker();
		$( "#datepicker10" ).appendDtpicker();
		
		$( "#datepicker11" ).appendDtpicker();
		$( "#datepicker12" ).appendDtpicker();
		$( "#datepicker13" ).appendDtpicker();
		$( "#datepicker14" ).appendDtpicker();
		$( "#datepicker15" ).appendDtpicker();
		$( "#datepicker16" ).appendDtpicker();
		$( "#datepicker17" ).appendDtpicker();
		$( "#datepicker18" ).appendDtpicker();
		$( "#datepicker19" ).appendDtpicker();
		$( "#datepicker20" ).appendDtpicker();
		});


		</script>
	<br /><br />
	<h3 class="page-title" style="margin-left:5%">Exam Master Maintenance - <b><?php echo ($ExamName); ?></b></h3>

	<div class="row-fluid">
									<div class="span10" style="margin-left:5%">
							<input type="hidden" name="txtExamID" value="<?php echo "{$ExamID}" ?>" />
							<input type="hidden" name="selectedbatch" id="selectedbatch" value="">
							<?php 
							if(($_SESSION["ReadAccess"] == "Yes") && ($_SESSION["WriteAccess"] == "Yes")){
								echo "<input type='submit' name='btnUpdate' value='Save' title='Update' class='btn btn-mini btn-success' />";
							}
							?>
							<a href="ExamListMain.php" class="btn btn-mini btn-warning">Cancel</a>
						</div>
						<br/><br/>
		<div class="v_detail" style="margin-left:5%">
			<table cellpadding="10" cellspacing="0" border="0" width="50%" class="tab_split">
				<tr>
					<td class="form_sec span4">&nbsp;</td>
					<td>

					</td>								
				</tr>
				<tr>
					<td class="form_sec span4">Name</td><td>
						<div class="span10">
							<input type="text" maxlength="50" name="txtExamName" class="textfield" value="<?php echo "{$ExamName}" ?>" required/>
						</div>
					</td>
				</tr>						
				<tr>
					<td class="form_sec span4">Online / Theory</td>
					<td>
						<select name="ddlExamType" style="width:120px;">
							<option value="Theory" <?php if($ExamType == "Theory") echo "selected"; ?>>Theory</option>
							<option value="Online" <?php if($ExamType == "Online") echo "selected"; ?>>Online</option>
						</select>
					</td>
				</tr>						
				<tr>
					<td class="form_sec span4">Semester</td>
					<td>
						<select name="ddlsem" style="width:120px;">
							<option value="1" <?php if($Sem == "1") echo "selected"; ?>>1</option>
							<option value="2" <?php if($Sem == "2") echo "selected"; ?>>2</option>
							<option value="3" <?php if($Sem == "3") echo "selected"; ?>>3</option>
						</select>
					</td>
				</tr>
				<tr>
					<td class="form_sec span4">Exam Type</td>
					<td>
						<select name="ddlexamtype2" style="width:120px;">
							<option value="In-Sem (T1)" <?php if($examtype2 == "In-Sem (T1)") echo "selected"; ?>>In-Sem (T1)</option>
							<option value="In-Sem (T2)" <?php if($examtype2 == "In-Sem (T2)") echo "selected"; ?>>In-Sem (T2)</option>
							<option value="End-Sem" <?php if($examtype2 == "End-Sem") echo "selected"; ?>>End-Sem</option>
							<option value="Retest" <?php if($examtype2 == "Retest") echo "selected"; ?>>Retest</option>
						</select>
					</td>
				</tr>
				<tr>
					<td class="form_sec span1">Academic Year</td>
					<td>
						<select id="ddlAcadYear" name="ddlAcadYear" style="width:120px;">
								<option value="2014-2015" <?php if($acadyear == "2014-2015") echo "selected"; ?>>2014-15</option>
								<option value="2015-2016"<?php if($acadyear == "2015-2016") echo "selected"; ?>>2015-16</option>
								<option value="2016-2017"<?php if($acadyear == "2016-2017") echo "selected"; ?>>2016-17</option>
								<option value="2017-2018"<?php if($acadyear == "2017-2018") echo "selected"; ?>>2017-18</option>
						</select>
					</td>
				<tr>
					<td class="form_sec span4">Exam For</td>
					<td>
						<select name="ddlexamcat" style="width:120px;">
							<option value="SPPU" <?php if($examcat == "SPPU") echo "selected"; ?>>SPPU</option>
							<option value="Autonomy" <?php if($examcat == "Autonomy") echo "selected"; ?>>Autonomy</option>
						</select>
					</td>
				</tr>
				<tr>
					<td class="form_sec span4">Use Division of Students?</td>
					<td>
						<select name="ddlstuddiv" style="width:120px;">
							<option value="Yes" <?php if($studdiv == "Yes") echo "selected"; ?>>Yes</option>
							<option value="No" <?php if($studdiv == "No") echo "selected"; ?>>No</option>
						</select>
					</td>
				</tr>				
				<tr>
					<td class="form_sec span4">Reporting Time (Morning)</td><td>
						<div class="span10">
							<input type="text" maxlength="100" name="txtRTM" class="textfield" value="<?php echo "{$RTM}" ?>"/>
						</div>
					</td>
				</tr>						
				<tr>
					<td class="form_sec span4">Reporting Time (Evening)</td><td>
						<div class="span10">
							<input type="text" maxlength="100" name="txtRTE" class="textfield" value="<?php echo "{$RTE}" ?>"/>
						</div>
					</td>
				</tr>						
				<tr>
					<td class="form_sec span4">Prof View Enabled</td>
					<td>
							<input type="checkbox" name="chkProfViewEnabled" class="checked" <?php echo ($ProfViewEnabled == '1' ? 'checked' : ''); ?>/>
					</td>
				</tr>
				<tr>
					<td class="form_sec span4">Prof Preferences Start</td>
					<td>
						<input type="text" maxlength="17" id='datepicker1' name="dtPubStart" class="textfield" style="width:120px;" value="<?php echo "{$PubStart}" ?>"/>
					</td>
				</tr>
				<tr>
					<td class="form_sec span4">Prof Preferences End</td>
					<td>
						<input type="text" maxlength="17" id='datepicker2' name="dtPubEnd" style="width:120px;" class="textfield" value="<?php echo "{$PubEnd}" ?>"/>
					</td>
				</tr>
				<tr>
					<td class="form_sec span4">Retest Start</td>
					<td>
						<input type="text" maxlength="17" id='datepicker19' name="dtretestStart" class="textfield" style="width:120px;" value="<?php echo "{$reteststart}" ?>"/>
					</td>
				</tr>
				<tr>
					<td class="form_sec span4">Retest End</td>
					<td>
						<input type="text" maxlength="17" id='datepicker20' name="dtretestEnd" style="width:120px;" class="textfield" value="<?php echo "{$retestend}" ?>"/>
					</td>
				</tr>
				<tr>
					<td class="form_sec span4">Min Saturday Duties</td>
					<td>
						<input type="text" maxlength="2" name="txtSatCount" class="textfield" style="width:40px;" value="<?php echo "{$SatCount}" ?>"/>
					</td>
				</tr>						
				<tr>
					<td class="form_sec span4">Min Evening Duties</td>
					<td>
						<input type="text" maxlength="2" name="txtEveCount" class="textfield" style="width:40px;" value="<?php echo "{$EveCount}" ?>"/>
					</td>
				</tr>
				<tr>
					<td class="form_sec span4">Total Min Prof Duties</td>
					<td>
						<input type="text" maxlength="2" name="txtMinPrefCount" class="textfield" style="width:40px;" value="<?php echo "{$MinPrefCount}" ?>"/>
					</td>
				</tr>				
				<tr>
					<td class="form_sec span4">Total Max Prof Duties</td>
					<td>
						<input type="text" maxlength="2" name="txtMaxPrefCount" class="textfield" style="width:40px;" value="<?php echo "{$MaxPrefCount}" ?>"/>
					</td>
				</tr>		
				<tr>
					<td class="form_sec span4">List</td>
					<td>
						<select name="ddlList" style="width:50%;margin-top:10px">
							<?php
							include 'db/db_connect.php';
							$sql = "SELECT 0 as MListID, 'Select '  as ListName 
									UNION 
									SELECT ListID as MListID, ListName From tbllistmster where ListType = 'User'";
							//echo $sql;
							$result1 = $mysqli->query( $sql );
							while( $row = $result1->fetch_assoc() ) {
							extract($row);
							 if ($ListID == $MListID){
									echo "<option value={$MListID} selected>{$ListName}</option>"; 
								}
								else{
									echo "<option value={$MListID}>{$ListName}</option>"; 
								}
							}
							?>
						</select>
					</td>
				</tr>						
					<tr>
					<td class="form_sec span4">Sr. Supervisor 1 Name</td>
					<td>
					<?php
						include 'db/db_connect.php';
						echo "<select name='ddlsrsup1' style='width:220px'><option value=''>Select Sr Sup1</option>";
						$query = "SELECT userID, Concat(FirstName,' ',LastName) as UserName 
								FROM tbluser 
								WHERE userid IN (SELECT ItemID FROM tbllistdetails WHERE LISTID = {$ListID})
								order by UserName";
								//echo $query;
								echo "<br/>";
								echo "<br/>";
								echo "<br/>";
								echo "<br/>";
								$result = $mysqli->query( $query );
								$num_results = $result->num_rows;
								if( $num_results ){
										while( $row = $result->fetch_assoc() ){
											extract($row);
											if($userID == $Sr1Name){
												echo "<option value={$userID} selected>{$UserName}</option>"; 
											}
											else{
												echo "<option value={$userID}>{$UserName}</option>"; 
											}
										}										
									}
						echo "</select>";
						?>						
						<a target="_blank" href='SeniorSupervisor.php?edit=<?php echo $Sr1NameL; ?>&name2=<?php echo $ExamName ?>&name3=<?php echo $Sr1Start ?>&name4=<?php echo $Sr1End ?>'>Print </a>
					</td>
				</tr>	
				
				<tr>
					<td class="form_sec span4">Sr. Supervisor 1 Start</td>
					<td>
						<input type="text" id='datepicker3' name="Sr1Start" class="textfield" style="width:120px;" value="<?php echo "{$Sr1Start}" ?>"/>
					</td>
				</tr>
				<tr>
					<td class="form_sec span4">Sr. Supervisor 1 End</td>
					<td>
						<input type="text" id='datepicker4' name="Sr1End" class="textfield" style="width:120px;" value="<?php echo "{$Sr1End}" ?>"/>
					</td>
				</tr>
				<tr>
					<td class="form_sec span4">Sr. Supervisor 2 Name</td>
					<td>
						<?php
							include 'db/db_connect.php';
							echo "<select name='ddlsrsup2' style='width:220px'><option value=''>Select Sr Sup2</option>";
							$query = "SELECT userID, Concat(FirstName,' ',LastName) as UserName FROM tbluser 
								WHERE userid IN (SELECT ItemID FROM tbllistdetails WHERE LISTID = {$ListID})
								order by UserName";
									//echo $query;
									$result = $mysqli->query( $query );
									$num_results = $result->num_rows;
									if( $num_results ){
											while( $row = $result->fetch_assoc() ){
												extract($row);
												if($userID == $Sr2Name){
													echo "<option value={$userID} selected>{$UserName}</option>"; 
												}
												else{
													echo "<option value={$userID}>{$UserName}</option>"; 
												}
											}										
										}
							echo "</select>";
							?>
						<a target="_blank" href='SeniorSupervisor.php?edit=<?php echo $Sr2NameL; ?>&name2=<?php echo $ExamName ?>&name3=<?php echo $Sr2Start ?>&name4=<?php echo $Sr2End ?>'>Print </a>
					</td>
					
					<tr>
					<td class="form_sec span4">Sr. Supervisor 2 Start</td>
					<td>
						<input type="text" id='datepicker5' name="Sr2Start" class="textfield" style="width:120px;" value="<?php echo "{$Sr2Start}" ?>"/>
					</td>
				</tr>
				<tr>
					<td class="form_sec span4">Sr. Supervisor 2 End</td>
					<td>
						<input type="text" id='datepicker6' name="Sr2End" class="textfield" style="width:120px;" value="<?php echo "{$Sr2End}" ?>"/>
					</td>
				</tr>
				<tr>
					<td class="form_sec span4">Custodian 1 Name</td>
					<td>
					<?php
						include 'db/db_connect.php';
						echo "<select name='ddlCus1Name' style='width:220px'><option value=''>Select Custodian1</option>";
							$query = "SELECT userID, Concat(FirstName,' ',LastName) as UserName FROM tbluser 
								WHERE userid IN (SELECT ItemID FROM tbllistdetails WHERE LISTID = {$ListID})
								order by UserName";
								//echo $query;
								echo "<br/>";
								echo "<br/>";
								echo "<br/>";
								echo "<br/>";
								$result = $mysqli->query( $query );
								$num_results = $result->num_rows;
								if( $num_results ){
										while( $row = $result->fetch_assoc() ){
											extract($row);
											if($userID == $Cus1Name){
												echo "<option value={$userID} selected>{$UserName}</option>"; 
											}
											else{
												echo "<option value={$userID}>{$UserName}</option>"; 
											}
										}										
									}
						echo "</select>";
						?>						
						<a target="_blank" href='Custodian.php?edit=<?php echo $Cus1NameL ?>&name2=<?php echo $ExamName ?>&name3=<?php echo $Cus1Start ?>&name4=<?php echo $Cus1End ?>'>Print </a>
					</td>
				</tr>	
				<tr>
					<td class="form_sec span4">Custodian 1 Start</td>
					<td>
						<input type="text" id='datepicker7' name="Cus1Start" class="textfield" style="width:120px;" value="<?php echo "{$Cus1Start}" ?>"/>
					</td>
				</tr>
				<tr>
					<td class="form_sec span4">Custodian 1 End</td>
					<td>
						<input type="text" id='datepicker8' name="Cus1End" class="textfield" style="width:120px;" value="<?php echo "{$Cus1End}" ?>"/>
					</td>
				</tr>
				<tr>
					<td class="form_sec span4">Custodian 2 Name</td>
					<td>
					<?php
						include 'db/db_connect.php';
						echo "<select name='ddlCus2Name' style='width:220px'><option value=''>Select Custodian2</option>";
						$query = "SELECT userID, Concat(FirstName,' ',LastName) as UserName FROM tbluser 
								WHERE userid IN (SELECT ItemID FROM tbllistdetails WHERE LISTID = {$ListID})
								order by UserName";
								echo $query;
								echo "<br/>";
								echo "<br/>";
								echo "<br/>";
								echo "<br/>";
								$result = $mysqli->query( $query );
								$num_results = $result->num_rows;
								if( $num_results ){
										while( $row = $result->fetch_assoc() ){
											extract($row);
											if($userID == $Cus2Name){
												echo "<option value={$userID} selected>{$UserName}</option>"; 
											}
											else{
												echo "<option value={$userID}>{$UserName}</option>"; 
											}
										}										
									}
						echo "</select>";
						?>						
						<a target="_blank" href='Custodian.php?edit=<?php echo $Cus2NameL; ?>&name2=<?php echo $ExamName ?>&name3=<?php echo $Cus2Start ?>&name4=<?php echo $Cus2End ?>'>Print </a>
					</td>
					<tr>
					<td class="form_sec span4">Custodian 2 Start</td>
					<td>
						<input type="text" id='datepicker9' name="Cus2Start" class="textfield" style="width:120px;" value="<?php echo "{$Cus2Start}" ?>"/>
					</td>
				</tr>
				<tr>
					<td class="form_sec span4">Custodian 2 End</td>
					<td>
						<input type="text" id='datepicker10' name="Cus2End" class="textfield" style="width:120px;" value="<?php echo "{$Cus2End}" ?>"/>
					</td>
				</tr>
				<tr>
					<td class="form_sec span4">Stationary Store Clerk-1 (SSK1)</td>
					<td>
					<?php
						include 'db/db_connect.php';
						echo "<select name='ddlSK1Name' style='width:220px'><option value=''>Select SK1</option>";
					$query = "SELECT userID, Concat(FirstName,' ',LastName) as UserName FROM tbluser 
								WHERE userid IN (SELECT ItemID FROM tbllistdetails WHERE LISTID = {$ListID})
								order by UserName";
								//echo $query;
								echo "<br/>";
								echo "<br/>";
								echo "<br/>";
								echo "<br/>";
								$result = $mysqli->query( $query );
								$num_results = $result->num_rows;
								if( $num_results ){
										while( $row = $result->fetch_assoc() ){
											extract($row);
											if($userID == $SK1Name){
												echo "<option value={$userID} selected>{$UserName}</option>"; 
											}
											else{
												echo "<option value={$userID}>{$UserName}</option>"; 
											}
										}										
									}
						echo "</select>";
						?>						
						<a target="_blank" href='StationaryStoreClerk.php?edit3=<?php echo $SK1NameL ?>&name2=<?php echo $ExamName ?>&name3=<?php echo $SK1Start ?>&name4=<?php echo $SK1End ?>'>Print </a>
					</td>
				</tr>	
				
				<tr>
					<td class="form_sec span4">SSK 1 Start</td>
					<td>
						<input type="text" id='datepicker11' name="SK1Start" class="textfield" style="width:120px;" value="<?php echo "{$SK1Start}" ?>"/>
					</td>
				</tr>
				<tr>
					<td class="form_sec span4">SSK 1 End</td>
					<td>
						<input type="text" id='datepicker12' name="SK1End" class="textfield" style="width:120px;" value="<?php echo "{$SK1End}" ?>"/>
					</td>
				</tr>
				<tr>
					<td class="form_sec span4">Stationary Store Clerk-2 (SSK2)</td>
					<td>
					<?php
						include 'db/db_connect.php';
						echo "<select name='ddlSK2Name' style='width:220px'><option value=''>Select SK2</option>";
						$query = "SELECT userID, Concat(FirstName,' ',LastName) as UserName FROM tbluser 
								WHERE userid IN (SELECT ItemID FROM tbllistdetails WHERE LISTID = {$ListID})
								order by UserName";
								//echo $query;
								echo "<br/>";
								echo "<br/>";
								echo "<br/>";
								echo "<br/>";
								$result = $mysqli->query( $query );
								$num_results = $result->num_rows;
								if( $num_results ){
										while( $row = $result->fetch_assoc() ){
											extract($row);
											if($userID == $SK2Name){
												echo "<option value={$userID} selected>{$UserName}</option>"; 
											}
											else{
												echo "<option value={$userID}>{$UserName}</option>"; 
											}
										}										
									}
						echo "</select>";
						?>						
						<a target="_blank" href='StationaryStoreClerk.php?edit3=<?php echo $SK2NameL ?>&name2=<?php echo $ExamName ?>&name3=<?php echo $SK2Start ?>&name4=<?php echo $SK2End ?>'>Print </a>
					</td>
					<tr>
					<td class="form_sec span4">SSK2 Start</td>
					<td>
						<input type="text" id='datepicker13' name="SK2Start" class="textfield" style="width:120px;" value="<?php echo "{$SK2Start}" ?>"/>
					</td>
				</tr>
				<tr>
					<td class="form_sec span4">SSK2 End</td>
					<td>
						<input type="text" id='datepicker14' name="SK2End" class="textfield" style="width:120px;" value="<?php echo "{$SK2End}" ?>"/>
					</td>
				</tr>
				</tr>	
				<tr>
					<td class="form_sec span4">Technical Assistant</td>
					<td>
					<?php
						include 'db/db_connect.php';
						echo "<select name='TA' style='width:220px'><option value=''>Select TA</option>";
						$query = "SELECT userID, Concat(FirstName,' ',LastName) as UserName FROM tbluser 
								WHERE userid IN (SELECT ItemID FROM tbllistdetails WHERE LISTID = {$ListID})
								order by UserName";
								//echo $query;
								echo "<br/>";
								echo "<br/>";
								echo "<br/>";
								echo "<br/>";
								$result = $mysqli->query( $query );
								$num_results = $result->num_rows;
								if( $num_results ){
										while( $row = $result->fetch_assoc() ){
											extract($row);
											if($userID == $TA){
												echo "<option value={$userID} selected>{$UserName}</option>"; 
											}
											else{
												echo "<option value={$userID}>{$UserName}</option>"; 
											}
										}										
									}
						echo "</select>";
						?>						
						<a target="_blank" href='TechnicalAssistant.php?edit3=<?php echo $TAL ?>&name2=<?php echo $ExamName ?>&name3=<?php echo $TAStart ?>&name4=<?php echo $TAEnd ?>'>Print </a>
					</td>
					<tr>
					<td class="form_sec span4">Start</td>
					<td>
						<input type="text" id='datepicker15' name="TAStart" class="textfield" style="width:120px;" value="<?php echo "{$TAStart}" ?>"/>
					</td>
				</tr>
				<tr>
					<td class="form_sec span4">End</td>
					<td>
						<input type="text" id='datepicker16' name="TAEnd" class="textfield" style="width:120px;" value="<?php echo "{$TAEnd}" ?>"/>
					</td>
				</tr>
				</tr>	
				<tr>
					<td class="form_sec span4">Assistant Clark</td>
					<td>
					<?php
						include 'db/db_connect.php';
						echo "<select name='AC' style='width:220px'><option value=''>Select AC</option>";
						$query = "SELECT userID, Concat(FirstName,' ',LastName) as UserName FROM tbluser 
								WHERE userid IN (SELECT ItemID FROM tbllistdetails WHERE LISTID = {$ListID})
								order by UserName";
								//echo $query;
								echo "<br/>";
								echo "<br/>";
								echo "<br/>";
								echo "<br/>";
								$result = $mysqli->query( $query );
								$num_results = $result->num_rows;
								if( $num_results ){
										while( $row = $result->fetch_assoc() ){
											extract($row);
											if($userID == $AC){
												echo "<option value={$userID} selected>{$UserName}</option>"; 
											}
											else{
												echo "<option value={$userID}>{$UserName}</option>"; 
											}
										}										
									}
						echo "</select>";
						?>						
						<a target="_blank" href='AssistantClark.php?edit3=<?php echo $ACL ?>&name2=<?php echo $ExamName ?>&name3=<?php echo $ACStart ?>&name4=<?php echo $ACEnd ?>'>Print </a>
					</td>
				</tr>
				<tr>
					<td class="form_sec span4">Start</td>
					<td>
						<input type="text" id='datepicker17' name="ACStart" class="textfield" style="width:120px;" value="<?php echo "{$ACStart}" ?>"/>
					</td>
				</tr>
				<tr>
					<td class="form_sec span4">End</td>
					<td>
						<input type="text" id='datepicker18' name="ACEnd" class="textfield" style="width:120px;" value="<?php echo "{$ACEnd}" ?>"/>
					</td>
				</tr>
				</tr>	

				<tr>
					<td class="form_sec span4">Time List</td>
					<td>
					<?php
						include 'db/db_connect.php';
						echo "<select name='TL' id='TL' style='width:220px' ><option value=''>Select Time List</option>";
						$query = "SELECT DISTINCT(batchname) as batchname FROM tblbatchtimemaster";
								// echo $query;
								// echo "<br/>";
								// echo "<br/>";
								// echo "<br/>";
								// echo "<br/>";
								$result = $mysqli->query( $query );
								$num_results = $result->num_rows;
								if( $num_results ){
										while( $row = $result->fetch_assoc() ){
											extract($row);
											if($batchname == $TL) {
												echo "<option value={$batchname} selected>{$batchname}</option>"; 
											}
											else{
												echo "<option value='{$batchname}'>{$batchname}</option>"; 
											}
										}
									}
						echo "</select>";
						?>						
						<input type="submit" name="btnUpdateList" id="btnUpdateList" value="Update List" title="Update List" class="btn btn btn-success" />
						<br/> <b>Pl Note, Block allocation will have to be done again.</b>";
					</td>
				</tr>
				<tr>
					<td class="form_sec span4">Process Results?</td>
					<td>
							<input type="checkbox" name="chkprocessresult" class="checked" <?php echo ($processresult == '1' ? 'checked' : ''); ?>/>
					</td>
				</tr>
				<tr>
					<td class="form_sec span4">Publish Results?</td>
					<td>
							<input type="checkbox" name="chkpublishresult" class="checked" <?php echo ($publishresult == '1' ? 'checked' : ''); ?>/>
					</td>
				</tr>

				
			</table>
		</div>
	</div>
</form>

