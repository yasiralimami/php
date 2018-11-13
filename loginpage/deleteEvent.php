
<?php
if(isset ($_GET['eventID'])){
$inEventID = $_GET['eventID']; // pull ID from Get parameter into a variable
}
else{
    header('Location: login.php'); //basically a PHP redirectly
}

try { 
    include 'connectPDO.php'; // coonects to database
    $stmt = $conn->prepare("DELETE FROM wdv341_event   WHERE event_id=:eventID; ");
    $stmt->bindParam(':eventID',$inEventID);
    $stmt->execute();
    
}
catch (PDOException $e)
    {//database problem has occured
    echo "Connection failed: " . $e->getMessage();
    }
    catch (Exception $e){
    //something else broke.
    }
header('Location: login.php'); //basically a PHP redirectly
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
    
</body>
</html>