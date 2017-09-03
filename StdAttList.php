<form name="myform" action="" method="post" onsubmit='showLoading();'>
<?php
//include database connection
include 'db/db_connect.php';
 // if the form was submitted/posted, update the record
 if($_POST)
	{ 	
		// calling SP to save attendance values
		if(isset($_POST['btnDelete'])){ 
					//echo $_GET['starttime'] . "<br/>";
					//echo $_GET['endtime'] . "<br/>";
					 //echo $_GET["attdate"] . "<br/>";
					 //echo $_GET["ysid"] . "<br/>";
					 //echo $_GET["subname"] . "<br/>";					  
					//die;
				$mysqli->query("SET @i_attdate  = '" . date("Y-m-d", strtotime($_GET["attdate"])) . "'");
				$mysqli->query("SET @i_ysid  = '" . $_GET["ysid"] . "'");
				$mysqli->query("SET @i_starttime  = '" . $_GET["starttime"] . "'");
				$mysqli->query("SET @i_endtime  = '" . $_GET["endtime"] . "'");
				$mysqli->query("SET @i_papertype  = '" . $_GET['subname'] . "'");
				$mysqli->query("SET @i_BatchId  = '" . strrev(substr(strrev($_GET['subname']),0,strpos(strrev($_GET['subname']),' '))) . "'");
				$result1 = $mysqli->query("CALL SP_DELETEATTENDANCE(@i_attdate,@i_ysid,@i_starttime,@i_endtime,@i_papertype,@i_BatchId);");
				header('Location: AttendanceMain.php');
		}
		if(isset($_POST['selectedids'])){ 
				if($_POST['selectedids'] != ''){
/* 					echo $_GET['starttime'] . "<br/>";
					echo $_GET['endtime'] . "<br/>";
					echo $_POST['txtlectplan'] . "<br/>";
					echo $_POST['txtremark'] . "<br/>";
					 echo $_POST['selectedids'] . "<br/>";
					 echo $_POST["selectedstatuses"] . "<br/>";
					 echo $_GET["attdate"] . "<br/>";
					 echo $_GET["ysid"] . "<br/>";
					 echo $_POST["ddlStartTime"] . "<br/>";
					 echo $_POST["ddlEndTime"] . "<br/>";
					 echo $_POST["dtPubStart"] . "<br/>";
					die; */
					$mysqli->query("SET @i_stdids  = '" . $_POST["selectedids"] . "'");
					$mysqli->query("SET @i_statuses  = '" . $_POST["selectedstatuses"] . "'");
					$mysqli->query("SET @i_attdate  = '" . date("Y-m-d", strtotime($_GET["attdate"])) . "'");
					$mysqli->query("SET @i_ysid  = '" . $_GET["ysid"] . "'");
					$mysqli->query("SET @i_starttime  = '" . $_GET["starttime"] . "'");
					$mysqli->query("SET @i_endtime  = '" . $_GET["endtime"] . "'");
					$mysqli->query("SET @i_lectplan  = '" . $_POST["txtLectPlan"] . "'");
					$mysqli->query("SET @i_remark  = '" . $_POST["txtRemark"] . "'");
					$mysqli->query("SET @i_papertype  = '" . $_GET["subname"] . "'");
					$mysqli->query("SET @i_starttimenew  = '" . $_POST["ddlStartTime"] . "'");
					$mysqli->query("SET @i_endtimenew  = '" . $_POST["ddlEndTime"] . "'");
					$mysqli->query("SET @i_attdatenew  = '" . date("Y-m-d", strtotime($_POST["dtPubStart"])) . "'");
					$mysqli->query("SET @i_BatchId  = '" . strrev(substr(strrev($_GET['subname']),0,strpos(strrev($_GET['subname']),' '))) . "'");
					$result1 = $mysqli->query("CALL SP_MARKATTENDANCE(@i_stdids,@i_statuses,@i_attdate,@i_ysid,@i_starttime,@i_endtime,@i_lectplan,@i_remark,@i_papertype,@i_starttimenew,@i_endtimenew,@i_attdatenew,@i_BatchId);");
					if(isset($_POST["ddlStartTime"]) && ($_POST["ddlStartTime"] != ''))
							header('Location: StdAttListMain.php?ysid=' . $_GET["ysid"] . '&attdate=' . $_POST["dtPubStart"] . 
							'&starttime=' . $_POST["ddlStartTime"] . '&endtime=' . $_POST["ddlEndTime"] . '&subname=' . $_GET["subname"] . "&success=1" );
					else
							header('Location: StdAttListMain.php?ysid=' . $_GET["ysid"] . '&attdate=' . $_POST["dtPubStart"] . 
							'&starttime=' . $_GET["starttime"] . '&endtime=' . $_GET["endtime"] . '&subname=' . $_GET["subname"] . "&success=1" );

							// if(isset($result1->num_rows))
					// {
						// $num_results = $result1->num_rows;
						// if( $num_results ){
									// echo $res;
									// die;
									// if($res == '0')
										// echo '<script>alert("Already exists. Can not update!");</script>';
						// }
					// }
				}
			}
	}
	if(isset($_GET['success'])){ 
		 echo '<script>alert("SAVED SUCCESSFULLY."); window.location.href = "AttendanceMain.php";</script>';
	}
