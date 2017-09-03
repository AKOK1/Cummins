<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Publications</title>
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
</style>
</head>

<body>
	<br/>
	<center><img class="center" alt="logo" src="images/logo.png"></center>
	<br/>
	<table width="90%" border="0" cellpadding="5" cellspacing="0" class="fix-table" style="margin-left: 0.5%;">
	<TR><td colspan='24' class='th-heading'><center><h2>Publications</center></td></TR>

	<TR>
		<td colspan='24' class='th-heading'>
		Department: <?php echo $_GET['dept'];?>&nbsp;
		</td>		
	</TR>
	<tr class="th">
		<td width="25%">User Name</td>
		<td width="5%">Type</td>
		<td width="5%">Publisher</td>
		<td width="5%">Volume</td>
		<td width="5%">Pages</td>
	    <td width="30%">Title of Paper</td>
		<td width="35%">Authors</td>
		<td width="5%">Year</td>
		<td width="5%">Month</td>	
		<td width="5%">Doi</td>
		<td width="5%">URL</td>
		<td width="5%">Impact Factor</td>
		<td width="5%">Abstract</td>
		<td width="5%">Status of Paper</td>
		<td width="5%">Is This International?</td>
		<td width="5%">ISSN</td>
		<td width="5%">Is This Open Access?</td>
		<td width="5%">Is This Peer Reviewed?</td>
		<td width="5%">Editors</td>
		<td width="5%">Address</td>
		<td width="5%">ISBN</td>
		<td width="5%">Patent Number</td>
		<td width="5%">Country</td>
		<td width="5%">Patent Status</td>
	</tr>	
	<?php
	if(!isset($_SESSION)){
		session_start();
	} 
		include 'db/db_connect.php';
		
				$query = "SELECT tp.userid,Concat(tu.FirstName, ' ' ,tu.LastName) as userName, 
				pubtype,journlpub,volume,pages,papertitle,authors1,year,month,doi,url,impactfactor,abstract,paperstatus,
				internjournal,ISSN,openacjournal,peer,'' as Editors,'' as addr, '' as ISBN,'' as pnum,'' as country, '' as pstatus
				 FROM tblpublications tp 
				  INNER JOIN tbluser tu ON tu.userID = tp.userid
				 where tu.Department = '" . $_GET['dept'] . "' 
				 and tu.userType IN ('HOD','Faculty','TA','Ad-hoc')
				 UNION
				 SELECT b.userid,Concat(tu.FirstName, ' ' ,tu.LastName) as userName, 
				'Book' as pubtype,'' as journlpub,'' as volume,'' as pages,bktitle as papertitle,pauthor as authors1,byear as year,
				'' as month,'' as doi,bookurl as url,'' as impactfactor,'' as abstract,'' as paperstatus,
				'' as internjournal,'' as ISSN,'' as openacjournal,'' as peer,Editors,addr,ISBN,'' as pnum,'' as country, '' as pstatus
				 FROM tblpublbook b 
				  INNER JOIN tbluser tu ON tu.userID = b.userid
				 where tu.Department = '" . $_GET['dept'] . "' 
				 and tu.userType IN ('HOD','Faculty','TA','Ad-hoc')
				 UNION
				 SELECT p.userid,Concat(tu.FirstName, ' ' ,tu.LastName) as userName, 
				'Patent' as pubtype, '' as journlpub,'' as volume,'' as pages,patenttitle as papertitle,author as authors1,year1 as year,
				'' as month,'' as doi,paturl as url,'' as impactfactor,'pabst' as abstract,'' as paperstatus,'' as Editors,'' as addr, '' as ISBN,
				'' as internjournal,'' as ISSN,'' as openacjournal,'' as peer,pnum,country,pstatus
				 FROM tblpubpatent p 
				  INNER JOIN tbluser tu ON tu.userID = p.userid
				 where tu.Department = '" . $_GET['dept'] . "' 
				 and tu.userType IN ('HOD','Faculty','TA','Ad-hoc') 
				 order by userName,pubtype";
				//echo $query;
				if($_GET['dept'] == 'All') {
				$query = "SELECT tp.userid,Concat(tu.FirstName, ' ' ,tu.LastName,' - ' ,tu.Department) as userName, 
				pubtype,journlpub,volume,pages,papertitle,authors1,year,month,doi,url,impactfactor,abstract,paperstatus,internjournal,
				ISSN,openacjournal,peer,'' as Editors,'' as addr,'' as ISBN,'' as pnum,'' as country, '' as pstatus
				 FROM tblpublications tp
				 INNER JOIN tbluser tu ON tu.userID = tp.userid 
				 where tu.userType IN ('HOD','Faculty','TA','Ad-hoc')
				 UNION
				 SELECT b.userid,Concat(tu.FirstName, ' ' ,tu.LastName,' - ' ,tu.Department) as userName, 
				'Book' as pubtype,publisher as journlpub,'' as volume,'' as pages,bktitle as papertitle,pauthor as authors1,byear as year,
				'' as month,'' as doi,bookurl as url,'' as impactfactor,'' as abstract,'' as paperstatus,
				'' as internjournal,'' as ISSN,'' as openacjournal,'' as peer,Editors,addr,ISBN,'' as pnum,'' as country, '' as pstatus
				 FROM tblpublbook b 
				  INNER JOIN tbluser tu ON tu.userID = b.userid 
				  where tu.userType IN ('HOD','Faculty','TA','Ad-hoc')
				 UNION
				 SELECT p.userid,Concat(tu.FirstName, ' ' ,tu.LastName,' - ' ,tu.Department) as userName, 
				'Patent' as pubtype,'' as journlpub,'' as volume,'' as pages,patenttitle as papertitle,author as authors1,year1 as year,
				'' as month,'' as doi,paturl as url,'' as impactfactor,'' as abstract,'' as paperstatus,
				'' as internjournal,'' as ISSN,'' as openacjournal,'' as peer,'' as Editors,'' as addr,'' as ISBN,pnum,country,pstatus
				 FROM tblpubpatent p 
				  INNER JOIN tbluser tu ON tu.userID = p.userid 
				  where tu.userType IN ('HOD','Faculty','TA','Ad-hoc')
				  order by userName,pubtype;";
				}

			//echo $query;
			//twohrsduties is not null and otherhrsduties is not null
			// execute the sql query
			//echo $sql;
			$result = $mysqli->query( $query );
			echo $mysqli->error;
			$num_results = $result->num_rows;
			//echo $sql;
			if( $num_results ){
				while( $row = $result->fetch_assoc() ){
					extract($row);
					echo "<TR>";
					echo "<td>{$userName} </td>";
				    echo "<td>{$pubtype} </td>";
					echo "<td>{$journlpub} </td>";
					echo "<td>{$volume} </td>";
					echo "<td>{$pages} </td>";
					echo "<td>{$papertitle} </td>";
					echo "<td>{$authors1} </td>";
					echo "<td>{$year} </td>";
					echo "<td>{$month} </td>";
					echo "<td>{$doi} </td>";
					echo "<td>{$url} </td>";
					echo "<td>{$impactfactor} </td>";
					echo "<td>{$abstract} </td>";
					echo "<td>{$paperstatus} </td>";
					echo "<td>{$internjournal} </td>";
					echo "<td>{$ISSN} </td>";
					echo "<td>{$openacjournal} </td>";
					echo "<td>{$peer}</td>";
					echo "<td>{$Editors}</td>";
					echo "<td>{$addr}</td>";
					echo "<td>{$ISBN}</td>";
					echo "<td>{$pnum}</td>";
					echo "<td>{$country}</td>";
					echo "<td>{$pstatus}</td>";
					echo "</TR>";
				}
			}					

			//disconnect from database	
			$result->free();
			$mysqli->close();
	?>

    </table>


</body>
</html>