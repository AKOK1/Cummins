<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Enter Reval Marks</title>
<style type="text/css">
body {
	margin-left: 0px;
	margin-top: 0px;
	font-family:Verdana, Geneva, sans-serif;
	font-size: 12px;
}
.th-heading {
	font-size:13px;
	font-weight:bold;	
	}
.fix-table, th, td {
	line-height:20px;
	height: 14px;
	border: solid 1px #666 ;
	text-align:left;
	text-indent:10px;
	}
.th {
	font-size:13px;
	font-weight: bold;
	background-color:#CCC;
	}
</style>
	<script>
				function removeattrall(){
					var inputs = document.getElementsByTagName('input');
					for(var i = 0; i < inputs.length; i++) {
						inputs[i].removeAttribute("required");
					}
				}
				function setreq() {
					removeattrall();
					document.getElementById("txtesn").setAttribute("required", "required");
				}
	</script>
</head>
<form action="RevalMarksMain.php" method="post">
<body>
<br/><br/>

		<div style="float:left">
			<h3 class="page-title">Enter Reval Marks - <?php echo $_SESSION["SESSCAPSelectedExamName"]; ?></h3>
		</div>
		<div style="float:right"><h3 class='page-title' style='margin-right:30px;'><a href='examinerAssignmentMain.php'>Back</a></h3></div>
		<br/><br/><br/><br/>
		<center style="margin-left:-100px">
		Search Student by ESN: <input value="<?php echo $_POST['txtesn']; ?>" type=text" maxlength="8" id='txtesn' name="txtesn" class="textfield" style="width:100px;" required/>
		&nbsp;&nbsp;&nbsp;<input onclick='setreq();' type="submit" name="btnsubmit" id="btnsubmit" value="Search Student"  class="btn btn-mini btn-success"/>
		<input type="submit" style="margin-left:200px" name="btnsave" id="btnsave" onclick="removeattrall();"
		value="Save Reval Marks"  class="btn btn-mini btn-success"/>
		</center>
		<br/><br/>
		<table width="90%" border="0" cellpadding="5" cellspacing="0" class="fix-table" style="margin-left: 5%;">
		<tr class="th">
			<td width="10%">Course Code</td>
			<td width="40%">Course Name</td>
			<td width="10%">Head Type</td>
			<td width="10%">Out Of</td>
			<td width="10%">Current Marks</td>
			<td width="10%">Reval Marks</td>
		</tr>
		<?php
			if(!isset($_SESSION)) {
				session_start();				
			}
			if(isset($_POST['btnsave'])){
				$go = 0;
				foreach (array('txtstdid', 'txtcapid','txtrevalmarks') as $pos) {
					if($_POST[$pos] == ''){
						echo '<script>alert("Please select a student.");</script>';	
						break;
					}
					else{
						foreach ($_POST[$pos] as $id => $row) {
								$_POST[$pos][$id] = mysqli_real_escape_string($mysqli, $row);
							} 
							$go = 1;
					}
				}
				if($go == 1){
					$stdids = $_POST['txtstdid'];
					$capids = $_POST['txtcapid'];
					$Marks = $_POST['txtrevalmarks'];
					include 'db/db_connect.php';
					$size = count($stdids);
					for($i = 0 ; $i < $size ; $i++){
						$sql = "update tblinsemmarks set revaltotal = ?
								where StdId = ? and CapId = ?";
							$stmt = $mysqli->prepare($sql);
							$stmt->bind_param('sss', $Marks[$i], $stdids[$i], $capids[$i]);
							if($stmt->execute()){
								//header('Location: SubjectList.php?'); 
							} else{
								echo $mysqli->error;
								//die("Unable to update.");
							}
					}
					echo '<script>alert("UPDATED SUCCESSFULLY");</script>';
				}
			}
			if(isset($_POST)){
			//search student
				include 'db/db_connect.php';
				$sql = "SELECT IM.stdid,capid,PaperCode,SubjectName, CASE COALESCE(IM.stdstatus,'') WHEN 'A' THEN 'AA' 
					ELSE CONVERT((Q1 + Q2 + Q3 + Q4 + Q5 + Q6 + Q7 + Q8 + Q9 + Q10 + Q11 + Q12 + Q13 + Q14 + Q15 + Q16 + Q17 + Q18 + Q19 + Q20) , CHAR(10)) END 
					AS TotMarks3,Paper as marksall3,revaltotal
					FROM tblinsemmarks IM 
					INNER JOIN tblcapblockprof CBP ON IM.CapId = CBP.cbpid 
					INNER JOIN tblexamblock EB ON EB.ExamBlockID = CBP.ExamBlockID 
					INNER JOIN tblpapermaster PM ON PM.PaperID = EB.PaperID 
					INNER JOIN tblsubjectmaster SM ON SM.SubjectID = PM.SubjectID 
					INNER JOIN tblstdadm sa ON sa.ESNum = IM.stdid 
					INNER JOIN tblexammaster em ON em.ExamID = CBP.ExamId 
					and em.AcadYearFrom = sa.EduYearFrom  AND em.ExamId = " . $_SESSION["SESSCAPSelectedExam"] . "
					WHERE sa.ESNum = '" . $_POST["txtesn"] . "' AND CBP.ExamId = " . $_SESSION["SESSCAPSelectedExam"] . "
					ORDER BY SubjectName";
					//INNER JOIN tblcuryearauto cy ON cy.EduYearFrom = sa.EduYearFrom 
					// execute the sql query
					//echo $sql;
					//die;
					$result = $mysqli->query( $sql );
					echo $mysqli->error;
					$num_results = $result->num_rows;
					//echo $sql;
					if( $num_results ){
						while( $row = $result->fetch_assoc() ){
							extract($row);						
							echo "<TR>";
							echo "<td><input name='txtstdid[]' type='text' style='display:none;' value='{$stdid}'>
										<input name='txtcapid[]' type='text' style='display:none;' value='{$capid}'>
										{$PaperCode}</td>";
							echo "<td>{$SubjectName}</td>";
							echo "<td>PP</td>";
							echo "<td>{$marksall3} </td>";
							if($PaperCode == 'ES 1102'){
								echo "<td>-</td>";
							}
							else{
								echo "<td>{$TotMarks3}</td>";
							}				
							echo "<td><input type='text' maxlength='8' name='txtrevalmarks[]' class='textfield' 
										style='width:100px;' value='{$revaltotal}' /></td>";
							echo "</TR>";
						}
					}
					else{
						echo "<br/><br/><center><b>Student not found.</b></center><br/><br/>";
					}
					//disconnect from database	
					$result->free();
					$mysqli->close();
			}			
		?>
		</table>

</body>
</form>
</html>
