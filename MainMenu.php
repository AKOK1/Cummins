
<form action="MainMenu.php" method="post">
	<br /><br />	<br />
	<h3 class="page-title">Main Menu</h3>
	<div class="row-fluid">
		<div class="span10">
			<div class="metro-nav  report_sec">
				<?php
				include 'db/db_connect.php';
				/*if($_SESSION["usertype"] == 'sa')
							$query = "SELECT distinct ScreenName,Screenpage,ScreenStyle
							FROM tblscreenmaster SM
							INNER JOIN tblrolescreens RS ON RS.ScreenID = SM.ScreenID 
							where Coalesce(Showonmainmenu,0) = 1 
							order by SM.ScreenID";
				else*/
					$query = "SELECT ScreenName,Screenpage,ScreenStyle
							FROM tblscreenmaster SM
							INNER JOIN tblrolescreens RS ON RS.ScreenID = SM.ScreenID 
							AND RS.ReadAccess = 'Yes'
							INNER JOIN tblrolemaster RM ON RM.RoleiD = RS.RoleID AND 
							RoleName = '" . $_SESSION["usertype"] . "' 
							 and Coalesce(Showonmainmenu,0) = 1 
							order by SM.ScreenID";
							//ReadAccess = 'Yes'
							//AND RoleID = " . $_SESSION["usertype"] .
				//echo $query;
				//die;
				$result = $mysqli->query( $query );
				$num_results = $result->num_rows;
				if( $num_results ){
					while( $row = $result->fetch_assoc() ){
						extract($row);
						echo "<div class='metro-nav-block ";
						echo $ScreenStyle;
						echo "'><a ";
						if(strcmp($ScreenName,"View In-sem Marks") != 0)
						{
							echo "";
						}
						else{
							echo " target='_blank' ";
						}
						echo " href='";
						echo $Screenpage;
						echo "'><div class='status'>";
						echo $ScreenName;
						echo "</div></a></div>";
					}
				}
				?>
				<div></div>
			</div>
		</div>
    </div>

	
				<!--
				<div class='metro-nav-block p_t'><a href='ExamListMain.php'>
					<div class="status">Exam Master </div></a>
				</div>
				<div class='metro-nav-block p_type'><a href='BlockListMain.php'>
					<div class="status">Block Master </div></a>
				</div>

				<div class='metro-nav-block comodity'><a href='UserListMain.php'>
					<div class="status">User Master</div></a>
				</div>
				<div class='metro-nav-block vendor_type'><a href='SubjectListMain.php'>
					<div class="status">Subject Master</div></a>
				</div>
				<div class='metro-nav-block p_t'><a href='PaperListMain.php'>
					<div class="status">Paper Master</div></a>
				</div>
				<div class='metro-nav-block p_t'><a href='CustomListMain.php'>
					<div class="status">Custom Lists</div></a>
				</div>
				<div class='metro-nav-block comodity'><a href='StdListMain.php'>
					<div class="status">Student Master</div></a>
				</div>
				<div class='metro-nav-block p_type'><a href='ContactUsListMain.php'>
					<div class="status">Contact Us Messages</div></a>
				</div>
				<div class='metro-nav-block comodity'><a href='RoleListMain.php'>
					<div class="status">Role Master</div></a>
				</div>
				<div class='metro-nav-block p_type'><a href='ExamMenuMain.php'>
					<div class="status">Exam Menu</div></a>
				</div>
				<div class='metro-nav-block vendor_type'><a href='RoleScreensMain.php'>
					<div class="status">Role Screen Access</div></a>
				</div>
-->

</form>
