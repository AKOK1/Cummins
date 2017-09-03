<?php  
if(!isset($_SESSION)){
	session_start();
}
$_SESSION["SESSFrom"] = $_GET['fromadmin'];

$_SESSION["SESSStdId"] = $_GET['userID'];

$_SESSION["selyear"] = $_GET['selyear'];

$_SESSION["seldept"] = $_GET['seldept'];

$_SESSION["selacadyear"] = $_GET['selacadyear'];

header('Location: stdviewmain.php'); 

?>
