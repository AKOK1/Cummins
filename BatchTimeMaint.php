<?php
	include 'db/db_connect.php';
	If (isset($_POST['AddToList'])){
		$mysqli->query("SET @i_timeid  = " . $_POST["ddlListNames"] . "");
		$mysqli->query("SET @i_batchname   = '" .  $_POST['txtBatchName'] . "'");
		$result1 = $mysqli->query("CALL SP_SAVETIMELIST(@i_timeid,@i_batchname)");
	}
	If (isset($_POST['btnUpdate'])){
		$mysqli->query("SET @i_batchname   = '" .  $_POST['txtBatchName'] . "'");
		$mysqli->query("SET @i_batchtimeid  = " . $_POST["batchtimeid"] . "");
		$result1 = $mysqli->query("CALL SP_SAVETIMEBATCH(@i_batchname,@i_batchtimeid)");
	}
	if(isset($_GET['batchtimeid'])){
		if ($_GET['batchtimeid'] != '') {
			$mysqli->query("SET @i_ItemID  = " . $_GET["batchtimeid"] . "");
			$mysqli->query("call SP_DELETETIMELISTITEMS(@i_ItemID)");
		}
	}
?>
<form action="" method="post">
	<br /><br />
	<h3 class="page-title">View Batch Time List</h3>
	<h3 class="page-title" style="float:right;margin-top:-40px;"><a href="BatchTimeListMain.php">Back</a></h3>
	
	<table cellpadding="10" cellspacing="0" border="0" width="30%" class="tab_split" style="margin-left:5%">
		<tr>
		<td>Batch Name</td><td>
			<div class="span10">
				<input type="text" maxlength="4" name="txtBatchName" class="textfield" required
				value="<?php	if(isset($_POST['txtBatchName']) && ($_POST['txtBatchName'] != '')){
									echo $_POST['txtBatchName'];
								}
							else{
								if($_GET['batchname'] == 'I') 
									echo ''; 
								else 
									echo $_GET['batchname'];								
							}								
						?>" />
			</div>
		</td>
		<td>
			<div class="span10">
				<input type="hidden" name="txtBlockID" value="<?php echo "{$BlockID}" ?>" />
				<?php 
				if(($_SESSION["ReadAccess"] == "Yes") && ($_SESSION["WriteAccess"] == "Yes")){
					echo "<input type='submit' name='btnUpdate' value='Save' title='Update' class='btn btn-mini btn-success' />";
				}
				?>
			</div>
		</td>								
		
	</tr>						
	</table>
	
	<table cellpadding="10" cellspacing="0" border="0" width="30%" class="tab_split" style="margin-left:5%">
		<tr>
			<th>Time</th>
			<th>Delete
			<?php
				include 'db/db_connect.php';	
				echo "<select id='ddlListNames' name='ddlListNames' style='width:160px'><option value=''>Select All</option>";
				$query = "SELECT timeid, Concat(timefrom,' ',ampmfr,' to ',timeto,' ',ampmto) as Time 
							FROM tbltimemaster order by timeorder";
				//echo $query;
				$result = $mysqli->query( $query );
				$num_results = $result->num_rows;
				if( $num_results ){
					while( $row = $result->fetch_assoc() ){
						extract($row);
						echo "<option value='{$timeid}'>{$Time}</option>";
					}
				}
				echo "<input style='margin-top:-7px;margin-left:10px' onclick=\"return confirm('Are you sure?');\" name='AddToList' type='submit' value='Add to List' />";
			?>
			</th>			
		</tr>		
		<?php
			include 'db/db_connect.php';
			$bname = '';
			if(isset($_POST['txtBatchName']) && ($_POST['txtBatchName'] != '')){
					$bname = $_POST['txtBatchName'];
				}
			else{
				if($_GET['batchname'] == 'I') 
					$bname = ''; 
				else 
					$bname = $_GET['batchname'];								
			}

			$query = "SELECT batchtimeid,Concat(timefrom,' ',ampmfr,' TO ',timeto,' ',ampmto) as Time 
							FROM tblbatchtimemaster 
							where batchname = '" . $bname ."' order by timeorder";
			//echo $query;
			$result = $mysqli->query( $query );
			$num_results = $result->num_rows;
			if( $num_results ){
				// Loop the first result set, reading it into an array
				while( $row = $result->fetch_assoc() ){
					extract($row);
					echo "<TR class='odd gradeX'>";
					echo "<td>{$Time}
							<input type='hidden' name='batchtimeid' value='{$batchtimeid}' />
						</td>";
					echo "<td><a class='btn btn-primary' href='BatchTimeMaintMain.php?batchname={$bname}&batchtimeid={$batchtimeid}'><i class='icon-remove icon-white'></i></a> </td>";
				}
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
