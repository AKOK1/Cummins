<?php   
session_start();
if(empty($_SESSION["authenticated"]) || $_SESSION["authenticated"] != 'true') {
//    header('Location: login.php');
}
$page_content = 'UploadDTEFile.php';
include('MasterPage.php');	
?>
