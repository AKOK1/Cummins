<?php 
//include database connection
		if(!isset($_SESSION)){
			session_start();
		}
	include 'db/db_connect.php';
	if ($_GET['IUD'] == 'I') {
		// Generate CNUM
		include 'db/db_connect.php';
		$sql = "SELECT EduYearFrom AS YearToFrom, RIGHT(EduYearTo,2) AS YearToS, EduYearTo AS YearToL FROM tblcuryear  ";
		//echo $sql;
		$result = $mysqli->query($sql);
		$num_results = $result->num_rows;

		if( $num_results ){
			while( $row = $result->fetch_assoc() ){
				extract($row);
				$SelYearFrom = $YearToFrom;
				$SelYearTo = $YearToS;
				$SelYearToL = $YearToL;
			}
		}

		/*
		SELECT * FROM tblStudent WHERE CNUM LIKE 'C22015%' ORDER BY CNUM -- 
		C22015551606
		C22015111201
		C 2 2015     11                                                                    1        001
		C 2 AdmYear  DEpt( 11 EnTC, 22 Comp, 33 Instru, 44 IT, 55 Mech, 77 EnTC , 88 Comp  (FE 1 SE 2) (001 Entc, 201 Comp, 401 Instru, 501 IT, 601 Mech, 701 EnTC, 801 Comp

		SELECT YearFrom, RIGHT(YearTo,2) FROM tblcuryear

		SELECT StdId, AppId, CONCAT(FirstName, ' ', FatherName, ' ', Surname), SeatType, shift, dept  FROM tblStudent WHERE feadmyear = '2015-16'

		2 Comp
		3 EnTC
		4 Instru
		5 IT
		6 Mech

		
		If ($_GET["Year"] == 'F.E.') {
			$sql = "SELECT right(CNUM, 3) as CNUM FROM tblstudent WHERE Mid(CNUM,9,1) = '1' and feadmyear = '" . $SelYearFrom . "-" . $SelYearTo . 
					"' AND dept = " . $_GET["Dept"] . " and shift = " . $_GET["Shift"] . " ORDER BY CNUM DESC LIMIT 1" ;
		}
		else {
			$sql = "SELECT right(CNUM, 3) as CNUM FROM tblstudent WHERE Mid(CNUM,9,1) = '2' and feadmyear = '" . $SelYearFrom . "-" . $SelYearTo . 
					"' AND dept = " . $_GET["Dept"] . " and shift = " . $_GET["Shift"] . " ORDER BY CNUM DESC LIMIT 1" ;
		}
		*/

		include 'db/db_connect.php';
		$query4 = "SELECT DeptName FROM tbldepartmentmaster where DeptID = " . $_GET["Dept"];
		$result4 = $mysqli->query( $query4 );
		$num_results4 = $result4->num_rows;
		if( $num_results4 ){
			while( $row4 = $result4->fetch_assoc() ){
				extract($row4);
			}
		}
		If ($_GET["Year"] == 'F.E.') {
			$sql = "SELECT RIGHT(CNUM, 3) AS CNUM 
			FROM tblstudent 
			INNER JOIN tblcuryear cy ON SUBSTRING(feadmyear,1,4) = cy.eduyearfrom
			WHERE stdid IN (SELECT stdid
			FROM tblstdadm sa INNER JOIN tblcuryear cy ON cy.eduyearfrom = sa.eduyearfrom AND cy.eduyearto = sa.eduyearto
			WHERE dept = " . $_GET["Dept"] . " AND shift = " . $_GET["Shift"] . "  AND YEAR = 'F.E.') AND MID(CNUM,9,1) = '1' ORDER BY CNUM DESC LIMIT 1";

		}
		elseif ($_GET["Year"] == 'S.E.') {
			$sql = "SELECT RIGHT(CNUM, 3) AS CNUM 
			FROM tblstudent 
			INNER JOIN tblcuryear cy ON SUBSTRING(feadmyear,1,4) = cy.eduyearfrom
			WHERE stdid IN (SELECT stdid
			FROM tblstdadm sa INNER JOIN tblcuryear cy ON cy.eduyearfrom = sa.eduyearfrom AND cy.eduyearto = sa.eduyearto
			WHERE dept = " . $_GET["Dept"] . " AND shift = " . $_GET["Shift"] . "  AND YEAR = 'S.E.') AND MID(CNUM,9,1) = '2' ORDER BY CNUM DESC LIMIT 1";
		} 
		elseif ($_GET["Year"] == 'M.E.') {
			$sql = "SELECT RIGHT(CNUM, 3) AS CNUM 
			FROM tblstudent 
			INNER JOIN tblcuryear cy ON SUBSTRING(feadmyear,1,4) = cy.eduyearfrom
			WHERE stdid IN (SELECT stdid
			FROM tblstdadm sa INNER JOIN tblcuryear cy ON cy.eduyearfrom = sa.eduyearfrom AND cy.eduyearto = sa.eduyearto
			WHERE dept = " . $_GET["Dept"] . " AND shift = " . $_GET["Shift"] . "  AND YEAR = 'M.E.') AND MID(CNUM,9,1) = '1' ORDER BY CNUM DESC LIMIT 1";
		}



		//$sql = "Select 240 as CNUM";
		//echo $sql . "<br/>";
		//die;
		
		$result = $mysqli->query($sql);
		$num_results = $result->num_rows;

		if( $num_results ){
			while( $row = $result->fetch_assoc() ){
				extract($row);
				$SelMaxCNUM = str_pad(($CNUM + 1),  3, "0", STR_PAD_LEFT);
			}
		}
		else {
			$SelMaxCNUM = 1;
		}
		
		//echo $SelMaxCNUM . "<br/>" ;
		//die;
		//get max CNUM from tbl std for adm yr and shist dept
		// add 1 to max no
		
		If ($_GET["Year"] == "F.E.") {
			$SelYear = "1";
		}
		elseIf ($_GET["Year"] == "S.E.") {
			$SelYear = "2";
		}
		elseIf ($_GET["Year"] == "M.E.") {
			$SelYear = "1";
		}
		
		If ($_GET["Year"] == "M.E.") {
		    If (($_GET["Dept"] == 3) and ($_GET["Shift"] == 1)) {
				If ($SelMaxCNUM == 1) {$SelMaxCNUM = '001';}
				$CNUM = "C3" . $SelYearFrom . "11" . $SelYear . $SelMaxCNUM;
		    }  
			ElseIf (($_GET["Dept"] == 4) and ($_GET["Shift"] == 1)) {
				If ($SelMaxCNUM == 1) {$SelMaxCNUM = '401';}
				$CNUM = "C3" . $SelYearFrom . "33" . $SelYear . $SelMaxCNUM;
		    }  
			ElseIf (($_GET["Dept"] == 6) and ($_GET["Shift"] == 1)) {
				If ($SelMaxCNUM == 1) {$SelMaxCNUM = '601';}
				$CNUM = "C3" . $SelYearFrom . "55" . $SelYear . $SelMaxCNUM;
		    }  
			Else {
				echo "Error: No Department, Shift found";
				die;
		    }
		}
		else {
		    If (($_GET["Dept"] == 2) and ($_GET["Shift"] == 1)) {
			If ($SelMaxCNUM == 1) {$SelMaxCNUM = '201';}
			$CNUM = "C2" . $SelYearFrom . "22" . $SelYear . $SelMaxCNUM;
		    } ElseIf (($_GET["Dept"] == 3) and ($_GET["Shift"] == 1)) {
			If ($SelMaxCNUM == 1) {$SelMaxCNUM = '001';}
			$CNUM = "C2" . $SelYearFrom . "11" . $SelYear . $SelMaxCNUM;
		    }  ElseIf (($_GET["Dept"] == 4) and ($_GET["Shift"] == 1)) {
			If ($SelMaxCNUM == 1) {$SelMaxCNUM = '401';}
			$CNUM = "C2" . $SelYearFrom . "33" . $SelYear . $SelMaxCNUM;
		    }  ElseIf (($_GET["Dept"] == 5) and ($_GET["Shift"] == 1)) {
			If ($SelMaxCNUM == 1) {$SelMaxCNUM = '501';}
			$CNUM = "C2" . $SelYearFrom . "44" . $SelYear . $SelMaxCNUM;
		    } ElseIf (($_GET["Dept"] == 6) and ($_GET["Shift"] == 1)) {
			If ($SelMaxCNUM == 1) {$SelMaxCNUM = '601';}
			$CNUM = "C2" . $SelYearFrom . "55" . $SelYear . $SelMaxCNUM;
		    } ElseIf (($_GET["Dept"] == 3) and ($_GET["Shift"] == 2)) {
			If ($SelMaxCNUM == 1) {$SelMaxCNUM = '701';}
			$CNUM = "C2" . $SelYearFrom . "77" . $SelYear . $SelMaxCNUM;
		    } ElseIf (($_GET["Dept"] == 2) and ($_GET["Shift"] == 2)) {
			If ($SelMaxCNUM == 1) {$SelMaxCNUM = '801';}
			$CNUM = "C2" . $SelYearFrom . "88" . $SelYear . $SelMaxCNUM;
		    } Else {
			echo "Error: No Department, Shift found";
			die;
		    }
		}
		
		
		$sfeadmyear = $SelYearFrom . '-' . $SelYearTo;
		echo $CNUM . "<br/>" ;
		echo $sfeadmyear . "<br/>"; 
		echo $_GET['StdId'] . "<br/>";
		//die;
		// Update tblstudent
		// Create StdAdm record
				
		include 'db/db_connect.php';
		$sql = "Update tblstudent Set CNUM = ? , stdpass = ? , feadmyear = ?,createddate = CURRENT_TIMESTAMP where StdId = ?";
		$stmt = $mysqli->prepare($sql);
		$sfeadmyear = $SelYearFrom . '-' . $SelYearTo;
		$stmt->bind_param('sssi', $CNUM, $CNUM, $sfeadmyear , $_GET['StdId']);
			
		if($stmt->execute()){} else { echo $mysqli->error;
			die(" Update Student Unable to update.");
		}
		//divn calculation
		$divn = '';
		if(($_GET['Dept'] == '4') && ($_GET["Shift"] == '1') && ($_GET["Year"] == 'F.E.')){
			$divn = 'E';
		}
		if(($_GET['Dept'] == '5') && ($_GET["Shift"] == '1') && ($_GET["Year"] == 'F.E.')){
			$divn = 'F';
		}
		if(($_GET['Dept'] == '6') && ($_GET["Shift"] == '1') && ($_GET["Year"] == 'F.E.')){
			$divn = 'G';
		}
		if(($_GET['Dept'] == '3') && ($_GET["Shift"] == '2') && ($_GET["Year"] == 'F.E.')){
			$divn = 'H';
		}
		if(($_GET['Dept'] == '2') && ($_GET["Shift"] == '2') && ($_GET["Year"] == 'F.E.')){
			$divn = 'I';
		}
		include 'db/db_connect.php';
		$sql = "Insert into tblstdadm  (StdId, EduYearFrom, EduYearTo, Year, Dept, Shift,stdremark,mhcetscore,`Div`,AdmConf,stdstatus) 
		Values ( ?, ?, ?, ?, ?, ?, ?, ?, ?,1,'R') ";
		$stmt = $mysqli->prepare($sql);
		$stmt->bind_param('isssiisss', $_GET['StdId'], $SelYearFrom, $SelYearToL , $_GET['Year'], $_GET['Dept'], $_GET['Shift'], $_GET['stdrem'], $_GET['mhcetscore'],$divn);
			
		if($stmt->execute()){} else { echo $mysqli->error;
			die("Insert StdAdm Unable to update.");
		}

		include 'db/db_connect.php';
		$sql = "Delete from tblstgstudent where stsgid = ? ";
		$stmt = $mysqli->prepare($sql);
		$stmt->bind_param('i', $_GET['stsgid']);
			
		if($stmt->execute()){} else { echo $mysqli->error;
			//die("Unable to update.");
		}
		
		header('Location: NewAdmissionMain.php'); 

	}

?>

<form >
	<h3 class="page-title" style="margin-left:5%">Peon Maintenance</h3>
	</form>

