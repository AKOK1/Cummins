
<?php
//include database connection
include 'db/db_connect.php';
 
// if the form was submitted/posted, update the record
 if($_POST)
	{
			if (isset($_POST['chkActive'])) {
				$tmpchkViewEnabled = '1';
			}
			else
				$tmpchkViewEnabled = '0';
		
		if ($_POST['txtRoleID'] == "I") {
			$sql = "Insert into tblrolemaster ( RoleName, created_by, created_on, updated_by, Updated_on) 
					Values ( ?, 'Admin', CURRENT_TIMESTAMP, 'Admin', CURRENT_TIMESTAMP)";
			$stmt = $mysqli->prepare($sql);
			$stmt->bind_param('s', $_POST['txtRoleName']);
		}
		else {
			$sql = "UPDATE  tblrolemaster
						Set RoleName = ?
							,updated_by = 'Admin'
							,updated_on = CURRENT_TIMESTAMP
						Where RoleID = ?";
				//echo $sql;
				$stmt = $mysqli->prepare($sql);
				$stmt->bind_param('si', $_POST['txtRoleName'], $_POST['txtRoleID'] );

				}
		
		// execute the update statement
		if($stmt->execute()){
			header('Location: RoleListMain.php?'); 
			// close the prepared statement
		}else{
			echo $mysqli->error;
			die("Unable to update.");
		}
	}
else 
	{
		if ($_GET['RoleID'] == "I") {
			$sql = "SELECT 'I' as RoleID, '' as RoleName" ;
		}
		Else
		{  
			$sql = " SELECT RoleID, RoleName FROM tblrolemaster Where RoleID = " . $_GET['RoleID']   ;
		} 

		// execute the sql query
		$result = $mysqli->query( $sql );
		$row = $result->fetch_assoc();
		extract($row);
		 
		//disconnect from database
		$result->free();
		$mysqli->close();
	}
?>

<form action="RoleMaintMain.php?RoleID=<?php echo $_GET['RoleID']; ?>" method="post">
	<br /><br />
	<h3 class="page-title" style="margin-left:5%">Role Maintenance</h3>
	<div class="row-fluid">
		<div class="v_detail" style="margin-left:5%">
			<table cellpadding="10" cellspacing="0" border="0" width="50%" class="tab_split">
				<tr>
					<td class="form_sec span4">&nbsp;</td>
					<td>
						<div class="span10">
							<input type="hidden" name="txtRoleID" value="<?php echo $_GET['RoleID'] ?>" />
							<?php 
							if(($_SESSION["ReadAccess"] == "Yes") && ($_SESSION["WriteAccess"] == "Yes")){
								echo "<input type='submit' name='btnUpdate' value='Save' title='Update' class='btn btn-mini btn-success' />";
							}
							?>
							<a href="RoleListMain.php" class="btn btn-mini btn-warning">Cancel</a>
						</div>
					</td>								
				</tr>
				<tr>
					<td class="form_sec span4">Name</td>
					<td>
						<input type="text" maxlength="100" name="txtRoleName" class="textfield" style="width:300px;" value="<?php echo "{$RoleName}" ?>"/>
					</td>
				</tr>						
			</table>
		</div>
	</div>
</form>

