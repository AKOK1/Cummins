	<?php
		if(!isset($_SESSION)){
			session_start();
		}
	
		if(isset($_POST['ddldept'])){
			$_SESSION["capseldept"] = $_POST['ddldept'];
		}

		if(isset($_POST['ddlYear'])){
			$_SESSION["tmpselyear"] = $_POST['ddlYear'];
		}
?>		

<form action="ImportStudentsMain.php" method="post" onsubmit='showLoading();' enctype="multipart/form-data">
<body>

<?php
//include database connection
include 'db/db_connect.php';
// if the form was submitted/posted, update the record
	if(isset($_POST['ddlYear']) && ($_POST['ddlYear'] != ''))
	{
		if(!isset($_SESSION)){
			session_start();
		}
		$_SESSION["SESSSelectedYear"] = $_POST['ddlYear'];		
				
		If (isset($_POST['ddlYear']))
		{
			include 'db/db_connect.php';
			$query = "SELECT examtype2,examname,sem as examsem FROM tblexammaster Where ExamID = ". $_SESSION["SESSSelectedExam"] .  "";
			$result = $mysqli->query( $query );			
			$num_results = $result->num_rows;			
			if( $num_results ){
				while( $row = $result->fetch_assoc() ){
					extract($row);
				}
			}
			//echo $query;
			if(($examtype2 <> 'Retest') AND (strpos($examname, 'Summer') == false)){
				include 'db/db_connect.php';
				$mysqli->query( 'SET group_concat_max_len = 4294967295;' );
				If ( $_POST['ddlImportType'] == 'RollNo' ) {
					if($_POST['ddlYear'] == 'F.E.'){
					$sql = " SELECT GROUP_CONCAT(distinct RollNo ORDER BY RollNo SEPARATOR ', ') AS RollNo
							FROM tblstdadm sa
							inner join tblexamfee ef on ef.stdadmid = sa.stdadmid and ef.examid = " . $_SESSION["SESSSelectedExam"] . "
							INNER JOIN tblexammaster em ON em.AcadYearFrom = sa.EduYearFrom AND em.ExamID = ef.ExamID
							WHERE coalesce(stdstatus,'D') in('R','P') AND YEAR = '" . $_POST['ddlYear'] . "' AND COALESCE(RollNo, '') <> ''
							ORDER BY RollNo " ;
					}
					else{
					$sql = " SELECT GROUP_CONCAT(distinct RollNo ORDER BY RollNo SEPARATOR ', ') AS RollNo
							FROM tblstdadm sa
							inner join tblexamfee ef on ef.stdadmid = sa.stdadmid and ef.examid = " . $_SESSION["SESSSelectedExam"] . "
							INNER JOIN tblexammaster em ON em.AcadYearFrom = sa.EduYearFrom AND em.ExamID = ef.ExamID
							WHERE dept = " . $_SESSION["capseldept"] . " AND 
							coalesce(stdstatus,'D') in('R','P') AND YEAR = '" . $_POST['ddlYear'] . "' AND COALESCE(RollNo, '') <> ''
							ORDER BY RollNo " ;
					}
				}
				else {
					if($_POST['ddlYear'] == 'F.E.'){
						$sql = " SELECT GROUP_CONCAT(distinct ESNum ORDER BY ESNum SEPARATOR ', ') AS RollNo
								FROM tblstdadm  sa
								inner join tblexamfee ef on ef.stdadmid = sa.stdadmid and ef.examid = " . $_SESSION["SESSSelectedExam"] . "
								INNER JOIN tblexammaster em ON em.AcadYearFrom = sa.EduYearFrom AND em.ExamID = ef.ExamID
								WHERE coalesce(stdstatus,'D') in('R','P') AND YEAR = '" . $_POST['ddlYear'] . "' AND COALESCE(ESNum, '') <> ''
								ORDER BY ESNum " ;
					}
					else{
						$sql = " SELECT GROUP_CONCAT(distinct ESNum ORDER BY ESNum SEPARATOR ', ') AS RollNo
								FROM tblstdadm  sa
								inner join tblexamfee ef on ef.stdadmid = sa.stdadmid and ef.examid = " . $_SESSION["SESSSelectedExam"] . "
								INNER JOIN tblexammaster em ON em.AcadYearFrom = sa.EduYearFrom AND em.ExamID = ef.ExamID
								WHERE dept = " . $_SESSION["capseldept"] . " AND 
								coalesce(stdstatus,'D') in('R','P') AND YEAR = '" . $_POST['ddlYear'] . "' AND COALESCE(ESNum, '') <> ''
								ORDER BY ESNum " ;
					}
				}
				 //echo $sql;
				 //echo "<br/>";
				 //die;
				$TotStdCnt = 0;
				include 'db/db_connect.php';
				$result = $mysqli->query( $sql );
				$num_results = $result->num_rows;
				if( $num_results  ){
					while( $row = $result->fetch_assoc() ){
						extract($row);
$RollNo2 = 'F1600101, F1600102, F1600103, F1600104, F1600105, F1600106, F1600107, F1600108, F1600109, F1600110, F1600111, F1600112, F1600113, F1600114, F1600115, F1600116, F1600117, F1600118, F1600119, F1600120, F1600121, F1600122, F1600123, F1600124, F1600125, F1600126, F1600127, F1600128, F1600129, F1600130, F1600131, F1600132, F1600133, F1600134, F1600135, F1600136, F1600137, F1600138, F1600139, F1600140, F1600141, F1600142, F1600143, F1600144, F1600145, F1600146, F1600147, F1600148, F1600149, F1600150, F1600151, F1600152, F1600153, F1600154, F1600155, F1600156, F1600157, F1600158, F1600159, F1600160, F1600161, F1600162, F1600163, F1600164, F1600165, F1600166, F1600167, F1600168, F1600169, F1600170, F1600171, F1600172, F1600173, F1600174, F1600175, F1600176, F1600177, F1600178, F1600179, F1600180, F1600181, F1600183, F1600184, F1600185, F1600186, F1600187, F1600188, F1600189, F1600190, F1600191, F1600192, F1600193, F1600194, F1600195, F1600196, F1600197, F1600198, F1600199, F1600200, F1600201, F1600202, F1600203, F1600204, F1600205, F1600206, F1600207, F1600208, F1600209, F1600210, F1600211, F1600212, F1600213, F1600214, F1600215, F1600216, F1600217, F1600218, F1600219, F1600220, F1600221, F1600222, F1600223, F1600224, F1600225, F1600226, F1600227, F1600228, F1600229, F1600230, F1600231, F1600232, F1600233, F1600234, F1600235, F1600236, F1600237, F1600238, F1600239, F1600240, F1600241, F1600242, F1600243, F1600244, F1600245, F1600246, F1600247, F1600248, F1600249, F1600250, F1600251, F1600252, F1600253, F1600254, F1600255, F1600256, F1600257, F1600258, F1600259, F1600260, F1600261, F1600262, F1600263, F1600264, F1600265, F1600266, F1600267, F1600268, F1600269, F1600270, F1600271, F1600272, F1600273, F1600274, F1600275, F1600276, F1600277, F1600278, F1600279, F1600280, F1600281, F1600282, F1600283, F1600284, F1600285, F1600286, F1600287, F1600288, F1600289, F1600290, F1600291, F1600292, F1600293, F1600294, F1600295, F1600296, F1600297, F1600298, F1600299, F1600300, F1600301, F1600302, F1600303, F1600304, F1600305, F1600306, F1600307, F1600308, F1600309, F1600310, F1600311, F1600312, F1600313, F1600314, F1600315, F1600316, F1600317, F1600318, F1600319, F1600320, F1600321, F1600322, F1600323, F1600324, F1600325, F1600326, F1600327, F1600328, F1600329, F1600330, F1600331, F1600332, F1600333, F1600334, F1600335, F1600336, F1600337, F1600338, F1600339, F1600340, F1600341, F1600342, F1600343, F1600344, F1600346, F1600347, F1600348, F1600349, F1600350, F1600351, F1600352, F1600353, F1600354, F1600355, F1600356, F1600357, F1600358, F1600359, F1600360, F1600361, F1600362, F1600363, F1600364, F1600365, F1600366, F1600367, F1600368, F1600369, F1600370, F1600371, F1600372, F1600373, F1600374, F1600375, F1600376, F1600377, F1600378, F1600379, F1600380, F1600381, F1600382, F1600383, F1600384, F1600385, F1600386, F1600387, F1600388, F1600389, F1600390, F1600391, F1600392, F1600393, F1600394, F1600395, F1600396, F1600397, F1600398, F1600399, F1600400, F1600401, F1600402, F1600403, F1600404, F1600405, F1600406, F1600407, F1600408, F1600409, F1600410, F1600411, F1600412, F1600413, F1600414, F1600415, F1600416, F1600417, F1600418, F1600419, F1600420, F1600421, F1600422, F1600423, F1600424, F1600425, F1600426, F1600427, F1600428, F1600429, F1600431, F1600432, F1600433, F1600434, F1600435, F1600436, F1600437, F1600438, F1600439, F1600440, F1600441, F1600442, F1600443, F1600444, F1600445, F1600446, F1600447, F1600448, F1600449, F1600450, F1600452, F1600453, F1600454, F1600455, F1600456, F1600457, F1600458, F1600459, F1600460, F1600461, F1600462, F1600463, F1600464, F1600465, F1600466, F1600467, F1600468, F1600469, F1600470, F1600471, F1600472, F1600473, F1600474, F1600475, F1600476, F1600477, F1600478, F1600479, F1600480, F1600481, F1600482, F1600483, F1600484, F1600485, F1600486, F1600487, F1600488, F1600489, F1600490, F1600491, F1600492, F1600493, F1600494, F1600495, F1600496, F1600497, F1600498, F1600499, F1600500, F1600501, F1600502, F1600503, F1600504, F1600505, F1600506, F1600507, F1600508, F1600509, F1600510, F1600511, F1600512, F1600513, F1600514, F1600515, F1600516, F1600517, F1600518, F1600519, F1600520, F1600521, F1600522, F1600523, F1600524, F1600525, F1600526, F1600527, F1600528, F1600529, F1600530, F1600531, F1600532, F1600533, F1600534, F1600535, F1600536, F1600537, F1600538, F1600539, F1600540, F1600541, F1600542, F1600543, F1600544, F1600545, F1600546, F1600547, F1600548, F1600549, F1600550, F1600551, F1600552, F1600553, F1600554, F1600555, F1600556, F1600557, F1600558, F1600559, F1600560, F1600561, F1600562, F1600563, F1600564, F1600565, F1600566, F1600567, F1600568, F1600569, F1600570, F1600571, F1600572, F1600573, F1600574, F1600575, F1600576, F1600577, F1600578, F1600579, F1600580, F1600581, F1600582, F1600583, F1600584, F1600585, F1600586, F1600587, F1600588, F1600589, F1600590, F1600591, F1600592, F1600593, F1600594, F1600595, F1600596, F1600597, F1600598, F1600599, F1600600, F1600601, F1600602, F1600603, F1600604, F1600605, F1600606, F1600607, F1600608, F1600609, F1600610, F1600611, F1600612, F1600613, F1600614, F1600615, F1600616, F1600617, F1600618, F1600619, F1600620, F1600621, F1600622, F1600623, F1600624, F1600625, F1600626, F1600627, F1600628, F1600629, F1600631, F1600632, F1600633, F1600634, F1600635, F1600636, F1600637, F1600638, F1600639';
						if($RollNo <> ''){
							$SelStdList = $RollNo;
							$TotStdCnt = substr_count($SelStdList, ',') + 1;
						}
					}
				}
				//echo $TotStdCnt;
				//$result->free();
				//disconnect from database
				//$mysqli->close();
				//echo $TotStdCnt;
				if($TotStdCnt > 0){
					if($_POST['ddlYear'] == 'F.E.'){
						$sql = " SELECT 0 AS YSID, EnggYear ,PaperID, CONCAT(deptname,' - ',subjectName) AS SubjectName,IsElective 
						FROM vwhodsubjectsselectedauto vwss 
						INNER JOIN tbldepartmentmaster dm ON dm.DeptID = vwss.DeptID 
						WHERE EnggYear = REPLACE('" . $_POST['ddlYear'] . "','.','') AND vwss.DeptID = " . $_POST['ddldept'] . " AND vwss.papertype = 'TH' ";
					}
					else{
						$sql = " SELECT 0 AS YSID, EnggYear ,PaperID, CONCAT(deptname,' - ',subjectName) AS SubjectName,IsElective 
						FROM vwhodsubjectsselected vwss 
						INNER JOIN tbldepartmentmaster dm ON dm.DeptID = vwss.DeptID 
						WHERE EnggYear = REPLACE('" . $_POST['ddlYear'] . "','.','') AND vwss.DeptID = " . $_POST['ddldept'] . " AND vwss.papertype = 'TH' ";
					}
					//IsElective = 0 AND 
					//echo $sql;
					//die;
					include 'db/db_connect.php';
					$sub_result = $mysqli->query( $sql );
					$sub_num_results = $sub_result->num_rows;
					if( $sub_num_results  ){
						while( $row = $sub_result->fetch_assoc() ){
							extract($row);
							$SelPaperId = $PaperID;
							$sqlSES = "Select ExamSchID from tblexamschedule where ExamID = ". $_SESSION["SESSSelectedExam"] . " and PaperID =  ". $SelPaperId . " ";
							//echo $sqlSES;
							$resultES = $mysqli->query( $sqlSES );
							$num_resultsES = $resultES->num_rows;
							if( $num_resultsES ){
								while( $row = $resultES->fetch_assoc() ){
									extract($row);

									$SelExamSch = $ExamSchID;
									$sqlUES = "Update tblexamschedule set Students = ?, UploadedFile = ?, updated_on = CURRENT_TIMESTAMP where ExamSchID = ?";
									$stmtUES = $mysqli->prepare($sqlUES);
									$stmtUES->bind_param('isi', $TotStdCnt, $SelStdList, $SelExamSch );
									if($stmtUES->execute()){ } 
									else{ echo $mysqli->error;}
								}
							}
							Else {
								$sqlIES = "Insert into tblexamschedule ( ExamID, PaperID, ExamFileID, Students, UploadedFile,
											Created_by, Created_on, updated_by, Updated_on) 
											Values ( ?, ?, 0, ?, ?, 'Admin', CURRENT_TIMESTAMP, 'Admin', CURRENT_TIMESTAMP)";
								$stmtIES = $mysqli->prepare($sqlIES);
								$stmtIES->bind_param('iiis', $_SESSION["SESSSelectedExam"],$SelPaperId, $TotStdCnt, $SelStdList );
								if($stmtIES->execute()){} 
								else{echo $mysqli->error;}
							}
						}
					}					
					//disconnect from database
					$mysqli->close();	
					}
					echo '<script> alert("' . $TotStdCnt . ' students Imported");</script>';
			}
			else{
				include 'db/db_connect.php';
				$mysqli->query( 'SET group_concat_max_len = 4294967295;' );

				if($_POST['ddlYear'] == 'F.E.'){
					$sql = "SELECT distinct GROUP_CONCAT(distinct ESNum ORDER BY ESNum SEPARATOR ', ') AS  SelStdList,pm.PaperID,
							COUNT(distinct ESNum) as TotStdCnt
							FROM tblyearstructstdretest yss 
							INNER JOIN tblstdadm sa ON sa.StdAdmID = yss.StdAdmID
							AND sa.Year = '" . $_POST['ddlYear'] . "' 
							inner join tblexamfee ef on ef.stdadmid = sa.stdadmid and ef.examid = " . $_SESSION["SESSSelectedExam"] . "
							INNER JOIN tblyearstruct ys ON ys.rowid = yss.YSID 
							INNER JOIN tblpapermaster pm ON pm.PaperID = ys.PaperID AND ys.papertype <> 'TT' 
							INNER JOIN tblsubjectmaster sm ON sm.SubjectID = pm.SubjectID 
							AND " . $examsem . "  = SUBSTRING(EnggYear,LENGTH(EnggYear),1) 
							GROUP BY pm.PaperID";					
							
					$sql = "SELECT GROUP_CONCAT(distinct ESNum ORDER BY ESNum SEPARATOR ', ') AS SelStdList,PaperID, COUNT(distinct ESNum) AS TotStdCnt  
							FROM tblyearstructstdretest yss
							INNER JOIN tblexamfee ef ON ef.stdadmid = yss.stdadmid 
							INNER JOIN tblstdadm sa ON ef.stdadmid = sa.stdadmid 
							INNER JOIN tblyearstruct ys ON ys.rowid = yss.YSID 
							INNER JOIN tblexammaster em ON em.AcadYearFrom = ys.EduYearFrom AND em.ExamID = ef.ExamID
							WHERE ef.examid = yss.ExamID AND yss.ExamID = " . $_SESSION["SESSSelectedExam"] . "
							GROUP BY PaperID";

							//AND COALESCE(FeesPaid,0) = 1
							//WHERE yss.sem = cy.Sem
							//INNER JOIN tblcuryearauto cy ON cy.EduYearFrom = ys.eduyearfrom 
							//AND cy.Sem = SUBSTRING(EnggYear,LENGTH(EnggYear),1)  
				}
				else{
					$sql = "SELECT distinct GROUP_CONCAT(distinct ESNum ORDER BY ESNum SEPARATOR ', ') AS  SelStdList,pm.PaperID,
							COUNT(distinct ESNum) as TotStdCnt
							FROM tblyearstructstdretest yss 
							INNER JOIN tblstdadm sa ON sa.StdAdmID = yss.StdAdmID AND sa.Year = '" . $_POST['ddlYear'] . "'
							AND sa.Dept = " . $_POST['ddldept'] . " 
							inner join tblexamfee ef on ef.stdadmid = sa.stdadmid and ef.examid = " . $_SESSION["SESSSelectedExam"] . "
							INNER JOIN tblyearstruct ys ON ys.rowid = yss.YSID 
							INNER JOIN tblpapermaster pm ON pm.PaperID = ys.PaperID AND ys.papertype <> 'TT' 
							INNER JOIN tblsubjectmaster sm ON sm.SubjectID = pm.SubjectID 
							AND " . $examsem . "  = SUBSTRING(EnggYear,LENGTH(EnggYear),1) 
							GROUP BY pm.PaperID";
					
					$sql = "SELECT GROUP_CONCAT(distinct ESNum ORDER BY ESNum SEPARATOR ', ') AS SelStdList,PaperID, COUNT(distinct ESNum) AS TotStdCnt  
							FROM tblyearstructstdretest yss
							INNER JOIN tblexamfee ef ON ef.stdadmid = yss.stdadmid 
							INNER JOIN tblstdadm sa ON ef.stdadmid = sa.stdadmid 
							INNER JOIN tblyearstruct ys ON ys.rowid = yss.YSID 
							INNER JOIN tblexammaster em ON em.AcadYearFrom = ys.EduYearFrom AND em.ExamID = ef.ExamID
							WHERE ef.examid = yss.ExamID AND yss.ExamID = " . $_SESSION["SESSSelectedExam"] . "
							GROUP BY PaperID";
							//AND COALESCE(FeesPaid,0) = 1
							//WHERE yss.sem = cy.Sem 
							//INNER JOIN tblcuryear cy ON cy.EduYearFrom = ys.eduyearfrom 
}
				include 'db/db_connect.php';
				$sub_result = $mysqli->query( $sql );
				$sub_num_results = $sub_result->num_rows;
				if( $sub_num_results  ){
					while( $row = $sub_result->fetch_assoc() ){
						extract($row);
						$SelPaperId = $PaperID;
						$sqlSES = "Select ExamSchID from tblexamschedule where ExamID = ". $_SESSION["SESSSelectedExam"] . " and PaperID =  ". $SelPaperId . " ";
						$resultES = $mysqli->query( $sqlSES );
						$num_resultsES = $resultES->num_rows;
						if( $num_resultsES ){
							while( $row = $resultES->fetch_assoc() ){
								extract($row);
								$SelExamSch = $ExamSchID;
						//echo $TotStdCnt . "<br/>";
//echo $SelStdList . "<br/>";
//echo $SelExamSch . "<br/>";
//die;

								$sqlUES = "Update tblexamschedule set Students = ?, UploadedFile = ?, updated_on = CURRENT_TIMESTAMP where ExamSchID = ?";
								$stmtUES = $mysqli->prepare($sqlUES);
								$stmtUES->bind_param('isi', $TotStdCnt, $SelStdList, $SelExamSch );
//echo $sqlUES;
//die;
								if($stmtUES->execute()){ } 
								else{ echo $mysqli->error;}
							}
						}
						Else {
							$sqlIES = "Insert into tblexamschedule ( ExamID, PaperID, ExamFileID, Students, UploadedFile,
										Created_by, Created_on, updated_by, Updated_on) 
										Values ( ?, ?, 0, ?, ?, 'Admin', CURRENT_TIMESTAMP, 'Admin', CURRENT_TIMESTAMP)";
							$stmtIES = $mysqli->prepare($sqlIES);
							$stmtIES->bind_param('iiis', $_SESSION["SESSSelectedExam"],$SelPaperId, $TotStdCnt, $SelStdList );
							if($stmtIES->execute()){} 
							else{echo $mysqli->error;}
						}
					}
				}
				echo '<script> alert("Students imported successfully.");</script>';
				//disconnect from database
				$mysqli->close();	
			}			
		}
		
	}
	else
		//echo '<script>alert("Please Note : This process will import students for the exam from student database. Existing records will be replaced.");</script>';

