<?php
//include database connection
include 'db/db_connect.php';
 if(!isset($_SESSION)){
		session_start();
		}
		if(!isset($_SESSION["qansid"])){
			$_SESSION["qansid"] = $_GET['qansid'] ;
		 }
		//echo $QID;
// if the form was submitted/posted, update the record
 if($_POST)
	{
		
				if (isset($_POST['chkiscorrect'])) {
							$tmpIsCorrect = '1';
						}
						else
							$tmpIsCorrect = '0';
					
						
					if ($_SESSION["qansid"] == "I") {
						$sql = "Insert into tblquestionanswer ( QID,correctans,iscorrect, created_by, created_on, updated_by, updated_on) Values 
						( ?, ?, ?,?, CURRENT_TIMESTAMP, ?, CURRENT_TIMESTAMP)";

						$stmt = $mysqli->prepare($sql);
						$stmt->bind_param('isiss', $_GET["QID"], $_POST['txtAnstext'], $tmpIsCorrect,$_SESSION["SESSusername"],$_SESSION["SESSusername"]);
						if($stmt->execute()) {
								$id = $stmt->insert_id;
								$_SESSION["qansid"] = $id;
								//header("Location: QuestionListMain.php"); 	
								}
							else{
								 echo $mysqli->error;
								 die("Unable to insert.");
							}		
					}
					else {
						$sql = "UPDATE  tblquestionanswer
									Set correctans = ?
										,iscorrect = ?
										,updated_by = ?
										,updated_on = CURRENT_TIMESTAMP
									Where qansid = ? ";
							$stmt = $mysqli->prepare($sql);
							$stmt->bind_param('sisi', $_POST['txtAnstext'],$tmpIsCorrect,$_SESSION["SESSusername"],$_SESSION["qansid"] );
							// execute the update statement
							if($stmt->execute()){
								//header("Location: QuestionMaintMain.php?QID=" . $_GET["QID"] . "&qansid=" . $_SESSION["qansid"] . ""); 
								// close the prepared statement
							}else{
								die("Unable to update.");
							}							
					}

					
		If (isset($_POST['uploadphoto'])){
				if(isset($_FILES['fileToUpload'])) {
				$errors     = array();
				//$maxsize    = 2097152;
				$maxsize    = 240000;
				$acceptable = array('image/gif','image/jpg','image/png','image/jpeg');
				if((strpos($_FILES['fileToUpload']['name'],' ') > 0) || (strpos($_FILES['fileToUpload']['name'],'(') > 0) || 
							(strpos($_FILES['fileToUpload']['name'],')') > 0)) {
					$errors[] = 'File name invalid. Please remove any spaces or brackets.';
				}

				if(($_FILES['fileToUpload']['size'] >= $maxsize) || ($_FILES["fileToUpload"]["size"] == 0)) {
					$errors[] = 'File too large. File must be less than 240KB.';
				}

				if((!in_array($_FILES['fileToUpload']['type'], $acceptable)) && (!empty($_FILES["fileToUpload"]["type"]))) {
					$errors[] = 'Invalid file type. Only an Image is accepted.';
				}
				if(count($errors) === 0) {
					$info = pathinfo($_FILES['fileToUpload']['name']);
					 $ext = $info['extension']; // get the extension of the file
					 $filename = $_FILES['fileToUpload']['name'];
					$newname = $_SESSION["qansid"] . substr($filename, strlen($filename)-4); 
					 $target = 'ansimages/'.$newname;
					 move_uploaded_file( $_FILES['fileToUpload']['tmp_name'], $target);
					 include 'db/db_connect.php';
					$sql2 = "UPDATE  tblquestionanswer	Set  photopath = ?	Where qansid = ?";
					if ($stmt2 = $mysqli->prepare($sql2)) {
						$stmt2->bind_param('si', $newname,$_SESSION["qansid"]);
					}
					else {
						printf("Errormessage: %s\n", $mysqli->error);
					}
					// execute the update statement
					if($stmt2->execute()) {
						//header('Location: stdviewmain.php');
						 //close the prepared statement
						}
					else{
						 echo $mysqli->error;
						 die("Unable to update.");
					}
				}
				else {
						foreach($errors as $error) {
							echo "<br/><pre>$error</pre>";
						}
				}
			}
		}
	
			
	}
		if ($_SESSION["qansid"] == "I") {
			$sql = "SELECT 'I' as qansid, '' as correctans, '0' as  iscorrect " ;
		}
		Else
		{
			$sql = " SELECT qansid, correctans, iscorrect
					 FROM tblquestionanswer Where qansid = " . $_SESSION["qansid"]   ;
		} 
		echo $sql;
		// execute the sql query
		$result = $mysqli->query( $sql );
		$row = $result->fetch_assoc();
		extract($row);
		 
		//disconnect from database
		$result->free();
		$mysqli->close();

