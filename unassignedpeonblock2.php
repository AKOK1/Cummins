<?php
		if(!isset($_SESSION)){
			session_start();
		}
		include 'db/db_connect.php';
		if (isset($_GET['PeonID']))
		{
			$_SESSION["SESSUnAssPeonID"] = $_GET['PeonID'];
		}
		if (isset($_GET['PeonName']))
		{
			$_SESSION["SESSUnAssPeon"] = $_GET['PeonName'];
		}
		if (isset($_POST['btnSavePref']))
		{
			header('Location: PrintPeonDuties.php?screen=unassigned');
		}
?>		
<form action="unassignedPeonblock2Main.php" method="post">
	<br /><br />
	<h3 class="page-title">Peon Allocation</h3>

	<?php
		if(isset($_GET['source'])){
			if( $_GET['source'] == 'report' ){
				echo "<h3 class='page-title' style='float:right;margin-top:-40px;'><a href='unassignedPeonMain.php'>Back</a></h3>";
			}
			else{
				echo "<h3 class='page-title' style='float:right;margin-top:-40px;'><a href='unassignedPeonMain.php'>Back</a></h3>";
			}
		}
		else
			echo "<h3 class='page-title' style='float:right;margin-top:-40px;'><a href='unassignedPeonMain.php'>Back</a></h3>";
	?>
	
	
	<div style="margin-left:10px;margin-top:10px">
	<?php
		echo "<div style='float:left'><label><b>Selected Peon: </b>{$_SESSION['SESSUnAssPeon']}</label></div>";
	?>
		<div style="float:left;margin-left:10px;margin-top:-5px">
			<input type="submit" name="btnSavePref" value="Print Peon Allocation" title="Update" class="btn btn-success" />
		</div>
	</div>
	<br/><br/>
		<div><center>
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
					$mysqli->query("SET @i_PeonId  = " . $_SESSION["SESSUnAssPeonID"] . "");
					$mysqli->query("SET @i_ExamId   = " .  $_SESSION["SESSSelectedExam"] . "");
					$result = $mysqli->query("CALL SP_GETPEONPREF(@i_PeonId,@i_ExamId)");
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
								echo "<td class='span3'><a class='btn btn-mini btn-success' href='PeonPrefUpd.php?IUD=U&ExamDate={$ExamDate}&ExamSlot={$ExamSlot}&screen=unassigned&PeonID={$_SESSION['SESSUnAssPeonID']}&PeonName={$_SESSION['SESSUnAssPeon']}'>
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
				<label><b>Assigned Duties</b></label>
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
					$sql = "SELECT  distinct PeonPrefID, 
							DATE_FORMAT(STR_TO_DATE(ExamDate,'%m/%d/%Y'), '%d %M %Y') AS ExamDateT, 
							DAYNAME(STR_TO_DATE(ExamDate,'%m/%d/%Y')) AS ExamDay, ExamSlot
							FROM tblpeonpref 
							WHERE PeonId = ".$_SESSION["SESSUnAssPeonID"]." AND ExamId = " .$_SESSION["SESSSelectedExam"]. "
							ORDER BY ExamDateT,ExamSlot"	 ;
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
							echo "<td class='span3'><a class='btn btn-mini btn-danger' href='PeonPrefUpd.php?IUD=D&PeonPrefID={$PeonPrefID}&screen=unassigned&PeonID={$_SESSION['SESSUnAssPeonID']}&PeonName={$_SESSION['SESSUnAssPeon']}'>
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

