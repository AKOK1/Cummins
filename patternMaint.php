
<?php
//include database connection
include 'db/db_connect.php';
 
// if the form was submitted/posted, update the record
 if($_POST)
	{
			
if(!isset($_SESSION)){
			session_start();
	}
	
	if(isset($_POST['ddlacadyear'])){
		$_SESSION["quizselectedexam"] = $_POST['ddlacadyear'];
	}
	if(isset($_POST['ddleduyear'])){
		$_SESSION["quizselectedyear"] = $_POST['ddleduyear'];
	}
	if(isset($_POST['txtpatid'])){
		$_SESSION["sesspatid"] = $_POST['txtpatid'];
	}
	if(isset($_POST['ddldept'])){
		$_SESSION["ddldeptpat"] = $_POST['ddldept'];
	}
	
	// echo $_SESSION["quizselectedyear"];
	// die;
	
		if ($_POST['txtpatid'] == "I") {
			if($_POST['ddldept'] == 'ALL'){
				if($_POST['ddleduyear'] == 'F.E.'){
					$sql = "Insert into tblpatternmaster ( acadyear, eduyear, teachingpat,created_by, created_on, updated_by, Updated_on,deptid) 
					select ?, ?, ?, 'Admin', CURRENT_TIMESTAMP, 'Admin', CURRENT_TIMESTAMP,DeptID
					FROM tbldepartmentmaster where coalesce(teaching,0) = 1";
					$stmt = $mysqli->prepare($sql);
					$stmt->bind_param('sss', $_POST['ddlacadyear'], $_POST['ddleduyear'], $_POST['txtteachingpat']);
				}
				else{
					$sql = "Insert into tblpatternmaster ( acadyear, eduyear, teachingpat,created_by, created_on, updated_by, Updated_on,deptid) 
					select ?, ?, ?, 'Admin', CURRENT_TIMESTAMP, 'Admin', CURRENT_TIMESTAMP,DeptID
					FROM tbldepartmentmaster where coalesce(teaching,0) = 1 and DeptName <> 'BSH'";
					$stmt = $mysqli->prepare($sql);
					$stmt->bind_param('sss', $_POST['ddlacadyear'], $_POST['ddleduyear'], $_POST['txtteachingpat']);
				}
			}
			else{
				$sql = "Insert into tblpatternmaster ( acadyear, eduyear, teachingpat,created_by, created_on, updated_by, Updated_on,deptid) Values ( ?, ?, ?, 'Admin', CURRENT_TIMESTAMP, 'Admin', CURRENT_TIMESTAMP,?)";
				$stmt = $mysqli->prepare($sql);
				$stmt->bind_param('sssi', $_POST['ddlacadyear'], $_POST['ddleduyear'], $_POST['txtteachingpat'], $_POST['ddldept']);
			}
//Values ( ?, ?, ?, 'Admin', CURRENT_TIMESTAMP, 'Admin', CURRENT_TIMESTAMP,?)";

		}
		else {
			$sql = "UPDATE  tblpatternmaster
						Set acadyear = ?
							,eduyear = ?
							,teachingpat = ?
							,updated_by = 'Admin'
							,updated_on = CURRENT_TIMESTAMP
							,deptid = ?
						Where patid = ?";
						
				
				$stmt = $mysqli->prepare($sql);
				$stmt->bind_param('sssii',  $_POST['ddlacadyear'], $_POST['ddleduyear'], $_POST['txtteachingpat'], $_POST['ddldept'], $_POST['txtpatid'] );

				}
		
	
		// execute the update statement
		if($stmt->execute()){
			header('Location: PatternListMain.php?'); 
			// close the prepared statement
		}else{
			die("Unable to update.");
		}
	}
