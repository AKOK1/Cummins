<form method="post">
<?php
	if(!isset($_SESSION)){
		session_start();
	}
	If (isset($_POST['updaterollnosMTECH'])){
		include 'db/db_connect.php';
		if(!$mysqli->query("CALL SP_UPDATEROLLNOFYMTECH()")){
			echo $mysqli->error;
			die;
		}
		echo '<script>alert("Roll Numbers updated successfully.");</script>';		
	}
	If (isset($_POST['updaterollnos11'])){
		include 'db/db_connect.php';
		if(!$mysqli->query("CALL SP_UPDATEROLLNONEW()")){
			echo $mysqli->error;
			die;
		}
		echo '<script>alert("Roll Numbers updated successfully.");</script>';		
	}
	If (isset($_POST['updaterollnos1'])){
		include 'db/db_connect.php';
		if(!$mysqli->query("CALL SP_UPDATEROLLNOAUTO()")){
			echo $mysqli->error;
			die;
		}
		echo '<script>alert("Roll Numbers updated successfully.");</script>';		
	}
	If (isset($_POST['updaterollnos2'])){
		include 'db/db_connect.php';
		if(!$mysqli->query("CALL SP_UPDATEROLLNO()")){
			echo $mysqli->error;
			die;
		}
		echo '<script>alert("Roll Numbers updated successfully.");</script>';		
	}
	
	If (isset($_POST['updatemtech'])){
		//-----------------
			include 'db/db_connect.php';
			$sql = "SELECT (MAX(EduYearFrom)) AS YearFrom, MAX(EduYearTo) as YearTo FROM tblcuryearauto";
			$result = $mysqli->query($sql);
			$num_results = $result->num_rows;
			If( $num_results ){
				while( $row = $result->fetch_assoc() ){
					extract($row);
					$SelYearFrom = $YearFrom;
					$SelYearTo = $YearTo;
				}
			}
			else {
					echo "Error";
					die;
			}		
			$result->free();
			
			//disconnect from database
			$mysqli->close();

			include 'db/db_connect.php';
			$sql = "SELECT count(*) as AdmCount FROM tblstdadm where EduYearFrom  = " . $SelYearFrom . " AND EduYearTo = " . $SelYearTo . " and YEAR = 'S.Y.' ";
			$result = $mysqli->query($sql);
			$num_results = $result->num_rows;
			If( $num_results ){
				while( $row = $result->fetch_assoc() ){
					extract($row);
					If ($AdmCount == 0) {
						$InsSql = " INSERT INTO tblstdadm (StdID, EduYearFrom, EduYearTo, YEAR, Dept, `Div`, Shift, RollNo, AdmConf,stdremark,stdstatus) " ;

						$SelSql = " SELECT StdID, {$SelYearFrom}, {$SelYearTo}, 'S.Y.' , Dept, `Div`, Shift, RollNo, 1 ,stdremark,'R'
									FROM tblstdadm 
									WHERE COALESCE(stdstatus,'') NOT IN ('DT1','DT2','YD','C','CT') and 
									EduYearFrom =  " . ($SelYearFrom - 1) . " AND EduYearTo =  " . ($SelYearTo - 1) . " AND YEAR = 'M.E.' ";
						$stmt = $mysqli->prepare( $InsSql . $SelSql );
						//echo $InsSql . $SelSql;
						//die;
						if($stmt->execute()){} else { echo $mysqli->error;}
					
					}
				}
				echo '<script>alert("All M. Tech. students progressed to next year successfully.");</script>';
				//header('Location: ProgressionMain.php');
			}											
			$result->free();

			//disconnect from database
			$mysqli->close();
		//------------------
		
	}
	If (isset($_POST['update1'])){
		include 'db/db_connect.php';
		$sql = "SELECT (MAX(EduYearFrom)) AS YearFrom, MAX(EduYearTo) as YearTo FROM tblcuryearauto";
		$result = $mysqli->query($sql);
		$num_results = $result->num_rows;
		If( $num_results ){
			while( $row = $result->fetch_assoc() ){
				extract($row);
				$SelYearFrom = $YearFrom;
				$SelYearTo = $YearTo;
			}
		}
		else {
				echo "Error";
				die;
		}		
		$result->free();
		
		//disconnect from database
		$mysqli->close();

		include 'db/db_connect.php';
		$sql = "SELECT count(*) as AdmCount 
				FROM tblstdadm sa
				inner join tblstudent s on s.StdID = sa.StdID and s.CNUM like '%2016%'
				where EduYearFrom  = " . $SelYearFrom . " AND EduYearTo = " . $SelYearTo . " and sa.stdid > 13953 and year = 'S.E.'";
		$result = $mysqli->query($sql);
		$num_results = $result->num_rows;
		If( $num_results ){
			while( $row = $result->fetch_assoc() ){
				extract($row);
				If ($AdmCount == 0) {
					$InsSql = " INSERT INTO tblstdadm (StdID, EduYearFrom, EduYearTo, YEAR, Dept, `Div`, Shift, RollNo, AdmConf,stdremark) " ;

					/*
					$SelSql = " SELECT StdID, {$SelYearFrom}, {$SelYearTo}, 'A.L.' , Dept, `Div`, Shift, RollNo, 0 ,stdremark
								FROM tblstdadm 
								WHERE COALESCE(stdstatus,'') NOT IN ('DT1','DT2','YD','C','CT') and 
								EduYearFrom =  " . ($SelYearFrom - 1) . " AND EduYearTo =  " . ($SelYearTo - 1) . " AND YEAR = 'B.E.' and stdid > 13953";
					$stmt = $mysqli->prepare( $InsSql . $SelSql );
					if($stmt->execute()){} else { echo $mysqli->error;}
					
					$SelSql = " SELECT StdID, {$SelYearFrom}, {$SelYearTo}, 'B.E.' , Dept, `Div`, Shift,  RollNo, 0 ,stdremark
								FROM tblstdadm 
								WHERE  COALESCE(stdstatus,'') NOT IN ('DT1','DT2','YD','C','CT') and 
								EduYearFrom =  " . ($SelYearFrom - 1) . " AND EduYearTo =  " . ($SelYearTo - 1)  . " AND YEAR = 'T.E.' and stdid > 13953";
					$stmt = $mysqli->prepare( $InsSql . $SelSql );
					if($stmt->execute()){} else { echo $mysqli->error;}

					$SelSql = " SELECT StdID, {$SelYearFrom}, {$SelYearTo}, 'T.E.' , Dept, `Div`, Shift,  RollNo, 0 ,stdremark
								FROM tblstdadm 
								WHERE  COALESCE(stdstatus,'') NOT IN ('DT1','DT2','YD','C','CT') and 
								EduYearFrom =  " . ($SelYearFrom - 1) . " AND EduYearTo =  " . ($SelYearTo - 1)  . " AND YEAR = 'S.E.' and stdid > 13953";
					//echo $SelSql;
					$stmt = $mysqli->prepare( $InsSql . $SelSql );
					if($stmt->execute()){} else { echo $mysqli->error;}

					$SelSql = " SELECT StdID, {$SelYearFrom}, {$SelYearTo}, YEAR , Dept, `Div`, Shift,  RollNo, 0 ,stdremark
								FROM tblstdadm 
								WHERE  COALESCE(stdstatus,'') IN ('DT1','DT2','YD') and 
								EduYearFrom =  " . ($SelYearFrom - 1) . " AND EduYearTo =  " . ($SelYearTo - 1)  . " AND YEAR NOT IN ('A.L.') 
								and stdid > 13953";
					//echo $SelSql;
					$stmt = $mysqli->prepare( $InsSql . $SelSql );
					if($stmt->execute()){} else { echo $mysqli->error;}
					*/
					
					
				$SelSql = " SELECT sa.StdID, {$SelYearFrom}, {$SelYearTo}, 'S.E.' ,
								case when substr(CNUM,7,2) = '11' then 3
								when substr(CNUM,7,2) = '22' then 2
								when substr(CNUM,7,2) = '33' then 4
								when substr(CNUM,7,2) = '44' then 5
								when substr(CNUM,7,2) = '55' then 6
								when substr(CNUM,7,2) = '77' then 3
								when substr(CNUM,7,2) = '88' then 2
								end
								as Dept,
								`Div`, sa.Shift,  RollNo, 0 ,stdremark
								FROM tblstdadm sa
								inner join tblstudent s on s.stdid = sa.stdid  and s.CNUM like '%2016%'
								WHERE  COALESCE(stdstatus,'') NOT IN ('DT1','DT2','YD','C','CT') and 
								EduYearFrom =  " . ($SelYearFrom - 1) . " AND EduYearTo =  " . ($SelYearTo - 1)  . " AND YEAR = 'F.E.' and sa.stdid > 13953";
					//echo $InsSql . $SelSql;
					$stmt = $mysqli->prepare( $InsSql . $SelSql );
					//echo $InsSql . $SelSql;
					//die;
					if($stmt->execute()){} else { echo $mysqli->error;}
					//update roll nos
					//if($mysqli->query("call SP_UPDATEROLLNO()")){

					if(!$mysqli->query("CALL SP_UPDATEDIV()")){
						echo $mysqli->error;
						die;
					}
				}
			}
			echo '<script>alert("All students progressed to next year successfully.");</script>';
			//header('Location: ProgressionMain.php');
		}											
		$result->free();

		//disconnect from database
		$mysqli->close();
		
	}
	If (isset($_POST['update2'])){
		include 'db/db_connect.php';
		$sql = "SELECT (MAX(EduYearFrom)) AS YearFrom, MAX(EduYearTo) as YearTo FROM tblcuryear";
		$result = $mysqli->query($sql);
		$num_results = $result->num_rows;
		If( $num_results ){
			while( $row = $result->fetch_assoc() ){
				extract($row);
				$SelYearFrom = $YearFrom;
				$SelYearTo = $YearTo;
			}
		}
		else {
				echo "Error";
				die;
		}		
		$result->free();
	
		//disconnect from database
		$mysqli->close();

		include 'db/db_connect.php';
		$sql = "SELECT count(*) as AdmCount FROM tblstdadm where EduYearFrom  = " . $SelYearFrom . " AND EduYearTo = " . $SelYearTo . " and stdid < 13954";
		$result = $mysqli->query($sql);
		$num_results = $result->num_rows;
		If( $num_results ){
			while( $row = $result->fetch_assoc() ){
				extract($row);
				If ($AdmCount == 0) {
					$InsSql = " INSERT INTO tblstdadm (StdID, EduYearFrom, EduYearTo, YEAR, Dept, `Div`, Shift, RollNo, AdmConf,stdremark) " ;

					$SelSql = " SELECT StdID, {$SelYearFrom}, {$SelYearTo}, 'A.L.' , Dept, `Div`, Shift, RollNo, 0 ,stdremark
								FROM tblstdadm 
								WHERE COALESCE(stdstatus,'') NOT IN ('DT1','DT2','YD','C','CT') and 
								EduYearFrom =  " . ($SelYearFrom - 1) . " AND EduYearTo =  " . ($SelYearTo - 1) . " AND YEAR = 'B.E.' and stdid < 13954";
					$stmt = $mysqli->prepare( $InsSql . $SelSql );
					if($stmt->execute()){} else { echo $mysqli->error;}
					
					$SelSql = " SELECT StdID, {$SelYearFrom}, {$SelYearTo}, 'B.E.' , Dept, `Div`, Shift,  RollNo, 0 ,stdremark
								FROM tblstdadm 
								WHERE  COALESCE(stdstatus,'') NOT IN ('DT1','DT2','YD','C','CT') and 
								EduYearFrom =  " . ($SelYearFrom - 1) . " AND EduYearTo =  " . ($SelYearTo - 1)  . " AND YEAR = 'T.E.' and stdid < 13954";
					$stmt = $mysqli->prepare( $InsSql . $SelSql );
					if($stmt->execute()){} else { echo $mysqli->error;}

					$SelSql = " SELECT StdID, {$SelYearFrom}, {$SelYearTo}, 'T.E.' , Dept, `Div`, Shift,  RollNo, 0 ,stdremark
								FROM tblstdadm 
								WHERE  COALESCE(stdstatus,'') NOT IN ('DT1','DT2','YD','C','CT') and 
								EduYearFrom =  " . ($SelYearFrom - 1) . " AND EduYearTo =  " . ($SelYearTo - 1)  . " AND YEAR = 'S.E.' and stdid < 13954";
					//echo $SelSql;
					$stmt = $mysqli->prepare( $InsSql . $SelSql );
					if($stmt->execute()){} else { echo $mysqli->error;}

					$SelSql = " SELECT StdID, {$SelYearFrom}, {$SelYearTo}, YEAR , Dept, `Div`, Shift,  RollNo, 0 ,stdremark
								FROM tblstdadm 
								WHERE  COALESCE(stdstatus,'') IN ('DT1','DT2','YD') and 
								EduYearFrom =  " . ($SelYearFrom - 1) . " AND EduYearTo =  " . ($SelYearTo - 1)  . " AND YEAR NOT IN ('A.L.') 
								and stdid < 13954";
					//echo $SelSql;
					$stmt = $mysqli->prepare( $InsSql . $SelSql );
					if($stmt->execute()){} else { echo $mysqli->error;}

					$SelSql = " SELECT sa.StdID, {$SelYearFrom}, {$SelYearTo}, 'S.E.' ,
								case when substr(CNUM,7,2) = '11' then 3
								when substr(CNUM,7,2) = '22' then 2
								when substr(CNUM,7,2) = '33' then 4
								when substr(CNUM,7,2) = '44' then 5
								when substr(CNUM,7,2) = '55' then 6
								when substr(CNUM,7,2) = '77' then 3
								when substr(CNUM,7,2) = '88' then 2
								end
								as Dept,
								`Div`, sa.Shift,  RollNo, 0 ,stdremark
								FROM tblstdadm sa
								inner join tblstudent s on s.stdid = sa.stdid 
								WHERE  COALESCE(stdstatus,'') NOT IN ('DT1','DT2','YD','C','CT') and 
								EduYearFrom =  " . ($SelYearFrom - 1) . " AND EduYearTo =  " . ($SelYearTo - 1)  . " AND YEAR = 'F.E.' and sa.stdid < 13954";
					//echo $InsSql . $SelSql;
					$stmt = $mysqli->prepare( $InsSql . $SelSql );
					if($stmt->execute()){} else { echo $mysqli->error;}
					//update roll nos
					//if($mysqli->query("call SP_UPDATEROLLNO()")){

					if(!$mysqli->query("CALL SP_UPDATEDIV()")){
						echo $mysqli->error;
						die;
					}
				}
			}
			echo '<script>alert("All students progressed to next year successfully.");</script>';
			//header('Location: ProgressionMain.php');
		}											
		$result->free();

		//disconnect from database
		$mysqli->close();
		
	}

