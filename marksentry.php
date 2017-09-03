<?php
//include database connection
include 'db/db_connect.php';
// if the form was submitted/posted, update the record
	if (isset($_POST['btnSave'])){

		//first delete existing
		$sql = " delete from tblprormarks WHERE cbpid = ".$_GET['cbpid'] . "";
		// execute the sql query
		$result = $mysqli->query( $sql );

		foreach (array('txtStdAdmID', 'txtStdAdmID') as $pos) {
			foreach ($_POST[$pos] as $id => $row) {
				$_POST[$pos][$id] = mysqli_real_escape_string($mysqli, $row);
			} 
		}
		$AdmIDs = $_POST['txtStdAdmID'];
		$Marks = $_POST['txtMarks'];
		$size = count($AdmIDs);
		for($i = 0 ; $i < $size ; $i++){
			$sql = "Insert into tblprormarks ( cbpid,stdadmid,marks,created_by,created_on) 
					Values ( ?, ?, ?, ?, CURRENT_TIMESTAMP)";
				$stmt = $mysqli->prepare($sql);
				$stmt->bind_param('iiss',$_GET['cbpid'], $AdmIDs[$i], $Marks[$i], $_SESSION["SESSUserID"] );
				if($stmt->execute()){
					//header('Location: SubjectList.php?'); 
				} else{
					echo $mysqli->error;
					//die("Unable to update.");
				}
		}
		echo "<script type='text/javascript'>window.onload = function()
						{
								document.getElementById('lblSuccess').style.display = 'block';
						}
						</script>";

	}
?>
<form action="marksentryMain.php?cbpid=<?php echo $_GET['cbpid']; ?>&subjname=<?php echo $_GET['subjname']; ?>" method="post">
<?php
?>		
	<br /><br />
	<div class="row-fluid">
		<div style="float:left"><h3 class="page-title">Term Work Marks for Div. <?php echo $_GET['subjname']; ?></h3>
		<h4>Maximum Marks 25&nbsp;&nbsp;&nbsp;&nbsp;Minimum Marks 10</h4>
		</div>
	 <div style="float:left;margin-top:18px;margin-left:20px;">
			<input type="submit" style="width:50px;margin-top:5px" name="btnSave" value="Save" title="Update" class="btn btn-mini btn-success" />&nbsp;&nbsp;&nbsp;&nbsp;
			<a target='_blank' href='MarksReport.php?cbpid=<?php echo $_GET['cbpid']; ?>&subjname=<?php echo $_GET['subjname']; ?>'>View Report</a>
		</div> 
		<div style="float:right"><h3 class='page-title' style='margin-right:30px;'><a href='assigneddivListMain.php'>Back</a></h3></div>
	</div>	
	<br/>
	<div><center>
		<label id="lblSuccess" style="color:green;display:none" >Marks saved successfully.</label>
		</center>
	</div>
		<div class="row-fluid">
		<div class="v_detail">
			<table cellpadding="10" cellspacing="0" border="0" width="80%" class="tab_split">
				<tr>
					<th width="8%">Sr. No.</td>
					<th style="width:20%">Roll No.</th>
					<th style="width:20%">ESN</th>
				<?php
					//for ( $i = 1; $i<=1; $i++ ){
						echo"<th>Marks</th>";
					//}
				?>
				</tr>
				<?php
						if(!isset($_SESSION)){
							session_start();
						}
					include 'db/db_connect.php';
					$sql = "SELECT (MAX(EduYearTo) - 1) AS YearFrom, MAX(EduYearTo) as YearTo FROM tblcuryearauto";
					$result = $mysqli->query($sql);
					$num_results = $result->num_rows;
					If( $num_results ){
						while( $row = $result->fetch_assoc() ){
							extract($row);
							$SelYearFrom = $YearFrom;
							$SelYearTo = $YearTo;
						}
					}
					else {
							echo "Error";
							die;
					}		
					$result->free();