?>

<style type="text/css">
      #loadingmsg {
      color: black;
      background: #fff; 
      padding: 10px;
      position: fixed;
      top: 50%;
      left: 50%;
      z-index: 100;
      margin-right: -25%;
      margin-bottom: -25%;
      }
      #loadingover {
      background: black;
      z-index: 99;
      width: 100%;
      height: 100%;
      position: fixed;
      top: 0;
      left: 0;
      -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=80)";
      filter: alpha(opacity=80);
      -moz-opacity: 0.8;
      -khtml-opacity: 0.8;
      opacity: 0.8;
    }
</style>
						
	<br /><br /><br />
	<h3 class="page-title">Import Students</h3>
	<h3 class="page-title" style="float:right;margin-top:-40px;"><a href="ExamIndexMain.php">Back</a></h3>
		<table cellpadding="10" cellspacing="0" border="0" class="tab_split" style="width:50%">
			<tr >
				<td class="form_sec span1"><b>Select Year</b></td>
				<td class="form_sec span1">
						<?php
						if(!isset($_SESSION)){
							session_start();
						}
						include 'db/db_connect.php';
						$strSelect1 = "<select id='ddldept' name='ddldept' style='width:120px;'";
						$strSelect2 = "<option value='0'>Select Dept</option>";
						$query = "SELECT DeptID,DeptName AS Department FROM tbldepartmentmaster where coalesce(teaching,0) = 1 ";
						$result = $mysqli->query( $query );
						$num_results = $result->num_rows;
						if( $num_results ){
							while( $row = $result->fetch_assoc() ){
								extract($row);
								$strSelect2 = $strSelect2 . "<option ";
								
								
									if(isset($_SESSION["capseldept"]))
									{ 
										if($_SESSION["capseldept"] == $DeptID){
											$strSelect2 = $strSelect2 . ' selected ';
										}
									} 
									else if(isset($_POST['ddldept']))
									{ 
										if($_POST["ddldept"] == $DeptID) 
											$strSelect2 = $strSelect2 .  'selected';
									} 		
									$strSelect2 = $strSelect2 . " value='{$DeptID}'>{$Department}</option>";
							}
						}
						$strSelect1 = $strSelect1 . " >";
						$strSelect1 = $strSelect1 . $strSelect2;
						$strSelect1 = $strSelect1 .  "</select>";
						echo $strSelect1;
						?>
				</td>
				<td class="form_sec span1"><b>Select Year</b></td>
				<td class="form_sec span1">
					<select id="ddlYear" name="ddlYear" style="margin-top:10px">
					<option value="">Select Year</option>
					<option value="F.E." <?php if(isset($_SESSION["tmpselyear"])){if($_SESSION['tmpselyear'] == "F.E.") echo "selected";} ?>>F.E.</option>
					<option value="S.E." <?php if(isset($_SESSION["tmpselyear"])){if($_SESSION['tmpselyear'] == "S.E.") echo "selected";} ?>>S.E.</option>
					<option value="T.E." <?php if(isset($_SESSION["tmpselyear"])){if($_SESSION['tmpselyear'] == "T.E.") echo "selected";} ?>>T.E.</option>
					<option value="B.E." <?php if(isset($_SESSION["tmpselyear"])){if($_SESSION['tmpselyear'] == "B.E.") echo "selected";} ?>>B.E.</option>
					<option value="M.E." <?php if(isset($_SESSION["tmpselyear"])){if($_SESSION['tmpselyear'] == "M.E.") echo "selected";} ?>>M.E.</option>
