<?php
//include database connection
include 'db/db_connect.php';

// if the form was submitted/posted, update the record
	If (isset($_POST['btnSelect']) && (!($_POST['ddlExam'] == 'Select' )))
	{
		if(!isset($_SESSION)){
			session_start();
		}
		
		$_SESSION["SESSCAPSelectedExam"] = $_POST['ddlExam'];
		$_SESSION["SESSCAPSelectedExamName"] = $_POST['hdnexamname'];		
		$_SESSION["ExamBlockID"] = $_POST["ExamBlockID"];
	
		$_SESSION["SESSSelectedExam"] = $_POST['ddlExam'];
		$_SESSION["SESSSelectedExamName"] = $_POST['hdnexamname'];		
		include 'db/db_connect.php';
		$sql2 = "SELECT ExamType FROM tblexammaster Where ExamID = ". $_SESSION['SESSSelectedExam'] .  " and coalesce(examcat,'') = 'Autonomy'";
		
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
			header('Location: assignedblockListMain.php?'); 
		}
		
	}
	
?>



<form action="selectexamMenuMain.php" method="post" enctype="multipart/form-data">
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
		<table cellpadding="10" cellspacing="0" border="0" class="tab_split" style="width:60%">
			<tr>
				<td class="form_sec span1" style="width:10%"><b>Select Exam</b></td>
				<td class="form_sec span2" style="width:25%">
					<select id="ddlExamID" name="ddlExam" style="width:100%;margin-top:10px" required>
						<?php
						include 'db/db_connect.php';
						// echo "<option value=Select>Select</option>"; 
						// if($_SESSION["usertype"] == "SuperAdmin")
						$sql = "SELECT ExamID, ExamName, ExamType,Sem  FROM tblexammaster where coalesce(examcat,'') = 'Autonomy';";
						// else
							// $sql = "SELECT ExamID, ExamName, ExamType  FROM tblexammaster 
									// WHERE CURRENT_TIMESTAMP BETWEEN CAPstart AND CAPend";
						// //where  coalesce(ProfViewEnabled,0) = 1;";
						$result1 = $mysqli->query( $sql );
						while( $row = $result1->fetch_assoc() ) {
						extract($row);
						 if((isset($_POST['ddlExam']) && $_POST['ddlExam'] == $ExamID)){
								echo "<option value={$ExamID} selected>{$ExamName} - {$ExamType} - Sem {$Sem}</option>"; 
							}
							else{
								echo "<option value={$ExamID}>{$ExamName} - {$ExamType} - Sem {$Sem}</option>"; 
							}
						}
						?>
					</select>
					<input type="hidden" name="hdnexamname" id="examname_hidden">
				</td>
				<td class="form_sec span2" style="width:20%">
					<input type="submit" name="btnSelect" value="Go" title="Go To Exam Main" class="btn btn btn-success" />
				</td>						
				<td class="form_sec span2" style="width:15%">
					<h4><a href="MainMenuMain.php">Back to Main Menu</a></h4>
				</td>				
			</tr>						
		</table>

</form>
