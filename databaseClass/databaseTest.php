<?php

include 'Database.php';

$params = array(':eventID' => 2);

$db= new Database("localhost","datbase","username","password");

$sql = "SELECT event_id,event_name,event_description FROM wdv341_event WHERE event_id=:eventID";

$db->preparePDO($sql);

$dbResult = $db->executePDO($params);

$rowCount = $dbResult->rowCount();

echo "<h3>Database row Count = $rowCount</h3>";

$sql = "SELECT event_id,event_name,event_description FROM wdv341_event WHERE event_id=3";

$db->preparePDO($sql);

$dbResult = $db->executePDO();

$rowCount = $dbResult->rowCount();

echo "<h3>Database row Count = $rowCount</h3>";
?>