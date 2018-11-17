
<!DOCTYPE html>
 <html lang="en">
 <head>
      <meta charset="UTF-8">
      <title>workspace page</title>
      <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="https://use.fontawesome.com/releases/v5.0.7/js/all.js"></script>
     <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
     <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
     <style>
      #big-cont{
       display: flex;
        text-align: left;
    height: 100%;
    margin: 20px;
    justify-content: flex-start;
    margin-left: auto;
    margin-right: auto;
    align-items: left;
    flex-direction: column;
     
      }
  #container1{
		width:960px;
		background-color:lightblue;
		margin:20px;
        padding: 10px;
            
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
      #eventlist{
       
		width:960px;
		background-color:lightblue;
		margin:20px;
        justify-content: center;
		  
      }
		  h1{
		   text-align: center;
	   }
		 h3{
       font-weight: 600;
       
       color: red;
      }
	
		 .container {
    display: flex;
    border: 2px solid black;
    text-align: center;
    height: 100%;
    margin: 20px;
    justify-content: center;
    margin-left: auto;
    margin-right: auto;
    align-items: center;
    flex-direction: column;
     
        
}
        button {
    background-color: #4CAF50;
    color: white;
    padding: 14px 20px;
    margin: 8px 0;
    border: none;
    cursor: pointer;
    width: 100px;
}
        
        input {
            padding: 10px;
             margin: 10px;
        }
        label {
            padding: 10px;
            margin: 10px;
        }
        #formdiv{ 
            width: 40%;
            justify-content: center;
            text-align: center;
             border: 2px dashed red;
             margin-bottom: 5%;
            margin-top: 5%;
        }
     
        
	 </style>
	 </head>

	<body>
	
	<?php
	include 'connectPDO.php';			//connects to the database
   
	$stmt = $conn->prepare("SELECT event_id,event_name,event_description,event_date,event_time  FROM wdv341_event  ");
	$stmt->execute();
?>

<?php 
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if($row == ""){
		echo ("your table is empty!, Please double check your table");
	}
	else{
		?>
		<h1>List Panel</h1>
		
		<h2>View or Modify your list</h2>
	<table border='1'>
	<tr>
		<td>ID</td>
		<td>Name</td>
		<td>Description</td>
		<td>Date</td>
		<td>Time</td>
		<td>UPDATE</td>
		<td>DELETE</td>
		<?php
		
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
	{
		echo "<tr>";
			echo "<td>" . $row['event_id'] . "</td>";
			echo "<td>" . $row['event_name'] . "</td>";	
			echo "<td>" . $row['event_description'] . "</td>";
		    echo "<td>" . $row['event_date'] . "</td>";
		    echo "<td>" . $row['event_time'] . "</td>";
			echo "<td><a href='updateEvent.php?eventID=" . $row['event_id'] . "'>Update</a></td>"; 
			echo "<td><a href='deleteEvent.php?eventID=" . $row['event_id'] . "'>Delete</a></td>"; 		
		echo "</tr>";
	}
	
	}
?>
</table>
  <div id="left"><a href="updateEvent.php" class="btn btn-default button">Back</a></div>
	 </body>
	 <html>