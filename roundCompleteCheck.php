<?php
//
//roundCompleteCheck.php
//

require 'db.inc';



// Query the RoundInfo table and check the RoundComplete flag
//print_r ($_POST);
$gameID = $_POST["GameID"];
$roundNum = $_POST["RoundNum"];
$sql = "SELECT * FROM RoundInfo
	WHERE GameID = {$gameID} AND RoundNumber = {$roundNum}";
//print $sql; 

$result     = mysqli_query($mysqlConnection, $sql) or
                die('<b>Invalid Query: </b> ' .
                mysqli_errno() . ': ' .
                mysqli_error());
//print_r (mysql_fetch_array($result));
$resource_details = mysqli_fetch_array($result);
$Complete = $resource_details['RoundComplete'];
$ColorResult = $resource_details['ColorResult'];
$UrnResult = $resource_details['UrnResult'];
$BlueSelection = $resource_details['BlueSelection'];
$GreenSelection = $resource_details['GreenSelection'];

//print_r ($resource_details);
if ($Complete)
{
  setcookie ("SBEGame_RoundComplete","True");
  setcookie ("SBEGame_ColorSelected",$resource_details['ColorResult']);
  setcookie ("SBEGame_UrnResult",$resource_details['UrnResult']);
  //setcookie ("SBEGame_GameOver", 1);
  //print "Blue Slection: " . $resource_details['BlueSelection'] . "\nGreenSelection: " . $resource_details['GreenSelection'];
  //print "\nUrn: " . $resource_details['UrnResult'] . "\nColor Selected from Urn: ". $resource_details['ColorResult'];
  
}
else
{
  setcookie ("SBEGame_RoundComplete","False"); 
  //print "Waiting";
  
}

$sql = "SELECT * FROM GameResults
	WHERE GameID = {$gameID}";
//print $sql; 

$result     = mysqli_query($mysqlConnection, $sql) or
                die('<b>Invalid Query: </b> ' .
                mysqli_errno() . ': ' .
                mysqli_error());
//print_r (mysql_fetch_array($result));
$resource_details = mysqli_fetch_array($result);
$GameComplete = $resource_details['GameComplete'];
setcookie ("SBEGame_GameOver", $GameComplete);

if ($Complete)
{
  //setcookie ("SBEGame_RoundComplete","True");
  //setcookie ("SBEGame_ColorSelected",$resource_details['ColorResult']);
  //setcookie ("SBEGame_UrnResult",$resource_details['UrnResult']);
  //setcookie ("SBEGame_GameOver", 1);
  print "Blue Slection: " . $BlueSelection . "\nGreenSelection: " . $GreenSelection;
  print "\nUrn: " . $UrnResult . "\nColor Selected from Urn: ". $ColorResult;
  
}
else
{
  //setcookie ("SBEGame_RoundComplete","False"); 
  print "Waiting";
  
}


?> 
