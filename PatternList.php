<form action="welocme.php" method="post">
	<br /><br />
	<h3 class="page-title">Pattern Master List
	<input type="button" name="btnreport" value="View Report" class="btn btn btn-success" onclick="return sendtoreport();" /></h3>
<script>
function sendtoreport()
{
	 window.open('PatternReport.php?');
	return false;
}
</script>
	<h3 class="page-title" style="float:right;margin-top:-40px;"><a href="MainMenuMain.php">Back</a></h3>
	<div class="row-fluid">
		<div class="v_detail">
			<table cellpadding="10" cellspacing="0" border="0" width="100%" class="tab_split">
				<tr>
					<th><a class='btn btn-mini btn-success' href="patternMaintMain.php?patid=I"><i class="icon-plus icon-white"></i>New</a></th>
					<th><strong>Academic Year</strong></th>
					<th><strong>Education Year</strong></th>
					<th><strong>Teaching Pattern</strong></th>
					<th><strong>Department</strong></th>
				</tr>
				<?php
				// Create connection
				include 'db/db_connect.php';

				
				$query = "SELECT patid, acadyear, Replace(Replace(eduyear,'FY','FYMTech'),'SY','SYMTech') as eduyear, teachingpat,Deptname 
						FROM tblpatternmaster pm 
						left outer join tbldepartmentmaster dm on pm.DeptID = dm.DeptID;";
				//echo $query;
				$result = $mysqli->query( $query );
				
				$num_results = $result->num_rows;
				
				if( $num_results ){
					while( $row = $result->fetch_assoc() ){
						extract($row);
					  echo "<TR class='odd gradeX'>";
					  echo "<td><a class='btn btn-mini btn-primary' href='patternMaintMain.php?patid={$patid}'><i class='icon-pencil icon-white'></i>Edit</a> </td>";
					  echo "<td>{$acadyear}</td>";
					  echo "<td>{$eduyear}</td>";
					  echo "<td>{$teachingpat}</td>";
					  echo "<td>{$Deptname}</td>";
					  echo "</TR>";
					}
				}
				else{
					echo "<TR class='odd gradeX'>";
					echo "<td></td>";
					echo "<td></td>";
					echo "<td>No records found.</td>";
					echo "<td></td>";
					echo "<td></td>";
					echo "<td><td>";
					echo "<td><td>";
					echo "</TR>";
				}

				echo "</table>";

				?> 
				
			</table>
		</div>
	</div>

</form>
