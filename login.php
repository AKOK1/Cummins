<html xmlns="http://www.w3.org/1999/xhtml">
<head runat="server">
   <meta charset="utf-8" />
   <title>Login</title>
   <meta content="width=device-width, initial-scale=1.0" name="viewport" />
   <meta content="" name="description" />
   <meta content="" name="author" />
   <link href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
   <link href="assets/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" />
   <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
   <link href="css/style.css" rel="stylesheet" />
   <link href="css/style-responsive.css" rel="stylesheet" />
   <link href="css/style-default.css" rel="stylesheet" id="style_color" />
	<script type="text/javascript" src="js/jquery.min.js"></script>
   
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



<body class="lock">
    <form action="login.php" method="post">
        <label name="lblError"></label>
        <div class="lock-header">
            <a class="center" id="logo" href="#">
                <img class="center" alt="logo" src="images/logo.png">
				<br/><br/><br/>
				<h1>College Online</h1>
            </a>
<h3 style="color:red;font-bold:true">
Important Notice: <br/></h3>
<!--  for First Year Students -->
<h4 style="color:black;font-bold:true;margin-top:-10px">

**For query related to form filling and display of result contact 25311123
<br/>
**For reset password contact 25311444

<!-- If you forgot your C-Number or Do not know it or getting error after using C-Number as userid and password, <br/>then use your Application id starting with EN16 in both the fields of userid and password, and you will see your C-Number.<br/>

If the problem still persists call 020-25311444.

Kindly change your password after your first login. -->
				</h4>
        </div>
        <div class="login-wrap" style="margin-bottom:-50px;margin-top:0px">
		<?php
			
			if (isset($_POST['btnlogin']))
			{
				if(($_POST['txtUsername'] == '') or ($_POST['txtPassword'] == '')){
					echo "<h4 style='color:Red;font-size:x-large'>Login failed. Invalid username and/or password.</h4>";
				}
				else
				{
					include 'db/db_connect.php';
					$sql = "SELECT  count(*) as UsrCnt, userType, userID,username,Department FROM vwauth 
							WHERE usertext = '" . $_POST['txtUsername'] . "' and userpassword  = '" . $_POST['txtPassword'] . "'"  	 ;
					//echo $sql;
					$result = $mysqli->query( $sql );
					$num_results = $result->num_rows;
					
					if( $num_results ){
						while( $row = $result->fetch_assoc() ){
							extract($row);
							//echo $UsrCnt;
							if ( $UsrCnt > 0 )  {
								if(!isset($_SESSION)){
									session_start();
								}
								session_unset();
								$_SESSION["authenticated"] = 'true';
								$_SESSION["SESSUserID"] = "{$userID}";
								$_SESSION["SESSStdId"] = "{$userID}";
								$_SESSION["SESSusername"] = "{$username}";
								$_SESSION["loginid"] = $_POST['txtUsername'];
								$_SESSION["SESSUserDept"] = "{$Department}";
								if($_POST['txtUsername'] == 'sa')
									$_SESSION["usertype"] = "SuperAdmin";
								else
									$_SESSION["usertype"] = "{$userType}";
								//echo $_SESSION["SESSUserID"];
								//die;
								if(($_POST['txtPassword'] == 'ccoew123')){
									echo '<script language="javascript">';
									echo 'alert("Please change your password.");';
									echo 'window.location= "changepassword.php";';
									echo '</script>';
								}
								else{
									header('Location: MainMenuMain.php?'); 				
								}
								/*
								if ( ($userType == 'Admin') || ($userType == 'ExamAdmin')){
									header('Location: MainMenuMain.php?'); 				
								}
								elseif (($userType == 'Regular') or ($userType == 'Ad-hoc')) {
									header('Location: ProfMain.php?'); 						
								}
								elseif ($userType == 'Peon'){
									header('Location: login.php?'); 						
								}
								else {
									// get stdid from student table and save in session!
									$sql = "SELECT  StdId FROM tblstudent WHERE CNUM = '" . $_POST['txtUsername'] . "'";
									echo $sql;
									$result = $mysqli->query( $sql );
									$num_results = $result->num_rows;

									if( $num_results ){
										while( $row = $result->fetch_assoc() ){
											extract($row);
											$_SESSION["SESSStdId"] = "{$StdId}";
										}
									}
									
									header('Location: StudentMain.php?'); 						
								}
								*/
							}
							else {
								//check if user is trying app id!
								include 'db/db_connect.php';
								$sql9 = "SELECT CNUM FROM tblstudent WHERE appid = '" . $_POST['txtUsername'] . "'";
								$result9 = $mysqli->query( $sql9 );
								$num_results9 = $result9->num_rows;
								if($num_results9 ){
									while( $row9 = $result9->fetch_assoc() ){
										extract($row9);
									}
									echo "<h4 style='color:Green;font-size:x-large'>Use {$CNUM} as your Username and password. Please call ext. 020-25311444 in case of queries.</h4>";
								}
								else{
									echo "<h4 style='color:Red;font-size:x-large'>Login failed. Invalid username and/or password. Please call ext. 020-25311444</h4>";
								}
							}
/*
							else {
								echo "<h4 style='color:Red;font-size:x-large'>Login failed. Invalid username and/or password. Please call 020-25311444</h4>";
//<a target='_blank' href='https://docs.google.com/a/cumminscollege.in/forms/d/1GjFAEMcBL1l8cVeWwWv2zqG6GkEAMmITyd3iV-xFvGk/viewform'>Click here</a> to log the issue.
							}
*/
						}
					}	
											
					//disconnect from database
					$result->free();
					$mysqli->close();
				}
				
			}
		?>
			<div class="metro single-size red">
				<div class="locked">
					<i class="icon-lock"></i>
					<span>Login</span>
				</div>
			</div>
			<div class="metro double-size green">
				<div class="input-append lock-input">
					<input type="text" name="txtUsername"/>
				</div>
			</div>
			<div class="metro double-size yellow">
				<div class="input-append lock-input">
					<input type="password" name="txtPassword"/>
				</div>
			</div>
			<div class="metro single-size terques login">
				<input type='submit' class='btn login-btn' name='btnlogin' value='Login' />
			  <!-- <a class='btn login-btn' name='btnlogin' ><i class=" icon-long-arrow-right"></i>Login</a>  -->
			</div>
            <div class="login-footer">
                <div class="forgot-hint pull-right">
                    <a id="forget-password" class="" href="forgotpassword.php">Forgot Password?</a>
                </div>
            </div>
        </div>
    </form>
</body>
</html>