?>
<head>
	<link rel="stylesheet" href="css/jquery-ui.css">
	<script src="js/jquery-1.10.2.js"></script>
	<script src="js/jquery-ui.js"></script>
	<script type="text/javascript" src="js/jquery.min.js"></script>
	<style type="text/css">
		  #loadingmsg {
		  color: black;
		  background: #fff; 
		  padding: 10px;
		  position: fixed;
		  top: 50%;
		  left: 50%;
		  z-index: 100;
		  margin-right: -25%;
		  margin-bottom: -25%;
		  }
		  #loadingover {
		  background: black;
		  z-index: 99;
		  width: 100%;
		  height: 100%;
		  position: fixed;
		  top: 0;
		  left: 0;
		  -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=80)";
		  filter: alpha(opacity=80);
		  -moz-opacity: 0.8;
		  -khtml-opacity: 0.8;
		  opacity: 0.8;
		}
	</style>
	<script type="text/javascript">     
		function setstarttime(){
		var st = document.getElementById('ddlEndTime').value;
		document.getElementById('ddlStartTime').value = String(parseInt(st.substring(0, st.indexOf(":"))) - 1) + st.substring(st.indexOf(":"));
	}	
	function setendtime(){
		var st = document.getElementById('ddlStartTime').value;
		document.getElementById('ddlEndTime').value = String(parseInt(st.substring(0, st.indexOf(":"))) + 1) + st.substring(st.indexOf(":"));
	}
	function EnableTime(){
		document.getElementById('ddlStartTime').disabled = false;
		document.getElementById('ddlEndTime').disabled = false;
		return true;
	}
	function DeleteAttendance()
	 {
		 if(confirm('Are you sure?'))
		 {
			 document.myform.submit();
		 }
		 else
			 return false;
	 }
	function MarkAttendance()
	 {
			var statuses = "";
			var stdids = "";
				$("input[type=checkbox]").each(function(chkbxidx){					
					if (statuses != "") 
						statuses += ",";
					/*
					if($(this).attr("title") != undefined)
						//statuses+= $(this).attr("title");
						statuses+= $(this).val());
						alert($(this).val());
						*/
						//alert($(this).val());
						//alert($(this).attr('checked'));
					//1 and 0 appended based on checkbox checked or not. 
					//alert(chkbxidx);
					if (chkbxidx != 0)
					{if($(this).attr('checked')) 
						statuses+='1';
					else 
					statuses+='0';}
					//alert(statuses);
					if (stdids != "") 
						stdids += ",";
					if($(this).attr("id") != undefined)
						stdids+= $(this).attr("id");
				});
				statuses = statuses+',';
				stdids = stdids +',';
				$('#selectedstatuses').val(statuses);
				$('#selectedids').val(stdids);
				//alert($('#selectedids').val());
				//alert($('#selectedstatuses').val());
				document.myform.submit();
		//}
		return true;
	 }
	
	function setall(chkmain)
	{
		if ($(chkmain).val() == 'Check All') {
			$('.checkbox-class').attr('checked', 'checked');
			$(chkmain).val('Uncheck All');
		} else {
			$('.checkbox-class').removeAttr('checked');
			$(chkmain).val('Check All');
		}
	}
		function showLoading() {
		document.getElementById('loadingmsg').style.display = 'block';
		document.getElementById('loadingover').style.display = 'block';
	}
	</script>
