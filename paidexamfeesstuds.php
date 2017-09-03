<form action="paidexamfeesstudsMain.php" method="post">
<?php
		if(!isset($_SESSION)){
			session_start();
		}
		include 'db/db_connect.php';
		if(isset($_POST['btnSearch'])){
			if(isset($_POST['ddldpt'])){
				if($_POST['ddldpt'] <> ""){
					$_SESSION["tmpseldpt"] = $_POST['ddldpt'] ;
				}
			}
			if(isset($_POST['ddlyr'])){
				if($_POST['ddlyr'] <> ""){
					$_SESSION["tmpselyr"] = $_POST['ddlyr'] ;
				}
			}		
			if(isset($_POST['ddldivision'])){
				if($_POST['ddldivision'] <> ""){
					$_SESSION["tmpseldivision"] = $_POST['ddldivision'] ;
				}
			}		
		}
?>		<script>
function setall(chkmain) {
			if ($(chkmain).val() == 'Confirm All') {
				$('.checkbox-class').attr('checked', 'checked');
				$(chkmain).val('Uncheck All');
			} else {
				$('.checkbox-class').removeAttr('checked');
				$(chkmain).val('Confirm All');
			}
	 }
</script>
	<br /><br />
	<div class="row-fluid">
		<div style="float:left"><h3 class="page-title">Confirm Paid Exam Fees Students</h3></div>
		<div style="float:left;margin-top:18px;margin-left:20px;">
			<?php
				include 'db/db_connect.php';
				$strSelect1 = "<select id='ddldpt' name='ddldpt' style='width:120px;'";
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
						if(isset($_SESSION["tmpseldpt"]))
						{ 
							if($_SESSION["tmpseldpt"] == $DeptID) 
								$strSelect2 = $strSelect2 . 'selected';
						} 
						
						// if(isset($_POST['ddldept']))
						// { 
							// if($_POST["ddldept"] == $DeptID) 
								// $strSelect2 = $strSelect2 .  'selected';
						// } 		
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
				<select id="ddlyr" name="ddlyr" style="width:120px">
					<option value="0">Select Year</option>
					<option value="F.E." <?php if(isset($_SESSION["tmpselyr"])){if($_SESSION['tmpselyr'] == "F.E.") echo "selected";} ?>>F.E.</option>
					<option value="S.E." <?php if(isset($_SESSION["tmpselyr"])){if($_SESSION['tmpselyr'] == "S.E.") echo "selected";} ?>>S.E.</option>
					<option value="T.E." <?php if(isset($_SESSION["tmpselyr"])){if($_SESSION['tmpselyr'] == "T.E.") echo "selected";} ?>>T.E.</option>
					<option value="B.E." <?php if(isset($_SESSION["tmpselyr"])){if($_SESSION['tmpselyr'] == "B.E.") echo "selected";} ?>>B.E.</option>
					<option value="M.E." <?php if(isset($_SESSION["tmpselyr"])){if($_SESSION['tmpselyr'] == "M.E.") echo "selected";} ?>>M.E.</option>
