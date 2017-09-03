<?php
//include database connection
	include 'db/db_connect.php';
	if(!isset($_SESSION)){
		session_start();
	} 
	if(isset($_GET['ExamDate'])){
		$tmpExamDate = $_GET['ExamDate'] ;
		$tmpExamSlot = $_GET['ExamSlot'] ;
	}
	if (isset($_POST['btnSearch']))
	{
		$tmpExamDate = $_POST['ddlDate'] ;
		$tmpExamSlot = $_POST['ddlExamDateSlot'] ;
	}	
	if (isset($_POST['btnAssignStds']))
	{
		$tmpExamDate = $_POST['ddlDate'] ;
		$tmpExamSlot = $_POST['ddlExamDateSlot'] ;

		if ( $tmpExamDate == 'Select' || $tmpExamSlot == 'Select' ){
			echo "<script type='text/javascript'>window.onload = function()
				{
					document.getElementById('lblSuccess').style.display = 'block';
					document.getElementById('lblSuccess').innerHTML = 'Select Date and Slot and click Search to continue.'
				}
				</script>";	
		}
		else {
			include 'db/db_connect.php';
			$sql = " Select UploadedFile From  tblexamschedule ES
					WHERE ExamId = " . $_SESSION['SESSSelectedExam'] . " and CoalESCE(UploadedFile, '') = ''
					AND ExamDate = '" . $tmpExamDate . "' AND Examslot = '" . $tmpExamSlot . "'"  ;
			
			//echo $sql;
			$result1 = $mysqli->query( $sql );
			$EsChk = 0;

			if ($EsChk == 0){
				include 'db/db_connect.php';
				$sql = " SELECT SUM(Students) as Students, SUM(Allocation) as Allocation 
						FROM tblexamschedule ES LEFT OUTER JOIN 
						(SELECT SUM(Allocation) AS Allocation, ExamSchID FROM tblexamblock EB 
							WHERE ExamSchID IN 
							(SELECT ExamSchId FROM tblexamschedule 
								WHERE ExamId = " . $_SESSION['SESSSelectedExam'] . " AND ExamDate = '" . $tmpExamDate . "' 
								AND Examslot = '" .  $tmpExamSlot . "')
								GROUP BY ExamSchID ) AS A
						ON ES.ExamSchID = A.ExamSchID
						WHERE ExamId = " . $_SESSION['SESSSelectedExam'] . " 
						AND ExamDate = '" . $tmpExamDate . "' AND Examslot = '" .  $tmpExamSlot . "'"  ;
				//echo $sql;
				$result1 = $mysqli->query( $sql );
				//echo $mysqli->error;
				while( $row = $result1->fetch_assoc() ) {
				extract($row);
				 if ( $Students == $Allocation){
						header("Location: AllocateStdToBlock.php?ExamDate=" . $tmpExamDate . "&ExamSlot=" . $tmpExamSlot . ""); 
					}
					else{
						echo "<script type='text/javascript'>window.onload = function()
							{
								document.getElementById('lblSuccess').style.display = 'block';
								document.getElementById('lblSuccess').innerHTML = 'Block Allocation not complete.'
							}
							</script>";	
					}
				}	
			}			
		}
	}	
	// if the form was submitted/posted, update the record
	if (isset($_POST['btnSave']))
	{
		if((isset($_POST['txtebcrowid'])) AND ($_POST['txtebcrowid'] != '')){
			$ebcid = $_POST['txtebcrowid'];
		}
		else{
			$ebcid = 0;
		}
		$tmpExamDate = $_POST['ddlDate'] ;
		$tmpExamSlot = $_POST['ddlExamDateSlot'] ;
		
		//first find out if sch exists...if yes..update else insert
			include 'db/db_connect.php';
			$sql = " SELECT 1 FROM tblexamblockcount WHERE examdate = '" . $tmpExamDate . "' AND examslot = '" . $tmpExamSlot . "' and examid = " . $_SESSION["SESSSelectedExam"] ."";
		//echo $sql;
		// execute the sql query
		$result = $mysqli->query( $sql );
		$num_results = $result->num_rows;
		if($num_results > 0)
		{
			//update
			$sql = "update tblexamblockcount set examdate = ?, examslot = ?, supcount = ?, relcount = ?, cccount = ?,  
						examid = ?, blocks = ?, peoncount = ? where ebcrowid = ".$ebcid."";
			$stmt = $mysqli->prepare($sql);
			//$Blockss[$i], $SupCounts[$i], 
			$stmt->bind_param('ssiiiiii', $tmpExamDate, $tmpExamSlot, $_POST['txtJrSup'], 
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
			include 'db/db_connect.php';
			$sql1 = "Insert into tblexamblockcount (examdate, examslot, supcount, relcount, cccount, examid, blocks,peoncount) Values (?,?,?,?,?,?,?,?)";
			$stmt = $mysqli->prepare($sql1);
			$stmt->bind_param('ssiiiiii', $tmpExamDate, $tmpExamSlot, $_POST['txtJrSup'], $_POST['txtRel'], $_POST['txtCC'],$_SESSION['SESSSelectedExam'],$_POST['txtBlocks'],$_POST['txtPeonCount']);

			if($stmt->execute()){
			}else{
				echo $mysqli->error;
			}
		}	
		echo "<script type='text/javascript'>window.onload = function()
					{
							document.getElementById('lblSuccess').style.display = 'block';
							document.getElementById('lblSuccess').innerHTML = 'Data saved successfully.';
					}
					</script>";		
		//header('Location: SelectPaperBlockMain.php');					
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
<form action="SelectPaperBlockMain.php" method="post" onsubmit='showLoading();'>
	<head>
	 <script type="text/javascript">     
	 function showLoading() {
    document.getElementById('loadingmsg').style.display = 'block';
    document.getElementById('loadingover').style.display = 'block';
}
		function checkddl() {   
			if((document.getElementById("ddlDate").value == "Select") || (document.getElementById("ddlExamDateSlot").value == "Select"))
			{
				document.getElementById('lblSuccess').style.display = 'block';
				document.getElementById('lblSuccess').innerHTML = 'Select Date and Slot and click Search to continue.';
				return false;
			}
			else
			{
				document.getElementById('lblSuccess').style.display = 'none';
				return true;
			}
		}
	</script>
	
	</head>
	<br /><br />
	<h3 class="page-title" style="margin-left:5%">Block Paper Allocation</h3>
	<h3 class="page-title" style="float:right;margin-top:-40px;">
	<?php
			echo"<a href='ExamIndexMain.php'>Back</a>";
	?>	
	</h3>
		<table cellpadding="10" cellspacing="0" border="0" class="tab_split" style="margin-left:5%">
			<tr >
				<td class="form_sec span1">Exam Date</td>
				<td class="form_sec span2">
					<select id="ddlDate" name="ddlDate" style="width:70%;margin-top:10px">
						<?php
						include 'db/db_connect.php';
						echo "<option value=Select>Select</option>"; 
						//$sql = "SELECT DISTINCT(ExamDate) as ExamDate, DISTINCT(DATE_FORMAT(STR_TO_DATE(ExamDate,'%m/%d/%Y'), '%d %M %Y')) AS ExamDateText FROM tblexamschedule WHERE ExamID = " . $_SESSION["SESSSelectedExam"] . " ORDER BY ExamDate;";
						$sql = "SELECT DISTINCT(ExamDate) as ExamDate,DATE_FORMAT(STR_TO_DATE(ExamDate,'%m/%d/%Y'), '%d %M %Y') as ExamDateText FROM tblexamschedule 
						WHERE coalesce(ExamDate,'') <> '' AND ExamID = " . $_SESSION["SESSSelectedExam"] . " ORDER BY ExamDate;";
						
						$result1 = $mysqli->query( $sql );
						while( $row = $result1->fetch_assoc() ) {
						extract($row);
						 if((isset($tmpExamDate) && $tmpExamDate == $ExamDate) || (isset($_GET['ExamDate']) && $_GET['ExamDate'] == $ExamDate) ){
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
					<select id="ddlExamDateSlot" name="ddlExamDateSlot" style="width:50%;margin-top:10px" >
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
				<td class="form_sec span4">
					<input type="submit" name="btnSearch" value="Search" title="Update" class="btn btn btn-success" />
					<input type="submit" name="btnAssignStds" value="Allocate Students" title="Allocate Students" class="btn btn btn-success" /><br/>
					
							
					<a onclick="return checkddl();" class='btn btn-mini btn-success'  target='_blank' href=<?php
					If(isset($tmpExamDate)){
						if($_SESSION["SESSSelectedExamType"] ==  'Online')
							echo "PrintDay.php?ExamDate=" . $tmpExamDate . "&ExamSlot=" . $tmpExamSlot ; 
						else
							echo "PrintDay.php?ExamDate=" . $tmpExamDate . "&ExamSlot=" . $tmpExamSlot ; 
					}
					else{
						echo "#";
					}
					?>
					>Seating</a>
					<a onclick="return checkddl();" class='btn btn-mini btn-success'  target='_blank' href=<?php
					If(isset($tmpExamDate)){
						echo "PrintBlockMain.php?ExamDate=" . $tmpExamDate . "&ExamSlot=" . $tmpExamSlot ; 
					}
					else{
						echo "#";
					}
					?>
					>Blocks</a>
					<a onclick="return checkddl();" class='btn btn-mini btn-success'  target='_blank' href=<?php
					If(isset($tmpExamDate)){
						echo "JrSupPrint.php?ExamDate=" . $tmpExamDate . "&ExamSlot=" . $tmpExamSlot ; 
					}
					else{
						echo "#";
					}
					?>
					>Jr Sup Duties</a>
					<a onclick="return checkddl();" class='btn btn-mini btn-success'  target='_blank' href=<?php
					If(isset($tmpExamDate)){
						echo "PrintPresentDay.php?ExamDate=" . $tmpExamDate . "&ExamSlot=" . $tmpExamSlot ; 
					}
					else{
						echo "#";
					}
					?>
					>Presenty</a>
					<a onclick="return checkddl();" class='btn btn-mini btn-success'  target='_blank' href=<?php
					If(isset($tmpExamDate)){
						echo "PrintReport.php?ExamDate=" . $tmpExamDate . "&ExamSlot=" . $tmpExamSlot ; 
					}
					else{
						echo "#";
					}
					?>
					>Paper Printing</a>
					<a onclick="return checkddl();" class='btn btn-mini btn-success'  href=<?php
					If(isset($tmpExamDate)){
						echo "ProfBlockMain.php?ExamDate=" . $tmpExamDate . "&ExamSlot=" . $tmpExamSlot ; 
					}
					else{
						echo "#";
					}
					?>
					>Prof. Block</a>
				</td>								
			</tr>						
		</table>
	<br/>
	<div style="float:left;margin-left:65px;margin-top:-20px">
		<label id="lblSuccess" style="margin-left:10px;color:green;font-weight:bold;display:none" ></label>
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
					<th>Jr. Sups.</th>
					<th>Relievers</th>
					<th>RCs</th>
					<th>Peons</th>
					<th></th>
				</tr>
				<?php
					include 'db/db_connect.php';
					//$tmpExamDate = '' ;
					//$tmpExamSlot = '' ;
					/*
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
					*/
						//if ($tmpExamDate == '') {$tmpExamDate = '01/01/1900';}
						//if ($tmpExamSlot == '') {$tmpExamSlot = 'Morning';}
						if (!isset($tmpExamDate)) {$tmpExamDate = '01/01/1900';}
						if (!isset($tmpExamSlot)) {$tmpExamSlot = 'Morning';}
						
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
								echo "<td><input type='text' maxlength='2' name='txtBlocks' class='span8' style='width:40px' value={$blocks}></td>";
								echo "<td><input type='text' maxlength='2' name='txtJrSup' style='width:40px' class='span8' value={$supcount}></td>";
								echo "<td><input type='text' maxlength='2' name='txtRel' class='span8' style='width:40px' value={$relcount}></td>";
								echo "<td><input type='text' maxlength='2' name='txtCC' class='span8' style='width:40px' value={$cccount}></td>";
								echo "<td><input type='text' maxlength='2' name='txtPeonCount' class='span8' style='width:40px' value={$peoncount}></td>";
								echo "<td class='span2'><input  onclick='return checkddl();' type='submit' name='btnSave' value='Save' title='Update' class='btn btn-mini btn-success' /><input type='hidden' name='txtebcrowid' value={$ebcrowid}></input></td>" ;
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
					<th>Blocks</th>
					<th>File Name</th>
					<th>Action</th>
				</tr>

				<?php
					include 'db/db_connect.php';
					//If ((isset($_POST['btnSearch'])))
						
					//If ((isset($_POST['btnSearch'])) or (isset($_POST['btnSave'])) or isset($_GET['ExamDate']) or isset($_POST['btnAssignStds']))
					//{
						
						//If (isset($_POST['btnSearch'])) { 
						/*
						If (isset($_POST['btnSearch']) or isset($_POST['btnSave']) or isset($_POST['btnAssignStds'])) { 
							$tmpExamDate = $_POST['ddlDate'] ;
							$tmpExamSlot = $_POST['ddlExamDateSlot'] ;
						}
						Else {
							$tmpExamDate = $_GET['ExamDate'] ;
							$tmpExamSlot = $_GET['ExamSlot'] ;
						}
						*/
						$sql = " SELECT ES.PaperID, EnggYear,PM.EnggPattern, DeptName,SubjectName,ES.TimeFrom, ES.TimeTo, Blocks, Students, 
								Supcount , ES.ExamSchId,
								concat(EnggYear,'-',PM.EnggPattern,'-', DeptName,'-',SubjectName,'-',Students) as PAPERINFO, 
								COALESCE(EB.FileName, '') as FileName, BlkCnt,
								concat(EnggYear,', ',DeptName,', ', PM.EnggPattern,', ',SubjectName,', ',Students) as PAPERINFO2,
								COALESCE(UploadedFile, '') as UploadedFile,
GROUP_CONCAT(CONCAT(SUBSTRING(BM.BlockName,1,INSTR(BM.BlockName,'-')-1),' - ',EB.Allocation) ORDER BY colorder SEPARATOR ', ') AS BlockAssignment
								FROM tblexamschedule ES INNER JOIN tblpapermaster PM ON ES.PaperID = PM.PaperID 
								INNER JOIN tblsubjectmaster SM ON PM.SubjectID = SM.SubjectID 
								INNER JOIN tbldepartmentmaster DM ON PM.DeptID = DM.DeptID 
								INNER JOIN tblexammaster EM ON EM.ExamID = ES.ExamID 
								LEFT OUTER JOIN (SELECT COUNT(distinct BlockID) AS BlkCnt, ExamSchID, FileName FROM tblexamblock GROUP BY ExamSchID, FileName) AS EBS ON ES.ExamSchID = EBS.ExamSchID 
								LEFT OUTER JOIN tblexamblock EB ON ES.ExamSchID = EB.ExamSchID 
								LEFT OUTER JOIN tblblocksmaster BM ON BM.BlockId = EB.BlockId  
							 WHERE ES.ExamID = " . $_SESSION["SESSSelectedExam"] . "
							 AND ES.ExamSlot = '" . $tmpExamSlot . "' 
							 AND ES.ExamDate = '". $tmpExamDate . "'
							 AND Students <> 0
							 Group by ExamSchID
							 ORDER BY PaperCode, PM.EnggPattern, DM.orderno, EnggYear, DeptName, SubjectName Asc";
						//echo $sql;
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
								echo "<td style='width:200px'>{$BlkCnt} ({$BlockAssignment})</td>";
								if ($FileName == '') {
									if ($UploadedFile <> '') {
										echo "<td>From Summary File</td>";
									}
									else {
										If ($FileName == '') {
											echo "<td style='color:red'>Pending</td>";
										}
									}
								}
								else {
									echo "<td>{$FileName}</td>";
								}
								$PI2 = urlencode($PAPERINFO2);
								echo "<td class='span2'>
										<a class='btn btn-mini btn-success' 
										href='PaperBlockMain.php?PaperId={$PaperID}&ExDate={$tmpExamDate}&ExSlot={$tmpExamSlot}&paperinfo={$PI2}&ExamSchId1={$ExamSchId}'>
										<i class='icon-ok icon-white'></i>&nbsp;&nbsp;Show Blocks</a>";
									echo "<a class='btn btn-mini btn-success' 
										href='BlockFileMain.php?PaperId={$PaperID}&ExDate={$tmpExamDate}&ExSlot={$tmpExamSlot}&paperinfo={$PI2}&ExamSchId1={$ExamSchId}'>
										<i class='icon-ok icon-white'></i>&nbsp;&nbsp;Upload</a>";
								echo "</td>";
								echo "</TR>";
								$totStd = $totStd + $Students;
							}
						}			

			$sql2 = "SELECT COUNT(DISTINCT EB.BlockId) AS BLOCKCOUNT
					FROM  tblexamschedule ES 
					INNER JOIN tblpapermaster PM ON ES.paperid = PM.paperid 
					INNER JOIN tblsubjectmaster SM ON PM.SubjectID = SM.SubjectID 
					INNER JOIN tbldepartmentmaster DM ON PM.DeptID = DM.DeptID 
					LEFT OUTER JOIN tblexamblock EB ON ES.ExamSchID = EB.ExamSchID
					INNER JOIN tblexammaster EM ON EM.ExamID = ES.ExamID
					LEFT OUTER JOIN tblblocksmaster BM ON BM.BlockId = EB.BlockId
					LEFT JOIN (SELECT MIN(StdId) AS StdId, EBS.ExamBlockId FROM tblexamblockstudent EBS GROUP BY EBS.ExamBlockId) AS A ON 					A.ExamBlockID = EB.ExamBlockID
					LEFT JOIN (SELECT MAX(StdId) AS StdId, EBS.ExamBlockId FROM tblexamblockstudent EBS GROUP BY EBS.ExamBlockId) AS B ON 					B.ExamBlockID = EB.ExamBlockID
					WHERE ES.ExamSlot = '" . $tmpExamSlot . "' 
					AND ES.ExamDate = '". $tmpExamDate . "'
					AND ES.ExamID = ".$_SESSION["SESSSelectedExam"]."
					ORDER BY colorder, DM.orderno, EnggYear, EnggPattern, DeptName, SubjectName limit 1;";

			//echo $sql;
			// execute the sql query
			$result2 = $mysqli->query( $sql2 );
				echo $mysqli->error;
			$num_results2 = $result2->num_rows;

			if( $num_results2 ){
				while( $row2 = $result2->fetch_assoc() ){
					extract($row2);
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
						echo"<th>{$BLOCKCOUNT}</th>";
						echo"</tr>";
					//}
				?>



			</table>
        </div>
	</div>
	<div class="clear"></div>
