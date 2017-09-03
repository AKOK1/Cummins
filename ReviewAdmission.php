
<?php

//include database connection
include 'db/db_connect.php';
 
// if the form was submitted/posted, update the record
 if($_POST)
	{
		if ((isset($_POST['btnYearDown'])) || ($_POST['btnYearDown']) )  {
			$sql = "Update tblstdadm Set AdmConf = NULL,stdstatus = 'YD', stdremark  = ?  where StdAdmID = ?";
		}
		if ($_POST['btnDrop']) {
			$sql = "Update tblstdadm Set AdmConf = NULL,stdstatus = 'D', stdremark = ?  where StdAdmID = ?";
		}
		if ($_POST['btnCancel']) {
			$sql = "Update tblstdadm Set AdmConf = NULL,stdstatus = 'C', stdremark = ?  where StdAdmID = ?";
		}
		if ($_POST['btnDT1']) {
			$sql = "Update tblstdadm Set AdmConf = NULL,stdstatus = 'DT1', stdremark = ?  where StdAdmID = ?";
		}
		if ($_POST['btnDT2']) {
			$sql = "Update tblstdadm Set AdmConf = NULL,stdstatus = 'DT2', stdremark = ?  where StdAdmID = ?";
		}
		if ($_POST['btnProv']) {
			$sql = "Update tblstdadm Set AdmConf = 1,stdstatus = 'P', stdremark = ?  where StdAdmID = ?";
		}
		if ($_POST['btnReg']) {
			$sql = "Update tblstdadm Set AdmConf = 1,stdstatus = 'R', stdremark = ?  where StdAdmID = ?";
		}

		//echo $_POST['txtStdAdmID'] . "<br/>";
		//echo $_POST['txtRemark'] . "<br/>";
		
		include 'db/db_connect.php';
		$stmt = $mysqli->prepare($sql);
		$stmt->bind_param('si', $_POST['txtRemark'], $_POST['txtStdAdmID'] );
		if($stmt->execute()){
			header('Location: StdListCurYearMain.php?'); 
		}
		else {
			echo $mysqli->error;
			die("Unable to update.");
		}
	}
else 
	{
			$sql = " SELECT CONCAT(Surname, ' ', Firstname, ' ', FatherName) AS StdName, CNUM, `Year`, SA.shift, `Div`, DeptName, stdremark as Remark
				FROM tblstdadm SA
				INNER JOIN tblstudent S ON SA.StdID = S.StdId
				INNER JOIN tbldepartmentmaster D ON SA.Dept = D.DeptID
				WHERE StdAdmID = " . $_GET['StdAdmID']   ;
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

<form action="ReviewAdmission.php?StdAdmID=<?php echo $_Post['txtStdAdmID']; ?>" method="post">
	<br /><br />
	<h3 class="page-title" style="margin-left:5%">Review Admission</h3>
	<div class="row-fluid">
		<div class="v_detail" style="margin-left:5%">
			<table cellpadding="10" cellspacing="0" border="0" width="50%" class="tab_split">
				<tr>
					<td class="form_sec span4">&nbsp;</td>
					<td>
						<div class="span10">
							<input type="hidden" name="txtStdAdmID" value="<?php echo $_GET['StdAdmID'] ?>" />
							<input type="submit" name="btnYearDown" value="Year Down" title="Year Down" class="btn btn-mini btn-success" />
							<input type="submit" name="btnDrop" value="Drop" title="Drop" class="btn btn-mini btn-success" />
							<input type="submit" name="btnCancel" value="Cancel Admission" title="Cancel Admission" class="btn btn-mini btn-success" /><br/>
							<input type="submit" name="btnDT1" value="Detained Term I" title="Detained Term I" class="btn btn-mini btn-success" />
							<input type="submit" name="btnDT2" value="Detained Term II" title="Detained Term II" class="btn btn-mini btn-success" /><br/>
							<input type="submit" name="btnProv" value="Provisional" title="Provisional" class="btn btn-mini btn-success" />
							<input type="submit" name="btnReg" value="Regular" title="Regular" class="btn btn-mini btn-success" /><br/><br/>
							<a href="StdListCurYearMain.php" class="btn btn-mini btn-warning">Cancel</a>
						</div>
					</td>								
				</tr>
				<tr>
					<td class="form_sec span4">Name</td>
					<td><?php echo "{$StdName}" ?></td>
				</tr>						
				<tr>
					<td class="form_sec span4">CNUM</td>
					<td><?php echo "{$CNUM}" ?></td>
				</tr>						
				<tr>
					<td class="form_sec span4">Year</td>
					<td><?php echo "{$Year}" ?></td>
				</tr>						
				<tr>
					<td class="form_sec span4">Shift</td>
					<td><?php echo "{$shift}" ?></td>
				</tr>						
				<tr>
					<td class="form_sec span4">Division</td>
					<td><?php echo "{$Div}" ?></td>
				</tr>						
				<tr>
					<td class="form_sec span4">Department</td>
					<td><?php echo "{$DeptName}" ?></td>
				</tr>						
				<tr>
					<td class="form_sec span4">Remark</td>
					<td>
						<input type="text" maxlength="100" name="txtRemark" class="textfield" style="width:300px;" value="<?php echo "{$Remark}" ?>"/>
					</td>
				</tr>						
			</table>
		</div>
	</div>
</form>

