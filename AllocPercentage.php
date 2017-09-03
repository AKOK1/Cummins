<?php
//include database connection
include 'db/db_connect.php';

// if the form was submitted/posted, update the record
 if (isset($_POST['btnSave']))
	{
		 
	foreach (array('txtFeeTypeID', 'txtPerOfOpen' ) as $pos) {
		foreach ($_POST[$pos] as $id => $row) {
			$_POST[$pos][$id] = mysqli_real_escape_string($mysqli, $row);
		} 
	}
	
	$FeeTypeIDs = $_POST['txtFeeTypeID'];
	$PerOfOpens = $_POST['txtPerOfOpen'];

	$size = count($FeeTypeIDs);

	for($i = 0 ; $i < $size ; $i++){
			//first find out if sch exists...if yes..update else insert
			$sql = " SELECT 1 FROM tblseattypefee WHERE SeatTypeId = ". $_POST["ddlSeatType"] . " and FeeTypeId = ". $FeeTypeIDs[$i]."";
			// execute the sql query
			$result = $mysqli->query( $sql );
			$num_results = $result->num_rows;
			if($num_results)
			{
				//update
				include 'db/db_connect.php';
				$sql = "update tblseattypefee set PerOfOpen = ?
						where SeatTypeId = ". $_POST["ddlSeatType"] . " and FeeTypeId = ". $FeeTypeIDs[$i] ;
				$stmt = $mysqli->prepare($sql);
				$stmt->bind_param('i', $PerOfOpens[$i]);
				if($stmt->execute()){
					//header('Location: SubjectList.php?'); 
				} 
				else{
					echo $mysqli->error;
					//die("Unable to update.");
				}
			}
			else{
				$sql = "Insert into tblseattypefee ( FeeTypeId, SeatTypeId, PerOfOpen) Values ( ?, ?, ?)";
			$stmt = $mysqli->prepare($sql);
			$stmt->bind_param('iii', $FeeTypeIDs[$i] ,$_POST["ddlSeatType"], $PerOfOpens[$i] );
			
			if($stmt->execute()){
				//header('Location: SubjectList.php?'); 
			} else{
				echo $mysqli->error;
				//die("Unable to update.");
			}
			}
		}
		echo "<script type='text/javascript'>window.onload = function()
						{
								document.getElementById('lblSuccess').style.display = 'block';
						}
						</script>";

	}
?>
<form action="AllocPercentageMain.php" method="post">

	<br /><br />
	<div>
	<h3 class="page-title" style="margin-left:5%">Allocate Percentage as a percentage of Open</h3>
	<h3 class="page-title" style="float:right;margin-top:-40px;"><a href="FeeIndexMain.php">Back</a></h3>
	</div>
		<table cellpadding="10" cellspacing="0" border="0" class="tab_split" style="margin-left:5%">
			<tr >
				<td class="form_sec span1">Seat Type</td>
				<td class="form_sec span2">
					<select name="ddlSeatType" style="width:50%;margin-top:10px">
						<?php
						include 'db/db_connect.php';
						$sql = "SELECT 0 AS SeatTypeId, ' Select ' AS SeatType UNION SELECT SeatTypeId, SeatType FROM tblseattype where SeatType <> 'Open' ;";
						$result1 = $mysqli->query( $sql );
						//echo $mysqli->error;
						while( $row = $result1->fetch_assoc() ) {
						extract($row);
						 if((isset($_POST['ddlSeatType']) && $_POST['ddlSeatType'] == $SeatTypeId)){
								echo "<option value={$SeatTypeId} selected>{$SeatType}</option>"; 
							}
							else{
								echo "<option value={$SeatTypeId}>{$SeatType}</option>"; 
							}
						}
						?>
					</select>
				</td>

				<td class="form_sec span2">
					<input type="submit" name="btnSearch" value="Search" title="Update" class="btn btn-mini btn-success" />
				</td>								
			</tr>						
		</table>

	<br/>
	<br/>
	<div style="float:left;margin-left:65px;margin-top:-20px">
		<label id="lblSuccess" style="margin-left:10px;color:green;font-weight:bold;display:none" >Data saved successfully.</label>
	</div>
	<br/>
	<div class="row-fluid" style="margin-left:5%">
	    <div class="span2 v_detail" style="overflow:scroll;width:90%">
			<table cellpadding="10" cellspacing="0" border="0" class="tab_split" width="90%">
				<tr>
					<th>Seat Type</th>
					<th>Percentage</th>
				</tr>

				<?php
					If ((isset($_POST['btnSearch'])) or (isset($_POST['btnSave'])))
					{
						$mysqli->query("set @i_SeatType   = " .  $_POST['ddlSeatType'] . "");
						$result = $mysqli->query("call SP_GetSeatFee(@i_SeatType)");
						$num_results = $result->num_rows;

						if( $num_results ){
							while( $row = $result->fetch_assoc() ){
								extract($row);
								echo "<TR class='odd gradeX'>";
								echo "<td style='display:none'><input type='text' maxlength='2' name='txtFeeTypeID[]' class='span4' value='{$FeeTypeID}' /></td>";
								echo "<td>{$FeeType}</td>";
								echo "<td><input style='width:100px;text-align:right' type='text' maxlength='3' name='txtPerOfOpen[]' class='span6' value='{$PerOfOpen}' /></td>";
								echo "</TR>";
							}
						}					
						//disconnect from database
						$result->free();
						$mysqli->close();

						}
				?>
			</table>
            <br />
        </div>
	</div>
	<div class="clear"></div>
	<div class="form_sec span2">
		<input type="submit" name="btnSave" value="Save" title="Update" class="btn btn-mini btn-success" />
	</div>								
