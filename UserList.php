<form name="myform" action="" method="post">
<head>
	   <link rel="stylesheet" href="css/jquery-ui.css">
	   <script src="js/jquery-1.10.2.js"></script>
       <script src="js/jquery-ui.js"></script>
	<script type="text/javascript" src="js/jquery.min.js"></script>
	 <script type="text/javascript">     
	 function showdept(){
		 $('#selecteddept').val($('#ddldept').val());
		 $('#selectedtype').val($('#ddlUserType').val());
		document.myform.submit();
	 }
	 function showtype(){
		 $('#selectedtype').val($('#ddlUserType').val());
		 $('#selecteddept').val($('#ddldept').val());
		document.myform.submit();
	 }
	 function AddToList()
	 {
		 if($('#ddlListNames').val() == '')
			alert('Please select a list.');
		else{
			var q = "";
				$("input[type=checkbox]:checked").each(function(){
					if (q != "") 
						q += ",";
					if($(this).attr("id") != undefined)
						q+= $(this).attr("id");
				});
				$('#selectedids').val(q);
				//alert($('#selectedids').val());
				document.myform.submit();
		}
	 }
	 function setall(chkmain)
	 {
			if ($(chkmain).val() == 'Check All') {
				$('.checkbox-class').attr('checked', 'checked');
				$(chkmain).val('Uncheck All');
			} else {
				$('.checkbox-class').removeAttr('checked');
				$(chkmain).val('Check All');
			}
	 }
		$("#clickit").click(function() {
				alert('1');
			if ($(this).val() == 'Check All') {
				$('.checkbox-class').attr('checked', 'checked');
				$(this).val('Uncheck All');
			} else {
				$('.checkbox-class').removeAttr('checked');
				$(this).val('Check All');
			}

		});
		function sendtoProfPersDet()
{
	var subvalue = document.getElementById("ddldept");
	var subtext = ddldept.options[ddldept.selectedIndex].text;
	window.open('Profbasicdetails.php?dept=' + subtext);
}
function sendToprofQual()
{
		var subvalue = document.getElementById("ddldept");
		var subtext = ddldept.options[ddldept.selectedIndex].text;

	window.open('profQual.php?dept=' + subtext);
}
function sendtoprofbankdet()
{
	var subvalue = document.getElementById("ddldept");
	var subtext = ddldept.options[ddldept.selectedIndex].text;
	window.open('ProfBankDet.php?dept=' + subtext);
}
function sendtoJournal()
{
	var subvalue = document.getElementById("ddldept");
	var subtext = ddldept.options[ddldept.selectedIndex].text;
	window.open('pubjournal.php?dept=' + subtext);
}
	</script>
