<form action="GenerateESNMain.php" method="post" onsubmit='showLoading();' enctype="multipart/form-data">
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
				
		If (isset($_POST['btnGenerateAll']))
		{
			$sql = " Update tblstdadm set ESNum = '' WHERE YEAR = 'M.E.' AND EduYearFrom = 2016 AND EduYearTo = 2017";
			include 'db/db_connect.php';
			$stmt = $mysqli->prepare($sql);
			if($stmt->execute()){ } 
			else{ echo $mysqli->error;}			
		}
		
		$sql = " SELECT StdAdmId
				FROM tblstdadm SA
				INNER JOIN tblstudent S ON SA.StdId = S.StdID
				WHERE coalesce(feespaid,0) = 1 AND coalesce(stdstatus,'R') = 'R' 
				and YEAR = 'M.E.' 
				AND EduYearFrom = 2016 AND EduYearTo = 2017 AND SA.DEPT = 4 
				and COALESCE(ESNum, '') = ''
				ORDER BY FirstName, FatherName, SurName ";

		include 'db/db_connect.php';
		$sub_result = $mysqli->query( $sql );
		$sub_num_results = $sub_result->num_rows;
		$i = 101;
		
		if( $sub_num_results  ){
			while( $row = $sub_result->fetch_assoc() ){
				extract($row);
				$SelStdAdmId = $StdAdmId;
				$ESN = 'M1633' . $i;
				$sqlUES = "Update tblstdadm set ESNum = ? where StdAdmId = ?";
				$stmtUES = $mysqli->prepare($sqlUES);
				$stmtUES->bind_param('si', $ESN, $SelStdAdmId );
				$i = $i + 1;
				if($stmtUES->execute()){ } 
				else{ echo $mysqli->error;}
			}
		}
		echo '<script> alert("Exam Seat numbers generated ");</script>';
		//disconnect from database
		$mysqli->close();

		
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
	<h3 class="page-title" style="float:right;margin-top:-40px;"><a href="MainMenuMain.php">Back</a></h3>
		<table cellpadding="10" cellspacing="0" border="0" class="tab_split" style="width:50%">
			<tr >
				<td class="form_sec span1"><b>Select Year</b></td>
				<td class="form_sec span1">
					<select id="ddlYear" name="ddlYear" style="margin-top:10px">
						<!-- <option value='FE'>FE</option>"; -->
						<option value=''>Select</option>"; 
						<option value='F.E.'>F.E.</option>"; 
						<option value='S.E.'>S.E.</option>"; 
						<option value='T.E.'>T.E.</option>"; 
						<option value='B.E.'>B.E.</option>"; 
						<option value='M.E.'>M.E.</option>"; 
					</select>
				</td>
				<td class="form_sec span1">
					<input type="submit" name="btnGenerate" value="Generate" title="Generate" class="btn btn btn-success" />
				</td>								
				<td class="form_sec span1">
					<input type="submit" name="btnGenerateAll" value="GenerateAll" title="Generate Again for all" class="btn btn btn-success" />
				</td>								
			</tr>						
		</table>
		<br/>
	<br />
</body>	
</form>