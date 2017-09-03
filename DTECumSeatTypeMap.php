<?php
//include database connection
include 'db/db_connect.php';

// if the form was submitted/posted, update the record
 if (isset($_POST['btnSave']))
	{
		$CSeatType = $_POST['ddlCSeatType'];
		$DTESeatTypes = $_POST['txtSeatType'];
		$size = count($CSeatType);

		for($i = 0 ; $i < $size ; $i++){

			include 'db/db_connect.php';
			$sql = "Update tblstudent Set cseattype = ? Where seattype = ? " ;
			$stmt = $mysqli->prepare($sql);
			$stmt->bind_param('ss', $CSeatType[$i],  $DTESeatTypes[$i]);
			if($stmt->execute()){} 
			else{echo $mysqli->error;}
		}
		echo "<script type='text/javascript'>window.onload = function()
			{	document.getElementById('lblSuccess').style.display = 'block';	}
			</script>";
	}
?>

<form action="DTECumSeatTypeMapMain.php" method="post">
	<head>	</head>

	<br /><br />
	<div>
	<h3 class="page-title" style="margin-left:5%">Seat Type Mapping</h3>
	<h3 class="page-title" style="float:right;margin-top:-40px;"><a href="FeeIndexMain.php">Back</a></h3>
	</div>

	<br/>
	<div style="float:left;margin-left:65px;margin-top:-20px">
		<label id="lblSuccess" style="margin-left:10px;color:green;font-weight:bold;display:none" >Data saved successfully.</label>
	</div>
	<br/>
	<div class="row-fluid" style="margin-left:5%">
	    <div class="span6 v_detail" style="overflow:scroll">
			<table cellpadding="10" cellspacing="0" border="0" class="tab_split" width="80%">
				<tr>
					<th>DTE Seat Type</th>
					<th>Cummins Seat Type</th>
				</tr>

				<?php
					$sql = " SELECT DISTINCT(seattype), cseattype FROM tblstudent ORDER BY seattype" ;

					//echo $sql;
					
					// execute the sql query
					$result = $mysqli->query( $sql );
					$num_results = $result->num_rows;

					if( $num_results ){
						while( $row = $result->fetch_assoc() ){
							extract($row);
							echo "<TR class='odd gradeX'>";
							echo "<td><label name='lblDTESeatType' class='span4'>{$seattype}</label>
									  <input style='display:none' type='text' maxlength='2' name='txtSeatType[]' class='span4' value='{$seattype}' />";
							echo "</td>";
							$Selcseattype = $cseattype;
							
							echo"<td class='form_sec span2'>";
							echo"<select name='ddlCSeatType[]' style='width:200px;margin-top:10px'>";

							include 'db/db_connect.php';
							$sql = "SELECT 0 AS SeatTypeId, 'Select ' AS SeatType UNION 
									SELECT SeatTypeId, SeatType FROM tblseattype;";
							$result1 = $mysqli->query( $sql );
							//echo $mysqli->error;
							while( $row1 = $result1->fetch_assoc() ) {
							extract($row1);
							 if(($Selcseattype == $SeatType)){
									echo "<option value={$SeatType} selected>{$SeatType}</option>"; 
								}
								else{
									echo "<option value={$SeatType}>{$SeatType}</option>"; 
								}
							}
							echo"</select>";
							echo "</td>";
						}
					}					
					//disconnect from database
					$result->free();
					$mysqli->close();
				?>
			</table>
            <br />
        </div>
	</div>
	<div class="clear"></div>
	<div class="form_sec span2">
		<input type="submit" name="btnSave" value="Save" title="Update" class="btn btn-mini btn-success" />
	</div>								
