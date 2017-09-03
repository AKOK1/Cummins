<?php
include 'db/db_connect.php';
$filename = $_FILES['fileToUpload']['name'];
echo ' A ' ;
echo $_POST['ddlPaper'];
 if( $_FILES['fileToUpload']['name'] != "" )
{
	echo ' B ';
	echo $_FILES['fileToUpload']['tmp_name'];
	//move_uploaded_file($_FILES['fileToUpload']['tmp_name'], "/uploads/".$filename);

	$sqlU = "Update tblexamblock set FileName = '" . $_FILES['fileToUpload']['name'] . "' Where PaperID = " . $_POST['ddlPaper'] ;

	if ($mysqli->query($sqlU) === TRUE) {
		} 
	else {
			echo "Error updating record: " . $mysqli->error;
		}
	;
	/* copy( $_FILES['fileToUpload']['name'], "uploads/" ) or 
           die( "Could not copy file!"); */
}
else
{
    die("No file specified!");
}

	//$file_handle = fopen($path, "r");
	$file_handle = fopen($_FILES['fileToUpload']['tmp_name'], "r");
	$i = 0;
	$y = 0;
	while (!feof($file_handle) ) {
		$line_of_text = fgetcsv($file_handle, 1024);
		for ($y = 0 ; $y <= count($line_of_text) - 1; $y++) {
			if ($line_of_text[$y] <> ''){
			$StdinCol[$i] = $line_of_text[$y];
			print $StdinCol[$i];
			$i++;
			}
		}
	}

	$stdCnt = count($StdinCol); 

	$j=0;
	include 'db/db_connect.php';
	$query = "SELECT ExamBlockID, Allocation FROM tblexamblock EB INNER JOIN tblblocksmaster BM ON EB.BlockID = BM.BlockID
				Where BlockType = 'Laboratory' and PaperID = " . $_POST['ddlPaper'] . " ORDER BY ExamBlockID, colorder ";
	echo $query;
	$result = $mysqli->query( $query );
	$num_results = $result->num_rows;

	//echo floor(44 / 5);
	//echo "FFFF";
	//echo 44 % 5;

	
	$sqlInsert = "Insert into tblexamblockstudent 
					(ExamBlockID, StdId, Created_by, Created_on)
					Values (?, ?, 'Admin', CURRENT_TIMESTAMP)";
		
		$i = 0;
		if( $num_results ){
			while( $row = $result->fetch_assoc() ){
				extract($row);
			//$j = floor($Allocation / 5);
			//$jmod = $Allocation % 5;
				
				for ($k = 0 ; $k < $Allocation ; $k++) {
					$stmt = $mysqli->prepare($sqlInsert);
					$stmt->bind_param('is', $ExamBlockID, $StdinCol[$i]);
						if($stmt->execute()){
							//header('Location: SubjectList.php?'); 
						} else{
							echo $mysqli->error;
							//die("Unable to update.");
						}
					$i += 1;
				}
				
			/*	if ($jmod > 0){
					If ($i < $stdCnt) {$StdId1 = $StdinCol[$i]; $i += 1;} else {$StdId1 = '';}
					If ($i < $stdCnt) {$StdId2 = $StdinCol[$i]; $i += 1;} else {$StdId2 = '';}
					If ($i < $stdCnt) {$StdId3 = $StdinCol[$i]; $i += 1;} else {$StdId3 = '';}
					If ($i < $stdCnt) {$StdId4 = $StdinCol[$i]; $i += 1;} else {$StdId4 = '';}
					If ($i < $stdCnt) {$StdId5 = $StdinCol[$i]; $i += 1;} else {$StdId5 = '';}

					$stmt = $mysqli->prepare($sqlInsert);
					$stmt->bind_param('isssss', $ExamBlockID, $StdId1, $StdId2, $StdId3	, $StdId4, $StdId5);
					if (trim($StdId1) != '') {
						if($stmt->execute()){
							//header('Location: SubjectList.php?'); 
						} else{
							echo $mysqli->error;
							//die("Unable to update.");
						}
					}					
				} */

			}
		}
	header("Location: BlockFileMain.php?ExamSchId1=" . $_POST['txtExamSchId'] . "&paperinfo=" . $_POST['txtPaperInfo'] . ""); 
?>

<html>
<head>
<title>Uploading Complete</title>
</head>
<body>

<h2>Uploaded File Info:</h2>
<ul>
<li>Sent file: <?php echo print_r($_FILES);  ?>
<li>Sent file: <?php echo $_FILES['fileToUpload']['name'];  ?>
<li>File size: <?php echo $_FILES['fileToUpload']['size'];  ?> bytes
<li>File type: <?php echo $_FILES['fileToUpload']['type'];  ?>
</ul>
</body>
</html>