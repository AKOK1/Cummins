<?php
if(!isset($_SESSION)){
	session_start();
}
//include database connection
include 'db/db_connect.php';
 // if the form was submitted/posted, update the record
 if($_POST)
	{
		$selecteddepts = $_POST['chkdept'];
		
		$dt = '';
		if($_POST['txtAdhocenddate'] != ''){
			$dt = date('m/d/Y', strtotime($_POST['txtAdhocenddate']));
		}
			if($_SESSION["usertype"] == "SuperAdmin"){
				$deptval = $_POST["ddlDepartment"];
				$roleval = $_POST["ddlUserType"];
			}
			else{
				if($_SESSION["isteaching"] == 1){
					$deptval = $_SESSION["SESSUserDept"];
					$roleval = $_SESSION["thisusertype"];
				}
				else{
					$deptval = $_POST['ddlDepartment'];
					$roleval = $_POST['ddlUserType'];
				}
			}

		if ($_GET['userID'] == "I") {
			$sql = "Insert into tbluser ( FirstName,LastName, LoginName,Email, Designation, ContactNumber,Gender, Department, 
						userType, Adhocenddate, userpassword,usertypereal,currstatus, userprofile,usertitle) 
					Values ( ?, ?, ?, ?, ?, ?, ?, ? ,?, ?, ?, ?, ? ,?, ?)";

			$stmt = $mysqli->prepare($sql);
			$stmt->bind_param('sssssssssssssss', $_POST['txtFirstName'], $_POST['txtLastName'], 
			$_POST['txtLoginName'],	$_POST['txtEmail'], $_POST['ddlDesignation'], 
										$_POST['txtContactNumber'], $_POST['ddlGender'], $deptval,
										$roleval, $dt, $_POST['txtPassword'], 
										$_POST['ddlusertypereal'], $_POST['ddlcurrstatus'], $_POST['ddlprofile'], $_POST['ddlusertitle']);
			// execute the insert statement
			$stmt->execute();
			// get the lastest inserted id
			//include database connection
			include 'db/db_connect.php';
			$sql = " SELECT max(userID) as thisuserid FROM tbluser";
			// execute the sql query
			$result = $mysqli->query( $sql );
			$row = $result->fetch_assoc();
			extract($row);
			$_SESSION["thisuserid"] = $thisuserid;
			
			//now insert this into tbluserdept
			$size = count($selecteddepts);
			//include database connection
			include 'db/db_connect.php';
			for($i = 0 ; $i < $size ; $i++){
				if($selecteddepts[$i] != ''){
					$sql = "Insert into tbluserdept (userid,deptid) Values ( ?, ?)";						
					$stmt = $mysqli->prepare($sql);
					$stmt->bind_param('ii', $_SESSION["thisuserid"],$selecteddepts[$i]);
					// execute the update statement
					$stmt->execute();
				}
			}
			header('Location: UserListMain.php?'); 
		}
		else {
			$sql = "UPDATE  tbluser
						Set FirstName = ?
							,LastName = ?
							,LoginName = ?
							,Email = ?
							,Designation = ?
							,ContactNumber = ?
							,Gender = ?
							,Department = ?
							,userType = ?
							,Adhocenddate = ?
							,userpassword = ?
							,usertypereal = ?
							,currstatus = ?
							,userprofile = ?
							,usertitle =?
						Where userID = ?";
						//include database connection
				include 'db/db_connect.php';
				
				$stmt = $mysqli->prepare($sql);
				$stmt->bind_param('sssssssssssssssi', $_POST['txtFirstName'], $_POST['txtLastName'], 
													   $_POST['txtLoginName'], $_POST['txtEmail'], 
											 		   $_POST['ddlDesignation'],$_POST['txtContactNumber'], $_POST['ddlGender'], 
													   $deptval,$roleval, $dt,
													   $_POST['txtPassword'], $_POST['ddlusertypereal'], 
													   $_POST['ddlcurrstatus'], $_POST['ddlprofile'], $_POST['ddlusertitle'],$_GET['userID']);
				$stmt->execute();				
				//now insert this into tbluserdept
				//include database connection
				include 'db/db_connect.php';
				$size = count($selecteddepts);
				$sql = "delete from tbluserdept where userid = " . $_GET['userID'];
				$stmt = $mysqli->prepare($sql);
				$stmt->execute();
				for($i = 0 ; $i < $size ; $i++){
					if($selecteddepts[$i] != ''){
						$sql = "Insert into tbluserdept (userid,deptid) Values (?, ?)";						
						$stmt = $mysqli->prepare($sql);
						$stmt->bind_param('ii', $_GET['userID'],$selecteddepts[$i]);
						// execute the update statement
						$stmt->execute();
					}
				}
				header('Location: UserListMain.php?'); 
		}
	}
