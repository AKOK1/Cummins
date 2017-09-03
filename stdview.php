<?php
if(!isset($_SESSION)){
	session_start();
}

IF(!isset($_SESSION["SESSStdId"]))
	header('Location: login.php?'); 

	$edit_record1=$_SESSION["SESSStdId"];

	//-------------------	for rollno(tblstdadm) ---------------------------------------------------------
	include 'db/db_connect.php';
	$sql = 'SELECT EduYearFrom, EduYearTo FROM tblcuryear WHERE EduYearTo = (SELECT MAX(EduYearTo) FROM tblcuryear)';
	//echo $sql;
	$result = $mysqli->query( $sql );
	$num_results = $result->num_rows;
	if( $num_results ){
		while( $row = $result->fetch_assoc() ){
			extract($row);
		}
	}
	$query13="SELECT RollNo,Dept,Year,`Div`,shift,ESNum as seatnonew FROM tblstdadm WHERE EduYearFrom = '$EduYearFrom' and EduYearTo = '$EduYearTo' and StdID='$edit_record1'";
	//echo $query13;
	$run=mysqli_query($mysqli,$query13);
	while($row=mysqli_fetch_array($run))
	{
		extract($row);
		$divn = $Div;
		$deptdb = $Dept;
		$curstdyear = $Year;
	}
	//echo $RollNo;
	$query14="SELECT Dept FROM tblstudent WHERE StdId='$edit_record'";
	//echo $query14;
	$run=mysqli_query($mysqli,$query14);
	while($row=mysqli_fetch_array($run))
	{
		extract($row);
	}
	//-----------------------------------------------------------------------------------------------


include 'db/db_connect.php';
if(isset($_POST['update1']) || isset($_POST['update2']) || isset($_POST['update3']) || isset($_POST['update4']) || isset($_POST['update5'])){
	$stu_name=addslashes($_POST['Surname']);
	$fir_name=addslashes($_POST['First_Name']);
	$far_name=addslashes($_POST['Father_Name']);
	// $dept_name=addslashes($_POST['dept_name']);
	$mar_name=addslashes($_POST['mother_name']);
	$tal=$_POST['tal_uka'];
	$dist=$_POST['dist'];
	$sta=$_POST['sta_te'];
	
	if(!isset($_POST['blood_grp']))
		$blodg = $_SESSION["bg"];
	else
		$blodg=$_POST['blood_grp'];

	$mot=addslashes($_POST['mother_tongue']);
	$na=$_POST['nationality'];
	$re=addslashes($_POST['religion']);
	//$cs=$_POST['caste'];
	
	if(!isset($_POST['caste']))
		$cs = $_SESSION["cas"];
	else
		$cs = $_POST['caste'];
	
	$mu=$_POST['married_unmarried'];
	$sm=$_POST['Stu_Mobile'];	
	$se=$_POST['stu_email'];
	//$lc=$_POST['last_college'];
	$lc="";
	
	
	$fena= addslashes($_POST['fe_name']);
	$feye=$_POST['fe_year'];
	$femobta=$_POST['fe_mobt'];
	$femouto=$_POST['fe_mout'];
	$fecl=$_POST['fe_class'];

	
	$dipna= addslashes($_POST['dip_name']);
	$dipye=$_POST['dip_year'];
	$dipmobta=$_POST['dip_mobt'];
	$dipmouto=$_POST['dip_mout'];
	$dipcl=$_POST['dip_class'];
	//$dipexam=$_POST['dip_exam'];
	
	if(!isset($_POST['dip_exam']))
		$dipexam = $_SESSION["dip_exam"];
	else
		$dipexam = $_POST['dip_exam'];
	
	
 	$pn=$_POST['par_n'];	
	$padd=addslashes($_POST['par_add']);
	$ptal=addslashes($_POST['par_tal']);
	$pdist=addslashes($_POST['par_dist']);
	$pstate=addslashes($_POST['par_state']);
	$pincod=$_POST['p_in'];
	$ptele=$_POST['par_tele'];
	$pmob=$_POST['par_mob'];
	$fincome=$_POST['f_income'];
	$mincome=$_POST['m_income'];
	$orgn=$_POST['org_n'];
	$orgadd=addslashes($_POST['org_add']);
	$orgtele=$_POST['org_tele'];
	$orgmob=$_POST['org_mob'];
	$lgn=$_POST['lg_n'];
	$lgadd=addslashes($_POST['lg_add']);
	$lgtele=$_POST['lg_tele'];
	$lgmob=$_POST['lg_mob'];
	$hname=addslashes($_POST['h_name']);
	$hadd=addslashes($_POST['h_add']);
	$htele=$_POST['h_tele'];
	$deta=trim($_POST['d_et']);
	$dobb=$_POST['d_ob'];
	$pm=$_POST['Pmail'] . "@cumminscollege.in";
	$Rel=$_POST['Rel'];

	$d_doa=$_POST['d_doa']; 
	$txtpandc= $_POST['txtpandc'];
	$txtnamefortransfer= $_POST['txtnamefortransfer'];
	$txtpob= $_POST['txtpob'];
	
	$d_dol= $_POST['d_dol'];
	$txtreasonofleaving= $_POST['txtreasonofleaving'];
	$txtleavingremarks= $_POST['txtleavingremarks'];
	$txtregisterno= $_POST['txtregisterno'];

	$txtcastesubcaste= $_POST['txtcastesubcaste'];
	$txtaadharno= $_POST['txtaadharno'];

	$txtbonapurpose= $_POST['txtbonapurpose'];

	//$uniprn=$_POST['uniprn'];
	//$aicteno=$_POST['aicteno'];
	//$unieli=$_POST['unieli'];
	//$dteid=$_POST['dteid'];
	//$seatno=$_POST['seatno'];
	
	if(isset($_SESSION["SESSFrom"]) && ($_SESSION["SESSFrom"] == "fromadmin")) 
	{
		$stdpass=$_POST['stdpass'];
		$cnum=$_POST['cnum'];
		$uniprn=$_POST['uniprn'];
		$RollNo=$_POST['RollNo'];
		
		//$aicteno=$_POST['aicteno'];
		$unieli=$_POST['unieli'];
		$dteid=$_POST['dteid'];
		//$seatno=$_POST['seatno'];

		$divn=$_POST['txtdivn'];
		$shift=$_POST['txtshift'];
		$mdeptid=$_POST['ddldept'];
		$lbldeptname = $_POST['ddldept_hidden'];
		}
	else{
		$cnum=$_POST['lblcnum'];
		$uniprn=$_POST['lbluniprn'];
		$RollNo=$_POST['lblrollno'];
		//$Year=$_POST['lblyear'];
		$divisn=$_POST['lbldivision'];
		//$aicteno=$_POST['lblaicteno'];
		$unieli=$_POST['lblunieli'];
		$dteid=$_POST['lbldteid'];
		
		$seatno=$_POST['lblseatno'];

		$divn=$_POST['lbldivn'];
		$shift=$_POST['lblshift'];
		}
	//-------------------	for rollno(tblstdadm)
	if(isset($_SESSION["SESSFrom"]) && ($_SESSION["SESSFrom"] == "fromadmin")) 
	{
			include 'db/db_connect.php';
			$sql = 'SELECT EduYearFrom, EduYearTo FROM tblcuryear WHERE EduYearTo = (SELECT MAX(EduYearTo) FROM tblcuryear)';
			//echo $sql;
			$result = $mysqli->query( $sql );
			$num_results = $result->num_rows;
			if( $num_results ){
				while( $row = $result->fetch_assoc() ){
					extract($row);
				}
			}
			include 'db/db_connect.php';
			if(isset($_SESSION["SESSFrom"]) && ($_SESSION["SESSFrom"] == "fromadmin") && ($mdeptid <> '')) {
				$query12="update tblstdadm set RollNo='$RollNo',`div`='$divn',Shift='$shift',dept='$mdeptid' where EduYearFrom = '$EduYearFrom' and EduYearTo = '$EduYearTo' and StdID='$edit_record1' ";	
			}
			else{
				$query12="update tblstdadm set RollNo='$RollNo',`div`='$divn',Shift='$shift' where EduYearFrom = '$EduYearFrom' and EduYearTo = '$EduYearTo' and StdID='$edit_record1' ";	
			}
			if($mdeptid <> ''){
				$deptdb = $mdeptid;
			}

			//echo $mdeptid;
			//echo $query12;
			mysqli_query($mysqli, $query12);
			//-------------------	
	}

	//,cnum='$cnum'

	
	
	$query1="update tblstudent 
	set Surname='$stu_name',
	FirstName='$fir_name',FatherName='$far_name',MotherName='$mar_name',Taluka='$tal',District='$dist',State='$sta',Blood_group='$blodg',Mother_tongue='$mot',Nationality='$na',Religion='$re',Caste_subcaste='$cs',Status='$mu',Mobno='$sm',Email_id='$se',Lastattended='$lc',parent_name='$pn',parent_address='$padd' ,parent_taluka='$ptal' ,parent_district='$pdist' ,parent_state='$pstate' ,pincode='$pincod' ,parent_telephone='$ptele' ,parent_mobile='$pmob' ,father_income='$fincome' ,mother_income='$mincome' ,org_name='$orgn' ,org_address='$orgadd' ,org_telephone='$orgtele' ,org_mobile='$orgmob' ,lg_name='$lgn' ,lg_address='$lgadd' ,lg_telephone='$lgtele' ,lg_mobile='$lgmob' ,hostel_name='$hname' ,hostel_address='$hadd' ,hostel_telephone='$htele' ,details='$deta' ,DOB='$dobb',Pmail='$pm',Rel='$Rel',unieli='$unieli',appid='$dteid',uniprn='$uniprn'
	,seatno='$seatno', doa= '$d_doa',pandc= '$txtpandc',dol= '$d_dol',reasonofleaving= '$txtreasonofleaving',leavingremarks= '$txtleavingremarks', registerno = '$txtregisterno', castesubcaste= '$txtcastesubcaste', aadharno= '$txtaadharno',
	namefortransfer	= '$txtnamefortransfer', pob = '$txtpob', bonapurpose = '$txtbonapurpose' ";
	if(isset($_SESSION["SESSFrom"]) && ($_SESSION["SESSFrom"] == "fromadmin")) 
	{
		$query1 = $query1 . " ,stdpass='$stdpass' ";
	}
	//echo $curstdyear . "<br/>";
	if(isset($_SESSION["SESSFrom"]) && ($_SESSION["SESSFrom"] == "fromadmin") && ($lbldeptname <> '') && ($curstdyear <> 'F.E.')) 
	{
		$query1 = $query1 . " ,dept='$lbldeptname' ";
	}
	
	$query1 = $query1 . " where StdId='$edit_record1'";
	//echo $query1;
	mysqli_query($mysqli, $query1);

	// for QUAL
	$query2="update stdqual set
	name='$fena',EduYearStart='$feye',mobt='$femobta',mout='$femouto',class='$fecl' where StdId='$edit_record1' and Exam='10th'";
	mysqli_query($mysqli, $query2);
	$query4="update stdqual set
	name='$dipna',EduYearStart='$dipye',mobt='$dipmobta',mout='$dipmouto',class='$dipcl',Exam='$dipexam'  where StdId='$edit_record1' and Exam <> '10th'";
	mysqli_query($mysqli, $query4);
	// END  - FOR QUAL
	
	
	
	echo '<script>alert("UPDATED SUCCESSFULLY");</script>';

}
/*
if(isset($_POST['Confirm']))
{
	$edit_record1=$_SESSION["SESSStdId"];
	$query7="update tblstudent set CFLAG='1'
	 where StdId='$edit_record1'";	 
	mysqli_query($mysqli, $query7);
	
}
*/

