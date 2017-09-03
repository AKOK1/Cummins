<form method="post">
<head>
<script type="text/javascript">
function setval(){
	document.getElementById('txtVal').value = '1';
		alert(document.getElementById('txtVal').value);
}
function showhide(){
	if(document.getElementById('txtVal').value == '1'){
		document.getElementById('divMain').style.display = 'none';
		document.getElementById('divMessage').style.display = 'block';
	}
}
</script>
</head>
<body>
<?php
//include database connection
include 'db/db_connect.php';
 
// if the form was submitted/posted, update the record
if (isset($_POST['btnUpdate']))
{
	$sql = "Insert into tblcontactus ( CDATE, MESSAGE, UID, UTYPE, MISC) 
			Values ( CURRENT_TIMESTAMP, ?, ?, ?, ?)";
	$stmt = $mysqli->prepare($sql);
	$stmt->bind_param('ssss', $_POST['txtMessage'], $_SESSION["SESSUserID"], $_SESSION["usertype"], $_SESSION["loginid"]);
	
	// execute the update statement
	if($stmt->execute()){
		echo "<script type='text/javascript'>window.onload = function()
						{
								document.getElementById('divMain').style.display = 'none';
								document.getElementById('divMessage').style.display = 'block';
						}
						</script>";
		//header('Location: BlockListMain.php?'); 
		// close the prepared statement
	}else{
		die("Unable to update.");
	}
}
?>

	<br /><br />
		<div id="divMessage" style="display:none">
			<h3 class="page-title" style="margin-left:5%">We have logged your issue.    <a href="MainMenuMain.php">Click here<a/> to go back to Main Page.</h3>
		</div>
		<div id="divMain" style="display:block">
			<h3 class="page-title" style="margin-left:5%">Please enter the details of the issue you are facing with Student Registration form.
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="MainMenuMain.php">Go Back<a/></h3>
			<div class="v_detail" style="margin-left:5%">
			<input type="hidden" id="txtVal" value="0"/>
  			<textarea rows="20" name="txtMessage" style="width:800px" required></textarea>
				<br/>
				<input type="submit" name="btnUpdate" value="Save" title="Update" class="btn btn-mini btn-success" />
			</div>
		</div>
</body>
</form>

