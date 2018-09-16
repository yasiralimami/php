<?php
require 'emailer.php';

$businessEmail = new Emailer (); //instantiate a new of instance of a class 
$businessEmail->setMessageLine("Hello Class"); //loaded a value into the object
$businessEmail->setSenderAddress ("info@yasiralimami.info");
$businessEmail->setSendToAddress ("yalimami123@dmacc.edu");
$businessEmail->setSubjectLine ("this simple message");
$validEmail = $businessEmail->sendPHPEmail();

?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
    <p>WDV341 Class Example</p>
    
    <p>Your email message is : <?php echo  $businessEmail->getMessageLine() ?> </p>
    <p>Your email Address is : <?php echo  $businessEmail->getSenderAddress() ?> </p>
    <p>Your email sender is : <?php echo  $businessEmail->getSendToAddress() ?> </p>
    <p>Your email message is : <?php echo  $businessEmail->getSubjectLine() ?> </p>
    <?php 
    
    if ($validEmail) {
        ?>
        <p>Thank you for your email. We will respond as soon as possible.</p>
        <?php
    }
        else
        {
     
    ?>
    
    <p>We are sorry . there has been a problem with our system </p>
    <?php 
    }
    ?>
    
    
    
    <?php 
    if ($validEmail) {
        
       echo " <p>Thank you for your email. We will respond as soon as possible.</p>";
        
    }
        else
        {
    
   echo " <p>We are sorry . there has been a problem with our system </p>";
    
    }
    ?>
    
</body>
</html>