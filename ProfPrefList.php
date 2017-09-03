
<form >
	<br /><br />
	<h3 class="page-title" style="margin-left:5%">Professor List</h3>
	<h3 class="page-title" style="float:right;margin-top:-46px;"><a href="selectpaperblockmain.php">Back</a></h3>
	

	<div class="row-fluid" style="margin-left:5%">
	    <div class="span5 v_detail" style="overflow:hidden">
            <br />
            <br />
            <div style="float:left">
				<label><b>Professor List</b></label>
            </div>
			<table cellpadding="10" cellspacing="0" border="0" width="100%" class="tab_split">
				<tr>
					<th>Name</th>
					<th width="15%"><strong>Action</strong></th>
				</tr>
				<?php
					include 'db/db_connect.php';
					
					$sql = "SELECT  userID, Concat(FirstName, ' ', LastName) as Name FROM tbluser " ;
					//echo $sql;
					
					// execute the sql query
					$result = $mysqli->query( $sql );
					$num_results = $result->num_rows;

					if( $num_results ){
						while( $row = $result->fetch_assoc() ){
							extract($row);
							echo "<TR class='odd gradeX'>";
							echo "<td>{$Name} </td>";
							echo "<td class='span3'><a class='btn btn-mini btn-success' href='ProfPrefMain.php?userID={$userID}'>
													<i class='icon-ok icon-white'></i>&nbsp&nbspPreferences</a>
								  </td>";
							echo "</TR>";
						}
					}					
					//disconnect from database
					$result->free();
					$mysqli->close();
				?>
				</table>
            <br />
        </div>

	</div>
	</form>

