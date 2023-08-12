<?php
session_start();
if (!isset($_SESSION["registration"])){
  header('Location: index.php');
} else {
  unset($_SESSION["registration"]);
}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>DD_Characters</title>
    <link rel="stylesheet" href="style.css">
 </head>
  <body>


    <center><h1>LET CREATE SOME CHARACTERS!</h1><center>

    <br> <a href="index.php">Log in for the first time!</a>


  </body>
</html>