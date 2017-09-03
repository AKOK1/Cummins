<form action="PrintBlockMain.php" method="post">
<?php
		if(!isset($_SESSION)){
			session_start();
		}
?>
	<br /><br />
	<h3 class="page-title" style="margin-left:5%">Sr. Sup. Report - <?php echo date('d-M-Y',strtotime($_GET["ExamDate"])); echo ", "; echo $_GET["ExamSlot"]; ?></h3>
	<h3 class="page-title" style="float:right;margin-top:-40px;"><a href="DayReportMain.php">Back</a></h3>
	<br/>

	<div class="row-fluid" style="margin-left:5%">
	    <div class="span5 v_detail" style="overflow:scroll">
			<table cellpadding="10" cellspacing="0" border="0" width="100%" class="tab_split" >
				<tr>
					<th>Pattern</th>
					<th></th>
				</tr>

				<?php
					include 'db/db_connect.php';
					 // $sql = " SELECT DISTINCT EnggPattern FROM tblexamschedule ES
							 // INNER JOIN tblpapermaster PM ON ES.PaperID = PM.PaperID
							 // WHERE ExamDate = '" . $_GET["ExamDate"] . "' 
							 // AND ExamSlot = '" . $_GET["ExamSlot"] . "' AND ExamID = ". $_SESSION["SESSSelectedExam"] . "
							 // order by EnggPattern ";
					// echo $sql;
					$sql = " SELECT DISTINCT A.EnggPattern FROM (
							SELECT Concat(substring(EnggYear,1,2),' - ',CAST(EnggPattern AS CHAR(10))) AS EnggPattern
							FROM tblexamschedule ES 
							INNER JOIN tblpapermaster PM ON ES.PaperID = PM.PaperID 
							WHERE ExamDate = '" . $_GET["ExamDate"] . "' AND ExamSlot = '" . $_GET["ExamSlot"] . "' AND ExamID = ". $_SESSION["SESSSelectedExam"] . " AND SUBSTRING(EnggYear,1,2) <> 'ME'
							UNION
							SELECT Concat(substring(EnggYear,1,2),' - ',CONCAT(CAST(EnggPattern AS CHAR(10)) , ' - ME')) AS EnggPattern
							FROM tblexamschedule ES 
							INNER JOIN tblpapermaster PM ON ES.PaperID = PM.PaperID 
							WHERE ExamDate = '" . $_GET["ExamDate"] . "' AND ExamSlot = '" . $_GET["ExamSlot"] . "' AND 
							ExamID = ". $_SESSION["SESSSelectedExam"] . "  AND SUBSTRING(EnggYear,1,2) = 'ME'
							) AS A
							ORDER BY A.EnggPattern ";
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
							echo "<td>{$EnggPattern}</td>";
							echo "<td class='span2'>
									<a class='btn btn-mini btn-success' target='_blank'
									href='SrSupPrint.php?Pattern={$EnggPattern}&ExDate=".$_GET["ExamDate"]."&ExSlot=".$_GET["ExamSlot"]."'>
									<i class='icon-ok icon-white'></i>&nbsp;&nbsp;Print</a>
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