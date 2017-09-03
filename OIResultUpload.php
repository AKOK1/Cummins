<form action="OIResultUploadMain.php" method="post" onsubmit='showLoading();' enctype="multipart/form-data">
<body>

<?php
//include database connection
include 'db/db_connect.php';
// if the form was submitted/posted, update the record
	if(isset($_POST['ddlExam']) && ($_POST['ddlExam'] != ''))
	{
		if(!isset($_SESSION)){
			session_start();
		}
		$_SESSION["SESSSelectedExam"] = $_POST['ddlExam'];
		$_SESSION["SESSSelectedYear"] = $_POST['ddlYear'];		
		$_SESSION["SESSSelectedExamName"] = $_POST['examname_hidden'];

		If (isset($_POST['btnPublish']))
		{
			if(!isset($_SESSION)){
				session_start();
			}
			include 'db/db_connect.php';
			$sql = "update tbloiresults set Publish = 1 where ExamID = " . $_SESSION["SESSSelectedExam"];
			$stmt = $mysqli->prepare($sql);
			$stmt->execute();
			echo '<script>alert("Results are Published.");</script>';
		}
		If (isset($_POST['btnUnPublish']))
		{
			if(!isset($_SESSION)){
				session_start();
			}
			include 'db/db_connect.php';
			$sql = "update tbloiresults set Publish = 0 where ExamID = " . $_SESSION["SESSSelectedExam"];
			$stmt = $mysqli->prepare($sql);
			$stmt->execute();
			echo '<script>alert("Results are off-line now.");</script>';
		}
		If (isset($_POST['btnDownload']))
		{
					//header("Location: ResultDownload.php?ddlExam=" . $_POST['ddlExam'] . "&ddlYear=" . $_POST['ddlYear'] . "&Dept=" . $DeptID . "&filename=RA.txt"); 
					$filename = $_POST['ddlYear'] . "_" . $_POST['examname_hidden'] . ".csv";
					$handle = fopen($filename, "w");
					include 'db/db_connect.php';
					ini_set('max_execution_time', 2000);
					$sql = "SELECT DISTINCT subjectname 
							FROM tblexamschedule es
							INNER JOIN tblpapermaster pm ON pm.paperid = es.paperid
							INNER JOIN tblsubjectmaster sm ON sm.subjectid = pm.subjectid
							WHERE ExamID = " . $_POST['ddlExam'] . " AND students <> 0 
							ORDER BY examdate,examslot";
					//echo $sql . "<br/> "; 
					//die;
					$j = 0;
					$result = $mysqli->query( $sql );
					$num_results = $result->num_rows;
					$TextLine = "Student Name " . " , CNUM, Roll No  , Dept , Div , Seat No , " ;
					if( $num_results ){
						while( $row = $result->fetch_assoc() ){
							extract($row);
							//echo $ResultSubject . " , " ;
							$TextLine = $TextLine . $subjectname . " , "  ;
							$j = $j + 1;
						}
						$TextLine = $TextLine . " , " . PHP_EOL;
						//echo "</br>";
						fwrite($handle, $TextLine );
						$TextLine = '';
					}
					$sql = "SELECT CONCAT(s.FirstName,' ',s.Surname) AS stdName,CNUM,RollNo,s.Dept,sa.Div,SeatNo
					FROM tblstdadm sa
					INNER JOIN tblstudent s ON s.stdid = sa.stdid
					WHERE EduYearFrom = '2015' AND EduYearTo = '2016' and YEAR =  '" . $_POST['year_hidden'] . "'
					 order by SeatNo";
					//echo $sql; 
					//echo $j;
					$i = $j;
					$TextLine = '';
					$result = $mysqli->query( $sql );
					$num_results = $result->num_rows;
					if( $num_results ){
						while( $row = $result->fetch_assoc() ){
							extract($row);
							//echo $SubType . " , " ;
							$TextLine = $stdName . " , " . $CNUM . " , " . $RollNo . " , "  . $Dept . " , "  . $Div . " , " . $SeatNo;
							while($i > 0){
								$TextLine = $TextLine . " , ";
								$i = $i - 1;
							}
							$i = $j;
							$TextLine = $TextLine . " , " . PHP_EOL;
							fwrite($handle, $TextLine );
							$TextLine = '';
						}
					}

					fclose($handle);
				
					ob_clean();
					header('Content-Type: application/octet-stream');
					header('Content-Disposition: attachment; filename='.basename($filename));
					header('Expires: 0');
					header('Cache-Control: must-revalidate');
					header('Pragma: public');
					header('Content-Length: ' . filesize($filename));
					readfile($filename);
					//header('Location: ProfExamAdminMain.php');
					exit;
		}
		if(isset($_POST['btnUpload'])){
			if(isset($_FILES['fileToUpload'])) {
				$errors     = array();
				$maxsize    = 2097152;
				$acceptable = array('application/vnd.ms-excel','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

				if(($_FILES['fileToUpload']['size'] >= $maxsize) || ($_FILES["fileToUpload"]["size"] == 0)) {
					$errors[] = 'File too large. File must be less than 2 megabytes.';
				}

				if((!in_array($_FILES['fileToUpload']['type'], $acceptable)) && (!empty($_FILES["fileToUpload"]["type"]))) {
					$errors[] = 'Invalid file type. Only PDF is accepted.';
				}

				if(count($errors) === 0) {
					$filename = $_FILES['fileToUpload']['name'];
					//move_uploaded_file( $_FILES['fileToUpload']['tmp_name'], $target);
					move_uploaded_file( $_FILES['fileToUpload']['tmp_name'], 'uploads/'. $filename);
					if( $_FILES['fileToUpload']['name'] != "" )
					{
						include 'db/db_connect.php';
						$sql = "delete from tbloiresults where ExamID = " . $_SESSION["SESSSelectedExam"];
						$stmt = $mysqli->prepare($sql);
						$stmt->execute();

						include 'db/db_connect.php';
						$sql = "INSERT INTO tblresultfile (UploadedFile, ExamID, Created_on, Created_by)
								VALUES	( ?, ?, CURRENT_TIMESTAMP, '" . $_SESSION["SESSusername"] . "')";
						//echo $_SESSION['SESSSelectedExam'];
						//die;
						$stmt = $mysqli->prepare($sql);
						$stmt->bind_param('si', $filename, $_SESSION["SESSSelectedExam"]);
						if($stmt->execute()){
							$iResFileID = $mysqli->insert_id;
							$file = fopen('uploads/' . $filename, "r");
							//$sql_data = "SELECT * FROM prod_list_1 ";
							$heading = true;
							
							while (($emapData = fgetcsv($file, 10000, ",")) !== FALSE)
							{
								// check if the heading row
								if($heading) {
									// unset the heading flag
									$heading = false;
									// skip the loop
									continue;
								}
								//print_r($emapData);
								//exit();
								if(!isset($emapData[6]))
										$emapData[6] = '';
								if(!isset($emapData[7]))
										$emapData[7] = '';
								if(!isset($emapData[8]))
										$emapData[8] = '';
								if(!isset($emapData[9]))
										$emapData[9] = '';
								if(!isset($emapData[10]))
										$emapData[10] = '';
								if(!isset($emapData[11]))
										$emapData[11] = '';
								if(!isset($emapData[12]))
										$emapData[12] = '';
								if(!isset($emapData[13]))
										$emapData[13] = '';
								if(!isset($emapData[14]))
										$emapData[14] = '';
								if(!isset($emapData[15]))
										$emapData[15] = '';

								include 'db/db_connect.php';
								$sql = "INSERT into tbloiresults(ResFileID,ExamID,StdName,CNUM,RollNo,Dept,`Div`,SeatNo,Subject1,Subject2,Subject3,Subject4,Subject5,Subject6,Subject7,Subject8,Subject9,Subject10) 
								values ($iResFileID,". $_SESSION["SESSSelectedExam"] . ",'$emapData[0]','$emapData[1]','$emapData[2]','$emapData[3]','$emapData[4]','$emapData[5]','$emapData[6]','$emapData[7]','$emapData[8]','$emapData[9]','$emapData[10]','$emapData[11]','$emapData[12]','$emapData[13]','$emapData[14]','$emapData[15]')";
								$stmt = $mysqli->prepare($sql);
								//echo $sql;
								if($stmt->execute()){
								}
								else{
									echo '<script>alert("Error! Please contact Admin!");</script>';
									exit;
								}
								//mysql_query($sql);
							}
							fclose($file);
						}
						else
						{
							echo "error updating record: " . $mysqli->error;
						}
					}
					else {
							echo '<script>alert("No file specified!");</script>';
					}
				}
				else
				{
					foreach($errors as $error) {
						echo "<pre>$error</pre>";
					}
				}
			}
			else {
					echo '<script>alert("No file specified!");</script>';
			}
		}
		
	}
	else
		echo '<script>alert("Please select Exam and Year.");</script>';

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

<script>
  $(document).ready(function() {
    $("#ddlExamID").change(function(){
		var skillsSelect = document.getElementById("ddlExamID");
		var selectedText = skillsSelect.options[skillsSelect.selectedIndex].text;
		$("#examname_hidden").val(selectedText);
    });
    $("#ddlYearID").change(function(){
		var YearSelect = document.getElementById("ddlYearID");
		var selectedText = YearSelect.options[YearSelect.selectedIndex].text;
		$("#year_hidden").val(selectedText);
    });
  });
  function hideLoading() {
    document.getElementById('loadingmsg').style.display = 'none';
    document.getElementById('loadingover').style.display = 'none';
	alert('File uploaded / downloaded successfully.');
}
  function showLoading() {
    document.getElementById('loadingmsg').style.display = 'block';
    document.getElementById('loadingover').style.display = 'block';
	setTimeout(hideLoading,28000);
  }
</script>
	<br /><br />	<br />
	<h3 class="page-title">Online / In-sem Result Upload</h3>
	<h3 class="page-title" style="float:right;margin-top:-40px;"><a href="MainMenuMain.php">Back</a></h3>
		<table cellpadding="10" cellspacing="0" border="0" class="tab_split" style="width:60%">
			<tr >
				<td class="form_sec span1" style="width:10%"><b>Select Exam</b></td>
				<td class="form_sec span2" style="width:25%">
					<select id="ddlExamID" name="ddlExam" style="width:100%;margin-top:10px">
						<?php
						include 'db/db_connect.php';
						echo "<option value=''>Select</option>"; 
						$sql = "SELECT ExamID, ExamName, ExamType  FROM tblexammaster;";
						$result1 = $mysqli->query( $sql );
						while( $row = $result1->fetch_assoc() ) {
						extract($row);
						 if((isset($_POST['ddlExam']) && $_POST['ddlExam'] == $ExamID)){
								echo "<option value={$ExamID} selected>{$ExamName} - {$ExamType}</option>"; 
							}
							else{
								echo "<option value={$ExamID}>{$ExamName} - {$ExamType}</option>"; 
							}
						}
						?>
					</select>
					<input type="hidden" name="examname_hidden" id="examname_hidden">
				</td>
				<td class="form_sec span1"><b>Select Year</b></td>
				<td class="form_sec span1">
					<select id="ddlYearID" name="ddlYear" style="margin-top:10px">
						<!-- <option value='FE'>FE</option>"; -->
						<option value=''>Select</option>"; 
						<option value='FE'>F.E.</option>"; 
						<option value='SE'>S.E.</option>"; 
						<option value='TE'>T.E.</option>"; 
						<option value='BE'>B.E.</option>"; 
					</select>
					<input type="hidden" name="year_hidden" id="year_hidden">
				</td>
				<td class="form_sec span1">
					<input type="submit" name="btnDownload" value="Download Result Template" title="Download Result Template" class="btn btn btn-success" />
				</td>								
			</tr>						
		</table>
		<br/>
			<table cellpadding="10" cellspacing="0" border="0" class="tab_split" style="width:60%">
				<tr >
					<td class="form_sec span1"><b>Upload Result File for Selected Exam and Year</b></td>
					<td class="form_sec span2">
						<input type="file" name="fileToUpload" id="fileToUpload"/>
						<input type="submit" name="btnUpload" value="Upload Result" title="Upload" class="btn btn-mini btn-success" />&nbsp;&nbsp;&nbsp;&nbsp;
						<a target="_blank" href="ViewOIResultsAll.php?ExamID=<?php if(!isset($_SESSION)){session_start();}
							if (isset($_SESSION["SESSSelectedExam"])) echo $_SESSION["SESSSelectedExam"]; else echo "0"; ?>">View Uploaded Results</a>
					</td>								
				</tr>						
			</table>
		<br/>
			<table cellpadding="10" cellspacing="0" border="0" class="tab_split" style="width:60%">
				<tr >
					<td class="form_sec span2">
						<input type="submit" name="btnPublish" value="Publish Results" title="Publish Results" class="btn btn-mini btn-success" /> &nbsp;&nbsp;&nbsp;&nbsp;
						<input type="submit" name="btnUnPublish" value="Un-publish Results" title="Un Publish Results" class="btn btn-mini btn-success" />
					</td>								
				</tr>						
			</table>

	<br />
	<br />
</body>	
</form>