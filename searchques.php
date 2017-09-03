<form action="<?php echo "searchquesMain.php?quizid=" . $_GET['quizid'] . "&paperid=" . $_GET['paperid'] ; ?>" method="post">
<?php
	//include database connection
	include 'db/db_connect.php';
	if(!isset($_SESSION)){
			session_start();
		}
		if(!isset($_SESSION["paperid"])){
			$_SESSION["paperid"] = $_GET['paperid'] ;
			
		 }
		 if(!isset($_SESSION["quizid"])){
			$_SESSION["quizid"] = $_GET['quizid'] ;
			
		 }

		 if(isset($_POST["txtqueno"]) && ($_POST["txtqueno"] <> '')){
			$_SESSION["qno"] = $_POST["txtqueno"] ;
		 }
		 else{
			 $_SESSION["qno"] = '';
		 }

		 if(isset($_POST["txtquemarks"]) && ($_POST["txtquemarks"] <> '')){
			$_SESSION["qmarks"] = $_POST["txtquemarks"] ;
		 }
		 else{
			 $_SESSION["qmarks"] = '';
		 }
?>

<br /><br />
	<h3 class="page-title">Search Questions</h3>
	 <h3 class="page-title" style="float:right;margin-top:-40px;"><a href="selectsubexamMaintMain.php?exampaperid=I&quizid=<?php echo $_SESSION['quizid'] ?>&paperid=<?php echo $_POST['ddlsubject'] ?>">Back</a></h3>
			<td> 
				<td class="form_sec span4">Q. No.</td>
				<input type="text" maxlength="100" id="txtqueno"  name="txtqueno" class="textfield" style="width:100px;" 
					value='<?php echo $_SESSION["qno"]; ?>' required/>
				<td class="form_sec span4">Q. Marks</td>
				<input type="text" maxlength="100" id="txtquemarks"  name="txtquemarks" class="textfield" style="width:100px;" 
					value='<?php echo $_SESSION["qmarks"]; ?>' required/>
				<td class="form_sec span4">Search Questions Bank</td>
				<input type="text" maxlength="100" id="txtque" style="margin-left:01%"  name="txtque" class="textfield" style="width:300px;" value=""/>
			</td>
			<td>
				<input type="submit" name="btnSearch" style="margin-left:02%" value="Search" class="btn btn-mini btn-success" />
			</td>
				<table cellpadding="10" cellspacing="0" border="0" width="90%" class="tab_split">
					<tr>
						<th style='width:84%'><strong>Question Name</strong></th>
						<th><strong>Image</strong></th>
						<th><strong>Select</strong></th>
					</tr>
				</table>
		<div class="row-fluid">
			<div class="v_detail">
				<table cellpadding="10" cellspacing="0" border="0" width="90%" class="tab_split">
					<?php
					// Create connection
					include 'db/db_connect.php';
						if(isset($_POST['btnSearch'])) {
							//if (!empty($_POST['txtque'])) {
							$query = "SELECT QID,QText, photopath FROM tblquestionmaster 
									WHERE (created_by = '" . $_SESSION["SESSusername"] . "' or updated_by = '" . $_SESSION["SESSusername"] . "') 
									and   (QText LIKE '%". $_POST["txtque"]. "%' 
									or 		keyword like  '%" . $_POST["txtque"]. "%')" ;
							//echo $query;
							$result = $mysqli->query( $query );
							$num_results = $result->num_rows;
								if( $num_results ){
									while( $row = $result->fetch_assoc() ){
										extract($row);
										echo "<TR class='odd gradeX'>";
										echo "<td><div style='word-wrap: break-word;width:800px'>{$QText}</div></td>";
										echo "<td><a target='_blank' href='qimages/" . $photopath . "'>{$photopath}</a></td>";
										echo "<td><a class='btn btn-primary' href='InstUpd.php?IUD=IQ&QID={$QID}&quizid=" . $_SESSION['quizid'] . "&quizno=" . $_POST['txtqueno'] . "&qmarks=" . $_POST['txtquemarks'] . "&paperid=" . $_GET['paperid'] . "'><i class='icon-ok icon-white'></i>Add</a> </td>";
										echo "</TR>";
									}
								}
							//}
						}
								else{
									echo "<TR class='odd gradeX'>";
									echo "<td></td>";
									echo "<td>No questions found.</td>";
									echo "<td></td>";
									echo "<td></td>";
									echo "</TR>";
								}

				echo "</table>";
					?>
			</div>
		</div>
</form>
				