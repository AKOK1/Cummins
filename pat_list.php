<?php
echo "comes";
session_start();
// pat_list
include 'db/db_connect.php';

header("Content-type: text/xml");
echo "<?xml version=\"1.0\" ?>\n";
echo "<companies>\n";
$select = "SELECT 0 AS PatId, ' Select Pattern'  AS EnggPattern UNION SELECT DISTINCT PatId, P.EnggPattern FROM tblPaperMaster PM, tblpattern P, tblExamSchedule ES WHERE PM.EnggPattern = P.EnggPattern AND PM.paperID = ES.PaperID AND ES.ExamID = " . $_SESSION["SESSExamID"] . " ORDER BY PatId;";
try {
	foreach($dbh->query($select) as $row) {
		echo "<Company>\n\t<id>".$row['PatId']."</id>\n\t<name>".$row['EnggPattern']."</name>\n</Company>\n";
	}
}
catch(PDOException $e) {
	echo $e->getMessage();
	die();
}
echo "</companies>";
?>