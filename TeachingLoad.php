<?php
	//include database connection
	include 'db/db_connect.php';
	if(!isset($_SESSION)){
		session_start();
	}
	$sql = "SELECT DeptID,DeptName 
			FROM tbluser U 
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
<form>
<head>
<script>
function sendtoreport()
{
	var subvalue = document.getElementById("ddldept").value;
	var subtext = ddldept.options[ddldept.selectedIndex].text;
	window.open('PrintTeachingLoad.php?deptname=' + subtext );
	return false;
}

</script>
</head>
<body>
<div class="row-fluid">
<br/><br/><br/>
		<div style="float:left"><h3 class="page-title">Teaching Load Report</h3></div>
		<div style="float:left;margin-top:18px;margin-left:20px;">
			<?php

					$setdisabled = '0';
					$strSelect1 = '';
					$strSelect2 = '';
					include 'db/db_connect.php';
					$strSelect1 = "<select id='ddldept' name='ddldept' style='width:120px;'";
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
						if(isset($_SESSION["SESSRAUserDept"]))
						{ 
							if($_SESSION["SESSRAUserDept"] == $Department) {
								$strSelect2 = $strSelect2 . ' selected ';
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
			?>
		</div>
		<div style="float:left;margin-top:20px;margin-left:20px;">
			<input type="button" name="btnreport" value="View Report" class="btn btn btn-success" onclick="return sendtoreport();" />

		</div>
		<div style="float:right"><h3 class='page-title' style='margin-right:30px;'><a href='MainMenuMain.php'>Back</a></h3></div>
	</div>	
</body>	
</form>
