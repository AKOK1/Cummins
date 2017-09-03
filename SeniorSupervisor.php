<html>

  <head>
    <meta charset="utf-8" /> <!-- first element so that the encoding is applied to the title etc. -->
    <title>Senior Supervisor</title>
	<style type="text/css">
.onlyprint {display: none;}
@media print
{    
  .onlyprint {display: block;}

    .no-print, .no-print *
    {
        display: none !important;
    }
}
</style>
    <link rel="stylesheet" href="letter.css" />
  </head>
<?php
$edit_record = $_GET['edit'];
$edit_record5 = $_GET['name2'];
$edit_record6 = $_GET['name3'];
$edit_record7 = $_GET['name4'];
?>
  <body>

    <header style="margin-top:192px;"> 	
	<p style="text-align:right; margin-right:160px;" ><time  datetime="2012-12-01">Date:</time></p><br></br>
	
      <address class="return-address">
				To,<br/>
				<?php echo $edit_record;?><br/> 
				M.K.S.S.S. Cummins College of Engg.<br/>
				Karvenagar, Pune 411 052.<br/>
        
      </address>

    
    </header>

    <br></br>
     Subject: Regarding appointment as a Senior Supervisor for University Theory Examination <?php echo $edit_record5;?>.
    
	<br></br>
    <div class="content"> <!-- use this div only if it is required for styling -->
        <p>
         Dear Sir / Madam,
        <br>
	<p><!-- pagebreak --></p> 

         This is to inform you that you have been appointed as a Senior Supervisor for FE TO BE University Theory Examination which will be held in <?php echo $edit_record5;?>.
<br>
		 Duty period is from <?php echo date("jS F Y",strtotime($edit_record6));?> to <?php echo date("jS F Y",strtotime($edit_record7));?>.
<br>
         You are requested to follow all the rules given by the University of Pune.
<br><br></br></br>
        </p>
        
      </div>

      <p class="adios">
       Principal.<br/>	   
	   M.K.S.S.S. Cummins College of Engg.<br/>
	   Karvenagar, Pune 411 052.<br/>
	   </p>
	  <br/>
	  <input type="button" value="Print" title="Print" onclick='window.print();' class="btn btn-success no-print" />
<!-- var d = new Date();document.getElementById("lbltime").innerHTML = "Printout Time - " + d; <h5 class="onlyprint" id="lbltime"></h5> -->
  </body>

</html>
