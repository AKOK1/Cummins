<?php
//include database connection
include 'db/db_connect.php';
 if(!isset($_SESSION)){
		session_start();
		}
		 if(!isset($_SESSION["QID"])){
			$_SESSION["QID"] = $_GET['QID'] ;
		 }
		 unset($_SESSION["qansid"]);
		 //$_SESSION["PaperId"] = $_GET['paperid'];
// if the form was submitted/posted, update the record
 if($_POST)
	{
		if ($_SESSION["QID"] == "I") {
						$sql = "Insert into tblquestionmaster ( QText,answertype,difflevel,
						Papertype,keyword,unit,
						created_by, created_on, updated_by, Updated_on,comment) 
						Values ( ?,?,?,?,?,?,?, CURRENT_TIMESTAMP, ?, CURRENT_TIMESTAMP,?)";
						$stmt = $mysqli->prepare($sql);
						$stmt->bind_param('sssssssss', $_POST['txtQtext'],$_POST['ddltype'],$_POST['ddldifflevel'],
						$_POST['ddlPaperType'],$_POST['txtkeyword'],$_POST['ddlunit'],
						$_SESSION["SESSusername"],$_SESSION["SESSusername"],$_POST['txtcommentheader']);						
						if($stmt->execute()) {
							$id = $stmt->insert_id;
							$_SESSION["QID"] = $id;
							//header("Location: QuestionListMain.php"); 	
							}
						else{
							 echo $mysqli->error;
							 die("Unable to insert.");
						}	
					}
					else {
						$sql = "UPDATE  tblquestionmaster
									Set  QText = ?
										,answertype = ?
										,difflevel = ?
										,Papertype = ?							
										,keyword = ?
										,unit = ?
										,updated_by = ?
										,updated_on = CURRENT_TIMESTAMP
										,comment = ?
									Where QID = ?";
							//echo $sql;
							$stmt = $mysqli->prepare($sql);
							$stmt->bind_param('ssssssssi', $_POST['txtQtext'],$_POST['ddltype'],$_POST['ddldifflevel'],
							$_POST['ddlPaperType'],$_POST['txtkeyword'],$_POST['ddlunit'],
							$_SESSION["SESSusername"],$_POST['txtcommentheader'],$_SESSION["QID"]);
							if($stmt->execute()) {
								//header("Location: QuestionListMain.php"); 	
								}
							else{
								 echo $mysqli->error;
								 die("Unable to update.");
							}	
						}
				$pos = $_POST['chkmappo'];
				if(count($pos) > 0) {
					foreach (array('txtmappo','chkmappo','ddllevelpo', 'txtpojustpo' ) as $pos) {
								foreach ($_POST[$pos] as $id => $row) {
										$_POST[$pos][$id] = mysqli_real_escape_string($mysqli, $row);
								} 
						}
						$mappos = $_POST['txtmappo'];
						$CheckPOs = $_POST['chkmappo'];
						$ddlLevelspo =  $_POST['ddllevelpo'];
						$Justspo = $_POST['txtpojustpo'];
						$size = count($mappos);
						//echo count($CheckPOs);
						// delete existing POs for QID!
						$sqlDel = "Delete from tblquemappo where QID = ? ";
						$stmt = $mysqli->prepare($sqlDel);
						$stmt->bind_param('i', $_SESSION["QID"]);
						if($stmt->execute()){
							//header('Location: SubjectList.php?'); 
						} else{
							echo $mysqli->error;
							//die("Unable to update.");
						}

							$k = 0;
							for($i = 0 ; $i < $size ; $i++){	
							//echo $CheckPOs[$i] . " " . $k . "</br>";
							//$ischecked = 0;
							//if(isset($CheckPOs[$i]))
							//	$ischecked =  1;
							if($CheckPOs[$k] == $i){
								$sql = "Insert into tblquemappo ( QID, mappo, mappochecked, polevel, pojust) 
									Values ( ?, ?, 1, ?, ?)";
								$stmt = $mysqli->prepare($sql);
								//echo $Justspo[$i] . "</br>";
								$stmt->bind_param('isis', $_SESSION["QID"],str_replace("'","''",$mappos[$i]), $ddlLevelspo[$i],$Justspo[$i]);

								if($stmt->execute()){
								//header('Location: SubjectList.php?'); 
								} else{
								echo $mysqli->error;
								//die("Unable to update.");
								}				
								$k = $k + 1;
							}
						}
				}
				$cos = $_POST['chkmapco'];
				if(count($cos) > 0) {
					foreach (array('txtmapco','chkmapco','ddllevelco', 'txtcojustco' ) as $pos) {
												foreach ($_POST[$pos] as $id => $row) {
														$_POST[$pos][$id] = mysqli_real_escape_string($mysqli, $row);
												} 
										}
										$mapcos = $_POST['txtmapco'];
										$CheckCOs = $_POST['chkmapco'];
										$ddlLevelsco =  $_POST['ddllevelco'];
										$Justsco = $_POST['txtcojustco'];
										$size = count($mapcos);
										//echo $size;
										// delete existing COs for QID!
										$sqlDel = "Delete from tblquemapco where QID = ? ";
										$stmt = $mysqli->prepare($sqlDel);
										$stmt->bind_param('i', $_SESSION["QID"]);
										if($stmt->execute()){
											//header('Location: SubjectList.php?'); 
										} else{
											echo $mysqli->error;
											//die("Unable to update.");
										}
										//str_replace("'","''",$_POST['txtmapco'])
										$k = 0;
										for($i = 0 ; $i < $size ; $i++){	
											if($CheckCOs[$k] == $i){
												//echo $_SESSION["QID"] . "-" . $mapcos[$i] . "-" . $ddlLevelsco[$i] . "-" . $Justsco[$i] . "</br>";
												$sql = "Insert into tblquemapco ( QID, mapco, mapcochecked, colevel, cojust) 
													Values ( ?, ?, 1, ?, ?)";
												$stmt = $mysqli->prepare($sql);
												$stmt->bind_param('isis', $_SESSION["QID"],$mapcos[$i], $ddlLevelsco[$i],$Justsco[$i]);
												if($stmt->execute()){
												//header('Location: SubjectList.php?'); 
												} else{
												echo $mysqli->error;
												//die("Unable to update.");
												}				
												$k = $k + 1;
											}
										}
				}
				$btos = $_POST['chkmapbt'];
				if(count($btos) > 0) {
					foreach (array('txtmapbt','chkmapbt') as $pos) {
								foreach ($_POST[$pos] as $id => $row) {
										$_POST[$pos][$id] = mysqli_real_escape_string($mysqli, $row);
								} 
						}
						$mappos = $_POST['txtmapbt'];
						$CheckPOs = $_POST['chkmapbt'];
						$size = count($mappos);
						//echo count($CheckPOs);
						// delete existing POs for QID!
						$sqlDel = "Delete from tblquemapbt where QID = ? ";
						$stmt = $mysqli->prepare($sqlDel);
						$stmt->bind_param('i', $_SESSION["QID"]);
						if($stmt->execute()){
							//header('Location: SubjectList.php?'); 
						} else{
							echo $mysqli->error;
							//die("Unable to update.");
						}

							$k = 0;
							for($i = 0 ; $i < $size ; $i++){	
							if($CheckPOs[$k] == $i){
								$sql = "Insert into tblquemapbt ( QID, btdesc, mapbtchecked) 
									Values ( ?, ?, 1)";
								$stmt = $mysqli->prepare($sql);
								$stmt->bind_param('is', $_SESSION["QID"],str_replace("'","''",$mappos[$i]));

								if($stmt->execute()){
								//header('Location: SubjectList.php?'); 
								} else{
								echo $mysqli->error;
								//die("Unable to update.");
								}				
								$k = $k + 1;
							}
						}
				}
		
		
		
		
		if (isset($_POST['uploadphoto'])){
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
					$newname = $_SESSION["QID"] . substr($filename, strlen($filename)-4); 
					 $target = 'qimages/'.$newname;
					 move_uploaded_file( $_FILES['fileToUpload']['tmp_name'], $target);
					 include 'db/db_connect.php';
					$sql = "UPDATE  tblquestionmaster	Set  photopath = ?	Where QID = ?";
					$stmt = $mysqli->prepare($sql);
					$stmt->bind_param('ss', $newname,$_SESSION["QID"]);
					// execute the update statement
					if($stmt->execute()) {
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
		elseIf (isset($_POST['uploadphoto2'])){
			// echo '<script>alert("error");</script>';
				if(isset($_FILES['fileToUpload2'])) {
				$errors     = array();
				//$maxsize    = 2097152;
				$maxsize    = 240000;
				$acceptable = array('image/gif','image/jpg','image/png','image/jpeg');
				if((strpos($_FILES['fileToUpload2']['name'],' ') > 0) || (strpos($_FILES['fileToUpload2']['name'],'(') > 0) || 
							(strpos($_FILES['fileToUpload2']['name'],')') > 0)) {
					$errors[] = 'File name invalid. Please remove any spaces or brackets.';
				}

				if(($_FILES['fileToUpload2']['size'] >= $maxsize) || ($_FILES["fileToUpload2"]["size"] == 0)) {
					$errors[] = 'File too large. File must be less than 240KB.';
				}

				if((!in_array($_FILES['fileToUpload2']['type'], $acceptable)) && (!empty($_FILES["fileToUpload2"]["type"]))) {
					$errors[] = 'Invalid file type. Only an Image is accepted.';
				}
				if(count($errors) === 0) {
					$info = pathinfo($_FILES['fileToUpload2']['name']);
					 $ext = $info['extension']; // get the extension of the file
					 $filename = $_FILES['fileToUpload2']['name'];
					$newname = $_SESSION["QID"] . "-1" . substr($filename, strlen($filename)-4); 
					 $target = 'ansimages/'.$newname;
					 echo $target ;
					 move_uploaded_file( $_FILES['fileToUpload2']['tmp_name'], $target);
					 include 'db/db_connect.php';
					$sql = "UPDATE  tblquestionmaster	Set  photopath2 = ?	Where QID = ?";
					echo $sql;
					$stmt = $mysqli->prepare($sql);
					$stmt->bind_param('ss', $newname,$_SESSION["QID"]);
					//echo $stmt;
					
					// execute the update statement
					if($stmt->execute()) {
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
				
				
		if(isset($_POST["btnNew"])){
			header("Location: AnswerListMaintMain.php?QID=" . $_SESSION["QID"] . "&qansid=I");  
		}			
		
	}
		if ($_SESSION["QID"] == "I") {
			$sql = "SELECT 'I' as QID, '' as QText, '0' as  Crequired , '' as comment, 'Select ' as answertype,
					'Select ' as difflevel, 'select ' as Category, 'select ' as Papertype,
					'select ' as mappo, '' as keyword, 'select ' as unit" ;
		}
		Else
		{  
			$sql = " SELECT QID, QText,Crequired, comment, answertype, 
			difflevel, Category, Papertype,mappo, keyword, unit FROM tblquestionmaster Where QID = " . $_SESSION["QID"] ;
		} 
		//echo $sql;
		// execute the sql query
		$result = $mysqli->query( $sql );
		$row = $result->fetch_assoc();
		extract($row);
		 
		//disconnect from database
		$result->free();
		$mysqli->close();
		
		//header('Location: QuestionMaintMain.php?QID=' . $_SESSION["QID"]);

?>

<form name="myform" id="myform" action="QuestionMaintMain.php?QID=<?php echo $_SESSION["QID"]; ?>" method="post" enctype="multipart/form-data">
<head>
    <script src="http://www.wiris.net/demo/editor/editor"></script>
    <script>
	function getParameterByName(name, url) {
    if (!url) url = window.location.href;
    name = name.replace(/[\[\]]/g, "\\$&");
    var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
        results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, " "));
}

    var editor;
	var editor2;
    window.onload = function () {
      editor = com.wiris.jsEditor.JsEditor.newInstance({'language': 'en'});
            editor.insertInto(document.getElementById('editorContainer'));
			//alert("a" + document.getElementById("txtQtext").value + "a");
			if(document.getElementById("txtQtext").value != '')
				editor.setMathML(document.getElementById("txtQtext").value);
			else
				editor.setMathML('<math xmlns="http://www.w3.org/1998/Math/MathML"><mi> </mi></math>');

			editor2 = com.wiris.jsEditor.JsEditor.newInstance({'language': 'en'});
            editor2.insertInto(document.getElementById('editorContainer2'));
			if(document.getElementById("txtcommentheader").value != '')
				editor2.setMathML(document.getElementById("txtcommentheader").value);
			else
				editor2.setMathML('<math xmlns="http://www.w3.org/1998/Math/MathML"><mi> </mi></math>');


			//hide answers if new Q!
		// var myqid = getParameterByName('QID'); 
		// if(myqid != 'I'){
			// document.getElementById("divAns").style.display = 'block';
			// document.getElementById("divNewQ").style.display = 'none';
		// }
	}
    </script>
	<script>
	function fnsave(){
		if(editor.getMathML() == '<math xmlns="http://www.w3.org/1998/Math/MathML"><mi> </mi></math>'){
			alert('Question text required.');
			return false;
		}
		else{		
			var form = document.getElementById('myform');
			for(var i=0; i < form.elements.length; i++){
			  if(form.elements[i].value === '' && form.elements[i].hasAttribute('required')){
				alert('There are some required fields!');
				return false;
			  }
			}
			document.getElementById("txtQtext").value = editor.getMathML();
			document.getElementById("txtcommentheader").value = editor2.getMathML();			
			document.myform.submit();
		  }
	}
	</script>
	
  </head>

<br /><br />
	<h3 class="page-title" style="margin-left:5%">Question Maintenance</h3>
	<br/><br/>
	<div class="row-fluid" style="margin-top:-35px">
		<div class="v_detail" style="margin-left:5%;height:100%	">
			<table cellpadding="10" cellspacing="0" border="0" width="70%" class="tab_split">
				<tr>
					<td class="form_sec span4">&nbsp;</td>
						<td>
							<div class="span10">
					<?php 
					
							if(($_SESSION["ReadAccess"] == "Yes") && ($_SESSION["WriteAccess"] == "Yes")){
								echo "<input type='submit' name='btnUpdate' value='Save' title='Save' onclick='javascript:return fnsave();' class='btn btn-mini btn-success' />";
							}
							?>

							<a href="QuestionListMain.php" class="btn btn-mini btn-warning">Cancel</a>	
							</div>
						</td>								
				</tr>			
				<tr>
				<td class="form_sec span4">Unit*</td>
					<td colspan="2">
						<select name="ddlunit" id="ddlunit" required >
						<option value="">Select Option</option>
							<option value="1" <?php if($unit == "1") echo "selected"; ?>>I</option>
							<option value="2" <?php if($unit == "2") echo "selected"; ?>>II</option>
							<option value="3" <?php if($unit == "3") echo "selected"; ?>>III</option>
							<option value="4" <?php if($unit == "4") echo "selected"; ?>>IV</option>
							<option value="5" <?php if($unit == "5") echo "selected"; ?>>V</option>
							<option value="6" <?php if($unit == "6") echo "selected"; ?>>VI</option>
						</select>
						
					</td>
				</tr>
				<tr>
					<td class="form_sec span4">Type</td>
					<td>
						<select name="ddlPaperType" id="ddlPaperType" required style="width:120px;">
							<option value="Theory" <?php if($Papertype == "Theory") echo "selected"; ?>>Theory</option>
							<option value="Online" <?php if($Papertype == "Online") echo "selected"; ?>>Online</option>
						</select>
					</td>
				</tr>	
				<tr>
					<td class="form_sec span4">Keyword</td>
					<td colspan="8">
						<input  name="txtkeyword" id="txtkeyword" type="text" style= "width:650px" value="<?php echo $keyword; ?>" />
					</td>
				</tr>	
				<tr>
					<td class="form_sec span4" style="vertical-align: text-top;">Question Text</td>
						<td colspan="8">  
						<div id="editorContainer"></div>
						<input  name="txtQtext" id="txtQtext" type="hidden" value='<?php echo $QText; ?>' />
						</td>
				</tr>	
								<tr>
					<td class="form_sec span4">Upload Image</td>
					<td colspan="8">
						<input name="fileToUpload" type="file" id="fileToUpload">
						<input  name="uploadphoto" id="uploadphoto" onclick="javascript:return fnsave();" type="submit" value="Upload Image" class="btn btn-mini btn-success" />
						<br/>
						<?php
							if(!isset($_SESSION)){
								session_start();
							}
							$dir = 'qimages';
							include 'db/db_connect.php';
							$query = "SELECT photopath FROM tblquestionmaster where QID = '" . $_SESSION["QID"] . "'";						
							//echo $query;
							$result = $mysqli->query( $query );
							$num_results = $result->num_rows;
							if( $num_results ) {
								while( $row = $result->fetch_assoc() ) {
									extract($row);
								  echo "<img src=qimages/". $photopath . " alt=''  />";
								}
							}		
						?>		
					</td>
				</tr>
				<tr>
					<td class="form_sec span4" style="vertical-align: text-top;">Bloom's Taxonomy</td>
					<td>
					<table cellpadding="10" cellspacing="0" border="0" width="100%" class="tab_split" >
					<tr>
						<th><strong>Sr. No.</strong></th>
						<th><strong>Description</strong></th>
						<th><strong>Select</strong></th>
					</tr>
					<?php
					// Create connection
					include 'db/db_connect.php';
					if($_SESSION["QID"] == 'I'){
						$query = "SELECT QID,COALESCE(qmb.btdesc,qbm.btdesc) AS mapbt,COALESCE(mapbtchecked,0) AS mappochecked
									,COALESCE(quemapbtid,0) AS quemapbtid
									FROM tblquebtmaster qbm 
									LEFT OUTER JOIN tblquemapbt qmb ON qbm.btdesc = qmb.btdesc
									AND QID IS NULL
									ORDER BY quebtmasterid";
					}
					else{
						$query = "SELECT QID,COALESCE(qmb.btdesc,qbm.btdesc) AS mapbt,COALESCE(mapbtchecked,0) AS mappochecked
									,COALESCE(quemapbtid,0) AS quemapbtid
									FROM tblquebtmaster qbm 
									LEFT OUTER JOIN tblquemapbt qmb ON qbm.btdesc = qmb.btdesc
									AND QID = " . $_SESSION["QID"] . "
									ORDER BY quebtmasterid";
					}
					//echo $query;
					$result = $mysqli->query( $query );
					$num_results = $result->num_rows;
					$i = 1;
					if( $num_results ){
						$k = 0;							  
						while( $row = $result->fetch_assoc() ){
							extract($row);
						  echo "<TR class='odd gradeX'>";
										echo "<td>$i</td>";
										echo "<td>{$mapbt}<input type='hidden' name='txtmapbt[]' value='{$mapbt}' /> </td>";
										echo "<td><input type='checkbox' name='chkmapbt[]' value='{$k}'";
										if ($mappochecked == '1')
											echo ' checked'; 
										else
											echo '';
									echo "/></td>";
						 echo "</TR>";
						 $k = $k + 1;
						  $i = $i + 1;
						}
					}
					else{
						echo "<TR class='odd gradeX'>";
						echo "<td></td>";
						echo "<td>No records found.</td>";
						echo "</TR>";
					}
					echo "</table>";
					?> 
			</td>
			</tr>	
				<tr>
				<td class="form_sec span4">Difficulty level</td>
					<td colspan="2">
						<select name="ddldifflevel" id="ddldifflevel">
						<option value="">Select Option</option>
							<option value="Simple" <?php if($difflevel == "Simple") echo "selected"; ?>>Simple</option>
							<option value="Medium" <?php if($difflevel == "Medium") echo "selected"; ?>>Medium</option>
							<option value="Complex" <?php if($difflevel == "Complex") echo "selected"; ?>>Complex</option>
						</select>
						
					</td>
				</tr>
				<tr>
					<td class="form_sec span4" style="vertical-align: text-top;">Map CO</td>
					<td>
					<table cellpadding="10" cellspacing="0" border="0" width="100%" class="tab_split" >
					<tr>
						<th><strong>Sr. No.</strong></th>
						<th><strong>Description</strong></th>
						<th><strong>Select</strong></th>
						<th><strong>Level</strong></th>
						<th><strong>Justification</strong></th>
					</tr>
					<?php
					// Create connection
					include 'db/db_connect.php';
					if($_SESSION["QID"] == 'I'){
						$query = "SELECT QID,COALESCE(mapco,coursedesc) AS mapco,COALESCE(mapcochecked,0) AS mapcochecked,COALESCE(colevel,0) AS colevel,
									COALESCE(cojust ,'') AS cojust  ,COALESCE(quemapcoid,0) AS quemapcoid
									FROM tblsyllaoutcome sco 
									LEFT OUTER JOIN tblquemapco mco ON sco.coursedesc = mco.mapco and QID is null
									where paperid = " . $_SESSION["qbpaperid"] . "
									ORDER BY mapco";
						
					}
					else{
						$query = "SELECT QID,COALESCE(mapco,coursedesc) AS mapco,COALESCE(mapcochecked,0) AS mapcochecked,COALESCE(colevel,0) AS colevel,
									COALESCE(cojust ,'') AS cojust  ,COALESCE(quemapcoid,0) AS quemapcoid
									FROM tblsyllaoutcome sco
									LEFT OUTER JOIN tblquemapco mco ON sco.coursedesc = mco.mapco 
									and QID = " . $_SESSION["QID"] . "
									where paperid = " . $_SESSION["qbpaperid"] . "
									ORDER BY mapco";
						
					}
					//echo $query;
					$result = $mysqli->query( $query );
					$num_results = $result->num_rows;
					if( $num_results ){
						$k = 0;		
						$i = 1;
						while( $row = $result->fetch_assoc() ){
							extract($row);
						  echo "<TR class='odd gradeX'>";
										echo "<td>$i</td>";
										echo "<td>{$mapco}<input type='hidden' name='txtmapco[]' value='{$mapco}' /> </td>";
										echo "<td><input type='checkbox' name='chkmapco[]' value='{$k}'";
										if ($mapcochecked == '1')
											echo ' checked'; 
										else
											echo '';
									echo "/></td>";
										echo "<td>";
												echo "<select style='width:100px' name='ddllevelco[]' class='span100'>";
													echo "<option value='0' ";  if($colevel == '0') echo "selected"; 
													echo ">0</option>";
													echo "<option value='1' ";  if($colevel == '1') echo "selected"; 
													echo ">1</option>";
													echo "<option value='2' "; if($colevel == '2') echo "selected"; 
													echo ">2</option>";
													echo "<option value='3' "; if($colevel == '3') echo "selected"; 
													echo ">3</option>";
													echo "</select>";
												echo "</td>";
										echo "<td><input type = 'text' name = 'txtcojustco[]' value='{$cojust}' /></td>";

						 echo "</TR>";
						 $k = $k + 1;
						 $i = $i + 1;
						}
					}
					else{
						echo "<TR class='odd gradeX'>";
						echo "<td></td>";
						echo "<td>No records found.</td>";
						echo "<td></td>";
						echo "<td></td>";
						echo "</TR>";
					}
					echo "</table>";
					?> 
			</td>
			</tr>
			<tr>
					<td class="form_sec span4" style="vertical-align: text-top;">Map POs</td>
					<td>
					<table cellpadding="10" cellspacing="0" border="0" width="100%" class="tab_split" >
					<tr>
						<th><strong>Sr. No.</strong></th>
						<th><strong>Description</strong></th>
						<th><strong>Select</strong></th>
						<th><strong>Level</strong></th>
						<th><strong>Justification</strong></th>
					</tr>
					<?php
					// Create connection
					include 'db/db_connect.php';
					if($_SESSION["QID"] == 'I'){
						$query = "SELECT QID,COALESCE(mappo,podesc) AS mappo,COALESCE(mappochecked,0) AS mappochecked,COALESCE(polevel,-1) AS polevel,
								COALESCE(pojust ,'') AS pojust ,COALESCE(quemappoid,0) AS quemappoid
								FROM tblquemappo mpo 
								RIGHT OUTER JOIN tblpomaster pco ON pco.podesc = mpo.mappo 
								and QID is NULL
								ORDER BY mappo";
					}
					else{
						$query = "SELECT QID,COALESCE(mappo,podesc) AS mappo,COALESCE(mappochecked,0) AS mappochecked,COALESCE(polevel,-1) AS polevel,
								COALESCE(pojust ,'') AS pojust ,COALESCE(quemappoid,0) AS quemappoid
								FROM tblquemappo mpo 
								RIGHT OUTER JOIN tblpomaster pco ON pco.podesc = mpo.mappo 
								and QID = " . $_SESSION["QID"] . "
								ORDER BY mappo";
					}
					//echo $query;
					$result = $mysqli->query( $query );
					$num_results = $result->num_rows;
					$i = 1;
					if( $num_results ){
						$k = 0;							  
						while( $row = $result->fetch_assoc() ){
							extract($row);
						  echo "<TR class='odd gradeX'>";
										echo "<td>$i</td>";
										echo "<td>{$mappo}<input type='hidden' name='txtmappo[]' value='{$mappo}' /> </td>";
										echo "<td><input type='checkbox' name='chkmappo[]' value='{$k}'";
										if ($mappochecked == '1')
											echo ' checked'; 
										else
											echo '';
									echo "/></td>";
										echo "<td>";
												echo "<select style='width:100px' name='ddllevelpo[]' class='span100'>";
													echo "<option value='0' ";  if($polevel == '0') echo "selected"; 
													echo ">0</option>";
													echo "<option value='1' ";  if($polevel == '1') echo "selected"; 
													echo ">1</option>";
													echo "<option value='2' "; if($polevel == '2') echo "selected"; 
													echo ">2</option>";
													echo "<option value='3' "; if($polevel == '3') echo "selected"; 
													echo ">3</option>";
													echo "</select>";
												echo "</td>";
										echo "<td><input type = 'text' name = 'txtpojustpo[]' value='{$pojust}' /></td>";

						 echo "</TR>";
						 $k = $k + 1;
						  $i = $i + 1;
						}
					}
					else{
						echo "<TR class='odd gradeX'>";
						echo "<td></td>";
						echo "<td>No records found.</td>";
						echo "<td></td>";
						echo "<td></td>";
						echo "</TR>";
					}
					echo "</table>";
					?> 
			</td>
			</tr>				
				<tr>
					<td class="form_sec span4" style="vertical-align: text-top;">Answer Key</td>
					<td colspan="8">
						<div id="editorContainer2"></div>
						<input  name="txtcommentheader" id="txtcommentheader" type="hidden" value='<?php echo $comment; ?>'>
					</td>
				</tr>
				<tr>
					<td class="form_sec span4" style="vertical-align: text-top;">Answer Key Image</td>
					<td colspan="8">
						<input name="fileToUpload2" type="file" id="fileToUpload2">
						<input  name="uploadphoto2" id="uploadphoto2" onclick="javascript:return fnsave();" type="submit" value="Upload Image" class="btn btn-mini btn-success" />
						<br/>
						<?php
							if(!isset($_SESSION)){
								session_start();
							}
							$dir = 'ansimages';
							// echo $dir;
							include 'db/db_connect.php';
							$query = "SELECT photopath2 FROM tblquestionmaster where QID = '" . $_SESSION["QID"] . "' ";						
							//echo $query;
							$result = $mysqli->query( $query );
							$num_results = $result->num_rows;
							if( $num_results ) {
								while( $row = $result->fetch_assoc() ) {
									extract($row);
								  echo "<img src=ansimages/". $photopath2 . " alt=''  />";
								}
							}
						//echo $photopath2;							
						?>		
					</td>
				</tr>				
				<tr>
					<td class="form_sec span4">Answer Type</td>
					<td colspan="2">
						<select name="ddltype" id="ddltype">
						<option value="">Select Option</option>
							<option value="Single Choice Correct" <?php if($answertype == "Single Choice Correct") echo "selected"; ?>>Single Choice Correct</option>
							<option value="Multiple Choices Correct" <?php if($answertype == "Multiple Choices Correct") echo "selected"; ?>>Multiple Choices Correct</option>
							<option value="Numerical Answer" <?php if($answertype == "Numerical Answer") echo "selected"; ?>>Numerical Answer</option>
							<option value="True or False" <?php if($answertype == "True or False") echo "selected"; ?>>True or False</option>
							<option value="Text" <?php if($answertype == "Text") echo "selected"; ?>>Text</option>
						</select>
						
					</td>
					
				</tr>
				<tr>
					<td class="form_sec span4" style="vertical-align: text-top;">Options</td>
					<td colspan="8">
					<div id="divNewQ" style="display:none">Please save question first to add options.</div>
					<table cellpadding="10" cellspacing="0" border="0" width="100%" class="tab_split" id="divAns" style="display:block">
					<tr>
						<th>
							<?php 
								if(($_SESSION["ReadAccess"] == "Yes") && ($_SESSION["WriteAccess"] == "Yes")){
									echo "<input name='btnNew' id='btnNew' value='+New' title='New' class='btn btn-mini btn-success' type='submit' 
									 onclick='javascript:return fnsave();'/>";
								}
							?>
											
						</th>
						<th><strong>Sr. No.</strong></th>
						<th><strong>Is Correct?</strong></th>
						<th><strong>Answer Description</strong></th>
						<th><strong>Delete</strong></th>
					</tr>
				</tr>
					<?php
					// Create connection
					include 'db/db_connect.php';
					$query = "SELECT qansid,iscorrect,correctans FROM tblquestionanswer WHERE QID = " . $_SESSION["QID"];
					//echo $query;
					$result = $mysqli->query( $query );
					$num_results = $result->num_rows;
					$i = 1;
					if( $num_results ){
						while( $row = $result->fetch_assoc() ){
							extract($row);
						  echo "<TR class='odd gradeX'>";
						   echo "<td><a class='btn btn-mini btn-primary' href='AnswerListMaintMain.php?QID=" . $_SESSION["QID"] . "&qansid={$qansid}&qans={$correctans}&iscorrect={$iscorrect}'><i class='icon-pencil icon-white'></i>Edit</a> </td>";
						   echo "<td>$i</td>";
						  echo "<td style='display:none'>{$qansid}</td>";
						  echo "<td>" . ($iscorrect == 1 ? 'Yes' : 'No'). "</td>";
						  echo "<td>{$correctans}</td>";
						  echo "<td><a onclick=\"return confirm('Are you sure?');\" class='btn btn-mini btn-primary' href='AnswerListUpd.php?QID=" . $_SESSION["QID"] . "&qansid={$qansid}&qans={$correctans}&iscorrect={$iscorrect}'><i class='icon-remove icon-white'></i></a> </td>";
						 echo "</TR>";
						}
					}
					else{
						echo "<TR class='odd gradeX'>";
						echo "<td></td>";
						echo "<td>No records found.</td>";
						echo "<td></td>";
						echo "<td></td>";
						echo "</TR>";
						 $i = $i + 1;
					}
					echo "</table>";
					?> 
					
					</td>
				</table>
				</div>
				</div>
</form>
