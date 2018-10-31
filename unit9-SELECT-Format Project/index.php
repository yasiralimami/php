<?php 
include 'connectPDO.php';			//connects to the database

	$stmt = $conn->prepare("SELECT DATE_FORMAT(event_date,'%m %d %Y') AS formatted_date, DATE_FORMAT(event_date,'%m') AS formatted_month,DATE_FORMAT(event_date,'%Y') AS formatted_year, event_date, event_id,event_name,event_description, event_presenter  FROM wdv341_event WHERE event_date  ORDER BY event_date DESC; ");
	$stmt->execute();
     
 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>PHP form</title>
    <style>
        #contianer{
            width: 98%;
            -webkit-box-shadow: 10px 10px 5px 0px rgba(0,0,0,0.75);
            -moz-box-shadow: 10px 10px 5px 0px rgba(0,0,0,0.75);
             box-shadow: 10px 10px 5px 0px rgba(0,0,0,0.75);
            text-align: center;
            border:1px solid black;
            
        }
        .raw{
            margin-left: auto ;
            margin-right: auto ;
            width: 95%;
            height: 1200px;
        }    
        #col1 {
            width: 30%;
            float:left;
            border:5px dashed red;
            height: 1150px;
            text-align: left;
            margin-top: 10px;
        }
         #col2 {
             width: 69%;
            float:right;
          height: auto;
             
        }
        #event{ float:left;
                 width: 48%;
                  text-align: center;
           
                         }
        #eventDate{
            float:right;
                 width: 48%;
                  text-align: center;
               
        }
        #descript{
            width: 100%;
            float:left;
            text-align: left;
            // border-bottom:1px solid black;
            
        }
        #hint{
             width: 100%;
            float:left;
            text-align: left;
            
        }
        .raw1{
            width: 70%;
            text-align: center;
            border:1px solid red;
            margin: 10px;
            height: 40%;
            height: 250px;
            padding: 1em;
             -webkit-box-shadow: 10px 10px 5px 0px rgba(0,0,0,0.75);
            -moz-box-shadow: 10px 10px 5px 0px rgba(0,0,0,0.75);
             box-shadow: 10px 10px 5px 0px rgba(0,0,0,0.75);
                        }
        .italic{
            
            font-style: italic;
        }
        
        .red {
            font-weight: bold;
            color: red;
        }
        .normal{
            color: black;
        }
    </style>
</head>
<body>
    <div id= "contianer">
       <header>
           <h1> This is simple header</h1>
           
       </header>
        <div class ="raw">
        
           <div id="col1">
               <h3>Cities</h3>
           </div>
            <div id="col2">
              <?php
                
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
	         {
                ?>
               <div class ="raw1">
               <?php  
                $currentMonth = date('m');
                    $currentYear = date('Y');
                   
                    if (( $row['formatted_month'] == $currentMonth) && ($row['formatted_year'] == $currentYear)){ 
                       $style ="red"; 
                    } else if (( $row['formatted_month'] < $currentMonth) && ($row['formatted_year'] <= $currentYear)) {
                        
                        
                        $style ="normal";
                    }
                    
                    else {
                        $style ="italic"; 
                    }
                   ?>
                <div id="event"><h3>Event Name:<span class="<?php  echo $style ?>"><?php echo $row['event_name'] ?></span></h3></div>
                <div id="eventDate"><h3>Event Date:<span><?php echo $row['formatted_date'] ?></span></h3></div>
                <div id="descript">
                    <h2>Event Description: </h2>
                    <p><span><?php echo $row['event_description'] ?></span></p>
                </div>
                <div id ="hint"><h4>present By:<span><?php echo $row['event_presenter'] ?></span></h4></div>
                </div>
                <?php
                      }
                ?>
            </div>
        </div>
        <footer>
            <h2>This is simple footer</h2>
        </footer>
    </div>
</body>
</html>