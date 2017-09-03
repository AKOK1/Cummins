<form method="post">

	<br /><br />
	<h3 class="page-title" style="margin-left:5%">Day Schedule</h3>
	<h3 class="page-title" style="float:right;margin-top:-40px;"><a href="examindexmain.php">Back</a></h3>
		<table cellpadding="10" cellspacing="0" border="0" class="tab_split" style="margin-left:5%">
			<tr >
				<td class="form_sec span1">Exam Date</td>
				<td class="form_sec span2">
					<select name="ddlDate" style="width:50%;margin-top:10px">
						<?php
						include 'db/db_connect.php';
						echo "<option value=Select>Select</option>"; 
						$sql = "SELECT DISTINCT(ExamDate) AS ExamDate FROM tblexamschedule ORDER BY ExamDate;";
						$result1 = $mysqli->query( $sql );
						while( $row = $result1->fetch_assoc() ) {
						extract($row);
						 if((isset($_POST['ddlDate']) && $_POST['ddlDate'] == $ExamDate)){
								echo "<option value={$ExamDate} selected>{$ExamDate}</option>"; 
							}
							else{
								echo "<option value={$ExamDate}>{$ExamDate}</option>"; 
							}
						}
						?>
					</select>
				</td>
				<td class="form_sec span1">Date</td>
				<td class="form_sec span2">
					<select name="ddlExamDateSlot" style="width:50%;margin-top:10px" >
						<option value="Select " <?php echo (isset($_POST['ddlExamDateSlot']) && $_POST['ddlExamDateSlot'] == 'Select ')?'selected="selected"':''; ?>>Select </option>
						<option value="Morning" <?php echo (isset($_POST['ddlExamDateSlot']) && $_POST['ddlExamDateSlot'] == 'Morning')?'selected="selected"':''; ?>>Morning</option>
						<option value="Evening" <?php echo (isset($_POST['ddlExamDateSlot']) && $_POST['ddlExamDateSlot'] == 'Evening')?'selected="selected"':''; ?>>Evening</option>
					</select>
				</td>
				<td class="form_sec span2">
					<input type="submit" name="btnSearch" value="Search" title="Update" class="btn btn-mini btn-success" />
					<a class='btn btn-mini btn-success' 
					  href=<?php  
								If ((isset($_POST['btnSearch'])) or (isset($_POST['btnSave'])))
								{
									echo "PrintDay.php?ExamDate=" . $_POST['ddlDate'] . "&ExamSlot=" . $_POST['ddlExamDateSlot'] ; 
								}
							?>
					>Print</a>
				</td>								
			</tr>						
		</table>

	<br/>
	<br/>


	
	<div class="row-fluid" style="margin-left:5%">
	    <div class="span10 v_detail" style="overflow:hidden">

			
			<table cellpadding="10" cellspacing="0" border="0" width="100%" class="tab_split">
				<tr>
					<th>Year</th>
					<th>Pattern</th>
					<th>Department</th>
					<th>Subject</th>
					<th>Time From - To</th>
					<th>Block</th>
					<th>Students</th>
					<th>Jr. Supervisor</th>
					<th>Action</th>
				</tr>

				<?php
					If ((isset($_POST['btnSearch'])) or (isset($_POST['btnSave'])))
					{
						$sql = " SELECT EnggYear,EnggPattern, DeptName,SubjectName,ES.TimeFrom, ES.TimeTo, BM.BlockName, EB.Allocation
								, CONCAT(FirstName, ' ', LastName) AS JrSupervisor, ExamBlockId, ES.ExamDate, ES.ExamSlot
								FROM  tblexamschedule ES 
								INNER JOIN tblpapermaster PM ON es.paperid = PM.paperid 
								INNER JOIN tblsubjectmaster SM ON PM.SubjectID = SM.SubjectID 
								INNER JOIN tbldepartmentmaster DM ON PM.DeptID = DM.DeptID 
								INNER JOIN tblexamblock AS EB ON ES.ExamSchID = EB.ExamSchID
								INNER JOIN tblexammaster EM ON EM.ExamID = ES.ExamID
								INNER JOIN tblblocksmaster BM ON BM.BlockId = EB.BlockId
								LEFT OUTER JOIN tbluser U on U.userID = EB.ProfID
							 WHERE ES.ExamSlot = '" . $_POST['ddlExamDateSlot'] . "' 
							 AND ES.ExamDate = '". $_POST['ddlDate'] . "'
							 ORDER BY EnggYear, EnggPattern, DeptName, SubjectName, BlockName ";

						//echo $sql;
						
						// execute the sql query
						$result = $mysqli->query( $sql );
						$num_results = $result->num_rows;

						if( $num_results ){
							while( $row = $result->fetch_assoc() ){
								extract($row);
								echo "<TR class='odd gradeX'>";
								echo "<td>{$EnggYear}</td>";
								echo "<td>{$EnggPattern}</td>";
								echo "<td>{$DeptName}</td>";
								echo "<td>{$SubjectName}</td>";
								echo "<td>{$TimeFrom} to {$TimeTo}</td>";
								echo "<td>{$BlockName}</td>";
								echo "<td>{$Allocation}</td>";
								echo "<td>{$JrSupervisor}</td>";
								echo "<td class='span2'>
										<a class='btn btn-mini btn-success' 
										href='PrintSeat.php?IUD=P&ExamBlockId1={$ExamBlockId}'>
										<i class='icon-ok icon-white'></i>&nbsp&nbspPrint Student List</a>
										<br/><br/>
										<a class='btn btn-mini btn-success' 
										href='ProfBlockMain.php?ExamBlockId1={$ExamBlockId}&ExamDate={$ExamDate}&ExamSlot={$ExamSlot}'>
										<i class='icon-ok icon-white'></i>&nbsp&nbspJr. Supervisor</a>
									  </td>";
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
