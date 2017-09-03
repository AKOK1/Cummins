<form method='post' action='profviewmain.php' enctype="multipart/form-data">
<head>


<script>
			function setval13() {
					removeattrall();
			}

function deleteRow(r) {
    var i = r.parentNode.parentNode.rowIndex;
    document.getElementById("grdpublistpatent").deleteRow(i);
	 // e.preventDefault();
	 
}
		function fnEditDataresearchcon(rconid) {
					var gvET = document.getElementById("grdlistresearchcon");
					var rCount = gvET.rows.length;
					var rowIdx;
					for (rowIdx=1; rowIdx<=rCount-1; rowIdx++) {						
						var rowElement = gvET.rows[rowIdx];
						if (parseInt(rowElement.cells[1].innerText) ==parseInt(rconid)){
				
							document.getElementById("lblrconid").value =rowElement.cells[1].innerText;
							document.getElementById("areaofspcl").value =rowElement.cells[2].innerText;
							document.getElementById("numofpgstuds").value =rowElement.cells[3].innerText;
							document.getElementById("numofphdstuds").value =rowElement.cells[4].innerText;					
							document.getElementById("otherachiev").value =rowElement.cells[5].innerText;					
							document.getElementById("update12").value = 'Update';
							break;
						}					
					}
			}


			function ClearFields9()  {
				document.getElementById("lblrconid").value = "0";
				document.getElementById("areaofspcl").value = "";
				document.getElementById("numofpgstuds").value = "";
				document.getElementById("numofphdstuds").value = "";
				document.getElementById("otherachiev").value = "";
				document.getElementById("update12").value = 'Add';
			}			

			function setval6() {
					removeattrall();
					document.getElementById("journal_conf").setAttribute("required", "required");
					document.getElementById("papertitle").setAttribute("required", "required");
					document.getElementById("authors1").setAttribute("required", "required");
					document.getElementById("Journalname").setAttribute("required", "required");
					document.getElementById("conyear").setAttribute("required", "required");					
					document.getElementById("ys_No").setAttribute("required", "required");
					document.getElementById("y_n").setAttribute("required", "required");  
					document.getElementById("Yes_no").setAttribute("required", "required");
					document.getElementById("update4").value = 'Add';
					return true;
			}
			function setval7() {
				removeattrall();
				document.getElementById("booktitle").setAttribute("required", "required");
				document.getElementById("bauthrs").setAttribute("required", "required");
				document.getElementById("bookyear").setAttribute("required", "required");
					document.getElementById("update5").value = 'Add';
					return true;
			}
			function setval8() {
					removeattrall();
					document.getElementById("patenttitle").setAttribute("required", "required");
					document.getElementById("authrs1").setAttribute("required", "required");
					document.getElementById("patentnumber").setAttribute("required", "required");
					document.getElementById("pcountry").setAttribute("required", "required");
					document.getElementById("pyear").setAttribute("required", "required");
					document.getElementById("Filed_Published").setAttribute("required", "required");
					return true;
			}
			function removeattrall(){
						var inputs = document.getElementsByTagName('input');
						for(var i = 0; i < inputs.length; i++) {
							inputs[i].removeAttribute("required");
						}
						var selects = document.getElementsByTagName('select');
						for(var i = 0; i < selects.length; i++) {
							selects[i].removeAttribute("required");
						}
						$('.DTEXDATE').removeAttr("required");
						

			}
														
			function setval22() {
					removeattrall();
					/*
					document.getElementById("deg_name").setAttribute("required", "required");
					
					document.getElementById("Branch_name").setAttribute("required", "required");
					document.getElementById("clas_name").setAttribute("required", "required");
					document.getElementById("mks_obt").setAttribute("required", "required");
					document.getElementById("mks_out").setAttribute("required", "required");
					document.getElementById("percen_name").setAttribute("required", "required");
					document.getElementById("yrof_pas").setAttribute("required", "required");
					document.getElementById("clg_name").setAttribute("required", "required");
					document.getElementById("uni_name").setAttribute("required", "required");
					document.getElementById("pgdeg_name").setAttribute("required", "required");
					document.getElementById("pgBranch_name").setAttribute("required", "required");
					document.getElementById("pgclas_name").setAttribute("required", "required");
					document.getElementById("pgmks_obt").setAttribute("required", "required");
					document.getElementById("pgmks_out").setAttribute("required", "required");
					document.getElementById("pgpercen_name").setAttribute("required", "required");
					document.getElementById("pgpgyrof_pas").setAttribute("required", "required");
					document.getElementById("pguni_name").setAttribute("required", "required");
					document.getElementById("pgclg_name").setAttribute("required", "required");
					document.getElementById("brnchnam").setAttribute("required", "required");
					document.getElementById("university_name").setAttribute("required", "required");
					document.getElementById("guide_name").setAttribute("required", "required");
					document.getElementById("reg_date").setAttribute("required", "required");
					document.getElementById("dec_date").setAttribute("required", "required");
					*/
					
			}
			function CopyAdd2() {  
					  var cb1 = document.getElementById('sameadd');
					  var a1 = document.getElementById('city_name1');
					  var al1 = document.getElementById('city_name2');
					  var b1 = document.getElementById('dist_1');
					  var bl1 = document.getElementById('dist_2');
					  var c1 = document.getElementById('vill_age1');
					  var cl1 = document.getElementById('vill_age2');
					  var d1 = document.getElementById('pincode_num1');
					  var dl1 = document.getElementById('pincode_num2');
					  var e1 = document.getElementById('h_addr1');
					  var el1 = document.getElementById('h_addr2');

					if (cb1.checked) {
						a1.value = al1.value;
						b1.value = bl1.value;
						c1.value = cl1.value;
						d1.value = dl1.value;
						e1.value = el1.value;

					}
					else {
						c1.value = '';
						a1.value = '';
						b1.value = '';
						d1.value = '';
						e1.value = '';
					}  
			}

			function CopyAdd() {
  
					  var cb1 = document.getElementById('sameadd');
					  var a1 = document.getElementById('city_name1');
					  var al1 = document.getElementById('city_name2');
					  var b1 = document.getElementById('dist_1');
					  var bl1 = document.getElementById('dist_2');
					  var c1 = document.getElementById('vill_age1');
					  var cl1 = document.getElementById('vill_age2');
					  var d1 = document.getElementById('pincode_num1');
					  var dl1 = document.getElementById('pincode_num2');
					  var e1 = document.getElementById('h_addr1');
					  var el1 = document.getElementById('h_addr2');

					if (cb1.checked) {
					   
						al1.value = a1.value;
						bl1.value = b1.value;
						cl1.value = c1.value;
						dl1.value = d1.value;
						el1.value = e1.value;

					}
					else {
						
						cl1.value = '';
						al1.value = '';
						bl1.value = '';
						cl1.value = '';
						dl1.value = '';
						el1.value = '';

					}  
			}
				function setval2() {	
					removeattrall();
		
					if(($('#chk').prop('checked')) && (($('#institution_name').val()=='') || ($('#passingyear').val()=='') || ($('#percent').val()=='')|| ($('#mksobt').val()=='')|| ($('#mksout').val()=='')|| ($('#cls_name').val()=='') )) {
						alert('Please enter data for checked row.');
						return false;	
					}
					else {
							if(($('#chk1').prop('checked')) && (($('#instiname').val()=='') || ($('#tpassingyear').val()=='') || ($('#tpercent').val()=='')|| ($('#tmksobt').val()=='')|| ($('#tmksout').val()=='')|| ($('#tclas_name').val()=='') )) {
							 alert('Please enter data for checked row.');
								return false;	
							}
							else {
								if(($('#chk2').prop('checked')) && (($('#dinstitution_name').val()=='') || ($('#dpassingyear').val()=='') || ($('#dpercent').val()=='')|| ($('#dmksobt').val()=='')|| ($('#dmksout').val()=='')|| ($('#dclas_name').val()=='') )) {					   
								 alert('Please enter data for checked row.');
									return false;	
								}
								else {
										return true;
								}
							}
					}
				}
				
			function setval1() {
					removeattrall();
					document.getElementById("Surname").setAttribute("required", "required");
					document.getElementById("First_Name").setAttribute("required", "required");
					document.getElementById("mother_name").setAttribute("required", "required");
					document.getElementById("nationality").setAttribute("required", "required");
					document.getElementById("religion").setAttribute("required", "required");
					document.getElementById("Stu_Mobile").setAttribute("required", "required");
					document.getElementById("Stu_Emegcontact").setAttribute("required", "required");
					document.getElementById("stu_email").setAttribute("required", "required");
					document.getElementById("Pmail").setAttribute("required", "required");
					 document.getElementById("pincode_num1").setAttribute("required", "required");
					 document.getElementById("pincode_num2").setAttribute("required", "required");
			}
			function setval5() {
					removeattrall();
					document.getElementById("bankname").setAttribute("required", "required");
					document.getElementById("branchname").setAttribute("required", "required");
					document.getElementById("accnum").setAttribute("required", "required");
					document.getElementById("IFScode").setAttribute("required", "required");
					document.getElementById("MICRnum").setAttribute("required", "required");
					document.getElementById("PFnum").setAttribute("required", "required");
			}
			function setval9() {
					removeattrall();
			}
			function setval10() {
					removeattrall();
			}
			function setval11() {
					removeattrall();
					document.getElementById("ddlAcadYear").setAttribute("required", "required");
					document.getElementById("projtitle").setAttribute("required", "required");
					document.getElementById("fundagency").setAttribute("required", "required");
			}
			function setval12() {
					removeattrall();
					document.getElementById("ddlCAcadYear").setAttribute("required", "required");
					document.getElementById("conprv").setAttribute("required", "required");
					document.getElementById("natofcon").setAttribute("required", "required");
			}
			function fnEditdata(pubId) {	
					 var gvET = document.getElementById("grdpublist");
					 var rCount = gvET.rows.length;
					 var rowIdx;
					 for (rowIdx=1; rowIdx<=rCount-1; rowIdx++) {						
						 var rowElement = gvET.rows[rowIdx];
						 if (parseInt(rowElement.cells[1].innerText) ==parseInt(pubId)){	
							 document.getElementById("lblpubid").value =rowElement.cells[1].innerText;
							 document.getElementById("journal_conf").value =rowElement.cells[2].innerText;
							 document.getElementById("papertitle").value =rowElement.cells[3].innerText;
							 document.getElementById("authors1").value =rowElement.cells[4].innerText;						
							 document.getElementById("Journalname").value =rowElement.cells[5].innerText;
							 document.getElementById("journalpub").value =rowElement.cells[6].innerText;							 
							 document.getElementById("vol").value =rowElement.cells[7].innerText;						
							 document.getElementById("pages").value =rowElement.cells[8].innerText;						
							 document.getElementById("conyear").value =rowElement.cells[9].innerText;						
							 document.getElementById("month").value =rowElement.cells[10].innerText;						
							 document.getElementById("Doi").value =rowElement.cells[11].innerText;						
							 document.getElementById("Url").value =rowElement.cells[12].innerText;						
							 document.getElementById("impctFactor").value =rowElement.cells[13].innerText;
							 document.getElementById("abstract").value =rowElement.cells[14].innerText;						
							 document.getElementById("Press_Published").value =rowElement.cells[15].innerText;						
							 document.getElementById("Yes_no").value =rowElement.cells[16].innerText;						
							 document.getElementById("y_n").value =rowElement.cells[17].innerText;						
							 document.getElementById("ys_No").value =rowElement.cells[18].innerText;	
							 document.getElementById("ISSNnum").value =rowElement.cells[19].innerText;		
							 document.getElementById("update4").value = 'Update';
							 break;
						 }					
					 }
			}
			function ClearFields(){
				document.getElementById("lblpubid").value = "0";
				document.getElementById("journal_conf").value = "";
				document.getElementById("papertitle").value = "";
				document.getElementById("authors1").value = "";						
				document.getElementById("Journalname").value = "";
				document.getElementById("journalpub").value = "";				
				document.getElementById("vol").value = "";						
				document.getElementById("pages").value = "";						
				document.getElementById("conyear").value = "";						
				document.getElementById("month").value = "";						
				document.getElementById("Doi").value = "";						
				document.getElementById("Url").value = "";						
				document.getElementById("impctFactor").value = "";
				document.getElementById("abstract").value = "";						
				document.getElementById("Press_Published").value = "";						
				document.getElementById("Yes_no").value = "";						
				document.getElementById("y_n").value = "";						
				document.getElementById("ys_No").value = "";	
				document.getElementById("ISSNnum").value = "";		
				document.getElementById("update4").value = 'Add';
			}
			function ClearFields2()  {
				document.getElementById("lblbookid").value = "0";
				document.getElementById("booktitle").value = "";
				document.getElementById("bauthrs").value = "";
				document.getElementById("bookyear").value = "";						
				document.getElementById("publish").value = "";						
				document.getElementById("addr").value = "";						
				document.getElementById("bookurl").value = "";						
				document.getElementById("bedition").value = "";						
				document.getElementById("ISBNnum").value = "";						
				document.getElementById("update5").value = 'Add';
			}
			function ClearFields3()  {
				document.getElementById("lblpatid").value = "0";
				document.getElementById("authrs1").value = "";
				document.getElementById("patenttitle").value = "";
				document.getElementById("pyear").value = "";
				document.getElementById("patentnumber").value = "";
				document.getElementById("pcountry").value = "";
				document.getElementById("Filed_Published").value = "";
				document.getElementById("paturl").value = "";
				document.getElementById("update7").value = 'Add';
			}
			function ClearFields6()  {
				document.getElementById("lblindusid").value = "0";
				document.getElementById("industry").value = "";
				//("#datepicker6").datepicker = "";
				//("#datepicker7").datepicker = "";
				document.getElementById("numofyrs").value = "";
				document.getElementById("update9").value = 'Add';
			}
			function ClearFields7()  {
				document.getElementById("lblprojid").value = "0";
				document.getElementById("ddlAcadYear").value = "";
				document.getElementById("projtitle").value = "";
				document.getElementById("fundagency").value = "";
				document.getElementById("update10").value = 'Add';
			}
			function ClearFields8()  {
				document.getElementById("lblconid").value = "0";
				document.getElementById("ddlCAcadYear").value = "";
				document.getElementById("conprv").value = "";
				document.getElementById("natofcon").value = "";
				document.getElementById("update11").value = 'Add';
			}
			function fnEditDataBook(pubId) {
					var gvET = document.getElementById("grdpublistbook");
					var rCount = gvET.rows.length;
					var rowIdx;
					for (rowIdx=1; rowIdx<=rCount-1; rowIdx++) {						
						var rowElement = gvET.rows[rowIdx];
						if (parseInt(rowElement.cells[1].innerText) ==parseInt(pubId)){									
							document.getElementById("lblbookid").value =rowElement.cells[1].innerText;
							document.getElementById("booktitle").value =rowElement.cells[2].innerText;
							document.getElementById("bauthrs").value =rowElement.cells[3].innerText;
							document.getElementById("bookyear").value =rowElement.cells[4].innerText;						
							document.getElementById("publish").value =rowElement.cells[5].innerText;						
							document.getElementById("addr").value =rowElement.cells[6].innerText;
							document.getElementById("bookurl").value =rowElement.cells[7].innerText;					
							document.getElementById("bedition").value =rowElement.cells[8].innerText;						
							document.getElementById("ISBNnum").value =rowElement.cells[9].innerText;						
							 document.getElementById("update5").value = 'Update';
							break;
						}					
					}
			}
			
		function fnEditdatapatent(pubId) {
					var gvET = document.getElementById("grdpublistpatent");
					var rCount = gvET.rows.length;
					var rowIdx;
					 for (rowIdx=1; rowIdx<=rCount-1; rowIdx++) {						
						var rowElement = gvET.rows[rowIdx];
						if (parseInt(rowElement.cells[1].innerText) ==parseInt(pubId)){									
							document.getElementById("lblpatid").value =rowElement.cells[1].innerText;
							document.getElementById("patenttitle").value =rowElement.cells[2].innerText;
							document.getElementById("authrs1").value =rowElement.cells[3].innerText;
							document.getElementById("pyear").value =rowElement.cells[4].innerText;							
							document.getElementById("patentnumber").value =rowElement.cells[5].innerText;					
							document.getElementById("pcountry").value =rowElement.cells[6].innerText;						
							document.getElementById("Filed_Published").value =rowElement.cells[7].innerText;
							document.getElementById("paturl").value =rowElement.cells[8].innerText;								
							document.getElementById("update7").value = 'Update';
							
							break;
						}					
					}
			}
		function fnEditdataindustry(indusid) {
					var gvET = document.getElementById("grdlistindustry");
					var rCount = gvET.rows.length;
					var rowIdx;
					for (rowIdx=1; rowIdx<=rCount-1; rowIdx++) {						
						var rowElement = gvET.rows[rowIdx];
						if (parseInt(rowElement.cells[1].innerText) ==parseInt(indusid)){
				
							document.getElementById("lblindusid").value =rowElement.cells[1].innerText;
							document.getElementById("industry").value =rowElement.cells[2].innerText;
							//alert(rowElement.cells[3].innerText);
							$('#datepicker6').datepicker('setDate', rowElement.cells[3].innerText);
							$('#datepicker7').datepicker('setDate', rowElement.cells[4].innerText);
							document.getElementById("numofyrs").value =rowElement.cells[5].innerText;					
							document.getElementById("update9").value = 'Update';
							break;
						}					
					}
			}
		function fnEditDatasponsProjs(projid) {
					var gvET = document.getElementById("grdlistsponsprojs");
					var rCount = gvET.rows.length;
					var rowIdx;
					for (rowIdx=1; rowIdx<=rCount-1; rowIdx++) {						
						var rowElement = gvET.rows[rowIdx];
						if (parseInt(rowElement.cells[1].innerText) ==parseInt(projid)){
				
							document.getElementById("lblprojid").value =rowElement.cells[1].innerText;
							document.getElementById("ddlAcadYear").value =rowElement.cells[2].innerText;
							document.getElementById("projtitle").value =rowElement.cells[3].innerText;
							document.getElementById("fundagency").value =rowElement.cells[4].innerText;					
							document.getElementById("fundamt").value =rowElement.cells[5].innerText;					
							document.getElementById("datepicker4").value =rowElement.cells[6].innerText;
							document.getElementById("currstatus").value =rowElement.cells[7].innerText;					
							document.getElementById("update10").value = 'Update';
							break;
						}					
					}
			}
		function fnEditDataconservices(conid) {
					var gvET = document.getElementById("grdlistconservices");
					var rCount = gvET.rows.length;
					var rowIdx;
					for (rowIdx=1; rowIdx<=rCount-1; rowIdx++) {						
						var rowElement = gvET.rows[rowIdx];
						if (parseInt(rowElement.cells[1].innerText) ==parseInt(conid)){
				
							document.getElementById("lblconid").value =rowElement.cells[1].innerText;
							document.getElementById("ddlCAcadYear").value =rowElement.cells[2].innerText;
							document.getElementById("conprv").value =rowElement.cells[3].innerText;
							document.getElementById("natofcon").value =rowElement.cells[4].innerText;					
							document.getElementById("brdesc").value =rowElement.cells[5].innerText;			
							document.getElementById("concurrstatus").value =rowElement.cells[7].innerText;					
							document.getElementById("datepicker5").value =rowElement.cells[6].innerText;
							document.getElementById("update11").value = 'Update';
							break;
						}					
					}
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
					}).datepicker({ dateFormat: 'dd-M-yy' , view: 'years' });
					$('.dobdate').attr("required","required");
					document.getElementById('lblpubid').value= "0";
					document.getElementById('lblbookid').value= "0";
					document.getElementById('lblpatid').value= "0";
					document.getElementById('lblindusid').value= "0";
					document.getElementById('lblprojid').value= "0";
					document.getElementById('lblconid').value= "0";
					document.getElementById('lblrconid').value= "0";
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


