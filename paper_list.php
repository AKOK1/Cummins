<?php
// list of printer types for specific manufacturer
session_start();
include 'db/db_connect.php';

header("Content-type: text/xml");
//$fp = fopen("log.txt", "a+");
$patid = $_POST['PatId'];
$deptid = $_POST['DeptId'];
//fwrite($fp, "\$man = $man - \$typ = $typ\n");
echo "<?xml version=\"1.0\" ?>\n";
echo "<papers>\n";

$select = "SELECT ES.PaperId, CONCAT(P.EnggPattern,'-',DM.DeptName,'-',CAST(EnggYear AS CHAR),'-',SubjectName,'-Students:',Students,'-Blocks:',Blocks) AS PaperName FROM tblexamschedule ES INNER JOIN tblpapermaster PM ON es.paperid = PM.paperid INNER JOIN tblsubjectmaster SM ON PM.SubjectID = SM.SubjectID INNER JOIN tbldepartmentmaster DM ON PM.DeptID = DM.DeptID INNER JOIN tblpattern P ON P.PatID = PM.EnggPattern WHERE ES.ExamID = " . $_SESSION["SESSExamID"] . " AND ES.ExamDate = '" . $patid . "' AND ES.ExamSlot = '" . $deptid . "' ORDER BY PaperName;";

try {
	foreach($mysqli->query($select) as $row) {
		echo "<ddlPaper>\n\t<id>".$row['PaperId']."</id>\n\t<name>".$row['PaperName']."</name>\n</ddlPaper>\n";
		//fwrite($fp, "man = ".$man." typ = ".$typ." model = ".$row['model_text']."\n");
	}
}
catch(PDOException $e) {
	echo $e->getMessage();
	die();
}
//fwrite($fp, "\n");
//fclose($fp);
echo "</papers>";
?>