</head>
<div id='loadingmsg' style='display: none;'>Please wait...</div>
<div id='loadingover' style='display: none;'></div>
<br /><br /><br />
	<div>
		<div style="float:left">
			<h4 class="page-title">Attendance - <?php echo  $_GET['subname'];?></h4>
		</div>		
		<div style="float:right;margin-right:100px">
			<h3 class="page-title"><a href="AttendanceMain.php">Back</a></h3>
		</div>
	</div>
<?php

				// Create connection
				include 'db/db_connect.php';
				// AND COALESCE(pm.Practicalapp,0) = 1 
				//AND bm.BatchName = Right('" . $_GET['subname'] . "',2)
				$query = "SELECT DISTINCT starttime,endtime,lectplan,remark
						FROM tblstdadm sa
						INNER JOIN tblcuryear cy ON cy.eduyearfrom = sa.EduYearFrom AND cy.eduyearto = sa.EduYearTo 
						INNER JOIN tblpapermaster pm ON pm.DeptID = sa.Dept AND SUBSTRING(pm.EnggYear,1,2) = REPLACE(sa.Year,'.','') 
						AND RIGHT(pm.EnggYear,1) = cy.Sem
						INNER JOIN tblyearstructstd yss ON yss.StdAdmID = sa.STDAdmId
						INNER JOIN tblyearstruct ys ON ys.PaperID = pm.PaperID AND ys.eduyearfrom = cy.eduyearfrom 
						AND ys.eduyearto = cy.eduyearto 
						LEFT OUTER JOIN tblattmaster att ON att.ysid = ys.rowid AND attdate = '" . date("Y-m-d", strtotime($_GET["attdate"])) . "'
						AND starttime = '" . $_GET['starttime'] . "' AND endtime = '" . $_GET['endtime'] . "'  AND att.papertype = ys.papertype
						INNER JOIN tblbatchmaster bm ON bm.Btchid = yss.Btchid  AND bm.papertype = ys.papertype
						AND bm.BatchName = SUBSTRING('" . $_GET['subname'] . "',LOCATE('Batch ', ('" . $_GET['subname'] . "'))+6,
						LENGTH('" . $_GET['subname'] . "') - LOCATE('Batch ','" . $_GET['subname'] . "') - LOCATE(' ',REVERSE('" . $_GET['subname'] . "')) - 5)  
						WHERE ys.rowid = " . $_GET['ysid'] . "
						AND ys.papertype = TRIM(SUBSTRING('" . $_GET['subname'] . "',LENGTH('" . $_GET['subname'] . "') - LOCATE('-', REVERSE('" . $_GET['subname'] . "'))+2,3))";

					$query = "Select starttime,endtime,lectplan,remark
					FROM tblattmaster 
					WHERE YSID = " . $_GET['ysid'] . 
					" and attdate = '" . date("Y-m-d", strtotime($_GET["attdate"])) . "' 
					AND starttime = '" . $_GET['starttime'] . "' AND endtime = '" . $_GET['endtime'] . "'";


				//echo $query;
				$result = $mysqli->query( $query );				
				$num_results = $result->num_rows;				
				$i = 1;
				if( $num_results ){
					while( $row = $result->fetch_assoc() ){
						extract($row);
					}
				}
