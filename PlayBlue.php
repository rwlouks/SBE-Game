<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!--
 PlayBlue.php

--> 
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel = "stylesheet" href = "sbegame.css">
<style>
   .results 
   {
     height: 350px;
     overflow: auto;
   } 
   
   table
   {
        border:1px solid black;    
   }
   td
   {
    padding:'5';
    text-align:center;
    vertical-align: middle;
    position: relative;
   }
   th
   {
    text-align:center;
    background-color: #006699;
    color:white;
   }
  </style>

<script src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.11.1.min.js"></script>


<script>
var roundComplete = "Null";
var waiting;
function selectValue ($Value)
    {
      document.getElementById("userMessage").innerHTML = "Waiting";
      document.getElementById("sel1").disabled = true;
      document.getElementById("sel2").disabled = true;
      $.post("AddRoundInfo.php",
      {
        GameID:getCookie("SBEGame_GameID"),
        PlayerColor:getCookie("SBEGame_PlayerColor"),
        RoundNum:getCookie("SBEGame_RoundNum"),
        Selection:$Value
      },
      function (data, status){
       
      //alert(window.parent.location);
      //alert("Data: " + data +"\nStatus: " + status);
      //do
      //{
        waiting = setInterval(function(){checkRoundComplete()},1000);
        //checkRoundComplete();
        //setTimeout(function(){alert(roundComplete);}, 2000);

        
            //}
      //while (!complete);
      //alert("Back from checkRoundComplete");
      //window.self.close();
      }
      );
    }
 
 
    
function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    //alert (ca);
    for(var i=0; i<ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1);
        if (c.indexOf(name) != -1) {
            return c.substring(name.length, c.length);
        }
    }
    return "Not Found";
   }
   
function checkRoundComplete()
{
  $.post("roundCompleteCheck.php",
    {
      GameID:getCookie("SBEGame_GameID"),
      RoundNum:getCookie("SBEGame_RoundNum")-1
    },
    function (data, status){
    //alert("From roundCompleteCheck:" + data + "\nStatus: " +status);
    document.getElementById("userMessage").innerHTML = data;
    roundComplete = data;
    if (roundComplete.indexOf("Waiting") < 0)
    {
      //alert(roundComplete);
      clearInterval(waiting);
      var colorResult = getCookie("SBEGame_ColorSelected");
      colorResult = colorResult.toLowerCase();
      flashFile = 'urn-' + colorResult + '.swf';
      var urnResult = getCookie("SBEGame_UrnResult");
      //alert("urnResult: " + urnResult + "  flashFile: " + flashFile);
      //alert(document.cookie);
      changeUrn (urnResult, flashFile);
      playUrn(urnResult);
      document.getElementById("sel1").disabled = false;
      document.getElementById("sel2").disabled = false;
      getTable();
      var gameOverFlag = getCookie("SBEGame_GameOver");
      //alert ("gameOverFlag: "+gameOverFlag);
      //alert (document.cookie);
      if (gameOverFlag == 1)
      {
        gameOver();
  
      }
    }
    //getTable();
    }
    
    );
   
}
 function gameOver() {
    //alert ("gameOver function called");
    window.open("gameOver.php", "_blank", "toolbar=yes, scrollbars=yes, resizable=yes, width=400, height=400");
    
    
}

function getTable(){
  $("#tableContents").load("generateTable.php", function(response,status)
      {
        //alert("Back from generateTable\n" + response);
      });
}

function playUrn(urnResult) {
 	
 	//alert(urnResult);
 	var urnID = "Urn"+urnResult;
 	//alert("urnID " + urnID);
 	setTimeout(function(){document.getElementById(urnID).play()},500);
 	
 	}  

function changeUrn(urnResult, flashFile) {
      var flashSrc ='<object id = Urn' + urnResult + ' data= ' + flashFile + ' width = "100" height = "190"  >';
      flashSrc += '<param name="loop" value="false">';
      flashSrc += '<param name="play" value="false">';
      flashSrc += '</object>';
      flashSrc += '<figcaption>Urn' + urnResult + '</figcaption>';

      document.getElementById('fig' + urnResult).innerHTML = flashSrc;
 
}	     
</script>






<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>SBE Game Play Blue</title>

</head>

<body onload="getTable()">

<div class="container">
  <div class="header"><a href="#"><img src="http://upload.wikimedia.org/wikipedia/en/thumb/e/e4/Michigan_Tech_ath.svg/200px-Michigan_Tech_ath.svg.png" alt="" width="162" height="119" style="-webkit-user-select: none" /></a> 
    <!-- end .header --></div>
  <div class="sidebar1">
    <ul class="nav">
      <li><a href="index.html" target="_self">Home</a></li>
      <li><a href="Instructions.html" target="_self">Instructions</a></li>
      <li><a href="#">Scores</a></li>
      <li><a href="NewGame.php" target="_self">Start New Game</a><a href="#"></a></li>
      <li><a href="Play.php" target="_self">Play</a></li>
    </ul>
    <p> The above links demonstrate a basic navigational structure using an unordered list styled with CSS. Use this as a starting point and </p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <!-- end .sidebar1 --></div>
  <div class="contentArea">
 
        <h1>Play Blue</h1>
    <?php
       // print( "<p> Post info here </p>");
       //print_r($_POST);
       //print_r($_COOKIE);
       print '<h2 style="color: #0000ff"> Game Number: ';
       print $_POST[GameID];
       print "</h2>";
       print '<h2 style="color: #0000ff">'.$_POST[PlayerColor].' Player</h2>';
    ?> 
      
  <figure id = "fig11">
    <object id = "Urn11" data= "urn-green.swf" width = "100" height = "190"  >
      <param name="loop" value="false">
      <param name="play" value="false">
    </object>
    <figcaption>Urn 11</figcaption>
  </figure>
  <figure id = "fig12">
    <object id = "Urn12" data= "urn-green.swf" width = "100" height = "190"  >
      <param name="loop" value="false">
      <param name="play" value="false">
    </object>
    <figcaption>Urn 12</figcaption>
  </figure>
  <figure id = "fig21">
    <object id = "Urn21" data= "urn-green.swf" width = "100" height = "190"  >
      <param name="loop" value="false">
      <param name="play" value="false">
    </object>
    <figcaption>Urn 21</figcaption>
  </figure>
  <figure id = "fig22">
    <object id = "Urn22" data= "urn-green.swf" width = "100" height = "190"  >
      <param name="loop" value="false">
      <param name="play" value="false">
    </object>
    <figcaption>Urn 22</figcaption>
  </figure><br>
 
  </div>
  <table></table>
  <div class = "results">
    
    <table id="tableContents" border="1">
    </table>
  </div>            
 

    
  <p>Click the button to play the next round</p>
  <button id = "sel1" onclick="selectValue(1)">Select 1</button>
  <button id = "sel2" onclick="selectValue(2)">Select 2</button>
  <button onclick="playUrn('11')">Play Urn 11</button>
  <button onclick="playUrn('21')">Play Urn 21</button>
  <button onclick="changeUrn('11', 'urn-blue.swf')">Change Urn 11</button>
  <button onclick="changeUrn('21', 'urn-blue.swf')">Change Urn21</button>
  <button onclick="gameOver()">Game Over</button>
  <button onclick="getTable()">Get Table</button>
  <p id = "userMessage"></p>

 </div>
 <footer>
  <img src="footer.png" width="963" height="159" />
  </footer> 
  </body>
</html>
