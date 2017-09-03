<form action="SubProfMapMain.php" method="post">
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
	<h3 class="page-title" style="margin-left:5%">Subject Professor Assignment</h3>
	<h3 class="page-title" style="float:right;margin-top:-40px;"><a href="MainMenuMain.php">Back</a></h3>
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
					<th colspan='2'><center>";
					echo "Year " . $EduYearFrom . " - " . $EduYearTo . " Sem " . $Sem;
					echo "</center></th>
				</tr>
				<tr>
					<th>Professor Name</th>
					<th>Hours</th>
					<th>Action</th>
				</tr>";			
				
				// Create connection
				include 'db/db_connect.php';
				$sql = "SELECT distinct userid,ProfName,SUM(Hours1) AS Hours1 ,SUM(Hours2) AS Hours2
						FROM (
						SELECT userid,CONCAT(Department, ' - ',FirstName,' ',LastName) AS ProfName ,COALESCE(lECTURE,0) AS Hours1 ,0 AS Hours2 
						FROM tbluser u LEFT OUTER JOIN tblyearstruct ys ON ys.profid = u.userID AND ys.papertype = 'TH' 
						AND ys.eduyearfrom = '" . $EduYearFrom ."' AND ys.eduyearto = '" . $EduYearTo . "' 
						LEFT OUTER JOIN tblpapermaster PM ON PM.PaperID = ys.paperid AND SPLIT_STR(PM.EnggYear,' ',4) = " . $Sem. " 
						WHERE Department = '" . $_SESSION["SESSUserDept"] . "' AND userType NOT IN ('Peon') 
						AND coalesce(currstatus,0) = 1 AND COALESCE(userprofile,'') = 'Teaching'
						UNION ALL
						SELECT u.userid,CONCAT(Department, ' - ',FirstName,' ',LastName) AS ProfName ,COALESCE(lECTURE,0) AS Hours1 ,0 AS Hours2 
						FROM tbluser u 
						LEFT OUTER JOIN tblyearstruct ys ON ys.profid = u.userID AND ys.papertype = 'TH' 
						AND ys.eduyearfrom = '" . $EduYearFrom ."' AND ys.eduyearto = '" . $EduYearTo . "' 
						LEFT OUTER JOIN tblpapermaster PM ON PM.PaperID = ys.paperid AND SPLIT_STR(PM.EnggYear,' ',4) = " . $Sem. "
						INNER JOIN tbluserdept UD ON u.userid = UD.userid AND u.Department <> '" . $_SESSION["SESSUserDept"] . "'
						INNER JOIN tblDepartmentMaster DM ON DM.Deptname = '" . $_SESSION["SESSUserDept"] . "' AND UD.DeptID = DM.DeptID 
						AND userType NOT IN ('Peon') 	
						AND coalesce(currstatus,0) = 1 AND COALESCE(userprofile,'') = 'Teaching'
						UNION ALL 
						SELECT userid,CONCAT(Department, ' - ',FirstName,' ',LastName) AS ProfName ,COALESCE(Practical,0) AS Hours1,0 AS Hours2 
						FROM tbluser u 
						LEFT OUTER JOIN tblyearstruct ys ON ys.profid = u.userID AND ys.papertype = 'PR' 
						AND ys.eduyearfrom = '" . $EduYearFrom ."' AND ys.eduyearto = '" . $EduYearTo . "' 
						LEFT OUTER JOIN tblpapermaster PM ON PM.PaperID = ys.paperid AND SPLIT_STR(PM.EnggYear,' ',4) = " . $Sem. " 
						WHERE Department = '" . $_SESSION["SESSUserDept"] . "' AND userType NOT IN ('Peon') 
AND coalesce(currstatus,0) = 1 AND COALESCE(userprofile,'') = 'Teaching'
						UNION ALL
						SELECT distinct u.userid,CONCAT(Department, ' - ',FirstName,' ',LastName) AS ProfName ,COALESCE(Practical,0) AS Hours1,0 AS Hours2 
						FROM tbluser u 
						LEFT OUTER JOIN tblyearstruct ys ON ys.profid = u.userID AND ys.papertype = 'PR' 
						AND ys.eduyearfrom = '" . $EduYearFrom ."' AND ys.eduyearto = '" . $EduYearTo . "' 
						LEFT OUTER JOIN tblpapermaster PM ON PM.PaperID = ys.paperid AND SPLIT_STR(PM.EnggYear,' ',4) = " . $Sem. "
						INNER JOIN tbluserdept UD ON u.userid = UD.userid AND u.Department <> '" . $_SESSION["SESSUserDept"] . "'
						INNER JOIN tblDepartmentMaster DM ON DM.Deptname = '" . $_SESSION["SESSUserDept"] . "' AND UD.DeptID = DM.DeptID 
						WHERE userType NOT IN ('Peon')
AND coalesce(currstatus,0) = 1 AND COALESCE(userprofile,'') = 'Teaching'
						UNION ALL
						SELECT userid,CONCAT(Department, ' - ',FirstName,' ',LastName) AS ProfName ,COALESCE(lECTURE,0) AS Hours1 ,0 AS Hours2 
						FROM tbluser u LEFT OUTER JOIN tblyearstruct ys ON ys.profid = u.userID AND ys.papertype = 'TT' 
						AND ys.eduyearfrom = '" . $EduYearFrom ."' AND ys.eduyearto = '" . $EduYearTo . "' 
						LEFT OUTER JOIN tblpapermaster PM ON PM.PaperID = ys.paperid AND SPLIT_STR(PM.EnggYear,' ',4) = " . $Sem. "
						WHERE Department = '" . $_SESSION["SESSUserDept"] . "' AND userType NOT IN ('Peon') 
AND coalesce(currstatus,0) = 1 AND COALESCE(userprofile,'') = 'Teaching'
						UNION ALL
						SELECT distinct u.userid,CONCAT(Department, ' - ',FirstName,' ',LastName) AS ProfName ,COALESCE(lECTURE,0) AS Hours1 ,0 AS Hours2 
						FROM tbluser u 
						LEFT OUTER JOIN tblyearstruct ys ON ys.profid = u.userID AND ys.papertype = 'TT' 
						AND ys.eduyearfrom = '" . $EduYearFrom ."' AND ys.eduyearto = '" . $EduYearTo . "' 
						LEFT OUTER JOIN tblpapermaster PM ON PM.PaperID = ys.paperid AND SPLIT_STR(PM.EnggYear,' ',4) = " . $Sem. "
						INNER JOIN tbluserdept UD ON u.userid = UD.userid AND u.Department <> '" . $_SESSION["SESSUserDept"] . "'
						INNER JOIN tblDepartmentMaster DM ON DM.Deptname = '" . $_SESSION["SESSUserDept"] . "' AND UD.DeptID = DM.DeptID 
						AND userType NOT IN ('Peon')  AND coalesce(currstatus,0) = 1 AND COALESCE(userprofile,'') = 'Teaching'
						) AS A GROUP BY ProfName";
						
						$sql = "SELECT distinct u.userid,CONCAT(Department, ' - ',FirstName,' ',LastName) AS ProfName ,0 AS Hours,
								0 as IsOpenElective
								FROM tbluser u 
								WHERE userType NOT IN ('Peon')
								AND Department = '" . $_SESSION["SESSUserDept"] . "'
								and u.userid not in (
								SELECT profid FROM vwhodsubjectsselected vwss
								INNER JOIN tblyearstructprof ysp ON ysp.YSID = vwss.YSID
								where DeptID  in (SELECT DeptID FROM tbldepartmentmaster where DeptName = '" . $_SESSION["SESSUserDept"] . "') AND coalesce(currstatus,0) = 1 AND COALESCE(userprofile,'') = 'Teaching'
								)
								UNION ALL
								SELECT distinct userid,CONCAT(Department, ' - ',FirstName,' ',LastName) AS ProfName,
								SUM(Hours) AS Hours, IsOpenElective
								FROM vwhodsubjectsselected vwss
								INNER JOIN tblyearstructprof ysp ON ysp.YSID = vwss.YSID
								INNER JOIN tbluser u ON u.userID = ysp.profid
								where DeptID  in (SELECT DeptID FROM tbldepartmentmaster where DeptName = '" . $_SESSION["SESSUserDept"] . "') AND coalesce(currstatus,0) = 1 AND COALESCE(userprofile,'') = 'Teaching'
								GROUP BY userid,CONCAT(Department, ' - ',FirstName,' ',LastName)
								UNION ALL
								SELECT userid,CONCAT(Department, ' - ',FirstName,' ',LastName) AS ProfName, 0 AS Hours,
								IsOpenElective 
								FROM tbluser u
								INNER JOIN tbldepartmentmaster dm ON u.Department = dm.DeptName
								INNER JOIN tblpaperdept pd ON pd.deptid = dm.DeptID
								INNER JOIN vwhodsubjectsselected vwss ON vwss.paperid = pd.paperid AND IsOpenElective = 1 AND vwss.DeptID in (SELECT DeptID FROM tbldepartmentmaster where DeptName = '" . $_SESSION["SESSUserDept"] . "') 
								WHERE userType NOT IN ('Peon')  AND coalesce(currstatus,0) = 1 AND COALESCE(userprofile,'') = 'Teaching'
								AND userid NOT IN ( SELECT profid FROM vwhodsubjectsselected vwss 
											INNER JOIN tblyearstructprof ysp ON ysp.YSID = vwss.YSID 
												WHERE DeptID IN (SELECT DeptID FROM tbldepartmentmaster WHERE DeptName = 'EnTC') ) 
								GROUP BY userid,CONCAT(Department, ' - ',FirstName,' ',LastName)
								UNION ALL
								SELECT distinct userid,CONCAT(Department, ' - ',FirstName,' ',LastName) AS ProfName, SUM(Hours) AS Hours,
								IsOpenElective 
								FROM tbluser u
								INNER JOIN tbldepartmentmaster dm ON u.Department = dm.DeptName
								INNER JOIN tblpaperdept pd ON pd.deptid = dm.DeptID
								INNER JOIN vwhodsubjectsselected vwss ON vwss.paperid = pd.paperid AND IsOpenElective = 1 AND vwss.DeptID in (SELECT DeptID FROM tbldepartmentmaster where DeptName = '" . $_SESSION["SESSUserDept"] . "') 
								INNER JOIN tblyearstructprof ysp ON ysp.YSID = vwss.YSID AND ysp.profid = u.userid
								WHERE userType NOT IN ('Peon') AND coalesce(currstatus,0) = 1 AND COALESCE(userprofile,'') = 'Teaching'
								GROUP BY userid,CONCAT(Department, ' - ',FirstName,' ',LastName)
								ORDER BY ProfName";
								
								$sql = "SELECT distinct LastName,FirstName,Department,userid,CONCAT(Department, ' - ',FirstName,' ',LastName) AS ProfName,
										SUM(COALESCE(Hours,0)) AS Hours, 0 AS IsOpenElective,COALESCE(desigcadre,999) AS desigcadre
										FROM tbluser u 
										LEFT OUTER JOIN tblyearstructprof ysp ON u.userID = ysp.profid
										LEFT OUTER JOIN vwhodsubjectsselected vwss ON ysp.YSID = vwss.YSID 
										inner JOIN tbldesignationmaster dm on dm.DesigID = u.Designation
										LEFT OUTER JOIN tblcuryear cy ON cy.eduyearfrom = vwss.eduyearfrom
										WHERE Department = '" . $_SESSION["SESSUserDept"] . "' AND userType NOT IN ('Peon') AND coalesce(currstatus,0) = 1 AND COALESCE(userprofile,'') = 'Teaching'
										GROUP BY userid,CONCAT(Department, ' - ',FirstName,' ',LastName),COALESCE(desigcadre,999)
										ORDER BY Department,COALESCE(desigcadre,999),LastName,FirstName";
										
								$sql = "SELECT DISTINCT LastName,FirstName,Department,userid,CONCAT(Department, ' - ',FirstName,' ',LastName) AS ProfName, 
										0 AS Hours, 0 AS IsOpenElective,
										COALESCE(desigcadre,999) AS desigcadre 
										FROM tbluser u 
										LEFT OUTER JOIN tbldesignationmaster dm ON dm.DesigID = u.Designation 
										WHERE Department = '" . $_SESSION["SESSUserDept"] . "' AND userType NOT IN ('Peon') AND COALESCE(currstatus,0) = 1 AND COALESCE(userprofile,'') = 'Teaching' 
										AND u.userID NOT IN (SELECT ysp.ProfID FROM tblyearstruct ys 
													INNER JOIN tblyearstructprof ysp ON ysp.YSID = ys.rowid 
													INNER JOIN tblcuryear cy ON cy.eduyearfrom = ys.eduyearfrom WHERE ysp.profid IS NOT NULL)
										UNION ALL
										SELECT DISTINCT LastName,FirstName,Department,userid,CONCAT(Department, ' - ',FirstName,' ',LastName) AS ProfName, SUM(COALESCE(Hours,0)) AS Hours, 0 AS IsOpenElective,
										COALESCE(desigcadre,999) AS desigcadre 
										FROM tbluser u 
										INNER JOIN tblyearstructprof ysp ON u.userID = ysp.profid 
										INNER JOIN tbldesignationmaster dm ON dm.DesigID = u.Designation 
										INNER JOIN vwhodsubjectsselected vwss ON ysp.YSID = vwss.YSID 
										INNER JOIN tblcuryear cy ON cy.eduyearfrom = vwss.eduyearfrom and cy.Sem = vwss.Sem
										INNER JOIN tblyearstruct ys ON cy.eduyearfrom = ys.eduyearfrom AND ysp.YSID = ys.rowid
										WHERE Department = '" . $_SESSION["SESSUserDept"] . "' AND userType NOT IN ('Peon') AND COALESCE(currstatus,0) = 1 AND COALESCE(userprofile,'') = 'Teaching' 
										GROUP BY LastName,FirstName,Department,userid,CONCAT(Department, ' - ',FirstName,' ',LastName),COALESCE(desigcadre,999)
