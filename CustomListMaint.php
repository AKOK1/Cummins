
<?php
//include database connection
include 'db/db_connect.php';
 
// if the form was submitted/posted, update the record
 if($_POST)
	{
		
		if ($_POST['txtListID'] == "I") {
			$sql = "Insert into tbllistmster ( ListName, ListType) Values ( ?, ?)";
			$stmt = $mysqli->prepare($sql);
			$stmt->bind_param('ss', $_POST['txtListName'], $_POST['ddlListType']);
		}
		else {
			$sql = "UPDATE  tbllistmster
						Set ListName = ?
							,ListType = ?
						Where ListID = ?";
				//echo $sql;
				$stmt = $mysqli->prepare($sql);
				$stmt->bind_param('ssi', $_POST['txtListName'], $_POST['ddlListType'],$_POST['txtListID']);

				}
		
		// execute the update statement
		if($stmt->execute()){
			header('Location: CustomListMain.php?'); 
			// close the prepared statement
		}else{
			echo $mysqli->error;
			die("Unable to update.");
		}
	}
else 
	{
		if ($_GET['ListID'] == "I") {
			$sql = "SELECT 'I' as ListID, '' as ListName, 'Select ' as ListType" ;
		}
		Else
		{  
			$sql = " SELECT ListID, ListName, ListType FROM tbllistmster Where ListID = " . $_GET['ListID']   ;
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

<form action="CustomListMaintMain.php?ListID=<?php echo $_GET['ListID']; ?>" method="post">
	<br /><br />
	<h3 class="page-title" style="margin-left:5%">List Maintenance</h3>
	<div class="row-fluid">
		<div class="v_detail" style="margin-left:5%">
			<table cellpadding="10" cellspacing="0" border="0" width="50%" class="tab_split">
				<tr>
					<td class="form_sec span4">&nbsp;</td>
					<td>
						<div class="span10">
							<input type="hidden" name="txtListID" value="<?php echo $_GET['ListID'] ?>" />
							<input type="submit" name="btnUpdate" value="Save" title="Update" class="btn btn-mini btn-success" />
							<a href="CustomListMain.php" class="btn btn-mini btn-warning">Cancel</a>
						</div>
					</td>								
				</tr>
				<tr>
					<td class="form_sec span4">Name</td>
					<td>
						<input type="text" maxlength="100" name="txtListName" class="textfield" style="width:300px;" value="<?php echo "{$ListName}" ?>"/>
					</td>
				</tr>						
				<tr>
					<td class="form_sec span4">Type</td>
					<td>
						<select name="ddlListType" style="width:120px;">
							<option value="User" <?php if($ListType == "User") echo "selected"; ?>>User</option>
						</select>
					</td>
				</tr>						
			</table>
		</div>
	</div>
</form>

