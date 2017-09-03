<?php
if(!isset($_SESSION)){
	session_start();
}

if(isset($_POST['ddldept'])){
	$_SESSION["pmseldept"] = $_POST['ddldept'];
}
if(isset($_POST['ddlYear'])){
	$_SESSION["pmselyear"] = $_POST['ddlYear'];
}
if(isset($_POST['ddlpattern'])){
	$_SESSION["pmselpat"] = $_POST['ddlpattern'];
}

?>	
<form action="PaperListMain.php" method="post" name="myform">
	<br /><br />
<head>
	 <script type="text/javascript">     
	 function showdept(){
		$('#selecteddept').val($('#ddldept').val());
		 $('#selectedyear').val($('#ddlYear').val());
		  $('#selectedpattern').val($('#ddlpattern').val());
		document.myform.submit();
	 }
	 function showpattern(){
		 $('#selectedpattern').val($('#ddlpattern').val());
		 $('#selecteddept').val($('#ddldept').val());
		  $('#selectedyear').val($('#ddlYear').val());
		document.myform.submit();
	 }
	</script>
</head>
<body>
	<input type="hidden" name="selecteddept" id="selecteddept" value="">
	<input type="hidden" name="selectedyear" id="selectedyear" value="">
	<input type="hidden" name="selectedpattern" id="selectedpattern" value="">
	<div style="margin-top:10px">
		<div style="float:left">
			<h3 class="page-title">Paper List</h3>
		</div>
		<div style="float:left;margin-top:18px;margin-left:20px;">
				<?php
				if(!isset($_SESSION)){
					session_start();
				}
				$sql = "SELECT DeptID,DeptName 
				FROM tbluser U 
				INNER JOIN tbldepartmentmaster DM on U.Department = DM.DeptName
				where userID =  " . $_SESSION["SESSUserID"] . " and coalesce(teaching,0) = 1";
				//echo $sql;
				$result1 = $mysqli->query( $sql );
				while( $row = $result1->fetch_assoc() ) {
				extract($row);
							$_SESSION["SESSRAUserDept"] = $DeptName;
							$_SESSION["SESSRAUserDeptID"] = $DeptID;
				}
				$_SESSION["SESSFrom"] = "";
				include 'db/db_connect.php';
				$strSelect1 = "<select id='ddldept' onchange='showdept();' name='ddldept' style='width:120px;'";
						//if($_SESSION["SESSRAUserDept"] == $Department) 
						//	echo ' disabled';
					$strSelect2 = "<option value='0'>Select Dept</option>";
					$query = "SELECT DeptID,DeptName AS Department FROM tbldepartmentmaster where coalesce(teaching,0) = 1 ";
							//echo $query;
							$result = $mysqli->query( $query );
							$num_results = $result->num_rows;
							if( $num_results ){
								while( $row = $result->fetch_assoc() ){
									extract($row);
									$strSelect2 = $strSelect2 . "<option ";
									// if(isset($_POST['selecteddept']))
									// { 
										// if($_POST["selecteddept"] == $DeptID) 
											// $strSelect2 = $strSelect2 .  'selected';
										// if(isset($_SESSION['SESSRAUserDept'])) {
										// if($_SESSION["SESSRAUserDept"] == $Department) {
											// $strSelect1 = $strSelect1 . " disabled";
										// }	
// }										
									// } 		
									if(isset($_SESSION["SESSRAUserDept"]))
									{ 
										if($_SESSION["SESSRAUserDept"] == $Department) {
											$strSelect2 = $strSelect2 . ' selected ';
											$strSelect1 = $strSelect1 . " disabled";
										}																	
									}
									else if(isset($_SESSION["pmseldept"]))
									{ 
										if($_SESSION["pmseldept"] == $DeptID){
											$strSelect2 = $strSelect2 . ' selected ';
										}
									} 
									else if(isset($_POST['ddldept']))
									{ 
										if($_POST["ddldept"] == $DeptID) 
											$strSelect2 = $strSelect2 .  'selected';
									} 		
									$strSelect2 = $strSelect2 . " value='{$DeptID}'>{$Department}</option>";
								}
							}
					$strSelect1 = $strSelect1 . " >";
					$strSelect1 = $strSelect1 . $strSelect2;
					$strSelect1 = $strSelect1 .  "</select>";
					echo $strSelect1;
				?>
			</div>
			<div style="float:left;margin-top:18px;margin-left:20px;">
					<select id="ddlYear" name="ddlYear" onchange="showdept();" style="width:120px">
						<option value="">Select Year</option>
						<option value="FE" <?php if(isset($_SESSION["pmselyear"])){if($_SESSION["pmselyear"] == "FE") echo "selected";} ?>>F.E.</option>
						<option value="SE" <?php if(isset($_SESSION["pmselyear"])){if($_SESSION["pmselyear"] == "SE") echo "selected";} ?>>S.E.</option>
						<option value="TE" <?php if(isset($_SESSION["pmselyear"])){if($_SESSION["pmselyear"] == "TE") echo "selected";} ?>>T.E.</option>
						<option value="BE" <?php if(isset($_SESSION["pmselyear"])){if($_SESSION["pmselyear"] == "BE") echo "selected";} ?>>B.E.</option>
						<option value="FY" <?php if(isset($_SESSION["pmselyear"])){if($_SESSION["pmselyear"] == "FY") echo "selected";} ?>>F.Y.M.Tech.</option>
						<option value="SY" <?php if(isset($_SESSION["pmselyear"])){if($_SESSION["pmselyear"] == "SY") echo "selected";} ?>>S.Y.M.Tech.</option>
					</select>
			</div>
			<div style="float:left;margin-top:18px;margin-left:20px;">
				<tr>				
					<td>
						<select  id="ddlpattern" name="ddlpattern" onchange="showpattern();" style="width:120px">
							<?php
							include 'db/db_connect.php';
							echo "<option value=''>Select Pattern</option>"; 
							$sql = "SELECT distinct teachingpat as PatternText FROM tblpatternmaster order by teachingpat;";
							$result1 = $mysqli->query( $sql );
							while( $row = $result1->fetch_assoc() ) {
							extract($row);
							if((isset($_SESSION["pmselpat"]) && $_SESSION["pmselpat"] == $PatternText)){
									echo "<option value={$PatternText} selected>{$PatternText}</option>"; 
								}
								else{
									echo "<option value={$PatternText}>{$PatternText}</option>"; 
								}
							}
							
							?>
						</select>
					</td>
				</tr>	
			</div>	
		
			<div style="float:right">
				<h3 class="page-title" style="margin-right:30px;"><a href="MainMenuMain.php">Back</a></h3>
			</div>
		</div>
		<br/><br/><br/><br/>
	<div class="row-fluid">
	<table cellpadding="10" cellspacing="0" border="0" width="100%" class="tab_split">
		<tr>
				<?php
				// Create connection
				include 'db/db_connect.php';
				if(!isset($_GET['sorting'])){
					$field='EnggYear';
					$sort='ASC';
					$image = 'arrowup.png';
				}
				if(isset($_GET['sorting']))
				{
				  if($_GET['sorting']=='ASC'){ $sort='DESC';$image = 'arrowdown.png';}
				  else { $sort='ASC'; $image = 'arrowup.png';}
				}
				if(isset($_GET['field'])){
					if($_GET['field']=='EnggYear'){$field = "EnggYear";}
					elseif($_GET['field']=='DeptName'){$field = "DeptName";}
					elseif($_GET['field']=='EnggPattern'){$field="EnggPattern";}
					elseif($_GET['field']=='SubjectName'){$field="SubjectName";}
					elseif($_GET['field']=='Papercode'){$field="Papercode";}
				}
				
					echo "<th style='width:10%'><a href='PaperMaintMain.php?PaperID=I'><i class='icon-plus icon-white'></i>New</a></th>";
					echo "<th style='width:10%'><a href='PaperListMain.php?sorting=" .$sort. "&field=EnggYear'>Engg Year</a>";
					if($field =='EnggYear'){
						echo " <img src='images/".$image."' />";
					}
					echo "</th>";
					echo "<th style='width:10%'><a href='PaperListMain.php?sorting=" .$sort. "&field=DeptName'>Department</a>";
					if($field =='DeptName'){
						echo " <img src='images/".$image."' />";
					}
					echo "</th>";
					echo "<th style='width:10%'><a href='PaperListMain.php?sorting=" .$sort. "&field=EnggPattern'>Pattern</a>";
					if($field =='EnggPattern'){
						echo " <img src='images/".$image."' />";
					}
					echo "</th>";
					echo "<th style='width:40%'><a href='PaperListMain.php?sorting=" .$sort. "&field=SubjectName'>Subject</a>";
					if($field =='SubjectName'){
						echo " <img src='images/".$image."' />";
					}
					echo "</th>";
					echo "<th style='width:10%'><a href='PaperListMain.php?sorting=" .$sort. "&field=Papercode'>Code</a>";
					if($field =='Papercode'){
						echo " <img src='images/".$image."' />";
					}
					echo "</th>";
					?>
			</tr>
		</table>
		<div class="v_detail">		
			<table cellpadding="10" cellspacing="0" border="0" width="100%" class="tab_split">
				<?php	
				$where = '';
				$query = "SELECT PaperID, Replace(Replace(EnggYear,'FY','FYMTech'),'SY','SYMTech') as EnggYear, DM.DeptName, EnggPattern, SM.SubjectName, Papercode 
							FROM tblpapermaster PM 
							LEFT JOIN tbldepartmentmaster DM ON PM.DeptID = DM.DeptID
							INNER JOIN tblsubjectmaster SM ON PM.SubjectID =  SM.SubjectID ";
							$deptval = "";
							$patval = "";
							$yearval = "";							
							if(isset($_SESSION["pmseldept"]))
							{ 
								$deptval = $_SESSION["pmseldept"];
							} 
							if(isset($_SESSION["pmselpat"]))
							{ 
								$patval = $_SESSION["pmselpat"];
							} 							
							if(isset($_SESSION["pmselyear"]))
							{ 
								$yearval = $_SESSION["pmselyear"];
							} 							
							if(isset($_SESSION["SESSRAUserDeptID"]))
							{ 
								$deptval = $_SESSION["SESSRAUserDeptID"];
							}
							if($yearval <> ""){
								if($where <> ""){
									$where = $where . " and SUBSTRING(EnggYear,1,2) = '" . $yearval . "'";
								} 
								else{
									$where = $where . " where SUBSTRING(EnggYear,1,2) = '" . $yearval . "'";							
								}
							}
							if($deptval <> ""){
								if($where <> ""){
									$where = $where . " and DM.DeptID = '" . $deptval . "'";
								} 
								else{
									$where = $where . " where DM.DeptID = '" . $deptval . "'";							
								}
							}
							if($patval <> ""){
								if($where <> ""){
									$where = $where . " and EnggPattern = '" . $patval . "'";
								} 
								else{
									$where = $where . " where EnggPattern = '" . $patval . "'";							
								}
							}
								// if(($_POST['selectedyear'] <> '' ) && ($deptval == '') && ($patval == '') ){
									// $query = $query . " where SUBSTRING(EnggYear,1,2) = '" . $_POST['selectedyear'] . "' ";
								// }
								// if(($_POST['selectedyear'] == '' ) && ($_POST['selecteddept'] <> '') && ($_POST['selectedpattern'] <> '')){
									// $query = $query . " where DM.DeptID = '" . $deptval . "' and EnggPattern = '" . $patval . "' ";
								// }
								// if(($_POST['selectedyear'] <> '' ) && ($deptval <> '') && ($patval <> '')){
									// $query = $query . " where DM.DeptID = '" . $deptval . "' and EnggPattern = '" . $patval . "' and SUBSTRING(EnggYear,1,2) = '" . $_POST['selectedyear'] . "' ";
								// }
								// if(($_POST['selectedpattern'] <> '' ) && ($patval <> '')){
									// $query = $query . " where EnggPattern = '" . $patval . "' and SUBSTRING(EnggYear,1,2) = '" . $_POST['selectedyear'] . "' and
										// DM.DeptID = '" . $deptval . "'";
								// }
								
							//}
							// else if($patval <> ""){
									// $query = $query . " where EnggPattern = '" . $patval . "' ";
							// }
							// else if($deptval <> ""){
									// $query = $query . " where DM.DeptID = '" . $deptval . "' ";
							// }
							//echo $query ;
							$query =	$query . $where . " order by " . $field . " " . $sort . ";";		
//echo $query;							
				$result = $mysqli->query( $query );
				
				$num_results = $result->num_rows;
				
				if( $num_results ){
					while( $row = $result->fetch_assoc() ){
						extract($row);
					  echo "<TR class='odd gradeX'>";
					  echo "<td style='width:10%'><a class='btn btn-mini btn-primary' href='PaperMaintMain.php?PaperID={$PaperID}'><i class='icon-pencil icon-white'></i>Edit</a> </td>";
					  echo "<td style='width:10%'>{$EnggYear}</td>";
					  echo "<td style='width:10%'>{$DeptName}</td>";
					  echo "<td style='width:10%'>{$EnggPattern}</td>";
					  echo "<td style='width:40%'>{$SubjectName}</td>";
					  echo "<td style='width:10%'>{$Papercode}</td>";
					  echo "</TR>";
					}
				}
				echo "</table>";

				?> 
				
			</table>
		</div>
	</div>
</body>
</form>