UNION ALL
SELECT DISTINCT LastName,FirstName,Department,u.userid,CONCAT(Department, ' - ',FirstName,' ',LastName) AS ProfName, 
COALESCE(lECTURE,0) AS Hours, 0 AS IsOpenElective, COALESCE(desigcadre,999) AS desigcadre 
FROM tbluser u 
INNER JOIN tbluserdept UD ON u.userid = UD.userid AND u.Department <> '" . $_SESSION["SESSUserDept"] . "'
AND userType NOT IN ('Peon') 
AND COALESCE(userprofile,'') = 'Teaching' 
AND COALESCE(currstatus,0) = 1 
INNER JOIN tbldepartmentmaster DM ON DM.Deptname = '" . $_SESSION["SESSUserDept"] . "' AND UD.DeptID = DM.DeptID 
INNER JOIN tbldesignationmaster tdm ON tdm.DesigID = u.Designation 
LEFT OUTER JOIN tblyearstruct ys ON ys.profid = u.userID 
AND ys.papertype = 'TH' AND ys.eduyearfrom = '" . $EduYearFrom ."' AND ys.eduyearto = '" . $EduYearTo ."'
LEFT OUTER JOIN tblpapermaster PM ON PM.PaperID = ys.paperid 
AND SPLIT_STR(PM.EnggYear,' ',4) = " . $Sem. "
										ORDER BY Department,COALESCE(desigcadre,999),LastName,FirstName";

										//echo $sql;

