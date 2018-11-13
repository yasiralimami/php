<?php  
 session_start();  
 if(isset($_SESSION["validUser"]))  
 {  
      echo '<h3> Welcome Admin- '.$_SESSION["validUser"].'</h3>';  
     
 }
else{
	header('location: login.php');  //redirect the user to another page
}

 ?>  
<?php 
$event_name="";
$event_description="";
$event_date="";
$event_time="";
$first_name="";
$name_errMsg = "";
$description_errMsg = "";
$date_errMsg = "";
$time_errMsg = "";
$valid_form = true;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	
	//to protect the data from special char and hacking
	function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
	//to validate the event name 
	function validateEventName( $inName ) {
	//cannot be empty
	
	if( empty($inName) ) {
		return false;	//Failed validation
	}
	else {
		return true;	//Passes validation	
	}	
}//end validateEventName()
	


function validateEventDesc( $inName ) {
	//cannot be empty
	
	if( empty($inName) ) {
		return false;	//Failed validation
	}
	else {
		return true;	//Passes validation	
	}	
//end validateEventDec()
	}
	function validateEventDate( $inName ) {
	//cannot be empty
	
	if( empty($inName) ) {
		return false;	//Failed validation
	}
	else {
		return true;	//Passes validation	
	}	
//end validateEventDate()
}
	function validateEventTime( $inName ) {
	//cannot be empty
	
	if( empty($inName) ) {
		return false;	//Failed validation
	}
	else {
		return true;	//Passes validation	
	}	
//end validateEventTime()
}
	
	
	function validateDate($date, $format = 'Y-m-d')
{
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) == $date;
}
	
	function validatetime($time, $format = 'H:i')
{
    $d = DateTime::createFromFormat($format, $time);
    return $d && $d->format($format) == $time;
}
	
	
	
	$event_name = test_input($_POST['event_name']); // pull the value of the field
    $event_description = test_input($_POST['event_description']);
    $event_date = test_input($_POST['event_date']);
    $event_time = test_input($_POST['event_time']);
	$firstName =  test_input($_POST['firstName']);
 	 

	if( !validateEventName($event_name) ) {
			$valid_form = false;
			$name_errMsg = "Please enter a event name";
		
		}
	
	if( !validateEventDesc($event_description) ) {
			$valid_form = false;
			$description_errMsg = "Please enter a event Description";
		}
	if( !validateDate($event_date) ) {
			$valid_form = false;
			$date_errMsg = "Please enter a event Date";
		}
	
	
	if( !validateDate($event_date) ) {
			$valid_form = false;
			$date_errMsg = "Please enter a event Date with right format";
		    		}
	
if( !validateEventTime($event_time) ) {
			$valid_form = false;
			$time_errMsg = "Please enter a event time";
		}
	if( !validatetime($event_time) ) {
			$valid_form = false;
			$time_errMsg = "Please enter a event time with right format";
		}
	//set protection
		if(!$firstName ==""){ 
		$valid_form = false; 
	                         } 
	
	if($valid_form) {
			require 'connectPDO.php';

    $event_name = test_input($_POST['event_name']); // pull the value of the field
    $event_description = test_input($_POST['event_description']);
    $event_date = test_input($_POST['event_date']);
    $event_time = test_input($_POST['event_time']);
		
$sql ="INSERT INTO wdv341_event (event_name,event_description,event_date,event_time ) VALUES (:eventName,:eventDesc,:eventDate,:eventTime )"; //sql language  sql Insert INTO table (fields)VALUes (...);

try{
$stmt = $conn->prepare($sql); //prepare the sql statment

$stmt-> bindparam(':eventName', $event_name);//bind
$stmt-> bindparam(':eventDesc', $event_description);
$stmt-> bindparam(':eventDate', $event_date);
$stmt-> bindparam(':eventTime', $event_time);   
$stmt->execute(); // process the SQL againt the database
	
	$general_Msg ="you have successfully add the information";
}

catch(PDOException $e)
    {
    die();
    
    }

		}
			//else display the form with original values and error messages

	
} 
	
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>event form</title>
   <style>
 	#container	{
		width:960px;
		background-color:lightblue;
		margin:auto;
        float:left;
			
	}
	   span{
		   color:red;
		   font-weight: 400;
	   }
	    h1{
		   text-align: center;
	   }
	   h3{
       font-weight: 600;
       
       color: red;
      }
	    a.button {
    -webkit-appearance: button;
    -moz-appearance: button;
    appearance: button;

    text-decoration: none;
    color: initial;
}
      #left{
       float: right;
       margin-right: 5%;
       border: 1px solid black;
      }
 </style>
        <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="https://use.fontawesome.com/releases/v5.0.7/js/all.js"></script>
     <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
     <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  


</head>
<body>
  <h1>Admin panel</h1>
       <div id="left"><a href="logout.php" class="btn btn-default button">Logout</a></div>
        <h2>Add Event Form</h2>
       
        <p>This form will gather information from the user. When submitted the form will call a server side PHP program. That program will use the form information to create and insert a record into the wdv341_event table in the database.</p>
        <div id="container">
        <h3><span><?php echo $general_Msg ?></span></h3>
   <form name="form1" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" >
      
       <h2>My PHP Form </h2> 
  
   <p>Event Name  <input type="text" id="event_name" name="event_name" placeholder="First Name Last Name" value="<?php echo $event_name ?>"> <span id="errorName"><?php echo $name_errMsg; ?></span></p>
   
   <p> Event Description<input type="text" id="event_description" name="event_description" size="100"placeholder="Short description" value="<?php echo $event_description ?>"> <span id="errorName"><?php echo $description_errMsg; ?></span></p>
   
    <p>Event Date <input type="date" id="event_date" name="event_date" value="<?php echo $event_date ?>"><span id="errorName"><?php echo $date_errMsg; ?></span></p>
    
    <p>Event Time <input type="time" id="event_time " name="event_time" value="<?php echo $event_time ?>" > hh:mm: (pm Or am) <span id="errorName"><?php echo $time_errMsg; ?></span></p>
    <input name="first_name" type="text" id="firstname" style ="display:none" >
    <p>
    <input type="submit" name="Submit" id="button" value="Submit" />
    <input type="reset" name="Reset" id="button2" value="Reset" />
  </p>
   </form> 
   <?php 
			
		if( isset($_POST['Reset'])  )				//if the form has been submitted Validate the form data
{   echo "hello";
	$event_name="";
    $event_description="";
    $event_date="";
    $event_time="";
	}	
			
			?>
   </div>
    <div id="left"><a href="selectEvents.php" class="btn btn-default button">Back</a></div>
   <script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
</body>
</html>