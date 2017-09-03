<form name="myform" method='post' action='StructureViewMain.php' enctype="multipart/form-data">
<head>
	<?php
	if(!isset($_SESSION)){
			session_start();
		}
			if (isset($_POST['chkiscomp'])) {
				$tmpIsComp = '1';
			}
			else
				$tmpIsComp = '0';
		
	?>
	<?php
	//include database connection
	include 'db/db_connect.php';
	if(!isset($_SESSION)){
		session_start();
	}
	$sql = "SELECT DeptID,DeptName 
			FROM tbluser U 
			INNER JOIN tbldepartmentmaster DM on U.Department = DM.DeptName
			where userID =  " . $_SESSION["SESSUserID"] . " and coalesce(teaching,0) = 1";
	//echo $sql;
	$result1 = $mysqli->query( $sql );
	while( $row = $result1->fetch_assoc() ) {
		extract($row);
		$_SESSION["SESSRAUserDept"] = $DeptName;
		$_SESSION["SESSRAUserDeptID"] = $DeptID;
	}		
	
	$sql2 = "SELECT SubjectName
			from tblpapermaster pm 
			INNER JOIN tblsubjectmaster sm ON sm.subjectid = pm.subjectid
			where paperid =  " . $_SESSION["PaperId"] ;
	//echo $sql;
	$result2 = $mysqli->query( $sql2 );
	while( $row2 = $result2->fetch_assoc() ) {
		extract($row2);
	}		
	
	
?>

	<script>
	
		$(function() { 
			$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
				localStorage.setItem('myTab', $(this).attr('href'));
			});
			var myTab = localStorage.getItem('myTab');
			if (myTab) {
				$('[href="' + myTab + '"]').tab('show');
			}
		});
		
		function ClearFields2()  {
			//document.getElementById("lblpatid").value = "0";
			document.getElementById("txtDesc").value = "";			
			document.getElementById("update2").value = 'Add';
		}
			
		function ClearFields3()  {
			document.getElementById("txtcourseoutdesc").value = "";
			document.getElementById("update3").value = 'Add';
		}

		function ClearFields4()  {
			//document.getElementById("lblpatid").value = "0";
			document.getElementById("ddlunit").value = "";
			document.getElementById("txthours").value = "";
			document.getElementById("txtsydesc").value = "";
			document.getElementById("txtunittitle").value = "";
			document.getElementById("update4").value = 'Add';
		}

		function ClearFields1()  {
			//document.getElementById("lblpatid").value = "0";
			document.getElementById("txtpretopic").value = "";
			document.getElementById("txtpreread").value = "";
			document.getElementById("update1").value = 'Add';
		}
				
		function ClearFields5()  {
			//document.getElementById("lblpatid").value = "0";
			document.getElementById("txtcexp").value = "";
			document.getElementById("chkiscomp").value = "";
			document.getElementById("update5").value = 'Add';
		}

		function ClearFields6()  {
			//document.getElementById("lblpatid").value = "0";
			document.getElementById("txttextbooks").value = "";
			document.getElementById("txtrefmaterial").value = "";
			document.getElementById("update6").value = 'Add';
		}
		function ClearFields7()  {
			//document.getElementById("lblpatid").value = "0";
			document.getElementById("txtprereqcourse").value = "";
			document.getElementById("update7").value = 'Add';
		}
		function ClearFields8()  {
			//document.getElementById("lblpatid").value = "0";
			document.getElementById("txtrefbooks").value = "";
			document.getElementById("update8").value = 'Add';
		}
		function ClearFields9()  {
			//document.getElementById("lblpatid").value = "0";
			document.getElementById("txtrefmaterial").value = "";
			document.getElementById("update9").value = 'Add';
		}

		function fnEditdataprereq(prereqid) {
			var gvET = document.getElementById("grdpublistprereq");
			var rCount = gvET.rows.length;
			var rowIdx;
			for (rowIdx=1; rowIdx<=rCount-1; rowIdx++) {						
				var rowElement = gvET.rows[rowIdx];
				if (parseInt(rowElement.cells[1].innerText) == parseInt(prereqid)){									
					document.getElementById("hdnprereqid").value = prereqid;
					document.getElementById("txtpretopic").value =rowElement.cells[2].innerText;
					document.getElementById("txtpreread").value =rowElement.cells[3].innerText;
					document.getElementById("update1").value = 'Update';
					break;
				}					
			}
		}
		function fnEditdataprereqbycourse(prereqidbycourse) {
			var gvET = document.getElementById("grdpublistprereqbycourse");
			var rCount = gvET.rows.length;
			var rowIdx;
			for (rowIdx=1; rowIdx<=rCount-1; rowIdx++) {						
				var rowElement = gvET.rows[rowIdx];
				if (parseInt(rowElement.cells[1].innerText) == parseInt(prereqidbycourse)){									
					document.getElementById("hdnprereqidbycourse").value = prereqidbycourse;
					document.getElementById("txtprereqcourse").value =rowElement.cells[2].innerText;
					document.getElementById("update7").value = 'Update';
					break;
				}					
			}
		}
		function fnEditdatarefbook(refbookid) {
			var gvET = document.getElementById("grdpublistrefbook");
			var rCount = gvET.rows.length;
			var rowIdx;
			for (rowIdx=1; rowIdx<=rCount-1; rowIdx++) {						
				var rowElement = gvET.rows[rowIdx];
				if (parseInt(rowElement.cells[1].innerText) == parseInt(refbookid)){									
					document.getElementById("hdnrefbookid").value = refbookid;
					document.getElementById("txtrefbooks").value =rowElement.cells[2].innerText;
					document.getElementById("update8").value = 'Update';
					break;
				}					
			}
		}
		function fnEditdatarefmatbook(refmatbookid) {
			var gvET = document.getElementById("grdpublistrefmatbook");
			var rCount = gvET.rows.length;
			var rowIdx;
			for (rowIdx=1; rowIdx<=rCount-1; rowIdx++) {						
				var rowElement = gvET.rows[rowIdx];
				if (parseInt(rowElement.cells[1].innerText) == parseInt(refmatbookid)){									
					document.getElementById("hdnrefmatbookid").value = refmatbookid;
					document.getElementById("txtrefmaterial").value =rowElement.cells[2].innerText;
					document.getElementById("update9").value = 'Update';
					break;
				}					
			}
		}
		
		function fnEditdatCourseobj(courseobjid) {
			var gvET = document.getElementById("grdpublistcobj");
			var rCount = gvET.rows.length;
			var rowIdx;
			for (rowIdx=1; rowIdx<=rCount-1; rowIdx++) {						
				var rowElement = gvET.rows[rowIdx];
				if (parseInt(rowElement.cells[1].innerText) == parseInt(courseobjid)){									
					document.getElementById("hdncourseobjid").value = courseobjid;
					document.getElementById("txtDesc").value =rowElement.cells[2].innerText;
					document.getElementById("update2").value = 'Update';
					break;
				}					
			}
		}


		function fnEditdatacourseout(courseoutid) {
			var gvET = document.getElementById("grdpublistcout");
			var rCount = gvET.rows.length;
			var rowIdx;
			for (rowIdx=1; rowIdx<=rCount-1; rowIdx++) {						
				var rowElement = gvET.rows[rowIdx];
				if (parseInt(rowElement.cells[1].innerText) ==parseInt(courseoutid)){									
					document.getElementById("hdncourseoutid").value = courseoutid;
					document.getElementById("txtcourseoutdesc").value =rowElement.cells[2].innerText;
					document.getElementById("update3").value = 'Update';
					document.myform.submit();					
					break;
				}					
			}
		}

		function fnEditdatasylabi(syllabusID) {
			var gvET = document.getElementById("grdpublistsyllabi");
			var rCount = gvET.rows.length;
			var rowIdx;
			for (rowIdx=1; rowIdx<=rCount-1; rowIdx++) {						
				var rowElement = gvET.rows[rowIdx];
				if (parseInt(rowElement.cells[1].innerText) ==parseInt(syllabusID)){									
					document.getElementById("hdnsyllabusID").value = syllabusID;
					document.getElementById("ddlunit").value =rowElement.cells[2].innerText;
					document.getElementById("txthours").value =rowElement.cells[3].innerText;
					document.getElementById("txtsydesc").value =rowElement.cells[4].innerText;
					document.getElementById("txtunittitle").value = rowElement.cells[5].innerText;

					document.getElementById("update4").value = 'Update';
					break;
				}					
			}
		}

		function fnEditdataexp(expid) {
			var gvET = document.getElementById("grdpublistexp");
			var rCount = gvET.rows.length;
			var rowIdx;
			for (rowIdx=1; rowIdx<=rCount-1; rowIdx++) {						
				var rowElement = gvET.rows[rowIdx];
				if (parseInt(rowElement.cells[1].innerText) ==parseInt(expid)){									
					document.getElementById("hdnexpid").value = expid;
					document.getElementById("txtcexp").value =rowElement.cells[2].innerText;
					if(rowElement.cells[3].innerText == 'Yes')
						document.getElementById("chkiscomp").checked = true;
					else
						document.getElementById("chkiscomp").checked = false;
					document.getElementById("update5").value = 'Update';
					break;
				}					
			}
		}
		function fnEditdataexpanyout(PaperID) {
			var gvET = document.getElementById("grdtblanyout");
			var rCount = gvET.rows.length;
			var rowIdx;
			for (rowIdx=1; rowIdx<=rCount-1; rowIdx++) {						
				var rowElement = gvET.rows[rowIdx];
				if (parseInt(rowElement.cells[1].innerText) ==parseInt(PaperID)){									
					document.getElementById("hdnsyllabusID").value = PaperID;
					document.getElementById("txtany").value =rowElement.cells[2].innerText;
					document.getElementById("txtout").value =rowElement.cells[3].innerText;
					document.getElementById("btnedit").value = 'Update';
					break;
				}					
			}
		}

		function fnEditdatabook(bookid) {
			var gvET = document.getElementById("grdpublistbook");
			var rCount = gvET.rows.length;
			var rowIdx;
			for (rowIdx=1; rowIdx<=rCount-1; rowIdx++) {						
				var rowElement = gvET.rows[rowIdx];
				if (parseInt(rowElement.cells[1].innerText) ==parseInt(bookid)){									
					document.getElementById("hdnbookid").value = bookid;
					document.getElementById("txttextbooks").value =rowElement.cells[2].innerText;
					document.getElementById("txtrefmaterial").value =rowElement.cells[3].innerText;
					document.getElementById("update6").value = 'Update';
					break;
				}					
			}
		}

		function confirmConfirm() {
			if (confirm("Data can not be edited after confirmation. Are you sure you want to Confirm?")) {
				return true;
			}
			else
				return false;
		}
				
		$(function() { 
			$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
				localStorage.setItem('myTab', $(this).attr('href'));
			});
			var myTab = localStorage.getItem('myTab');
			if (myTab) {
				$('[href="' + myTab + '"]').tab('show');
			}
		});
				
	</script>	
