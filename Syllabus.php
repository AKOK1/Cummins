<?php
//include database connection
include 'db/db_connect.php';

?>

<form action="" method="post">
	<script>
		function sendtoobj() {
			var paperSelect = document.getElementById("ddlSubject");
			var PaperName = paperSelect.options[paperSelect.selectedIndex].text;	  
			alert('PrintAttendance.php?paperid=' + document.getElementById('ddlSubject').value + '&SubName=' + PaperName);

			window.location.href = 'PrintAttendance.php?paperid=' + document.getElementById('ddlSubject').value + 
							'&SubName=' + PaperName;
		};
	</script>

	<br /><br />
	<h3 class="page-title" style="margin-left:5%">Define Syllabus</h3>
	<h3 class="page-title" style="float:right;margin-top:-40px;"><a href="MainMenuMain.php">Back</a></h3>
	<div class="row-fluid">
		<div style="margin-left:5%">
			<table cellpadding="10" cellspacing="0" border="0" width="50%" class="tab_split">
				<tr>
					<td class="form_sec span2">Subject</td>
					<td>
					<select id="ddlSubject" name="ddlSubject" style="width:450px;" required>
						<?php
						include 'db/db_connect.php';
						echo "<option value=0>Select Subject</option>"; 						
						$sql = "SELECT ys.YSID as rowid, 
								CONCAT(EnggYear ,' - ' ,'Div ',`div`,' - ',SubjectName, ' Batch ',BatchName) AS Subjects ,ys.papertype, ys.PaperID
								FROM vwhodsubjectsselected ys 
								INNER JOIN tblyearstructprof ysp ON ysp.YSID = ys.YSID
								LEFT JOIN tblbatchmaster bm ON bm.BtchId = ysp.btchId 
								WHERE COALESCE(profid,0) = " . $_SESSION["SESSUserID"] . 
								" AND ys.papertype IS NOT NULL 
								ORDER BY Subjects;";
						$result1 = $mysqli->query( $sql );
						while( $row = $result1->fetch_assoc() ) {
								extract($row);
								echo "<option value={$PaperID}>{$Subjects}</option>"; 
						}
						?>
					</select>
					<?php echo "<input type='hidden' value={$papertype} id='hdnpt' name='hdnpt' />"; ?>
						<input type="submit" name="btnUpdate" value="Go" title="Update" class="btn btn-mini btn-success"/>		
					</td>
				</tr>	
			</table>
		</div>
	</div>
	<br/>

	<div class="row-fluid" style="margin-left:5%">
		<div class="span10">
			<div class="metro-nav  report_sec">
				<div class="metro-nav-block p_t">
					<a  onclick="sendtoobj();" href="#"><div class="status">Course Objectives</div></a>
				</div>
				<div class="metro-nav-block p_type">
					<a  onclick="sendtoout();" href="#"><div class="status">Course Outcomes</div></a>
				</div>
				<div class="metro-nav-block p_type">
					<a onclick="sendtocon();" href="#"><div class="status">Vendor Type</div></a>
				</div>
			</div>
		</div>
	</div>
	
	<div class="row-fluid">
		<div style="margin-left:5%">

			<?php

			if (isset($_POST['btnUpdate'])) {
				echo "<h3>Course Objectives</h3>";

				echo "<table cellpadding='10' cellspacing='0' border='0' width='100%' class='tab_split'>";
				echo "<tr>";
					echo "<th><a class='btn btn-mini btn-success' href='CourseObjectivesMaintMain.php?CourseobjID=I'><i class='icon-plus icon-white'></i>New</a></th>";
					echo "<th><strong>Description</strong></th>";
				echo "</tr>";

				// Create connection
				include 'db/db_connect.php';

				$query = "SELECT CourseobjID, CourseDesc FROM tblCourseObjMaster where PaperID = " . $_POST['ddlSubject'] . " ;";
				echo $query;
				$result = $mysqli->query( $query );
				$num_results = $result->num_rows;
				
				if( $num_results ){
					while( $row = $result->fetch_assoc() ){
						extract($row);
					  echo "<TR class='odd gradeX'>";
					  echo "<td><a class='btn btn-mini btn-primary' href='CourseObjectivesMaintMain.php?CourseobjID={$CourseobjID}'><i class='icon-pencil icon-white'></i>Edit</a> </td>";
					  echo "<td>{$CourseDesc}</td>";
					  echo "</TR>";
					}
				}
				else{
					echo "<TR class='odd gradeX'>";
					echo "<td></td>";
					echo "<td>No records found.</td>";
					echo "<td></td>";
					echo "</TR>";
				}

				echo "</table>";
				echo "</table>";
			}

			?> 
				
		</div>
	</div>

</form>

