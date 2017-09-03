<?php
		if(!isset($_SESSION)){
			session_start();
		}
		include 'db/db_connect.php';
		if(isset($_POST['btnSearch'])){
			if(isset($_POST['ddldept'])){
				if($_POST['ddldept'] <> ""){
					$_SESSION["tmpseldept"] = $_POST['ddldept'] ;
				}
			}
			if(isset($_POST['ddlYear'])){
				if($_POST['ddlYear'] <> ""){
					$_SESSION["tmpselyear"] = $_POST['ddlYear'] ;
				}
			}		
			if(isset($_POST['ddlDiv'])){
				if($_POST['ddlDiv'] <> ""){
					$_SESSION["tmpseldiv"] = $_POST['ddlDiv'] ;
				}
			}		
		}
?>		
<form action="StdListCurYearMain.php" method="post">
	<br /><br />
	<div class="row-fluid">
		<div style="float:left"><h3 class="page-title">Student List</h3></div>
		<div style="float:left;margin-top:18px;margin-left:20px;">
			<?php
			if(!isset($_SESSION)){
				session_start();
			}

			include 'db/db_connect.php';
			$strSelect1 = "<select id='ddldept' name='ddldept' style='width:120px;'";
					//if($_SESSION["SESSRAUserDept"] == $Department) 
					//	echo ' disabled';
			$strSelect2 = "<option value=''>Select Dept</option>";
			$query = "SELECT DeptID,DeptName AS Department FROM tbldepartmentmaster where coalesce(teaching,0) = 1 ";
			//echo $query;
			$result = $mysqli->query( $query );
			$num_results = $result->num_rows;
			if( $num_results ){
				while( $row = $result->fetch_assoc() ){
					extract($row);
					$strSelect2 = $strSelect2 . "<option ";
					if(isset($_SESSION["tmpseldept"]))
					{ 
						if($_SESSION["tmpseldept"] == $DeptID) 
							$strSelect2 = $strSelect2 .  'selected';
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
				<select id="ddlYear" name="ddlYear" style="width:120px">
					<option value="">Select Year</option>
					<option value="F.E." <?php if(isset($_SESSION["tmpselyear"])){if($_SESSION["tmpselyear"] == "F.E.") echo "selected";} ?>>F.E.</option>
					<option value="S.E." <?php if(isset($_SESSION["tmpselyear"])){if($_SESSION["tmpselyear"] == "S.E.") echo "selected";} ?>>S.E.</option>
					<option value="T.E." <?php if(isset($_SESSION["tmpselyear"])){if($_SESSION["tmpselyear"] == "T.E.") echo "selected";} ?>>T.E.</option>
					<option value="B.E." <?php if(isset($_SESSION["tmpselyear"])){if($_SESSION["tmpselyear"] == "B.E.") echo "selected";} ?>>B.E.</option>
					<option value="F.Y." <?php if(isset($_SESSION["tmpselyear"])){if($_SESSION["tmpselyear"] == "F.Y.") echo "selected";} ?>>F.Y.M.Tech.</option>
					<option value="S.Y." <?php if(isset($_SESSION["tmpselyear"])){if($_SESSION["tmpselyear"] == "S.Y.") echo "selected";} ?>>S.Y.M.Tech.</option>
				</select>
		</div>
		<div style="float:left;margin-top:18px;margin-left:20px;">
				<select id="ddlDiv" name="ddlDiv" style="width:120px">
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
		<div style="float:left;margin-top:18px;margin-left:20px;">
			<input type="submit" name="btnSearch" value="Search" title="Update" class="btn btn-mini btn-success" />
		</div>
		<div style="float:right"><h3 class='page-title' style='margin-right:30px;'><a href='MainMenuMain.php'>Back</a></h3></div>
	</div>	
	
	<br/>
	<div><center>
		<label id="lblSuccess" style="margin-left:10px;color:green;display:none" >Saved successfully.</label>
		</center>
	</div>
	<div class="row-fluid">
	    <div class="span6 v_detail" >
            <div style="float:left">
				<label><b>Current Year Students</b></label>
            </div>
			<table cellpadding="10" cellspacing="0" border="0" width="100%" class="tab_split" style="overflow:scroll">
				<tr>
					<th>Year</th>
					<th>Department</th>
					<th>CNUM</th>
					<th>Name</th>
					<th>Shift</th>
					<th>Roll No.</th>
					<th>Action</th>
				</tr>
				<?php
					include 'db/db_connect.php';
			
					$sql = "SELECT (MAX(EduYearFrom)) AS YearFrom, MAX(EduYearTo) as YearTo FROM tblcuryear";
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
	
					
					$sql = "SELECT SA.StdAdmID, CNUM, RollNo, CONCAT(FirstName, ' ', FatherName,  ' ', Surname) AS StdName, DM.DeptName, SA.Shift  , Year
							FROM tblstdadm SA 
							INNER JOIN tblstudent S ON S.StdId = SA.StdID
							INNER JOIN tbldepartmentmaster DM ON SA.Dept = DM.DeptID
							WHERE SA.EduYearFrom  = " . $SelYearFrom . " AND SA.EduYearTo = " . $SelYearTo . " AND YEAR <> 'A.L.'  
							AND SA.AdmConf = 1 and SA.stdstatus = 'R' ";
							// echo $sql;
					If (isset($_SESSION["tmpseldept"]))
					{
						$sql = $sql . " and DM.DeptID = "  . $_SESSION["tmpseldept"]  ;
					}
					If (isset($_SESSION["tmpselyear"]))
					{
						$sql = $sql . " and Year = '"  . $_SESSION["tmpselyear"] . "'" ;
					}
					If ((isset($_SESSION["tmpseldiv"])))
					{
						$sql = $sql . " and SA.`div` = '"  . $_SESSION["tmpseldiv"] . "'" ;
					}
					$sql = $sql . " ORDER BY YEAR, SA.Dept, SA.Shift, Surname";
					// Prepare IN parameters
					//echo $sql;
					//die;
					$result = $mysqli->query($sql);
					$num_results = $result->num_rows;
					//echo $num_results;

					if( $num_results ){
						while( $row = $result->fetch_assoc() ){
							extract($row);
							echo "<TR class='odd gradeX'>";
							echo "<td>{$Year} </td>";
							echo "<td>{$DeptName} </td>";
							echo "<td>{$CNUM} </td>";
							echo "<td>{$StdName} </td>";
							echo "<td>{$Shift} </td>";
							echo "<td>{$RollNo} </td>";
							echo "<td class='span4'>";
							echo "<a class='btn btn-mini btn-success' href='ReviewAdmissionMain.php?IUD=D&StdAdmID={$StdAdmID}'><i class='icon-ok icon-white'></i>&nbsp&nbspReview</a>&nbsp;&nbsp;";
							//echo "<a class='btn btn-mini btn-success' href='ProgressionUpd.php?IUD=D&StdAdmID={$StdAdmID}'><i class='icon-ok //icon-white'></i>&nbsp&nbspDrop</a>&nbsp;&nbsp;";
							//echo "<a class='btn btn-mini btn-success' href='ProgressionUpd.php?IUD=YD&StdAdmID={$StdAdmID}'><i class='icon-ok //icon-white'></i>&nbsp&nbspYear Down</a>&nbsp;&nbsp;";
							//echo "<a class='btn btn-mini btn-success' href='ProgressionUpd.php?IUD=CA&StdAdmID={$StdAdmID}'><i class='icon-ok //icon-white'></i>&nbsp&nbspCancel Admission</a>&nbsp;&nbsp;";
							echo "</td>";
							echo "</TR>";
						}
					}											
					$result->free();

					//disconnect from database
					$mysqli->close();

				?>
				</table>
				
				<br />
        </div>

        <div class="span6 v_detail">
            <div style="float:left;">
				<label><b>Drop Out etc</b></label>
            </div>
			<table cellpadding="10" cellspacing="0" border="0" width="100%" class="tab_split" style="overflow:scroll">
				<tr>
					<th>Year</th>
					<th>Dept</th>
					<th>CNUM</th>
					<th>Name</th>
					<th>Shift</th>
					<th>Roll No.</th>
					<th>Status</th>
					<th>Action</th>
				</tr>
				<?php
					include 'db/db_connect.php';
					$sql = "SELECT SA.StdAdmID, CNUM, RollNo, CONCAT(FirstName, ' ', FatherName,  ' ', Surname) AS StdName, DM.DeptName, SA.Shift  , Year, SA.stdstatus 
							FROM tblstdadm SA 
							INNER JOIN tblstudent S ON S.StdId = SA.StdID
							INNER JOIN tbldepartmentmaster DM ON SA.Dept = DM.DeptID
							WHERE SA.EduYearFrom  = " . $SelYearFrom . " AND SA.EduYearTo = " . $SelYearTo . " AND YEAR <> 'A.L.'  
							AND SA.stdstatus <> 'R' ";
//Coalesce(SA.AdmConf,0) = 0 and 
					If (isset($_SESSION["tmpseldept"]))
					{
						$sql = $sql . " and DM.DeptID = "  . $_SESSION["tmpseldept"]  ;
					}
					If (isset($_SESSION["tmpselyear"]))
					{
						$sql = $sql . " and Year = '"  . $_SESSION["tmpselyear"] . "'" ;
					}
					If ((isset($_SESSION["tmpseldiv"])))
					{
						$sql = $sql . " and SA.`div` = '"  . $_SESSION["tmpseldiv"] . "'" ;
					}
					$sql = $sql . "	ORDER BY YEAR, SA.Dept, SA.Shift, Surname";
					//echo $sql;
					// execute the sql query
					$result = $mysqli->query( $sql );
					$num_results = $result->num_rows;

					if( $num_results ){
						while( $row = $result->fetch_assoc() ){
							extract($row);
							echo "<TR class='odd gradeX'>";
							echo "<td>{$Year} </td>";
							echo "<td>{$DeptName} </td>";
							echo "<td>{$CNUM} </td>";
							echo "<td>{$StdName} </td>";
							echo "<td>{$Shift} </td>";
							echo "<td>{$RollNo} </td>";
							echo "<td>{$stdstatus} </td>";
							echo "<td class='span2'>";
							echo "<a class='btn btn-mini btn-success' href='ProgressionUpd.php?IUD=R&StdAdmID={$StdAdmID}'><i class='icon-ok icon-white'></i>&nbsp&nbspRegular</a>";
							echo "</td>";
							echo "</TR>";
						}
					}					
					//disconnect from database
					$result->free();
					$mysqli->close();

				?>

			</table>
			


			</div>
	</div>
	</form>

