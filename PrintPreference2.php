<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Exam Supervision Duty</title>
<style type="text/css">

.onlyprint {display: none;}
@media print
{    
  .onlyprint {display: block;}

    .no-print, .no-print *
    {
        display: none !important;
    }
}
body {
	margin-left: 0px;
	margin-top: 0px;
	font-family:Verdana, Geneva, sans-serif;
	font-size: 12px;
	
}
.th-heading {
	font-size:13px;
	font-weight:bold;	
	}
.fix-table, th, td {
	line-height:20px;
	height: 14px;
	border: solid 1px #666 ;
	text-align:left;
	text-indent:10px;
	}
.th {
	font-size:13px;
	font-weight: bold;
	background-color:#CCC;
	}
</style>
</head>

<body>
<div class="lock-header">
		<br/>
		<center><img class="center" alt="logo" src="images/logo.png"></center>
		<br/><br/>
		<h1><center>Exam Supervision Duty for <?php if(!isset($_SESSION)){
									session_start();
								}
							echo $_SESSION["SESSusername"]; ?></center></h1>
</div>
<center>
<table width="50%" border="0" cellpadding="0" cellspacing="0">
	<br/>
  <tr>
    <td>
	<table width="100%" cellpadding="5" cellspacing="0" class="fix-table">

	<?php
		if(!isset($_SESSION)){
			session_start();
		}
		include 'db/db_connect.php';
		  $sql = "SELECT ExamName,ExamType FROM tblexammaster WHERE examid = " . $_SESSION["SESSSelectedExam"];
			//echo $sql;
			// execute the sql query
			$result = $mysqli->query( $sql );
			$num_results = $result->num_rows;

			if( $num_results ){
				while( $row = $result->fetch_assoc() ){
					extract($row);
					echo "<TR>";
					echo "<td colspan='5' class='th-heading'><b>Exam: &nbsp</b>{$ExamName} </td>";
					echo "</TR>";
					if ($ExamType == 'Online'){
						//header('Location: ExamIndexOMain.php?'); 
						$_SESSION["SESSSelectedExamType"] =  'Online';
					}
					else {
						$_SESSION["SESSSelectedExamType"] =  'Classroom';
					}
				}
			}					
			//disconnect from database
			$result->free();
			$mysqli->close();

	?>
	

      <tr class="th">
        <td>Date</td>
        <td>Day</td>
        <td>Slot</td>
	<?php 
		if($_SESSION["SESSSelectedExamType"] ==  'Online'){
			echo "<td>Block</td>";
		}
	?>
        <td>Reporting Time</td>
      </tr>
	<?php
		if($_SESSION["SESSSelectedExamType"] ==  'Online'){

			/*$sql = "SELECT u.userID AS ProfPrefID
					, DATE_FORMAT(STR_TO_DATE(ExamDate,'%m/%d/%Y'), '%d %M %Y') AS ExamDateT, DAYNAME(STR_TO_DATE(ExamDate,'%m/%d/%Y')) AS ExamDay 
					,SUBSTRING(BlockName,LOCATE('@',BlockName)+1) AS ExamSlot
			FROM tblexamblock eb
			LEFT JOIN tblblocksmaster bm ON eb.BlockID = bm.BlockID 
			LEFT JOIN tblexamschedule es ON eb.ExamSchID = es.ExamSchID 
			LEFT OUTER JOIN vwuser u ON eb.ProfID = u.userID AND u.ExamID = ".$_SESSION["SESSSelectedExam"]."
			WHERE u.userID IS NOT NULL and es.ExamID = ".$_SESSION["SESSSelectedExam"]."
			ORDER BY CAST(bm.BlockNo AS UNSIGNED);";
			*/
			$sql = "SELECT distinct BlockName, DATE_FORMAT(STR_TO_DATE(ES.ExamDate,'%m/%d/%Y'), '%d %M %Y') AS ExamDateT, DAYNAME(STR_TO_DATE(ES.ExamDate,'%m/%d/%Y')) AS ExamDay, 
			SUBSTRING(BlockName,LOCATE('@',BlockName)+1) AS ExamSlot ,
			case when ((ES.ExamSlot = 'Morning') or (ES.ExamSlot like '%.M.%')) then RTM else RTE end as RT,
			SUBSTRING(BlockName,1,LOCATE('@',BlockName)-1) as actblockname
			FROM tblexamschedule ES
			LEFT OUTER JOIN tblexamblock  EB ON ES.ExamSchID = EB.ExamSchID
			LEFT OUTER JOIN tblblocksmaster BM ON BM.BlockID = EB.BlockID
			LEFT OUTER JOIN  tblprofessorpref PP on PP.ProfID = EB.ProfID 
			LEFT JOIN  tblexammaster em on em.examid = ES.examid 
			WHERE PP.ProfId = ".$_SESSION["SESSUserID"]." and ES.examid = ".$_SESSION["SESSSelectedExam"]." 
			UNION
			SELECT distinct '111:30 AM' as BlockName, DATE_FORMAT(STR_TO_DATE(ES.ExamDate,'%m/%d/%Y'), '%d %M %Y') AS ExamDateT, DAYNAME(STR_TO_DATE(ES.ExamDate,'%m/%d/%Y')) AS ExamDay, ExamSlot ,
			case when ((ExamSlot = 'Morning') or (ExamSlot like '%.M.%')) then RTM else RTE end as RT,
			'' as actblockname
			FROM tblrelccduties rc
			LEFT JOIN tblexamschedule ES ON ES.ExamSchID = rc.ExamSchID
			LEFT JOIN  tblexammaster em on em.examid = ES.examid 
			WHERE ES.examid = ".$_SESSION["SESSSelectedExam"]." and rc.Profid = ".$_SESSION["SESSUserID"]."
			ORDER BY ExamDateT, 
			SUBSTRING( ExamSlot,LOCATE(' ',ExamSlot)+1,4), CAST(SUBSTRING( ExamSlot,1,LOCATE(' ',ExamSlot)-1) AS UNSIGNED)	
			;";

		}
		else{
			$sql = "SELECT  ProfPrefID, 
			DATE_FORMAT(STR_TO_DATE(ExamDate,'%m/%d/%Y'), '%d %M %Y') AS ExamDateT, 
			DAYNAME(STR_TO_DATE(ExamDate,'%m/%d/%Y')) AS ExamDay, ExamSlot ,
			case when ((ExamSlot = 'Morning') or (ExamSlot like '%.M.%')) then RTM else RTE end as RT
			FROM tblprofessorpref pp
			LEFT JOIN  tblexammaster em on em.examid = pp.examid 
			WHERE ProfId = ".$_SESSION["SESSUserID"]." AND pp.ExamId = " .$_SESSION["SESSSelectedExam"]. " order by ExamDate, ExamSlot";
		}
		//echo $sql;
		include 'db/db_connect.php';
		// execute the sql query
		$result = $mysqli->query( $sql );
		$num_results = $result->num_rows;
		
		//echo $sql;
		if( $num_results ){
			while( $row = $result->fetch_assoc() ){
				extract($row);
				echo "<TR>";
				echo "<td>{$ExamDateT} </td>";
				echo "<td>{$ExamDay} </td>";
				echo "<td>{$ExamSlot}</td>";
					if($_SESSION["SESSSelectedExamType"] ==  'Online'){
						echo "<td>{$actblockname}</td>";
					}
				//echo "<td>" . substr($BlockName,strpos($BlockName,'@')+1) . "</td>";
				echo "<td>{$RT} </td>";
				echo "</TR>";
			}
		}					
		//disconnect from database
		$result->free();
		$mysqli->close();
	?>
    </table></td>
  </tr>
