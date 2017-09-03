

<form action="studentviewMain.php?" method="post">
<?php
 $sql = "SELECT stdview from tblinsemmarks IM
					  INNER JOIN tblcapblockprof CBP ON IM.CapId = CBP.cbpid 
								   WHERE examID =" . $_SESSION["SESSCAPSelectedExam"]."
								   limit 1 ";
								  $result = $mysqli->query( $sql );
	$num_results = $result->num_rows;
	if( $num_results ){
		while( $row = $result->fetch_assoc() ){
			extract($row);
		}
	}
		if(isset($_POST['btnenable'])){
			$sql = "UPDATE `tblinsemmarks` IM 
					INNER JOIN tblcapblockprof CBP ON IM.CapId = CBP.cbpid 
					SET IM.`stdview` = '1' 
					 WHERE examID =" . $_SESSION["SESSCAPSelectedExam"]."";
			       	 // echo $sql;
			$stmt = $mysqli->prepare($sql);
			if($stmt->execute()){
				//echo "done";
					echo '<script>alert("UPDATED SUCCESSFULLY");</script>';
			} 
			else { echo $mysqli->error;
				///die("Unable to update.");
			}
		}
		if(isset($_POST['btndisable'])){
				$sql = "UPDATE `tblinsemmarks` IM 
						INNER JOIN tblcapblockprof CBP ON IM.CapId = CBP.cbpid 
						SET IM.`stdview` = '0' 
						 WHERE examID =" . $_SESSION["SESSCAPSelectedExam"]."";
						//echo $sql;
						$stmt = $mysqli->prepare($sql);
						if($stmt->execute()){
							//echo "done";
								echo '<script>alert("UPDATED SUCCESSFULLY");</script>';
						}
						else { echo $mysqli->error;
							///die("Unable to update.");
						}
					
		}
					include 'db/db_connect.php';
					If(isset($_POST['btnenable'])) {
						//echo"alert('hi')";
					  $sql = "SELECT stdview from tblinsemmarks IM
					  INNER JOIN tblcapblockprof CBP ON IM.CapId = CBP.cbpid 
							where examID =" . $_SESSION["SESSCAPSelectedExam"]."
								  limit 1 ";
								//echo $sql;
							$result = $mysqli->query( $sql );
							$num_results = $result->num_rows;
								if( $num_results ){
									while( $row = $result->fetch_assoc() ){
										extract($row);
									}
								}
					}
					If(isset($_POST['btndisable'])) {
						//echo"alert('hi')";
					  $sql = "SELECT stdview from tblinsemmarks IM
					  INNER JOIN tblcapblockprof CBP ON IM.CapId = CBP.cbpid 
							where examID =" . $_SESSION["SESSCAPSelectedExam"]."
								  limit 1 ";
								//echo $sql;
							$result = $mysqli->query( $sql );
							$num_results = $result->num_rows;
							if( $num_results ){
								while( $row = $result->fetch_assoc() ){
									extract($row);
								}
							}
					}
						
?>
	<br /><br />
	<h3 class="page-title" style="margin-left:5%">Student Access</h3>
		<h3 class="page-title" style="float:right;margin-top:-40px;"><a href="examinerAssignmentMain.php">Back</a></h3>

	<div class="row-fluid">
		<div class="v_detail" style="margin-left:5%">
			<table cellpadding="10" cellspacing="0" border="0" width="50%" class="tab_split">
				<tr>
					<input type="hidden" name="txtExamID" value="<?php echo "{$stdview}" ?>" />													
					<td class="form_sec span4">&nbsp;</td>
												
				</tr>				
				<tr>
					<td class="form_sec span4">Exam</td>
					<td><label id="studexam" style="width:280px;"><?php if(!isset($_SESSION)){ session_start(); } echo $_SESSION["SESSCAPSelectedExamName"]; ?></label></td>
				</tr>
				<tr>
					<td class="form_sec span4">Student View</td>
					<td><label id="stdview" name="stdview"><?php echo $stdview; ?></label></td>
				</tr>
			</table>
			</br></br>
			<?php
					if(($_SESSION["ReadAccess"] == "Yes") && ($_SESSION["WriteAccess"] == "Yes")){
							 echo "<input class='btn btn btn-success' type='submit' name='btnenable' id='btnenable' value='Enable' />&nbsp;&nbsp;&nbsp;&nbsp;";
					}
					if(($_SESSION["ReadAccess"] == "Yes") && ($_SESSION["WriteAccess"] == "Yes")){
							echo "<input class='btn btn btn-success' type='submit' name='btndisable' id='btndisable' value='Disable' />&nbsp;&nbsp;&nbsp;&nbsp;";
					}
			?>
		</div>
	</div>
</form>