// function checkDelete($patid){
	// alert('hi');
    // return confirm('Are you sure?');
// }
		</script>	
 <script type="text/javascript">
			// $(document).ready(function () {
				// //Disable cut copy paste
				// $('body').bind('cut copy paste', function (e) {
					// e.preventDefault();
				// });
			   
				// //Disable mouse right click
				// $("body").on("contextmenu",function(e){
					// return false;
				// });
			// });
			// function disableF5(e) { if ((e.which || e.keyCode) == 116) e.preventDefault(); };
			// $(document).on("keydown", disableF5);

			// // simply visual, let's you know when the correct iframe is selected
			// $(window).on("focus", function(e) {
				// $("html, body").css({ background: "#FFF", color: "#000" })
				// .find("h2").html("THIS BOX NOW HAS FOCUS<br />F5 should not work.");
			// })
			// .on("blur", function(e) {
				// $("html, body").css({ background: "", color: "" })
				// .find("h2").html("CLICK HERE TO GIVE THIS BOX FOCUS BEFORE PRESSING F5");
			// });
 </script>

</head> 
<body> 
<br/><br/><br/>
<?php
if(!isset($_SESSION)){
	session_start();
}
IF(!isset($_SESSION["SESSUserID"]))
	header('Location: login.php?'); 
