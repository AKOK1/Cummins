<form action="profblockreportMain.php" method="post">
<?php
		if(!isset($_SESSION)){
			session_start();
		}
?>
	<br /><br />
	<h3 class="page-title" style="margin-left:5%">Professor Block Allocation</h3>
	<h3 class="page-title" style="float:right;margin-top:-40px;">
	<?php
			echo"<a href='ExamIndexMain.php'>Back</a>";
	?>
	</h3>


			<table cellpadding="10" cellspacing="0" border="0" width="90%" class="tab_split" style="margin-left:3%">
				<tr>
					<th  colspan="4"><center>Planned Duties</center></th>
					<th></th>
					<th  colspan="4"><center>Taken Duties</center></th>
				</tr>
				<tr>
					<th>Total</th>
					<th>Saturday</th>
					<th>Evening</th>
					<th>Morning</th>
					<th></th>
					<th>Total</th>
					<th>Saturday</th>
					<th>Evening</th>
					<th>Morning</th>
				</tr>
				<?php
					include 'db/db_connect.php';
					$tmpExamDate = '' ;
					$tmpExamSlot = '' ;

					If (isset($_POST['btnSearch']) or (isset($_POST['btnSave']))  ) { 
							$tmpExamDate = $_POST['ddlDate'] ;
							$tmpExamSlot = $_POST['ddlExamDateSlot'] ;
						}
						Else { 
							if  (isset($_GET['ExamDate'])) {
								$tmpExamDate = $_GET['ExamDate'] ;
								$tmpExamSlot = $_GET['ExamSlot'] ;
							}
						}
						
						if ($tmpExamDate == '') {$tmpExamDate = '01/01/1900';}
						if ($tmpExamSlot == '') {$tmpExamSlot = 'Morning';}