</head>
	<?php
		if(!isset($_SESSION)){
			session_start();
		}
		include 'db/db_connect.php';
		$sql = "SELECT DeptID,DeptName,coalesce(teaching,0) as teaching FROM tbluser U 
		INNER JOIN tbldepartmentmaster DM on U.Department = DM.DeptName
		where userID =  " . $_SESSION["SESSUserID"] ;
		//. " and coalesce(teaching,0) = 1"
		//echo $sql;
		$result1 = $mysqli->query( $sql );
		while( $row = $result1->fetch_assoc() ) {
			extract($row);
			$_SESSION["SESSUserDept"] = $DeptName;
			$_SESSION["SESSUserDeptID"] = $DeptID;
			$_SESSION["isteaching"] = $teaching;
		}
		?>
	<br /><br />
	<div>
		<div style="float:left">
			<h3 class="page-title">User List</h3>
		</div>
		<div style="float:left;margin-top:25px;margin-left:50px">
			Reports for Selected Dept: <a target="_blank" onclick="sendtoProfPersDet();" href="Profbasicdetails.php">Personal Info</a>
			 <a target="_blank" onclick="sendToprofQual();" href="profQual.php">Qualifications</a>
			 <a target="_blank" onclick="sendtoprofbankdet();" href="ProfBankDet.php">Bank Details</a>
			 <a target="_blank" onclick="sendtoJournal();" href="pubjournal.php">Publications</a>
		</div>
		<div style="float:right">
				<h3 class="page-title"><a href="MainMenuMain.php">Back</a></h3>
		</div>
	</div>
	<br/><br/><br/><br/>
	<input type="hidden" name="selectedids" id="selectedids">
	<input type="hidden" name="selecteddept" id="selecteddept" value="">
	<input type="hidden" name="selectedtype" id="selectedtype" value="">
	<div>
		<div style="float:left;width:60%">
			<table cellpadding="10" cellspacing="0" border="0" width="100%" class="tab_split" style="margin-left:5%">
				<tr>
					<th>Total Users</th>
					<th>Faculty</th>
					<th>Ad-hoc</th>
					<th>Non-teaching</th>
					<th>Peon</th>
				</tr>
				<?php
					include 'db/db_connect.php';
					if(isset($_POST['selectedids'])){
					if($_POST['selectedids'] != ''){
						$mysqli->query("SET @i_ListID  = " . $_POST["ddlListNames"] . "");
						$mysqli->query("SET @i_ExamDate   = '" .  $_POST['selectedids'] . "'");
						$result1 = $mysqli->query("CALL SP_SAVELIST(@i_ListID,@i_ExamDate)");
					}
				}
						
					$sql = " SELECT COUNT(*) as TotalUsers, SUM(CASE userType WHEN 'Ad-hoc' THEN 1 ELSE 0 END) AS Adhoc
							,SUM(CASE userType WHEN 'Teaching Assistant' THEN 1 ELSE 0 END) AS TA
							,SUM(CASE userType WHEN 'Faculty' THEN 1 ELSE 0 END) AS Regular
							,SUM(CASE userType WHEN 'Peon' THEN 1 ELSE 0 END) AS Peon
							FROM tbluser ";
					
					//echo $sql;
					// execute the sql query
					$result = $mysqli->query( $sql );
					echo $mysqli->error;
					$num_results = $result->num_rows;

					if( $num_results ){
						while( $row = $result->fetch_assoc() ){
							extract($row);
							echo "<TR class='odd gradeX'>";
							echo "<td>{$TotalUsers}</td>";
							echo "<td>{$Regular}</td>";
							echo "<td>{$Adhoc}</td>";
							echo "<td>{$TA}</td>";
							echo "<td>{$Peon}</td>";
						}
					}					
					//disconnect from database
					$result->free();
					$mysqli->close();
				?>
			</table>
		</div>
		<div style="float:left;margin-left:50px;margin-top:5px">
			<?php
			include 'db/db_connect.php';
			$strSelect1 = '';
			$strSelect2 = '';
			$strSelect1 = "<select id='ddldept' onchange='showdept();' name='ddldept' required style='width:120px;' required ";
			$strSelect2 = "<option value=''>Select Dept</option>";
			$query = "SELECT DeptName AS Department FROM tbldepartmentmaster";
					//echo $query;
					$result = $mysqli->query( $query );
					$num_results = $result->num_rows;
					if( $num_results ){
						while( $row = $result->fetch_assoc() ){
							extract($row);
							$strSelect2 = $strSelect2 . "<option ";
							if(($_SESSION["usertype"] == "SuperAdmin") || ($_SESSION["isteaching"] <> 1)){
								//select the posted thing!!
								if(isset($_POST["selecteddept"])){
									if($_POST["selecteddept"] == $Department){
										$strSelect2 = $strSelect2 . ' selected ';
									}								
								}
							}
							else{
								if(isset($_SESSION["SESSUserDept"])){ 
									if($_SESSION["SESSUserDept"] == $Department){
										$strSelect2 = $strSelect2 . ' selected ';
										$strSelect1 = $strSelect1 . " disabled";
									}
								} 								
							}
							$strSelect2 = $strSelect2 . " value='{$Department}'>{$Department}</option>";
						}
					}
				$strSelect1 = $strSelect1 . " >";
				$strSelect1 = $strSelect1 . $strSelect2;
				$strSelect1 = $strSelect1 .  "</select>";
				echo $strSelect1;	
			?>
		</div>
		<div style="float:left;margin-left:20px;margin-top:5px">
				<select id="ddlUserType" name="ddlUserType" onchange="showtype();">
							<?php
							include 'db/db_connect.php';
							echo "<option value=''>Select</option>"; 
							if($_SESSION["usertype"] == "SuperAdmin")
								$sql = "SELECT RoleID, RoleName FROM tblrolemaster;";
							else
								$sql = "SELECT RoleID, RoleName FROM tblrolemaster WHERE RoleName <> 'SuperAdmin';";

							//$sql = "SELECT RoleID, RoleName FROM tblrolemaster;";
							$result1 = $mysqli->query( $sql );
							while( $row = $result1->fetch_assoc() ) {
							extract($row);
							 if((isset($_POST['ddlUserType']) && $_POST['ddlUserType'] == $RoleName)){
									echo "<option value={$RoleName} selected>{$RoleName}</option>"; 
								}
								else{
									echo "<option value={$RoleName}>{$RoleName}</option>"; 
								}
							}
							?>
				</select>
		</div>
	</div>
	<br/><br/><br/><br/><br/>
	<div class="row-fluid">
		<div class="v_detail">
			<table cellpadding="10" cellspacing="0" border="0" class="tab_split">
				<tr>
				<?php
				// Create connection
				include 'db/db_connect.php';
				if(!isset($_GET['sorting'])){
					$field='userName';
					$sort='ASC';
					$image = 'arrowup.png';
				}
				if(isset($_GET['sorting']))
				{
				  if($_GET['sorting']=='ASC'){ $sort='DESC';$image = 'arrowdown.png';}
				  else { $sort='ASC'; $image = 'arrowup.png';}
				}
				if(isset($_GET['field'])){
					if($_GET['field']=='userName'){$field = "userName";}
					elseif($_GET['field']=='userLogin'){$field = "userLogin";}
					elseif($_GET['field']=='userMobile'){$field="userMobile";}
					elseif($_GET['field']=='userDepartment'){$field="userDepartment";}
					elseif($_GET['field']=='userType'){$field="userType";}
				}
					if($teaching == 0){
						echo "<th><a href='UserMaintMain.php?userID=I'><i class='icon-plus icon-white'></i>New</a></th>";
					}
					else{
						echo "<th>&nbsp;</th>";
					}
					echo "<th><a href='UserListMain.php?sorting=" .$sort. "&field=userName'>Full Name</a>";
					if($field =='userName'){
						echo " <img src='images/".$image."' />";
					}
					echo "</th>";
					echo "<th><a href='UserListMain.php?sorting=" .$sort. "&field=userLogin'>Email</a>";
					if($field =='userLogin'){
						echo " <img src='images/".$image."' />";
					}
					echo "</th>";
					echo "<th><a href='UserListMain.php?sorting=" .$sort. "&field=userMobile'>Mobile</a>";
					if($field =='userMobile'){
						echo " <img src='images/".$image."' />";
					}
					echo "</th>";
					echo "<th><a href='UserListMain.php?sorting=" .$sort. "&field=userDepartment'>Department</a>";
					if($field =='userDepartment'){
						echo " <img src='images/".$image."' />";
					}
					echo "</th>";
					echo "<th></th>";
					echo "<th><a href='UserListMain.php?sorting=" .$sort. "&field=userType'>User Type</a>";
					if($field =='userType'){
						echo " <img src='images/".$image."' />";
					}
					echo "</th>";
					echo "<th></th>";
					echo "<th>
							<input onclick='setall(this);' class='checkbox-class' type='checkbox' value='Check All' />
								<input style='margin-top:-7px;' onclick='AddToList();' type='button' value='Add to List' />";
								echo "<select id='ddlListNames' name='ddlListNames' style='width:110px'><option value=''>Select List</option>";
								$query = "SELECT ListID, ListName FROM tbllistmster where ListType = 'User' order by ListName";
								//echo $query;
								$result = $mysqli->query( $query );
								$num_results = $result->num_rows;
								if( $num_results ){
									while( $row = $result->fetch_assoc() ){
										extract($row);
										echo "<option value='{$ListID}'>{$ListName}</option>";
									}
								}
					echo "</th>";
				echo "</tr>";

				if($_SESSION["usertype"] == "SuperAdmin")
					$query = "SELECT userID, Concat(FirstName,' ',LastName) as userName, email as userLogin, 
							ContactNumber as userMobile, Department as userDepartment,userType FROM tbluser where 1=1 ";
				else
					$query = "SELECT userID, Concat(FirstName,' ',LastName) as userName, email as userLogin, 
							ContactNumber as userMobile, Department as userDepartment,userType FROM tbluser where userType <> 							'SuperAdmin' ";
			
				
				//$query = "SELECT userID, Concat(FirstName,' ',LastName) as userName, email as userLogin, ContactNumber as userMobile, 				//Department as userDepartment,userType FROM tbluser";
				if($_SESSION["isteaching"] == 1){
					if($_SESSION["usertype"] == "SuperAdmin"){
						$vardept = $_POST['selecteddept'];
					}
					else{
						$vardept = $_SESSION["SESSUserDept"];
					}
				}
				else{
					$vardept = $_POST['selecteddept'];
				}
				if(isset($_POST['selectedtype'])){
					if(($_POST['selectedtype'] <> '' ) && ($vardept == '')){
						$query = $query . " and userType = '" . $_POST['selectedtype'] . "' ";
					}
					if(($_POST['selectedtype'] == '' ) && ($vardept <> '')){
						$query = $query . " and Department = '" . $vardept . "' ";
					}
					if(($_POST['selectedtype'] <> '' ) && ($vardept <> '')){
						$query = $query . " and Department = '" . $vardept . "' and userType = '" . $_POST['selectedtype'] . "' ";
					}
				}
				else{
					$query = $query . " and Department = '" . $vardept . "' ";
				}
				$query =	$query . " order by " . $field . " " . $sort . ";";
							
				//echo $query;
				$result = $mysqli->query( $query );
				
				$num_results = $result->num_rows;
				
				if( $num_results ){
					while( $row = $result->fetch_assoc() ){
						extract($row);
					  echo "<TR class='odd gradeX'>";
					  echo "<td><a class='btn btn-mini btn-primary' href='UserMaintMain.php?userID={$userID}'><i class='icon-pencil icon-white'></i>Edit</a> </td>";
					  echo "<td>{$userName}</td>";
					  echo "<td>{$userLogin}</td>";
					  echo "<td>{$userMobile}</td>";
					  echo "<td>{$userDepartment}<td>";
					  echo "<td>{$userType}<td>";
					  echo "<td><input id={$userID} class='checkbox-class' type='checkbox' value='0' /></td>";
					  echo "<td><a class='btn btn-mini btn-primary' href='redirectingprof.php?userID={$userID}&fromadmin=fromadmin'><i class='icon-pencil icon-white'></i>Faculty Profile</a> </td>";
					  echo "</TR>";
					  }
				}
				else{
					echo "No records found.";
					echo "<TR class='odd gradeX'>";
					echo "<td><a class='btn btn-mini btn-primary' href='UserMaintMain.php?&userID=" . $row['userID'] . "'><i class='icon-pencil icon-white'>Edit</a> </td>";
					echo "<td>No records found.</td>";
					echo "<td></td>";
					echo "<td></td>";
					echo "<td></td>";
					echo "<td></td>";
					echo "<td></td>";
					echo "</TR>";
				}

				echo "</table>";

				?> 
				
			</table>
		</div>
	</div>

</form>
