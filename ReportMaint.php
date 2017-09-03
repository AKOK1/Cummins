
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
				
		if ($_POST['txtreportId'] == "I") {
			$sql = "Insert into tblreport ( reportsql,colwidth, reportTitle,Active, created_by, created_on,
			updated_by, Updated_on) Values ( ?,?,?,?,'Admin', CURRENT_TIMESTAMP, 
			'Admin', CURRENT_TIMESTAMP)";
			$stmt = $mysqli->prepare($sql);
			$stmt->bind_param('sssi', $_POST['txtreportsql'],$_POST['txtcolwidth'], $_POST['txtrepTitle'],$tmpchkProfViewEnabled);
		}
		else {
			$sql = "UPDATE  tblreport
						Set  reportsql = ?
							,colwidth = ?
							,reportTitle = ?
							,Active = ?
							,updated_by = 'Admin'
							,updated_on = CURRENT_TIMESTAMP
						Where reportId = ?";
				//echo $sql;
				$stmt = $mysqli->prepare($sql);
				//$stmt->bind_param('ssisss', $_POST['txtDeptName'], $_POST['txtDeptUnivName'],$_POST['ddlHOD'],$tmpchkViewEnabled , $_POST['txtDeptID'],$_POST['chkTeachingYesNO'] );
                $stmt->bind_param('sssii', $_POST['txtreportsql'],$_POST['txtcolwidth'], $_POST['txtrepTitle'],$tmpchkProfViewEnabled, $_POST['txtreportId']);

				}
		
		// execute the update statement
		if($stmt->execute()){
			header('Location: ReportListMain.php?'); 
			// close the prepared statement
		}else{
			echo $mysqli->error;
			die("Unable to update.");
		}
	}
else 
	{
		if ($_GET['reportId'] == "I") {
			$sql = "SELECT 'I' as reportId, '' as reportsql, '' as colwidth, '' as  reportTitle,'0' as  Active" ;
		}
		Else
		{  
			$sql = " SELECT reportId, reportsql, colwidth, reportTitle,COALESCE(Active, 0) as Active
			 FROM tblreport Where reportId = " . $_GET['reportId'];
		} 
		echo $sql;
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

<form action="ReportMaintMain.php?reportId=<?php echo $_GET['reportId']; ?>" method="post">
	<br /><br />
	<h3 class="page-title" style="margin-left:5%">Report Maintenance</h3>
	<div class="row-fluid">
		<div class="v_detail" style="margin-left:5%">
			<table cellpadding="10" cellspacing="0" border="0" width="50%" class="tab_split">
				<tr>
					<td class="form_sec span4">&nbsp;</td>
					<td>
						<div class="span10">
							<input type="hidden" name="txtreportId" value="<?php echo $_GET['reportId'] ?>" />
							<input type="submit" name="btnUpdate" value="Save" title="Update" class="btn btn-mini btn-success" />
							<a href="ReportListMain.php" class="btn btn-mini btn-warning">Cancel</a>
						</div>
					</td>								
				</tr>
				<tr>
					<td class="form_sec span4">Sql</td>
					<td>
						<textarea rows="10" name="txtreportsql" style="width:400px" required><?php echo "{$reportsql}" ?></textarea>
					</td>
				</tr>						
				<tr>
					<td class="form_sec span4">Column Width</td>
					<td>
						<input type="text" name="txtcolwidth" class="textfield" required  style="width:300px;" value="<?php echo "{$colwidth}" ?>"/>
					</td>
				</tr>
				<tr>
					<td class="form_sec span4">Report Title</td>
					<td>
						<input type="text" name="txtrepTitle" class="textfield" required  style="width:300px;" value="<?php echo "{$reportTitle}" ?>"/>
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

