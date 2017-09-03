<form action="welcome.php" method="post">
	<br /><br />
	<h3 class="page-title">Report List</h3>
	<h3 class="page-title" style="float:right;margin-top:-40px;"><a href="MainMenuMain.php">Back</a></h3>
	<div class="row-fluid">
		<div class="v_detail">
			<table cellpadding="10" cellspacing="0" border="0" width="100%" class="tab_split">
				<tr>
					<th><a class='btn btn-mini btn-success' href="ReportMaintMain.php?reportId=I"><i class="icon-plus icon-white"></i>New</a></th>
					<th><strong>Report Title</strong></th>
					<th><strong>Active</strong></th>
					<th><strong>Column Width</strong></th>
					<th><strong>View</strong></th>

				</tr>

				<?php
				// Create connection
				include 'db/db_connect.php';
				$query="SELECT reportId FROM tblreport";
					
					$getif=mysqli_query($mysqli,$query);
					while($row=mysqli_fetch_array($getif)) {
						$reportId=$row['reportId'];
				
					}
					

				$query = "SELECT reportId,reportsql,colwidth,reportTitle,Active FROM tblreport";
				$result = $mysqli->query( $query );
				$num_results = $result->num_rows;
				
				if( $num_results ){
					while( $row = $result->fetch_assoc() ){
						extract($row);
					  echo "<TR class='odd gradeX'>";
					  echo "<td><a class='btn btn-mini btn-primary' href='ReportMaintMain.php?reportId={$reportId}'><i class='icon-pencil icon-white'></i>Edit</a> </td>";
					  echo "<td>{$reportTitle}</td>";
					  echo "<td>{$Active}</td>";
					  echo "<td>{$colwidth}</td>";
					  echo "<td><a style='color:green' href='ReportViewListMain.php?reportId={$reportId}' target='_blank'>View Report</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>"; 

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
				}

				echo "</table>";

				?> 
				
			</table>
		</div>
	</div>

</form>
