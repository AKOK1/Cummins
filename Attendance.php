<?php
//include database connection
include 'db/db_connect.php';

?>

<form action="" method="post">
	<script>
	function setstarttime(){
		var st = document.getElementById('EndTime').value;
		document.getElementById('StartTime').value = String(parseInt(st.substring(0, st.indexOf(":"))) - 1) + st.substring(st.indexOf(":"));
	}	
	function setendtime(){
		var st = document.getElementById('StartTime').value;
		document.getElementById('EndTime').value = String(parseInt(st.substring(0, st.indexOf(":"))) + 1) + st.substring(st.indexOf(":"));
	}
  function sendtoatt() {
			if(document.getElementById('ddlSubject').value == ''){
				alert('Please select a Subject.');
				return false;
			}
			var skillsSelect = document.getElementById("ddlSubject");
			var starttime = document.getElementById("StartTime");
			var endtime = document.getElementById("EndTime");
			var selectedText = skillsSelect.options[skillsSelect.selectedIndex].text;	  
			window.location.href = 'StdAttListMain.php?ysid=' + document.getElementById('ddlSubject').value + 
							'&attdate=' + document.getElementById('datepicker1').value + 
							'&starttime=' + document.getElementById('StartTime').value +
							'&endtime=' + document.getElementById('EndTime').value +
							'&subname=' + selectedText;
	 }
		//$(function(){
			//$('*[name=date]').appendDtpicker();
		//});
		$(function() {
		$( "#datepicker1" ).datepicker({ dateFormat: 'dd-M-yy' });
		//$( "#datepicker2" ).datepicker({ dateFormat: 'dd-M-yy' });
		//$( "#datepicker1" ).appendDtpicker();
		
		});
	</script>
	<br /><br />
	<h3 class="page-title" style="margin-left:5%">Attendance for - <b><?php echo (date('d/m/Y')); ?></b></h3>
	<h3 class="page-title" style="float:right;margin-top:-40px;"><a href="MainMenuMain.php">Back</a></h3>
	<div class="row-fluid">
							<div class="span10" style="margin-left:5%">
							</div>
						<br/><br/>
		<div class="v_detail" style="margin-left:5%">
			<table cellpadding="10" cellspacing="0" border="0" width="50%" class="tab_split">
<?php			echo "<tr>";
				echo "<td class='form_sec span4'>Last Attendance Filled</td>";
					include 'db/db_connect.php';
					$sql11 = "Select DATE_FORMAT(max(attdate), '%d-%b-%Y') as AttDate FROM tblattmaster  
					WHERE YSID IN ( 
					SELECT ysid FROM tblyearstructprof ysp
					INNER JOIN tblyearstruct ys ON ys.rowid = ysp.ysid
					INNER JOIN tblcuryear cy ON cy.eduyearfrom = ys.eduyearfrom AND cy.eduyearto = ys.eduyearto WHERE papertype = 'TH' 
					AND coalesce(ysp.profid,0) = " . $_SESSION["SESSUserID"] . "
					)";
					//echo $sql11;
					$result11 = $mysqli->query( $sql11 );
					$num_results11 = $result11->num_rows;
					if( $num_results11 ){
						while( $row11 = $result11->fetch_assoc() ){
							extract($row11);
							echo "<td >{$AttDate}</td>";
						}
					}
				echo "</tr>";
