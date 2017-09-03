<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Pending Details - All Students</title>
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
</head>
<body>
<?php
	if(!isset($_SESSION)){
		session_start();
	}
?>	
	<br /><br /><br />
	
	<h3>
	</h3>
	<h3 class="page-title" style="margin-left:5%">Professor Preferences Report</h3>
	<h3 class="page-title" style="float:right;margin-top:-46px;"></h3>

	<div class="row-fluid" style="margin-left:5%">
            <br />

			<div class="span11 v_detail">		
			<table cellpadding="10" cellspacing="0" border="0" width="100%" class="tab_split">
				<tr>
					<th style="width:15%">Name</th>
					<th style="width:5%">Dept</th>
					<th style="width:5%">Type</th>
					<th style="width:5%">Mobile</th>
					<th style="width:14%">Slot - 1 </th>
					<th style="width:14%">Slot - 2 </th>
					<th style="width:14%">Slot - 3 </th>
					<th style="width:14%">Slot - 4 </th>
					<th style="width:14%">Slot - 5 </th>
				</tr>
				<?php
//							INNER JOIN vwuser U on U.userID = PP.ProfID  where U.ExamID = " . $_SESSION["SESSSelectedExam"] ."
//							LEFT JOIN vwuser U ON U.userID = PP.ProfID  AND U.ExamID = PP.ExamID where PP.ExamID = " . $_SESSION["SESSSelectedExam"] . "							

				include 'db/db_connect.php';
					  $sql = "SELECT ProfID, CONCAT(DATE_FORMAT(STR_TO_DATE(ExamDate,'%m/%d/%Y'), '%d-%M-%Y'), ' ', ExamSlot) AS ExamDateSlot, U.ContactNumber ,CONCAT(CONCAT(FirstName,' ',LastName)) as ProfName,U.Department as Dept,userType,
							ExamDate,DM.orderno
							FROM tblexamblock PP
							INNER JOIN tblexamschedule es ON es.ExamSchID = PP.ExamSchID AND es.ExamID = " . $_SESSION["SESSSelectedExam"] ." 
							INNER JOIN tbluser U on U.userID = PP.ProfID and Designation in (2,3,4,5,6,14,15,16)
							INNER JOIN tbldepartmentmaster DM on U.Department = DM.DeptName
							UNION
							SELECT ProfID, CONCAT(DATE_FORMAT(STR_TO_DATE(ExamDate,'%m/%d/%Y'), '%d-%M-%Y'), ' ', ExamSlot) AS ExamDateSlot, U.ContactNumber ,CONCAT(CONCAT(FirstName,' ',LastName)) as ProfName,U.Department as Dept,userType,
								ExamDate,DM.orderno
							FROM tblprofessorpref PP 
							INNER JOIN tbluser U on U.userID = PP.ProfID and Designation in (2,3,4,5,6,14,15,16)
	
							INNER JOIN tbldepartmentmaster DM on U.Department = DM.DeptName
where PP.ExamID = " . $_SESSION["SESSSelectedExam"] . "
							ORDER BY orderno,ProfID, ExamDate, ExamDateSlot DESC ";
						//echo $sql;
						// execute the sql query
						$result = $mysqli->query( $sql );
						$num_results = $result->num_rows;
						if($num_results > 0){
						$tmpProfID = '';
						$slot1 = '';
						$slot2 = '';
						$slot3 = '';
						$slot4 = '';
						$slot5 = '';
						$Name = '';
						$Mob = '';
						$D = '';
						$UT = '';
						$i = 1;
						if( $num_results ){
							while( $row = $result->fetch_assoc() ){
								extract($row);
								if ($ProfID == $tmpProfID){ }
								else {
									if ($tmpProfID == ''){	}
									else {
										echo "<TR class='odd gradeX'>";
										echo "<td style='width:15%'>{$Name}</td>";
										echo "<td style='width:5%'>{$D}</td>";
										echo "<td style='width:5%'>{$UT}</td>";
										echo "<td style='width:5%'>{$Mob}</td>";
										echo "<td style='width:14%'>{$slot1}</td>";
										echo "<td style='width:14%'>{$slot2}</td>";
										echo "<td style='width:14%'>{$slot3}</td>";
										echo "<td style='width:14%'>{$slot4}</td>";
										echo "<td style='width:14%'>{$slot5}</td>";

										echo "</TR>";

										$slot1 = '';
										$slot2 = '';
										$slot3 = '';
										$slot4 = '';
										$slot5 = '';
										$i = 1;
										
									}
								}

								switch ($i){
									case 1: $slot1 = $ExamDateSlot; break;
									case 2: $slot2 = $ExamDateSlot; break;
									case 3: $slot3 = $ExamDateSlot; break;
									case 4: $slot4 = $ExamDateSlot; break;
									case 5: $slot5 = $ExamDateSlot; break;
								}
								
								$i += 1;
								
								$tmpProfID = $ProfID;
								$Name = $ProfName;
								$Mob = $ContactNumber;
								$D = $Dept;
								$UT = $userType;
							}
						}

						echo "<TR class='odd gradeX'>";
						echo "<td  style='width:15%'>{$Name}</td>";
						echo "<td  style='width:5%'>{$D}</td>";
						echo "<td  style='width:5%'>{$UT}</td>";
						echo "<td style='width:5%'>{$Mob}</td>";
						echo "<td style='width:14%'>{$slot1}</td>";
						echo "<td style='width:14%'>{$slot2}</td>";
						echo "<td style='width:14%'>{$slot3}</td>";
						echo "<td style='width:14%'>{$slot4}</td>";
						echo "<td style='width:14%'>{$slot5}</td>";
						echo "</TR>";
						}
						//vwuser
						$sql = "SELECT userID AS UProfID,CONCAT(CONCAT(FirstName,' ',LastName)) as UProfName, 
								ContactNumber as UMob,Department as UDept,userType as UuserType
								FROM tbluser
								where Designation in (2,3,4,5,6,14,15,16) and userID NOT IN (SELECT ProfID FROM tblprofessorpref WHERE ExamID = " . $_SESSION["SESSSelectedExam"] . ")
								Order by Department;";
						//echo $sql;
						// execute the sql query
						$result = $mysqli->query( $sql );
						//echo $mysqli->error;
						$num_results = $result->num_rows;
						if( $num_results ){
							while( $row = $result->fetch_assoc() ){
								extract($row);
								echo "<TR class='odd gradeX'>";
								echo "<td style='width:15%'>{$UProfName}</td>";
								echo "<td style='width:5%'>{$UDept}</td>";
								echo "<td style='width:5%'>{$UuserType}</td>";
								echo "<td style='width:5%'>{$UMob}</td>";
								echo "<td style='width:14%'></td>";
								echo "<td style='width:14%'></td>";
								echo "<td style='width:14%'></td>";
								echo "<td style='width:14%'></td>";
								echo "<td style='width:14%'></td>";
								echo "</TR>";
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
</body>
</html>

