<form action="welcome.php" method="post">
	<br /><br />
	<h3 class="page-title">Block Master List</h3>
	<h3 class="page-title" style="float:right;margin-top:-40px;"><a href="MainMenuMain.php">Back</a></h3>
	<div class="row-fluid">
		<div class="v_detail">
			<table cellpadding="10" cellspacing="0" border="0" width="100%" class="tab_split">
				<tr>
				<?php
				// Create connection
				include 'db/db_connect.php';

				if(!isset($_GET['sorting'])){
					$field='BlockName';
					$sort='ASC';
					$image = 'arrowup.png';
				}
				if(isset($_GET['sorting']))
				{
				  if($_GET['sorting']=='ASC'){ $sort='DESC';$image = 'arrowdown.png';}
				  else { $sort='ASC'; $image = 'arrowup.png';}
				}
				if(isset($_GET['field'])){
					if($_GET['field']=='BlockName'){$field = "BlockName";}
					elseif($_GET['field']=='BlockNo'){$field = "BlockNo";}
					elseif($_GET['field']=='BlockType'){$field="BlockType";}
					elseif($_GET['field']=='BlockCapacity'){$field="BlockCapacity";}
				}
				
					echo "<th><a href='BlockMaintMain.php?BlockID=I'><i class='icon-plus icon-white'></i>New</a></th>";
					echo "<th><a href='BlockListMain.php?sorting=" .$sort. "&field=BlockNo'>Number</a>";
					if($field =='BlockNo'){
						echo " <img src='images/".$image."' />";
					}
					echo "</th>";
					echo "<th><a href='BlockListMain.php?sorting=" .$sort. "&field=BlockType'>Type</a>";
					if($field =='BlockType'){
						echo " <img src='images/".$image."' />";
					}
					echo "</th>";
					
					echo "<th><a href='BlockListMain.php?sorting=" .$sort. "&field=BlockName'>Name</a>";
					if($field =='BlockName'){
						echo " <img src='images/".$image."' />";
					}
					echo "</th>";
					
					echo "<th><a href='BlockListMain.php?sorting=" .$sort. "&field=BlockCapacity'>Capacity</a>";
					if($field =='BlockCapacity'){
						echo " <img src='images/".$image."' />";
					}
					echo "</th>";

					echo "<th>Status</th>";
				
					echo "<th></th>";
				echo "</tr>";
				
					
				
				
				$query = "SELECT BlockID, cast(BlockNo as UNSIGNED) as BlockNo, BlockType, BlockName, BlockCapacity, 
							case coalesce(Active,0) when 0 then 'Inactive' else 'Active' end as Active
							FROM tblblocksmaster where ExamID is NULL order by " . $field . " " . $sort . ";";
				
				$result = $mysqli->query( $query );
				
				$num_results = $result->num_rows;
				
				if( $num_results ){
					while( $row = $result->fetch_assoc() ){
						extract($row);
					  echo "<TR class='odd gradeX'>";
					  echo "<td><a class='btn btn-mini btn-primary' href='BlockMaintMain.php?BlockID={$BlockID}'><i class='icon-pencil icon-white'></i>Edit</a> </td>";
					  echo "<td>{$BlockNo}</td>";
					  echo "<td>{$BlockType}</td>";
					  echo "<td>{$BlockName}</td>";
					  echo "<td>{$BlockCapacity}</td>";
					  echo "<td>{$Active}</td>";
					  echo "</TR>";
					}
				}
				else{
					echo "<TR class='odd gradeX'>";
					echo "<td></td>";
					echo "<td></td>";
					echo "<td>No records found.</td>";
					echo "<td></td>";
					echo "<td></td>";
					echo "<td><td>";
					echo "</TR>";
				}

				echo "</table>";

				?> 
				
			</table>
		</div>
	</div>

</form>
