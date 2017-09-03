<?php
		if(!isset($_SESSION)){
			session_start();
		}
		include 'db/db_connect.php';
		//$sql = "SELECT examid FROM tblexammaster WHERE CURRENT_TIMESTAMP BETWEEN STR_TO_DATE(PubStart,'%m/%d/%Y') AND STR_TO_DATE(PubEnd,'%m/%d/%Y') limit 1;" ;
		$sql = "SELECT examid FROM tblexammaster WHERE CURRENT_TIMESTAMP BETWEEN PubStart AND PubEnd limit 1;" ;
		// execute the sql query
		$result = $mysqli->query( $sql );
		$num_results = $result->num_rows;
		 if( $num_results ){
			 while( $row = $result->fetch_assoc() ){
				extract($row);
				$_SESSION["SESSSelectedExam"] = $examid;
			}
		 }					
?>		
<form action="profblock2Main.php" method="post">
	<br /><br />
	<h3 class="page-title">Professor Block Allocation</h3>
	<h3 class="page-title" style="float:right;margin-top:-46px;">
	<?php echo "<a href='ProfBlockMain.php?ExamDate={$_GET['ExamDate']}&ExamSlot={$_GET['ExamSlot']}'>Back</a>"; ?>
	</h3>

	<div style="margin-left:10px;margin-top:10px">
	<div style="float:left">
	<?php
		if(!isset($_SESSION)){
			session_start();
		}
		include 'db/db_connect.php';
		echo '
						<table class="table table-condensed table-bordered neutralize">     
							<tbody>
								<tr>
									<td><b>Selected Block</td><td>'.$_GET['BlockName'] .'</td>
					';
		$papername = '';
		$i = 0;
		if(($_GET['BlockID'] != '1000') AND $_GET['BlockID'] != '2000'){
			$sql = "SELECT CONCAT(DeptName,' - ',SubjectName) AS  PaperInfo
					FROM tblexamblock eb
					LEFT JOIN tblblocksmaster bm ON eb.BlockID = bm.BlockID 
					LEFT JOIN tblexamschedule es ON eb.ExamSchID = es.ExamSchID 
					LEFT JOIN tblpapermaster pm ON eb.PaperID = pm.PaperID
					LEFT JOIN tblsubjectmaster sm ON pm.SubjectID = sm.SubjectID
					LEFT JOIN tbldepartmentmaster dm ON dm.DeptID = pm.DeptID
					WHERE es.ExamID = " . $_SESSION["SESSSelectedExam"] . "
					AND eb.BlockID = " . $_GET['BlockID'] ." 
					AND es.ExamDate = '".$_GET['ExamDate']."' AND ExamSlot = '".$_GET['ExamSlot']."' ;" ;
			//echo $sql;
			// execute the sql query
			$result = $mysqli->query( $sql );
			$num_results = $result->num_rows;
			 if( $num_results ){
				 while( $row = $result->fetch_assoc() ){
					extract($row);
					$papername .= '<td>'.$PaperInfo.'</td>';
					$i++;
					//echo "<b>{$PaperInfo}</b><br/>";
				}
				echo '
									<td><b>Selected Papers</td>'.$papername .'
								</tr>
							</tbody>
						</table>
					';
			 }					
		}
		else{
				echo '
						<table class="table table-condensed table-bordered neutralize">     
							<tbody>
								<tr>
									<td>Selected Slot:' .$_GET['ExamDate']. ',' . $_GET['ExamSlot'] . '</td>
								</tr>
							</tbody>
						</table>';
			
		}
	?>
	</div>
	</div>
	<br/><br/><br/><br/>
		<div><center>
			<label id="lblFailure" style="margin-left:10px;color:red;display:none;font-size:large" >Please select Saturdays, Evenings and Total Slots as per the requirement.</label>
			<label id="lblSuccess" style="margin-left:10px;color:green;display:none" >Saved successfully.</label>
			</center>
		</div>
	<br/>
	<br/>
	<div class="row-fluid" style="margin-left:5%;margin-top:-15px">
	    <div class="span5 v_detail" style="overflow:scroll">
            <div style="float:left">
				<label><b>Available Professors</b></label>
            </div>
			<table cellpadding="10" cellspacing="0" border="0" width="90%" class="tab_split">
				<tr>
					<th>Prof. Name</th>
					<th width="10%"><strong>Action</strong></th>
				</tr>
				<?php
						if(!isset($_SESSION)){
							session_start();
						}
					include 'db/db_connect.php';
			
					// $sql = "SELECT PP.ProfID, CONCAT(FirstName,' ',LastName,'-',Gender,'-',Department,'-',userType,COALESCE(Adhocenddate,'')) as ProfName
							// FROM tblprofessorpref PP , tbluser U
							// WHERE PP.ProfID = U.userID AND PP.ExamID = " . $_SESSION["SESSSelectedExam"] . "
							// AND ExamDate = '" . $_GET['ExamDate'] . "'
							// AND ExamSlot = '" . $_GET['ExamSlot'] . "'" ;
					
					if ($_SESSION["SESSSelectedExamType"] == 'Online') {
						$pos = strpos($_GET['BlockName'], '@');
						$Slot = substr($_GET['BlockName'], $pos+1);
						$sql = "SELECT PP.ProfID, 
								COALESCE(CONCAT(Department,' - ', FirstName,' ',LastName,' - ',Gender),'') AS ProfName 
								FROM tblprofessorpref PP , tbluser U 
								WHERE PP.ProfID = U.userID AND PP.ExamID = " . $_SESSION["SESSSelectedExam"] . " AND ExamDate = '" . $_GET['ExamDate'] . "' 
								AND ExamSlot = '" . $Slot . "'
								AND PP.ProfID NOT IN (
								SELECT COALESCE(ProfID ,0)
								FROM tblexamblock eb 
inner join tblexamschedule es on eb.ExamSchID = es.ExamSchID
inner join tblblocksmaster BM on BM.BlockID = eb.BlockID and 
BM.ExamID = es.ExamID and SUBSTRING(BlockName,LOCATE('@',BlockName)+1) = '" . $Slot . "'

								WHERE es.ExamID = " . $_SESSION["SESSSelectedExam"] . " 
								AND ExamDate = '" . $_GET['ExamDate'] . "') 
								AND PP.ProfID NOT IN 
								(SELECT COALESCE(ProfID ,0) FROM tblrelccduties PP , tbluser U 
								WHERE PP.ProfID = U.userID AND PP.ExamSchID IN (SELECT ExamSchID FROM tblexamschedule 
								WHERE ExamID = " . $_SESSION["SESSSelectedExam"] . "  AND 
								ExamDate = '" . $_GET['ExamDate'] . "' AND ExamSlot = '" . $_GET['ExamSlot'] . "'))
								order by Department;";
					}
					else {
						$sql = "SELECT PP.ProfID, 
								COALESCE(CONCAT(Department,' - ', FirstName,' ',LastName,' - ',Gender),'') AS ProfName 
								FROM tblprofessorpref PP , tbluser U 
								WHERE PP.ProfID = U.userID AND PP.ExamID = " . $_SESSION["SESSSelectedExam"] . " AND ExamDate = '" . $_GET['ExamDate'] . "' 
								AND ExamSlot = '" . $_GET['ExamSlot'] . "'
								AND PP.ProfID NOT IN (
								SELECT COALESCE(ProfID ,0)
								FROM tblexamblock eb , tblexamschedule es
								WHERE eb.ExamSchID = es.ExamSchID AND es.ExamID = " . $_SESSION["SESSSelectedExam"] . " 
								AND ExamDate = '" . $_GET['ExamDate'] . "' AND ExamSlot = '" . $_GET['ExamSlot'] . "') 
								AND PP.ProfID NOT IN 
								(SELECT COALESCE(ProfID ,0) FROM tblrelccduties PP , tbluser U 
								WHERE PP.ProfID = U.userID AND PP.ExamSchID IN (SELECT ExamSchID FROM tblexamschedule 
								WHERE ExamID = " . $_SESSION["SESSSelectedExam"] . "  AND 
								ExamDate = '" . $_GET['ExamDate'] . "' AND ExamSlot = '" . $_GET['ExamSlot'] . "'))
								order by Department;";
					}
					//echo $sql;
					// execute the sql query
					$result = $mysqli->query( $sql );
					$num_results = $result->num_rows;
						if( $num_results ){
							while( $row = $result->fetch_assoc() ){
								extract($row);
								echo "<TR class='odd gradeX'>";
								echo "<td>{$ProfName} </td>";
								echo "<td class='span3'><a class='btn btn-mini btn-success' href='profblock2upd.php?IUD=U&ProfID={$ProfID}&BlockID={$_GET['BlockID']}&BlockName={$_GET['BlockName']}&ExamDate={$_GET['ExamDate']}&ExamSlot={$_GET['ExamSlot']}'>
														<i class='icon-ok icon-white'></i>&nbsp&nbspAssign</a></td>";
								echo "</TR>";
							}
						}			
						else{
								echo "<TR class='odd gradeX'>";
								echo "<td>No Supervisors available. </td>";
								echo "<td class='span3'></td>";
								echo "</TR>";
						}								
						$result->free();
					
					//disconnect from database
					$mysqli->close();

				?>
				</table>
				
				<br />
        </div>

		<div class="span1 v_detail" style="overflow:hidden">
            <div style="margin-top:80px;margin-left:15px;float:left">
            <br />
            <br />
            <center>
				<br/>
				<br/>
				<br/>
				<br/>
				<br/>
				<br/>
				<br/>
				<br/>
            </center>
            </div>
        </div>
        
        <div class="span5 v_detail" style="overflow:hidden">
            <div style="float:left;">
				<label><b>Professor Block Assignment</b></label>
            </div>
			<br/><br/><br/><br/>
			<table style="margin-top:-45px" cellpadding="10" cellspacing="0" border="0" width="90%" class="tab_split">
				<tr>
					<th>Prof. Name</th>
					<th width="10%"><strong>Action</strong></th>
				</tr>
				<?php
					include 'db/db_connect.php';
					// $sql = "SELECT  distinct ProfPrefID, 
							// DATE_FORMAT(STR_TO_DATE(ExamDate,'%m/%d/%Y'), '%d %M %Y') AS ExamDateT, 
							// DAYNAME(STR_TO_DATE(ExamDate,'%m/%d/%Y')) AS ExamDay, ExamSlot
							// FROM tblprofessorpref 
							// WHERE ProfId = ".$_SESSION["SESSUserID"]." AND ExamId = " .$_SESSION["SESSSelectedExam"]. ""	 ;
							
					// $sql = "SELECT distinct eb.ProfID, 
							// COALESCE(CONCAT(Department,' - ', FirstName,' ',LastName,' - ',Gender),'') as ProfName 
							// FROM tblexamblock eb , tblexamschedule es, tbluser u
							// WHERE eb.ProfID = u.userID AND eb.ExamSchID = es.ExamSchID AND 
							// eb.BlockID = ". $_GET['BlockID'] . " and 
							// es.ExamID = " .$_SESSION["SESSSelectedExam"]. " AND ExamDate = '" . $_GET['ExamDate'] . "' 
							// AND ExamSlot = '" . $_GET['ExamSlot'] . "'";
						
					//echo $sql;
						$mysqli->query("set @i_BlockId   = " .  $_GET['BlockID'] . "");
						$mysqli->query("set @i_ExamId   = " .  $_SESSION["SESSSelectedExam"] . "");
						$mysqli->query("set @i_ExamDate   = '" .  $_GET['ExamDate'] . "'");
						$mysqli->query("set @i_ExamSlot   = '" .  $_GET['ExamSlot'] . "'");
						$result = $mysqli->query("call SP_ASSIGNEDPROFs(@i_BlockId,@i_ExamId,@i_ExamDate,@i_ExamSlot)");
						// execute the sql query
						$num_results = $result->num_rows;
						if( $num_results ){
							while( $row = $result->fetch_assoc() ){
								extract($row);
								echo "<TR class='odd gradeX'>";
								echo "<td>{$ProfName} </td>";
								echo "<td class='span3'><a class='btn btn-mini btn-danger' href='profblock2upd.php?IUD=D&ProfID={$ProfID}&BlockID={$_GET['BlockID']}&BlockName={$_GET['BlockName']}&ExamDate={$_GET['ExamDate']}&ExamSlot={$_GET['ExamSlot']}'>
														<i class='icon-remove icon-white'></i>&nbsp&nbspCancel</a>
										</td>";
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
	</form>

