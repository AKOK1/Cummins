<?php
//include database connection
include 'db/db_connect.php';

?>

<form action="" method="post">
	<script>
		function sendtoatt() {
			if((document.getElementById('ddlSubject').value == '') || (document.getElementById('datepicker1').value == '') || (document.getElementById('datepicker2').value == '')){
				alert('Please select a Subject and Date Range.');
				return false;
			}
			var skillsSelect = document.getElementById("ddlSubject");
			var SubName = skillsSelect.options[skillsSelect.selectedIndex].text;	  

			window.open('PrintAttendance.php?ysid=' + document.getElementById('ddlSubject').value + 
							'&startdate=' + document.getElementById('datepicker1').value + 
							'&enddate=' + document.getElementById('datepicker2').value + 
							'&SelMoth=' + '1' +
							'&SelYear=' + '1' +
							'&MonthName=' + '1' +
							'&SubName=' + SubName);
			return false;
		}

		function sendtoattlp() {
			if(document.getElementById('ddlSubject').value == ''){
				alert('Please select a Subject.');
				return false;
			}
			var skillsSelect = document.getElementById("ddlSubject");
			var SubName = skillsSelect.options[skillsSelect.selectedIndex].text;	  

			window.open('PrintLecturePlan.php?ysid=' + document.getElementById('ddlSubject').value + 
							'&SelMoth=' + '1' +
							'&SelYear=' + '1' +
							'&MonthName=' + '1' +
							'&SubName=' + SubName);
			return false;
		}

		$(function() {
		$( "#datepicker1" ).datepicker({ dateFormat: 'dd-M-yy' });
		$( "#datepicker2" ).datepicker({ dateFormat: 'dd-M-yy' });
		//$( "#datepicker1" ).appendDtpicker();
		
		});
	</script>

	<br /><br />
	<h3 class="page-title" style="margin-left:5%">Attendance Report</h3>
	<h3 class="page-title" style="float:right;margin-top:-40px;"><a href="MainMenuMain.php">Back</a></h3>
	<div class="row-fluid">
		<div class="span10" style="margin-left:5%"></div>
		<br/><br/>
		<div class="v_detail" style="margin-left:5%">
			<table cellpadding="10" cellspacing="0" border="0" width="50%" class="tab_split">
<?php
			echo "<tr>";
				echo "<td class='form_sec span4'>Last Attendance Filled</td>";
					include 'db/db_connect.php';
					$sql = "Select DATE_FORMAT(max(attdate), '%d-%b-%Y') as AttDate FROM tblattmaster  
					WHERE YSID IN ( 
					SELECT ysid FROM tblyearstructprof ysp
					INNER JOIN tblyearstruct ys ON ys.rowid = ysp.ysid
					INNER JOIN tblcuryear cy ON cy.eduyearfrom = ys.eduyearfrom AND cy.eduyearto = ys.eduyearto WHERE papertype = 'TH' 
					AND coalesce(ysp.profid,0) = " . $_SESSION["SESSUserID"] . "
					)";
					//echo $sql;
					$result = $mysqli->query( $sql );
					$num_results = $result->num_rows;
					if( $num_results ){
						while( $row = $result->fetch_assoc() ){
							extract($row);
							echo "<td >{$AttDate}</td>";
						}
					}
				echo "</tr>";
?>
			<tr>
					<td class="form_sec span4">Start Date</td>
					<td>
							<input type="text" maxlength="17" id='datepicker1' name="dtPubStart" class="textfield" style="width:120px;" value="<?php  echo (date('d-M-Y')) ?>" required/>
					</td>
				</tr>
				<tr>
					<td class="form_sec span4">End Date</td>
					<td>
							<input type="text" maxlength="17" id='datepicker2' name="dtPubEnd" class="textfield" style="width:120px;" value="<?php  echo (date('d-M-Y')) ?>" required/>
					</td>
				</tr>
				<tr>
					<td class="form_sec span4">Subject</td>
					<td>
					<select id="ddlSubject" name="ddlSubject" style="width:450px;" required>
						<?php
						include 'db/db_connect.php';
						echo "<option value=''>Select Subject</option>"; 						
						$sql = "SELECT rowid, CASE WHEN ys.papertype = 'TH' 
								THEN CONCAT(EnggYear ,' - ' ,'Div ',`div`,' - ',SubjectName)
								ELSE CONCAT(EnggYear ,' - ' ,'Div ',`div`,' - ',SubjectName, ' Batch ',BatchName)
								END AS Subjects 
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
						CONCAT(EnggYear ,' - ' ,'Div ',divn,' - ',SubjectName, ' Batch ',BatchName, ' ',Coalesce(ysp.btchId,0)) AS Subjects ,ys.papertype
								FROM vwhodsubjectsselected ys 
								INNER JOIN tblyearstructprof ysp ON ysp.YSID = ys.YSID
								INNER JOIN tblcuryear cy ON cy.eduyearfrom = ys.eduyearfrom 
								LEFT JOIN tblbatchmaster bm ON bm.BtchId = ysp.btchId 
								WHERE COALESCE(profid,0) = " . $_SESSION["SESSUserID"] . 
								" AND ys.papertype IS NOT NULL 
								ORDER BY Subjects;";
						//echo $sql;
						$result1 = $mysqli->query( $sql );
						while( $row = $result1->fetch_assoc() ) {
								extract($row);
								echo "<option value={$rowid}>{$Subjects}</option>"; 
						}
						?>
					</select>
					<?php echo "<input type='hidden' value={$papertype} id='hdnpt' name='hdnpt' />"; ?>
					</td>
				</tr>	
				<tr>
					<td class="form_sec span4"></td>
					<td>
						<input type="button" name='btnUpdate' value='View Daily Attendance' title='Update' onclick='return sendtoatt();' class='btn btn-mini btn-success' />
						<input type="button" name='btnUpdate' value='View Lecture Plan' title='Update' onclick='return sendtoattlp();' class='btn btn-mini btn-success' />
					</td>
				</tr>		
			</table>
		</div>
	</div>
</form>
<!--
				<tr>
					<td class="form_sec span4">Month</td>
					<td>
						<select id="SelMonth">
							<option value="1">January</option>
							<option value="2">Febuary</option>
							<option value="3">March</option>
							<option value="4">April</option>
							<option value="5">May</option>
							<option value="6">June</option>
							<option value="7">July</option>
							<option value="8">August</option>
							<option value="9">September</option>
							<option value="10">October</option>
							<option value="11">November</option>
							<option value="12">December</option>
						</select>
					</td>
				</tr>				
				<tr>
					<td class="form_sec span4">Year</td>
					<td>
						<select id="SelYear">
							<option value="2016">2016</option>
							<option value="2017">2017</option>
							<option value="2018">2018</option>
							<option value="2019">2019</option>
							<option value="2020">2020</option>
						</select>
					</td>
				</tr>				
-->