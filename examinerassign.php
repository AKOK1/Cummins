	<?php
		if(!isset($_SESSION)){
			session_start();
		}
	
		if(isset($_POST['ddldept'])){
			$_SESSION["capseldept"] = $_POST['ddldept'];
		}
		
		?>		
<script>
				 function sendtodiv(profid) {
					window.location.href = 'assigndivisionMain.php?profid=' + profid;
				}
</script>
<form action="examinerassignMain.php" method="post">
	<br /><br />
	<div class="row-fluid">
		<div style="float:left"><h3 class="page-title">Examiner Assignment  
		PR / OR &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Professor List</h3></div>
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
					
					
						if(isset($_SESSION["capseldept"]))
						{ 
							if($_SESSION["capseldept"] == $DeptID){
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
			<input type="submit" name="btnView" value="View" title="Update" class="btn btn-mini btn-success" />
		</div>
		<div style="float:right"><h3 class='page-title' style='margin-right:30px;'><a href='examinerAssignmentMain.php'>Back</a></h3></div>
	</div>	
	
	<br/>
	<div class="row-fluid">
		<div class="v_detail">
			<table cellpadding="10" cellspacing="0" border="0" width="60%" class="tab_split">
				<tr>
					<th>Sr. No.</th>
					<th>Professor Name</th>
					<th>Assign</th>
					
				</tr>	
<?php
					include 'db/db_connect.php';
					If ((isset($_POST['btnView'])) or (isset($_SESSION["capseldept"])))
					{
					
					$sql = "SELECT userID,CONCAT(FirstName,' ', LastName) AS profname, DM.DeptName
							from tbluser U
							INNER JOIN tbldepartmentmaster DM ON U.Department = DM.DeptName";
						
					if(isset($_SESSION["capseldept"])){
						$sql = $sql . " and DM.DeptID = "  . $_SESSION["capseldept"]  ;
					}
					$sql = $sql . " ORDER BY userID";
					//echo $sql;	
					// Prepare IN parameters
					
					//die;
					$result = $mysqli->query($sql);
					$num_results = $result->num_rows;
					//echo $num_results;

					if( $num_results ){
						$srno = 1;
						while( $row = $result->fetch_assoc() ){
							extract($row);
							echo "<TR class='odd gradeX'>";
							echo "<td>{$srno} </td>";
							echo "<td>{$profname} </td>";
							echo "<td class='span2'>
										<a class='btn btn-mini btn-success' id='btnsubmit' name='btnsubmit'
										onclick='javascript:sendtodiv({$userID});'>
										<i class='icon-ok icon-white'></i>&nbsp;&nbsp;Assign</a></td>";
							echo "</TR>";
							$srno = $srno  + 1;
						}
					}		
					
					$result->free();

					//disconnect from database
					$mysqli->close();
}
				?>
				
			</table>
		</div>
	</div>	
	</form>

