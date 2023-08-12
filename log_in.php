<?php
session_start();

//if there is no data to crunch, sending to start page
if(!isset($_POST["username"]) || !isset($_POST["password"])){
header("Location: index.php");
}
//connect.php contains everything that is necessary to connect with mysql
require_once "connect.php";

//new connection
$connection = @new mysqli($host,$db_user,$db_password,$db_name);

//printing errors
if ($connection->connect_errno != 0)
{
echo "Error " . $connection->connect_errno;

} else {
  //no errors; downloading data from client
  $username = $_POST["username"];
  $password = $_POST["password"];

  $username = htmlentities($username,ENT_QUOTES,"UTF-8");

//making a query secure from mysql injection
  if ($result = @$connection->query(
    sprintf("SELECT * FROM users WHERE username ='%s'",
    mysqli_real_escape_string($connection,$username)))){

//if there is existing user with provided username, $existing_users === 1
    $existing_users = $result->num_rows;
    if ($existing_users){
      //$record is a whole record uploaded from database
      $record = $result->fetch_assoc();
      //verifying password
      if (password_verify($password, $record["password"])){
        $_SESSION["status"] = true;

        $_SESSION["id"] = $record["id"];
        $_SESSION["username"] = $record["username"];
        $_SESSION["email"] = $record["email"];

        unset($_SESSION["login_error"]);
        header('Location: DD_fight.php');
//closing the result to save little kittens
      $result->close();
    } else {
      $_SESSION["login_error"] = '<span id="error">Wrong password!</span>';
      header('Location: index.php');
    }
    } else {
      $_SESSION["login_error"] = '<span id="error">Wrong login or password!</span>';
      header('Location: index.php');$_SESSION["login_error"] = '<span id="error">Wrong login or password!</span>';
      header('Location: index.php');
    }

  }
//closing the connection to save even more little kittens
$connection->close();
}


?>