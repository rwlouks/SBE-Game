<?php
//
//generateTable.php
//

require 'db.inc';

// Build the Results table header
print "<caption>Game Progress</caption>";
print "<tr>";
print "<th>Round</th>";
print "<th>Urn 11</th>";
print "<th>Urn 12</th>";
print "<th>Urn 21</th>";
print "<th>Urn 22</th>";
print "<th>Color Selected</th>";
print "</tr>";


// Query the GameResults table and build the row of the Results table

$sql = "SELECT * FROM RoundInfo
	WHERE `GameID` = '{$_REQUEST["SBEGame_GameID"]}' AND RoundComplete = TRUE
	ORDER BY RoundNumber DESC"; 
//print_r ($_REQUEST);
$result     = mysqli_query($mysqlConnection, $sql) or
                die('<b>Invalid Query: </b> ' .
                mysqli_errno() . ': ' .
                mysqli_error());
// print_r (mysql_fetch_array($result));
while ($resource_details = mysqli_fetch_array($result)) {

  
  $GameID        = $resource_details['GameID']; 
  $RoundNum      = $resource_details['RoundNumber'];
  $UrnResult     = $resource_details['UrnResult'];
  $ColorResult   = $resource_details['ColorResult'];
  
  switch ($UrnResult)
{
    case "11":
        $urn11 = "X";
        $urn12 = " ";
        $urn21 = " ";
        $urn22 = " ";
        break;
    case "12":
        $urn11 = " ";
        $urn12 = "X";
        $urn21 = " ";
        $urn22 = " ";
        break;
    case "21":
        $urn11 = " ";
        $urn12 = " ";
        $urn21 = "X";
        $urn22 = " "; 
        break;
    case "22":
        $urn11 = " ";
        $urn12 = " ";
        $urn21 = " ";
        $urn22 = "X";
        break;
    
}

  print <<<EOF
  <tr>
    <td>$RoundNum</td>
    <td>$urn11</td>
    <td>$urn12</td>
    <td>$urn21</td>
    <td>$urn22</td>
    <td>$ColorResult</td>
  </tr>
EOF;
}
 	
?>
