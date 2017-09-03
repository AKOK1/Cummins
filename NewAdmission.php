<?php 
		if(!isset($_SESSION)){
			session_start();
		}
		include 'db/db_connect.php';

		$sql = 'SELECT EduYearFrom as admyear FROM tblcuryearauto';
		$result = $mysqli->query( $sql );
				$num_results = $result->num_rows;
				if( $num_results ){
					while( $row = $result->fetch_assoc() ){
						extract($row);

					}
				}
?>		
<form action="unassignedPeonblock2Main.php" method="post">
	<br /><br />
	<h3 class="page-title">New Admission for <?php echo $admyear; ?></h3>

	<?php
		if(isset($_GET['source'])){
			if( $_GET['source'] == 'report' ){
				echo "<h3 class='page-title' style='float:right;margin-top:-40px;'><a href='MainMenuMain.php'>Back</a></h3>";
			}
			else{
				echo "<h3 class='page-title' style='float:right;margin-top:-40px;'><a href='MainMenuMain.php'>Back</a></h3>";
			}
		}
		else
			echo "<h3 class='page-title' style='float:right;margin-top:-40px;'><a href='MainMenuMain.php'>Back</a></h3>";
	?>
	
	
	<br/>
	<div><center>
		<label id="lblSuccess" style="margin-left:10px;color:green;display:none" >Saved successfully.</label>
		</center>
	</div>
	<div class="row-fluid">
	    <div class="span6 v_detail" >
            <div style="float:left">
				<label><b>Student List</b></label>
            </div>
			<br/><br/>
			<table cellpadding="10" cellspacing="0" border="0" width="120%" class="tab_split" style="overflow:scroll">
				<tr>
					<th>Sr. No.</th>
					<th>App ID</th>
					<th>Name</th>
					<th>Year</th>
					<th>Dept</th>
					<th>Shift</th>
					<th>Seat Type</th>
					<th style="width:5%"><strong>Action</strong></th>
				</tr>
				<?php
					include 'db/db_connect.php';
			
					$sql = "SELECT stsgid, S.AppId, CONCAT(S.FirstName, ' ', S.MiddleName, ' ', S.LastName) as Name, S.SeatType, DM.DeptName, S.Shift, COalesce(StdId, 0) as StdId, S.Dept, S.Year, coalesce(stdrem,'') as stdrem,coalesce(mhcetscore,'') as mhcetscore
							 FROM tblstgstudent S
							inner join tblcuryearauto cy on cy.EduYearFrom = S.admyear
							 INNER JOIN tbldepartmentmaster DM ON S.Dept=DM.DeptID
							 LEFT OUTER JOIN tblstudent ST on S.AppId = ST.AppId  
							 Order by DM.DeptName";
					// Prepare IN parameters
					//echo $sql;
					//die;
					$result = $mysqli->query($sql);
					if(isset($result->num_rows))
					{
						$num_results = $result->num_rows;
						//echo $num_results;

						$j = 1;
						if( $num_results ){
							while( $row = $result->fetch_assoc() ){
								extract($row);
								echo "<TR class='odd gradeX'>";
								echo "<td>{$j} </td>";
								echo "<td>{$AppId} </td>";
								echo "<td>{$Name} </td>";
								echo "<td>{$Year} </td>";
								echo "<td>{$DeptName} </td>";
								echo "<td>{$Shift} </td>";
								echo "<td>{$SeatType} </td>";
								if ($StdId == 0) {
									echo "<td>Form to be Filled</td>";
								}
								else {
									echo "<td><a class='btn btn-mini btn-success' href='NewAdmissionUpd.php?IUD=I&stsgid={$stsgid}&StdId={$StdId}&AppId={$AppId}&Dept={$Dept}&Shift={$Shift}&Year={$Year}&stdrem={$stdrem}&mhcetscore={$mhcetscore}'><i class='icon-ok icon-white'></i>&nbsp&nbspConfirm</a></td>";
								}
								echo "</TR>";
								$j = $j + 1;
							}
						}											
						$result->free();
					}

					//disconnect from database
					$mysqli->close();

				?>
				</table>
				
				<br />
        </div>

        <div class="span6 v_detail">
            <div style="float:left;">
				<label><b>Confirmed Admission's</b></label>
            </div>
			<table cellpadding="10" cellspacing="0" border="0" width="120%" class="tab_split" style="overflow:scroll">
				<tr>
					<th>Sr. No.</th>
					<th>App Id</th>
					<th>CNUM</th>
					<th>Name</th>
					<th>Seat</th>
					<th>Shift</th>
					<th>Dept</th>
				</tr>
				<?php
					include 'db/db_connect.php';
					$sql = "SELECT Concat((MAX(EduYearTo) - 1), '-', Right(MAX(EduYearTo), 2)) as YearFrTo FROM tblcuryear";
					//echo $sql;
					$result = $mysqli->query($sql);
					$num_results = $result->num_rows;

					if( $num_results ){
						while( $row = $result->fetch_assoc() ){
							extract($row);
							$SelYearFromTo = $YearFrTo;
						}
					}

												/* and feadmyear = '" . $YearFrTo . "'";*/

					$sql = "SELECT StdId, AppId, CNUM, CONCAT(FirstName, ' ', FatherName, ' ', Surname) as Name, SeatType, Shift, DeptName as DeptName
							FROM tblstudent S
							inner join tblcuryearauto cy on cy.EduYearFrom = SUBSTRING(S.CNUM,3,4)
							Inner Join tbldepartmentmaster DM on DM.DeptID = S.dept
							WHERE AppId is NOT NULL and CNUM <> AppId ";
					$sql = "SELECT s.StdId, AppId, CNUM, CONCAT(FirstName, ' ', FatherName, ' ', Surname) as Name, SeatType, sa.Shift, 
								DM.DeptName as DeptName
							FROM tblstudent s
							inner join tblstdadm sa on s.StdId = sa.StdId 
							inner join tblcuryearauto cy on cy.EduYearFrom = substring(s.feadmyear,1,4)
							 INNER JOIN tbldepartmentmaster DM ON sa.Dept=DM.DeptID
							WHERE AppId is NOT NULL and CNUM <> AppId 
							order by sa.Dept";
					//echo $sql;
					// execute the sql query 
					$result = $mysqli->query( $sql );
					$num_results = $result->num_rows;

					$j = 1;
					if( $num_results ){
						while( $row = $result->fetch_assoc() ){
							extract($row);
							echo "<TR class='odd gradeX'>";
								echo "<td>{$j} </td>";
								echo "<td>{$AppId} </td>";
								echo "<td>{$CNUM} </td>";
								echo "<td>{$Name} </td>";
								echo "<td>{$SeatType} </td>";
								echo "<td>{$Shift} </td>";
								echo "<td>{$DeptName} </td>";
							echo "</TR>";
							$j = $j + 1;
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

