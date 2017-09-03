<?php
if(!isset($_SESSION)){
	session_start();
}
//include database connection
include 'db/db_connect.php';
 // if the form was submitted/posted, update the record
 if(isset($_POST['btnUpdate']))
	{

			$sql = "UPDATE  tblstdadm
						Set castcert = ?
							,creamycert = ?
						Where StdID = ?";
						//include database connection
				include 'db/db_connect.php';
				
				$stmt = $mysqli->prepare($sql);
				$stmt->bind_param('iii', $_POST['ddlcastcert'], $_POST['ddlcreamycert'],$_GET['StdID']);
				$stmt->execute();				
				//header('Location: UserListMain.php?'); 
				echo "<script type='text/javascript'>window.onload = function()
				{
						document.getElementById('lblSuccess').style.display = 'block';
				}
				</script>";
	}
	include 'db/db_connect.php';
	$sql = "SELECT CNUM, CONCAT(Surname, ' ',FirstName,' ',Fathername) AS stdname,
				CONCAT(Coalesce(YEAR,'N/A'),' - ',Coalesce(dm.DeptName,'N/A'),' - ',Coalesce(`div`,'N/A'),' - ',Coalesce(RollNo,'N/A')) AS stdinfo, feadmyear,admcat,seattype,coalesce(castcert,0) as castcert,coalesce(creamycert,0) as creamycert
			FROM tblstdadm sa 
			INNER JOIN tblstudent s ON s.stdid = sa.stdid 
			INNER JOIN tbldepartmentmaster dm ON dm.DeptId = sa.Dept
			WHERE s.StdID =  " . $_GET['StdID'] . " and sa.EduYearFrom = ". $_GET['eduyear'];
		//echo $sql;
		// execute the sql query
		$result = $mysqli->query( $sql );
		$row = $result->fetch_assoc();
		extract($row);
		//disconnect from database
		$result->free();
		$mysqli->close();

	
	
	
	// make changes based on the cast cert and creamy cert - if one of that is NO then get fee for OPEN!
	include 'db/db_connect.php';
	if(($castcert == "0") || ($creamycert == "0")){
		$sql2 = "SELECT CNUM, CONCAT(Surname, ' ',FirstName,' ',Fathername) AS stdname,
					CONCAT(Coalesce(YEAR,'N/A'),' - ',Coalesce(dm.DeptName,'N/A'),' - ',Coalesce(`div`,'N/A'),' - ',Coalesce(RollNo,'N/A')) AS stdinfo, feadmyear,admcat,ST.seattype,coalesce(castcert,0) as castcert,coalesce(creamycert,0) as creamycert,FeeType,Fee
				FROM tblstdadm sa 
				INNER JOIN tblstudent s ON s.stdid = sa.stdid AND sa.EduYearFrom = " . $_GET['eduyear'] . " 
				INNER JOIN tbldepartmentmaster dm ON dm.DeptId = sa.Dept 
				INNER JOIN tblseattypefeedetail STFD ON CONCAT(sa.eduyearfrom,'-',SUBSTRING(sa.eduyearto,3,2)) = CalYear
				AND feadmyear = AdmYear AND sa.Year = EduYear
				INNER JOIN tblseattype ST ON STFD.SeatTypeId = ST.SeatTypeId  AND ST.SeatType = 'OPEN'
				INNER JOIN tblfeetype ft ON ft.FeeTypeID = STFD.FeeTypeID
				WHERE s.StdID = " . $_GET['StdID'] ;
		
	}
	else{
		$sql2 = "SELECT CNUM, CONCAT(Surname, ' ',FirstName,' ',Fathername) AS stdname,
					CONCAT(Coalesce(YEAR,'N/A'),' - ',Coalesce(dm.DeptName,'N/A'),' - ',Coalesce(`div`,'N/A'),' - ',Coalesce(RollNo,'N/A')) AS stdinfo, feadmyear,admcat,ST.seattype,coalesce(castcert,0) as castcert,coalesce(creamycert,0) as creamycert,FeeType,Fee
				FROM tblstdadm sa 
				INNER JOIN tblstudent s ON s.stdid = sa.stdid AND sa.EduYearFrom = " . $_GET['eduyear'] . " 
				INNER JOIN tbldepartmentmaster dm ON dm.DeptId = sa.Dept 
				INNER JOIN tblseattypefeedetail STFD ON CONCAT(sa.eduyearfrom,'-',SUBSTRING(sa.eduyearto,3,2)) = CalYear
				AND feadmyear = AdmYear AND sa.Year = EduYear
				INNER JOIN tblseattype ST ON STFD.SeatTypeId = ST.SeatTypeId  AND cseattype = ST.SeatType
				INNER JOIN tblfeetype ft ON ft.FeeTypeID = STFD.FeeTypeID
				WHERE s.StdID = " . $_GET['StdID'] ;
		
	}
	//echo $sql2;
	$result2 = $mysqli->query( $sql2 );
	$num_results2 = $result2->num_rows;
	if( $num_results2 ){
		$row2 = $result2->fetch_assoc();
		extract($row2);
	}
