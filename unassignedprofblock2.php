<?php
		if(!isset($_SESSION)){
			session_start();
		}
		include 'db/db_connect.php';
		if (isset($_GET['ProfID']))
		{
			$_SESSION["SESSUnAssProfID"] = $_GET['ProfID'];
		}
		if (isset($_GET['ProfName']))
		{
			$_SESSION["SESSUnAssProf"] = $_GET['ProfName'];
		}
		if (isset($_POST['btnSavePref']))
		{
			$mysqli->query("SET @i_ProfId  = " . $_SESSION["SESSUnAssProfID"] . "");
			$mysqli->query("SET @i_ExamId   = " .  $_SESSION["SESSSelectedExam"] . "");
			$result1 = $mysqli->query("CALL SP_SAVEPROFPREF(@i_ProfId,@i_ExamId)");
			while( $row = $result1->fetch_assoc() ) {
				extract($row);
				If($SAVESTATUS == 0)
					{
						echo "<script type='text/javascript'>window.onload = function()
						{
							document.getElementById('lblFailure').style.display = 'block';
						}
						</script>";
					}
					else
					{
						echo "<script type='text/javascript'>window.onload = function()
						{
								document.getElementById('lblSuccess').style.display = 'block';
						}
						</script>";
						header('Location: PrintPreference.php?screen=unassigned');
					}
			}
			//echo "PrintDay.php?ExamDate=" . $_POST['ddlDate'] . "&ExamSlot=" . $_POST['ddlExamDateSlot'] ; 
		}
