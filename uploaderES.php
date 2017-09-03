<html>
<head>
	<title>Uploading Complete</title>
</head>
<body>

<h2>Uploaded File Info:</h2>
<h3 class="page-title" style="float:right;margin-top:-40px;margin-right:10px"><a href="UploadExamFileMain.php">Back</a></h3>
<h3 class="page-title" style="float:right;margin-top:-40px;margin-right:20px" onclick="window.print();"><a href="#">Print</a></h3>

<ul>
<li><br/></li>
<li>Following subjects did not match our database : </li>
<li><br/></li>

<?php
	if(!isset($_SESSION)){
		session_start();
	}
include 'db/db_connect.php';
	$filename = $_FILES['fileToUpload']['name'];

	//echo $filename;
	
	$file_handle = fopen($_FILES['fileToUpload']['tmp_name'], "r");
	$i = 0;
	$file_errors = 0;
	$Theory = 0;
	$stdList = '';
	while (!feof($file_handle) ) {
		$line_of_text = fgetcsv($file_handle, 1024);
		//echo $line_of_text[0] . "<br/>";
		//$line_of_text = preg_replace("/\f+/", "", $line_of_text);
		strlen($line_of_text[0]);

		if ( strlen($line_of_text[0]) == 0 ) {
			continue;
		}
		//YEAR:B.E.(2012 PAT.)(MECHANICAL)
		//0123456789012345678901234567890
		If (substr($line_of_text[0],0,4) == 'YEAR') {
			$Yr = str_replace('.','',substr($line_of_text[0],5,4));
			$Pattern = substr($line_of_text[0],10,4);
			$Branch = str_replace(')', '', substr($line_of_text[0],strrpos($line_of_text[0],"(")+1 ));
			//Echo $Yr . "<br/>";
			//Echo $Pattern . "<br/>";
			//Echo $Branch . "<br/>";
		}
		//SUB:402041 REFRIGERATION AND AIR CONDITIONING [TH]

		ElseIf (substr($line_of_text[0],0,4) == 'SUB:') {
			If (strpos($line_of_text[0],"[TH]") > 0) {
				//echo strpos($line_of_text[0]," ") . "<br/>";
				$SubjectCode = substr($line_of_text[0],strpos($line_of_text[0],":")+1, (strpos($line_of_text[0]," ") - strpos($line_of_text[0],":") ) );

				//Echo $SubjectCode . "<br/>";
				$sql = "SELECT PaperID FROM tblpapermaster PM INNER JOIN tblsubjectmaster SM ON PM.SubjectID = SM.SubjectID 
				INNER JOIN tbldepartmentmaster DM ON DM.DeptID = PM.DeptID
				WHERE ExamPaperCode = '" . $SubjectCode . "' AND SUBSTR(EnggYear,1,2)  = '" . $Yr. "' 
				AND EnggPattern = ". $Pattern . " AND DeptName = '" . $Branch . "'";
				
				//echo $sql . "<br/>";

				include 'db/db_connect.php';
				$result = $mysqli->query( $sql );
				$num_results = $result->num_rows;
				if( $num_results == 0 ){
						$i = $i + 1;
						echo "<li>Subject: " .$SubjectCode. ", Pattern: ". $Pattern .", Year: ". $Yr .". ";
						echo "<li>Subject : " .$line_of_text[0]. ", Branch : ". trim($Branch) ." </li>";
					}
					$result->free();
				//disconnect from database
				$mysqli->close();

			}
		}
	}
	echo $i;
	
	if ($i > 0) {
		echo "<br/>";
		echo "Please review these errors";
		die;
	}

	include 'db/db_connect.php';

		$sql = "INSERT INTO tblexamfile (ExamID, UploadedFile, Created_on, Created_by)
				VALUES	(?, ?, CURRENT_TIMESTAMP, 'A123')";
		//echo $sql;
			$stmt = $mysqli->prepare($sql);
			$stmt->bind_param('ss', $_SESSION['SESSSelectedExam'],$filename);
			if($stmt->execute()){
				//echo "please review these errors";
			}
			else
			{
				echo "error updating record: " . $mysqli->error;
			}		
		
	




	$file_handle = fopen($_FILES['fileToUpload']['tmp_name'], "r");
	$i = 0;
	$errcnt = 0;
	$Theory = 0;
	$StdCount = 0;

	$stdList = '';
	while (!feof($file_handle) ) {
		$line_of_text = fgetcsv($file_handle, 1024);
		//$line_of_text = preg_replace("/\f+/", "", $line_of_text);
		//strlen($line_of_text[0]);
		if ( strlen($line_of_text[0]) == 0 ) {
			continue;
		}
		//YEAR:B.E.(2012 PAT.)(MECHANICAL)
		//0123456789012345678901234567890
		If (substr($line_of_text[0],0,4) == 'YEAR') {
			If ($Theory == 1) {
				//echo $stdList . "<br/>";
			
				$Theory = 0;
				$sql = "SELECT PaperID FROM tblpapermaster PM INNER JOIN tblsubjectmaster SM ON PM.SubjectID = SM.SubjectID 
				INNER JOIN tbldepartmentmaster DM ON DM.DeptID = PM.DeptID
				WHERE ExamPaperCode = '" . $SubjectCode . "' AND SUBSTR(EnggYear,1,2)  = '" . $Yr. "' 
				AND EnggPattern = ". $Pattern . " AND DeptName = '" . $Branch . "'";
				
				//echo $sql . "<br/>";
				$SelPaperId = 0;

				include 'db/db_connect.php';
				$result = $mysqli->query( $sql );
				$num_results = $result->num_rows;
				while( $row = $result->fetch_assoc() ){
					extract($row);
					$SelPaperId = $PaperID;
				}
				$result->free();
				//disconnect from database
				//$mysqli->close();

				$sqlSES = "Select ExamSchID from tblexamschedule where ExamID = ". $_SESSION["SESSSelectedExam"] . " and PaperID =  ". $SelPaperId . " ";

				//echo $sqlSES;
				$result = $mysqli->query( $sqlSES );
				$num_results = $result->num_rows;
				if( $num_results ){
					while( $row = $result->fetch_assoc() ){
						extract($row);

					$SelExamSch = $ExamSchID;
					$sqlUES = "Update tblexamschedule set Students = ?, UploadedFile = ?, updated_on = CURRENT_TIMESTAMP 
								   where ExamSchID = ?";
						$stmtUES = $mysqli->prepare($sqlUES);
						$stmtUES->bind_param('isi', $StdCount, $stdList, $SelExamSch );
						if($stmtUES->execute()){ } 
						else{ echo $mysqli->error;}
					}
					$result->free();
				}
				Else {
					$sqlIES = "Insert into tblexamschedule ( ExamID, PaperID, ExamFileID, Students, UploadedFile,
								Created_by, Created_on, updated_by, Updated_on) 
							Values ( ?, ?, ?, ?, ?, 'Admin', CURRENT_TIMESTAMP, 'Admin', CURRENT_TIMESTAMP)";
					$stmtIES = $mysqli->prepare($sqlIES);
					$stmtIES->bind_param('iiiis', $_SESSION["SESSSelectedExam"],$SelPaperId, $iexamfile, $StdCount, $stdList );
					if($stmtIES->execute()){} 
					else{echo $mysqli->error;}
				}						
				$stdList = '';
				$StdCount = 0;
				
			}

			$Yr = str_replace('.','',substr($line_of_text[0],5,4));
			$Pattern = substr($line_of_text[0],10,4);
			$Branch = str_replace(')', '', substr($line_of_text[0],strrpos($line_of_text[0],"(")+1 ));
			//Echo $Yr . "<br/>";
			//Echo $Pattern . "<br/>";
			//Echo $Branch . "<br/>";
		}
		ElseIf ((substr($line_of_text[0],0,4) == 'SUB:') || ((substr($line_of_text[0],0,9) == 'EndOfFile'))) {
			If ($Theory == 1) {
				//echo $stdList . "<br/>";
			
				$Theory = 0;
				$sql = "SELECT PaperID FROM tblpapermaster PM INNER JOIN tblsubjectmaster SM ON PM.SubjectID = SM.SubjectID 
				INNER JOIN tbldepartmentmaster DM ON DM.DeptID = PM.DeptID
				WHERE ExamPaperCode = '" . $SubjectCode . "' AND SUBSTR(EnggYear,1,2)  = '" . $Yr. "' 
				AND EnggPattern = ". $Pattern . " AND DeptName = '" . $Branch . "'";
				
				//echo $sql . "<br/>";
				$SelPaperId = 0;

				include 'db/db_connect.php';
				$result = $mysqli->query( $sql );
				$num_results = $result->num_rows;
				while( $row = $result->fetch_assoc() ){
					extract($row);
					$SelPaperId = $PaperID;
				}
				$result->free();
				//disconnect from database
				//$mysqli->close();

				$sqlSES = "Select ExamSchID from tblexamschedule where ExamID = ". $_SESSION["SESSSelectedExam"] . " and PaperID =  ". $SelPaperId . " ";

				//echo $sqlSES;
				$result = $mysqli->query( $sqlSES );
				$num_results = $result->num_rows;
				if( $num_results ){
					while( $row = $result->fetch_assoc() ){
						extract($row);

					$SelExamSch = $ExamSchID;
					$sqlUES = "Update tblexamschedule set Students = ?, UploadedFile = ?, updated_on = CURRENT_TIMESTAMP 
								   where ExamSchID = ?";
						$stmtUES = $mysqli->prepare($sqlUES);
						$stmtUES->bind_param('isi', $StdCount, $stdList, $SelExamSch );
						if($stmtUES->execute()){ } 
						else{ echo $mysqli->error;}
					}
					$result->free();
				}
				Else {
					$sqlIES = "Insert into tblexamschedule ( ExamID, PaperID, ExamFileID, Students, UploadedFile,
								Created_by, Created_on, updated_by, Updated_on) 
							Values ( ?, ?, ?, ?, ?, 'Admin', CURRENT_TIMESTAMP, 'Admin', CURRENT_TIMESTAMP)";
					$stmtIES = $mysqli->prepare($sqlIES);
					$stmtIES->bind_param('iiiis', $_SESSION["SESSSelectedExam"],$SelPaperId, $iexamfile, $StdCount, $stdList );
					if($stmtIES->execute()){} 
					else{echo $mysqli->error;}
				}						
				$stdList = '';
				$StdCount = 0;
				
			}
			
			If (strpos($line_of_text[0],"[TH]") > 0) {
				$Theory = 1;
				$SubjectCode = substr($line_of_text[0],strpos($line_of_text[0],":")+1, (strpos($line_of_text[0]," ") - strpos($line_of_text[0],":") ) );

				//Echo $line_of_text[0] . "<br/>";
				$sql = "SELECT PaperID FROM tblpapermaster PM INNER JOIN tblsubjectmaster SM ON PM.SubjectID = SM.SubjectID 
				INNER JOIN tbldepartmentmaster DM ON DM.DeptID = PM.DeptID
				WHERE ExamPaperCode = '" . $SubjectCode . "' AND SUBSTR(EnggYear,1,2)  = '" . $Yr. "' 
				AND EnggPattern = ". $Pattern . " AND DeptUnivName = '" . $Branch . "'";
				//echo $Theory . "<br/>";
				
				//echo $sql . "<br/>";
			}
		}
		
		//substr(string,start,length)
		//if (preg_match('/^[a-z]/i', $input))
		//	is_numeric(substr($string, 0, 1))
		
	
		Else {
			If ($Theory == 0) {}
			else {
				//echo $line_of_text[0];
				for ($y = 0 ; $y <= count($line_of_text) - 1; $y++) {
					
					$line_of_text[$y] = ltrim($line_of_text[$y], " ");

					$firstCharac = substr($line_of_text[$y],0,1);
					$secCharac = substr($line_of_text[$y],1,1);

					//if ($line_of_text[$y] <> ''){
					if ( is_numeric($secCharac)  and  ( preg_match('/^[a-z]/i', $firstCharac) ) ){
						//echo 'True' . "<br/>";
						$pos = strpos(trim($stdList), trim($line_of_text[$y]));
						if ($pos === false){
							$stdList = $stdList .  $line_of_text[$y] . ',' ;
							$StdCount++;
						}
						else{
							//dup hence ignored
						}
					}
				}
				//echo $stdList;
			}
		}
	}

	header('Location: UploadExamFileMain.php');


?>

</ul>
</body>
</html>