?>				
	<input type="hidden" name="selectedids" id="selectedids">
	<input type="hidden" name="selectedstatuses" id="selectedstatuses">
	<br/>
			<div class="span10" style="margin-left:5%">
				<h4><b>Date: <input type="text" maxlength="17" id='dtPubStart' readonly name="dtPubStart" class="textfield" style="width:120px;margin-top:10px" value="<?php  echo $_GET['attdate'] ?>"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<input type="button" name="btnUpdateTime" value="Update Time" title="Update Time" onclick='return EnableTime();'
				class="btn btn-mini btn-success"  style="margin-top:-2px"/>
				Start Time: <select id="ddlStartTime" name="ddlStartTime" style="width:80px;margin-top:10px" disabled onchange="setendtime()">
							<?php
							$start_hour = 7;
							$end_hour = 18;
							$minutes_array = array("15", "30", "45");
							for($i=$start_hour; $i<($end_hour + 1); $i++){
								$string = $i . ':00';
								echo '<option value="' . $string . '"';
								if(isset($_GET['starttime'])){
									 if($_GET['starttime'] == $string){
										 echo ' selected';
									 }
								 }											
								echo '>' . $string . '</option>';
								if($i != $end_hour){
									for($j=0; $j<sizeof($minutes_array); $j++){
										 $string = $i . ':' . $minutes_array[$j];
										 echo '<option value="' . $string . '"';
										if(isset($_GET['starttime'])){
											 if($_GET['starttime'] == $string){
												 echo ' selected';
											 }
										 }											
										echo '>' . $string . '</option>';
									}
								}
							}
							?>
						</select>
						End Time: <select id="ddlEndTime" name="ddlEndTime" style="width:80px;margin-top:10px" disabled onchange="setstarttime();">
							<?php
							$start_hour = 8;
							$end_hour = 19;
							$minutes_array = array("15", "30", "45");
							for($i=$start_hour; $i<($end_hour + 1); $i++){
								$string = $i . ':00';
								echo '<option value="' . $string . '"';
								if(isset($_GET['endtime'])){
									 if($_GET['endtime'] == $string){
										 echo ' selected';
									 }
								 }											
								echo '>' . $string . '</option>';
								if($i != $end_hour){
									for($j=0; $j<sizeof($minutes_array); $j++){
										 $string = $i . ':' . $minutes_array[$j];
										 echo '<option value="' . $string . '"';
										if(isset($_GET['endtime'])){
											 if($_GET['endtime'] == $string){
												 echo ' selected';
											 }
										 }											
										echo '>' . $string . '</option>';
									}
								}
							}
							?>
						</select>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<input type="submit" name="btnUpdate" value="Save Attendance" title="Update" onclick='return MarkAttendance();'
				class="btn btn-mini btn-success"  style="margin-top:-2px"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<input type="submit" name="btnDelete" value="Delete Attendance" title="Delete Attendance" onclick='return DeleteAttendance();'
				class="btn btn-mini btn-success"  style="margin-top:-2px"/></b></h4>
			</div>
			<br/><br/><br/><br/><br/>
	Lecture plan: <textarea id="txtLectPlan" name="txtLectPlan" style="width:400px" ><?php echo $lectplan; ?></textarea> <br/>Remark<textarea name="txtRemark" id="txtRemark" style="width:200px" ><?php echo $remark; ?></textarea>
	<div class="row-fluid">		
		<table cellpadding="10" cellspacing="0" border="0" class="tab_split" style="width:52%">
				<tr>
					<th width="10%">Sr. No.</th>
					<th width="20%">CNUM
					</th>
					<th width="37%">Name
					</th>
					<th width="10%">Roll No
					</th>
					<th>
						<input onclick='setall(this);' class='checkbox-class' type='checkbox' value='Check All' />
						Tick for Present
					</th>
				</tr>
				</table>
		<div class="v_detail" style="width:52%">
			<table cellpadding="10" cellspacing="0" border="0" class="tab_split">
				<?php
				// Create connection
				include 'db/db_connect.php';
				// AND COALESCE(pm.Practicalapp,0) = 1 
				//AND bm.BatchName = Right('" . $_GET['subname'] . "',2)
				$query = "select s.stdid,rollno,cnum,concat(firstname,' ',surname) as stdname,0 as attendance 
						from tblstudent s 
						inner join tblstdadm sa on sa.stdid = s.stdid 
						inner join tblcuryear cy on cy.eduyearfrom = sa.eduyearfrom and cy.eduyearto = sa.eduyearto 
						inner join tblpapermaster pm on pm.deptid = sa.dept and substring(pm.enggyear,1,2) = replace(sa.year,'.','') 
						and right(pm.enggyear,1) = cy.sem
						inner join tblyearstructstd yss on yss.stdadmid = sa.stdadmid
						inner join tblyearstruct ys on ys.paperid = pm.paperid and ys.eduyearfrom = cy.eduyearfrom 
						and ys.eduyearto = cy.eduyearto 
						inner join tblbatchmaster bm on bm.btchid = yss.btchid  
						and bm.papertype = ys.papertype
						and bm.batchname = SUBSTRING('" . $_GET['subname'] . "',LOCATE('Batch ', ('" . $_GET['subname'] . "'))+6,
						LENGTH('" . $_GET['subname'] . "') - LOCATE('Batch ','" . $_GET['subname'] . "') - LOCATE(' ',REVERSE('" . $_GET['subname'] . "')) - 5)  
						where ys.rowid = " . $_GET['ysid'] . "
						 and ys.papertype = trim(substring('" . $_GET['subname'] . "',length('" . $_GET['subname'] . "') - locate('-', reverse('" . $_GET['subname'] . "'))+2,3))
						 and s.stdid NOT IN (SELECT s.stdid FROM tblattendance A
							INNER JOIN tblattmaster AM ON A.attmasterid = AM.attmasterid and AM.attdate = '" . date("Y-m-d", strtotime($_GET["attdate"])) . "' 
							and AM.starttime = '" . $_GET["starttime"] . "'  and AM.endtime = '" . $_GET["endtime"] . "'
							INNER JOIN tblstudent s ON s.stdid = A.stdid  
							INNER JOIN tblstdadm sa ON s.stdid = sa.stdid 
							INNER JOIN tblcuryear cy ON cy.eduyearfrom = sa.EduYearFrom AND cy.eduyearto = sa.EduYearTo
							WHERE A.ysid = " . $_GET['ysid'] . ")
						UNION All
						SELECT s.stdid,RollNo,CNUM,CONCAT(FirstName,' ',Surname) AS stdname, 
							CASE WHEN COALESCE(Attendance,0) = 0 THEN '' ELSE 'checked' END AS attendance
							FROM tblattendance A
							INNER JOIN tblattmaster AM ON A.attmasterid = AM.attmasterid and AM.attdate = '" . date("Y-m-d", strtotime($_GET["attdate"])) . "' 
							and AM.starttime = '" . $_GET["starttime"] . "'  and AM.endtime = '" . $_GET["endtime"] . "'
							INNER JOIN tblstudent s ON s.stdid = A.stdid  
							INNER JOIN tblstdadm sa ON s.stdid = sa.stdid 
							INNER JOIN tblcuryear cy ON cy.eduyearfrom = sa.EduYearFrom AND cy.eduyearto = sa.EduYearTo
							WHERE A.ysid = " . $_GET['ysid'] . "
							order by rollno";
			if(stripos($_GET['subname'], ' TH ') > 0 ){
				$query = " SELECT s.stdid,RollNo,CNUM,CONCAT(Surname,' ',FirstName) AS stdname, 
								CASE WHEN COALESCE(Attendance,0) = 0 THEN '' ELSE 'checked' END AS attendance
						FROM tblyearstructstd Y
						INNER JOIN tblstdadm SA ON Y.StdAdmID = SA.StdAdmID
						INNER JOIN tblstudent s ON SA.StdId = s.StdId
						INNER JOIN tblcuryear cy ON cy.EduYearFrom = SA.EduYearFrom
						LEFT OUTER JOIN tblattmaster am on am.ysid = Y.ysid and am.attdate = '" . date("Y-m-d", strtotime($_GET["attdate"])) . "' 
								and am.starttime = '" . $_GET["starttime"] . "'  and am.endtime = '" . $_GET["endtime"] . "'
								and am.BatchId = Y.BtchId
						LEFT outer JOIN tblattendance a on a.attmasterid = am.attmasterid AND s.stdid = a.stdid
						inner join tblbatchmaster bm on bm.btchid = Y.btchid
						and Y.BtchId = SUBSTRING('" . $_GET['subname'] . "',LENGTH('" . $_GET['subname'] . "') - LOCATE(' ', REVERSE('" . $_GET['subname'] . "')) + 2)
						WHERE coalesce(stdstatus,'D') in('R','P') and Y.YSID = " . $_GET['ysid'] . " 
						ORDER BY RollNo,stdname ";
			}
			else{
				$query = " SELECT s.stdid,RollNo,CNUM,CONCAT(Surname,' ',FirstName) AS stdname, 
								CASE WHEN COALESCE(Attendance,0) = 0 THEN '' ELSE 'checked' END AS attendance
						FROM tblyearstructstd Y
						INNER JOIN tblstdadm SA ON Y.StdAdmID = SA.StdAdmID
						INNER JOIN tblstudent s ON SA.StdId = s.StdId
						INNER JOIN tblcuryear cy ON cy.EduYearFrom = SA.EduYearFrom
						LEFT OUTER JOIN tblattmaster am on am.ysid = Y.ysid and am.attdate = '" . date("Y-m-d", strtotime($_GET["attdate"])) . "' 
								and am.starttime = '" . $_GET["starttime"] . "'  and am.endtime = '" . $_GET["endtime"] . "'
								and am.BatchId = Y.BtchId
						LEFT outer JOIN tblattendance a on a.attmasterid = am.attmasterid AND s.stdid = a.stdid
						inner join tblbatchmaster bm on bm.btchid = Y.btchid
						and Y.BtchId = SUBSTRING('" . $_GET['subname'] . "',LENGTH('" . $_GET['subname'] . "') - LOCATE(' ', REVERSE('" . $_GET['subname'] . "')) + 2)
						WHERE coalesce(stdstatus,'D') in('R','P') and Y.YSID = " . $_GET['ysid'] . " 
						ORDER BY RollNo,stdname ";
			}
