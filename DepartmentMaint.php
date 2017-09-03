<?php
//include database connection
include 'db/db_connect.php';
 
// if the form was submitted/posted, update the record
 if($_POST)
	{
			if (isset($_POST['chkTeachingYesNO'])) {
				$tmpchkTeachingYesNO = '1';
			}
			else
				$tmpchkTeachingYesNO = '0';
		
		if ($_POST['txtDeptID'] == "I") {
			$sql = "Insert into tbldepartmentmaster ( DeptName, DeptUnivName, created_by, created_on, updated_by, Updated_on,HOD,Teaching) Values ( ?, ?,'Admin', CURRENT_TIMESTAMP, 'Admin', CURRENT_TIMESTAMP,?,?)";
			$stmt = $mysqli->prepare($sql);
			$stmt->bind_param('ssis', $_POST['txtDeptName'], $_POST['txtDeptUnivName'], $_POST['ddlHOD'],$tmpchkTeachingYesNO);
		}
		else {
			$sql = "UPDATE  tbldepartmentmaster
						Set  DeptName = ?
							,DeptUnivName = ?
							,HOD = ?
							,Teaching = ?
							,updated_by = 'Admin'
							,updated_on = CURRENT_TIMESTAMP
						Where DeptID = ?";
				//echo $sql;
				$stmt = $mysqli->prepare($sql);
				//$stmt->bind_param('ssisss', $_POST['txtDeptName'], $_POST['txtDeptUnivName'],$_POST['ddlHOD'],$tmpchkViewEnabled , $_POST['txtDeptID'],$_POST['chkTeachingYesNO'] );
                $stmt->bind_param('ssiii', $_POST['txtDeptName'], $_POST['txtDeptUnivName'],$_POST['ddlHOD'],$tmpchkTeachingYesNO, $_POST['txtDeptID']);

				}
		
		// execute the update statement
		if($stmt->execute()){
			header('Location: DepartmentListMain.php?'); 
			// close the prepared statement
		}else{
			echo $mysqli->error;
			die("Unable to update.");
		}
	}
else 
	{
		if ($_GET['DeptID'] == "I") {
			$sql = "SELECT 'I' as DeptID, '' as DeptName, '' as DeptUnivName, '0' as  Teaching, 'Select ' as HOD " ;
		}
		Else
		{  
			$sql = " SELECT DeptID, DeptName, DeptUnivName, COALESCE(Teaching, 0) as Teaching, HOD FROM tbldepartmentmaster Where DeptID = " . $_GET['DeptID'];
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

<form action="DepartmentMaintMain.php?DeptID=<?php echo $_GET['DeptID']; ?>" method="post">
	<br /><br />
	<h3 class="page-title" style="margin-left:5%">Department Maintenance</h3>
	<div class="row-fluid">
		<div class="v_detail" style="margin-left:5%">
			<table cellpadding="10" cellspacing="0" border="0" width="50%" class="tab_split">
				<tr>
					<td class="form_sec span4">&nbsp;</td>
					<td>
						<div class="span10">
							<input type="hidden" name="txtDeptID" value="<?php echo $_GET['DeptID'] ?>" />
							<?php 
							if(($_SESSION["ReadAccess"] == "Yes") && ($_SESSION["WriteAccess"] == "Yes")){
								echo "<input type='submit' name='btnUpdate' value='Save' title='Update' class='btn btn-mini btn-success' />";
							}
							?>
							<a href="DepartmentListMain.php" class="btn btn-mini btn-warning">Cancel</a>
						</div>
					</td>								
				</tr>
				<tr>
					<td class="form_sec span4">Department Name</td>
					<td>
						<input type="text" maxlength="100" name="txtDeptName" class="textfield" required  style="width:300px;" value="<?php echo "{$DeptName}" ?>"/>
					</td>
				</tr>						
				<tr>
					<td class="form_sec span4">Department University Name</td>
					<td>
						<input type="text" maxlength="100" name="txtDeptUnivName" class="textfield" required  style="width:300px;" value="<?php echo "{$DeptUnivName}" ?>"/>
					</td>
				</tr>
			     <tr>
					<td class="form_sec span4">HOD</td>
					<td>
						<?php
							include 'db/db_connect.php';
							echo "<select name='ddlHOD' style='width:220px'><option value=''>Select HOD</option>";
							$query = "SELECT userID, Concat(FirstName,' ',LastName) as HODName FROM tbluser";
									//echo $query;
									$result = $mysqli->query( $query );
									$num_results = $result->num_rows;
									if( $num_results ){
											while( $row = $result->fetch_assoc() ){
												extract($row);
												if($userID == $HOD){
													echo "<option value={$userID} selected>{$HODName}</option>"; 
												}
												else{
													echo "<option value={$userID}>{$HODName}</option>"; 
												}
											}										
										}
							echo "</select>";
							?>
						</td>
				<tr>
				<tr>
					<td class="form_sec span4">Teaching ? </td>
					<td>
							<input type="checkbox" name="chkTeachingYesNO" class="checked" <?php echo ($Teaching == '1' ? 'checked' : ''); ?>/>
					</td>
				</tr>				
			</table>
		</div>
	</div>
</form>

