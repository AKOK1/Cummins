




<?php



include 'db/db_connect.php';

if(isset($_POST['update'])){	
	$edit_record1=$_GET['edit_form'];
	$stu_name=$_POST['Surname'];
	$fir_name=$_POST['First_Name'];
	$far_name=$_POST['Father_Name'];
	$mar_name=$_POST['mother_name'];
	$tal=$_POST['tal_uka'];
	$dist=$_POST['dist'];
	$sta=$_POST['sta_te'];
	$blodg=$_POST['blood_grp'];
	$mot=$_POST['mother_tongue'];
	$na=$_POST['nationality'];
	$re=$_POST['religion'];
	$cs=$_POST['caste'];
	$mu=$_POST['married_unmarried'];
	$sm=$_POST['Stu_Mobile'];	
	$se=$_POST['stu_email'];
	$lc=$_POST['last_college'];
	$fena=$_POST['fe_name'];
	$feye=$_POST['fe_year'];
	$femobta=$_POST['fe_mobt'];
	$femouto=$_POST['fe_mout'];
	$fecl=$_POST['fe_class'];
	$ferema=$_POST['fe_rem'];
	
	$dipna=$_POST['dip_name'];
	$dipye=$_POST['dip_year'];
	$dipmobta=$_POST['dip_mobt'];
	$dipmouto=$_POST['dip_mout'];
	$dipcl=$_POST['dip_class'];
	$diprema=$_POST['dip_rem'];
	
	$pn=$_POST['par_n'];	
	$padd=$_POST['par_add'];
	$ptal=$_POST['par_tal'];
	$pdist=$_POST['par_dist'];
	$pstate=$_POST['par_state'];
	$pincod=$_POST['p_in'];
	$ptele=$_POST['par_tele'];
	$pmob=$_POST['par_mob'];
	$fincome=$_POST['f_income'];
	$mincome=$_POST['m_income'];
	$orgn=$_POST['org_n'];
	$orgadd=$_POST['org_add'];
	$orgtele=$_POST['org_tele'];
	$orgmob=$_POST['org_mob'];
	$lgn=$_POST['lg_n'];
	$lgadd=$_POST['lg_add'];
	$lgtele=$_POST['lg_tele'];
	$lgmob=$_POST['lg_mob'];
	$hname=$_POST['h_name'];
	$hadd=$_POST['h_add'];
	$htele=$_POST['h_tele'];
	$deta=$_POST['d_et'];
	$dobb=$_POST['d_ob'];
	$pm=$_POST['Pmail'];
	$Rel=$_POST['Rel'];
	
	
$query1="update tblstudent 
	set Surname='$stu_name',
	FirstName='$fir_name',FatherName='$far_name',MotherName='$mar_name',Taluka='$tal',District='$dist',State='$sta',Blood_group='$blodg',Mother_tongue='$mot',Nationality='$na',Religion='$re',Caste_subcaste='$cs',Status='$mu',Mobno='$sm',Email_id='$se',Lastattended='$lc',parent_name='$pn',parent_address='$padd' ,parent_taluka='$ptal' ,parent_district='$pdist' ,parent_state='$pstate' ,pincode='$pincod' ,parent_telephone='$ptele' ,parent_mobile='$pmob' ,father_income='$fincome' ,mother_income='$mincome' ,org_name='$orgn' ,org_address='$orgadd' ,org_telephone='$orgtele' ,org_mobile='$orgmob' ,lg_name='$lgn' ,lg_address='$lgadd' ,lg_telephone='$lgtele' ,lg_mobile='$lgmob' ,hostel_name='$hname' ,hostel_address='$hadd' ,hostel_telephone='$htele' ,details='$deta' ,DOB='$dobb',Pmail='$pm',Rel='$Rel' where StdId='$edit_record1'";
	mysqli_query($mysqli, $query1);
	
	
	
	$query2="update stdqual set
	name='$fena',EduYearStart='$feye',mobt='$femobta',mout='$femouto',class='$fecl',remark='$ferema' where StdId='$edit_record1' and Year='FE'";
	mysqli_query($mysqli, $query2);
	$query3="update stdqual set
	name='$fena',EduYearStart='$feye',mobt='$femobta',mout='$femouto',class='$fecl',remark='$ferema' where StdId='$edit_record1' and Year='SE'";
	mysqli_query($mysqli, $query3);
	$query4="update stdqual set
	name='$dipna',EduYearStart='$dipye',mobt='$dipmobta',mout='$dipmouto',class='$dipcl',remark='$diprema'  where StdId='$edit_record1' and Year='DIPLOMA'";
	mysqli_query($mysqli, $query4);
	echo '<script>alert("UPDATED SUCCESSFULLY");</script>';

}

