<?php  
if(!isset($_SESSION)){
	session_start();
}
$_SESSION["PaperId"] = $_GET['PaperID'];

header('Location: StructureViewMain.php'); 

?>