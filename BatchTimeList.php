<form action="welcome.php" method="post">
	<br /><br />
	<h3 class="page-title">Batch Time Lists</h3>
	<h3 class="page-title" style="float:right;margin-top:-40px;"><a href="MainMenuMain.php">Back</a></h3>
	<div class="row-fluid">
		<div class="v_detail">
			<table cellpadding="10" cellspacing="0" border="0" width="100%" class="tab_split">
				<tr>
				<?php
				// Create connection
					include 'db/db_connect.php';
					echo "<th><a href='BatchTimeMaintMain.php?batchname=I'><i class='icon-plus icon-white'></i>New</a></th>";
					echo "<th>Batch Name</a>";
				echo "</tr>";
				
				$query = "SELECT distinct batchname from tblbatchtimemaster order by timeorder;";
							
				$result = $mysqli->query( $query );
				
				$num_results = $result->num_rows;
				
				if( $num_results ){
					while( $row = $result->fetch_assoc() ){
						extract($row);
					  echo "<TR class='odd gradeX'>";
					  echo "<td><a class='btn btn-mini btn-primary' href='BatchTimeMaintMain.php?batchname={$batchname}'><i class='icon-pencil icon-white'></i>Edit</a> </td>";
					  echo "<td>{$batchname}</td>";
					  echo "</TR>";
					}
				}
				else{
					echo "<TR class='odd gradeX'>";
					echo "<td></td>";
					echo "<td></td>";
					echo "<td>No records found.</td>";
					echo "</TR>";
				}

				echo "</table>";

				?> 
				
			</table>
		</div>
	</div>

</form>
