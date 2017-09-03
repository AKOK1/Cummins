<?php  include("MasterPage.php");?>

<?php
//include database connection
include 'db/db_connect.php';
 
// if the form was submitted/posted, update the record
 if($_POST)
	{
		if ($_GET['userID'] = "I") {
			$sql = "Insert into tblUsers ( userLogin, userPassword, userGroup, userName, userMobile, userDepartment, created_by, created_on, updated_by, Updated_on) Values ( ?, ?, ?, ?, ?, ?, 'Admin', CURRENT_TIMESTAMP, 'Admin', CURRENT_TIMESTAMP)";

			$stmt = $mysqli->prepare($sql);
			$stmt->bind_param('ssssss', $_POST['txtLogin'], $_POST['txtPassword'], $_POST['ddlUserGroup'], $_POST['txtUserName'],
				$_POST['txtMobile'], $_POST['ddlUserDept'] );
		}
		else {
			$sql = "UPDATE  tblUsers
						Set userLogin = ?
							,userPassword = ?
							,userGroup = ?
							,userName = ?
							,userMobile = ?
							,userDepartment = ?
							,updated_by = 'Admin'
							,updated_on = CURRENT_TIMESTAMP
						Where userID = ?";

				$stmt = $mysqli->prepare($sql);
				$stmt->bind_param('ssssssi', $_POST['txtLogin'], $_POST['txtPassword'], $_POST['ddlUserGroup'], $_POST['txtUserName'],
					$_POST['txtMobile'], $_POST['ddlUserDept'], $_POST['txtuserID'] );
		}
		
	
		// execute the update statement
		if($stmt->execute()){
			header('Location: UserList.php?'); 
			// close the prepared statement
		}else{
			die("Unable to update.");
		}
	}
else 
	{
		if ($_GET['userID'] = "I") {
			echo 'if'; 
			$sql = "SELECT 'I' as UserID, '' as userLogin, '' as userPassword, 'ClientUser' as userGroup, ' ' as  userName, '' as userMobile, 'Select ' as userDepartment FROM tblUsers" ;
		}
		Else
		{
			echo 'else'; 
			$sql = " SELECT userID, userLogin, userPassword, userGroup, userName, userMobile, userDepartment 
					 FROM tblUsers Where userID = " . $_GET['userID']   ;
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
 
<form action="UsersMaint.php?userID=<?php echo $_GET['userID']; ?>" method="post">
	<br /><br />
	<h3 class="page-title" style="margin-left:5%">User Maintenance</h3>
	<div class="row-fluid">
		<div class="v_detail" style="margin-left:5%">
			<table cellpadding="10" cellspacing="0" border="0" width="50%" class="tab_split">
				<tr>
					<td class="form_sec span4">&nbsp;</td>
					<td>
						<div class="span10">
							<input type="hidden" name="txtuserID" value="<?php echo "{$userID}" ?>" />
							<input type="submit" name="btnUpdate" value="Save" title="Update" class="btn btn-mini btn-success" />
							<a href="UserList.php" class="btn btn-mini btn-warning">Cancel</a>
						</div>
					</td>								
				</tr>
				<tr>
					<td class="form_sec span4">Email (Login ID)</td><td>
						<div class="span10">
							<input type="text" maxlength="100" name="txtLogin" class="textfield" value="<?php echo "{$userLogin}" ?>"/>
						</div>
					</td>
				</tr>						
				<tr>
					<td class="form_sec span4">Password</td>
					<td>
						<input type="text" maxlength="20" name="txtPassword" class="textfield" style="width:150px;" value="<?php echo "{$userPassword}" ?>"/>
					</td>
				</tr>						
				<tr>
					<td class="form_sec span4">User Group</td>
					<td>
						<select name="ddlUserGroup">
							<option value="ClientAdmin" <?php if($userGroup == "ClientAdmin") echo "selected"; ?>>ClientAdmin</option>
							<option value="ClientUser" <?php if($userGroup == "ClientUser") echo "selected"; ?>>ClientUser</option>
						</select>
						<input id="chkActiveEdit" type="checkbox" checked="checked"/>
					</td>
				</tr>						
				<tr>
					<td class="form_sec span4">Full Name</td>
					<td>
						<input type="text" maxlength="50" name="txtUserName" class="textfield" value="<?php echo "{$userName}" ?>"/>
					</td>
				</tr>
				<tr>
					<td class="form_sec span4">Mobile No.</td>
					<td>
						<input type="text" maxlength="10" name="txtMobile" class="textfield" value="<?php echo "{$userMobile}" ?>"/>
					</td>
				</tr>
				<tr>
				<td class="form_sec span4">Department</td>
					<td>
						<select name="ddlUserDept">
							<option value="Select " <?php if($userDepartment == "Select ") echo "selected"; ?>>Select</option>
							<option value="Mechanical" <?php if($userDepartment == "Mechanical") echo "selected"; ?>>Mechanical</option>
							<option value="Electrical" <?php if($userDepartment == "Electrical") echo "selected"; ?>>Electrical</option>
							<option value="Computers" <?php if($userDepartment == "Computers") echo "selected"; ?>>Computers</option>
						</select>
					</td>
				</tr>						
			</table>
		</div>
	</div>
</form>

