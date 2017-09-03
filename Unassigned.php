
<form action="UnassignedMain.php" method="post">
	<br /><br />
	<h3 class="page-title" style="margin-left:5%">Pending Preferences</h3>

			<table cellpadding="10" cellspacing="0" border="0" class="tab_split" style="margin-left:5%">
			<tr >
				<td class="form_sec span1">Professors</td>
				<td class="form_sec span2">
					<select name="ddlProfList" style="width:50%;margin-top:10px">
						<?php
						include 'db/db_connect.php';
						$sql = "CALL GetUnassignedProfNames();";
						$result1 = $mysqli->query( $sql );
						while( $row = $result1->fetch_assoc() ) {
						extract($row);
						echo "<option value={$UserID} ";  
								If (isset($_POST['ddlProfList']) && $_POST['ddlProfList'] == $UserID) 
								{ echo 'selected';}
						echo ">{$ProfName}</option>"; 
						}
						?>
					</select>
				</td>

				<td class="form_sec span2">
					<input type="submit" name="btnSearch" value="Search" title="Update" class="btn btn-mini btn-success" />
				</td>								
			</tr>						
		</table>

	<div class="row-fluid" style="margin-left:5%">
	    <div class="span5 v_detail" style="overflow:hidden">
            <br />
            <br />
            <div style="float:left">
				<label><b>Available Slots</b></label>
            </div>
			<table cellpadding="10" cellspacing="0" border="0" width="100%" class="tab_split">
				<tr>
					<th>Exam Date</th>
					<th>Exam Date</th>
					<th>Day</th>
					<th>Slot</th>
					<th width="10%"><strong>Action</strong></th>
				</tr>
				<?php
					include 'db/db_connect.php';
					if (isset($_POST['btnSearch']))
					{
						$sql = "SELECT  ExamDate, 
								DATE_FORMAT(STR_TO_DATE(ExamDate,'%m/%d/%Y'), '%d %M %Y') AS ExamDateT, 
								DAYNAME(STR_TO_DATE(ExamDate,'%m/%d/%Y')) AS ExamDay, ExamSlot
								FROM tblexamschedule 
									WHERE CONCAT(ExamDate,ExamSlot) NOT IN  (SELECT CONCAT(ExamDate,ExamSlot) 
									FROM tblprofessorpref WHERE ProfId = " . $_POST['ddlProfList'] . " AND ExamId = 1)"	 ;

						// execute the sql query
						$result = $mysqli->query( $sql );
						$num_results = $result->num_rows;

						if( $num_results ){
							while( $row = $result->fetch_assoc() ){
								extract($row);
								echo "<TR class='odd gradeX'>";
								echo "<td>{$ExamDate} </td>";
								echo "<td>{$ExamDateT} </td>";
								echo "<td>{$ExamDay} </td>";
								echo "<td>{$ExamSlot} </td>";
								echo "<td class='span2'>
										<a class='btn btn-mini btn-success' 
										href='ProfPrefUpd.php?IUD=U&ExamDate={$ExamDate}&ExamSlot={$ExamSlot}&Prof=$_POST[ddlProfList]'>
										<i class='icon-ok icon-white'></i>&nbsp&nbspBook</a>
									  </td>";
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
	</form>

