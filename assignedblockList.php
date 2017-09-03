<form action="assignedblockList.php" method="post">
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
	<h3 class="page-title" style="float:right;margin-top:-40px;"><a href="selectexamMenuMain.php">Back</a></h3>
	<div class="row-fluid">
		<div class="v_detail">
			<table style="margin-top:-45px" cellpadding="10" cellspacing="0" border="0" width="90%" class="tab_split">
				<tr>
					<th>Block</th>
					<th width="60%"><strong>Action</strong></th>
				</tr>
				
				<?php
				//get assigned blocks 
				include 'db/db_connect.php';
				$sql = "SELECT cbpid,eb.ExamBlockID,CONCAT(bm.BlockName, ' - ',sm.SubjectName) as BlockName, cbpid
						FROM tblexamblock eb
						INNER JOIN tblpapermaster pm ON pm.PaperID = eb.PaperID
						INNER JOIN tblsubjectmaster sm ON sm.SubjectID = pm.SubjectID
						INNER JOIN tblblocksmaster bm ON bm.BlockID = eb.BlockID
						INNER JOIN tblcapblockprof cbp ON cbp.ExamBlockID = eb.ExamBlockID AND cbp.profid =  " . $_SESSION["SESSUserID"] ."
						WHERE ExamSchID IN (SELECT ExamSchID FROM tblexamschedule WHERE ExamID = " . $_SESSION["SESSCAPSelectedExam"] . ")
						ORDER BY sm.SubjectName, eb.ExamBlockID";
						//echo $sql;
					$result1 = $mysqli->query( $sql );
					//echo $mysqli->error;
					while( $row = $result1->fetch_assoc() ) {
						extract($row);
						echo "<TR class='odd gradeX'>";
						echo "<td style='width:400px;font-size:medium'>{$BlockName}</td>";
						echo "<td class='span2'>
										<a class='btn btn-mini btn-success' id='btnsubmit' name='btnsubmit'
										href='StudentqueDownloadMain.php?IUD=I&ExamBlockID={$ExamBlockID}&cbpid={$cbpid}&blockname={$BlockName}&profid=" . $_SESSION["SESSUserID"] ."'>
										</i>&nbsp;&nbsp;Enter Marks</a></td>";
										
						echo "</TR>";					
					}				
				?>
			</table>

		</div>
	</div>
</form>	