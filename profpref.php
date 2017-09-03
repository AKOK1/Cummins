<form action="ProfPrefMain.php" method="post">
	<?php
		if(!isset($_SESSION)){
			session_start();
		}
		include 'db/db_connect.php';
		//Get the prof view setting
		$hasprefenabled = 0;
		$sql = "SELECT 1 as examid FROM tblexammaster WHERE CURRENT_TIMESTAMP BETWEEN PubStart AND PubEnd and 
				examid = " . $_SESSION["SESSSelectedExam"] ;
		// execute the sql query
		$result = $mysqli->query( $sql );
		$num_results = $result->num_rows;
		 if( $num_results ){
			 while( $row = $result->fetch_assoc() ){
				extract($row);
				$hasprefenabled = $examid;
			}
		 }		

		 if($hasprefenabled == 0)
		 {

					header('Location: PrintPreference2.php'); 
					exit();
		}
		 if (isset($_POST['btnSavePref']))
		{
			$minduties = 0;
			if ($_SESSION["SESSSelectedExamType"] ==  'Online') {
				//check 
				include 'db/db_connect.php';
				$sql = "SELECT ProfID FROM tblprofessorpref pp 
								INNER JOIN tblexammaster em ON pp.ExamID = em.ExamID
								WHERE pp.ExamID = " .  $_SESSION["SESSSelectedExam"] . "  
								and ProfId = " . $_SESSION["SESSUserID"] . "
								GROUP By ProfID,MinPrefCount
								Having count(*) >= MinPrefCount"	 ;
						$result = $mysqli->query( $sql );
						$minduties = $result->num_rows;
			}
			else{
				include 'db/db_connect.php';
				$mysqli->query("SET @i_ProfId  = " . $_SESSION["SESSUserID"] . "");
				$mysqli->query("SET @i_ExamId   = " .  $_SESSION["SESSSelectedExam"] . "");
				$result1 = $mysqli->query("CALL SP_SAVEPROFPREF(@i_ProfId,@i_ExamId)");
				while( $row = $result1->fetch_assoc() ) {
					extract($row);
					$minduties = $SAVESTATUS;
				}
			}
			If($minduties == 0)
			{
				if ($_SESSION["SESSSelectedExamType"] ==  'Online') {
					echo "<script type='text/javascript'>window.onload = function()
					{
						document.getElementById('lblFailure').innerText = 'Please select minimuim slots as per the requirement.';
						document.getElementById('lblFailure').style.display = 'block';
					}
					</script>";
				}
				else
				{
					echo "<script type='text/javascript'>window.onload = function()
					{
						document.getElementById('lblFailure').style.display = 'block';
					}
					</script>";
				}
			}
			else
			{
				echo "<script type='text/javascript'>window.onload = function()
				{
						document.getElementById('lblSuccess').style.display = 'block';
						window.open('PrintPreference.php');
				}
				</script>";
				//header('Location: PrintPreference.php'); 
				
			}
			//echo "PrintDay.php?ExamDate=" . $_POST['ddlDate'] . "&ExamSlot=" . $_POST['ddlExamDateSlot'] ; 
		}
		
		echo "<br /><br />";
		echo "<h3 class='page-title'>Supervisor Slot Selection</h3>";
		echo "<h3 class='page-title' style='float:right;margin-top:-40px;'>";
		echo"<a href='MainMenuMain.php'>Back</a>";
		echo "</h3>";
		include 'db/db_connect.php';
		$sql = "SELECT  Concat(FirstName, ' ', LastName) as Name FROM tbluser WHERE userID  = " .$_SESSION["SESSUserID"] . ""	 ;
		$result = $mysqli->query( $sql );
		$num_results = $result->num_rows;
		if( $num_results ){
			while( $row = $result->fetch_assoc() ){
				extract($row);
				echo "<div style='float:left;margin-left:10px'><label><b style='font-size:large'>Professor: </b>{$Name}</label></div><br/><br/>";
				break;
			}
		}		
				