//$edit_record =isset( $_GET['edit']) ? $_GET ['edit'] : $_GET ['edit_form'];
$edit_record = $_SESSION["SESSStdId"];


$query="SELECT StdId,Surname,FirstName,FatherName,MotherName,Taluka,District,State,Blood_group,
Mother_tongue,Nationality,Religion,Caste_subcaste,Status,Mobno,Email_id,Lastattended,parent_name,parent_address,
parent_taluka,parent_district,parent_state,pincode,parent_telephone,parent_mobile,
father_income,mother_income,org_name,org_address,org_telephone,org_mobile,lg_name,lg_address,lg_telephone,lg_mobile,hostel_name,
hostel_address,hostel_telephone,details,DOB,SUBSTRING(Pmail,1,LOCATE('@',Pmail)-1) as Pmail,Rel,CNUM,msname,stdpass,uniprn,unieli,appid as dteid,uniprn,aicteno,seatno,dept,coalesce(CFLAG,0) as CFLAG,
doa,coalesce(pandc,'GOOD') as pandc,dol,coalesce(reasonofleaving,'PASSED FINAL YEAR EXAM') as reasonofleaving,coalesce(leavingremarks,'COMPLETED THE COURSE SUCCESSFULLY') as leavingremarks,registerno,castesubcaste,aadharno,coalesce(namefortransfer,concat(Surname,' ', FirstName,' ', FatherName)) as namefortransfer,
coalesce(pob,concat(Taluka,' ',District)) as pob,coalesce(bonapurpose,'') as bonapurpose
FROM tblstudent WHERE StdId='$edit_record'";
//echo $query;
$run=mysqli_query($mysqli,$query);
//DATE_FORMAT(STR_TO_DATE(DOB,'%m/%d/%Y'), '%d-%b-%Y') as 

	$Stuname="";
	$Finame="";
	$Faname="";
	$Mname="";
	$Tal="";
	$Dis="";
	$stat="";
	$bg="";
	$mt="";
	$nat="";
	$reg="";
	$cas="";
	$sts="";
	$mb="";
	$email="";
	$lst="";
	$doa = "";
	$pandc = "";
	$dol = "";
	$reasonofleaving = "";
	$leavingremarks = "";
	$registerno = "";
	$castesubcaste= "";
	$aadharno= "";
	$namefortransfer = "";
	$pob = "";
	$bonapurpose = "";
	$parn="";
	$paradd="";
	$partal="";
	$pardist="";
	$parstate="";
	$pin="";
	$partele="";
	$parmob="";
	$fincome="";
	$mincome="";
	$orgn="";
	$orgadd="";
	$orgtele="";
	$orgmob="";
	$lgn="";
	$lgadd="";
	$lgtele="";
	$lgmob="";
	$hname="";
	$hadd="";
	$htele="";
	$det="";
	$dob="";
	$em="";
	$re="";
	$cnum="";
	$NameMark="";
	$stdpass = "";

	$unieli = "";
	$dteid = "";
	$uniprn = "";
	$aicteno = "";
	$seatno="";
	$deptname="";	
	$CFLAG="";
	
	
while($row=mysqli_fetch_array($run))
{
	
	$Stuname=$row[1];
	$Finame=$row[2];
	$Faname=$row[3];
	$Mname=$row[4];
	$Tal=$row[5];
	$Dis=$row[6];
	$stat=$row[7];
	$bg=$row[8];
	$_SESSION["bg"] = $bg;
	$mt=$row[9];
	$nat=$row[10];
	$reg=$row[11];
	$cas=$row[12];
	$_SESSION["cas"] = $cas;
	$sts=$row[13];
	$mb=$row[14];
	$email=$row[15];
	$lst=$row[16];
	
	$parn=$row[17];
	$paradd=$row[18];
	$partal=$row[19];
	$pardist=$row[20];
	$parstate=$row[21];
	$pin=$row[22];
	$partele=$row[23];
	$parmob=$row[24];
	$fincome=$row[25];
	$mincome=$row[26];
	$orgn=$row[27];
	$orgadd=$row[28];
	$orgtele=$row[29];
	$orgmob=$row[30];
	$lgn=$row[31];
	$lgadd=$row[32];
	$lgtele=$row[33];
	$lgmob=$row[34];
	$hname=$row[35];
	$hadd=$row[36];
	$htele=$row[37];
	$det=$row[38];
	$dob=$row[39];
	$em=$row[40];
	$re=$row[41];
	$cnum=$row[42];
	$NameMark=$row[43];
	$stdpass=$row[44];
	$uniprn = $row[45];
	$unieli = $row[46];
	$dteid = $row[47];
	$uniprn = $row[48];
	$aicteno = $row[49];
	$seatno=$row[50];
	$deptname=$row[51];
	$CFLAG=$row[52];
	$doa = $row[53];
	$pandc = $row[54];
	$dol = $row[55];
	$reasonofleaving = $row[56];
	$leavingremarks = $row[57];
	$registerno = $row[58];
	$castesubcaste= $row[59];
	$aadharno= $row[60];
	$namefortransfer= $row[61];
	$pob = $row[62];
	$bonapurpose = $row[63];
	}

	$sql = "SELECT Exam,name,mobt,mout,class,remark,EduYearStart FROM stdqual WHERE StdId='" . $_SESSION["SESSStdId"]. "'" ;
	//echo $sql;
	// execute the sql query
	$result = $mysqli->query( $sql );
	$num_results = $result->num_rows;
	$fd="";
	$sd="";
	$d="";
	if( $num_results ){
		while( $row = $result->fetch_assoc() ){
			extract($row);
			if($Exam=="10th")
			{
				$fen=$name;
				$femobt=$mobt;
				$femout=$mout;
				$fec=$class;
				$ferem=$remark;
				$feEduYearStart=$EduYearStart;
			}
			else
			{
				$dipn=$name;
				$dipmobt=$mobt;
				$dipmout=$mout;
				$dipc=$class;
				$diprem=$remark;
				$dEduYearStart=$EduYearStart;
				$dipexam=$Exam;
				$_SESSION["dip_exam"] = $dipexam;
			}
		}
	}			

		//-------------------	for dept and year ---------------------------------------------------------
		$sql3 = 'SELECT EduYearFrom, EduYearTo FROM tblcuryear WHERE EduYearTo = (SELECT MAX(EduYearTo) FROM tblcuryear)';
		//echo $sql3;
		$result3 = $mysqli->query( $sql3 );
		$num_results3 = $result3->num_rows;
		if( $num_results3 ){
			while( $row3 = $result3->fetch_assoc() ){
				extract($row3);
			}
		}
		$query4="SELECT DeptUnivName as DeptName,Year as DeptYear,DeptName as DeptNameShort FROM tblstdadm sa, tbldepartmentmaster DM 
					WHERE sa.Dept = DM.DeptID and
					EduYearFrom = '$EduYearFrom' 
					and EduYearTo = '$EduYearTo' and StdID=" . $_SESSION["SESSStdId"];
		//echo $query4;
		$result4=mysqli_query($mysqli,$query4);
		$num_results4 = $result4->num_rows;
		if( $num_results4 ){
			while( $row4 = $result4->fetch_assoc() ){
				extract($row4);
			}
		}


	
	//disconnect from database
	$result->free();
	$mysqli->close();
