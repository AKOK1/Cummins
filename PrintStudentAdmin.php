<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ADMISSION FORM</title>
<style type="text/css">
body {
	font-family:Verdana, Geneva, sans-serif;
	font-size: 12px;
	text-align:left;
	margin-left:5px;
	margin-top: 0px;
}
.footer {
	font-family:Verdana, Geneva, sans-serif;
	font-size:10px;
	}
.center-text {
	font-family:Verdana, Geneva, sans-serif;
	font-size:13px;
	text-decoration:underline;
	text-align:center;
	}
.simple-table {
	width:100%;
	border-collapse:collapse;
	border:0px;
	line-height:23px;
	}	
.fix-table {
	width:100%;
	border-collapse:collapse;
	border:0px;
	}
	
.fix-table, th, td {
	line-height:23px;
	text-align:left;
	text-indent:5px;
	}
.th {
	font-size:12px;
	}
	
.th-heading {
	font-size:13px;
	font-weight:bold;
	}

.branch-table {
	width:100%;
	border:1px solid #666;
	border-collapse:collapse;
	line-height:22px;
	text-align:center;
	vertical-align:middle;
	font-weight:bold;
	}
	
.branch-table td , th {
	border:1px solid #666;
	}

.textfield {
	font-size:12px;
	font-weight:bold;	
	border:0px solid #666;
	margin:0px;
	padding:10px;
	line-height:22px;
	}
.textfield02 {
	border:1px solid #666;
	font-weight:bold;	
	margin:0px;
	padding:5px;
	line-height:22px;
	}
.textfield03 {
	border-left:0px;
	font-weight:bold;	
	border-right:0px;
	border-top:0px;
	border-bottom:1px solid #666;
	width:300px;
	margin-left:5px;
	}
.textfield04 {
	border-left:0px;
	font-weight:bold;	
	border-right:0px;
	border-top:0px;
	border-bottom:1px solid #666;
	width:500px;
	line-height:22px;
	padding:5px;
	}
.textfield05 {
	border-left:0px;
	font-weight:bold;	
	border-right:0px;
	border-top:0px;
	border-bottom:1px solid #666;
	width:600px;
	height:23px;
	margin-left:5px;
	}
.hr {
	line-height:2px;
	}
</style>
</head>

