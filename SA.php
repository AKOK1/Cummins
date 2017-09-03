<form>
<?php
	if(!isset($_SESSION)){
		session_start();
	}
?>	
	<br /><br /><br />
	
	<h3>
	</h3>
	<h3 class="page-title" style="margin-left:5%">Seating Arrangement</h3>
	<h3 class="page-title" style="float:right;margin-top:-46px;"><a href="ExamIndexMain.php">Back</a></h3>


	<div class="row-fluid" style="margin-left:5%">
	    <div class="span11 v_detail" style="overflow:scroll">
            <br />
            <br />
			<table cellpadding="10" cellspacing="0" border="0" width="100%" class="tab_split">
				<tr>
					<th>Day</th>
					<th>Exam Date</th>
					<th>Slot</th>
					<th></th>
				</tr>
				<?php
					include 'db/db_connect.php';
					  $sql = "SELECT DISTINCT ExamDate, 
								DATE_FORMAT(STR_TO_DATE(ExamDate,'%m/%d/%Y'), '%d %M %Y') AS ExamDateT, 
								DAYNAME(STR_TO_DATE(ExamDate,'%m/%d/%Y')) AS ExamDay, ExamSlot
								FROM tblexamschedule Where ExamID = " . $_SESSION["SESSSelectedExam"] ."
								 and coalesce(examdate,'') <> '' 								
								ORDER BY ExamDate, ExamSlot Desc";

						// execute the sql query
						$result = $mysqli->query( $sql );
						$num_results = $result->num_rows;

						if( $num_results ){
							while( $row = $result->fetch_assoc() ){
								extract($row);
								echo "<TR class='odd gradeX'>";
								echo "<td>{$ExamDay}</td>";
								echo "<td>{$ExamDateT}</td>";
								echo "<td>{$ExamSlot}</td>";
								echo "<td>
										<a class='btn btn-mini btn-success' target='_blank'
										href='PrintDay.php?IUD=P&ExamDate={$ExamDate}&ExamSlot={$ExamSlot}'>
										<i class='icon-ok icon-white'></i>&nbsp&nbspSeating Arrangement</a></td>";
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

