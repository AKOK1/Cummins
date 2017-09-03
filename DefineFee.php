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
			$sql = " SELECT 1 FROM tblseattypefeedetail 
					WHERE CalYear = '". $_POST['ddlYear'] . "' 
					and AdmYear = '".  $_POST['ddlAdmYear'] . "'
					and AdmType = '".  $_POST['ddlAdmType'] . "'
					and EduYear = '".  $_POST['ddlEduYear'] . "'
					and SeatTypeId = ". $_POST['ddlSeatType']  . "
					and FeeTypeId = " .$FeeTypeIDs[$i] . "";

					// execute the sql query
			$result = $mysqli->query( $sql );
			$num_results = $result->num_rows;
			if($num_results)
			{
				//update
				include 'db/db_connect.php';
				$sql = "update tblseattypefeedetail set Fee = ?
						where CalYear = '". $_POST['ddlYear'] . "' 
						and AdmYear = '" .  $_POST['ddlAdmYear'] . "'
						and AdmType = '" .  $_POST['ddlAdmType'] . "'
						and EduYear = '" .  $_POST['ddlEduYear'] . "'
						and SeatTypeId = " . $_POST['ddlSeatType']  . "
						and FeeTypeId = " . $FeeTypeIDs[$i] . "" ;
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
				$sql = "Insert into tblseattypefeedetail ( CalYear, AdmYear, AdmType, EduYear, SeatTypeId, FeeTypeId, Fee) Values ( ?, ?, ?, ?, ?, ?, ?)";
			$stmt = $mysqli->prepare($sql);
			$stmt->bind_param('sssssii', $_POST['ddlYear'], $_POST['ddlAdmYear'], $_POST['ddlAdmType'],$_POST['ddlEduYear'], $_POST['ddlSeatType'], $FeeTypeIDs[$i] , $PerOfOpens[$i] );
			
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
<form action="DefineFeeMain.php" method="post">
	<head>
		<script>
			$(function() {
				$('.DTEXDATE').each(function(i) {
							this.id = 'datepicker' + i;
					}).datepicker({ dateFormat: 'dd-M-yy' });
				//});
				//$( ".DTEXDATE" ).datepicker();
				//$(".DTEXDATE").each(function(){
				//	$(this).datepicker();
				//});
			});

			function sendshowfee()
			{
				var getYear = ddlYear.options[ddlYear.selectedIndex].text;
				var getAdmType = ddlAdmType.options[ddlAdmType.selectedIndex].text;
				var getEduYear = ddlEduYear.options[ddlEduYear.selectedIndex].text;

				window.open('ShowFee.php?CalYear=' + getYear + 
										'&AdmType=' + getAdmType +
										'&EduYear=' + getEduYear,'_blank');
			}

			</script>
	</head>

	<br /><br />
	<div>
	<h3 class="page-title" style="margin-left:5%">Define Fee</h3>
	<h3 class="page-title" style="float:right;margin-top:-40px;"><a href="FeeIndexMain.php">Back</a></h3>
	</div>
		<table cellpadding="10" cellspacing="0" border="0" class="tab_split" style="margin-left:5%">
			<tr >
				<td class="form_sec span1">Academic Year</td>
				<td class="form_sec span3">
					<select name="ddlYear" id="ddlYear" style="margin-top:10px;width:100px" required>
						<option value="">Select </option>
						<option value="2017-18" <?php echo (isset($_POST['ddlYear']) && $_POST['ddlYear'] == '2017-18')?'selected="selected"':''; ?>>2017-18</option>
						<option value="2018-19" <?php echo (isset($_POST['ddlYear']) && $_POST['ddlYear'] == '2018-19')?'selected="selected"':''; ?>>2018-19</option>
						<option value="2019-20" <?php echo (isset($_POST['ddlYear']) && $_POST['ddlYear'] == '2019-20')?'selected="selected"':''; ?>>2019-20</option>
						<option value="2020-21" <?php echo (isset($_POST['ddlYear']) && $_POST['ddlYear'] == '2020-21')?'selected="selected"':''; ?>>2020-21</option>
					</select>
				</td>
				<td class="form_sec span1">Educational Year</td>
				<td class="form_sec span3">
					<select name="ddlEduYear" id="ddlEduYear" style="margin-top:10px;width:100px" required>
						<option value="">Select </option>
						<option value="F.E." <?php echo (isset($_POST['ddlEduYear']) && $_POST['ddlEduYear'] == 'F.E.')?'selected="selected"':''; ?>>F.E.</option>
						<option value="S.E." <?php echo (isset($_POST['ddlEduYear']) && $_POST['ddlEduYear'] == 'S.E.')?'selected="selected"':''; ?>>S.E.</option>
						<option value="T.E." <?php echo (isset($_POST['ddlEduYear']) && $_POST['ddlEduYear'] == 'T.E.')?'selected="selected"':''; ?>>T.E.</option>
						<option value="B.E." <?php echo (isset($_POST['ddlEduYear']) && $_POST['ddlEduYear'] == 'B.E.')?'selected="selected"':''; ?>>B.E.</option>
						<option value="M.E.1" <?php echo (isset($_POST['ddlEduYear']) && $_POST['ddlEduYear'] == 'M.E.1')?'selected="selected"':''; ?>>M.E.1</option>
						<option value="M.E.2" <?php echo (isset($_POST['ddlEduYear']) && $_POST['ddlEduYear'] == 'M.E.2')?'selected="selected"':''; ?>>M.E.2</option>
					</select>
				</td>
				<td class="form_sec span1">Admission Year</td>
				<td class="form_sec span3">
					<select name="ddlAdmYear" id="ddlAdmYear" style="margin-top:10px;width:100px" required >
						<option value="">Select </option>

						<option value="2017-18" <?php echo (isset($_POST['ddlAdmYear']) && $_POST['ddlAdmYear'] == '2017-18')?'selected="selected"':''; ?>>2017-18</option>
						<option value="2016-17" <?php echo (isset($_POST['ddlAdmYear']) && $_POST['ddlAdmYear'] == '2016-17')?'selected="selected"':''; ?>>2016-17</option>
						<option value="2015-16" <?php echo (isset($_POST['ddlAdmYear']) && $_POST['ddlAdmYear'] == '2015-16')?'selected="selected"':''; ?>>2015-16</option>
						<option value="2014-15" <?php echo (isset($_POST['ddlAdmYear']) && $_POST['ddlAdmYear'] == '2014-15')?'selected="selected"':''; ?>>2014-15</option>
						<option value="2013-14" <?php echo (isset($_POST['ddlAdmYear']) && $_POST['ddlAdmYear'] == '2013-14')?'selected="selected"':''; ?>>2013-14</option>
						<option value="2012-13" <?php echo (isset($_POST['ddlAdmYear']) && $_POST['ddlAdmYear'] == '2012-13')?'selected="selected"':''; ?>>2012-13</option>
						<option value="2011-12" <?php echo (isset($_POST['ddlAdmYear']) && $_POST['ddlAdmYear'] == '2011-12')?'selected="selected"':''; ?>>2011-12</option>
						<option value="2010-11" <?php echo (isset($_POST['ddlAdmYear']) && $_POST['ddlAdmYear'] == '2010-11')?'selected="selected"':''; ?>>2010-11</option>
					</select>
				</td>
				<td class="form_sec span1">Adm. Type</td>
				<td class="form_sec span3">
					<select name="ddlAdmType" id="ddlAdmType" style="margin-top:10px;width:150px" required>
						<option value="">Select </option>
						<option value="F.E." <?php echo (isset($_POST['ddlAdmType']) && $_POST['ddlAdmType'] == 'F.E.')?'selected="selected"':''; ?>>F.E.</option>
						<option value="D.S.E." <?php echo (isset($_POST['ddlAdmType']) && $_POST['ddlAdmType'] == 'D.S.E.')?'selected="selected"':''; ?>>D.S.E.</option>
						<option value="M.E." <?php echo (isset($_POST['ddlAdmType']) && $_POST['ddlAdmType'] == 'M.E.')?'selected="selected"':''; ?>>M.E.</option>
					</select>
				</td>
				<td class="form_sec span1">Seat Type</td>
				<td class="form_sec span3">
					<select name="ddlSeatType" id="ddlSeatType" style="margin-top:10px;width:180px" required>
						<?php
						include 'db/db_connect.php';
						$sql = "SELECT '' AS SeatTypeId, ' Select ' AS SeatType UNION SELECT SeatTypeId, SeatType FROM tblseattype;";
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
	<div class="clear"></div>
	<div class="row-fluid" style="margin-left:5%">
		<input type="submit" name="btnCalcPer" value="Calculate Fee using Percentage" title="Update" class="btn btn-mini btn-success" />
	</div>
	<div class="clear"></div>
	<br/>

	<div class="row-fluid" style="margin-left:5%">
	    <div class="span10 v_detail" style="overflow:scroll">
			<table cellpadding="10" cellspacing="0" border="0" class="tab_split" width="50%">
				<tr>
					<th>Fee Type</th>
					<th>Fee</th>
				</tr>

				<?php
					If ((isset($_POST['btnSearch'])) or (isset($_POST['btnSave'])) or isset($_POST['btnCalcPer']) )
					{
						If (isset($_POST['btnCalcPer']))
						{
							$mysqli->query("set @i_CalYear   = '" .  $_POST['ddlYear'] . "'");
							$mysqli->query("set @i_AdmYear   = '" .  $_POST['ddlAdmYear'] . "'");
							$mysqli->query("set @i_AdmType   = '" .  $_POST['ddlAdmType'] . "'");
							$mysqli->query("set @i_EduYear   = '" .  $_POST['ddlEduYear'] . "'");
							$mysqli->query("set @i_SeatTypeId   = " .  $_POST['ddlSeatType'] . "");
							
							$result = $mysqli->query("call SP_CalFromPer(@i_CalYear, @i_AdmYear, @i_AdmType, @i_EduYear, @i_SeatTypeId )");
							$num_results = $result->num_rows;
						}

						$mysqli->query("set @i_CalYear   = '" .  $_POST['ddlYear'] . "'");
						$mysqli->query("set @i_AdmYear   = '" .  $_POST['ddlAdmYear'] . "'");
						$mysqli->query("set @i_AdmType   = '" .  $_POST['ddlAdmType'] . "'");
						$mysqli->query("set @i_EduYear   = '" .  $_POST['ddlEduYear'] . "'");
						$mysqli->query("set @i_SeatTypeId   = " .  $_POST['ddlSeatType'] . "");
						
						$result = $mysqli->query("call SP_GetFeeDetails(@i_CalYear, @i_AdmYear, @i_AdmType, @i_EduYear, @i_SeatTypeId )");
						$num_results = $result->num_rows;

						
						$TotalFee = 0;
						if( $num_results ){
							while( $row = $result->fetch_assoc() ){
								extract($row);
								$TotalFee = $TotalFee + $Fee;
								echo "<TR class='odd gradeX'>";
								echo "<td style='display:none'><input type='text' maxlength='5' name='txtFeeTypeID[]' class='span4' value='{$FeeTypeID}' /></td>";
								echo "<td>{$FeeType}</td>";
								echo "<td><input style='width:100px;text-align:right' type='text' maxlength='6' name='txtPerOfOpen[]' class='span6' value='{$Fee}' /></td>";
								echo "</TR>";
							}
							echo "<TR class='odd gradeX'>";
							echo "<td><b>Total</b></td>";
							echo "<td><b><input style='width:100px;text-align:right' type='text' maxlength='6' name='txtPerOfOpen[]' class='span6' readonly value='{$TotalFee}' /></b></td>";
							echo "</TR>";
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
		<input type="button" name="btnShowFee" value="Show Fee" class="btn btn btn-success" onclick="sendshowfee();" />
	</div>								