include 'db/db_connect.php';
// $bookpubid = "I";
	if (isset($_POST['chk'])) {
				$checkact = '1';
	}
	else{
		$checkact = '0';
	}
	$edit_record1=$_SESSION["SESSUserID"];
	if(isset($_POST['update12'])){
	if($_POST['lblrconid'] == '0'){
			
			//--------------------Professional Exp Insert-----------------------------------------------------------
			include 'db/db_connect.php';
			// if($bookpubid == "I") {
			$stmt = $mysqli->prepare("INSERT INTO `tblresearchcon`(areaofsp,numofpgstuds,numofphdstuds,anyotherachiev,profid)

			VALUES (?, ?, ?, ?, ?)");
			// }
			$stmt->bind_param('siisi', $_POST['areaofspcl'],$_POST['numofpgstuds'],$_POST['numofphdstuds'],$_POST['otherachiev'],
			$_SESSION["SESSUserID"]);
			$stmt->execute(); 
			$stmt->close();
			//-------------------------------------------------------------------------------		
		}
	
		else{
			$ar=addslashes($_POST['areaofspcl']);
			$pgstud=addslashes($_POST['numofpgstuds']);
			$phdstud=addslashes($_POST['numofphdstuds']);
			$otherachievements=addslashes($_POST['otherachiev']);
			$query25="update tblresearchcon set areaofsp='$ar',numofpgstuds='$pgstud',numofphdstuds='$phdstud',anyotherachiev='$otherachievements'
			
			where profid = " . $_SESSION["SESSUserID"] . " and rconid=" . $_POST['lblrconid'] . "";
			// }
			//echo $query25;
			mysqli_query($mysqli, $query25);
		}		
		echo '<script>alert("UPDATED SUCCESSFULLY");</script>';
}

	
if(isset($_POST['update1'])){
	$stu_name=addslashes($_POST['Surname']);
	$fir_name=addslashes($_POST['First_Name']);
	$far_name=addslashes($_POST['Father_Name']);
	$dofb=addslashes($_POST['d_ob']);
	$mar_name=addslashes($_POST['mother_name']);
	$hus_name=addslashes($_POST['husband_name']);
	$MothrFull_name=addslashes($_POST['MothrFull_Name']);
	$City_name1=$_POST['city_name1'];
	$distr_1=$_POST['dist_1'];
	$vill_1=$_POST['vill_age1'];
	$pincode_1=$_POST['pincode_num1'];
	$h_add1=$_POST['h_addr1'];
	$h_add2=$_POST['h_addr2'];
	$City_name_2=$_POST['city_name2'];
//	$act=$_POST['sameadd'];
	$distr_2=$_POST['dist_2'];
	$vill_2=$_POST['vill_age2'];
	$pincode_2=$_POST['pincode_num2'];
	//$h_add2=$_POST['h_addr2'];
	
	if(!isset($_POST['blood_grp']))
		$blodg = $_SESSION["bg"];
	else
		$blodg=$_POST['blood_grp'];

	$na=$_POST['nationality'];
	$re=addslashes($_POST['religion']);
	
	if(!isset($_POST['caste']))
		$cs = $_SESSION["cas"];
	else
		$cs = $_POST['caste'];
	
	$mu=$_POST['married_unmarried'];
	$sm=$_POST['Stu_Mobile'];
	$emob=$_POST['Stu_Emegcontact'];
	$landineno=$_POST['Stu_Landlineno'];
	$clgext=$_POST['clg_ext'];
	$sgender=$_POST['male_female'];	
	$se=$_POST['stu_email'];
	$pe=$_POST['Pmail'];
	//$dept=$_POST['dpt'];
	$jdate=$_POST['joiningdate'];

	$query1="update tbluser 
	set LastName='$stu_name',
	FirstName='$fir_name',FatherName='$far_name',
	MotherName='$mar_name', HusbandName='$hus_name',MothrFullName='$MothrFull_name',City1='$City_name1',District1='$distr_1',Village1='$vill_1',addr1='$h_add1',addr2='$h_add2',
	City2='$City_name_2',
	District2='$distr_2',Village2='$vill_2',Pincode1='$pincode_1',
	Pincode2='$pincode_2',ContactNumber='$sm',emerg_cntactnum='$emob',
	LandlineNo='$landineno',collgext='$clgext',Gender='$sgender',
	Blood_group='$blodg',Nationality='$na',Religion='$re',Caste_subcaste='$cs',Status='$mu',DOB='$dofb',
	Email='$se',Pmail='$pe',dateofjoining='$jdate'";

	$query1 = $query1 . " where userID=$edit_record1";
	//echo $query1;
	mysqli_query($mysqli, $query1);
	
	echo '<script>alert("UPDATED SUCCESSFULLY");</script>';
}
if(isset($_POST['update2'])){
	//qualifications for UG
	$dg_name=addslashes($_POST['deg_name']);
	$brnch_name=addslashes($_POST['Branch_name']);
	$clas_name=addslashes($_POST['clas_name']);
	$mksobt=addslashes($_POST['mks_obt']);
	$mksout=addslashes($_POST['mks_out']);
	$percen=addslashes($_POST['percen_name']);
	$yr_passing=addslashes($_POST['yrof_pas']);
	$univ_name=addslashes($_POST['uni_name']);
	$colg_name=addslashes($_POST['clg_name']);
	
	//qualifications for UG
	$pgdg_name=addslashes($_POST['pgdeg_name']);
	$pgbrnch_name=addslashes($_POST['pgBranch_name']);
	$pgclas_name=addslashes($_POST['pgclas_name']);
	$pgmksobt=addslashes($_POST['pgmks_obt']);
	$pgmksout=addslashes($_POST['pgmks_out']);
	$pgercen=addslashes($_POST['pgpercen_name']);
	$pgyr_passing=addslashes($_POST['pgpgyrof_pas']);
	$pguniv_name=addslashes($_POST['pguni_name']);
	$pgcolg_name=addslashes($_POST['pgclg_name']);
	
	//phdQual
	
	$b_name=addslashes($_POST['brnchnam']);
	$u_name=addslashes($_POST['university_name']);
	$guide=addslashes($_POST['guide_name']);
	$regdate=addslashes($_POST['reg_date']);
	$decdate=addslashes($_POST['dec_date']);
	$phd_title=addslashes($_POST['title']);
	$phd_domain=addslashes($_POST['domain']);
	
	//10th/12th/diploma
	
	$i_name=addslashes($_POST['institution_name']);
	$yearstart=addslashes($_POST['passingyear']);
	$mObt=addslashes($_POST['mksobt']);
	$mOut=addslashes($_POST['mksout']);
	$classname=addslashes($_POST['cls_name']);
	$perc=addslashes($_POST['percent']);
//	$tact=addslashes($_POST['chk']);
	
	$ti_name=addslashes($_POST['instiname']);
	$tyearstart=addslashes($_POST['tpassingyear']);
	$tmObt=addslashes($_POST['tmksobt']);
	$tmOut=addslashes($_POST['tmksout']);
	$tclassname=addslashes($_POST['tclas_name']);
	$tperc=addslashes($_POST['tpercent']);

	$di_name=addslashes($_POST['dinstiname']);
	$dyearstart=addslashes($_POST['dpassingyear']);
	$dmObt=addslashes($_POST['dmksobt']);
	$dmOut=addslashes($_POST['dmksout']);
	$dclassname=addslashes($_POST['dclas_name']);
	$dperc=addslashes($_POST['dpercent']);

	
	$query2="update profqual set Degree='$dg_name',
	Branch='$brnch_name',class='$clas_name',mobt='$mksobt',mout='$mksout',Percentage='$percen',YearOfPassing='$yr_passing',
	nameofuni='$univ_name',nameofcollage='$colg_name' where ProfId=$edit_record1 and degtype='UG'";
	//echo $query2;
	mysqli_query($mysqli, $query2);
	$query4="update profqual set Degree='$pgdg_name',
	Branch='$pgbrnch_name',class='$pgclas_name',mobt='$pgmksobt',mout='$pgmksout',Percentage='$pgercen',
	YearOfPassing='$pgyr_passing',nameofuni='$pguniv_name',nameofcollage='$pgcolg_name'
	  where ProfId=$edit_record1 and degtype='PG'";
	  
	mysqli_query($mysqli, $query4);
	// END  - FOR QUAL
	
	
	//for phdQual
	
	$query6="update phdqual set branch='$b_name',university='$u_name',guidename='$guide',
	DofReg='$regdate',dofdec='$decdate',title='$phd_title',domain='$phd_domain' where ProfId=$edit_record1 and degtype='PHD'";
	//echo $query6;
	mysqli_query($mysqli, $query6);
	
	//for 10th/12th/diploma
	
	$query10="update profqual2 set insti_name='$i_name',year='$yearstart',mobt='$mObt',
	mout='$mOut',class='$classname',Percentage='$perc' where ProfId=$edit_record1 and Exam_name='10th'";
	//echo $query10;
	mysqli_query($mysqli, $query10);

	$query12="update profqual2 set insti_name='$ti_name',year='$tyearstart',mobt='$tmObt',
	mout='$tmOut',class='$tclassname',Percentage='$tperc' where ProfId=$edit_record1 and Exam_name='12th'";
	//echo $query12;
	mysqli_query($mysqli, $query12);
	
	$query14="update profqual2 set insti_name='$di_name',year='$dyearstart',mobt='$dmObt',
	mout='$dmOut',class='$dclassname',Percentage='$dperc' where ProfId=$edit_record1 and Exam_name='Diploma'";
	//echo $query14;
	mysqli_query($mysqli, $query14);

	echo '<script>alert("UPDATED SUCCESSFULLY");</script>';
}
if(isset($_POST['update9'])){
	// -----  exp file upload START
		$hasfile = 0;
		if(is_uploaded_file($_FILES['fileToUpload']['tmp_name'])) {
			$errors     = array();
			//$maxsize    = 2097152;
			$maxsize    = 250000;
			$acceptable = array('image/gif','image/jpg','image/png','image/jpeg','application/pdf');
			if((strpos($_FILES['fileToUpload']['name'],' ') > 0) || (strpos($_FILES['fileToUpload']['name'],'(') > 0) || 
						(strpos($_FILES['fileToUpload']['name'],')') > 0)) {
				$errors[] = 'File name invalid. Please remove any spaces or brackets.';
			}

			if(($_FILES['fileToUpload']['size'] >= $maxsize) || ($_FILES["fileToUpload"]["size"] == 0)) {
				$errors[] = 'File too large. File must be less than 250KB.';
			}

			if((!in_array($_FILES['fileToUpload']['type'], $acceptable)) && (!empty($_FILES["fileToUpload"]["type"]))) {
				$errors[] = 'Invalid file type. Only an Image or PDF is accepted.';
			}
			if(count($errors) === 0) {
				$info = pathinfo($_FILES['fileToUpload']['name']);
				 $ext = $info['extension']; // get the extension of the file
				 $filename = $_FILES['fileToUpload']['name'];
				$newname = $_SESSION["SESSUserID"] . '-' . $filename; 
				 $target = 'profexp/'.$newname;
				 move_uploaded_file( $_FILES['fileToUpload']['tmp_name'], $target);
				 $hasfile = 1;
			}
			else {
					foreach($errors as $error) {
						echo "<br/><pre>$error</pre>";
						echo "<br/><pre>Please re-enter all information or click Edit again.</pre>";
					}
					goto exitsave1;
			}
		}
	// -----  exp file upload END
	
	
	if($_POST['lblindusid'] == '0'){
			//--------------------Professional Exp Insert-----------------------------------------------------------
			include 'db/db_connect.php';
			// if($bookpubid == "I") {
			$stmt = $mysqli->prepare("INSERT INTO tblprofexp(industry,datefrom,dateto,numofyrs,profid,profexpdocument)

			VALUES (?, ?, ?, ?, ?,?)");
			// }
			
			$stmt->bind_param('ssssis', $_POST['industry'], 
			$_POST['datefrom'],
			$_POST['dateto'],
			$_POST['numofyrs'],
			$_SESSION["SESSUserID"],
			$target);
			$stmt->execute(); 
			$stmt->close();
			//-------------------------------------------------------------------------------		
		}
		else{
			$indus=addslashes($_POST['industry']);
			$datefrom=addslashes($_POST['datefrom']);  
			$dateto=addslashes($_POST['dateto']); 
			$numofyrs=addslashes($_POST['numofyrs']);
			$profexpdocument=addslashes($target);
			if($hasfile == 1)
				$query19="update tblprofexp set industry='$indus',datefrom='$datefrom',
				dateto='$dateto',numofyrs='$numofyrs', profexpdocument = '$profexpdocument'
				where profid = " . $_SESSION["SESSUserID"] . " and industryid=" . $_POST['lblindusid'] . "";
			else
				$query19="update tblprofexp set industry='$indus',datefrom='$datefrom',
				dateto='$dateto',numofyrs='$numofyrs'
				where profid = " . $_SESSION["SESSUserID"] . " and industryid=" . $_POST['lblindusid'] . "";
				
			// }
			//echo $query19;
			mysqli_query($mysqli, $query19);
		}		
		echo '<script>alert("UPDATED SUCCESSFULLY");</script>';
}

exitsave1: if(isset($_POST['update10'])){
	
		// -----  exp file upload START
		$hasfile = 0;
		if(is_uploaded_file($_FILES['fileToUploadsponproj']['tmp_name'])) {
			$errors     = array();
			//$maxsize    = 2097152;
			$maxsize    = 250000;
			$acceptable = array('image/gif','image/jpg','image/png','image/jpeg','application/pdf');
			if((strpos($_FILES['fileToUploadsponproj']['name'],' ') > 0) || (strpos($_FILES['fileToUploadsponproj']['name'],'(') > 0) || 
						(strpos($_FILES['fileToUploadsponproj']['name'],')') > 0)) {
				$errors[] = 'File name invalid. Please remove any spaces or brackets.';
			}

			if(($_FILES['fileToUploadsponproj']['size'] >= $maxsize) || ($_FILES["fileToUploadsponproj"]["size"] == 0)) {
				$errors[] = 'File too large. File must be less than 250KB.';
			}

			if((!in_array($_FILES['fileToUploadsponproj']['type'], $acceptable)) && (!empty($_FILES["fileToUploadsponproj"]["type"]))) {
				$errors[] = 'Invalid file type. Only an Image or PDF is accepted.';
			}
			if(count($errors) === 0) {
				$info = pathinfo($_FILES['fileToUploadsponproj']['name']);
				 $ext = $info['extension']; // get the extension of the file
				 $filename = $_FILES['fileToUploadsponproj']['name'];
				$newname = $_SESSION["SESSUserID"] . '-' . $filename; 
				 $target = 'profsponproj/'.$newname;
				 move_uploaded_file( $_FILES['fileToUploadsponproj']['tmp_name'], $target);
				 $hasfile = 1;
			}
			else {
					foreach($errors as $error) {
						echo "<br/><pre>$error</pre>";
						echo "<br/><pre>Please re-enter all information or click Edit again.</pre>";
					}
					goto exitsave2;
			}
		}
	// -----  exp file upload END
	
	
	
	
	if($_POST['lblprojid'] == '0'){
			//--------------------Sponsored Projects Insert-----------------------------------------------------------
			include 'db/db_connect.php';
			// if($bookpubid == "I") {
			$stmt = $mysqli->prepare("INSERT INTO tblsponsoredprojs(acadyear,Titleofproj,fundingagency,fundingamount,datesanctioned,currstatus,profid,profsponprojocument)
			VALUES (?, ?, ?, ?, ?, ?, ?,?)");
			// }
			$stmt->bind_param('ssssssis',$_POST['ddlAcadYear'], $_POST['projtitle'], 
			$_POST['fundagency'],
			$_POST['fundamt'],
			$_POST['datesnactioned'],
			$_POST['currstatus'],
			$_SESSION["SESSUserID"],
			$target);
			$stmt->execute(); 
			$stmt->close();
			//-------------------------------------------------------------------------------		
		}
		else{
			$pacadyear=addslashes($_POST['ddlAcadYear']);
			$ptitle=addslashes($_POST['projtitle']);
			$fundage=addslashes($_POST['fundagency']);  
			$famount=addslashes($_POST['fundamt']); 
			$dtsnactioned=addslashes($_POST['datesnactioned']);
			$curstatus=addslashes($_POST['currstatus']);
			$profsponprojocument=addslashes($target);

			if($hasfile == 1)
				$query20="update tblsponsoredprojs set acadyear='$pacadyear',Titleofproj='$ptitle',fundingagency='$fundage',
				fundingamount='$famount',datesanctioned='$dtsnactioned',currstatus='$curstatus',profsponprojocument = '$profsponprojocument'
				where profid = " . $_SESSION["SESSUserID"] . " and projid=" . $_POST['lblprojid'] . "";
			else
				$query20="update tblsponsoredprojs set acadyear='$pacadyear',Titleofproj='$ptitle',fundingagency='$fundage',
				fundingamount='$famount',datesanctioned='$dtsnactioned',currstatus='$curstatus'
				where profid = " . $_SESSION["SESSUserID"] . " and projid=" . $_POST['lblprojid'] . "";
				
			// }
			//echo $query19;
			mysqli_query($mysqli, $query20);
		}		
		echo '<script>alert("UPDATED SUCCESSFULLY");</script>';
	
}
exitsave2: if(isset($_POST['update11'])){
	
			// -----  exp file upload START
		$hasfile = 0;
		if(is_uploaded_file($_FILES['fileToUploadcon']['tmp_name'])) {
			$errors     = array();
			//$maxsize    = 2097152;
			$maxsize    = 250000;
			$acceptable = array('image/gif','image/jpg','image/png','image/jpeg','application/pdf');
			if((strpos($_FILES['fileToUploadcon']['name'],' ') > 0) || (strpos($_FILES['fileToUploadcon']['name'],'(') > 0) || 
						(strpos($_FILES['fileToUploadcon']['name'],')') > 0)) {
				$errors[] = 'File name invalid. Please remove any spaces or brackets.';
			}

			if(($_FILES['fileToUploadcon']['size'] >= $maxsize) || ($_FILES["fileToUploadcon"]["size"] == 0)) {
				$errors[] = 'File too large. File must be less than 250KB.';
			}

			if((!in_array($_FILES['fileToUploadcon']['type'], $acceptable)) && (!empty($_FILES["fileToUploadcon"]["type"]))) {
				$errors[] = 'Invalid file type. Only an Image or PDF is accepted.';
			}
			if(count($errors) === 0) {
				$info = pathinfo($_FILES['fileToUploadcon']['name']);
				 $ext = $info['extension']; // get the extension of the file
				 $filename = $_FILES['fileToUploadcon']['name'];
				$newname = $_SESSION["SESSUserID"] . '-' . $filename; 
				 $target = 'profcon/'.$newname;
				 move_uploaded_file( $_FILES['fileToUploadcon']['tmp_name'], $target);
				 $hasfile = 1;
			}
			else {
					foreach($errors as $error) {
						echo "<br/><pre>$error</pre>";
						echo "<br/><pre>Please re-enter all information or click Edit again.</pre>";
					}
					goto exitsave3;
			}
		}
	// -----  exp file upload END
	
	
	if($_POST['lblconid'] == '0'){
			//--------------------Consultancy Services Insert-----------------------------------------------------------
			include 'db/db_connect.php';
			// if($bookpubid == "I") {
			$stmt = $mysqli->prepare("INSERT INTO tblconservices(conacadyear,conserprovidedto,natureofcon,bdesc,dsanc,constatus,profid,profcondocument)
			VALUES (?, ?, ?, ?, ?, ?, ?,?)");
			// }
			
			$stmt->bind_param('ssssssis', $_POST['ddlCAcadYear'], $_POST['conprv'],$_POST['natofcon'],
			$_POST['brdesc'],
			$_POST['cdatesnactioned'],
			$_POST['concurrstatus'], 
			$_SESSION["SESSUserID"],
			$target);
			$stmt->execute(); 
			$stmt->close();
			//-------------------------------------------------------------------------------		
		}
		else{
			$Cacadyear=addslashes($_POST['ddlCAcadYear']);
			$ptle=addslashes($_POST['conprv']);
			$natureofcon=addslashes($_POST['natofcon']);  
			$briefdesc=addslashes($_POST['brdesc']); 
			$condatesnactioned=addslashes($_POST['cdatesnactioned']);
			$concurstatus=addslashes($_POST['concurrstatus']);
			$profcondocument=addslashes($target);

			if($hasfile == 1)
				$query21="update tblconservices set conacadyear='$Cacadyear',conserprovidedto='$ptle',natureofcon='$natureofcon',
				bdesc='$briefdesc',dsanc='$condatesnactioned',constatus='$concurstatus', profcondocument = '$profcondocument'
				where profid = " . $_SESSION["SESSUserID"] . " and conid=" . $_POST['lblconid'] . "";
			else
				$query21="update tblconservices set conacadyear='$Cacadyear',conserprovidedto='$ptle',natureofcon='$natureofcon',
				bdesc='$briefdesc',dsanc='$condatesnactioned',constatus='$concurstatus'
				where profid = " . $_SESSION["SESSUserID"] . " and conid=" . $_POST['lblconid'] . "";
				
				mysqli_query($mysqli, $query21);
		}		
		echo '<script>alert("UPDATED SUCCESSFULLY");</script>';
}
exitsave3: if(isset($_POST['update3'])){
	//Salary Bank Details
	$bnk_name=addslashes($_POST['bankname']);
	$bnch_name=addslashes($_POST['branchname']);
	$acc_num=addslashes($_POST['accnum']);
	$ifscnum=addslashes($_POST['IFScode']);
	$micrnum=addslashes($_POST['MICRnum']);
	$pfnum=addslashes($_POST['PFnum']);
	//for bank salary details
	$query8="update profbankdet set bank_name='$bnk_name',branch_name='$bnch_name',acc_no='$acc_num',
	IFSC_code='$ifscnum',MICR_no='$micrnum',PF_no='$pfnum' where ProfId=$edit_record1";
	mysqli_query($mysqli, $query8);
	echo '<script>alert("UPDATED SUCCESSFULLY");</script>';
}
if(isset($_POST['update4'])){
	if($_POST['lblpubid'] == '0'){
		//-------------------Journal Insert------------------------------------------------------------
		include 'db/db_connect.php';
		// if($bookpubid == "I") {
		$stmt = $mysqli->prepare("INSERT INTO tblpublications(pubtype,papertitle,authors1,Journalname,journlpub,
		volume,pages,year,month,doi,url,impactfactor,abstract,paperstatus,internjournal,openacjournal,peer,ISSN,userid) 
		VALUES (?, ?, ?, ?, ?,?, ?, ?, ?, ?,?, ?, ?, ?, ?, ?, ?, ?, ?)");
		$stmt->bind_param('ssssssssssssssssssi', $_POST['journal_conf'], $_POST['papertitle'], 
		$_POST['authors1'],$_POST['Journalname'],$_POST['journalpub'],$_POST['vol'],$_POST['pages'],$_POST['conyear'],$_POST['month'],
		$_POST['Doi'],$_POST['Url'],$_POST['impctFactor'],$_POST['abstract'],$_POST['Press_Published'],
		$_POST['Yes_no'],$_POST['y_n'],$_POST['ys_No'],$_POST['ISSNnum'],$_SESSION["SESSUserID"]);
		$stmt->execute(); 
		$stmt->close();
	}
	else{
		$pubtype=addslashes($_POST['journal_conf']);
		$paptitle=addslashes($_POST['papertitle']);
		$bookauthors=addslashes($_POST['authors1']);
		$jname=addslashes($_POST['Journalname']);
		$jpubname=addslashes($_POST['journalpub']);
		$pvol=addslashes($_POST['vol']);
		$jpages=addslashes($_POST['pages']);
		$jyear=addslashes($_POST['conyear']);
		$jmonth=addslashes($_POST['month']);
		$jDoi=addslashes($_POST['Doi']);
		$JUrl=addslashes($_POST['Url']);
		$impctFactor=addslashes($_POST['impctFactor']);
		$abstract=addslashes($_POST['abstract']);
		$paperst=$_POST['Press_Published'];	
		$interj=$_POST['Yes_no'];	
		$openacess=$_POST['y_n'];
		$peer=$_POST['ys_No'];
		$ISSN_no=addslashes($_POST['ISSNnum']);
		$query16="update tblpublications set pubtype='$pubtype',papertitle='$paptitle',authors1='$bookauthors',
		Journalname='$jname',journlpub='$jpubname',volume='$pvol',
		pages='$jpages',
		year='$jyear',month='$jmonth',doi='$jDoi',url='$JUrl',
		impactfactor='$impctFactor',abstract='$abstract',paperstatus='$paperst',internjournal='$interj',
		openacjournal='$openacess',peer='$peer',ISSN='$ISSN_no' where bookpubid=" . $_POST['lblpubid']. "
		and userid = " . $_SESSION["SESSUserID"] . "";
		mysqli_query($mysqli, $query16);		
	}	
	echo '<script>alert("UPDATED SUCCESSFULLY");</script>';
}
/////////for book
if(isset($_POST['update7'])){
		if($_POST['lblpatid'] == '0'){
			//--------------------Patent Insert-----------------------------------------------------------
			include 'db/db_connect.php';
			// if($bookpubid == "I") {
			$stmt = $mysqli->prepare("INSERT INTO tblpubpatent(patenttitle,author,pnum,country,year1,pstatus,paturl,userid)
			VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
			// }
			$stmt->bind_param('sssssssi', $_POST['patenttitle'], 
			$_POST['authrs1'],
			$_POST['patentnumber'],
			$_POST['pcountry'],
			$_POST['pyear'],$_POST['Filed_Published'],
			$_POST['paturl'],$_SESSION["SESSUserID"]);
			$stmt->execute(); 
			$stmt->close();
			//-------------------------------------------------------------------------------		
		}
		else{
			$patenttitle=addslashes($_POST['patenttitle']);
			$auth=addslashes($_POST['authrs1']);  
			$patentnumber=addslashes($_POST['patentnumber']); 
			$pcountry=addslashes($_POST['pcountry']);
			$year1=addslashes($_POST['pyear']);	//$filename=addslashes($_POST['Filename']);
			$patentst=$_POST['Filed_Published'];
			$patantURL=addslashes($_POST['paturl']);
			$query18="update tblpubpatent set patenttitle='$patenttitle',author='$auth',
			pnum='$patentnumber',country='$pcountry',year1='$year1',pstatus='$patentst',
			paturl='$patantURL' where bookpubid=" . $_POST['lblpatid'] . "
			and userid = " . $_SESSION["SESSUserID"] . "";
			mysqli_query($mysqli, $query18);
		}		
		echo '<script>alert("UPDATED SUCCESSFULLY");</script>';
}
if(isset($_POST['update5'])){
	if($_POST['lblbookid'] == '0'){
		//--------------------Book Insert-----------------------------------------------------------
		include 'db/db_connect.php';
		// if($bookpubid == "I") {
		$stmt = $mysqli->prepare("INSERT INTO tblpublbook(bktitle,pauthor,publisher,Editors,addr,bookurl,byear,ISBN,userid)
		VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
		$stmt->bind_param('ssssssssi', $_POST['booktitle'], 
		$_POST['bauthrs'],
		$_POST['publish'],
		$_POST['bedition'],
		$_POST['addr'],$_POST['bookurl'],$_POST['bookyear'],$_POST['ISBNnum'],$_SESSION["SESSUserID"]);
		$stmt->execute(); 
		$stmt->close();
	}
	else{
		//for book
		$booktitle=addslashes($_POST['booktitle']);
		$bookauthor=addslashes($_POST['bauthrs']);
		$pub=addslashes($_POST['publish']);
		$edition=addslashes($_POST['bedition']);
		$addr=addslashes($_POST['addr']);  
		$bkurl=addslashes($_POST['bookurl']);
		$bookYear=addslashes($_POST['bookyear']);
		$isbn=addslashes($_POST['ISBNnum']);
		$query17="update tblpublbook set bktitle='$booktitle',pauthor='$bookauthor',
		publisher='$pub',Editors='$edition',addr='$addr',bookurl='$bkurl',byear='$bookYear',ISBN='$isbn' where bookpubid=" . $_POST['lblbookid'] . " and userid = " . $_SESSION["SESSUserID"] . "";
		mysqli_query($mysqli, $query17);		
	}
	echo '<script>alert("UPDATED SUCCESSFULLY");</script>';
}
/*
if(isset($_POST['Confirm']))
{
	$edit_record1=$_SESSION["SESSStdId"];
	$query7="update tbluser set CFLAG='1'
	 where StdId='$edit_record1'";	 
	mysqli_query($mysqli, $query7);
}
*/
$edit_record = $_SESSION["SESSUserID"];
    $edit_id="";
	$Stuname="";
	$Finame="";
	$Faname="";
	$Mname="";
	$Hbname="";
	$MFname="";
	$Cityname1="";
	$Dis1="";
	$vil1="";
	$pin1="";
	$praddr="";
	$Cityname2="";
	$Dis2="";
	$vil2="";
	$pin2="";
	$perddr="";
	$Sameadd="";
	$mb="";
	$PMail="";
	$Emeg_mb="";
	$landline_num="";
	$cext="";
	$gen="";
	// echo $gen;
	$bg="";
	$mt="";
	$nat="";
	$reli="";
	$cas="";
	$sts="";	
	$email="";
	$pe="";
	$dept="";
	$desig="";
	$jdate="";
	$lst="";
	$dob="";
	$em="";
	$CFLAG="";
	//-----------personal details
	include 'db/db_connect.php';
	$sql="SELECT LastName, FirstName,FatherName,MotherName,
		HusbandName,MothrFullName,City1,District1,Village1,Pincode1,addr1,addrcheck,City2,District2,Village2,
		Pincode2,addr2,ContactNumber,emerg_cntactnum,LandlineNo,collgext,Gender,Blood_group,
		Nationality,Religion,Caste_subcaste,Status,DOB,Email,Pmail,Department,d.Designation as Designame,dateofjoining
		FROM tbluser u
		inner join tbldesignationmaster d on d.DesigID = u.Designation
		WHERE u.userID = '". $_SESSION["SESSUserID"]. "'";
		//echo $sql;
		$result = $mysqli->query( $sql );
		$num_results = $result->num_rows;
		$fd="";
		$sd="";
		$d="";
		if( $num_results ){
							while( $row = $result->fetch_assoc() ){
							extract($row);
	
						$Stuname=$LastName;
						$Finame=$FirstName;
						$Faname=$FatherName;
						$dob=$DOB;
						$Mname=$MotherName;
						$Hbname=$HusbandName;
						$MFname=$MothrFullName;
						$Cityname1=$City1;
						$Dis1=$District1;
						$vil1=$Village1;
						$pin1=$Pincode1;
						$praddr=$addr1;
						$Cityname2=$City2;
						$Dis2=$District2;
						$vil2=$Village2;
						$pin2=$Pincode2;
						$perddr=$addr2;
						$Sameadd=$addrcheck;
						$mb=$ContactNumber;
						$Emeg_mb=$emerg_cntactnum;
						$landline_num=$LandlineNo;
						$cext=$collgext;
						$gen=$Gender;
						$bg=$Blood_group;
						$nat=$Nationality;
						$reli=$Religion;
						$cas=$Caste_subcaste;
						$sts=$Status;
						$email=$Email;
						$pe=$Pmail;
						$dept=$Department;
						$desig=$Designame;
						$jdate=$dateofjoining;
							}
		}
				$result->free();
				$mysqli->close();
				
		
						
//-------------------------------------------------------------------------------

	
	
	//qual
	$degname="";
	$branchname="";
	$clasname="";
	$mobtname="";
	$moutname="";
	$yrofpasname="";
	$pername="";
	$univname="";
	$colname="";
	
	$pgdegname="";
	$pgbranchname="";
	$pgclasname="";
	$pgmobtname="";
	$pgmoutname="";
	$pgyrofpasname="";
	$pgpername="";
	$pgunivname="";
	$pgcolname="";
	
	//phdqual
	$branchnm="";
	$uni="";
	$guidenm="";
	$reg="";
	$dec="";
	
	//10th/12th
	$exam="";
	$nameofinsti="";
	$yearofpas="";
	$marksobt="";
	$marksout="";
	$clas="";
	$percen="";
	$checkact="";
	
	$texam="";
	$tnameofinsti="";
	$tyearofpas="";
	$tmarksobt="";
	$tmarksout="";
	$tclas="";
	$tpercen="";
	$tcheckact="";
	
	$dexam="";
	$dnameofinsti="";
	$dyearofpas="";
	$dmarksobt="";
	$dmarksout="";
	$dclas="";
	$dpercen="";
	$dcheckact="";

	//Bank Details
	
	$banknm="";
	$brnm="";
	$accno="";
	$ifsc="";
	$micr="";
	$pf="";

	//Book Publications
	$pid=0;
	// $lstname="";
	// $ftname="";
	// $midlename="";
	// $titleofbook="";
	// $publyear="";
	// $bookEditors="";
	// $bkpages="";
	
	// $pubplace="";
	// $bkpublisher="";
	$isbnnum="";
	$issnnum="";
	$websiteaddr="";
	$fileupld="";

	
	//for journal
	$bookid="";
	$paperstat="";
	$bkauth="";
	$Journalname="";
	$jpub="";
	$pvolume="";
	$pages="";
	$confyear="";
	$month="";
	$Doi="";
	$Url="";
	$ifac= "";
	$abstct="";
	$editin="";
	
	$interjnl="";
	$openaccess="";
	$peer="";
	$ptitle="";
	$bkaddr="";
	$pubid="";
	$ptype="";
	
	//for book-----------
	
	$btitle="";
	$bookauth="";
	$bkedit="";
	$pub="";
	$baddr="";
	$bUrl="";
	$byear="";
	//-------------------
	$tpatent="";
	$bkauth1="";
	$patentnum="";
	$country="";
	$pyr="";
	$patentstat="";
	$pUrl="";
	$patid="";
//	--------------------
	$pindustry="";
	$pdatefrom="";
	$pdateto="";
	$pnumofyrs="";
	$indusid="";
	
	$prtitle="";
	$pacadyear="";
	$fagency="";
	$famt="";
	$sdate="";
	$cstatus="";
	$projid="";
	
	$Cacadyear="";
	$prv="";
	$natofcons="";
	$brfdesc="";
	$dtsanc="";
	$cnstatus="";
	$conid="";
	include 'db/db_connect.php';
	$sql = "SELECT degtype,Degree,Branch,class,mobt,mout,YearOfPassing,Percentage,
			nameofuni,nameofcollage FROM profqual WHERE profId = '". $_SESSION["SESSUserID"]. "'  ";
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
									if($degtype=="UG")
									{
										$degname=$Degree;
										$branchname=$Branch;
										$clasname=$class;
										$mobtname=$mobt;
										$moutname=$mout;
										$yrofpasname=$YearOfPassing;
										$pername=$Percentage;
										$univname=$nameofuni;
										$colname=$nameofcollage;
										
									}
									else
									{
										$pgdegname=$Degree;
										$pgbranchname=$Branch;
										$pgclasname=$class;
										$pgmobtname=$mobt;
										$pgmoutname=$mout;
										$pgyrofpasname=$YearOfPassing;
										$pgpername=$Percentage;
										$pgunivname=$nameofuni;
										$pgcolname=$nameofcollage;
										
									}
								}
							}					
							//disconnect from database
							$result->free();
							$mysqli->close();
							
				//phdQual			
	include 'db/db_connect.php';
	$sql = "SELECT degtype,branch,university,guidename,DofReg,dofdec,title,domain 
			FROM phdqual WHERE profId = '". $_SESSION["SESSUserID"]. "'  ";
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
									if($degtype=="PHD")
									{
										$branchnm=$branch;
										$uni=$university;
										$guidenm=$guidename;
										$reg=$DofReg;
										$dec=$dofdec;
										$f_title=$title;
										$f_domain=$domain;
										
									}
									
								}
							}					
							//disconnect from database
							$result->free();
							$mysqli->close();
							
//--------------------
				//10th/12th/diploma examination			
	include 'db/db_connect.php';
	$sql = "SELECT Exam_name,insti_name,year,mobt,mout,class,percentage,active
			FROM profqual2 WHERE profId = '". $_SESSION["SESSUserID"]. "'  ";
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
									
									if($Exam_name=="10th")

									{
										$nameofinsti=$insti_name;
										$yearofpas=$year;
										$marksobt=$mobt;
										$marksout=$mout;
										$clas=$class;
										$percen=$percentage;
										$checkact=$active;
										
									}
									if($Exam_name=="12th")
									{
										$tnameofinsti=$insti_name;
										$tyearofpas=$year;
										$tmarksobt=$mobt;
										$tmarksout=$mout;
										$tclas=$class;
										$tpercen=$percentage;
										$tcheckact=$active;
									}
									if($Exam_name=="Diploma")
									{
										$dnameofinsti=$insti_name;
										$dyearofpas=$year;
										$dmarksobt=$mobt;
										$dmarksout=$mout;
										$dclas=$class;
										$dpercen=$percentage;
										$dcheckact=$active;
									}
									
								}
							}					
							//disconnect from database
							$result->free();
							$mysqli->close();
							
