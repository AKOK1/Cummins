<form name="myform" action="" method="post" onsubmit='showLoading();'>
	<head>
	   <link rel="stylesheet" href="css/jquery-ui.css">
	   <script src="js/jquery-1.10.2.js"></script>
       <script src="js/jquery-ui.js"></script>
		<script year="text/javascript" src="js/jquery.min.js"></script>
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
		function clearbatch(ysid,stdadmid){
		 $('#selectedysid').val(ysid);
		 $('#selectedadmid').val(stdadmid);			
		 document.myform.submit();
		 return false;
		}
	 function showbatch(){
		 $('#selectedbatch').val($('#ddlbatch').val());
		 $('#selectedyear').val($('#ddlyear').val());
	 }
	 function showyear(){
		 $('#selectedyear').val($('#ddlyear').val());
		 $('#selectedbatch').val($('#ddlbatch').val());
		 document.myform.submit();
	 }
	 function showdiv(){
		 $('#selecteddiv').val($('#ddldiv').val());
		 $('#selectedbatch').val($('#ddlbatch').val());
	 }	 
	 function AddToList(iselective) {
			if(confirm('Assign selected students to selected batch for all subjects?'))
			{
				$('#hdnsetall').val(0);
			}
			else
			{
				if(confirm('Assign selected students to selected batch for only the selected subject?')){
					//set THIS subject flag!!!
					$('#hdnsetall').val(1);
				}
				else{
					return false;
				}
			}

		 if($('#ddlBatchNames').val() == '')
			alert('Please select a Batch.');
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
				else
					document.myform.submit();
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

?>
<?php
		if(isset($_POST['selectedysid'] )){
			$sql = "Update tblyearstructstd set Btchid = NULL where  YSID = ? and StdAdmID = ?";
			$stmt = $mysqli->prepare($sql);
			$stmt->bind_param('ii', $_POST["selectedysid"],$_POST["selectedadmid"]);
			if($stmt->execute()){
				//echo "done";
			} else { echo $mysqli->error;
				///die("Unable to update.");
			}
		}
		if(isset($_POST['selectedids'] )){
			if($_POST['selectedids'] != ''){
			    //echo "a " . $_POST['ddlBatchNames'] . "<br/>";
			    //echo "b " . $_POST['selectedids'] . "<br/>";
			    //echo "c " . $_POST['ddlyear'] . "<br/>";
			    //echo "d " . $_POST['ddlpapertype'] . "<br/>";
			    //echo "e " . $_POST['ddlSubject'] . "<br/>";
			   //echo "e " . $_POST["hdnsetall"] . "<br/>";
			  // die;			
				if(isset($_POST["ddldept"])){
					$deptsql = $_POST["ddldept"];
				 }
				else{
					$deptsql =  $_SESSION["SESSRAUserDeptID"];
				}
			  // echo "f " . $deptsql . "<br/>";

				$mysqli->query("SET @i_BatchID  = " . $_POST["ddlBatchNames"] . "");
				$mysqli->query("SET @i_ItemIDs   = '" .  $_POST['selectedids'] . "'");
				$mysqli->query("SET @i_year  = '" . $_POST["ddlyear"] . "'");
				$mysqli->query("SET @i_papertype  = '" . $_POST["ddlpapertype"] . "'");
				$mysqli->query("SET @i_paperid  = " . $_POST["ddlSubject"] . "");
				$mysqli->query("SET @i_deptid  = " . $deptsql . "");
				$mysqli->query("SET @i_iselective  = " . $_POST["hdnsetall"] . "");
				//$mysqli->query("SET @i_iselective  = " . $_SESSION["IsElective"] . "");
				$result1 = $mysqli->query("CALL SP_SaveBatch(@i_BatchID, @i_ItemIDs,@i_year,@i_papertype,@i_paperid,@i_deptid,@i_iselective)");
		}
		}
?>
<div id='loadingmsg' style='display: none;'>Please wait...</div>
<div id='loadingover' style='display: none;'></div>
	<br /><br />
	<h3 class="page-title">Create Batch</h3>
	<h3 class="page-title" style="float:right;margin-top:-40px;"><a href="MainMenuMain.php">Back</a></h3>
	<input type="hidden" name="selectedids" id="selectedids" value=''/>
	<input type="hidden" name="selecteddiv" id="selecteddiv">
	<input type="hidden" name="selectedyear" id="selectedyear"/>
	<input type="hidden" name="selectedysid" id="selectedysid"/>
	<input type="hidden" name="selectedadmid" id="selectedadmid"/>
	<input type="hidden" name="hdnsetall" id="hdnsetall"/>
	
	<?php
		//echo isset($_POST['selectedyear']);
		//echo isset($_POST['selecteddiv']);
	?> 
		<div>
		<div style="float:left;margin-left:50px;margin-top:5px">
		<?php
				$setdisabled = '0';
				$strSelect1 = '';
				$strSelect2 = '';
				include 'db/db_connect.php';
				$strSelect1 = "<select id='ddldept' name='ddldept' required style='width:120px;' required onchange='document.myform.submit();' ";
				$strSelect2 = "<option value=''>Select Dept</option>";
				$query = "SELECT DeptID,DeptName AS Department FROM tbldepartmentmaster where coalesce(teaching,0) = 1 ";
				//echo $query;
				$result = $mysqli->query( $query );
				$num_results = $result->num_rows;
				if( $num_results ){
					while( $row = $result->fetch_assoc() ){
						extract($row);
						$strSelect2 = $strSelect2 . "<option ";
						if(isset($_SESSION["SESSUserDept"]))
						{ 
							if($_SESSION["SESSRAUserDept"] == $Department){
								$strSelect2 = $strSelect2 . ' selected ';
								$strSelect1 = $strSelect1 . " disabled";
							}
							else if(isset($_POST["ddldept"])){
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
					
			<select id="ddlyear" name="ddlyear"  required onchange="showyear();">
				<option value="">Select Year</option>
				<option value="F.E." <?php if(isset($_POST['ddlyear'])){if($_POST['ddlyear'] == "F.E.") echo "selected";} ?>>F.E.</option>
				<option value="S.E." <?php if(isset($_POST['ddlyear'])){if($_POST['ddlyear'] == "S.E.") echo "selected";} ?>>S.E.</option>
				<option value="T.E." <?php if(isset($_POST['ddlyear'])){if($_POST['ddlyear'] == "T.E.") echo "selected";} ?>>T.E.</option>
				<option value="B.E." <?php if(isset($_POST['ddlyear'])){if($_POST['ddlyear'] == "B.E.") echo "selected";} ?>>B.E.</option>
				<option value="F.Y." <?php if(isset($_POST['ddlyear'])){if($_POST['ddlyear'] == "F.Y.") echo "selected";} ?>>F.Y. M. Tech.</option>
				<option value="S.Y." <?php if(isset($_POST['ddlyear'])){if($_POST['ddlyear'] == "S.Y.") echo "selected";} ?>>S.Y. M. Tech.</option>
			</select>
		</div>
		<div style="float:left;margin-left:20px;margin-top:5px">
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
		</div>
		<div style="float:left;margin-left:20px;margin-top:5px">
			<select id="ddlpapertype" name="ddlpapertype"  required >
				<option value="">Select Papertype</option>
				<option value="TH" <?php if(isset($_POST['ddlpapertype'])){if($_POST['ddlpapertype'] == "TH") echo "selected";} ?>>TH</option>
				<option value="PR" <?php if(isset($_POST['ddlpapertype'])){if($_POST['ddlpapertype'] == "PR") echo "selected";} ?>>PR</option>
				<option value="TT" <?php if(isset($_POST['ddlpapertype'])){if($_POST['ddlpapertype'] == "TT") echo "selected";} ?>>TT</option>
			</select>
		</div>
		<div style="float:left;margin-left:20px;margin-top:5px">
			<select id="ddlSubject" name="ddlSubject"  required >
				<?php
						//CONCAT(sm.SubjectName, '-', ys.papertype) AS Sub 
						include 'db/db_connect.php';
						echo "<option value=''>Select Subject</option>"; 						
						if($_POST["ddlyear"] == 'F.E.'){
						$sql = "SELECT distinct ys.paperid as PaperID,sm.SubjectID,
								sm.SubjectName AS Sub 
								FROM tblyearstruct ys
								INNER JOIN tblcuryearauto cy ON cy.EduYearFrom = ys.eduyearfrom AND cy.EduYearTo = ys.eduyearto
								INNER JOIN tblpapermaster pm ON pm.PaperID = ys.paperid
								INNER JOIN vwmaxpattern mp ON mp.EnggPattern = pm.EnggPattern 
								AND CONCAT(mp.EnggYear,' - Sem ',mp.Sem) = pm.EnggYear 
								INNER JOIN tblsubjectmaster sm ON sm.SubjectID = pm.SubjectID
								 WHERE profid IS NULL AND ys.papertype IS NOT NULL 
								 AND pm.EnggYear = concat(replace('" . $_POST["ddlyear"] . "','.',''),' - Sem ',cy.Sem) ";
								 if(isset($_POST["ddldept"])){
									$sql = $sql . " AND pm.DeptID = " . $_POST["ddldept"] .  "";
								 }
								else{
									$sql = $sql . " AND pm.DeptID = '" . $_SESSION["SESSRAUserDeptID"] .  "'";
								}						
						}
						else{
						$sql = "SELECT distinct ys.paperid as PaperID,sm.SubjectID,
								sm.SubjectName AS Sub 
								FROM tblyearstruct ys
								INNER JOIN tblcuryear cy ON cy.EduYearFrom = ys.eduyearfrom AND cy.EduYearTo = ys.eduyearto
								INNER JOIN tblpapermaster pm ON pm.PaperID = ys.paperid
								INNER JOIN vwmaxpattern mp ON mp.EnggPattern = pm.EnggPattern 
								AND CONCAT(mp.EnggYear,' - Sem ',mp.Sem) = pm.EnggYear 
								INNER JOIN tblsubjectmaster sm ON sm.SubjectID = pm.SubjectID
								 WHERE profid IS NULL AND ys.papertype IS NOT NULL 
								 AND pm.EnggYear = concat(replace('" . $_POST["ddlyear"] . "','.',''),' - Sem ',cy.Sem) ";
								 if(isset($_POST["ddldept"])){
									$sql = $sql . " AND pm.DeptID = " . $_POST["ddldept"] .  "";
								 }
								else{
									$sql = $sql . " AND pm.DeptID = '" . $_SESSION["SESSRAUserDeptID"] .  "'";
								}						
						}
//echo $sql ;
						$result1 = $mysqli->query( $sql );
						while( $row = $result1->fetch_assoc() ) {
								extract($row);
								echo "<option value={$PaperID} ";
										if(isset($_POST['ddlSubject'])){
											if($_POST['ddlSubject'] == "{$PaperID}") echo "selected";
										}
											echo ">{$Sub} </option>"; 
						}
						?>
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
					<th>Sr. No.</th>
					<th>CNUM</th>
					<th>Div.</th>
					<th style='width:23%'>Full Name</th>
					<th>Roll No</th>
					<th>Batch</th>
				<?php
					If (isset($_POST['btnSearch']) or isset($_POST['selectedids']) || (isset($_POST['selectedysid']))){
				// Create connection
				include 'db/db_connect.php';
				$query1 = "SELECT DeptID FROM tbldepartmentmaster where DeptName = '" . $_SESSION["SESSUserDept"] . "'";
				$result1 = $mysqli->query( $query1 );
				$num_results1 = $result1->num_rows;
				if( $num_results1 ){
					while( $row1 = $result1->fetch_assoc() ){
						extract($row1);
					}
				}
				if($_POST["ddlyear"] == 'F.E.'){
					$sql = 'SELECT EduYearFrom, EduYearTo FROM tblcuryearauto WHERE EduYearTo = (SELECT MAX(EduYearTo) FROM tblcuryearauto)';
				}
				else{
					$sql = 'SELECT EduYearFrom, EduYearTo FROM tblcuryear WHERE EduYearTo = (SELECT MAX(EduYearTo) FROM tblcuryear)';
				}
				//echo $sql;
				$result = $mysqli->query( $sql );
				$num_results = $result->num_rows;
				if( $num_results ){
					while( $row = $result->fetch_assoc() ){
						extract($row);
					}
				}

				// if the selected subject is elective...show from tblyearstructstd else all stds				
				$query0 = "SELECT coalesce(IsElective,0) as IsElective FROM tblpapermaster 
				where PaperID = " . $_POST['ddlSubject'] ;
				//echo $query0;
				$result0 = $mysqli->query( $query0 );
				$num_results0 = $result0->num_rows;
				if( $num_results0 ){
					while( $row0 = $result0->fetch_assoc() ){
							extract($row0);
							$_SESSION["IsElective"] = $IsElective;
					}
				}
				
				echo "<th>Check
					<input onclick='setall(this);' class='checkbox-class' type='checkbox' value='Check All' /></th>
					<th>Delete</th>			
					<th>
						<input id='btnSave' name='btnSave' style='margin-top:-7px;' onclick='return AddToList(" . $_SESSION["IsElective"] . ");' type='button' value='Assign Batch' />";
						echo "<select id='ddlBatchNames' name='ddlBatchNames' style='width:115px'><option value=''>Select Batch</option>";
						If ((isset($_POST['btnSearch'])) || ($_POST['selectedids'] != '') || (isset($_POST['selectedysid']))){
							$query = "SELECT BtchId, BatchName 
							FROM tblbatchmaster  WHERE DeptID = '";
							if($_POST["ddldept"] <> '')
								$query = $query . $_POST["ddldept"];
							else
								$query = $query . $_SESSION["SESSRAUserDeptID"];
							$query = $query . "' and papertype = '" . $_POST["ddlpapertype"] . "' and EduYear = Replace('" . $_POST["ddlyear"] . "','.','')
							order by BtchId";
							$result = $mysqli->query( $query );
							$num_results = $result->num_rows;
							if( $num_results ){
								while( $row = $result->fetch_assoc() ){
									extract($row);
									echo "<option value='{$BtchId}'>{$BatchName}</option>";
								}
							}
						}
				echo "</select></th>";
			echo "</tr>";
			echo "</table>";
			// Assign to all subjects except elective?<input class='checkbox-class' type='checkbox' />
			?>
			<div class="v_detail">
			<?php
			If ((isset($_POST['btnSearch'])) || ($_POST['selectedids'] != '') || (isset($_POST['selectedysid'])))
			{				
				

				if($_SESSION["IsElective"] == 1){					
					//it's an elective!
					$query = "SELECT SA.StdAdmID, CONCAT(Surname, ' ', FirstName) AS NAME,SA.RollNo, S.CNUM, SA.BtchId, BM.BatchName,SA.Div 
					FROM tblstdadm SA 
					INNER JOIN tblstudent S ON SA.StdID = S.StdId
					INNER JOIN tblyearstructstd yss ON yss.StdAdmID = SA.StdAdmID
					INNER JOIN vwhodsubjectsselectedauto hss ON hss.YSID = yss.YSID AND IsElective = 1 
					AND PaperID = " . $_POST['ddlSubject'] . "
					LEFT OUTER JOIN tblbatchmaster BM ON BM.BtchId = yss.BtchId AND BM.papertype = '" . $_POST['ddlpapertype'] . "'
					WHERE SA.EduYearFrom = {$EduYearFrom} AND SA.EduYearTo = {$EduYearTo} AND SA.Dept = " . $DeptID . "  
					and SA.Year = '" . $_POST['ddlyear'] . "'";
				}
				else{
					//not an elective!
					$query = "SELECT SA.StdAdmID , CONCAT(FirstName, ' ', Surname) AS NAME,SA.RollNo, s.CNUM , yss.BtchId  , BM.BatchName,SA.Div ,yss.YSID
								FROM tblstdadm SA
								INNER JOIN tblstudent s ON s.stdid = SA.stdid
								LEFT OUTER JOIN tblyearstructstd yss ON yss.StdAdmID = SA.StdAdmID AND yss.BtchId IS NOT NULL
								LEFT OUTER JOIN vwhodsubjectsselectedauto hss ON hss.YSID = yss.YSID AND IsElective = 0 AND hss.PaperID = " . $_POST['ddlSubject'] . "
								AND COALESCE(hss.papertype,'') = '" . $_POST['ddlpapertype'] . "'
								INNER JOIN tblbatchmaster BM ON BM.BtchId = yss.BtchId  AND BM.DeptID = SA.Dept AND BM.papertype = '" . $_POST['ddlpapertype'] . "' 
								AND BM.EduYear = Replace('" . $_POST['ddlyear'] . "','.','')
								where  EduYearFrom = {$EduYearFrom} AND EduYearTo = {$EduYearTo} AND SA.Dept = " . $DeptID . " 
								AND Year = '" . $_POST['ddlyear'] . "'
								AND SA.`Div` = '" . $_POST['ddldiv'] . "'
								and coalesce(AdmConf,'') = 1
								UNION ALL
								SELECT SA.StdAdmID , CONCAT(FirstName, ' ', Surname) AS NAME,SA.RollNo, s.CNUM , 0 as BtchId  , '' as BatchName,SA.Div ,0 as YSID
								FROM tblstdadm SA
								INNER JOIN tblstudent s ON s.stdid = SA.stdid
								WHERE  EduYearFrom = {$EduYearFrom} AND EduYearTo = {$EduYearTo} AND SA.Dept = " . $DeptID . " 
								AND YEAR = '" . $_POST['ddlyear'] . "'
								AND SA.`Div` = '" . $_POST['ddldiv'] . "'
								AND COALESCE(AdmConf,'') = 1
								and SA.StdAdmID not in (
								SELECT SA.StdAdmID
								FROM tblstdadm SA
								LEFT OUTER JOIN tblyearstructstd yss ON yss.StdAdmID = SA.StdAdmID AND yss.BtchId IS NOT NULL
								LEFT OUTER JOIN vwhodsubjectsselectedauto hss ON hss.YSID = yss.YSID AND IsElective = 0 AND hss.PaperID = " . $_POST['ddlSubject'] . "  
								AND COALESCE(hss.papertype,'') = '" . $_POST['ddlpapertype'] . "'
								INNER JOIN tblbatchmaster BM ON BM.BtchId = yss.BtchId  AND BM.DeptID = SA.Dept AND BM.papertype = '" . $_POST['ddlpapertype'] . "' 
								AND BM.EduYear = Replace('" . $_POST['ddlyear'] . "','.','')
								WHERE  EduYearFrom = {$EduYearFrom} AND EduYearTo = {$EduYearTo} AND SA.Dept = " . $DeptID . " AND YEAR = '" . $_POST['ddlyear'] . "'
								AND SA.`Div` = '" . $_POST['ddldiv'] . "' AND COALESCE(AdmConf,'') = 1	)";
					// $query = "SELECT  SA.StdAdmID, CONCAT(FirstName, ' ', Surname) AS NAME,SA.RollNo, S.CNUM, SA.BtchId, BM.BatchName,SA.Div FROM tblstdadm SA 
					// INNER JOIN tblstudent S ON SA.StdID = S.StdId 
					// LEFT OUTER JOIN tblyearstructstd yss ON yss.StdAdmID = SA.StdAdmID
					// LEFT OUTER JOIN vwhodsubjectsselected hss ON hss.YSID = yss.YSID AND IsElective = 0 
					// AND PaperID = " . $_POST['ddlSubject'] . "
					// LEFT OUTER JOIN tblbatchmaster BM on BM.BtchId = yss.BtchId and BM.papertype = '" . $_POST['ddlpapertype'] . "'
					// WHERE SA.EduYearFrom = {$EduYearFrom} AND SA.EduYearTo = {$EduYearTo} AND SA.Dept = " . $DeptID . "  
					// and SA.Year = '" . $_POST['ddlyear'] . "'";
				}

				if($_SESSION["IsElective"] == 1){
						if($_POST["ddlyear"] == 'F.E.'){
							$query = "SELECT SA.StdAdmID , CONCAT(Surname, ' ', FirstName) AS NAME,SA.RollNo, s.CNUM , yss.BtchId , BM.BatchName,SA.Div ,yss.YSID 
								FROM tblstdadm SA 
								INNER JOIN tblstudent s ON s.stdid = SA.stdid 
								INNER JOIN tbldepartmentmaster dm ON dm.deptname = s.dept 
								INNER JOIN tblyearstructstd yss ON yss.StdAdmID = SA.StdAdmID 
								AND ysid IN (SELECT ysid FROM vwhodsubjectsselectedauto WHERE PaperID = " . $_POST['ddlSubject'] . " 
								AND COALESCE(papertype,'') = '" . $_POST['ddlpapertype'] . "')
								LEFT OUTER JOIN tblbatchmaster BM ON BM.BtchId = yss.BtchId AND BM.DeptID = dm.DeptID AND BM.papertype = '" . $_POST['ddlpapertype'] . "'
								AND BM.EduYear = REPLACE('" . $_POST['ddlyear'] . "','.','') 
								WHERE EduYearFrom = {$EduYearFrom} AND EduYearTo = {$EduYearTo} AND YEAR = '" . $_POST['ddlyear'] . "' 
								AND COALESCE(AdmConf,'') = 1 and SA.`div` = '" . $_POST['ddldiv'] . "'";

						}
						else{
											$query = "SELECT SA.StdAdmID , CONCAT(Surname, ' ', FirstName) AS NAME,SA.RollNo, s.CNUM , yss.BtchId , BM.BatchName,SA.Div ,yss.YSID 
														FROM tblstdadm SA 
														INNER JOIN tblstudent s ON s.stdid = SA.stdid 
														INNER JOIN tbldepartmentmaster dm ON dm.deptname = s.dept 
														INNER JOIN tblyearstructstd yss ON yss.StdAdmID = SA.StdAdmID 
														AND ysid IN (SELECT ysid FROM vwhodsubjectsselected WHERE PaperID = " . $_POST['ddlSubject'] . ")
														LEFT OUTER JOIN tblbatchmaster BM ON BM.BtchId = yss.BtchId AND BM.DeptID = dm.DeptID 
														AND BM.papertype = '" . $_POST['ddlpapertype'] . "'
														AND BM.EduYear = REPLACE('" . $_POST['ddlyear'] . "','.','') 
														WHERE EduYearFrom = {$EduYearFrom} AND EduYearTo = {$EduYearTo} AND YEAR = '" . $_POST['ddlyear'] . "' 
														AND COALESCE(AdmConf,'') = 1";
														
								if(isset($_POST["ddldept"])){
									$query = "SELECT sa.StdAdmID , CONCAT(Surname, ' ', FirstName) AS NAME,sa.RollNo, s.CNUM , 
												yss.BtchId , BM.BatchName,sa.Div ,yss.YSID
												FROM tblstdadm sa
												INNER JOIN tblstudent s ON s.stdid = sa.stdid  
												AND sa.Dept = " . $_POST["ddldept"] . " 
												AND sa.`div` = '" . $_POST['ddldiv'] . "'
												AND sa.Year = '" . $_POST['ddlyear'] . "'
												INNER JOIN tblcuryear cy ON cy.EduYearFrom = sa.eduyearfrom
												INNER JOIN tblyearstructstd yss ON sa.StdAdmID = yss.StdAdmID
												AND ysid IN (SELECT ysid FROM vwhodsubjectsselected 
													WHERE PaperID = " . $_POST['ddlSubject'] . " AND eduyearfrom = " . $EduYearFrom . ")
												LEFT OUTER JOIN tblbatchmaster BM ON BM.BtchId = yss.BtchId";
									
								}
								else{
//mandar												
									$query = "SELECT sa.StdAdmID , CONCAT(Surname, ' ', FirstName) AS NAME,sa.RollNo, s.CNUM , 
												yss.BtchId , BM.BatchName,sa.Div ,yss.YSID
												FROM tblstdadm sa
												INNER JOIN tblstudent s ON s.stdid = sa.stdid  
												AND sa.Dept = " . $_SESSION["SESSRAUserDeptID"] . " 
												AND sa.`div` = '" . $_POST['ddldiv'] . "'
												AND sa.Year = '" . $_POST['ddlyear'] . "'
												INNER JOIN tblcuryear cy ON cy.EduYearFrom = sa.eduyearfrom
INNER JOIN tblyearstructstd yss ON sa.StdAdmID = yss.StdAdmID
												AND ysid IN (SELECT ysid FROM vwhodsubjectsselected 
														WHERE PaperID = " . $_POST['ddlSubject'] . " AND eduyearfrom = " . $EduYearFrom . ")
												LEFT OUTER JOIN tblbatchmaster BM ON BM.BtchId = yss.BtchId";
								}
						}
						/*
						if(isset($_POST["ddldept"]))
							$query = $query . " AND dm.DeptID = " . $_POST["ddldept"] .  "";
						else
							$query = $query . " AND dm.DeptID = " . $_SESSION["SESSRAUserDeptID"];
						*/
						//AND COALESCE(papertype,'') = '" . $_POST['ddlpapertype'] . "'
				}
				else{
						if($_POST["ddlyear"] == 'F.E.'){
							$query = "SELECT SA.StdAdmID , CONCAT(Surname, ' ', FirstName) AS NAME,SA.RollNo, s.CNUM , yss.BtchId , BM.BatchName,SA.Div ,yss.YSID 
								FROM tblstdadm SA 
								INNER JOIN tblstudent s ON s.stdid = SA.stdid 
								INNER JOIN tbldepartmentmaster dm ON dm.deptname = s.dept 
								LEFT OUTER JOIN tblyearstructstd yss ON yss.StdAdmID = SA.StdAdmID 
								AND ysid IN (SELECT ysid FROM vwhodsubjectsselectedauto WHERE PaperID = " . $_POST['ddlSubject'] . " 
								AND COALESCE(papertype,'') = '" . $_POST['ddlpapertype'] . "')
								LEFT OUTER JOIN tblbatchmaster BM ON BM.BtchId = yss.BtchId AND BM.papertype = '" . $_POST['ddlpapertype'] . "'
								AND BM.EduYear = REPLACE('" . $_POST['ddlyear'] . "','.','') 
								WHERE EduYearFrom = {$EduYearFrom} AND EduYearTo = {$EduYearTo} AND YEAR = '" . $_POST['ddlyear'] . "' 
								AND COALESCE(AdmConf,'') = 1 and SA.`div` = '" . $_POST['ddldiv'] . "'";
								//AND BM.DeptID = dm.DeptID 
						}
						else{
							$query = "SELECT SA.StdAdmID , CONCAT(Surname, ' ', FirstName) AS NAME,SA.RollNo, s.CNUM , yss.BtchId , BM.BatchName,SA.Div ,yss.YSID 
								FROM tblstdadm SA 
								INNER JOIN tblstudent s ON s.stdid = SA.stdid 
								INNER JOIN tbldepartmentmaster dm ON dm.deptname = s.dept 
								LEFT OUTER JOIN tblyearstructstd yss ON yss.StdAdmID = SA.StdAdmID 
								AND ysid IN (SELECT ysid FROM vwhodsubjectsselected WHERE PaperID = " . $_POST['ddlSubject'] . " 
								AND COALESCE(papertype,'') = '" . $_POST['ddlpapertype'] . "')
								LEFT OUTER JOIN tblbatchmaster BM ON BM.BtchId = yss.BtchId AND BM.DeptID = dm.DeptID AND BM.papertype = '" . $_POST['ddlpapertype'] . "'
								AND BM.EduYear = REPLACE('" . $_POST['ddlyear'] . "','.','') 
								WHERE EduYearFrom = {$EduYearFrom} AND EduYearTo = {$EduYearTo} AND YEAR = '" . $_POST['ddlyear'] . "' 
								AND COALESCE(AdmConf,'') = 1";
					
								if(isset($_POST["ddldept"])){
									$query = "SELECT sa.StdAdmID , CONCAT(Surname, ' ', FirstName) AS NAME,sa.RollNo, s.CNUM , 
												yss.BtchId , BM.BatchName,sa.Div ,yss.YSID
												FROM tblstdadm sa
												INNER JOIN tblstudent s ON s.stdid = sa.stdid  
												AND sa.Dept = " . $_POST["ddldept"] . " 
												AND sa.`div` = '" . $_POST['ddldiv'] . "'
												AND sa.Year = '" . $_POST['ddlyear'] . "'
												INNER JOIN tblcuryear cy ON cy.EduYearFrom = sa.eduyearfrom
												LEFT OUTER JOIN tblyearstructstd yss ON sa.StdAdmID = yss.StdAdmID
												AND ysid IN (SELECT ysid FROM vwhodsubjectsselected 
																WHERE PaperID = " . $_POST['ddlSubject'] . " AND eduyearfrom = " . $EduYearFrom . "  and PaperType = '" . $_POST['ddlpapertype'] . "')
												LEFT OUTER JOIN tblbatchmaster BM ON BM.BtchId = yss.BtchId";
									
								}
								else{
									$query = "SELECT sa.StdAdmID , CONCAT(Surname, ' ', FirstName) AS NAME,sa.RollNo, s.CNUM , 
												yss.BtchId , BM.BatchName,sa.Div ,yss.YSID
												FROM tblstdadm sa
												INNER JOIN tblstudent s ON s.stdid = sa.stdid  
												AND sa.Dept = " . $_SESSION["SESSRAUserDeptID"] . " 
												AND sa.`div` = '" . $_POST['ddldiv'] . "'
												AND sa.Year = '" . $_POST['ddlyear'] . "'
												INNER JOIN tblcuryear cy ON cy.EduYearFrom = sa.eduyearfrom
												LEFT OUTER JOIN tblyearstructstd yss ON sa.StdAdmID = yss.StdAdmID
												AND ysid IN (SELECT ysid FROM vwhodsubjectsselected 
																WHERE PaperID = " . $_POST['ddlSubject'] . " AND eduyearfrom = " . $EduYearFrom . " and PaperType = '" . $_POST['ddlpapertype'] . "')
												LEFT OUTER JOIN tblbatchmaster BM ON BM.BtchId = yss.BtchId";
								}
						}

			/*
								if(isset($_POST["ddldept"]))
									$query = $query . " AND dm.DeptID = " . $_POST["ddldept"] .  "";
								else
									$query = $query . " AND dm.DeptID = " . $_SESSION["SESSRAUserDeptID"];
			*/
				}
				//AND SA.`Div` = '" . $_POST['ddldiv'] . "' 
				//AND SA.`Div` = '" . $_POST['ddldiv'] . "' 
				/*
				if($_POST['ddldiv'] <> "ALL"){
					$query = $query . " and SA.Div = '" . $_POST['ddldiv'] . "'";
				}
				*/
				$query = $query . " order by  RollNo,NAME";
				//echo $query;
				$result = $mysqli->query( $query );
				$num_results = $result->num_rows;
				$i = 1;
				echo "<table cellpadding='10' cellspacing='0' border='0' class='tab_split'>";
				if( $num_results ){
					while( $row = $result->fetch_assoc() ){
						extract($row);
					  echo "<TR class='odd gradeX'>";
					  echo "<td>{$i}</td>";
					  $i = $i + 1;
					  echo "<td>{$CNUM}</td>";
					  echo "<td>{$Div}</td>";
					  echo "<td>{$NAME}</td>";
					  echo "<td style='width:13%'>{$RollNo}</td>";
					  echo "<td style='width:13%'>{$BatchName}</td>";
					  echo "<td style='width:11%'><input id={$StdAdmID} class='checkbox-class' type='checkbox' value='0' /></td>";
					   echo "<td><a id='btnClear' name='btnClear' onclick='return clearbatch({$YSID},{$StdAdmID});' class='btn btn-primary' ><i class='icon-remove icon-white'></i></a> </td>";
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
				echo "<td>Please select Year and Division.</td>";
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