<body>
<?php
	if(!isset($_SESSION)){
		session_start();
		
			include 'db/db_connect.php';
			$query111 = "SELECT stdid FROM tblstudent WHERE cnum = '" . $_SESSION["stdcnum"] ."' LIMIT 1;";
			$result111 = $mysqli->query( $query111 );				
			if( $result111 ){
				while( $row111 = $result111->fetch_assoc() ){
					extract($row111);
					$_SESSION["SESSStudentID"] = $stdid;
				}
			}		
		
		if(isset($_SESSION["SESSStudentID"]))
		{
		
			$RollNo = "";
			include 'db/db_connect.php';
	
			$query11 = "SELECT name as Lastattended 
				FROM stdqual WHERE StdId=" . $_SESSION["SESSStudentID"] ." and exam = '12th' LIMIT 1;";
			//echo $query11;
			$result11 = $mysqli->query( $query11 );				
			if( $result11 ){
				while( $row11 = $result11->fetch_assoc() ){
					extract($row11);
				}
			}

		
		//$query = "SELECT photopath FROM tblstudent where CNUM = '" . $_SESSION["stdcnum"] . "'";
				//echo $query; 				
			//get the examyear
			
			$query = "SELECT year,shift FROM tblstdadm 
						WHERE StdId=" . $_SESSION["SESSStudentID"] ." 
						order by StdAdmID desc LIMIT 1;";
			//echo $query;
			$result = $mysqli->query( $query );				
			$num_results = $result->num_rows;
			if( $num_results ){
				while( $row = $result->fetch_assoc() ){
					extract($row);
				  $_SESSION['SESSselectedExamYear'] = $year;

				}
			}
			
			//get the examyear
			include 'db/db_connect.php';
			$query = "SELECT concat(EduYearFrom,' - ',EduYearTo) as curyear 
						FROM tblcuryear order by EduYearFrom desc LIMIT 1;";
			$result = $mysqli->query( $query );				
			$num_results = $result->num_rows;
			if( $num_results ){
				while( $row = $result->fetch_assoc() ){
					extract($row);
					$_SESSION['SESSSelectedFromToYear'] = $curyear;
				}
			}
			
			$query4="SELECT DeptUnivName as DeptName,upper(Year) as Year,RollNo FROM tblstdadm sa, tbldepartmentmaster DM 
					WHERE sa.Dept = DM.DeptID and
					concat(EduYearFrom,' - ',EduYearTo) = '" . $_SESSION['SESSSelectedFromToYear'] . "' 
					and StdID=" . $_SESSION["SESSStudentID"];
			//echo $query4;
			$result4=mysqli_query($mysqli,$query4);
			while($row4=mysqli_fetch_array($result4))
			{
				extract($row4);
				$_SESSION['stddeptprint'] = $DeptName;
					if($RollNo == "")
						$RollNo = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
					else
						$RollNo = $RollNo;
			}

			
			
		}
	}
		include 'db/db_connect.php';
	// $edit_record =isset( $_GET['edit']) ? $_GET ['edit'] : $_GET ['edit_form'];
	// $query="SELECT * FROM tblstudent WHERE StdId='$edit_record'";
	$query="SELECT * FROM tblstudent WHERE StdId=" . $_SESSION["SESSStudentID"] ."";
	//echo $query;
	$run=mysqli_query($mysqli,$query);

	while($row=mysqli_fetch_array($run))
	{
		$edit_id=$row['StdId'];
		$Surname=$row['Surname'];
		$Fname=$row['FirstName'];
		$Fathname=$row['FatherName'];
		$Mname=$row['MotherName'];
		$Tal=$row['Taluka'];
		$Dis=$row['District'];
		$State=$row['State'];
		
		$BloodGroup=$row['Blood_group'];
		$MotherTongue=$row['Mother_tongue'];
		$Nationality=$row['Nationality'];
		$Religion=$row['Religion'];
		$Caste=$row['Caste_subcaste'];
		$castesubcaste=$row['castesubcaste'];

		if($row['aadharno'] == "")
			$aadharno= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
		else
			$aadharno=$row['aadharno'];
		
		$Status=$row['Status'];
		$Mobno=$row['Mobno'];
		$Email_id=$row['Email_id'];
		
		//$ParName=$row['FatherName'] . ' ' .$row['Surname'];
		$ParName=$row['parent_name'];
		$ParAddress=$row['parent_address'];
		$ParTaluka=$row['parent_taluka'];
		$ParDistrict=$row['parent_district'];
		$ParState=$row['parent_state'];
		$Pincode=$row['pincode'];
		$ParTel=$row['parent_telephone'];
		$ParMobile=$row['parent_mobile'];
		if($row['father_income'] == '')
			$FatherIncome = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'; 
		else 
			$FatherIncome = $row['father_income'];
		if($row['mother_income'] == '')
			$MotherIncome = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'; 
		else 
			$MotherIncome = $row['mother_income'];
		$OrgName=$row['org_name'];
		$OrdAdd=$row['org_address'];
		$OrgTel=$row['org_telephone'];
		$OrgMob=$row['org_mobile'];
		$LgName=$row['lg_name'];
		$LgAddress=$row['lg_address'];
		$LgTel=$row['lg_telephone'];
		$LgMob=$row['lg_mobile'];
		$HName=$row['hostel_name'];
		$HAddress=$row['hostel_address'];
		$HTel=$row['hostel_telephone'];
		$Details=$row['details'];
		$DOB=$row['DOB'];
		$PEmail=$row['Pmail'];
		$Rel=$row['Rel'];
		$uniprn=$row['uniprn'];
		$unieli = $row['unieli'];
		$CNUM=$row['CNUM'];
		$photopath=$row['photopath'];
	}

