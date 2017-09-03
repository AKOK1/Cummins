<?php  
if(!isset($_SESSION)){
	session_start();
}
$_SESSION["SESSFrom"] = $_GET['fromadmin'];

//$_SESSION["SESSStudentID"] = $_GET['userID'];

$_SESSION["stdcnum"] = $_GET['cnum'];

$_SESSION["stdname"] = $_GET['stdname'];

header('Location: PrintStudentAdmin.php'); 

?>