if($_SESSION["SESSSelectedExamType"] ==  'Online')
{
$sql = "select A.PM as TotCount,0 as Satcount,0 as EvenCount,A.PM as MornCount from 
(
SELECT DISTINCT ExamDate as examdate, COUNT(EB.ExamBlockID) AS PM,0 as PE, 0 as AE, 0 as TECount 
FROM tblblocksmaster BM 
INNER JOIN tblexamblock EB ON BM.blockid = EB.blockid 
INNER JOIN tblexamschedule ES ON EB.ExamSchID = ES.ExamSchID 
INNER JOIN tblexammaster em ON BM.ExamID = em.ExamID WHERE em.ExamID = " . $_SESSION["SESSSelectedExam"] . "
) as A";
}
else
{						
						$sql = " SELECT DISTINCT TotCount, Satcount, EvenCount,MornCount FROM
								(SELECT SUM(COALESCE(supcount, 0)) + SUM(COALESCE(relcount, 0)) + SUM(COALESCE(cccount, 0)) AS TotCount , '1' AS id FROM tblexamblockcount where examid = " . $_SESSION["SESSSelectedExam"] .") AS A
								INNER JOIN 
								(SELECT SUM(COALESCE(supcount, 0)) + SUM(COALESCE(relcount, 0)) + SUM(COALESCE(cccount, 0)) AS SatCount, '1' AS id FROM tblexamblockcount where DAYNAME(STR_TO_DATE(examdate,'%m/%d/%Y'))  = 'Saturday'
								and examid = " . $_SESSION["SESSSelectedExam"] .") AS B ON A.id = B.id
								INNER JOIN
								(SELECT SUM(COALESCE(supcount, 0)) + SUM(COALESCE(relcount, 0)) + SUM(COALESCE(cccount, 0)) AS EvenCount, '1' AS id FROM tblexamblockcount	where examslot  = 'Evening' and examid = " . $_SESSION["SESSSelectedExam"] .") AS C ON B.id = C.id
								INNER JOIN
								(SELECT SUM(COALESCE(supcount, 0)) + SUM(COALESCE(relcount, 0)) + SUM(COALESCE(cccount, 0)) AS MornCount, '1' AS id FROM tblexamblockcount	where examslot  = 'Morning' and examid = " . $_SESSION["SESSSelectedExam"] .") AS E ON B.id = E.id
								LEFT OUTER JOIN
								(SELECT '1' AS id, supcount, relcount, cccount, blocks, ebcrowid
								 FROM tblexamblockcount WHERE examid = " . $_SESSION["SESSSelectedExam"] .") AS D ON A.id = D.id ";
}						
						//echo $sql;

						// execute the sql query
						$result = $mysqli->query( $sql );
						echo $mysqli->error;
						$num_results = $result->num_rows;

						if( $num_results ){
							while( $row = $result->fetch_assoc() ){
								extract($row);
								echo "<TR class='odd gradeX'>";
								echo "<td>{$TotCount}</td>";
								echo "<td>{$Satcount}</td>";
								echo "<td>{$EvenCount}</td>";
								echo "<td>{$MornCount}</td>";
								echo "<td></td>";
							}
						}	

						$sql =  "SELECT A.RELRCCOUNT + B.PrefTotCount as ActTotCount, ActSatcount,ActEvenCount,ActMornCount
									FROM (SELECT COUNT(*) AS RELRCCOUNT FROM tblrelccduties WHERE ExamSchID IN (SELECT ExamSchID FROM tblexamschedule WHERE ExamID = " . $_SESSION["SESSSelectedExam"] .")) AS A,
									(SELECT COUNT(*) AS PrefTotCount , SUM(CASE WHEN ExamSlot = 'Evening' THEN 1 ELSE 0 END) AS ActEvenCount,
											SUM(CASE WHEN ExamSlot = 'Morning' THEN 1 ELSE 0 END) AS ActMornCount,
											SUM(CASE WHEN DAYNAME(STR_TO_DATE(ExamDate,'%m/%d/%Y')) = 'Saturday' THEN 1 ELSE 0 END) AS ActSatcount
									FROM tblprofessorpref WHERE ExamID = " . $_SESSION["SESSSelectedExam"] .") AS B";
						//echo $sql;
						// execute the sql query
						$result = $mysqli->query( $sql );
						echo $mysqli->error;
						$num_results = $result->num_rows;

						if( $num_results ){
							while( $row = $result->fetch_assoc() ){
								extract($row);
								echo "<td>{$ActTotCount}</td>";
								echo "<td>{$ActSatcount}</td>";
								echo "<td>{$ActEvenCount}</td>";
								echo "<td>{$ActMornCount}</td>";
								echo "</TR>";
							}
						}	


						
						//disconnect from database
						$result->free();
						$mysqli->close();
					
				?>
			</table>

	<div class="row-fluid" style="margin-left:5%">
			 <div class="span10" style="margin-left:3%">
			<table cellpadding="10" cellspacing="0" border="0" width="100%" class="tab_split" >
				<tr>
					<th style="width:14%">Exam Date</th>
					<th style="width:14%">Planned Morning</th>
					<th style="width:14%">Taken Morning</th>
					<th style="width:14%">Assigned Morning</th>
					<th style="width:14%">Planned Evening</th>
					<th style="width:14%">Taken Evening</th>
					<th style="width:14%">Assigned Evening</th>
				</tr>
			</table>
			</div>
	    <div class="span10 v_detail" style="overflow:scroll">
			<table cellpadding="10" cellspacing="0" border="0" width="100%" class="tab_split" >
				<?php
					include 'db/db_connect.php';
