<?php
	if(!isset($_SESSION)){
			session_start();
	}
	
	if(isset($_POST['ddlExam'])){
		$_SESSION["quizselectedexam"] = $_POST['ddlExam'];
	}
	elseif(!isset($_SESSION["quizselectedexam"])){
		$_SESSION["quizselectedexam"] = 0;
	}
	
	if(isset($_POST['ddlsubject'])){
		$_SESSION["quizselectedsubject"] = $_POST['ddlsubject'];
	}
	elseif(!isset($_SESSION["quizselectedsubject"])){
		$_SESSION["quizselectedsubject"] = 0;
	}

	if((isset($_POST['examname_hidden'])) && ($_POST['examname_hidden'] <> '')){
		$_SESSION["quizselectedexamname"] = $_POST['examname_hidden'];
	}
	if((isset($_POST['subname_hidden'])) && ($_POST['subname_hidden'] <> '')){
		$_SESSION["quizselectedsubname"] = $_POST['subname_hidden'];
	}
	//echo $_SESSION["quizselectedexamname"];
	// // if the form was submitted/posted, update the record
	// If (isset($_POST['btnSelect']) && (!($_POST['ddlExam'] == 'Select' )) && (!($_POST['ddlsubject'] == 'Select' )))
	// {
		// if(!isset($_SESSION)){
			// session_start();
		// }
		// //$_SESSION["SESSCAPSelectedExam"] = $_POST['ddlExam'];	
		// //$_SESSION["paperid"] = $_POST['ddlsubject'];	
		// //$_SESSION["SESSSelectedExamName"] = $_POST['hdnexamname'];		

		// //$_SESSION["SESSSelectedsubname"] = $_POST['hdnsubname'];	
		
		// //$_SESSION["quizid"] = $_POST['quizid'];	
		// //$_SESSION["quizqueid"] = $_POST['quizqueid'];	
		
	// }
?>
<form action="selectsubexamMain.php" method="post" name="myform">
<script>
  $(document).ready(function() {
    $("#ddlExam").change(function(){
		var skillsSelect = document.getElementById("ddlExam");
		var selectedText = skillsSelect.options[skillsSelect.selectedIndex].text;
		$("#examname_hidden").val(selectedText);
		document.myform.submit();
    });
	$("#ddlsubject").change(function(){
		var skillsSelect = document.getElementById("ddlsubject");
		var selectedText = skillsSelect.options[skillsSelect.selectedIndex].text;
		$("#subname_hidden").val(selectedText);
    });
  });
