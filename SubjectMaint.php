
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
		
		if ($_POST['txtSubjectID'] == "I") {
			$sql = "Insert into tblsubjectmaster ( SubjectName, PaperType, Active, created_by, created_on, updated_by, Updated_on) Values ( ?, ?, 1, 'Admin', CURRENT_TIMESTAMP, 'Admin', CURRENT_TIMESTAMP)";
			$stmt = $mysqli->prepare($sql);
			$stmt->bind_param('ss', $_POST['txtSubjectName'], $_POST['ddlPaperType']);
		}
		else {
			$sql = "UPDATE  tblsubjectmaster
						Set SubjectName = ?
							,PaperType = ?
							,Active = ?
							,updated_by = 'Admin'
							,updated_on = CURRENT_TIMESTAMP
						Where SubjectID = ?";
				//echo $sql;
				$stmt = $mysqli->prepare($sql);
				$stmt->bind_param('ssii', $_POST['txtSubjectName'], $_POST['ddlPaperType'], $tmpchkViewEnabled , $_POST['txtSubjectID'] );

				}
		
		// execute the update statement
		if($stmt->execute()){
			header('Location: SubjectListMain.php?'); 
			// close the prepared statement
		}else{
			echo $mysqli->error;
			die("Unable to update.");
		}
	}
else 
	{
		if ($_GET['SubjectID'] == "I") {
			$sql = "SELECT 'I' as SubectID, '' as SubjectName, 'Select ' as PaperType, '0' as  Active " ;
		}
		Else
		{  
			$sql = " SELECT SubjectID, SubjectName, PaperType, COALESCE(Active, 0) as ChkViewEnabled FROM tblsubjectmaster Where SubjectID = " . $_GET['SubjectID']   ;
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

<form action="SubjectMaintMain.php?SubjectID=<?php echo $_GET['SubjectID']; ?>" method="post">
	<br /><br />
	<h3 class="page-title" style="margin-left:5%">Subject Maintenance</h3>
	<div class="row-fluid">
		<div class="v_detail" style="margin-left:5%">
			<table cellpadding="10" cellspacing="0" border="0" width="50%" class="tab_split">
				<tr>
					<td class="form_sec span4">&nbsp;</td>
					<td>
						<div class="span10">
							<input type="hidden" name="txtSubjectID" value="<?php echo $_GET['SubjectID'] ?>" />
							<?php 
							if(($_SESSION["ReadAccess"] == "Yes") && ($_SESSION["WriteAccess"] == "Yes")){
								echo "<input type='submit' name='btnUpdate' value='Save' title='Update' class='btn btn-mini btn-success' />";
							}
							?>
							<a href="SubjectListMain.php" class="btn btn-mini btn-warning">Cancel</a>
						</div>
					</td>								
				</tr>
				<tr>
					<td class="form_sec span4">Name</td>
					<td>
						<input type="text" maxlength="100" name="txtSubjectName" class="textfield" style="width:300px;" value="<?php echo "{$SubjectName}" ?>"/>
					</td>
				</tr>						
				<tr>
					<td class="form_sec span4">Type</td>
					<td>
						<select name="ddlPaperType" style="width:120px;">
							<option value="Regular" <?php if($PaperType == "Regular") echo "selected"; ?>>Regular</option>
							<option value="Online" <?php if($PaperType == "Online") echo "selected"; ?>>Online</option>
						</select>
					</td>
				</tr>						
			</table>
		</div>
	</div>
</form>

