<?php

require_once('exception_handlers.php'); 	

require_once('dbConnect.php'); //connects to the database
	
$sql = "SELECT event_name, event_description, event_presenter, DATE_FORMAT( event_time,'%l:%i %p' ), DATE_FORMAT( event_date,'%W %M %D, %Y' )";	
$sql .= " FROM wdv341_event;";	// SQL command
	
//echo "<h1>$sql</h1>";
	
//prepare the Statement Object

	$query = $connection->stmt_init();
try 
{
	if(!$query->prepare($sql)) 
	{
		throw new Exception("Prepared Statement Failed!");
	}
}	
catch(Exception $e)
{	
	set_connection_exception_handler($connection,$e);
	die();	
}

	//run the statement
	
	if( $query->execute() )	//Run Query and Make sure the Query ran correctly
	{
		$query->bind_result($event_name, $event_description, $event_presenter, $event_time, $event_date);
	
		$query->store_result();
	}
	else
	{
		set_statement_exception_handler($query,$e)
		//send control to a User friendly Error page				
	}
?>

<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>WDV341 Intro PHP  - Display Events Example</title>
    <style>
		.eventBlock{
			width:500px;
			margin-left:auto;
			margin-right:auto;
			background-color:#CCC;	
		}
		
		.displayEvent{
			text_align:left;
			font-size:18px;	
		}
		
		.displayDescription {
			margin-left:100px;
		}
	</style>
</head>

<body>
    <h1>WDV341 Intro PHP</h1>
    <h2>Example Code - Display Events as formatted output blocks</h2>   
    <h3> <?php echo $query->num_rows; ?> Events are available today.</h3>

<?php
	//Display each row as formatted output
	while( $query->fetch() )		
	//Turn each row of the result into an associative array 
  	{
		//For each row you have in the array create a block of formatted text
?>
	<p>
        <div class="eventBlock">	
            <div>
            	<span class="displayEvent">Event: <?php echo $event_name; ?></span>
            	<span class="displayDescription">Description: <?php echo $event_description; ?></span>
            </div>
            <div>
            	Presenter: <?php echo $event_presenter; ?>
            </div>
            <div>
            	<span class="displayTime">Time: <?php echo $event_time; ?></span>
            </div>
            <div>
            	<span class="displayDate">Date: <?php echo $event_date; ?></span>
            </div>
        </div>
    </p>

<?php
  	}//close while loop
	$query->close();
	$connection->close();	//Close the database connection	
?>
</div>	
</body>
</html>