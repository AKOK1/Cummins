<form action="assigneddivListMain.php" method="post">
	<br /><br />
	<script>
</script>
	<?php
		include 'db/db_connect.php';
		$sql = "SELECT CONCAT(FirstName,' ', LastName) AS profname
				from tbluser where userID = " . $_SESSION["SESSUserID"] ."";
			$result = $mysqli->query( $sql );
			$num_results = $result->num_rows;
			//echo $sql;
			if( $num_results ){
				while( $row = $result->fetch_assoc() ){
					extract($row);
				}
			}					
			//disconnect from database
			$result->free();
			$mysqli->close();
			echo "</td>";
			echo "</tr>";
			echo "<tr>";
			//echo "<td colspan='9'><h2><center><b>{$ExamDateT}, ".$_GET['ExamSlot']."</b></center></h2>";
			//if ($_SESSION["SESSSelectedExamType"] == 'Online') {
			//	echo "<h2><center><b style='color:red'>Report in Mech Auditorium, 30 Minutes before your timing, for university attendance.</b></center></h2>";
			//}
			echo "</td>";
			echo "</tr>";
	?>
		<h3 class="page-title" style="margin-left:0%">Enter Marks for - <?php echo $_SESSION["SESSCAPSelectedExamName"]; ?> <br/><?php echo $profname; ?></h3>
		<br/>
	<h3 class="page-title" style="float:right;margin-top:-90px;"><a href="InsementryMain.php">Back</a></h3>
	<div class="row-fluid">
		<div class="v_detail">
			<table cellpadding="10" cellspacing="0" border="0" width="90%" class="tab_split">
				<tr>
					<th width="60%">Division Subject</th>
					<th><strong>Action</strong></th>
					<th><strong>Report</strong></th>
				</tr>
				<?php
				//get assigned blocks 
				include 'db/db_connect.php';
				// $sql = "SELECT distinct sa.Div as division,eb.ExamBlockID,CONCAT(sa.Div, ' - ',sm.SubjectName) as subname, cbpid
						// FROM tblexamblock eb
						// INNER JOIN tblpapermaster pm ON pm.PaperID = eb.PaperID
						// INNER JOIN tblsubjectmaster sm ON sm.SubjectID = pm.SubjectID
						// INNER JOIN tblblocksmaster bm ON bm.BlockID = eb.BlockID
						// INNER JOIN tblstdadm sa ON pm.DeptID = sa.dept
						// INNER JOIN tblcapblockprof cbp ON cbp.ExamBlockID = eb.ExamBlockID AND cbp.profid =  " . $_SESSION["SESSUserID"] ."
						// WHERE ExamSchID IN (SELECT ExamSchID FROM tblexamschedule WHERE ExamID = " . $_SESSION["SESSCAPSelectedExam"] . ")
						// ORDER BY sm.SubjectName, eb.ExamBlockID limit 10";

						$sql = "SELECT distinct cbpid,CONCAT(dm.DivName,' - ',sm.SubjectName , 
							CASE WHEN COALESCE(PracticalPRapp,0) = 1 THEN ' - PR' 
								ELSE 
									CASE WHEN COALESCE(OralORapp,0) = 1 THEN ' - OR' 
										ELSE CASE WHEN COALESCE(TermWorkapp,0) = 1 THEN ' - TW' 
								END END END) AS subjname 
						FROM tblpapermaster pm 
						INNER JOIN tbldivmaster dm ON REPLACE(dm.Year,'.','') = SUBSTRING(pm.EnggYear,1,2) 
						INNER JOIN tblcuryearauto cy ON cy.EduYearFrom = dm.EduYearFrom AND SUBSTRING(EnggYear,LENGTH(EnggYear),1)  = cy.Sem
						INNER JOIN `tblpatternmaster` patm ON patm.acadyear = CONCAT(cy.EduYearFrom,'-',SUBSTRING(cy.EduYearTo,3,2)) 
						AND dm.year = patm.eduyear AND pm.EnggPattern = patm.teachingpat 
						INNER JOIN tblsubjectmaster sm ON sm.SubjectID = pm.SubjectID 
						INNER JOIN tblcapblockprof cpb ON cpb.ExamBlockID = pm.PaperID
						AND cpb.`div` = dm.DivName
						WHERE (COALESCE(PracticalPRapp,0) = 1 OR COALESCE(OralORapp,0) = 1 OR COALESCE(TermWorkapp,0) = 1 ) 
						AND cpb.ExamID = " . $_SESSION["SESSCAPSelectedExam"] . " AND cpb.ProfID = " . $_SESSION["SESSUserID"] . "
						 order by subjname";

						//echo $sql;
					$result1 = $mysqli->query( $sql );
					//echo $mysqli->error;
					while( $row = $result1->fetch_assoc() ) {
						extract($row);
						echo "<TR class='odd gradeX'>";
						echo "<td style='font-size:medium'>{$subjname}</td>";
						echo "<td class='span2'>";
							include 'db/db_connect.php';
							if($_SESSION["usertype"] == "SuperAdmin")
								$sql2 = "SELECT ExamID, ExamName, ExamType  FROM tblexammaster;";
							else
								$sql2 = "SELECT ExamID, ExamName, ExamType  FROM tblexammaster 
										WHERE CURRENT_TIMESTAMP BETWEEN CAPstartPROR AND CAPendPROR and ExamID = ". $_SESSION["SESSCAPSelectedExam"] ."";
							//echo $sql;
							$result2 = $mysqli->query( $sql2 );
							while( $row2 = $result2->fetch_assoc() ) {
								echo "<a class='btn btn-mini btn-success' id='btnsubmit' name='btnsubmit'
										href='marksentryMain.php?cbpid={$cbpid}&subjname={$subjname}'>
										</i>&nbsp;&nbsp;Enter Marks</a></td>";
							}
							
						echo "<td style='font-size:medium'><a target='_blank' href='MarksReport.php?cbpid={$cbpid}&subjname={$subjname}'>View Report</a></td>";
						echo "</TR>";					
					}				
				?>
			</table>
		</div>
	</div>
</form>	