
<form >
	<head>
	 <script type="text/javascript">     
		function PrintDiv() {    
		var divToPrint = document.getElementById('divToPrint');
		var popupWin = window.open('', '_blank', 'width=300,height=300');
		popupWin.document.open();
		popupWin.document.write('<html><body onload="window.print()">' + divToPrint.innerHTML + '</html>');
		popupWin.document.close();
            }
	</script>
	
	</head>

	<body onload="PrintDiv()">
		<div class="row-fluid" id="divToPrint" style="margin-left:5%">

		<?php
			include 'db/db_connect.php';
			$sql = "SELECT  Concat(FirstName, ' ', LastName) as Name FROM tbluser WHERE userID  = " . $_GET['userID'] 	 ;
			$result = $mysqli->query( $sql );
			$num_results = $result->num_rows;
			if( $num_results ){
				while( $row = $result->fetch_assoc() ){
					extract($row);
					echo "<h3 class='page-title' style='margin-left:5%'>Preferences for {$Name}</h3>";
				}
			}					
			//disconnect from database
			$result->free();
			$mysqli->close();

		?>

        <div class="span5 v_detail" style="overflow:hidden">
            <br/>
            <br/>
			<table cellpadding="10" cellspacing="0" border="1" width="50%" class="tab_split">
				<tr>
					<th>Exam Date</th>
					<th>Day</th>
					<th>Slot</th>
				</tr>
				<?php
					include 'db/db_connect.php';
					$sql = "SELECT  ProfPrefID, 
							DATE_FORMAT(STR_TO_DATE(ExamDate,'%m/%d/%Y'), '%d %M %Y') AS ExamDateT, 
							DAYNAME(STR_TO_DATE(ExamDate,'%m/%d/%Y')) AS ExamDay, ExamSlot
							FROM tblprofessorpref 
							WHERE ProfId = ". $_GET['userID'] . " AND ExamId = 1"	 ;

					// execute the sql query
					$result = $mysqli->query( $sql );
					$num_results = $result->num_rows;

					if( $num_results ){
						while( $row = $result->fetch_assoc() ){
							extract($row);
							echo "<TR class='odd gradeX'>";
							echo "<td>{$ExamDateT} </td>";
							echo "<td>{$ExamDay} </td>";
							echo "<td>{$ExamSlot} </td>";
							echo "</TR>";
						}
					}					
					//disconnect from database
					$result->free();
					$mysqli->close();

				?>

			</table>
			
			</div>
	</div>

	</body>
	</form>