//--------------------
	
	
echo "<script type='text/javascript'>window.onload = function()
						{
								document.getElementById('lblSuccess').style.display = 'block';
						}
						</script>";

						
						//$('#tabsleft-tab2').load('http://localhost/cummins/stdviewmain.php');
?>

<form method='post' action='stdviewmain.php' enctype="multipart/form-data">
<head>
<script>
  $(document).ready(function() {
    $("#ddldept").change(function(){
      $("#ddldept_hidden").val($("#ddldept").find(":selected").text());
    });
  });
</script>

	<script>
				function removeattrall(){
					var inputs = document.getElementsByTagName('input');
					for(var i = 0; i < inputs.length; i++) {
						inputs[i].removeAttribute("required");
					}
					$('.DTEXDATE').removeAttr("required");
				}
				function setval4() {
					removeattrall();
				}
				function setval5() {
					removeattrall();
					document.getElementById("unieli").setAttribute("required", "required");
					document.getElementById("RollNo").setAttribute("required", "required");
					document.getElementById("Year").setAttribute("required", "required");
					document.getElementById("seatno").setAttribute("required", "required");
				}
				function setval7() {
					removeattrall();
					//$('.d_doa').attr('required','true');
					//$('.d_dol').attr('required','true');
					//document.getelementbyid("txtpandc").setattribute("required", "required");
					//document.getelementbyid("txtreasonofleaving").setattribute("required", "required");
					//document.getelementbyid("txtleavingremarks").setattribute("required", "required");
					//document.getelementbyid("txtnamefortransfer").setattribute("required", "required");
					//document.getelementbyid("txtpob").setattribute("required", "required");
				}
				function setval3() {
					removeattrall();
					document.getElementById("par_n").setAttribute("required", "required");
					document.getElementById("Rel").setAttribute("required", "required");
					document.getElementById("par_add").setAttribute("required", "required");
					document.getElementById("par_tal").setAttribute("required", "required");
					document.getElementById("par_dist").setAttribute("required", "required");
					document.getElementById("par_state").setAttribute("required", "required");
					document.getElementById("p_in").setAttribute("required", "required");
					document.getElementById("par_mob").setAttribute("required", "required");
				}
				function setval2() {
					removeattrall();
					document.getElementById("fe_name").setAttribute("required", "required");
					document.getElementById("fe_year").setAttribute("required", "required");
					document.getElementById("fe_mobt").setAttribute("required", "required");
					document.getElementById("fe_mout").setAttribute("required", "required");
					document.getElementById("fe_class").setAttribute("required", "required");
					document.getElementById("dip_name").setAttribute("required", "required");
					document.getElementById("dip_year").setAttribute("required", "required");
					document.getElementById("dip_mobt").setAttribute("required", "required");
					document.getElementById("dip_mout").setAttribute("required", "required");
					document.getElementById("dip_class").setAttribute("required", "required");
				}
				
				function setval1() {
					removeattrall();
					document.getElementById("First_Name").setAttribute("required", "required");
					document.getElementById("mother_name").setAttribute("required", "required");
					document.getElementById("nationality").setAttribute("required", "required");
					document.getElementById("religion").setAttribute("required", "required");
					document.getElementById("Stu_Mobile").setAttribute("required", "required");
					//document.getElementById("Pmail").setAttribute("required", "required");
					$('.d_ob').attr('required','true');
				}
				function confirmConfirm() {
				  if (confirm("Data can not be edited after confirmation. Are you sure you want to Confirm?")) {
				   return true;
				  }
				  else
					  return false;
				}
		$(function() {
		$('.DTEXDATE').each(function(i) {
		this.id = 'datepicker' + i;
		}).datepicker({ dateFormat: 'dd-M-yy' });
		$('.DTEXDATE').attr("required","required");
		//});
		//$( ".DTEXDATE" ).datepicker();
		//$(".DTEXDATE").each(function(){
		//	$(this).datepicker();
		//});
		});
	$(function() { 
		$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
			localStorage.setItem('myTab', $(this).attr('href'));
		});
		var myTab = localStorage.getItem('myTab');
		if (myTab) {
			$('[href="' + myTab + '"]').tab('show');
		}
	});
	function enable() {
		//alert("hi");
		 $("#ddldept").attr('disabled', false);
}
 

	</script>
</head>  
<br/><br/><br/>
   <!-- BEGIN CONTAINER -->
	<div id="container" class="row-fluid">
      <!-- BEGIN PAGE -->
		<div id="main-content">
         <!-- BEGIN PAGE CONTAINER-->
			<div class="container-fluid">
            <!-- BEGIN PAGE CONTENT-->
				<div class="row-fluid">
					<div class="span12">
					<center><b>Please click "Contact Us" on the right top of this page to report any issues that you may face with this form.</b></center>

						<div class="widget box purple">
							<div class="widget-title">
								<h4>
								<!--  <i class="icon-reorder"></i> STUDENT REGISTRATION</span> -->
								<div style="float:left">
									<i class="icon-reorder"></i> STUDENT REGISTRATION</span>
								</div>
								<div style="float:left">
									<table>
										<tr>
											<td>
												&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $cnum;?>
											</td>
											<td>
												&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $Stuname. " " . $Finame. " " . $Faname;?>
											</td>
											<td>
												&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $Year;?>
											</td>
											<td>
												&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $DeptNameShort;?>
											</td>
											<td>
												&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Div: <?php echo $Div;?>
											</td>
										</tr>
									</table>								
								</div>
								</h4>
								<div style="float:right;margin-right:15px;margin-top:8px">
									<?php 
									$stdname = $Stuname. " " . $Finame;

									if(isset($_SESSION["SESSFrom"]) && ($_SESSION["SESSFrom"] == "fromadmin")) {
										//echo "<a target='_blank' style='color:white' href='PrintStudent.php?stdid={$edit_record1}'>Print</a>"; 
										
									  echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<td><a class='btn btn-mini btn-primary' href='redirecting2.php?userID={$edit_record1}&fromadmin=fromadmin&cnum={$cnum}&stdname={$stdname}'><i class='icon-white'></i>Results</a> </td>";

									  echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<td><a class='btn btn-mini btn-primary' target='_blank' href='redirectingprint.php?userID={$edit_record1}&fromadmin=fromadmin&cnum={$cnum}&stdname={$stdname}'><i class='icon-white'></i>Print Form</a> </td>";

echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a style='color:white' href='StdListMain.php?selyear=" . $_SESSION["selyear"] . "&seldept=" . $_SESSION["seldept"] . "&selacadyear=" . $_SESSION["selacadyear"] . "'>Back</a>"; 
									}
									else{
echo "<a class='btn btn-mini btn-primary' target='_blank' href='PrintStudent.php'><i class='icon-white'></i>Print Form</a> ";
									echo "&nbsp;&nbsp;&nbsp;&nbsp;";
										echo "<a style='color:white' href='MainMenuMain.php'>Back</a>"; 
									}
									?>								
								</div>							</div>
