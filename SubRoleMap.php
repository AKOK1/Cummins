	<form action="SubRoleMapMain.php" method="post">
<?php
		if(!isset($_SESSION)){
			session_start();
		}
		if(isset($_POST['ddlyear'])){
			$selyear = $_POST['ddlyear'];
		}
		if(isset($_POST['ddlSem'])){
			$selsem = $_POST['ddlSem'];
		}		
		if(isset($_GET['Year'])){
			$selyear = substr($_GET['Year'],0,strpos($_GET['Year'],' '));
			$selsem = substr($_GET['Year'],strpos($_GET['Year'],' - ')+3);
		}
		if(isset($_POST['ddlDiv'])){
			$seldiv = $_POST['ddlDiv'];
		}
		if(isset($_GET['Div'])){
			$seldiv = $_GET['Div'];
		}
		if(isset($_GET['Year']) and isset($_GET['Div']))
		{
			$showresult = 1;
		}
		else
			$showresult = 0;
?>
	<br /><br />
	<h3 class="page-title" style="margin-left:5%">Subject Role Assignment - <?php echo $_GET["subname"]; ?></h3>
	<h3 class="page-title" style="float:right;margin-top:-40px;"><a href="subpaperallocationMain.php">Back</a></h3>
	<div class="row-fluid" style="margin-left:5%">
	    <div class="span6 v_detail" style="overflow:scroll">
			<table cellpadding="10" cellspacing="0" border="0" width="100%" class="tab_split">
				<?php
		
				// Get and store current year
				include 'db/db_connect.php';
				$sql = 'SELECT EduYearFrom, EduYearTo,Sem FROM tblcuryear WHERE EduYearTo = (SELECT MAX(EduYearTo) FROM tblcuryear)';
				//echo $sql;
				$result = $mysqli->query( $sql );
				$num_results = $result->num_rows;
				if( $num_results ){
					while( $row = $result->fetch_assoc() ){
						extract($row);
						$_SESSION["EduYearFrom"] = $EduYearFrom;
						$_SESSION["EduYearTo"] = $EduYearTo;
					}
				}				
				echo "<tr>
					<th></th>
					<th colspan='3'><center>";
					echo "Year " . $EduYearFrom . " - " . $EduYearTo . " Sem " . $Sem;
					echo "</center></th>
				</tr>
				<tr>
					<th>Professor Name</th>
					<th colspan='3'>Click a button below to assign the respective role.</th>
				</tr>";			
				
				// Create connection
				include 'db/db_connect.php';
				

$sql = "SELECT LastName,u.userid,CONCAT(Department, ' - ',FirstName,' ',LastName) AS ProfName,Department
FROM tbluser u ,tbluserdept ud, tbldepartmentmaster dm
WHERE u.userid = ud.userid AND dm.deptname = '" . $_GET["deptname"] . "' AND ud.deptid = dm.deptid
AND COALESCE(userprofile,'') = 'Teaching' AND COALESCE(currstatus,0) = 1
UNION
SELECT LastName,u.userid,CONCAT(Department, ' - ',FirstName,' ',LastName) AS ProfName,Department
FROM tbluser u 
WHERE department = '" . $_GET["deptname"] . "'
AND COALESCE(userprofile,'') = 'Teaching' AND COALESCE(currstatus,0) = 1
						ORDER BY Department,LastName";