//coalesce(stdstatus,'D') in('R','P') and 
//coalesce(stdstatus,'D') in('R','P') and 
			//echo $query;
			/*
			$query = "SELECT s.stdid,RollNo,CNUM,CONCAT(Surname,' ',FirstName) AS stdname, CASE WHEN COALESCE(Attendance,0) = 0 THEN '' ELSE 'checked' END 
			AS attendance 
			FROM tblattendance a
			INNER JOIN tblattmaster am ON a.attmasterid = am.attmasterid  
			INNER JOIN tblstudent s ON s.StdId = a.stdid
			INNER JOIN tblstdadm SA ON SA.StdId = s.StdId 
			WHERE COALESCE(stdstatus,'D') IN('R','P') AND am.BatchId = 
			SUBSTRING('" . $_GET['subname'] . "',LENGTH('" . $_GET['subname'] . "') - LOCATE(' ', REVERSE('" . $_GET['subname'] . "')) + 2)
			AND am.attdate = '" . date("Y-m-d", strtotime($_GET["attdate"])) . "' AND am.starttime = '" . $_GET["starttime"] . "'
				AND am.endtime = '" . $_GET["endtime"] . "' 
			AND am.YSID = " . $_GET['ysid'] . "  
			ORDER BY RollNo,stdname
			";
			*/


