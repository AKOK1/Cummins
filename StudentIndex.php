<?php
		if(!isset($_SESSION)){
			session_start();
		}
		if ( ($_SESSION["usertype"] != 'student')){
			header('Location: login.php?');
		}
?>
<form action="welcome.php" method="post">
	<br /><br />	<br />
	<h3 class="page-title">Student Main</h3>
<!--	<h3 class="page-title" style="float:right;margin-top:-40px;"><a href="login.php">Back</a></h3> -->
	<br />
	
	<div class="row-fluid">
		<div class="span10">
			<div class="metro-nav  report_sec">
				<div class='metro-nav-block p_t'><a href='stdviewmain.php'>
					<div class="status">My Profile</div></a>
				</div>
				<?php 
						include 'db/db_connect.php';
						$_SESSION["STDGOOD"] = 'N';
						$sql = "SELECT  1 FROM tblstudent WHERE StdId = '" . $_SESSION["SESSStdId"] . "'
						and CASE WHEN COALESCE(Pmail,'') = '' THEN 'N' ELSE 'Y' END = 'Y' AND 
						CASE WHEN COALESCE(FirstName,'') = '' THEN 'N' ELSE 'Y' END  = 'Y' AND 
						CASE WHEN COALESCE(parent_name,'') = '' THEN 'N' ELSE 'Y' END = 'Y' AND 
						CASE WHEN COALESCE(unieli,'') = '' THEN 'N' ELSE 'Y' END = 'Y'";
						//echo $sql;
						$result = $mysqli->query( $sql );
						$num_results = $result->num_rows;
						if( $num_results ){
							while( $row = $result->fetch_assoc() ){
								extract($row);
								$_SESSION["STDGOOD"] = 'Y';
							}
						}

				if($_SESSION["STDGOOD"] == 'Y'){
						echo "<div class='metro-nav-block p_t'><a href='AcadsListMain.php'>
								<div class='status'>Academics</div></a>
								</div>";
					}
				?>
				<!--
				<div class='metro-nav-block p_t'><a href='ExamScheduleMain.php'>
					<div class="status">Academics</div></a>
				</div>
				<div class='metro-nav-block p_type'><a href='SelectPaperBlockMain.php'>
					<div class="status">Achievements</div></a>
				</div>
				<div class='metro-nav-block comodity'><a href='ProfBlockMain.php'>
					<div class="status">Reports</div></a>
				</div>
				-->
			</div>
		</div>
    </div>

</form>