<center><h4><b>Please enter all information in CAPITAL LETTERS.</b></h4></center>
							<div class="widget-body">
							 	<form class="form-horizontal" action="#">
									<div id="tabsleft" class="tabbable tabs-left">
										<ul class="nav nav-tabs" id="myTab">
											<li><a href="#tabsleft-tab1" id="persnldetails"  data-toggle="tab"> <span class="Strong">Personal Details</span></a></li>
											<li><a href="#tabsleft-tab2" id="qual"  data-toggle="tab"> <span class="Strong">Qualifications</span></a></li>
											<li><a href="#tabsleft-tab3" id="parentinfo" data-toggle="tab"> <span class="Strong">Parent Information</span></a></li>
											 <li><a href="#tabsleft-tab4" id="othr" data-toggle="tab"> <span class="Strong">Other Information</span></a></li>
										<!--	<li><a href="#tabsleft-tab5" data-toggle="tab"> <span class="Strong">Other Details</span></a></li>-->
										<li><a href="#tabsleft-tab6" id="num" data-toggle="tab"> <span class="Strong">My Numbers</span></a></li>
										<li><a href="#tabsleft-tab7" id="phs" data-toggle="tab"> <span class="Strong">My Photo</span></a></li>
										<?php
											if(isset($_SESSION["SESSFrom"]) && ($_SESSION["SESSFrom"] == "fromadmin")) {
												echo "<li><a href='#tabsleft-tab8' id='ts' data-toggle='tab'> <span class='Strong'>Transfer Cert</span></a></li>";
											}
										?>
										</ul>
									<div class="tab-content">
									<div class="tab-pane" id="tabsleft-tab1">
													<h3><b>Personal Details</b></h3>
													<div class="control-group">
														<div class="controls">
															<table>
																<tr>
																	<td ><label class="control-label">Surname</label></td>
																	<td > <label class="control-label">First Name*</label></td>
																	<td> <label class="control-label">Father's Name</label></td>
																	<td> <label class="control-label">Mother's Name*</label></td>
																</tr>
																<tr>
																	<?php 
																	if(isset($_SESSION["SESSFrom"]) && ($_SESSION["SESSFrom"] == "fromadmin")) 
																	{
																		
																		echo "<td><input type='text' name='Surname' type='text' pattern='[ A-ZA-z]{1,50}' style='width:150px' value='$Stuname' /></td>"; 
																	}
																	else 
																	{
																		echo"<td><input type='text' readonly name='Surname' pattern='[ A-ZA-z]{1,50}' value='$Stuname'></td>";
	
																	}	
																	if(isset($_SESSION["SESSFrom"]) && ($_SESSION["SESSFrom"] == "fromadmin")) 
																	{
																		
																		echo "<td><input type='text' name='First_Name' type='text' style='width:150px' pattern='[ A-ZA-z]{1,50}' value='$Finame' /></td>"; 
																	}
																	else
																	{
																		echo"<td><input type='text' readonly name='First_Name' pattern='[ A-ZA-z]{1,50}' value='$Finame'></td>";
	
																	}	
																	if(isset($_SESSION["SESSFrom"]) && ($_SESSION["SESSFrom"] == "fromadmin")) 
																	{
																		
																		echo "<td><input type='text' name='Father_Name' type='text' pattern='[ A-ZA-z]{1,50}' style='width:150px' value='$Faname' /></td>"; 
																	}
																	else
																	{
																		echo"<td><input type='text' readonly name='Father_Name' pattern='[ A-ZA-z]{1,50}' value='$Faname'></td>";
	
																	}																		
																?>
																	<td><input <?php if($CFLAG=='1'){echo "readonly";} ?> id='mother_name' name='mother_name' pattern="[ A-ZA-z]{1,50}" type="text"  style="width:150px"placeholder="Enter Mother Name" value='<?php echo $Mname; ?>'>   </td>
																</tr>
																<tr>
																	<td><label>Name As On Mark Sheet: </label></td>
																	<td colspan="3"><label><?php echo $NameMark; ?></label></td>
																</tr>
															</table>
														</div>
													</div>     
													<label class="control-label">Place of Birth</label>
													<div class="control-group">
														<div class="controls">
															<table>
																<tr>
																	<td><label class="control-label">Taluka</label></td>
																	<td> <label class="control-label">District</label></td>
																	<td> <label class="control-label">State</label></td>
																	<td> <label class="control-label">Date of Birth (DD-MON-YYYY)</label></td>
																</tr>
																<tr>
																	<td><input <?php if($CFLAG=='1'){echo "readonly";} ?> name='tal_uka' pattern="[ A-ZA-z]{1,50}"type="text"  style="width:150px" value='<?php echo $Tal; ?>'> </td>
																	<td><input <?php if($CFLAG=='1'){echo "readonly";} ?> name="dist"pattern="[ A-ZA-z]{1,50}" type="text" style="width:150px"  value='<?php echo $Dis; ?>'></td>
																	<td><input <?php if($CFLAG=='1'){echo "readonly";} ?> name="sta_te"pattern="[ A-ZA-z]{1,50}" type="text"   style="width:150px"value='<?php echo $stat; ?>'></td>
																	<td><input <?php if($CFLAG=='1'){echo "readonly";} ?> id="d_ob" name="d_ob"  class='span13 DTEXDATE d_ob' placeholder="DD-MON-YYYY" pattern="(^((31(?! (FEB|APR|JUN|SEP|NOV|Feb|Apr|Jun|Sep|Nov)))|((30|29)(?! FEB|Feb))|(29(?= FEB|Feb (((1[6-9]|[2-9]\d)(0[48]|[2468][048]|[13579][26])|((16|[2468][048]|[3579][26])00)))))|(0?[1-9])|1\d|2[0-8])-(JAN|FEB|MAR|MAY|APR|JUL|JUN|AUG|OCT|SEP|NOV|DEC|Jan|Feb|Mar|May|Apr|Jul|Jun|Aug|Oct|Sep|Nov|Dec)-((1[6-9]|[2-9]\d)\d{2})$)"   style="width:150px" type="text" value='<?php echo $dob; ?>'></td>
																	<!-- pattern="^[0-9]{2}-[a-zA-Z]{3}-[0-9]{4}$" -->
																</tr>
															</table>
														</div>
													</div>
													<div class="control-group">
														<div class="controls">
															<table>
																<tr>
																	<td><label class="control-label">Blood Group</label></td>
																	<td><label class="control-label">Mother Tongue</label></td>
																	<td><label class="control-label">Status</label></td>
																	<td><label class="control-label">Aadhar No.</label></td>
																</tr>
															<tr>
																<td>
																	<select <?php if($CFLAG=='1'){echo "disabled";} ?> name="blood_grp"  style="width:165px">
																		<option value="A positive"  style="width:150px"value='<?php echo $bg; ?>'
																		 <?php if($bg == 'A positive') echo 'selected' ?>
																		>A +ve</option>
																		<option value="A negative"  style="width:150px"value='<?php echo $bg; ?>'
																		<?php if($bg == 'A negative') echo 'selected' ?>
																		>A -ve</option>
																		<option value="B positive"  style="width:150px"value='<?php echo $bg; ?>'
																		 <?php if($bg == 'B positive') echo 'selected' ?>
																		>B +ve</option>
																		<option value="B negative"  style="width:150px"value='<?php echo $bg; ?>'
																		 <?php if($bg == 'B negative') echo 'selected' ?>
																		>B -ve</option>
																		<option value="O positive"  style="width:150px"value='<?php echo $bg; ?>'
																		 <?php if($bg == 'O positive') echo 'selected' ?>
																		>O +ve</option>
																		<option value="O negative"  style="width:150px"value='<?php echo $bg; ?>'
																		 <?php if($bg == 'O negative') echo 'selected' ?>
																		>O -ve</option>
																		<option value="AB positive"  style="width:150px"value='<?php echo $bg; ?>'
																		 <?php if($bg == 'AB positive') echo 'selected' ?>
																		>AB +ve</option>
																		<option value="AB negative"  style="width:150px"value='<?php echo $bg; ?>'
																		 <?php if($bg == 'AB negative') echo 'selected' ?>
																		>AB -ve</option>
																	</select>
																</td>
																<td><input <?php if($CFLAG=='1'){echo "readonly";} ?> name="mother_tongue" pattern="[ A-ZA-z]{1,50}"type="text" value='<?php echo $mt; ?>'></td>
																<td>
																	<select name="married_unmarried" style="width:150px"> 
																		<option value="Unmarried" style="width:150px"value='<?php echo $sts; ?>'
																		<?php if($sts == 'Unmarried') echo 'selected' ?>
																		>Unmarried</option>     
																		<option value="Married" style="width:150px"value='<?php echo $sts; ?>'
																		<?php if($sts == 'Married') echo 'selected' ?>
																		>Married</option>
																	</select>
																</td>
																<td><input <?php if($CFLAG=='1'){echo "readonly";} ?> name="txtaadharno" type="text" value='<?php echo $aadharno; ?>'></td>
															</tr>
															</table>
														</div>
													</div>        
													<div class="control-group">
														<div class="controls">
															<table>
																<tr>
																	<td><label class="control-label">Nationality*</label></td>
																	<td>   <label class="control-label">Religion*</label></td>
																	<td>  <label class="control-label">Category*</label></td>
																	<td>  <label class="control-label">Caste and Subcaste</label></td>
																</tr>
																<tr>
																	<td><input <?php if($CFLAG=='1'){echo "readonly";} ?> id="nationality" name="nationality" pattern="[ A-ZA-z]{1,50}"type="text" style="width:150px" value='<?php echo $nat; ?>'></td>
																	<td>   <input <?php if($CFLAG=='1'){echo "readonly";} ?> id="religion" name="religion" pattern="[ A-ZA-z]{1,50}" type="text" style="width:150px" value='<?php echo $reg; ?>'></td>
																	<td>
