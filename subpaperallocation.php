	<?php
		if(!isset($_SESSION)){
			session_start();
		}
		include 'db/db_connect.php';

		if(isset($_POST['btnSearch'])){
			if(isset($_POST['ddldept'])){
				if($_POST['ddldept'] <> ""){
					$_SESSION["tmpseldept"] = $_POST['ddldept'] ;
				}
			}
			if(isset($_POST['ddlYear'])){
				if($_POST['ddlYear'] <> ""){
					$_SESSION["tmpselyear"] = $_POST['ddlYear'] ;
				}
			}		
		}
		
		elseif(!isset($_SESSION["tmpselyear"])){
			$_SESSION["tmpselyear"] = '';
		}
		// if(isset($_POST['ddlYear'])){
			// $selyear = $_POST['ddlYear'];
		// }
		// if(isset($_POST['ddldept'])){
			// $seldept = $_POST['ddldept'];
		// }
	?>		
	<?php
	//include database connection
	include 'db/db_connect.php';
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
	?>

<form action="subpaperallocationMain.php" method="post">
	<br /><br /></br>
	<div class="row-fluid" style="margin-left:1%;margin-top:-15px">
	   
		<div style="float:left"><h3 class="page-title">Subject Role Allocation</h3></div>
		<div style="float:left;margin-top:18px;margin-left:20px;">
			<?php

					$setdisabled = '0';
					$strSelect1 = '';
					$strSelect2 = '';
					include 'db/db_connect.php';
					$strSelect1 = "<select id='ddldept' name='ddldept' style='width:120px;'";
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
									if(isset($_SESSION["tmpseldept"])){ 
										if($_SESSION["tmpseldept"] == $DeptID) {
											$strSelect2 = $strSelect2 .  ' selected ';
											if($_SESSION["SESSUserDept"] == $Department) {
												echo $_SESSION["SESSUserDept"];
												$strSelect1 = $strSelect1 . " disabled ";
											}
										}
									} 		
									else{
										if($_SESSION["SESSUserDept"] == $Department) {
												$strSelect2 = $strSelect2 .  ' selected ';
												$strSelect1 = $strSelect1 . " disabled ";
												$_SESSION["tmpseldept"] = $DeptID;
										}
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
					<option value="FE" <?php if(isset($_SESSION["tmpselyear"])){if($_SESSION["tmpselyear"] == "FE") echo "selected";} ?>>F.E.</option>
					<option value="SE" <?php if(isset($_SESSION["tmpselyear"])){if($_SESSION["tmpselyear"] == "SE") echo "selected";} ?>>S.E.</option>
					<option value="TE" <?php if(isset($_SESSION["tmpselyear"])){if($_SESSION["tmpselyear"] == "TE") echo "selected";} ?>>T.E.</option>
					<option value="BE" <?php if(isset($_SESSION["tmpselyear"])){if($_SESSION["tmpselyear"] == "BE") echo "selected";} ?>>B.E.</option>
				</select>
		</div>
		
		<div style="float:left;margin-top:18px;margin-left:20px;">
			<input type="submit" name="btnSearch" value="Search" title="Update" class="btn btn-mini btn-success" />
		</div>
			<div style="float:right"><h3 class='page-title' style='margin-right:30px;'><a href='MainMenuMain.php'>Back</a></h3></div>
	</div>	
	<br/>
	<div><center>
		<label id="lblSuccess" style="margin-left:10px;color:green;display:none" >Saved successfully.</label>
		</center>
	</div>
	<div class="row-fluid">
		 <div class="span7 v_detail" style="overflow:scroll">
			<table cellpadding="10" cellspacing="0" border="0" width="100%" class="tab_split">
				<tr>
					<th>Sr. No.</th>
					<th>Subjects</th>
					<th>Assign</th>
				</tr>	
		<?php
					include 'db/db_connect.php';
					$sql = "SELECT (MAX(EduYearTo) - 1) AS YearFrom, MAX(EduYearTo) as YearTo FROM tblcuryear";
					$result = $mysqli->query($sql);
					$num_results = $result->num_rows;
					If( $num_results ){
						while( $row = $result->fetch_assoc() ){
							extract($row);
							$SelYearFrom = $YearFrom;
							$SelYearTo = $YearTo;
						}
					}
					else {
							echo "Error";
							die;
					}		
					$result->free();
					//If ((isset($_POST['btnSearch'])) or (isset($_POST['btnSave'])))
					//{
						$sql = "SELECT papertype, PaperID, SubjectName,deptname as deptnamesel FROM vwhodsubjects vw,tbldepartmentmaster dm where vw.deptid = dm.deptid   ";
						If ((isset($_SESSION["tmpselyear"])))
						{
							$sql = $sql . " and EnggYear = '"  . $_SESSION["tmpselyear"] . "'" ;
						}
						If ((isset($_SESSION["tmpseldept"])))
						{
							//$sql = $sql . " and DeptID in (select DeptID from tbldepartmentmaster where DeptName = '". $_SESSION["SESSRAUserDept"] . "')";
							$sql = $sql . " and vw.DeptID = " . $_SESSION["tmpseldept"];
						}
						//echo $sql;

						$result = $mysqli->query($sql);
						$num_results = $result->num_rows;
						//echo $num_results;

						if( $num_results ){
							$i = 1;
							while( $row = $result->fetch_assoc() ){
								extract($row);
								echo "<TR class='odd gradeX'>";
								echo "<td>{$i}</td>";
								$i = $i + 1;
								echo "<td>{$SubjectName} </td>";
								echo "<td class='span2'>
											<a class='btn btn-mini btn-success' 
											href='SubRoleMapMain.php?PaperID={$PaperID}&subname={$SubjectName}&deptname={$deptnamesel}'>
											<i class='icon-ok icon-white'></i>&nbsp;&nbsp;Assign</a>";
								echo "</TR>";
								$i = $i  + 1;
							}
						}		
					
					$result->free();
					//disconnect from database
					$mysqli->close();
					//}
		?>
			</table>
		</div>
	</div>
</form>

