<?php
//include database connection
	include 'db/db_connect.php';
	$sql = "SELECT AcadYearFrom,AcadYearTo,Sem  FROM tblexammaster 
			where examid = " . $_SESSION["SESSCAPSelectedExam"];
	$result1 = $mysqli->query( $sql );
	while( $row = $result1->fetch_assoc() ) {
		extract($row);
		$_SESSION["SESSCAPAcadFrom"] = $AcadYearFrom;		
		$_SESSION["SESSCAPAcadTo"] = $AcadYearTo;		
		$_SESSION["SESSCAPAcadSem"] = $Sem;		
	}
?>

<form action="" method="post">
	<script>
		function sendtoprof() {
			window.location.href = 'proflistMain.php';
							
		};
		function sendtoexamassignment() {
			window.location.href = 'examinerassignMain.php';
							
		};
		function sendtocapaccess() {
			window.location.href = 'CAPaccess_PRORMain.php';
							
		};
		function sendtostudview() {
			window.location.href = 'studentviewMain.php';
							
		};
	</script>
	<br /><br />
	<h3 class="page-title" style="margin-left:5%">Examiner Assignment - <?php if(!isset($_SESSION)){ session_start(); } echo $_SESSION["SESSCAPSelectedExamName"]; ?></h3>
	<h3 class="page-title" style="float:right;margin-top:-40px;"><a href="capmasterMain.php">Back</a></h3>
	<br/>
	<div class="row-fluid" style="margin-left:5%">
		<div class="span10">
			<div class="metro-nav  report_sec">
				<div class="metro-nav-block p_t">
					<a  onclick="sendtoprof();" href="#"><div class="status">Examiner Assignment - Theory</div></a>
				</div>
				<div class="metro-nav-block p_type">
					<a  onclick="sendtofeecol();" href="#"><div class="status">Cap Reports</div></a>
				</div>
				<div class="metro-nav-block comodity">
					<a  onclick="sendtofeecol();" href="#"><div class="status">DAY Reports</div></a>
				</div>
				<div class="metro-nav-block p_type">
					<a  href="StudentqueDownloadMain.php"><div class="status">Marks Summary</div></a>
				</div>
				<div class="metro-nav-block comodity">
					<a  href="InSemReportMain.php"><div class="status">Marks Report - Theory</div></a>
				</div>
				<div class="metro-nav-block p_t">
					<a  href="CAPaccessMain.php"><div class="status">CAP Access - Theory</div></a>
				</div>
				<div class="metro-nav-block p_t">
					<a  onclick="sendtoexamassignment();" href="#"><div class="status">Examiner Assignment - PR / OR</div></a>
				</div>
				<div class="metro-nav-block p_type">
					<a  onclick="sendtocapaccess();" href="#"><div class="status">CAP Access - PR / OR</div></a>
				</div>
				<div class="metro-nav-block comodity">
					<a  onclick="sendtostudview();" href="#"><div class="status">Student View Access</div></a>
				</div>
				<div class="metro-nav-block p_t">
					<a  target='_blank' href="ViewInsemMarksAll.php"><div class="status">All Marks Report</div></a>
				</div>
				<div class="metro-nav-block comodity">
					<a   href="InSemReportPRORMain.php"><div class="status">Marks Report - PR / OR / TW</div></a>
				</div>
				<div class="metro-nav-block p_t">
					<a href="autoraMain.php"><div class="status">ESE Result Analysis</div></a>
				</div>
				<div class="metro-nav-block p_type">
					<a  href="InSemReportAllMain.php"><div class="status">Provisional Marksheet</div></a>
				</div>
				<div class="metro-nav-block p_t">
					<a  href="RevalMarksMain.php"><div class="status">Enter Reval Marks</div></a>
				</div>

			</div>
		</div>
	</div>
	<div class="row-fluid">
		<div style="margin-left:5%">
		</div>
	</div>
</form>

