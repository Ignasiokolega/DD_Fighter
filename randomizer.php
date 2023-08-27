<?php
session_start();
require_once "connect.php";


$connection = @new mysqli($host, $db_user, $db_password, $db_name);

if ($connection->connect_errno !== 0) {
    echo "Error " . $connection->connect_errno;
} else {

    $name = $_POST["name"];
    $username = $_SESSION['username'];
    $find_id = "SELECT id FROM users WHERE username = '$username'";

    if ($result1 = @$connection->query($find_id)) {
        $record1 = $result1->fetch_assoc();
        $user_id = $record1["id"];
    } else {
        $_SESSION["err_character"] = "You're not in database. Please contact with frontend, not backend. If you don't know what that means, please contact with our support or create account";
        header("DD_fight");
    }
    $find_name = "SELECT * FROM kaufen WHERE name = '$name' AND user_id = '$user_id'";


    if ($result1 = @$connection->query($find_name)) {

        //existing heroes

        $exist_hero = $result1->num_rows;

        if ($exist_hero > 0) {
            $_SESSION["err_name"] = "<span style='color: red'>That's name is already taken.</span>";
            header("Location: index.php");
            exit();
        }

        //Contains: Str, Dex, Con, Int, WIs, Cha, Number of Dices, Attack Strenght Bonus, Armour Class, Attack Strenght Bonus
        $randoms = [
            [2, 0, -2, 1, 3, 1, 1, 5, 2, 11, 2],
            [-1, 3, 0, 1, 2, 0, 2, 2, -1, 14, 3],
            [1, 2, 1, 0, 0, 1, 1, 4, 1, 13, 1],
            [3, -2, 1, 2, 1, 0, 1, 6, 3, 9, 4]
        ];
        $index = count($randoms) - 1;

        $chosenOne = $randoms[random_int(0, $index)];


        $creating_hero = "INSERT INTO kaufen VALUES (NULL,'$user_id','$name','$chosenOne[0]','$chosenOne[1]','$chosenOne[2]','$chosenOne[3]','$chosenOne[4]','$chosenOne[5]','$chosenOne[6]','$chosenOne[7]','$chosenOne[8]','$chosenOne[9]','$chosenOne[10]')";
        if ($result2 = @$connection->query($creating_hero)) {
            $_SESSION["completed_character"] = 1;
            header("Location: index.php");
        }
    }
}

$connection->close();
