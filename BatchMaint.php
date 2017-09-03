<?php
//include database connection
include 'db/db_connect.php';
if(!isset($_SESSION)){
	session_start();
}
					include 'db/db_connect.php';
					$sql = 'SELECT EduYearFrom, EduYearTo FROM tblcuryear';
					$result = $mysqli->query( $sql );
					$num_results = $result->num_rows;
					if( $num_results ){
						while( $row = $result->fetch_assoc() ){
							extract($row);
						}
					}
 // if the form was submitted/posted, update the record
 if($_POST)
	{
			$sql = "SELECT DeptID,DeptName FROM tbluser U 
			INNER JOIN tbldepartmentmaster DM on U.Department = DM.DeptName
			where userID =  " . $_SESSION["SESSUserID"] . " and coalesce(teaching,0) = 1";
			//echo $sql;
			$result1 = $mysqli->query( $sql );
			while( $row = $result1->fetch_assoc() ) {
				extract($row);
				$_SESSION["SESSRAUserDept"] = $DeptName;
				$_SESSION["SESSRAUserDeptID"] = $DeptID;
			}		

			if(isset($_POST['ddldept'])){
				$_SESSION["seldeptid"] = $_POST['ddldept'];
			}	
			else{
				$_SESSION["seldeptid"] = $_SESSION["SESSRAUserDeptID"];
			}
			if (isset($_POST['chkTeachingYesNO'])) {
				$tmpchkTeachingYesNO = '1';
			}
			else
				$tmpchkTeachingYesNO = '0';

		if ($_POST['txtBatchID'] == "I") {
			$sql = "Insert into tblbatchmaster(BatchName,DeptID,EduYear,papertype,divn) Values (?, ?, ?, ?, ?)";
			$stmt = $mysqli->prepare($sql);
			$stmt->bind_param('sssss', $_POST['txtBatch'],$_SESSION["seldeptid"],$_POST['ddlEnggYear'],$_POST['ddlpapertype'],$_POST['ddldiv']);
			// execute the update statement
			if($stmt->execute()){
				$id = $stmt->insert_id;
				header('Location: BatchMaintMain.php?BtchId='. $id); 
				// close the prepared statement
			}else{
				echo $mysqli->error;
				die("Unable to update.");
			}
		}
		else {
			$sql = "UPDATE  tblbatchmaster
						Set  BatchName = ?
						,EduYear = ?  
						,papertype = ?  
						,divn = ? 						
						Where BtchId = ?";
				//echo $sql;
				$stmt = $mysqli->prepare($sql);
				$stmt->bind_param('sssss', $_POST['txtBatch'],$_POST['ddlEnggYear'],$_POST['ddlpapertype'],$_POST['ddldiv'],$_POST['txtBatchID']);
				// execute the update statement
				if($stmt->execute()){
					//header('Location: BatchListMain.php?'); 
					// close the prepared statement
				}else{
					echo $mysqli->error;
					die("Unable to update.");
				}
				 if($_POST["btnAssign"]){
					//update roll nos now!
					// echo $_POST["txtBatchID"] . "<br/>";
					// echo $_POST["ddlEnggYear"] . "<br/>";
					// echo $_POST["ddlpapertype"] . "<br/>";
					// echo $_SESSION["seldeptid"] . "<br/>";
					// echo $_POST["ddlstartrollno"] . "<br/>";
					// echo $_POST["ddlendrollno"] . "<br/>";
					// die;
					$mysqli->query("SET @i_BatchID  = " . $_POST["txtBatchID"] . "");
					$mysqli->query("SET @i_year  = '" . $_POST["ddlEnggYear"] . "'");
					$mysqli->query("SET @i_papertype  = '" . $_POST["ddlpapertype"] . "'");
					$mysqli->query("SET @i_deptid  = " . $_SESSION["seldeptid"] . "");
					$mysqli->query("SET @i_StartRollNo  = '" . $_POST["ddlstartrollno"] . "'");
					$mysqli->query("SET @i_EndRollNo  = '" . $_POST["ddlendrollno"] . "'");
					$result1 = $mysqli->query("CALL SP_SaveBatchFromMaster(@i_BatchID, @i_year,@i_papertype,@i_deptid,@i_StartRollNo,@i_EndRollNo)");
				 }
			
			}
			header('Location: BatchListMain.php?'); 	
	}
