<?php
//include database connection
include 'db/db_connect.php';

?>

<form action="" method="post">
	<script>
		function sendtoatt() {
			if(document.getElementById('ddlYear').value == ''){
				alert('Please select a Year.');
				return false;
			}
			if(document.getElementById('ddldept').value == ''){
				alert('Please select a Department.');
				return false;
			}
			if(document.getElementById('ddldiv').value == ''){
				alert('Please select a Division.');
				return false;
			}
			var subvalue = document.getElementById("ddldept").value;
			var subtext = ddldept.options[ddldept.selectedIndex].text;
			window.open('AllInsemMarksReport.php?div=' + document.getElementById('ddldiv').value + '&year=' + document.getElementById('ddlYear').value + '&dept=' + document.getElementById('ddldept').value + '&deptname=' + subtext );
			return false;
			//document.getElementById('SelYear').value
			//document.getElementById('SelMonth').value
		}
	</script>

	<br /><br />
	<h3 class="page-title" style="margin-left:5%">In-Sem Report <?php echo $_SESSION["SESSCAPSelectedExamName"]; ?></h3>
	<h3 class="page-title" style="float:right;margin-top:-40px;"><a href="examinerAssignmentMain.php">Back</a></h3>
	<div class="row-fluid">
		<div class="span10" style="margin-left:5%"></div>
		<br/><br/>
		<div class="v_detail" style="margin-left:5%">
			<table cellpadding="10" cellspacing="0" border="0" width="50%" class="tab_split">
				<tr>
					<td class="form_sec span4">Select Year</td>
					<td>
					<select id="ddlYear" name="ddlYear" style="margin-top:10px;width:120px;" required >
						<option value="">Select Year</option>
						<option value="F.E.">F.E.</option>; 
						<option value="S.E.">S.E.</option>; 
						<option value="T.E.">T.E.</option>; 
						<option value="B.E.">B.E.</option>; 
						<option value="M.E.">M.E.</option>; 
					</select>					
					</td>
				</tr>	
				<tr>
					<td class="form_sec span4">Select Department</td>
					<td>
					<?php
						if(!isset($_SESSION)){
							session_start();
						}
						include 'db/db_connect.php';
						$strSelect1 = "<select id='ddldept' name='ddldept' style='width:120px;'";
						$strSelect2 = "<option value='0'>Select Dept</option>";
						$query = "SELECT DeptID,DeptName AS Department FROM tbldepartmentmaster where coalesce(teaching,0) = 1 ";
								//echo $query;
								$result = $mysqli->query( $query );
								$num_results = $result->num_rows;
								if( $num_results ){
									while( $row = $result->fetch_assoc() ){
										extract($row);
										$strSelect2 = $strSelect2 . "<option ";
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
				<tr>
					<td class="form_sec span4">Select Division</td>
					<td>
					<select id="ddldiv" name="ddldiv"  required >
						<option value="">Select Division</option>
						<option value="ALL" <?php if(isset($_POST['ddldiv'])){if($_POST['ddldiv'] == "ALL") echo "selected";} ?>>ALL</option>
						<option value="A" <?php if(isset($_POST['ddldiv'])){if($_POST['ddldiv'] == "A") echo "selected";} ?>>A</option>
						<option value="B" <?php if(isset($_POST['ddldiv'])){if($_POST['ddldiv'] == "B") echo "selected";} ?>>B</option>
						<option value="C" <?php if(isset($_POST['ddldiv'])){if($_POST['ddldiv'] == "C") echo "selected";} ?>>C</option>
						<option value="D" <?php if(isset($_POST['ddldiv'])){if($_POST['ddldiv'] == "D") echo "selected";} ?>>D</option>
						<option value="E" <?php if(isset($_POST['ddldiv'])){if($_POST['ddldiv'] == "E") echo "selected";} ?>>E</option>
						<option value="F" <?php if(isset($_POST['ddldiv'])){if($_POST['ddldiv'] == "F") echo "selected";} ?>>F</option>
						<option value="G" <?php if(isset($_POST['ddldiv'])){if($_POST['ddldiv'] == "G") echo "selected";} ?>>G</option>
						<option value="H" <?php if(isset($_POST['ddldiv'])){if($_POST['ddldiv'] == "H") echo "selected";} ?>>H</option>
						<option value="I" <?php if(isset($_POST['ddldiv'])){if($_POST['ddldiv'] == "I") echo "selected";} ?>>I</option>
					</select>
					</td>
				</tr>	
				<tr>
					<td class="form_sec span4"></td>
					<td>
						<input type="button" name='btnUpdate' value='Go' title='Update' onclick='return sendtoatt();' class='btn btn-mini btn-success' />
						</td>
				</tr>		
			</table>
		</div>
	</div>
</form>
