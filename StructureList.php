<form name="myform" action="StructureListMain.php" method="post">
	<head>
		<link rel="stylesheet" href="css/jquery-ui.css">
		<script src="js/jquery-1.10.2.js"></script>
		<script src="js/jquery-ui.js"></script>
		<script type="text/javascript" src="js/jquery.min.js"></script>
	</head>
	
<body>
	<br /><br />
	<div>
		<div style="float:left">
			<h3 class="page-title">Your Subjects</h3>
		</div>
		<div style="float:right;margin-right:100px">
			<h3 class="page-title"><a href="MainMenuMain.php">Back</a></h3>
		</div>
		<br/><br/><br/>
	</div>
	
	<input type="hidden" name="selectedids" id="selectedids">
	<input type="hidden" name="selecteddept" id="selecteddept" value="">
	<input type="hidden" name="selectedyear" id="selectedyear" value="">
	
	<br/>
	<div class="row-fluid">
		<div class="v_detail">
			<table cellpadding="10" cellspacing="0" border="0" class="tab_split">
				<tr>
				<?php
					// Create connection
					include 'db/db_connect.php';
					echo "<th></th>";
					echo "<th></th>";
					echo "<th>Subject </th>";
					echo "</tr>";

					$query = "SELECT SubjectName, ys.PaperID
							FROM vwhodsubjectsselected ys 
							INNER JOIN tblyearstructprof ysp ON ysp.YSID = ys.YSID
							LEFT JOIN tblbatchmaster bm ON bm.BtchId = ysp.btchId 
							WHERE COALESCE(profid,0) = " . $_SESSION["SESSUserID"] . 
							" AND ys.papertype IS NOT NULL 
							ORDER BY SubjectName;";
					$query = "SELECT spr.PaperID, SubjectName FROM tblsubprofrole spr,tblsubjectmaster sm,tblpapermaster pm
					where coalesce(roleid,0) = 1 and pm.paperid = spr.paperid and pm.subjectid = sm.subjectid and profid = ". $_SESSION["SESSUserID"];
					//echo $query;
					$result = $mysqli->query( $query );
					
					$num_results = $result->num_rows;
					
					if( $num_results ){
						while( $row = $result->fetch_assoc() ){
							extract($row);
						  echo "<TR class='odd gradeX'>";
						  echo "<td><a class='btn btn-mini btn-primary' href='redirectToStruct.php?PaperID={$PaperID}'><i class='icon-white'></i>Edit</a> </td>";
						  echo "<td><a class='btn btn-mini btn-success' target='_blank'
										href='PrintSyllabus.php?PaperID={$PaperID}&SubName={$SubjectName}'><i class='icon-ok icon-white'></i>Print</a></td>";
						  echo "<td>{$SubjectName}</td>";

						  echo "</TR>";
						}
					}
					else{
						//echo "No records found.";
						echo "<TR class='odd gradeX'>";
						echo "<td></td>";
						echo "<td>No records found.</td>";
						echo "<td></td>";
						echo "</TR>";
					}
					echo "</table>";
				?> 
			</table>
		</div>
	</div>
</body>
</form>
