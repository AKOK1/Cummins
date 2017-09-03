<?php
//include database connection
include 'db/db_connect.php';

// if the form was submitted/posted, update the record
	If (isset($_POST['btnSelect']) && (!($_POST['ddlExam'] == 'Select' )))
	{
		if(!isset($_SESSION)){
			session_start();
		}
		$_SESSION["SESSSelectedExam"] = $_POST['ddlExam'];
		$_SESSION["SESSSelectedExamName"] = $_POST['hdnexamname'];		
		include 'db/db_connect.php';
		$sql2 = "SELECT ExamType FROM tblexammaster Where ExamID = ". $_SESSION['SESSSelectedExam'] .  "";
		$result2 = $mysqli->query( $sql2 );
		while( $row = $result2->fetch_assoc() ) {
			extract($row);
			if ($ExamType == 'Online'){
				//header('Location: ExamIndexOMain.php?'); 
				$_SESSION["SESSSelectedExamType"] =  'Online';
			}
			else {
				$_SESSION["SESSSelectedExamType"] =  'Classroom';
			}
			header('Location: ExamIndexMain.php?'); 
		}
	}
?>



<form action="ExamAdminMain.php" method="post">
<script>
  $(document).ready(function() {
    $("#ddlExamID").change(function(){
		var skillsSelect = document.getElementById("ddlExamID");
		var selectedText = skillsSelect.options[skillsSelect.selectedIndex].text;
		$("#examname_hidden").val(selectedText);
    });
  });
</script>
	<br /><br />	<br />
	<h3 class="page-title">Exam Menu</h3>
		<table cellpadding="10" cellspacing="0" border="0" class="tab_split" style="width:80%">
			<tr >
				<td class="form_sec span1"><b>Select Exam</b></td>
				<td class="form_sec span2">
					<select id="ddlExamID" name="ddlExam" style="width:100%;margin-top:10px">
						<?php
						include 'db/db_connect.php';
						echo "<option value=Select>Select</option>"; 
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
					<input type="hidden" name="hdnexamname" id="examname_hidden">
				</td>
				<td class="form_sec span2" style="width:50%">
					<input type="submit" name="btnSelect" value="Go To Exam Main" title="Go To Exam Main" class="btn btn btn-success" />
				</td>								
			</tr>						
		</table>

	<br />

	<br />
	<br />
	<br />

	<h3 class="page-title">Admin Menu</h3>
	
	<div class="row-fluid">
		<div class="span10">
			<div class="metro-nav  report_sec">
				<div class='metro-nav-block p_t'><a href='ExamListMain.php'>
					<div class="status">Exam Master </div></a>
				</div>
				<div class='metro-nav-block p_type'><a href='BlockListMain.php'>
					<div class="status">Block Master </div></a>
				</div>
				<div class='metro-nav-block comodity'><a href='UserListMain.php'>
					<div class="status">User Master</div></a>
				</div>
				<div class='metro-nav-block vendor_type'><a href='SubjectListMain.php'>
					<div class="status">Subject Master</div></a>
				</div>
				<div class='metro-nav-block p_t'><a href='PaperListMain.php'>
					<div class="status">Paper Master</div></a>
				</div>
				<div class='metro-nav-block p_t'><a href='CustomListMain.php'>
					<div class="status">Custom Lists</div></a>
				</div>
				<div class='metro-nav-block comodity'><a href='StdListMain.php'>
					<div class="status">Student Master</div></a>
				</div>
				<div class='metro-nav-block p_type'><a href='ContactUsListMain.php'>
					<div class="status">Contact Us Messages</div></a>
				</div>
				<div></div>
			</div>
		</div>
    </div>
	
</form>
