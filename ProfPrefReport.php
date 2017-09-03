<form>
<?php
	if(!isset($_SESSION)){
		session_start();
	}
?>	
	<br /><br /><br />
	
	<h3>
	</h3>
	<h3 class="page-title" style="margin-left:5%">Professor Preferences Report&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<a target="_blank" href="ProfPrefReportPrint.php">Print</a></h3>
	<h3 class="page-title" style="float:right;margin-top:-46px;">
	<?php
			echo"<a href='ExamIndexMain.php'>Back</a>";
	?>
	</h3>

	<div class="row-fluid" style="margin-left:5%">
            <br />
			<table cellpadding="10" cellspacing="0" border="0" width="90%" class="tab_split" style="margin-left:3%">
				<tr>
					<th  colspan="4"><center>Planned Duties</center></th>
					<th></th>
					<th  colspan="4"><center>Taken Duties</center></th>
				</tr>
				<tr>
					<th>Total</th>
					<th>Saturday</th>
					<th>Evening</th>
					<th>Morning</th>
					<th></th>
					<th>Total</th>
					<th>Saturday</th>
					<th>Evening</th>
					<th>Morning</th>
				</tr>
				<?php
					include 'db/db_connect.php';
					$tmpExamDate = '' ;
					$tmpExamSlot = '' ;

					If (isset($_POST['btnSearch']) or (isset($_POST['btnSave']))  ) { 
							$tmpExamDate = $_POST['ddlDate'] ;
							$tmpExamSlot = $_POST['ddlExamDateSlot'] ;
						}
						Else { 
							if  (isset($_GET['ExamDate'])) {
								$tmpExamDate = $_GET['ExamDate'] ;
								$tmpExamSlot = $_GET['ExamSlot'] ;
							}
						}
						
						if ($tmpExamDate == '') {$tmpExamDate = '01/01/1900';}
						if ($tmpExamSlot == '') {$tmpExamSlot = 'Morning';}
						
