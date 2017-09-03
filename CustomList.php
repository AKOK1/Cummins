<form action="" method="post">
	<br /><br />
	<h3 class="page-title">Custom Lists</h3>
	<h3 class="page-title" style="float:right;margin-top:-40px;"><a href="MainMenuMain.php">Back</a></h3>

	<table cellpadding="10" cellspacing="0" border="0" width="30%" class="tab_split" style="margin-left:5%">
		<tr>
			<th><a class='btn btn-mini btn-success' href="CustomListMaintMain.php?ListID=I"><i class="icon-plus icon-white"></i>New</a></th>
			<th>ID</th>
			<th>Name</th>
			<th>Type</th>
			<th>View List</th>
		</tr>
		<?php
			include 'db/db_connect.php';
				
			$sql = " SELECT ListID,ListName,ListType FROM tbllistmster ";
			
			//echo $sql;

			// execute the sql query
			$result = $mysqli->query( $sql );
			echo $mysqli->error;
			$num_results = $result->num_rows;

			if( $num_results ){
				while( $row = $result->fetch_assoc() ){
					extract($row);
					echo "<TR class='odd gradeX'>";
					  echo "<td><a class='btn btn-mini btn-primary' href='CustomListMaintMain.php?ListID={$ListID}'><i class='icon-pencil icon-white'></i>Edit</a> </td>";
					echo "<td>{$ListID}</td>";
					echo "<td>{$ListName}</td>";
					echo "<td>{$ListType}</td>";
					  echo "<td><a class='btn btn-primary' href='CustomListViewMain.php?ListID={$ListID}'><i class='icon-search icon-white'></i></a> </td>";
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

			//disconnect from database
			$result->free();
			$mysqli->close();
		?>
	</table>
</form>
