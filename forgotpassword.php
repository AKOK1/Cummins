<html xmlns="http://www.w3.org/1999/xhtml">
<body class="lock">
<head runat="server">
   <meta charset="utf-8" />
   <title>Forgot Password</title>
   <meta content="width=device-width, initial-scale=1.0" name="viewport" />
   <meta content="" name="description" />
   <meta content="" name="author" />
   <link href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
   <link href="assets/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" />
   <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
   <link href="css/style.css" rel="stylesheet" />
   <link href="css/style-responsive.css" rel="stylesheet" />
   <link href="css/style-default.css" rel="stylesheet" id="style_color" />
   <style type="text/css">
      #loadingmsg {
      color: black;
      background: #fff; 
      padding: 10px;
      position: fixed;
      top: 50%;
      left: 50%;
      z-index: 100;
      margin-right: -25%;
      margin-bottom: -25%;
      }
      #loadingover {
      background: black;
      z-index: 99;
      width: 100%;
      height: 100%;
      position: fixed;
      top: 0;
      left: 0;
      -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=80)";
      filter: alpha(opacity=80);
      -moz-opacity: 0.8;
      -khtml-opacity: 0.8;
      opacity: 0.8;
    }
</style>
	 <script type="text/javascript">     
	 function showLoading() {
		document.getElementById('loadingmsg').style.display = 'block';
		document.getElementById('loadingover').style.display = 'block';
	}
	</script>
</head>


<div id='loadingmsg' style='display: none;'>Please wait...</div>
<div id='loadingover' style='display: none;'></div>
    <form action="forgotpassword.php" method="post" onsubmit='showLoading();'>
        <label name="lblError"></label>
        <div class="lock-header">
            <a class="center" id="logo" href="#">
                <img class="center" alt="logo" src="images/logo.png">
				<br/><br/><br/>
				<h1>College Online - Forgot Password Screen</h1>
            </a>
        </div>
        <div class="login-wrap" style="margin-bottom:-50px;width:71%">
		<?php
			if (isset($_POST['btnChange']))
			{
				if($_POST['txtUsername'] == ''){
					echo "<h4 style='color:Red;font-size:x-large'>Please Enter your User ID.</h4>";
				}
				else{
					$mypass = '';
					$myemail = '';
					include 'db/db_connect.php';
					//decide if its a std or faculty
					$mystring = $_POST['txtUsername'];
					$findme   = '@';
					$pos = strpos($mystring, $findme);
					if ($pos === false) {
						//this is a std!
						$sql = "SELECT  stdpass as userpassword,coalesce(Pmail,'') as Pmail FROM tblstudent WHERE CNUM = '" . $_POST['txtUsername'] . "' limit 1";
					} else {
						//this is a faculty!
						$sql = "SELECT  userpassword,email as Pmail FROM tbluser WHERE email = '" . $_POST['txtUsername'] . "' limit 1";
					}				
					$result = $mysqli->query( $sql );
					$num_results = $result->num_rows;
					if( $num_results ){
						while( $row = $result->fetch_assoc() ){
							extract($row);
							$mypass = "{$userpassword}";	
							$myemail = "{$Pmail}";
						}
						if($myemail == ''){
							echo "<h4 style='color:Red;font-size:x-large'>Your College Email not found. Please contact admin @25311444.</h4>";
						}
						else{
							//$to      = $_POST['txtUsername'];
							$to      = $myemail;
							//$to      = 'mandaroak@yahoo.com';
							$subject = "Your College Online Password";
							$message = "Hello, Your CCOEW College Online password is: " . $mypass . "";
							 $headers = 'From: exam@cumminscollege.in' . "\r\n" .
								 'Reply-To: exam@cumminscollege.in' . "\r\n" .
								 'X-Mailer: PHP/' . phpversion();
							mail($to, $subject, $message, $headers);						
							header('Location: login.php');					
						}					
					}
					else{
						echo "<h4 style='color:Red;font-size:x-large'>Invalid User ID.</h4>";
					}
				}
				
				
			}
		?>
			<div class="metro double-size green" style="margin-left:250px">
				<div class="input-append lock-input" style="margin-top:20px"><center><span>Enter Your User ID <br/><h4>(Faculty - Email / Student - CNUM)</h4></span></center>
					<input style="width:290px" type="text" name="txtUsername"/>
				</div>
			</div>
			<div class="metro double-size terques login">
				<input type='submit' class='btn login-btn' name='btnChange' value='Email Me My Password' />
			  <!-- <a class='btn login-btn' name='btnlogin' ><i class=" icon-long-arrow-right"></i>Login</a>  -->
			</div>
            <div class="login-footer">
                <div class="forgot-hint">
                    <a id="forget-password" class="" href="login.php">Back to Login</a>
                </div>
            </div>
        </div>
    </form>
</body>
</html>