//AND userType IN ('Faculty' ,'Ad-hoc','HOD','Registrar','SuperAdmin') 
						//echo $sql;
						$result = $mysqli->query($sql);
						$num_results = $result->num_rows;
						if( $num_results ){
							while( $row = $result->fetch_assoc() ){
								extract($row);
								echo "<TR class='odd gradeX'>";
								echo "<td>{$ProfName}</td>";								
								echo "<td class='span3'>
										<a class='btn btn-mini btn-success' 
										href='SubProfRole2Main.php?deptname=" . $_GET["deptname"] . "&profid={$userid}&PaperID=" . $_GET["PaperID"] . "&Sem={$Sem}&role=1&subname=" . $_GET["subname"] . "&op=I'>
										<i class='icon-ok icon-white'></i>&nbsp;&nbsp;Subject Chairman</a>
									  </td>";								
								echo "<td class='span3'>
										<a class='btn btn-mini btn-success' 
										href='SubProfRole2Main.php?deptname=" . $_GET["deptname"] . "&profid={$userid}&PaperID=" . $_GET["PaperID"] . "&Sem={$Sem}&role=2&subname=" . $_GET["subname"] . "&op=I'>
										<i class='icon-ok icon-white'></i>&nbsp;&nbsp;Paper Setter</a>
									  </td>";								
								echo "<td class='span3'>
										<a class='btn btn-mini btn-success' 
										href='SubProfRole2Main.php?deptname=" . $_GET["deptname"] . "&profid={$userid}&PaperID=" . $_GET["PaperID"] . "&Sem={$Sem}&role=3&subname=" . $_GET["subname"] . "&op=I'>
										<i class='icon-ok icon-white'></i>&nbsp;&nbsp;Examiner</a>
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
		<div class="span6 v_detail" style="overflow:scroll">
			<table cellpadding="10" cellspacing="0" border="0" width="100%" class="tab_split">
				<?php
		
				// Get and store current year
				include 'db/db_connect.php';
				$sql = 'SELECT EduYearFrom, EduYearTo,Sem FROM tblcuryear WHERE EduYearTo = (SELECT MAX(EduYearTo) FROM tblcuryear)';
				//echo $sql;
				$result = $mysqli->query( $sql );
				$num_results = $result->num_rows;
				if( $num_results ){
					while( $row = $result->fetch_assoc() ){
						extract($row);
						$_SESSION["EduYearFrom"] = $EduYearFrom;
						$_SESSION["EduYearTo"] = $EduYearTo;
					}
				}	
				echo "
				<tr>
					<th></th>
					<th colspan='2'>";
					echo "Year " . $EduYearFrom . " - " . $EduYearTo . " Sem " . $Sem;
					echo "</th>
				</tr>
				<tr>
					<th>Professor Name</th>
					<th>Role</th>
					<th>Cancel</th>
					
				</tr>";			
				
				// Create connection
				include 'db/db_connect.php';
				$sql = "SELECT LastName,userid,CONCAT(Department, ' - ',FirstName,' ',LastName) AS ProfName,
						case when coalesce(r1.roleid,0) = 1 then 'Subject Chairman' else case when coalesce(r1.roleid,0) = 2 then 'Paper Setter' 
								else CASE WHEN coalesce(r1.roleid,0) = 3 then 'Examiner' END END END as Role,
								r1.roleid
						FROM tbluser u 
						INNER JOIN tblsubprofrole r1 on r1.profid = u.userid
						WHERE paperid = " . $_GET["PaperID"] . " and Department = '" .$_GET["deptname"] . "' 
AND COALESCE(userprofile,'') = 'Teaching' AND COALESCE(currstatus,0) = 1 
UNION
SELECT LastName,u.userid,
CONCAT(Department, ' - ',FirstName,' ',LastName) AS ProfName, 
CASE WHEN COALESCE(r1.roleid,0) = 1 THEN 'Subject Chairman' ELSE CASE WHEN COALESCE(r1.roleid,0) = 2 
THEN 'Paper Setter' ELSE CASE WHEN COALESCE(r1.roleid,0) = 3 THEN 'Examiner' END END END AS Role, r1.roleid 
FROM tbluser u ,tbluserdept ud, tbldepartmentmaster dm, tblsubprofrole r1 
WHERE r1.profid = u.userid AND paperid = " . $_GET["PaperID"] . " AND u.userid = ud.userid AND dm.deptname = '" .$_GET["deptname"] . "' AND ud.deptid = dm.deptid
AND COALESCE(userprofile,'') = 'Teaching' AND COALESCE(currstatus,0) = 1 
						ORDER BY LastName";
						//echo $sql;
						$result = $mysqli->query($sql);
						$num_results = $result->num_rows;
						if( $num_results ){
							while( $row = $result->fetch_assoc() ){
								extract($row);
								echo "<TR class='odd gradeX'>";
								echo "<td>{$ProfName}</td>";
								echo "<td>{$Role}</td>";
								echo "<td class='span3'><a class='btn btn-mini btn-danger' href='SubProfRole2Main.php?deptname=" . $_GET["deptname"] . "&profid={$userid}&PaperID=" . $_GET["PaperID"] . "&Sem={$Sem}&role={$roleid}&subname=" . $_GET["subname"] . "&op=D'>
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
	
	<div class="clear"></div>

</form>