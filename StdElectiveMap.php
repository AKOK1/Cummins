<form action="StdElectiveMapMain.php" method="post">
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
		$query = "SELECT EduYearFrom,EduYearTo,Sem FROM tblcuryear order by EduYearFrom desc LIMIT 1;";
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
				echo "</b></h4>";
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
			if(isset($_GET["fromadmin"])){
				echo "<h3 class='page-title' style='float:right;margin-top:-40px;'><a href='StdListSubMappingMain.php?fromadmin=1&StdId=" . $_SESSION["SESSStdId"] ."'>Back</a></h3>";
			}
			else{
				echo "<h3 class='page-title' style='float:right;margin-top:-40px;'><a href='MainMenuMain.php'>Back</a></h3>";
			}
	?>
	
	<br/>
	<br/>

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
							// $sql2 = " SELECT count(*) as elcount
							 // FROM tblyearstructstd yss
							 // INNER JOIN tblyearstruct ys on ys.rowid = yss.YSID
							 // INNER JOIN tblpapermaster PM on ys.PaperID = PM.PaperID
							 // INNER JOIN tblsubjectmaster SM ON PM.SubjectID = SM.SubjectID
							 // WHERE COALESCE(IsElective,0) = 1 AND StdAdmID = " . $StdAdmID . "
							 // group by coalesce(ElectiveNo,0)";
							 // $sql2 = "SELECT ElectiveNoSel,COUNT(*) AS elcount FROM vwhodsubjectsselected 
										// WHERE EnggYear = REPLACE('" . $Year . "','.','') AND DeptID = ". $Dept . " 
										// AND YSID IN (SELECT YSID FROM tblyearstructstd WHERE StdAdmId = " . $StdAdmID . ")
										// GROUP BY ElectiveNo
										// UNION
										// SELECT ElectiveNoSel,COUNT(*) AS elcount FROM vwhodsubjectsselected 
										// WHERE EnggYear = REPLACE('" . $Year . "','.','') AND DeptID = ". $Dept . " 
										// AND YSID NOT IN (SELECT YSID FROM tblyearstructstd WHERE StdAdmId = " . $StdAdmID . ")
										// GROUP BY ElectiveNo";
							//echo $sql2;
							//$result2 = $mysqli->query( $sql2 );
							//$num_results2 = $result2->num_rows;
							//if( $num_results2 ){
							//	while( $row2 = $result2->fetch_assoc() ){
							//		extract($row2);
							//	}
							//}					

							// $sql3 = " SELECT PM.PaperID, COUNT(*) AS elcount2
										// FROM tblyearstruct ys 
										// INNER JOIN tblpapermaster PM ON PM.PaperID = ys.PaperID 
										// INNER JOIN tblsubjectmaster SM ON PM.SubjectID = SM.SubjectID 
										// WHERE COALESCE(IsElective,0) = 1 AND eduyearfrom = " . $EduYearFrom . " AND 
										// eduyearto = " . $EduYearTo . " 
										// AND ys.rowid NOT IN (SELECT YSID FROM tblyearstructstd WHERE StdAdmID = " . $StdAdmID. ") AND SPLIT_STR(PM.EnggYear,' ',4) = '2' 
										// AND ys.papertype = 'TH' AND SPLIT_STR(PM.EnggYear,' ',1) = REPLACE('$Year','.','')
										// GROUP BY PM.PaperID
										// UNION ALL
										// SELECT PM.PaperID ,0 AS elcount2 
										// FROM tblyearstructstd yss 
										// INNER JOIN tblyearstruct ys ON ys.rowid = yss.YSID 
										// INNER JOIN tblpapermaster PM ON ys.PaperID = PM.PaperID 
										// INNER JOIN tblsubjectmaster SM ON PM.SubjectID = SM.SubjectID 
										// WHERE COALESCE(IsElective,0) = 1 AND StdAdmID = " . $StdAdmID. " 
										// GROUP BY PM.PaperID";
	// ------------------------------------------------------------
	//$sql3 = " ";
	// --------------------------------------------------------------
	
	
	//echo $sql3;
							// $result3 = $mysqli->query( $sql3 );
							// $num_results3 = $result3->num_rows;
							// if( $num_results3 ){
								// while( $row3 = $result3->fetch_assoc() ){
									// extract($row3);
								// }
							// }					
							
							// $sql = " SELECT distinct PM.PaperID, SM.SubjectName,ys.rowid as YSID,ElectiveNo
									// FROM tblyearstruct ys
									// INNER JOIN tblpapermaster PM ON PM.PaperID = ys.PaperID
									// INNER JOIN tblsubjectmaster SM ON PM.SubjectID = SM.SubjectID 
									// WHERE COALESCE(IsElective,0) = 1 and eduyearfrom = " . $EduYearFrom . " and eduyearto = "	. $EduYearTo . "
									// and ys.rowid not in (select YSID from tblyearstructstd where StdAdmID = " . $StdAdmID. ")
									 // AND SPLIT_STR(PM.EnggYear,' ',4) = '" . $Sem . "' and ys.papertype = 'TH'
									 // AND SPLIT_STR(PM.EnggYear,' ',1) = REPLACE('$Year','.','') 
									 // Order by PaperCode";
									 
									 
					$sql = "SELECT YSID, EnggYear ,PaperID, CONCAT(deptname,' - ',subjectName) AS SubjectName,IsElective ,ElectiveNo
							from vwhodsubjectsselected vwss
							INNER JOIN tblcuryear cy ON cy.EduYearFrom = vwss.EduYearFrom
							INNER JOIN tbldepartmentmaster dm ON dm.DeptID = vwss.DeptID
							where IsElective = 1 and EnggYear = REPLACE('" . $Year . "','.','') AND vwss.DeptID = ". $Dept . "
							AND YSID NOT IN (SELECT YSID FROM tblyearstructstd WHERE StdAdmId = " . $StdAdmID . ")
							AND papertype = 'TH'
							UNION ALL
							SELECT YSID, EnggYear ,vwss.PaperID, CONCAT(dm.DeptName,' - ',subjectName) AS SubjectName,
							IsElective ,ElectiveNo
							FROM vwhodsubjectsselected vwss
							INNER JOIN tblcuryear cy ON cy.EduYearFrom = vwss.EduYearFrom
							INNER JOIN tblpaperdept pd ON pd.paperid = vwss.paperid AND pd.deptid = ". $Dept . "
							INNER JOIN tbldepartmentmaster dm ON dm.DeptID = vwss.deptid 
							WHERE IsOpenElective = 1 AND EnggYear = REPLACE('" . $Year . "','.','') 
							AND YSID NOT IN (SELECT YSID FROM tblyearstructstd WHERE StdAdmId = " . $StdAdmID . ")";	

						
						//echo $sql;
						// execute the sql query
						$result = $mysqli->query( $sql );
						$num_results = $result->num_rows;
						//echo $elcount;
						if( $num_results ){
							while( $row = $result->fetch_assoc() ){
								extract($row);
								//--------
									$sql2 = "SELECT SUM(elcount) AS elcount FROM (
											SELECT coalesce(COUNT(*),0) AS elcount
											FROM vwhodsubjectsselected vwss
											INNER JOIN tblstdadm sa ON sa.StdAdmID = vwss.YSID AND StdAdmId = " . $StdAdmID . "
											INNER JOIN tblcuryear cy ON cy.EduYearFrom = sa.EduYearFrom AND cy.Sem = vwss.Sem
											INNER JOIN tblpaperdept pd ON pd.paperid = vwss.paperid AND pd.deptid = ". $Dept . "
											WHERE IsOpenElective = 1 AND EnggYear = REPLACE('" . $Year . "','.','') 
											AND YSID IN (SELECT YSID FROM tblyearstructstd WHERE StdAdmId = " . $StdAdmID . ")
											AND ElectiveNo = " . $ElectiveNo ."
											) as A";

									$sql2 = "SELECT COUNT(DISTINCT YSID) AS elcount
											FROM tblyearstructstd yss 
											INNER JOIN tblstdadm sa ON sa.StdAdmID = yss.StdAdmId
											INNER JOIN tbldepartmentmaster dm ON dm.DeptID = sa.Dept
											INNER JOIN tblyearstruct ys ON ys.rowid = yss.YSID
											INNER JOIN tblpapermaster pm ON pm.PaperID = ys.paperid
											INNER JOIN tblsubjectmaster sm ON sm.SubjectID = pm.SubjectID
											INNER JOIN tblcuryear cy ON cy.EduYearFrom = sa.EduYearFrom AND cy.Sem = SUBSTRING(pm.EnggYear,LENGTH(pm.EnggYear),1)
											WHERE sa.StdAdmId = " . $StdAdmID . "
											AND (IsOpenElective = 1 or IsElective = 1)
											AND ElectiveNo = " . $ElectiveNo ."
											AND SUBSTRING(pm.EnggYear,1,2) = REPLACE('" . $Year . "','.','')";
											
									//echo $sql2 . "<br/>";
									//die;
									$result2 = $mysqli->query( $sql2 );
									$num_results2 = $result2->num_rows;
									if( $num_results2 ){
										while( $row2 = $result2->fetch_assoc() ){
											extract($row2);
										}
									}					
								//---------
								//echo $elcount;
								echo "<td>{$SubjectName}</td>";
								//if(($ElectiveNoSel == $ElectiveNo) && ($elcount > 1)){
								if($elcount == 0){
									/*
									if(isset($_GET["fromadmin"]))
										echo "<td class='span2'><a class='btn btn-mini btn-success' href='StdElectiveMapUpd.php?IUD=I&YSID={$YSID}&StdAdmID={$StdAdmID}&fromadmin=1'>
										<i class='icon-ok icon-white'></i>Assign</a></td>";
									else
									*/
									echo "<td class='span2'><a class='btn btn-mini btn-success' href='StdElectiveMapUpd.php?IUD=I&YSID={$YSID}&StdAdmID={$StdAdmID}&fromadmin=1'>
										<i class='icon-ok icon-white'></i>Assign</a></td>";
								}
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
					$sql = " SELECT yssid, PM.EnggYear ,PM.PaperID, SM.SubjectName,coalesce(IsElective,0) as IsElective
							 FROM tblyearstructstd yss
							 INNER JOIN tblyearstruct ys on ys.rowid = yss.YSID and ys.eduyearfrom = ". $EduYearFrom . " and ys.eduyearto = " . $EduYearTo . "
							 INNER JOIN tblpapermaster PM on ys.PaperID = PM.PaperID AND PM.DeptID in (SELECT DeptID FROM tbldepartmentmaster where DeptName = '" . $_SESSION["SESSUserDept"] . "')
							 and SPLIT_STR(PM.EnggYear,' ',4) = '" . $Sem . "' 
							 INNER JOIN tblsubjectmaster SM ON PM.SubjectID = SM.SubjectID
							 WHERE StdAdmID = " . $StdAdmID . "
							 UNION ALL
							 SELECT 0 as yssid, PM.EnggYear ,PM.PaperID, SM.SubjectName,coalesce(IsElective,0) as IsElective
							 FROM tblyearstruct ys 
							 INNER JOIN tblpapermaster PM on ys.PaperID = PM.PaperID  AND PM.DeptID in (SELECT DeptID FROM tbldepartmentmaster where DeptName = '" . $_SESSION["SESSUserDept"] . "')
							 and SPLIT_STR(PM.EnggYear,' ',4) = '" . $Sem . "' 
							 INNER JOIN tblsubjectmaster SM ON PM.SubjectID = SM.SubjectID
							 WHERE  ys.eduyearfrom = ". $EduYearFrom . " and ys.eduyearto = " . $EduYearTo . " and 
									coalesce(IsElective,0) = 0 and SUBSTRING(EnggYear,1,2) = Replace('" . $Year . "','.','')";
					$sql = "SELECT 0 as YSID, EnggYear ,PaperID, CONCAT(deptname,' - ',subjectName,' - ', EnggPattern) AS SubjectName,IsElective 
							from vwhodsubjectsselected vwss
							INNER JOIN tbldepartmentmaster dm ON dm.DeptID = vwss.DeptID
							where IsElective = 0 and EnggYear = REPLACE('" . $Year . "','.','') AND vwss.DeptID = ". $Dept . "
							UNION ALL
							SELECT YSID, EnggYear ,PaperID, CONCAT(deptname,' - ',subjectName,' - ', EnggPattern) AS SubjectName,IsElective 
							FROM vwhodsubjectsselected vwss
							INNER JOIN tbldepartmentmaster dm ON dm.DeptID = vwss.DeptID
							WHERE (IsOpenElective = 1 or IsElective = 1) AND EnggYear = REPLACE('" . $Year . "','.','') 
							AND YSID IN (SELECT YSID FROM tblyearstructstd WHERE StdAdmId = " . $StdAdmID . ")";
							
					$sql = "SELECT 0 as YSID, EnggYear ,PaperID, CONCAT(deptname,' - ',subjectName,' - ', EnggPattern) AS SubjectName,IsElective 
							from vwhodsubjectsselected vwss
							INNER JOIN tbldepartmentmaster dm ON dm.DeptID = vwss.DeptID
							where IsElective = 0 and EnggYear = REPLACE('" . $Year . "','.','') AND vwss.DeptID = ". $Dept . "
							UNION ALL
							SELECT YSID, EnggYear ,PaperID, CONCAT(deptname,' - ',subjectName,' - ', EnggPattern) AS SubjectName,IsElective 
							FROM vwhodsubjectsselected vwss 
							INNER JOIN tblstdadm sa ON sa.StdAdmID = vwss.YSID AND StdAdmId = " . $StdAdmID . "
							INNER JOIN tblcuryear cy ON cy.EduYearFrom = sa.EduYearFrom AND cy.Sem = vwss.Sem
							INNER JOIN tbldepartmentmaster dm ON dm.DeptID = vwss.DeptID 
							WHERE (IsOpenElective = 1 or IsElective = 1) AND EnggYear = REPLACE('" . $Year . "','.','') ";							

					$sql = "SELECT 0 as YSID, EnggYear ,PaperID, CONCAT(deptname,' - ',subjectName,' - ', EnggPattern) AS SubjectName,IsElective 
							from vwhodsubjectsselected vwss
							INNER JOIN tblcuryear cy ON cy.EduYearFrom = vwss.EduYearFrom
							INNER JOIN tbldepartmentmaster dm ON dm.DeptID = vwss.DeptID
							where IsElective = 0 and EnggYear = REPLACE('" . $Year . "','.','') AND vwss.DeptID = ". $Dept . "
							UNION ALL
							SELECT DISTINCT YSID, EnggYear ,pm.PaperID, CONCAT(deptname,' - ',subjectName,' - ', EnggPattern) AS SubjectName,IsElective 
							FROM tblyearstructstd yss 
							INNER JOIN tblstdadm sa ON sa.StdAdmID = yss.StdAdmId
							INNER JOIN tbldepartmentmaster dm ON dm.DeptID = sa.Dept
							INNER JOIN tblyearstruct ys ON ys.rowid = yss.YSID
							INNER JOIN tblpapermaster pm ON pm.PaperID = ys.paperid
							INNER JOIN tblsubjectmaster sm ON sm.SubjectID = pm.SubjectID
							INNER JOIN tblcuryear cy ON cy.EduYearFrom = sa.EduYearFrom AND cy.Sem = SUBSTRING(pm.EnggYear,LENGTH(pm.EnggYear),1)
							WHERE sa.StdAdmId = " . $StdAdmID . "  
							AND (IsOpenElective = 1 or IsElective = 1) AND SUBSTRING(pm.EnggYear,1,2) = REPLACE('" . $Year . "','.','') ";							



							//AND vwss.DeptID = ". $Dept . "
					//echo $sql;
					// execute the sql query
					$result = $mysqli->query( $sql );
					$num_results = $result->num_rows;

					if( $num_results ){
						while( $row = $result->fetch_assoc() ){
							extract($row);
							echo "<TR class='odd gradeX'>";
							echo "<td>{$SubjectName} </td>";
							if($IsElective == 1){
								if(isset($_GET["fromadmin"])){
								echo "<td class='span3'><a class='btn btn-mini btn-danger' href='StdElectiveMapUpd.php?IUD=D&YSID={$YSID}&StdAdmID={$StdAdmID}&fromadmin=1'>
											<i class='icon-remove icon-white'></i>&nbsp&nbspCancel</a></td>";
								}
								else{
									echo "<td class='span3'><a class='btn btn-mini btn-danger' href='StdElectiveMapUpd.php?IUD=D&YSID={$YSID}&StdAdmID={$StdAdmID}'>
												<i class='icon-remove icon-white'></i>&nbsp&nbspCancel</a></td>";
								}
							}
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