<option value="FY - Sem 1" <?php if(isset($_SESSION["tmpselyr"])){if($_SESSION['tmpselyr'] == "FY - Sem 1") echo "selected";} ?>>FY - Sem 1</option>
<option value="FY - Sem 2" <?php if(isset($_SESSION["tmpselyr"])){if($_SESSION['tmpselyr'] == "FY - Sem 2") echo "selected";} ?>>FY - Sem 2</option>
<option value="SY - Sem 1" <?php if(isset($_SESSION["tmpselyr"])){if($_SESSION['tmpselyr'] == "SY - Sem 1") echo "selected";} ?>>SY - Sem 1</option>
<option value="SY - Sem 2" <?php if(isset($_SESSION["tmpselyr"])){if($_SESSION['tmpselyr'] == "SY - Sem 2") echo "selected";} ?>>SY - Sem 2</option>
				</select>
		</div>
		<div style="float:left;margin-top:18px;margin-left:20px;">
				<select id="ddldivision" name="ddldivision" style="width:120px">
					<option value="0">Select Division</option>
					<option value="ALL" <?php if(isset($_SESSION["tmpseldivision"])){if($_SESSION['tmpseldivision'] == "ALL") echo "selected";} ?>>All</option>
					<option value="A" <?php if(isset($_SESSION["tmpseldivision"])){if($_SESSION['tmpseldivision'] == "A") echo "selected";} ?>>A</option>
					<option value="B" <?php if(isset($_SESSION["tmpseldivision"])){if($_SESSION['tmpseldivision'] == "B") echo "selected";} ?>>B</option>
					<option value="C" <?php if(isset($_SESSION["tmpseldivision"])){if($_SESSION['tmpseldivision'] == "C") echo "selected";} ?>>C</option>
					<option value="D" <?php if(isset($_SESSION["tmpseldivision"])){if($_SESSION['tmpseldivision'] == "D") echo "selected";} ?>>D</option>
					<option value="E" <?php if(isset($_SESSION["tmpseldivision"])){if($_SESSION['tmpseldivision'] == "E") echo "selected";} ?>>E</option>
					<option value="F" <?php if(isset($_SESSION["tmpseldivision"])){if($_SESSION['tmpseldivision'] == "F") echo "selected";} ?>>F</option>
					<option value="G" <?php if(isset($_SESSION["tmpseldivision"])){if($_SESSION['tmpseldivision'] == "G") echo "selected";} ?>>G</option>
					<option value="H" <?php if(isset($_SESSION["tmpseldivision"])){if($_SESSION['tmpseldivision'] == "H") echo "selected";} ?>>H</option>
					<option value="I" <?php if(isset($_SESSION["tmpseldivision"])){if($_SESSION['tmpseldivision'] == "I") echo "selected";} ?>>I</option>
				</select>
		</div>
		<div style="float:left;margin-top:18px;margin-left:20px;">
			<input type="submit" name="btnSearch" value="Search" title="Update" class="btn btn-mini btn-success" />
			<?php echo "<a class='btn btn-mini btn-success' target='_new' 
							href='PrintHallTicket.php?deptid=" . $_SESSION["tmpseldpt"] . "&enggyear=" . $_SESSION["tmpselyr"] . "&div=" . $_SESSION["tmpseldivision"] . "'>
							Print Hall Ticket</a></td>";
			?>
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
				<label><b>Unpaid Exam Fees Students</b></label>
            </div>
			<table cellpadding="10" cellspacing="0" border="0" width="100%" class="tab_split" style="overflow:scroll">
				<tr>
					<th>Name</th>
					<th>Roll No</th>
					<th>ESN</th>
					<th>Action</th>
					<!-- <th>Confirm All<input onclick="setall(this);" class="checkbox-class" type="checkbox" value="Confirm All" /></th> -->
				</tr>
				<?php
					if(($_SESSION["tmpseldpt"] <> "") && ($_SESSION["tmpselyr"] <> "") && ($_SESSION["tmpseldivision"] <> "")){
						include 'db/db_connect.php';
						$sql = "SELECT SA.StdAdmID,CONCAT(Surname, ' ',FirstName) AS StdName, DM.DeptName,SA.RollNo,SA.ESNum
								FROM tblstdadm SA 
								INNER JOIN tblstudent S ON S.StdId = SA.StdID								
								INNER JOIN tbldepartmentmaster DM ON SA.Dept = DM.DeptID
								INNER JOIN tblexammaster em on em.AcadYearFrom = SA.EduYearFrom
								and em.ExamID = " . $_SESSION["SESSSelectedExam"] . "
								WHERE coalesce(stdstatus,'R') = 'R' 
								AND YEAR <> 'A.L.' 
								and SA.stdadmid not in (select stdadmid from tblexamfee where examid = " . $_SESSION["SESSSelectedExam"] . ")";  
								//AND COALESCE(SA.feespaid, 0) = 0 ";
						If ((isset($_SESSION["tmpseldpt"])) && ($_SESSION["tmpseldpt"] <> "1"))
						{
							$sql = $sql . " and DM.DeptID = "  . $_SESSION["tmpseldpt"]  ;
						}
						If ((isset($_SESSION["tmpselyr"])))
						{
							$sql = $sql . " and Year = '"  . $_SESSION["tmpselyr"] . "'" ;
						}
						If ((isset($_SESSION["tmpseldivision"])) AND ($_SESSION["tmpseldivision"] <> 'ALL'))
						{
							$sql = $sql . " and `div` = '"  . $_SESSION["tmpseldivision"] . "'" ;
						}
						$sql = $sql . " ORDER BY StdName";
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
								
								echo "<td>{$StdName} </td>";
								echo "<td>{$RollNo} </td>";
								echo "<td>{$ESNum} </td>";
								echo "<td class='span2'><a class='btn btn-mini btn-success' href='paidfeesUpd.php?IUD=I&StdAdmID={$StdAdmID}'><i class='icon-ok icon-white'></i>&nbsp&nbspConfirm</a></td>";
								 //echo "<td style='width:11%'><input id={$StdAdmID} class='checkbox-class' type='checkbox' value='0' /></td>";
								echo "</TR>";
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

        <div class="span6 v_detail">
            <div style="float:left;">
				<label><b>Paid Exam Fees</b></label>
            </div>
			<table cellpadding="10" cellspacing="0" border="0" width="100%" class="tab_split" style="overflow:scroll">
				<tr>
					<th>Name</th>
					<th>Roll No</th>
					<th>ESN</th>
					<th>Action</th>
				</tr>
				<?php
					if(($_SESSION["tmpseldpt"] <> "") && ($_SESSION["tmpselyr"] <> "") && ($_SESSION["tmpseldivision"] <> "")){
						include 'db/db_connect.php';
						$sql = "SELECT SA.StdAdmID,CONCAT(Surname, ' ',FirstName) AS StdName,SA.RollNo,SA.ESNum
								FROM tblstdadm SA 
								INNER JOIN tblstudent S ON S.StdId = SA.StdID
								inner join tblexamfee ef on ef.stdadmid = SA.stdadmid and ef.examid = " . $_SESSION["SESSSelectedExam"] . "
								INNER JOIN tbldepartmentmaster DM ON SA.Dept = DM.DeptID
								INNER JOIN tblexammaster em on em.AcadYearFrom = SA.EduYearFrom 
								and em.ExamId = ef.ExamID
								WHERE coalesce(stdstatus,'R') = 'R' and YEAR <> 'A.L.'" ;
								//  AND SA.feespaid = 1 
						If ((isset($_SESSION["tmpseldpt"])) && ($_SESSION["tmpseldpt"] <> 1))
						{
							$sql = $sql . " and DM.DeptID = "  . $_SESSION["tmpseldpt"]  ;
						}
						If ((isset($_SESSION["tmpselyr"])))
						{
							$sql = $sql . " and Year = '"  . $_SESSION["tmpselyr"] . "'" ;
						}
						If ((isset($_SESSION["tmpseldivision"])) AND ($_SESSION["tmpseldivision"] <> 'ALL'))
						{
							$sql = $sql . " and `div` = '"  . $_SESSION["tmpseldivision"] . "'" ;
						}

						$sql = $sql . "	ORDER BY StdName";
						//echo $sql;
						// execute the sql query
						$result = $mysqli->query( $sql );
						$num_results = $result->num_rows;

						if( $num_results ){
							while( $row = $result->fetch_assoc() ){
								extract($row);
								echo "<TR class='odd gradeX'>";
								echo "<td>{$StdName} </td>";
								echo "<td>{$RollNo} </td>";
								echo "<td>{$ESNum} </td>";
								echo "<td class='span2'><a class='btn btn-mini btn-danger' href='paidfeesUpd.php?IUD=C&StdAdmID={$StdAdmID}'><i class='icon-remove icon-white'></i>&nbsp&nbspCancel</a></td>";
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

