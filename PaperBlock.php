<?php
if(!isset($_SESSION)){
	session_start();
}
If ((isset($_GET['ExDate'])) or (isset($_GET['ExSlot']))){
$_SESSION["SESSExDate"] = $_GET['ExDate'];
$_SESSION["SESSExSlot"] = $_GET['ExSlot'];
$_SESSION["SESSABPaperId"] = $_GET['PaperId'];
$_SESSION["SESSABpaperinfo"] = $_GET['paperinfo'];
$_SESSION["SESSExSchId"] = $_GET['ExamSchId1'];
}
//include database connection
include 'db/db_connect.php';

	// if the form was submitted/posted, update the record
	if (isset($_POST['btnSetPartial']) && isset($_POST['lblExamBlockID']))
	{
		$ExBDs = $_POST['lblExamBlockID'];
		$PAs = $_POST['txtPA'];
		$size = count($PAs);

		for($i = 0 ; $i < $size ; $i++){
			if($PAs[$i] != '')
			{
				$sql = "update tblexamblock set IsPartial = 1,Allocation = ? where ExamBlockID = ?";
				$stmt = $mysqli->prepare($sql);
				$stmt->bind_param('ii', $PAs[$i], $ExBDs[$i] );
				
				if($stmt->execute()){
					//header('Location: SubjectList.php?'); 
				} 
				else{
					echo $mysqli->error;
					//die("Unable to update.");
				}			
			}
		}
	}
	

	$_SESSION["SESSExamID"] = $_SESSION["SESSSelectedExam"];
?>

<form action="PaperBlockMain.php" method="post">
	<head>
		<link rel="stylesheet" href="css/jquery-ui.css">
	   <script src="js/jquery-1.10.2.js"></script>
       <script src="js/jquery-ui.js"></script>
		<script year="text/javascript" src="js/jquery.min.js"></script>
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
	<script year="text/javascript">    
		function showLoading() {
		document.getElementById('loadingmsg').style.display = 'block';
		document.getElementById('loadingover').style.display = 'block';
	}
	</script>
	</head>
<div id='loadingmsg' style='display: none;'>Please wait...</div>
<div id='loadingover' style='display: none;'></div>
	<br /><br />

<h3 class="page-title" style="margin-left:6%;top:40px">Block Paper Allocation Details</h3>
<div style="margin-left:6%">	
<h4><b>
<?php echo date('d-M-Y',strtotime($_SESSION["SESSExDate"]));
?>
&nbsp;&nbsp;&nbsp;<?php echo $_SESSION["SESSExSlot"];
?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<?php echo $_SESSION["SESSABpaperinfo"] ?></b></h4>
<h3 class="page-title" style="float:right;margin-top:-46px;">
<?php echo "<a href='SelectPaperBlockMain.php?ExamDate={$_SESSION["SESSExDate"]}&ExamSlot={$_SESSION["SESSExSlot"]}'>Back</a>"; ?>
</h3>
<?php 
							if($_SESSION["SESSSelectedExamType"] == 'Online')
									$btype = "Laboratory";
							else
									$btype = "Classroom";
								
							$sql2 = " SELECT sum(EB.Allocation) as stdtotal 
							FROM tblblocksmaster BM 
							INNER JOIN tblexamblock EB ON BM.blockid = EB.blockid 
							INNER JOIN tblexamschedule ES on EB.ExamSchID = ES.ExamSchID
							where EB.PaperID = " .$_SESSION['SESSABPaperId']. " and ES.ExamSchID =  ". $_SESSION["SESSExSchId"]. 
							" AND BM.BlockType='".$btype. "' AND ES.ExamID = " . $_SESSION["SESSSelectedExam"] ."";
							//echo $sql2;
							$result2 = $mysqli->query( $sql2 );
							$num_results2 = $result2->num_rows;
							$totStd = 0;
							if( $num_results2 ){
								while( $row2 = $result2->fetch_assoc() ){
									extract($row2);
									$_SESSION["SESStotStd"] = $stdtotal;
									break;
								}
							}
							//echo $_SESSION["SESSABpaperinfo"];
							if(!isset($_SESSION["SESStotStd"])){ $_SESSION["SESStotStd"] == 0; }
							$diff = substr($_SESSION["SESSABpaperinfo"],strrpos($_SESSION["SESSABpaperinfo"], ',')+2) - $_SESSION["SESStotStd"];
							if($diff == 0){
								echo "<h3 style='color:green'><b>Pending Allocation: " . (string)$diff . "</b></h3>"; 
							}
							else{
								echo "<h3 style='color:red'><b>Pending Allocation: " . (string)$diff . "</b></h3>"; 
							}
						?>
