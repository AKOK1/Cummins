<?php
//include database connection
	include 'db/db_connect.php';
	if(!isset($_SESSION)){
			session_start();
		}
	if(!isset($_SESSION["quizpaperid"])){
		$_SESSION["quizpaperid"] = $_GET['paperid'] ;		
	 }
		//echo $_SESSION["quizpaperid"];
	 if(!isset($_SESSION["quizid"])){
		$_SESSION["quizid"] = $_GET['quizid'] ;
		
	 }
	  //if(!isset($_SESSION["quizqueid"])){
		//$_SESSION["quizqueid"] = $_GET['quizqueid'];	
	  //}

		 // if the form was submitted/posted, update the record
	if($_POST) {

		if(isset($_POST['btnUpdate'])){
			$dt1 = $_POST['dtStartTime'];
			$dt2 = $_POST['dtEndTime'];
			if ($_GET['quizid'] == "I") {
				$sql = "Insert into tblquizdetails ( quizname, quizstarttime, quizendtime, totaltime, outof,profid,examid,paperid) Values ( ?, ?, ?, ?, ?, ?, ?, ?)";
				// echo($_GET['paperid']);
				// die;
				$stmt = $mysqli->prepare($sql);
				$stmt->bind_param('ssssiiii', $_POST['txtquizname'],  $dt1, $dt2,$_POST['txttotaltime'],$_POST['txtoutof'],$_SESSION["SESSUserID"],$_SESSION["quizselectedexam"],$_SESSION["quizpaperid"]);
			}
			else {
				$sql = "UPDATE  tblquizdetails Set quizname = ? ,quizstarttime = ? ,quizendtime = ? ,totaltime = ? ,outof = ? Where quizid = ?";
				//echo $sql;
				$stmt = $mysqli->prepare($sql);
				$stmt->bind_param('ssssii', $_POST['txtquizname'], $dt1, $dt2,$_POST['txttotaltime'],$_POST['txtoutof'], $_POST['txtquizid'] );
			}
			
			if($stmt->execute()){
				// close the prepared statement
				if ($_GET["quizid"] == "I") {
					$id = $stmt->insert_id;				
					$_SESSION["quizid"] = $id;
				}
				header("Location: selectsubexamMaintMain.php?quizid=" . $_SESSION["quizid"] . "&paperid=" . $_SESSION["quizpaperid"]);  
			}else{
				echo $mysqli->error;
				die("Unable to update.");
			}
		}
		

		if(isset($_POST['addIsnst'])){
			if ($_POST['txtquizid'] == "I") {
				echo '<script>alert("Please save Quiz before adding instructions.");</script>';
			}
			else {
				include 'db/db_connect.php';
				$maxqnoorder = 0;
				$sql = "SELECT (COALESCE(MAX(qnoorder), 0) + 1) AS qnoorder  FROM tblquizques WHERE quizid = " .  $_GET['quizid'] ;
				//echo $sql;
				
				$resultmaxQueno = $mysqli->query( $sql );
				if( $num_results ){
					while( $row = $resultmaxQueno->fetch_assoc() ){
						extract($row);
							$maxqnoorder = $qnoorder;
						}
				}
				else {
					echo $mysqli->error;
					die("Issue.");
				}

				//disconnect from database
				$resultmaxQueno->free();
				$mysqli->close();

				include 'db/db_connect.php';
				$stmt = $mysqli->prepare("INSERT INTO tblquizques (quizid, inst ,instno,qtype, qnoorder) VALUES (" . $_GET['quizid'] . ", ?,?, 'I', ?)");
				$stmt->bind_param('ssi',  $_POST['txtinstruct'],$_POST['txtinstructno'], $maxqnoorder);
				if($stmt->execute()) {
					echo '<script>alert("UPDATED SUCCESSFULLY");</script>';
				}
				else {
					echo $mysqli->error;
					die("Unable to update.");
				}
				//-------------------------------------------------------------------------------		
			}
		}
		
		if(isset($_POST['btnAddBreak'])){
			if ($_POST['txtquizid'] == "I") {
				echo '<script>alert("Please save Quiz before adding page break.");</script>';
			}
			else {
				include 'db/db_connect.php';
				$maxqnoorder = 0;
				$sql = "SELECT (COALESCE(MAX(qnoorder), 0) + 1) AS qnoorder  FROM tblquizques WHERE quizid = " .  $_GET['quizid'] ;
				//echo $sql;
				$resultmaxQueno = $mysqli->query( $sql );
				if( $num_results ){
					while( $row = $resultmaxQueno->fetch_assoc() ){
						extract($row);
							$maxqnoorder = $qnoorder;
						}
				}
				else {
					echo $mysqli->error;
					die("Issue.");
				}

				//disconnect from database
				$resultmaxQueno->free();
				$mysqli->close();
				include 'db/db_connect.php';
				$stmt = $mysqli->prepare("INSERT INTO tblquizques (quizid, inst ,instno,qtype, qnoorder) 
						VALUES (" . $_GET['quizid'] . ", 'PAGEBREAK','0', 'P', ?)");
				$stmt->bind_param('i', $maxqnoorder);
				if($stmt->execute()) {
					echo '<script>alert("UPDATED SUCCESSFULLY");</script>';
				}
				else {
					echo $mysqli->error;
					die("Unable to update.");
				}
				//-------------------------------------------------------------------------------		
			}
		}
		
	}

	if ($_GET['quizid'] == "I") {
		$sql = "SELECT 'I' as quizid, '' as quizname, '' as quizstarttime, ''  as quizendtime,'' as totaltime,'' as totaltime,'' as outof " ;
	}
	Else
	{  
		$sql = " SELECT quizid, quizname, quizstarttime, quizendtime,totaltime,outof from tblquizdetails Where quizid = " . $_SESSION["quizid"];
	} 
//echo $sql;
	// execute the sql query
	$result = $mysqli->query( $sql );
	$row = $result->fetch_assoc();
	extract($row);
	 
	//disconnect from database
	$result->free();
	$mysqli->close();

?>

<?php
//include database connection
include 'db/db_connect.php';
If (isset($_POST['btnreview']))
	{
		// $_SESSION["SESSSelectedExam"] = $_POST['ddlExam'];
		//header('Location: Printquizdetails.php?quizid = ' . $_GET['quizid'] .''); 
		header('Location: Printquepaper.php?quizid = ' . $_GET['quizid'] .''); 
	}

// if the form was submitted/posted, update the record
	If (isset($_POST['btnSelectques']))
	{
		// $_SESSION["SESSSelectedExam"] = $_POST['ddlExam'];
		header('Location: searchquesMain.php?quizid = ' . $_GET['quizid'] . '&paperid=' . $_GET['paperid'] .''); 
	}
?>
<script>
	$(function() {
		$( "#datepicker1" ).appendDtpicker();
		$( "#datepicker2" ).appendDtpicker();
		});
</script>
<?php
//include database connection
include 'db/db_connect.php';


// if the form was submitted/posted, update the record
	If (isset($_POST['btnSelect']))
	{
		header('Location: quizquesMain.php?'); 
	}
	If (isset($_POST['btnaddstuds']))
	{
		header('Location: selectstudsMain.php?'); 
	}
	
?>
<script>
$("#fnaddpgbrk").click(function () {
	alert("hi");
$("#grdlistinstruct").each(function () {
 var tds = '<tr>';
 jQuery.each($('tr:last td', this), function () {
	 tds += '<td>' + $(this).html() + '</td>';
 });
 tds += '</tr>';
 if ($('tbody', this).length > 0) {
	 $('tbody', this).append(tds);
 } else {
	 $(this).append(tds);
 }
});
});

	//$(function(){
		//$('*[name=date]').appendDtpicker();
		//});
		$(function() {
		// $( "#datepicker1" ).datepicker({ dateFormat: 'dd-M-yy' });
		//$( "#datepicker2" ).datepicker({ dateFormat: 'dd-M-yy' });
		//$( "#datepicker1" ).appendDtpicker();
		});
	$(function() {
		$('.DTEXDATE').each(function(i) {
		this.id = 'datepicker' + i;
		}).datepicker({ dateFormat: 'dd-M-yy' });
		$('.DTEXDATE').attr("required","required");
		//});
		document.getElementById('lblqueid').value= "0";
		//$( ".DTEXDATE" ).datepicker();
		//$(".DTEXDATE").each(function(){
		//	$(this).datepicker();
		//});
	});
	
	function fnEditDatainstruct(queid) {
		var gvET = document.getElementById("grdlistinstruct");
		var rCount = gvET.rows.length;
		var rowIdx;
		for (rowIdx=1; rowIdx<=rCount-1; rowIdx++) {						
			var rowElement = gvET.rows[rowIdx];
			if (parseInt(rowElement.cells[1].innerText) ==parseInt(queid)){
	
				document.getElementById("lblqueid").value =rowElement.cells[1].innerText;
				document.getElementById("txtinstruct").value =rowElement.cells[2].innerText;
				document.getElementById("txtinstructno").value =rowElement.cells[3].innerText;
				document.getElementById("update1").value = 'Update';
				break;
			}					
		}
	}
	
	function ClearFields1()  {
		document.getElementById("lblqueid").value = "0";
		document.getElementById("txtinstruct").value = "";
		document.getElementById("txtinstructno").value = "";
		document.getElementById("update1").value = 'Add';
	}
	function getDOM(xmlstring) {
		parser=new DOMParser();
		return parser.parseFromString(xmlstring, "text/xml");
	}

	function remove_tags(node) {
		var result = "";
		var nodes = node.childNodes;
		var tagName = node.tagName;
		if (!nodes.length) {
			if (node.nodeValue == "π") result = "pi";
			else if (node.nodeValue == " ") result = "";
			else result = node.nodeValue;
		} else if (tagName == "mfrac") {
			result = "("+remove_tags(nodes[0])+")/("+remove_tags(nodes[1])+")";
		} else if (tagName == "msup") {
			result = "Math.pow(("+remove_tags(nodes[0])+"),("+remove_tags(nodes[1])+"))";
		} else for (var i = 0; i < nodes.length; ++i) {
			result += remove_tags(nodes[i]);
		}

		if (tagName == "mfenced") result = "("+result+")";
		if (tagName == "msqrt") result = "Math.sqrt("+result+")";

		return result;
	}

	function stringifyMathML(mml) {
	   xmlDoc = getDOM(mml);
	   return remove_tags(xmlDoc.documentElement);
	}
	function extraxttext(){
		var table = document.getElementById("grdlistinstruct");
		for (var i = 0, row; row = table.rows[i]; i++) {
			s = row.cells[2].innerHTML;
			if(s.startsWith("<math")){
				//s = s.replace(/null/g,"\n");
				//s = s.replace(/nbsp/g," ");
				//alert(s);
				//s = s.replace(/[\[\]]/g, "\\$&");
				//s = stringifyMathML(s);
			}
			//row.cells[2].innerText = s;
			//s = stringifyMathML(row.cells[2].innerHTML);
			//s = s.replace(/null/g,"\n");
			//row.cells[2].innerHTML = s;
			//alert(row.cells[2].innerText);
		   //iterate through rows
		   //rows would be accessed using the "row" variable assigned in the for loop
		   //for (var j = 0, col; col = row.cells[j]; j++) {
			 //iterate through columns
			 //columns would be accessed using the "col" variable assigned in the for loop
		   //}  
		}
	}
</script>
<br /><br />

<form action="selectsubexamMaintMain.php?quizid=<?php echo $_SESSION["quizid"]; ?>&paperid=<?php echo $_SESSION["quizpaperid"]; ?>" method="post">
	<body onload="extraxttext();">
		<div>
			<div style="float:left">
				<h3 class="page-title">Quiz Details </h3>
			</div>
			<div style="float:left;margin-top:15px;margin-left:20px">
				<h4>Exam-<?php echo $_SESSION["quizselectedexamname"]; ?></h4>
			</div>
			<div style="float:left;margin-top:15px;margin-left:20px">
				<h4>Subject-<?php echo $_SESSION["quizselectedsubname"]; ?></h4>
			</div>
			<div style="float:right">
				<h3 class="page-title" style="margin-right:40px;"><a href="selectsubexamMain.php">Back</a></h4>
			</div>
		</div><br/><br/>
		<div class="control-group">
			<br/><br/>
				<div class="v_detail" style="margin-left:5%;height:200%">
					<table cellpadding="10" cellspacing="0" border="0" width="90%" class="tab_split">
						<tr>
							<td class="form_sec" style="width:20%">Enter Basic Quiz Information</td>
							<td>
								<div class="span10">
									<input type="hidden" id="txtquizid" name="txtquizid" value="<?php echo $_GET['quizid'] ?>" />
									<?php 
									if(($_SESSION["ReadAccess"] == "Yes") && ($_SESSION["WriteAccess"] == "Yes")){
										echo "<input type='submit' name='btnUpdate' value='Save' title='Update' class='btn btn-mini btn-success' />";
									}
									?>
									<a target="_blank" href="Printquepaper.php" class='btn btn-mini btn-success'>Preview</a>
								</div>
							</td>								
						</tr>
						<tr>
							<td class="form_sec">Quiz Name</td>
							<td>
								<input type="text" maxlength="100" name="txtquizname" id="txtquizname"  class="textfield" style="width:250px;" required value="<?php echo "{$quizname}" ?>"/>
								
								<input type="text" maxlength="17" id='datepicker1' name="dtStartTime" class="textfield" 
								style="width:120px;height:20px;display:none" required value="<?php echo "{$quizstarttime}" ?>"/>
								
								<input type="text" maxlength="17" id='datepicker2' name="dtEndTime" 
								class="textfield"  style="width:40px;display:none;width:120px;" 
								value="<?php echo "{$quizendtime}" ?>" required/>

							</td>
						</tr>
<!--						<tr>
							<td class="form_sec">Start Time</td>
							<td colspan="2">
								<input type="text" maxlength="17" id='datepicker1' name="dtStartTime" class="textfield" style="width:120px;height:20px;" required value="<?php echo "{$quizstarttime}" ?>"/>
							</td>
						</tr>
						<tr>
							<td class="form_sec">End Time</td>
							<td colspan="2">
								<input type="text" maxlength="17" id='datepicker2' name="dtEndTime" style="width:120px;" class="textfield" required style="width:40px;" value="<?php echo "{$quizendtime}" ?>"/>
							</td>
						</tr>
-->
						<tr>
							<td class="form_sec">Total Time (In Minutes)</td>
							<td>
								<input type="text" maxlength="100" name="txttotaltime" id="txttotaltime" class="textfield" style="width:100px;" required value="<?php echo "{$totaltime}" ?>"/>
							</td>
						</tr>				
						<tr>
							<td class="form_sec">Maximum marks / Quiz Out of</td>
							<td>
								<input type="text" maxlength="100" name="txtoutof" id="txtoutof" class="textfield" style="width:100px;" required value="<?php echo "{$outof}" ?>"/>
							</td>
						</tr>		
					</table>
					</br></br>
					<table cellpadding="10" cellspacing="0" border="0" width="90%" class="tab_split">
						<tr>
							<td class="form_sec" style="width:20%">Add Instruction</td>
							<td>
								Number (if any): <input type="text" maxlength="100" name="txtinstructno" id="txtinstructno" class="textfield" style="width:50px;" value=""/>
								Text: <input type="text" maxlength="100" name="txtinstruct" id="txtinstruct" class="textfield" style="width:590px" value=""/>
								<input type='submit' name='addIsnst' id='addIsnst' value='Add' title='Update' class='btn btn btn-success' style="margin-top:-10px" />
							</td>
						</tr>
						<tr>
							<td class="form_sec">Add Question</td>
							<td>
								<input type="submit" name="btnSelectques" value="Add Question" class="btn btn btn-success" />
							</td>
						</tr>
						<tr>
							<td class="form_sec">Add Page Break</td>
							<td>
									<input type="submit" name="btnAddBreak" id="btnAddBreak" value="Add Page Break" 
									class="btn btn btn-success" />
							</td>
						</tr>	
					</table>
					</br></br>
					<table cellpadding="10" id="grdlistinstruct" name="grdlistinstruct" cellspacing="0" border="0" width="100%" class="tab_split">
						<tr>
							<th><strong>Q. No.</strong></th>
							<th><strong>Question Name</strong></th>
							<th><strong>Marks</strong></th>
							<th><strong></strong></th>
							<th><strong></strong></th>
							<th><strong></strong></th>
						</tr>
							<?php
								// Create connection
								include 'db/db_connect.php';
								$query = "SELECT quizqueid,instno, 
										CASE qtype WHEN 'Q' THEN QText ELSE  inst END  AS inst , qmarks, qnoorder 
										FROM tblquizques QQ 
										LEFT OUTER JOIN tblquestionmaster QM ON QQ.qid = QM.qid
										WHERE quizid = " . $_GET['quizid'] . " order  by qnoorder  ";
								//echo $query;
								$result = $mysqli->query( $query );
								$num_results = $result->num_rows;
								$i = 1;
								if( $num_results ){
									while( $row = $result->fetch_assoc() ){
										extract($row);
									  echo "<TR class='odd gradeX'>";
									  echo "<td>{$instno}</td>";
									  echo "<td style='display:none'>{$quizqueid}</td>";
									  echo "<td style='width:60%'><div style='word-wrap: break-word;width:800px'>{$inst}</div></td>";
									  echo "<td>{$qmarks}</td>";
									  echo "<td><a onclick=\"return confirm('Are you sure?');\" class='btn btn-primary' 
																			href='InstUpd.php?IUD=D&queid={$quizqueid}&quizid=" . $_GET['quizid'] . "&paperid=" . $_SESSION["quizpaperid"] . "'><i class='icon-remove icon-white'></i>Delete</a> </td>";
									  echo "<td><a class='btn btn-primary' 	href='InstUpd.php?IUD=Up&queid={$quizqueid}&quizid=" . $_GET['quizid'] . "&qnoorder={$qnoorder}&paperid=" . $_SESSION["quizpaperid"] . "'><i class='icon-ok icon-white'></i>Up</a> </td>";
									  echo "<td><a class='btn btn-primary' 	href='InstUpd.php?IUD=Down&queid={$quizqueid}&quizid=" . $_GET['quizid'] . "&qnoorder={$qnoorder}&paperid=" . $_SESSION["quizpaperid"] . "'><i class='icon-ok icon-white'></i>Down</a> </td>";
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
		</body>
	</form>
