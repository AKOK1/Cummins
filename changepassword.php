<html xmlns="http://www.w3.org/1999/xhtml">
<head runat="server">
   <meta charset="utf-8" />
   <title>Change Password</title>
   <meta content="width=device-width, initial-scale=1.0" name="viewport" />
   <meta content="" name="description" />
   <meta content="" name="author" />
   <link href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
   <link href="assets/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" />
   <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
   <link href="css/style.css" rel="stylesheet" />
   <link href="css/style-responsive.css" rel="stylesheet" />
   <link href="css/style-default.css" rel="stylesheet" id="style_color" />
   
</head>

<body class="lock">
    <form action="changepassword.php" method="post">
        <label name="lblError"></label>
		<?php 
					if(!isset($_SESSION)){
						session_start();
					} 
					//echo $_SESSION["loginid"];
					?>
        <div class="lock-header">
            
                <img class="center" alt="logo" src="images/logo.png">
				<br/><br/><br/>
				<h1>College Online - Change Password Screen</h1>
				<h3>Change Password for: <?php echo $_SESSION["SESSusername"]; ?></h3>
            
        </div>
        <div class="login-wrap" style="margin-bottom:-50px;width:70%">
		<?php
			if (isset($_POST['btnChange']))
			{
				if(($_POST['txtPasswordNew'] != $_POST['txtPasswordConfirm']) or ($_POST['txtPasswordNew'] == '')
					or ($_POST['txtPasswordConfirm'] == '') or ($_POST['txtCurPass'] == ''))
				{							
					echo "<h4 style='color:Red;font-size:x-large'>Either Current Password is incorrect or New and Confirm passwords do not match.</h4>";
				}
				elseif($_POST['txtPasswordNew'] == 'ccoew123')
				{
					echo "<h4 style='color:Red;font-size:x-large'>Old Password can not be reused. Please enter new Password.</h4>";

				}
				else
				{
					if(!isset($_SESSION)){
						session_start();
					}
					$mypass = '';
					$myemail = '';
					include 'db/db_connect.php';
					//decide if its a std or faculty
					$mystring = $_SESSION["loginid"];
					$findme   = '@';
					$pos = strpos($mystring, $findme);
					if ($pos === false) {
						//this is a std!
							$sql = "update tblstudent set stdpass  = '" . $_POST['txtPasswordNew'] . "' 
							where StdId = " . $_SESSION["SESSUserID"] . " and stdpass = '" .$_POST['txtCurPass']. "'";
					} else {
						//this is a faculty!
						$sql = "update tbluser set userpassword  = '" . $_POST['txtPasswordNew'] . "' 
							where userID = " . $_SESSION["SESSUserID"] . " and userpassword = '" .$_POST['txtCurPass']. "'";
					}	
					//echo $sql;
					$stmt = $mysqli->prepare($sql);
					if($stmt->execute()){
								echo "<h4 style='color:Green;font-size:x-large'>Password changed successfully! <a href='login.php'>Click here</a> to login.</h4>";
								session_unset();
								echo "<script type='text/javascript'>
									document.getElementById('divChangePassMain').style.display = 'none';
								}
								</script>";
								return;
								//header('Location: login.php'); 
					}
					else {
								echo "<h4 style='color:Red;font-size:x-large'>Sorry! There was an error. Please contact admin.</h4>";
								return;
					}					
					//disconnect from database
					$mysqli->close();					
				}
			}
		?>
			<div id="divChangePassMain" style="display:block">
				<div class="metro double-size green">
					<div class="input-append lock-input" style="margin-top:40px"><center><span>Current Password</span></center>
						<input type="password" name="txtCurPass" required/>
					</div>
				</div>
				<div class="metro double-size yellow">
					<div class="input-append lock-input" style="margin-top:40px"><center><span>New Password</span></center>
						<input type="password" name="txtPasswordNew" required/>
					</div>
				</div>
				<div class="metro double-size yellow">
					<div class="input-append lock-input" style="margin-top:40px"><center><span>Confirm Password</span></center>
						<input type="password" name="txtPasswordConfirm" required/>
					</div>
				</div>
				<div class="metro single-size terques login">
					<input type='submit' class='btn login-btn' name='btnChange' value='Change' />
				  <!-- <a class='btn login-btn' name='btnlogin' ><i class=" icon-long-arrow-right"></i>Login</a>  -->
				</div>
			</div>
        </div>
    </form>
</body>
</html>
