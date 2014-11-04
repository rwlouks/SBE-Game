<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
                      "http://www.w3.org/TR/html401/loose.dtd">
<!-- GameOver.php -->
<html>
<?php
  require 'db.inc';
?>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <title>The Times-Tables</title>
</head>
<body bgcolor="#ffffff">
<h1>Game Over</h1>

<?php
 // print_r($_COOKIE);
  //Look up the Game Profile information
  $Game = $_COOKIE['SBEGame_GameID'];
  $sql = "SELECT * FROM GameResults WHERE GameID = $Game";
  //print $sql; 

  $result     = mysqli_query($mysqlConnection, $sql) or
                die('<b>Invalid Query: </b> ' .
                mysqli_errno() . ': ' .
                mysqli_error());
  $resource_details = mysqli_fetch_array($result);
  //print_r ($resource_details);
    
  print "<p>Blue Wins = " . $resource_details['GUBlue']."</p>";
  print "<p>Green Wins = " . $resource_details['GUGreen'] ."</p>";
   
  print "<p>Game Winner: " . $resource_details['GUColorResult'] . "</p>";
  if ($resource_details['GUColorResult'] == "Green")
    {
      print "<object data= 'grandurn-green.swf' width = '150' height = '285' type='application/vnd.adobe.flash-movie'><param name='loop' value='false'></object>";
    }  
    else
    {
      print "<object data= 'grandurn-blue.swf' width = '150' height = '285' type='application/vnd.adobe.flash-movie'><param name='loop' value='false'></object>";
    }    
     

?>
</body>
</html>

