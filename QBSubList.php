<?php
 if(!isset($_SESSION)){
	session_start();
	}
	$_SESSION["qbpaperid"] = "";
?>

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
			<h3 class="page-title">Select a Subject for adding Questions</h3>
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
					echo "<th>Subject </th>";
					echo "<th></th>";
					echo "</tr>";

					$query = "SELECT spr.PaperID, SubjectName FROM tblsubprofrole spr,tblsubjectmaster sm,tblpapermaster pm
					where pm.paperid = spr.paperid and pm.subjectid = sm.subjectid and profid = ". $_SESSION["SESSUserID"];

					$query = "SELECT SubjectName, ys.PaperID
							FROM vwhodsubjectsselected ys 
							INNER JOIN tblyearstructprof ysp ON ysp.YSID = ys.YSID
							LEFT JOIN tblbatchmaster bm ON bm.BtchId = ysp.btchId 
							WHERE COALESCE(profid,0) = " . $_SESSION["SESSUserID"] . 
							" AND ys.papertype IS NOT NULL 
							ORDER BY SubjectName;";

					$query = "SELECT PaperID, SubjectName FROM tblsubjectmaster sm,tblpapermaster pm, vwmaxpattern mp 
					where sem = 1 AND mp.EnggPattern = pm.EnggPattern AND CONCAT(mp.EnggYear,' - Sem ',mp.Sem) = pm.EnggYear and pm.subjectid = sm.subjectid and deptid in (SELECT DeptID FROM tbldepartmentmaster where DeptName = '" . $_SESSION["SESSUserDept"] . "')";

							//echo $query;
					$result = $mysqli->query( $query );
					
					$num_results = $result->num_rows;
					
					if( $num_results ){
						while( $row = $result->fetch_assoc() ){
							extract($row);
						  echo "<TR class='odd gradeX'>";
						  echo "<td>{$SubjectName}</td>";
						  echo "<td><a class='btn btn-mini btn-primary' href='QuestionListMain.php?PaperID={$PaperID}&subname={$SubjectName}'><i class='icon-white'></i>Go</a> </td>";
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
