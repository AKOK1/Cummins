<form action="assigndivisionMain.php" method="post">
	<br /><br />
	<script>
	function assignprof() {
					var skillsSelect = document.getElementById("profid");
					alert(skillsSelect);
			}
		    function assignprof(profid) {
			       alert(userid);
					var gvET = document.getElementById("tblid");
					var rCount = gvET.rows.length;
					var rowIdx;
					for (rowIdx=1; rowIdx<=rCount-1; rowIdx++) {						
						var rowElement = gvET.rows[rowIdx];
						if (parseInt(rowElement.cells[1].innerText) ==parseInt(profid)){									
							document.getElementById("profid").value =rowElement.cells[1].innerText;
							break;
						}					
					}
		    }
	</script>
	<?php
		include 'db/db_connect.php';
		$sql = "SELECT CONCAT(FirstName,' ', LastName) AS profname
				from tbluser where userID = " . $_GET["profid"];
			$result = $mysqli->query( $sql );
			$num_results = $result->num_rows;
			if( $num_results ){
				while( $row = $result->fetch_assoc() ){
					extract($row);
				}
			}					
			//disconnect from database
			$result->free();
			$mysqli->close();
			echo "</td>";
			echo "</tr>";
			echo "<tr>";
			//echo "<td colspan='9'><h2><center><b>{$ExamDateT}, ".$_GET['ExamSlot']."</b></center></h2>";
			//if ($_SESSION["SESSSelectedExamType"] == 'Online') {
			//	echo "<h2><center><b style='color:red'>Report in Mech Auditorium, 30 Minutes before your timing, for university attendance.</b></center></h2>";
			//}
			echo "</td>";
			echo "</tr>";
	?>
	<h3 class="page-title" style="margin-left:0%">Professor Division Subjects Assignment - <?php 
	//echo $_SESSION["SESSCAPSelectedExamName"]; ?><?php echo $profname; ?></h3>
	<h3 class="page-title" style="float:right;margin-top:-40px;"><a href="examinerassignMain.php">Back</a></h3>
<div class="row-fluid" style="margin-left:1%;margin-top:-15px">
	<div class="span7 v_detail" style="overflow:scroll">
            <div style="float:left">
				<label><b>Available Division Subjects</b></label>
            </div>
		</script>
		<table cellpadding="10" id="tblid" cellspacing="0" border="0" width="100%" class="tab_split">
				<?php
				echo "<tr>
				<th>Block</th>
				<th>Assign</th>
				</tr>";			
				//get blocks for selected cap exam
				include 'db/db_connect.php';
				$sql = "SELECT distinct PaperID,dm.DivName as division, CONCAT(dm.DivName,' - ',sm.SubjectName ,
						CASE WHEN COALESCE(PracticalPRapp,0) = 1 THEN ' - PR' ELSE 
							CASE WHEN COALESCE(OralORapp,0) = 1 THEN ' - OR' 
										ELSE CASE WHEN COALESCE(TermWorkapp,0) = 1 THEN ' - TW' 
								END END END, ' - ', cast(pm.DeptID as char(10))) as subjname
						FROM tblpapermaster pm 
						INNER JOIN tbldivmaster dm ON REPLACE(dm.Year,'.','') = SUBSTRING(pm.EnggYear,1,2)
						INNER JOIN tblexammaster em ON em.AcadYearFrom = dm.EduYearFrom AND SUBSTRING(EnggYear,LENGTH(EnggYear),1) = em.Sem 
						INNER JOIN `tblpatternmaster` patm ON patm.acadyear = CONCAT(em.AcadYearFrom,'-',SUBSTRING(em.AcadYearTo,3,2)) AND dm.year = patm.eduyear
						AND pm.EnggPattern = patm.teachingpat
						INNER JOIN tblsubjectmaster sm ON sm.SubjectID = pm.SubjectID
						WHERE (COALESCE(PracticalPRapp,0) = 1 OR COALESCE(OralORapp,0) = 1 OR COALESCE(TermWorkapp,0) = 1 )
						AND CONCAT(cast(PaperID as char(10)),dm.DivName) NOT IN (SELECT CONCAT(cast(ExamBlockID as char(10)),COALESCE(`div`,'')) 
						FROM tblcapblockprof WHERE ExamID = " . $_SESSION["SESSCAPSelectedExam"] . ")
						Order by subjname";
