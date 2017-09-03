<form action="unassignedPeonMain.php" method="post">
<?php
		if(!isset($_SESSION)){
			session_start();
		}
?>
	<br /><br />
	<h3 class="page-title" style="margin-left:5%">Peon Assignment</h3>
	<h3 class="page-title" style="float:right;margin-top:-40px;"><a href="ExamIndexMain.php">Back</a></h3>

	
	<table cellpadding="10" cellspacing="0" border="0" width="90%" class="tab_split" style="margin-left:3%">
				<tr>
					<th  colspan="3"><center>Planned Duties</center></th>
					<th  colspan="3"><center>Actual Duties</center></th>
				</tr>
				<?php
					include 'db/db_connect.php';
					$tmpExamDate = '' ;
					$tmpExamSlot = '' ;

					If (isset($_POST['btnSearch']) or (isset($_POST['btnSave']))  ) { 
							$tmpExamDate = $_POST['ddlDate'] ;
							$tmpExamSlot = $_POST['ddlExamDateSlot'] ;
						}
						Else { 
							if  (isset($_GET['ExamDate'])) {
								$tmpExamDate = $_GET['ExamDate'] ;
								$tmpExamSlot = $_GET['ExamSlot'] ;
							}
						}
						
						if ($tmpExamDate == '') {$tmpExamDate = '01/01/1900';}
						if ($tmpExamSlot == '') {$tmpExamSlot = 'Morning';}
						
						$sql = " SELECT SUM(COALESCE(peoncount, 0)) as TotPeonCount
								 FROM tblexamblockcount WHERE examid = " . $_SESSION["SESSSelectedExam"] ."";

						// execute the sql query
						$result = $mysqli->query( $sql );
						echo $mysqli->error;
						$num_results = $result->num_rows;

						if( $num_results ){
							while( $row = $result->fetch_assoc() ){
								extract($row);
								echo "<TR class='odd gradeX'>";
								echo "<td colspan='3'><center>{$TotPeonCount}</center></td>";
							}
						}	

						$sql =  "SELECT COUNT(*) AS ActTotCount 
								FROM tblpeonpref WHERE ExamID = " . $_SESSION["SESSSelectedExam"] ."";

						// execute the sql query
						$result = $mysqli->query( $sql );
						echo $mysqli->error;
						$num_results = $result->num_rows;

						if( $num_results ){
							while( $row = $result->fetch_assoc() ){
								extract($row);
								echo "<td colspan='3'><center>{$ActTotCount}</center></td>";
								echo "</TR>";
							}
						}	


						
						//disconnect from database
						$result->free();
						$mysqli->close();
					
				?>
			</table>
			
			

	<div class="row-fluid" style="margin-left:5%">
	    <div class="span10 v_detail" style="overflow:scroll">

			<table cellpadding="10" cellspacing="0" border="0" width="100%" class="tab_split" >
				<tr>
					<th>Peon Name</th>
					<th>Action</th>
					<th>Duties</th>
				</tr>

				<?php
					include 'db/db_connect.php';
						$sql = "SELECT U.userID AS PeonID,CONCAT(FirstName,' ',LastName,'-',Gender,'-',Department,'-',userType) AS PeonName, 
								COUNT(PP.peonID) AS duties 
								FROM tbluser U
								LEFT OUTER JOIN tblpeonpref PP ON  PP.peonID = U.userID AND PP.ExamID = " .  $_SESSION["SESSSelectedExam"] . "
								WHERE userType IN ('Peon') 
								GROUP BY U.userID,CONCAT(FirstName,' ',LastName,'-',Gender,'-',Department,'-',userType) 
								Order by Department;";
						
						//echo $sql;
						
						// execute the sql query
						$result = $mysqli->query( $sql );
						//echo $mysqli->error;
						$num_results = $result->num_rows;
						if( $num_results ){
							while( $row = $result->fetch_assoc() ){
								extract($row);
								echo "<TR class='odd gradeX'>";
								echo "<td>{$PeonName}</td>";
								echo "<td class='span2'>
										<a class='btn btn-mini btn-success' 
										href='unassignedPeonblock2Main.php?PeonName={$PeonName}&PeonID={$PeonID}'>
										<i class='icon-ok icon-white'></i>&nbsp;&nbsp;Assign Duties</a>
									  </td>";
								echo "<td>{$duties}</td>";
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
	<div class="clear"></div>
