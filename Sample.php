<!DOCTYPE html>
<html>
<body>

<form action="../subs/custompcorder2.php/" method="post" id="form">

            <p><input id="name" name="part_id[]"/> 
               <input type="text"  id="quantity" name="quantity[]"/>  
               <input id="name-data" type="text" name="price[]"/></p>

            <p><input id="name" name="part_id[]"/> 
               <input type="text" id="quantity" name="quantity[]"/>  
               <input id="name-data" type="text" name="price[]"/></p>

            <p><input id="name" name="part_id[]"/> 
               <input type="text" id="quantity" name="quantity[]"/> 
               <input id="name-data" type="text" name="price[]"/></p>

            <p><input id="name" name="part_id[]"/> 
               <input type="text" id="quantity" name="quantity[]"/> 
               <input id="name-data" type="text" name="price[]"/></p>   


    <input id="submit" type="submit" value="Submit Order" name="submission"/>


</form>
</body> 
</html>

<?php
include '../db/connect.php';

foreach (array('part_id', 'quantity', 'price') as $pos) {
    foreach ($_POST[$pos] as $id => $row) {
        $_POST[$pos][$id] = mysqli_real_escape_string($con, $row);
    }
}

$ids = $_POST['part_id'];
$quantities = $_POST['quantity'];
$prices =  $_POST['price'];

$items = array();

$size = count($ids);

for($i = 0 ; $i < $size ; $i++){
    // Check for part id
    if (empty($ids[$i]) || empty($quantities[$i]) || empty($prices[$i])) {
        continue;
    }
    $items[] = array(
        "part_id"     => $ids[$i], 
        "quantity"    => $quantities[$i],
        "price"       => $prices[$i]
    );
}

if (!empty($items)) {
    $values = array();
    foreach($items as $item){
        $values[] = "('{$item['part_id']}', '{$item['quantity']}', '{$item['price']}')";
    }

    $values = implode(", ", $values);

    $sql = "INSERT INTO oz2ts_custompc_details (part_id, quantity, price) VALUES  {$values}    ;
    " ;
    $result = mysqli_query($con, $sql );
    if ($result) {
        echo 'Successful inserts: ' . mysqli_affected_rows($con);
    } else {
        echo 'query failed: ' . mysqli_error($con);
    }
}


				<td class="form_sec span2">
					<select name="ddlPattern" style="width:50%;margin-top:10px">
						<option value="Select " >Select </option>
						<option value="2014" <?php echo (isset($_POST['ddlPattern']) && $_POST['ddlPattern'] == '2014')?'selected="selected"':''; ?> > 2014</option>
						<option value="2012" <?php echo (isset($_POST['ddlPattern']) && $_POST['ddlPattern'] == '2012')?'selected="selected"':''; ?> > 2012</option>
						<option value="2010" <?php echo (isset($_POST['ddlPattern']) && $_POST['ddlPattern'] == '2010')?'selected="selected"':''; ?> > 2010</option>
						<option value="2008" <?php echo (isset($_POST['ddlPattern']) && $_POST['ddlPattern'] == '2008')?'selected="selected"':''; ?> > 2008</option>
						<option value="2006" <?php echo (isset($_POST['ddlPattern']) && $_POST['ddlPattern'] == '2006')?'selected="selected"':''; ?> > 2006</option>
					</select>
				</td>

				
				<select name="gender">
<option value="Male" <?php echo (isset($_POST['gender'] && $_POST['gender'] == 'Male')?'selected="selected"':''; ?> >Male</option>
<option value="Female" <?php echo (isset($_POST['gender'] && $_POST['gender'] == 'Female')?'selected="selected"':''; ?> >Female</option>
<option value="Other" <?php echo (isset($_POST['gender'] && $_POST['gender'] == 'other')?'selected="selected"':''; ?> >Other</option>
</select>


SELECT * FROM tblUser WHERE userID NOT IN
	(SELECT ProfID FROM tblprofessorpref 
	WHERE ExamId = 1
	  AND DAYNAME(STR_TO_DATE(ExamDate,'%m/%d/%Y')) = 
	(
		SELECT SchDay FROM (
		SELECT * FROM (
		SELECT '1' AS OrderNo, 'Saturday' AS SchDay, COUNT(*) AS RecCnt FROM tblUser WHERE userID NOT IN 
		( SELECT ProfID FROM tblprofessorpref 
		WHERE ExamId = 1
		  AND DAYNAME(STR_TO_DATE(ExamDate,'%m/%d/%Y')) = 'Saturday' )
		UNION
		SELECT '2' AS OrderNo, 'Evening' AS SchDay, COUNT(*) AS RecCnt FROM tblUser WHERE userID NOT IN 
		( SELECT ProfID FROM tblprofessorpref 
		WHERE ExamId = 1
		  AND DAYNAME(STR_TO_DATE(ExamDate,'%m/%d/%Y')) = 'Evening' )
		UNION
		SELECT '3' AS OrderNo , 'Others' AS SchDay, COUNT(*) AS RecCnt FROM tblUser WHERE userID NOT IN 
		( SELECT ProfID FROM tblprofessorpref 
		WHERE ExamId = 1
		  AND DAYNAME(STR_TO_DATE(ExamDate,'%m/%d/%Y')) <> 'Evening' AND DAYNAME(STR_TO_DATE(ExamDate,'%m/%d/%Y')) <> 'Saturday' )
		  ) AS A
		  WHERE RecCnt <> 0 LIMIT 1
		  ) AS B)
	 ) 