<?php if(isset($_SESSION["SESSFrom"]) && ($_SESSION["SESSFrom"] == "fromadmin")) { ?>
																		<select  name="caste" style="width:150px">
																			<option value="Open" value='<?php echo $cas; ?>'
																			<?php if($cas == 'Open') echo 'selected' ?>
																			>Open</option>
																			<option value="OBC" value='<?php echo $cas; ?>'
																			<?php if($cas == 'OBC') echo 'selected' ?>
																			>OBC</option> 
																			<option value="SC" value='<?php echo $cas; ?>'
																			<?php if($cas == 'SC') echo 'selected' ?>
																			>SC</option> 											
																			<option value="ST" value='<?php echo $cas; ?>'
																			<?php if($cas == 'ST') echo 'selected' ?>
																			>ST</option> 
																			<option value="VJA" value='<?php echo $cas; ?>'
																			<?php if($cas == 'VJA') echo 'selected' ?>
																			>VJA</option> 
																			<option value="NTB" value='<?php echo $cas; ?>'
																			<?php if($cas == 'NTB') echo 'selected' ?>
																			>NTB</option> 
																			<option value="NTC" value='<?php echo $cas; ?>'
																			<?php if($cas == 'NTC') echo 'selected' ?>
																			>NTC</option> 
																			<option value="NTD" value='<?php echo $cas; ?>'
																			<?php if($cas == 'NTD') echo 'selected' ?>
																			>NTD</option> 
																			<option value="SBC" value='<?php echo $cas; ?>'
																			<?php if($cas== 'SBC') echo 'selected' ?>
																			>SBC</option> 
																		</select>
<?php }
else { ?>
																		<select name="caste" style="width:150px">
																			<option value="Open" value='<?php echo $cas; ?>'
																			<?php if($cas == 'Open') echo 'selected' ?>
																			>Open</option>
																			<option value="OBC" value='<?php echo $cas; ?>'
																			<?php if($cas == 'OBC') echo 'selected' ?>
																			>OBC</option> 
																			<option value="SC" value='<?php echo $cas; ?>'
																			<?php if($cas == 'SC') echo 'selected' ?>
																			>SC</option> 											
																			<option value="ST" value='<?php echo $cas; ?>'
																			<?php if($cas == 'ST') echo 'selected' ?>
																			>ST</option> 
																			<option value="VJA" value='<?php echo $cas; ?>'
																			<?php if($cas == 'VJA') echo 'selected' ?>
																			>VJA</option> 
																			<option value="NTB" value='<?php echo $cas; ?>'
																			<?php if($cas == 'NTB') echo 'selected' ?>
																			>NTB</option> 
																			<option value="NTC" value='<?php echo $cas; ?>'
																			<?php if($cas == 'NTC') echo 'selected' ?>
																			>NTC</option> 
																			<option value="NTD" value='<?php echo $cas; ?>'
																			<?php if($cas == 'NTD') echo 'selected' ?>
																			>NTD</option> 
																			<option value="SBC" value='<?php echo $cas; ?>'
																			<?php if($cas== 'SBC') echo 'selected' ?>
																			>SBC</option> 
																		</select>
<?php } ?>
																	</td>
																	<td><input <?php if($CFLAG=='1'){echo "readonly";} ?> id="txtcastesubcaste" name="txtcastesubcaste" pattern="[ A-ZA-z]{1,50}"type="text" style="width:150px" value='<?php echo $castesubcaste; ?>'></td>
																</tr>
															</table>
														</div>
													</div>
													<div class="control-group"> 
														<div class="controls">
															<table>
																<tr>
																	<td><label class="control-label">Mobile Number*</label></td>
																	<td><label class="control-label"></label>Personal Email Id</td>
																	<td colspan="2"><label class="control-label">College Email Id</label></td>
																</tr>
																<tr>
																	<td> <input id="Stu_Mobile" name="Stu_Mobile" pattern="\d{10}$" style="width:150px" type="text"placeholder="Enter 10-digit Mobile Number " value='<?php echo $mb; ?>'></td>
																	<td><input id="stu_email" name="stu_email" pattern="(^\w+[\w-\.]*\@\w+?\x2E.+)" style="width:150px" type="text" placeholder="Enter Valid Email " value='<?php echo $email; ?>'></td>
																	<td><input  <?php if($CFLAG=='1'){echo "readonly";} ?> id="Pmail" name="Pmail" pattern="(^\w+[\w-\.]*)"  style="width:150px"type="text" placeholder="Enter Valid Email"  value='<?php echo $em; ?>'>
																	</td>
																	<td><label style="margin-top:-7px"><b>@cumminscollege.in</b></label></td>
																	</tr>
															</table>
														</div>
												   </div>
													<?php
														if(($_SESSION["ReadAccess"] == "Yes") && ($_SESSION["WriteAccess"] == "Yes")){
														 echo "<input onclick='setval1();' type='submit' name='update1' value='Save' />&nbsp;&nbsp;&nbsp;&nbsp;* Required fields.";
													 }
													 ?>
													<!-- <input onclick="setval1();" type='submit' name='update1' value='Save' />&nbsp;&nbsp;&nbsp;&nbsp;* Required fields.
													-->
												</div>                       
	<div class="tab-pane" id="tabsleft-tab2">
		<label class="control-label"><h3><b>Qualifications</b></h3></label>
		<div class="control-group">
			<table  class="inner"  width="25">
				<tr>
					 <td align="center"><b>Examination*&nbsp;&nbsp;&nbsp;&nbsp;</b></td>
					 <td align="center"><b>Name of Institution*</b></td>
					 <td align="center"><b>Year*</b></td>
					 <td align="center"><b>Marks Obtained*</b></td>
					 <td align="center"><b>Marks Out Of*</b></td>
					 <td align="center"><b>Class*</b></td>
				</tr>
				<tr> 
					 <td>10th</td>
					 <td>
						<input <?php if($CFLAG=='1'){echo "readonly";} ?> type='text' class='input-medium' id='fe_name' name='fe_name' size='20' value="<?php echo $fen;?>">
					 </td> 
					 <td>
						<input <?php if($CFLAG=='1'){echo "readonly";} ?> type='text' class='input-medium' name='fe_year' id='fe_year' value="<?php echo$feEduYearStart;?>">
					</td> 
					 <td>
						<input <?php if($CFLAG=='1'){echo "readonly";} ?> type='text' class='input-medium' id='fe_mobt' name='fe_mobt' value="<?php echo$femobt;?>">
					</td> 
					 <td>
						<input <?php if($CFLAG=='1'){echo "readonly";} ?> type='text' class='input-medium' id='fe_mout' name='fe_mout' value="<?php echo$femout;?>">
					</td> 
					 <td>
						<input <?php if($CFLAG=='1'){echo "readonly";} ?> type='text' class='input-medium' id='fe_class' name='fe_class' value="<?php echo$fec;?>">
					</td> 
				 </tr> 
				<tr> 
					<td>
						<select <?php if($CFLAG=='1'){echo "disabled";} ?> name="dip_exam"  style="width:150px"> 
							<option value="12th" <?php if($dipexam == '12th') echo 'selected=selected'; ?>  style="width:150px">12th</option>
							<option value="Diploma" <?php if($dipexam == 'Diploma') echo 'selected=selected'; ?> style="width:150px">Diploma</option>     
						</select>
					 </td>
					 <td>
						<input <?php if($CFLAG=='1'){echo "readonly";} ?> type='text' class='input-medium' id='dip_name' name='dip_name' size='20' value="<?php echo $dipn;?>">
					 </td> 
					 <td>
						<input <?php if($CFLAG=='1'){echo "readonly";} ?> type='text' class='input-medium' id='dip_year' name='dip_year' value="<?php echo$dEduYearStart;?>">
					 </td> 
					 <td>
						<input <?php if($CFLAG=='1'){echo "readonly";} ?> type='text' class='input-medium' id='dip_mobt' name='dip_mobt' value=" <?php echo$dipmobt;?>">
					 </td> 
					 <td>
						<input <?php if($CFLAG=='1'){echo "readonly";} ?> type='text' class='input-medium' id='dip_mout' name='dip_mout' value=" <?php echo$dipmout;?>">
					</td> 
					 <td>
						<input <?php if($CFLAG=='1'){echo "readonly";} ?> type='text' class='input-medium' id='dip_class' name='dip_class' value=" <?php echo$dipc;?>">
					</td> 
				</tr>
			</table>
		</div>
			<br/><br/>
			<?php
				if(($_SESSION["ReadAccess"] == "Yes") && ($_SESSION["WriteAccess"] == "Yes")){
				 echo "<input onclick='setval2();' type='submit' name='update2' value='Save' />&nbsp;&nbsp;&nbsp;&nbsp;* Required fields.";
			 }
			 ?>
			<!-- <input onclick="setval2();" type='submit' name='update2' value='Save' />&nbsp;&nbsp;&nbsp;&nbsp;* Required fields. -->
	</div>
								
								
								
						
									
                                    <div class="tab-pane" id="tabsleft-tab3">
                                       
										<label class="control-label"><h3><b>Parent Information</b></h3></label>                                     
									   
                                        <div class="control-group">
                                            <div class="controls">
											<table>
											<tr>
											<td> <label class="control-label">Full Name*</label></td>
											<td> <label class="control-label">Relation*</label></td>
											</tr>
											
											<tr>
											<td><input name='par_n' id='par_n' pattern="[ .A-ZA-z]{1,50}" type='text' style="width:150px" value="<?php echo $parn; ?>"></td>
											<td><input name='Rel' id='Rel' pattern="[ A-ZA-z]{1,50}"type='text'  style="width:150px"value="<?php echo $re; ?>"></td>
                                            </tr>
											</table>
                                             </div>
                                        </div>	
                                           
                                            
									   <div class="control-group">
                                            <div class="controls">
											
											<table>
											<tr>
											<td> <label class="control-label">Address*</label></td>
											</tr>
											
											<tr>
                                             <td><input  name='par_add' id='par_add' type='text' style ="width:800px" value="<?php echo $paradd; ?>" ></td>
                                              </tr>
											</table>	
											 </div>
                                        </div>	
                                                
                                           
										
                                        <div class="control-group">
                                            <div class="controls">
											
											<table>
											<tr>
											  <td> <label class="control-label">Taluka*</label></td>
											   <td> <label class="control-label">District*</label></td>
												<td><label class="control-label">State*</label></td>
												<td><label class="control-label">Pin Code*</label></td>
											 </tr>
											
											
											<tr>
											<td><input name="par_tal" id="par_tal" pattern="[ A-ZA-z]{1,50}"  style="width:150px" type="text" value="<?php echo $partal; ?>"></td>
											<td><input name='par_dist' id='par_dist' pattern="[ A-ZA-z]{1,50}" style="width:150px" type="text"value="<?php echo $pardist; ?>">   </td>
											 <td><input name='par_state' id='par_state' pattern="[ A-ZA-z]{1,50}" style="width:150px" type="text" value="<?php echo $parstate; ?>"> </td>
											 <td><input name="p_in" id="p_in" pattern="\d{6}$" type="text" style="width:150px" value="<?php echo $pin; ?>"></td>
											</tr>
											</table>
											</div>
                                          </div>  
										
                                            <div class="control-group">
												<div class="controls">
												<table>
												<tr>
												<td><label class="control-label">Telephone number</label></td>
												<td>   <label class="control-label">Mobile Number*</label></td>
												<td> <label class="control-label">Total Income Of Father</label></td>
												<td><label class="control-label">Total Income Of Mother</label></td>
												</tr>
												 
												
												<tr>
												<td><input name="par_tele" type="text"  style="width:150px" value="<?php echo $partele; ?>"></td>
												<td><input name="par_mob" id="par_mob" pattern="\d{10}$"type="text"  style="width:150px" placeholder="Enter 10-digit Mobile Number " value="<?php echo trim($parmob); ?>"> </td>
												<td><input name="f_income" type="text"  style="width:150px" value="<?php echo $fincome; ?>"> </td>
												 <td> <input name="m_income" type="text"  style="width:150px" value="<?php echo $mincome; ?>"> </td>
												</tr>
												</table>
												</div>
											</div>
										
											<label class="control-label"><h3><b>Organization Details of Parent</b></h3></label>
											<div class="control-group">
												<div class="controls">
											   <table>
											   <tr>
												<td> <label class="control-label">Name</label></td>
												<td>  <label class="control-label">Address</label></td>
											   </tr>  
											   <tr>
											   <td>  <input name="org_n"name="org_tele"   style="width:150px" type="text" value="<?php echo $orgn; ?>"></td>
											   <td><input name="org_add" type="text" style= "width:650px" colspan="20" value="<?php echo $orgadd; ?>"></td>
											   </tr>
											   </table>
											   </div>
										   </div>	
                                           
                                            <div class="control-group">
												<div class="controls">
												<table>
													<tr>
													<td>  <label class="control-label">Telephone Number</label></td>
													<td>   <label class="control-label">Mobile Number</label></td>
													</tr>
												
													<tr>
													<td><input name="org_tele"name="org_n" type="text" style="width:150px" value="<?php echo $orgtele; ?>"></td>
													<td> <input name="org_mob" type="text"pattern="\d{10}$" placeholder="Enter 10-digit Mobile Number "style ="width:650px" value="<?php echo $orgmob; ?>"></td>
													</tr>
												</table>
												</div>
                                            </div>  
											<?php
												if(($_SESSION["ReadAccess"] == "Yes") && ($_SESSION["WriteAccess"] == "Yes")){
												 echo "<input onclick='setval3();' type='submit' name='update3' value='Save' />&nbsp;&nbsp;&nbsp;&nbsp;* Required fields.";
											 }
											 ?>
											<!-- <input onclick="setval3();" type='submit' name='update3' value='Save' />&nbsp;&nbsp;&nbsp;&nbsp;* Required fields. -->
                                    </div>    
										
                                    <div class="tab-pane" id="tabsleft-tab4">										   
										 
										<label class="control-label"><h3><b>Local Guardian Details</b></h3></label>
                                        <div class="control-group">
                                            <div class="controls">
											<table>
											<tr>
											<td> <label class="control-label">Name</label></td>
											 <td>  <label class="control-label">Address</label></td>
											 </tr> 
											<tr>
											<td>  <input name="lg_n" pattern="[ .A-ZA-z]{1,50}"type="text"  style="width:150px" value="<?php echo $lgn; ?>"></td>
											<td><input  name="lg_add" type="text" style= "width:650px" value="<?php echo $lgadd; ?>"></td>
                                             </tr> 
											 </table>
											</div>
                                        </div>
										
									   <div class="control-group"> 
										<div class="controls">
										<table>
											<tr>
											<td><label class="control-label">Telephone Number</label></td>
											<td><label class="control-label">Mobile Number</label></td>
											</tr>
											<tr>
											<td><input name="lg_tele" type="text"  style="width:150px"value='<?php echo $lgtele; ?>'></td>
											<td>  <input name="lg_mob" pattern="\d{10}$"  type="text" placeholder="Enter 10-digit Mobile Number " value="<?php echo $lgmob; ?>"></td>
											</tr>
										 </table>
										 </div>
										</div>
										
										 <label class="control-label"><h3><b>Hostel Details</b></h3></label>
										
                                           <div class="control-group">
												<div class="controls">
												<table>
												<tr>
												<td> <label class="control-label">Name</label></td>
												 <td>  <label class="control-label">Address</label></td>
												</tr>
												
												<tr>
												<td>  <input name="h_name" style="width:150px" type="text" value="<?php echo $hname; ?>"></td>
												<td> <input  name="h_add" type="text" style= "width:650px" value="<?php echo $hadd; ?>"></td> 
												</tr>
												</table>
												</div>
                                           </div>	
											 
											<div class="control-group">
												<div class="controls">
													<table>
													<tr>
													 <td>  <label class="control-label">Telephone Number</label></td>
													</tr>
													<tr>
													<td><input name="h_tele" type="text"  style="width:150px"value="<?php echo $htele; ?>"></td>
													</tr>
													</table>
												</div>
											 </div>
											<?php
												if(($_SESSION["ReadAccess"] == "Yes") && ($_SESSION["WriteAccess"] == "Yes")){
												 echo "<input onclick='setval4();' type='submit' name='update4' value='Save' />&nbsp;&nbsp;&nbsp;&nbsp;* Required fields.";
											 }
											 ?>
											<!-- <input type='submit' onclick="setval4();" name='update4' value='Save' 		/> -->
                                    </div>
												 
									<div class="tab-pane" id="tabsleft-tab5">
                                               <div class="control-group">
                                              <label class="control-label"><h3><b>Details of Sports and Cultural Activities</b></h3></label>
                                               <div class="controls">
                                               <textarea rows="20" name="d_et" class="input-xxlarge" type="text">"<?php echo trim($det); ?>"</textarea>
                                                </div>
                                            </div>
									</div>
									
									<div class="tab-pane" id="tabsleft-tab6">										   
										 
                                        <div class="control-group">
                                            <div class="controls">
												<table>
																
																
																<?php 
																	if(isset($_SESSION["SESSFrom"]) && ($_SESSION["SESSFrom"] == "fromadmin")) 
																	{
																		echo "<tr>";
																		echo "<td><label class='control-label'>CNUM</label></td>";
																		echo "<td><input name='cnum' type='text' style='width:150px' value='$cnum' readonly /></td>"; 
																		echo "</tr>";
																	}
																	else
																	{
																		echo "<tr>";
																		echo "<td><label class='control-label'>CNUM</label></td>";
																		echo "<td><label class='control-label'>$cnum</label>

																		<input type='hidden' name='lblcnum' value='$cnum'>
																			</td>";
																		echo "</tr>";
	
																	}																		
																?>
																<?php 
																	if(isset($_SESSION["SESSFrom"]) && ($_SESSION["SESSFrom"] == "fromadmin")) 
																	{
																		echo "<tr>";
																		echo "<td><label class='control-label'>Register Number</label></td>";
																		echo "<td><input name='txtregisterno' type='text' style='width:150px' value='$registerno' /></td>"; 
																		echo "</tr>";
																	}
																	else
																	{
																		echo "<tr>";
																		echo "<td><label class='control-label'>Register Number</label></td>";
																		echo "<td><label class='control-label'>$registerno</label>
																		<input type='hidden' name='lblregisterno' value='$registerno'></td>";
																		echo "</tr>";	
																	}																		
																?>
													<tr>
														<td> <label class="control-label">Name</label></td>
														<td><label class="control-label"><?php echo trim($Finame) . ' ' . trim($Stuname); ?></label></td>
													 </tr> 											 
																									
																
																<?php 
																	if(isset($_SESSION["SESSFrom"]) && ($_SESSION["SESSFrom"] == "fromadmin")) 
																	{
																		echo "<tr>";
																		echo "<td><label class='control-label'>University PRN</label></td>";
																		echo "<td><input name='uniprn' type='text' style='width:150px' value='$uniprn' /></td>"; 
																		echo "</tr>";
																	}
																	else
																	{
																		echo "<tr>";
																		echo "<td><label class='control-label'>University PRN</label></td>";
																		echo "<td><label class='control-label'>$uniprn</label>
																		<input type='hidden' name='lbluniprn' value='$uniprn'></td>";
																		echo "</tr>";
	
																	}																		
																?>

																<?php 
																	if(isset($_SESSION["SESSFrom"]) && ($_SESSION["SESSFrom"] == "fromadmin")) 
																	{
																		echo "<tr>";
																		echo "<td><label class='control-label'>Current Roll Number</label></td>";
																		echo "<td><input name='RollNo' type='text' style='width:150px' value='$RollNo' /></td>"; 
																		echo "</tr>";
																	}
																	else
																	{
																		echo "<tr>";
																		echo "<td><label class='control-label'>Current Roll Number</label></td>";
																		echo "<td><label class='control-label'>$RollNo</label>
																			<input type='hidden' name='lblrollno' value='$RollNo'></td>";
																		echo "</tr>";
	
																	}																		
																	?>
																	
																	

																<?php 
																	if(isset($_SESSION["SESSFrom"]) && ($_SESSION["SESSFrom"] == "fromadmin")) 
																	{
																		echo "<tr>";
																		echo "<td><label class='control-label'>University Eligibility Number</label></td>";
																		echo "<td><input name='unieli' type='text' style='width:150px' value='$unieli' /></td>"; 
																		echo "</tr>";
																	}
																	else
																	{
																		echo "<tr>";
																		echo "<td><label class='control-label'>University Eligibility Number</label></td>";
																		echo "<td><label class='control-label'>$unieli</label>
																		<input type='hidden' name='lblunieli' value='$unieli'></td>";
																		echo "</tr>";
	
																	}																		
																?>

																										 
																<?php 
																	if(isset($_SESSION["SESSFrom"]) && ($_SESSION["SESSFrom"] == "fromadmin")) 
																	{
																		echo "<tr>";
																		echo "<td><label class='control-label'>DTE Number</label></td>";
																		echo "<td><input name='dteid' type='text' style='width:150px' value='$dteid' /></td>"; 
																		echo "</tr>";
																	}
																	else
																	{
																		echo "<tr>";
																		echo "<td><label class='control-label'>DTE Number</label></td>";
																		echo "<td><label class='control-label'>$dteid</label>
																		<input type='hidden' name='lbldteid' value='$dteid'></td>";
																		echo "</tr>";
	
																	}																		
																?>
																									 
																<?php 
																	if(isset($_SESSION["SESSFrom"]) && ($_SESSION["SESSFrom"] == "fromadmin")) 
																	{
																		echo "<tr>";
																		echo "<td><label class='control-label'>Exam Seat Number</label></td>";
																		echo "<td><label class='control-label'>$seatnonew</label>
																		<input type='hidden' name='lblseatno' value='$seatnonew'></td>"; 
																		echo "</tr>";
																	}
																	else
																	{
																		echo "<tr>";
																		echo "<td><label class='control-label'>Exam Seat Number</label></td>";
																		echo "<td><label class='control-label'>$seatnonew</label>
																		<input type='hidden' name='lblseatno' value='$seatnonew'></td>";
																		echo "</tr>";
	
																	}																		
																?>
																<?php 
																	if(isset($_SESSION["SESSFrom"]) && ($_SESSION["SESSFrom"] == "fromadmin")) 
																	{
																		echo "<tr>";
																		echo "<td><label class='control-label'>Password</label></td>";
																		echo "<td><input name='stdpass' type='text' style='width:150px' value='$stdpass' /></td>"; 
																		echo "</tr>";
																	}	
																?>
																<?php 
																	if(isset($_SESSION["SESSFrom"]) && ($_SESSION["SESSFrom"] == "fromadmin")) 
																	{
																		echo "<tr>";
																		echo "<td><label class='control-label'>Division</label></td>";
																		echo "<td><input name='txtdivn' type='text' style='width:150px' value='$divn' /></td>"; 
																		echo "</tr>";
																	}
																	else
																	{
																		echo "<tr>";
																		echo "<td><label class='control-label'>Division</label></td>";
																		echo "<td><label class='control-label'>$divn</label>
																		<input type='hidden' name='lbldivn' value='$divn'></td>";
																		echo "</tr>";
	
																	}																		
																?>
																<?php 
																	if(isset($_SESSION["SESSFrom"]) && ($_SESSION["SESSFrom"] == "fromadmin")) 
																	{
																		echo "<tr>";
																		echo "<td><label class='control-label'>Shift</label></td>";
																		echo "<td><input name='txtshift' type='text' style='width:150px' value='$shift' /></td>"; 
																		echo "</tr>";
																	}
																	else
																	{
																		echo "<tr>";
																		echo "<td><label class='control-label'>Shift</label></td>";
																		echo "<td><label class='control-label'>$shift</label>
																		<input type='hidden' name='lblshift' value='$shift'></td>";
																		echo "</tr>";
	
																	}																		
																?>
																
																<?php 
																	if(isset($_SESSION["SESSFrom"]) && ($_SESSION["SESSFrom"] == "fromadmin")) 
																	{
																		echo"<tr>";
																		echo "<td>
																		<input type='hidden' name='ddldept_hidden' id='ddldept_hidden' />
																		<label class='control-label'>Department</label></td>";
																		$strselect1 =  "<td><select onchange='settext();' name='ddldept' id='ddldept' style='width:69%;margin-top:10px;' ";
																		include 'db/db_connect.php';
																		$sql = "SELECT DeptID as Mdeptid, 
																		DeptName as MDeptName , orderno From tbldepartmentmaster where DeptName <> 'BSH' and COALESCE(Teaching,0) = 1;";
																		$result1 = $mysqli->query( $sql );
																		while( $row = $result1->fetch_assoc() ) {
																			extract($row);
																			
																			if($deptdb == $Mdeptid) {
																					$strselect2 = $strselect2 . "<option value={$Mdeptid} selected>{$MDeptName}</option>"; 
																			}	
																			else{
																				$strselect2 = $strselect2 .  "<option value={$Mdeptid}>{$MDeptName}</option>"; 
																			}
																		}
																		echo $strselect1 . " disabled >" . $strselect2 . "</select>";
																		echo "<input type='submit' name='submit' onclick='enable()' value='Change'>";
																		echo"</td>";
																	
																		echo "</tr>";
																	}
																	//echo $sql ;
																?>		
										</table>
											</div>
                                        </div>
											 <?php
