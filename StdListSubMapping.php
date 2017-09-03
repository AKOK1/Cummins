<?php
		if(!isset($_SESSION)){
			session_start();
		}
		include 'db/db_connect.php';
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
		
		if(isset($_POST['ddldiv'])){
			$_SESSION["seldiv"] = $_POST['ddldiv'];
		}
		else if(!isset($_SESSION["seldiv"])){
			$_SESSION["seldiv"] = '';
		}

		if(isset($_POST['ddlYear'])){
			$_SESSION["selyear"] = $_POST['ddlYear'];
		}
		else if(!isset($_SESSION["selyear"])){
			$_SESSION["selyear"] = '';
		}
		
		if(isset($_POST['ddldept'])){
			$_SESSION["seldept"] = $_POST['ddldept'];
		}
		else if(isset($_SESSION["SESSRAUserDeptID"])){
			$_SESSION["seldept"] = $_SESSION["SESSRAUserDeptID"];
		}
		else if(!isset($_SESSION["selyear"])){
			$_SESSION["seldept"] = '';
		}

?>		
<form action="StdListSubMappingMain.php" method="post">
	<br /><br />
	<div class="row-fluid">
		<div style="float:left"><h3 class="page-title">Student List</h3></div>
		<div style="float:left;margin-top:18px;margin-left:20px;">
		<?php
				$setdisabled = '0';
				$strSelect1 = '';
				$strSelect2 = '';
				include 'db/db_connect.php';
				$strSelect1 = "<select id='ddldept' name='ddldept' required style='width:120px;' required ";
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
							else if(isset($_SESSION["seldept"])){
								if($_SESSION["seldept"] == $DeptID){
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
			</div>
		<div style="float:left;margin-top:18px;margin-left:20px;">
				<select id="ddlYear" name="ddlYear" style="width:120px" required>
					<option value="">Select Year</option>
					<option value="F.E." <?php if(isset($_SESSION["selyear"])){if($_SESSION["selyear"] == "F.E.") echo "selected";} ?>>F.E.</option>
					<option value="S.E." <?php if(isset($_SESSION["selyear"])){if($_SESSION["selyear"] == "S.E.") echo "selected";} ?>>S.E.</option>
					<option value="T.E." <?php if(isset($_SESSION["selyear"])){if($_SESSION["selyear"] == "T.E.") echo "selected";} ?>>T.E.</option>
					<option value="B.E." <?php if(isset($_SESSION["selyear"])){if($_SESSION["selyear"] == "B.E.") echo "selected";} ?>>B.E.</option>
					<option value="M.E." <?php if(isset($_SESSION["selyear"])){if($_SESSION["selyear"] == "M.E.") echo "selected";} ?>>M.E.</option>
					<option value="FY" <?php if(isset($_SESSION["pmselyear"])){if($_SESSION["pmselyear"] == "FY") echo "selected";} ?>>F.Y.M.Tech.</option>
					<option value="SY" <?php if(isset($_SESSION["pmselyear"])){if($_SESSION["pmselyear"] == "SY") echo "selected";} ?>>S.Y.M.Tech.</option>
				</select>
		</div>
		<div style="float:left;margin-left:20px;margin-top:18px">
			<select id="ddldiv" name="ddldiv"  style="width:128px" required>
				<option value="">Select Division</option>
				<option value="ALL" <?php if(isset($_SESSION["seldiv"])){if($_SESSION["seldiv"] == "ALL") echo "selected";} ?>>ALL</option>
				<option value="A" <?php if(isset($_SESSION["seldiv"])){if($_SESSION["seldiv"] == "A") echo "selected";} ?>>A</option>
				<option value="B" <?php if(isset($_SESSION["seldiv"])){if($_SESSION["seldiv"] == "B") echo "selected";} ?>>B</option>
				<option value="C" <?php if(isset($_SESSION["seldiv"])){if($_SESSION["seldiv"] == "C") echo "selected";} ?>>C</option>
				<option value="D" <?php if(isset($_SESSION["seldiv"])){if($_SESSION["seldiv"] == "D") echo "selected";} ?>>D</option>
				<option value="E" <?php if(isset($_SESSION["seldiv"])){if($_SESSION["seldiv"] == "E") echo "selected";} ?>>E</option>
				<option value="F" <?php if(isset($_SESSION["seldiv"])){if($_SESSION["seldiv"] == "F") echo "selected";} ?>>F</option>
				<option value="G" <?php if(isset($_SESSION["seldiv"])){if($_SESSION["seldiv"] == "G") echo "selected";} ?>>G</option>
				<option value="H" <?php if(isset($_SESSION["seldiv"])){if($_SESSION["seldiv"] == "H") echo "selected";} ?>>H</option>
				<option value="I" <?php if(isset($_SESSION["seldiv"])){if($_SESSION["seldiv"] == "I") echo "selected";} ?>>I</option>
			</select>
		</div>
		<div style="float:left;margin-top:22px;margin-left:20px;">
			<input type="submit" name="btnSearch" value="Search" title="Update" class="btn btn-mini btn-success" />
		</div>
		<div style="float:right"><h3 class='page-title' style='margin-right:30px;'><a href='MainMenuMain.php'>Back</a></h3></div>
	</div>	
	
	<br/>
	<div class="row-fluid">
	    <div class="span12 v_detail" >
			<table cellpadding="10" cellspacing="0" border="0" class="tab_split" style="overflow:scroll">
				<tr>
					<th>Sr. No.</th>
					<th>Year</th>
					<th>CNUM</th>
					<th>Name</th>
					<th>RollNo</th>
					<th>ESN</th>
					<th>Action</th>
					<th>Electives</th>
				</tr>
				<?php
					include 'db/db_connect.php';
			
					$sql = "SELECT (MAX(EduYearTo) - 1) AS YearFrom, MAX(EduYearTo) as YearTo,Sem FROM tblcuryear";
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
	
					if((isset($_SESSION["seldept"])) && isset($_SESSION["selyear"]) && isset($_SESSION["seldiv"])){
							$sql = "SELECT SA.StdAdmID, CNUM, CONCAT(Surname, ' ', FirstName,  ' ', FatherName) AS StdName, DM.DeptName, SA.Shift  , Year,S.StdId,cast(RollNo as UNSIGNED) as RollNo,ESNum,A.SubjectName
							FROM tblstdadm SA 
							INNER JOIN tblstudent S ON S.StdId = SA.StdID
							INNER JOIN tbldepartmentmaster DM ON SA.Dept = DM.DeptID
							LEFT OUTER JOIn 
							(SELECT stdadmid, GROUP_CONCAT(distinct subjectName ORDER BY subjectName SEPARATOR ', ') AS SubjectName
							FROM vwhodsubjectsselected vwss 
							inner join tblyearstructstd yss on yss.YSID = vwss.YSID 
							WHERE vwss.Sem = " . $Sem . " and IsElective = 1 AND EnggYear = REPLACE('" . $_SESSION["selyear"] . "','.','') and papertype = 'TH' 
							GROUP BY stdadmid) as A on A.stdadmid = SA.stdadmid
							WHERE SA.EduYearFrom  = " . $SelYearFrom . " AND SA.EduYearTo = " . $SelYearTo . " AND YEAR <> 'A.L.'  
							AND SA.AdmConf = 1 and SA.stdstatus in ('R','P') ";
							if($_POST['ddlYear'] == 'F.E.'){
							}
							else{
								$sql = $sql . " and DM.DeptID = "  . $_SESSION["seldept"];
							}
							$sql = $sql . " and Year = '"  . $_SESSION["selyear"] . "'" ;
							if($_SESSION["seldiv"] == 'ALL'){
							}
							else{
								$sql = $sql . " and SA.Div = '"  . $_SESSION["seldiv"] . "'" ;						
							}
							$sql = $sql . " ORDER BY cast(RollNo as UNSIGNED), Surname";
							// Prepare IN parameters
							//echo $sql;
							//die;
							$result = $mysqli->query($sql);
							$num_results = $result->num_rows;
							//echo $num_results;
							$a = 1;
							if( $num_results ){
								while( $row = $result->fetch_assoc() ){
									extract($row);
									echo "<TR class='odd gradeX'>";
									echo "<td>{$a} </td>";
									echo "<td>{$Year} </td>";
									echo "<td>{$CNUM} </td>";
									echo "<td>{$StdName} </td>";
									echo "<td>{$RollNo} </td>";
									echo "<td>{$ESNum} </td>";
									echo "<td>";
									echo "<a class='btn btn-mini btn-success' href='StdElectiveMapMain.php?fromadmin=1&StdId={$StdId}'><i class='icon-ok icon-white'></i>&nbsp&nbspReview</a>&nbsp;&nbsp;";
									echo "</td>";
									echo "<td>{$SubjectName} </td>";
									echo "</TR>";
									$a = $a + 1;
								}
							}											
							$result->free();

							//disconnect from database
							$mysqli->close();						
					}
					

				?>
				</table>
				
				<br />
        </div>
	</div>
	</form>