</head> 

<body> 
	<br/><br/><br/>
	<?php
		if(!isset($_SESSION)){
			session_start();
		}
		if(!isset($_POST['update3'])){
			$_SESSION["courseoutid"] = "I";
		}
		If(!isset($_SESSION["SESSUserID"]))
			header('Location: login.php?'); 

		// echo $_SESSION["PaperId"] ;
		
		include 'db/db_connect.php';

		$edit_record1=$_SESSION["SESSUserID"];
		
		if(isset($_POST['update1'])){
			include 'db/db_connect.php';
			if($_POST['hdnprereqid'] == ''){
				$stmt = $mysqli->prepare("INSERT INTO tblsyllaprereq (prebytopic,preread, paperid) VALUES (?,?,?)");
				$stmt->bind_param('ssi', $_POST['txtpretopic'],$_POST['txtpreread'], $_SESSION["PaperId"]);
				$stmt->execute(); 
				$stmt->close();
			}
			else{
				$txtpretopic=addslashes($_POST['txtpretopic']);
				$txtpreread=addslashes($_POST['txtpreread']);

				$stmt = $mysqli->prepare("Update tblsyllaprereq set prebytopic=?, preread=? where prereqid = ?");
				$stmt->bind_param('ssi', $_POST['txtpretopic'],$_POST['txtpreread'], $_POST['hdnprereqid']);
				$stmt->execute(); 
				$stmt->close();
			}		
			echo '<script>alert("UPDATED SUCCESSFULLY");</script>';
		}
			if(isset($_POST['update7'])){
			include 'db/db_connect.php';
			//echo $_POST['txtprereqcourse'];
			$txtprereqcourse=addslashes($_POST['txtprereqcourse']);
			//echo $txtprereqcourse;
			//die;
			if($_POST['hdnprereqidbycourse'] == ''){
				$stmt = $mysqli->prepare("INSERT INTO tblsyllaprebycourse (prereqbycourse, paperid) VALUES (?,?)");
				$stmt->bind_param('si',$txtprereqcourse, $_SESSION["PaperId"]);
				$stmt->execute(); 
				$stmt->close();
			}
			else{
				$stmt = $mysqli->prepare("Update tblsyllaprebycourse set prereqbycourse=? where prereqidbycourse = ?");
				$stmt->bind_param('si',$txtprereqcourse,$_POST['hdnprereqidbycourse']);
				$stmt->execute(); 
				$stmt->close();
			}		
			echo '<script>alert("UPDATED SUCCESSFULLY");</script>';
		}
		if(isset($_POST['update8'])){
			include 'db/db_connect.php';
			if($_POST['hdnrefbookid'] == ''){
				$stmt = $mysqli->prepare("INSERT INTO tblsyllarefbooks (refbooks, paperid) VALUES (?,?)");
				$stmt->bind_param('si',$_POST['txtrefbooks'], $_SESSION["PaperId"]);
				$stmt->execute(); 
				$stmt->close();
			}
			else{
				$txtrefbooks=addslashes($_POST['txtrefbooks']);

				$stmt = $mysqli->prepare("Update tblsyllarefbooks set refbooks=? where refbookid = ?");
				$stmt->bind_param('si',$_POST['txtrefbooks'],$_POST['hdnrefbookid']);
				$stmt->execute(); 
				$stmt->close();
			}		
			echo '<script>alert("UPDATED SUCCESSFULLY");</script>';
		}
		if(isset($_POST['update9'])){
			include 'db/db_connect.php';
			if($_POST['hdnrefmatbookid'] == ''){
				$stmt = $mysqli->prepare("INSERT INTO tblsyllarefmatbooks (refmaterial, paperid) VALUES (?,?)");
				$stmt->bind_param('si',$_POST['txtrefmaterial'], $_SESSION["PaperId"]);
				$stmt->execute(); 
				$stmt->close();
			}
			else{
				$txtrefmaterial=addslashes($_POST['txtrefmaterial']);

				$stmt = $mysqli->prepare("Update tblsyllarefmatbooks set refmaterial=? where refmatbookid = ?");
				$stmt->bind_param('si',$_POST['txtrefmaterial'],$_POST['hdnrefmatbookid']);
				$stmt->execute(); 
				$stmt->close();
			}		
			echo '<script>alert("UPDATED SUCCESSFULLY");</script>';
		}

		if(isset($_POST['update2'])){
			if($_POST['hdncourseobjid'] == ''){
				include 'db/db_connect.php';
				$stmt = $mysqli->prepare("INSERT INTO tblsyllaobj(coursedesc, paperid) VALUES (?,?)");
				$stmt->bind_param('si', $_POST['txtDesc'], $_SESSION["PaperId"]);
				$stmt->execute(); 
				$stmt->close();
			}
			else{
				$txtDesc=addslashes($_POST['txtDesc']);
				$stmt = $mysqli->prepare("update tblsyllaobj set coursedesc = ? where courseobjid = ?");
				$stmt->bind_param('si', $_POST['txtDesc'], $_POST["hdncourseobjid"]);
				$stmt->execute(); 
				$stmt->close();
			}		
			echo '<script>alert("UPDATED SUCCESSFULLY");</script>';
		}
		//and (!isset($_POST['update3']))
		if(isset($_POST['hdncourseoutid']))
		{
			if($_POST['hdncourseoutid'] <> ''){
			$_SESSION["courseoutid"] = $_POST['hdncourseoutid'];
			//echo "<script>alert(document.getElementById('hdncourseoutid').value);</script>";
			}
		}	
		if(isset($_POST['update3'])){
			if($_SESSION["courseoutid"] == 'I'){
				include 'db/db_connect.php';
				$stmt = $mysqli->prepare("INSERT INTO tblsyllaoutcome(coursedesc, paperid) VALUES (?,?)");
				$stmt->bind_param('si', $_POST['txtcourseoutdesc'], $_SESSION["PaperId"]);
				if($stmt->execute()) {
					$id = $stmt->insert_id;
					$_SESSION["courseoutid"] = $id;
					//header("Location: QuestionListMain.php"); 	
					}
				else{
					 echo $mysqli->error;
					 die("Unable to insert.");
				}	
				$stmt->close();
			}
		else {
				$txtcourseoutdesc=addslashes($_POST['txtcourseoutdesc']);
				$stmt = $mysqli->prepare("update tblsyllaoutcome set coursedesc = ? where  courseoutid = ?");
				$stmt->bind_param('si', $_POST['txtcourseoutdesc'], $_SESSION["courseoutid"]);
				$stmt->execute(); 
				$stmt->close();
				//$_SESSION["courseoutid"] = $_POST["hdncourseoutid"];
			}		
			//---------------- PO UPDATE START
			// delete existing POs for courseoutid!
			$sqlDel = "Delete from tblmapcopo where courseoutid = ? ";
			$stmt = $mysqli->prepare($sqlDel);
			$stmt->bind_param('i', $_SESSION["courseoutid"]);
			if($stmt->execute()){
				//header('Location: SubjectList.php?'); 
			} else{
				echo $mysqli->error;
				//die("Unable to update.");
			}

			$pos = $_POST['chkmappo'];
			if($pos <> ''){
				if(count($pos) > 0) {
						foreach (array('txtmappo','chkmappo','ddllevelpo', 'txtpojustpo' ) as $pos) {
									foreach ($_POST[$pos] as $id => $row) {
											$_POST[$pos][$id] = mysqli_real_escape_string($mysqli, $row);
									} 
							}
							$mappos = $_POST['txtmappo'];
							$CheckPOs = $_POST['chkmappo'];
							$ddlLevelspo =  $_POST['ddllevelpo'];
							$Justspo = $_POST['txtpojustpo'];
							$size = count($mappos);
							//echo count($CheckPOs);

								$k = 0;
								for($i = 0 ; $i < $size ; $i++){	
								//echo $CheckPOs[$i] . " " . $k . "</br>";
								//$ischecked = 0;
								//if(isset($CheckPOs[$i]))
								//	$ischecked =  1;
							if(isset($CheckPOs[$k]))
							{
									if($CheckPOs[$k] == $i){
										$sql = "Insert into tblmapcopo ( courseoutid, mappo, mappochecked, polevel, pojust) 
											Values ( ?, ?, 1, ?, ?)";
											//echo $sql;
										$stmt = $mysqli->prepare($sql);
										//echo $Justspo[$i] . "</br>";
										$stmt->bind_param('isis', $_SESSION["courseoutid"],str_replace("'","''",$mappos[$i]), $ddlLevelspo[$i],$Justspo[$i]);

										if($stmt->execute()){
										//header('Location: SubjectList.php?'); 
										} else{
										echo $mysqli->error;
										//die("Unable to update.");
										}				
										$k = $k + 1;
									}
							}
							}
				}	
			}
				
				//$_SESSION["courseoutid"] = "I";
			//---------------- PO UPDATE END
			
			//---------------- PSO UPDATE START
			// delete existing POs for courseoutid!
			$sqlDel = "Delete from tblmapcopso where courseoutid = ? ";
			$stmt = $mysqli->prepare($sqlDel);
			$stmt->bind_param('i', $_SESSION["courseoutid"]);
			if($stmt->execute()){
				//header('Location: SubjectList.php?'); 
			} else{
				echo $mysqli->error;
				//die("Unable to update.");
			}

			$pos = $_POST['chkmappso'];
			if($pos <> ''){
				if(count($pos) > 0) {
						foreach (array('txtmappso','chkmappso','ddllevelpso', 'txtpojustpso' ) as $pos) {
									foreach ($_POST[$pos] as $id => $row) {
											$_POST[$pos][$id] = mysqli_real_escape_string($mysqli, $row);
									} 
							}
							$mappsos = $_POST['txtmappso'];
							$CheckPsOs = $_POST['chkmappso'];
							$ddlLevelspso =  $_POST['ddllevelpso'];
							$Justspso = $_POST['txtpojustpso'];
							$size = count($mappsos);
							//echo count($CheckPOs);

								$k = 0;
								for($i = 0 ; $i < $size ; $i++){	
								//echo $CheckPOs[$i] . " " . $k . "</br>";
								//$ischecked = 0;
								//if(isset($CheckPOs[$i]))
								//	$ischecked =  1;
							if(isset($CheckPsOs[$k]))
							{
									if($CheckPsOs[$k] == $i){
										$sql = "Insert into tblmapcopso ( courseoutid, mappso, mappsochecked, psolevel, psojust) 
											Values ( ?, ?, 1, ?, ?)";
											//echo $sql;
										$stmt = $mysqli->prepare($sql);
										//echo $Justspo[$i] . "</br>";
										$stmt->bind_param('isis', $_SESSION["courseoutid"],str_replace("'","''",$mappsos[$i]), $ddlLevelspso[$i],$Justspso[$i]);

										if($stmt->execute()){
										//header('Location: SubjectList.php?'); 
										} else{
										echo $mysqli->error;
										//die("Unable to update.");
										}				
										$k = $k + 1;
									}
							}
							}
				}	
			}
				
				//$_SESSION["courseoutid"] = "I";
			//---------------- PSO UPDATE END
			echo '<script>alert("UPDATED SUCCESSFULLY");</script>';
		}

		if(isset($_POST['update4'])){
			if($_POST['hdnsyllabusID'] == ''){
				include 'db/db_connect.php';
				$stmt = $mysqli->prepare("INSERT INTO tblsyllacontents (sname ,hrs ,Syllabusdesc, paperid,unittitle) VALUES (?,?,?,?,?)");
				$stmt->bind_param('sssis', $_POST['ddlunit'],$_POST['txthours'],$_POST['txtsydesc'], $_SESSION["PaperId"],$_POST['txtunittitle']);
				$stmt->execute(); 
				$stmt->close();
			}
			else{
				$ddlunit=addslashes($_POST['ddlunit']);
				$txthours=addslashes($_POST['txthours']);
				$txtsydesc=addslashes($_POST['txtsydesc']);
				$unittitle=addslashes($_POST['txtunittitle']);
				$stmt = $mysqli->prepare("Update tblsyllacontents set sname = ?, hrs = ?, Syllabusdesc= ?,unittitle = ? where syllabusID = ?");
				$stmt->bind_param('ssssi', $_POST['ddlunit'],$_POST['txthours'],$_POST['txtsydesc'],$_POST['txtunittitle'], $_POST['hdnsyllabusID']);
				$stmt->execute(); 
				$stmt->close();
			}		
			echo '<script>alert("UPDATED SUCCESSFULLY");</script>';
		}

		if(isset($_POST['update5'])){
			if($_POST['hdnexpid'] == ''){
				include 'db/db_connect.php';
				$stmt = $mysqli->prepare("INSERT INTO tblsyllaexpts (complexp ,Iscomp, paperid) VALUES (?,?,?)");
				$stmt->bind_param('sii', $_POST['txtcexp'], $tmpIsComp, $_SESSION["PaperId"]);
				$stmt->execute(); 
				$stmt->close();
			}
			else {
				$txtcexp=addslashes($_POST['txtcexp']);
				//$chkiscomp=addslashes($_POST['chkiscomp']);
				//$chkiscomp	=$chkiscomp;
				// echo $chkiscomp;
				$stmt = $mysqli->prepare("Update tblsyllaexpts set complexp = ?, Iscomp = ? where expid = ?");
				$stmt->bind_param('sii', $_POST['txtcexp'],$tmpIsComp, $_POST['hdnexpid']);
				$stmt->execute(); 
				$stmt->close();
			}		
		}
		if(isset($_POST['btnUpdate'])){
		include 'db/db_connect.php';
				$txtany=$_POST['txtany'];
				$txtout=$_POST['txtout'];
				$query1="update tblpapermaster set syllaAny='$txtany',syllaOut='$txtout'
				where PaperID=" . $_SESSION["PaperId"] . "";
				mysqli_query($mysqli, $query1);		
				
			//echo $query1;
			echo '<script>alert("UPDATED SUCCESSFULLY");</script>';
		}

		if(isset($_POST['update6'])){
			if($_POST['hdnbookid'] == ''){
				$stmt = $mysqli->prepare("INSERT INTO tblsyllabooks(textbooks, paperid) VALUES (?,?)");
				$stmt->bind_param('si', $_POST['txttextbooks'], $_SESSION["PaperId"]);
				$stmt->execute(); 
				$stmt->close();
			}
			else {
				$txtcexp=addslashes($_POST['txtcexp']);
				//$txtexp=addslashes($_POST['txtexp']);
				$stmt = $mysqli->prepare("Update tblsyllabooks set textbooks = ? where bookid = ?");
				$stmt->bind_param('si', $_POST['txttextbooks'],$_POST['hdnbookid']);
				$stmt->execute(); 
				$stmt->close();

				}		
			echo '<script>alert("UPDATED SUCCESSFULLY");</script>';
		}
		$edit_record = $_SESSION["SESSUserID"];

		$query1="SELECT PaperID,syllaAny,syllaOut FROM tblpapermaster WHERE PaperID = " . $_SESSION["PaperId"] . "";
	//echo $query13;
	$run=mysqli_query($mysqli,$query1);
	while($row=mysqli_fetch_array($run))
	{
		extract($row);
	}
		//$pid=0;
		$tpatent="";
		$bkauth1="";
		$patentnum="";
		$country="";
		$pyr="";
		$patentstat="";
		$pUrl="";
		$patid="";
		$pretopic="";
		$precourse="";
		$preread="";
		$cobjdesc="";
		$courseoutdesc="";
		$sydesc = "";
		$syhrs ="";
		$unittitle="";
		$syname="";
		$cexp="";
		$Iscomp="";
		$books="";
		$refbooks="";
		$refmaterial="";
		$syunit="";
		$expany="";
		//echo $expany;
		$expout="";
		
		echo "<script type='text/javascript'>window.onload = function()
			{
					document.getElementById('lblSuccess').style.display = 'block';
			}
			</script>";

	?>

	<!-- BEGIN CONTAINER -->
