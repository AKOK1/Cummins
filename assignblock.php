<form action="assignblockMain.php" method="post">
	<br /><br />
	<?php
		include 'db/db_connect.php';
		$sql = "SELECT CONCAT(FirstName,' ', LastName) AS profname
				from tbluser where userID = " . $_GET["profid"];
			$result = $mysqli->query( $sql );
			$num_results = $result->num_rows;
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
			echo "<td colspan='9'><h2><center><b>{$ExamDateT} ".$_GET['ExamSlot']."</b></center></h2>";
			//if ($_SESSION["SESSSelectedExamType"] == 'Online') {
			//	echo "<h2><center><b style='color:red'>Report in Mech Auditorium, 30 Minutes before your timing, for university attendance.</b></center></h2>";
			//}
			echo "</td>";
			echo "</tr>";
	?>
	
	<h3 class="page-title" style="margin-left:0%">Professor Block Assignment - <?php echo $_SESSION["SESSCAPSelectedExamName"]; ?> , <?php echo $profname; ?></h3>
	<h3 class="page-title" style="float:right;margin-top:-40px;"><a href="proflistMain.php">Back</a></h3>
<div class="row-fluid" style="margin-left:1%;margin-top:-15px">
	<div class="span7 v_detail" style="overflow:scroll">
            <div style="float:left">
				<label><b>Available Blocks</b></label>
            </div>
		</script>
		<table cellpadding="10" id="tblid" cellspacing="0" border="0" width="100%" class="tab_split">
				<?php
				echo "<tr>
				<th>Block</th>
				<th>Assign</th>
				</tr>";			
				//get blocks for selected cap exam
				include 'db/db_connect.php';
				$sql = "SELECT eb.ExamBlockID,CONCAT(DATE_FORMAT(STR_TO_DATE(es.ExamDate,'%m/%d/%Y'), '%d %M %Y') , ' - ', bm.BlockName, ' - ',sm.SubjectName) as BlockName
						FROM tblexamblock eb
						INNER JOIN tblpapermaster pm ON pm.PaperID = eb.PaperID
						INNER JOIN tblsubjectmaster sm ON sm.SubjectID = pm.SubjectID
						INNER JOIN tblblocksmaster bm ON bm.BlockID = eb.BlockID
						INNER JOIN tblexamschedule es ON es.ExamSchID = eb.ExamSchID
						WHERE eb.ExamSchID IN (SELECT ExamSchID FROM tblexamschedule WHERE ExamID = " . $_SESSION["SESSCAPSelectedExam"] . ")
						AND eb.ExamBlockID not in (select ExamBlockID from tblcapblockprof where ExamID = " . $_SESSION["SESSCAPSelectedExam"] . ")
						ORDER BY es.ExamDate,sm.SubjectName, eb.ExamBlockID";

						//AND eb.ExamBlockID not in (select ExamBlockID from tblcapblockprof where ExamID = " . $_SESSION["SESSCAPSelectedExam"] . " and profid = " . $_GET['profid'] . ")
				//echo $sql;
					$result1 = $mysqli->query( $sql );
					//echo $mysqli->error;
					while( $row = $result1->fetch_assoc() ) {
						extract($row);
						echo "<TR class='odd gradeX'>";
						echo "<td>{$BlockName}</td>";
						echo "<td class='span2'>
								<a class='btn btn-mini btn-success' id='btnsubmit' name='btnsubmit'
								 href='assigncapblockupd.php?type=b&IUD=I&ExamBlockID={$ExamBlockID}&profid={$_GET['profid']}'>
								<i class='icon-ok icon-white'></i>&nbsp;&nbsp;Assign</a>
							  </td>";
						echo "</TR>";
					}
				?>
		</table>
			<br />
    </div>
        <div class="span5 v_detail" style="overflow:scroll">
            <div style="float:left;">
				<label><b>Selected Blocks</b></label>
            </div>
			<br/><br/><br/><br/>
			<table style="margin-top:-45px" cellpadding="10" cellspacing="0" border="0" width="90%" class="tab_split">
				<tr>
					<th>Block</th>
					<th width="10%"><strong>Action</strong></th>
				</tr>
				<?php
				//get assigned blocks 
				include 'db/db_connect.php';
				$sql = "SELECT cbpid,eb.ExamBlockID,CONCAT(bm.BlockName, ' - ',sm.SubjectName) as BlockName
						FROM tblexamblock eb
						INNER JOIN tblpapermaster pm ON pm.PaperID = eb.PaperID
						INNER JOIN tblsubjectmaster sm ON sm.SubjectID = pm.SubjectID
						INNER JOIN tblblocksmaster bm ON bm.BlockID = eb.BlockID
						INNER JOIN tblcapblockprof cbp ON cbp.ExamBlockID = eb.ExamBlockID AND cbp.profid = " . $_GET['profid'] . "
						WHERE ExamSchID IN (SELECT ExamSchID FROM tblexamschedule WHERE ExamID = " . $_SESSION["SESSCAPSelectedExam"] . ")
						ORDER BY sm.SubjectName, eb.ExamBlockID";
					$result1 = $mysqli->query( $sql );
					//echo $sql;
					//echo $mysqli->error;
					while( $row = $result1->fetch_assoc() ) {
						extract($row);
						echo "<TR class='odd gradeX'>";
						echo "<td>{$BlockName}</td>";
					echo "<td class='span3'><a class='btn btn-mini btn-danger' href='assigncapblockupd.php?type=b&IUD=D&cbpid={$cbpid}&profid={$_GET['profid']}'>
						<i class='icon-remove icon-white'></i>&nbsp&nbspCancel</a></td>";						
						echo "</TR>";					
					}				
				?>
			</table>
		</div>
</div>
	<div class="clear"></div>
</form>