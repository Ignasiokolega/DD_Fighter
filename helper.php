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
            }

            $creating_bingo = "SELECT contents FROM bingos WHERE character_name = '$name' AND user_id = '$user_id' ORDER BY id";

        
            
                $results_array = [];
                $result2 = $connection->query($creating_bingo);
                while ($row = $result2->fetch_assoc()) {
                    $row = array_shift($row);
                $results_array[] = $row;
}
                $_SESSION["new_bingo"] = $results_array;
                header("Location: bingo.php");
            
            
        }
    $connection->close();

    
?>
