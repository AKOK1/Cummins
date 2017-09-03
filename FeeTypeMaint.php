
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
		
		if ($_POST['txtFeeTypeID'] == "I") {
			$sql = "Insert into tblfeetype ( FeeType, FeeOrder ) Values ( ?, ?)";
			$stmt = $mysqli->prepare($sql);
			$stmt->bind_param('si', $_POST['txtFeeType'], $_POST['txtFeeOrder']);
		}
		else {
			$sql = "UPDATE  tblfeetype
						Set FeeType = ?, FeeOrder = ?
						Where FeeTypeID = ?";
				//echo $sql;
				$stmt = $mysqli->prepare($sql);
				$stmt->bind_param('sii', $_POST['txtFeeType'], $_POST['txtFeeOrder'], $_POST['txtFeeTypeID'] );

				}
		
		// execute the update statement
		if($stmt->execute()){
			header('Location: FeeTypeMain.php?'); 
			// close the prepared statement
		}else{
			echo $mysqli->error;
			die("Unable to update.");
		}
	}
else 
	{
		if ($_GET['FeeTypeID'] == "I") {
			$sql = "SELECT 'I' as FeeTypeID, '' as FeeType, '' as FeeOrder " ;
		}
		Else
		{  
			$sql = " SELECT FeeTypeID, FeeType, coalesce(FeeOrder, 0) as FeeOrder FROM tblfeetype Where FeeTypeID = " . $_GET['FeeTypeID']   ;
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

<form action="FeeTypeMaintMain.php?RoleID=<?php echo $_GET['FeeTypeID']; ?>" method="post">
	<br /><br />
	<h3 class="page-title" style="margin-left:5%">Fee Type Maintenance</h3>
	<div class="row-fluid">
		<div class="v_detail" style="margin-left:5%">
			<table cellpadding="10" cellspacing="0" border="0" width="50%" class="tab_split">
				<tr>
					<td class="form_sec span4">&nbsp;</td>
					<td>
						<div class="span10">
							<input type="hidden" name="txtFeeTypeID" value="<?php echo $_GET['FeeTypeID'] ?>" />
							<?php 
							if(($_SESSION["ReadAccess"] == "Yes") && ($_SESSION["WriteAccess"] == "Yes")){
								echo "<input type='submit' name='btnUpdate' value='Save' title='Update' class='btn btn-mini btn-success' />";
							}
							?>
							<a href="FeeTypeMain.php" class="btn btn-mini btn-warning">Cancel</a>
						</div>
					</td>								
				</tr>
				<tr>
					<td class="form_sec span4">Fee Type</td>
					<td>
						<input type="text" maxlength="100" name="txtFeeType" class="textfield" style="width:300px;" value="<?php echo "{$FeeType}" ?>"/>
					</td>
				</tr>						
				<tr>
					<td class="form_sec span4">Order</td>
					<td>
						<input type="text" maxlength="2" name="txtFeeOrder" class="textfield" style="width:30px;" value="<?php echo "{$FeeOrder}" ?>"/>
					</td>
				</tr>						
			</table>
		</div>
	</div>
</form>