else 
	{
		if ($_GET['userID'] == "I") {
			$sql = "SELECT 'I' as userID, '' as FirstName,'' as LastName, '' as LoginName ,
					'' as Email, '' as Designation,'' as ContactNumber,'' as Gender,'' as Department,'' as userType,
					'' as Adhocenddate, '' as userpassword,'' as usertypereal,'' as currstatus,'' as userprofile ,
					'Select' as usertitle FROM tbluser" ;
		}
		Else
		{
			$sql = " SELECT userID, FirstName, LastName,LoginName,Email,Designation,ContactNumber,Gender,Department,userType,
						DATE_FORMAT(str_to_date(Adhocenddate, '%m/%d/%Y'), '%d-%b-%Y') as Adhocenddate, userpassword,
						usertypereal,currstatus,userprofile,usertitle FROM tbluser Where userID = " . $_GET['userID']   ;
		} 
		// execute the sql query
		$result = $mysqli->query( $sql );
		$row = $result->fetch_assoc();
		extract($row);
		$_SESSION["thisusertype"] = $userType;
		//disconnect from database
		$result->free();
		$mysqli->close();
	}
?>
 
<form action="UserMaintMain.php?userID=<?php echo $_GET['userID']; ?>" method="post">
	<head>
		<script>
			$(function() {
				$('.DTEXDATE').datepicker({ dateFormat: 'dd-M-yy' });
			});
			</script>
	</head>
	<br /><br />
	<h3 class="page-title" style="margin-left:5%">User Maintenance</h3>
	<div class="row-fluid">
		<div class="v_detail" style="margin-left:5%;height:120%">
			<table cellpadding="10" cellspacing="0" border="0" width="50%" class="tab_split">
				<tr>
					<td class="form_sec span4">&nbsp;</td>
					<td>
						<div class="span10">
							<input type="hidden" name="txtuserID" value="<?php echo "{$userID}" ?>" />
							<?php 
							if(($_SESSION["ReadAccess"] == "Yes") && ($_SESSION["WriteAccess"] == "Yes")){
								echo "<input type='submit' name='btnUpdate' value='Save' title='Update' class='btn btn-mini btn-success' />";
							}
							?>
							<a href="UserListMain.php" class="btn btn-mini btn-warning">Cancel</a>
						</div>
					</td>								
				</tr>
				<tr>
					<td class="form_sec span4">Title</td><td>
						<select name="ddlusertitle">
							<option value="Select" <?php if($usertitle == "Select") echo "selected"; ?>>Select</option>
							<option value="Prof." <?php if($usertitle == "Prof.") echo "selected"; ?>>Prof.</option>
							<option value="Mrs." <?php if($usertitle == "Mrs.") echo "selected"; ?>>Mrs.</option>
							<option value="Dr." <?php if($usertitle == "Dr.") echo "selected"; ?>>Dr.</option>
							<option value="Mr." <?php if($usertitle == "Mr.") echo "selected"; ?>>Mr.</option>
							<option value="Dr. Prof." <?php if($usertitle == "Dr. Prof.") echo "selected"; ?>>Dr. Prof.</option>
						</select>
					</td>
				</tr>	
				<tr>
					<td class="form_sec span4">First Name</td><td>
						<div class="span10">
							<input type="text" maxlength="100" name="txtFirstName" class="textfield" value="<?php echo "{$FirstName}" ?>"/>
						</div>
					</td>
				</tr>						
				<tr>
					<td class="form_sec span4">Last Name</td><td>
						<div class="span10">
							<input type="text" maxlength="100" name="txtLastName" class="textfield" value="<?php echo "{$LastName}" ?>"/>
						</div>
					</td>
				</tr>						
				<tr>
					<td class="form_sec span4">Login Name</td><td>
						<div class="span10">
							<input type="text" maxlength="100" name="txtLoginName" class="textfield" value="<?php echo "{$LoginName}" ?>"/>
						</div>
					</td>
				</tr>						
				<tr>
					<td class="form_sec span4">Email</td><td>
						<div class="span10">
							<input type="text" maxlength="100" name="txtEmail" class="textfield" value="<?php echo "{$Email}" ?>"/>
						</div>
					</td>
				</tr>						
				<tr>
					<td class="form_sec span4">Designation</td>
					<td>
						<select name="ddlDesignation">
							<?php
							include 'db/db_connect.php';
							echo "<option value=Select>Select</option>"; 
							$sql = "SELECT DesigID,Designation as DesignationText FROM tbldesignationmaster;";
							$result1 = $mysqli->query( $sql );
							while( $row = $result1->fetch_assoc() ) {
							extract($row);
							 if($Designation == $DesigID){
									echo "<option value={$DesigID} selected>{$DesignationText}</option>"; 
								}
								else{
									echo "<option value={$DesigID}>{$DesignationText}</option>"; 
								}
							}
							?>
						</select>
					</td>
				</tr>								
				<tr>
					<td class="form_sec span4">Mobile No.</td>
					<td>
						<input type="text" maxlength="10" name="txtContactNumber" class="textfield" value="<?php echo "{$ContactNumber}" ?>"/>
					</td>
				</tr>
				<tr>
					<td class="form_sec span4">Department</td>
					<td>
							<?php
							if(!isset($_SESSION)){
								session_start();
							}
							echo "<select name='ddlDepartment' style='width:50%;margin-top:10px' ";
							if($_SESSION["usertype"] == "SuperAdmin"){
							}
							else{
								if($_SESSION["isteaching"] == 1){
									echo " disabled";
								}	
							}
							echo ">";
							include 'db/db_connect.php';
							$sql = "SELECT DeptID as MDeptID, DeptName as MDeptName 
							From tbldepartmentmaster";
							//echo $sql;
							$result1 = $mysqli->query( $sql );
							while( $row = $result1->fetch_assoc() ) {
							extract($row);
							 if ($Department == $MDeptName){
									echo "<option value={$MDeptName} selected>{$MDeptName}</option>"; 
								}
								else{
									echo "<option value={$MDeptName}>{$MDeptName}</option>"; 
								}
							}
							echo "</select>";
							?>						
						</br>
						<div id="divDepts">
							Select Departments for Open Electives:<br/>
							<?php
							include 'db/db_connect.php';
							$query2 = "SELECT dm.DeptID, DeptName AS Department2 ,
										COALESCE(ud.deptid,0) AS UserDeptID
										FROM tbldepartmentmaster dm
										LEFT OUTER JOIN tbluserdept ud ON dm.DeptID = ud.deptid 
										AND userid = " . $_GET['userID'] . "
										WHERE COALESCE(Teaching,0) = 1 ORDER BY dm.DeptID";
										//echo $query2;
									$result2 = $mysqli->query( $query2 );
									$num_results2 = $result2->num_rows;
									if( $num_results2 ){
										while( $row2 = $result2->fetch_assoc() ){
											extract($row2);
											echo "{$Department2}<input value='$DeptID' onclick='return deptcheck(this);' id='chkdept[]' name='chkdept[]' 
											class='checkbox-class' type='checkbox' " .
											($UserDeptID == $DeptID ?  'checked' : '') . 
											" />&nbsp;&nbsp;&nbsp;&nbsp;";
										}
									}
							?>
						</div>						
					</td>
				</tr>						
				<tr>
					<td class="form_sec span4">User Role</td>
					<td>
							<?php
							if(!isset($_SESSION)){
								session_start();
							}
							echo "<select name='ddlUserType'";
							if($_SESSION["usertype"] == "SuperAdmin"){
							}
							else{
								if($_SESSION["isteaching"] == 1){
									echo " disabled";
								}	
							}
							echo ">";
							include 'db/db_connect.php';
							echo "<option value=Select>Select</option>"; 
							if($_SESSION["usertype"] == "SuperAdmin")
								$sql = "SELECT RoleID, RoleName FROM tblrolemaster;";
							else
								$sql = "SELECT RoleID, RoleName FROM tblrolemaster WHERE RoleName <> 'SuperAdmin';";
								
							$result1 = $mysqli->query( $sql );
							while( $row = $result1->fetch_assoc() ) {
							extract($row);
							 if($userType == $RoleName){
									echo "<option value={$RoleName} selected>{$RoleName}</option>"; 
								}
								else{
									echo "<option value={$RoleName}>{$RoleName}</option>"; 
								}
							}
							echo "</select>";
							?>
					</td>
				</tr>						
				<tr>
					<td class="form_sec span4">Gender</td><td>
						<select name="ddlGender">
							<option value="F" <?php if($Gender == "F") echo "selected"; ?>>Female</option>
							<option value="M" <?php if($Gender == "M") echo "selected"; ?>>Male</option>
						</select>
					</td>
				</tr>						
				<tr>
					<td class="form_sec span4">Adhocenddate</td><td>
						<div class="span10">
							<input type="text" maxlength="100" name="txtAdhocenddate" class="textfield DTEXDATE" value="<?php echo "{$Adhocenddate}" ?>"/>
						</div>
					</td>
				</tr>						
				<tr>
					<td class="form_sec span4">Password</td><td>
						<div class="span10">
							<input type="text" maxlength="100" name="txtPassword" class="textfield" value="<?php echo "{$userpassword}" ?>"/>
						</div>
					</td>
				</tr>	
				<tr>
					<td class="form_sec span4">User Type</td><td>
						<select name="ddlusertypereal">
							<option value="Select" <?php if($usertypereal == "Select") echo "selected"; ?>>Select</option>
							<option value="Permanent Faculty" <?php if($usertypereal == "Permanent Faculty") echo "selected"; ?>>Permanent Faculty</option>
							<option value="Ad-hoc Faculty" <?php if($usertypereal == "Ad-hoc Faculty") echo "selected"; ?>>Ad-hoc Faculty</option>
							<option value="Visiting Faculty" <?php if($usertypereal == "Visiting Faculty") echo "selected"; ?>>Visiting Faculty</option>
							<option value="Staff" <?php if($usertypereal == "Staff") echo "selected"; ?>>Staff</option>
							<option value="TA" <?php if($usertypereal == "TA") echo "selected"; ?>>TA</option>
							<option value="Peon" <?php if($usertypereal == "Peon") echo "selected"; ?>>Peon</option>
						</select>
					</td>
				</tr>	
				<tr>
					<td class="form_sec span4">Current Status</td><td>
						<select name="ddlcurrstatus">
							<option value="Select" <?php if($currstatus == "Select") echo "selected"; ?>>Select</option>
							<option value="1" <?php if($currstatus == "1") echo "selected"; ?>>Active</option>
							<option value="0" <?php if($currstatus == "0") echo "selected"; ?>>In-Active</option>
						</select>
					</td>
				</tr>	
				<tr>
					<td class="form_sec span4">Faculty</td><td>
						<select name="ddlprofile">
							<option value="Select" <?php if($userprofile == "Select") echo "selected"; ?>>Select</option>
							<option value="Teaching" <?php if($userprofile == "Teaching") echo "selected"; ?>>Teaching</option>
							<option value="Non-Teaching" <?php if($userprofile == "Non-Teaching") echo "selected"; ?>>Non-Teaching</option>
						</select>
					</td>
				</tr>					
			</table>
		</div>
	</div>
</form>

