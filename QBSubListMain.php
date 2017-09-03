<?php  
if(!isset($_SESSION)){
	session_start();
}
if(empty($_SESSION["authenticated"]) || $_SESSION["authenticated"] != 'true') {
    header('Location: login.php');
}
$page_content = 'QBSubList.php';
include('MasterPage.php');
?>