//if(($_SESSION["ReadAccess"] == "Yes") && ($_SESSION["WriteAccess"] == "Yes")){
if(isset($_SESSION["SESSFrom"]) && ($_SESSION["SESSFrom"] == "fromadmin")) {

												 echo "<input onclick='setval5();' type='submit' name='update5' value='Save' />&nbsp;&nbsp;&nbsp;&nbsp;* Required fields.";
											 }
											 ?>
										<!-- <input onclick="setval5();" type='submit' name='update5' value='Save' />&nbsp;&nbsp;&nbsp;&nbsp;* Required fields. -->

                                    </div>
<div class="tab-pane" id="tabsleft-tab7">										   
<h3 class="page-title" style="margin-left:5%">Upload Photo</h3>
	<div class="row-fluid">
		<div class="v_detail" style="margin-left:5%">
			<table cellpadding="10" cellspacing="0" border="0" width="50%" class="tab_split">
				<tr>
					<td class="form_sec span4">&nbsp;</td>
					<td>
						<div class="span10">
							<input name="fileToUpload" type="file" id="fileToUpload">
							<input  onclick="removeattrall();" name="uploadphoto" id="uploadphoto" type="submit" value="Upload Photo" class="btn btn-mini btn-success" />
							<input onclick="removeattrall();" title="Click to Refresh page" name="btnRefresh" id="btnRefresh" type="submit" value="Refresh" class="btn btn-mini btn-success" />
						</div>
					</td>								
				</tr>
				 <tr>
					<td class="form_sec span4">My Photo</td>
						<?php
							if(!isset($_SESSION)){
								session_start();
							}
							$dir = 'photos';
							include 'db/db_connect.php';
							if(isset($_SESSION["SESSFrom"]) && ($_SESSION["SESSFrom"] == "fromadmin")) {
									$query = "SELECT photopath FROM tblstudent where CNUM = '" . $_SESSION["cnum"] . "'";
								 }
								 else{
									$query = "SELECT photopath FROM tblstudent where CNUM = '" . $_SESSION["loginid"] . "'";
								 }							
							//echo $query;
							$result = $mysqli->query( $query );
							$num_results = $result->num_rows;
							if( $num_results ) {
								while( $row = $result->fetch_assoc() ) {
									extract($row);
								  //echo "<td colspan='7' class='th-heading'><center>Access List - ". $photopath . "</center></td>";
								  echo "<td colspan='7' class='th-heading'><img src=photos/". $photopath . " alt=''  /></td>";
								}
							}		
						?>		
			  </tr>	
			 </table>
			 <?php 
				//upload_tmp_dir = "C:/wamp/tmp"
				If (isset($_POST['uploadphoto'])){
					if(isset($_FILES['fileToUpload'])) {
							$errors     = array();
							//$maxsize    = 2097152;
							$maxsize    = 240000;
							$acceptable = array('image/gif','image/jpg','image/png','image/jpeg');
							if((strpos($_FILES['fileToUpload']['name'],' ') > 0) || (strpos($_FILES['fileToUpload']['name'],'(') > 0) || 
										(strpos($_FILES['fileToUpload']['name'],')') > 0)) {
								$errors[] = 'File name invalid. Please remove any spaces or brackets.';
							}

							if(($_FILES['fileToUpload']['size'] >= $maxsize) || ($_FILES["fileToUpload"]["size"] == 0)) {
								$errors[] = 'File too large. File must be less than 240KB.';
							}

							if((!in_array($_FILES['fileToUpload']['type'], $acceptable)) && (!empty($_FILES["fileToUpload"]["type"]))) {
								$errors[] = 'Invalid file type. Only an Image is accepted.';
							}
							if(count($errors) === 0) {
								$info = pathinfo($_FILES['fileToUpload']['name']);
								 $ext = $info['extension']; // get the extension of the file
								 $filename = $_FILES['fileToUpload']['name'];
								 if(isset($_SESSION["SESSFrom"]) && ($_SESSION["SESSFrom"] == "fromadmin")) {
									$newname = $_SESSION["cnum"] . substr($filename, strlen($filename)-4); 
								 }
								 else{
									$newname = $_SESSION["loginid"] . substr($filename, strlen($filename)-4); 
								 }
								 $target = 'photos/'.$newname;
								 //move_uploaded_file( $_FILES['fileToUpload']['tmp_name'], $target);
								 move_uploaded_file( $_FILES['fileToUpload']['tmp_name'], $target);
								 include 'db/db_connect.php';
									$sql = "UPDATE  tblstudent	Set  photopath = ?	Where CNUM = ?";
								$stmt = $mysqli->prepare($sql);
								 if(isset($_SESSION["SESSFrom"]) && ($_SESSION["SESSFrom"] == "fromadmin")) {
									$stmt->bind_param('ss', $newname,$_SESSION["cnum"]);
								}
								 else{
									$stmt->bind_param('ss', $newname,$_SESSION["loginid"]);
								}
								// execute the update statement
								if($stmt->execute()) {
									//header('Location: stdviewmain.php');
									 //close the prepared statement
									}
								else{
									 echo $mysqli->error;
									 die("Unable to update.");
								}
							}
							else {
									foreach($errors as $error) {
										echo "<br/><pre>$error</pre>";
									}
							}
						}
					}
				?>
		 </div>
	</div>
					 
                                     
											 <?php