?>
				<tr>
					<td class="form_sec span4">Attendance Date</td>
					<td>
						<input type="text" maxlength="17" id='datepicker1' name="dtPubStart" class="textfield" style="width:120px;" value="<?php  echo (date('d-M-Y')) ?>"/>
					</td>
				</tr>
				<tr>
					<td class="form_sec span4">Start Time</td>
					
					<td>
						<select id="StartTime" onchange="setendtime()" name="StartTime">
							<?php
							$start_hour = 7;
							$end_hour = 20;
							$minutes_array = array("15", "30", "45");
							for($i=$start_hour; $i<($end_hour); $i++){
								$string = $i . ':00';
								echo '<option value="' . $string . '">' . $string . '</option>';
								if($i != $end_hour){
									for($j=0; $j<sizeof($minutes_array); $j++){
										 $string = $i . ':' . $minutes_array[$j];
										 echo '<option value="' . $string . '">' . $string . '</option>';
									}
								}
							}
							?>
						</select>
					</td>
				</tr>				
				<tr>
					<td class="form_sec span4">End Time</td>
					<td>
						<select id="EndTime" name="EndTime">
							<?php
							$start_hour = 8;
							$end_hour = 20;
							$minutes_array = array("15", "30", "45");
							for($i=$start_hour; $i<($end_hour + 1); $i++){
								$string = $i . ':00';
								echo '<option value="' . $string . '">' . $string . '</option>';
								if($i != $end_hour){
									for($j=0; $j<sizeof($minutes_array); $j++){
										 $string = $i . ':' . $minutes_array[$j];
										 echo '<option value="' . $string . '">' . $string . '</option>';
									}
								}
							}
							?>
						</select>
					</td>
				</tr>
				
				<tr>
					<td class="form_sec span4">Subject</td>
					<td>
					<select id="ddlSubject" name="ddlSubject" style="width:450px;" required>
						<option value="">Select Subject</option>
						<?php
						include 'db/db_connect.php';
						$sql = "SELECT rowid, CASE WHEN ys.papertype = 'TH' 
								THEN CONCAT(EnggYear ,' - ' ,'Div ',`div`,' - ',SubjectName)
								ELSE CONCAT(EnggYear ,' - ' ,'Div ',`div`,' - ',SubjectName, ' Batch ',BatchName)
								END AS Subjects ,Coalesce(ys.BatchId,0) as BatchId
								FROM tblyearstruct ys
								INNER JOIN tblcuryear cy ON cy.eduyearfrom = ys.eduyearfrom AND cy.eduyearto = ys.eduyearto
								INNER JOIN tblpapermaster pm ON pm.paperid = ys.paperid
								INNER JOIN tblsubjectmaster sm ON sm.subjectid = pm.subjectid
								LEFT JOIN tblbatchmaster bm ON bm.BtchId = ys.BatchId
								WHERE coalesce(profid,0) = " . $_SESSION["SESSUserID"] . 
								" AND ys.papertype IS NOT NULL
								ORDER BY Subjects;";
						// CASE WHEN ys.papertype = 'TH' THEN CONCAT(EnggYear ,' - ' ,'Div ',`div`,' - ',SubjectName) ELSE CONCAT(EnggYear ,' - ' ,'Div ',`div`,' - ',SubjectName, ' Batch ',BatchName) END 
						$sql = "SELECT ys.YSID as rowid, 
						CONCAT(EnggYear ,' - ' ,'Div ',divn,' - ',SubjectName, ' Batch ',BatchName, ' ', Coalesce(ysp.btchId,0)) AS Subjects ,ys.papertype
								FROM vwhodsubjectsselected ys 
								INNER JOIN tblyearstructprof ysp ON ysp.YSID = ys.YSID
								LEFT JOIN tblbatchmaster bm ON bm.BtchId = ysp.btchId 
								INNER JOIN tblcuryear cy ON cy.eduyearfrom = ys.eduyearfrom 
								WHERE COALESCE(profid,0) = " . $_SESSION["SESSUserID"] . 
								" AND ys.papertype IS NOT NULL 
								ORDER BY Subjects;";
//AND cy.eduyearto = ys.eduyearto
//echo $sql;
						$result1 = $mysqli->query( $sql );
						while( $row = $result1->fetch_assoc() ) {
								extract($row);
								echo "<option value={$rowid}>{$Subjects}</option>"; 
						}
						?>
					</select>
					<?php  echo "<input type='hidden' value={$papertype} id='hdnpt' name='hdnpt' />"; ?>
					</td>
				</tr>	
				<tr>
					<td class="form_sec span4"></td>
					<td>
						<a name="btnUpdate" value="Go" title="Update" onclick="return sendtoatt();" href="#" class="btn btn-mini btn-success">Go</a>		
						</td>
				</tr>		
			</table>
		</div>
	</div>
</form>

