<?php
 //Session things
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

    <!--GREETING USER AND GIVING HIM INFO--> 
          
          
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

        
        
        
        
    <!--INFORMATION ABOUT USER'S SUCCESFULLY DELETING/ADDING CHARACTER--> 
                
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
          
    <!--NEW CHARACTER FORM-->
          

                  <h2><p> Do you want  to add D&D character? No problem. Just fill up the form</p></h2>

              
            <form action="new_dd_character.php" method="post">
              NAME:   
                <input type="text" name="name" required placeholder = "Name">

                <?php 
                  
                  if(isset ($_SESSION["err_name"])) {
                    echo  $_SESSION["err_name"]; 
                    unset($_SESSION["err_name"]);
                  }
                ?>
                <br>
              <h3>STATS:</h3> <br>
                <?php 
                @$variables = [$str,$dex,$con,$int,$wis,$cha];
                $strings1 = ['str','dex','con','int','wis','cha'];
                $strings2 = ['STRENGTH','DEXTERITY','CONSTITUTION','INTELLIGENCE','WISDOM','CHARISMA'];
                $var = ['-5','-4','-3','-2','-1','+0','+1','+2','+3','+4','+5'];
                $e = 0;
                do{  
                $i = 0;
                echo $strings2[$e].":   ";  
                echo "<select name=" . $strings1[$e] . ">";
                do{
                echo "<option value=" . '"' . $var[$i] . '">' . $var[$i] . "</option>";
                $i ++;
                } while($i <= 10); 
                echo "</select>"."<br> <br>";
                $e ++;
                } while($e <= 5);
                
                
                ?>
              ARMOUR CLASS: <br>
                <input type="range" name="armour_class" required value="10" min='1' max='54' oninput="this.nextElementSibling.value = this.value">
                <output>10</output>
                <br>
              ATTACK STRENGTH: <br>
                <input type="number" name="times" required placeholder = "1" min="1" max="10">d 
                <input type="number" name="strenght" required placeholder = "4" min="1" max="100">
                <select name="attack_s">
                  <option value="+">+</option>
                  <option value="-">-</option>
                </select>
                <input type="number" name="addition" min="0" max="999" required placeholder="3"><br>
              ATTACK ROLL: <br>
                <select name="attack_r">
                  <option value="+">+</option>
                  <option value="-">-</option>
                </select>
                <input type='number' name='roll_add' required placeholder='Addition' min="0" max="41">
                <br>
                <input type="submit" name="checkbox" value ="Click it when you finish">
              </form>
              
            
    <!--PLACE BETWEEN-->
                  
              <br>
              <br>
              <br>
                  
      <!--TABLE WITH CHOOSEN CHARACTER-->     
                
              If you want to see your character, just write it name down below.
              <br> 
              <br>
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
    <!--DELETING AND RANDOMIZING CHARACTERS FORMS--> 
            <div> 
              <p> Wanna delete character? Write down it's name. <p> 
              <form action="delete_hero.php" method="post" >
                <input type="text" name="delete" required placeholder = "Name">
                <?php 
                    
                    if(isset ($_SESSION["err_name"])) {
                      echo  $_SESSION["err_name"]; 
                      unset($_SESSION["err_name"]);
                    }
                    
                  ?>
                  <input type="submit" name="checkbox"  value ="Delete" onclick="return confirm('Do you really want to delete this character? You can\'t undo this');">
                  </form>
              </div>    
            <div> 
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
              </div>        
    <!--FIGHT-->
            
        <p> Do you have 2 character or more now? Wanna them to fight? Write down their names and hp. Enjoy! <p>
        
        <form action='helper.php' method='post'>
          <input type='text' name='name1' required placeholder ='John'>  
          <input type='int'  name='hp1' required placeholder = '20'> 
          <br>
          <input type='text' name='name2' required placeholder ='John'>  
          <input type='int'  name='hp2' required placeholder = '20'> 
          <br>
          <input type='submit' name='submit' value='I have choosen'>          
        </form>
        <table>  
          <tr>
            <th> Round\Info </th>
            <th> Name of First Character </th>
            <th> Hp after round </th>
            <th> Damage Dealt</th>
            <th> Damage Taken</th>
            <th> Name of Second Character </th>
            <th> Hp after round </th>
            <th> Damage Dealt </th>
            <th> Damage Taken</th>
          </tr>
          <?php
            if(isset($_SESSION['hero1']) AND isset($_SESSION['hero2'])){
              $hero1 = $_SESSION['hero1'];
              $hero2 = $_SESSION['hero2'];
              fight($hero1, $hero2);
            }
          ?>  
         </table>
    
      
          <br> <br> <br> <br> <br> <br> <br>
      







    <!--LOG OUT-->
        
            <button id="logout_button"><a href="logout.php">LOG OUT</a></button>
          
  
  


  </body> 
 </html>