?>		

	<div style="margin-left:10px;margin-top:10px">
	<?php
		include 'db/db_connect.php';
					
		$sql = "SELECT  satcount,evecount,MinPrefCount,MaxPrefCount FROM tblexammaster WHERE ExamID  = " .$_SESSION["SESSSelectedExam"] . ""	 ;
		$result = $mysqli->query( $sql );
		$num_results = $result->num_rows;
		if( $num_results ){
			while( $row = $result->fetch_assoc() ){
				extract($row);
				if(($satcount <> 0) || ($evecount <> 0)){
					echo "<div style='float:left;margin-left:10px'><label><b style='font-size:large'>Mandatory Slots:";
					if($satcount <> 0)
						echo "{$satcount} Saturdays.";
					if($evecount <> 0)
						echo " {$evecount} Evenings.";
				}
				//echo "<div style='float:left;margin-left:10px'><label><b style='font-size:large'>Mandatory Slots: //{$satcount} Saturdays, {$evecount} evenings. 
				echo " Minimum: {$MinPrefCount}. Maximum: {$MaxPrefCount}. </b> <br/> ";
if ($_SESSION["SESSSelectedExamType"] !=  'Online') {
echo "Select an additional evening, if Saturdays are not seen.</label></div>";
}
else{
	
}
				/*
				echo "<div style='float:left;margin-left:10px'><label><b style='font-size:large'>Mandatory Slots: {$satcount} Saturdays, {$evecount} evenings, 1 morning. Minimum: {$MinPrefCount}. Maximum: {$MaxPrefCount}. </b> <br/> Select an additional evening, if Saturdays are not seen.</label></div>";
				*/
				break;
			}
		}					
			
		 
		//disconnect from database
		$result->free();
		$mysqli->close();
	

	?>
		<div style="float:left;">
			<input type="submit" name="btnSavePref" value="Save & Print My Preferences" title="Update" class="btn btn-success" />
		</div>
	</div>
	<br/>
		<div><center>
			<label id="lblFailure" style="margin-left:10px;color:red;display:none;font-size:large" >Please select Saturdays, Evenings and Total Slots as per the requirement.</label>
			<label id="lblSuccess" style="margin-left:10px;color:green;display:none" >Saved successfully.</label>
			</center>
		</div>
	<br/>
	<br/>
            <br />
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
					//if ($_SESSION["SESSSelectedExamType"] ==  'Online') {
						//$result = $mysqli->query("CALL SP_GETPROFPREFONLINE(@i_ProfId,@i_ExamId)");
						$sql = "select A.PCOUNT,MaxPrefCount from 
								(SELECT count(*) as PCOUNT
								FROM tblprofessorpref 
								where ProfID = " . $_SESSION["SESSUserID"] . "
								and ExamID = " .  $_SESSION["SESSSelectedExam"] . "
								) as A,
								(select MaxPrefCount from tblexammaster
								WHERE ExamID = " .  $_SESSION["SESSSelectedExam"] . "
								) as B";

						//echo $sql;
						$result = $mysqli->query( $sql );
						$num_results = $result->num_rows;
						if( $num_results ){
						while( $row = $result->fetch_assoc() ){
							extract($row);
								if( $PCOUNT < $MaxPrefCount){
if ($_SESSION["SESSSelectedExamType"] ==  'Online') {
									$sql = "SELECT A.ExamDate, A.ExamDateT,A.ExamSlot,A.ExamDay
									FROM
									(
									SELECT DISTINCT ExamDate, 
									DATE_FORMAT(STR_TO_DATE(ExamDate,'%m/%d/%Y'), '%d %M %Y') AS ExamDateT, 
									DAYNAME(STR_TO_DATE(ExamDate,'%m/%d/%Y')) AS ExamDay, 
									SUBSTRING(BlockName,LOCATE('@',BlockName)+1) as ExamSlot,
									COUNT(EB.ExamBlockID) AS ACOUNT
									FROM tblblocksmaster BM 
									INNER JOIN tblexamblock EB ON BM.blockid = EB.blockid  
									INNER JOIN tblexamschedule ES ON EB.ExamSchID = ES.ExamSchID 
									INNER JOIN tblexammaster em ON ES.ExamID = em.ExamID
									WHERE  em.ExamID = " .  $_SESSION["SESSSelectedExam"] . "
									GROUP BY ExamDate,SUBSTRING(BlockName,LOCATE('@',BlockName)+1)
									ORDER BY CAST(BM.BlockNo AS UNSIGNED)
									) AS A
									LEFT OUTER JOIN 
									(SELECT ExamDAte,ExamSLot,COUNT(*)  AS BCOUNT
									FROM tblprofessorpref pp
									WHERE pp.ExamID = " .  $_SESSION["SESSSelectedExam"] . " 
									GROUP BY ExamDAte,ExamSLot
									) AS B ON A.ExamDate = B.ExamDate AND A.ExamSlot = B.ExamSlot
									WHERE (COALESCE(A.ACOUNT,0) - COALESCE(B.BCOUNT,0) > 0)
									order by A.ExamDate,A.ExamSlot
									;";
									$result = $mysqli->query( $sql );				
}
else
{
					$mysqli->query("SET @i_ProfId  = " . $_SESSION["SESSUserID"] . "");
					$mysqli->query("SET @i_ExamId   = " .  $_SESSION["SESSSelectedExam"] . "");
					$result = $mysqli->query("CALL SP_GETPROFPREF(@i_ProfId,@i_ExamId)");				

}

//echo $sql;
//and ProfId = " . $_SESSION["SESSUserID"] . ")
//SUBSTRING(BlockName,LOCATE('@',BlockName)+1) AS 

									if(isset($result->num_rows))
									{
										$num_results = $result->num_rows;
										if( $num_results ){
											while( $row = $result->fetch_assoc() ){
												extract($row);
												echo "<TR class='odd gradeX'>";
												echo "<td>{$ExamDateT} </td>";
												echo "<td>{$ExamDay} </td>";
												echo "<td>{$ExamSlot} </td>";
												echo "<td class='span3'><a class='btn btn-mini btn-success' href='ProfPrefUpd.php?IUD=U&ExamDate={$ExamDate}&ExamSlot={$ExamSlot}'>
																		<i class='icon-ok icon-white'></i>&nbsp&nbspBook</a>
													  </td>";
												echo "</TR>";
											}
										}											
										$result->free();
									}

									//disconnect from database
									$mysqli->close();
								}			
							}
						}
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
							WHERE ProfId = ".$_SESSION["SESSUserID"]." AND ExamId = " .$_SESSION["SESSSelectedExam"]. ""	 ;
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
							echo "<td class='span3'><a class='btn btn-mini btn-danger' href='ProfPrefUpd.php?IUD=D&ProfPrefID={$ProfPrefID}'>
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