//--------------------

	//-----------Bank salary details
	include 'db/db_connect.php';
	$sql="SELECT bank_name,branch_name,acc_no,IFSC_code,MICR_no,PF_no
		FROM profbankdet WHERE profId = '". $_SESSION["SESSUserID"]. "' ";
		//echo $sql;
		$result = $mysqli->query( $sql );
		$num_results = $result->num_rows;
		$fd="";
		$sd="";
		$d="";
		if( $num_results ){
							while( $row = $result->fetch_assoc() ){
							extract($row);
									$banknm=$bank_name;
									$brnm=$branch_name;
									$accno=$acc_no;
									$ifsc=$IFSC_code;
									$micr=$MICR_no;
									$pf=$PF_no;

							}
		}
				$result->free();
				$mysqli->close();
						
				echo "<script type='text/javascript'>window.onload = function()
										{
												document.getElementById('lblSuccess').style.display = 'block';
										}
										</script>";

?>
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
				<i class="icon-reorder"></i> Faculty Profile</span>
				&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
				&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
				&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
				&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
				&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
				<?php echo $Finame . ' ' . $Stuname;?>
				&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
				&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
				&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
				&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
				&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
				&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
				&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
				&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
								 
				<?php 
					if(isset($_SESSION["SESSFrom"]) && ($_SESSION["SESSFrom"] == "fromadmin")) 
						echo "<a style='color:white' href='UserListMain.php'>Back</a>"; 
					else
						echo "<a style='color:white' href='MainMenuMain.php'>Back</a>"; 
				?>
										
				</h4>
			</div>