?>
 
<form action="StdAcctMaintMain.php?StdID=<?php echo $_GET['StdID']; ?>&eduyear=<?php echo $_GET['eduyear']; ?>" method="post">
	<head>
	</head>
	<br /><br />
	<h3 class="page-title" style="margin-left:5%">Student Update</h3>
	<div class="row-fluid">
		<div class="v_detail" style="margin-left:5%;height:120%">
			<table cellpadding="10" cellspacing="0" border="0" width="50%" class="tab_split">
				<tr>
					<td class="form_sec span5">&nbsp;</td>
					<td>
						<label id="lblSuccess" style="margin-left:10px;color:green;font-weight:bold;display:none" >Data saved successfully.</label>
						<div class="span10">
							<input type="hidden" name="txtuserID" value="<?php echo "{$userID}" ?>" />
							<?php 
							if(($_SESSION["ReadAccess"] == "Yes") && ($_SESSION["WriteAccess"] == "Yes")){
								echo "<input type='submit' name='btnUpdate' value='Save' title='Update' class='btn btn-mini btn-success' />";
							}
							?>
							<a href="StdListAcctMain.php" class="btn btn-mini btn-warning">Cancel</a>
							<a style="display:none" href="payfee.php?StdID=<?php echo $_GET['StdID']; ?>&eduyear=<?php echo $_GET['eduyear']; ?>" class="btn btn-mini btn-success">Pay using BillDesk</a>
						</div>
					</td>								
				</tr>
				<tr>
					<td class="form_sec span5">CNUM</td>
					<td><?php echo $CNUM; ?></td>
				</tr>
				<tr>
					<td class="form_sec span5">Name</td>
					<td><?php echo $stdname; ?></td>
				</tr>
				<tr>
					<td class="form_sec span5">Year - Dept - Division - Roll No</td>
					<td><?php echo $stdinfo; ?></td>
				</tr>
				<tr>
					<td class="form_sec span5">Adm Year</td>
					<td><?php echo $feadmyear; ?></td>
				</tr>
				<tr>
					<td class="form_sec span5">Category</td>
					<td><?php echo $admcat; ?></td>
				</tr>									
				<tr>
					<td class="form_sec span5">Seat Type</td>
					<td><?php echo $seattype; ?></td>
				</tr>									
				<tr>
					<td class="form_sec span5">Cast Certificate?</td>
					<td>
						<select name="ddlcastcert">
							<option value="0" <?php if($castcert == "0") echo " Selected"; ?>>No</option>
							<option value="1" <?php if($castcert == "1") echo " Selected"; ?>>Yes</option>
						</select>
					</td>
				</tr>								
				<tr>
					<td class="form_sec span5">Creamy Layer Certificate?</td>
					<td>
						<select name="ddlcreamycert">
							<option value="0" <?php if($creamycert == "0") echo " Selected"; ?>>No</option>
							<option value="1" <?php if($creamycert == "1") echo " Selected"; ?>>Yes</option>
						</select>
					</td>
				</tr>								
				<!-- Display fee here! -->
				<?php
				if( $num_results ){
					while( $row2 = $result2->fetch_assoc() ){
							echo "<tr>";
							echo "<td class='form_sec span5'>" . $FeeType . "</td>";
							echo "<td>". $Fee . "</td>";
							echo "</tr>";									
							extract($row2);
					}
				}
				?>
			</table>
		</div>
	</div>
</form>