?>
<table class="simple-table">
      <tr>
        <td colspan="3" class="center-text"><img src="images/logo.png" alt="logo" width="577" height="91" /></td>
      </tr>
	  <tr>
        <td colspan="3" width="15%" class="txt2"><center>Approved by AICTE & affiliated to University of Pune, No. PU/PN/ENGG/087/1991,INDIA</center></label></td>
      </tr>
      <tr>
        <td colspan="3" class="hr"><hr/></td>
      </tr>
	  
      <tr>
	    <td colspan="3"><span class="th-heading"><center>Admission Form for <?php echo$_SESSION['SESSselectedExamYear']?> Engineering 
		<?php if($shift == 1) echo "1st"; else "2nd";?> Shift for the Year <?php echo$_SESSION['SESSSelectedFromToYear']?></center></span></td>
      </tr>
      <tr>
        <td colspan="3"><table class="branch-table">
          <tr>
            <td>Branch</td>
            <td><span><img src="images/check.png" alt="check" width="20" height="20" align="top" /> <?php echo $_SESSION['stddeptprint']; ?></span></td>
          </tr>
        </table></td>
      </tr>
		<br/><br/>
      <tr>
        <td width="446"><table class="branch-table">
          <tr>
            <td width="14%">Category</td>
            <td width="11%"><span class="tick-td"><?php echo $Caste; ?></span></td>

          </tr>
        </table></td>
        <td >&nbsp;</td>
        <td width="426" colspan="-3"><table class="branch-table">
          <tr>
            <td>Univ. Eligibility No. -            
            <label class="textfield" id="univ-no"><?php echo $unieli; ?></label></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td colspan="3"><table class="fix-table" >
          <tr>
            <td width="25%">Roll No.
              <label id="roll" class="textfield02"><?php echo $RollNo; ?></label></td>
            <td width="10%">C-Number</td>
            <td width="25%"><label class="textfield02"><?php echo $CNUM; ?></label></td>
            <td width="40%">Aadhar Card No. -
            <label class="textfield02" id="aadhar"><?php echo $aadharno; ?></label></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td colspan="3"><table class="fix-table">
          <tr>
            <td width="12%">1. Name:</td>
            <td width="13%"><label class="textfield04" id["Surname"><?php echo $Surname; ?></label></td>
            <td width="15%"><label class="textfield04" id="First_Name"><?php echo $Fname; ?></label></td>
            <td width="60%"><label class="textfield04" id="Father_Name"><?php echo $Fathname; ?></label></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Surname</td>
            <td>First Name</td>
            <td>Father's Name</td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td colspan="3"><table class="fix-table">
          <tr>
            <td> 2. Mother's Name :
            <label class="textfield04" id="mother_name"><?php echo $Mname; ?></label></td>
            <td>3. Place of Birth: Taluka
            <label class="textfield04" id="taluka"><?php echo $Tal; ?></label></td>
            <td>Dist.
            <label class="textfield04" id="dist"><?php echo $Dis; ?></label></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td colspan="3">
			<table width="100%" border="0" cellpadding="0" cellspacing="0" class="fix-table">
			  <tr>
				<td> 4. Date of Birth:
				  <label class="textfield04" id="DOB"><?php echo $DOB; ?></label></td>
				<td>5. Place of Birth: State
				  <label class="textfield04" id="mother name5"><?php echo $State; ?></label></td>
				<td width="143" rowspan="4" align="center" valign="bottom">
				<img src="<?php 
				if($photopath == '')
					echo 'photos/photo.png';
				else
					echo 'photos/'. $photopath; ?>" alt="photo" width="100" height="120" align="middle" /></td>
			  </tr>
			  <tr>
				<td>6.Blood Group:
				  <label class="textfield04" id="Blood-grp"><?php echo $BloodGroup; ?></label></td>
				<td>7. Mother Tongue: 
				  <label class="textfield04" id="mother-tongue"><?php echo $MotherTongue; ?></label></td>
			  </tr>
			  <tr>
				<td>8. Nationality: 
				<label class="textfield04" id="nationality"><?php echo $Nationality; ?></label></td>
				<td>9. Religion: 
				<label class="textfield04" id="religion"><?php echo $Religion; ?></label></td>
			  </tr>
			  <tr>
				<td>10. Caste-Sub-caste: 
				<label class="textfield04" id="caste"><?php echo $castesubcaste; ?></label></td>
				<td>11. Married/Unmarried: 
				<label class="textfield04" id="married_unmarried"><?php echo $Status; ?></label></td>
			  </tr>
			</table>
		</td>
      </tr>
      <tr>
        <td colspan="3" bgcolor="#FFFFFF"><table width="881" border="0" cellpadding="0" cellspacing="0" class="fix-table">
          <tr>
            <td width="369"> 12. Student's Mobile No.:
              <label class="textfield04" id="Stu_Mobile"><?php echo $Mobno; ?></label></td>
            <td width="485">13. Student's Email ID: 
              <label class="textfield04" id="mother name6"><?php echo $Email_id; ?></label></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td colspan="3">14. Last College Attended: 
        <label class="textfield04" id="last_college"><?php echo $Lastattended; ?></label></td>
      </tr>
      <tr >
        <td colspan="3" bgcolor="#FFFFFF">15. Details of Exams Passed:</td>
      </tr>
      <tr>
        <td colspan="3" bgcolor="#FFFFFF"><table class="branch-table">
          <tr>
		  
           </td>
		    <td width="8%" rowspan="2"><center>Exam</center></td>
            <td width="30%" rowspan="2"><center>Name of the Institution &amp; Branch</center></td>
            <td width="12%" rowspan="2"><center>Year</center></td>
			
            <td colspan="2"><center>Marks</center></td>
            <td width="20%" rowspan="2"><center>Class</center></td>
          </tr>
          <tr>
            <td width="8%" align="left"><center>Obt.</center></td>
            <td width="8%" align="left"><center>Out of</center></td>
          </tr>
<?php
			include 'db/db_connect.php';

				// sa
				// inner join tblstdresultm srm on 
		  
	  $query = "SELECT s.StdID as StdId, CONCAT(SUBSTR(EduYear,1,1),'.',SUBSTR(EduYear,2,1),'.') as Exam, 'MKSSS CCOEW' as name, CONCAT(srm.EduYearFr,'-', srm.EduYearTo) as EduYearStart,
				LTRIM(RTRIM(SUBSTR(BLine,INSTR(BLine,'/')-4,4))) AS mobt,LTRIM(RTRIM(SUBSTR(BLine,INSTR(BLine,'/')+1,4))) AS mout
				, CASE WHEN Bline LIKE '%Result:%' THEN LTRIM(RTRIM(SUBSTR(BLine,INSTR(BLine,'Result:')+7,100))) ELSE ''  END as class, '' as remark 
				FROM tblstudent s
				INNER JOIN tblstdresultm srm ON srm.UniPRN = s.UniPRN 				
				WHERE s.StdId=" . $_SESSION["SESSStudentID"] ." 
				-- AND Replace(sa.Year,'.','') = srm.EduYear
				-- AND CONCAT(sa.EduYearFrom,'-', sa.EduYearTo) = CONCAT(srm.EduYearFr,'-', srm.EduYearTo) 
				-- and CONCAT(EduYearFrom,' - ', sa.EduYearTo) <> '" . $_SESSION['SESSSelectedFromToYear'] . "'
				order by EduYearStart DESC LIMIT 3 ;";
				 
				//echo $query;
				$result = $mysqli->query( $query );
				$num_results = $result->num_rows;
				$counter = 0;
				
				if( $num_results ){

					while( $row = $result->fetch_assoc() ){
						$counter++;
						//count=3;
						 //count++;
						//$counter i;
						 // $i++;
						 //counter i;
						extract($row);
					  echo "<TR class='odd gradeX'>";
					  echo "<td>{$Exam}</td>";
					  echo "<td>{$name}</td>";
					  echo "<td>{$EduYearStart}</td>";
					  echo "<td>{$mobt}</td>";
					  echo "<td>{$mout}</td>";
					  echo "<td>{$class}</td>";
					  echo "</TR>";
					}
				}
				else{
					echo "<TR class='odd gradeX'>";
					echo "<td>&nbsp;</td>";
					echo "<td>&nbsp;</td>";
					echo "<td>&nbsp;</td>";
					echo "<td>&nbsp;</td>";
					echo "<td>&nbsp;</td>";
					echo "<td>&nbsp;</td>";
					echo "</TR>";
				}

					$limit=3-$counter;
					$query = "SELECT StdId, Exam, name, EduYearStart, mobt, mout, class,
				remark FROM stdqual WHERE StdId=" . $_SESSION["SESSStudentID"] ." order by Exam desc LIMIT $limit;";
				 
				 //echo $query;
				$result = $mysqli->query( $query );				
				$num_results = $result->num_rows;
				if( $num_results ){
					while( $row = $result->fetch_assoc() ){
						extract($row);
					  echo "<TR class='odd gradeX'>";
					  echo "<td>{$Exam}</td>";
					  echo "<td>{$name}</td>";
					  echo "<td>{$EduYearStart}</td>";
					  echo "<td>{$mobt}</td>";
					  echo "<td>{$mout}</td>";
					  echo "<td>{$class}</td>";
					  echo "</TR>";
					 }
				}
				
?>
				
		  
        </table></td>
      </tr>
      <tr>
        <td colspan="3" bgcolor="#FFFFFF">16. Name and Address with Pin Code of Parent (Telephone No. along with STD Code Or Mobile No.)</td>
      </tr>
      <tr>
        <td colspan="3" bgcolor="#FFFFFF"><table class="branch-table">
          <tr>
            <td>Name: <label class="textfield" id="mother name7"><?php echo $ParName; ?></label></td>
          </tr>
          <tr>
            <td>Address: <label class="textfield" id="Parent_Address1"><?php echo $ParAddress; ?></label></td>
          </tr>
          <tr>
            <td>Tal. <label class="textfield"id="tal2" ><?php echo $ParTaluka; ?></label>
            Dist. <label class="textfield" id="dist2"><?php echo $ParDistrict; ?></label>
            State - <label class="textfield" id="state"><?php echo $ParState; ?></label> 
            Pin Code - <label class="textfield" id="pin_code"><?php echo $Pincode; ?></label></td>
          </tr>
          <tr>
            <td>Telephone No. with STD Code 
            <label class="textfield" id="Parent_Telephone"><?php echo $ParTel; ?></label> 
            Mobile No. 
            <label class="textfield" id="Parent_Mobile"><?php echo $ParMobile; ?></label></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td colspan="3"><hr/></td>
      </tr>
      <tr>
        <td colspan="3">Students should fill all the columns of the Admission Form. Signatures of the parent & Student are necessary.</td>
      </tr>
	</table>
	<p  style="page-break-after:always;"></p>
<table class="simple-table">
      <tr>
        <td colspan="3">17. Name and Address with pin code of Local Guardian for any communication and Telephone or Mobile No.</td>
      </tr>
      <tr>
        <td colspan="3"><table class="branch-table">
          <tr>
            <td><label class="textfield"><?php echo $LgName; ?></label></td>
          </tr>
          <tr>
            <td><label class="textfield"><?php echo $LgAddress; ?></label></td>
          </tr>
          <tr>
            <td>&nbsp;&nbsp;Telephone No.
              <label class="textfield" id="LG_Telephone"><?php echo $LgTel; ?></label>
              Mobile No.
              <label class="textfield" id="LG_Mobile2"><?php echo $LgMob; ?></label></td>
          </tr>
        </table></td>
      </tr>
      <tr class="th">
        <td colspan="3" bgcolor="#FFFFFF">18. Name of the Organization where Parent is employed along with Telephone no.</td>
      </tr>
      <tr class="th">
        <td colspan="3"><table class="branch-table">
          <tr>
            <td><label class="textfield" id="company_ name"><?php echo $OrgName; ?></label></td>
          </tr>
          <tr>
            <td><label class="textfield" id="address5"><?php echo $OrdAdd; ?></label></td>
          </tr>
          <tr>
            <td>&nbsp;&nbsp;Telephone No.
              <label class="textfield" id="company_Telephone"><?php echo $OrgTel; ?></label>
              Mobile No.
              <label class="textfield" id="company_Mobile"><?php echo $OrgMob; ?></label></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td colspan="3" >19. Total Annual Income of Father 
        <label class="textfield02" id="Father_Income"><?php echo $FatherIncome; ?></label> 
        Total Annual Income of Mother 
        <label class="textfield02" id="Mother_Income2"><?php echo $MotherIncome; ?></label>
		</td>
      </tr>
      <tr class="th">
        <td colspan="3">20. Name and Address of the Hostel along with Telephone No.</td>
      </tr>
      <tr class="th">
        <td colspan="3"><table class="branch-table">
          <tr>
            <td><label class="textfield" id="Hostel_Name"><?php echo $HName; ?></label></td>
          </tr>
          <tr>
            <td><label class="textfield" id="Hostel_Address"><?php echo $HAddress; ?></label></td>
          </tr>
          <tr>
            <td>&nbsp;&nbsp;Telephone No.
              <label class="textfield" id="Hostel_Telephone2"><?php echo $HTel; ?></label></td>
          </tr>
        </table></td>
      </tr>
      <tr class="th">
        <td colspan="3" bgcolor="#FFFFFF">21. Details of Sports and Cultural Activities</td>
      </tr>
      <tr class="th">
        <td height="24" colspan="3" bgcolor="#FFFFFF"><table class="branch-table">
          <tr>
            <td><label class="textfield" id="Details1"><?php echo $Details; ?></label></td>
          </tr>
          <tr>
            <td><label class="textfield" id="Detail2"></label></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td colspan="3" class="center-text">Declaration by the Candidate</td>
  </tr>
      <tr>
        <td colspan="3">I hereby solemnly and sincerely affirm that, each and every statement made and the entire information given by me in the application form is true and correct.</td>
      </tr>
      <tr>
        <td colspan="2">Date:
            <label class="textfield04" id="Date">
				&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
			</label>
        </td>
        <td bgcolor="#FFFFFF">
        <label class="textfield04" id="Candidate_Sign">
		  &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
		  &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
		</label></td>
      </tr>
      <tr>
        <td colspan="2">Place:
        <label class="textfield" id="Place"> Pune</label></td>
        <td bgcolor="#FFFFFF">Signature of the Candidate: </td>
      </tr>
      <tr>
        <td colspan="3"><p>I have fully read the information furnished by my daughter and affirm that it is true. I understand that if it is proved that the information is fraudulent, I am liable for criminal prosecution.</p></td>
      </tr>
      <tr>
        <td colspan="2" bgcolor="#FFFFFF">Date:
            <label class="textfield04" id="Date3">
				&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
			</label>
        </td>
        <td bgcolor="#FFFFFF">
          <label class="textfield04" id="Parent_Sign">
		  &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
		  &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
		  </label></td>
      </tr>
      <tr>
        <td colspan="2" bgcolor="#FFFFFF">Place:
        <label class="textfield" id="Place2">Pune</label></td>
        <td>Signature of Parent/Guardian:</td>
      </tr>
      <tr>
        <td colspan="3" class="hr"><hr/></td>
      </tr>
      <tr>
        <td colspan="3" class="center-text">For Office Use Only</td>
      </tr>
      <tr>
        <td colspan="3">I hereby certify that the information furnished by the said candidate is verified and true.</td>
      </tr>
      <tr>
        <td colspan="3" ><table class="fix-table" >
          <tr>
            <td width="23%">Date:
              <label class="textfield04" id="Date2">
				&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
			  </label></td>
            <td width="36%">
              <label class="textfield04" id="Authority_Sign">
			  &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
			  &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
			  &nbsp&nbsp&nbsp
			  </label></td>
            <td width="41%">
            <label class="textfield04" id="Principal_Sign">
			  &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
			  &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
			</label></td>
          </tr>
          <tr>
            <td>Place:
            <label class="textfield" id="Place4">Pune</label></td>
            <td width="36%">Signature of Admission Authority: </td>
            <td width="41%">Signature of Principal:</td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td colspan="3" class="hr"><hr/></td>
      </tr>
      <tr>
        <td colspan="3"><table class="simple-table">
          <tr>
            <td class="footer">Instructions:<br />
              i) Incomplete Admission form will not be considered.<br />
			  <?php 
				if($_SESSION['SESSselectedExamYear'] == 'F.E.')
					echo 'ii) Third year student should submit attested copy of the First Year and Second Year or Diploma mark sheet along with this Admission Form.'; 
				if($_SESSION['SESSselectedExamYear'] == 'S.E.')
					echo 'ii) Second year student should submit attested copy of the First Year 	mark-sheet along with this Admission Form. 
						  iii) Students taking Direct admission to Second Year after Diploma should submit following attested copies along with Admission Form a) 10th Mark Sheet b) Last year Diploma Mark sheet c) Leaving Certificate d)Passing Certificate e) Equivalence Certificate f) Migration Certificate (if there is a change of University) g) Two Photograph h) Nationality i) Caste j) Caste Validity k) Non-creamy Layer Certificate
						  iv) Students transferred from other college to this college should submit attested copies of following documents along with Admission Form a) First Year mark sheet b) Leaving Certificate c) No Objection Certificate d) Jt. Director, Pune permission letter'; 
				if($_SESSION['SESSselectedExamYear'] == 'T.E.')
					echo 'ii) Third year student should submit attested copy of the First Year and Second Year or Diploma mark-sheet along with this Admission Form.'; 
				if($_SESSION['SESSselectedExamYear'] == 'B.E.')
					echo 'ii) Final year student should submit attested copy of the First Year and Second Year or Diploma and Third Year mark-sheet along with this Admission Form.'; 
				?>
            <br />
            iii) Aadhar Card Xerox</td>
          </tr>
		  
        </table></td>
      </tr>
	   </table>
	   
</body>