<div class="widget-body">
	<form class="form-horizontal" name="form1" action="#">
		<div id="tabsleft" class="tabbable tabs-left">
			<ul id="myTab">
				<li><a href="#tabsleft-tab1"  data-toggle="tab"> <span class="Strong">Personal Details</span></a></li>
				<li><a href="#tabsleft-tab2"  data-toggle="tab"> <span class="Strong">Qualifications</span></a></li>
				<li><a href="#tabsleft-tab10"  data-toggle="tab"> <span class="Strong">Consultancy Services</span></a></li>
				<li><a href="#tabsleft-tab11"  data-toggle="tab"> <span class="Strong">Research Contributions</span></a></li>
				<li><a href="#tabsleft-tab9"  data-toggle="tab"> <span class="Strong">Sponsored Projects</span></a></li>
				<li><a href="#tabsleft-tab8"  data-toggle="tab"> <span class="Strong">Professional Experience</span></a></li>
				<li><a href="#tabsleft-tab7"  data-toggle="tab"> <span class="Strong">Official Details</span></a></li>
				<li><a href="#tabsleft-tab3"  data-toggle="tab"> <span class="Strong">Professor Bank Details</span></a></li>
				<li><a href="#tabsleft-tab4"  data-toggle="tab"> <span class="Strong">Journal / Conference</span></a></li>
				<li><a href="#tabsleft-tab5"  data-toggle="tab"> <span class="Strong">Book</span></a></li>
				<li><a href="#tabsleft-tab6"  data-toggle="tab"> <span class="Strong">Patent</span></a></li>
				
			</ul>
			<div class="tab-content">
			<div class="tab-pane" id="tabsleft-tab1">
				<h3><b>Personal Details</b></h3>
					<div class="control-group">
						<div class="controls">
							<table>
								<tr>								
									<td > <label class="control-label">Surname*</label></td>
									<td ><label class="control-label">First Name*</label></td>
									<td> <label class="control-label">Middle Name</label></td>
									<td> <label class="control-label">Mother's Name*</label></td>
								</tr>																				
								<tr>
									<td><input maxlength="100" <?php if($CFLAG=='1'){echo "readonly";} ?> name='Surname'  id='Surname'
									pattern="[ A-ZA-z]{1,50}" type='text'  style="width:150px" placeholder="Enter Surname"value='<?php echo $Stuname; ?>' /> </td>
									<td><input maxlength="100" <?php if($CFLAG=='1'){echo "readonly";} ?> id='First_Name' name='First_Name' pattern="[ .A-ZA-z]{1,50}"type='text' style="width:150px" placeholder="Enter First Name " value='<?php echo $Finame; ?>' ></td>
									<td><input maxlength="100" <?php if($CFLAG=='1'){echo "readonly";} ?> name="Father_Name"  pattern="[ A-ZA-z]{1,50}" type="text" style="width:150px"placeholder="Enter Father Name " value='<?php echo $Faname; ?>' ></td>
									<td><input maxlength="100" <?php if($CFLAG=='1'){echo "readonly";} ?> id='mother_name' name='mother_name' pattern="[ A-ZA-z]{1,50}" type="text"  style="width:150px"placeholder="Enter Mother Name" value='<?php echo $Mname; ?>'>   </td>
								</tr>
								<tr>
									<td> <label class="control-label">Father / Husband Full name</label></td>
									<td colspan="2"> <label class="control-label">Date of Birth</label>
									</td>										
								</tr>							
								<tr>	
									<td><input maxlength="20" <?php if($CFLAG=='1'){echo "readonly";} ?> name='husband_name' pattern="[ A-ZA-z]{1,50}" type='text'  style="width:170px" placeholder="Enter Father/Husband's name"   value='<?php echo $Hbname; ?>' /> </td>
									<td><input <?php if($CFLAG=='1'){echo "readonly";} ?> id="d_ob" name="d_ob"  class='span13 DTEXDATE dobdate' placeholder="DD-MON-YYYY" pattern="(^((31(?! (FEB|APR|JUN|SEP|NOV|Feb|Apr|Jun|Sep|Nov)))|((30|29)(?! FEB|Feb))|(29(?= FEB|Feb (((1[6-9]|[2-9]\d)(0[48]|[2468][048]|[13579][26])|((16|[2468][048]|[3579][26])00)))))|(0?[1-9])|1\d|2[0-8])-(JAN|FEB|MAR|MAY|APR|JUL|JUN|AUG|OCT|SEP|NOV|DEC|Jan|Feb|Mar|May|Apr|Jul|Jun|Aug|Oct|Sep|Nov|Dec)-((1[6-9]|[2-9]\d)\d{2})$)"   style="width:150px" type="text" value='<?php echo $dob; ?>'></td>																
								</tr>
								<tr>
									<td> <label class="control-label">Mother's Full Name</label></td>
								</tr>																
								<tr>
									<td colspan="2"><input maxlength="100" <?php if($CFLAG=='1'){echo "readonly";} ?> name='MothrFull_Name' pattern="[ A-ZA-z]{1,50}" type='text'  style="width:250px" placeholder="Enter Mother's Full name"   value='<?php echo $MFname; ?>' /> </td>
								</tr>								
							</table>
							<table>
								<tr>
									<td><label class="control-label">Blood Group*</label></td>
									<td><label class="control-label">Status</label></td>
									<td> <label class="control-label">Gender*</label></td>
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
									<td>
																								
									<select name="male_female" style="width:150px"> 
									<option value="M" style="width:150px"value='<?php echo $gen; ?>'
									<?php if($gen == 'M') echo 'selected' ?>
									>Male</option>     
									<option value="F" style="width:150px"value='<?php echo $gen; ?>'
									<?php if($gen == 'F') echo 'selected' ?>
									>Female</option>
									</select>
									</td>
								</tr>
							</table>
							<table>
								<tr>
									<td><label class="control-label">Nationality*</label></td>
									<td><label class="control-label">Religion*</label></td>
									<td><label class="control-label">Category*</label></td>
								</tr>
								<tr>
									<td><input maxlength="100" <?php if($CFLAG=='1'){echo "readonly";} ?> id="nationality" name="nationality" pattern="[ A-ZA-z]{1,50}"type="text" style="width:150px" value='<?php echo $nat; ?>'></td>
									<td><input maxlength="100" <?php if($CFLAG=='1'){echo "readonly";} ?> id="religion" name="religion" pattern="[ A-ZA-z]{1,50}" type="text" style="width:150px" value='<?php echo $reli; ?>'></td>
									<td>
									<select <?php if($CFLAG=='1'){echo "disabled";} ?> name="caste" style="width:150px">
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
									</td>
								</tr>
						</table>
						<table>
							<tr>
								<td colspan="2"> <label class="control-label">Permanent Residential Address*</label></td>
							</tr>
								<tr>
									<td> <label class="control-label">Address</label></td>
																																				
								</tr>
								<tr>
									<td colspan="6"> <input maxlength="100" id="h_addr2"  name="h_addr2" type="text" style= "width:650px" value="<?php echo $perddr; ?>"></td> 
								</tr>
							<tr>
								<td><label class="control-label">City</label></td>
								<td> <label class="control-label">District</label></td>
								<td> <label class="control-label">Village</label></td>
								<td> <label class="control-label">Pin Code</label></td>
							</tr>
							<tr>
								<td><input maxlength="100" <?php if($CFLAG=='1'){echo "readonly";} ?>id='city_name2' name='city_name2' pattern="[ A-ZA-z]{1,50}"type="text"  style="width:150px" value='<?php echo $Cityname2; ?>'> </td>
								<td><input maxlength="100" <?php if($CFLAG=='1'){echo "readonly";} ?>id="dist_2" name="dist_2"pattern="[ A-ZA-z]{1,50}" type="text" style="width:150px"  value='<?php echo $Dis2; ?>'></td>
								<td><input maxlength="100" <?php if($CFLAG=='1'){echo "readonly";} ?>id="vill_age2" name="vill_age2"pattern="[ A-ZA-z]{1,50}" type="text"   style="width:150px"value='<?php echo $vil2; ?>'></td>
								<td><input maxlength="100" <?php if($CFLAG=='1'){echo "readonly";} ?>id="pincode_num2" name="pincode_num2" pattern="^([1-9])([0-9]){5}$" type="text"   style="width:150px"value='<?php echo $pin2; ?>'></td>
									<!-- pattern="^[0-9]{2}-[a-zA-Z]{3}-[0-9]{4}$" -->
							</tr>
						</table>
						<table>
							<tr>
								<td colspan="2"> <label class="control-label">Present Residential Address*</label></td>			
							</tr>
							<tr>
								<td> <label class="control-label">Address</label></td>					
							</tr>
							<tr>
								<td colspan="6"> <input maxlength="100" id="h_addr1"  name="h_addr1" type="text" style= "width:650px" value="<?php echo $praddr; ?>"></td> 							
								<td>
									<input maxlength="100" id="sameadd" name="sameadd" type="checkbox" value="Sameadd" <?php if(isset($_POST['sameadd'])) echo "checked='checked'"; ?> onchange="CopyAdd2();" />
								</td>
								<td> <label class="control-label">Check if Present Address is same as Permanent Address</label></td>
							</tr>
							<tr>
								<td><label class="control-label">City</label></td>
								<td> <label class="control-label">District</label></td>
								<td> <label class="control-label">Village</label></td>
								<td> <label class="control-label">Pin Code</label></td>
							</tr>
							<tr>
								<td><input maxlength="100" <?php if($CFLAG=='1'){echo "readonly";} ?>id='city_name1' name='city_name1' pattern="[ A-ZA-z]{1,50}" type="text"  style="width:150px" value='<?php echo $Cityname1; ?>'> </td>
								<td><input maxlength="100" <?php if($CFLAG=='1'){echo "readonly";} ?>id="dist_1" name="dist_1"pattern="[ A-ZA-z]{1,50}" type="text" style="width:150px"  value='<?php echo $Dis1; ?>'></td>
								<td><input maxlength="100" <?php if($CFLAG=='1'){echo "readonly";} ?>id="vill_age1" name="vill_age1"pattern="[ A-ZA-z]{1,50}" type="text"   style="width:150px"value='<?php echo $vil1; ?>'></td>
								<td><input maxlength="100" <?php if($CFLAG=='1'){echo "readonly";} ?>id="pincode_num1" name="pincode_num1"pattern="^([1-9])([0-9]){5}$" type="text"   style="width:150px"value='<?php echo $pin1; ?>'></td>
									<!-- pattern="^[0-9]{2}-[a-zA-Z]{3}-[0-9]{4}$" -->
							</tr>
						</table>			
						<table>
							<tr>
								<td><label class="control-label">Mobile Number*</label></td>
								<td><label class="control-label">Emergency Contact Number*</label></td>
								<td><label class="control-label">Landline Number</label></td>																		
							</tr>
							<tr>
								<td> <input maxlength="100" id="Stu_Mobile" name="Stu_Mobile" pattern="\d{10}$" style="width:150px" type="text"placeholder="Enter 10-digit Mobile Number " value='<?php echo $mb; ?>'></td>	
								<td> <input maxlength="100" id="Stu_Emegcontact" name="Stu_Emegcontact" pattern="\d{10}$" style="width:180px" type="text"placeholder="Enter Contact Number " value='<?php echo $Emeg_mb; ?>'></td>	
								<td> <input maxlength="100" id="Stu_Landlineno" name="Stu_Landlineno" style="width:150px" type="text" value='<?php echo $landline_num; ?>'></td>																	
							</tr>																
						</table>
						<table>
							<tr>
								<td><label class="control-label">College Ext.</label></td>
								<td><label class="control-label">Personal Email*</label></td>
								<td><label class="control-label">College Email*</label></td>																		
							</tr>
							<tr>
								<td> <input maxlength="100" name="clg_ext" style="width:150px" type="text" placeholder="Enter Number " value='<?php echo $cext; ?>'></td>	
								<td><input maxlength="100" id="stu_email" name="stu_email" pattern="(^\w+[\w-\.]*\@\w+?\x2E.+)" style="width:250px" type="text" placeholder="Enter Valid Email " value='<?php echo $pe; ?>'></td>
								<td><input maxlength="100"  <?php if($CFLAG=='1'){echo "readonly";} ?> id="Pmail" name="Pmail" pattern="(^\w+[\w-\.]*\@\w+?\x2E.+)"  style="width:250px"type="text" placeholder="Enter Valid Email"  value='<?php echo $email; ?>'></td>
								<td><label style="margin-top:-7px"></label></td>
							</tr>
						
						</table>
					</div>
				</div>								
				<?php
					if(($_SESSION["ReadAccess"] == "Yes") && ($_SESSION["WriteAccess"] == "Yes")){
							 echo "<input onclick='setval1();' type='submit' name='update1' value='Save' />&nbsp;&nbsp;&nbsp;&nbsp;* Required fields.";
					}
				?>
			</div>                       
							
			<div class="tab-pane" id="tabsleft-tab2">
		<label class="control-label"><h3><b>Qualifications</b></h3></label>
			<div class="control-group">
				<div class="controls">
				<table  class="inner"  width="25">
					<tr>
						<td align="center"><b>Examination</b></td>
						<td align="center"><b>Check</b></td>
						<td  align="center"><b>Name of Institution</b></td>
						 <td align="center"><b>Year</b></td>
						 <td align="center"><b>Marks Obtained</b></td>
						 <td align="center"><b>Marks Out of</b></td>
						 <td align="center"><b>Class</b></td>
						 <td align="center"><b>Percentage</b></td>
						 
					</tr>			
					<tr>
							<td>10th</td>
							<td>
							<input id="chk" name="chk" type="checkbox" <?php echo ($active == '1' ? 'checked' : ''); ?> value="<?php echo $checkact; ?>"/>
							</td>
							<td>
							<input maxlength="100" <?php if($CFLAG=='1'){echo "readonly";} ?> type='text' class='input-medium' id='institution_name' name='institution_name' size='20' value="<?php echo $nameofinsti;?>">
							</td>				
							<td>
							<input maxlength="100" <?php if($CFLAG=='1'){echo "readonly";} ?> type='text' style="width:150px;" class='input-medium' id='passingyear' name='passingyear'  style="width:100px" size='20' value="<?php echo $yearofpas;?>">
							</td>
							<td>
							<input maxlength="100" <?php if($CFLAG=='1'){echo "readonly";} ?> type='text' class='input-small' id='mksobt' name='mksobt' size='20' value="<?php echo $marksobt;?>">
							</td>
							<td>
							<input maxlength="100" <?php if($CFLAG=='1'){echo "readonly";} ?> type='text' class='input-small' id='mksout' name='mksout' size='20' value="<?php echo $marksout;?>">
							</td>
							<td>
							<input maxlength="100" <?php if($CFLAG=='1'){echo "readonly";} ?> type='text' class='input-small' id='cls_name' name='cls_name' size='20' value="<?php echo $clas;?>">
							</td>
							<td>
							<input maxlength="100" <?php if($CFLAG=='1'){echo "readonly";} ?> type='text' class='input-small' id='percent' name='percent' size='20' value="<?php echo $percen;?>">
							</td>											
					</tr>
					<tr>
							<td>12th</td>
							<td>
							<input id="chk1" name="chk1" type="checkbox"  <?php echo ($active == '1' ? 'checked' : ''); ?>/>
							</td>
							<td>
							<input maxlength="100" <?php if($CFLAG=='1'){echo "readonly";} ?> type='text' class='input-medium' id='instiname' name='instiname' size='20' value="<?php echo $tnameofinsti;?>">
							</td>				
							<td>
							<input maxlength="100" <?php if($CFLAG=='1'){echo "readonly";} ?> type='text' style="width:150px;" class='input-medium' id='tpassingyear' style="width:100px"  name='tpassingyear' size='20' value="<?php echo $tyearofpas;?>">
							</td>
							<td>
							<input maxlength="100" <?php if($CFLAG=='1'){echo "readonly";} ?> type='text' class='input-small' id='tmksobt' name='tmksobt' size='20' value="<?php echo $tmarksobt;?>">
							</td>
							<td>
							<input maxlength="100" <?php if($CFLAG=='1'){echo "readonly";} ?> type='text' class='input-small' id='tmksout' name='tmksout' size='20' value="<?php echo $tmarksout;?>">
							</td>
							<td>
							<input maxlength="100" <?php if($CFLAG=='1'){echo "readonly";} ?> type='text' class='input-small' id='tclas_name' name='tclas_name' size='20' value="<?php echo $tclas;?>">
							</td>
							<td>
							<input maxlength="100" <?php if($CFLAG=='1'){echo "readonly";} ?> type='text' class='input-small' id='tpercent' name='tpercent' size='20' value="<?php echo $tpercen;?>">
							</td>
							<td>
								<label class="control-label"></label>
							</td>
					</tr>
					<tr>
							<td>Diploma</td>
							<td>
							<input id="chk2" name="chk2" type="checkbox"  <?php echo ($active == '1' ? 'checked' : ''); ?>/>
							</td>
							<td>
							<input maxlength="100" <?php if($CFLAG=='1'){echo "readonly";} ?> type='text' class='input-medium' id='dinstiname' name='dinstiname' size='20' value="<?php echo $dnameofinsti;?>">
							</td>				
							<td>
							<input maxlength="100" <?php if($CFLAG=='1'){echo "readonly";} ?> type='text' style="width:150px;" class='input-medium' id='dpassingyear' name='dpassingyear' style="width:100px" size='20' value="<?php echo $dyearofpas;?>">
							</td>
							<td>
							<input maxlength="100" <?php if($CFLAG=='1'){echo "readonly";} ?> type='text' class='input-small' id='dmksobt' name='dmksobt' size='20' value="<?php echo $dmarksobt;?>">
							</td>
							<td>
							<input maxlength="100" <?php if($CFLAG=='1'){echo "readonly";} ?> type='text' class='input-small' id='dmksout' name='dmksout' size='20' value="<?php echo $dmarksout;?>">
							</td>
							<td>
							<input maxlength="100" <?php if($CFLAG=='1'){echo "readonly";} ?> type='text'  class='input-small' id='dclas_name' name='dclas_name' size='20' value="<?php echo $dclas;?>">
							</td>
							<td>
							<input maxlength="100" <?php if($CFLAG=='1'){echo "readonly";} ?> type='text' class='input-small' id='dpercent' name='dpercent' size='20' value="<?php echo $dpercen;?>">
							</td>
					</tr>			
					<tr>
						 <td align="center"><b>Degree Type</b></td>
						 <td align="center"><b>Degree</b></td>
						 <td align="center"><b>Branch</b></td>
						 <td align="center"><b>Class</b></td>
						 <td align="center"><b>Marks Obtained</b></td>
						 <td align="center"><b>Marks Out of</b></td>
						 <td align="center"><b>Percentage</b></td>
						 <td align="center"><b>Year of Passing</b></td>
					</tr>
					<tr> 
							<td>U.G.</td>					 
							<td>
								<select <?php if($CFLAG=='1'){echo "disabled";} ?> name="deg_name"  style="width:150px"> 
									<option value="B.E." <?php if($degname == 'B.E.') echo 'selected=selected'; ?>  style="width:100px">B.E.</option>
									<option value="B.Tech." <?php if($degname == 'B.Tech.') echo 'selected=selected'; ?> style="width:100px">B.Tech.</option>     
									<option value="B.S." <?php if($degname == 'B.S.') echo 'selected=selected'; ?> style="width:150px">B.S.</option>     
								</select>
							</td>					
							<td>
							<input maxlength="100" <?php if($CFLAG=='1'){echo "readonly";} ?> type='text' class='input-medium' id='Branch_name' name='Branch_name' size='10' value="<?php echo $branchname;?>">
							</td>
							<td>
							<input maxlength="100" <?php if($CFLAG=='1'){echo "readonly";} ?> type='text' style="width:150px" class='input-small' id='clas_name' name='clas_name' size='20' value="<?php echo $clasname;?>">
							</td>
							<td>
							<input maxlength="100" <?php if($CFLAG=='1'){echo "readonly";} ?> type='text' class='input-small' id='mks_obt' name='mks_obt' size='10' value="<?php echo $mobtname;?>">
							</td>
							<td>
							<input maxlength="100" <?php if($CFLAG=='1'){echo "readonly";} ?> type='text' class='input-small' id='mks_out' name='mks_out' size='10' value="<?php echo $moutname;?>">
							</td>
							<td>
							<input maxlength="100" <?php if($CFLAG=='1'){echo "readonly";} ?> type='text' class='input-small' id='percen_name' name='percen_name' size='10' value="<?php echo $pername;?>">
							</td>
							<td>
							<input maxlength="100" <?php if($CFLAG=='1'){echo "readonly";} ?> type='text' class='input-small' id='yrof_pas' name='yrof_pas' size='10' value="<?php echo $yrofpasname;?>">
							</td>
					</tr>
					<tr>
							<td colspan="2"></td>
						 <td colspan="1"><b>Name of The College</b></td>
						 <td><b>Name of The University</b></td>
					</tr>
					
					<tr>
							<td colspan="2"></td>
							<td colspan="1">
							<input maxlength="100" <?php if($CFLAG=='1'){echo "readonly";} ?> type='text' class='input-medium' id='clg_name' name='clg_name' size='20' value="<?php echo $univname;?>">
							</td>
							<td>
							<input maxlength="100" <?php if($CFLAG=='1'){echo "readonly";} ?> type='text' class='input-medium' id='uni_name' name='uni_name' size='20' value="<?php echo $colname;?>">
							</td>
					</tr>
					<tr>
						 <td align="center"><b>Degree Type</b></td>
						 <td align="center"><b>Degree</b></td>
						 <td align="center"><b>Branch</b></td>
						 <td align="center"><b>Class</b></td>
						 <td align="center"><b>Marks Obtained</b></td>
						 <td align="center"><b>Marks Out of</b></td>
						 <td align="center"><b>Percentage</b></td>
						 <td align="center"><b>Year of Passing</b></td>
					</tr>
				
					 <tr> 					 
						 <td>P.G.</td>
							<td>
								<select <?php if($CFLAG=='1'){echo "disabled";} ?> name="pgdeg_name"  style="width:150px"> 
									<option value="M.E." <?php if($pgdegname == 'M.E.') echo 'selected=selected'; ?>  style="width:150px">M.E.</option>
									<option value="M.Tech." <?php if($pgdegname == 'M.Tech.') echo 'selected=selected'; ?> style="width:150px">M.Tech.</option>     
									<option value="M.S." <?php if($pgdegname == 'M.S.') echo 'selected=selected'; ?> style="width:150px">M.S.</option>     
								</select>
							</td>				
							<td>
							<input maxlength="100" <?php if($CFLAG=='1'){echo "readonly";} ?> type='text' class='input-medium' id='pgBranch_name' name='pgBranch_name' size='20' value="<?php echo $pgbranchname;?>">
							</td>
							<td>
							<input maxlength="100" <?php if($CFLAG=='1'){echo "readonly";} ?> type='text' class='input-small' style="width:150px" style="width:150px" id='pgclas_name' name='pgclas_name' size='20' value="<?php echo $pgclasname;?>">
							</td>
							<td>
							<input maxlength="100" <?php if($CFLAG=='1'){echo "readonly";} ?> type='text' class='input-small' id='pgmks_obt' name='pgmks_obt'  size='20' value="<?php echo $pgmobtname;?>">
							</td>
							<td>
							<input maxlength="100" <?php if($CFLAG=='1'){echo "readonly";} ?> type='text' class='input-small' id='pgmks_out' name='pgmks_out' size='20' value="<?php echo $pgmoutname;?>">
							</td>
							<td>
							<input maxlength="100" <?php if($CFLAG=='1'){echo "readonly";} ?> type='text' class='input-small' id='pgpercen_name' name='pgpercen_name' size='20' value="<?php echo $pgpername;?>">
							</td>
							<td>
							<input maxlength="100" <?php if($CFLAG=='1'){echo "readonly";} ?> type='text' class='input-small' id='pgpgyrof_pas' name='pgpgyrof_pas' size='20' value="<?php echo $pgyrofpasname;?>">
							</td>
					</tr>
					<tr>
						<td colspan="2"></td>
						 <td colspan="1"><b>Name of The College</b></td>
						 <td><b>Name of The University</b></td>
					</tr>
					<tr>
							<td colspan="2"></td>
							<td colspan="1">
							<input maxlength="100" <?php if($CFLAG=='1'){echo "readonly";} ?> type='text' class='input-medium'  id='pguni_name' name='pguni_name' size='20' value="<?php echo $pgunivname;?>">
							</td>
							<td>
							<input maxlength="100" <?php if($CFLAG=='1'){echo "readonly";} ?> type='text' class='input-medium' id='pgclg_name' name='pgclg_name' size='20' value="<?php echo $pgcolname;?>">
							</td>					 
					</tr> 
					<tr>
						 <td align="center"><b>Degree Type</b></td>
						 <td align="center"><b>Branch</b></td>
						 <td align="center"><b>University</b></td>
						 <td align="center"><b>Guide Name</b></td>
						 <td align="center"><b>Date of Reg</b></td>
						 <td align="center"><b>Date of Declaration</b></td>	
					</tr>
					<tr>
							<td>PhD</td>
							<td>
							<input maxlength="100" <?php if($CFLAG=='1'){echo "readonly";} ?> type='text' class='input-medium' id='brnchnam' name='brnchnam' size='20' value="<?php echo $branchnm;?>">
							</td>				
							<td>
							<input maxlength="100" <?php if($CFLAG=='1'){echo "readonly";} ?> type='text' class='input-medium' id='university_name' name='university_name' size='20' value="<?php echo $uni;?>">
							</td>
							<td>
							<input maxlength="100" <?php if($CFLAG=='1'){echo "readonly";} ?> type='text' class='input-small' style="width:150px" id='guide_name' name='guide_name' size='20' value="<?php echo $guidenm;?>">
							</td>
							<td><input maxlength="20" <?php if($CFLAG=='1'){echo "readonly";} ?> id="reg_date" name="reg_date"  class='span13 DTEXDATE' placeholder="DD-MON-YYYY" pattern="(^((31(?! (FEB|APR|JUN|SEP|NOV|Feb|Apr|Jun|Sep|Nov)))|((30|29)(?! FEB|Feb))|(29(?= FEB|Feb (((1[6-9]|[2-9]\d)(0[48]|[2468][048]|[13579][26])|((16|[2468][048]|[3579][26])00)))))|(0?[1-9])|1\d|2[0-8])-(JAN|FEB|MAR|MAY|APR|JUL|JUN|AUG|OCT|SEP|NOV|DEC|Jan|Feb|Mar|May|Apr|Jul|Jun|Aug|Oct|Sep|Nov|Dec)-((1[6-9]|[2-9]\d)\d{2})$)"   style="width:110px" type="text" value='<?php echo $reg; ?>'></td>																

							<td><input maxlength="20" <?php if($CFLAG=='1'){echo "readonly";} ?> id="dec_date" name="dec_date"  class='span13 DTEXDATE' placeholder="DD-MON-YYYY" pattern="(^((31(?! (FEB|APR|JUN|SEP|NOV|Feb|Apr|Jun|Sep|Nov)))|((30|29)(?! FEB|Feb))|(29(?= FEB|Feb (((1[6-9]|[2-9]\d)(0[48]|[2468][048]|[13579][26])|((16|[2468][048]|[3579][26])00)))))|(0?[1-9])|1\d|2[0-8])-(JAN|FEB|MAR|MAY|APR|JUL|JUN|AUG|OCT|SEP|NOV|DEC|Jan|Feb|Mar|May|Apr|Jul|Jun|Aug|Oct|Sep|Nov|Dec)-((1[6-9]|[2-9]\d)\d{2})$)"   style="width:100px" type="text" value='<?php echo $dec; ?>'></td>			
					</tr>
					<tr>
						<td colspan="2"></td>
						 <td colspan="1" align="center"><b>Title</b></td>							 
						 <td align="center"><b>Domain</b></td>							 

					</tr>
					<tr>
							<td colspan="2"></td>
							<td colspan="1">
							<input maxlength="100" <?php if($CFLAG=='1'){echo "readonly";} ?> type='text' class='input-medium' id='title' name='title' size='20' value="<?php echo $f_title;?>">
							</td>				
							<td>
							<input maxlength="100" <?php if($CFLAG=='1'){echo "readonly";} ?> type='text' class='input-medium' id='domain' name='domain' size='20' value="<?php echo $f_domain;?>">
							</td>				
					</tr>
					</table>
				</div>
			</div>
			<br/><br/>
			<?php
				if(($_SESSION["ReadAccess"] == "Yes") && ($_SESSION["WriteAccess"] == "Yes")){
					 echo "<input onclick='return setval2();' type='submit' name='update2' value='Save' />";
					 // echo "<input onclick='setval2();' type='submit' name='update2' value='Save' />";
				}
				//&nbsp;&nbsp;&nbsp;&nbsp;* Required fields.
			?>	
	</div>		