//										and bm.batchname = SUBSTRING('" . $_GET['subname'] . "',LOCATE('Batch ', ('" . $_GET['subname'] . "'))+6,
//						LENGTH('" . $_GET['subname'] . "') - LOCATE('Batch ','" . $_GET['subname'] . "') - LOCATE(' ',REVERSE('" . $_GET['subname'] . "')) - 5)
//						and am.Batchid = bm.btchid 

// AND am.BatchId = y.BtchId
				//echo strpos($query, "'A'");
				if (strpos($query, "'A'") > 0 ) {
					$query = str_replace("'A'","''A''",$query);
					$query = str_replace("+2","-1",$query);
				}
				if (strpos($query, "'B'") > 0) {
					$query = str_replace("'B'","''B''",$query);
					$query = str_replace("+2","-1",$query);
				}
				if (strpos($query, "'C'") > 0 ) {
					$query = str_replace("'C'","''C''",$query);
					$query = str_replace("+2","-1",$query);
				}

				// $query = "SELECT s.stdid,RollNo,CNUM,CONCAT(FirstName,' ',Surname) AS stdname, 
							// CASE WHEN COALESCE(Attendance,0) = 0 THEN '' ELSE 'checked' END AS attendance
							// FROM tblattendance A
							// INNER JOIN tblattmaster AM ON A.attmasterid = AM.attmasterid
							// INNER JOIN tblstudent s ON s.stdid = A.stdid  
							// INNER JOIN tblstdadm sa ON s.stdid = sa.stdid 
							// INNER JOIN tblcuryear cy ON cy.eduyearfrom = sa.EduYearFrom AND cy.eduyearto = sa.EduYearTo
							// WHERE A.ysid = " . $_GET['ysid'];



						 //echo $query;
				// $query = "SELECT s.StdId as userID,Concat(FirstName,' ',Surname) as userName, s.CNUM as CNUM 
							// FROM tblstudent s
							// inner join tblstdadm sa on s.stdid = sa.stdid and sa.Year <> 'A.L.'
							// AND `div` = " . $_GET['selecteddept'] . " AND sa.Year = 'S.E.' 
							// AND sa.Dept IN (SELECT DeptID FROM tbldepartmentmaster WHERE DeptName = 'Mech') 
							// inner join tblcuryear cy on cy.EduYearFrom = sa.EduYearFrom and 
							// cy.EduYearTo = sa.EduYearTo";
				//echo $query;
				// if(isset($_POST['selectedyear'])){
					// if(($_POST['selectedyear'] <> '' ) && ($_POST['selecteddept'] == '')){
						// $query = $query . " where sa.Year = '" . $_POST['selectedyear'] . "' ";
					// }
					// if(($_POST['selectedyear'] == '' ) && ($_POST['selecteddept'] <> '')){
						// $query = $query . " where s.dept = '" . $_POST['selecteddept'] . "' ";
					// }
					// if(($_POST['selectedyear'] <> '' ) && ($_POST['selecteddept'] <> '')){
						// $query = $query . " where s.dept = '" . $_POST['selecteddept'] . "' and sa.Year = '" . $_POST['selectedyear'] . "' ";
					// }
				// }
				// $query =	$query . " order by " . $field . " " . $sort . ";";							
				//echo $query;
				$result = $mysqli->query( $query );				
				$num_results = $result->num_rows;				
				$i = 1;
				if( $num_results ){
					while( $row = $result->fetch_assoc() ){
						extract($row);
					  echo "<TR class='odd gradeX'>";
					  echo "<td width='10%'>$i</td>";
					  echo "<td width='20%'>{$CNUM}</td>";
					  echo "<td width='54%'>{$stdname}</td>";
					  echo "<td width='10%'>{$RollNo}</td>";
					  echo "<td><input id='{$stdid}' class='checkbox-class' type='checkbox' value='0' $attendance/></td>";
					  echo "</TR>";
					  $i = $i + 1;
					}				
				}
				else{
					//echo "No records found.";
					echo "<TR class='odd gradeX'>";
					echo "<td>No records found.</td>";				
					echo "</TR>";
				}
				?>				
			</table>
		</div>
	</div>
</form>
