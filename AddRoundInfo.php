<?php
//
// AddRound.php
//
require 'db.inc';

       $RoundNumber = $_POST["RoundNum"];
       $RoundNumber++;
       setcookie("SBEGame_RoundNum", $RoundNumber);
       setcookie("SBEGame_GameOver", "Unknown");
       //print $_POST["GameID"];
       //print $_POST["PlayerColor"];
       //print $_POST["Selection"];
       //print "\n Round Number: " .$_POST["RoundNum"];
       
      if ($_POST["PlayerColor"] == "Blue")
         {
           $colorSelection = "BlueSelection";
         }
         else
         {
           $colorSelection = "GreenSelection";  
         }  
 
       
      $query = "SELECT * FROM  RoundInfo
      		WHERE GameID = '{$_POST["GameID"]}' AND RoundNumber = '{$_POST["RoundNum"]}'";
       $result = mysqli_query($mysqlConnection, $query);
       $row = mysqli_fetch_array($result);
       if (count($row) > 0)
       {
        $row[$colorSelection] = $_POST["Selection"];
       	//print_r ($row);
       	// Update the selection portion of the RoundInfo record.
       	$query = "UPDATE RoundInfo
       		  SET {$colorSelection} = '{$_POST["Selection"]}'
       		  WHERE GameID = '{$_POST["GameID"]}' AND RoundNumber = '{$_POST["RoundNum"]}'";
        mysqli_query ($mysqlConnection, $query);
        $gameOverFlag = updateGameResults ($mysqlConnection, $row["GameID"], $row["RoundNumber"], $row["BlueSelection"], $row["GreenSelection"]);
 	//if ($gameOverFlag)
 	//{
 	//  setcookie("SBEGame_GameOver", "True");
 	//}
 	//else
 	//{
 	//  setcookie("SBEGame_GameOver", "False");  
 	//}  
       }
       else
       {
         //print "Not round not found";
                  $query = "INSERT INTO RoundInfo (GameID, RoundNumber, {$colorSelection})
         	   VALUES ('{$_POST["GameID"]}', '{$_POST["RoundNum"]}', '{$_POST["Selection"]}')";
       	 //print $query; 
         mysqli_query ($mysqlConnection, $query);
       }
       
   function updateGameResults ($con, $gameID, $roundNum, $blueSelection, $greenSelection)
    {
     $sql = "SELECT * FROM GameResults INNER JOIN GameProfile
             ON GameResults.ProfileIndex = GameProfile.ProfileIndex    
     	     WHERE GameResults.GameID = {$gameID}";
     $result = mysqli_query($con, $sql);
     $gameInfo = mysqli_fetch_array($result);
     //print_r ($gameInfo);
     $numRounds = $gameInfo['NumRounds'];
     $urn = "Blue".$blueSelection.$greenSelection;
     //print $urn."\n";
     $blueOdds = round($gameInfo[$urn] / $gameInfo["BallsPerUrn"], 3);
     print $blueOdds."\n";
     $random = round(lcg_value(), 3);
     print $random."\n";
    
     if ($random <= $blueOdds)
     {
       $colorResult = "Blue";
     }
     else
     {
       $colorResult = "Green";
     }    
     
     $sql = "UPDATE RoundInfo 
             SET UrnResult = '{$blueSelection}{$greenSelection}', ColorResult = '{$colorResult}', RoundComplete = 1
             WHERE GameID = {$gameID} AND RoundNumber = {$roundNum}";
     //print $sql;
     mysqli_query($con, $sql);
     
     if ($numRounds == $roundNum)
     {
       $sql = "SELECT COUNT(RoundNumber) AS BlueWins FROM RoundInfo WHERE ColorResult = 'Blue'";
       //print $sql; 

       $result  = mysqli_query($con, $sql) or
                die('<b>Invalid Query: </b> ' .
                mysqli_errno() . ': ' .
                mysqli_error());
       $resource_details = mysqli_fetch_array($result);
       //print_r ($resource_details);
       //print "<p>Blue Wins = " . $resource_details['BlueWins']."</p>";
       $GreenWins = $numRounds - $resource_details['BlueWins'];
       //print "<p>Green Wins = " . $GreenWins ."</p>";

      $greenOdds = round($GreenWins / $numRounds, 3);
      // print $greenOdds."\n";
      $random = round(lcg_value(), 3);
       //print $random."\n";
      if ($random <= $greenOdds)
       {
         $colorResult = "Green";
       }
       else
       {
         $colorResult = "Blue";
       }    
   
       //print "<p>Game Winner: " . $colorResult . "</p>";
     
       $sql = "UPDATE GameResults 
             SET GameComplete = 1, GUColorResult = '{$colorResult}', GUBlue = {$resource_details['BlueWins']}, GUGreen = {$GreenWins}
             WHERE GameID = {$gameID}";
       //print $sql;
       mysqli_query($con, $sql);
       return true;
   }
   else
   {
     return false;
   }        
  }       	   	
?> 
    