if($_SESSION["SESSSelectedExamType"] ==  'Online')
{
$sql = "select Concat(DATE_FORMAT(STR_TO_DATE(A.ExamDate,'%m/%d/%Y'), '%d %M %Y'),' - ',A.ExamSlot) as examdate, PM,0 as PE,AM,0 as AE,TMCount, 0 as TECount from 
(
SELECT DISTINCT ExamDate as examdate, COUNT(EB.ExamBlockID) AS PM,0 as PE, 0 as AE, 0 as TECount ,SUBSTRING(BlockName,LOCATE('@',BlockName)+1) as ExamSlot
FROM tblblocksmaster BM 
INNER JOIN tblexamblock EB ON BM.blockid = EB.blockid 
INNER JOIN tblexamschedule ES ON EB.ExamSchID = ES.ExamSchID 
INNER JOIN tblexammaster em ON BM.ExamID = em.ExamID WHERE em.ExamID = " . $_SESSION["SESSSelectedExam"] . "
Group by examdate,SUBSTRING(BlockName,LOCATE('@',BlockName)+1)
) as A LEFT OUTER JOIN (
select ExamDate,ExamSlot,count(*) as TMCount from tblprofessorpref where examid = " . $_SESSION["SESSSelectedExam"] . " Group by ExamDate,ExamSlot
) as B on A.ExamDate = B.ExamDate and A.ExamSlot = B.ExamSlot
LEFT OUTER JOIN (
SELECT DISTINCT ExamDate, SUBSTRING(BlockName,LOCATE('@',BlockName)+1) as ExamSlot,count(*) as AM
FROM tblexamblock EB 
INNER JOIN tblblocksmaster BM on BM.blockid = EB.blockid 
INNER JOIN tblexamschedule ES ON EB.ExamSchID = ES.ExamSchID 
INNER JOIN tblexammaster em ON ES.ExamID = em.ExamID 
WHERE em.ExamID = " . $_SESSION["SESSSelectedExam"] . " and ProfID is not null
group by ExamDate,SUBSTRING(BlockName,LOCATE('@',BlockName)+1)
) as C on A.ExamDate = C.ExamDate and A.ExamSlot = C.ExamSlot";
//echo $sql;

}
else
{
						$sql = "select DATE_FORMAT(STR_TO_DATE(ACT2.examdate,'%m/%d/%Y'), '%d %M %Y') as examdate,P.PMCount as PM,P.PECount as PE,ACT2.AMCount as AM,ACT2.AECount as AE,TMCount,TECount
								from 
								(SELECT examdate,
									sum(case examslot when 'Morning' then coalesce(supcount,0) + coalesce(relcount,0) + coalesce(cccount,0) else 0 end) as PMCount,
									sum(case examslot when 'Evening' then coalesce(supcount,0) + coalesce(relcount,0) + coalesce(cccount,0) else 0 end) as PECount
								FROM tblexamblockcount
								WHERE ExamID = " .  $_SESSION["SESSSelectedExam"] . " group by examdate) as P 
								inner join (
								select ACT.examdate,ACT.AMCount,ACT.AECount
								from (
								select A.examdate, 
								sum(case A.examslot when 'Morning' then A.CNT else 0 end) as AMCount,
								sum(case A.examslot when 'Evening' then A.CNT else 0 end) as AECount
								from 
								(SELECT examdate,examslot,(count(distinct eb.profid) + count(distinct rc.Profid)) as CNT  
								FROM tblexamschedule es  
								LEFT OUTER JOIN tblexamblock eb ON eb.ExamSchID = es.ExamSchID 
								LEFT OUTER JOIN tblrelccduties rc on rc.ExamSchID = es.ExamSchID
								WHERE es.ExamID = " .  $_SESSION["SESSSelectedExam"] . "
								Group by examdate,examslot) as A
								group by A.examdate) as ACT) as ACT2
								on P.examdate = ACT2.examdate
								LEFT OUTER JOIN (SELECT examdate, SUM(CASE examslot WHEN 'Morning' THEN 1 ELSE 0 END) AS 
									TMCount, SUM(CASE examslot WHEN 'Evening' THEN 1 ELSE 0 END) AS TECount 
								FROM tblprofessorpref WHERE ExamID = " .  $_SESSION["SESSSelectedExam"] . "
								 GROUP BY examdate) 
								AS T  ON P.examdate = T.examdate 
								group by ACT2.examdate";
}
										
						//WHERE P.PMCount <> 0
						//echo $sql;
						
						// execute the sql query
						$result = $mysqli->query( $sql );
						//echo $mysqli->error;
						$num_results = $result->num_rows;
						if( $num_results ){
							while( $row = $result->fetch_assoc() ){
								extract($row);
								echo "<TR class='odd gradeX'>";
								echo "<td style='width:16%'>{$examdate}</td>";
								echo "<td style='width:14%'>{$PM}</td>";
								echo "<td style='width:14%'>{$TMCount}</td>";			
								echo "<td style='width:14%'>{$AM}</td>";			
								echo "<td style='width:14%'>{$PE}</td>";
								echo "<td style='width:14%'>{$TECount}</td>";			
								echo "<td style='width:14%'>{$AE}</td>";			
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
