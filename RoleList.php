<form action="welcome.php" method="post">
	<br /><br />
	<h3 class="page-title">Role Master List</h3>
	<h3 class="page-title" style="float:right;margin-top:-40px;"><a href="MainMenuMain.php">Back</a></h3>
	<div class="row-fluid">
		<div class="v_detail">
			<table cellpadding="10" cellspacing="0" border="0" width="100%" class="tab_split">
				<tr>
					<th><a class='btn btn-mini btn-success' href="RoleMaintMain.php?RoleID=I"><i class="icon-plus icon-white"></i>New</a></th>
					<th><strong>Role Name</strong></th>
				</tr>

				<?php
				// Create connection
				include 'db/db_connect.php';

				$query = "SELECT RoleID, RoleName FROM tblrolemaster ;";
				
				$result = $mysqli->query( $query );
				$num_results = $result->num_rows;
				
				if( $num_results ){
					while( $row = $result->fetch_assoc() ){
						extract($row);
					  echo "<TR class='odd gradeX'>";
					  echo "<td><a class='btn btn-mini btn-primary' href='RoleMaintMain.php?RoleID={$RoleID}'><i class='icon-pencil icon-white'></i>Edit</a> </td>";
					  echo "<td>{$RoleName}</td>";
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

				?> 
				
			</table>
		</div>
	</div>

</form>
