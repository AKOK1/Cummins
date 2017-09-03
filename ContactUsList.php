<form action="" method="post">
	<br /><br />
	<h3 class="page-title">Contact Us Messages</h3>
	<h3 class="page-title" style="float:right;margin-top:-40px;"><a href="MainMenuMain.php">Back</a></h3>
<script type='text/javascript'>
function doSwap(self, event)
{
    var swapValue = document.getElementById('msg').value;
	var lnk = document.getElementById("mylink").title + '&message=' + encodeURIComponent(swapValue);
	//event.preventDefault();
    location.href = lnk; 
}
</script>
	<table cellpadding="10" cellspacing="0" border="0" width="80%" class="tab_split" style="margin-left:5%">
		<tr>
			<th style="width:1%">No.</th>
			<th style="width:20%">Name - Dept - Mob - Email - Year</th>
			<th style="width:10%">Date</th>
			<th style="width:32%">Message</th>
			<th style="width:9%">CNUM</th>
			<th style="width:26%">Reply</th>
			<th style="width:2%">Delete</th>
		</tr>
		<?php
			include 'db/db_connect.php';
			if(isset($_GET['CID'])){
				if ($_GET['CID'] != '') {
					$mysqli->query("SET @i_CID  = " . $_GET["CID"] . "");
					$mysqli->query("call SP_DELETECONTACTUSITEMS(@i_CID)");
				}
			}
			//$mysqli->query("SET @i_ListID  = " . $_GET["ListID"] . "");
			if ($mysqli->multi_query("call SP_GETCONTACTUSITEMS()"))
			{
					//$show_results = true;
					//$rs = array();
					do {
						// Lets work with the first result set
						if ($result = $mysqli->use_result())
						{
							// Loop the first result set, reading it into an array
							while ($row = $result->fetch_array(MYSQLI_ASSOC))
							{
								extract($row);
								echo "<TR class='odd gradeX'>";
								echo "<td>{$SrNo}</td>";
								echo "<td>{$STDName}</td>";
								echo "<td>{$CDATE}</td>";
								echo "<td>{$MESSAGE}</td>";
								echo "<td>{$CNUM}</td>";
								echo "<td><textarea name='msg' id='msg' rows='3'></textarea>
							<a id='mylink' title='sendemail.php?emailto={$email}&tickettext={$MESSAGE}' onclick=\"doSwap.call(this, event);\" class='btn btn-primary' ><i class='icon-white'>Send</i></a>
										</td>";
								echo "<td><a onclick=\"return confirm('Are you sure?');\" class='btn btn-primary' href='ContactUsListMain.php?CID={$CID}'><i class='icon-remove icon-white'></i></a> </td>";

							}
						}
					} while ($mysqli->next_result() && $mysqli->more_results());
							// Close the result set
							//disconnect from database
							$result->free();
							$mysqli->close();
					}
			else
			{
				echo "<TR class='odd gradeX'>";
				echo "<td></td>";
				echo "<td>No records found.</td>";
				echo "<td></td>";
				echo "</TR>";
			}


		?>
	</table>
</form>
