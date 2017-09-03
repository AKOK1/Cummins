<form name="myform" action="StdListMain.php" method="post" enctype="multipart/form-data">
<?php
	if(!isset($_SESSION)){
		session_start();
	}
	if(isset($_POST['ddlYear'])){
		if($_POST['ddlYear'] <> ""){
			$tmpselyear = $_POST['ddlYear'] ;
		}
	}
	if(isset($_POST['ddlacadyear'])){
		if($_POST['ddlacadyear'] <> ""){
			$tmpselacadyear = $_POST['ddlacadyear'] ;
		}
	}
	if(isset($_POST['ddldept'])){
		if($_POST['ddldept'] <> ""){
			$tmpseldept = $_POST['ddldept'] ;
		}
	}		
	if(isset($_GET['selyear'])){
		$tmpselyear = $_GET['selyear'] ;
	}
	if(isset($_GET['seldept'])){
		$tmpseldept = $_GET['seldept'] ;
	}
	if(isset($_GET['selacadyear'])){
		$tmpselacadyear = $_GET['selacadyear'] ;
	}

	// elseif(isset($_GET['sorting'])){
		// echo "sdfds";
		// echo $_GET['selyear'];
		// echo $_POST['selectedyear'];
		// echo "sdsdf";
		// $tmpselyear = $_GET['selyear'] ;
		// $tmpseldept = $_POST['ddldept'] ;
	// }
	