if($_SESSION["SESSSelectedExamType"] ==  'Online')
{
$sql = "select A.PM as TotCount,0 as Satcount,0 as EvenCount,A.PM as MornCount from 
(
SELECT DISTINCT ExamDate as examdate, COUNT(EB.ExamBlockID) AS PM,0 as PE, 0 as AE, 0 as TECount 
FROM tblblocksmaster BM 
INNER JOIN tblexamblock EB ON BM.blockid = EB.blockid 
INNER JOIN tblexamschedule ES ON EB.ExamSchID = ES.ExamSchID 
INNER JOIN tblexammaster em ON BM.ExamID = em.ExamID WHERE em.ExamID = " . $_SESSION["SESSSelectedExam"] . "
) as A";
}
else
{						
						$sql = " SELECT DISTINCT TotCount, Satcount, EvenCount,MornCount FROM
								(SELECT SUM(COALESCE(supcount, 0)) + SUM(COALESCE(relcount, 0)) + SUM(COALESCE(cccount, 0)) AS TotCount , '1' AS id FROM tblexamblockcount where examid = " . $_SESSION["SESSSelectedExam"] .") AS A
								INNER JOIN
								(SELECT SUM(COALESCE(supcount, 0)) + SUM(COALESCE(relcount, 0)) + SUM(COALESCE(cccount, 0)) AS EvenCount, '1' AS id FROM tblexamblockcount	where examslot  = 'Evening' and examid = " . $_SESSION["SESSSelectedExam"] .") AS C ON A.id = C.id
								INNER JOIN
								(SELECT SUM(COALESCE(supcount, 0)) + SUM(COALESCE(relcount, 0)) + SUM(COALESCE(cccount, 0)) AS MornCount, '1' AS id FROM tblexamblockcount	where examslot  = 'Morning' and examid = " . $_SESSION["SESSSelectedExam"] .") AS E ON A.id = E.id
								INNER JOIN 
								(SELECT SUM(COALESCE(supcount, 0)) + SUM(COALESCE(relcount, 0)) + SUM(COALESCE(cccount, 0)) AS SatCount, '1' AS id FROM tblexamblockcount where DAYNAME(STR_TO_DATE(examdate,'%m/%d/%Y'))  = 'Saturday'
								and examid = " . $_SESSION["SESSSelectedExam"] .") AS B ON A.id = B.id
								LEFT OUTER JOIN
								(SELECT '1' AS id, supcount, relcount, cccount, blocks, ebcrowid
								 FROM tblexamblockcount WHERE examid = " . $_SESSION["SESSSelectedExam"] .") AS D ON A.id = D.id ";
						
}
						//echo $sql;

						// execute the sql query
						$result = $mysqli->query( $sql );
						echo $mysqli->error;
						$num_results = $result->num_rows;

						if( $num_results ){
							while( $row = $result->fetch_assoc() ){
								extract($row);
								echo "<TR class='odd gradeX'>";
								echo "<td>{$TotCount}</td>";
								echo "<td>{$Satcount}</td>";
								echo "<td>{$EvenCount}</td>";
								echo "<td>{$MornCount}</td>";
								echo "<td></td>";
							}
						}	

						$sql =  "SELECT A.RELRCCOUNT + B.PrefTotCount as ActTotCount, ActSatcount,ActEvenCount,ActMornCount
									FROM (SELECT COUNT(*) AS RELRCCOUNT FROM tblrelccduties WHERE ExamSchID IN (SELECT ExamSchID FROM tblexamschedule WHERE ExamID = " . $_SESSION["SESSSelectedExam"] .")) AS A,
									(SELECT COUNT(*) AS PrefTotCount , SUM(CASE WHEN ExamSlot = 'Evening' THEN 1 ELSE 0 END) AS ActEvenCount,
											SUM(CASE WHEN ExamSlot = 'Morning' THEN 1 ELSE 0 END) AS ActMornCount,
											SUM(CASE WHEN DAYNAME(STR_TO_DATE(ExamDate,'%m/%d/%Y')) = 'Saturday' THEN 1 ELSE 0 END) AS ActSatcount
									FROM tblprofessorpref WHERE ExamID = " . $_SESSION["SESSSelectedExam"] .") AS B";
						//echo $sql;
						// execute the sql query
						$result = $mysqli->query( $sql );
						echo $mysqli->error;
						$num_results = $result->num_rows;

						if( $num_results ){
							while( $row = $result->fetch_assoc() ){
								extract($row);
								echo "<td>{$ActTotCount}</td>";
								echo "<td>{$ActSatcount}</td>";
								echo "<td>{$ActEvenCount}</td>";
								echo "<td>{$ActMornCount}</td>";
								echo "</TR>";
							}
						}	


						
						//disconnect from database
						$result->free();
						$mysqli->close();
					
				?>
			</table>
			<div class="span11 v_detail" style="height:40px;overflow:hidden">		
			<table cellpadding="10" cellspacing="0" border="0" width="100%" class="tab_split">
				<tr>
					<th style="width:17%">Name</th>
					<th style="width:6%">Mobile</th>
					<th style="width:7%">Update</th>
					<th style="width:14%">Slot - 1 </th>
					<th style="width:14%">Slot - 2 </th>
					<th style="width:14%">Slot - 3 </th>
					<th style="width:14%">Slot - 4 </th>
					<th style="width:14%">Slot - 5 </th>
				</tr>
			</table>
			</div>
			<div class="span11 v_detail" style="overflow:scroll;height:300px">		
			<table cellpadding="10" cellspacing="0" border="0" width="100%" class="tab_split">
				<?php
//							INNER JOIN vwuser U on U.userID = PP.ProfID  where U.ExamID = " . $_SESSION["SESSSelectedExam"] ."
//							LEFT JOIN vwuser U ON U.userID = PP.ProfID  AND U.ExamID = PP.ExamID where PP.ExamID = " . $_SESSION["SESSSelectedExam"] . "							

				include 'db/db_connect.php';
