<?php
session_start();
require_once "connect.php";


$connection = @new mysqli($host , $db_user , $db_password , $db_name);

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
        $_SESSION["err_character"] = "You're not in database. Please contact with frontend, not backend. If you don't know what that means, please contact with our support or create account";    
        header("DD_fight");
        }
$find_name = "SELECT * FROM kaufen WHERE name = '$name' AND user_id = '$user_id'";


    if($result1 = @$connection->query($find_name)){

        //existing heroes

        $exist_hero = $result1->num_rows;

        if($exist_hero > 0) {
            $_SESSION["err_name"] = "<span style='color: red'>That's name is already taken.</span>";
            header("Location: index.php");
            exit();
        }

            $stats = ['+3','-2','+0','+2','+1','+1'];
            shuffle($stats);
            $str = $stats[0];
            $dex = $stats[1];
            $con = $stats[2];
            $int = $stats[3];
            $wis = $stats[4];
            $cha = $stats[5];

            $strenght = [1,1,1,1,2,1,1,1,2,2];
            shuffle($strenght);
            $times = ($strenght[0]); 

            if($times === 2){
            $attack = [4,3,3,3,3,3,3,3,3,4,4];
            shuffle($attack);
            $van = ($attack[0]); 

            } else {

                $attack = [5,4,5,4,5,4,4,4,4,5];
                shuffle($attack);
                $van = ($attack[0]); 

            } 
            if($times === 2 AND $van === 4){

                $addition = ['+','-','-','-','+','-','-'];
                shuffle($addition);
                $add = $addition[0];

            } else if($times === 1 AND $van === 4) {

                $addition = ['+','-','+','+','+','+','-','-','-','-'];
                shuffle($addition);
                $add = $addition[0];

            } else {

                $addition = ['+','-'];
                shuffle($addition);
                $add = $addition[0];

            }

            if($times === 2 AND $van === 4 AND $add === '+'){

                $vax = (1);

            } else if($times === 1 AND $van === 4 AND $add === '-') {

                $to_add = [3,2,3,3,2,2,3,3,3,3,3,2,2,2];
                $add = '+';
                shuffle($to_add);
                $vax = ($to_add[0]);

            } else {

                $to_add = [1,2,1,2,1,1,1,2,1,1,1,2,2,3];
                shuffle($to_add);
                $vax = ($to_add[0]);

            }
        $creating_hero = "INSERT INTO kaufen VALUES (NULL,'$user_id','$name','$str','$dex','$con','$int','$wis','$cha','$times','$van','$add','$vax')";
        if($result2 = @$connection->query($creating_hero)){
            $_SESSION["completed_character"] = 1;
            header("Location: index.php");
        }
    }
}

$connection->close();







?>