If (isset($_POST['btnDownload']))
		{
					$filename = "allstudents.csv";
					$handle = fopen($filename, "w");

					$TextLine = "CNUM, Student Name, Mobile, Dept. , Year, UniPRN, Roll No  , UniEli, SeatNo" ;
					$TextLine = $TextLine . " , " . PHP_EOL;
					fwrite($handle, $TextLine );

					include 'db/db_connect.php';
					ini_set('max_execution_time', 2000);
					if($tmpselyear == 'F.E.'){
					$sql = "SELECT s.CNUM, Concat(SurName,' ',Firstname) as stdName, 
							Mobno, s.Dept,sa.Year,
							uniprn,coalesce(sa.RollNo , '') as RollNo,unieli,coalesce(sa.ESNum, '') as SeatNo
							FROM tblstudent s
							inner join tblstdadm sa on s.stdid = sa.stdid and sa.Year <> 'A.L.'
							inner join tblcuryearauto cy on cy.EduYearFrom = sa.EduYearFrom and 
							cy.EduYearTo = sa.EduYearTo ";
					}
					else{
					$sql = "SELECT s.CNUM, Concat(SurName,' ',Firstname) as stdName, 
							Mobno, s.Dept,sa.Year,
							uniprn,coalesce(sa.RollNo , '') as RollNo,unieli,coalesce(sa.ESNum, '') as SeatNo
							FROM tblstudent s
							inner join tblstdadm sa on s.stdid = sa.stdid and sa.Year <> 'A.L.'
							inner join tblcuryear cy on cy.EduYearFrom = sa.EduYearFrom and 
							cy.EduYearTo = sa.EduYearTo ";

					}
						if(isset($_POST['selectedyear'])){
							if(($_POST['selectedyear'] <> '' ) && ($_POST['selecteddept'] == '')){
								$sql = $sql . " where sa.Year = '" . $_POST['selectedyear'] . "' ";
							}
							if(($_POST['selectedyear'] == '' ) && ($_POST['selecteddept'] <> '')){
								$sql = $sql . " where s.dept = '" . $_POST['selecteddept'] . "' ";
							}
							if(($_POST['selectedyear'] <> '' ) && ($_POST['selecteddept'] <> '')){
								$sql = $sql . " where s.dept = '" . $_POST['selecteddept'] . "' and sa.Year = '" . $_POST['selectedyear'] . "' ";
							}
						}
					$result = $mysqli->query($sql);
					$num_results = $result->num_rows;
					$TextLine = '';
					if( $num_results ){
						while( $row = $result->fetch_assoc() ){
							extract($row);
							$TextLine = $CNUM . " , " . $stdName . " , " . $Mobno . " , "  . $Dept . " , "  . $Year . " , " . $uniprn . " , " . $RollNo . " , " . $unieli . " , " . $SeatNo;
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
		?>
<head>
	   <link rel="stylesheet" href="css/jquery-ui.css">
	   <script src="js/jquery-1.10.2.js"></script>
       <script src="js/jquery-ui.js"></script>
	<script type="text/javascript" src="js/jquery.min.js"></script>
	 <script type="text/javascript">     
	 function showdept(){
		 $('#selecteddept').val($('#ddldept').val());
		 $('#selectedyear').val($('#ddlYear').val());
		 $('#selectedacadyear').val($('#ddlacadyear').val());
		 
		document.myform.submit();
	 }
	 function showyear(){
		 //$('#selectedyear').val($('#ddlYear').val());
		 //$('#selecteddept').val($('#ddldept').val());
		//document.myform.submit();
	 }
	 function AddToList()
	 {
		 if($('#ddlListNames').val() == '')
			alert('Please select a list.');
		else{
			var q = "";
				$("input[type=checkbox]:checked").each(function(){
					if (q != "") 
						q += ",";
					if($(this).attr("id") != undefined)
						q+= $(this).attr("id");
				});
				$('#selectedids').val(q);
				//alert($('#selectedids').val());
				document.myform.submit();
		}
	 }
	 function setall(chkmain)
	 {
			if ($(chkmain).val() == 'Check All') {
				$('.checkbox-class').attr('checked', 'checked');
				$(chkmain).val('Uncheck All');
			} else {
				$('.checkbox-class').removeAttr('checked');
				$(chkmain).val('Check All');
			}
	 }
		$("#clickit").click(function() {
				alert('1');
			if ($(this).val() == 'Check All') {
				$('.checkbox-class').attr('checked', 'checked');
				$(this).val('Uncheck All');
			} else {
				$('.checkbox-class').removeAttr('checked');
				$(this).val('Check All');
			}

		});
	</script>
</head>
<body>
<?php
	if(isset($_POST['btnUpload'])){
			if(isset($_FILES['fileToUpload'])) {
				$errors     = array();
				$maxsize    = 2097152;
				$acceptable = array('application/vnd.ms-excel','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

				if(($_FILES['fileToUpload']['size'] >= $maxsize) || ($_FILES["fileToUpload"]["size"] == 0)) {
					$errors[] = 'File too large. File must be less than 2 megabytes.';
				}

				if((!in_array($_FILES['fileToUpload']['type'], $acceptable)) && (!empty($_FILES["fileToUpload"]["type"]))) {
					$errors[] = 'Invalid file type. Only Excel or CSV is accepted.';
				}

				if(count($errors) === 0) {
					$filename = $_FILES['fileToUpload']['name'];
					//move_uploaded_file( $_FILES['fileToUpload']['tmp_name'], $target);
					move_uploaded_file( $_FILES['fileToUpload']['tmp_name'], 'uploads/'. $filename);
					if( $_FILES['fileToUpload']['name'] != "" )
					{
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
								include 'db/db_connect.php';
								if(($emapData[0] != '') && ($emapData[1] != '')){
									$sql = "update tblstudent set seatno = TRIM('$emapData[1]') 
									where TRIM(uniprn) = TRIM('$emapData[0]');";
								}
								$stmt = $mysqli->prepare($sql);
								if($stmt->execute()){
									//echo "1" . "<br/>";
								}
								else{
									echo '<script>alert("Error! Please contact Admin!");</script>';
									exit;
								}
								//mysql_query($sql);
							}
							fclose($file);
							echo '<script>alert("Updated Successfully!");</script>';
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
		
		
		if(isset($_POST['btnUpload2'])){
			if(isset($_FILES['fileToUpload2'])) {
				$errors     = array();
				$maxsize    = 2097152;
				$acceptable = array('application/vnd.ms-excel','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

				if(($_FILES['fileToUpload2']['size'] >= $maxsize) || ($_FILES["fileToUpload2"]["size"] == 0)) {
					$errors[] = 'File too large. File must be less than 2 megabytes.';
				}

				if((!in_array($_FILES['fileToUpload2']['type'], $acceptable)) && (!empty($_FILES["fileToUpload2"]["type"]))) {
					$errors[] = 'Invalid file type. Only Excel or CSV is accepted.';
				}

				if(count($errors) === 0) {
					$filename = $_FILES['fileToUpload2']['name'];
					//move_uploaded_file( $_FILES['fileToUpload2']['tmp_name'], $target);
					move_uploaded_file( $_FILES['fileToUpload2']['tmp_name'], 'uploads/'. $filename);
					if( $_FILES['fileToUpload2']['name'] != "" )
					{
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
								include 'db/db_connect.php';
								if(($emapData[0] != '') && ($emapData[1] != '')){
									$sql = "update tblstudent set uniprn = TRIM('$emapData[1]') 
									where TRIM(CNUM) = TRIM('$emapData[0]');";
								}
								$stmt = $mysqli->prepare($sql);
								if($stmt->execute()){
									//echo "1" . "<br/>";
								}
								else{
									echo '<script>alert("Error! Please contact Admin!");</script>';
									exit;
								}
								//mysql_query($sql);
							}
							fclose($file);
							echo '<script>alert("Updated Successfully!");</script>';
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
		
		
		
		if(isset($_POST['btnUpload3'])){
			if(isset($_FILES['fileToUpload3'])) {
				$errors     = array();
				$maxsize    = 2097152;
				$acceptable = array('application/vnd.ms-excel','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

				if(($_FILES['fileToUpload3']['size'] >= $maxsize) || ($_FILES["fileToUpload3"]["size"] == 0)) {
					$errors[] = 'File too large. File must be less than 2 megabytes.';
				}

				if((!in_array($_FILES['fileToUpload3']['type'], $acceptable)) && (!empty($_FILES["fileToUpload3"]["type"]))) {
					$errors[] = 'Invalid file type. Only Excel or CSV is accepted.';
				}

				if(count($errors) === 0) {
					$filename = $_FILES['fileToUpload3']['name'];
					//move_uploaded_file( $_FILES['fileToUpload3']['tmp_name'], $target);
					move_uploaded_file( $_FILES['fileToUpload3']['tmp_name'], 'uploads/'. $filename);
					if( $_FILES['fileToUpload3']['name'] != "" )
					{
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
								include 'db/db_connect.php';
								if(($emapData[0] != '') && ($emapData[1] != '')){
									$sql = "update tblstudent set unieli = TRIM('$emapData[1]') 
									where TRIM(CNUM) = TRIM('$emapData[0]');";
								}
								$stmt = $mysqli->prepare($sql);
								if($stmt->execute()){
									//echo "1" . "<br/>";
								}
								else{
									echo '<script>alert("Error! Please contact Admin!");</script>';
									exit;
								}
								//mysql_query($sql);
							}
							fclose($file);
							echo '<script>alert("Updated Successfully!");</script>';
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
?>
	<br /><br />
	<div>
		<div style="float:left">
			<h3 class="page-title">Student List</h3>
		</div>
		<div style="float:left;margin-top:18px;margin-left:20px;">
					<select id="ddlacadyear" name="ddlacadyear" style="width:150px" required>
							<option value="">Select Acad Year</option>
							<option value="2017-2018" <?php if(isset($tmpselacadyear)){if($tmpselacadyear == "2017-2018") echo "selected";} ?>>2017-18</option>
							<option value="2016-2017" <?php if(isset($tmpselacadyear)){if($tmpselacadyear == "2016-2017") echo "selected";} ?>>2016-17</option>
							<option value="2015-2016" <?php if(isset($tmpselacadyear)){if($tmpselacadyear == "2015-2016") echo "selected";} ?>>2015-16</option>
					</select>
		</div>
		<div style="float:left;margin-top:18px;margin-left:20px;">
			<?php
			if(!isset($_SESSION)){
				session_start();
			}
			$_SESSION["SESSFrom"] = "";
			include 'db/db_connect.php';
			echo "<select id='ddldept' onchange='showdept();' name='ddldept' style='width:120px'><option value=''>Select Dept</option>";
			$query = "SELECT DeptName AS Department FROM tbldepartmentmaster where coalesce(teaching,0) = 1";
					//echo $query;
					$result = $mysqli->query( $query );
					$num_results = $result->num_rows;
					if( $num_results ){
						while( $row = $result->fetch_assoc() ){
							extract($row);
						echo "<option ";
						if(isset($tmpseldept))
								{ 
									if($tmpseldept == $Department) 
										echo 'selected';
								} 
						echo " value='{$Department}'>{$Department}</option>";
						}
					}
			echo "</select>";
			?>
		</div>
		<div style="float:left;margin-top:18px;margin-left:20px;">
				<select id="ddlYear" name="ddlYear" onchange="showdept();" style="width:120px">
					<option value="">Select Year</option>
					<option value="F.E." <?php if(isset($tmpselyear)){if($tmpselyear == "F.E.") echo "selected";} ?>>F.E.</option>
					<option value="S.E." <?php if(isset($tmpselyear)){if($tmpselyear == "S.E.") echo "selected";} ?>>S.E.</option>
					<option value="T.E." <?php if(isset($tmpselyear)){if($tmpselyear == "T.E.") echo "selected";} ?>>T.E.</option>
					<option value="B.E." <?php if(isset($tmpselyear)){if($tmpselyear == "B.E.") echo "selected";} ?>>B.E.</option>
					<option value="M.E." <?php if(isset($tmpselyear)){if($tmpselyear == "M.E.") echo "selected";} ?>>M.E.</option>
					<option value="A.L." <?php if(isset($tmpselyear)){if($tmpselyear == "A.L.") echo "selected";} ?>>A.L.</option>
					<option value="F.Y." <?php if(isset($tmpselyear)){if($tmpselyear == "F.Y.") echo "selected";} ?>>F.Y.M.Tech.</option>
					<option value="S.Y." <?php if(isset($tmpselyear)){if($tmpselyear == "S.Y.") echo "selected";} ?>>S.Y.M.Tech.</option>
				</select>
		</div>
		<div style="float:left;margin-top:18px;margin-left:20px;">
			<input type="submit" name="btnSearch" value="Search" title="Show Students" class="btn btn btn-success" />
		</div>
		<div style="float:left;margin-top:18px;margin-left:20px;">
		<a target="_blank" href="PendingAll.php">Pending Report: All Students</a>
		</div>
		<div style="float:right;margin-right:100px">
			<h3 class="page-title"><a href="MainMenuMain.php">Back</a></h3>
		</div>
		<br/><br/><br/><br/>
		<table cellpadding="10" cellspacing="0" border="0" style="width:75%">
				<tr >
					<td class="form_sec span2">
						<b><a href="PRNTEMPLATE.csv">UniPRN-Seat Number Template</a></b><br/><br/>
						<b><a href="CNUMPRNTEMPLATE.csv">CNUM-UniPRN Template</a></b><br/><br/>
						<b><a href="CNUMUniEliTEMPLATE.csv">CNUM-UniEli Template</a></b>
					</td>
					<td class="form_sec span2">
						<input type="file" name="fileToUpload" id="fileToUpload"/>
						<input type="submit" name="btnUpload" value="Upload UniPRN-Seat Number" title="Upload UniPRN" class="btn btn-mini btn-success" /><BR/><br/>
						<input type="file" name="fileToUpload2" id="fileToUpload2"/>
						<input type="submit" name="btnUpload2" value="Upload CNUM-UniPRN Number" title="Upload CNUMUniPRN" class="btn btn-mini btn-success" /><BR/><br/>
						<input type="file" name="fileToUpload3" id="fileToUpload3"/>
						<input type="submit" name="btnUpload3" value="Upload CNUM-UniEli Number" title="Upload CNUMUniEli" class="btn btn-mini btn-success" />
					</td>		
					<td class="form_sec span1">
					<input type="submit" name="btnDownload" value="Download All Student Data" title="Download All Students" class="btn btn btn-success" />
					</td>		
				</tr>						
			</table>
	</div>

	
	<input type="hidden" name="selectedids" id="selectedids">
	<input type="hidden" name="selecteddept" id="selecteddept" value="">
	<input type="hidden" name="selectedyear" id="selectedyear" value="">
	
	<br/>
	<div class="row-fluid">
		<div class="v_detail">
			<table cellpadding="10" cellspacing="0" border="0" class="tab_split">
				<tr>
				<?php
		//if(isset($_POST['btnSearch'])){

				// Create connection
				include 'db/db_connect.php';
				if(!isset($_GET['sorting'])){
					$field='userName';
					$sort='ASC';
					$image = 'arrowup.png';
				}
				if(isset($_GET['sorting']))
				{
				  if($_GET['sorting']=='ASC'){ $sort='DESC';$image = 'arrowdown.png';}
				  else { $sort='ASC'; $image = 'arrowup.png';}
				}
				if(isset($_GET['field'])){
					if($_GET['field']=='userName'){$field = "userName";}
					elseif($_GET['field']=='userLogin'){$field = "userLogin";}
					elseif($_GET['field']=='userMobile'){$field="userMobile";}
					elseif($_GET['field']=='userDepartment'){$field="userDepartment";}
					elseif($_GET['field']=='userType'){$field="userType";}
					elseif($_GET['field']=='uniprn'){$field="uniprn";}
					elseif($_GET['field']=='unieli'){$field="unieli";}
					elseif($_GET['field']=='RollNo'){$field="RollNo";}
					elseif($_GET['field']=='SeatNo'){$field="SeatNo";}
				}
				
					// echo "<th><a href='UserMaintMain.php?userID=I'><i class='icon-plus icon-white'></i>New</a></th>";
					echo "<th></th>";
					echo "<th><a href='StdListMain.php?sorting=" .$sort. "&field=userName&selyear=" . $tmpselyear . "&seldept=" . $tmpseldept . "&selacadyear=" . $tmpselacadyear . "'>Full Name</a>";
					if($field =='userName'){
						echo " <img src='images/".$image."' />";
					}
					echo "</th>";
					echo "<th><a href='StdListMain.php?sorting=" .$sort. "&field=userLogin&selyear=" . $tmpselyear . "&seldept=" . $tmpseldept . "&selacadyear=" . $tmpselacadyear . "'>CNUM</a>";
					if($field =='userLogin'){
						echo " <img src='images/".$image."' />";
					}
					echo "</th>";
					echo "<th><a href='StdListMain.php?sorting=" .$sort. "&field=userMobile&selyear=" . $tmpselyear . "&seldept=" . $tmpseldept . "&selacadyear=" . $tmpselacadyear . "'>Mobile</a>";
					if($field =='userMobile'){
						echo " <img src='images/".$image."' />";
					}
					echo "</th>";
					echo "<th><a href='StdListMain.php?sorting=" .$sort. "&field=userDepartment&selyear=" . $tmpselyear . "&seldept=" . $tmpseldept . "&selacadyear=" . $tmpselacadyear . "'>Dept.</a>";
					if($field =='userDepartment'){
						echo " <img src='images/".$image."' />";
					}
					echo "</th>";
					echo "<th></th>";
					echo "<th><a href='StdListMain.php?sorting=" .$sort. "&field=userType&selyear=" . $tmpselyear . "&seldept=" . $tmpseldept . "&selacadyear=" . $tmpselacadyear . "'>Educational Year</a>";
					if($field =='userType'){
						echo " <img src='images/".$image."' />";
					}
					echo "</th>";
					echo "<th></th>";
					echo "<th><a href='StdListMain.php?sorting=" .$sort. "&field=uniprn&selyear=" . $tmpselyear . "&seldept=" . $tmpseldept . "&selacadyear=" . $tmpselacadyear . "'>Uni. PRN</a>";
					if($field =='uniprn'){
						echo " <img src='images/".$image."' />";
					}
					echo "</th>";
					echo "<th></th>";
					echo "<th><a href='StdListMain.php?sorting=" .$sort. "&field=unieli&selyear=" . $tmpselyear . "&seldept=" . $tmpseldept . "&selacadyear=" . $tmpselacadyear . "'>Uni. Eli.</a>";
					if($field =='unieli'){
						echo " <img src='images/".$image."' />";
					}
					echo "</th>";
					echo "<th></th>";
					echo "<th><a href='StdListMain.php?sorting=" .$sort. "&field=RollNo&selyear=" . $tmpselyear . "&seldept=" . $tmpseldept . "&selacadyear=" . $tmpselacadyear . "'>Roll No.</a>";
					if($field =='RollNo'){
						echo " <img src='images/".$image."' />";
					}
					echo "</th>";
					echo "<th></th>";
					echo "<th><a href='StdListMain.php?sorting=" .$sort. "&field=SeatNo&selyear=" . $tmpselyear . "&seldept=" . $tmpseldept . "&selacadyear=" . $tmpselacadyear . "'>Seat No.</a>";
					if($field =='SeatNo'){
						echo " <img src='images/".$image."' />";
					}
					echo "</th>";
					echo "<th></th>";
					/*
					echo "<th>
							<input onclick='setall(this);' class='checkbox-class' type='checkbox' value='Check All' />
								<input style='margin-top:-7px;' onclick='AddToList();' type='button' value='Add to List' />";
								echo "<select id='ddlListNames' name='ddlListNames' style='width:110px'><option value=''>Select List</option>";
								$query = "SELECT ListID, ListName FROM tbllistmster where ListType = 'User' order by ListName";
								//echo $query;
								$result = $mysqli->query( $query );
								$num_results = $result->num_rows;
								if( $num_results ){
									while( $row = $result->fetch_assoc() ){
										extract($row);
										echo "<option value='{$ListID}'>{$ListName}</option>";
									}
								}
					echo "</th>";
					*/
				echo "</tr>";

			if(isset($tmpselyear)){
					if(($tmpselyear <> '' ) && ($tmpseldept == '')){
						if($tmpselyear == 'F.E.'){
							$query = "SELECT s.StdId as userID, s.CNUM as userLogin, Concat(SurName,' ',Firstname) as userName, 
									Mobno as userMobile, s.dept as userDepartment,sa.Year as userType ,
									uniprn,coalesce(sa.RollNo , '') as RollNo,unieli,coalesce(sa.ESNum, '') as SeatNo
									FROM tblstudent s
									inner join tblstdadm sa on s.stdid = sa.stdid 
									INNER JOIN tbldepartmentmaster DM ON sa.Dept = DM.DeptID
									inner join tblcuryearauto cy on cy.EduYearFrom = sa.EduYearFrom and 
									cy.EduYearTo = sa.EduYearTo ";
						}
						else{
							$query = "SELECT s.StdId as userID, s.CNUM as userLogin, Concat(SurName,' ',Firstname) as userName, 
									Mobno as userMobile, s.dept as userDepartment,sa.Year as userType ,
									uniprn,coalesce(sa.RollNo , '') as RollNo,unieli,coalesce(sa.ESNum, '') as SeatNo
									FROM tblstudent s
									inner join tblstdadm sa on s.stdid = sa.stdid 
									INNER JOIN tbldepartmentmaster DM ON sa.Dept = DM.DeptID
									inner join tblcuryear cy on cy.EduYearFrom = sa.EduYearFrom and 
									cy.EduYearTo = sa.EduYearTo ";

						}
					}
					else{
						if($tmpselyear == 'F.E.'){
							$query = "SELECT s.StdId as userID, s.CNUM as userLogin, Concat(SurName,' ',Firstname) as userName, 
									Mobno as userMobile, s.dept as userDepartment,sa.Year as userType ,
									uniprn,coalesce(sa.RollNo , '') as RollNo,unieli,coalesce(sa.ESNum, '') as SeatNo
									FROM tblstudent s
									inner join tblstdadm sa on s.stdid = sa.stdid
									INNER JOIN tbldepartmentmaster DM ON sa.Dept = DM.DeptID
									inner join tblcuryearauto cy on cy.EduYearFrom = sa.EduYearFrom and 
									cy.EduYearTo = sa.EduYearTo ";
						}
						else{
							$query = "SELECT s.StdId as userID, s.CNUM as userLogin, Concat(SurName,' ',Firstname) as userName, 
									Mobno as userMobile, s.dept as userDepartment,sa.Year as userType ,
									uniprn,coalesce(sa.RollNo , '') as RollNo,unieli,coalesce(sa.ESNum, '') as SeatNo
									FROM tblstudent s
									inner join tblstdadm sa on s.stdid = sa.stdid
									INNER JOIN tbldepartmentmaster DM ON sa.Dept = DM.DeptID
									inner join tblcuryear cy on cy.EduYearFrom = sa.EduYearFrom and 
									cy.EduYearTo = sa.EduYearTo ";
						}
					}
			}

				// $query = "SELECT s.StdId as userID, s.CNUM as userLogin, Concat(FirstName,' ',Surname) as userName, 
							// Mobno as userMobile, s.dept as userDepartment,sa.Year as userType ,
							// uniprn,coalesce(sa.RollNo , '') as RollNo,unieli,s.SeatNo
							// FROM tblstudent s
							// inner join tblstdadm sa on s.stdid = sa.stdid 
							// inner join tblcuryear cy on cy.EduYearFrom = sa.EduYearFrom and 
							// cy.EduYearTo = sa.EduYearTo 
							// where sa.Year <> 'A.L.'
							// UNION ALL
							// SELECT s.StdId as userID, s.CNUM as userLogin, Concat(FirstName,' ',Surname) as userName, 
							// Mobno as userMobile, s.dept as userDepartment,sa.Year as userType ,
							// uniprn,coalesce(sa.RollNo , '') as RollNo,unieli,s.SeatNo
							// FROM tblstudent s
							// inner join tblstdadm sa on s.stdid = sa.stdid 
							// inner join tblcuryear cy on (cy.EduYearFrom -1) = sa.EduYearFrom and (cy.EduYearTo -1) = sa.EduYearTo ";
				if(isset($tmpselyear)){
					if(($tmpselyear <> '' ) && ($tmpseldept == '')){
						$query = $query . " where sa.Year = '" . $tmpselyear . "' ";
					}
					if($tmpselyear == 'F.E.'){
						if(($tmpselyear == '' ) && ($tmpseldept <> '')){
							//$query = $query . " where s.dept = '" . $tmpseldept . "' ";
						}
						if(($tmpselyear <> '' ) && ($tmpseldept <> '')){
							$query = $query . " where sa.Year = '" . $tmpselyear . "' ";
							//s.dept = '" . $tmpseldept . "' and 
						}
					}
					else{
						if(($tmpselyear == '' ) && ($tmpseldept <> '')){
							$query = $query . " where DM.DeptName = '" . $tmpseldept . "' ";
						}
						if(($tmpselyear <> '' ) && ($tmpseldept <> '')){
							$query = $query . " where DM.DeptName = '" . $tmpseldept . "' and sa.Year = '" . $tmpselyear . "' ";
						}
					}
				}
				$query =	$query . " order by " . $field . " " . $sort . ";";
							
				//echo $query;
				$result = $mysqli->query( $query );
				
				$num_results = $result->num_rows;
				
				if( $num_results ){
					while( $row = $result->fetch_assoc() ){
						extract($row);
					  echo "<TR class='odd gradeX'>";
					  echo "<td><a class='btn btn-mini btn-primary' href='redirecting.php?userID={$userID}&fromadmin=fromadmin&cnum={$userLogin}&selyear=" . $tmpselyear . "&seldept=" . $tmpseldept . "&selacadyear=" . $tmpselacadyear . "'><i class='icon-white'></i>Edit</a> </td>";
					  echo "<td>{$userName}</td>";
					  echo "<td>{$userLogin}</td>";
					  echo "<td>{$userMobile}</td>";
					  echo "<td>{$userDepartment}<td>";
					  if($userType == 'F.Y.'){
						  $userType = 'F.Y.M.Tech.';
					  }
					  if($userType == 'S.Y.'){
						  $userType = 'S.Y.M.Tech.';
					  }
					  echo "<td>{$userType}<td>";
					  echo "<td>{$uniprn}<td>";
					  echo "<td>{$unieli}<td>";
					  echo "<td>{$RollNo}<td>";
					  echo "<td>{$SeatNo}<td>";
					  /*
					  echo "<td><input id={$userID} class='checkbox-class' type='checkbox' value='0' /></td>";
					  */
					  echo "</TR>";
					}
				}
				else{
					//echo "No records found.";
					echo "<TR class='odd gradeX'>";
					//echo "<td><a class='btn btn-mini btn-primary' href='UserMaintMain.php?&userID=" . $row['userID'] . "'><i class='icon-pencil icon-white'>Edit</a> </td>";
					echo "<td>No records found.</td>";
					echo "<td></td>";
					echo "<td></td>";
					echo "<td></td>";
					echo "<td></td>";
					echo "<td></td>";
					echo "</TR>";
				}

				echo "</table>";
		//}
				?> 
				
			</table>
		</div>
	</div>
</body>
</form>