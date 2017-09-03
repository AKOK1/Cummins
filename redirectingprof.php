<?php  
if(!isset($_SESSION)){
	session_start();
}
$_SESSION["SESSFrom"] = $_GET['fromadmin'];

$_SESSION["SESSUserID"] = $_GET['userID'];

header('Location: profviewmain.php'); 

?>
