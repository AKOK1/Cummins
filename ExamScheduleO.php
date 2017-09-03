<?php
//include database connection
include 'db/db_connect.php';

// if the form was submitted/posted, update the record
 if (isset($_POST['btnSave']))
	{
		//'txtBlocks', 'txtSupCount', 
	foreach (array('txtPaperID', 'txtStudents', 'dtEmax','ddlSlot', 'txtFrom', 'txtTo' ) as $pos) {
		foreach ($_POST[$pos] as $id => $row) {
			$_POST[$pos][$id] = mysqli_real_escape_string($mysqli, $row);
		} 
	}
	
	$PaperIDs = $_POST['txtPaperID'];
	$Studentss = $_POST['txtStudents'];
	//$Blockss = $_POST['txtBlocks'];
	//$SupCounts =  $_POST['txtSupCount'];
	$dtExams =  $_POST['dtEmax'];
	$ddlSlots =  $_POST['ddlSlot'];
	$txtFroms =  $_POST['txtFrom'];
	$txtTos =  $_POST['txtTo'];

	$size = count($PaperIDs);

	for($i = 0 ; $i < $size ; $i++){
		//if($Studentss[$i] != 0) {
			$dt = '';
			if($dtExams[$i] != ''){
				$dt = date('m/d/Y', strtotime($dtExams[$i]));
			}
			//first find out if sch exists...if yes..update else insert
			$sql = " SELECT 1 FROM tblexamschedule WHERE ExamID = ".$_SESSION["SESSSelectedExam"] . " and paperid = ".$PaperIDs[$i]."";
			// execute the sql query
			$result = $mysqli->query( $sql );
			$num_results = $result->num_rows;
			if($num_results)
			{
				//update
				$sql = "update tblexamschedule set ExamID = ?, PaperID = ?, Students = ?, Blocks = 0, SupCount = 0,  ExamSlot = ?, 
												ExamDate = ?, TimeFrom = ?, TimeTo = ?, Created_by = 'Admin', Created_on = CURRENT_TIMESTAMP, 
												updated_by = 'Admin', Updated_on = CURRENT_TIMESTAMP
							where ExamID = ".$_SESSION["SESSSelectedExam"] . " and PaperID = ". $PaperIDs[$i] ;
				$stmt = $mysqli->prepare($sql);
				//$Blockss[$i], $SupCounts[$i], 
				$stmt->bind_param('iiissss', $_SESSION["SESSSelectedExam"],$PaperIDs[$i], $Studentss[$i], $ddlSlots[$i], 
									$dt, $txtFroms[$i], $txtTos[$i] );
				if($stmt->execute()){
					//header('Location: SubjectList.php?'); 
				} 
				else{
					echo $mysqli->error;
					//die("Unable to update.");
				}
			}
			else
			{
				//insert!
				$sql = "Insert into tblexamschedule ( ExamID, PaperID, Students, Blocks, SupCount,  ExamSlot, ExamDate, TimeFrom, TimeTo,
							Created_by, Created_on, updated_by, Updated_on) 
						Values ( ?, ?, ?, 0, 0, ?, ?, ?, ?,
							'Admin', CURRENT_TIMESTAMP, 'Admin', CURRENT_TIMESTAMP)";
				$stmt = $mysqli->prepare($sql);
				//$Blockss[$i], $SupCounts[$i], 
				$stmt->bind_param('iiissss', $_SESSION["SESSSelectedExam"],$PaperIDs[$i], $Studentss[$i], $ddlSlots[$i], 
									$dt, $txtFroms[$i], $txtTos[$i] );
				
				if($stmt->execute()){
					//header('Location: SubjectList.php?'); 
				} else{
					echo $mysqli->error;
					//die("Unable to update.");
				}
			}
		//}
	
		/*		
		$sqlD = "Delete from tblexamschedule where ExamID = ".$_SESSION["SESSSelectedExam"] . " and PaperID = ". $PaperIDs[$i] ;
		if ($mysqli->query($sqlD) === TRUE) {
		} 
		else {
			echo "Error updating record: " . $mysqli->error;
		}
		
		if (($Studentss[$i] == '') || ($Studentss[$i] == '0')){
			
		}
		Else {
			$dt = '';
			if($dtExams[$i] != ''){
				$dt = date('m/d/Y', strtotime($dtExams[$i]));
			}
			$sql = "Insert into tblexamschedule ( ExamID, PaperID, Students, Blocks, SupCount,  ExamSlot, ExamDate, TimeFrom, TimeTo,
						Created_by, Created_on, updated_by, Updated_on) 
					Values ( ?, ?, ?, 0, 0, ?, ?, ?, ?,
						'Admin', CURRENT_TIMESTAMP, 'Admin', CURRENT_TIMESTAMP)";
			$stmt = $mysqli->prepare($sql);
			//$Blockss[$i], $SupCounts[$i], 
			$stmt->bind_param('iiissss', $_SESSION["SESSSelectedExam"],$PaperIDs[$i], $Studentss[$i], $ddlSlots[$i], 
								$dt, $txtFroms[$i], $txtTos[$i] );
			
			if($stmt->execute()){
				//header('Location: SubjectList.php?'); 
			} else{
				echo $mysqli->error;
				//die("Unable to update.");
			}
		}
		*/	
		}
		echo "<script type='text/javascript'>window.onload = function()
						{
								document.getElementById('lblSuccess').style.display = 'block';
						}
						</script>";

	}