if(isset($_POST['Confirm']))
{

	$edit_record1=$_GET['edit_form'];
	$query7="update tblstudent set CFLAG='1'
	 where StdId='$edit_record1'";
	
	 
	mysqli_query($mysqli, $query7);
	
}




$edit_record =isset( $_GET['edit']) ? $_GET ['edit'] : $_GET ['edit_form'];



$query="SELECT * FROM tblstudent WHERE StdId='$edit_record'";
$run=mysqli_query($mysqli,$query);


    $edit_id="";
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
	
	$fen="";
	$fey="";
	$femobt="";
	$femout="";
	$fec="";
	$ferem="";
	$sen="";
	$sey="";
	$semobt="";
	$semout="";
	$sec="";
	$serem="";
	$dipn="";
	$dipy="";
	$dipmobt="";
	$dipmout="";
	$dipc="";
	$diprem="";
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
	$CNUM="";
	$CFLAG="";

	
	$feEduYearFrom="";
	$feEduYearStart="";
	$seEduYearFrom="";
	$seEduYearStart="";
	$dEduYearFrom="";
	$dEduYearStart="";



while($row=mysqli_fetch_array($run))
{
	
	$edit_id=$row['StdId'];
	$Stuname=$row[1];
	$Finame=$row[2];
	$Faname=$row[3];
	$Mname=$row[4];
	$Tal=$row[5];
	$Dis=$row[6];
	$stat=$row[7];
	$bg=$row[8];
	$mt=$row[9];
	$nat=$row[10];
	$reg=$row[11];
	$cas=$row[12];
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
	$CNUM=$row[42];
	$CFLAG=$row[43];
	
	
}
/*if(isset($_POST['upload']))
{
	$imageName=mysqli_real_escape_string($mysqli,$_FILES["image"]["name"]);
	$imageData=mysqli_real_escape_string($mysqli,file_get_contents($_FILES["image"]["tmp_name"]));
	$imageType=mysqli_real_escape_string($mysqli,file_get_contents($_FILES["image"]["type"]));
	
	if(substr($imageType,0,5)=="image")
	{
		echo "working code";
	}
	else{
		echo "only images";
	}
	mysqli_query(mysqli,"INSERT INTO 'tblstudent' values ('','$imageName','$imageData')");
}

if(isset($_GET['StdId']))
{
	$StdId=mysqli_real_escape_string($_GET['StdId']);
	$query=mysqli_query("select * from 'tblstudent' where 'StdId'='$StdId'");
	while($row=mysqli_fetch_assoc($query))
	{
		$imageData=$row["image"];
	}
	header ("content_type:image/jpeg");

}
else{echo "error";}
*/


echo "<script type='text/javascript'>window.onload = function()
						{
								document.getElementById('lblSuccess').style.display = 'block';
						}
						</script>";

						
						//$('#tabsleft-tab2').load('http://localhost/cummins/stdviewmain.php');
						
?>

