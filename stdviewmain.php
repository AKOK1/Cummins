<?php  
session_start();
if(empty($_SESSION["authenticated"]) || $_SESSION["authenticated"] != 'true') {
    header('Location: login.php');
}  
$page_content = 'stdview.php';
include('MasterPageStudent.php');
?>
