<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script type="text/x-mathjax-config">MathJax.Hub.Config({
  config: ["MMLorHTML.js"],
  jax: ["input/TeX","input/MathML","output/HTML-CSS","output/NativeMML"],
  extensions: ["tex2jax.js","mml2jax.js","MathMenu.js","MathZoom.js"],
  TeX: {
    extensions: ["AMSmath.js","AMSsymbols.js","noErrors.js","noUndefined.js"]
  }
});</script>
<script type="text/javascript" src="https://cdn.mathjax.org/mathjax/2.0-latest/MathJax.js?config=TeX-AMS-MML_HTMLorMML"></script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Question Paper</title>
<style type="text/css">
body {
	font-family:Verdana, Geneva, sans-serif;
	font-size: 12px;
	text-align:left;
	margin-left:5px;
	margin-top: 0px;
}
.footer {
	font-family:Verdana, Geneva, sans-serif;
	font-size:10px;
	}
.center-text {
	font-family:Verdana, Geneva, sans-serif;
	font-size:13px;
	text-decoration:underline;
	text-align:center;
	}
.simple-table {
	width:100%;
	border-collapse:collapse;
	border:0px;
	line-height:23px;
	}	
.fix-table {
	width:100%;
	border-collapse:collapse;
	border:0px;
	}
	
.fix-table, th, td {
	line-height:23px;
	text-align:left;
	text-indent:5px;
	}
.th {
	font-size:12px;
	}
	
.th-heading {
	font-size:13px;
	font-weight:bold;
	}

.branch-table {
	width:100%;
	border:1px solid #666;
	border-collapse:collapse;
	line-height:22px;
	text-align:center;
	vertical-align:middle;
	font-weight:bold;
	}
	
.branch-table td , th {
	border:1px solid #666;
	}
.hr {
	line-height:2px;
	}
</style>
</head>

<body>
<?php
		if(!isset($_SESSION)){
			session_start();
		}
		include 'db/db_connect.php';
		$query="SELECT * FROM tblquizdetails qd
				INNER JOIN tblpapermaster pm ON pm.PaperID = qd.paperid
				INNER JOIN tblSubjectMaster sm ON sm.SubjectID = pm.SubjectID
				WHERE quizid = " . $_SESSION["quizid"] . "";
		$run=mysqli_query($mysqli,$query);
		while($row=mysqli_fetch_array($run))
		{
			//$edit_id=$row['quizid'];
			//$quizname=$row['quizname'];
			//$quizstarttime=$row['quizstarttime'];
			//$quizendtime=$row['quizendtime'];
			$totaltime=$row['totaltime'];
			$outof=$row['outof'];
			$subjectname = $row['SubjectName'];
		}
?>
<table class="simple-table">
		 <TR>
			<td colspan='10' style="text-align:center;" class='th-heading'><h4>MKSSS's</h4></td>
		 </tr>
		 <TR>
			<td colspan='10' style="text-align:center;" class='th-heading'>
			<h2>Cummins College of Engineering For Women Pune</h2></td>
		 </tr>
		 <TR>
			<td colspan='10' style="text-align:center;" class='th-heading'>
			<h4>(Autonomous Institute affilated to Savitribai Phule Pune University)</h4></td>
		  </tr>
		 <TR>
			<td colspan='10' style="text-align:center;" class='th-heading'>
				<h3><?php echo $_SESSION["quizselectedexamname"]; ?></h3>
				<h3><?php echo $subjectname;  ?></h3>
			</td>
		  </tr>
		 <TR>
			<td colspan='10' style="text-align:center;" class='th-heading'>
				<div>
					<div style="float:left">
						<h3>Time: <?php echo $totaltime; ?> Minutes</h3>
					</div>
					<div style="float:right">
						<h4>Maximum Marks: <?php echo $outof; ?></h4>
					</div>
				</div>
			</tr>
		 <TR>
	<tr>
		<td><strong>Instruction:</strong></td>
	</tr>
		<?php
			// Create connection
			include 'db/db_connect.php';
			$query = "SELECT qtype,instno,
					CASE qtype WHEN 'Q' THEN QText ELSE CASE qtype WHEN 'I' THEN inst ELSE '' END END AS qtext, 
					COALESCE(qmarks,0) AS marks ,coalesce(photopath,'') as photopath
					FROM tblquizques QQ 
					LEFT OUTER JOIN tblquestionmaster QM ON QQ.qid = QM.qid 
					WHERE quizid = " . $_SESSION["quizid"] . "  
					ORDER BY qnoorder  ";
			//echo $query;
			$result = $mysqli->query( $query );
			$num_results = $result->num_rows;
			$i = 1;
			if( $num_results ){
				while( $row = $result->fetch_assoc() ){
					extract($row);
					if($qtype == 'P'){
						echo "</table>";
						echo "<p style='page-break-after:always;'></p>";
						echo "</br></br>";
						echo "<table class='simple-table'>";
					}
					else{
							echo "<TR class='odd gradeX'>";
							echo "<td>{$instno}</td>";
							echo "<td><div style='word-wrap: break-word;'>{$qtext}</div></td>";
							if($photopath == ''){
								echo "</TR>";
							}
							else{
								echo "</TR>";
								echo "<TR class='odd gradeX'>";
								echo "<td></td>";
								echo "<td><img src=qimages/". $photopath . " alt=''  />";
								echo "</TR>";
							}
					}
				  $i = $i + 1;
				}
			}
		?> 
</table>
</body>
<script type="text/javascript">
  MathJax.Hub.Configured()
</script>