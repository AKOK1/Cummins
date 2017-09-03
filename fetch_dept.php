<?php
session_start();
// list of departments for specific pattern
include 'db/db_connect.php';

header("Content-type: text/xml");
$patid = $_POST['PatId'];

echo "<?xml version=\"1.0\" ?>\n";
echo "<departments>\n";
$select = "SELECT DISTINCT ExamSlot AS DeptId, ExamSlot AS DeptName FROM tblexamschedule WHERE ExamID = " . $_SESSION["SESSExamID"] . " AND ExamDate = '" . $patid . "' ORDER BY DeptId;";

try {
	foreach($mysqli->query($select) as $row) {
		//If ((isset($_SESSION["SESSDeptId"]) && ($_SESSION["SESSDeptId"] == $row['DeptId'])) 
		//{echo "<ddlDept>\n\t<id>".$row['DeptId']." selected</id>\n\t<name>".$row['DeptName']."</name>\n</ddlDept>\n";}
		//Else
		//{
			echo "<ddlDept>\n\t<id>".$row['DeptId']."</id>\n\t<name>".$row['DeptName']."</name>\n</ddlDept>\n";
		//}
	}
}
catch(PDOException $e) {
	echo $e->getMessage();
	die();
}
echo "</departments>";
?>