<div class="tab-pane" id="tabsleft-tab7">
		<label class="control-label"><h3><b>Official Details</b></h3></label>
			<div class="control-group">
				<table  class="inner"  width="25">
				<tr>								
									<td ><label class="control-label" style="width:150px">Department</label></td>
													
					
									<td><input maxlength="100" <?php if($CFLAG=='1'){echo "readonly";} ?> disabled="disabled" id='dpt' name='dpt' style="width:200px" type='text' style="width:320px" value='<?php echo $dept; ?>' ></td>
									
				</tr>
								<tr>
									<td ><label class="control-label">Designation</label></td>
									<td><input maxlength="100" <?php if($CFLAG=='1'){echo "readonly";} ?> disabled="disabled" id='designation' name='designation' style="width:200px" type='text' style="width:320px" value='<?php echo $desig; ?>' ></td>
							
								</tr>
								
								<tr>
									<td> <label class="control-label">Date of Joining</label></td>
									<td><input maxlength="20" <?php if($CFLAG=='1'){echo "readonly";} ?> id="joiningdate" name="joiningdate"  class='span13 DTEXDATE' placeholder="DD-MON-YYYY" pattern="(^((31(?! (FEB|APR|JUN|SEP|NOV|Feb|Apr|Jun|Sep|Nov)))|((30|29)(?! FEB|Feb))|(29(?= FEB|Feb (((1[6-9]|[2-9]\d)(0[48]|[2468][048]|[13579][26])|((16|[2468][048]|[3579][26])00)))))|(0?[1-9])|1\d|2[0-8])-(JAN|FEB|MAR|MAY|APR|JUL|JUN|AUG|OCT|SEP|NOV|DEC|Jan|Feb|Mar|May|Apr|Jul|Jun|Aug|Oct|Sep|Nov|Dec)-((1[6-9]|[2-9]\d)\d{2})$)"   style="width:120px" type="text" value='<?php echo $jdate; ?>'></td>																
								</tr>
				</table>
			</div>
				<br/><br/>
		<?php
			if(($_SESSION["ReadAccess"] == "Yes") && ($_SESSION["WriteAccess"] == "Yes")){
				 echo "<input onclick='javascript:return setval9();' type='submit' name='update1' value='Save' />";
			}
		?>	
		
</div>
<div class="tab-pane" id="tabsleft-tab11">
		<label class="control-label"><h3><b>Research Contributions</b></h3></label>
			<div class="control-group">
				<table  class="inner"  width="25">
				<tr>		
					<input type="hidden" id="lblrconid" name="lblrconid" value="<?php echo $rconid; ?>" />
					<td ><label class="control-label" style="width:150px">Area of Specialization</label></td>
					<td><input maxlength="1500" <?php if($CFLAG=='1'){echo "readonly";} ?> id='areaofspcl' name='areaofspcl' style="width:800px" type='text' value='<?php echo $area; ?>' ></td>
				</tr>
				<tr>
					<td ><label class="control-label" style="width:200px">No. of Students Guided (PG)</label></td>
					<td><input maxlength="100" <?php if($CFLAG=='1'){echo "readonly";} ?> id='numofpgstuds' name='numofpgstuds' style="width:200px" type='text' style="width:320px" value='<?php echo $pgstuds; ?>' ></td>
				</tr>
								
				<tr>
					<td> <label class="control-label">No. of Students Guided (PHD)</label></td>
					<td><input maxlength="100" <?php if($CFLAG=='1'){echo "readonly";} ?> id='numofphdstuds' name='numofphdstuds' style="width:200px" type='text' style="width:320px" value='<?php echo $phdstuds; ?>' ></td>
				</tr>
				<tr>
					<td> <label class="control-label">Any other Achievements?</label></td>
					<td><input maxlength="100" <?php if($CFLAG=='1'){echo "readonly";} ?> id='otherachiev' name='otherachiev' style="width:800px" type='text' value='<?php echo $achievements; ?>' ></td>
				</tr>
				</table>
			</div>
				<br/>
		<?php
			if(($_SESSION["ReadAccess"] == "Yes") && ($_SESSION["WriteAccess"] == "Yes")){
				 echo "<input onclick='javascript:return setval13();' type='submit' name='update12' id='update12' value='Save' />&nbsp;&nbsp;&nbsp;&nbsp;";
			}
			if(($_SESSION["ReadAccess"] == "Yes") && ($_SESSION["WriteAccess"] == "Yes")){
					 echo "<input onclick='ClearFields9();'type='submit' name='cupdate5' value='Clear' />&nbsp;&nbsp;&nbsp;&nbsp;";
			}
		?>	
			&nbsp;&nbsp;&nbsp;&nbsp;* Required fields.
				<br></br>				       
			<table cellpadding="10" id="grdlistresearchcon" cellspacing="0" border="0" width="100%" class="tab_split">
				<tr>
					<th><strong>Sr. No.</strong></th>
					<th><strong>Area of Specialization</strong></th>
					<th><strong>No. of Students Guided (PG)</strong></th>
					<th><strong>No. of Students Guided (PHD)</strong></th>
					<th><strong>Any other achievements?</strong></th>
					<th><strong>Edit</strong></th>
					<th><strong>Delete</strong></th>
				</tr>
					<?php
				// Create connection
				include 'db/db_connect.php';
				$query = "SELECT rconid ,areaofsp,numofpgstuds,numofphdstuds,anyotherachiev
				FROM tblresearchcon WHERE profid = '". $_SESSION["SESSUserID"]. "'";
					//echo $query;
				$result = $mysqli->query( $query );
				$num_results = $result->num_rows;
				$i = 1;
				if( $num_results ){
					while( $row = $result->fetch_assoc() ){
						extract($row);
					  echo "<TR class='odd gradeX'>";
					  echo "<td>$i</td>";
					  echo "<td style='display:none'>{$rconid}</td>";
					   echo "<td>{$areaofsp}</td>";
					  echo "<td>{$numofpgstuds}</td>";
					  echo "<td>{$numofphdstuds}</td>";
					  echo "<td>{$anyotherachiev}</td>";
					  echo "<td class='indusid'><a class='btn btn-mini btn-primary' id='btnedit' onclick='javascript:fnEditDataresearchcon({$rconid});'><i class='icon-pencil icon-white'></i>Edit</a> </td>";
					  echo "<td><a onclick=\"return confirm('Are you sure?');\" class='btn btn-primary' href='profviewFileUpd.php?IUD=D&rconid={$rconid}'><i class='icon-remove icon-white'></i></a> </td>";
					  echo "</TR>";
					  $i = $i + 1;
					}
				}
				else{
					echo "<TR class='odd gradeX'>";
					echo "<td></td>";
					echo "<td>No records found.</td>";
					echo "<td></td>";
					echo "<td></td>";
					echo "</TR>";
				}
					?> 
				</table>
<br></br>
</div>
<div class="tab-pane" id="tabsleft-tab9">
		<label class="control-label"><h3><b>Sponsored Projects</b></h3></label>
			<div class="control-group">
				<table  class="inner"  width="25">
				<tr>
					<input type="hidden" id="lblprojid" name="lblprojid" value="<?php echo $projid; ?>" />
					<td ><label class="control-label" style="width:150px">Academic Year*</label></td>
					<td>
						
						<select name="ddlAcadYear" id="ddlAcadYear" style="width:150px"> 
										<option value="2016-17" style="width:150px"value='<?php echo $pacadyear; ?>'
										<?php if($pacadyear == '2016-17') echo 'selected' ?>
										>2016-17</option>     
										<option value="2015-16" style="width:150px"value='<?php echo $pacadyear; ?>'
										<?php if($pacadyear == '2015-16') echo 'selected' ?>
										>2015-16</option>
										<option value="2014-15" style="width:150px"value='<?php echo $pacadyear; ?>'
										<?php if($pacadyear == '2014-15') echo 'selected' ?>
										>2014-15</option>
										<option value="2013-14" style="width:150px"value='<?php echo $pacadyear; ?>'
										<?php if($pacadyear == '2013-14') echo 'selected' ?>
										>2013-14</option>
										<option value="2012-13" style="width:150px"value='<?php echo $pacadyear; ?>'
										<?php if($pacadyear == '2012-13') echo 'selected' ?>
										>2012-13</option>
										<option value="Before 2012" style="width:150px"value='<?php echo $pacadyear; ?>'
										<?php if($pacadyear == 'Before 2012') echo 'selected' ?>
										>Before 2012</option>
						</select>
					</td>
				</tr>
				<tr>		
					
					<td ><label class="control-label" style="width:150px">Title of The Project*</label></td>
					<td><input maxlength="100" <?php if($CFLAG=='1'){echo "readonly";} ?> required id='projtitle' name='projtitle' style="width:200px" type='text' style="width:320px" value='<?php echo $prtitle; ?>' ></td>
				</tr>
				<tr>
					<td ><label class="control-label">Funding Agency*</label></td>
					<td><input maxlength="100" <?php if($CFLAG=='1'){echo "readonly";} ?> required id='fundagency' name='fundagency' style="width:200px" type='text' style="width:320px" value='<?php echo $fagency; ?>' ></td>
			
				</tr>
								
				<tr>
					<td> <label class="control-label">Funding Amount</label></td>
					<td><input maxlength="100" <?php if($CFLAG=='1'){echo "readonly";} ?> id='fundamt' name='fundamt' style="width:200px" type='text' style="width:320px" value='<?php echo $famt; ?>' ></td>
				</tr>
				<tr>
					<td> <label class="control-label">Date Snactioned</label></td>
					<td><input maxlength="20" <?php if($CFLAG=='1'){echo "readonly";} ?>  id="datesnactioned" name="datesnactioned"  class='span13 DTEXDATE' placeholder="DD-MON-YYYY" pattern="(^((31(?! (FEB|APR|JUN|SEP|NOV|Feb|Apr|Jun|Sep|Nov)))|((30|29)(?! FEB|Feb))|(29(?= FEB|Feb (((1[6-9]|[2-9]\d)(0[48]|[2468][048]|[13579][26])|((16|[2468][048]|[3579][26])00)))))|(0?[1-9])|1\d|2[0-8])-(JAN|FEB|MAR|MAY|APR|JUL|JUN|AUG|OCT|SEP|NOV|DEC|Jan|Feb|Mar|May|Apr|Jul|Jun|Aug|Oct|Sep|Nov|Dec)-((1[6-9]|[2-9]\d)\d{2})$)"   style="width:120px" type="text" value='<?php echo $sdate; ?>'></td>	
				</tr>
				<tr>
					<td> <label class="control-label">Current Status</label></td>
					<td><input maxlength="100" <?php if($CFLAG=='1'){echo "readonly";} ?> id='currstatus' name='currstatus' style="width:200px" type='text' style="width:320px" value='<?php echo $cstatus; ?>' ></td>
				</tr>
				<tr>
					<td ><label class="control-label">Scanned copy of related document (First page only)</label></td>
					<td>
						<input name="fileToUploadsponproj" type="file" id="fileToUploadsponproj">
					</td>							
				</tr>
								
				</table>
			</div>
				<br/><br/>
		<?php
			if(($_SESSION["ReadAccess"] == "Yes") && ($_SESSION["WriteAccess"] == "Yes")){
				 echo "<input onclick='javascript:return setval11();' type='submit' name='update10' id='update10' value='Save' />";
			}
			if(($_SESSION["ReadAccess"] == "Yes") && ($_SESSION["WriteAccess"] == "Yes")){
					 echo "<input onclick='ClearFields7();'type='submit' name='cupdate5' value='Clear' />&nbsp;&nbsp;&nbsp;&nbsp;";
			}
		?>	
			&nbsp;&nbsp;&nbsp;&nbsp;* Required fields.
				<br></br>				       
			<table cellpadding="10" id="grdlistsponsprojs" cellspacing="0" border="0" width="100%" class="tab_split">
				<tr>
					<th><strong>Sr. No.</strong></th>
					<th><strong>Academic Year</strong></th>
					<th><strong>Title of The Project</strong></th>
					<th><strong>Funding Agency</strong></th>
					<th><strong>Document</strong></th>
					<th><strong>Edit</strong></th>
					<th><strong>Delete</strong></th>
				</tr>
					<?php
				// Create connection
				include 'db/db_connect.php';
				$query = "SELECT projid ,acadyear,Titleofproj,fundingagency,profsponprojocument,fundingamount,datesanctioned,currstatus
				FROM tblsponsoredprojs WHERE profid = '". $_SESSION["SESSUserID"]. "'";
					//echo $query;
				$result = $mysqli->query( $query );
				$num_results = $result->num_rows;
				$i = 1;
				if( $num_results ){
					while( $row = $result->fetch_assoc() ){
						extract($row);
					  echo "<TR class='odd gradeX'>";
					  echo "<td>$i</td>";
					  echo "<td style='display:none'>{$projid}</td>";
					   echo "<td>{$acadyear}</td>";
					  echo "<td>{$Titleofproj}</td>";
					  echo "<td>{$fundingagency}</td>";
					  echo "<td style='display:none'>{$fundingamount}</td>";
					  echo "<td style='display:none'>{$datesanctioned}</td>";
					  echo "<td style='display:none'>{$currstatus}</td>";
					  if($profsponprojocument != '')
						echo "<td><a target='_blank' href='{$profsponprojocument}'>View</a></td>"; 
					else
						echo "<td>&nbsp;</td>";
					  // echo "<td class='pubId'><a class='btn btn-mini btn-primary' id='btnedit' onclick='javascript:return checkDelete({$patid});'><i class='icon-pencil icon-white'></i>Delete</a> </td>";
				 //echo"<td><input type='submit' value='Delete' onclick='return deleteRow(this)'></td>";
					  echo "<td class='indusid'><a class='btn btn-mini btn-primary' id='btnedit' onclick='javascript:fnEditDatasponsProjs({$projid});'><i class='icon-pencil icon-white'></i>Edit</a> </td>";
					  echo "<td><a onclick=\"return confirm('Are you sure?');\" class='btn btn-primary' href='profviewFileUpd.php?IUD=D&projid={$projid}'><i class='icon-remove icon-white'></i></a> </td>";
					  echo "</TR>";
					  $i = $i + 1;
					}
				}
				else{
					echo "<TR class='odd gradeX'>";
					echo "<td></td>";
					echo "<td>No records found.</td>";
					echo "<td></td>";
					echo "<td></td>";
					echo "</TR>";
				}
					?> 
				</table>
<br></br>
</div>
<div class="tab-pane" id="tabsleft-tab10">
		<label class="control-label"><h3><b>Consultancy Services</b></h3></label>
			<div class="control-group">
				<table  class="inner"  width="25">
				<tr>
					<input type="hidden" id="lblconid" name="lblconid" value="<?php echo $conid; ?>" />
					<td ><label class="control-label" style="width:150px">Academic Year*</label></td>
					<td>
						
						<select name="ddlCAcadYear" id="ddlCAcadYear" style="width:150px"> 
										<option value="2016-17" style="width:150px"value='<?php echo $Cacadyear; ?>'
										<?php if($Cacadyear == '2016-17') echo 'selected' ?>
										>2016-17</option>     
										<option value="2015-16" style="width:150px"value='<?php echo $Cacadyear; ?>'
										<?php if($Cacadyear == '2015-16') echo 'selected' ?>
										>2015-16</option>
										<option value="2014-15" style="width:150px"value='<?php echo $Cacadyear; ?>'
										<?php if($Cacadyear == '2014-15') echo 'selected' ?>
										>2014-15</option>
										<option value="2013-14" style="width:150px"value='<?php echo $Cacadyear; ?>'
										<?php if($Cacadyear == '2013-14') echo 'selected' ?>
										>2013-14</option>
										<option value="2012-13" style="width:150px"value='<?php echo $Cacadyear; ?>'
										<?php if($Cacadyear == '2012-13') echo 'selected' ?>
										>2012-13</option>
										<option value="Before 2012" style="width:150px"value='<?php echo $Cacadyear; ?>'
										<?php if($Cacadyear == 'Before 2012') echo 'selected' ?>
										>Before 2012</option>
						</select>
					</td>
				</tr>				
				<tr>		
					<td ><label class="control-label" style="width:150px">Consultancy Services Provided to*</label></td>
					<td><input maxlength="100" <?php if($CFLAG=='1'){echo "readonly";} ?> required id='conprv' name='conprv' style="width:200px" type='text' style="width:320px" value='<?php echo $prv; ?>' ></td>
				</tr>
				<tr>
					<td ><label class="control-label">Nature of Consultancy*</label></td>
					<td><input maxlength="100" <?php if($CFLAG=='1'){echo "readonly";} ?> required id='natofcon' name='natofcon' style="width:200px" type='text' style="width:320px" value='<?php echo $natofcons; ?>' ></td>
			
				</tr>
								
				<tr>
					<td> <label class="control-label">Brief Decription</label></td>
					<td><input maxlength="100" <?php if($CFLAG=='1'){echo "readonly";} ?> id='brdesc' name='brdesc' style="width:200px" type='text' style="width:320px" value='<?php echo $brfdesc; ?>' ></td>
				</tr>
				<tr>
					<td> <label class="control-label">Date Snactioned</label></td>
					<td><input maxlength="20" <?php if($CFLAG=='1'){echo "readonly";} ?>  id="cdatesnactioned" name="cdatesnactioned"  class='span13 DTEXDATE' placeholder="DD-MON-YYYY" pattern="(^((31(?! (FEB|APR|JUN|SEP|NOV|Feb|Apr|Jun|Sep|Nov)))|((30|29)(?! FEB|Feb))|(29(?= FEB|Feb (((1[6-9]|[2-9]\d)(0[48]|[2468][048]|[13579][26])|((16|[2468][048]|[3579][26])00)))))|(0?[1-9])|1\d|2[0-8])-(JAN|FEB|MAR|MAY|APR|JUL|JUN|AUG|OCT|SEP|NOV|DEC|Jan|Feb|Mar|May|Apr|Jul|Jun|Aug|Oct|Sep|Nov|Dec)-((1[6-9]|[2-9]\d)\d{2})$)"   style="width:120px" type="text" value='<?php echo $dtsanc; ?>'></td>																
				</tr>
				<tr>
					<td> <label class="control-label">Current Status</label></td>
					<td><input maxlength="100" <?php if($CFLAG=='1'){echo "readonly";} ?> id='concurrstatus' name='concurrstatus' style="width:200px" type='text' style="width:320px" value='<?php echo $cnstatus; ?>' ></td>
				</tr>
				<tr>
					<td ><label class="control-label">Scanned copy of related document (First page only)</label></td>
					<td>
						<input name="fileToUploadcon" type="file" id="fileToUploadcon">
					</td>							
				</tr>

				</table>
			</div>
				<br/><br/>
		<?php
			if(($_SESSION["ReadAccess"] == "Yes") && ($_SESSION["WriteAccess"] == "Yes")){
				 echo "<input onclick='javascript:return setval12();' type='submit' name='update11' id='update11' value='Save' />";
			}
			if(($_SESSION["ReadAccess"] == "Yes") && ($_SESSION["WriteAccess"] == "Yes")){
					 echo "<input onclick='ClearFields8();'type='submit' name='cupdate5' value='Clear' />&nbsp;&nbsp;&nbsp;&nbsp;";
			}
		?>	
			&nbsp;&nbsp;&nbsp;&nbsp;* Required fields.
				<br></br>				       
			<table cellpadding="10" id="grdlistconservices" cellspacing="0" border="0" width="100%" class="tab_split">
				<tr>
					<th><strong>Sr. No.</strong></th>
					<th><strong>Academic Year</strong></th>
					<th><strong>Consultancy Services Provided To</strong></th>
					<th><strong>Nature of Consultancy</strong></th>
					<th><strong>Document</strong></th>
					<th><strong>Edit</strong></th>
					<th><strong>Delete</strong></th>
				</tr>
					<?php
				// Create connection
				include 'db/db_connect.php';
				$query = "SELECT conid ,conacadyear,conserprovidedto,natureofcon,profcondocument,bdesc,dsanc,constatus
				FROM tblconservices WHERE profid = '". $_SESSION["SESSUserID"]. "'";
				
				//echo $query;
				$result = $mysqli->query( $query );
				$num_results = $result->num_rows;
				$i = 1;
				if( $num_results ){
					while( $row = $result->fetch_assoc() ){
						extract($row);
					  echo "<TR class='odd gradeX'>";
					  echo "<td>$i</td>";
					  echo "<td style='display:none'>{$conid}</td>";
					  echo "<td>{$conacadyear}</td>";
					  echo "<td>{$conserprovidedto}</td>";
					  echo "<td>{$natureofcon}</td>";
					  echo "<td style='display:none'>{$bdesc}</td>";
					  echo "<td style='display:none'>{$dsanc}</td>";
					  echo "<td style='display:none'>{$constatus}</td>";
					  if($profcondocument != '')
						echo "<td><a target='_blank' href='{$profcondocument}'>View</a></td>"; 
					else
						echo "<td>&nbsp;</td>";
					  // echo "<td class='pubId'><a class='btn btn-mini btn-primary' id='btnedit' onclick='javascript:return checkDelete({$patid});'><i class='icon-pencil icon-white'></i>Delete</a> </td>";
				 //echo"<td><input type='submit' value='Delete' onclick='return deleteRow(this)'></td>";
					  echo "<td class='indusid'><a class='btn btn-mini btn-primary' id='btnedit' onclick='javascript:fnEditDataconservices({$conid});'><i class='icon-pencil icon-white'></i>Edit</a> </td>";
					  echo "<td><a onclick=\"return confirm('Are you sure?');\" class='btn btn-primary' href='profviewFileUpd.php?IUD=D&conid={$conid}'><i class='icon-remove icon-white'></i></a> </td>";
					  echo "</TR>";
					  $i = $i + 1;
					}
					 
				}
				else{
					echo "<TR class='odd gradeX'>";
					echo "<td></td>";
					echo "<td>No records found.</td>";
					echo "<td></td>";
					echo "<td></td>";
					echo "</TR>";
				}
				
					?> 
				</table>
