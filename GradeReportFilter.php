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
<form action="GradeReportFilterMain.php" method="post" onsubmit='showreport();'>
<body>
<script>
function showreport(){
	//window.open('msppagenew.php');
	window.open('msppage.php?div=' + document.getElementById('ddldiv').value + 
							'&eduyear=' + document.getElementById('ddlAcadYear').value +
							'&deptid=' + document.getElementById('ddldept').value +
							'&year=' + document.getElementById('ddlYearID').value,'_blank');							
}

  $(document).ready(function() {
    $("#ddlExamID").change(function(){
		var skillsSelect = document.getElementById("ddlExamID");
		var selectedText = skillsSelect.options[skillsSelect.selectedIndex].text;
		$("#examname_hidden").val(selectedText);
    });
    $("#ddlYear").change(function(){
		var YearSelect = document.getElementById("ddlYear");
		var selectedText = YearSelect.options[YearSelect.selectedIndex].text;
		$("#year_hidden").val(selectedText);
    });
  });

</script>
	<br /><br />	<br />
	<h3 class="page-title">Result Analysis</h3>
	<h3 class="page-title" style="float:right;margin-top:-40px;"><a href="MainMenuMain.php">Back</a></h3>
		<table cellpadding="10" cellspacing="0" border="0" class="tab_split" style="width:70%">
			<tr >
				<td class="form_sec span1"><b>Dept</b></td>
				<td class="form_sec span1">
					<?php
					$setdisabled = '0';
					$strSelect1 = '';
					$strSelect2 = '';
					include 'db/db_connect.php';
					$strSelect1 = "<select id='ddldept' onchange='showdept();' name='ddldept' style='margin-top:10px;width:120px;'";
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
				<input type="hidden" name="hdnyear" id="year_hidden">
				</td>
				<td class="form_sec span1"><b>Academic Year</b></td>
				<td class="form_sec span1">
					<select id="ddlAcadYear" name="ddlAcadYear" style="margin-top:10px;width:120px;">
							<option value="2014-2015">2014-15</option>
							<option value="2015-2016">2015-16</option>
							<option value="2016-2017">2016-17</option>
					</select>
				</td>
				<td class="form_sec span1"><b>Educational Year</b></td>
				<td class="form_sec span1">
					<select id="ddlYearID" name="ddlYear" style="margin-top:10px;width:120px;">
						<!-- <option value='FE'>FE</option>"; -->
						<option value='FE'>F.E.</option>"; 
						<option value='SE'>S.E.</option>"; 
						<option value='TE'>T.E.</option>"; 
						<option value='BE'>B.E.</option>"; 
					</select>
					<input type="hidden" name="hdnyear" id="year_hidden">
				</td>
				<td class="form_sec span1"><b>Div</b></td>
				<td class="form_sec span1">
					<select id="ddldiv" name="ddldiv" style="margin-top:10px;width:70px;">
							<option value="A">A</option>
							<option value="B">B</option>
							<option value="C">C</option>
							<option value="D">D</option>
							<option value="E">E</option>
							<option value="F">F</option>
							<option value="G">G</option>
							<option value="H">H</option>
							<option value="I">I</option>
					</select>
				</td>
			</tr>						
		</table>
		<br/>
		<table cellpadding="10" cellspacing="0" border="0" class="tab_split" style="width:77%">
			<tr >
				<td class="form_sec span1">
					<input type="submit" name="btnSelect" value="Show Grade Report" title="Show Grade Report" class="btn btn btn-success" />
				</td>								
			</tr>
		</table>
		
	<br />
	<br />
</body>	
</form>
