<?php

$to = $_GET['emailto'];
$to = 'mandaroak@yahoo.com';
//$to      = 'exam@cumminscollege.in';
$subject = "Collge Online Response to your query.";
$message = $_GET['message'] . "\r\n" . $_GET['query'];
$headers = 'From: exam@cumminscollege.in' . "\r\n" .
'Reply-To: mandaroak@yahoo.com' . "\r\n" .
'X-Mailer: PHP/' . phpversion();
mail($to, $subject, $message, $headers);						
header('Location: ContactUsListMain.php');					
							
?>