<br></br>
</div>
<div class="tab-pane" id="tabsleft-tab8">
		<label class="control-label"><h3><b>Professional Experience</b></h3></label>
			<div class="control-group">
				<table  class="inner"  width="25">
				<tr>								
									<td >
									<input type="hidden" id="lblindusid" name="lblindusid" value="<?php echo $indusid; ?>" />
									<label class="control-label" style="width:150px">Industry</label></td>
									<td>
									<select name="industry" id="industry" style="width:150px"> 
									<option value="Teaching" style="width:150px"value='<?php echo $pindustry; ?>'
									<?php if($pindustry == 'Teaching') echo 'selected' ?>
									>Teaching</option>     
									<option value="Research" style="width:150px"value='<?php echo $pindustry; ?>'
									<?php if($pindustry == 'Research') echo 'selected' ?>
									>Research</option>
									</select>
									</td>

					
				</tr>
								<tr>
									<td> <label class="control-label" style="width:200px">From Date</label></td>
									<td><input maxlength="20" <?php if($CFLAG=='1'){echo "readonly";} ?>  id="datefrom" name="datefrom"  class='span13 DTEXDATE' placeholder="DD-MON-YYYY" pattern="(^((31(?! (FEB|APR|JUN|SEP|NOV|Feb|Apr|Jun|Sep|Nov)))|((30|29)(?! FEB|Feb))|(29(?= FEB|Feb (((1[6-9]|[2-9]\d)(0[48]|[2468][048]|[13579][26])|((16|[2468][048]|[3579][26])00)))))|(0?[1-9])|1\d|2[0-8])-(JAN|FEB|MAR|MAY|APR|JUL|JUN|AUG|OCT|SEP|NOV|DEC|Jan|Feb|Mar|May|Apr|Jul|Jun|Aug|Oct|Sep|Nov|Dec)-((1[6-9]|[2-9]\d)\d{2})$)"   style="width:120px" type="text" value='<?php echo $pdatefrom; ?>'></td>																
								</tr>
								<tr>
									<td> <label class="control-label">To Date</label></td>
									<td><input maxlength="20" <?php if($CFLAG=='1'){echo "readonly";} ?> id="dateto" name="dateto"  class='span13 DTEXDATE' placeholder="DD-MON-YYYY" pattern="(^((31(?! (FEB|APR|JUN|SEP|NOV|Feb|Apr|Jun|Sep|Nov)))|((30|29)(?! FEB|Feb))|(29(?= FEB|Feb (((1[6-9]|[2-9]\d)(0[48]|[2468][048]|[13579][26])|((16|[2468][048]|[3579][26])00)))))|(0?[1-9])|1\d|2[0-8])-(JAN|FEB|MAR|MAY|APR|JUL|JUN|AUG|OCT|SEP|NOV|DEC|Jan|Feb|Mar|May|Apr|Jul|Jun|Aug|Oct|Sep|Nov|Dec)-((1[6-9]|[2-9]\d)\d{2})$)"   style="width:120px" type="text" value='<?php echo $pdateto; ?>'></td>																
								</tr>
				
								<tr>
									<td ><label class="control-label">Number of Years</label></td>
									<td><input maxlength="100" <?php if($CFLAG=='1'){echo "readonly";} ?> id='numofyrs' name='numofyrs' type='text' style="width:110px" value='<?php echo $pnumofyrs; ?>' ></td>
							
								</tr>
								<tr>
									<td ><label class="control-label">Scanned copy of related document (First page only)</label></td>
									<td>
										<input name="fileToUpload" type="file" id="fileToUpload">
									</td>							
								</tr>
				</table>
			</div>
				<br/>
		<?php
			if(($_SESSION["ReadAccess"] == "Yes") && ($_SESSION["WriteAccess"] == "Yes")){
				 echo "<input onclick='javascript:return setval10();' type='submit' id='update9' name='update9' value='Save' />";
			}
			if(($_SESSION["ReadAccess"] == "Yes") && ($_SESSION["WriteAccess"] == "Yes")){
					 echo "<input onclick='ClearFields6();'type='submit' name='cupdate4' value='Clear' />&nbsp;&nbsp;&nbsp;&nbsp;";
			}
		?>	
				<br></br>				       
			<table cellpadding="10" id="grdlistindustry" cellspacing="0" border="0" width="100%" class="tab_split">
				<tr>
					<th><strong>Sr. No.</strong></th>
					<th><strong>Industry</strong></th>
					<th><strong>From Date</strong></th>
					<th><strong>To Date</strong></th>
					<th><strong>Number of Years</strong></th>
					<th><strong>Document</strong></th>
					<th><strong>Edit</strong></th>
					<th><strong>Delete</strong></th>
				</tr>
					<?php
				// Create connection
				include 'db/db_connect.php';
				$query = "SELECT industryid ,industry,datefrom,dateto,numofyrs ,profexpdocument
				FROM tblprofexp WHERE profid = '". $_SESSION["SESSUserID"]. "'";
				
				//echo $query;
				$result = $mysqli->query( $query );
				$num_results = $result->num_rows;
				$i = 1;
				if( $num_results ){
					while( $row = $result->fetch_assoc() ){
						extract($row);
					  echo "<TR class='odd gradeX'>";
					  echo "<td>$i</td>";
					  echo "<td style='display:none'>{$industryid}</td>";
					  echo "<td>{$industry}</td>";
					  echo "<td>{$datefrom}</td>";
					  echo "<td>{$dateto}</td>";
					  echo "<td>{$numofyrs}</td>"; 
					  if($profexpdocument != '')
						echo "<td><a target='_blank' href='{$profexpdocument}'>View</a></td>"; 
					else
						echo "<td>&nbsp;</td>";
					  
					  
					 
					  // echo "<td class='pubId'><a class='btn btn-mini btn-primary' id='btnedit' onclick='javascript:return checkDelete({$patid});'><i class='icon-pencil icon-white'></i>Delete</a> </td>";
				 //echo"<td><input type='submit' value='Delete' onclick='return deleteRow(this)'></td>";
					  echo "<td class='indusid'><a class='btn btn-mini btn-primary' id='btnedit' onclick='javascript:fnEditdataindustry({$industryid});'><i class='icon-pencil icon-white'></i>Edit</a> </td>";
					  echo "<td><a onclick=\"return confirm('Are you sure?');\" class='btn btn-primary' href='profviewFileUpd.php?IUD=D&industryid={$industryid}'><i class='icon-remove icon-white'></i></a> </td>";
					 
						
					  echo "</TR>";
					  $i = $i + 1;
					}
					 
				}
				else{
					echo "<TR class='odd gradeX'>";
					echo "<td></td>";
					echo "<td>No records found.</td>";
					echo "<td></td>";
					echo "<td></td>";
					echo "</TR>";
				}
				
					?> 
				</table>
<br></br>
</div>
<div class="tab-pane" id="tabsleft-tab3">
		<label class="control-label"><h3><b>Professor Bank Details</b></h3></label>
			<div class="control-group">
				<table  class="inner"  width="25">
								<tr>								
									<td ><label class="control-label" style="width:150px">Bank Name*</label></td>
									<td><input maxlength="100" <?php if($CFLAG=='1'){echo "readonly";} ?> id='bankname' name='bankname' required style="width:320px" type='text' style="width:320px" value='<?php echo $banknm; ?>' ></td>
								</tr>
								<tr>
									<td ><label class="control-label">Branch Name*</label></td>
									<td colspan="4"><input maxlength="100" <?php if($CFLAG=='1'){echo "readonly";} ?> id='branchname' name='branchname' required type='text' style="width:320px"  value='<?php echo $brnm; ?>' ></td>
								</tr>
								<tr>
									<td> <label class="control-label">Account Number*</label></td>
									<td><input maxlength="100" id="accnum" name="accnum" required type="text"  style="width:320px" value="<?php echo $accno; ?>"></td>
								</tr>
								<tr>
									<td> <label class="control-label">IFSC Code*</label></td>
									<td><input maxlength="100" id="IFScode" name="IFScode" required type="text"  style="width:320px"value="<?php echo $ifsc; ?>"></td>
								</tr>
								<tr>
									<td> <label class="control-label">MICR*</label></td>
									<td><input maxlength="100" id="MICRnum" name="MICRnum" required type="text"  style="width:320px"value="<?php echo $micr; ?>"></td>
								</tr>
								<tr>
									<td> <label class="control-label">PF Number*</label></td>
									<td><input maxlength="100" id="PFnum" name="PFnum" required type="text"  style="width:320px"value="<?php echo $pf; ?>"></td>
								</tr>
				</table>
			</div>
				<br/><br/>
		<?php
			if(($_SESSION["ReadAccess"] == "Yes") && ($_SESSION["WriteAccess"] == "Yes")){
				 echo "<input onclick='setval5();' type='submit' name='update3' value='Save' />";
			}
		?>	
			&nbsp;&nbsp;&nbsp;&nbsp;* Required fields.
		
