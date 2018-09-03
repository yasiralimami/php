<!doctype html>
<html>

<head>
<meta charset="utf-8">
<title>Mail page</title>
</head>

<body>

<? php

function phpMailer() {
$sendTo = "yasir_altaee@yahoo.com";
$subject = "My test email";
$message = "Hello world!";
$from = "From: sales@hostdcenter.com" . "\r\n" .


$emailResult = mail($sendTo,$subject,$message,$form);
}
phpMailer();

?> 
<H1> test email</H1>
<?php echo $emailResult ?>


</body>
</html>

