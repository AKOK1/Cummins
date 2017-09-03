<form action="CAPaccess_PRORMain.php" method="post">
		<?php
		if(!isset($_SESSION)){
			session_start();
		}
		// $_SESSION["SESSCAPSelectedExam"] = $_POST['ddlExam'];
		?>
<script>
	$(function() {
		$( "#datepicker1" ).appendDtpicker();
		$( "#datepicker2" ).appendDtpicker();
		});
</script>
<?php
//include database connection
include 'db/db_connect.php';
 
// if the form was suSr1Startbmitted/posted, update the record
 if($_POST)
	{
		if($_POST['datepicker1'] != ''){
			//$dt1 = date('m/d/Y', strtotime($_POST['dtPubStart']));
			$dt1 = $_POST['datepicker1'];
		}
		if($_POST['datepicker2'] != ''){
			//$dt2 = date('m/d/Y', strtotime($_POST['dtPubEnd']));
			$dt2 = $_POST['datepicker2'];
		}
		if(isset($_POST['btnsave'])){
			include 'db/db_connect.php';
			$dt1 = $_POST['datepicker1'];
			$dt2 = $_POST['datepicker2'];
			$query1="update tblexammaster set CAPstartPROR='$dt1',CAPendPROR='$dt2' Where ExamID = ". $_SESSION['SESSCAPSelectedExam'] .  "";
			mysqli_query($mysqli, $query1);	
		}
}


	$sql = " SELECT CAPstartPROR,CAPendPROR FROM tblexammaster Where ExamID = ". $_SESSION['SESSCAPSelectedExam'] .  "";
	$result = $mysqli->query( $sql );
	$num_results = $result->num_rows;
	if( $num_results ){
		while( $row = $result->fetch_assoc() ){
			extract($row);
		}
	}
 
?>

	
							<div class="tab-pane" id="tabsleft-tab6">
							</br></br></br></br>
								<label class="control-label"><h3><b>CAP Access - PR / OR</b></h3></label>
									<h3 class="page-title" style="float:right;margin-top:-40px;"><a href="examinerAssignmentMain.php">Back</a></h3>
										<div class="control-group">
											<div class="controls">
												<table>
													<tr>
														<input type="hidden" name="txtExamID" value="<?php echo "{$ExamID}" ?>" />													
													</tr>
													<tr>
														<td>Start Time :  </td>
														<td colspan="2">
															<input type="text" maxlength="17" id='datepicker1' name="datepicker1" class="textfield" style="width:120px;height:20px;" value="<?php echo "{$CAPstartPROR}" ?>"/>
														</td>
													</tr>
													<tr>
														<td>End Time :  </td>
														<td colspan="2">
															<input type="text" maxlength="17" id='datepicker2' name="datepicker2" style="width:120px;" class="textfield" required style="width:40px;" value="<?php echo "{$CAPendPROR}" ?>"/>
														</td>
													</tr>
													<tr>
<td> 
												</br> </br> 
													<?php 
														if(($_SESSION["ReadAccess"] == "Yes") && ($_SESSION["WriteAccess"] == "Yes")){
															
															echo "<input style='margin-top:-10px' type='submit' id='btnsave' name='btnsave' value='Save' title='Update' class='btn btn-mini btn-success' />";
														}
														// if(($_SESSION["ReadAccess"] == "Yes") && ($_SESSION["WriteAccess"] == "Yes")){
															// echo "<input type='submit' onclick='javascript:fnEditdataexpanyout();' id='btnedit' name='btnedit' value='Edit' title='Update' class='btn btn-mini btn-success' />";
														// }
														?>
														</td>
													</tr>	
												</table>
											</div>	
										</div>	
								 
							</div>    
</form>