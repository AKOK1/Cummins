<?php
	include 'db/db_connect.php';
	ini_set('max_execution_time', 30);
	if(!isset($_SESSION)){
		session_start();
	}
	ini_set('max_execution_time', 30);

//for production set this to 1=1
if(1==1){
	// conversion  code starts
	if(isset($_FILES['fileToUpload'])) {
		$errors     = array();
		$maxsize    = 2097152;
		$acceptable = array('application/pdf');

		if((strpos($_FILES['fileToUpload']['name'],' ') > 0) || (strpos($_FILES['fileToUpload']['name'],'(') > 0) || 
					(strpos($_FILES['fileToUpload']['name'],')') > 0)) {
			$errors[] = 'File name invalid. Please remove any spaces or brackets.';
		}

		if(($_FILES['fileToUpload']['name'] >= $maxsize) || ($_FILES["fileToUpload"]["size"] == 0)) {
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
			 //$output = shell_exec('/usr/bin/pdftotext -layout -enc Windows-1255 uploads/' . $filename . ' ' . $target);
			 $output = shell_exec('/usr/bin/pdftotext -layout -nopgbrk -eol dos -enc Windows-1255 uploads/' . $filename . ' ' . $target);
			 //$output = shell_exec('/usr/bin/pdftotext -layout uploads/newname.pdf uploads/newname.txt');
			 //$output = shell_exec('ls -lart');
				//echo "<pre>File uploaded successfully!</pre>";

		}
		else {
				foreach($errors as $error) {
					echo "<pre>$error</pre>";
				}
		}
	}
}
else
{
	$target = "uploads/motest.txt";
	$filename = "uploads/motest.txt";
}

 if( $target == "" )
{
    die("No file specified!");
}
	
	$CurMonth = date("m",strtotime(date('Y-m-d')));
	$CurYear = date("Y",strtotime(date('Y-m-d')));
	
	$Year = 'SE';  // input
	$Pattern = '2012'; // input
	$SelStdAdmId = '';
	$HdrLine1 = '';
	$HdrLine2 = '';
	$HdrLine3 = '';
	$BLine = '';
	$MaxMinLine = '';
	$TLine = '';
	$HLine = '';
	$iStdResMID = 0;
	$aaa = 0;
	$Ord = '';

	include 'db/db_connect.php';

	$sql = "SELECT AcadYearFrom, AcadYearTo, Sem
			FROM tblexammaster Where ExamID = " .  $_SESSION['SESSSelectedExam']  . "";
	
	//echo $sql . "<br/>";

	include 'db/db_connect.php';
	$result = $mysqli->query( $sql );
	$num_results = $result->num_rows;
	while( $row = $result->fetch_assoc() ){
		extract($row);
		$SelEduYearFr = $AcadYearFrom;
		$SelEduYearTo = $AcadYearTo;
		$SelSem = $Sem;
	}
	$result->free();
	//disconnect from database
	$mysqli->close();

	//echo $SelEduYearFr;
	//echo $SelEduYearTo;
	//echo $SelSem;
	//die;
	
	/* If ($CurMonth < 9) {
		$SelEduYearFr = $CurYear - 1;
		$SelEduYearTo = $CurYear;
	}
	Else {
		$SelEduYearFr = $CurYear;
		$SelEduYearTo = $CurYear + 1;
	} */
	$iStdMID = 0;

	
	
	include 'db/db_connect.php';

	$sql = "INSERT INTO tblresultfile (UploadedFile, ExamID, Created_on, Created_by)
			VALUES	( ?, ?, CURRENT_TIMESTAMP, 'A123')";
	//echo $_SESSION['SESSSelectedExam'];
	//die;
	$stmt = $mysqli->prepare($sql);
	$stmt->bind_param('si', $filename, $_SESSION['SESSSelectedExam']);
	if($stmt->execute()){
		$iResFileID = $mysqli->insert_id;
			//echo 'iResFileID:'; echo $iResFileID . "<br/>";
		//echo "please review these errors";
	}
	else
	{
		echo "error updating record: " . $mysqli->error;
	}

		//$file_handle = fopen($path, "r");
	//$file_handle = fopen($_FILES['fileToUpload']['tmp_name'], "r");
	$file_handle = fopen(getcwd() . "/" . $target, "r");
	//$file_handle = fopen('/var/www/html/ccoew/' . $target, "r");
	
	$i = 0;
	$y = 0;
	$z = 0;
	$mocnt = 0;
	while (!feof($file_handle) ) {
		$line_of_text = fgets($file_handle, 1024);
		$line_of_text = preg_replace("/\f+/", "", $line_of_text);
		// echo "Z:" . $z . "<br/>";
		// echo (strpos($line_of_text,"BRANCH")) . "<br/>";
			// if($z > 2){
				// die;
			// }
			// $z = $z + 1;
		if ( strlen($line_of_text) == 0 ) {
			continue;
		}
		 //echo $line_of_text . "<br/>" ;
		 //echo strpos($line_of_text,"CEWP") . "<br/>" ;
		$findstr = 0;
		If (strpos($line_of_text,"UNIVERSITY") > 0) {
			//echo 'This is Univ line :';
			$HdrLine1 = $line_of_text;
			$tmp_line_of_text = str_replace("COURSE","PAT",$line_of_text);
			$findstr = strpos($tmp_line_of_text,"PAT");
			$Year = str_replace(".","",substr($line_of_text,$findstr - 10,4));
			$Pattern = substr($line_of_text,$findstr - 5,4);
			
			If ($Year == 'FE') {
				$Branch = 'Allied';
			}
			else {
				$tmpBranch = substr($line_of_text,$findstr + 5, strlen($line_of_text) - $findstr + 5);
				//$tmpBranch = str_replace()
				//echo "Tmp Branch :" . $tmpBranch. "<br/>";
				$findstr = strpos($tmpBranch,"EXAMINATION");
				If ($findstr > 0) {
					$Branch = str_replace("(", "", substr($tmpBranch,0 , $findstr));
					$Branch = str_replace(")", "", $Branch);
				}
				//echo "Branch :" . $Branch. "<br/>";
			}
			
			//echo "Pattern :" . $Pattern;
		}
		ElseIf (strpos($line_of_text,"BRANCH") > -1){
			//echo $line_of_text . "<br/>";
			$HdrLine2 = $line_of_text;
			$tmpBranch =  substr(strrchr($line_of_text, "("), 1);
			$findstr = strpos($tmpBranch,")");
			$Branch = substr($tmpBranch, 0, $findstr);
			//echo $Branch;
		}
		ElseIf (strpos($line_of_text," DATE :") > 0) {
			//echo $line_of_text . "<br/>";
			//echo 'This is Date line :';
			$HdrLine3 = $line_of_text;
		}
		ElseIf (strpos($line_of_text,"LEDGER") > 0) {
			//echo 'This is Date line :';
		}
		ElseIf (strpos($line_of_text,"SEM.") > 0) {
			//echo 'This is Date line :';
		}
		ElseIf (strpos($line_of_text,"CEWP") > 0) {
			//If ($aaa > 15) { die;} else { $aaa = $aaa + 1; }
			//echo 'This is Std line :';
			$TLine = $line_of_text;
			//echo $TLine;
			$TLineS = explode(',', $line_of_text);
			$UnivPRN = $TLineS[1];
			$TLineSN = preg_split('/\s\s+/', $TLineS[0]); 
			$MotherName = $TLineSN[3];
			$Name = $TLineSN[2];
			$i = 0;
			/*echo 'This is student record. ###';
			echo 'Name:'; echo $Name;
			echo 'Mother:'; echo $MotherName;*/
			//echo 'PRN:'; echo $UnivPRN . "<br/>";
			/*echo $StdAdmId;*/
			//echo $HdrLine;
 			$sqlI = "Insert into tblstdresultm ( UniPRN, HLine1, ResFileID, Dept, EduYearFr, EduYearTo, EduYear, Sem, Pattern) Values ( ?, ?, ?, ?, ?, ?, ?, ?, ? );";
			$stmt = $mysqli->prepare($sqlI);
			$stmt->bind_param('ssissssis', $UnivPRN, $HdrLine1, $iResFileID, $Branch, $SelEduYearFr, $SelEduYearTo, $Year, $SelSem,$Pattern );
			
			if ($stmt->execute()) {	
				$iStdResMID = $mysqli->insert_id;
				/*echo $iStdResMID;*/
			} 
			else {echo "Insert Error "; echo $mysqli->error;}
		}
		ElseIf ((strpos($line_of_text,"GRAND TOTAL") > -1) or (strpos($line_of_text,"FIRST SEM TOTAL") > -1)  
					or (strpos($line_of_text,"SGPA") > -1)) {
			//echo 'This is Grand Total. $$$';
			$BLine = $line_of_text;
			$sqlURM = "Update tblstdresultm set HLine2 = ? , HLine3 = ?, TLine = ?, BLine = ? Where StdResMID = ?;";
			/*echo $sqlURM; */
			$stmt = $mysqli->prepare($sqlURM);
			$stmt->bind_param('ssssi', $HdrLine2 , $HdrLine3 , $TLine, $BLine, $iStdResMID);
			if ($stmt->execute()) {	} 
			else {echo $mysqli->error;}
		}
		ElseIf ((strpos($line_of_text,"TH") > 0) || (strpos($line_of_text,"TO") > 0) || (strpos($line_of_text,"OR") > 0) || (strpos($line_of_text,"TW") > 0) || (strpos($line_of_text,"PP") > 0) || (strpos($line_of_text,"PR ") > 0)) {
			//echo "aaa" . "<br/>";
			// echo substr($line_of_text,0,75);
			If ($Year == 'FE'){
				//echo $PrevSubjectName . "<br/>";
				$Sem1 = preg_split('/\s+/', Ltrim(substr(str_replace('*','',$line_of_text),0,74), " "));
				//echo str_replace('*','',$line_of_text) . '<br/>';
				if(($Sem1[0] == 'TW') || ($Sem1[0] == 'TO')){
					$ResultLineSem1 = $SubCode . " " . $PrevSubjectName . " " . trim(substr($line_of_text,0,74), " ");
					$Sem1 = preg_split('/\s+/', $SubCode . " " . $PrevSubjectName . " " . Ltrim(substr(str_replace('*','',$line_of_text),0,74), " "));
				}
				else{
					$ResultLineSem1 = trim(substr($line_of_text,0,74), " ");
				}
				//echo Ltrim(substr($line_of_text,0,74)) . "<br/>";
				//echo $Sem1[0] . " " . $Sem1[1] . '<br/>';
				// if($mocnt > 15)
						// die;
				 // else
					// $mocnt = $mocnt + 1;
			
				//echo '$Sem2' . "<br/>";
				$Sem2 = preg_split('/\s+/', Ltrim(substr($line_of_text,74), " "));
				//echo Ltrim(substr($line_of_text,74)) . "<br/>";
				$ResultLineSem2 = trim(substr($line_of_text,74), " ");
			}
			If ($Year == 'SE'){
				$Sem1 = preg_split('/\s+/', Ltrim(substr($line_of_text,0,77), " "));
				$ResultLineSem1 = trim(substr($line_of_text,0,77), " ");
				$Sem2 = preg_split('/\s+/', Ltrim(substr($line_of_text,78), " "));
				$ResultLineSem2 = trim(substr($line_of_text,78), " ");
			}
			If ($Year == 'TE'){
				$Sem1 = preg_split('/\s+/', Ltrim(substr($line_of_text,0,78), " "));
				$ResultLineSem1 = trim(substr($line_of_text,0,78), " ");
				$Sem2 = preg_split('/\s+/', Ltrim(substr($line_of_text,79), " "));
				$ResultLineSem2 = trim(substr($line_of_text,79), " ");
			}
			If ($Year == 'BE'){
				$Sem1 = preg_split('/\s+/', Ltrim(substr($line_of_text,0,79), " "));
				$ResultLineSem1 = trim(substr($line_of_text,0,79), " ");
				$Sem2 = preg_split('/\s+/', Ltrim(substr($line_of_text,80), " "));
				$ResultLineSem2 = trim(substr($line_of_text,80), " ");
			}
			
			//echo substr($line_of_text,74,75) . '<br/>';
			//echo count($Sem1[]) . '<br/>';
			//if($mocnt > 25)
				//	die;
			//else
				//$mocnt = $mocnt + 1;
			//echo "Sem 1" . Ltrim(substr($line_of_text,0,75), " ") . "<br/>";
			//echo "Sem 2" . Ltrim(substr($line_of_text,76), " ") . "<br/>";
			//echo "Sem 1" . $Sem1[0] . "<br/>";
			//echo "Sem 2" . $Sem2[0] . "<br/>";
			
			$j = 0;
			$Y = 0;
			$SubjectName = '';
			//echo ' Array Cnt ';
			//echo $Sem1[0] . "<br/>";
			$i = $i + 1;
			if ((trim($Sem1[0], " ") == "") || (count($Sem1) < 4)){
			}
			else {
				//echo Ltrim(substr($line_of_text,0,74)) . "<br/>";
				$SubCode = $Sem1[0];
				//echo "SubCode " . $Sem1[0] . "<br/>" ;
				for ($j = 1; $j <= count($Sem1); $j++) {
					$Y = $Y + 1;
					$PPORTWPR = 0;

					If ((Trim($Sem1[$j]) == 'TH') || (Trim($Sem1[$j]) == 'TO') || (Trim($Sem1[$j]) == 'PP') || (Trim($Sem1[$j]) == 'OR') || (Trim($Sem1[$j]) == 'TW') || (Trim($Sem1[$j]) == 'PR')) {
							$PPORTWPR = 1;
							$SubType = $Sem1[$j];
						}
					ElseIF ( ((substr(Trim($Sem1[$j]),(strlen(Trim($Sem1[$j])) - 2),2) == 'PP') ||
							 (substr(Trim($Sem1[$j]),(strlen(Trim($Sem1[$j])) - 2),2) == 'OR') ||
							 (substr(Trim($Sem1[$j]),(strlen(Trim($Sem1[$j])) - 2),2) == 'TW') ||
							 (substr(Trim($Sem1[$j]),(strlen(Trim($Sem1[$j])) - 2),2) == 'TO') ||
							 (substr(Trim($Sem1[$j]),(strlen(Trim($Sem1[$j])) - 2),2) == 'TH') ||
							 (substr(Trim($Sem1[$j]),(strlen(Trim($Sem1[$j])) - 2),2) == 'PR')) && ( is_numeric(Trim($Sem1[$j + 1]))) ){ 
							$SubType = substr(Trim($Sem1[$j]),(strlen(Trim($Sem1[$j])) - 2),2);
							$PPORTWPR = 2;
					}
					$SubjectName = '';

					$SubjectName = '';
					//echo $PPORTWPR . "<br/>";
					if ($PPORTWPR > 0){
						//echo "PPORTWPR " . $PPORTWPR ;
						if ($PPORTWPR == 1) {
							for ($k = 1; $k < $j; $k ++ ) {
								$SubjectName = $SubjectName . ' ' . $Sem1[$k];
							}
						}
						Else {
							for ($k = 1; $k < $j+1; $k ++ ) {
								$SubjectName = $SubjectName . ' ' . $Sem1[$k];
							}
							$SubjectName = substr($SubjectName,0,strlen($SubjectName)-2);
						}
						$PrevSubjectName = $SubjectName;


						//If ((($Year == 'TE') || ($Year == 'FE'))  && (substr($Sem1[$j],(strlen($Sem1[$j]) - 2),2) == 'PP')){
						If (((($Year == 'TE')  && ($Pattern == 2012)) || (($Year == 'BE') && ($Pattern == 2012)) ||
								(($Year == 'SE') && ($Pattern == 2014))||
								(($Year == 'FE') && ($Pattern == 2015)))
							&& (
								((Trim($Sem1[$j]) == 'PP') || (substr($Sem1[$j],(strlen($Sem1[$j]) - 2),2) == 'PP')) ||
								((Trim($Sem1[$j]) == 'TH') || (substr($Sem1[$j],(strlen($Sem1[$j]) - 2),2) == 'TH')) 
								)){
							$Max = $Sem1[$j + 1];
							$Pass = $Sem1[$j + 2];
							$MidSem =  $Sem1[$j + 3];
							$EndSem =  $Sem1[$j + 4];
							$ActTot =  $Sem1[$j + 5];
							$Res = $Sem1[$j + 6];
							// echo 'If'. "<br/>";
							// echo $j. "<br/>";
							// echo $Sem1[$j + 5]. "<br/>";
							// die;
							//echo "SubjectName " . $SubjectName . "<BR/>";
							//echo $j + 7 . "<br/>";
							//echo (count($Sem1) -1 ) . "<br/>";
							if ($PPORTWPR == 1) {
								If (($j + 7	) == (count($Sem1) -1 )) {							
									$Prev = '';}
								else {
									$Prev = $Sem1[$j + 7];
								}
							}
							else {
								If (($j + 8	) == (count($Sem1) -1 )) {							
									$Prev = '';}
								else {
									$Prev = $Sem1[$j + 7];
								}
							}
						}
						else {
							$Max = $Sem1[$j + 1];
							$Pass = $Sem1[$j + 2];
							$MidSem =  0;
							$EndSem =  0;
							// echo 'Else' . "<br/>";
							// echo $Sem1[$j + 5] . "<br/>";
							// die;

							$ActTot =  $Sem1[$j + 3];
							$Res = $Sem1[$j + 4];
							if ($PPORTWPR == 1) {
								If (($j + 4) == (count($Sem1)-1)){							
									$Prev = '';}
								else {
									$Prev = $Sem1[$j + 5];
								}
							}
							else {
								If (($j + 5) == (count($Sem1)-1)){							
									$Prev = '';}
								else {
									$Prev = $Sem1[$j + 5];
								}
							}
						//echo "ActTotal " . $ActTot . "<br/>";
						//echo "PrevCo " . strlen($Prev) . "<br/>";
						}
						break;
					}
				}
				
				//echo $SubCode . "<br/>";
				include 'db/db_connect.php';
				$sqlIstdresult = " Insert into tblstdresult (StdResMID, Sem, ResOrder, SubCode, ResultSubject, SubType, Max, Min
								   , Marks, ORD, PassFail, PREVCO, ResultLine,MidSem,EndSem) 
								   Values (?, 1, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
				//echo $sqlIstdresult;
				$stmt = $mysqli->prepare($sqlIstdresult);
				$stmt->bind_param('iisssiisssssss', $iStdResMID, $i, trim($SubCode), trim($SubjectName), 
				trim($SubType), trim($Max), trim($Pass), trim($ActTot), trim($Ord) , trim($Res) , trim($Prev), $ResultLineSem1
							, trim($MidSem), trim($EndSem)) ;
				if ($stmt->execute()) {} 
				else {
					echo $mysqli->error;
				}
			}
			$j = 0;
			
			//echo "Sem2" . LTRIM(substr($line_of_text,74 ), " ") . "<br/>";
			//echo "Sem[0]". "<br/>";
			//echo $Sem2[0] . "<br/>";
			//echo "Sem[1]". "<br/>";
			//echo $Sem2[1] . "<br/>";
			
			if (trim($Sem2[0], " ") == ""){
			}
			else {
				$SubCode = $Sem2[0];
				for ($j = 0; $j <= count($Sem2); $j++) {
					$PPORTWPR = 0;
					
					If ((Trim($Sem2[$j]) == 'PP') || (Trim($Sem2[$j]) == 'OR') || (Trim($Sem2[$j]) == 'TW') || (Trim($Sem2[$j]) == 'PR')) {
							$PPORTWPR = 1;
							$SubType = $Sem2[$j];
						}
					ElseIF ( ((substr(Trim($Sem2[$j]),(strlen(Trim($Sem2[$j])) - 2),2) == 'PP') ||
							 (substr(Trim($Sem2[$j]),(strlen(Trim($Sem2[$j])) - 2),2) == 'OR') ||
							 (substr(Trim($Sem2[$j]),(strlen(Trim($Sem2[$j])) - 2),2) == 'TW') ||
							 (substr(Trim($Sem2[$j]),(strlen(Trim($Sem2[$j])) - 2),2) == 'PR')) && ( is_numeric(Trim($Sem2[$j + 1]))) ){ 
							$SubType = substr(Trim($Sem2[$j]),(strlen(Trim($Sem2[$j])) - 2),2);
							$PPORTWPR = 2;
					}
					$SubjectName = '';
					if ($PPORTWPR > 0){
						//echo "PPORTWPR " . $PPORTWPR ;
						if  (is_numeric(substr($Sem2[0],0,2))) {
							$StrArr = 1;
						}
						else {
							$StrArr = 0;
						}
						if ($PPORTWPR == 1) {
							for ($k = $StrArr; $k < $j; $k ++ ) {
								
								$SubjectName = $SubjectName . ' ' . $Sem2[$k];
							}
						}
						Else {
							for ($k = $StrArr; $k < $j+1; $k ++ ) {
								$SubjectName = $SubjectName . ' ' . $Sem2[$k];
							}
							$SubjectName = substr($SubjectName,0,strlen($SubjectName)-2);
						}
						If ($SubjectName == '') {
							$SubjectName = $SubCode	;
						}

						If (((($Year == 'TE')  && ($Pattern == 2012)) || (($Year == 'BE') && ($Pattern == 2012)) ||
								(($Year == 'SE') && ($Pattern == 2014)))
							&& ((Trim($Sem2[$j]) == 'PP') || (substr($Sem2[$j],(strlen($Sem2[$j]) - 2),2) == 'PP'))){
							$Max = $Sem2[$j + 1];
							$Pass = $Sem2[$j + 2];
							$MidSem =  $Sem2[$j + 3];
							$EndSem =  $Sem2[$j + 4];
							$ActTot =  $Sem2[$j + 5];
							$Res = $Sem2[$j + 6];
							//echo "SubjectName " . $SubjectName . "<BR/>";
							//echo $j + 7 . "<br/>";
							//echo (count($Sem2) -1 ) . "<br/>";
							if ($PPORTWPR == 1) {
								If (($j + 7	) == (count($Sem2) -1 )) {							
									$Prev = '';}
								else {
									$Prev = $Sem2[$j + 7];
								}
							}
							else {
								If (($j + 8	) == (count($Sem2) -1 )) {							
									$Prev = '';}
								else {
									$Prev = $Sem2[$j + 7];
								}
							}
						}
						else {
							$Max = $Sem2[$j + 1];
							$Pass = $Sem2[$j + 2];
							$MidSem =  0;
							$EndSem =  0;
							$ActTot =  $Sem2[$j + 3];
							$Res = $Sem2[$j + 4];
							If (($j + 4) == (count($Sem2)-1)){							
								$Prev = '';}
							else {
								$Prev = $Sem2[$j + 5];
							}
						}

						break;
					}
				}

				include 'db/db_connect.php';
				$sqlIstdresult = " Insert into tblstdresult (StdResMID, Sem, ResOrder, SubCode, ResultSubject, SubType, Max, Min
								   , Marks, ORD, PassFail, PREVCO, ResultLine,MidSem,EndSem) 
								   Values (?, 2, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?,?)";
				//echo $sqlIstdresult;
				$stmt = $mysqli->prepare($sqlIstdresult);
				$stmt->bind_param('iisssiisssssss', $iStdResMID, $i, trim($SubCode), trim($SubjectName), 
				trim($SubType), trim($Max), trim($Pass), trim($ActTot), trim($Ord) , trim($Res) , trim($Prev), $ResultLineSem2
				, trim($MidSem), trim($EndSem)) ;
				if ($stmt->execute()) {} 
				else {
					echo $mysqli->error;
				}
			
			}
			
		}
	}
	
	//header('Location: UploadResultFileMain.php');

	/*
	SELECT A.*, B.* FROM 
(SELECT * FROM tblstdresult WHERE Sem = 1) AS A
INNER JOIN
(SELECT * FROM tblstdresult WHERE Sem = 2) AS B 
ON A.StdResMID = B.StdResMID AND A.ResOrder = B.ResOrder AND A.StdResMID = 1

SELECT Hline1 AS ResLine FROM tblstdresultm WHERE StdAdmId = 36  
UNION
SELECT Hline2 AS ResLine FROM tblstdresultm WHERE StdAdmId = 36  
UNION
SELECT Hline3 AS ResLine FROM tblstdresultm WHERE StdAdmId = 36  
UNION
SELECT TLine AS ResLine FROM tblstdresultm WHERE StdAdmId = 36  
UNION
SELECT CONCAT(A.ResultLine,' ' ,B.ResultLine) AS ResLine FROM
( SELECT ResultLine, ResOrder FROM tblstdresult WHERE Sem = 1 AND StdResMID = 3 ) AS A
LEFT OUTER JOIN ( SELECT ResultLine, ResOrder FROM tblstdresult WHERE Sem = 2 AND StdResMID = 3 ) B 
ON A.ResOrder = B.ResOrder
UNION
SELECT BLine AS ResLine FROM tblstdresultm WHERE StdAdmId = 36  

-- truncate table tblstdresultm;
-- truncate table tblstdresult;

SELECT COUNT(*) FROM tblstdresultm;


SELECT * FROM tblstudent  ORDER BY StdId DESC
SELECT * FROM tblstudent WHERE uniprn = '71406110H';
SELECT * FROM tblstdadm WHERE StdId = 23081
SELECT * FROM tblstdresultm WHERE StdAdmID = 5610

*/
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