</div>
	<div>
	<div style="float:left;width:40%">
	<h4 style="margin-left:100px">Fully Available Blocks</h4>
	<div class="row-fluid" style="margin-left:15%;">
	    <div class="span10 v_detail" style="overflow:scroll;height:300px;">
			<table cellpadding="10" cellspacing="0" border="0" width="200%" class="tab_split">
				<tr>
					<th>Block Name</th>
					<th>Block Capacity</th>
					<th>Available Capacity</th>
					<th width="20%"><strong>Assign</strong></th>
				</tr>

				<?php
						if($_SESSION["SESSSelectedExamType"] == 'Online')
									$btype = "Laboratory";
							else
									$btype = "Classroom";

						If ((isset($_SESSION["SESSExDate"])) or (isset($_SESSION["SESSExSlot"])))
						{
							
/*							//$sql = " SELECT BlockID as ExamBlockID,CONCAT(BlockNo,'-',BlockName) AS Block,BlockCapacity FROM tblblocksmaster WHERE blockid NOT IN (SELECT blockid FROM tblexamblock WHERE examschid = 1 and coalesce(IsPartial,0) = 0);";
							//$sql = "SELECT BM.BlockID AS ExamBlockID,CONCAT(BlockNo,'-',BlockName) AS Block,BlockCapacity, COALESCE(allocation,0) AS allocation,CASE BlockCapacity - COALESCE(allocation,0) WHEN 0 THEN BlockCapacity ELSE BlockCapacity - COALESCE(allocation,0) END AS available FROM tblblocksmaster BM LEFT OUTER JOIN tblexamblock eb ON BM.BlockID = eb.blockid AND examschid = 1 WHERE COALESCE(CASE BlockCapacity - eb.allocation WHEN 0 THEN BlockCapacity ELSE BlockCapacity - eb.allocation END,0) <> BlockCapacity;";

							$sql = "SELECT coalesce(IsPartial,0) as Partial,BM.BlockID AS ExamBlockID,CONCAT(BlockNo,'-',BlockName) AS Block,BlockCapacity, COALESCE(allocation,0) AS allocation,CASE BlockCapacity - COALESCE(allocation,0) WHEN 0 THEN BlockCapacity ELSE BlockCapacity - COALESCE(allocation,0) END AS available FROM tblblocksmaster BM LEFT OUTER JOIN tblexamblock eb ON BM.BlockID = eb.blockid AND examschid = " .$_SESSION["SESSSelectedExam"]. " and eb.PaperID = " .$_SESSION["SESSABPaperId"]. " WHERE COALESCE(eb.allocation,0) <> COALESCE(BM.BlockCapacity,0);";
*/
							
							
							if ($_SESSION["SESSSelectedExamType"] == 'Online') {
								$sql = "SELECT CONCAT(BlockNo,'-',BlockName) AS Block,BlockCapacity, '0' AS allocation, BlockCapacity AS available, 
									'0' AS IsPartial, BM.BlockID, BM.colorder AS orderno,BM.BlockNo
									FROM tblblocksmaster BM 
									WHERE BM.examid = " .  $_SESSION["SESSSelectedExam"] . " and BM.BlockID NOT IN 
										(SELECT BlockID FROM tblexamblock EB 
										INNER JOIN tblexamschedule ES ON EB.ExamSchID = ES.ExamSchID 
										WHERE ES.ExamDate='".$_SESSION["SESSExDate"]."' AND ES.ExamSlot='".$_SESSION["SESSExSlot"]."' 
										and ES.ExamID = " . $_SESSION["SESSSelectedExam"] .") 
										AND BM.BlockType='Laboratory' ORDER BY CAST(BlockNo AS UNSIGNED)";
							}
							else {
								$sql = "SELECT CONCAT(BlockNo,'-',BlockName) AS Block,BlockCapacity, '0' AS allocation, BlockCapacity AS available, 
									'0' AS IsPartial, BM.BlockID, BM.colorder AS orderno,BM.BlockNo
									FROM tblblocksmaster BM 
									WHERE BM.BlockID NOT IN 
										(SELECT BlockID FROM tblexamblock EB 
										INNER JOIN tblexamschedule ES ON EB.ExamSchID = ES.ExamSchID 
										WHERE ES.ExamDate='".$_SESSION["SESSExDate"]."' AND ES.ExamSlot='".$_SESSION["SESSExSlot"]."' 
										and ES.ExamID = " . $_SESSION["SESSSelectedExam"] .") 
										AND BM.BlockType='Classroom' ORDER BY CAST(BlockNo AS UNSIGNED)";
							}

							//echo $sql;
							$result = $mysqli->query( $sql );
							$num_results = $result->num_rows;

							if( $num_results ){
								while( $row = $result->fetch_assoc() ){
									extract($row);
									echo "<TR class='odd gradeX'>";
									echo "<td>{$Block}</td>";
									echo "<td>{$BlockCapacity}</td>";
									echo "<td>{$available}</td>";
								echo "<td class='span2'><a onclick='showLoading();' class='btn btn-mini btn-success' href='PaperBlockUpd.php?IUD=I&PaperID={$_SESSION["SESSABPaperId"]}&ExamSchID={$_SESSION["SESSExSchId"]}&BlockCapacityAvailable={$available}&Partial={$IsPartial}&BlockCapacity={$BlockCapacity}&ExamBlockID1={$BlockID}'>
														<i class='icon-ok icon-white'></i>Assign</a></td>";
									echo "</TR>";
								}
							}					
							//disconnect from database
							$result->free();
							//$mysqli->close();

							}
				?>
			</table>
            <br />
        </div>
	</div>

		<h4 style="margin-left:100px">Partially Available Blocks</h4>
	<div class="row-fluid" style="margin-left:15%">
	    <div class="span10 v_detail" style="overflow:scroll;height:300px;">
			<table cellpadding="10" cellspacing="0" border="0" width="200%" class="tab_split">
				<tr>
					<th>Block Name</th>
					<th>Block Capacity</th>
					<th>Available Capacity</th>
					<th width="20%"><strong>Assign</strong></th>
				</tr>

				<?php
						If ((isset($_SESSION["SESSExDate"])) or (isset($_SESSION["SESSExSlot"])))
						{
							
/*							//$sql = " SELECT BlockID as ExamBlockID,CONCAT(BlockNo,'-',BlockName) AS Block,BlockCapacity FROM tblblocksmaster WHERE blockid NOT IN (SELECT blockid FROM tblexamblock WHERE examschid = 1 and coalesce(IsPartial,0) = 0);";
							//$sql = "SELECT BM.BlockID AS ExamBlockID,CONCAT(BlockNo,'-',BlockName) AS Block,BlockCapacity, COALESCE(allocation,0) AS allocation,CASE BlockCapacity - COALESCE(allocation,0) WHEN 0 THEN BlockCapacity ELSE BlockCapacity - COALESCE(allocation,0) END AS available FROM tblblocksmaster BM LEFT OUTER JOIN tblexamblock eb ON BM.BlockID = eb.blockid AND examschid = 1 WHERE COALESCE(CASE BlockCapacity - eb.allocation WHEN 0 THEN BlockCapacity ELSE BlockCapacity - eb.allocation END,0) <> BlockCapacity;";

							$sql = "SELECT coalesce(IsPartial,0) as Partial,BM.BlockID AS ExamBlockID,CONCAT(BlockNo,'-',BlockName) AS Block,BlockCapacity, COALESCE(allocation,0) AS allocation,CASE BlockCapacity - COALESCE(allocation,0) WHEN 0 THEN BlockCapacity ELSE BlockCapacity - COALESCE(allocation,0) END AS available FROM tblblocksmaster BM LEFT OUTER JOIN tblexamblock eb ON BM.BlockID = eb.blockid AND examschid = " .$_SESSION["SESSSelectedExam"]. " and eb.PaperID = " .$_SESSION["SESSABPaperId"]. " WHERE COALESCE(eb.allocation,0) <> COALESCE(BM.BlockCapacity,0);";
*/
							
							
							if($_SESSION["SESSSelectedExamType"] == 'Online')
									$btype = "Laboratory";
							else
									$btype = "Classroom";
							$sql = "SELECT CONCAT(BlockNo,'-',BlockName) AS Block,BlockCapacity, SUM(allocation) AS allocation,
								BlockCapacity - SUM(allocation) AS available, EB.IsPartial, BM.BlockID, -1 as orderno,BM.BlockNo
							 FROM tblexamblock EB 
							INNER JOIN tblexamschedule ES ON EB.ExamSchID = ES.ExamSchID 
							INNER JOIN tblblocksmaster BM ON BM.BlockID = EB.BlockID
							WHERE ES.ExamDate='".$_SESSION["SESSExDate"]."' AND ES.ExamSlot='".$_SESSION["SESSExSlot"]."' 
							AND BM.BlockType= '". $btype ."' AND EB.Capacity <> EB.Allocation 
							and ES.ExamID = " . $_SESSION["SESSSelectedExam"] ."
							GROUP BY EB.BlockID
							ORDER BY CAST(BlockNo AS UNSIGNED)";

							//echo $sql;
							$result = $mysqli->query( $sql );
							$num_results = $result->num_rows;

							if( $num_results ){
								while( $row = $result->fetch_assoc() ){
									extract($row);
									echo "<TR class='odd gradeX'>";
									echo "<td>{$Block}</td>";
									echo "<td>{$BlockCapacity}</td>";
									echo "<td>{$available}</td>";
								echo "<td class='span2'><a onclick='showLoading();' class='btn btn-mini btn-success' href='PaperBlockUpd.php?IUD=I&PaperID={$_SESSION["SESSABPaperId"]}&ExamSchID={$_SESSION["SESSExSchId"]}&BlockCapacityAvailable={$available}&Partial={$IsPartial}&BlockCapacity={$BlockCapacity}&ExamBlockID1={$BlockID}'>
														<i class='icon-ok icon-white'></i>Assign</a></td>";
									echo "</TR>";
								}
							}					
							//disconnect from database
							$result->free();
							//$mysqli->close();

							}
				?>
			</table>
            <br />
        </div>
	</div>

	
	</div>
	<div class="clear"></div>
	
	
	
	
	<div style="float:left;width:55%">
	<h4 style="margin-left:100px">Assigned Blocks</h4>
	<div class="row-fluid" style="margin-left:5%">
	    <div class="span10 v_detail" style="overflow:scroll;height:600px;">
			<table cellpadding="10" cellspacing="0" border="0" class="tab_split">
				<tr>
					<th>Block Name</th>
					<th>Allocation</th>
					<th width="20%"><strong>Cancel Block</strong></th>
					<th width="20%"><strong>Partial Allocation</strong></th>
					<th width="20%"><strong>Mark Partial</strong></th>
				</tr>

				<?php			
							if($_SESSION["SESSSelectedExamType"] == 'Online')
									$btype = "Laboratory";
							else
									$btype = "Classroom";				
						$sql2 = " SELECT EB.ExamBlockID as ExamBlockID,CONCAT(BlockNo,'-',BlockName) as Block,EB.Capacity,EB.Allocation FROM tblblocksmaster BM 
						INNER JOIN tblexamblock EB ON BM.blockid = EB.blockid 
						INNER JOIN tblexamschedule ES on EB.ExamSchID = ES.ExamSchID
						where EB.PaperID = " .$_SESSION['SESSABPaperId']. " and ES.ExamSchID =  ". $_SESSION["SESSExSchId"]. 
						" AND BM.BlockType= '". $btype ."' ORDER BY CAST(EB.ExamBlockID AS UNSIGNED)";
						//echo $sql2;
						$result2 = $mysqli->query( $sql2 );
						$num_results2 = $result2->num_rows;
						$totStd = 0;
						if( $num_results2 ){
							while( $row2 = $result2->fetch_assoc() ){
								extract($row2);
								echo "<TR class='odd gradeX'>";
								echo "<td>{$Block}</td>";
								echo "<td>{$Allocation}</td>";
								echo "<td class='span2'><a class='btn btn-mini btn-danger' href='PaperBlockUpd.php?IUD=D&PaperID={$_SESSION['SESSABPaperId']}&ExamBlockID={$ExamBlockID}'>
													<i class='icon-remove icon-white'></i>Cancel</a></td>";
								echo "<td style='display:none'><input id='lblExamBlockID' name='lblExamBlockID[]' value={$ExamBlockID} /></td>";
								echo "<td class='span2'><input style='width:40%;align:right' id='txtPA' name='txtPA[]' /></td>";
								echo "<td class='span2'><input type='submit' name='btnSetPartial' value='Set Partial' title='Set Partial' class='btn btn-mini btn-success' /></td>";													
								echo "</TR>";
								$totStd = $totStd + $Allocation;
							}
						}					
						//disconnect from database
						$result2->free();
						$mysqli->close();
						
						//$ddlDeptName = str_replace("value='".$_POST["ddlDept"]."'","value='".$_POST["ddlDept"]."' selected=\"selected\"",$ddlDeptName);

							echo "<tr>";
								echo "<th>Total</th>";
								echo "<th>{$totStd}</th>";
								echo "<th></th>";
								echo "<th></th>";
								echo "<th></th>";
							echo "</tr>";
						?>



			</table>
            <br />
        </div>
	</div>
	</div>
	<div class="clear"></div>
</div>
</body>