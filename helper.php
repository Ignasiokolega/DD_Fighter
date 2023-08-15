<?php

    session_start();
    if ($_SESSION['status'] != true || !isset($_SESSION["status"])){
        header('Location: index.php');
        exit();
      }
    require_once 'connect.php';

    $connection = @new mysqli($host, $db_user, $db_password, $db_name);

        if ($connection->connect_errno !== 0)
        {
        echo "Error " . $connection->connect_errno;
        
        } else {

            $name = $_POST["name"];
            $username = $_SESSION['username'];

            $find_id = "SELECT id FROM users WHERE username = '$username'";

            if($result1 = @$connection->query($find_id)){
                $record1 = $result1->fetch_assoc();
                $user_id = $record1["id"];
            } else {
            $_SESSION["err_character"] = "You're not in database. Please contact with frontend, not backend";    
            header("bingo.php");
            }

$find_name = "SELECT * FROM kaufen WHERE name = '$name'";

    if($result1 = @$connection->query($find_name)){

        //existing heroes

        $exist_hero = $result1->num_rows;

        if($exist_hero > 0) {
            $_SESSION["err_name"] = "<span style='color: red'>That's name is already taken.</span>";
            header("Location: index.php");
        }

        $str = $_POST["str"];
        $dex = $_POST["dex"];
        $con = $_POST["con"];
        $int = $_POST["int"];
        $wis = $_POST["wis"];
        $cha = $_POST["cha"];
        $times = $_POST["times"];
        $strenght = $_POST["strenght"];
        $add = $_POST["-/+"];
        $to_add = $_POST["addition"];

        $creating_hero = "INSERT INTO kaufen VALUES (NULL,'$user_id','$name','$str','$dex','$con','$int','$wis','$cha','$times','$strenght','$add','$to_add')";
        if($result2 = @$connection->query($creating_hero)){
            $_SESSION["completed_character"] = 1;
            header("Location: index.php");
        }
    }
}
$connection->close();
?>
