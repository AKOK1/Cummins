<?php
//include database connection
include 'db/db_connect.php';
 
// if the form was submitted/posted, update the record
 if($_POST)
	{
			if (isset($_POST['chkTeachingYesNO'])) {
				$tmpchkTeachingYesNO = '1';
			}
			else
				$tmpchkTeachingYesNO = '0';
		
		if ($_POST['txtDesigID'] == "I") {
			$sql = "Insert into tbldesignationmaster ( Designation,desigcadre, created_by, created_on, updated_by, Updated_on) Values ( ?,?,'Admin', CURRENT_TIMESTAMP, 'Admin', CURRENT_TIMESTAMP)";
			$stmt = $mysqli->prepare($sql);
			$stmt->bind_param('ss', $_POST['txtDesignation'],$_POST['ddlcadre']);
		}
		else {
			$sql = "UPDATE  tbldesignationmaster
						Set  Designation = ?
							 ,desigcadre = ?
							,updated_by = 'Admin'
							,updated_on = CURRENT_TIMESTAMP
						Where DesigID = ?";
				//echo $sql;
				$stmt = $mysqli->prepare($sql);
				$stmt->bind_param('sss', $_POST['txtDesignation'],$_POST['ddlcadre'],$_POST['txtDesigID']);
			}
		
		// execute the update statement
		if($stmt->execute()){
			header('Location: DesignationListMain.php?'); 
			// close the prepared statement
		}else{
			echo $mysqli->error;
			die("Unable to update.");
		}
	}
else 
	{
		if ($_GET['DesigID'] == "I") {
			$sql = "SELECT 'I' as DesigID, '' as Designation, '' as desigcadre " ;
		}
		Else
		{  
			$sql = " SELECT DesigID, Designation, desigcadre FROM tbldesignationmaster Where DesigID = " . $_GET['DesigID'];
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

<form action="DesignationMaintMain.php?DesigID=<?php echo $_GET['DesigID']; ?>" method="post">
	<br /><br />
	<h3 class="page-title" style="margin-left:5%">Designation Maintenance</h3>
	<div class="row-fluid">
		<div class="v_detail" style="margin-left:5%">
			<table cellpadding="10" cellspacing="0" border="0" width="50%" class="tab_split">
				<tr>
					<td class="form_sec span4">&nbsp;</td>
					<td>
						<div class="span10">
							<input type="hidden" name="txtDesigID" value="<?php echo $_GET['DesigID'] ?>" />
							<?php 
							if(($_SESSION["ReadAccess"] == "Yes") && ($_SESSION["WriteAccess"] == "Yes")){
								echo "<input type='submit' name='btnUpdate' value='Save' title='Update' class='btn btn-mini btn-success' />";
							}
							?>
							<a href="DesignationListMain.php" class="btn btn-mini btn-warning">Cancel</a>
						</div>
					</td>								
				</tr>
				<tr>
					<td class="form_sec span4">Designation Name</td>
					<td>
						<input type="text" maxlength="100" name="txtDesignation" class="textfield" required  style="width:300px;" value="<?php echo "{$Designation}" ?>"/>
					</td>
				</tr>						
				<tr>
					<td class="form_sec span4">Cadre</td><td>
						<select name="ddlcadre" style="width:90px;">
							<option value="Select" <?php if($desigcadre == "Select") echo "selected"; ?>>Select</option>
							<option value="1" <?php if($desigcadre == "1") echo "selected"; ?>>1</option>
							<option value="2" <?php if($desigcadre == "2") echo "selected"; ?>>2</option>
							<option value="3" <?php if($desigcadre == "3") echo "selected"; ?>>3</option>
							<option value="4" <?php if($desigcadre == "4") echo "selected"; ?>>4</option>
							<option value="5" <?php if($desigcadre == "5") echo "selected"; ?>>5</option>
							<option value="6" <?php if($desigcadre == "6") echo "selected"; ?>>6</option>
							<option value="7" <?php if($desigcadre == "7") echo "selected"; ?>>7</option>
							<option value="8" <?php if($desigcadre == "8") echo "selected"; ?>>8</option>
							<option value="9" <?php if($desigcadre == "9") echo "selected"; ?>>9</option>
							<option value="10" <?php if($desigcadre == "10") echo "selected"; ?>>10</option>
							<option value="11" <?php if($desigcadre == "11") echo "selected"; ?>>11</option>
							<option value="12" <?php if($desigcadre == "12") echo "selected"; ?>>12</option>
							<option value="13" <?php if($desigcadre == "13") echo "selected"; ?>>13</option>
							<option value="14" <?php if($desigcadre == "14") echo "selected"; ?>>14</option>
							<option value="15" <?php if($desigcadre == "15") echo "selected"; ?>>15</option>
							<option value="16" <?php if($desigcadre == "16") echo "selected"; ?>>16</option>
							<option value="17" <?php if($desigcadre == "17") echo "selected"; ?>>17</option>
							<option value="18" <?php if($desigcadre == "18") echo "selected"; ?>>18</option>
							<option value="19" <?php if($desigcadre == "19") echo "selected"; ?>>19</option>
							<option value="20" <?php if($desigcadre == "20") echo "selected"; ?>>20</option>
							<option value="99" <?php if($desigcadre == "99") echo "selected"; ?>>99</option>
						</select>
					</td>
				</tr>	
			</table>
		</div>
	</div>
</form>

