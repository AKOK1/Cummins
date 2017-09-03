
<?php
//include database connection
include 'db/db_connect.php';
 
// if the form was submitted/posted, update the record
 if($_POST)
	{
			if (isset($_POST['chkActive'])) {
				$tmpchkProfViewEnabled = '1';
			}
			else
				$tmpchkProfViewEnabled = '0';

		if ($_POST['txtBlockID'] == "I") {
			$sql = "Insert into tblblocksmaster ( BlockNo, BlockName, BlockType, BlockCapacity, Active, created_by, created_on, updated_by, Updated_on,colorder) Values ( ?, ?, ?, ?, ?, 'Admin', CURRENT_TIMESTAMP, 'Admin', CURRENT_TIMESTAMP,?)";

			$stmt = $mysqli->prepare($sql);
			$stmt->bind_param('sssiii', $_POST['txtBlockNo'], $_POST['txtBlockName'], $_POST['ddlBlockType'], 
										$_POST['txtBlockCapacity'],$tmpchkProfViewEnabled,$_POST['txtBlockNo']);
		}
		else {
			$sql = "UPDATE  tblblocksmaster
						Set BlockNo = ?
							,BlockName = ?
							,BlockType = ?
							,BlockCapacity = ?
							,Active = ?
							,updated_by = 'Admin'
							,updated_on = CURRENT_TIMESTAMP
							,colorder = ?
						Where BlockID = ?";
						
				
				$stmt = $mysqli->prepare($sql);
				$stmt->bind_param('sssiiii', $_POST['txtBlockNo'], $_POST['txtBlockName'], $_POST['ddlBlockType'], $_POST['txtBlockCapacity'],$tmpchkProfViewEnabled, $_POST['txtBlockNo'], $_POST['txtBlockID'] );

				}
		
	
		// execute the update statement
		if($stmt->execute()){
			header('Location: BlockListMain.php?'); 
			// close the prepared statement
		}else{
			die("Unable to update.");
		}
	}
else 
	{
		if ($_GET['BlockID'] == "I") {
			$sql = "SELECT 'I' as BlockID, '' as BlockNo, '' as BlockName, 'Select ' as BlockType, '' as BlockCapacity, '0' as  Active " ;
		}
		Else
		{
			$sql = " SELECT BlockID, BlockNo, BlockName, BlockType, BlockCapacity, Active 
					 FROM tblblocksmaster Where BlockId = " . $_GET['BlockID']   ;
		} 
		//echo $sql;
		// execute the sql query
		$result = $mysqli->query( $sql );
		$row = $result->fetch_assoc();
		extract($row);
		 
		//disconnect from database
		$result->free();
		$mysqli->close();
	}
?>

<form action="BlockMaintMain.php?userID=<?php echo $_GET['BlockID']; ?>" method="post">
	<br /><br />
	<h3 class="page-title" style="margin-left:5%">Block Maintenance</h3>
	<div class="row-fluid">
		<div class="v_detail" style="margin-left:5%">
			<table cellpadding="10" cellspacing="0" border="0" width="50%" class="tab_split">
				<tr>
					<td class="form_sec span4">&nbsp;</td>
					<td>
						<div class="span10">
							<input type="hidden" name="txtBlockID" value="<?php echo "{$BlockID}" ?>" />
							<?php 
							if(($_SESSION["ReadAccess"] == "Yes") && ($_SESSION["WriteAccess"] == "Yes")){
								echo "<input type='submit' name='btnUpdate' value='Save' title='Update' class='btn btn-mini btn-success' />";
							}
							?>
							<a href="BlockListMain.php" class="btn btn-mini btn-warning">Cancel</a>
						</div>
					</td>								
				</tr>
				<tr>
					<td class="form_sec span4">Last Block Number</td><td>
						<div class="span10">
						<?php
							//include database connection
							include 'db/db_connect.php';
								$sql="SELECT CONCAT('Classroom: ',Class,' Laboratory: ',Lab) As lastblock  FROM 
									(SELECT MAX(CAST(BlockNo AS UNSIGNED)) AS Class,1 FROM tblblocksmaster WHERE blocktype ='Classroom') AS A INNER JOIN
									(SELECT MAX(CAST(BlockNo AS UNSIGNED)) AS Lab,1 FROM tblblocksmaster WHERE blocktype ='Laboratory') AS B ON 1=1";
								// execute the sql query
								$result = $mysqli->query( $sql );
								echo $mysqli->error;
								$num_results = $result->num_rows;
								if( $num_results ){
									while( $row = $result->fetch_assoc() ){
										extract($row);
										echo "{$lastblock}";
									}
								}

									$sql="SELECT COALESCE(max(colorder),0) + 1 as colorder FROM tblblocksmaster";
								// execute the sql query
								$result = $mysqli->query( $sql );
								echo $mysqli->error;
								$num_results = $result->num_rows;
								if( $num_results ){
									while( $row = $result->fetch_assoc() ){
										extract($row);
										echo "<input type='hidden' name='maxcolorder' value='{$colorder}' />";
									}
								}


								?>							
						</div>
					</td>
				</tr>				
				<tr>
					<td class="form_sec span4">Block Number</td><td>
						<div class="span10">
							<input type="text" maxlength="50" name="txtBlockNo" class="textfield" value="<?php echo "{$BlockNo}" ?>"/>
						</div>
					</td>
				</tr>						
				<tr>
					<td class="form_sec span4">Name</td>
					<td>
						<input type="text" maxlength="100" name="txtBlockName" class="textfield" style="width:250px;" value="<?php echo "{$BlockName}" ?>"/>
					</td>
				</tr>						
				<tr>
					<td class="form_sec span4">Type</td>
					<td>
						<select name="ddlBlockType">
							<option value="Classroom" <?php if($BlockType == "Classroom") echo "selected"; ?>>Classroom</option>
							<option value="Laboratory" <?php if($BlockType == "Laboratory") echo "selected"; ?>>Laboratory</option>
						</select>
					</td>
				</tr>						
				<tr>
					<td class="form_sec span4">Capacity</td>
					<td>
						<input type="text" maxlength="2" name="txtBlockCapacity" class="textfield" value="<?php echo "{$BlockCapacity}" ?>"/>
					</td>
				</tr>
				<tr>
					<td class="form_sec span4">Active</td>
					<td>
							<input type="checkbox" name="chkActive" class="checked" <?php echo ($Active == '1' ? 'checked' : ''); ?>/>
					</td>
				</tr>
			</table>
		</div>
	</div>
</form>

