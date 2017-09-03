
<form action="welcome.php" method="post">
	<br /><br />	<br />
	<h3 class="page-title">Exam Main - <?php if(!isset($_SESSION)){ session_start(); } echo $_SESSION["SESSSelectedExamName"]; ?></h3>
	<h3 class="page-title" style="float:right;margin-top:-40px;"><a href="MainMenuMain.php">Back</a></h3>
	<br />
	
	<div class="row-fluid">
		<div class="span10">
			<div class="metro-nav  report_sec">
				<?php
				if(!isset($_SESSION)){
					session_start();
				}
				include 'db/db_connect.php';
				if($_SESSION["usertype"] == 'SuperAdmin')
							$query = "SELECT distinct ScreenName,Screenpage,ScreenStyle
							FROM tblscreenmaster SM
							INNER JOIN tblrolescreens RS ON RS.ScreenID = SM.ScreenID 
							where Coalesce(Showonexamindex,0) = 1 
							order by SM.ScreenID";
				else
					$query = "SELECT ScreenName,Screenpage,ScreenStyle
							FROM tblscreenmaster SM
							INNER JOIN tblrolescreens RS ON RS.ScreenID = SM.ScreenID 
							AND RS.ReadAccess = 'Yes'
							INNER JOIN tblrolemaster RM ON RM.RoleiD = RS.RoleID AND 
							RoleName = '" . $_SESSION["usertype"] . "' 
							 and Coalesce(Showonexamindex,0) = 1 
							order by SM.ScreenID";
							//ReadAccess = 'Yes'
							//AND RoleID = " . $_SESSION["usertype"] .
				//echo $query;
				//die;
				$result = $mysqli->query( $query );
				$num_results = $result->num_rows;
				if( $num_results ){
					while( $row = $result->fetch_assoc() ){
						extract($row);
						echo "<div class='metro-nav-block ";
						echo $ScreenStyle;
						echo "'><a href='";
						echo $Screenpage;
						echo "'><div class='status'>";
						echo $ScreenName;
						echo "</div></a></div>";
					}
				}
				?>
				<div></div>
			</div>
		
		
			<!--
			<div class="metro-nav  report_sec">
				<div class='metro-nav-block p_t'><a href='ExamScheduleMain.php'>
					<div class="status">Exam Schedule</div></a>
				</div>
				<div class='metro-nav-block p_t'><a href='UploadExamFileMain.php'>
					<div class="status">Upload Exam File</div></a>
				</div>
				<div class='metro-nav-block p_type'><a href='SelectPaperBlockMain.php'>
					<div class="status">Block Paper Allocation</div></a>
				</div>
				<div class='metro-nav-block tax_id'><a href='ProfPrefReportMain.php'>
					<div class="status">Professor Preferences</div></a>
				</div>
				<div class='metro-nav-block p_t'><a href='AllReportsMain.php'>
					<div class="status">All Reports</div></a>
				</div>
				<div class='metro-nav-block comodity'><a href='unassignedPeonMain.php'>
					<div class="status">Peon Allocation<br/><br/></div></a>
				</div>
				<div class='metro-nav-block p_type'><a href='profblockreportMain.php'>
					<div class="status">Prof-Block Allocation Report<br/><br/></div></a>
				</div>
				<div class='metro-nav-block p_t'><a href='UploadResultFileMain.php'>
					<div class="status">Upload University Results</div></a>
				</div>
				<div class='metro-nav-block p_type'><a href='OIResultUploadMain.php'>
					<div class="status">Upload Online / In-sem Results</div></a>
				</div>
				<div></div>
				<div class='metro-nav-block p_t'><a target='_blank' href='JrSupReport.php'>
					<div class="status">Jr. Sup. Duty Report</div></a>
				</div>
				<div></div>
				<div></div>
			</div>
			-->
		</div>
    </div>

</form>
