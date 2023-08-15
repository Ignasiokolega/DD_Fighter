<?php
session_start();
require_once "connect.php";

$connection = @new mysqli($host , $db_user , $db_password , $db_name);

if ($connection->connect_errno !== 0)
{
echo "Error " . $connection->connect_errno;
} else {

$username = $_SESSION['username'];
$find_id = "SELECT id FROM users WHERE username = '$username'";

if($result1 = @$connection->query($find_id)){
    $record1 = $result1->fetch_assoc();
    $user_id = $record1["id"];
    $_SESSION["deleted_character"] = $user_id;
} else {
$_SESSION["err_character"] = "You're not in database. Please contact with frontend, not backend";    
header("bingo.php");
}
$name = $_POST["name"];
$find_name = "SELECT * FROM kaufen WHERE name = '$name' AND user_id = '$user_id'";
if($result = @$connection->query($find_name)){
    $exist_hero = $result->num_rows;

    if($exist_hero) {
      $data = $result->fetch_assoc();
     
$_SESSION['data'] = $data;
header("Location: index.php");
}
}
}
$connection->close();
?>
