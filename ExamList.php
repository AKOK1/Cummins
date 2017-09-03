
<form action="welcome.php" method="post">
	<br /><br />
	<h3 class="page-title">Exam Master List</h3>
	<h3 class="page-title" style="float:right;margin-top:-40px;"><a href="MainMenuMain.php">Back</a></h3>
	<div class="row-fluid">
		<div class="v_detail">
			<table cellpadding="10" cellspacing="0" border="0" width="100%" class="tab_split">
				<tr>
					<th><a class='btn btn-mini btn-success' href="ExamMaintMain.php?ExamID=I"><i class="icon-plus icon-white"></i>New</a></th>
					<th><strong>Name</strong></th>
					<th><strong>Online / Theory</strong></th>
					<th><strong>Sem</strong></th>
					<th><strong>Exam Type</strong></th>
					<th><strong>Exam For</strong></th>
					<th><strong>Academic Year</strong></th>
					<th><strong>Prof View Start</strong></th>
					<th><strong>Prof View End</strong></th>
					<th><strong>Min Saturday Duties</strong></th>
					<th><strong>Min Evening Duties</strong></th>
					<th><strong>Total Min Preferences</strong></th>
					<th><strong>Total Max Preferences</strong></th>
				</tr>

				<?php
				// Create connection
				include 'db/db_connect.php';

				$query = "SELECT ExamID, ExamName, ExamType,Sem, examtype2, CONCAT(AcadYearFrom,' - ',AcadYearTo) as acadyear, examcat, SatCount, 
				EveCount, PubStart, PubEnd, MinPrefCount, MaxPrefCount FROM tblexammaster;";
				$result = $mysqli->query( $query );
				
				$num_results = $result->num_rows;
				
				if( $num_results ){
					while( $row = $result->fetch_assoc() ){
						extract($row);
					  echo "<TR class='odd gradeX'>";
					  echo "<td><a class='btn btn-mini btn-primary' href='ExamMaintMain.php?ExamID={$ExamID}'><i class='icon-pencil icon-white'></i>Edit</a> </td>";
					  echo "<td>{$ExamName}</td>";
					  echo "<td>{$ExamType}</td>";
					  echo "<td>{$Sem}</td>";
					  echo "<td>{$examtype2}</td>";
					  echo "<td>{$examcat}</td>";
					  echo "<td>{$acadyear}</td>";
					  echo "<td>{$PubStart}</td>";
					  echo "<td>{$PubEnd}</td>";
					  echo "<td>{$SatCount}</td>";
					  echo "<td>{$EveCount}</td>";
					  echo "<td>{$MinPrefCount}</td>";
					  echo "<td>{$MaxPrefCount}</td>";
					  echo "</TR>";
					}
				}
				echo "</table>";

				?> 
				
			</table>
		</div>
	</div>

</form>
