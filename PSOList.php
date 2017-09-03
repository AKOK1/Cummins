<form action="PSOListMain.php" method="post" name="myform">
<?php
		if(!isset($_SESSION)){
			session_start();
		}
		
		if(isset($_POST['ddldept'])){
			$_SESSION["seldeptid"] = $_POST['ddldept'];
		}		
		else{
							$sql = "SELECT DeptID,DeptName FROM tbluser U 
							INNER JOIN tbldepartmentmaster DM on U.Department = DM.DeptName
							where userID =  " . $_SESSION["SESSUserID"] . " and coalesce(teaching,0) = 1";
							//echo $sql;
							$result1 = $mysqli->query( $sql );
							while( $row = $result1->fetch_assoc() ) {
								extract($row);
								$_SESSION["seldeptid"]  = $DeptID;
								$_SESSION["SESSRAUserDept"] = $DeptName;
							}	
		}
		
?>

	<br /><br />

	<h3 class="page-title">PSO List</h3>
	<h3 class="page-title" style="float:right;margin-top:-40px;"><a href="MainMenuMain.php">Back</a></h3>
	<div class="row-fluid">
		<div class="v_detail">
		
		
		<?php
			//include database connection
			include 'db/db_connect.php';

		$setdisabled = '0';
		$strSelect1 = '';
		$strSelect2 = '';
		include 'db/db_connect.php';
		$strSelect1 = "<select id='ddldept' onchange='document.myform.submit();' name='ddldept' style='margin-top:10px;margin-left:90px;width:160px;'";
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
							if($_SESSION["SESSRAUserDept"] == $Department){
								$strSelect2 = $strSelect2 . ' selected ';
								$strSelect1 = $strSelect1 . " disabled";
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
			<br/>
		
			<table cellpadding="10" cellspacing="0" border="0" width="100%" class="tab_split">
				<tr>
					<th><a class='btn btn-mini btn-success' href="PSOMaintMain.php?psoid=I"><i class="icon-plus icon-white"></i>New</a></th>
					<th><strong>Name</strong></th>
					<th><strong>Department</strong></th>
					<th><strong>Delete</strong></th>
				</tr>
				 
	
				<?php
			include 'db/db_connect.php';

				$query = "SELECT psoid,psodesc,d.DeptName FROM tblpso pm
				inner join tbldepartmentmaster d on d.DeptID =  pm.DeptID
				where d.DeptID = " . $_SESSION["seldeptid"] ;
				//echo $query;
				
												
				$result = $mysqli->query( $query );
				$num_results = $result->num_rows;
				
				if( $num_results ){
					while( $row = $result->fetch_assoc() ){
						extract($row);
					  echo "<TR class='odd gradeX'>";
					  echo "<td><a class='btn btn-mini btn-primary' href='PSOMaintMain.php?psoid={$psoid}'><i class='icon-pencil icon-white'></i>Edit</a> </td>";
					  echo "<td>{$psodesc}</td>";
					   echo "<td>{$DeptName}</td>";
					   echo "<td><a onclick=\"return confirm('Are you sure?');\" class='btn btn-primary' href='PSOListUpd.php?IUD=D&psoid={$psoid}'><i class='icon-remove icon-white'></i></a> </td>";
					  echo "</TR>";
					}
				}
				else{
					echo "<TR class='odd gradeX'>";
					echo "<td></td>";
					echo "<td>No records found.</td>";
					echo "<td></td>";
					echo "<td></td>";
					echo "</TR>";
				}

				echo "</table>";

				?> 
				
			</table>
		</div>
	</div>

</form>
