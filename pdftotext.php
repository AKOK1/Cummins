<?php
	include 'db/db_connect.php';
	ini_set('max_execution_time', 2000);
	if(!isset($_SESSION)){
		session_start();
	}
	ini_set('max_execution_time', 2000);

	// conversion  code starts
	if(isset($_FILES['fileToUpload'])) {
		$errors     = array();
		$maxsize    = 2097152;
		$acceptable = array('application/pdf');
		if(($_FILES['fileToUpload']['size'] >= $maxsize) || ($_FILES["fileToUpload"]["size"] == 0)) {
			$errors[] = 'File too large. File must be less than 2 megabytes.';
		}
		if((!in_array($_FILES['fileToUpload']['type'], $acceptable)) && (!empty($_FILES["fileToUpload"]["type"]))) {
			$errors[] = 'Invalid file type. Only PDF is accepted.';
		}
		if(count($errors) === 0) {
			$info = pathinfo($_FILES['fileToUpload']['name']);
			 $ext = $info['extension']; // get the extension of the file
			 $filename = $_FILES['fileToUpload']['name'];
			 $newname = substr($filename, 0,strlen($filename)-4).'.txt'; 
			 $target = 'uploads/'.$newname;
			 //move_uploaded_file( $_FILES['fileToUpload']['tmp_name'], $target);
			 move_uploaded_file( $_FILES['fileToUpload']['tmp_name'], 'uploads/'. $filename);

			 //$output = shell_exec('/usr/bin/pdftotext -layout '. $target);
			 $output = shell_exec('/usr/bin/pdftotext -layout -nopgbrk -eol dos -enc Windows-1255 uploads/' . $filename . ' ' . $target);
			 //$output = shell_exec('/usr/bin/pdftotext -layout -enc Windows-1255 uploads/' . $filename . ' ' . $target);
			 //$output = shell_exec('/usr/bin/pdftotext -layout uploads/newname.pdf uploads/newname.txt');
			 //$output = shell_exec('ls -lart');
				//echo "<pre>File uploaded successfully!</pre>";
		}
	}
	else {
		foreach($errors as $error) {
			echo "<pre>$error</pre>";
		}
	}
		//echo "after PDF conversion";

	// conversion code ends
	//echo $target;


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