<?php
 //function used above 
  function fight($hero1, $hero2)
   {
   //first character
    $h1_times = $hero1['Times'];
    $h1_strenght = $hero1['Attack Strenght'];
    $h1_add1 = $hero1['+/-'];
    $h1_addition = $hero1['Addition'];
    $h1_add2 = $hero1['Hit Attempt'];
    $h1_addition2 = $hero1['Add'];
    $h1_ac = $hero1['Armour Class'];
    $hp1 = $_SESSION['hp1'];
   //second character
    $h2_times = $hero2['Times'];
    $h2_strenght = $hero2['Attack Strenght'];
    $h2_add1 = $hero2['+/-'];
    $h2_addition = $hero2['Addition'];
    $h2_add2 = $hero2['Hit Attempt'];
    $h2_addition2 = $hero2['Add'];
    $h2_ac = $hero2['Armour Class'];
    $hp2 = $_SESSION['hp2'];
   //battle to the end of the life.
    $count = 0;
    do{      
      echo "<tr>";
      echo "<th>Round" . $count . "</th>";
      $count ++;
      $i = 1;
      $h1_attacks = [];
      do{
          $h1_att = random_int(1,$h1_strenght);
          array_push($h1_attacks, $h1_att);  
          $i++;
          } while($i <= $h1_times);
      $h1_attack = 0;
      do{
          if(isset($attack)){ 
          $h1_attack += array_shift($h1_attacks);
        }
        } while(count($h1_attacks) > 0);
        if($h1_add1 === '+') {
          $h1_attack += $h1_addition;
        } else {
          $h1_attack -= $h1_addition;  
        } 
        $h1_attack_roll = random_int(1,20);
        switch($h1_add2){
          case '+':
            $h1_attack_roll += $h1_addition2;
            break;
          case '-':
            $h1_attack_roll -= $h1_addition2;
            break;
        }
   //Second character calculations  
          

          $i = 1;
          $h2_attacks = [0];
      do{
        $h2_att = random_int(1,$h2_strenght);
        array_push($h2_attacks, $h2_att);  
        $i++;
      } while($i <= $h2_times);
        $h2_attack = 0;
        do{
          if(isset($attack)){ 
            $h2_attack += array_shift($h2_attacks);
          }
         } while(count($h2_attacks) > 0);
      if($h2_add1 === '+') {
        $h2_attack += $h2_addition;
      } else {
        $h2_attack -= $h2_addition;  
      } 
      $h2_attack_roll = random_int(1,20);
      switch($h2_add2){
        case '+':
          $h2_attack_roll += $h2_addition2;
          break;
        case '-':
          $h2_attack_roll -= $h2_addition2;
          break;
      }
   //Attacks, and back to the start
        
        
       if($h2_ac <= $h1_attack_roll AND $h1_attack_roll > 1 OR $h1_attack_roll >= 20){
          $hp2 -= $h1_attack;
          $h2_damaged = true;
       } 
       if($h1_ac <= $h2_attack_roll AND $h2_attack_roll > 1 OR $h2_attack_roll >= 20){
          $hp1 -= $h2_attack;
          $h1_damaged = true;
       } 
       if($hp1 <= 0){
        $hp1 = 0;
       } 
       if($hp2 <= 0){
        $hp2 = 0;
       } 
       echo '<td>'.$hero1['name'].'</td>';
       echo '<td>'.$hp1.'</td>';
       if(isset($h2_damaged) AND $h2_damaged !== false){
        echo '<td>' . $h1_attack . '</td>';
       } else {
        echo '<td>0</td>';
       }
       if(isset($h1_damaged) AND $h1_damaged !== false){
        echo '<td>' . $h2_attack . '</td>';
       } else {
        echo '<td>0</td>';
       }
       echo '<td>'.$hero2['name'].'</td>';
       echo '<td>'.$hp2.'</td>';
       if(isset($h1_damaged) AND $h1_damaged !== false){
        echo '<td>' . $h2_attack . '</td>';
       } else {
        echo '<td>0</td>';
       }
       if(isset($h2_damaged) AND $h2_damaged !== false){
        echo '<td>' . $h1_attack . '</td>';
       } else {
        echo '<td>0</td>';
       }
       echo '</tr>';
    }while($hp1 !== 0 AND $hp2 !== 0);
    }

 ?>