<?php
 if(!isset($_SESSION)){
	session_start();
	}
	if(isset($_SESSION["qbpaperid"])){
		if(($_SESSION["qbpaperid"] == "")) 
			$_SESSION["qbpaperid"] = $_GET["PaperID"];
		
	}
	unset($_SESSION["QID"]);
?>
<form action="welcome.php" method="post">
	<br /><br />
	<h3 class="page-title">Question Master List</h3>
	<h3 class="page-title" style="float:right;margin-top:-40px;"><a href="QBSubListMain.php">Back</a></h3>
	<div class="row-fluid">
		<div class="v_detail">
			<table cellpadding="10" cellspacing="0" border="0" width="100%" class="tab_split">
				<tr>
					<th><a class='btn btn-mini btn-success' href="QuestionMaintMain.php?QID=I"><i class="icon-plus icon-white"></i>New</a></th>
					<th><strong>Papertype</strong></th>
					<th><strong>Category</strong></th>
					<th><strong>Question Name</strong></th>
					<th><strong>Answer Type</strong></th>
					<th><strong>Map CO</strong></th>
					<th><strong>Map PO</strong></th>
					<th><strong>Keyword</strong></th>
					<th><strong>Difficulty Level</strong></th>
					<th><strong>Unit</strong></th>
					<th><strong>Delete</strong></th>
					
				</tr>

				<?php
				// Create connection
				include 'db/db_connect.php';
				 if(!isset($_SESSION)){
				session_start();
				}
				$_SESSION["qbsubname"] = $_GET["subname"];
				$query = "SELECT QID, QText,answertype,difflevel,Category,Papertype,mapco,mappo,keyword,unit 
				FROM tblquestionmaster where created_by = '" . $_SESSION["SESSusername"] . "'";
				
				$result = $mysqli->query( $query );
				$num_results = $result->num_rows;
				
				if( $num_results ){
					while( $row = $result->fetch_assoc() ){
						extract($row);
					  echo "<TR class='odd gradeX'>";
					  echo "<td><a class='btn btn-mini btn-primary' href='QuestionMaintMain.php?QID={$QID}'><i class='icon-pencil icon-white'></i>Edit</a> </td>";
					  echo "<td>{$Papertype}</td>";
					  echo "<td>{$Category}</td>";
					  echo "<td>{$QText}</td>";
					  echo "<td>{$answertype}</td>";
					  echo "<td>{$mapco}</td>";
					  echo "<td>{$mappo}</td>";
					  echo "<td>{$keyword}</td>";
					  echo "<td>{$difflevel}</td>";
					  echo "<td>{$unit}</td>";
					  echo "<td><a onclick=\"return confirm('Are you sure?');\" class='btn btn-primary' href='QuestionListUpd.php?IUD=D&QID={$QID}'><i class='icon-remove icon-white'></i></a> </td>";
					  echo "</TR>";
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
				
			</table>
			
		</div>
	</div>

</form>