if ($_SESSION["SESSSelectedExamType"] == 'Online') {
					  $sql = "SELECT ProfID, CONCAT(DATE_FORMAT(STR_TO_DATE(ExamDate,'%m/%d/%Y'), '%d-%M-%Y'), ' ', 
SUBSTRING(BlockName,LOCATE('@',BlockName)+1)) AS ExamDateSlot, U.ContactNumber ,CONCAT(U.Department,' - ',CONCAT(FirstName,' ',LastName)) as ProfName,
							ExamDate
							FROM tblexamblock PP
							INNER JOIN tblblocksmaster BM on BM.BlockID = PP.BlockID

							INNER JOIN tblexamschedule es ON es.ExamSchID = PP.ExamSchID AND es.ExamID = " . $_SESSION["SESSSelectedExam"] ." 
							INNER JOIN tbluser U on U.userID = PP.ProfID and Designation in (2,3,4,5,6,7,8,9,11,12,13,14,15,16)
							UNION
							SELECT ProfID, CONCAT(DATE_FORMAT(STR_TO_DATE(ExamDate,'%m/%d/%Y'), '%d-%M-%Y'), ' ', ExamSlot) AS ExamDateSlot, U.ContactNumber ,CONCAT(U.Department,' - ',CONCAT(FirstName,' ',LastName)) as ProfName,
								ExamDate
							FROM tblprofessorpref PP 
							INNER JOIN tbluser U on U.userID = PP.ProfID and Designation in (2,3,4,5,6,7,8,9,11,12,13,14,15,16)
							where PP.ExamID = " . $_SESSION["SESSSelectedExam"] . "
							ORDER BY ProfID, ExamDate, ExamDateSlot";
}
else
{
					  $sql = "SELECT ProfID, CONCAT(DATE_FORMAT(STR_TO_DATE(ExamDate,'%m/%d/%Y'), '%d-%M-%Y'), ' ', ExamSlot) AS ExamDateSlot, U.ContactNumber ,CONCAT(U.Department,' - ',CONCAT(FirstName,' ',LastName)) as ProfName,
							ExamDate
							FROM tblexamblock PP
							INNER JOIN tblexamschedule es ON es.ExamSchID = PP.ExamSchID AND es.ExamID = " . $_SESSION["SESSSelectedExam"] ." 
							INNER JOIN tbluser U on U.userID = PP.ProfID and Designation in (2,3,4,5,6,7,8,9,11,12,13,14,15,16)
							UNION
							SELECT ProfID, CONCAT(DATE_FORMAT(STR_TO_DATE(ExamDate,'%m/%d/%Y'), '%d-%M-%Y'), ' ', ExamSlot) AS ExamDateSlot, U.ContactNumber ,CONCAT(U.Department,' - ',CONCAT(FirstName,' ',LastName)) as ProfName,
								ExamDate
							FROM tblprofessorpref PP 
							INNER JOIN tbluser U on U.userID = PP.ProfID and Designation in (2,3,4,5,6,7,8,9,11,12,13,14,15,16)
							where PP.ExamID = " . $_SESSION["SESSSelectedExam"] . "
							ORDER BY ProfID, ExamDate, ExamDateSlot";

}
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
						$i = 1;
						if( $num_results ){
							while( $row = $result->fetch_assoc() ){
								extract($row);
								if ($ProfID == $tmpProfID){ }
								else {
									if ($tmpProfID == ''){	}
									else {
										echo "<TR class='odd gradeX'>";
										echo "<td style='width:17%'>{$Name}</td>";
										echo "<td style='width:6%'>{$Mob}</td>";
										echo "<td  style='width:7%'>
												<a class='btn btn-mini btn-success' 
												href='unassignedProfblock2Main.php?source=report&ProfName={$Name}&ProfID={$tmpProfID}'>
												<i class='icon-ok icon-white'></i>&nbsp;&nbsp;Update</a></td>";
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
							}
						}

						echo "<TR class='odd gradeX'>";
						echo "<td  style='width:17%'>{$Name}</td>";
						echo "<td style='width:6%'>{$Mob}</td>";
						echo "<td style='width:7%'>
								<a class='btn btn-mini btn-success'
								href='unassignedProfblock2Main.php?source=report&ProfName={$Name}&ProfID={$tmpProfID}'>
								<i class='icon-ok icon-white'></i>&nbsp;&nbsp;Update</a></td>";
						echo "<td style='width:14%'>{$slot1}</td>";
						echo "<td style='width:14%'>{$slot2}</td>";
						echo "<td style='width:14%'>{$slot3}</td>";
						echo "<td style='width:14%'>{$slot4}</td>";
						echo "<td style='width:14%'>{$slot5}</td>";
						echo "</TR>";
						}
						//vwuser
						$sql = "SELECT userID AS UProfID,CONCAT(Department,' - ',CONCAT(FirstName,' ',LastName)) as UProfName, 
								ContactNumber as UMob
								FROM tbluser
								where Designation in (2,3,4,5,6,7,8,9,11,12,13,14,15,16) and userID NOT IN (SELECT ProfID FROM tblprofessorpref WHERE ExamID = " . $_SESSION["SESSSelectedExam"] . ")
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
								echo "<td style='width:17%'>{$UProfName}</td>";
								echo "<td style='width:6%'>{$UMob}</td>";
								echo "<td  style='width:7%'>
										<a class='btn btn-mini btn-success'
										href='unassignedProfblock2Main.php?source=report&ProfName={$UProfName}&ProfID={$UProfID}'>
										<i class='icon-ok icon-white'></i>&nbsp;&nbsp;Update</a></td>";
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
	</form>