</div>
				
			<div class="tab-pane" id="tabsleft-tab4">
				<h3><b>Journal / Conference</b></h3>
					<div class="control-group">					
							<table class="inner">
								<tr>
									<td>
										<label class ="control-label">Type of Paper*</label>
									</td>
								</tr>
									<td>
										<select id="journal_conf" name="journal_conf" style="width:150px"> 
											<option value="">Select</option>
											<option value="Journal" style="width:150px"value='<?php echo $ptype; ?>'
											<?php if($ptype == 'Journal') echo 'selected' ?>
											>Journal</option>     
											<option value="Conference" style="width:150px"value='<?php echo $ptype; ?>'
											<?php if($ptype == 'Conference ') echo 'selected' ?>
											>Conference</option>
										</select>	
									</td>
								<tr>
									
								</tr>
								<tr>
									<td colspan="2">
										<input type="hidden" id="lblpubid" name="lblpubid" value="<?php echo $pubid; ?>" />
										<label class ="control-label">Title of the Paper*</label>
									</td>
									<td colspan="2">
										<label class ="control-label">Authors*</label>
									</td>
								</tr>
								<tr>
									<td colspan="2">
										<input maxlength="100" <?php if($CFLAG=='1'){echo "readonly";} ?> name='papertitle'  id='papertitle'
									 type='text' style="width:350px" placeholder="Enter Title" value='<?php echo $ptitle; ?>' required/> 
									 </td>
									<td colspan="2">
										<input maxlength="100" <?php if($CFLAG=='1'){echo "readonly";} ?> name='authors1'  id='authors1'
									 type='text'  style="width:300px" placeholder="Enter Authors" required value='<?php echo $bkauth; ?>' /> 
									 </td>
								</tr>
								<tr>
									<td  colspan="2"><label class ="control-label">Name of Journal / Conference*</label></td>
									<td><label class ="control-label">Publisher</label></td>
								</tr>
								<tr>
									<td colspan="2"><input maxlength="100" <?php if($CFLAG=='1'){echo "readonly";} ?> name='Journalname'  id='Journalname'
									 type='text'  style="width:400px" placeholder="Enter Journal/Conference name" required value='<?php echo $Journalname; ?>' /> </td>
									<td><input maxlength="100" <?php if($CFLAG=='1'){echo "readonly";} ?> name='journalpub'  id='journalpub'
									 type='text'  style="width:150px" placeholder="Enter Publisher" value='<?php echo $jpub; ?>' /> </td>
								</tr>
								<tr>
									<td><label class ="control-label">Volume</label></td>
									<td><label class ="control-label">Pages</label></td>
									<td><label class ="control-label">Year*</label></td>
									<td><label class ="control-label">Month</label></td>
								</tr>
								<tr>
									<td><input maxlength="100" name='vol'  id='vol'
									 type='text'  style="width:100px" placeholder="Enter Volume" value='<?php echo $pvolume; ?>' /> </td>
									<td><input maxlength="100" name='pages'  id='pages'
									 type='text'  style="width:100px" placeholder="Enter Pages" value='<?php echo $pages; ?>' /> </td>
									<td><input  name='conyear'  id='conyear' maxlength="4"
									 type='text'  style="width:100px" placeholder="Enter Year" required value='<?php echo $confyear; ?>' /> </td>
									<td><input maxlength="10"  name='month'  id='month'
									 type='text'  style="width:100px" placeholder="Enter Month" value='<?php echo $month; ?>' /></td>
								</tr>
								<tr>
									<td><label class ="control-label">DOI</label></td>
									<td colspan="3"><label class ="control-label">URL</label></td>
								</tr>
								<tr>
									<td><input maxlength="100"  name='Doi'  id='Doi'
									 type='text'  style="width:150px" placeholder="Enter DOI" value='<?php echo $Doi; ?>' /></td>
									<td colspan="3"><input maxlength="100" name='Url'  id='Url'
									 type='text'  style="width:450px" placeholder="Enter Url" value='<?php echo $Url; ?>' /></td>
								</tr>
								<tr>
									<td><label class ="control-label">Impact Factor</label></td>
									<td><label class ="control-label">Abstract</label></td>
								</tr>
								<tr>
									<td><input maxlength="100" name='impctFactor'  id='impctFactor'
									 type='text'  style="width:150px" placeholder="Enter Impact Factor" value='<?php echo $ifac; ?>' /></td>
									<td colspan="2">
										<textarea rows="4" id="abstract" name="abstract" style="width:450px"><?php echo $abstct; ?></textarea>
										<!-- <input maxlength="100" name='abstract'  id='abstract'
										type='text' style="width:450px" placeholder="Enter Abstract" value='<?php echo $abstct; ?>' /> --->
									 </td>
								</tr>
								<tr>
									<td><label class ="control-label">Status of Paper</label></td>
									<td><label class ="control-label">Is This International Journal?*</label></td>
									<td> <label class="control-label">ISSN</label></td>
								</tr>
								<tr>
									<td>
										<select id="Press_Published" name="Press_Published" style="width:100px"> 
											<option value="">Select</option>
											<option value="In Press" style="width:150px"value='<?php echo $paperstat; ?>'
											<?php if($paperstat == 'In Press') echo 'selected' ?>
											>In Press</option>     
											<option value="Published " style="width:150px"value='<?php echo $paperstat; ?>'
											<?php if($paperstat == 'Published ') echo 'selected' ?>
											>Published</option>
										</select>	
									</td>
									<td>
										<select name="Yes_no" id="Yes_no" style="width:100px"> 
											<option value="">Select</option>
											<option value="Yes" style="width:150px"value='<?php echo $interjnl; ?>'
											<?php if($interjnl == 'Yes') echo 'selected' ?>
											>Yes</option>     
											<option value="no " style="width:150px"value='<?php echo $interjnl; ?>'
											<?php if($interjnl == 'no ') echo 'selected' ?>
											>No</option>
										</select>	
									</td>
									<td colspan="2">
										<input maxlength="100" name="ISSNnum" id="ISSNnum" type="text"  style="width:150px" placeholder="Enter ISSN"value="<?php echo $issnnum; ?>">
									</td>
								</tr>
								<tr>
									<td colspan="2">
										<label class ="control-label">Is This Open Access Journal?*
										<a title="What is Open Access Journal?" href="https://en.wikipedia.org/wiki/Open_access_journal" target="_blank"><img src="images\\info-icon1.png"></a></label>
									</td>
									<td>
										<label class ="control-label">Is This Peer Reviewed Journal?*
										<a title="What is Peer Reviewed Journal?" href="https://en.wikipedia.org/wiki/Peer_review" target="_blank"><img src="images\\info-icon1.png"></a></label>
									</td>
									
								</tr>
								<tr>							
									<td colspan="2">
										<select name="y_n" id="y_n" required style="width:150px"> 
										<option value="">Select</option>
										<option value="y" style="width:150px"value='<?php echo $openaccess; ?>'
										<?php if($openaccess == 'y') echo 'selected' ?>
										>Yes</option>     
										<option value="n" style="width:150px"value='<?php echo $openaccess; ?>'
										<?php if($openaccess == 'n') echo 'selected' ?>
										>No</option>
										</select>
									</td>
									<td>
										<select name="ys_No" id="ys_No" style="width:150px"> 
										<option value="">Select</option>
										<option value="y" style="width:150px"value='<?php echo $peer; ?>'
										<?php if($peer == 'Yes') echo 'selected' ?>
										>Yes</option>     
										<option value="No" style="width:150px"value='<?php echo $peer; ?>'
										<?php if($peer == 'No') echo 'selected' ?>
										>No</option>
										</select>	
									</td>
								</tr>
							</table>
						
					</div>  
		<?php
			if(($_SESSION["ReadAccess"] == "Yes") && ($_SESSION["WriteAccess"] == "Yes")){
					 echo "<input onclick='javascript:return setval6();' type='submit' id='update4' name='update4' value='Add' />&nbsp;&nbsp;&nbsp;&nbsp;";
			}
			if(($_SESSION["ReadAccess"] == "Yes") && ($_SESSION["WriteAccess"] == "Yes")){
					 echo "<input onclick='ClearFields();'type='submit' name='cupdate4' value='Clear' />&nbsp;&nbsp;&nbsp;&nbsp;";
			}
		?>
					&nbsp;&nbsp;&nbsp;&nbsp;* Required fields.

			<br></br>				       
				<table cellpadding="10" id="grdpublist" cellspacing="0" border="0" width="100%" class="tab_split">
					<tr>
						<th><strong>Sr.No.</strong></th>
						<th><strong>Type of Paper</strong></th>
						<th><strong>Paper Title</strong></th>
						<th><strong>Authors</strong></th>
						<th><strong>Year</strong></th>
						<th><strong>Edit</strong></th>
						<th><strong>Delete</strong></th>
					</tr>
						<?php
					// Create connection
					include 'db/db_connect.php';

					$query = "SELECT bookpubid,pubtype,year, pages, ISSN, Journalname,journlpub,volume, MONTH, impactfactor, keywords, paperstatus, 
					internjournal, openacjournal, papertitle, doi,url, abstract, peer, authors1 FROM tblpublications WHERE userid = '". $_SESSION["SESSUserID"]. "'";
					//echo $query;
					$result = $mysqli->query( $query );
					$num_results = $result->num_rows;
					$i = 1;
					if( $num_results ){
						while( $row = $result->fetch_assoc() ){
							extract($row);
						  echo "<TR class='odd gradeX'>";
						   // echo "<td class='pubId'><a class='btn btn-mini btn-primary' 
						  // onclick='javascript:fnEditdata({$pubid});'><i class='icon-pencil icon-white'></i>Delete</a> </td>";
							// echo"<td class='pubId'><a class='btn btn-mini btn-primary'  class="pubId" value="Delete" ></a></td>";
						  echo "<td>$i</td>";
						  echo "<td style='display:none'>{$bookpubid}</td>";
						  echo "<td>{$pubtype}</td>";
						  echo "<td>{$papertitle}</td>";
						  echo "<td>{$authors1}</td>";
						  echo "<td style='display:none'>{$Journalname}</td>";
						  echo "<td style='display:none'>{$journlpub}</td>";
						  echo "<td style='display:none'>{$volume}</td>";
						  echo "<td style='display:none'>{$pages}</td>";
						  echo "<td>{$year}</td>";
						  echo "<td style='display:none'>{$MONTH}</td>";
						  echo "<td style='display:none'>{$doi}</td>";
						  echo "<td style='display:none'>{$url}</td>";
						  echo "<td style='display:none'>{$impactfactor}</td>";
						  echo "<td style='display:none'>{$abstract}</td>";
						  echo "<td style='display:none'>{$paperstatus}</td>";
						  echo "<td style='display:none'>{$internjournal}</td>";
						  echo "<td style='display:none'>{$openacjournal}</td>";
						  echo "<td style='display:none'>{$peer}</td>";
						  echo "<td style='display:none'>{$ISSN}</td>";
						  echo "<td class='pubId'><a class='btn btn-mini btn-primary' 
						  onclick='javascript:fnEditdata({$bookpubid});'><i class='icon-pencil icon-white'></i>Edit</a> </td>";
						  echo "<td><a onclick=\"return confirm('Are you sure?');\" class='btn btn-primary' href='profviewFileUpd.php?IUD=D&bookpubid={$bookpubid}'><i class='icon-remove icon-white'></i></a> </td>";
						  echo "</TR>";
						  $i = $i + 1;
						}
					}
					else{
						echo "<TR class='odd gradeX'>";
						echo "<td></td>";
						echo "<td>No records found.</td>";
						echo "<td></td>";
						echo "<td></td>";
						echo "</TR>";
					}
					echo "</table>";
						?> 
			
				<br></br>
			</div>	

			
			<div class="tab-pane" id="tabsleft-tab5">
				<h3><b>Book</b></h3>
					<div class="control-group">
							<table  class="inner"  width="25">
								<tr>
									<td>
										<input type="hidden" id="lblbookid" name="lblbookid" value="<?php echo $bookid; ?>" />
										<label class ="control-label">Book Title*</label>
									</td>
									<td><label class ="control-label">Authors*</label></td>
								</tr>
								<tr>
									<td><input maxlength="100" name='booktitle'  id='booktitle'
									 type='text'  style="width:350px" placeholder="Enter Title" required value='<?php echo $btitle; ?>' /> </td>
									<td colspan="4"><input maxlength="100" name='bauthrs'  id='bauthrs'
									 type='text'  style="width:350px" placeholder="Enter Author" required value='<?php echo $bookauth; ?>' /> </td>
								</tr>
								<tr>
									<td><label class ="control-label">Publisher</label></td>
									<td><label class ="control-label">Edition</label></td>
									
								</tr>
								<tr>
									<td><input maxlength="100" name='publish'  id='publish'
									 type='text'  style="width:350px" placeholder="Enter Publisher" value='<?php echo $pub; ?>' /> </td>
									<td><input maxlength="100" name='bedition'  id='bedition'
									 type='text'  style="width:100px" placeholder="Enter Edition" value='<?php echo $bkedit; ?>' /> </td>
								</tr>
								<tr>
									<td><label class ="control-label">Address</label></td>
									<td><label class ="control-label">Year*</label></td>
									<td><label class ="control-label">ISBN</label></td>
								</tr>
								<tr>
									<td><input maxlength="100" name='addr'  id='addr'
									 type='text'  style="width:400px" placeholder="Enter Address" value='<?php echo $baddr; ?>' /> </td>
									 <td><input maxlength="100" name='bookyear'  id='bookyear'
									 type='text'  style="width:150px" placeholder="Enter Year" required value='<?php echo $byear; ?>' /> </td>
									  <td ><input maxlength="100" name="ISBNnum" id="ISBNnum" type="text" style="width:150px"  placeholder="Enter ISBN"value="<?php echo $isbnnum; ?>"></td>
								</tr>
								<tr>
									<td>
										<label class ="control-label">URL</label>
									</td>
								</tr>
								<tr>
									<td>
									<input maxlength="100" name='bookurl'  id='bookurl'
									 type='text'  style="width:450px" placeholder="Enter Url" value='<?php echo $bUrl; ?>' />
									 </td>
								
								</tr>
							</table>
						
					</div>  
		<?php
			if(($_SESSION["ReadAccess"] == "Yes") && ($_SESSION["WriteAccess"] == "Yes")){
					 echo "<input onclick='javascript:return setval7();' type='submit' id='update5' name='update5' value='Add' />&nbsp;&nbsp;&nbsp;&nbsp;";
			}
			if(($_SESSION["ReadAccess"] == "Yes") && ($_SESSION["WriteAccess"] == "Yes")){
					 echo "<input onclick='ClearFields2();'type='submit' name='bupdate5' value='Clear' />&nbsp;&nbsp;&nbsp;&nbsp;";
			}
		?>
					&nbsp;&nbsp;&nbsp;&nbsp;* Required fields.

			<br></br>				       
				<table cellpadding="10" id="grdpublistbook" cellspacing="0" border="0" width="100%" class="tab_split">
					<tr>
						<th><strong>Sr. No.</strong></th>
						<th><strong>Book Title</strong></th>
						<th><strong>Authors</strong></th>
						<th><strong>Year</strong></th>
						<th><strong>Edit</strong></th>
						<th><strong>Delete</strong></th>
					</tr>
						<?php
					// Create connection
					include 'db/db_connect.php';
					$query = "SELECT bookpubid,bktitle,pauthor,byear,publisher,addr,bookurl,Editors,ISBN FROM tblpublbook WHERE userid = '". $_SESSION["SESSUserID"]. "'";
					//echo $query;
					$result = $mysqli->query( $query );
					$num_results = $result->num_rows;
					$i = 1;
					if( $num_results ){
						while( $row = $result->fetch_assoc() ){
							extract($row);
						  echo "<TR class='odd gradeX'>";
						  echo "<td>$i</td>";
						  echo "<td style='display:none'>{$bookpubid}</td>";
						  echo "<td>{$bktitle}</td>";
						  echo "<td>{$pauthor}</td>";
						  echo "<td>{$byear}</td>";
						  echo "<td style='display:none'>{$publisher}</td>";
						  echo "<td style='display:none'>{$addr}</td>";
						  echo "<td style='display:none'>{$bookurl}</td>";
						  echo "<td style='display:none'>{$Editors}</td>";
						  echo "<td style='display:none'>{$ISBN}</td>";
						  echo "<td class='pubId'><a class='btn btn-mini btn-primary' id='btnedit' onclick='javascript:fnEditDataBook({$bookpubid});'><i class='icon-pencil icon-white'></i>Edit</a> </td>";
						  echo "<td><a onclick=\"return confirm('Are you sure?');\" class='btn btn-primary' href='profviewFileUpd.php?IUD=D&bookpubid={$bookpubid}'><i class='icon-remove icon-white'></i></a> </td>";
						  
						  echo "</TR>";
						  $i = $i + 1;
						}
					}
					else{
						echo "<TR class='odd gradeX'>";
						echo "<td></td>";
						echo "<td>No records found.</td>";
						echo "<td></td>";
						echo "<td></td>";
						echo "</TR>";
					}
					echo "</table>";
					
					
						?> 

	<br></br>
			</div>	
	<!-- END ------------------------------------------------------------------------------------------------------------ -->	
		
			<div class="tab-pane" id="tabsleft-tab6">

			<h3><b>Patent</b></h3>
				<div class="control-group">					
						<table  class="inner"  width="25">
							<tr>
								<td colspan="3">
									<input type="hidden" id="lblpatid" name="lblpatid" value="<?php echo $patid; ?>" />
									<label class ="control-label">Title of the Patent*</label>
								</td>
								<td><label class ="control-label">Authors*</label></td>
							</tr>
							<tr>
								<td colspan="3"><input maxlength="100" name='patenttitle'  id='patenttitle'
								 type='text'  style="width:400px" placeholder="Enter Title" required value='<?php echo $tpatent; ?>' /> </td>
								<td><input maxlength="100" name='authrs1'  id='authrs1'
								 type='text'  style="width:350px" placeholder="Enter Authors" required value='<?php echo $bkauth1; ?>' /> </td>
							</tr>
							<tr>
									<td>
										<label class ="control-label">URL</label>
									</td>
							</tr>
							<tr>
									<td colspan="4">
									<input maxlength="100" name='paturl'  id='paturl'
									 type='text'  style="width:450px" placeholder="Enter Url" required value='<?php echo $pUrl; ?>' />
									 </td>
								
							</tr>
							<tr>
								<td><label class ="control-label">Patent Number*</label></td>
								<td><label class ="control-label">Country*</label></td>
								<td><label class ="control-label">Year*</label></td>
								<td><label class ="control-label">Status*</label></td>
							</tr>
							<tr>
								<td><input maxlength="100" name='patentnumber'  id='patentnumber'
								 type='text'  style="width:150px" placeholder="Enter Number" required value='<?php echo $patentnum; ?>' /> </td>
								 <td><input maxlength="100" name='pcountry'  id='pcountry'
								 type='text'  style="width:150px" placeholder="Enter Country" required value='<?php echo $country; ?>' /> </td>
								 <td><input maxlength="100" name='pyear'  id='pyear'
								 type='text'  style="width:150px" placeholder="Enter Year" required value='<?php echo $pyr; ?>' /> </td>
								<td>
												<select Id="Filed_Published" name="Filed_Published" style="width:150px" required> 
												<option value="">Select</option>
												<option value="Filed" style="width:150px"value='<?php echo $patentstat; ?>'
												<?php if($patentstat == 'Filed') echo 'selected' ?>
												>Filed</option>     
												<option value="Published " style="width:150px"value='<?php echo $patentstat; ?>'
												<?php if($patentstat == 'Published ') echo 'selected' ?>
												>Published</option>
												</select>	
								</td>
							</tr>
						</table>
					</div>
	<?php
		if(($_SESSION["ReadAccess"] == "Yes") && ($_SESSION["WriteAccess"] == "Yes")){
				 echo "<input onclick='javascript:return setval8();' type='submit' id='update7' name='update7' value='Add' />&nbsp;&nbsp;&nbsp;&nbsp;";
		}
		if(($_SESSION["ReadAccess"] == "Yes") && ($_SESSION["WriteAccess"] == "Yes")){
				 echo "<input onclick='ClearFields3();'type='submit' name='pupdate7' value='Clear' />&nbsp;&nbsp;&nbsp;&nbsp;";
		}
	?>
				&nbsp;&nbsp;&nbsp;&nbsp;* Required fields.

		<br></br>				       
			<table cellpadding="10" id="grdpublistpatent" cellspacing="0" border="0" width="100%" class="tab_split">
				<tr>
					<th><strong>Sr. No.</strong></th>
					<th><strong>Title</strong></th>
					<th><strong>Authors</strong></th>
					<th><strong>Year</strong></th>
					<th><strong>Edit</strong></th>
					<th><strong>Delete</strong></th>
				</tr>
					<?php
				// Create connection
				include 'db/db_connect.php';
				$query = "SELECT bookpubid ,patenttitle,author,year1,pnum,country,pstatus,paturl 
				FROM tblpubpatent WHERE userid = '". $_SESSION["SESSUserID"]. "'";
				
				//echo $query;
				$result = $mysqli->query( $query );
				$num_results = $result->num_rows;
				$i = 1;
				if( $num_results ){
					while( $row = $result->fetch_assoc() ){
						extract($row);
					  echo "<TR class='odd gradeX'>";
					  echo "<td>$i</td>";
					  echo "<td style='display:none'>{$bookpubid}</td>";
					  echo "<td>{$patenttitle}</td>";
					  echo "<td>{$author}</td>";
					  echo "<td>{$year1}</td>"; 
					  echo "<td style='display:none'>{$pnum}</td>";
					  echo "<td style='display:none'>{$country}</td>";
					  echo "<td style='display:none'>{$pstatus}</td>";
					  echo "<td style='display:none'>{$paturl}</td>";
					 
					  // echo "<td class='pubId'><a class='btn btn-mini btn-primary' id='btnedit' onclick='javascript:return checkDelete({$patid});'><i class='icon-pencil icon-white'></i>Delete</a> </td>";
				 //echo"<td><input type='submit' value='Delete' onclick='return deleteRow(this)'></td>";
					  echo "<td class='pubId'><a class='btn btn-mini btn-primary' id='btnedit' onclick='javascript:fnEditdatapatent({$bookpubid});'><i class='icon-pencil icon-white'></i>Edit</a> </td>";
					  echo "<td><a onclick=\"return confirm('Are you sure?');\" class='btn btn-primary' href='profviewFileUpd.php?IUD=D&bookpubid={$bookpubid}'><i class='icon-remove icon-white'></i></a> </td>";
					 
						
					  echo "</TR>";
					  $i = $i + 1;
					}
					 
				}
				else{
					echo "<TR class='odd gradeX'>";
					echo "<td></td>";
					echo "<td>No records found.</td>";
					echo "<td></td>";
					echo "<td></td>";
					echo "</TR>";
				}
				
					?> 
				</table>
<br></br>
		</div>								
		<!-----------end-------------------->
</div>
</div>
</form>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</body>
</form>