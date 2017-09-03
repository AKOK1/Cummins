<form action="OIListMain.php" method="post">
<?php
	if(!isset($_SESSION)){
		session_start();
	}
		if ( ($_SESSION["usertype"] != 'Student')){
			header('Location: login.php?');
		}
?>	
	
	<br /><br />
	<h3 class="page-title">Online / In-sem Marks</h3>
	<h3 class="page-title" style="float:right;margin-top:-40px;"><a href="MainMenuMain.php">Back</a></h3>
	<div class="row-fluid">
		<div class="v_detail">
			<table cellpadding="10" cellspacing="0" border="0" width="100%" class="tab_split">
				<tr>
					<th></th>
					<th><strong>Exam</strong></th>
					<th></th>
					<th></th>
				</tr>

				<?php
				// Create connection
				include 'db/db_connect.php';

				$query = "SELECT DISTINCT oi.examid,examname 
							FROM tbloiresults oi
							inner join tblstudent s on TRIM(s.CNUM) = TRIM(oi.CNUM)
							INNER JOIN tblexammaster em ON em.ExamID = oi.ExamID and coalesce(Publish,0) = 1
							INNER JOIN stdqual SQ ON s.stdid = SQ.stdid AND Exam = '10th'
							WHERE trim(COALESCE(Pmail,'')) <> '' 
							AND trim(COALESCE(SQ.name,'')) <> '' 
							AND trim(COALESCE(parent_name,'')) <> '' 
							AND trim(COALESCE(unieli,'')) <> ''
							AND s.CNUM = '" . $_SESSION["loginid"] . "'";
				//echo $query;
				$result = $mysqli->query( $query );
				$num_results = $result->num_rows;
				
				if( $num_results ){
					while( $row = $result->fetch_assoc() ){
						extract($row);
					  echo "<TR class='odd gradeX'>";
					  echo "<td>{$examname}</td>";
					  echo "<td class='span2'>
							<a class='btn btn-mini btn-success' 
							href='ViewOIResults.php?ExamID={$examid}&examname={$examname}'>
							<i class='icon-ok icon-white'></i>&nbsp&nbspView Results</a></td>";
					  echo "</TR>";
					}
				}
				else{
					echo "<TR class='odd gradeX'>";
					echo "<td></td>";
					echo "<td>No records found.</td>";
					echo "<td></td>";
					echo "<td></td>";
					echo "<td></td>";
					echo "<td></td>";
					echo "</TR>";
				}

				echo "</table>";

				?> 
				
			</table>
		</div>
	</div>

</form>
