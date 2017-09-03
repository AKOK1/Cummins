<?php
//include database connection
include 'db/db_connect.php';
	if(!isset($_SESSION)){
		session_start();
	} 
	if(isset($_POST['ExamDate'])){
		$_POST['ddlDate'] = $_POST['ExamDate'];
		$_POST['ddlExamDateSlot'] = $_POST['ExamSlot'];
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


<form action="ProfBlockMain.php" method="post">
<?php
		if(!isset($_SESSION)){
			session_start();
		}
?>
	<br /><br />
	<h3 class="page-title" style="margin-left:5%">Professor Block Allocation</h3>
	<h3 class="page-title" style="float:right;margin-top:-40px;">
	<?php
			if(isset($_GET['ExamDate'])){
				echo"<a href='SelectPaperBlockMain.php?ExamDate=" . $_GET['ExamDate'] . "&ExamSlot=" . $_GET['ExamSlot'] . "'>Back</a>";
			}
			elseif(isset($_POST['ddlDate'])){
				echo"<a href='SelectPaperBlockMain.php?ExamDate=" . $_POST['ddlDate'] . "&ExamSlot=" . $_POST['ddlExamDateSlot'] . "'>Back</a>";
			}
	?>		</h3>
		<table cellpadding="10" cellspacing="0" border="0" class="tab_split" style="margin-left:5%">
			<tr >
				<td class="form_sec span1">Exam Date</td>
				<td class="form_sec span2">
					<select name="ddlDate" style="width:50%;margin-top:10px">
						<?php
						include 'db/db_connect.php';
						echo "<option value=Select>Select</option>"; 
						$sql = "SELECT DISTINCT(ExamDate) AS ExamDate,DATE_FORMAT(STR_TO_DATE(ExamDate,'%m/%d/%Y'), '%d %M %Y') as ExamDateText FROM tblexamschedule WHERE ExamID = " . $_SESSION["SESSSelectedExam"] . " ORDER BY ExamDate;";
						$result1 = $mysqli->query( $sql );
						while( $row = $result1->fetch_assoc() ) {
						extract($row);
						 if((isset($_POST['ddlDate']) && $_POST['ddlDate'] == $ExamDate) || (isset($_GET['ExamDate']) && $_GET['ExamDate'] == $ExamDate) ){
								echo "<option value={$ExamDate} selected>{$ExamDateText}</option>"; 
							}
							else{
								echo "<option value={$ExamDate}>{$ExamDateText}</option>"; 
							}
						}
						?>
					</select>
				</td>
				<td class="form_sec span1">Slot</td>
				<td class="form_sec span2">
					<select name="ddlExamDateSlot" style="width:50%;margin-top:10px" >
						<?php
						if((isset($_POST['ddlExamDateSlot']) && $_POST['ddlExamDateSlot'] == 'Select') || 
							(isset($_GET['ExamSlot']) && $_GET['ExamSlot'] == 'Select')){
								echo "<option value=Select selected>Select</option>"; 
							}
							else{
								echo "<option value=Select>Select</option>"; 
							}
						if((isset($_POST['ddlExamDateSlot']) && $_POST['ddlExamDateSlot'] == 'Morning') || 
							(isset($_GET['ExamSlot']) && $_GET['ExamSlot'] == 'Morning')){
								echo "<option value=Morning selected>Morning</option>"; 
							}
							else{
								echo "<option value=Morning>Morning</option>"; 
							}
						if((isset($_POST['ddlExamDateSlot']) && $_POST['ddlExamDateSlot'] == 'Evening') || 
							(isset($_GET['ExamSlot']) && $_GET['ExamSlot'] == 'Evening')){
								echo "<option value=Evening selected>Evening</option>"; 
							}
							else{
								echo "<option value=Evening>Evening</option>"; 
							}
						?>
					</select>
				</td>
				<td class="form_sec span2">
					<input type="submit" name="btnSearch" value="Search" title="Update" class="btn btn btn-success" />
				</td>								
			</tr>						
		</table>
	<br/>

	<div class="row-fluid" style="margin-left:5%">
	    <div class="span10 v_detail" style="overflow:scroll">

			<table cellpadding="10" cellspacing="0" border="0" width="100%" class="tab_split" >
				<tr>
					<th>Sr. No.</th>
					<th>Block Name</th>
					<th>Action</th>
					<th>Assigned Professor</th>
				</tr>

				<?php
					include 'db/db_connect.php';
					If ((isset($_POST['btnSearch'])) or (isset($_POST['btnSave'])) or isset($_GET['ExamDate']))
					{
						If (isset($_POST['btnSearch']) or (isset($_POST['btnSave']))) { 
							$tmpExamDate = $_POST['ddlDate'] ;
							$tmpExamSlot = $_POST['ddlExamDateSlot'] ;
						}
						Else {
							$tmpExamDate = $_GET['ExamDate'] ;
							$tmpExamSlot = $_GET['ExamSlot'] ;
						}

						// $sql = " SELECT eb.PaperID,CONCAT(BlockNo,'-',BlockName) AS BlockName ,eb.BlockID
								// FROM tblexamblock eb, tblblocksmaster bm, tblexamschedule es
								// WHERE eb.BlockID = bm.BlockID AND eb.ExamSchID = es.ExamSchID AND es.ExamID = " . $_SESSION["SESSSelectedExam"] . "
								// AND es.ExamSlot = '" . $tmpExamSlot . "' 
								// AND es.ExamDate = '". $tmpExamDate . "' ";

						$sql = "SELECT distinct eb.BlockID,BlockName, 
								COALESCE(CONCAT(Department,' - ', Concat(u.FirstName, ' ', u.LastName),' - ',Gender),'') as ProfName,
								bm.BlockNo
								FROM tblexamblock eb
								LEFT JOIN tblblocksmaster bm ON eb.BlockID = bm.BlockID 
								LEFT JOIN tblexamschedule es ON eb.ExamSchID = es.ExamSchID 
								LEFT OUTER JOIN tbluser u ON eb.ProfID = u.userID 
								WHERE es.ExamSlot = '" . $tmpExamSlot . "' 
								AND es.ExamDate = '". $tmpExamDate . "' AND es.ExamID = ".$_SESSION["SESSSelectedExam"]."
								 ORDER BY CAST(bm.BlockNo AS UNSIGNED);";
							//LEFT OUTER JOIN vwuser u ON eb.ProfID = u.userID AND u.ExamID = ".$_SESSION["SESSSelectedExam"]."
						//and eb.ProfID is not null 
						//echo $sql;
						
						// execute the sql query
						$result = $mysqli->query( $sql );
						//echo $mysqli->error;
						$i = 1;
						$num_results = $result->num_rows;
						if( $num_results ){
							while( $row = $result->fetch_assoc() ){
								extract($row);
								echo "<TR class='odd gradeX'>";
								echo "<td>$i</td>";
								echo "<td>{$BlockName}</td>";
								echo "<td class='span2'>
										<a class='btn btn-mini btn-success' 
										href='profblock2Main.php?BlockID={$BlockID}&BlockName={$BlockName}&ExamDate={$tmpExamDate}&ExamSlot={$tmpExamSlot}'>
										<i class='icon-ok icon-white'></i>&nbsp;&nbsp;Show Profs.</a>
									  </td>";
								echo "<td>{$ProfName}</td>";
								echo "</TR>";
								$i += 1;
							}
						}					
						//now append the RELs and CCs
						$mysqli->query("set @i_examid   = " .  $_SESSION["SESSSelectedExam"] . "");
						$mysqli->query("set @i_examdate   = '" .  $tmpExamDate . "'");
						$mysqli->query("set @i_examslot   = '" .  $tmpExamSlot . "'");
						// $result1 = $mysqli->query("call sp_getrelccs(@i_examid,@i_examdate,@i_examslot)");
						// while( $row = $result1->fetch_assoc() ) {
							// extract($row);
								// echo "<tr class='odd gradex'>";
								// echo "<td>{$BlockName}</td>";
								// echo "<td>{$ProfName}</td>";
								// echo "<td class='span2'>
										// <a class='btn btn-mini btn-success' 
										// href='profblock2main.php?blockid={$blockid}&blockname={$blockname}&examdate={$tmpexamdate}&examslot={$tmpexamslot}'>
										// <i class='icon-ok icon-white'></i>&nbsp;&nbsp;show profs.</a>
									  // </td>";
								// echo "</tr>";
						// }
						
						if ($mysqli->multi_query("call sp_getrelccs(@i_examid,@i_examdate,@i_examslot)"))
						{
							//$show_results = true;
							//$rs = array();
							do {
								// Lets work with the first result set
								if ($result = $mysqli->use_result())
								{
									// Loop the first result set, reading it into an array
									while ($row = $result->fetch_array(MYSQLI_ASSOC))
									{
										extract($row);
										echo "<tr class='odd gradex'>";
										echo "<td>$i</td>";
										echo "<td>{$BlockName}</td>";
										echo "<td class='span2'>
												<a class='btn btn-mini btn-success' 
												href='profblock2Main.php?BlockID={$BlockID}&BlockName={$BlockName}&ExamDate={$tmpExamDate}&ExamSlot={$tmpExamSlot}'>
												<i class='icon-ok icon-white'></i>&nbsp;&nbsp;show profs.</a>
											  </td>";
										echo "<td>{$ProfName}</td>";
										echo "</tr>";
										$i += 1;
									}
									// Close the result set
									$result->close();
								}
							} while ($mysqli->next_result() && $mysqli->more_results());
						}
						else
						{
							echo 'fail';
						}
						
						
						
						// // // while($mysqli->more_results())
						// // // {
							// // // $mysqli->next_result();
							// // // //$discard = $mysqli->store_result();
							// // // while( $row = $mysqli->store_result() ) {
								// // // extract($row);
									// // // echo "<tr class='odd gradex'>";
									// // // echo "<td>{$BlockName}</td>";
									// // // echo "<td>{$ProfName}</td>";
									// // // echo "<td class='span2'>
											// // // <a class='btn btn-mini btn-success' 
											// // // href='profblock2main.php?blockid={$blockid}&blockname={$blockname}&examdate={$tmpexamdate}&examslot={$tmpexamslot}'>
											// // // <i class='icon-ok icon-white'></i>&nbsp;&nbsp;show profs.</a>
										  // // // </td>";
									// // // echo "</tr>";
							// // // }
						// // // }
						
						//------------------------------------------------------------------
						// $stmt = db2_exec($mysqli, 'CALL SP_GETRELCCs(?,?,?)');
						// mysqli_stmt_bind_param($stmt, 'iss', $_SESSION["SESSSelectedExam"], $tmpExamDate, $tmpExamSlot);
						  // print "Fetching first result set\n";
						  // while ($row = db2_fetch_array($stmt)) {
							// var_dump($row);
						  // }

						  // print "\nFetching second result set\n";
						  // $res = db2_next_result($stmt);
						  // if ($res) {
							// while ($row = db2_fetch_array($res)) {
							  // var_dump($row);
							// }
						  // }

						  // print "\nFetching third result set\n";
						  // $res2 = db2_next_result($stmt);
						  // if ($res2) {
							// while ($row = db2_fetch_array($res2)) {
							  // var_dump($row);
							// }
						  // }

						  // db2_close($conn);
						
						
						
						
						
						
						// $stmt = mysqli_prepare($mysqli, 'CALL SP_GETRELCCs(?, ?, ?)');
						// mysqli_stmt_bind_param($stmt, 'iss', $_SESSION["SESSSelectedExam"], $tmpExamDate, $tmpExamSlot);
						// mysqli_stmt_execute($stmt);
						// // fetch the first result set
						// $result1 = mysqli_use_result($mysqli);
						// // you have to read the result set here 
						// while ($row = $result1->fetch_assoc()) {
							// printf("%d\n", $row['id']);
						// }
						// // now we're at the end of our first result set.
						// mysqli_free_result($result1);

						// //move to next result set
						// mysqli_next_result($mysqli);
						// $result2 = mysqli_use_result($mysqli);
						// // you have to read the result set here 
						// while ($row = $result2->fetch_assoc()) {
							// printf("%d\n", $row['BlockName']);
						// }
						// // now we're at the end of our second result set.
						// mysqli_free_result($result2);

						// // close statement
						// mysqli_stmt_close($stmt);
						
						
						
						// // // // // // // // // Check our query results
						// // // // // // // // if ($mysqli->multi_query("CALL SP_GETRELCCs(@i_ExamId,@i_ExamDate,@i_ExamSlot)"))
						// // // // // // // // {
							// // // // // // // // do {
								// // // // // // // // // Lets work with the first result set
								// // // // // // // // if ($result = $mysqli->use_result())
								// // // // // // // // {
									// // // // // // // // // Loop the first result set, reading it into an array
									// // // // // // // // while ($row = $result->fetch_array(MYSQLI_ASSOC))
									// // // // // // // // {
										// // // // // // // // echo "<td>{$BlockName}</td>";
									// // // // // // // // }
									// // // // // // // // // Close the result set
									// // // // // // // // $result->close();
								// // // // // // // // }
							// // // // // // // // } while ($mysqli->next_result());
						// // // // // // // // }
						// // // // // // // // else
						// // // // // // // // {
							// // // // // // // // echo '<p>There were problems with your query [' . $sql . ']:<br /><strong>Error Code ' . $mysqli->errno . ' :: Error Message ' . $mysql->error . '</strong></p>';
						// // // // // // // // }
						//--------------------------------------------------------------------
						//disconnect from database
						//$result->free();
						$mysqli->close();

					}
				?>



			</table>
        </div>
	</div>
	<div class="clear"></div>
