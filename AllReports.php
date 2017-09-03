
<form action="welcome.php" method="post">
	<br /><br />	<br />
	<h3 class="page-title">Exam Reports - <?php if(!isset($_SESSION)){ session_start(); } echo $_SESSION["SESSSelectedExamName"]; ?></h3>
	<h3 class="page-title" style="float:right;margin-top:-40px;"><a href="ExamIndexMain.php">Back</a></h3>
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
							where Coalesce(Showonallreports,0) = 1 
							order by SM.ScreenID";
				else
					$query = "SELECT ScreenName,Screenpage,ScreenStyle
							FROM tblscreenmaster SM
							INNER JOIN tblrolescreens RS ON RS.ScreenID = SM.ScreenID 
							AND RS.ReadAccess = 'Yes'
							INNER JOIN tblrolemaster RM ON RM.RoleiD = RS.RoleID AND 
							RoleName = '" . $_SESSION["usertype"] . "' 
							 and Coalesce(Showonallreports,0) = 1 
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
				<div class='metro-nav-block p_t'><a href='TimeTableMain.php'>
					<div class="status">Time Table</div></a>
				</div>
				<div class='metro-nav-block p_t'><a href='DayReportMain.php'>
					<div class="status">Day Report</div></a>
				</div>
				<div></div>
			</div>
			-->
		</div>
    </div>

</form>
