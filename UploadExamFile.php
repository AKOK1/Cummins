<form action="uploaderES.php" method="post" enctype="multipart/form-data">
<?php
	if(!isset($_SESSION)){
		session_start();
	}
	/* Template User BlockFile.php */
?>	
	<br /><br /><br />
	
	<h3 class="page-title" style="margin-left:5%">Upload Exam Schedule</h3>
	<h3 class="page-title" style="float:right;margin-top:-40px;"><a href="ExamIndexMain.php">Back</a></h3>

	<h3 class="page-title" style="float:right;margin-top:-46px;"></h3>

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
				</tr>

				<?php
				include 'db/db_connect.php';
				$sql = " SELECT  @a:=@a+1 AS SrNo, UploadedFile FROM tblexamfile  , (SELECT @a:= 0) AS a where ExamID = " . $_SESSION["SESSSelectedExam"] . "";
					//echo $sql;
					
					// execute the sql query
					$result = $mysqli->query( $sql );
					$num_results = $result->num_rows;

					if( $num_results ){
						while( $row = $result->fetch_assoc() ){
							extract($row);
							echo "<TR class='odd gradeX'>";
							echo "<td>{$SrNo}</td>";
							echo "<td>{$UploadedFile}</td>";
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
	<div class="clear"></div>

		</form>