<form method='post' enctype="multipart/form-data" action='stdviewmain.php?edit_form=<?php echo $edit_id;?>'>
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
                    <div class="widget box purple">
                        <div class="widget-title">
                            <h4>
								
                                <i class="icon-reorder"></i> STUDENT REGISTRATION</span>
								 &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
								 &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
								 &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
								 &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
								 &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
								 Your College Identification Number: <?php echo $CNUM;?>
								 &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
								 &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
								 &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
								 &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
								 &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
								 &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
								 &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
								 &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
								<?php echo "<a style='color:white' href='StudentMain.php'>Back</a>"; ?>
                            </h4>
						</div>
                        <div class="widget-body">
                            <form class="form-horizontal" action="#">
                                <div id="tabsleft" class="tabbable tabs-left">
                                <ul>
                                    <li><a href="#tabsleft-tab1"  data-toggle="tab"> <span class="Strong">Personal Details</span></a></li>
                                    <li><a href="#tabsleft-tab2" data-toggle="tab"> <span class="Strong">Exam Details</span></a></a></li>
                                    <li><a href="#tabsleft-tab3" data-toggle="tab"> <span class="Strong">Parent Information</span></a></a></li>
									 <li><a href="#tabsleft-tab4" data-toggle="tab"> <span class="Strong">Other Information</span></a></a></li>
                                    <li><a href="#tabsleft-tab5" data-toggle="tab"> <span class="Strong">Other Details</span></a></a></li>
                                </ul>
                                
                                <div class="tab-content">
                                    <div class="tab-pane" id="tabsleft-tab1">
                                      
                                        <div class="control-group">
                                            <h3><b>Personal Information</b></h3>
                                            <div class="controls">
											<table  >
											<tr>
											<td ><label class="control-label">Surname*</label></td>
											
											  <td > <label class="control-label">First Name*</label>
									
											   <td> <label class="control-label">Father's Name*</label>
										
											  <td> <label class="control-label">Mother's Name*</label>
											 
											</tr>
											
											
											<td ><input  <?php if($CFLAG=='1'){echo "disabled";} ?> name='Surname' pattern="[A-ZA-z]{1,50}" type='text'  style="width:150px"placeholder="Enter Surname " required  ="required" value='<?php echo $Stuname; ?>'> </td>
										
											<td ><input name='First_Name' pattern="[A-ZA-z]{1,50}"type='text' style="width:150px" placeholder="Enter First Name " required="required" value='<?php echo $Finame; ?>' ></td>
										
											<td><input name="Father_Name"  pattern="[A-ZA-z]{1,50}" type="text" style="width:150px"placeholder="Enter Father Name " required="required" value='<?php echo $Faname; ?>' ></td>
										
											<td><input name='mother_name' pattern="[A-ZA-z]{1,50}" type="text"  style="width:150px"placeholder="Enter Mother Name " required="required"value='<?php echo $Mname; ?>'>   </td>
											
											</tr>
											
											</table>
											
                                                
												 
                                                
                                                
                                            </div>
                                        </div>
                                       
										
										<div class="control-group">
										
                                            <label class="control-label">Place of Birth</label>
											 
                                            <div class="controls">
											<table>
											<tr>
											<td><label class="control-label">Taluka</label>
											<td> <label class="control-label">District</label>
											   <td> <label class="control-label">State</label>
											    <td> <label class="control-label">Date of Birth</label>
											 
											</tr>
											<tr>
										<td><input name='tal_uka' pattern="[A-ZA-z]{1,50}"type="text"  style="width:150px" value='<?php echo $Tal; ?>'> </td>
											<td> <input name="dist"pattern="[A-ZA-z]{1,50}" type="text" style="width:150px"  value='<?php echo $Dis; ?>'></td>
										<td><input name="sta_te"pattern="[A-ZA-z]{1,50}" type="text"   style="width:150px"value='<?php echo $stat; ?>'></td>
											<td><input name="d_ob" required="required" class='span13 DTEXDATE'  style="width:150px"type="text" value='<?php echo $dob; ?>'></td>
											</tr>
											</table>
                                              
                                               
                                            </div>
                                        </div>
										
										<div class="control-group">
                                           
										
                                            <div class="controls">
											<table>
											<tr>
											<td><label class="control-label">Blood Group</label>
											<td>  <label class="control-label">Mother Tongue</label>
											   <td>  <label class="control-label">Status</label>
											 
											 
											</tr>
											<tr>
										<td><select name="blood_grp"  style="width:150px"> 
											<option value="A positive"  style="width:150px"value='<?php echo $bg; ?>'>A positive</option>
											<option value="B positive"  style="width:150px"value='<?php echo $bg; ?>'>B positive</option>     
											</select>
											
											<td>  <input name="mother_tongue" pattern="[A-ZA-z]{1,50}"type="text" value='<?php echo $mt; ?>'></td>
										
											<td><select name="married_unmarried" style="width:150px"> 
											<option value="Married" style="width:150px"value='<?php echo $sts; ?>'>Married</option>
											<option value="Unmarried" style="width:150px"value='<?php echo $sts; ?>'>Unmarried</option>     
											</select>
											</tr>
											</table>
											
                                                 
											
										
                                               
                                            </div>
                                        </div>
										<div class="control-group">
                                           
                                            <div class="controls">
											<table>
											<tr>
											<td> <label class="control-label">Nationality</label>
											  <td>   <label class="control-label">Religion</label>
											   <td>  <label class="control-label">Caste-Subcaste</label>
											 
											</tr>
											<tr>
											<td>  <input name="nationality" pattern="[A-ZA-z]{1,50}"type="text" style="width:150px" value='<?php echo $nat; ?>'></td>
											<td>   <input name="religion" pattern="[A-ZA-z]{1,50}"type="text" style="width:150px" value='<?php echo $reg; ?>'></td>
											<td><select name="caste" style="width:150px"> 
											<option value="Open" value='<?php echo $cas; ?>'>Open</option>
											<option value="OBC" value='<?php echo $cas; ?>'>OBC</option> 
											<option value="SC" value='<?php echo $cas; ?>'>SC</option> 											
											<option value="ST" value='<?php echo $cas; ?>'>ST</option> 
											<option value="VJA" value='<?php echo $cas; ?>'>VJA</option> 
											<option value="NTB" value='<?php echo $cas; ?>'>NTB</option> 
											<option value="NTC" value='<?php echo $cas; ?>'>NTC</option> 
											<option value="NTD" value='<?php echo $cas; ?>'>NTD</option> 
											<option value="SBC" value='<?php echo $cas; ?>'>SBC</option> 
											</select>
											
											</tr>
											</table>
											
                                              
                                               
                                            </div>
                                        </div>
										
										
										<div class="control-group">
                                            
                                            <div class="controls">
											<table>
											<tr>
											<td><label class="control-label">Mobile Number*</label>
											
											  <td>  <label class="control-label">College Email Id*</label>
											  <td>  <label class="control-label"> Personal Email Id*</label>
											 
											   <td> <label class="control-label">Last College Attended</label>
											 
											</tr>
											<tr>
											<td> <input name="Stu_Mobile" pattern="\d{10}$" style="width:150px" type="text"placeholder="Enter 10-digit Mobile Number " required="required" value='<?php echo $mb; ?>'></td>
											<td><input name="stu_email" pattern="(^\w+[\w-\.]*\@\w+?\x2E.+)" style="width:150px" type="text" placeholder="Enter Valid Email "  value='<?php echo $email; ?>'></td>
											<td><input name="Pmail" pattern="(^\w+[\w-\.]*\@\w+?\x2E.+)"  style="width:150px"type="text" placeholder="Enter Valid Email "  value='<?php echo $em; ?>'></td>
											
											<td> <input name="last_college" pattern="[A-ZA-z]{1,50}" style="width:150px" type="text" value='<?php echo $lst; ?>'></td>
											
											</tr>
											</table>
                                              
                                               
                                            </div>
                                        </div>
										
										
                                    </div>
									
									
									
									
                                    <div class="tab-pane" id="tabsleft-tab2">
                                       
                                        <div class="control-group">
                                            <td><h3><b>QUALIFICATION</b></h3> 
       </td>
  