?>		
<form action="unassignedProfblock2Main.php" method="post">
	<br /><br />
	<h3 class="page-title">Admin Professor Block Allocation</h3>

	<?php
		if(isset($_GET['source'])){
				echo "<h3 class='page-title' style='float:right;margin-top:-40px;'><a href='ProfPrefReportMain.php'>Back</a></h3>";
/*			if( $_GET['source'] == 'report' ){
				echo "<h3 class='page-title' style='float:right;margin-top:-40px;'><a href='ProfPrefReportMain.php'>Back</a></h3>";
			}
			else{
				echo "<h3 class='page-title' style='float:right;margin-top:-40px;'><a href='unassignedProfBlockMain.php'>Back</a></h3>";
			}
*/
			}
		else
			echo "<h3 class='page-title' style='float:right;margin-top:-40px;'><a href='ProfPrefReportMain.php'>Back</a></h3>";
	?>
	
	
	<div style="margin-left:10px;margin-top:10px">
	<?php
		include 'db/db_connect.php';
		echo "<div style='float:left'><label><b>Selected Professor: </b>{$_SESSION['SESSUnAssProf']}</label></div>";
				
		$sql = "SELECT  satcount,evecount,MinPrefCount,MaxPrefCount FROM tblexammaster WHERE ExamID  = " .$_SESSION["SESSSelectedExam"] . ""	 ;
		$result = $mysqli->query( $sql );
		$num_results = $result->num_rows;
		if( $num_results ){
			while( $row = $result->fetch_assoc() ){
				extract($row);
			echo "<div style='float:left;margin-left:10px'><label><b style='font-size:large'>Mandatory Slots: {$satcount} Saturdays, {$evecount} evenings, 1 morning. Minimum: {$MinPrefCount}. Maximum: {$MaxPrefCount}</b></label></div>";
				break;
			}
		}					
		
		
		if($_SESSION["SESSSelectedExam"] == 0)
		 {
			 //check if profview is enabled...if yes...send to printpreferences
			$sql = "SELECT examid FROM tblexammaster WHERE ExamID = " . $_SESSION["SESSSelectedExam"] ." and  coalesce(ProfViewEnabled,0) = 1 limit 1" ;
			//echo $sql;
			$result = $mysqli->query( $sql );
			$num_results = $result->num_rows;
			 if( $num_results ){
				 while( $row = $result->fetch_assoc() ){
					extract($row);
					$_SESSION["SESSSelectedExam"] = $examid;
				}
			 }					
			if($_SESSION["SESSSelectedExam"] == 0){
				echo "<div style='float:left;margin-left:50px'><label><b>The Exam Schedule is not published yet.</b></label></div>";
				//die;
				return;
			}
			else
				header('Location: PrintPreference2.php'); 
		 }
		 
		//disconnect from database
		$result->free();
		$mysqli->close();
	

	?>
		<div style="float:left;margin-left:10px;margin-top:-5px">
			<input type="submit" name="btnSavePref" value="Save & Print Allocation" title="Update" class="btn btn-success" />
		</div>
	</div>
	<br/><br/>
		<div><center>
			<label id="lblFailure" style="margin-left:10px;color:red;display:none;font-size:large" >Please select Saturdays, Evenings and Total Slots as per the requirement.</label>
			<label id="lblSuccess" style="margin-left:10px;color:green;display:none" >Saved successfully.</label>
			</center>
		</div>
	<br/>
	<br/>
	<div class="row-fluid" style="margin-left:5%;margin-top:-15px">
	    <div class="span5 v_detail" style="overflow:scroll">
            <br />
            <br />
            <div style="float:left">
				<label><b>Available Slots</b></label>
            </div>
			<table cellpadding="10" cellspacing="0" border="0" width="100%" class="tab_split">
				<tr>
					<th>Exam Date</th>
					<th>Day</th>
					<th>Slot</th>
					<th width="10%"><strong>Action</strong></th>
				</tr>
				<?php
					include 'db/db_connect.php';
			
					//$sql = "SP_GETPROFPREF";
					// Prepare IN parameters
					if($_SESSION["SESSSelectedExamType"] ==  'Online'){
						$sql = "SELECT A.ExamDate, A.ExamDateT,A.ExamSlot,A.ExamDay
								FROM
								(
								SELECT DISTINCT ExamDate, 
								DATE_FORMAT(STR_TO_DATE(ExamDate,'%m/%d/%Y'), '%d %M %Y') AS ExamDateT, 
								DAYNAME(STR_TO_DATE(ExamDate,'%m/%d/%Y')) AS ExamDay, SUBSTRING(BlockName,LOCATE('@',BlockName)+1) AS ExamSlot,
								COUNT(EB.ExamBlockID) AS ACOUNT
								FROM tblblocksmaster BM 
								INNER JOIN tblexamblock EB ON BM.blockid = EB.blockid 
								INNER JOIN tblexamschedule ES ON EB.ExamSchID = ES.ExamSchID 
								INNER JOIN tblexammaster em ON BM.ExamID = em.ExamID
								WHERE em.ExamID = " .  $_SESSION["SESSSelectedExam"] . "
								And concat(ExamDate,SUBSTRING(BlockName,LOCATE('@',BlockName)+1)) not in (select Concat(ExamDate,ExamSlot) from tblprofessorpref where 
								ExamID = " .  $_SESSION["SESSSelectedExam"] . " 
								and ProfID = " . $_SESSION["SESSUnAssProfID"] . ")
								GROUP BY ExamDate,SUBSTRING(BlockName,LOCATE('@',BlockName)+1)
								ORDER BY CAST(BM.BlockNo AS UNSIGNED)
								) AS A
								LEFT OUTER JOIN 
								(SELECT ExamDAte,ExamSLot,COUNT(*)  AS BCOUNT
								FROM tblprofessorpref 
								WHERE ExamID = " .  $_SESSION["SESSSelectedExam"] . " 
								GROUP BY ExamDAte,ExamSLot) AS B ON A.ExamDate = B.ExamDate AND A.ExamSlot = B.ExamSlot
								WHERE COALESCE(A.ACOUNT,0) - COALESCE(B.BCOUNT,0) > 0
								Order by A.ExamDate,A.ExamSlot;";
						//echo $sql;
						$result = $mysqli->query( $sql );
					}
						//$result = $mysqli->query("CALL SP_GETPROFPREFONLINE(@i_ProfId,@i_ExamId)");
					else{
						$mysqli->query("SET @i_ProfId  = " . $_SESSION["SESSUnAssProfID"] . "");
						$mysqli->query("SET @i_ExamId   = " .  $_SESSION["SESSSelectedExam"] . "");
						$result = $mysqli->query("CALL SP_GETPROFPREF(@i_ProfId,@i_ExamId)");
					}
						
					if(isset($result->num_rows))
					{
						$num_results = $result->num_rows;
						//echo $num_results;

						if( $num_results ){
							while( $row = $result->fetch_assoc() ){
								extract($row);
								echo "<TR class='odd gradeX'>";
								echo "<td>{$ExamDateT} </td>";
								echo "<td>{$ExamDay} </td>";
								echo "<td>{$ExamSlot} </td>";
								echo "<td class='span3'><a class='btn btn-mini btn-success' href='ProfPrefUpd.php?IUD=U&ExamDate={$ExamDate}&ExamSlot={$ExamSlot}&screen=unassigned&ProfID={$_SESSION['SESSUnAssProfID']}&ProfName={$_SESSION['SESSUnAssProf']}'>
														<i class='icon-ok icon-white'></i>&nbsp&nbspBook</a>
									  </td>";
								echo "</TR>";
							}
						}											
						$result->free();
					}

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
            <br/>
            <br/>
            <div style="float:left;">
				<label><b>Your Choices</b></label>
            </div>
			<br/><br/><br/><br/>
			<table style="margin-top:-45px" cellpadding="10" cellspacing="0" border="0" width="90%" class="tab_split">
				<tr>
					<th>Exam Date</th>
					<th>Day</th>
					<th>Slot</th>
					<th width="10%"><strong>Action</strong></th>
				</tr>
				<?php
					include 'db/db_connect.php';
					$sql = "SELECT  distinct ProfPrefID, 
							DATE_FORMAT(STR_TO_DATE(ExamDate,'%m/%d/%Y'), '%d %M %Y') AS ExamDateT, 
							DAYNAME(STR_TO_DATE(ExamDate,'%m/%d/%Y')) AS ExamDay, ExamSlot
							FROM tblprofessorpref 
							WHERE ProfId = ".$_SESSION["SESSUnAssProfID"]." AND ExamId = " .$_SESSION["SESSSelectedExam"]. ""	 ;
					//echo $sql;
					// execute the sql query
					$result = $mysqli->query( $sql );
					$num_results = $result->num_rows;

					if( $num_results ){
						while( $row = $result->fetch_assoc() ){
							extract($row);
							echo "<TR class='odd gradeX'>";
							echo "<td>{$ExamDateT} </td>";
							echo "<td>{$ExamDay} </td>";
							echo "<td>{$ExamSlot} </td>";
							echo "<td class='span3'><a class='btn btn-mini btn-danger' href='ProfPrefUpd.php?IUD=D&ProfPrefID={$ProfPrefID}&screen=unassigned&ProfID={$_SESSION['SESSUnAssProfID']}&ProfName={$_SESSION['SESSUnAssProf']}'>
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