?>

<form action="AnswerListMaintMain.php?QID=<?php echo $_SESSION["QID"]; ?>&qansid=<?php echo $_SESSION["qansid"]; ?>&iscorrect=<?php echo $_GET['iscorrect']; ?>" method="post" enctype="multipart/form-data">
<head>
<script src="http://www.wiris.net/demo/editor/editor"></script>
<script>
	var editor;
    window.onload = function () {
      editor = com.wiris.jsEditor.JsEditor.newInstance({'language': 'en'});
            editor.insertInto(document.getElementById('editorContainer'));
			if(document.getElementById("txtAnstext").value != '')
				editor.setMathML(document.getElementById("txtAnstext").value);
			else
				editor.setMathML('<math xmlns="http://www.w3.org/1998/Math/MathML"><mi> </mi></math>');
	}
	
	function fnsave(){
		if(editor.getMathML() == '<math xmlns="http://www.w3.org/1998/Math/MathML"><mi> </mi></math>'){
			alert('Answer text required.');
			return false;
		}
		else{		
			document.getElementById("txtAnstext").value = editor.getMathML();
			document.myform.submit();
		  }
	}
    </script>
</head>

	<br /><br />
	<h3 class="page-title" style="margin-left:5%">Answer Maintenance</h3>
	<div class="row-fluid">
		<div class="v_detail" style="margin-left:5%;height:100%">
			<table cellpadding="10" cellspacing="0" border="0" width="70%" class="tab_split">
				<tr>
					<td class="form_sec span3">&nbsp;</td>
					<td>
						<div class="span10">
							<?php 
							if(($_SESSION["ReadAccess"] == "Yes") && ($_SESSION["WriteAccess"] == "Yes")){
								echo "<input type='submit' name='btnUpdate' onclick='javascript:return fnsave();' value='Save' title='Update' class='btn btn-mini btn-success' />";
							}
							?>
							<a href='QuestionMaintMain.php?QID=<?php echo $_SESSION["QID"]; ?>'  class="btn btn-mini btn-warning">Cancel</a>
						</div>
					</td>								
				</tr>
				<tr>
					<td class="form_sec span3">Is Correct?</td>
					<td>
							<input type="checkbox" name="chkiscorrect" class="checked" <?php echo ($_GET["iscorrect"] == '1' ? 'checked' : ''); ?>/>
					</td>
				</tr>			
				<tr>
					<td class="form_sec span3" style="vertical-align: text-top;">Answer Description</td>
						<td colspan="8"> 
							<div id="editorContainer"></div>
							<input  name="txtAnstext" id="txtAnstext" type="hidden" value='<?php echo $correctans; ?>' />
						</td>
					</td>
				</tr>	
				<tr>
					<td class="form_sec span3">Upload Image</td>
					<td colspan="8">
						<input name="fileToUpload" type="file" id="fileToUpload">
						<input  name="uploadphoto" id="uploadphoto" onclick="javascript:return fnsave();" type="submit" value="Upload Image" class="btn btn-mini btn-success" />
						<br/>
						<?php
							if(!isset($_SESSION)){
								session_start();
							}
							$dir = 'ansimages';
							include 'db/db_connect.php';
							$query = "SELECT photopath FROM tblquestionanswer where qansid = '" . $_SESSION["qansid"] . "'";						
							//echo $query;
							$result = $mysqli->query( $query );
							$num_results = $result->num_rows;
							if( $num_results ) {
								while( $row = $result->fetch_assoc() ) {
									extract($row);
								  echo "<img src=ansimages/". $photopath . " alt=''  />";
								}
							}		
						?>		
					</td>
				</tr>				
			</table>
		</div>
	</div>
</form>

