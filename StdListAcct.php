<?php
if(!isset($_SESSION)){
	session_start();
}

if(isset($_POST['ddldept'])){
	$_SESSION["pmseldept"] = $_POST['ddldept'];
}
if(isset($_POST['ddlYear'])){
	$_SESSION["pmselyear"] = $_POST['ddlYear'];
}
if(isset($_POST['ddleduyear'])){
	$_SESSION["pmseleduyear"] = $_POST['ddleduyear'];
}
if(isset($_POST['ddldiv'])){
	$_SESSION["pmseldiv"] = $_POST['ddldiv'];
}

?>	
<form action="StdListAcctMain.php" method="post" name="myform">
	<br /><br />
<head>
	 <script type="text/javascript">     
	 function showyear(){
		$('#selecteddept').val($('#ddldept').val());
		 $('#selectedyear').val($('#ddlYear').val());
		  $('#selectededuyear').val($('#ddleduyear').val());
		  $('#selecteddiv').val($('#ddldiv').val());
		document.myform.submit();
	 }
	 function showdept(){
		$('#selecteddept').val($('#ddldept').val());
		 $('#selectedyear').val($('#ddlYear').val());
		  $('#selectededuyear').val($('#ddleduyear').val());
		  $('#selecteddiv').val($('#ddldiv').val());
		document.myform.submit();
	 }
	 function showeduyear(){
		 $('#selectededuyear').val($('#ddleduyear').val());
		 $('#selecteddept').val($('#ddldept').val());
		  $('#selectedyear').val($('#ddlYear').val());
		  $('#selecteddiv').val($('#ddldiv').val());
		document.myform.submit();
	 }
	 function showdiv(){
		 $('#selectededuyear').val($('#ddleduyear').val());
		 $('#selecteddept').val($('#ddldept').val());
		  $('#selectedyear').val($('#ddlYear').val());
		  $('#selecteddiv').val($('#ddldiv').val());
		document.myform.submit();
	 }
	</script>