else 
	{
		if ($_GET['BtchId'] == "I") {
			$sql = "SELECT 'I' as BtchId, '' as BatchName, '' as DeptID, '' as EduYear, '' as papertype, '' as divn,0 as minrollno,0 as maxrollno " ;
		}
		Else
		{  
			$sql = " SELECT bm.BtchId, BatchName,DeptID,EduYear,papertype, divn ,MIN(RollNo) as minrollno,MAX(RollNo) as maxrollno
					FROM tblbatchmaster bm
					INNER JOIN tblyearstructstd yss ON yss.BtchId = bm.BtchId 
					INNER JOIN tblstdadm sa ON sa.StdAdmId = yss.StdAdmId and sa.EduYearFrom = " . $EduYearFrom . "
					WHERE bm.BtchId = " . $_GET['BtchId'];
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

<form action="BatchMaintMain.php?BtchId=<?php echo $_GET['BtchId']; ?>" method="post">
	<br /><br />
	<h3 class="page-title" style="margin-left:5%">Batch Maintenance</h3>
	<div class="row-fluid">
		<div class="v_detail" style="margin-left:5%">
			<table cellpadding="10" cellspacing="0" border="0" width="50%" class="tab_split">
				<tr>
					<td class="form_sec span4">&nbsp;</td>
					<td>
						<div class="span10">
							<input type="hidden" name="txtBatchID" value="<?php echo $_GET['BtchId'] ?>" />
							<input type="submit" name="btnUpdate" value="Save" title="Update" class="btn btn-mini btn-success" />
							<a href="BatchListMain.php" class="btn btn-mini btn-warning">Cancel</a>
						</div>
					</td>								
				</tr>
				<tr>
					<td class="form_sec span4">Batch Name</td>
					<td>
						<input type="text" maxlength="100" name="txtBatch" class="textfield" required  style="width:300px;" value="<?php echo "{$BatchName}" ?>"/>
					</td>
				</tr>						
				<tr>
					<td class="form_sec span4">Department</td>
					<td>
							<?php
							$strSelect2 = '';
							$strSelect1 = "<select name='ddldept' style='width:30%;margin-top:10px' ";
							include 'db/db_connect.php';
							$sql = "SELECT 0 as MDeptId, 'Select '  as DeptName, -1 as orderno UNION SELECT DeptID as MDeptId, DeptName , orderno From tbldepartmentmaster where COALESCE(Teaching,0) = 1 order by orderno ;";
							$result1 = $mysqli->query( $sql );
							while( $row = $result1->fetch_assoc() ) {
								extract($row);
								$strSelect2 = $strSelect2 . "<option ";
								if(isset($_SESSION["SESSUserDept"]))
								{ 
									if($_SESSION["SESSRAUserDept"] == $DeptName){
										$strSelect2 = $strSelect2 . ' selected ';
										$strSelect1 = $strSelect1 . " disabled";
									}
									else if(isset($_SESSION["seldeptid"])){
										if($_SESSION["seldeptid"] == $MDeptId){
											$strSelect2 = $strSelect2 . ' selected ';
										}								
									}
								} 						
								$strSelect2 = $strSelect2 . " value='{$MDeptId}'>{$DeptName}</option>";
							}
							$strSelect1 = $strSelect1 . " >";
							echo $strSelect1 . $strSelect2 . "</select>";
							?>
					</td>
				</tr>		
				<tr>
					<td class="form_sec span4">Year</td>
					<td>
						<select name="ddlEnggYear">
							<option value="Select" <?php if($EduYear == "Select") echo "selected"; ?>>Select</option>
							<option value="FE" <?php if($EduYear == "FE") echo "selected"; ?>>F.E.</option>
							<option value="SE" <?php if($EduYear == "SE") echo "selected"; ?>>S.E.</option>
							<option value="TE" <?php if($EduYear == "TE") echo "selected"; ?>>T.E.</option>
							<option value="BE" <?php if($EduYear == "BE") echo "selected"; ?>>B.E.</option>
							<option value="FY" <?php if(isset($_SESSION["pmselyear"])){if($_SESSION["pmselyear"] == "FY") echo "selected";} ?>>F.Y.M.Tech.</option>
							<option value="SY" <?php if(isset($_SESSION["pmselyear"])){if($_SESSION["pmselyear"] == "SY") echo "selected";} ?>>S.Y.M.Tech.</option>

						</select>
					</td>
				</tr>	
				<tr>
					<td class="form_sec span4">Paper Type</td>
					<td>
						<select name="ddlpapertype">
							<option value="Select" <?php if($papertype == "Select") echo "selected"; ?>>Select</option>
							<option value="TH" <?php if($papertype == "TH") echo "selected"; ?>>TH</option>
							<option value="PR" <?php if($papertype == "PR") echo "selected"; ?>>PR</option>
							<option value="TT" <?php if($papertype == "TT") echo "selected"; ?>>TT</option>
							

						</select>
					</td>
				</tr>					
				<tr>
					<td class="form_sec span4">Division</td>
					<td>
						<select name="ddldiv">
							<option value="" <?php if($divn == "Select") echo "selected"; ?>>Select</option>
							<option value="A" <?php if($divn == "A") echo "selected"; ?>>A</option>
							<option value="B" <?php if($divn == "B") echo "selected"; ?>>B</option>
							<option value="C" <?php if($divn == "C") echo "selected"; ?>>C</option>
							<option value="D" <?php if($divn == "D") echo "selected"; ?>>D</option>
							<option value="E" <?php if($divn == "E") echo "selected"; ?>>E</option>
							<option value="F" <?php if($divn == "F") echo "selected"; ?>>F</option>
							<option value="G" <?php if($divn == "G") echo "selected"; ?>>G</option>
							<option value="H" <?php if($divn == "H") echo "selected"; ?>>H</option>
							<option value="I" <?php if($divn == "I") echo "selected"; ?>>I</option>
							<option value="NA" <?php if($divn == "NA") echo "selected"; ?>>NA</option>
						</select>
					</td>
				</tr>
				<?php 
					if(!isset($_SESSION)){
						session_start();
					}
					if ($_GET['BtchId'] == "I") {
					}
					else{
						echo "<tr>";
							echo "<td class='form_sec span4'>Roll No From</td>";
							echo "<td>";
							$strSelect2 = '';
							$strSelect1 = "<select name='ddlstartrollno' style='width:30%;margin-top:10px' ";
							include 'db/db_connect.php';
							if($EduYear == 'FE'){
							$sql = "SELECT RollNo from tblstdadm sa
									inner join tblcuryearauto cy on cy.EduYearFrom = sa.EduYearFrom
									where sa.Div = '{$divn}' and REPLACE(sa.Year,'.','') = '{$EduYear}' 
									order by cast(RollNo as UNSIGNED)" ;
							}
							else{
							$sql = "SELECT RollNo from tblstdadm sa
									inner join tblcuryearauto cy on cy.EduYearFrom = sa.EduYearFrom
									where sa.Div = '{$divn}' and REPLACE(sa.Year,'.','') = '{$EduYear}' 
									and sa.Dept = {$DeptID}
									order by cast(RollNo as UNSIGNED)" ;
							}
							//echo $sql;
							$result1 = $mysqli->query( $sql );
							while( $row = $result1->fetch_assoc() ) {
								extract($row);
								$strSelect2 = $strSelect2 . "<option ";
									if($minrollno == $RollNo){
										$strSelect2 = $strSelect2 . ' selected ';
									}
								$strSelect2 = $strSelect2 . " value='{$RollNo}'>{$RollNo}</option>";
							}
							$strSelect1 = $strSelect1 . " >";
							echo $strSelect1 . $strSelect2 . "</select> &nbsp;&nbsp;";
							echo "<input type='submit' name='btnAssign' value='Assign Roll Numbers' title='Assign' class='btn btn-mini btn-success' />";
							echo "</td>";
						echo "</tr>";	
					}
				?>
				<?php 
					if(!isset($_SESSION)){
						session_start();
					}
					if ($_GET['BtchId'] == "I") {
					}
					else{
						echo "<tr>";
							echo "<td class='form_sec span4'>Roll No To</td>";
							echo "<td>";
							$strSelect2 = '';
							$strSelect1 = "<select name='ddlendrollno' style='width:30%;margin-top:10px' ";
							include 'db/db_connect.php';
							if($EduYear == 'FE'){
							$sql = "SELECT RollNo from tblstdadm sa
									inner join tblcuryearauto cy on cy.EduYearFrom = sa.EduYearFrom
									where sa.Div = '{$divn}' and REPLACE(sa.Year,'.','') = '{$EduYear}' 
									order by Cast(RollNo as UNSIGNED)" ;
							}
							else{
							$sql = "SELECT RollNo from tblstdadm sa
									inner join tblcuryearauto cy on cy.EduYearFrom = sa.EduYearFrom
									where sa.Div = '{$divn}' and REPLACE(sa.Year,'.','') = '{$EduYear}' 
									and sa.Dept = {$DeptID}
									order by Cast(RollNo as UNSIGNED)" ;
							}
							//echo $sql;
							$result1 = $mysqli->query( $sql );
							while( $row = $result1->fetch_assoc() ) {
								extract($row);
								$strSelect2 = $strSelect2 . "<option ";
								if($maxrollno == $RollNo){
									$strSelect2 = $strSelect2 . ' selected ';
								}
								$strSelect2 = $strSelect2 . " value='{$RollNo}'>{$RollNo}</option>";
							}
							$strSelect1 = $strSelect1 . " >";
							echo $strSelect1 . $strSelect2 . "</select>";
							echo "</td>";
						echo "</tr>";	
					}
				?>
				</table>
		</div>
	</div>
</form>