</script>
	<br /><br />
	<h3 class="page-title">Select Exam and Subject to View / Create a Quiz</h3>
		<table cellpadding="10" cellspacing="0" border="0" class="tab_split" style="width:90%">
			<tr>
				<td class="form_sec span1" style="width:12%"><b>Select Exam</b></td>
				<input type="hidden" id="lblquizid" name="lblquizid" value="<?php echo $quizid; ?>" />
				<td class="form_sec span2" style="width:25%">
					<select id="ddlExam" name="ddlExam" style="width:400px;margin-top:10px" required>
						<?php
						include 'db/db_connect.php';
						echo "<option value=''>Select Exam</option>"; 
						if($_SESSION["usertype"] == "SuperAdmin")
							$sql = "SELECT ExamID, ExamName, ExamType  FROM tblexammaster;";
						else
							$sql = "SELECT ExamID, ExamName, ExamType  FROM tblexammaster where coalesce(ProfViewEnabled,0) = 1;";
						$result1 = $mysqli->query( $sql );
						while( $row = $result1->fetch_assoc() ) {
						extract($row);
						 if((isset($_SESSION["quizselectedexam"]) && $_SESSION["quizselectedexam"] == $ExamID)){
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
					<td class="form_sec span1" style="width:12%"><b>Select Subject</b></td>
				<td class="form_sec span2" style="width:25%">
					<select id="ddlsubject" name="ddlsubject" style="width:400px;margin-top:10px" required>
						<?php
						include 'db/db_connect.php';
						echo "<option value=''>Select Subject</option>"; 						
						$sql = "SELECT ys.YSID as rowid, 
								CONCAT(EnggYear ,' - ' ,'Div ',`div`,' - ',SubjectName, ' Batch ',BatchName) AS Subjects ,
								ys.papertype, ys.PaperID FROM vwhodsubjectsselected ys 
								INNER JOIN tblyearstructprof ysp ON ysp.YSID = ys.YSID
								LEFT JOIN tblbatchmaster bm ON bm.BtchId = ysp.btchId 
								WHERE COALESCE(profid,0) = " . $_SESSION["SESSUserID"] . 
								" AND ys.papertype IS NOT NULL 
								ORDER BY Subjects;";
						$sql = "SELECT distinct pm.PaperID, sm.SubjectName as Subjects
								FROM tblexamblock eb
								INNER JOIN tblpapermaster pm ON pm.PaperID = eb.PaperID
								INNER JOIN tblsubjectmaster sm ON sm.SubjectID = pm.SubjectID
								INNER JOIN tblblocksmaster bm ON bm.BlockID = eb.BlockID
								INNER JOIN tblcapblockprof cbp ON cbp.ExamBlockID = eb.ExamBlockID AND cbp.profid =  " . $_SESSION["SESSUserID"] ."
								WHERE ExamSchID IN (SELECT ExamSchID FROM tblexamschedule WHERE ExamID = " . $_SESSION["quizselectedexam"] . ")
								ORDER BY sm.SubjectName, eb.ExamBlockID";

				$sql = "SELECT distinct pm.PaperID, sm.SubjectName as Subjects
						FROM tbluser u 
						INNER JOIN tblsubprofrole r1 on r1.profid = u.userid
						INNER JOIN tblpapermaster pm ON pm.PaperID = r1.PaperID
						INNER JOIN tblsubjectmaster sm ON sm.SubjectID = pm.SubjectID
						WHERE userid = " . $_SESSION["SESSUserID"] . " and coalesce(r1.roleid,0) = 2
						ORDER BY sm.SubjectName";
					//echo $sql;
					
						$result1 = $mysqli->query( $sql );
						while( $row = $result1->fetch_assoc() ) {
						extract($row);
						 if((isset($_SESSION["quizselectedsubject"]) && $_SESSION["quizselectedsubject"] == $PaperID)){
								echo "<option value={$PaperID} selected>{$Subjects}</option>"; 
							}
							else{
								echo "<option value={$PaperID}>{$Subjects}</option>"; 
							}
						}
						?>
					</select>
					<input type="hidden" name="subname_hidden" id="subname_hidden">
					</td>
					<td>
					<?php
						if(($_SESSION["ReadAccess"] == "Yes") && ($_SESSION["WriteAccess"] == "Yes")){
								 echo "<input type='submit'  name='btnSelect' id='btnSelect' class='btn btn btn-success'  value='Search' class='btn btn btn-success' />";
							}
						?>
				</td>
				
			</tr>
			<h3 class="page-title" style="float:right;margin-top:-40px;"><a href="MainMenuMain.php">Back</a></h3>
		</table>
		</br>
	<?php
	// Create connection
	include 'db/db_connect.php';
	//if(isset($_POST['btnSelect'])){
				$query = "SELECT quizid, quizname, quizstarttime,quizendtime, totaltime, outof FROM tblquizdetails 
				where examid=" . $_SESSION['quizselectedexam'] ." and paperid='" . $_SESSION["quizselectedsubject"] . "'";
				//echo $query;
				$result = $mysqli->query( $query );
				$num_results = $result->num_rows;
				//echo $num_results;
				//die;
				$doonce = 1;
				if( $num_results ){
					while( $row = $result->fetch_assoc() ){
						extract($row);
						if($doonce == 1){
							echo '<div class="row-fluid">
								<div class="v_detail" id="divlist" name="divlist"">
								<table cellpadding="10" cellspacing="0" border="0" width="100%" class="tab_split">
									<tr>
										<th><a class="btn btn-mini btn-success" id="btnNew" name="btnNew"  onclick="javascript:return setval1();" href="selectsubexamMaintMain.php?quizid=I&paperid=' . 
										$_SESSION["quizselectedsubject"] . '">
										<i class="icon-plus icon-white"></i>New</a></th>
										<th><strong>Quiz Name</strong></th>
										<th><strong>Quiz Start Time</strong></th>
										<th><strong>Quiz End Time</strong></th>
										<th><strong>Total Time (In Hrs)</strong></th>
										<th><strong>Out of</strong></th>
									</tr>';
							$doonce = 0;
						}

						//echo 'alert("message successfully sent")';
					  echo "<TR class='odd gradeX'>";
					  echo "<td><a class='btn btn-mini btn-primary' href='selectsubexamMaintMain.php?quizid={$quizid}&paperid={$_SESSION["quizselectedsubject"]}'><i class='icon-pencil icon-white'></i>Edit</a> </td>";
					  echo "<td>{$quizname}</td>";
					  echo "<td>{$quizstarttime}</td>";
					  echo "<td>{$quizendtime}</td>";
					  echo "<td>{$totaltime}</td>";
					  echo "<td>{$outof}</td>";
					  //echo "<td><a href='QueListMain.php' style='width:80%;height:15%' class='btn btn-mini btn-success'>View Question Paper</a></td>";
					  echo "</TR>";
					}
				}
				elseif((isset($_SESSION["quizselectedexam"]) && $_SESSION["quizselectedexam"] <> 0) && 
								(isset($_SESSION["quizselectedsubject"]) && $_SESSION["quizselectedsubject"] <> 0)){
					echo "<TR class='odd gradeX'>";
					echo "<th><a class='btn btn-mini btn-success' id='btnNew' name='btnNew'  
								onclick='javascript:return setval1();' 
								href='selectsubexamMaintMain.php?quizid=I&paperid=" . $_SESSION["quizselectedsubject"] . "'>
								<i class='icon-plus icon-white'></i>New</a></th>";				
					echo "</TR>";
					echo "<TR class='odd gradeX'>";
					echo "<td></td>";
					echo "<td>No records found.</td>";
					echo "<td></td>";
					echo "<td></td>";
					echo "</TR>";	
				}
				else{
					echo "<TR class='odd gradeX'>";
					echo "<td></td>";
					echo "<td>No records found.</td>";
					echo "<td></td>";
					echo "<td></td>";
					echo "</TR>";
				}
			// }
			// else{
				// echo "<TR class='odd gradeX'>";
				// echo "<td></td>";
				// echo "<td>No records found.</td>";
				// echo "<td></td>";
				// echo "<td></td>";
				// echo "</TR>";
			// }

			echo "</table>";
			if(isset($_POST['btnNew'])){
					if($num_results == 1) {
						echo 'alert("message successfully sent")';
					}
				}
			echo '</table>';
		echo '</div>';
	echo '</div>';

				?> 
				
		</br></br>
		
		
</form>
