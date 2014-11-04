<?php


   // This file is the same as example 6-7, but includes mysqlclean() and shellclean() 

   $server = "localhost";
   $databaseName = "mis2200_sbeGame";
   $username = "mis2200_sbeGame";
   $password = "sbeGameAdmin";
   
   
   
   
   $mysqlConnection = mysqli_connect($server, $username, $password);
if (!$mysqlConnection)

{
	print "<p>Please try later.</p>";
}
else
{
//print "<p>Connected, trying to read db</p>";
mysqli_select_db($mysqlConnection, $databaseName);
}
        
   function showerror()
   {
      die("Error " . mysql_errno() . " : " . mysql_error());
   }

   function mysqlclean($array, $index, $maxlength, $mysqlConnection)
   {
     if (isset($array["{$index}"]))
     {
        $input = substr($array["{$index}"], 0, $maxlength);
        $input = mysql_real_escape_string($input, $mysqlConnection);
        return ($input);
     }
     return NULL;
   }

   function shellclean($array, $index, $maxlength)
   {
     if (isset($array["{$index}"]))
     {
       $input = substr($array["{$index}"], 0, $maxlength);
       $input = EscapeShellCmd($input);
       return ($input);
     }
     return NULL;
   }
?>