<?php
require_once "connect.php";
session_start();

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

    $character = $_POST["delete"];
    $delete = "DELETE FROM kaufen WHERE name = '$character' AND user_id = '$user_id'";

    if($result1 = @$connection->query($delete)){

            $_SESSION["deleted_character"] = 'You have successfully deleted character.';
            header("Location: index.php");
        }
    }


$connection->close();





















?>
