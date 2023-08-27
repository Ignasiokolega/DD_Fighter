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
            $_SESSION["err_character"] = "You're not in database. Sorry for problems. If you haven't created your account, page won't work without that";    
            header("DD_fight.php");
            }
            $hero_stats1 = "SELECT * FROM kaufen WHERE name = '$name1' AND user_id = '$user_id'";
            $hero_stats2 = "SELECT * FROM kaufen WHERE name = '$name2' AND user_id = '$user_id'";
            
            if($result2 = $connection->query($hero_stats1)){
                $results_array1 = [];
                while ($row = $result2->fetch_assoc()) {
                    if(count($row) > 0){    
                    $results_array1 = $row;
                    } else {
                    $results_array1 = false;    
                    }
                }
            } 
            if($result3 = $connection->query($hero_stats2)){
                $results_array2 = [];
                while ($row = $result3->fetch_assoc()) {
                    if(count($row) > 0) {
                    $results_array2 = $row;
                    } else {
                    $results_array2 = false;
                    }
                }
            }
            if($results_array1 AND $results_array2){
            $_SESSION["hero1"] = $results_array1;
            $_SESSION["hero2"] = $results_array2;
            $_SESSION['hp1'] = $_POST['max_hp1'];
            $_SESSION['hp2'] = $_POST['max_hp2'];
            } else {
             $_SESSION['err_2_characters'] = 'At least one of your character is not in database';   
            }
        }   
            
    $connection->close();

    header("Location: DD_fight.php");
    
?>