?>	
	<br /><br /><br />
	
	
	<h3 class="page-title" style="margin-left:5%">Progress Students - Autonomy</h3>
	<h3 class="page-title" style="margin-left:5%">Progress Students - Autonomy</h3>
	<h3 class="page-title" style="float:right;margin-top:-46px;"><a href='MainMenuMain.php'>Back</a></h3>;

	<table cellpadding="10" cellspacing="0" border="0" class="tab_split" style="margin-left:5%;width:80%">
		<tr >
			<td class="form_sec span3">
				<?php
					include 'db/db_connect.php';
					$sql = "SELECT (MAX(EduYearTo) - 1) AS YearFrom, MAX(EduYearTo) as YearTo FROM tblcuryearauto";
					$result = $mysqli->query( $sql );
					$num_results = $result->num_rows;

					if( $num_results ){
						while( $row = $result->fetch_assoc() ){
							extract($row);
							echo "<label id='lblSuccess' style='color:red;font-weight:bold' >Students will be admitted to {$YearFrom} - {$YearTo} year. <br/>Please contact Administrator if this is not correct.<br/> If the dates are correct, please proceed with click of 'Progrss Students'  button.</label>";
						}
					}					
					//disconnect from database
					$result->free();
					$mysqli->close();
				?>
			</td>								
			<td class="form_sec span1">
				<input type='submit' class="btn btn btn-success" name='update1' value='Progress Students - Non M.tech.' /><br/><br/>
				<input type='submit' class="btn btn btn-success" name='updatemtech' value='Progress Students - M.tech. Only' />
			</td>								
			<td class="form_sec span1">
				<input type='submit' class="btn btn btn-success" name='updaterollnos11' value='Update Roll Numbers - F.Y. B.Tech. Only' /><br/><br/>
				<input type='submit' class="btn btn btn-success" name='updaterollnos1' value='Update Roll Numbers - Non M.Tech.' /><br/><br/>
				<input type='submit' class="btn btn btn-success" name='updaterollnosMTECH' value='Update Roll Numbers - F.Y. M.Tech. Only' />
			</td>								
			<td class="form_sec span1">
				<a href="ProgressionMain.php">Go to Confirm Admissions</a>
			</td>								
			
		</tr>						
	</table>

	
		<br /><br /><br />
	
	
	<h3 class="page-title" style="margin-left:5%">Progress Students - SPPU</h3>
	<h3 class="page-title" style="float:right;margin-top:-46px;"><a href='MainMenuMain.php'>Back</a></h3>;

	<table cellpadding="10" cellspacing="0" border="0" class="tab_split" style="margin-left:5%;width:80%">
		<tr >
			<td class="form_sec span3">
				<?php
					include 'db/db_connect.php';
					$sql = "SELECT (MAX(EduYearTo) - 1) AS YearFrom, MAX(EduYearTo) as YearTo FROM tblcuryear";
					$result = $mysqli->query( $sql );
					$num_results = $result->num_rows;

					if( $num_results ){
						while( $row = $result->fetch_assoc() ){
							extract($row);
							echo "<label id='lblSuccess' style='color:red;font-weight:bold' >Students will be admitted to {$YearFrom} - {$YearTo} year. <br/>Please contact Administrator if this is not correct.<br/> If the dates are correct, please proceed with click of 'Progrss Students'  button.</label>";
						}
					}					
					//disconnect from database
					$result->free();
					$mysqli->close();
				?>
			</td>								
			<td class="form_sec span1">
				<input type='submit' class="btn btn btn-success" name='update2' value='Progress Students' />
			</td>								
			<td class="form_sec span1">
				<input type='submit' class="btn btn btn-success" name='updaterollnos2' value='Update Roll Numbers' />
			</td>								
			<td class="form_sec span1">
				<a href="ProgressionMain.php">Go to Confirm Admissions</a>
			</td>								
			
		</tr>						
	</table>

	<br/>
</form>