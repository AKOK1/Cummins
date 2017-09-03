<?php
//include database connection
	include 'db/db_connect.php';
	echo $_GET['EduYearFrom'] . "<br/>";
	echo $_GET['EduYearTo'] . "<br/>";
	echo $_GET['paperid'] . "<br/>";
	echo $_GET['papertype'];
	//die;
	if ($_GET['IUD'] == 'D') {
		//$sql = "DELETE FROM tblyearstruct WHERE rowid  = ? ;";
		$sql = "DELETE FROM tblyearstruct WHERE eduyearfrom = ? and eduyearto = ? and paperid = ? and papertype = ?";
//echo $sql;
//die;		
$stmt = $mysqli->prepare($sql);
		//$stmt->bind_param('i', $_GET['rowid']  );
		$stmt->bind_param('iiis', $_GET['EduYearFrom'], $_GET['EduYearTo'], $_GET['paperid'], $_GET['papertype']);
		if($stmt->execute()){
		header("Location: SubMapMain.php?Year=" . $_GET['Year']); 
		} else{
			echo $mysqli->error;
		}
	} 
?>

<form >
	<h3 class="page-title" style="margin-left:5%">File Upload Maintenance</h3>
	</form>

