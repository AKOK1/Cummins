<form action='' method='POST' enctype='multipart/form-data'>
<br/><br/><br/><br/>
<input type='file' name='userFile'><br>
<input type='submit' name='upload_btn' value='upload'>
</form>
<?php
if(isset($_FILES['userFile'])) {
    $errors     = array();
    $maxsize    = 2097152;
    $acceptable = array('application/pdf');

    if(($_FILES['userFile']['size'] >= $maxsize) || ($_FILES["userFile"]["size"] == 0)) {
        $errors[] = 'File too large. File must be less than 2 megabytes.';
    }

    if((!in_array($_FILES['userFile']['type'], $acceptable)) && (!empty($_FILES["userFile"]["type"]))) {
		$errors[] = 'Invalid file type. Only PDF is accepted.';
	}

	if(count($errors) === 0) {
		$info = pathinfo($_FILES['userFile']['name']);
		 $ext = $info['extension']; // get the extension of the file
		 $newname = "newname.".$ext; 
		 $target = 'uploads/'.$newname;
		 move_uploaded_file( $_FILES['userFile']['tmp_name'], $target);

		 $output = shell_exec('/usr/bin/pdftotext -layout '. $target);
		 //$output = shell_exec('/usr/bin/pdftotext -layout uploads/newname.pdf uploads/newname.txt');
		 //$output = shell_exec('ls -lart');
			echo "<pre>File uploaded successfully!</pre>";
	} 
	else {
		foreach($errors as $error) {
			echo "<pre>$error</pre>";
		}

		die(); //Ensure no more processing is done
	}
}

 ?>