//and dm.DivName = 'A'
				//echo $sql;
					$result1 = $mysqli->query( $sql );
					//echo $mysqli->error;
					while( $row = $result1->fetch_assoc() ) {
						extract($row);
						echo "<TR class='odd gradeX'>";
						echo "<td>{$subjname}</td>";
						echo "<td class='span2'>
								<a class='btn btn-mini btn-success' id='btnsubmit' name='btnsubmit'
								 href='assigncapblockupd.php?type=d&IUD=I&paperid={$PaperID}&division={$division}&profid={$_GET['profid']}'>
								<i class='icon-ok icon-white'></i>&nbsp;&nbsp;Assign</a>
							  </td>";
						echo "</TR>";
					}
				?>
		</table>
			<br />
    </div>
        <div class="span5 v_detail" style="overflow:scroll">
            <div style="float:left;">
				<label><b>Selected Division Subjects</b></label>
            </div>
			<br/><br/><br/><br/>
			<table style="margin-top:-45px" cellpadding="10" cellspacing="0" border="0" width="90%" class="tab_split">
				<tr>
					<th>Block</th>
					<th width="10%"><strong>Action</strong></th>
				</tr>
				<?php
				//get assigned blocks 
				include 'db/db_connect.php';
				$sql = "SELECT distinct cbpid,CONCAT(dm.DivName,' - ',sm.SubjectName , 
							CASE WHEN COALESCE(PracticalPRapp,0) = 1 THEN ' - PR' ELSE 
							CASE WHEN COALESCE(OralORapp,0) = 1 THEN ' - OR' 
										ELSE CASE WHEN COALESCE(TermWorkapp,0) = 1 THEN ' - TW' 
								END END END, ' - ', cast(pm.DeptID as char(10))) AS subjname 
						FROM tblpapermaster pm 
						INNER JOIN tbldivmaster dm ON REPLACE(dm.Year,'.','') = SUBSTRING(pm.EnggYear,1,2) 
						INNER JOIN tblexammaster em ON em.AcadYearFrom = dm.EduYearFrom AND SUBSTRING(EnggYear,LENGTH(EnggYear),1) = em.Sem 
						INNER JOIN `tblpatternmaster` patm ON patm.acadyear = CONCAT(em.AcadYearFrom,'-',SUBSTRING(em.AcadYearTo,3,2)) 
						AND dm.year = patm.eduyear AND pm.EnggPattern = patm.teachingpat 
						INNER JOIN tblsubjectmaster sm ON sm.SubjectID = pm.SubjectID 
						INNER JOIN tblcapblockprof cpb ON cpb.ExamBlockID = pm.PaperID
						AND cpb.`div` = dm.DivName
						WHERE (COALESCE(PracticalPRapp,0) = 1 OR COALESCE(OralORapp,0) = 1 OR COALESCE(TermWorkapp,0) = 1 ) 
						AND cpb.ExamID = " . $_SESSION["SESSCAPSelectedExam"] . " AND cpb.ProfID = " . $_GET['profid'] . "
						 Order by subjname";
//and dm.DivName = 'A' 
						//echo $sql;
				$result1 = $mysqli->query( $sql );
					//echo $mysqli->error;
					while( $row = $result1->fetch_assoc() ) {
						extract($row);
						echo "<TR class='odd gradeX'>";
						echo "<td>{$subjname}</td>";
					echo "<td class='span3'><a class='btn btn-mini btn-danger' href='assigncapblockupd.php?type=d&IUD=D&cbpid={$cbpid}&profid={$_GET['profid']}'>
						<i class='icon-remove icon-white'></i>&nbsp&nbspCancel</a></td>";						
						echo "</TR>";					
					}				
				?>
			</table>
		</div>
</div>
	<div class="clear"></div>
</form>