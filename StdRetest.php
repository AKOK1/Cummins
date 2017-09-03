<form action="StdRetestMain.php" method="post">
<?php
	if(!isset($_SESSION)){
		session_start();
	}
?>	
	<br /><br /><br />
	<div>
	<div style="float:left">
		<h3 class="page-title">My Subjects:</h3>
	</div>
	<div style="float:left;margin-top:15px;margin-left:10px">
		<?php
		// get current acad year
		include 'db/db_connect.php';
		$query = "SELECT EduYearFrom,EduYearTo,Sem FROM tblcuryearauto order by EduYearFrom desc LIMIT 1;";
		$result = $mysqli->query( $query );				
		$num_results = $result->num_rows;
		if( $num_results ){
			while( $row = $result->fetch_assoc() ){
				extract($row);
			}
		}

		include 'db/db_connect.php';
		if(isset($_GET["fromadmin"])){
			if(isset($_GET["StdId"]))
				$_SESSION["SESSStdId"] = $_GET["StdId"];
		}
		$query = "SELECT StdAdmID, Year, CASE WHEN YEAR = 'F.E.' THEN dm.DeptID ELSE SM.Dept END AS Dept , CONCAT(Surname,' ',FirstName) as stdname,SM.Div
					FROM tblstdadm SM 
					INNER JOIN tblstudent s on s.StdID = SM.StdID
					INNER JOIN tbldepartmentmaster dm ON dm.DeptName = s.Dept
				  Where SM.StdID = ". $_SESSION["SESSStdId"] . " 
				  and EduYearFrom = " . $EduYearFrom . "
				  and EduYearTo = " . $EduYearTo ;
		//echo $query;
		$result = $mysqli->query( $query );
		$num_results = $result->num_rows;
		if( $num_results ){
			while( $row = $result->fetch_assoc() ){
				extract($row);
				echo "<h4><b>";
				echo "&nbsp;Student Name:&nbsp;&nbsp;" . "{$stdname}";
				echo "&nbsp;&nbsp;{$Year} - Sem {$Sem} - Div {$Div}";
				echo "&nbsp;&nbsp;&nbsp;&nbsp;Academic Year ";
				echo "{$EduYearFrom} - {$EduYearTo} </td>";
				echo "</b>&nbsp;&nbsp;&nbsp;&nbsp;<a class='btn btn-mini btn-success' target='_blank'
					href='RetestPrint.php'></i>&nbsp&nbspPrint</a></h4>";
			}
		}

		$query = "SELECT Year ,CASE WHEN YEAR = 'F.E.' THEN dm.DeptID ELSE SM.Dept END AS Dept 
					FROM tblstdadm sa
					INNER JOIN tbldepartmentmaster dm ON dm.DeptName = sa.Dept
				  where StdID = " . $_SESSION["SESSStdId"] . " and EduYearFrom = " . $EduYearFrom . " and EduYearTo = " . $EduYearTo . " 
				  order by EduYearFrom desc LIMIT 1";
		$result = $mysqli->query( $query );				
		$num_results = $result->num_rows;
		if( $num_results ){
			while( $row = $result->fetch_assoc() ){
				extract($row);
			}
		}

