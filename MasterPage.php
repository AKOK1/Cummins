<?php 
	if(!isset($_SESSION)){
		session_start();
	}
	//if ( ($_SESSION["usertype"] == 'student')){
	//	header('Location: login.php?');
	//}
	//echo $page_content;
	if(empty($_SESSION["authenticated"]) || $_SESSION["authenticated"] != 'true') {
		header('Location: login.php');
	}
	else{
			//check if this user has access to THIS screen!!!
		// get roles for this page
		include 'db/db_connect.php';
		$query = "SELECT coalesce(WriteAccess,'No') as WriteAccess,coalesce(ReadAccess,'No') as ReadAccess 
				 FROM tblrolescreens rs
				INNER JOIN tblscreenmaster sm ON sm.Screenid = rs.Screenid
				INNER JOIN tblrolemaster rm ON rm.RoleID = rs.RoleID 
				WHERE ScreenPage2 = '" . $page_content ."'  AND RoleName = '" . $_SESSION["usertype"] . "'
				AND ReadAccess = 'Yes'";
				//ReadAccess = 'Yes' AND 
		//echo $query . "<br/>";
		//die;
		//echo $_SESSION["usertype"]. "<br/>";
		$result = $mysqli->query( $query );
		$num_results = $result->num_rows;
		//echo $num_results;
		//die;
		if( $num_results ){
			while( $row = $result->fetch_assoc() ){
				extract($row);
				//good to go
				$_SESSION["ReadAccess"] = $ReadAccess;
				$_SESSION["WriteAccess"] = $WriteAccess;
				break;
			}
		}
		else{
			header('Location: login.php');
		}
	}	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head runat="server">
       <meta charset="utf-8" />
       <title>College Online</title>
       <meta content="width=device-width, initial-scale=1.0" name="viewport" />
       <meta content="" name="description" />
       <meta content="Mosaddek" name="author" />
       <link href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
       <link href="assets/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" />
       <link href="assets/bootstrap/css/bootstrap-fileupload.css" rel="stylesheet" />
       <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
       <link href="css/style.css" rel="stylesheet" />
       <link href="css/style-responsive.css" rel="stylesheet" />
       <link href="css/style-default.css" rel="stylesheet" id="style_color" />
    <link href="assets/fancybox/source/jquery.fancybox.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="assets/uniform/css/uniform.default.css" />

       <link href="assets/fullcalendar/fullcalendar/bootstrap-fullcalendar.css" rel="stylesheet" />
       <link href="assets/jquery-easy-pie-chart/jquery.easy-pie-chart.css" rel="stylesheet" type="text/css" media="screen"/>
       <link href="assets/dropzone/css/dropzone.css" rel="stylesheet"/>
       <link href='css/googlefonts.css' rel='stylesheet' type='text/css'>

	   <link rel="stylesheet" href="css/jquery-ui.css">
	   <script src="js/jquery-1.10.2.js"></script>
       <script src="js/jquery-ui.js"></script>

	   	<!--Requirement jQuery-->
	<script type="text/javascript" src="js/jquery.min.js"></script>
	<!--Load Script and Stylesheet -->
	<script type="text/javascript" src="js/jquery.simple-dtpicker.js"></script>
	<link type="text/css" href="css/jquery.simple-dtpicker.css" rel="stylesheet" />
	<!---->

	   <script type="text/javascript">

		function setPushState() {
				window.history.pushState('forward', null, null);
			}

			jQuery(document).ready(function ($) {
				$(window).on('popstate', function () {
					setPushState();
				});

				if (window.history && window.history.pushState)
					setPushState();
			}); 

		</script>

	</head>
<body>
   <!-- BEGIN HEADER -->
   <div id="header" class="navbar navbar-inverse navbar-fixed-top" >
       <!-- BEGIN TOP NAVIGATION BAR -->
       <div class="navbar-inner">
           <div class="container-fluid">
               <div class="top-nav ">
					 <ul class="nav pull-left top-menu" style="margin-top:10px" >
						<span class="username"><?php if(!isset($_SESSION)){
									session_start();
								}
							echo $_SESSION["SESSUserDept"]; ?>
						</span>
					 </ul>
                   <ul class="nav pull-right top-menu" >
                       <li class="dropdown">
                           <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                               <span class="username"><?php if(!isset($_SESSION)){
									session_start();
								}
							echo $_SESSION["SESSusername"]; ?></span>
                               <b class="caret"></b>
                           </a>
                           <ul class="dropdown-menu extended logout">
                               <li><a href="login.php"><i class="icon-key"></i> Log Out</a></li>
                               <li><a href="changepassword.php"><i class="icon-key"></i> Change Password</a></li>
                           </ul>
                       </li>
                   </ul>
               </div>
           </div>
       </div>
       <!-- END TOP NAVIGATION BAR -->
   </div>
   <!-- END HEADER -->

    <div id="container" class="row-fluid" >
      <!-- BEGIN PAGE -->  
		<div id="main-content" class="r_contant">
        <!-- BEGIN PAGE CONTAINER-->
			<div class="container-fluid" style="margin-top:10px">
				<?php include($page_content);?>
			</div>
        <!-- END PAGE CONTAINER-->
		</div>
      <!-- END PAGE -->  
   </div>
   <!-- END CONTAINER -->

   <div id="footer">
     <div class="row-fluid">
     	<div class="span10">
        	<ul class="f_sec">
                <li>©2016 OK Infosolutions</li>
            </ul>
        </div>
     </div>
   </div>

        <script src="js/jquery.nicescroll.js" type="text/javascript"></script>
        <script type="text/javascript" src="assets/jquery-slimscroll/jquery-ui-1.9.2.custom.min.js"></script>
        <script type="text/javascript" src="assets/jquery-slimscroll/jquery.slimscroll.min.js"></script>
        <script src="assets/bootstrap/js/bootstrap.min.js"></script>
		<script src="assets/bootstrap-wizard/jquery.bootstrap.wizard.min.js"></script>
        <script src="js/jquery.blockui.js"></script>
		   <!-- ie8 fixes -->
		   <!--[if lt IE 9]>
		   <script src="js/excanvas.js"></script>
		   <script src="js/respond.js"></script>
		   <![endif]-->
		<script src="assets/jquery-easy-pie-chart/jquery.easy-pie-chart.js" type="text/javascript"></script>
		   <script type="text/javascript" src="assets/chosen-bootstrap/chosen/chosen.jquery.min.js"></script>
		   <script type="text/javascript" src="assets/uniform/jquery.uniform.min.js"></script>
        <script src="js/jquery.scrollTo.min.js"  type="text/javascript"></script>
   <script src="js/form-wizard.js"  type="text/javascript"></script>

    
</body>
</html>
