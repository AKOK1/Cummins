<form action="uploaderResF.php" method="post" enctype="multipart/form-data">
<?php
	if(!isset($_SESSION)){
		session_start();
	}

	/* Template User BlockFile.php */
	
	
//SELECT * FROM tblpapermaster PM INNER JOIN tblsubjectmaster SM ON PM.SubjectID = SM.SubjectID
//WHERE EnggYear = 'BE - Sem 1' AND EnggPattern = 2008 AND SM.Subjectname LIKE 'CAD/CAM AU%'
?>	
	<br /><br /><br />
	
	<h3 class="page-title" style="margin-left:5%">Upload Result File</h3>
	<h3 class="page-title" style="float:right;margin-top:-40px;"><a href="ExamIndexMain.php">Back</a></h3>

	<table cellpadding="10" cellspacing="0" border="0" class="tab_split" style="margin-left:5%;width:80%">
		<tr >
			<td class="form_sec span2">
				<input type="file" name="fileToUpload" id="fileToUpload"/>
				<input type="submit" name="btnUpload" value="Upload" title="Upload" class="btn btn-mini btn-success" />
			</td>								
		</tr>						
	</table>


	<br/>
	<div class="row-fluid" style="margin-left:5%">
	    <div class="span10 v_detail" style="overflow:scroll">
			<table cellpadding="10" cellspacing="0" border="0" class="tab_split" >
				<tr>
					<th class='span2'>Sr. No.</th>
					<th class='span7'>File Name</th>
					<th></th>
					<th></th>
				</tr>

				<?php
				include 'db/db_connect.php';
				$sql = " SELECT  UploadedFile, ResFileID FROM tblresultfile  where 
				ExamId = " . $_SESSION['SESSSelectedExam'];
					//echo $sql;
					
					// execute the sql query
					$result = $mysqli->query( $sql );
					$num_results = $result->num_rows;
					$i = 1;
					if( $num_results ){
						while( $row = $result->fetch_assoc() ){
							extract($row);
							echo "<TR class='odd gradeX'>";
							echo "<td>$i</td>";
							echo "<td>{$UploadedFile}</td>";
							echo "<td class='span2'><a class='btn btn-mini btn-success' href='UniResDeptMapMain.php?ResFileID={$ResFileID}'>
									<i class='icon-ok icon-white'></i>Dept Map</a></td>";
							echo "<td class='span2'><a class='btn btn-mini btn-danger' href='ResultFileUpd.php?ResFileID={$ResFileID}'>
									<i class='icon-remove icon-white'></i>Cancel</a></td>";
							echo "</TR>";
						$i = $i + 1;
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
	<div class="clear"></div>

		</form>