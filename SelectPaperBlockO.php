<?php
//include database connection
include 'db/db_connect.php';
	if(!isset($_SESSION)){
		session_start();
	} 
// if the form was submitted/posted, update the record
	if (isset($_POST['btnSave']))
	{
		if(isset($_SESSION["SESSSearchClicked"]))
		{
			if($_SESSION["SESSSearchClicked"] == "1")
			{
				if(($_POST['ddlDate'] != 'Select') AND ($_POST['ddlExamDateSlot'] != 'Select'))
				{
					if(!isset($tmpExamDate))
						$tmpExamDate = $_POST['ddlDate'] ;
					if(!isset($tmpExamSlot))
						$tmpExamSlot = $_POST['ddlExamDateSlot'] ;
					
					if((isset($_POST['txtebcrowid'])) AND ($_POST['txtebcrowid'] != '')){
						$ebcid = $_POST['txtebcrowid'];
					}
					else{
						$ebcid = 0;
					}
					//first find out if sch exists...if yes..update else insert
					$sql = " SELECT 1 FROM tblexamblockcount WHERE examdate = '" . $tmpExamDate . "' AND examslot = '" . $tmpExamSlot . "' and examid = " . $_SESSION["SESSSelectedExam"] ."";
					// execute the sql query
					$result = $mysqli->query( $sql );
					$num_results = $result->num_rows;
					//echo $num_results;
					if($num_results > 0)
					{
						//update
						$sql = "update tblexamblockcount set examdate = ?, examslot = ?, supcount = ?, relcount = ?, cccount = ?,  
									examid = ?, blocks = ?, peoncount = ? where ebcrowid = ".$ebcid."";
						$stmt = $mysqli->prepare($sql);
						//$Blockss[$i], $SupCounts[$i], 
						$stmt->bind_param('ssiiiiii', $_POST['ddlDate'], $_POST['ddlExamDateSlot'], $_POST['txtJrSup'], 
												$_POST['txtRel'], $_POST['txtCC'],$_SESSION['SESSSelectedExam'],$_POST['txtBlocks'],$_POST['txtPeonCount']);
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
						$sql1 = "Insert into tblexamblockcount (examdate, examslot, supcount, relcount, cccount, examid, blocks,peoncount) Values (?,?,?,?,?,?,?,?)";
						$stmt = $mysqli->prepare($sql1);
						$stmt->bind_param('ssiiiiii', $_POST['ddlDate'], $_POST['ddlExamDateSlot'], $_POST['txtJrSup'], $_POST['txtRel'], $_POST['txtCC'],$_SESSION['SESSSelectedExam'],$_POST['txtBlocks'],$_POST['txtPeonCount']);

						if($stmt->execute()){
						}else{
							echo $mysqli->error;
						}
					}	
					echo "<script type='text/javascript'>window.onload = function()
								{
										document.getElementById('lblSuccess').style.display = 'block';
								}
								</script>";	
										
					$_SESSION["SESSSearchClicked"] = "0";
				}
			}
		}

		// $sql = "Delete from tblexamblockcount where ebcrowid = ?";
		// $stmt = $mysqli->prepare($sql);
		// $stmt->bind_param('i', $_POST['txtebcrowid']);
		// if($stmt->execute()){
		// }else{
			// echo $mysqli->error;;
		// }
		
		// $sql1 = "Insert into tblexamblockcount (examdate, examslot, supcount, relcount, cccount, examid, blocks) Values (?,?,?,?,?,?,?)";
		// $stmt = $mysqli->prepare($sql1);
		// $stmt->bind_param('ssiiiii', $_POST['ddlDate'], $_POST['ddlExamDateSlot'], $_POST['txtJrSup'], $_POST['txtRel'], $_POST['txtCC'],$_SESSION['SESSSelectedExam'],$_POST['txtBlocks']);

		// if($stmt->execute()){
		// }else{
			// echo $mysqli->error;
		// }

	}
?>


<form action="SelectPaperBlockMainO.php" method="post">
<?php
		if(!isset($_SESSION)){
			session_start();
		}
