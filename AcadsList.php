<form action="AcadsList.php" method="post">
<?php
	if(!isset($_SESSION)){
		session_start();
	}
		if ( ($_SESSION["usertype"] == 'Student') || $_SESSION["SESSFrom"] == 'fromadmin'){
			// do nothing
		}
		else{
			header('Location: login.php?');
		}
?>	
	
	<br /><br />
	<?php
				if($_SESSION["SESSFrom"] == 'fromadmin'){
					echo '<h3 class="page-title">Academics - ' . $_SESSION["stdname"] . '</h3>';
				}
				else{
					echo '<h3 class="page-title">Academics</h3>';
				}
	?>
	<h3 class="page-title" style="float:right;margin-top:-40px;">
	<?php
				if($_SESSION["SESSFrom"] == 'fromadmin'){
					echo '<a href="StdListMain.php">Back</a>';
				}
				else{
					echo '<a href="MainMenuMain.php">Back</a>';
				}
	?>
	</h3>
	<div class="row-fluid">
		<div class="v_detail">
			<table cellpadding="10" cellspacing="0" border="0" width="100%" class="tab_split">
				<tr>
					<th></th>
					<th><strong>Year From</strong></th>
					<th><strong>Year To</strong></th>
					<th><strong>Year</strong></th>
					<th><strong>Department</strong></th>
					<th><strong>Shift</strong></th>
					<th></th>
					<th></th>
				</tr>

				<?php
				// Create connection
				include 'db/db_connect.php';
				if($_SESSION["SESSFrom"] == 'fromadmin'){
					$query = "SELECT StdAdmID, EduYearFrom, EduYearTo, Year, DeptName, s.Shift 
								FROM tblstdadm SM
								inner join tblstudent s on s.stdid = SM.stdid
							  Left Outer Join tbldepartmentmaster DM on SM.Dept = DM.DeptID  
							  LEFT JOIN stdqual SQ ON s.stdid = SQ.stdid AND Exam = '10th'
							  Where SM.StdID = ". $_SESSION["SESSStdId"] . " 
							  AND COALESCE(Pmail,'') <> '' AND COALESCE(SQ.name,'') <> ''
							  AND COALESCE(parent_name,'') <> '' AND COALESCE(uniprn,'') <> ''
								AND s.CNUM = '" . $_SESSION["cnum"] . "'  
							  Order by EduYearTo desc" ;					
				}
				else{
					if($_SESSION["SESSStdId"] > 13953){
						$query = "SELECT DISTINCT sa.EduYearFrom,sa.EduYearTo,Year, DeptName,sa.Shift
						FROM tblstudent s
						INNER JOIN tblstdadm sa ON s.stdid = sa.stdid
						INNER JOIN tblexamblockstudent ebs ON ebs.StdID = sa.ESNum
						INNER JOIN tblexamblock eb ON eb.ExamBlockID = ebs.ExamBlockID
						INNER JOIN tblexamschedule es ON es.ExamSchID = eb.ExamSchID
						INNER JOIN tblexammaster em ON em.ExamID = es.ExamID AND em.AcadYearFrom = sa.EduYearFrom AND examtype2 IN('End-Sem')
						LEFT OUTER JOIN tbldepartmentmaster DM ON sa.Dept = DM.DeptID
						WHERE s.StdID = ". $_SESSION["SESSStdId"] . " Order by sa.EduYearTo desc ";
					}
					else{
						$query = "SELECT StdAdmID, EduYearFrom, EduYearTo, Year, DeptName, s.Shift 
									FROM tblstdadm SM
									inner join tblstudent s on s.stdid = SM.stdid
								  Left Outer Join tbldepartmentmaster DM on SM.Dept = DM.DeptID  
								  LEFT JOIN stdqual SQ ON s.stdid = SQ.stdid AND Exam = '10th'
								  Where SM.StdID = ". $_SESSION["SESSStdId"] . " 
								  AND COALESCE(Pmail,'') <> '' AND COALESCE(SQ.name,'') <> ''
								  AND COALESCE(parent_name,'') <> '' 
									AND s.CNUM = '" . $_SESSION["loginid"] . "' 
								  Order by EduYearTo desc" ;					
					}

				}
				//AND COALESCE(uniprn,'') <> ''
				//echo $query;
				$result = $mysqli->query( $query );
				$num_results = $result->num_rows;
				
				if( $num_results ){
					while( $row = $result->fetch_assoc() ){
						extract($row);
					  echo "<TR class='odd gradeX'>";
					  echo "<td></td>";
					  echo "<td>{$EduYearFrom}</td>";
					  echo "<td>{$EduYearTo}</td>";
					  echo "<td>{$Year}</td>";
					  echo "<td>{$DeptName}</td>";
					  echo "<td>{$Shift}</td>";
					  /*
					  echo "<td class='span2'>
							<a class='btn btn-mini btn-success' 
							href='StdElectiveMapMain.php?EduYearFrom={$EduYearFrom}&EduYearTo={$EduYearTo}'>
							<i class='icon-ok icon-white'></i>&nbsp&nbspView Subjects</a></td>";
					  */
					  if($_SESSION["SESSStdId"] > 13953){
						  echo "<td class='span2'>
								<a class='btn btn-mini btn-success' 
								href='ViewInsemMarks.php'>
								<i class='icon-ok icon-white'></i>&nbsp&nbspView Results</a></td>";
					  }
					  else{
						  echo "<td class='span2'>
								<a class='btn btn-mini btn-success' 
								href='ShowResult.php?YearFrom={$EduYearFrom}&YearTo={$EduYearTo}'>
								<i class='icon-ok icon-white'></i>&nbsp&nbspView Results</a></td>";
					  }
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
