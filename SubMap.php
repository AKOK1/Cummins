<form name="myform" action="SubMapMain.php" method="post">
<?php
		if(!isset($_SESSION)){
			session_start();
		}
		if(isset($_POST['ddlyear'])){
			$selyear = $_POST['ddlyear'];
		}
		if(isset($_POST['ddlSem'])){
			$selsem = $_POST['ddlSem'];
		}		
		if(isset($_POST['ddldept'])){
			$_SESSION["seldeptid"] = $_POST['ddldept'];
		}		
		if(isset($_GET['Year'])){
			//$selyear = substr($_GET['Year'],0,strpos($_GET['Year'],' '));
			$selyear = $_GET['Year'];
			$selsem = substr($_GET['Year'],strpos($_GET['Year'],' - ')+3);
		}
		if(isset($_GET['Year']))
		{
			$showresult = 1;
		}
		else
			$showresult = 0;
		//echo $selyear;
?>

	<head>
	   <link rel="stylesheet" href="css/jquery-ui.css">
	   <script src="js/jquery-1.10.2.js"></script>
       <script src="js/jquery-ui.js"></script>
		<script year="text/javascript" src="js/jquery.min.js"></script>
		<script year="text/javascript">     
		 function showyear(){
			 $('#selectedyear').val($('#ddlyear').val());
		 }
		 function AddToList() {
				var q = "";
				var t = "";
					$("input[type=checkbox]:checked").each(function(){
						if (q != "") 
							q += ",";
						if($(this).attr("id") != undefined)
							q+= $(this).attr("id");

						if (t != "") 
							t += ",";
						if($(this).attr("title") != undefined)
							t+= $(this).attr("title");
						});
						if (q != "") 
							q += ",";
						if (t != "") 
							t += ",";
					$('#selectedids').val(q);
					$('#selectedtypes').val(t);
					//alert($('#selectedtypes').val());
					document.myform.submit();
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


	<br /><br />
	<h3 class="page-title">Subject Mapping</h3>
	<h3 class="page-title" style="float:right;margin-top:-40px;"><a href="MainMenuMain.php">Back</a></h3>
	<input type="hidden" name="selectedids" id="selectedids"/>
	<input type="hidden" name="selectedtypes" id="selectedtypes"/>

	<div>
		<center>
			<label id="lblFailure" style="margin-left:10px;color:red;display:none;font-size:large" ></label>
			<label id="lblSuccess" style="margin-left:10px;color:green;display:none" >Saved successfully.</label>
		</center>
	</div>
	<br/>
	<div>
		<div style="float:left;margin-left:50px;margin-top:5px">
			<?php
				//include database connection
				include 'db/db_connect.php';
				if(!isset($_SESSION)){
					session_start();
				}				
				if(!isset($deptid)){
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
				}
				$setdisabled = '0';
				$strSelect1 = '';
				$strSelect2 = '';
				include 'db/db_connect.php';
				$strSelect1 = "<select id='ddldept' name='ddldept' style='width:160px;' required ";
					//if($_SESSION["SESSRAUserDept"] == $Department) 
					//	echo ' disabled';
				$strSelect2 = "<option value=''>Select Department</option>";
				$query = "SELECT DeptID,DeptName AS Department FROM tbldepartmentmaster where coalesce(teaching,0) = 1 ";
						//echo $query;
						$result = $mysqli->query( $query );
						$num_results = $result->num_rows;
						if( $num_results ){
							while( $row = $result->fetch_assoc() ){
								extract($row);
								$strSelect2 = $strSelect2 . "<option ";
								if((isset($_SESSION["SESSUserDept"])) and (!isset($_SESSION["seldeptid"])))
								{ 
									if($_SESSION["SESSRAUserDept"] == $Department){
										$strSelect2 = $strSelect2 . ' selected ';
										$strSelect1 = $strSelect1 . " disabled";
									}
									else if(isset($_SESSION["seldeptid"])){
										if($_SESSION["seldeptid"] == $DeptID){
											$strSelect2 = $strSelect2 . ' selected ';
										}								
									}
								} 						
								else if(isset($_SESSION["seldeptid"])){
									if($_SESSION["seldeptid"] == $DeptID){
										$strSelect2 = $strSelect2 . ' selected ';
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
			<select id="ddlyear" name="ddlyear"  required onchange="showyear();">
				<option value="">Select Year</option>
				<option value="FE" <?php if(isset($selyear)){if($selyear == "FE") echo "selected";} ?>>F.E.</option>
				<option value="SE" <?php if(isset($selyear)){if($selyear == "SE") echo "selected";} ?>>S.E.</option>
				<option value="TE" <?php if(isset($selyear)){if($selyear == "TE") echo "selected";} ?>>T.E.</option>
				<option value="BE" <?php if(isset($selyear)){if($selyear == "BE") echo "selected";} ?>>B.E.</option>
				<option value="FY" <?php if(isset($selyear)){if($selyear == "FY") echo "selected";} ?>>F.Y.M.Tech.</option>
				<option value="SY" <?php if(isset($selyear)){if($selyear == "SY") echo "selected";} ?>>S.Y.M.Tech.</option>
			</select>
		</div>

		<div style="float:left;margin-left:20px;margin-top:5px">
			<input type="submit" name="btnSearch" value="Search" title="Update" class="btn btn-mini btn-success" />
		</div>
	</div>
	<br/><br/><br/><br/>

	<div class="row-fluid" style="margin-left:1%;margin-top:-15px">
	    <div class="span7 v_detail" style="overflow:scroll">
            <div style="float:left">
				<label><b>Available Subjects</b></label>
            </div>
			<table cellpadding="10" cellspacing="0" border="0" width="90%" class="tab_split">
				<tr>
					<th>Sr. No.</th>
					<th>Subject</th>
					<th><strong>Action</strong></th>
				<?php
				// Create connection
					if((isset($_SESSION["seldeptid"]) and ($_SESSION["seldeptid"] != "0")) OR (isset($_SESSION["SESSUserDept"]))){
						if((isset($_SESSION["seldeptid"]) and ($_SESSION["seldeptid"] != "0"))){
							$deptid = $_SESSION["seldeptid"];
						}
						else{
							$deptid = $_SESSION["SESSRAUserDeptID"];
						}
					}
				
				include 'db/db_connect.php';
				$sql = 'SELECT EduYearFrom, EduYearTo FROM tblcuryear WHERE EduYearTo = (SELECT MAX(EduYearTo) FROM tblcuryear)';
				//echo $sql;
				$result = $mysqli->query( $sql );
				$num_results = $result->num_rows;
				if( $num_results ){
					while( $row = $result->fetch_assoc() ){
						extract($row);
					}
				}
					if(isset($_POST['selectedids'])){	
						if($_POST['selectedids'] <> ''){
								//echo "B " . $_POST['selectedids'] . "<br/>";
							 //echo "C " . $_POST['selectedtypes'] . "<br/>";
							 //echo "D " . $_SESSION["seldeptid"] . "<br/>";
							 //echo $selyear;
							 //die;
							if($_POST['selectedids'] != ''){
								$mysqli->query("SET @i_ItemIDs   = '" .  $_POST['selectedids'] . "'");
								$mysqli->query("SET @i_ItemTypes   = '" .  $_POST['selectedtypes'] . "'");
								$mysqli->query("SET @i_deptname   = '" .  $_SESSION["seldeptid"] . "'");
								$mysqli->query("SET @i_enggyear   = '" .  $selyear . "'");
								$result1 = $mysqli->query("CALL SP_SaveYearStruct(@i_ItemIDs, @i_ItemTypes,@i_deptname,@i_enggyear)");
							}
		
						}					
					}
				
				echo "<th><input onclick='setall(this);' class='checkbox-class' type='checkbox' value='Check All' />
				<input style='margin-top:-7px;' id='btnAdd' onclick='AddToList();' type='button' value='Add' />";
				echo "</th>";
				echo "</tr>";

			If ((isset($_POST['btnSearch'])) or (isset($_POST['btnSave'])) or (isset($_POST['selectedids'])) or ($showresult == 1))
			{
				include 'db/db_connect.php';
				if($selyear == 'FE'){
					$query22 = "SELECT papertype, PaperID, SubjectName FROM vwhodsubjectsauto
				 	where EnggYear = '" . $selyear . "' AND DeptID = ". $deptid . " AND CONCAT(coalesce(papertype,''),PaperID) NOT IN (
					SELECT CONCAT(coalesce(papertype,''),PaperID) FROM vwhodsubjectsselectedauto 
					WHERE EnggYear = '" . $selyear . "' 
					AND DeptID = ". $deptid . ") order by SubjectName";
				}
				else{
					$query22 = "SELECT papertype, PaperID, SubjectName FROM vwhodsubjects
				 	where EnggYear = '" . $selyear . "' AND DeptID = ". $deptid . " 
					AND CONCAT(coalesce(papertype,''),PaperID) NOT IN (
					SELECT CONCAT(coalesce(vwhod.papertype,''),vwhod.PaperID) FROM vwhodsubjectsselected vwhod
					WHERE EnggYear = '" . $selyear . "' and eduyearfrom = " . $EduYearFrom . "
					AND DeptID = ". $deptid . ") order by SubjectName";
				}
				//LEFT OUTER join tblyearstruct ys on ys.paperid = vwhod.paperid and ys.rowid = vwhod.ysid
				//echo $query22;

				$i = 1;

				$result22 = $mysqli->query( $query22);
				echo $mysqli->error;
				$num_results22 = $result22->num_rows;
				if( $num_results22 ){
					while( $row22 = $result22->fetch_assoc() ){
						extract($row22);
					  echo "<TR class='odd gradeX'>";
					  echo "<td>{$i}</td>";
					  $i = $i + 1;
					  echo "<td>{$SubjectName}</td>";
					  echo "<td><input title={$papertype} id={$PaperID} class='checkbox-class' type='checkbox' value='0' /></td>";
					  echo "</TR>";
					}
				}
				else{
					echo "<TR class='odd gradeX'>";
					echo "<td>No records found.</td>";
					echo "<td></td>";
					echo "<td></td>";
					echo "</TR>";
				}
			}
			else {
				echo "<TR class='odd gradeX'>";
				echo "<td>Please select Year.</td>";
				echo "<td></td>";
				echo "<td></td>";
				echo "</TR>";
			}
				

				echo "</table>";

				?> 
				</tr>
			</table>
				
			<br />
        </div>


        
        <div class="span5 v_detail" style="overflow:scroll">
            <div style="float:left;">
				<label><b>Selected Subjects</b></label>
            </div>
			<br/><br/><br/><br/>
			<table style="margin-top:-45px" cellpadding="10" cellspacing="0" border="0" width="90%" class="tab_split">
				<tr>
					<th>Sr. No.</th>
					<th>Subject - Type</th>
					<th width="10%"><strong>Action</strong></th>
				</tr>
				<?php
					include 'db/db_connect.php';

					If ((isset($_POST['btnSearch'])) or (isset($_POST['btnSave'])) or (isset($_POST['selectedids'])) or ($showresult == 1))
					{
						$queryL = "Select 'TH' as papertype, YR.PaperID as PaperID, Concat(SubjectName,' - TH') as SubjectName1,EnggYear,rowid ";
						$queryP = " UNION ALL Select 'PR' as papertype,YR.PaperID, Concat(SubjectName,' - PR') as SubjectName1,EnggYear,rowid ";
						$queryT = "  UNION ALL Select 'TT' as papertype,YR.PaperID, Concat(SubjectName,' - TT') as SubjectName1,EnggYear,rowid ";
						$queryLW = " AND COALESCE(YR.papertype,'') = 'TH' "; //" and coalesce(Lectureapp,0) = 1 ) and coalesce(Lectureapp,0) = 1 ";
						$queryPW = "  AND COALESCE(YR.papertype,'') = 'PR' "; //" and coalesce(Practicalapp,0) = 1 ) and coalesce(Practicalapp,0) = 1 ";
						$queryTW = " AND COALESCE(YR.papertype,'') = 'TT' "; //" and coalesce(Tutorialapp,0) = 1 ) and coalesce(Tutorialapp,0) = 1 ;";
						$querymain = " from tblyearstruct YR 
							INNER JOIN tblpapermaster PM on PM.paperid = YR.paperid
							INNER JOIN tblsubjectmaster SM ON PM.SubjectID = SM.SubjectID
							WHERE eduyearfrom = {$EduYearFrom}  and  eduyearto = {$EduYearTo} 
							AND EnggYear = '" . $selyear . " - " . $selsem . "' 
							AND PM.DeptID = ". $deptid . "
							and EnggYear = '" . $selyear . " - " . $selsem . "' ";

							$query = $queryL . $querymain . $queryLW . $queryP . $querymain . $queryPW . $queryT . $querymain . $queryTW;
							if($selyear == 'FE'){
								$query = "SELECT papertype, PaperID, SubjectName AS SubjectName1 FROM  vwhodsubjectsselectedauto WHERE EnggYear = '" . $selyear . "' 
								AND DeptID = ". $deptid;
							}
							else{
								$query = "SELECT vwhod.papertype, vwhod.PaperID, vwhod.SubjectName AS SubjectName1 
								FROM  vwhodsubjectsselected vwhod
								where eduyearfrom = {$EduYearFrom} and vwhod.EnggYear = '" . $selyear . "' AND vwhod.DeptID = ". $deptid;
							}
							//INNER join tblyearstruct ys on ys.paperid = vwhod.paperid and ys.rowid = vwhod.ysid and 
							//echo $query;
						$result2 = $mysqli->query( $query );
						echo $mysqli->error;
						$i = 1;
						$num_results2 = $result2->num_rows;
						if( $num_results2 ){
							while( $row2 = $result2->fetch_assoc() ){
								extract($row2);
								echo "<TR class='odd gradeX'>";
								echo "<td>{$i}</td>";
								$i = $i + 1;
								echo "<td>{$SubjectName1}</td>";
								echo "<td class='span3'><a class='btn btn-mini btn-danger' href='SubMapUpd.php?IUD=D&rowid={$rowid}&Year={$selyear}&EduYearFrom={$EduYearFrom}&EduYearTo={$EduYearTo}&paperid={$PaperID}&papertype={$papertype}'>
								<i class='icon-remove icon-white'></i>&nbsp&nbspCancel</a></td>";
								echo "</TR>";
							}
						}					
					
						//disconnect from database
						$result->free();
						$mysqli->close();
					}
				?>

			</table>
			


			</div>
	</div>
	</form>

