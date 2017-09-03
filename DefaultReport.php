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
<form>
<head>
<script>
function sendtoreport()
{
	var subvalue = document.getElementById("ddldept").value;
	var subtext = ddldept.options[ddldept.selectedIndex].text;
	var yearvalue = document.getElementById("ddlYear");
	var yeartext = ddlYear.options[ddlYear.selectedIndex].text;
	var divvalue = document.getElementById("ddlDiv");
	var divtext = ddlDiv.options[ddlDiv.selectedIndex].text;
	var semvalue = document.getElementById("ddlSem");
	var semtext = ddlSem.options[ddlSem.selectedIndex].text;
	var sdate = document.getElementById('datepicker1').value;
	var edate = document.getElementById('datepicker2').value;
	var ptype = document.getElementById("ddlpapertype").value;
	
	window.open('PrintDefaulter.php?deptname=' + subtext + '&dept=' + subvalue + '&year=' + yeartext + '&divn=' + divtext + '&sem=' + semtext + '&sdate=' + sdate + '&edate=' + edate + '&ptype=' + ptype);
	return false;
}

		$(function() {
		$( "#datepicker1" ).datepicker({ dateFormat: 'dd-M-yy' });
		$( "#datepicker2" ).datepicker({ dateFormat: 'dd-M-yy' });
		//$( "#datepicker1" ).appendDtpicker();
		
		});
	</script>
