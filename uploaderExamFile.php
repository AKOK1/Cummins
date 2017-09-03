<?php
include 'db/db_connect.php';
$filename = $_FILES['fileToUpload']['name'];
echo ' A ' ;

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
	};
	/* copy( $_FILES['fileToUpload']['name'], "uploads/" ) or 
           die( "Could not copy file!"); */
}
else
{
    die("No file specified!");
}

	//$file_handle = fopen($path, "r");
	$file_handle = fopen($_FILES['fileToUpload']['tmp_name'], "r");
	$UploadedFileText = '';
	$i=0;
	$j=0;
	//echo $file_handle;
	while (!feof($file_handle) ) {
		$line_of_text = fgetcsv($file_handle, 1024);
		//echo $line_of_text;
		//echo count($line_of_text);
		for ($y = 0 ; $y <= count($line_of_text) - 1; $y++) {
			if ($line_of_text[$y] <> ''){
			//$StdinCol[$i] = $line_of_text[$y];
			//echo $StdinCol[$i];
			//$UploadedFileText = $UploadedFileText . $StdinCol[$i]. ',' ;
			//echo $line_of_text[$y];
			$UploadedFileText = $UploadedFileText . $line_of_text[$y]. ',' ;
			$i++;
			}
		}
	}

	include 'db/db_connect.php';
	$sqlUpdate = "Update tblexamschedule set UploadedFile = ? Where ExamSchID = ?";
	$stmt = $mysqli->prepare($sqlUpdate);
	$stmt->bind_param('si', $UploadedFileText, $_POST['txtExamSchId']);
	if($stmt->execute()){
		//header('Location: SubjectList.php?'); 
	} else{
		echo $mysqli->error;
		//die("Unable to update.");
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