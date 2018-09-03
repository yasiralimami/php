<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title> PHP Basic </title>
</head>
<body>
    <?php
    $yourName= "Yasir Al Imami";
    echo "<h1>$yourName</h1>";
    
    ?>
    <h2><?php echo "$yourName ";?></h2>
    <?php 
    $number1 = 5 ;
    $number2 = 15 ;
    $total = $number1 + $number2 ;
    
    echo "Number 1 value = $number1 </br>";
    echo "Number 2 value = $number2</br>";
    echo "Total value =$total</br>";
    
    $names = array ("PHP" , "HTML" , "Javascript" );
    echo "<h3>To show inside the Array</h3>";
    echo '<pre>',print_r ($names,true),'</pre>';
    echo "<h3>To run the array in PHP</h3>";
    for ($i=0; $i<3; $i++){
        echo "</br>".$names[$i];
    }
    
    echo "<h3>To run the array in Javascript</h3>";
    
    
    ?>
    <script>
    var array = <?php  echo json_encode ($names);  ?>;
	    var i;
        for( i = 0 ; i < 3 ; i++ ){
            
            document.write("</br>"+array[i]);
        }
    </script>
</body>
</html>