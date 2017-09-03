<form name="myform" action="" method="post" onsubmit='showLoading();'>
	<head>
	<style type="text/css">
		  #loadingmsg {
		  color: black;
		  background: #fff; 
		  padding: 10px;
		  position: fixed;
		  top: 50%;
		  left: 50%;
		  z-index: 100;
		  margin-right: -25%;
		  margin-bottom: -25%;
		  }
		  #loadingover {
		  background: black;
		  z-index: 99;
		  width: 100%;
		  height: 100%;
		  position: fixed;
		  top: 0;
		  left: 0;
		  -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=80)";
		  filter: alpha(opacity=80);
		  -moz-opacity: 0.8;
		  -khtml-opacity: 0.8;
		  opacity: 0.8;
		}
	</style>
		<script year="text/javascript">     
		function clearbatch(stdadmid){
			if(confirm('Clear selected students division?'))
			{
				$('#clearclicked').val(stdadmid);			
				document.myform.submit();
			}
		}
	 function AddToList() {
			if(confirm('Assign selected students to selected division?'))
			{
				
			}
			else
				return false;
		 if($('#ddlDiv').val() == '')
			alert('Please select a Division.');
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
				if($('#selectedids').val() == '')
					alert('Please select at least one Student.');
				else{
					return true;
					//document.myform.submit();
					//alert("UPDATED SUCCESSFULLY");
				}
		}
	 }
	 function setall(chkmain) {
			if ($(chkmain).val() == 'Check All') {
				$('.checkbox-class').attr('checked', 'checked');
				$(chkmain).val('Uncheck All');
			} else {
				$('.checkbox-class').removeAttr('checked');
				$(chkmain).val('Check All');
			}
	 }
	function showLoading() {
		document.getElementById('loadingmsg').style.display = 'block';
		document.getElementById('loadingover').style.display = 'block';
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
</script>
</head>
<body>
<?php
	//include database connection
	include 'db/db_connect.php';
	if(!isset($_SESSION)){
		session_start();
	}
?>
<?php
	if($_POST['clearclicked'] != ''){
		if(isset($_POST['selectedids'])){
			$sql = "Update tblstdadm set `Div` = NULL where  StdAdmID = ?";
			$stmt = $mysqli->prepare($sql);
			$stmt->bind_param('i', $_POST["clearclicked"]);
			if($stmt->execute()){
				//echo "done";
					echo '<script>alert("UPDATED SUCCESSFULLY");</script>';
			} else { echo $mysqli->error;
				///die("Unable to update.");
			}
		}
	}
	if(isset($_POST['btnSave'] )){
		if(isset($_POST['selectedids'] )){
			if($_POST['selectedids'] != ''){
				   //echo "a " . $_POST['ddlDiv'] . "<br/>";
				   //echo "b " . $_POST['selectedids'] . "<br/>";
				   //die;			
					$mysqli->query("SET @i_div  = '" . $_POST["ddlDiv"] . "'");
					$mysqli->query("SET @i_ItemIDs   = '" .  $_POST['selectedids'] . "'");
					$result1 = $mysqli->query("CALL SP_SaveDiv(@i_div, @i_ItemIDs)");
					echo '<script>alert("UPDATED SUCCESSFULLY");</script>';
			}
		}
	}
?>
<div id='loadingmsg' style='display: none;'>Please wait...</div>
<div id='loadingover' style='display: none;'></div>
	<br /><br />
	<h3 class="page-title">Assign Division</h3>
	<h3 class="page-title" style="float:right;margin-top:-40px;"><a href="MainMenuMain.php">Back</a></h3>
	<input type="hidden" name="selectedids" id="selectedids" value=''/>
	<input type="hidden" name="clearclicked" id="clearclicked" value=''/>
	<?php
		//echo isset($_POST['selectedyear']);
		//echo isset($_POST['selecteddiv']);
	?> 
		<div>
		<div style="float:left;margin-left:20px;margin-top:5px">
				<select id="ddlyear" name="ddlyear" style="width:150px"  required onchange="showyear();">
				<option value="">Select Year</option>
				<option value="F.E." <?php if(isset($_POST['ddlyear'])){if($_POST['ddlyear'] == "F.E.") echo "selected";} ?>>F.E.</option>
				<option value="S.E." <?php if(isset($_POST['ddlyear'])){if($_POST['ddlyear'] == "S.E.") echo "selected";} ?>>S.E.</option>
				<option value="T.E." <?php if(isset($_POST['ddlyear'])){if($_POST['ddlyear'] == "T.E.") echo "selected";} ?>>T.E.</option>
				<option value="B.E." <?php if(isset($_POST['ddlyear'])){if($_POST['ddlyear'] == "B.E.") echo "selected";} ?>>B.E.</option>
				<option value="M.E." <?php if(isset($_POST['ddlyear'])){if($_POST['ddlyear'] == "M.E.") echo "selected";} ?>>M.E.</option>
			</select>
		</div>
		<div style="float:left;margin-left:5px;margin-top:5px">
		<?php
				$setdisabled = '0';
				$strSelect1 = '';
				$strSelect2 = '';
				include 'db/db_connect.php';
				$strSelect1 = "<select id='ddldept' name='ddldept' required style='width:120px;' required ";
				$strSelect2 = "<option value=''>Select Dept</option>";
				$query = "SELECT DeptID,DeptName AS Department FROM tbldepartmentmaster where coalesce(teaching,0) = 1 and DeptName <> 'BSH'";
				//echo $query;
				$result = $mysqli->query( $query );
				$num_results = $result->num_rows;
				if( $num_results ){
					while( $row = $result->fetch_assoc() ){
						extract($row);
						$strSelect2 = $strSelect2 . "<option ";
						if(isset($_SESSION["SESSUserDept"]))
						{ 
							if(isset($_POST["ddldept"])){
								if($_POST["ddldept"] == $DeptID){
									$strSelect2 = $strSelect2 . ' selected ';
								}								
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
			<select id='ddlShift' name='ddlShift' style='width:120px' required>
				<option value=''>Select Shift</option>
				<option value='1' <?php if(isset($_POST["ddlShift"])){if($_POST['ddlShift'] == "1") echo "selected";} ?>>1</option>
				<option value='2' <?php if(isset($_POST["ddlShift"])){if($_POST['ddlShift'] == "2") echo "selected";} ?>>2</option>
			</select>	
		</div>
		<div style="float:left;margin-left:20px;margin-top:5px">
			<input type="submit" name="btnSearch" value="Search" title="Update" class="btn btn-mini btn-success" />
		</div>
	</div>
	<br/><br/><br/>
	<div class="row-fluid">
			<table cellpadding="10" cellspacing="0" border="0" class="tab_split">
				<tr>
					<th style='width:5%'>Sr. No.</th>
					<th style='width:8%'>CNUM</th>
					<th style='width:10%'>Remark</th>
					<th style='width:15%'>Full Name</th>
					<th style='width:5%'>Div.</th>
				<?php
					If (isset($_POST['btnSearch']) or isset($_POST['selectedids']) || ($_POST['clearclicked'] != '')){
						echo "<th style='width:8%'>Check
						<input onclick='setall(this);' class='checkbox-class' type='checkbox' value='Check All' /></th>
						<th>Clear</th>			
						<th>
							<input id='btnSave' name='btnSave' style='margin-top:-7px;' onclick='return AddToList();' type='submit' value='Assign Division' />";
						?>
								<select id='ddlDiv' name='ddlDiv' style='width:80px'>
									<option value=''>Select Div</option>
									<option value='A'>A</option>
									<option value='B'>B</option>
									<option value='C'>C</option>
									<option value='D'>D</option>
									<option value='E'>E</option>
									<option value='F'>F</option>
									<option value='G'>G</option>
									<option value='H'>H</option>
									<option value='I'>I</option>
								</select>
						<?php	
						echo "</th>";
						echo "</tr>";
						echo "</table>";
						// Assign to all subjects except elective?<input class='checkbox-class' type='checkbox' />
						?>
						<div class="v_detail">
						<?php
						If (($_POST["ddldept"] != '') and ($_POST['ddlShift'] != ''))
						{				
							include 'db/db_connect.php';
							$query = "SELECT SA.StdAdmID, CONCAT(Surname, ' ', FirstName) AS NAME,SA.RollNo, S.CNUM, SA.Div ,stdremark,createddate
							FROM tblstdadm SA 
							INNER JOIN tblstudent S ON SA.StdID = S.StdId
							INNER JOIN tblcuryear cy on cy.EduYearFrom = SA.EduYearFrom and cy.EduYearTo = SA.EduYearTo
							WHERE SA.Dept = " . $_POST["ddldept"] . " and SA.Year = '" . $_POST["ddlyear"] ."'
							and SA.shift = " . $_POST["ddlShift"] ."
							order by  createddate,NAME";
							//echo $query;
							$result = $mysqli->query( $query );
							$num_results = $result->num_rows;
							$i = 1;
							echo "<table cellpadding='10' cellspacing='0' border='0' class='tab_split'>";
							if( $num_results ){
								while( $row = $result->fetch_assoc() ){
									extract($row);
								  echo "<TR class='odd gradeX'>";
								  echo "<td style='width:5%'>{$i}</td>";
								  $i = $i + 1;
								  echo "<td style='width:10%'>{$CNUM}</td>";
								  echo "<td style='width:10%'>{$stdremark}</td>";
								  echo "<td style='width:20%'>{$NAME}</td>";
								  echo "<td style='width:5%'>{$Div}</td>";
								  echo "<td style='width:10%'><input id={$StdAdmID} class='checkbox-class' type='checkbox' value='0' /></td>";
								   echo "<td><a id='btnClear' name='btnClear' onclick='clearbatch({$StdAdmID});' class='btn btn-primary' ><i class='icon-remove icon-white'></i></a> </td>";
								  echo "</TR>";
								  //href='CreateBatchUpd.php?YSID={$YSID}&StdAdmID={$StdAdmID}'
								}
							}
							else{
								echo "<TR class='odd gradeX'>";
								echo "<td>No records found.</td>";
								echo "<td></td>";
								echo "<td></td>";
								echo "</TR>";
							}
							echo "</table>";
						}
						else {
							echo "<TR class='odd gradeX'>";
							echo "<td>Please select Department and Division.</td>";
							echo "<td></td>";
							echo "<td></td>";
							echo "</TR>";
						}
				}
			?> 
		</div>
	</div>
</body>
</form>
