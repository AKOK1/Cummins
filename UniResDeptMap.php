<?php
//include database connection
include 'db/db_connect.php';

// if the form was submitted/posted, update the record
 if (isset($_POST['btnSave']))
	{
		$CDepts = $_POST['ddlCDept'];
		$Depts = $_POST['txtDept'];
		$size = count($Depts);

		for($i = 0 ; $i < $size ; $i++){
			//echo "CDept" . $CDepts[$i] . "<br/>";
			//echo "Dept" . $Depts[$i] . "<br/>";
			//echo "Res File" . $_SESSION["ResFileID"] . "<br/>";

			include 'db/db_connect.php';
			$sql = "Update tblstdresultm Set CDept = ? Where ResFileID = ? and Dept = ? " ;
			$stmt = $mysqli->prepare($sql);
			$stmt->bind_param('iis', $CDepts[$i], $_SESSION["ResFileID"], $Depts[$i]);
			if($stmt->execute()){} 
			else{echo $mysqli->error;}
		}
		echo "<script type='text/javascript'>window.onload = function()
			{	document.getElementById('lblSuccess').style.display = 'block';	}
			</script>";
	}
 else {
	$_SESSION["ResFileID"] = $_GET['ResFileID'];
	 
 }
?>

<form action="UniResDeptMapMain.php" method="post">
	<head>	</head>

	<br /><br />
	<div>
	<h3 class="page-title" style="margin-left:5%">Department Mapping</h3>
	<h3 class="page-title" style="float:right;margin-top:-40px;"><a href="UploadResultFileMain.php">Back</a></h3>
	</div>

	<br/>
	<div style="float:left;margin-left:65px;margin-top:-20px">
		<label id="lblSuccess" style="margin-left:10px;color:green;font-weight:bold;display:none" >Data saved successfully.</label>
	</div>
	<br/>
	<div class="row-fluid" style="margin-left:5%">
	    <div class="span8 v_detail" style="overflow:scroll">
			<table cellpadding="10" cellspacing="0" border="0" class="tab_split" width="100%">
				<tr>
					<th>Result Dept.</th>
					<th>Cummins Dept.</th>
				</tr>

				<?php
					$sql = " SELECT DISTINCT trim(Dept) as Dept, CDept  FROM tblstdresultm
							 WHERE ResFileID = " . $_SESSION["ResFileID"] . "" ;

					//echo $sql;
					
					// execute the sql query
					$result = $mysqli->query( $sql );
					$num_results = $result->num_rows;

					if( $num_results ){
						while( $row = $result->fetch_assoc() ){
							extract($row);
							echo "<TR class='odd gradeX'>";
							echo "<td><label name='lblDept' class='span4'>{$Dept}</label>
									  <input style='display:none' type='text' maxlength='2' name='txtDept[]' class='span4' value='{$Dept}' />";
							echo "</td>";
							$SelCDept = $CDept;
							
							echo"<td class='form_sec span2'>";
							echo"<select name='ddlCDept[]' style='width:90%;margin-top:10px'>";

							include 'db/db_connect.php';
							$sql = "SELECT 0 AS MDeptId, 'Select ' AS DeptName ,-1 AS orderno UNION SELECT DeptID AS MDeptId, DeptName ,orderno FROM tbldepartmentmaster where coalesce(Teaching,0) = 1 ORDER BY orderno;";
							$result1 = $mysqli->query( $sql );
							//echo $mysqli->error;
							while( $row1 = $result1->fetch_assoc() ) {
							extract($row1);
							 if(($SelCDept == $MDeptId)){
									echo "<option value={$MDeptId} selected>{$DeptName}</option>"; 
									$SelMDeptId = $MDeptId;
								}
								else{
									echo "<option value={$MDeptId}>{$DeptName}</option>"; 
								}
							}
							echo"</select>";
							echo "</td>";
						}
					}					
					//disconnect from database
					$result->free();
					$mysqli->close();
				?>
			</table>
            <br />
        </div>
	</div>
	<div class="clear"></div>
	<div class="form_sec span2">
		<input type="submit" name="btnSave" value="Save" title="Update" class="btn btn-mini btn-success" />
	</div>								