?> 
	</div>

	<br /><br /><br />
	
	<?php
		echo "<h3 class='page-title' style='float:right;margin-top:-40px;'><a href='MainMenuMain.php'>Back</a></h3>";
	?>
	
	<br/>
	<br/>
	<?php
		if(!isset($_SESSION)){
			session_start();
		}
		include 'db/db_connect.php';
		  $sql = "SELECT ExamID,ExamName FROM  tblexammaster 
				WHERE CURRENT_TIMESTAMP BETWEEN reteststart AND retestend and examtype2 = 'Retest' limit 1"	 ;
			//echo $sql;
			// execute the sql query
			$result = $mysqli->query( $sql );
			$num_results = $result->num_rows;

			if( $num_results ){
				$row = $result->fetch_assoc();
				extract($row);
	?>
	<div class="row-fluid" style="margin-left:5%;margin-top:-15px">
	    <div class="span5 v_detail">
            <div style="float:left">
				<label><b>Available Subjects</b></label>
            </div>
			<table cellpadding="10" cellspacing="0" border="0" width="100%" class="tab_split">
				<tr>
					<th>Paper</th>
					<th width="15%"><strong>Action</strong></th>
				</tr>
				<?php			
					 
					$sql = "SELECT distinct pm.PaperID , SubjectName ,em.Sem,ys.rowid as YSID
							FROM tblyearstructstd yss
							INNER JOIN tblyearstruct ys ON ys.rowid = yss.YSID
							INNER JOIN tblpapermaster pm ON pm.PaperID = ys.PaperID  
							 AND ys.papertype <> 'TT'
							INNER JOIN tblsubjectmaster sm ON sm.SubjectID = pm.SubjectID
		inner join tblexammaster em on em.ExamID = " . $ExamID . " and ys.eduyearfrom = em.AcadYearFrom  and em.Sem = SUBSTRING(EnggYear,LENGTH(EnggYear),1)
							WHERE StdAdmID = ". $StdAdmID . 
							" and concat(cast(coalesce(yss.YSID,0) as char(10)),cast(coalesce(StdAdmID,0) as char(10)),cast(coalesce(sem,0) as char(10))) not in (
							select concat(cast(coalesce(ysid,0) as char(10)),cast(coalesce(StdAdmID,0) as char(10)),cast(coalesce(em.sem,0) as char(10))) from tblyearstructstdretest) order by pm.PaperID";
							
							
							$sql = "SELECT DISTINCT pm.PaperID , SubjectName ,em.Sem,ys.rowid AS YSID 
									FROM tblyearstructstd yss 
									INNER JOIN tblyearstruct ys ON ys.rowid = yss.YSID 
									INNER JOIN tblpapermaster pm ON pm.PaperID = ys.PaperID AND ys.papertype <> 'TT' 
									INNER JOIN tblsubjectmaster sm ON sm.SubjectID = pm.SubjectID 
									INNER JOIN tblexammaster em ON em.ExamID = " . $ExamID . " AND em.Sem = SUBSTRING(pm.EnggYear,LENGTH(pm.EnggYear),1) AND em.acadyearfrom = ys.eduyearfrom
									WHERE StdAdmID = ". $StdAdmID . " AND CONCAT(CAST(COALESCE(yss.YSID,0) AS CHAR(10)),CAST(COALESCE(StdAdmID,0) AS CHAR(10)),CAST(COALESCE(em.sem,0) AS CHAR(10))) 
									NOT IN ( SELECT CONCAT(CAST(COALESCE(ysid,0) AS CHAR(10)),CAST(COALESCE(StdAdmID,0) AS CHAR(10)),CAST(COALESCE(em.sem,0) AS CHAR(10))) FROM tblyearstructstdretest WHERE ExamID = " . $ExamID . ") 
									ORDER BY pm.PaperID";
							
						//echo $sql;
						// execute the sql query
						$result = $mysqli->query( $sql );
						$num_results = $result->num_rows;
						//echo $elcount;
						if( $num_results ){
							while( $row = $result->fetch_assoc() ){
								extract($row);
								echo "<td>{$SubjectName}</td>";
								echo "<td class='span2'><a class='btn btn-mini btn-success' href='StdRetestUpd.php?IUD=I&YSID={$YSID}&StdAdmID={$StdAdmID}&sem={$Sem}&ExamID={$ExamID}'>
								<i class='icon-ok icon-white'></i>Apply</a></td>";
								echo "</TR>";
							}
						}					
						//onclick=\"return confirm('Are you sure?');\" 
						//disconnect from database
						$result->free();
						$mysqli->close();
				?>

			</table>
			<br />
        </div>

		<div class="span1 v_detail" style="overflow:hidden">
            <div style="margin-top:80px;margin-left:15px;float:left">
            <br />
            <br />
            <center>
				<br/>
				<br/>
				<br/>
				<br/>
				<br/>
				<br/>
				<br/>
				<br/>
            </center>
            </div>
        </div>
        
        <div class="span5 v_detail">
            <div style="float:left;">
				<label><b>Selected Subjects</b></label>
            </div>
			<table cellpadding="10" cellspacing="0" border="0" width="90%" class="tab_split">
				<tr>
					<th>Paper</th>
					<th width="10%"><strong>Action</strong></th>
				</tr>
				<?php
					include 'db/db_connect.php';
					$sql = "SELECT pm.PaperID , SubjectName ,em.Sem,yss.YSID
							FROM tblyearstructstdretest yss
							INNER JOIN tblyearstruct ys ON ys.rowid = yss.YSID
							INNER JOIN tblpapermaster pm ON pm.PaperID = ys.PaperID 
							AND ys.papertype <> 'TT'
							INNER JOIN tblsubjectmaster sm ON sm.SubjectID = pm.SubjectID
							inner join tblexammaster em on em.ExamID = " . $ExamID . " and ys.eduyearfrom = em.AcadYearFrom  
							and em.Sem = SUBSTRING(EnggYear,LENGTH(EnggYear),1)
							WHERE yss.sem = em.Sem and StdAdmID = ". $StdAdmID . " and em.ExamID = yss.ExamID";
					//echo $sql;
					// execute the sql query
					$result = $mysqli->query( $sql );
					$num_results = $result->num_rows;

					if( $num_results ){
						while( $row = $result->fetch_assoc() ){
							extract($row);
							echo "<TR class='odd gradeX'>";
							echo "<td>{$SubjectName} </td>";
							echo "<td class='span3'><a class='btn btn-mini btn-danger' href='StdRetestUpd.php?IUD=D&YSID={$YSID}&StdAdmID={$StdAdmID}&sem={$Sem}&ExamID={$ExamID}'>
										<i class='icon-remove icon-white'></i>&nbsp&nbspCancel</a></td>";
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
<?php } ?>	
	</form>

