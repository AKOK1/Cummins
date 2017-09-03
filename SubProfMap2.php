<?php
		if(!isset($_SESSION)){
			session_start();
		}
?>		
<form action="unassignedPeonblock2Main.php" method="post">
	<br /><br />
	<h3 class="page-title">Assign Subject</h3>
	<h3 class='page-title' style='float:right;margin-top:-40px;'><a href='SubProfMapMain.php?'>Back</a></h3>
	
	
	<div style="margin-left:10px;margin-top:10px">
	<?php
		echo "<div style='float:left'><label><b>Selected Professor: </b>{$_GET['profname']}</label></div>";
	?>
	</div>
	<br/><br/>
		<div><center>
			<label id="lblSuccess" style="margin-left:10px;color:green;display:none" >Saved successfully.</label>
			</center>
		</div>

	<div class="row-fluid" style="margin-left:5%;margin-top:-15px">
	    <div class="span5 v_detail" style="overflow:scroll">
			<br/>
            <div style="float:left">
				<label><b>Available Subjects</b></label>
            </div>
			<table cellpadding="10" cellspacing="0" border="0" width="100%" class="tab_split">
				<tr>
					<th>Year-Sem-(Pat)-Batch-Subject</th>
					<th>Action</th>
				</tr>
				<?php
				// Create connection
				include 'db/db_connect.php';
				
					
				
				$sql = "SELECT PM.PaperID,CONCAT(ys.div,' - ',PM.EnggYear,' (',PM.EnggPattern,') - ',SubjectName ,' - TH') AS 	SubjectName,
						'TH' AS strpapertype,ys.div AS strdivname,'0' AS batchid
					FROM tblyearstruct ys
					INNER JOIN tblpapermaster PM ON PM.PaperId = ys.paperid
					AND SPLIT_STR(PM.EnggYear,' ',4) = '" . $_GET['Sem'] . "'
					INNER JOIN tblsubjectmaster SM ON SM.SubjectId = PM.SubjectId 
					INNER JOIN vwmaxpattern mp ON mp.EnggPattern = PM.EnggPattern AND CONCAT(mp.EnggYear,' - Sem ',mp.Sem) = PM.EnggYear 
					-- INNER JOIN tbldivmaster dm ON dm.DeptID = PM.DeptID 
					WHERE PM.DeptID in (SELECT DeptID FROM tbldepartmentmaster where DeptName = '" . $_SESSION["SESSUserDept"] . "') and COALESCE(Lectureapp,0) = 1 AND profid IS NULL AND ys.papertype = 'TH'
					UNION ALL 
					SELECT PM.PaperID,CONCAT(ys.div,' - ',PM.EnggYear,' (',PM.EnggPattern,') - ',SubjectName, ' - PR - ',b.BatchName) AS SubjectName,
						'PR' AS strpapertype,ys.div as strdivname,b.BtchID AS batchid 
					FROM tblyearstruct ys
					INNER JOIN tblpapermaster PM ON PM.PaperId = ys.paperid
					AND SPLIT_STR(PM.EnggYear,' ',4) = '" . $_GET['Sem'] . "'  and PM.DeptID in (SELECT DeptID FROM tbldepartmentmaster where DeptName = '" . $_SESSION["SESSUserDept"] . "')
					INNER JOIN tblsubjectmaster SM ON SM.SubjectId = PM.SubjectId 
					INNER JOIN vwmaxpattern mp ON mp.EnggPattern = PM.EnggPattern AND CONCAT(mp.EnggYear,' - Sem ',mp.Sem) = PM.EnggYear
					-- INNER JOIN tbldivmaster dm ON dm.DeptID = PM.DeptID 
					INNER JOIN tblbatchmaster b ON b.BtchId = ys.batchid 
					and b.DeptID in (SELECT DeptID FROM tbldepartmentmaster where DeptName = '" . $_SESSION["SESSUserDept"] . "')
					WHERE COALESCE(Practicalapp,0) = 1 AND profid IS NULL AND ys.papertype = 'PR'
						ORDER BY SubjectName";				

						$sql = "SELECT CONCAT(EnggYear,' - Sem ',vwss.Sem,' (',EnggPattern,') - ',BatchName,' - ',SubjectName) AS  			
								SubjectName,PaperID,vwss.papertype as strpapertype,EnggYear,vwss.DeptID,IsElective,
								YSID,ElectiveNo,vwss.Sem,BtchId as batchid
								FROM vwhodsubjectsselected vwss 
								INNER JOIN tblbatchmaster bm ON bm.DeptID = vwss.DeptID 
								AND bm.papertype = CONVERT(vwss.papertype USING latin1)
								 and vwss.DeptID in (SELECT DeptID FROM tbldepartmentmaster where DeptName = '" . $_SESSION["SESSUserDept"] . "') AND EduYear = EnggYear
								inner join tblcuryear cy on cy.EduYearFrom = vwss.eduyearfrom and cy.Sem = vwss.Sem
								WHERE CONCAT( YSID,BtchId) 
								NOT IN (SELECT CONCAT( YSID,BtchId) FROM tblyearstructprof)
								ORDER BY SubjectName";
								// and IsOpenElective = " . $_GET["IsOpenElective"] . "

							//echo $sql;
						$result = $mysqli->query($sql);
						$num_results = $result->num_rows;
						if( $num_results ){
							while( $row = $result->fetch_assoc() ){
								extract($row);
								echo "<TR class='odd gradeX'>";
								echo "<td>{$SubjectName}</td>";
								echo "<td class='span2'>
										<a class='btn btn-mini btn-success' 
										href='SubProfMapUpd.php?YSID={$YSID}&profid={$_GET['profid']}&paperid={$PaperID}
										&IUD=U&profname={$_GET['profname']}&papertype={$strpapertype}&batchid={$batchid}&Sem={$_GET['Sem']}&IsOpenElective={$_GET['IsOpenElective']}'>
										<i class='icon-ok icon-white'></i>&nbsp;&nbsp;Assign</a>
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
       
        <div class="span5 v_detail" style="overflow:scroll">
            <br/>
            <div style="float:left;">
				<label><b>Assigned Subjects</b></label>
            </div>
			<br/><br/>
			<table cellpadding="10" cellspacing="0" border="0" width="100%" class="tab_split">
				<tr>
					<th>SubjectName</th>
					<th>Action</th>
				</tr>
				<?php
				// Create connection
				include 'db/db_connect.php';
				$sql = "SELECT rowid,CONCAT(ys.div,' - ',PM.EnggYear,' (',PM.EnggPattern,') - ',SubjectName,' - TH') AS SubjectName 
						FROM tblyearstruct ys 
						INNER JOIN tblpapermaster PM ON PM.PaperID = ys.PaperID 
						AND SPLIT_STR(PM.EnggYear,' ',4) = '" . $_GET['Sem'] . "'
						INNER JOIN tblsubjectmaster SM ON SM.SubjectId = PM.SubjectId 
						WHERE COALESCE(Lectureapp,0) = 1 AND profid = " . $_GET['profid'] . " AND ys.papertype = 'TH'
						UNION ALL 
						SELECT rowid,CONCAT(ys.div,' - ',PM.EnggYear,' (',PM.EnggPattern,') - ',SubjectName, ' - PR - ',b.BatchName) AS SubjectName 
						FROM tblyearstruct ys 
						INNER JOIN tblpapermaster PM ON PM.PaperID = ys.PaperID 
						AND SPLIT_STR(PM.EnggYear,' ',4) = '" . $_GET['Sem'] . "'
						INNER JOIN tblsubjectmaster SM ON SM.SubjectId = PM.SubjectId 
						-- INNER JOIN tbldivmaster dm ON dm.DeptID = PM.DeptID 
						INNER JOIN tblbatchmaster b WHERE COALESCE(Practicalapp,0) = 1 AND profid = " . $_GET['profid'] . "
						AND ys.papertype = 'PR' and b.BtchID = ys.batchid
						ORDER BY SubjectName";
						
					$sql = "SELECT CONCAT(EnggYear,' - Sem ',vwss.Sem,' (',EnggPattern,') - ',BatchName,' - ',SubjectName) AS  			
							SubjectName,PaperID,vwss.papertype as strpapertype,EnggYear,vwss.DeptID,IsElective,
							YSID,ElectiveNo,vwss.Sem,BtchId as batchid,IsOpenElective
							FROM vwhodsubjectsselected vwss 
							INNER JOIN tblbatchmaster bm ON bm.DeptID = vwss.DeptID 
							AND bm.papertype = CONVERT(vwss.papertype USING latin1)
							 and vwss.DeptID in (SELECT DeptID FROM tbldepartmentmaster where DeptName = '" . $_SESSION["SESSUserDept"] . "')
							inner join tblcuryear cy on cy.EduYearFrom = vwss.eduyearfrom and cy.Sem = vwss.Sem
							WHERE CONCAT( YSID,BtchId,'" . $_GET['profid'] . "') 
							IN (SELECT CONCAT( YSID,BtchId,profid) FROM tblyearstructprof)
							ORDER BY SubjectName";
						//echo $sql;
						$result = $mysqli->query($sql);
						$num_results = $result->num_rows;
						if( $num_results ){
							while( $row = $result->fetch_assoc() ){
								extract($row);
								echo "<TR class='odd gradeX'>";
								echo "<td>{$SubjectName}</td>";
								echo "<td class='span4'>
										<a class='btn btn-mini btn-danger' 
										href='SubProfMapUpd.php?YSID={$YSID}&profid={$_GET['profid']}&rowid={$rowid}&profname={$_GET['profname']}&IUD=D&Sem={$_GET['Sem']}&batchid={$batchid}&IsOpenElective={$IsOpenElective}'>
										<i class='icon-remove icon-white'></i>&nbsp;&nbsp;Cancel</a>
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

