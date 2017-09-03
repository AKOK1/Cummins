
<form action="welcome.php" method="post">
	<br /><br />	<br />
	<h3 class="page-title">Exam Main - <?php if(!isset($_SESSION)){ session_start(); } echo $_SESSION["SESSSelectedExamName"]; ?></h3>
	<h3 class="page-title" style="float:right;margin-top:-40px;"><a href="MainMenuMain.php">Back</a></h3>
	<br />
	
	<div class="row-fluid">
		<div class="span10">
			<div class="metro-nav  report_sec">
				<div class='metro-nav-block p_t'><a href='ExamScheduleOMain.php'>
					<div class="status">Exam Schedule</div></a>
				</div>
				<div class='metro-nav-block p_type'><a href='SelectPaperBlockMainO.php'>
					<div class="status">Block Paper Allocation</div></a>
				</div>
				<div class='metro-nav-block comodity'><a href='ProfBlockMain.php'>
					<div class="status">Allocate Professor to Blocks</div></a>
				</div>
				<div class='metro-nav-block comodity'><a href='unassignedProfBlockMain.php'>
					<div class="status">Unassigned Professors<br/><br/></div></a>
				</div>
				<div class='metro-nav-block tax_id'><a href='ProfPrefReportMain.php'>
					<div class="status">Professor Preferences</div></a>
				</div>
				<div class='metro-nav-block p_t'><a href='DayReportMain.php'>
					<div class="status">Day Report</div></a>
				</div>
				<div class='metro-nav-block comodity'><a href='unassignedPeonMain.php'>
					<div class="status">Peon Allocation<br/><br/></div></a>
				</div>
				<div class='metro-nav-block p_type'><a href='profblockreportMain.php'>
					<div class="status">Prof-Block Allocation Report<br/><br/></div></a>
				</div>
			</div>
		</div>
    </div>

</form>
