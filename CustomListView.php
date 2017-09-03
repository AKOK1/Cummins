<form action="" method="post">
	<br /><br />
	<h3 class="page-title">View Custom List</h3>
	<h3 class="page-title" style="float:right;margin-top:-40px;"><a href="CustomListMain.php">Back</a></h3>

	<table cellpadding="10" cellspacing="0" border="0" width="30%" class="tab_split" style="margin-left:5%">
		<tr>
			<th>Sr. No.</th>
			<th>Type</th>
			<th>Department</th>
			<th>Name</th>
			<th>Delete</th>
		</tr>
		<?php
			include 'db/db_connect.php';
			if(isset($_GET['ItemID'])){
				if ($_GET['ItemID'] != '') {
					$mysqli->query("SET @i_ItemID  = " . $_GET["ItemID"] . "");
					$mysqli->query("SET @i_ListType  = '" . $_GET["ListType"] . "'");
					$mysqli->query("call SP_DELETELISTITEMS(@i_ItemID,@i_ListType)");
				}
			}
			$mysqli->query("SET @i_ListID  = " . $_GET["ListID"] . "");
			if ($mysqli->multi_query("call SP_GETLISTITEMS(@i_ListID)"))
			{
					//$show_results = true;
					//$rs = array();
					do {
						// Lets work with the first result set
						if ($result = $mysqli->use_result())
						{
							// Loop the first result set, reading it into an array
							while ($row = $result->fetch_array(MYSQLI_ASSOC))
							{
								extract($row);
								echo "<TR class='odd gradeX'>";
								echo "<td>{$SrNo}</td>";
								echo "<td>{$userType}</td>";
								echo "<td>{$Department}</td>";
								echo "<td>{$ItemName}</td>";
								echo "<td><a class='btn btn-primary' href='CustomListViewMain.php?ListID={$_GET["ListID"]}&ItemID={$ItemID}&ListType={$ListType}'><i class='icon-remove icon-white'></i></a> </td>";

							}
						}
					} while ($mysqli->next_result() && $mysqli->more_results());
							// Close the result set
							//disconnect from database
							$result->free();
							$mysqli->close();
					}
			else
			{
				echo "<TR class='odd gradeX'>";
				echo "<td></td>";
				echo "<td>No records found.</td>";
				echo "<td></td>";
				echo "</TR>";
			}


		?>
	</table>
</form>