</head>
<body>
	<input type="hidden" name="selecteddept" id="selecteddept" value="">
	<input type="hidden" name="selectedyear" id="selectedyear" value="">
	<input type="hidden" name="selectededuyear" id="selectededuyear" value="">
	<input type="hidden" name="selecteddiv" id="selecteddiv" value="">
	<div style="margin-top:10px">
		<div style="float:left">
			<h3 class="page-title">Student List</h3>
		</div>
		<div style="float:left;margin-top:18px;margin-left:20px;">
				<tr>				
					<td>
						<select  id="ddleduyear" name="ddleduyear" onchange="showeduyear();" style="width:140px">
							<?php
							include 'db/db_connect.php';
							echo "<option value=''>Educational Year</option>"; 
							$sql = "SELECT EduYearFrom,CONCAT(EduYearFrom, '-',SUBSTRING(EduYearTo,3,2)) AS curyear
									FROM tblcuryearauto
									UNION
									SELECT EduYearFrom-1,CONCAT(EduYearFrom-1, '-',SUBSTRING(EduYearTo-1,3,2)) AS curyear
									FROM tblcuryearauto
									UNION
									SELECT EduYearFrom-2,CONCAT(EduYearFrom-2, '-',SUBSTRING(EduYearTo-2,3,2)) AS curyear
									FROM tblcuryearauto";
							$result1 = $mysqli->query( $sql );
							while( $row = $result1->fetch_assoc() ) {
							extract($row);
							if((isset($_SESSION["pmseleduyear"])) && ($_SESSION["pmseleduyear"] == $EduYearFrom)){
									echo "<option value={$EduYearFrom} selected>{$curyear}</option>"; 
								}
								else{
									echo "<option value={$EduYearFrom}>{$curyear}</option>"; 
								}
							}
							
							?>
						</select>
					</td>
				</tr>	
			</div>	
		<div style="float:left;margin-top:18px;margin-left:20px;">
				<?php
				if(!isset($_SESSION)){
					session_start();
				}
				include 'db/db_connect.php';
				$strSelect1 = "<select id='ddldept' onchange='showdept();' name='ddldept' style='width:120px;'";
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
	
									if(isset($_SESSION["pmseldept"]))
									{ 
										if($_SESSION["pmseldept"] == $DeptID){
											$strSelect2 = $strSelect2 . ' selected ';
										}
									} 
									else if(isset($_POST['ddldept']))
									{ 
										if($_POST["ddldept"] == $DeptID) 
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
					<select id="ddlYear" name="ddlYear" onchange="showyear();" style="width:120px">
						<option value="">Select Year</option>
						<option value="FE" <?php if(isset($_SESSION["pmselyear"])){if($_SESSION["pmselyear"] == "FE") echo "selected";} ?>>F.E.</option>
						<option value="SE" <?php if(isset($_SESSION["pmselyear"])){if($_SESSION["pmselyear"] == "SE") echo "selected";} ?>>S.E.</option>
						<option value="TE" <?php if(isset($_SESSION["pmselyear"])){if($_SESSION["pmselyear"] == "TE") echo "selected";} ?>>T.E.</option>
						<option value="BE" <?php if(isset($_SESSION["pmselyear"])){if($_SESSION["pmselyear"] == "BE") echo "selected";} ?>>B.E.</option>
						<option value="ME" <?php if(isset($_SESSION["pmselyear"])){if($_SESSION["pmselyear"] == "ME") echo "selected";} ?>>M.E.</option>
						<option value="FY" <?php if(isset($_SESSION["pmselyear"])){if($_SESSION["pmselyear"] == "FY") echo "selected";} ?>>F.Y.M.Tech.</option>
						<option value="SY" <?php if(isset($_SESSION["pmselyear"])){if($_SESSION["pmselyear"] == "SY") echo "selected";} ?>>S.Y.M.Tech.</option>
					</select>
			</div>
		<div style="float:left;margin-top:18px;margin-left:20px;">
				<select id="ddldiv" name="ddldiv" style="width:130px"  onchange="showdiv();" required>
					<option value="">Select Division</option>
					<option value="A" <?php if(isset($_SESSION["pmseldiv"])){if($_SESSION['pmseldiv'] == "A") echo "selected";} ?>>A</option>
					<option value="B" <?php if(isset($_SESSION["pmseldiv"])){if($_SESSION['pmseldiv'] == "B") echo "selected";} ?>>B</option>
					<option value="C" <?php if(isset($_SESSION["pmseldiv"])){if($_SESSION['pmseldiv'] == "C") echo "selected";} ?>>C</option>
					<option value="D" <?php if(isset($_SESSION["pmseldiv"])){if($_SESSION['pmseldiv'] == "D") echo "selected";} ?>>D</option>
					<option value="E" <?php if(isset($_SESSION["pmseldiv"])){if($_SESSION['pmseldiv'] == "E") echo "selected";} ?>>E</option>
					<option value="F" <?php if(isset($_SESSION["pmseldiv"])){if($_SESSION['pmseldiv'] == "F") echo "selected";} ?>>F</option>
					<option value="G" <?php if(isset($_SESSION["pmseldiv"])){if($_SESSION['pmseldiv'] == "G") echo "selected";} ?>>G</option>
					<option value="H" <?php if(isset($_SESSION["pmseldiv"])){if($_SESSION['pmseldiv'] == "H") echo "selected";} ?>>H</option>
					<option value="I" <?php if(isset($_SESSION["pmseldiv"])){if($_SESSION['pmseldiv'] == "I") echo "selected";} ?>>I</option>
				</select>
		</div>
		
			<div style="float:right">
				<h3 class="page-title" style="margin-right:30px;"><a href="FeeIndexMain.php">Back</a></h3>
			</div>
		</div>
		<br/><br/><br/><br/>
	<div class="row-fluid">
		<div class="v_detail">
			<table cellpadding="10" cellspacing="0" border="0" class="tab_split">
				<tr>
				<?php

				// Create connection
				include 'db/db_connect.php';
				// echo "<th><a href='UserMaintMain.php?userID=I'><i class='icon-plus icon-white'></i>New</a></th>";
				echo "<th></th>";
				echo "<th>CNUM</th>";
				echo "<th>Mobno</th>";
				echo "<th>Student Name</th>";
				echo "<th>Year - Dept - Div - Roll No - Shift</th>";
				echo "<th>Adm. Year</th>";
				echo "<th>Category</th>";
				echo "<th>Seat Type</th>";
				echo "<th>CCOEW Seat Type</th>";
				echo "<th>Fee</th>";
				echo "</tr>";

				$deptval = "";
				$eduyearval = "";
				$yearval = "";							
				if(isset($_SESSION["pmseldept"]))
				{ 
					$deptval = $_SESSION["pmseldept"];
				} 
				if(isset($_SESSION["pmseleduyear"]))
				{ 
					$eduyearval = $_SESSION["pmseleduyear"];
				} 							
				if(isset($_SESSION["pmselyear"]))
				{ 
					$yearval = $_SESSION["pmselyear"];
				} 							
				if(isset($_SESSION["pmseldiv"]))
				{ 
					$divval = $_SESSION["pmseldiv"];
				} 							

				if(isset($eduyearval) && ($eduyearval <> '' ) && isset($deptval) && ($deptval <> '') && isset($yearval) && ($yearval <> '') 
					&& isset($divval) && ($divval <> '')){
						$query = "SELECT s.StdId,CNUM, CONCAT(Surname, ' ',FirstName,' ',Fathername) AS stdname,
										CONCAT(YEAR,' - ',dm.DeptName,' - ',`div`,' - ',RollNo,' - ',sa.Shift) AS stdinfo,feadmyear,admcat,SFTD.seattype,Mobno,
										s.cseattype, Fee
									FROM tblstdadm sa 
									INNER JOIN tblstudent s ON s.stdid = sa.stdid 
									INNER JOIN tbldepartmentmaster dm ON dm.DeptId = sa.Dept
									LEFT OUTER JOIN (SELECT CalYear, AdmYear, AdmType, EduYear, SUM(Fee) AS Fee, SeatType 
									FROM tblseattypefeedetail STFD
									INNER JOIN tblseattype ST ON STFD.SeatTypeId = ST.SeatTypeId
									GROUP BY CalYear, AdmYear, AdmType, EduYear, SeatType ) AS SFTD ON  CONCAT(sa.eduyearfrom,'-',SUBSTRING(sa.eduyearto,3,2)) = CalYear AND sa.Year = EduYear 
									AND case when ((coalesce(castcert,0) = 0) OR (coalesce(creamycert,0) = 0)) Then 'OPEN' Else cseattype End 
									= SFTD.SeatType AND feadmyear = AdmYear
									WHERE YEAR <> 'A.L.'
									and  Replace(sa.year,'.','') = '{$yearval}' 
									and sa.EduYearFrom = {$eduyearval} and sa.Dept = {$deptval} 
									and sa.`Div` = '{$divval}'";
				}
				$query =	$query . " order by cast(sa.RollNo as UNSIGNED)";
				//echo $query;
				$result = $mysqli->query( $query );
				
				$num_results = $result->num_rows;
				
				if( $num_results ){
					while( $row = $result->fetch_assoc() ){
						extract($row);
					  echo "<TR class='odd gradeX'>";
					  echo "<td><a class='btn btn-mini btn-primary' href='StdAcctMaintMain.php?StdID={$StdId}&eduyear={$eduyearval}'><i class='icon-white'></i>Edit</a> </td>";
					  echo "<td>{$CNUM}</td>";
					  echo "<td>{$Mobno}</td>";
					  echo "<td>{$stdname}</td>";
					  echo "<td>{$stdinfo}</td>";
					  echo "<td>{$feadmyear}</td>";
					  echo "<td>{$admcat}</td>";
					  echo "<td>{$seattype}</td>";
					  echo "<td>{$cseattype}</td>";
					  echo "<td>{$Fee}</td>";
					  echo "</TR>";
					}
				}
				else{
					echo "<TR class='odd gradeX'>";
					echo "<td>No records found.</td>";
					echo "<td></td>";
					echo "<td></td>";
					echo "<td></td>";
					echo "<td></td>";
					echo "<td></td>";
					echo "<td></td>";
					echo "<td></td>";
					echo "<td></td>";
					echo "</TR>";
				}

				echo "</table>";
				?> 
				
			</table>
		</div>
	</div>
</body>
</form>