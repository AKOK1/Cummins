<?php
session_start();
if(empty($_SESSION["authenticated"]) || $_SESSION["authenticated"] != 'true') {
    header('Location: login.php');
}  
$page_content = 'profpref.php';
include('MasterPage.php');
?>
