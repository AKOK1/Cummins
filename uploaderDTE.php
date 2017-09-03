<html>
<head>
	<title>Uploading Complete</title>
</head>
<body>

<h2>Uploaded File Info:</h2>
<h3 class="page-title" style="float:right;margin-top:-40px;margin-right:10px"><a href="UploadDTEFileMain.php">Back</a></h3>
<h3 class="page-title" style="float:right;margin-top:-40px;margin-right:20px" onclick="window.print();"><a href="#">Print</a></h3>

<ul>

<?php 
include 'db/db_connect.php';
$filename = $_FILES['fileToUpload']['name'];
	if(!isset($_SESSION)){
		session_start();
	}

 if( $_FILES['fileToUpload']['name'] != "" )
{
}
else
{
    die("No file specified!");
}

	$e = 0;
	$i = 0;
	$y = 0;
	$file_handle = fopen($_FILES['fileToUpload']['tmp_name'], "r");
	
	while (!feof($file_handle) ) {
		$line_of_text = fgetcsv($file_handle, 1024);
		$MName = '';
		$LName = '';
		if ($i == 0){
			$i = $i + 1;
			continue;
		}
		if ($line_of_text[$y] <> ''){
			$AppId = $line_of_text[1];
			//$StdName = explode(' ', $line_of_text[2]);
			//$LName = $StdName[0];
			// if (count($StdName) > 1) {
				// $FName = $StdName[1];
			// }
			// if (count($StdName) > 2) {
				// $MName = $StdName[2];
			// }
			$LName = $line_of_text[2];
			$FName = $line_of_text[3];
			$MName = $line_of_text[4];
			$MeritNo = $line_of_text[5];
			$mhcetscore = $line_of_text[6];
			$SeatType = $line_of_text[7];
			$MobileNo = $line_of_text[8];
			$Shift = $line_of_text[11];
			$Year = $line_of_text[12];
			$admrem = $line_of_text[13];
			
			include 'db/db_connect.php';

			$query = "SELECT DeptID from tbldepartmentmaster Where DeptName =  '" . $line_of_text[10] . "' " ;
			// echo $query . "<br/>";
			$result = $mysqli->query( $query );
			$num_results = $result->num_rows;
			
			$SelDeptID  = 0;
			if( $num_results ){
				while( $row = $result->fetch_assoc() ){
					extract($row);
					$SelDeptID = $DeptID;
				}
			}
			
			If (($FName == '') || ($LName == '')){
				$e = $e + 1;
				echo "<li>Missing Information for " . $AppId . ": Name missing.</li><br/>";
			}
			If ($AppId == ''){
				$e = $e + 1;
				echo "<li>Missing Information for " . $AppId . ": Application Id Missing.</li><br/>";
			}
			If ($SelDeptID == 0){
				$e = $e + 1;
				echo "<li>Missing Information for " . $AppId . ": Department Incorrect.</li><br/>";
			}
			If (($Shift == 1) || ($Shift == 2)) {
			}
			else {
				$e = $e + 1;
				echo "<li>Missing Information for " . $AppId . ": Shift Incorrect.</li><br/>";
			}
			If (($Year == 'F.E.') || ($Year == 'S.E.') || ($Year == 'M.E.')) {
			}
			else {
				$e = $e + 1;
				echo "<li>Missing Information for " . $AppId . ": Year Incorrect.</li><br/>";
			}
		}
	}

	if ($e > 0) {
		echo "<br/>";
		echo "Please review these errors";
		die;
	}


 if( $_FILES['fileToUpload']['name'] != "" )
{
	echo ' B ';
	echo $_FILES['fileToUpload']['tmp_name'];
		echo "<br/>";

	$sqlU = "Insert into tbldtefile set UploadedFile = '" . $_FILES['fileToUpload']['name'] . "', Created_On = CURRENT_TIMESTAMP, Created_By = '". $_SESSION["SESSUserID"] ."'" ;

	if ($mysqli->query($sqlU) === TRUE) {
		$istgFileID = $mysqli->insert_id;
	} 
	else {
			echo "Error updating record: " . $mysqli->error;
		}
	;
}
else
{
    die("No file specified!");
}

	$sqlInsert = "Insert into tblstgstudent (AppId, FirstName, MiddleName, LastName, SeatType, MeritNo, Mobile, Dept, Shift, stgFileId, Year,stdrem,mhcetscore,admyear)
					Values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,2017)" ;
	$sqlDelete = "Delete from tblstgstudent where AppId = ?";
	$sqlDUser = "Delete from tbluser where Email = ?";
	$sqlIUser = "Insert into tbluser (FirstName, LastName, Email, userType, userPassword) Values (?, ?, ?, 'Student', ?)" ;
	
	$i = 0;
	
	//$file_handle = fopen($path, "r");
	$file_handle = fopen($_FILES['fileToUpload']['tmp_name'], "r");
	while (!feof($file_handle) ) {
		$line_of_text = fgetcsv($file_handle, 1024);
		$FName = '';
		$MName = '';
		$LName = '';
		if ($i == 0){
			$i = $i + 1;
			continue;
		}
		if ($line_of_text[$y] <> ''){
			$AppId = $line_of_text[1];
			//echo $AppId . "<br/>";
			// $StdName = explode(' ', $line_of_text[2]);
			// $LName = $StdName[0];
			// if (count($StdName) > 1) {
				// $FName = $StdName[1];
			// }
			// if (count($StdName) > 2) {
				// $MName = $StdName[2];
			// }
			// $MeritNo = $line_of_text[3];
			// $SeatType = $line_of_text[5];
			// $MobileNo = $line_of_text[6];
			// $Shift = $line_of_text[9];
			// $Year = $line_of_text[10];
			// $admrem = $line_of_text[11];
			$LName = $line_of_text[2];
			$FName = $line_of_text[3];
			$MName = $line_of_text[4];
			$MeritNo = $line_of_text[5];
			$mhcetscore = $line_of_text[6];
			$SeatType = $line_of_text[7];
			$MobileNo = $line_of_text[8];
			$Shift = $line_of_text[11];
			$Year = $line_of_text[12];
			$admrem = $line_of_text[13];			
			
			
			
			include 'db/db_connect.php';

			$query = "SELECT DeptID from tbldepartmentmaster Where DeptName =  '" . $line_of_text[10] . "' " ;
			// echo $query . "<br/>";
			$result = $mysqli->query( $query );
			$num_results = $result->num_rows;
			
			$SelDeptID  = 0;
			if( $num_results ){
				while( $row = $result->fetch_assoc() ){
					extract($row);
					$SelDeptID = $DeptID;
				}
			}
			
			//echo $SelDeptID;
			
			include 'db/db_connect.php';
			$stmt = $mysqli->prepare($sqlDelete);
			$stmt->bind_param('s', $AppId);
			if($stmt->execute()){
				//header('Location: SubjectList.php?'); 
			} else{
				echo $mysqli->error;
				die("Select dept Unable to update.");
			}
			//echo "after delete";
			
			$stmt = $mysqli->prepare($sqlInsert);
			//echo $istgFileID . "<br/>";
			
			$stmt->bind_param('sssssssiiisss', $AppId, $FName, $MName, $LName, $SeatType, $MeritNo, $MobileNo, $SelDeptID, $Shift, $istgFileID, $Year,$admrem,$mhcetscore);
			if($stmt->execute()){
				//header('Location: SubjectList.php?'); 
			} else{
				echo $mysqli->error;
				die("Insert Unable to update.");
			}
			if($Year == 'F.E.'){
				$sql = "INSERT INTO tblstudent (Surname, FirstName, FatherName, dept, shift, dteid, CNUM, stdpass, SeatType, AppId, admcat)
						SELECT LastName, FirstName, MiddleName, 'BSH', Shift, MeritNo, AppId, AppId, SeatType, AppId, stdrem FROM tblstgstudent
						WHERE AppId = '" .  $AppId .  "'";
			}
			else{
				$sql = "INSERT INTO tblstudent (Surname, FirstName, FatherName, dept, shift, dteid, CNUM, stdpass, SeatType, AppId, admcat)
						SELECT LastName, FirstName, MiddleName, '" . $line_of_text[10] . "', Shift, MeritNo, AppId, AppId, SeatType, AppId, stdrem FROM tblstgstudent
						WHERE AppId = '" .  $AppId .  "'";
			}
			$stmt = $mysqli->prepare($sql);
			if($stmt->execute()){
				$StdId = $mysqli->insert_id;
			} else
			{
				echo $mysqli->error;
				die("Unable to create Student record");
			}
		
			$sql = "INSERT INTO stdqual (StdId, Exam) values (". $StdId  .", '10th')";
			$stmt = $mysqli->prepare($sql);
			if($stmt->execute()){}
			else
			{	
				echo $mysqli->error;
				die("Unable to create Student record");
			}

			$sql = "INSERT INTO stdqual (StdId, Exam) values (". $StdId  .", '12th')";
			$stmt = $mysqli->prepare($sql);
			if($stmt->execute()){}
			else
			{
				echo $mysqli->error;
				die("Unable to create Student record");
			}
			

		}
	}
	header("Location: UploadDTEFileMain.php"); 
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