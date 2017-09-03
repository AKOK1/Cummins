<?php
		if(!isset($_SESSION)){
			session_start();
		}
//include database connection
	include 'db/db_connect.php';
	if ($_GET['IUD'] == 'U') {
	
		 echo $_GET['profid'] . "<br/>" ;
		 echo $_SESSION["EduYearFrom"] . "<br/>" ;
		 echo $_SESSION["EduYearTo"] . "<br/>" ;
		 echo $_GET['paperid'] . "<br/>" ;
		 //echo $_GET['div'] . "<br/>" ;
		 echo $_GET['papertype'] . "<br/>" ;

		$sql = "insert into tblyearstructprof (YSID,profid,btchid) values(?,?,?);";
		//$sql = "Update tblyearstruct set profid = ? WHERE eduyearfrom  = ? and eduyearto = ? and paperid = ? and `div` = ? and papertype = ? and coalesce(batchid,0) = ?;";
		$stmt = $mysqli->prepare($sql);
		//$stmt->bind_param('iiiissi',  $_GET['profid'], $_SESSION["EduYearFrom"], $_SESSION["EduYearTo"], $_GET['paperid'], $_GET['div']  , $_GET['papertype'],$_GET['batchid']);
		$stmt->bind_param('iii',  $_GET['YSID'], $_GET['profid'],$_GET['batchid']);
		//if($stmt->execute()){} 
		//else{ echo $mysqli->error;}

		if($stmt->execute()){
			header("Location: SubProfMap2Main.php?profname={$_GET['profname']}&profid={$_GET['profid']}&Sem={$_GET['Sem']}&IsOpenElective={$_GET['IsOpenElective']}"); 
		} else{
			echo $mysqli->error;
		}
	} 
	else {
		$sql = "delete from tblyearstructprof WHERE YSID  = ? and profid = ? and btchid = ?";
		//$sql = "Update tblyearstruct set profid = NULL WHERE rowid  = ? ;";
		$stmt = $mysqli->prepare($sql);
		$stmt->bind_param('iii', $_GET['YSID'], $_GET['profid'],$_GET['batchid'] );
		//$stmt->bind_param('i', $_GET['rowid'] );
		if($stmt->execute()){} 
		else{ echo $mysqli->error;}
		if($stmt->execute()){
		header("Location: SubProfMap2Main.php?profname={$_GET['profname']}&profid={$_GET['profid']}&Sem={$_GET['Sem']}&IsOpenElective={$_GET['IsOpenElective']}"); 
		} else{
			echo $mysqli->error;
		}
		
	}
?>

<form >
	<h3 class="page-title" style="margin-left:5%">File Upload Maintenance</h3>
	</form>

