<?php  
if(!isset($_SESSION)){
	session_start();
}
if(empty($_SESSION["authenticated"]) || $_SESSION["authenticated"] != 'true') {
    header('Location: login.php');
}
$page_content = 'AssignDiv.php';
include('MasterPage.php');
?>