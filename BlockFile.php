<form action="uploaderExamFile.php" method="post" enctype="multipart/form-data">
<?php
	if(!isset($_SESSION)){
		session_start();
	}
If ((isset($_GET['ExDate'])) or (isset($_GET['ExSlot']))){
$_SESSION["SESSExDate"] = $_GET['ExDate'];
$_SESSION["SESSExSlot"] = $_GET['ExSlot'];
$_SESSION["SESSABPaperId"] = $_GET['PaperId'];
$_SESSION["SESSABpaperinfo"] = $_GET['paperinfo'];
$_SESSION["SESSExSchId"] = $_GET['ExamSchId1'];
}

?>	
	<br /><br /><br />
	
	<h3 class="page-title" style="margin-left:5%">Upload CSV file for - <b><?php echo date('d-M-Y',strtotime($_SESSION["SESSExDate"])). ", ". $_SESSION["SESSExSlot"] ;?></b></h3>
	<h3 class="page-title" style="float:right;margin-top:-46px;">
	<?php echo "<a href='SelectPaperBlockMain.php?ExamDate={$_SESSION["SESSExDate"]}&ExamSlot={$_SESSION["SESSExSlot"]}'>Back</a>"; ?>
	</h3>

		<table cellpadding="10" cellspacing="0" border="0" class="tab_split" style="margin-left:5%;width:80%">
			<tr >
				<td class="form_sec span1"><h3><b>Paper</b></h3></td>
				<td class="form_sec span10"><h3><b><?php echo $_GET['paperinfo'] ?></b></h3></td>

<!--				<select name="ddlPaper" style="width:90%;margin-top:10px">
					<?php