//echo $_SESSION["SESSCAPSelectedExamName"];
					if(stripos($_SESSION["SESSCAPSelectedExamName"], 'Regular') > 0 ){
						$sql = "SELECT distinct RollNo,ESNum,sa.StdAdmID,CONCAT(FirstName, ' ',FatherName , ' ', Surname) AS StdName,marks
								FROM tblstdadm sa
								INNER JOIN tblstudent s ON s.StdID = sa.StdID
								INNER JOIN tblyearstructstd yss ON yss.StdAdmID = sa.StdAdmID
								INNER JOIN tblyearstruct ys ON ys.rowid = yss.YSID
								INNER JOIN tblpapermaster pm ON SUBSTRING(pm.EnggYear,1,2) = REPLACE(YEAR,'.','') AND COALESCE(StdStatus,'') IN ('R','P')
								AND pm.PaperID = ys.PaperID
								INNER JOIN tbldivmaster dm ON REPLACE(dm.Year,'.','') = SUBSTRING(pm.EnggYear,1,2) 
								INNER JOIN tblexammaster em ON em.AcadYearFrom = dm.EduYearFrom AND SUBSTRING(EnggYear,LENGTH(EnggYear),1)  = em.Sem
								INNER JOIN `tblpatternmaster` patm ON patm.acadyear = CONCAT(em.AcadYearFrom,'-',SUBSTRING(em.AcadYearTo,3,2)) AND dm.year = patm.eduyear 
								AND pm.EnggPattern = patm.teachingpat 
								INNER JOIN tblcapblockprof cpb ON cpb.ExamBlockID = pm.PaperID AND cpb.`div` = dm.DivName 
								LEFT OUTER JOIN tblprormarks prormarks ON cpb.cbpid = prormarks.cbpid AND prormarks.stdadmid = sa.StdAdmID
								WHERE (COALESCE(PracticalPRapp,0) = 1 OR COALESCE(OralORapp,0) = 1  OR COALESCE(TermWorkapp,0) = 1) 
								AND cpb.cbpid = " . $_GET["cbpid"] . " AND sa.Div = cpb.div AND em.AcadYearFrom = sa.EduYearFrom 
								and cpb.ExamID = " . $_SESSION["SESSCAPSelectedExam"] . "
								Order by RollNo";
								//INNER JOIN tblcuryearauto cy ON cy.EduYearFrom = dm.EduYearFrom AND SUBSTRING(EnggYear,LENGTH(EnggYear),1)  = cy.Sem
					}
					else{
						$sql = "SELECT distinct RollNo,ESNum,sa.StdAdmID,CONCAT(FirstName, ' ',FatherName , ' ', Surname) AS StdName,marks
								FROM tblstdadm sa
								INNER JOIN tblstudent s ON s.StdID = sa.StdID
								INNER JOIN tblyearstructstdretest yss ON yss.StdAdmID = sa.StdAdmID
								INNER JOIN tblyearstruct ys ON ys.rowid = yss.YSID
								INNER JOIN tblpapermaster pm ON SUBSTRING(pm.EnggYear,1,2) = REPLACE(YEAR,'.','') AND COALESCE(StdStatus,'') IN ('R','P')
								AND pm.PaperID = ys.PaperID
								INNER JOIN tbldivmaster dm ON REPLACE(dm.Year,'.','') = SUBSTRING(pm.EnggYear,1,2) 
								INNER JOIN tblexammaster em ON em.AcadYearFrom = dm.EduYearFrom AND SUBSTRING(EnggYear,LENGTH(EnggYear),1)  = em.Sem
								INNER JOIN `tblpatternmaster` patm ON patm.acadyear = CONCAT(em.AcadYearFrom,'-',SUBSTRING(em.AcadYearTo,3,2)) AND dm.year = patm.eduyear 
								AND pm.EnggPattern = patm.teachingpat 
								INNER JOIN tblcapblockprof cpb ON cpb.ExamBlockID = pm.PaperID
								LEFT OUTER JOIN tblprormarks prormarks ON cpb.cbpid = prormarks.cbpid AND prormarks.stdadmid = sa.StdAdmID
								WHERE (COALESCE(PracticalPRapp,0) = 1 OR COALESCE(OralORapp,0) = 1  OR COALESCE(TermWorkapp,0) = 1) 
								AND cpb.cbpid = " . $_GET["cbpid"] . " AND em.AcadYearFrom = sa.EduYearFrom 
								and cpb.ExamID = " . $_SESSION["SESSCAPSelectedExam"] . "
								Order by RollNo";
								//INNER JOIN tblcuryearauto cy ON cy.EduYearFrom = dm.EduYearFrom AND SUBSTRING(EnggYear,LENGTH(EnggYear),1)  = cy.Sem
// AND cpb.`div` = dm.DivName  AND sa.Div = cpb.div 
					}
					echo $sql;
					//and sa.Dept = pm.DeptID 
//and sa.Year = 'M.E.'  
					$result = $mysqli->query($sql);
					$num_results = $result->num_rows;
					//echo $num_results;
					$srno = 1;
					if( $num_results ){
						while( $row = $result->fetch_assoc() ){
							extract($row);
							echo "<TR class='odd gradeX'>";
							echo "<td>{$srno} </td>";
							echo "<td>{$RollNo} </td>";
							echo "<td>{$ESNum} </td>";
								//for ( $i = 1; $i<=1; $i++ ){
									echo "<td>
											<input name='txtStdAdmID[]' type='text' style='display:none;' value='{$StdAdmID}'>
											<input maxlength='10' name='txtMarks[]' type='text' style='width:100px;margin-left:1%;' value='{$marks}'>
										</td>";
								//}
							echo "</TR>";
							$srno = $srno  + 1;
						}
					}											
					$result->free();
					//disconnect from database
					$mysqli->close();
				?>
			</table>
		</div>
	</div>
	</form>
