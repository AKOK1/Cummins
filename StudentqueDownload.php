<form action="StudentqueDownloadMain.php" method="post" onsubmit='showLoading();' enctype="multipart/form-data">
<body>
<script>
</script>
<?php
//include database connection
include 'db/db_connect.php';
// if the form was submitted/posted, update the record
	
		if(!isset($_SESSION)){
			session_start();
		}
		
		if(!isset($_POST['btnUpload']) && !isset($_POST['btnDownload'])){
			if(isset($_GET['cbpid'])){
				$_SESSION["cbpid"] = $_GET['cbpid'];
				$_SESSION["ExamBlockID"] = $_GET['ExamBlockID'];
				$_SESSION["qblockname"] = $_GET['blockname'];
			}
		}
		If (isset($_POST['btnDownload']))
		{
			//$filename =   $_SESSION["SESSCAPSelectedExamName"] . "_" .  ".csv";
			
			$filename = str_replace(" ","",$_SESSION["qblockname"]) .  ".csv";
			$handle = fopen($filename, "w");
			include 'db/db_connect.php';
			ini_set('max_execution_time', 2000);
			$j = 0;
			$TextLine = "ESN,A/P,Q1,Q2,Q3,Q4,Q5,Q6,Q7,Q8,Q9,Q10,Q11,Q12,Q13,Q14,Q15,Q16,Q17,Q18,Q19,Q20,"  ;
				$TextLine = $TextLine . " , " . PHP_EOL;
				fwrite($handle, $TextLine );
				$TextLine = '';
				$sql = "SELECT ebs.StdId,ebs.ExamBlockID FROM `tblexamblockstudent` ebs
				INNER JOIN `tblexamblock` eb ON eb.`ExamBlockID` = ebs.`ExamBlockID`
				INNER JOIN `tblcapblockprof` cbp ON cbp.`ExamBlockID` = eb.ExamBlockID
				WHERE cbp.profid=" . $_SESSION["SESSUserID"] ." and cbp.ExamID = ". $_SESSION['SESSCAPSelectedExam'] . 
				 " and eb.ExamBlockID =  " . $_SESSION["ExamBlockID"]  . " ";
			$i = $j;
			$TextLine = '';
			$result = $mysqli->query( $sql );
			$num_results = $result->num_rows;
			if( $num_results ){
				while( $row = $result->fetch_assoc() ){
					extract($row);
					$TextLine = $StdId. ",,,,,,,,,,,,,,,,,,,,,,";
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
					move_uploaded_file($_FILES['fileToUpload']['tmp_name'], 'uploads/'. $filename);
					if( $_FILES['fileToUpload']['name'] != "" )
					{
						$iResFileID = $mysqli->insert_id;
						$file = fopen('uploads/' . $filename, "r");
						$heading = true;
						
							include 'db/db_connect.php';
						$sql = "delete from tblinsemmarks where CapId = " . $_SESSION["cbpid"] ;
						$stmt = $mysqli->prepare($sql);
						$stmt->execute();

						while (($line_of_text = fgetcsv($file, 10000, ",")) !== FALSE)
						{
							// check if the heading row
							if($heading) {
								// unset the heading flag
								$heading = false;
								// skip the loop
								continue;
							}
							include 'db/db_connect.php';
							if($line_of_text[0] == ''){
								break;
							}
							if($line_of_text[1] == 'A'){
								$line_of_text[2] = '0';
								$line_of_text[3] = '0';
								$line_of_text[4] = '0';
								$line_of_text[5] = '0';
								$line_of_text[6] = '0';
								$line_of_text[7] = '0';
								$line_of_text[8] = '0';
								$line_of_text[9] = '0';
								$line_of_text[10] = '0';
								$line_of_text[11] = '0';
								$line_of_text[12] = '0';
								$line_of_text[13] = '0';
								$line_of_text[14] = '0';
								$line_of_text[15] = '0';
								$line_of_text[16] = '0';
								$line_of_text[17] = '0';
								$line_of_text[18] = '0';
								$line_of_text[19] = '0';
								$line_of_text[20] = '0';
								$line_of_text[21] = '0';
							}
							else{
								if($line_of_text[0] == '')
									$line_of_text[0] = '0';
								if($line_of_text[2] == '')
									$line_of_text[2] = '0';
								if($line_of_text[3] == '')
									$line_of_text[3] = '0';
								if($line_of_text[4] == '')
									$line_of_text[4] = '0';
								if($line_of_text[5] == '')
									$line_of_text[5] = '0';
								if($line_of_text[6] == '')
									$line_of_text[6] = '0';
								if($line_of_text[7] == '')
									$line_of_text[7] = '0';
								if($line_of_text[8] == '')
									$line_of_text[8] = '0';
								if($line_of_text[9] == '')
									$line_of_text[9] = '0';
								if($line_of_text[10] == '')
									$line_of_text[10] = '0';
								if($line_of_text[11] == '')
									$line_of_text[11] = '0';
								if($line_of_text[12] == '')
									$line_of_text[12] = '0';
								if($line_of_text[13] == '')
									$line_of_text[13] = '0';
								if($line_of_text[14] == '')
									$line_of_text[14] = '0';
								if($line_of_text[15] == '')
									$line_of_text[15] = '0';
								if($line_of_text[16] == '')
									$line_of_text[16] = '0';
								if($line_of_text[17] == '')
									$line_of_text[17] = '0';
								if($line_of_text[18] == '')
									$line_of_text[18] = '0';
								if($line_of_text[19] == '')
									$line_of_text[19] = '0';
								if($line_of_text[20] == '')
									$line_of_text[20] = '0';
								if($line_of_text[21] == '')
									$line_of_text[21] = '0';
						}
							

							include 'db/db_connect.php';
							$sql = "INSERT into tblinsemmarks (StdId ,CapId ,Q1 ,Q2 ,Q3 ,Q4 ,Q5 ,Q6 ,Q7 ,Q8 ,Q9 ,Q10 
							,Q11 ,Q12 ,Q13 ,Q14 ,Q15 ,Q16 ,Q17,Q18,Q19,Q20,stdstatus) 
							values ('" . $line_of_text[0] . "'," . $_SESSION["cbpid"] 
								. ", " . $line_of_text[2] . ", " . $line_of_text[3] . ", " . $line_of_text[4] 
								. ", " . $line_of_text[5] . ", " . $line_of_text[6] . ", " . $line_of_text[7] . ", " . $line_of_text[8] 
								. ", " . $line_of_text[9] . ", " . $line_of_text[10] . ", " . $line_of_text[11] . ", " . $line_of_text[12] 
								. ", " . $line_of_text[13] . ", " . $line_of_text[14] . ", " . $line_of_text[15] . ", " . $line_of_text[16] 
								. ", " . $line_of_text[17] . ", " . $line_of_text[18] . ", " . $line_of_text[19] . ", " . $line_of_text[20] . ", " . $line_of_text[21] . ", '" . $line_of_text[1] .  "')";
							$stmt = $mysqli->prepare($sql);
							//echo $sql;
							//die;
							if($stmt->execute()){
							}
							else{
								echo '<script>alert("Error! Please contact Admin!");</script>';
								exit;
							}
							//mysql_query($sql);
						}
						fclose($file);
						echo '<script>alert("File uploaded successfully!");</script>';
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
}
  function showLoading() {
  }
</script>
	<br /><br />	<br />
	<h3 class="page-title">Marks Upload - <?php echo $_SESSION["SESSCAPSelectedExamName"]; ?> <br/> <?php echo $_SESSION["qblockname"]; ?></h3>
	<h3 class="page-title" style="float:right;margin-top:-40px;"><a href="assignedblockListMain.php">Back</a></h3>
		<table cellpadding="10" cellspacing="0" border="0" class="tab_split" style="width:20%">
			<tr >
				<td class="form_sec span1">
					<input type="submit" name="btnDownload" value="Download Marks Template" title="Download Marks Template" class="btn btn btn-success" />
				</td>								
			</tr>						
		</table>
		<br/>
			<table cellpadding="10" cellspacing="0" border="0" class="tab_split" style="width:60%">
				<tr >
					<td class="form_sec span1"><b>Upload Result File for Selected Exam and Block</b></td>
					<td class="form_sec span2">
						<input type="file" name="fileToUpload" id="fileToUpload"/>
						
						<?php
							include 'db/db_connect.php';
							if($_SESSION["usertype"] == "SuperAdmin")
								$sql = "SELECT ExamID, ExamName, ExamType  FROM tblexammaster;";
							else
								$sql = "SELECT ExamID, ExamName, ExamType  FROM tblexammaster 
										WHERE CURRENT_TIMESTAMP BETWEEN CAPstart AND CAPend and ExamID = ". $_SESSION["SESSCAPSelectedExam"] ."";
							$result1 = $mysqli->query( $sql );
							while( $row = $result1->fetch_assoc() ) {
								echo "<input type='submit' name='btnUpload' value='Upload Result' title='Upload' class='btn btn-mini btn-success' />";
							}
						?>
						
						&nbsp;&nbsp;&nbsp;&nbsp;
						<a target="_blank" href="ViewStudMarks.php?cbpid=<?php if(!isset($_SESSION)){session_start();}
							if (isset($_SESSION["cbpid"])) echo $_SESSION["cbpid"]; else echo "0"; ?>">View Uploaded Results</a>
					</td>								
				</tr>						
			</table>
		<br/>
	<br />
	<br />
</body>	
</form>