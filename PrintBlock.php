<form action="PrintBlockMain.php" method="post">
<?php
		if(!isset($_SESSION)){
			session_start();
		}
?>
	<br /><br />
	<h3 class="page-title" style="margin-left:5%">Print Block Student List - <?php echo date('d-M-Y',strtotime($_GET["ExamDate"])); echo ", "; echo $_GET["ExamSlot"]; ?></h3>
	<h3 class="page-title" style="float:right;margin-top:-40px;">
	<!-- 
	<?php
			echo"<a href='SelectPaperBlockMain.php?ExamDate=" . $_GET['ExamDate'] . "&ExamSlot=" . $_GET['ExamSlot'] . "'>Back</a>";
	?>
	-->
	</h3>
	<br/>

	<div class="row-fluid" style="margin-left:5%">
	    <div class="span7 v_detail" style="overflow:scroll">
			<table cellpadding="10" cellspacing="0" border="0" width="100%" class="tab_split" >
				<tr>
					<th>Block Name</th>
					<th>Capacity</th>
					<th>Allocation</th>
					<th></th>
					<th></th>
				</tr>

				<?php
					include 'db/db_connect.php';
					$sql = " SELECT BlockId, BlockName, BlockCapacity, SUM(Allocation) AS Allocation, colorder, BlockNo
							FROM (
						 SELECT EB.BlockId, BlockName, BlockType, BM.BlockCapacity, EB.Allocation, colorder, BM.BlockNo
						 FROM tblexamblock EB 
						INNER JOIN tblblocksmaster BM ON EB.BlockID = BM.BlockID
						INNER JOIN (SELECT COUNT(*) AS Allocation, ExamBlockID FROM tblexamblockstudent GROUP BY ExamBlockId) AS EBS ON EB.ExamBlockID = EBS.ExamBlockID
						WHERE EB.ExamSchId IN (SELECT ExamSchId FROM tblexamschedule WHERE ExamDate = '" . $_GET["ExamDate"] . "' 
						AND ExamSlot = '" . $_GET["ExamSlot"] . "' and examid = " . $_SESSION["SESSSelectedExam"] . ")
						) AS A
						GROUP BY BlockId, BlockName, BlockCapacity, colorder 
						 ORDER BY cast(BlockNo as UNSIGNED)";
					//echo $sql;
					// execute the sql query
					$result = $mysqli->query( $sql );
					echo $mysqli->error;
					$num_results = $result->num_rows;
					$totStd = 0;
					if( $num_results ){
						while( $row = $result->fetch_assoc() ){
							extract($row);
							echo "<TR class='odd gradeX'>";
							echo "<td>{$BlockName}</td>";
							echo "<td>{$BlockCapacity}</td>";
							echo "<td>{$Allocation}</td>";
							echo "<td class='span2'>
									<a class='btn btn-mini btn-success' target='_blank'
									href='";
									if($_SESSION["SESSSelectedExamType"] ==  'Online')
										echo "PrintSeatOnline.php";
									else
										echo "PrintSeat.php";
							echo  "?BlockId={$BlockId}&ExDate=".$_GET["ExamDate"]."&ExSlot=".$_GET["ExamSlot"]."'>
									<i class='icon-ok icon-white'></i>&nbsp;&nbsp;Print</a>
									</td>" ;

							echo "<td class='span2'>
									<a class='btn btn-mini btn-success' target='_blank'
									href='";
									if($_SESSION["SESSSelectedExamType"] ==  'Online')
										echo "PrintSeatOnline.php";
									else
										echo "PrintJrSup.php";
							echo  "?BlockId={$BlockId}&ExDate=".$_GET["ExamDate"]."&ExSlot=".$_GET["ExamSlot"]."'>
									<i class='icon-ok icon-white'></i>&nbsp;&nbsp;Jr. Sup.</a>
									</td>" ;

							echo "</TR>";
						}
					}					
					//disconnect from database
					$result->free();
					$mysqli->close();
				
				?>
			</table>
        </div>
	</div>
</form>