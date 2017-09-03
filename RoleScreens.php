<?php
//include database connection
include 'db/db_connect.php';
// if the form was submitted/posted, update the record
 if (isset($_POST['btnSave']))
{
	if (isset($_POST['txtScreenID']))
	{
			
		$ScreenIDs = $_POST['txtScreenID'];
		$ReadAccess = $_POST['ddlRead'];
		$WriteAccess = $_POST['ddlWrite'];
		$size = count($ScreenIDs);
		// echo $size  . "<br/>";
		// echo $ScreenIDs[0]  . "<br/>";
		// echo $ReadAccess[0]  . "<br/>";
		// echo $WriteAccess[0]  . "<br/>";
		// delete existing for this roleid!
		$sqlD = "Delete from tblrolescreens where RoleID = " . $_POST['ddlRole'] ;
		if ($mysqli->query($sqlD) === TRUE) {
		} 
		else {
			echo "Error updating record: " . $mysqli->error;
		}

		for($i = 0 ; $i < $size ; $i++){
			//now insert!
			$sql = "Insert into tblrolescreens ( RoleID, ScreenID, ReadAccess, WriteAccess, Created_by, Created_on, updated_by, Updated_on) 
				Values ( ?, ?, ?, ?, 'Admin', CURRENT_TIMESTAMP, 'Admin', CURRENT_TIMESTAMP)";
			$stmt = $mysqli->prepare($sql);
			$stmt->bind_param('iiss', $_POST['ddlRole'],$ScreenIDs[$i], $ReadAccess[$i], $WriteAccess[$i]);
			if($stmt->execute()){
				//header('Location: SubjectList.php?'); 
				$readval = 0;
				$writeval = 0;
			} else{
				echo $mysqli->error;
				//die("Unable to update.");
			}
		}
		
		echo "<script type='text/javascript'>window.onload = function()
						{
								document.getElementById('lblSuccess').style.display = 'block';
						}
						</script>";
	}
}
?>

<form name="myform" action="" method="post">
<head>
	   <link rel="stylesheet" href="css/jquery-ui.css">
	   <script src="js/jquery-1.10.2.js"></script>
       <script src="js/jquery-ui.js"></script>
	<script type="text/javascript" src="js/jquery.min.js"></script>
</head>
	<br /><br />
	<h3 class="page-title">Role Screen Access</h3>
	<h3 class="page-title" style="float:right;margin-top:-40px;"><a href="MainMenuMain.php">Back</a></h3>
	<input type="hidden" name="selectedids" id="selectedids">
	<input type="hidden" name="selecteddept" id="selecteddept" value="">
	<input type="hidden" name="selectedtype" id="selectedtype" value="">
	<table cellpadding="10" cellspacing="0" border="0" class="tab_split" style="width:80%">
			<tr >
				<td class="form_sec span1"><b>Select Role</b></td>
				<td class="form_sec span2">
					<select id="ddlRole" name="ddlRole" style="width:100%;margin-top:10px">
						<?php
						include 'db/db_connect.php';
						echo "<option value=Select>Select</option>"; 
						$sql = "SELECT RoleID, RoleName FROM tblrolemaster;";
						$result1 = $mysqli->query( $sql );
						while( $row = $result1->fetch_assoc() ) {
						extract($row);
						 if((isset($_POST['ddlRole']) && $_POST['ddlRole'] == $RoleID)){
								echo "<option value={$RoleID} selected>{$RoleName}</option>"; 
							}
							else{
								echo "<option value={$RoleID}>{$RoleName}</option>"; 
							}
						}
						?>
					</select>
					<input type="hidden" name="hdnexamname" id="examname_hidden">
				</td>
				<td class="form_sec span2" style="width:50%">
					<input type="submit" name="btnSelect" value="Show Access" title="Show Access" class="btn btn btn-success" />
					<input type="submit" name="btnSave" value="Save Access" title="Save Access" class="btn btn btn-success" />
					<?php
						if(isset($_POST['ddlRole']))
							echo "<a target='_blank' href='AccessList.php?RoleID=" . $_POST['ddlRole'] . "'>View Report</a>";
					?>
				</td>								
			</tr>						
		</table>
		<br/><br/>
		<div style="float:left;margin-left:65px;margin-top:-20px">
			<label id="lblSuccess" style="margin-left:10px;color:green;font-weight:bold;display:none" >Data saved successfully.</label>
		</div>
	
	<br/>
	<div class="row-fluid">
		<div class="v_detail">
			<table cellpadding="10" cellspacing="0" border="0" class="tab_split">
				<tr>
					<th>Screen Name</th>
					<th>Read</th>
					<th>Write</th>
				</tr>
				<?php
					if(isset($_POST['ddlRole']) && $_POST['ddlRole'] != 'Select' ){
						include 'db/db_connect.php';
						$query = "SELECT @a:=@a+1 AS SrNo,RoleID,SM.ScreenID,ScreenName,COALESCE(ReadAccess,0) AS ReadAccess,COALESCE(WriteAccess,0) AS WriteAccess
									FROM (SELECT @a:= 0) AS a , tblscreenmaster SM
									LEFT OUTER JOIN tblrolescreens RS ON RS.ScreenID = SM.ScreenID AND RoleID = " . $_POST['ddlRole'] . " where coalesce(Showonscreen,0) = 1
									order by ScreenName";
						//echo $query;
						$result = $mysqli->query( $query );
						$num_results = $result->num_rows;
						if( $num_results ){
							while( $row = $result->fetch_assoc() ){
								extract($row);
							  echo "<TR class='odd gradeX'>";
							  echo "<td><input type='hidden' name='txtScreenID[]' value='{$ScreenID}' />{$ScreenName}</td>";
							  echo "<td>
								<select name='ddlRead[]' style='width:100px;margin-top:10px'>
								<option value='No'";
								if($ReadAccess == 'No') echo "selected"; 
								echo ">No</option>
								<option value='Yes' ";
								//({$ReadAccess} == 'Yes') ? 'selected' : '' >Yes</option>
								if($ReadAccess == 'Yes') echo "selected"; 
								echo ">Yes</option></select>
								</td>";
							  echo "<td>
								<select name='ddlWrite[]' style='width:100px;margin-top:10px'>
								<option value='No' ";
								//({$WriteAccess} == 'No') ? 'selected' : '' >No</option>
								if($WriteAccess == 'No') echo "selected"; 
								echo ">No</option>
								<option value='Yes' ";
								//({$WriteAccess} == 'Yes') ? 'selected' : '' >Yes</option>
								if($WriteAccess == 'Yes') echo "selected"; 
								echo ">Yes</option></select>
								</td>";
							  echo "</TR>";
							}
						}
						else{
							echo "No records found.";
							echo "<TR class='odd gradeX'>";
							echo "<td>No records found.</td>";
							echo "<td></td>";
							echo "<td></td>";
							echo "</TR>";
						}
						echo "</table>";
					}
				?> 
				
			</table>
		</div>
	</div>

</form>