/*						include 'db/db_connect.php';
						
						$sql = "SELECT 0 AS PaperId, 'Select Paper'  AS PaperName, '-1' AS orderno , '-1' AS EnggPattern, -1 AS Yorder 
							UNION 
							SELECT ES.PaperId, 
							CONCAT(CAST(EnggYear AS CHAR),' - ',DeptName, ' - ' , EnggPattern,' - ',SubjectName,' - Students: ',Students,' - Blocks: ',EB.Blocks) AS PaperName , 
							DM.orderno, EnggPattern, 
							CASE EnggYear WHEN 'FE - Sem 1' THEN 1 WHEN 'FE - Sem 2' THEN 2 
							WHEN 'SE - Sem 1' THEN 3 WHEN 'SE - Sem 2' THEN 4 
							WHEN 'TE - Sem 1' THEN 5 WHEN 'TE - Sem 2' THEN 6 
							WHEN 'BE - Sem 1' THEN 7 WHEN 'BE - Sem 2' THEN 8 
							WHEN 'ME - Sem 1' THEN 9 WHEN 'ME - Sem 2' THEN 10 WHEN 'TE - Sem 3' THEN 11 END AS Yorder
							FROM  tblexamschedule ES 
							INNER JOIN tblexammaster EM on EM.ExamID = ES.ExamID
							INNER JOIN tblpapermaster PM ON ES.PaperID = PM.PaperID 
							INNER JOIN tblsubjectmaster SM ON PM.SubjectID = SM.SubjectID 
							INNER JOIN tbldepartmentmaster DM ON PM.DeptID = DM.DeptID 
							INNER JOIN (SELECT SUM(Capacity) AS Capacity, SUM(Allocation) AS Allocation, ExamSchID, PaperID, FileName 
								, COUNT(BlockID) AS Blocks FROM tblexamblock GROUP BY ExamSchID, PaperID) AS EB
							ON ES.ExamSchID = EB.ExamSchID
							WHERE EB.FileName IS NULL and ES.ExamID = " . $_SESSION["SESSSelectedExam"] . "
							ORDER BY Yorder, orderno, EnggPattern ;";
							
						$result1 = $mysqli->query( $sql );
						while( $row = $result1->fetch_assoc() ) {
						extract($row);
						echo "<option value={$PaperId} ";  
						If ((isset($_POST['ddlPaper']) && $_POST['ddlPaper'] == $PaperId) || (isset($_SESSION["SESSPaperID"]) && $_SESSION[	"SESSPaperID"] == $PaperId)) 
						{ echo 'selected';}
						echo ">{$PaperName}</option>"; 
						}
*/					?>
					</select> -->
				</td>

				<td class="form_sec span2">
					<input type="file" name="fileToUpload" id="fileToUpload"/>
					<input type="hidden" name="ddlPaper" value="<?php echo $_GET['PaperId'] ?>"/>
					<input type="hidden" name="txtExamSchId" value="<?php echo $_GET['ExamSchId1'] ?>"/>
					<input type="hidden" name="txtPaperInfo" value="<?php echo $_GET['paperinfo'] ?>"/>
					<br/>
					<input type="submit" name="btnUpload" value="Upload CSV" title="Upload" class="btn btn-mini btn-success" />
				</td>								
						

			</tr>						
		</table>

	<div class="row-fluid" style="margin-left:5%">
	    <div class="span10 v_detail" style="overflow:scroll">
            <br />
            <br />
            <div style="float:left">
				<label><b>Uploaded Files</b></label>
            </div>
			<table cellpadding="10" cellspacing="0" border="0" width="100%" class="tab_split">
				<tr>
					<th>Paper</th>
					<th>File Name </th>
					<th>Block </th>
					<th>Allocation </th>
					<th>Partial </th>
					<th><strong>Action</strong></th>
				</tr>
				<?php
					include 'db/db_connect.php';
					  $sql = "SELECT ES.PaperId, CONCAT(CAST(EnggYear AS CHAR),'-',DeptName, '-' 			,EnggPattern,'-',SubjectName,'-Students:',Students) AS PaperName, EB.ExamBlockId , BlockName, FileName, EB.ExamSchID
							,CASE EnggYear WHEN 'FE - Sem 1' THEN 1 WHEN 'FE - Sem 2' THEN 2 
							WHEN 'SE - Sem 1' THEN 3 WHEN 'SE - Sem 2' THEN 4 
							WHEN 'TE - Sem 1' THEN 5 WHEN 'TE - Sem 2' THEN 6 
							WHEN 'BE - Sem 1' THEN 7 WHEN 'BE - Sem 2' THEN 8 
							WHEN 'ME - Sem 1' THEN 9 WHEN 'ME - Sem 2' THEN 10 WHEN 'TE - Sem 3' THEN 11 END AS Yorder,
							DM.orderno, EnggPattern, Allocation, Case IsPartial When 1 then 'Yes' When 0 then 'No' End as IsPartial
							FROM  tblexamschedule ES 
						INNER JOIN tblexammaster em on em.ExamID = ES.ExamID
						INNER JOIN tblpapermaster PM ON ES.PaperID = PM.PaperID 
						INNER JOIN tblsubjectmaster SM ON PM.SubjectID = SM.SubjectID 
						INNER JOIN tbldepartmentmaster DM ON PM.DeptID = DM.DeptID 
						INNER JOIN tblexamblock AS EB ON ES.ExamSchID = EB.ExamSchID
						INNER JOIN tblblocksmaster BM ON EB.BlockID = BM.BlockID
						WHERE EB.FileName IS NOT NULL and ES.EXamID = " . $_SESSION["SESSSelectedExam"] . " 
						and ES.ExamSchID = " .  $_GET['ExamSchId1'] .  "
							ORDER BY Yorder, orderno, EnggPattern, BM.colorder ;";

						// execute the sql query
						$result = $mysqli->query( $sql );
						$num_results = $result->num_rows;

						if( $num_results ){
							while( $row = $result->fetch_assoc() ){
								extract($row);
								echo "<TR class='odd gradeX'>";
								echo "<td>{$PaperName} </td>";
								echo "<td>{$FileName} </td>";
								echo "<td>{$BlockName} </td>";
								echo "<td>{$Allocation} </td>";
								echo "<td>{$IsPartial} </td>";
								echo "<td class='span2'>
										<a class='btn btn-mini btn-danger' 
										href='BlockFileUpd.php?IUD=D&ExamBlockId={$ExamSchID}&PaperInfo={$_GET['paperinfo']}'>
										<i class='icon-remove icon-white'></i>&nbsp&nbspDelete</a>
									  </td>";
								echo "</TR>";
							}
						}					
						//disconnect from database
						$result->free();
						$mysqli->close();
				?>
				</table>
            <br />
        </div>

	</div>
	</form>

