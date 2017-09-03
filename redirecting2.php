<?php  
if(!isset($_SESSION)){
	session_start();
}
$_SESSION["SESSFrom"] = $_GET['fromadmin'];

//$_SESSION["SESSStdId"] = $_GET['userID'];

$_SESSION["cnum"] = $_GET['cnum'];

$_SESSION["stdname"] = $_GET['stdname'];


header('Location: AcadsListMain.php'); 

?>
