<form action="BatchListMain.php" method="post" name="myform">
	<br /><br />
	<h3 class="page-title">Batch Master List</h3>
	<h3 class="page-title" style="float:right;margin-top:-40px;"><a href="MainMenuMain.php">Back</a></h3>	
			<table cellpadding="05" cellspacing="0" border="0" class="tab_split" style="width:40%">
			<tr >
				<td class="form_sec span1"><b>Select Department to view Batches</b></td>
				<td class="form_sec span1">
					<?php
						//include database connection
						include 'db/db_connect.php';
						if(!isset($_SESSION)){
							session_start();
						}
							if(isset($_POST['ddldept'])){
								$_SESSION["seldeptid"] = $_POST['ddldept'];
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





					$setdisabled = '0';
					$strSelect1 = '';
					$strSelect2 = '';
					include 'db/db_connect.php';
					$strSelect1 = "<select id='ddldept' onchange='document.myform.submit();' name='ddldept' style='margin-top:10px;width:160px;'";
						//if($_SESSION["SESSRAUserDept"] == $Department) 
						//	echo ' disabled';
					$strSelect2 = "<option value='0'>Select Department</option>";
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
										else if(isset($_SESSION["seldeptid"])){
											if($_SESSION["seldeptid"] == $DeptID){
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
				<input type="hidden" name="hdnyear" id="year_hidden">
				</td>
				
			</tr>						
		</table>
		<br/>
	<div class="row-fluid">
		<div class="v_detail">
			<table cellpadding="10" cellspacing="0" border="0" width="60%" class="tab_split">
				<tr>
					<th><a class='btn btn-mini btn-success' href="BatchMaintMain.php?BtchId=I"><i class="icon-plus icon-white"></i>New</a></th>
					<th><strong>Batch Name</strong></th>
					<th><strong>Year</strong></th>
					<th><strong>Paper Type</strong></th>
					<th><strong>Division</strong></th>
					<th><strong>Roll No From</strong></th>
					<th><strong>Roll No To</strong></th>
				</tr>

				<?php
					include 'db/db_connect.php';
					$sql = 'SELECT EduYearFrom, EduYearTo FROM tblcuryear';
					$result = $mysqli->query( $sql );
					$num_results = $result->num_rows;
					if( $num_results ){
						while( $row = $result->fetch_assoc() ){
							extract($row);
						}
					}
					if((isset($_SESSION["seldeptid"]) and ($_SESSION["seldeptid"] != "0")) OR (isset($_SESSION["SESSUserDept"]))){
						// Create connection
						//in (SELECT DeptID FROM tbldepartmentmaster where DeptName = '" . $_SESSION["SESSUserDept"] . "') order by EduYear";
						include 'db/db_connect.php';
						if((isset($_SESSION["seldeptid"]) and ($_SESSION["seldeptid"] != "0"))){
							$query = "SELECT bm.BtchID, BatchName,Concat(Substring(EduYear,1,1),'.', Substring(EduYear,2,1),'.') as EduYear,papertype,divn
										,MIN(RollNo) as minrollno,MAX(RollNo) as maxrollno
							FROM tblbatchmaster bm
							LEFT OUTER JOIN tblyearstructstd yss ON yss.BtchId = bm.BtchId 
							LEFT OUTER  JOIN tblstdadm sa ON sa.StdAdmId = yss.StdAdmId and sa.EduYearFrom = " . $EduYearFrom . "
							where bm.DeptID  =  " . $_SESSION["seldeptid"] .
							" GROUP BY bm.BtchID, BatchName,CONCAT(SUBSTRING(EduYear,1,1),'.', SUBSTRING(EduYear,2,1),'.'),papertype,divn
							Order by EduYear,divn,papertype,BatchName";
						}
						else{
							$query = "SELECT bm.BtchID, BatchName,Concat(Substring(EduYear,1,1),'.', Substring(EduYear,2,1),'.') as EduYear,papertype,divn
										,MIN(RollNo) as minrollno,MAX(RollNo) as maxrollno
							FROM tblbatchmaster bm
							LEFT OUTER JOIN tblyearstructstd yss ON yss.BtchId = bm.BtchId 
							LEFT OUTER JOIN tblstdadm sa ON sa.StdAdmId = yss.StdAdmId and sa.EduYearFrom = " . $EduYearFrom . "
							where bm.DeptID  =  " . $_SESSION["SESSRAUserDeptID"] .
							" GROUP BY bm.BtchID, BatchName,CONCAT(SUBSTRING(EduYear,1,1),'.', SUBSTRING(EduYear,2,1),'.'),papertype,divn
							Order by EduYear,divn,papertype,BatchName";
						}
							//LEFT OUTER tblcuryear cy on cy.EduYearFrom = sa.eduyearfrom
						//echo $query;
						$result = $mysqli->query( $query );
						$num_results = $result->num_rows;
						
						if( $num_results ){
							while( $row = $result->fetch_assoc() ){
								extract($row);
							  echo "<TR class='odd gradeX'>";
							  echo "<td><a class='btn btn-mini btn-primary' href='BatchMaintMain.php?BtchId={$BtchID}'><i class='icon-pencil icon-white'></i>Edit</a> </td>";
							  echo "<td>{$BatchName}</td>";
							  echo "<td>{$EduYear}</td>";
							  echo "<td>{$papertype}</td>";
							  echo "<td>{$divn}</td>";
							  echo "<td>{$minrollno}</td>";
							  echo "<td>{$maxrollno}</td>";
							  echo "</TR>";
							}
						}
						else{
							echo "<TR class='odd gradeX'>";
							echo "<td></td>";
							echo "<td>No records found.</td>";
							echo "<td></td>";
							echo "</TR>";
						}
						echo "</table>";
					}
				?> 
				
			</table>
		</div>
	</div>

</form>