<option value="FY - Sem 1" <?php if(isset($_SESSION["tmpselyear"])){if($_SESSION['tmpselyear'] == "FY - Sem 1") echo "selected";} ?>>FYMTech - Sem 1</option>
<option value="FY - Sem 2" <?php if(isset($_SESSION["tmpselyear"])){if($_SESSION['tmpselyear'] == "FY - Sem 2") echo "selected";} ?>>FYMTech - Sem 2</option>
<option value="SY - Sem 1" <?php if(isset($_SESSION["tmpselyear"])){if($_SESSION['tmpselyear'] == "SY - Sem 1") echo "selected";} ?>>SYMTech - Sem 1</option>
<option value="SY - Sem 2" <?php if(isset($_SESSION["tmpselyear"])){if($_SESSION['tmpselyear'] == "SY - Sem 2") echo "selected";} ?>>SYMTech - Sem 2</option>
				</select>
				</td>
				<td class="form_sec span1"><b>Import By</b></td>
				<td class="form_sec span1">
					<select id="ddlImportType" name="ddlImportType" style="margin-top:10px" required>
						<!-- <option value='FE'>FE</option>"; -->
						<option value=''>Select</option>"; 
						<option value='RollNo'>Roll No</option>"; 
						<option value='SeatNo'>Exam Seat No</option>"; 
					</select>
				</td>
				<td class="form_sec span1">
					<input type="submit" name="btnImport" value="Import" title="Import" class="btn btn btn-success" />
				</td>								
			</tr>						
		</table>
		<br/>
	<br />
</body>	
</form>