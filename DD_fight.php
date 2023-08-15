<?php
session_start();
if ($_SESSION['status'] != true || !isset($_SESSION["status"])){
  header('Location: index.php');
  exit();
}

?>

<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="utf-8">
    <title>D&D Fight!</title>
    <link rel="stylesheet" href="style.css">
  </head>
  <body>
    <div>
    <p>Hello, <?=$_SESSION["username"]?>! <br>
  You are successfully logged into your account! <br>
  Your e-mail: <?=$_SESSION["email"]?> </p>

    <br> 
    <?php 
    if(isset($_SESSION["Success"])) {
    echo '<p>'.$_SESSION["Success"]."</p>";
    }
    if (isset($_SESSION['err_name'])){
      echo "<p>".$_SESSION['err_name']."</p>";
      unset($_SESSION['err_name']);
    } 
    if (isset($_SESSION["err_character"])) {
      unset($_SESSION['status']);
      header('DD_fight.php');
      exit();
    }
    if(isset($_SESSION["deleted_character"])) {
      echo "<p>".$_SESSION["deleted_character"]."</p>";
    }
    ?>
    <br>

  
  <?php
    if(isset( $_SESSION["completed_character"])){
      echo "I see you have created your character. You can just use it down below.";
      unset($_SESSION["completed_character"]);
      }
      if(isset( $_SESSION["deleted_character"])){
        echo "I see you have deleted your character";
        unset($_SESSION["deleted_character"]);
        }
  ?>

    <h2><p> Do you want  to add D&D character? No problem. Just fill up the form</p></h2>

    <form action="helper.php" method="post">
      <input type="text" name="name" required placeholder = "Name">

      <?php 
        
        if(isset ($_SESSION["err_name"])) {
          echo  $_SESSION["err_name"]; 
          unset($_SESSION["err_name"]);
        }
      ?>
      <input type="int" name="str" required placeholder = "Strength" pattern="[+|-][0-5]">
      <input type="int" name="dex" required placeholder = "Dexterity" pattern="[+|-][0-5]">
      <input type="int" name="con" required placeholder = "Constitution" pattern="[+|-][0-5]">
      <input type="int" name="int" required placeholder = "Intelligence" pattern="[+|-][0-5]">
      <input type="int" name="wis" required placeholder = "Wisdom" pattern="[+|-][0-5]">
      <input type="int" name="cha" required placeholder = "Charisma" pattern="[+|-][0-5]">
      <br>
      <input type="int" name="times" required placeholder = "3">d 
      <input type="int" name="strenght" required placeholder = "5">
      <input type="radio" name="-/+" required value='+' id='+'>+
      <input type="radio" name="-/+" required value='-' id='-'>-
      <input type="int" name="addition" required placeholder="2"><br>
      <input type="submit" name="checkbox" value ="Click it when you finish">
    </form>
    
    <br><br><br>

    If you want to see your character, just write it name down below.
    <br> <br>
    <form action="created_characters.php" method="post">
    <input type="text" name="name" required placeholder = "Name of Existing Character">
    <input type="submit" name="checkbox" value ="Click it when you finish">
    </form>

    <table>

    <?php
    if(isset($_SESSION['data'])){
      $data = $_SESSION['data']; 

      //unwanted values :(
      unset($data['user_id']);
      unset($data['id']);

      foreach($data as $header => $content) {
        echo "<tr>"; 
        echo "<th>".$header."</th>";
        echo "<td>".$content."</td>";
        echo "</tr>";  
      }  
    }
    ?>
    </table>

  <p> Wanna delete character? Write down it's name. <p> 
  <form action="delete_hero.php" method="post">
    <input type="text" name="delete" required placeholder = "Name">

    <?php 
        
        if(isset ($_SESSION["err_name"])) {
          echo  $_SESSION["err_name"]; 
          unset($_SESSION["err_name"]);
        }
        
      ?>
      <input type="submit" name="checkbox" onsubmit="confirm ('Do you really want to delete this character? You can\'t undo this');" value ="Delete">
      </form>
      
  <p> Do you want random character? Just click down below. </p> 
  <form action="randomizer.php" method="post">
      <input type="text" name="name" required placeholder = "Name">
      <?php 
        
        if(isset ($_SESSION["err_name"])) {
          echo  $_SESSION["err_name"]; 
          unset($_SESSION["err_name"]);
        }
      ?>
      <br><br>
      <input type="submit" name="checkbox" value ="Generate">
  </form>
        <p> Do you have 2 character or more now? Wanna them to fight? Write down their names and hp. Enjoy! <p>
    </body>
</html>

      

  

        <br> 
        <br>
        <br>
        <br>









    <button id="logout_button"><a href="logout.php">LOG OUT</a></button>




  </body>
</html>