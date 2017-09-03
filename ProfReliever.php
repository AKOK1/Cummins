
<form action="ProfRelieverMain.php" method="post" >

	<br /><br />
	<h3 class="page-title" style="margin-left:5%">Paper Maintenance</h3>
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
						if((isset($_POST['ddlDate']) && $_POST['ddlDate'] == $ExamDate) || 
							(isset($_GET['ExamDate']) && $_GET['ExamDate'] == $ExamDate)){
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
	    <div class="span5 v_detail" style="overflow:hidden">
            <br />
            <br />
            <div style="float:left">
				<label><b>Available Jr. Supervisor's</b></label>
            </div>
			<table cellpadding="10" cellspacing="0" border="0" width="100%" class="tab_split">
				<tr>
					<th>Select Professor</th>
					<th width="10%"><strong>Action</strong></th>
				</tr>
				<?php
					include 'db/db_connect.php';
					If ((isset($_POST['btnSearch'])) or (isset($_POST['btnSave'])) or isset($_GET['ExamSlot']))
					{
						If (isset($_POST['btnSearch'])) { 
							$tmpExamDate = $_POST['ddlDate'] ;
							$tmpExamSlot = $_POST['ddlExamDateSlot'] ;
						}
						Else {
							$tmpExamDate = $_GET['ExamDate'] ;
							$tmpExamSlot = $_GET['ExamSlot'] ;
						}
							
						$sql = "SELECT CONCAT(FirstName, ' ', LastName) AS ProfName, userID
								FROM tblprofessorpref PP
								INNER JOIN tbluser U ON PP.ProfID = U.userID
								WHERE ExamDate = '" . $tmpExamDate . "'
								AND ExamSlot = '" . $tmpExamSlot . "' 
								AND U.userID NOT IN (
									SELECT COALESCE(ProfID, 0)
									FROM tblexamblock EB 
									INNER JOIN tblExamSchedule ES ON EB.ExamSchID = ES.ExamSchID 
									WHERE ES.ExamId = 1
									AND ES.ExamDate = '" . $tmpExamDate . "'
									AND ExamSlot = '" . $tmpExamSlot . "' )
								AND U.userID NOT IN (
									SELECT COALESCE(ProfID, 0) 
									FROM tblreliever R 
									INNER JOIN tblExamSchedule ES ON R.ExamSchID = ES.ExamSchID 
									AND ES.ExamDate = '" . $tmpExamDate . "'
									AND ExamSlot = '" . $tmpExamSlot . "' )
									" ;
						//echo $sql;
						
						// execute the sql query
						$result = $mysqli->query( $sql );
						$num_results = $result->num_rows;

						if( $num_results ){
							while( $row = $result->fetch_assoc() ){
								extract($row);
								echo "<TR class='odd gradeX'>";
								echo "<td>{$ProfName} </td>";
								echo "<td class='span3'><a class='btn btn-mini btn-success' href='ProfRelieverUpd.php?IUD=U&ExamDate=" .$tmpExamDate."&ExamSlot=".$tmpExamSlot. "&ProfID={$userID}'><i class='icon-ok icon-white'></i>&nbsp&nbspAssign</a>
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

		<div class="span1 v_detail" style="overflow:hidden">
            <div style="margin-top:80px;margin-left:15px;float:left">
            <br />
            <br />
            <center>
				<br/>
				<br/>
				<br/>
				<br/>
				<br/>
				<br/>
				<br/>
				<br/>
            </center>
            </div>
        </div>
        
        <div class="span5 v_detail" style="overflow:hidden">
            <br/>
            <br/>
            <div style="float:left">
				<label><b>Allocated Jr. Professor</b></label>
            </div>
			<br/>
			<table cellpadding="10" cellspacing="0" border="0" width="40%" class="tab_split">
				<tr>
					<th>Professor</th>
					<th width="10%"><strong>Action</strong></th>
				</tr>
				<?php
					include 'db/db_connect.php';
					If ((isset($_POST['btnSearch'])) or (isset($_POST['btnSave'])) or isset($_GET['ExamSlot']))
					{
						If (isset($_POST['btnSearch'])) { 
							$tmpExamDate = $_POST['ddlDate'] ;
							$tmpExamSlot = $_POST['ddlExamDateSlot'] ;
						}
						Else {
							$tmpExamDate = $_GET['ExamDate'] ;
							$tmpExamSlot = $_GET['ExamSlot'] ;
						}

						$sql = "SELECT CONCAT(FirstName, ' ', LastName) AS ProfName, RelID
								FROM tblreliever R
								INNER JOIN tbluser U ON R.ProfID = U.userID
								INNER JOIN tblexamschedule ES ON ES.ExamSchID = R.ExamSchId
								WHERE ExamDate = '" . $tmpExamDate . "'
								AND ExamSlot = '" . $tmpExamSlot . "' " ;
						//echo $sql;
						// execute the sql query
						$result = $mysqli->query( $sql );
						$num_results = $result->num_rows;

						if( $num_results ){
							while( $row = $result->fetch_assoc() ){
								extract($row);
								echo "<TR class='odd gradeX'>";
								echo "<td>{$ProfName}</td>";
								echo "<td class='span3'><a class='btn btn-mini btn-danger' href='ProfRelieverUpd.php?IUD=D&RelID={$RelID}&ExamDate=".$tmpExamDate."&ExamSlot=".$tmpExamSlot. "'>
														<i class='icon-remove icon-white'></i>&nbsp&nbspCancel</a></td>";
								echo "</TR>";
							}
						}					
						//disconnect from database
						$result->free();
						$mysqli->close();
					}
				?>
			</table>
			


			</div>
	</div>
	</form>

