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

            $name1 = $_POST["name1"];
            $name2 = $_POST["name2"];
            $username = $_SESSION['username'];
            $find_id = "SELECT id FROM users WHERE username = '$username'";
            if($result1 = @$connection->query($find_id)){
                $record1 = $result1->fetch_assoc();
                $user_id = $record1["id"];
            } else {
            $_SESSION["err_character"] = "You're not in database. Please contact with frontend, not backend";    
            header("bingo.php");
            }
            $hero_stats1 = "SELECT contents FROM bingos WHERE character_name = '$name1' AND user_id = '$user_id' ORDER BY id";
            $hero_stats2 = "SELECT contents FROM bingos WHERE character_name = '$name2' AND user_id = '$user_id' ORDER BY id";
        
            $results_array1 = [];
            $result2 = $connection->query($hero_stats1);
            while ($row = $result2->fetch_assoc()) {
                $row = array_shift($row);
            $results_array[] = $row;
}
            $results_array2 = [];
            $result3 = $connection->query($hero_stats2);
            while ($row = $result3->fetch_assoc()) {
                $row = array_shift($row);
            $results_array[] = $row;
}
            $_SESSION["hero1"] = $results_array1;
            $_SESSION["hero2"] = $results_array2;
            header("Location: DD_fight.php");
            
            
        }
    $connection->close();

    
?>