<td>
 <table  class="inner"  width="25">
 
  
 <tr>

 <td align="center"><b>Examination</b></td>
 <td align="center"><b>Name of Institution</b></td>
 <td align="center"><b>Year</b></td>
 <td align="center"><b>Marks Obtained</b></td>
 <td align="center"><b>Marks Outof</b></td>
 <td align="left"><b>Class</b></td>
 <td align="left"><b>Remarks</b></td>
 <?php

						$sql = "SELECT * FROM stdqual WHERE StdId='$edit_record'" ;

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
								
							if($Year=="FE")
							{
								
	
	$fen=$name;
	

	$femobt=$mobt;
	$femout=$mout;
	$fec=$class;
	$ferem=$remark;
	$feEduYearFrom=$EduYearFrom;
	$feEduYearStart=$EduYearStart;
	
	
	
							}
							else if($Year=="SE")
							{
								
								
	$fen=$name;
	

	$femobt=$mobt;
	$femout=$mout;
	$fec=$class;
	$ferem=$remark;
	$feEduYearFrom=$EduYearFrom;
	$feEduYearStart=$EduYearStart;
								
							}
							else if ($Year=="DIPLOMA")
							{
								
								$dipn=$name;
	
	$dipmobt=$mobt;
	$dipmout=$mout;
	$dipc=$class;
	$diprem=$remark;
	$dEduYearFrom=$EduYearFrom;
	$dEduYearStart=$EduYearStart;
							}
							
							
							}
						}					
						//disconnect from database
						$result->free();
						$mysqli->close();

						
				?>
				
 
 </tr>
  
 
								 <tr> 
								 <td><select name="demo"  style="width:150px"> 
								
											<option value="FE"  style="width:150px">FE</option>
											<option value="SE"  style="width:150px">SE</option>     
											</select>
								 
								 
								 <td><input type='text' class='input-medium' name='fe_name'pattern="[A-ZA-z]{1,50}" size='20' value='<?php echo$fen;?>'></td> 
								 <td><input type='text' class='input-medium' name='fe_year' value=' <?php echo$feEduYearStart;?>'></td> 
								 <td><input type='text' class='input-medium' name='fe_mobt' value=' <?php echo$femobt;?>'></td> 
								 <td><input type='text' class='input-medium' name='fe_mout' value=' <?php echo$femout;?>'></td> 
								 <td><input type='text' class='input-medium' name='fe_class' value=' <?php echo$fec;?>'></td> 
								 <td><input type='text' class='input-medium' style="width:70px"name='fe_rem' value=' <?php echo$ferem;?>'></td> 
								 
							
									
							 </tr>
								
								 <tr> 
								 <td>Diploma</td>
								 <td><input type='text' class='input-medium' name='dip_name' pattern="[A-ZA-z]{1,50}"size='20' value='<?php echo$dipn;?>'></td> 
								 <td><input type='text' class='input-medium' name='dip_year' value=' <?php echo$dEduYearStart;?>'></td> 
								  <td><input type='text' class='input-medium' name='dip_mobt' value=' <?php echo$dipmobt;?>'></td> 
								 <td><input type='text' class='input-medium' name='dip_mout' value=' <?php echo$dipmout;?>'></td> 
								 <td><input type='text' class='input-medium' name='dip_class' value=' <?php echo$dipc;?>'></td> 
								 <td><input type='text' class='input-medium' style="width:70px" name='dip_rem' value=' <?php echo$diprem;?>'></td> 
								 </tr> 
								
 
 </table>
  
 </td>
 </tr>
 </div>
 </div>
									
									
									
                                    <div class="tab-pane" id="tabsleft-tab3">
                                       
										    <label class="control-label"><h3><b>Parent Information</b></h3></label>
                                       <div class="control-group">
									   
                                           
                                            <div class="controls">
											<table>
											<tr>
											<td> <label class="control-label">Name</label>
											<td> <label class="control-label">Relation</label>
											
											</tr>
											<tr>
											<td><input name='par_n' pattern="[A-ZA-z]{1,50}"type='text' style="width:150px" value='<?php echo $parn; ?>'></td>
											<td><input name='Rel' pattern="[A-ZA-z]{1,50}"type='text'  style="width:150px"value='<?php echo $re; ?>'></td>
                                            
                                              
												</tr>
												</table>
                                                
                                            </div>
                                        </div>
										 <div class="control-group">
									   
                                           
                                            <div class="controls">
											<table>
											<tr>
											
											<td> <label class="control-label">Address</label>
											</tr>
											<tr>
											
                                             <td><input  name='par_add' type='text' style ="width:800px" value='<?php echo $paradd; ?>' ></td>
                                              
												</tr>
												</table>
                                                
                                            </div>
                                        </div>
										
                                        <div class="control-group">
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
			</script>
	</head>  
                                            <div class="controls">
											<table>
											<tr>
											
											  <td> <label class="control-label">Taluka</label>
											   <td> <label class="control-label">District</label>
												<td><label class="control-label">State</label>
												<td><label class="control-label">Pin Code</label>
											 
											</tr>
											<tr>
											
											<td><input name="par_tal"pattern="[A-ZA-z]{1,50}"  style="width:150px" type="text" value='<?php echo $partal; ?>' ></td>
											<td><input name='par_dist'pattern="[A-ZA-z]{1,50}" style="width:150px" type="text"value='<?php echo $pardist; ?>'>   </td>
											 <td><input name='par_state'pattern="[A-ZA-z]{1,50}" style="width:150px" type="text" value='<?php echo $parstate; ?>'> </td>
											  <td><input name="p_in"pattern="\d{6}$" type="text" style="width:150px" value='<?php echo $pin; ?>'></td>
											
											</tr>
											</table>
                                                 
												</div>
                                        </div>
										 
										
										
										
										<div class="control-group">
                                            
                                            <div class="controls">
											<table>
											<tr>
											<td><label class="control-label">Telephone number</label>
											  <td>   <label class="control-label">Mobile Number</label>
											   <td> <label class="control-label">Total Income Of Father</label>
												<td><label class="control-label">Total Income Of Mother</label>
												
											 
											</tr>
											<tr>
											<td><input name="par_tele" type="text"  style="width:150px" value='<?php echo $partele; ?>'></td>
											<td><input name="par_mob" pattern="\d{10}$"type="text"  style="width:150px"placeholder="Enter 10-digit Mobile Number "value='<?php echo $parmob; ?>'> </td>
											<td><input name="f_income" type="text"  style="width:150px"value='<?php echo $fincome; ?>'> </td>
											 <td> <input name="m_income" type="text"  style="width:150px"value='<?php echo $mincome; ?>'> </td>
											
											
											</tr>
											</table>
                                                
                                               
                                            </div>
                                        </div>
										
										 <label class="control-label"><h3><b>Organization Details of Parent</b></h3></label>
										<div class="control-group">
                                           
                                            <div class="controls">
											<table>
											<tr>
											<td> <label class="control-label">Name</label>
											  <td>  <label class="control-label">Address</label>
											   
											   </tr>
											   <tr>
											   <td>  <input name="org_n"name="org_tele" pattern="[A-ZA-z]{1,50}"  style="width:150px" type="text" value='<?php echo $orgn; ?>'></td>
											<td><input name="org_add" type="text" style= "width:650px" colspan="20" value='<?php echo $orgadd; ?>'></td>
											   
											 </tr>
											   </table>
											   </div>
											   </div>
											   
											   <div class="control-group">
                                           
                                            <div class="controls">
											<table>
											<tr>
											   
											   <td>  <label class="control-label">Telephone Number</label>
												<td>   <label class="control-label">Mobile Number</label>
												
											 
											</tr>
											<tr>
											<td><input name="org_tele"name="org_n" type="text" style="width:150px" value='<?php echo $orgtele; ?>'></td>
											 <td> <input name="org_mob" type="text"pattern="\d{10}$" placeholder="Enter 10-digit Mobile Number "style ="width:650px" value='<?php echo $orgmob; ?>'></td>
											
												
											
											
											
											</tr>
											</table>
                                           
                                               
                                            </div>
                                        </div>
										
										 
										
										
                                    </div>
									
									<div class="tab-pane" id="tabsleft-tab4">
                                       
										   
										  <label class="control-label"><h3><b>Local Guardian Details</b></h3></label>
										<div class="control-group">
                                           
                                            <div class="controls">
											<table>
											<tr>
											<td> <label class="control-label">Name</label>
											  <td>  <label class="control-label">Address</label>
											   
												
											 
											</tr>
											<tr>
											<td>  <input name="lg_n" pattern="[A-ZA-z]{1,50}"type="text"  style="width:150px" value='<?php echo $lgn; ?>'></td>
											<td><input  name="lg_add" type="text" style= "width:650px"value='<?php echo $lgadd; ?>'>
                                               
											
											
											
											</tr>
											</table>
                                           
                                             
                                               
                                            </div>
                                        </div>
										<div class="control-group">
                                           
                                            <div class="controls">
											<table>
											<tr>
										
										<td>  <label class="control-label">Telephone Number</label>
												<td>   <label class="control-label">Mobile Number</label>
												</tr>
												<tr>
										 <td><input name="lg_tele" type="text"  style="width:150px"value='<?php echo $lgtele; ?>'></td>
											 <td>  <input name="lg_mob" pattern="\d{10}$"  type="text"placeholder="Enter 10-digit Mobile Number " value='<?php echo $lgmob; ?>'></td>
											 </tr>
											 </table>
											 </div>
											 </div>
										
										 <label class="control-label"><h3><b>Hostel Details</b></h3></label>
										<div class="control-group">
                                           
                                            <div class="controls">
											<table>
											<tr>
											<td> <label class="control-label">Name</label>
											  <td>  <label class="control-label">Address</label>
											  
											
												
											 
											</tr>
											<tr>
											<td>  <input name="h_name"pattern="[A-ZA-z]{1,50}" style="width:150px" type="text" value='<?php echo $hname; ?>'></td>
											<td> <input  name="h_add" type="text" style= "width:650px"value='<?php echo $hadd; ?>'> 
												 
											
											 
											
											
											</tr>
											</table>
                                               
                                               
                                            </div>
                                        </div>
										<div class="control-group">
                                           
                                            <div class="controls">
											<table>
											<tr>
										 <td>  <label class="control-label">Telephone Number</label>
										 </tr>
										 <tr>
										 <td><input name="h_tele" type="text"  style="width:150px"value='<?php echo $htele; ?>'></td>
										 </tr>
										 </table>
										 </div>
										 </div>
										
                                    </div>
									
                                    <div class="tab-pane" id="tabsleft-tab5">
                                      
                                        <div class="control-group">
                                            <label class="control-label"><h3><b>Details of Sports and Cultural Activities</b></h3></label>
                                            <div class="controls">
                                               <textarea rows="20" name="d_et" class="input-xxlarge" type="text" value='<?php echo $det; ?>'>
												<?php echo trim($det); ?>
											   </textarea>
                                               
                                            </div>
                                        </div>
                                       
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                                    <ul class="pager wizard">
									
                                       
										<input type='submit' name='update' value='Update' />
										<!-- <input type='submit' name='Confirm' value='Confirm' /> -->
										<!-- <input type="file"  name="image"/> -->
										<!-- <input type='submit' name='upload' value='upload'/> -->
										
                                    </ul>
                            </form>
                        </div>
                    </div>
                </div>
   </div>
   <!-- END CONTAINER -->
</DIV>

</DIV>

</DIV>