</table>
		<br/>
				<center><h2>Senior Supervisors</h2>
				<table cellpadding="5" cellspacing="0" class="fix-table" style="text-align:left">
					<tr class="th">
						<td>Name</td>
						<td>Date</td>
						<td>Email</td>
						<td>Mobile</td>
					</tr>
					<?php
						include 'db/db_connect.php';
						  $sql = "SELECT concat(u1.FirstName,' ',u1.LastName) as Sr1Name,
										Concat(coalesce(DATE_FORMAT(Sr1Start,'%d-%b-%Y'),''),' to ',coalesce(DATE_FORMAT(Sr1End,'%d-%b-%Y'),'')) as Span1,
										u1.Email as Email1,
										u1.ContactNumber as Phone1,
										concat(u2.FirstName,' ',u2.LastName) as Sr2Name,
										Concat(coalesce(DATE_FORMAT(Sr2Start,'%d-%b-%Y'),''),' to ',coalesce(DATE_FORMAT(Sr2End,'%d-%b-%Y'),'')) as Span2,
										u2.Email as Email2,
										u2.ContactNumber as Phone2
									from tblexammaster em 
									left outer join tbluser u1 on u1.userID = coalesce(em.Sr1Name,0)
									left outer join tbluser u2 on u2.userID = coalesce(em.Sr2Name,0)
									where ExamID = " . $_SESSION["SESSSelectedExam"];
							//echo $sql;
							// execute the sql query
							$result = $mysqli->query( $sql );
							$num_results = $result->num_rows;

							if( $num_results ){
								while( $row = $result->fetch_assoc() ){
									extract($row);
									echo "<TR>";
									if($Sr1Name <> ''){
										echo "<td>{$Sr1Name}</td>";
										echo "<td>{$Span1}</td>";
										echo "<td>{$Email1}</td>";
										echo "<td>{$Phone1}</td>";
										echo "</TR>";
										echo "<TR>";
									}
									if($Sr2Name <> ''){
										echo "<td>{$Sr2Name}</td>";
										echo "<td>{$Span2}</td>";
										echo "<td>{$Email2}</td>";
										echo "<td>{$Phone2}</td>";
										echo "</TR>";
									}
								}
							}					
							//disconnect from database
							$result->free();
							$mysqli->close();
					?>
<!--			<tr>
				<td>1 - 5 September 2015</td>
				<td>Mrs. Yogini Kulkarni</td>
				<td>admin@cumminscollege.in</td>
				<td>9423566528</td>
			<tr>
-->
			</table>
		<br/>
		<input type="button" value="Print" title="Print" onclick='var d = new Date();document.getElementById("lbltime").innerHTML = "Printout Time - " + d;window.print();' class="btn btn-success no-print" />
		<h5 class="onlyprint" id="lbltime"></h5>

</center>

</body>
</html>
