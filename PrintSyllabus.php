<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Syllabus Report</title>
<style type="text/css">
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
table, th, td {
    border: 1px solid black;
}
table.tblsub td.marks {
  text-align: right;
}
table.tblsub td.marks1 {
  text-align: right;
}

</head>
</style>
</head>
<body>
		<br/>
	<center><img class="center" alt="logo" src="images/logo.png"></center>
	<br/>
	<table width="90%" cellpadding="5" cellspacing="0" class="fix-table" style="margin-left: 5%;">
	<TR>
		<td colspan='7' class='th-heading'><center>Syllabus Report- <?php echo $_GET['SubName']?> </center></td>
	</TR>
	</table>
	<br/><br/>
	<?php
		if(!isset($_SESSION)){
			session_start();
		} 
		
		include 'db/db_connect.php';

		$sql = "select Lecture, Tutorial, InSem, EndSem from tblpapermaster where PaperID = ". $_GET['PaperID'] .  " ";
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
	?>
		
	<table class="tblsub" width="90%" border="0" cellpadding="5" cellspacing="0" class="fix-table" style="margin-left: 5%;">
		<tr class="th">
			<td>Teaching Scheme:</td>
			<td>Examination Scheme:</td>
        </tr>
		<tr>
			<td>Lectures: <?php echo $Lecture ; ?> Hrs/Week</td>
			<td class="marks1">In-Semester: <?php echo $InSem ; ?> Marks</td>
        </tr>
		<tr>
			<td>Tutorial: <?php echo $Tutorial ; ?> Hrs/Week</td>
			<td class="marks1">End-Semester: <?php echo $EndSem ; ?> Marks</td>
        </tr>
		<tr>
			<td width="15%"></td>
			<td class="marks1">Credits: 3</td>
        </tr>
		<tr><td colspan='8'></td></tr>

		<tr>
			<td colspan='8'>
				<b>Course Objectives:</b><br/>
				<?php 
					include 'db/db_connect.php';
					$sql = "select @a:=@a+1 AS SrNo, coursedesc 
						from (SELECT @a:= 0) AS a , tblsyllaobj 
						where paperid = ". $_GET['PaperID'] .  " ";
					$result = $mysqli->query( $sql );
					while ($row = mysqli_fetch_assoc($result))  
					{
						extract($row);
						echo "&nbsp;&nbsp;" . $SrNo . ". " . $coursedesc . "<br/>";
					}
				?>
			</td>
		</tr>

		<tr>
			<td colspan='8'>
				<b>Course Outcomes:</b></br>
				<?php 
					include 'db/db_connect.php';
					$sql = "select @a:=@a+1 AS SrNo, coursedesc 
						from (SELECT @a:= 0) AS a , tblsyllaoutcome 
						where paperid = ". $_GET['PaperID'] .  " ";
					$result = $mysqli->query( $sql );
					while ($row = mysqli_fetch_assoc($result))  
					{
						extract($row);
						echo "&nbsp;&nbsp;" . $SrNo . ". " . $coursedesc . "<br/>";
					}
				?>
			</td>
        </tr>
		
		<tr><td colspan='8'></td></tr>

		<?php 
			include 'db/db_connect.php';
			$sql = "select @a:=@a+1 AS SrNo, sname, hrs, Syllabusdesc 
				from (SELECT @a:= 0) AS a , tblsyllacontents 
				where paperid = ". $_GET['PaperID'] .  " ";
			$result = $mysqli->query( $sql );
			while ($row = mysqli_fetch_assoc($result))  
			{
				extract($row);
				echo "<tr>";
				echo "<td class='th-heading'  width='80%'> Unit - " . $SrNo . ": " . $sname ;
				echo "</td>";
				echo "<td class='marks'>No. of Hrs : " . $hrs ."</td>";
				echo "</tr>";
				echo "<tr>";
				echo "<td colspan='8'> " . $Syllabusdesc  ."</td>";
				echo "</tr>";
				
			}
		?>

		<tr><td colspan='8'></td></tr>
		<tr>
			<td colspan="8">
				<b>Text Books:</b></br>
				<?php 
					include 'db/db_connect.php';
					$sql = "select @a:=@a+1 AS SrNo, textbooks 
						from (SELECT @a:= 0) AS a , tblsyllabooks
						where paperid = ". $_GET['PaperID'] .  " ";
					$result = $mysqli->query( $sql );
					while ($row = mysqli_fetch_assoc($result))  
					{
						extract($row);
						echo "&nbsp;&nbsp;" . $SrNo . ". " . $textbooks . "<br/>";
					}
				?>
			</td>
        </tr>

		<tr><td colspan='8'></td></tr>
		<tr>
			<td colspan="8">
				<b>Reference Books:</b></br>
				<?php 
					include 'db/db_connect.php';
					$sql = "select @a:=@a+1 AS SrNo, refbooks  
						from (SELECT @a:= 0) AS a , tblsyllarefbooks 
						where paperid = ". $_GET['PaperID'] .  " ";
					$result = $mysqli->query( $sql );
					while ($row = mysqli_fetch_assoc($result))  
					{
						extract($row);
						echo "&nbsp;&nbsp;" . $SrNo . ". " . $refbooks  . "<br/>";
					}
				?>
			</td>
        </tr>
	</table>
</body>
</html>