// UNION  
										// SELECT distinct LastName,FirstName,Department,userid,CONCAT(Department, ' - ',FirstName,' ',LastName) AS ProfName,
										// SUM(COALESCE(Hours,0)) AS Hours, 0 AS IsOpenElective,COALESCE(desigcadre,999) AS desigcadre
										// FROM tbluser u 
										// LEFT OUTER JOIN tblyearstructprof ysp ON u.userID = ysp.profid
										// LEFT OUTER JOIN vwhodsubjectsselected vwss ON ysp.YSID = vwss.YSID 
// inner JOIN tbldesignationmaster dm on dm.DesigID = u.Designation
										// WHERE userid IN (SELECT userid FROM tbluserdept WHERE deptid IN (SELECT deptid FROM tbldepartmentmaster WHERE DeptName = '" . $_SESSION["SESSUserDept"] . "' ))
										// AND userType NOT IN ('Peon')  AND coalesce(currstatus,0) = 1 AND COALESCE(userprofile,'') = 'Teaching'
										// GROUP BY userid,CONCAT(Department, ' - ',FirstName,' ',LastName),COALESCE(desigcadre,999)
//'Faculty' ,'Ad-hoc','HOD','Registrar','SuperAdmin','DeptCoord'
						$result = $mysqli->query($sql);
						$num_results = $result->num_rows;
						if( $num_results ){
							while( $row = $result->fetch_assoc() ){
								extract($row);
								if($Hours <> ''){
									echo "<TR class='odd gradeX'>";
									echo "<td>{$ProfName}</td>";
									echo "<td>{$Hours}</td>";
									echo "<td class='span2'>
											<a class='btn btn-mini btn-success' 
											href='SubProfMap2Main.php?profid={$userid}&profname={$ProfName}&Sem={$Sem}&IsOpenElective={$IsOpenElective}'>
											<i class='icon-ok icon-white'></i>&nbsp;&nbsp;Assign</a>
										  </td>";
									echo "</TR>";					
								}
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