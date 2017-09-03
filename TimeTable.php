<form method="post">
<?php
	if(!isset($_SESSION)){
		session_start();
	}
?>	
	<br /><br /><br />
	
	<h3>
	<?php
		 if (isset($_POST['btnUpload']))
		 {
			 echo $_FILES['fileToUpload']['name'] ;
		 }
	 ?>
	</h3>
	<h3 class="page-title" style="margin-left:5%">Time Table Report</h3>
	<h3 class="page-title" style="float:right;margin-top:-46px;">
	<?php
		if ($_SESSION["SESSSelectedExamType"] ==  'Online') {
			echo"<a href='ExamIndexOMain.php'>Back</a>";
		}
		else {
			echo"<a href='ExamIndexMain.php'>Back</a>";
		}
	?>
	</h3>


	<div class="row-fluid" style="margin-left:5%">
	    <div class="span11 v_detail" style="overflow:scroll">
		<div style="float:left">
			<table cellpadding="10" cellspacing="0" border="0" width="150%" class="tab_split">
				<tr>
					<th>Select Department</th>
				</tr>
				<?php
					include 'db/db_connect.php';
					  $sql = "SELECT DeptName,DeptUnivName from tbldepartmentmaster where coalesce(Teaching,0) = 1";
						// execute the sql query
						$result = $mysqli->query( $sql );
						$num_results = $result->num_rows;

						if( $num_results ){
							while( $row = $result->fetch_assoc() ){
								extract($row);
								echo "<TR class='odd gradeX'>";
								echo "<td>
										<a class='btn btn-mini btn-success' target='_blank'
										href='PrintDayByDept.php?DeptName={$DeptName}&DeptFull={$DeptUnivName}'>
										<i class='icon-ok icon-white'></i>&nbsp&nbsp{$DeptName}</a></td>";
								echo "</TR>";
							}
						}					
						//disconnect from database
						$result->free();
						$mysqli->close();
				?>
						<TR class='odd gradeX'>										
								<td><a class='btn btn-mini btn-success' target='_blank'
								href='PrintDayByDept.php?DeptName=ALL&DeptFull=All Departments'>
								<i class='icon-ok icon-white'></i>&nbsp&nbspALL</a></td>
						</TR>
				</table>
				</div>
				<div style="float:left;margin-left:100px">
				<table cellpadding="10" cellspacing="0" border="0" width="120%" class="tab_split">
				<tr>
					<th>Select Year</th>
				</tr>
				<TR class='odd gradeX'>
					<td>
						<a class='btn btn-mini btn-success' target='_blank'
						href='PrintDayByYear.php?Year=FE'>
						<i class='icon-ok icon-white'></i>&nbsp&nbspF.E.</a>
					</td>
				</TR>
				<TR class='odd gradeX'>
					<td>
						<a class='btn btn-mini btn-success' target='_blank'
						href='PrintDayByYear.php?Year=SE'>
						<i class='icon-ok icon-white'></i>&nbsp&nbspS.E.</a>
					</td>
				</TR>
				<TR class='odd gradeX'>
					<td>
						<a class='btn btn-mini btn-success' target='_blank'
						href='PrintDayByYear.php?Year=TE'>
						<i class='icon-ok icon-white'></i>&nbsp&nbspT.E.</a>
					</td>
				</TR>
				<TR class='odd gradeX'>
					<td>
						<a class='btn btn-mini btn-success' target='_blank'
						href='PrintDayByYear.php?Year=BE'>
						<i class='icon-ok icon-white'></i>&nbsp&nbspB.E.</a>
					</td>
				</TR>
				<TR class='odd gradeX'>
					<td>
						<a class='btn btn-mini btn-success' target='_blank'
						href='PrintDayByYear.php?Year=ME'>
						<i class='icon-ok icon-white'></i>&nbsp&nbspM.E.</a>
					</td>
				</TR>
				<TR class='odd gradeX'>
					<td>
						<a class='btn btn-mini btn-success' target='_blank'
						href='PrintDayByYear.php?Year=ALL'>
						<i class='icon-ok icon-white'></i>&nbsp&nbspALL</a>
					</td>
				</TR>
				</table>
				</div>
            <br />
        </div>

	</div>
	</form>