?>
<form action="ExamScheduleOMain.php" method="post">
	<head>
		<script>
			$(function() {
				$('.DTEXDATE').each(function(i) {
							this.id = 'datepicker' + i;
					}).datepicker({ dateFormat: 'dd-M-yy' });
				//});
				//$( ".DTEXDATE" ).datepicker();
				//$(".DTEXDATE").each(function(){
				//	$(this).datepicker();
				//});
			});
			</script>
	</head>

	<br /><br />
	<div>
	<h3 class="page-title" style="margin-left:5%">Exam Schedule</h3>
	<h3 class="page-title" style="float:right;margin-top:-40px;"><a href="ExamIndexOMain.php">Back</a></h3>
	</div>
		<table cellpadding="10" cellspacing="0" border="0" class="tab_split" style="margin-left:5%">
			<tr >
				<td class="form_sec span1">Year</td>
				<td class="form_sec span2">
					<select name="ddlYear" style="width:70%;margin-top:10px" >
						<option value="Select " <?php echo (isset($_POST['ddlYear']) && $_POST['ddlYear'] == 'Select ')?'selected="selected"':''; ?>>Select </option>
						<option value="FE - Sem 1" <?php echo (isset($_POST['ddlYear']) && $_POST['ddlYear'] == 'FE - Sem 1')?'selected="selected"':''; ?>>FE - Sem 1</option>
						<option value="FE - Sem 2" <?php echo (isset($_POST['ddlYear']) && $_POST['ddlYear'] == 'FE - Sem 2')?'selected="selected"':''; ?>>FE - Sem 2</option>
						<option value="SE - Sem 1" <?php echo (isset($_POST['ddlYear']) && $_POST['ddlYear'] == 'SE - Sem 1')?'selected="selected"':''; ?>>SE - Sem 1</option>
						<option value="SE - Sem 2" <?php echo (isset($_POST['ddlYear']) && $_POST['ddlYear'] == 'SE - Sem 2')?'selected="selected"':''; ?>>SE - Sem 2</option>
						<option value="TE - Sem 1" <?php echo (isset($_POST['ddlYear']) && $_POST['ddlYear'] == 'TE - Sem 1')?'selected="selected"':''; ?>>TE - Sem 1</option>
						<option value="TE - Sem 2" <?php echo (isset($_POST['ddlYear']) && $_POST['ddlYear'] == 'TE - Sem 2')?'selected="selected"':''; ?>>TE - Sem 2</option>
						<option value="BE - Sem 1" <?php echo (isset($_POST['ddlYear']) && $_POST['ddlYear'] == 'BE - Sem 1')?'selected="selected"':''; ?>>BE - Sem 1</option>
						<option value="BE - Sem 2" <?php echo (isset($_POST['ddlYear']) && $_POST['ddlYear'] == 'BE - Sem 2')?'selected="selected"':''; ?>>BE - Sem 2</option>
						<option value="ME - Sem 1" <?php echo (isset($_POST['ddlYear']) && $_POST['ddlYear'] == 'ME - Sem 1')?'selected="selected"':''; ?>>ME - Sem 1</option>
						<option value="ME - Sem 2" <?php echo (isset($_POST['ddlYear']) && $_POST['ddlYear'] == 'ME - Sem 2')?'selected="selected"':''; ?>>ME - Sem 2</option>
						<option value="ME - Sem 3" <?php echo (isset($_POST['ddlYear']) && $_POST['ddlYear'] == 'ME - Sem 3')?'selected="selected"':''; ?>>ME - Sem 3</option>
					</select>
				</td>
				<td class="form_sec span1">Branch</td>
				<td class="form_sec span2">
					<select name="ddlBranch" style="width:90%;margin-top:10px">
						<?php
						include 'db/db_connect.php';
						$sql = "SELECT 0 AS MDeptId, 'Select ' AS DeptName ,-1 AS orderno UNION SELECT DeptID AS MDeptId, DeptName ,orderno FROM tbldepartmentmaster ORDER BY orderno;";
						$result1 = $mysqli->query( $sql );
						//echo $mysqli->error;
						while( $row = $result1->fetch_assoc() ) {
						extract($row);
						 if((isset($_POST['ddlYear']) && $_POST['ddlBranch'] == $MDeptId)){
								echo "<option value={$MDeptId} selected>{$DeptName}</option>"; 
							}
							else{
								echo "<option value={$MDeptId}>{$DeptName}</option>"; 
							}
						}
						?>
					</select>
				</td>
				<td class="form_sec span1">Pattern</td>
				<td class="form_sec span2">
					<select name="ddlPattern" style="width:50%;margin-top:10px">
						<option value="Select " >Select </option>
						<option value="2013" <?php echo (isset($_POST['ddlPattern']) && $_POST['ddlPattern'] == '2013')?'selected="selected"':''; ?> > 2013</option>
						<option value="2012" <?php echo (isset($_POST['ddlPattern']) && $_POST['ddlPattern'] == '2012')?'selected="selected"':''; ?> > 2012</option>
						<option value="2008" <?php echo (isset($_POST['ddlPattern']) && $_POST['ddlPattern'] == '2008')?'selected="selected"':''; ?> > 2008</option>
					</select>
				</td>

				<td class="form_sec span2">
					<input type="submit" name="btnSearch" value="Search" title="Update" class="btn btn-mini btn-success" />
				</td>								
			</tr>						
		</table>

	<br/>
	<br/>
	<div style="float:left;margin-left:65px;margin-top:-20px">
		<label id="lblSuccess" style="margin-left:10px;color:green;font-weight:bold;display:none" >Data saved successfully.</label>
	</div>
	<br/>
	<div class="row-fluid" style="margin-left:5%">
	    <div class="span10 v_detail" style="overflow:scroll">
			<table cellpadding="10" cellspacing="0" border="0" class="tab_split" width="120%">
				<tr>
					<th>Subject</th>
					<th>Students</th>
					<th>Date</th>
					<th>Slot</th>
					<th>Time From</th>
					<th>Time To</th>
				</tr>

				<?php
					If ((isset($_POST['btnSearch'])) or (isset($_POST['btnSave'])))
					{
						$sql = " SELECT PM.PaperID, SM.SubjectName, Students, Blocks, SupCount, DATE_FORMAT(str_to_date(ExamDate, '%m/%d/%Y'), '%d-%b-%Y') as ExamDate,
								 ExamSlot, TimeFrom, TimeTo FROM tblpapermaster PM
								 LEFT OUTER JOIN (SELECT * FROM tblexamschedule WHERE ExamID = " .$_SESSION["SESSSelectedExam"]. " )  AS ES ON PM.PaperID = ES.PaperID
								 INNER JOIN tblsubjectmaster SM ON PM.SubjectID = SM.SubjectID
								 INNER JOIN tbldepartmentmaster DM ON DM.DeptID = PM.DeptID
								 WHERE PM.EnggPattern = '" . $_POST['ddlPattern'] . "' 
								 AND PM.EnggYear = '". $_POST['ddlYear'] . "' 
								 AND PM.DeptID = " . $_POST['ddlBranch']	 ;

						//echo $sql;
						
						// execute the sql query
						$result = $mysqli->query( $sql );
						$num_results = $result->num_rows;

						if( $num_results ){
							while( $row = $result->fetch_assoc() ){
								extract($row);
								echo "<TR class='odd gradeX'>";
								echo "<td style='display:none'><input type='text' maxlength='2' name='txtPaperID[]' class='span4' value='{$PaperID}' /></td>";
								echo "<td>{$SubjectName}</td>";
								echo "<td><input style='width:50px' type='text' maxlength='3' name='txtStudents[]' class='span6' value='{$Students}' /></td>";
								//echo "<td><input type='text' maxlength='2' name='txtBlocks[]' class='span7' value='{$Blocks}' /></td>";
								//echo "<td><input type='text' maxlength='2' name='txtSupCount[]' class='span4' value='{$SupCount}' /></td>";
								echo "<td><input type='text' name='dtEmax[]' class='span13 DTEXDATE' value='{$ExamDate}' /></td>";

								// echo "<td>";
								// echo "<select style='width:100px' name='ddlSlot[]' class='span100'>";
									// echo "<option value='Morning' ";
									// if($ExamSlot == 'Morning') echo "selected"; 
									// echo ">Morning</option>";
									// echo "<option value='Evening' ";  
									// if($ExamSlot == 'Evening') echo "selected"; 
									// echo ">Evening</option>";
									// echo "</select>";
								// echo "</td>";
								
								If ((substr($_POST['ddlYear'],0,2) == 'FE') ||  (substr($_POST['ddlYear'],0,2) == 'TE')) {
									
									echo "<td>";
									echo "<select style='width:100px' name='ddlSlot[]' class='span100'>";
										echo "<option value='Morning' ";
										if($ExamSlot == 'Morning') echo "selected"; 
										echo ">Morning</option>";
										echo "<option value='Evening' ";  
										if($ExamSlot == 'Evening') echo "selected"; 
										echo ">Evening</option>";
										echo "</select>";
									echo "</td>";
									
									if ($TimeFrom == ''){
										echo "<td><input type='text' maxlength='5' name='txtFrom[]' class='span6' value='10' /></td>";
										echo "<td><input type='text' maxlength='5' name='txtTo[]' class='span6' value='1' /></td>";
									}
									else {
										echo "<td><input type='text' maxlength='5' name='txtFrom[]' class='span6' value='{$TimeFrom}' /></td>";
										echo "<td><input type='text' maxlength='5' name='txtTo[]' class='span6' value='{$TimeTo}' /></td>";
									}
								}
								else {
									
									echo "<td>";
									echo "<select style='width:100px' name='ddlSlot[]' class='span100'>";
										echo "<option value='Evening' ";  
										if($ExamSlot == 'Evening') echo "selected"; 
										echo ">Evening</option>";
										echo "<option value='Morning' ";
										if($ExamSlot == 'Morning') echo "selected"; 
										echo ">Morning</option>";
										echo "</select>";
									echo "</td>";

									
									if ($TimeTo == ''){
										echo "<td><input type='text' maxlength='5' name='txtFrom[]' class='span6' value='2:30' /></td>";
										echo "<td><input type='text' maxlength='5' name='txtTo[]' class='span6' value='5:30' /></td>";
									}
									else {
										echo "<td><input type='text' maxlength='5' name='txtFrom[]' class='span6' value='{$TimeFrom}' /></td>";
										echo "<td><input type='text' maxlength='5' name='txtTo[]' class='span6' value='{$TimeTo}' /></td>";
									}
								}
								echo "</TR>";
							}
						}					
						//disconnect from database
						$result->free();
						$mysqli->close();

						}
				?>
			</table>
            <br />
        </div>
	</div>
	<div class="clear"></div>
	<div class="form_sec span2">
		<input type="submit" name="btnSave" value="Save" title="Update" class="btn btn-mini btn-success" />
	</div>								