</head>
<body>
<div class="row-fluid">
<br/><br/><br/>
		<div style="float:left"><h3 class="page-title">Defaulter Report</h3></div>
				<div style="float:right"><h3 class='page-title' style='margin-right:30px;'><a href='MainMenuMain.php'>Back</a></h3></div>
		<br/><br/><br/><br/>
		<div style="float:left;margin-top:30px;margin-left:20px;">
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
						if(isset($_SESSION["SESSRAUserDept"]))
						{ 
							if($_SESSION["SESSRAUserDept"] == $Department) {
								$strSelect2 = $strSelect2 . ' selected ';
								$strSelect1 = $strSelect1 . " disabled";
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
		<div style="float:left;margin-left:-95px;"><tr><td class="form_sec span1" ><b>Department</b></td></tr></div>
		<div style="float:left;margin-top:30px;margin-left:20px;">
		
				<select id="ddlYear" name="ddlYear" style="width:120px" required>
					<option value="">Select Year</option>
					<option value="F.E." <?php if(isset($_SESSION["tmpselyear"])){if($_SESSION['tmpselyear'] == "F.E.") echo "selected";} ?>>F.E.</option>
					<option value="S.E." <?php if(isset($_SESSION["tmpselyear"])){if($_SESSION['tmpselyear'] == "S.E.") echo "selected";} ?>>S.E.</option>
					<option value="T.E." <?php if(isset($_SESSION["tmpselyear"])){if($_SESSION['tmpselyear'] == "T.E.") echo "selected";} ?>>T.E.</option>
					<option value="B.E." <?php if(isset($_SESSION["tmpselyear"])){if($_SESSION['tmpselyear'] == "B.E.") echo "selected";} ?>>B.E.</option>
					<option value="F.Y." <?php if(isset($_SESSION["tmpselyear"])){if($_SESSION["tmpselyear"] == "F.Y.") echo "selected";} ?>>F.Y.M.Tech.</option>
					<option value="S.Y." <?php if(isset($_SESSION["tmpselyear"])){if($_SESSION["tmpselyear"] == "S.Y.") echo "selected";} ?>>S.Y.M.Tech.</option>
				</select>
		</div>
		<div style="float:left;margin-left:-70px;"><tr><td class="form_sec span1" ><b>Year</b></td></tr></div>
		<div style="float:left;margin-top:30px;margin-left:20px;">
				<select id="ddlDiv" name="ddlDiv" style="width:130px" required>
					<option value="">Select Division</option>
					<option value="A" <?php if(isset($_SESSION["tmpseldiv"])){if($_SESSION['tmpseldiv'] == "A") echo "selected";} ?>>A</option>
					<option value="B" <?php if(isset($_SESSION["tmpseldiv"])){if($_SESSION['tmpseldiv'] == "B") echo "selected";} ?>>B</option>
					<option value="C" <?php if(isset($_SESSION["tmpseldiv"])){if($_SESSION['tmpseldiv'] == "C") echo "selected";} ?>>C</option>
					<option value="D" <?php if(isset($_SESSION["tmpseldiv"])){if($_SESSION['tmpseldiv'] == "D") echo "selected";} ?>>D</option>
					<option value="E" <?php if(isset($_SESSION["tmpseldiv"])){if($_SESSION['tmpseldiv'] == "E") echo "selected";} ?>>E</option>
					<option value="F" <?php if(isset($_SESSION["tmpseldiv"])){if($_SESSION['tmpseldiv'] == "F") echo "selected";} ?>>F</option>
					<option value="G" <?php if(isset($_SESSION["tmpseldiv"])){if($_SESSION['tmpseldiv'] == "G") echo "selected";} ?>>G</option>
					<option value="H" <?php if(isset($_SESSION["tmpseldiv"])){if($_SESSION['tmpseldiv'] == "H") echo "selected";} ?>>H</option>
					<option value="I" <?php if(isset($_SESSION["tmpseldiv"])){if($_SESSION['tmpseldiv'] == "I") echo "selected";} ?>>I</option>
				</select>
		</div>
		<div style="float:left;margin-left:-90px;"><tr><td class="form_sec span1" ><b>Division</b></td></tr></div>
		<div style="float:left;margin-top:30px;margin-left:20px;">
				<select id="ddlSem" name="ddlSem" style="width:140px" required>
					<option value="">Select Semester</option>
					<option value="1" <?php if(isset($_SESSION["tmpselsem"])){if($_SESSION['tmpselsem'] == "1") echo "selected";} ?>>1</option>
					<option value="2" <?php if(isset($_SESSION["tmpselsem"])){if($_SESSION['tmpselsem'] == "2") echo "selected";} ?>>2</option>
				</select>
		</div>
		<div style="float:left;margin-left:-100px;"><tr><td class="form_sec span1" ><b>Semester</b></td></tr></div>
		<div style="float:left;margin-top:30px;margin-left:20px;">
			<input type="text" maxlength="17" id='datepicker1' name="dtPubStart" class="textfield" style="width:120px;" value="<?php  echo (date('d-M-Y')) ?>"/>
		</div>
		<div style="float:left;margin-left:-100px;"><tr><td class="form_sec span1" ><b>Start Date</b></td></tr></div>
		<div style="float:left;margin-top:30px;margin-left:20px;">
			<input type="text" maxlength="17" id='datepicker2' name="dtPubEnd" class="textfield" style="width:120px;" value="<?php  echo (date('d-M-Y')) ?>"/>
		</div>
		<div style="float:left;margin-left:-100px;"><tr><td class="form_sec span1" ><b>End Date</b></td></tr></div>
		<div style="float:left;margin-top:30px;margin-left:20px;">
			<select id="ddlpapertype" name="ddlpapertype"  required >
				<option value="TH" <?php if(isset($_POST['ddlpapertype'])){if($_POST['ddlpapertype'] == "TH") echo "selected";} ?>>TH</option>
				<option value="PR" <?php if(isset($_POST['ddlpapertype'])){if($_POST['ddlpapertype'] == "PR") echo "selected";} ?>>PR</option>
				<option value="TT" <?php if(isset($_POST['ddlpapertype'])){if($_POST['ddlpapertype'] == "TT") echo "selected";} ?>>TT</option>
			</select>
		</div>
		<div style="float:left;margin-left:-180px;"><tr><td class="form_sec span1" ><b>Select Papertype</b></td></tr></div>
		<div style="float:left;margin-top:30px;margin-left:20px;">
			<input type="button" name="btnreport" value="View Report" class="btn btn btn-success" onclick="return sendtoreport();" />
		</div>
	</div>	
</body>	
</form>