<div id="container" class="row-fluid">
      <!-- BEGIN PAGE -->
	<div id="main-content">
         <!-- BEGIN PAGE CONTAINER-->
		<div class="container-fluid">
            <!-- BEGIN PAGE CONTENT-->
			<div class="row-fluid">
				<div class="span12">
					<div class="widget box purple">
						<div class="widget-title">
								<h4>
								<!--  <i class="icon-reorder"></i> STUDENT REGISTRATION</span> -->
								<div style="float:left">
									<i class="icon-reorder"></i> Syllabus Definition</span>
								</div>
								<div style="float:left">
									<table>
										<tr>
											<td>
												&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Department: <?php echo $_SESSION["SESSRAUserDept"];?>
											</td>
											<td>
												&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Subject: <?php echo $SubjectName; ?>
											</td>
										</tr>
									</table>								
								</div>
								</h4>

						
						
							<h4 style="float:right"> 
							<?php 
								if(isset($_SESSION["SESSFrom"]) && ($_SESSION["SESSFrom"] == "fromadmin")) 
									echo "<a style='color:white' href='StructureListMain.php'>Back</a>"; 
								else
									echo "<a style='color:white' href='StructureListMain.php'>Back</a>"; 
							?>
							</h4>
						</div>
						<div class="widget-body">
							<form class="form-horizontal" name="form1" action="#">
								<div id="tabsleft" class="tabbable tabs-left">
									<ul id="myTab">
										<li><a href="#tabsleft-tab1"  data-toggle="tab"> <span class="Strong">Pre-requisites by Topic</span></a></li>
										<li><a href="#tabsleft-tab2"  data-toggle="tab"> <span class="Strong">Pre-requisites by Course</span></a></li>
										<li><a href="#tabsleft-tab3"  data-toggle="tab"> <span class="Strong">Course Objectives List</span></a></li>
										<li><a href="#tabsleft-tab4"  data-toggle="tab"> <span class="Strong">Course Outcomes List</span></a></li>
										<li><a href="#tabsleft-tab5"  data-toggle="tab"> <span class="Strong">Course Contents</span></a></li>
										<li><a href="#tabsleft-tab6"  data-toggle="tab"> <span class="Strong">List of Experiments</span></a></li>
										<li><a href="#tabsleft-tab7"  data-toggle="tab"> <span class="Strong">Text Books</span></a></li>
										<li><a href="#tabsleft-tab8"  data-toggle="tab"> <span class="Strong">Reference Books</span></a></li>
										<li><a href="#tabsleft-tab9"  data-toggle="tab"> <span class="Strong">Reference Material</span></a></li>
									</ul>
									<div class="tab-content">
									<div class="tab-pane" id="tabsleft-tab1">
										<h3><b>Pre-requisites by Topic</b></h3>
										<div class="control-group">
											<div class="controls">
												<table>
													<tr>
														<td><input type="text" id="hdnprereqid"  name="hdnprereqid" style="display:none" value="" /></td>
													</tr>
													<tr>								
														<td ><label class="control-label">Pre-requisite by topic</label></td>
													</tr>	
													<tr>
														<td>
														<input type="text" id="txtpretopic"  name="txtpretopic"  style="width:300px" type="text" value="<?php echo $pretopic; ?>">
														</td>
														
													</tr>
													<tr>
														<td ><label class="control-label">Pre-Read</label></td>
													</tr>
													<tr>
														<td><input type="text" id="txtpreread"  name="txtpreread"  style="width:300px" type="text" value="<?php echo $preread; ?>"></td>
													</tr>
												</table>
											</div>	
										</div>						
										<?php
											if(($_SESSION["ReadAccess"] == "Yes") && ($_SESSION["WriteAccess"] == "Yes")){
													 echo "<input onclick='setval1();' type='submit' id='update1' name='update1' value='Add' />&nbsp;&nbsp;&nbsp;&nbsp;";
											}
											if(($_SESSION["ReadAccess"] == "Yes") && ($_SESSION["WriteAccess"] == "Yes")){
										 echo "<input onclick='ClearFields1();'type='submit' name='pupdate1' value='Clear' />&nbsp;&nbsp;&nbsp;&nbsp;";
											}
										?>
										<br></br>				       
									<table cellpadding="10" id="grdpublistprereq" cellspacing="0" border="0" width="100%" class="tab_split">
										<tr>
											<th><strong>Sr. No.</strong></th>
											<th><strong>Pre-Requisite by Topic</strong></th>
											<th><strong>Pre Read</strong></th>
											<th><strong>Edit</strong></th>
											<th><strong>Delete</strong></th>
										</tr>
											<?php
										// Create connection
										include 'db/db_connect.php';
										$query = "SELECT prereqid, prebytopic, preread FROM tblsyllaprereq WHERE paperid = " . $_SESSION["PaperId"] ;
										
										//echo $query;
										$result = $mysqli->query( $query );
										$num_results = $result->num_rows;
										$i = 1;
										if( $num_results ){
											while( $row = $result->fetch_assoc() ){
												extract($row);
												echo "<TR class='odd gradeX'>";
												echo "<td>$i</td>";
												echo "<td style='display:none'>{$prereqid}</td>";
												echo "<td>{$prebytopic}</td>";
												echo "<td>{$preread}</td>";
												echo "<td class='pubId'><a class='btn btn-mini btn-primary' id='btnedit' onclick='javascript:fnEditdataprereq({$prereqid});'><i class='icon-pencil icon-white'></i>Edit</a> </td>";
												echo "<td><a onclick=\"return confirm('Are you sure?');\" class='btn btn-primary' href='StructureViewUpd.php?IUD=D&prereqid={$prereqid}'><i class='icon-remove icon-white'></i></a> </td>";
												echo "</TR>";
												$i = $i + 1;
											}
											 
										}
										else{
											echo "<TR class='odd gradeX'>";
											echo "<td></td>";
											echo "<td>No records found.</td>";
											echo "<td></td>";
											echo "<td></td>";
											echo "</TR>";
										}
										
											?> 
									</table>
									</div>  
									<div class="tab-pane" id="tabsleft-tab2">
										<h3><b>Pre-requisites by Course</b></h3>
										<div class="control-group">
											<div class="controls">
												<table>
													<tr>
														<td><input type="text" id="hdnprereqidbycourse"  name="hdnprereqidbycourse" style="display:none" value="" /></td>
													</tr>
												<tr>
													<tr>								
														<td ><label class="control-label">Pre-requisite by Course</label></td>
													</tr>
														<td>
															<select id="txtprereqcourse" name="txtprereqcourse" style="width:450px;">
																<?php
																include 'db/db_connect.php';
																echo "<option value=''>Select Subject</option>"; 	
																$sql = "SELECT DISTINCT SUBSTRING(SubjectName,1,LENGTH(SubjectName)- LOCATE(' ',REVERSE(SubjectName))-2) as SubjectName, 
																		CONCAT(EnggYear ,' - ',SUBSTRING(SubjectName,1,LENGTH(SubjectName)- LOCATE(' ',REVERSE(SubjectName))-2)) AS Subjects 
																		FROM vwhodsubjectsselected ys 
																		WHERE DeptID  in (select DeptID from tbldepartmentmaster where DeptName = '". $_SESSION["SESSUserDept"] . "')
																		ORDER BY Subjects;";
																	
																$result1 = $mysqli->query( $sql );
																
																while( $row = $result1->fetch_assoc() ) {
																		extract($row);
																		echo "<option value='";
																		echo addslashes($SubjectName);
																		echo "'>{$Subjects}</option>"; 
																
																}

																
																?>
																
															</select>
														</td>
												</tr>	
												</table>
											</div>	
										</div>						
										<?php
											if(($_SESSION["ReadAccess"] == "Yes") && ($_SESSION["WriteAccess"] == "Yes")){
													 echo "<input onclick='setval7();' type='submit' id='update7' name='update7' value='Add' />&nbsp;&nbsp;&nbsp;&nbsp;";
											}
											if(($_SESSION["ReadAccess"] == "Yes") && ($_SESSION["WriteAccess"] == "Yes")){
										 echo "<input onclick='ClearFields7();'type='submit' name='pupdate7' value='Clear' />&nbsp;&nbsp;&nbsp;&nbsp;";
											}
										?>
										<br></br>				       
									<table cellpadding="10" id="grdpublistprereqbycourse" cellspacing="0" border="0" width="100%" class="tab_split">
										<tr>
											<th><strong>Sr. No.</strong></th>
											<th><strong>Pre-Requisite by Course</strong></th>
											<th><strong>Edit</strong></th>
											<th><strong>Delete</strong></th>
										</tr>
											<?php
										// Create connection
										include 'db/db_connect.php';
										$query = "SELECT prereqidbycourse, prereqbycourse FROM tblsyllaprebycourse WHERE paperid = " . $_SESSION["PaperId"] ;
										
										//echo $query;
										$result = $mysqli->query( $query );
										$num_results = $result->num_rows;
										$i = 1;
										if( $num_results ){
											while( $row = $result->fetch_assoc() ){
												extract($row);
												echo "<TR class='odd gradeX'>";
												echo "<td>$i</td>";
												echo "<td style='display:none'>{$prereqidbycourse}</td>";
												echo "<td>{$prereqbycourse}</td>";
												echo "<td class='pubId'><a class='btn btn-mini btn-primary' id='btnedit' onclick='javascript:fnEditdataprereqbycourse({$prereqidbycourse});'><i class='icon-pencil icon-white'></i>Edit</a> </td>";
												echo "<td><a onclick=\"return confirm('Are you sure?');\" class='btn btn-primary' href='StructureViewUpd.php?IUD=D&prereqidbycourse={$prereqidbycourse}'><i class='icon-remove icon-white'></i></a> </td>";
												echo "</TR>";
												$i = $i + 1;
											}
										}
										else{
											echo "<TR class='odd gradeX'>";
											echo "<td></td>";
											echo "<td>No records found.</td>";
											echo "<td></td>";
											echo "<td></td>";
											echo "</TR>";
										}
										
											?> 
									</table>
									</div>  
									<div class="tab-pane" id="tabsleft-tab3">
										<h3><b>Course objectives List</b></h3>
											<div class="control-group">
												<div class="controls">
													<table>
														<tr>
														<td><input type="hidden" id="hdncourseobjid" name="hdncourseobjid"  style="display:none" value="" /></td>
														</tr>
														<tr>								
															<td ><label class="control-label">Description</label></td>
														</tr>	
														<tr>
															<td>
															<input type="text" id="txtDesc"  name="txtDesc"  style="width:300px" type="text" value="<?php echo $cobjdesc; ?>">
															</td>
														</tr>
													</table>
												</div>	
											</div>						
										<?php
											if(($_SESSION["ReadAccess"] == "Yes") && ($_SESSION["WriteAccess"] == "Yes")){
													 echo "<input onclick='setval2();' type='submit' id='update2' name='update2' value='Add' />&nbsp;&nbsp;&nbsp;&nbsp;";
											}
											if(($_SESSION["ReadAccess"] == "Yes") && ($_SESSION["WriteAccess"] == "Yes")){
										 echo "<input onclick='ClearFields2();'type='submit' name='pupdate2' value='Clear' />&nbsp;&nbsp;&nbsp;&nbsp;";
											}
										?>
										<br></br>				       
									<table cellpadding="10" id="grdpublistcobj" cellspacing="0" border="0" width="100%" class="tab_split">
										<tr>
											<th><strong>Sr. No.</strong></th>
											<th><strong>Description</strong></th>
											<th><strong>Edit</strong></th>
											<th><strong>Delete</strong></th>
										</tr>
											<?php
										// Create connection
										include 'db/db_connect.php';
										$query = "SELECT courseobjid ,coursedesc FROM tblsyllaobj WHERE paperid = " . $_SESSION["PaperId"] ;										
										//echo $query;
										$result = $mysqli->query( $query );
										$num_results = $result->num_rows;
										$i = 1;
										if( $num_results ){
											while( $row = $result->fetch_assoc() ){
												extract($row);
												echo "<TR class='odd gradeX'>";
												echo "<td>$i</td>";
												echo "<td style='display:none'>{$courseobjid}</td>";
												echo "<td>{$coursedesc}</td>";
												echo "<td class='pubId'><a class='btn btn-mini btn-primary' id='btnedit' onclick='javascript:fnEditdatCourseobj({$courseobjid});'><i class='icon-pencil icon-white'></i>Edit</a> </td>";
												echo "<td><a onclick=\"return confirm('Are you sure?');\" class='btn btn-primary' href='StructureViewUpd.php?IUD=D&courseobjid={$courseobjid}'><i class='icon-remove icon-white'></i></a> </td>";
												echo "</TR>";
												$i = $i + 1;
											}
										}
										else{
											echo "<TR class='odd gradeX'>";
											echo "<td></td>";
											echo "<td>No records found.</td>";
											echo "<td></td>";
											echo "<td></td>";
											echo "</TR>";
										}
																			
									?> 
									</table>
								</div>                       
							<div class="tab-pane" id="tabsleft-tab4">
							<?php
									if((isset($_SESSION["courseoutid"])) and ($_SESSION["courseoutid"] <> 'I')) {
										include 'db/db_connect.php';
										$query22 = "SELECT coursedesc as courseoutdesc FROM tblsyllaoutcome WHERE courseoutid = " . $_SESSION["courseoutid"];										
										//echo $query22;
										$result22 = $mysqli->query( $query22 );
										$num_results22 = $result22->num_rows;
										$i = 1;
										if( $num_results22 ){
											while( $row22 = $result22->fetch_assoc() ){
												extract($row22);
											}
										}
									}
							?>
								<label class="control-label"><h3><b>Course Outcomes List</b></h3></label>
									<div class="control-group">
												<div class="controls">
													<table>
														<tr>
														<td><input type="hidden" id="hdncourseoutid" name="hdncourseoutid" value="" /></td>
														</tr>
														<tr>	
															<td><label class="control-label">Description</label></td>
															<td>
															<input type="text" id="txtcourseoutdesc"  name="txtcourseoutdesc"  style="width:900px;margin-left:-650px" type="text" value="<?php echo $courseoutdesc; ?>">
															</td>
														</tr>
														<tr>	
															<td ><label class="control-label">Map POs</label></td>
														</tr>	
														<tr>
																<td>
																<table cellpadding="10" cellspacing="0" border="0" width="100%" class="tab_split" >
																<tr>
																	<th><strong>Sr. No.</strong></th>
																	<th><strong>Description</strong></th>
																	<th><strong>Select</strong></th>
																	<th><strong>Level</strong></th>
																	<th><strong>Justification</strong></th>
																</tr>
																<?php
																// Create connection
																include 'db/db_connect.php';
																if($_SESSION["courseoutid"] == 'I'){
																	$query = "SELECT courseoutid,COALESCE(mappo,podesc) AS mappo,COALESCE(mappochecked,0) AS mappochecked,COALESCE(polevel,-1) AS polevel,
																			COALESCE(pojust ,'') AS pojust ,COALESCE(mapcopoid,0) AS mapcopoid
																			FROM tblmapcopo mpo 
																			RIGHT OUTER JOIN tblpomaster pco ON pco.podesc = mpo.mappo 
																			and courseoutid is NULL
																			ORDER BY poid";
																}
																else{
																	$query = "SELECT courseoutid,COALESCE(mappo,podesc) AS mappo,COALESCE(mappochecked,0) AS mappochecked,COALESCE(polevel,-1) AS polevel,
																			COALESCE(pojust ,'') AS pojust ,COALESCE(mapcopoid,0) AS mapcopoid
																			FROM tblmapcopo mpo 
																			RIGHT OUTER JOIN tblpomaster pco ON pco.podesc = mpo.mappo 
																			and courseoutid = " . $_SESSION["courseoutid"] . "
																			ORDER BY poid";
																}
																// echo $query;
																$result = $mysqli->query( $query );
																$num_results = $result->num_rows;
																$i = 1;
																if( $num_results ){
																	$k = 0;							  
																	while( $row = $result->fetch_assoc() ){
																		extract($row);
																	  echo "<TR class='odd gradeX'>";
																					echo "<td style='height:10px'>$i</td>";
																					echo "<td style='height:10px'>{$mappo}<input type='hidden' name='txtmappo[]' value='{$mappo}' /> </td>";
																					echo "<td style='height:10px'><input type='checkbox' id='chkmappo[]' name='chkmappo[]' value='{$k}'";
																					if ($mappochecked == '1')
																						echo ' checked'; 
																					else
																						echo '';
																				echo "/></td>";
																					echo "<td style='height:10px'>";
																							echo "<select style='width:100px' name='ddllevelpo[]' class='span100'>";
																								echo "<option value='0' ";  if($polevel == '0') echo "selected"; 
																								echo ">0</option>";
																								echo "<option value='1' ";  if($polevel == '1') echo "selected"; 
																								echo ">1</option>";
																								echo "<option value='2' "; if($polevel == '2') echo "selected"; 
																								echo ">2</option>";
																								echo "<option value='3' "; if($polevel == '3') echo "selected"; 
																								echo ">3</option>";
																								echo "</select>";
																							echo "</td>";
																					echo "<td style='height:10px'><input type = 'text' name = 'txtpojustpo[]' value='{$pojust}' /></td>";

																	 echo "</TR>";
																	 $k = $k + 1;
																	  $i = $i + 1;
																	}
																}
																else{
																	echo "<TR class='odd gradeX'>";
																	echo "<td></td>";
																	echo "<td>No records found.</td>";
																	echo "<td></td>";
																	echo "<td></td>";
																	echo "</TR>";
																}
																echo "</table>";
																?> 
														</td>
														</tr>				
														
														
														
														<tr>	
															<td ><label class="control-label">Map PSOs</label></td>
														</tr>	
														<tr>
																<td>
																<table cellpadding="10" cellspacing="0" border="0" width="100%" class="tab_split" >
																<tr>
																	<th><strong>Sr. No.</strong></th>
																	<th><strong>Description</strong></th>
																	<th><strong>Select</strong></th>
																	<th><strong>Level</strong></th>
																	<th><strong>Justification</strong></th>
																</tr>
																<?php
																// Create connection
																include 'db/db_connect.php';
																if($_SESSION["courseoutid"] == 'I'){
																	$query = "SELECT courseoutid,COALESCE(mappso,psodesc) AS mappso,COALESCE(mappsochecked,0) AS mappsochecked,COALESCE(psolevel,-1) AS psolevel,
																			COALESCE(psojust ,'') AS psojust ,COALESCE(mapcopsoid,0) AS mapcopsoid
																			FROM tblmapcopso mpo 
																			RIGHT OUTER JOIN tblpso pso ON pso.psodesc = mpo.mappso 
																			
																			where DeptID  in (select DeptID from tbldepartmentmaster 
																				where DeptName = '". $_SESSION["SESSUserDept"] . "')
and courseoutid is NULL
																			ORDER BY psoid";
																}
																else{
																	$query = "SELECT courseoutid,COALESCE(mappso,psodesc) AS mappso,COALESCE(mappsochecked,0) AS mappsochecked,COALESCE(psolevel,-1) AS psolevel,
																			COALESCE(psojust ,'') AS psojust ,COALESCE(mapcopsoid,0) AS mapcopsoid
																			FROM tblmapcopso mpo 
																			RIGHT OUTER JOIN tblpso pso ON pso.psodesc = mpo.mappso 
																			

																			and DeptID  in (select DeptID from tbldepartmentmaster 
																				where DeptName = '". $_SESSION["SESSUserDept"] . "')
and courseoutid = " . $_SESSION["courseoutid"] . "
																			ORDER BY psoid";
																}
																// echo $query;
																$result = $mysqli->query( $query );
																$num_results = $result->num_rows;
																$i = 1;
																if( $num_results ){
																	$k = 0;							  
																	while( $row = $result->fetch_assoc() ){
																		extract($row);
																	  echo "<TR class='odd gradeX'>";
																					echo "<td style='height:10px'>$i</td>";
																					echo "<td style='height:10px'>{$mappso}<input type='hidden' name='txtmappso[]' value='{$mappso}' /> </td>";
																					echo "<td style='height:10px'><input type='checkbox' id='chkmappso[]' name='chkmappso[]' value='{$k}'";
																					if ($mappsochecked == '1')
																						echo ' checked'; 
																					else
																						echo '';
																				echo "/></td>";
																					echo "<td style='height:10px'>";
																							echo "<select style='width:100px' name='ddllevelpso[]' class='span100'>";
																								echo "<option value='0' ";  if($psolevel == '0') echo "selected"; 
																								echo ">0</option>";
																								echo "<option value='1' ";  if($psolevel == '1') echo "selected"; 
																								echo ">1</option>";
																								echo "<option value='2' "; if($psolevel == '2') echo "selected"; 
																								echo ">2</option>";
																								echo "<option value='3' "; if($psolevel == '3') echo "selected"; 
																								echo ">3</option>";
																								echo "</select>";
																							echo "</td>";
																					echo "<td style='height:10px'><input type = 'text' name = 'txtpojustpso[]' value='{$psojust}' /></td>";

																	 echo "</TR>";
																	 $k = $k + 1;
																	  $i = $i + 1;
																	}
																}
																else{
																	echo "<TR class='odd gradeX'>";
																	echo "<td></td>";
																	echo "<td>No records found.</td>";
																	echo "<td></td>";
																	echo "<td></td>";
																	echo "</TR>";
																}
																echo "</table>";
																?> 
														</td>
														</tr>				
														</table>
												</div>	
										</div>						
										<?php
											if(($_SESSION["ReadAccess"] == "Yes") && ($_SESSION["WriteAccess"] == "Yes")){
												if((isset($_SESSION["courseoutid"])) and ($_SESSION["courseoutid"] <> 'I')) {
													 echo "<input type='submit' id='update3' name='update3' value='Update' />&nbsp;&nbsp;&nbsp;&nbsp;";
												}
												else{
													 echo "<input type='submit' id='update3' name='update3' value='Add' />&nbsp;&nbsp;&nbsp;&nbsp;";
												}
											}
											if(($_SESSION["ReadAccess"] == "Yes") && ($_SESSION["WriteAccess"] == "Yes")){
												echo "<input onclick='ClearFields3();'type='submit' name='pupdate3' value='Clear' />&nbsp;&nbsp;&nbsp;&nbsp;";
											}
										?>
										<br></br>				       
									<table cellpadding="10" id="grdpublistcout" cellspacing="0" border="0" width="100%" class="tab_split">
										<tr>
											<th><strong>Sr. No.</strong></th>
											<th><strong>Description</strong></th>
											<th><strong>Edit</strong></th>
											<th><strong>Delete</strong></th>
										</tr>
											<?php
										// Create connection
										include 'db/db_connect.php';
										$query = "SELECT courseoutid, coursedesc FROM tblsyllaoutcome WHERE paperid = " . $_SESSION["PaperId"] ;										
										//echo $query;
										$result = $mysqli->query( $query );
										$num_results = $result->num_rows;
										$i = 1;
										if( $num_results ){
											while( $row = $result->fetch_assoc() ){
												extract($row);
											  echo "<TR class='odd gradeX'>";
											  echo "<td>$i</td>";
											  echo "<td style='display:none'>{$courseoutid}</td>";
											  echo "<td>{$coursedesc}</td>";
											  echo "<td class='pubId'><a class='btn btn-mini btn-primary' id='btnedit' onclick='javascript:fnEditdatacourseout({$courseoutid});'><i class='icon-pencil icon-white'></i>Edit</a> </td>";
											  echo "<td><a onclick=\"return confirm('Are you sure?');\" class='btn btn-primary' href='StructureViewUpd.php?IUD=D&courseoutid={$courseoutid}'><i class='icon-remove icon-white'></i></a> </td>";
											  echo "</TR>";
											  $i = $i + 1;
											}
										}
										else{
											echo "<TR class='odd gradeX'>";
											echo "<td></td>";
											echo "<td>No records found.</td>";
											echo "<td></td>";
											echo "<td></td>";
											echo "</TR>";
										}
											?> 
									</table>
								</div>                       			
															
						<div class="tab-pane" id="tabsleft-tab5">
								<label class="control-label"><h3><b>Course Contents</b></h3></label>
								<div class="control-group">
												<div class="controls">
													<table>
														<tr>
														<td><input type="hidden" name="hdnsyllabusID" id="hdnsyllabusID" value="" /></td>
														</tr>
														<tr>								
															<td><label class="control-label">Unit</label></td>
															<td><label class="control-label" style="margin-left:-400px">Teaching Hours</label></td>
														</tr>	
														<tr>
															<td>
															<select Id="ddlunit" name="ddlunit" style="width:150px"> 
															<option value="">Select</option>
															<option value="I" style="width:150px"value='<?php echo $syunit; ?>'
															<?php if($syunit == 'I') echo 'selected' ?>
															>I</option>     
															<option value="II" style="width:150px"value='<?php echo $syunit; ?>'
															<?php if($syunit == 'II') echo 'selected' ?>
															>II</option>
															<option value="III" style="width:150px"value='<?php echo $syunit; ?>'
															<?php if($syunit == 'III') echo 'selected' ?>
															>III</option>     
															<option value="IV" style="width:150px"value='<?php echo $syunit; ?>'
															<?php if($syunit == 'IV') echo 'selected' ?>
															>IV</option>
															<option value="V" style="width:150px"value='<?php echo $syunit; ?>'
															<?php if($syunit == 'V') echo 'selected' ?>
															>V</option>     
															<option value="VI" style="width:150px"value='<?php echo $syunit; ?>'
															<?php if($syunit == 'VI') echo 'selected' ?>
															>VI</option>
															</select>	
															</td>
															<td  colspan="2"><input style="margin-left:-400px" name="txthours" id="txthours"   style="width:150px" type="text" value="<?php echo $syhrs; ?>"></td>
														</tr>
														<tr>								
															<td><label class="control-label">Unit Title</label></td>
														</tr>	
														<tr>								
															<td  colspan="2"><input style="margin-left:0px;width:598px" name="txtunittitle" id="txtunittitle"  type="text" value="<?php echo $unittitle; ?>"></td>
														</tr>	
														<tr>								
															<td><label class="control-label">Details</label></td>
														</tr>	
														<tr>
															<td><textarea rows="8" name="txtsydesc" id="txtsydesc" style="width:600px"><?php $sydesc;  ?></textarea></td>
														</tr>
														
													</table>
												</div>	
											</div>						
										<?php
											if(($_SESSION["ReadAccess"] == "Yes") && ($_SESSION["WriteAccess"] == "Yes")){
													 echo "<input onclick='setval4();' type='submit' name='update4' id='update4' value='Add' />&nbsp;&nbsp;&nbsp;&nbsp;";
											}
											if(($_SESSION["ReadAccess"] == "Yes") && ($_SESSION["WriteAccess"] == "Yes")){
										 echo "<input onclick='ClearFields4();'type='submit' name='pupdate4' value='Clear' />&nbsp;&nbsp;&nbsp;&nbsp;";
								}
										?>
										<br></br>				       
									<table cellpadding="10" id="grdpublistsyllabi" cellspacing="0" border="0" width="100%" class="tab_split">
										<tr>
											<th><strong>Sr. No.</strong></th>
											<th><strong>Unit</strong></th>
											<th><strong>Teaching Hours</strong></th>
											<th><strong>Unit Title</strong></th>
											<th><strong>Edit</strong></th>
											<th><strong>Delete</strong></th>
										</tr>
											<?php
										// Create connection
										include 'db/db_connect.php';
										$query = "SELECT syllabusID ,sname ,hrs ,Syllabusdesc,unittitle FROM tblsyllacontents WHERE paperid = "  . $_SESSION["PaperId"] ;
										$result = $mysqli->query( $query );
										$num_results = $result->num_rows;
										$i = 1;
										if( $num_results ){
											while( $row = $result->fetch_assoc() ){
												extract($row);
											  echo "<TR class='odd gradeX'>";
											  echo "<td>$i</td>";
											  echo "<td style='display:none'>{$syllabusID}</td>";
											  echo "<td>{$sname}</td>";
											  echo "<td>{$hrs}</td>";
											  echo "<td style='display:none'>{$Syllabusdesc}</td>";
											  echo "<td>{$unittitle}</td>";
											  echo "<td class='pubId'><a class='btn btn-mini btn-primary' id='btnedit' onclick='javascript:fnEditdatasylabi({$syllabusID});'><i class='icon-pencil icon-white'></i>Edit</a> </td>";
											  echo "<td><a onclick=\"return confirm('Are you sure?');\" class='btn btn-primary' href='StructureViewUpd.php?IUD=D&syllabusID={$syllabusID}'><i class='icon-remove icon-white'></i></a> </td>";
											  echo "</TR>";
											  $i = $i + 1;
											}
										}
										else{
											echo "<TR class='odd gradeX'>";
											echo "<td></td>";
											echo "<td>No records found.</td>";
											echo "<td></td>";
											echo "<td></td>";
											echo "</TR>";
										}
											?> 
									</table>
						</div>                       			
							<div class="tab-pane" id="tabsleft-tab6">
								<label class="control-label"><h3><b>List of Experiments</b></h3></label>
										<div class="control-group">
											<div class="controls">
												<table>
													<tr>
													<td><input type="hidden" name="hdnexpid" id="hdnexpid" value="" /></td>
													<input type="hidden"  id="txtsyllapaperid" name="txtsyllapaperid" value="<?php echo $_GET["PaperID"]; ?>" />
													</tr>
													<tr>								
														<td colspan="2"><label class="control-label">Experiments</label></td>
														<td ><label style="margin-left:-20px" class="control-label">Is Compulsory ?</label></td>
													</tr>	
													<tr>
														<td>
															<input name="txtcexp" id="txtcexp"  style="width:150px" type="text" value="<?php echo $cexp; ?>">
														</td>
														<td><input style="margin-left:50px" type="checkbox" name="chkiscomp"  id="chkiscomp" class="checked" /></td>
														<td>
															<span style="width:200px;margin-left:200px">Any</span><input type="text" id="txtany"  name="txtany"  style="width:200px;" type="text" value='<?php echo $syllaAny; ?>'>
															Out Of<input type="text" id="txtout"  name="txtout"  style="width:200px" type="text" value="<?php  echo $syllaOut; ?>">
															<?php 
															if(($_SESSION["ReadAccess"] == "Yes") && ($_SESSION["WriteAccess"] == "Yes")){
																echo "<input style='margin-top:-10px' type='submit' id='btnUpdate' name='btnUpdate' value='Save' title='Update' class='btn btn-mini btn-success' />";
															}
															// if(($_SESSION["ReadAccess"] == "Yes") && ($_SESSION["WriteAccess"] == "Yes")){
																// echo "<input type='submit' onclick='javascript:fnEditdataexpanyout();' id='btnedit' name='btnedit' value='Edit' title='Update' class='btn btn-mini btn-success' />";
															// }
															?>
														</td>
													</tr>
												</table>
											</div>	
										</div>	
								<div class="control-group">
									</div>	
										<?php
											if(($_SESSION["ReadAccess"] == "Yes") && ($_SESSION["WriteAccess"] == "Yes")){
													 echo "<input onclick='setval5();' type='submit' name='update5' id='update5' value='Add' />&nbsp;&nbsp;&nbsp;&nbsp;";
											}
											if(($_SESSION["ReadAccess"] == "Yes") && ($_SESSION["WriteAccess"] == "Yes")){
										 echo "<input onclick='ClearFields5();'type='submit' name='pupdate5' value='Clear' />&nbsp;&nbsp;&nbsp;&nbsp;";
								}
										?>
										<br></br>				       
									<table cellpadding="10" id="grdpublistexp" cellspacing="0" border="0" width="100%" class="tab_split">
										<tr>
											<th><strong>Sr. No.</strong></th>
											<th><strong>Experiments</strong></th>
											<th><strong>Is compulsory ?</strong></th>
											<th><strong>Edit</strong></th>
											<th><strong>Delete</strong></th>
										</tr>
											<?php
										// Create connection
										include 'db/db_connect.php';
										$query = "SELECT expid ,complexp, Iscomp FROM tblsyllaexpts WHERE paperid = " .  $_SESSION["PaperId"] ;
										$result = $mysqli->query( $query );
										$num_results = $result->num_rows;
										$i = 1;
										if( $num_results ){
											while( $row = $result->fetch_assoc() ){
												extract($row);
											  echo "<TR class='odd gradeX'>";
											  echo "<td>$i</td>";
											  echo "<td style='display:none'>{$expid}</td>";
											  echo "<td>{$complexp}</td>";
											  echo "<td>";
											  if($Iscomp == '1') 
												  echo "Yes"; 
											  else 
												  echo 'No';
											  echo "</td>";
											  echo "<td class='pubId'><a class='btn btn-mini btn-primary' id='btnedit' onclick='javascript:fnEditdataexp({$expid});'><i class='icon-pencil icon-white'></i>Edit</a> </td>";
											  echo "<td><a onclick=\"return confirm('Are you sure?');\" class='btn btn-primary' href='StructureViewUpd.php?IUD=D&expid={$expid}'><i class='icon-remove icon-white'></i></a> </td>";
											  echo "</TR>";
											  $i = $i + 1;
											}
										}
										else{
											echo "<TR class='odd gradeX'>";
											echo "<td></td>";
											echo "<td>No records found.</td>";
											echo "<td></td>";
											echo "<td></td>";
											echo "</TR>";
										}
											?> 
									</table>
								</div>    
									
						<div class="tab-pane" id="tabsleft-tab7">
								<label class="control-label"><h3><b>Text Books</b></h3></label>
								<div class="control-group">
												<div class="controls">
													<table>
														<tr>
															<td><input type="hidden" name="hdnbookid" id="hdnbookid" value="" /></td>
														</tr>
														<tr>								
															<td colspan="2"><label class="control-label">Text Books</label></td>
														</tr>	
														<tr>
															<td><input name="txttextbooks" id="txttextbooks"  style="width:150px" type="text" value="<?php echo $books; ?>"></td>
														</tr>
													</table>
												</div>	
											</div>						
										<?php
											if(($_SESSION["ReadAccess"] == "Yes") && ($_SESSION["WriteAccess"] == "Yes")){
													 echo "<input onclick='setval6();' type='submit' name='update6' id='update6' value='Add' />&nbsp;&nbsp;&nbsp;&nbsp;";
											}
											if(($_SESSION["ReadAccess"] == "Yes") && ($_SESSION["WriteAccess"] == "Yes")){
										 echo "<input onclick='ClearFields6();'type='submit' name='pupdate6' value='Clear' />&nbsp;&nbsp;&nbsp;&nbsp;";
								}
										?>
										<br></br>				       
									<table cellpadding="10" id="grdpublistbook" cellspacing="0" border="0" width="100%" class="tab_split">
										<tr>
											<th><strong>Sr. No.</strong></th>
											<th><strong>Text Books</strong></th>
											<th><strong>Edit</strong></th>
											<th><strong>Delete</strong></th>
										</tr>
											<?php
										// Create connection
										include 'db/db_connect.php';
										$query = "SELECT bookid,textbooks FROM tblsyllabooks WHERE paperid = " . $_SESSION["PaperId"] ;
										$result = $mysqli->query( $query );
										$num_results = $result->num_rows;
										$i = 1;
										if( $num_results ){
											while( $row = $result->fetch_assoc() ){
												extract($row);
											  echo "<TR class='odd gradeX'>";
											  echo "<td>$i</td>";
											  echo "<td style='display:none'>{$bookid}</td>";
											  echo "<td>{$textbooks}</td>";
											  echo "<td class='pubId'><a class='btn btn-mini btn-primary' id='btnedit' onclick='javascript:fnEditdatabook({$bookid});'><i class='icon-pencil icon-white'></i>Edit</a> </td>";
											  echo "<td><a onclick=\"return confirm('Are you sure?');\" class='btn btn-primary' href='StructureViewUpd.php?IUD=D&bookid={$bookid}'><i class='icon-remove icon-white'></i></a> </td>";
											  echo "</TR>";
											  $i = $i + 1;
											}
											 
										}
										else{
											echo "<TR class='odd gradeX'>";
											echo "<td></td>";
											echo "<td>No records found.</td>";
											echo "<td></td>";
											echo "<td></td>";
											echo "</TR>";
										}
											?> 
									</table>
						</div> 
								<div class="tab-pane" id="tabsleft-tab8">
								<label class="control-label"><h3><b>Reference Books</b></h3></label>
								<div class="control-group">
												<div class="controls">
													<table>
														<tr>
															<td><input type="hidden" name="hdnrefbookid" id="hdnrefbookid" value="" /></td>
														</tr>
														<tr>								
															<td><label class="control-label">Reference Books</label></td>
														</tr>	
														<tr>
															<td colspan="4"><input name="txtrefbooks" id="txtrefbooks"  style="width:150px" type="text" value="<?php echo $refbooks; ?>"></td>
														</tr>
													</table>
												</div>	
											</div>						
										<?php
											if(($_SESSION["ReadAccess"] == "Yes") && ($_SESSION["WriteAccess"] == "Yes")){
													 echo "<input onclick='setval8();' type='submit' name='update8' id='update8' value='Add' />&nbsp;&nbsp;&nbsp;&nbsp;";
											}
											if(($_SESSION["ReadAccess"] == "Yes") && ($_SESSION["WriteAccess"] == "Yes")){
										 echo "<input onclick='ClearFields8();'type='submit' name='pupdate8' value='Clear' />&nbsp;&nbsp;&nbsp;&nbsp;";
								}
										?>
										<br></br>				       
									<table cellpadding="10" id="grdpublistrefbook" cellspacing="0" border="0" width="100%" class="tab_split">
										<tr>
											<th><strong>Sr. No.</strong></th>
											<th><strong>Reference Books</strong></th>
											<th><strong>Edit</strong></th>
											<th><strong>Delete</strong></th>
											
										</tr>
											<?php
										// Create connection
										include 'db/db_connect.php';
										$query = "SELECT refbookid,refbooks FROM tblsyllarefbooks WHERE paperid = " . $_SESSION["PaperId"] ;
										$result = $mysqli->query( $query );
										$num_results = $result->num_rows;
										$i = 1;
										if( $num_results ){
											while( $row = $result->fetch_assoc() ){
												extract($row);
											  echo "<TR class='odd gradeX'>";
											  echo "<td>$i</td>";
											  echo "<td style='display:none'>{$refbookid}</td>";
											  echo "<td>{$refbooks}</td>";
											  echo "<td class='pubId'><a class='btn btn-mini btn-primary' id='btnedit' onclick='javascript:fnEditdatarefbook({$refbookid});'><i class='icon-pencil icon-white'></i>Edit</a> </td>";
											  echo "<td><a onclick=\"return confirm('Are you sure?');\" class='btn btn-primary' href='StructureViewUpd.php?IUD=D&refbookid={$refbookid}'><i class='icon-remove icon-white'></i></a> </td>";
											  echo "</TR>";
											  $i = $i + 1;
											}
											 
										}
										else{
											echo "<TR class='odd gradeX'>";
											echo "<td></td>";
											echo "<td>No records found.</td>";
											echo "<td></td>";
											echo "<td></td>";
											echo "</TR>";
										}
										
											?> 
									</table>

						</div> 	
								<div class="tab-pane" id="tabsleft-tab9">
								<label class="control-label"><h3><b>Reference Material</b></h3></label>
								<div class="control-group">
												<div class="controls">
													<table>
														<tr>
															<td><input type="hidden" name="hdnrefmatbookid" id="hdnrefmatbookid" value="" /></td>
														</tr>
														<tr>
															<td colspan="2"><label class="control-label">Reference Material</label></td>
														</tr>
														<tr>
															<td><input name="txtrefmaterial" id="txtrefmaterial"  style="width:150px" type="text" value="<?php echo $refmaterial; ?>"></td>
														</tr>
													</table>
												</div>	
											</div>						
										<?php
											if(($_SESSION["ReadAccess"] == "Yes") && ($_SESSION["WriteAccess"] == "Yes")){
													 echo "<input onclick='setval9();' type='submit' name='update9' id='update9' value='Add' />&nbsp;&nbsp;&nbsp;&nbsp;";
											}
											if(($_SESSION["ReadAccess"] == "Yes") && ($_SESSION["WriteAccess"] == "Yes")){
										 echo "<input onclick='ClearFields9();'type='submit' name='pupdate9' value='Clear' />&nbsp;&nbsp;&nbsp;&nbsp;";
								}
										?>
										<br></br>				       
									<table cellpadding="10" id="grdpublistrefmatbook" cellspacing="0" border="0" width="100%" class="tab_split">
										<tr>
											<th><strong>Sr. No.</strong></th>
											<th><strong>Reference Books</strong></th>
											<th><strong>Edit</strong></th>
											<th><strong>Delete</strong></th>
											
										</tr>
											<?php
										// Create connection
										include 'db/db_connect.php';
										$query = "SELECT refmatbookid,refmaterial FROM tblsyllarefmatbooks WHERE paperid = " . $_SESSION["PaperId"] ;
										//echo $query;
										$result = $mysqli->query( $query );
										$num_results = $result->num_rows;
										$i = 1;
										if( $num_results ){
											while( $row = $result->fetch_assoc() ){
												extract($row);
											  echo "<TR class='odd gradeX'>";
											  echo "<td>$i</td>";
											  echo "<td style='display:none'>{$refmatbookid}</td>";
											  echo "<td>{$refmaterial}</td>";
											  echo "<td class='pubId'><a class='btn btn-mini btn-primary' id='btnedit' onclick='javascript:fnEditdatarefmatbook({$refmatbookid});'><i class='icon-pencil icon-white'></i>Edit</a> </td>";
											  echo "<td><a onclick=\"return confirm('Are you sure?');\" class='btn btn-primary' href='StructureViewUpd.php?IUD=D&refmatbookid={$refmatbookid}'><i class='icon-remove icon-white'></i></a> </td>";
											  echo "</TR>";
											  $i = $i + 1;
											}
											 
										}
										else{
											echo "<TR class='odd gradeX'>";
											echo "<td></td>";
											echo "<td>No records found.</td>";
											echo "<td></td>";
											echo "<td></td>";
											echo "</TR>";
										}
										
											?> 
									</table>
						</div> 							
						</div>
						</div>
						</div>
</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

</body>
</form>