<?php

include("connection.php");
$state_id = trim(mysql_escape_string($_POST["state_id"]));
 
$sql = "SELECT * FROM tbl_city WHERE state_id = ".$state_id ." ORDER BY city_name";
$count = mysqli_num_rows( mysqli_query($con, $sql) );
if ($count > 0 ) {
$query = mysqli_query($con, $sql);
?>
<label>City: 
<select name="city" name="box">
	<option value="">Please Select</option>
	<?php while ($rs = mysqli_fetch_array($query, MYSQLI_ASSOC)) { ?>
	<option value="<?php echo $rs["id"]; ?>"><?php echo $rs["city_name"]; ?></option>
	<?php } ?>
</select>
</label>
<?php 
	}

?>