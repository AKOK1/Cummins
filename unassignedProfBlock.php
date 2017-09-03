<?php
//include database connection
include 'db/db_connect.php';
	if(!isset($_SESSION)){
		session_start();
	} 
// if the form was submitted/posted, update the record
 if (isset($_POST['btnSave']))
	{
		include 'db/db_connect.php';
		$sql = "Delete from tblexamblockcount where ebcrowid = ?";
		$stmt = $mysqli->prepare($sql);
		$stmt->bind_param('i', $_POST['txtebcrowid']);
		if($stmt->execute()){
		}else{
			echo $mysqli->error;;
		}
		
		$sql1 = "Insert into tblexamblockcount (examdate, examslot, supcount, relcount, cccount, examid, blocks) Values (?,?,?,?,?,?,?)";
		$stmt = $mysqli->prepare($sql1);
		$stmt->bind_param('ssiiiii', $_POST['ddlDate'], $_POST['ddlExamDateSlot'], $_POST['txtJrSup'], $_POST['txtRel'], $_POST['txtCC'],$_SESSION['SESSSelectedExam'],$_POST['txtBlocks']);

		if($stmt->execute()){
		}else{
			echo $mysqli->error;
		}

	}
?>


<form action="unassignedProfBlockMain.php" method="post">
<?php
		if(!isset($_SESSION)){
			session_start();
		}
?>
	<br /><br />
	<h3 class="page-title" style="margin-left:5%">Unassigned Professor Block Allocation</h3>
	<h3 class="page-title" style="float:right;margin-top:-40px;"><a href="ExamIndexMain.php">Back</a></h3>


	<div class="row-fluid" style="margin-left:5%">
	    <div class="span10 v_detail" style="overflow:scroll">

			<table cellpadding="10" cellspacing="0" border="0" width="100%" class="tab_split" >
				<tr>
					<th>Unassigned Professor</th>
					<th>Duties</th>
					<th>Action</th>
				</tr>

				<?php
					include 'db/db_connect.php';
						$sql = "SELECT userID AS ProfID,CONCAT(FirstName,' ',LastName,'-',Gender,'-',Department,'-',userType,COALESCE(Adhocenddate,'')) AS ProfName, 
								COUNT(PP.ProfID) AS duties 
								FROM tbluser U
								LEFT OUTER JOIN tblprofessorpref PP ON  PP.ProfID = U.userID AND PP.ExamID = " .  $_SESSION["SESSSelectedExam"] . "
								WHERE userType IN ('Faculty','Ad-hoc') 
								GROUP BY ProfID,CONCAT(FirstName,' ',LastName,'-',Gender,'-',Department,'-',userType, 
											COALESCE(Adhocenddate,'')) 
								HAVING duties < (SELECT MinPrefCount FROM tblexammaster WHERE ExamID = " .  $_SESSION["SESSSelectedExam"] . "
								 ) Order by Department;";
						
						//echo $sql;
						
						// execute the sql query
						$result = $mysqli->query( $sql );
						//echo $mysqli->error;
						$num_results = $result->num_rows;
						if( $num_results ){
							while( $row = $result->fetch_assoc() ){
								extract($row);
								echo "<TR class='odd gradeX'>";
								echo "<td>{$ProfName}</td>";
								echo "<td class='span2'>
										<a class='btn btn-mini btn-success' 
										href='unassignedProfblock2Main.php?ProfName={$ProfName}&ProfID={$ProfID}'>
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