else 
	{
		if ($_GET['patid'] == "I") {
			$sql = "SELECT 'I' as patid, 'Select ' as acadyear, 'Select ' as eduyear, '' as teachingpat,'' as DeptIDVal" ;
		}
		Else
		{
			$sql = " SELECT patid, acadyear, eduyear,teachingpat,DeptID as DeptIDVal FROM tblpatternmaster Where patid = " . $_GET['patid']   ;
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

<form action="patternMaintMain.php?patid=<?php echo $_GET['patid']; ?>" method="post">
	<br /><br />
	<h3 class="page-title" style="margin-left:5%">Pattern Maintenance</h3>
	<div class="row-fluid">
		<div class="v_detail" style="margin-left:5%">
			<table cellpadding="10" cellspacing="0" border="0" width="50%" class="tab_split">
				<tr>
					<td class="form_sec span4">&nbsp;</td>
					<td>
						<div class="span10">
							<input type="hidden" name="txtpatid" value="<?php echo "{$patid}" ?>" />
							<?php 
							if(($_SESSION["ReadAccess"] == "Yes") && ($_SESSION["WriteAccess"] == "Yes")){
								echo "<input type='submit' name='btnUpdate' value='Save' title='Update' class='btn btn-mini btn-success' />";
							}
							?>
							<a href="PatternListMain.php" class="btn btn-mini btn-warning">Cancel</a>
						</div>
					</td>								
				</tr>				
				<tr>
					<td class="form_sec span4">Academic Year</td>
					<td>
						<select name="ddlacadyear" id="ddlacadyear"  style="margin-top:10px;width:120px;">  
							<option value="2017-18" <?php if($acadyear == "2017-18") echo "selected"; ?>>2017-18</option>
							<option value="2016-17" <?php if($acadyear == "2016-17") echo "selected"; ?>>2016-17</option>
							<option value="2015-16" <?php if($acadyear == "2015-16") echo "selected"; ?>>2015-16</option>
							<option value="2014-15" <?php if($acadyear == "2014-15") echo "selected"; ?>>2014-15</option>
						</select>
					</td>
				</tr>						
				<tr>
					<td class="form_sec span4">Education Year</td>
					<td>
					<select id="ddleduyear" name="ddleduyear" style="margin-top:10px;width:180px;">
						<!-- <option value='FE'>FE</option>"; -->
						<option value="F.E." <?php if($eduyear == "F.E.") echo "selected"; ?>>F.E.</option>
						<option value="S.E." <?php if($eduyear == "S.E.") echo "selected"; ?>>S.E.</option>
						<option value="T.E." <?php if($eduyear == "T.E.") echo "selected"; ?>>T.E.</option>
						<option value="B.E." <?php if($eduyear == "B.E.") echo "selected"; ?>>B.E.</option>
						<option value="M.E." <?php if($eduyear == "M.E.") echo "selected"; ?>>M.E.</option>
						<option value="F.Y." <?php if(isset($_SESSION["pmselyear"])){if($_SESSION["pmselyear"] == "F.Y.") echo "selected";} ?>>F.Y.M.Tech.</option>
						<option value="S.Y." <?php if(isset($_SESSION["pmselyear"])){if($_SESSION["pmselyear"] == "S.Y.") echo "selected";} ?>>S.Y.M.Tech.</option>
					</select>
					</td>
				</tr>	
				<tr>
					<td class="form_sec span4">Teaching Pattern</td>
					<td>
						<input maxlength="40" type="text" name="txtteachingpat" id="txtteachingpat" class="textfield" value="<?php echo "{$teachingpat}" ?>"/>
					</td>
				</tr>
				<tr>
					<td class="form_sec span4">Department</td>
					<td>
					<?php
						$setdisabled = '0';
						$strSelect1 = '';
						$strSelect2 = '';
						include 'db/db_connect.php';
						$strSelect1 = "<select id='ddldept' name='ddldept' required style='width:120px;' required ";
						$strSelect2 = "<option value='ALL'>ALL</option>";
						$query = "SELECT DeptID,DeptName AS Department FROM tbldepartmentmaster where coalesce(teaching,0) = 1";
						//echo $query;
						$result = $mysqli->query( $query );
						$num_results = $result->num_rows;
						if( $num_results ){
							while( $row = $result->fetch_assoc() ){
								extract($row);
								$strSelect2 = $strSelect2 . "<option ";
								if($DeptID == $DeptIDVal){
									$strSelect2 = $strSelect2 . ' selected ';
								}								
								$strSelect2 = $strSelect2 . " value='{$DeptID}'>{$Department}</option>";
							}
						}
						$strSelect1 = $strSelect1 . " >";
						$strSelect1 = $strSelect1 . $strSelect2;
						$strSelect1 = $strSelect1 .  "</select>";
						echo $strSelect1;			
					?>
					</td>
				</tr>
			</table>
		</div>
	</div>
</form>