// //if(($_SESSION["ReadAccess"] == "Yes") && ($_SESSION["WriteAccess"] == "Yes")){
// if(isset($_SESSION["SESSFrom"]) && ($_SESSION["SESSFrom"] == "fromadmin")) {

												 // echo "<input onclick='setval6();' type='submit' name='update5' value='Save' />&nbsp;&nbsp;&nbsp;&nbsp;* Required fields.";
											 // }
											 // ?>
										<!-- <input onclick="setval6();" type='submit' name='update6' value='Save' />&nbsp;&nbsp;&nbsp;&nbsp;* Required fields. -->

 	
                                   
</div>
						
<div class="tab-pane" id="tabsleft-tab8">										   
<h3 class="page-title" style="margin-left:5%">Transfer Certificate</h3>

	<div class="control-group">
			<div class="controls">
				<table>
					<tr>
						<td> <label class="control-label">Register Number</label></td>
						<td><label class="control-label"><?php echo trim($registerno); ?></label></td>
					 </tr>
					<tr>
						<td> <label class="control-label">College Enrollment No</label></td>
						<td><label class="control-label"><?php echo trim($cnum); ?></label></td>
					 </tr>
					<tr>
						<td> <label class="control-label">Name of the Student in full</label></td>
						<td>
						<input id='txtnamefortransfer' name='txtnamefortransfer' type='text' style='width:250px' value='<?php echo $namefortransfer; ?>'>
						</td>
					 </tr> 										
					<tr>
						<td> <label class="control-label">Mother's Name</label></td>
						<td><label class="control-label"><?php echo trim($Mname); ?></label></td>
					 </tr> 										
					<tr>
						<td> <label class="control-label">Caste and subcaste</label></td>
						<td><label class="control-label"><?php echo trim($castesubcaste); ?></label></td>
					 </tr> 										
					<tr>
						<td> <label class="control-label">Nationality</label></td>
						<td><label class="control-label"><?php echo trim($nat); ?></label></td>
					 </tr> 										
					<tr>
						<td> <label class="control-label">Place of birth</label></td>
						<td><input id='txtpob' name='txtpob' type='text' style='width:250px' value='<?php echo $pob; ?>'></td>
					 </tr> 										
					<tr>
						<td> <label class="control-label">Date of birth <br/> (according to the Christian era) in words:</label></td>
						<td><label class="control-label"><?php echo trim($dob); ?></label></td>
					 </tr> 										
					<tr>
						<td> <label class="control-label">Last school attended</label></td>
						<td><label class="control-label"><?php echo trim($dipn); ?></label></td>
					 </tr>
					 <tr>
						<td><label class="control-label">Date of Admission (DD-MON-YYYY)</label></td>
						<td><input <?php if($CFLAG=='1'){echo "readonly";} ?> id="d_doa" name="d_doa"  class='span13 DTEXDATE d_doa' placeholder="DD-MON-YYYY" pattern="(^((31(?! (FEB|APR|JUN|SEP|NOV|Feb|Apr|Jun|Sep|Nov)))|((30|29)(?! FEB|Feb))|(29(?= FEB|Feb (((1[6-9]|[2-9]\d)(0[48]|[2468][048]|[13579][26])|((16|[2468][048]|[3579][26])00)))))|(0?[1-9])|1\d|2[0-8])-(JAN|FEB|MAR|MAY|APR|JUL|JUN|AUG|OCT|SEP|NOV|DEC|Jan|Feb|Mar|May|Apr|Jul|Jun|Aug|Oct|Sep|Nov|Dec)-((1[6-9]|[2-9]\d)\d{2})$)"   style="width:150px" type="text" value='<?php echo $doa; ?>'>
						</td>
					 </tr>
					 <tr>
						<td><label class="control-label">University PRN Number</td>
						<td><label class="control-label"><?php echo trim($uniprn); ?></label></td>
					 </tr>
					 <tr>
						<td><label class="control-label">Progress and Conduct</td>
						<td><input id='txtpandc' name='txtpandc' type='text' style='width:300px' value='<?php echo $pandc; ?>' /></td>
					</tr>
					 <tr>
						<td><label class="control-label">Date of leaving the college</label></td>
						<td><input <?php if($CFLAG=='1'){echo "readonly";} ?> id="d_dol" name="d_dol"  class='span13 DTEXDATE d_dol' placeholder="DD-MON-YYYY" pattern="(^((31(?! (FEB|APR|JUN|SEP|NOV|Feb|Apr|Jun|Sep|Nov)))|((30|29)(?! FEB|Feb))|(29(?= FEB|Feb (((1[6-9]|[2-9]\d)(0[48]|[2468][048]|[13579][26])|((16|[2468][048]|[3579][26])00)))))|(0?[1-9])|1\d|2[0-8])-(JAN|FEB|MAR|MAY|APR|JUL|JUN|AUG|OCT|SEP|NOV|DEC|Jan|Feb|Mar|May|Apr|Jul|Jun|Aug|Oct|Sep|Nov|Dec)-((1[6-9]|[2-9]\d)\d{2})$)"   style="width:150px" type="text" value='<?php echo $dol; ?>'>
						</td>
					 </tr>
					 <tr>
						<td><label class="control-label">Class from which left</td>
						<td><label class="control-label"><?php echo trim($DeptYear) . ' ' . trim($DeptName); ?></label></td>
					 </tr>
					 <tr>
						<td><label class="control-label">Reason of leaving the college</td>
						<td><input required id='txtreasonofleaving' name='txtreasonofleaving' type='text' style='width:300px' value='<?php echo $reasonofleaving; ?>' ></td>
					</tr>
					 <tr>
						<td><label class="control-label">Remarks if any*</td>
						<td><input name='txtleavingremarks' id='txtleavingremarks' type='text' style='width:300px' value='<?php echo $leavingremarks; ?>' >
						</td>
					</tr>
					<tr>
						<td> <label class="control-label">Purpose for Bonafied</label></td>
						<td><input id='txtbonapurpose' name='txtbonapurpose' type='text' style='width:650px' value='<?php echo $bonapurpose; ?>'></td>
					 </tr> 										
					<tr>
						<td>
							<input onclick='setval7();' type='submit' name='update1' value='Save' />&nbsp;&nbsp;&nbsp;&nbsp;* Required fields.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<a target='_blank' href='PrintTS.php'>Print Transfer Certificate</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<a target='_blank' href='PrintBS.php'>Print Bonafied Certificate</a>
						</td>
					</tr>												
				</table>
			</div>
		</div>
 	
                                   
</div>
		</div>						
        </div>
                                </form>
                            </div>
                        </div>
                                    <ul class="pager wizard">
                                       
                                    </ul>
                    </div>
                </div>
                </div>
         </div>
   <!-- END CONTAINER -->
</DIV>




