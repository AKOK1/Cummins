
<?php
//include database connection

	if(!isset($_SESSION)){
		session_start();
	}
		if(isset($_POST['ddldept'])){
			$_SESSION["seldeptid"] = $_POST['ddldept'];
		}		

// if the form was submitted/posted, update the record
 if($_POST)
	{
		include 'db/db_connect.php';
		if ($_POST['txtpsoid'] == "I") {
			$sql = "Insert into tblpso ( psodesc,DeptID) Values (?,?)";
			$stmt = $mysqli->prepare($sql);
			$stmt->bind_param('si', $_POST['txtpsodesc'],$_SESSION["seldeptid"]);
		}
		else {
			$sql = "UPDATE  tblpso
						Set psodesc = ?,
							DeptID = ?
						Where psoid = ?";
				$stmt = $mysqli->prepare($sql);
				//echo $sql;
				$stmt->bind_param('sii', $_POST['txtpsodesc'],$_SESSION["seldeptid"], $_POST['txtpsoid'] );

				}
		
		// execute the update statement
		if($stmt->execute()){
			header('Location: PSOListMain.php?'); 
			// close the prepared statement
		}else{
			echo $mysqli->error;
			die("Unable to update.");
		}
	}
else 
	{
		if ($_GET['psoid'] == "I") {
			$sql = "SELECT 'I' as psoid,'' as DeptID, '' as psodesc " ;
		}
		Else
		{  
			$sql = " SELECT psoid, psodesc,DeptID FROM tblpso Where psoid = " . $_GET['psoid']   ;
		} 

		// execute the sql query
		$result = $mysqli->query( $sql );
		$row = $result->fetch_assoc();
		extract($row);
		 
		//disconnect from database
		$result->free();
		$mysqli->close();
	}
	?>

<form action="PSOMaintMain.php?psoid=<?php echo $_GET['psoid']; ?>" method="post">
	<br /><br />
	<h3 class="page-title" style="margin-left:5%">PSO Maintenance</h3>
	<div class="row-fluid">
		<div class="v_detail" style="margin-left:5%">
			<table cellpadding="10" cellspacing="0" border="0" width="50%" class="tab_split">
				<tr>
					<td class="form_sec span4">&nbsp;</td>
					<td>
						<div class="span10">
							<input type="hidden" name="txtpsoid" value="<?php echo $_GET['psoid'] ?>" />
							<?php 
							if(($_SESSION["ReadAccess"] == "Yes") && ($_SESSION["WriteAccess"] == "Yes")){
								echo "<input type='submit' name='btnUpdate' value='Save' title='Update' class='btn btn-mini btn-success' />";
							}
							?>
							<a href="PSOListMain.php" class="btn btn-mini btn-warning">Cancel</a>
						</div>
					</td>								
				</tr>
				<tr>
					<td class="form_sec span4">Name</td>
					<td>
						<input type="text" maxlength="1000" name="txtpsodesc" class="textfield" style="width:800px;" value="<?php echo "{$psodesc}" ?>"/>
					</td>
				</tr>	
				
				<?php
				
				include 'db/db_connect.php';
				echo "<tr>";
				echo "<td class='form_sec span4'>Name</td>";
				echo "<td>";
				$strSelect1 = "<select required id='ddldept' name='ddldept' style='width:120px;'";
					$strSelect2 = "<option value=''>Select Dept</option>";
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
									else if(isset($_SESSION["seldeptid"]))
									{ 
										if($_SESSION["seldeptid"] == $DeptID) 
											$strSelect2 = $strSelect2 .  'selected';
										if($_SESSION["seldeptid"] == $Department) {
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
					echo "</td>";
					echo "</tr>";
				?>
								
			</table>
		</div>
	</div>
</form>