?>
	<br /><br />
	<h3 class="page-title" style="margin-left:5%">Block Paper Allocation</h3>
	<h3 class="page-title" style="float:right;margin-top:-40px;"><a href="ExamIndexMain.php">Back</a></h3>
		<table cellpadding="10" cellspacing="0" border="0" class="tab_split" style="margin-left:5%">
			<tr >
				<td class="form_sec span1">Exam Date</td>
				<td class="form_sec span2">
					<select name="ddlDate" style="width:50%;margin-top:10px">
						<?php
						include 'db/db_connect.php';
						echo "<option value=Select>Select</option>"; 
						//$sql = "SELECT DISTINCT(ExamDate) as ExamDate, DISTINCT(DATE_FORMAT(STR_TO_DATE(ExamDate,'%m/%d/%Y'), '%d %M %Y')) AS ExamDateText FROM tblexamschedule WHERE ExamID = " . $_SESSION["SESSSelectedExam"] . " ORDER BY ExamDate;";
						$sql = "SELECT DISTINCT(ExamDate) as ExamDate,DATE_FORMAT(STR_TO_DATE(ExamDate,'%m/%d/%Y'), '%d %M %Y') as ExamDateText FROM tblexamschedule WHERE coalesce(ExamDate,'') <> '' AND ExamID = " . $_SESSION["SESSSelectedExam"] . " ORDER BY ExamDate;";
						$result1 = $mysqli->query( $sql );
						while( $row = $result1->fetch_assoc() ) {
						extract($row);
						 if((isset($_POST['ddlDate']) && $_POST['ddlDate'] == $ExamDate) || (isset($_GET['ExamDate']) && $_GET['ExamDate'] == $ExamDate) ){
								echo "<option value={$ExamDate} selected>{$ExamDateText}</option>"; 
							}
							else{
								echo "<option value={$ExamDate}>{$ExamDateText}</option>"; 
							}
						}
						?>
					</select>
				</td>
				<td class="form_sec span1">Slot</td>
				<td class="form_sec span2">
					<select name="ddlExamDateSlot" style="width:50%;margin-top:10px" >
						<?php
						if((isset($_POST['ddlExamDateSlot']) && $_POST['ddlExamDateSlot'] == 'Select') || 
							(isset($_GET['ExamSlot']) && $_GET['ExamSlot'] == 'Select')){
								echo "<option value=Select selected>Select</option>"; 
							}
							else{
								echo "<option value=Select>Select</option>"; 
							}
						if((isset($_POST['ddlExamDateSlot']) && $_POST['ddlExamDateSlot'] == 'Morning') || 
							(isset($_GET['ExamSlot']) && $_GET['ExamSlot'] == 'Morning')){
								echo "<option value=Morning selected>Morning</option>"; 
							}
							else{
								echo "<option value=Morning>Morning</option>"; 
							}
						if((isset($_POST['ddlExamDateSlot']) && $_POST['ddlExamDateSlot'] == 'Evening') || 
							(isset($_GET['ExamSlot']) && $_GET['ExamSlot'] == 'Evening')){
								echo "<option value=Evening selected>Evening</option>"; 
							}
							else{
								echo "<option value=Evening>Evening</option>"; 
							}
						?>
					</select>
				</td>
				<td class="form_sec span2">
					<input type="submit" name="btnSearch" value="Search" title="Update" class="btn btn btn-success" />
					<a class='btn btn-mini btn-success'  target='_blank'
					  href=<?php  
							If ((isset($_POST['btnSearch'])) or (isset($_POST['btnSave'])) or isset($_GET['ExamDate']))
							{
								If (isset($_POST['btnSearch']) or (isset($_POST['btnSave'])) ) { 
									$tmpExamDate = $_POST['ddlDate'] ;
									$tmpExamSlot = $_POST['ddlExamDateSlot'] ;
								}
								Else {
									$tmpExamDate = $_GET['ExamDate'] ;
									$tmpExamSlot = $_GET['ExamSlot'] ;
								}	
							echo "PrintDay.php?ExamDate=" . $tmpExamDate . "&ExamSlot=" . $tmpExamSlot ; 
								
							}
						?>
					>Print</a>
				</td>								
			</tr>						
		</table>
	<br/>
	<div style="float:left;margin-left:65px;margin-top:-20px">
		<label id="lblSuccess" style="margin-left:10px;color:green;font-weight:bold;display:none" >Data saved successfully.</label>
	</div>
	<br/>

			<table cellpadding="10" cellspacing="0" border="0" width="90%" class="tab_split" style="margin-left:5%">
				<tr>
					<th>Total Duties</th>
					<th>Saturday Duties</th>
					<th>Evening Duties</th>
					<th>Peon Duties</th>
					<th class="span4" ></th>
					<th>Blocks</th>
					<th>Jr. Supervisors</th>
					<th>Relievers</th>
					<th>RCs</th>
					<th>Peons</th>
					<th></th>
				</tr>
				<?php
					include 'db/db_connect.php';
					$tmpExamDate = '' ;
					$tmpExamSlot = '' ;

					If (isset($_POST['btnSearch']) or (isset($_POST['btnSave']))  ) { 
							$tmpExamDate = $_POST['ddlDate'] ;
							$tmpExamSlot = $_POST['ddlExamDateSlot'] ;
						}
						Else { 
							if  (isset($_GET['ExamDate'])) {
								$tmpExamDate = $_GET['ExamDate'] ;
								$tmpExamSlot = $_GET['ExamSlot'] ;
							}
						}
						
						if ($tmpExamDate == '') {$tmpExamDate = '01/01/1900';}
						if ($tmpExamSlot == '') {$tmpExamSlot = 'Morning';}
						
						$sql = " SELECT TotCount, Satcount, EvenCount,  supcount, relcount, cccount, blocks,peoncount, ebcrowid,TotPeonCount FROM
								(SELECT SUM(COALESCE(supcount, 0)) + SUM(COALESCE(relcount, 0)) + SUM(COALESCE(cccount, 0)) AS TotCount , SUM(COALESCE(peoncount, 0)) as TotPeonCount, '1' AS id FROM tblexamblockcount where examid = " . $_SESSION["SESSSelectedExam"] .") AS A
								INNER JOIN 
								(SELECT SUM(COALESCE(supcount, 0)) + SUM(COALESCE(relcount, 0)) + SUM(COALESCE(cccount, 0)) AS SatCount, '1' AS id FROM tblexamblockcount where DAYNAME(STR_TO_DATE(examdate,'%m/%d/%Y'))  = 'Saturday'
								and examid = " . $_SESSION["SESSSelectedExam"] .") AS B ON A.id = B.id
								INNER JOIN
								(SELECT SUM(COALESCE(supcount, 0)) + SUM(COALESCE(relcount, 0)) + SUM(COALESCE(cccount, 0)) AS EvenCount, '1' AS id FROM tblexamblockcount	where examslot  = 'Evening' and examid = " . $_SESSION["SESSSelectedExam"] .") AS C ON B.id = C.id
								LEFT OUTER JOIN
								(SELECT '1' AS id, supcount, relcount, cccount, blocks,peoncount, ebcrowid
								 FROM tblexamblockcount WHERE examdate = '" . $tmpExamDate . "' AND examslot = '" . $tmpExamSlot . "' and examid = " . $_SESSION["SESSSelectedExam"] .") AS D ON A.id = D.id ";
						
						//echo $sql;

						// execute the sql query
						$result = $mysqli->query( $sql );
						echo $mysqli->error;
						$num_results = $result->num_rows;

						if( $num_results ){
							while( $row = $result->fetch_assoc() ){
								extract($row);
								echo "<TR class='odd gradeX'>";
								echo "<td>{$TotCount}</td>";
								echo "<td>{$Satcount}</td>";
								echo "<td>{$EvenCount}</td>";
								echo "<td>{$TotPeonCount}</td>";
								echo "<td style='text-align:right'><b>Enter for Selected Day/Slot ==></b></td>";
								echo "<td><input type='text' maxlength='2' name='txtBlocks' class='span8' value={$blocks}></td>";
								echo "<td><input type='text' maxlength='2' name='txtJrSup' class='span8' value={$supcount}></td>";
								echo "<td><input type='text' maxlength='2' name='txtRel' class='span8' value={$relcount}></td>";
								echo "<td><input type='text' maxlength='2' name='txtCC' class='span8' value={$cccount}></td>";
								echo "<td><input type='text' maxlength='2' name='txtPeonCount' class='span8' value={$peoncount}></td>";
								echo "<td class='span2'><input type='submit' name='btnSave' value='Save' title='Update' class='btn btn-mini btn-success' /><input type='hidden' name='txtebcrowid' value={$ebcrowid}></input></td>" ;
								echo "</TR>";
							}
						}					
						//disconnect from database
						$result->free();
						$mysqli->close();
					
				?>
			</table>

			<br/>
	
	<div class="row-fluid" style="margin-left:5%">
	    <div class="span11 v_detail" style="overflow:scroll">

			<table cellpadding="10" cellspacing="0" border="0" width="100%" class="tab_split" >
				<tr>
					<th>Year</th>
					<th>Pattern</th>
					<th>Department</th>
					<th>Subject</th>
					<th>Time From - To</th>
					<th>Students</th>
					<th>File Name</th>
					<th>Blocks</th>
					<th>Action</th>
				</tr>

				<?php
					include 'db/db_connect.php';
					//If ((isset($_POST['btnSearch'])))
					If ((isset($_POST['btnSearch'])) or (isset($_POST['btnSave'])) or isset($_GET['ExamDate']))
					{
						
						//If (isset($_POST['btnSearch'])) { 
						If (isset($_POST['btnSearch']) or (isset($_POST['btnSave']))) { 
							$tmpExamDate = $_POST['ddlDate'] ;
							$tmpExamSlot = $_POST['ddlExamDateSlot'] ;
						}
						Else {
							$tmpExamDate = $_GET['ExamDate'] ;
							$tmpExamSlot = $_GET['ExamSlot'] ;
						}

						$sql = " SELECT ES.PaperID, EnggYear,PM.EnggPattern, DeptName,SubjectName,ES.TimeFrom, ES.TimeTo, Blocks, Students, 
								Supcount , ES.ExamSchId,
								concat(EnggYear,'-',PM.EnggPattern,'-', DeptName,'-',SubjectName,'-',Students) as PAPERINFO, FileName, BlkCnt,
								concat(EnggYear,', ',DeptName,', ', PM.EnggPattern,', ',SubjectName,', ',Students) as PAPERINFO2
								FROM tblexamschedule ES INNER JOIN tblpapermaster PM ON ES.PaperID = PM.PaperID 
								INNER JOIN tblsubjectmaster SM ON PM.SubjectID = SM.SubjectID 
								INNER JOIN tbldepartmentmaster DM ON PM.DeptID = DM.DeptID 
								INNER JOIN tblexammaster EM ON EM.ExamID = ES.ExamID 
								LEFT OUTER JOIN (SELECT COUNT(*) AS BlkCnt, ExamSchID, FileName FROM tblexamblock GROUP BY ExamSchID, FileName) AS EBS ON ES.ExamSchID = EBS.ExamSchID 
							 WHERE ES.ExamID = " . $_SESSION["SESSSelectedExam"] . "
							 AND ES.ExamSlot = '" . $tmpExamSlot . "' 
							 AND ES.ExamDate = '". $tmpExamDate . "'
							 ORDER BY DM.orderno, EnggYear, PM.EnggPattern Asc, DeptName, SubjectName ";

						// execute the sql query
						$result = $mysqli->query( $sql );
						//echo $mysqli->error;
						$num_results = $result->num_rows;
						$totStd = 0;
						if( $num_results ){
							while( $row = $result->fetch_assoc() ){
								extract($row);
								echo "<TR class='odd gradeX'>";
								echo "<td>{$EnggYear}</td>";
								echo "<td>{$EnggPattern}</td>";
								echo "<td>{$DeptName}</td>";
								echo "<td>{$SubjectName}</td>";
								echo "<td>{$TimeFrom} to {$TimeTo}</td>";
								echo "<td style='text-align:center'>{$Students}</td>";
								echo "<td>{$FileName}</td>";
								echo "<td>{$BlkCnt}</td>";
								echo "<td class='span2'>
										<a class='btn btn-mini btn-success' 
										href='PaperBlockMain.php?PaperId={$PaperID}&ExDate={$tmpExamDate}&ExSlot={$tmpExamSlot}&paperinfo={$PAPERINFO2}&ExamSchId1={$ExamSchId}'>
										<i class='icon-ok icon-white'></i>&nbsp;&nbsp;Show Blocks</a>
										<a class='btn btn-mini btn-success' 
										href='BlockFileMain.php?PaperId={$PaperID}&ExDate={$tmpExamDate}&ExSlot={$tmpExamSlot}&paperinfo={$PAPERINFO2}&ExamSchId1={$ExamSchId}'>
										<i class='icon-ok icon-white'></i>&nbsp;&nbsp;Upload</a>
									  </td>";
								echo "</TR>";
								$totStd = $totStd + $Students;
							}
						}					
						//disconnect from database
						$result->free();
						$mysqli->close();

						echo"<tr>";
						echo"<th></th>";
						echo"<th></th>";
						echo"<th></th>";
						echo"<th></th>";
						echo"<th>Total</th>";
						echo"<th style='text-align:center'>{$totStd}</th>";
						echo"<th></th>";
						echo"</tr>";

						$_SESSION["SESSSearchClicked"] = "1";
					}
				?>



			</table>
        </div>
	</div>
	<div class="clear"></div>
