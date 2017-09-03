
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
		
		if ($_POST['txtSeatTypeId'] == "I") {
			$sql = "Insert into tblseattype ( SeatType ) Values ( ?)";
			$stmt = $mysqli->prepare($sql);
			$stmt->bind_param('s', $_POST['txtSeatType']);
		}
		else {
			$sql = "UPDATE tblseattype
						Set SeatType = ?
						Where SeatTypeId = ?";
				//echo $sql;
				$stmt = $mysqli->prepare($sql);
				$stmt->bind_param('si', $_POST['txtSeatType'], $_POST['txtSeatTypeId'] );

				}
		
		// execute the update statement
		if($stmt->execute()){
			header('Location: SeatTypeMain.php?'); 
			// close the prepared statement
		}else{
			echo $mysqli->error;
			die("Unable to update.");
		}
	}
else 
	{
		if ($_GET['SeatTypeId'] == "I") {
			$sql = "SELECT 'I' as SeatTypeId, '' as SeatType " ;
		}
		Else
		{  
			$sql = " SELECT SeatTypeId, SeatType FROM tblseattype Where SeatTypeId = " . $_GET['SeatTypeId']   ;
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

<form action="SeatTypeMaintMain.php?RoleID=<?php echo $_GET['SeatTypeId']; ?>" method="post">
	<br /><br />
	<h3 class="page-title" style="margin-left:5%">Seat Type Maintenance</h3>
	<div class="row-fluid">
		<div class="v_detail" style="margin-left:5%">
			<table cellpadding="10" cellspacing="0" border="0" width="50%" class="tab_split">
				<tr>
					<td class="form_sec span4">&nbsp;</td>
					<td>
						<div class="span10">
							<input type="hidden" name="txtSeatTypeId" value="<?php echo $_GET['SeatTypeId'] ?>" />
							<?php 
							if(($_SESSION["ReadAccess"] == "Yes") && ($_SESSION["WriteAccess"] == "Yes")){
								echo "<input type='submit' name='btnUpdate' value='Save' title='Update' class='btn btn-mini btn-success' />";
							}
							?>
							<a href="SeatTypeMain.php" class="btn btn-mini btn-warning">Cancel</a>
						</div>
					</td>								
				</tr>
				<tr>
					<td class="form_sec span4">Seat Type</td>
					<td>
						<input type="text" maxlength="100" name="txtSeatType" class="textfield" style="width:300px;" value="<?php echo "{$SeatType}" ?>"/>
					</td>
				</tr>						
			</table>
		</div>
	</div>
</form>

