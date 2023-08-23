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

<!--HEAD-->
         
      <head>
        <meta charset="utf-8">
        <title>D&D Fight!</title>
        <link rel="stylesheet" href="style.css">
      </head>
     
<!--BODY-->
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
              <input type="number" name="times" required placeholder = "1" min="1" max="100">d 
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
    
    <form action='in_need_of_info.php' method='post'>
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
      <tr>
        <th>Round 0</th>
      <?php
        if(isset($_SESSION['hero1']) AND isset($_SESSION['hero2'])){

          $hero1[] = $_SESSION['hero1'];
          $hero2[] = $_SESSION['hero2'];
          $hp1 = $_SESSION['hp1'];
          $hp2 = $_SESSION['hp2'];
          echo '<td>'.$hero1['name'].'</td>';
          echo '<td>'.$hp1.'</td>';
          echo '<td>0</td>';
          echo '<td>0</td>';
          echo '<td>'.$hero2['name'].'</td>';
          echo '<td>'.$hp2.'</td>';
          echo '<td>0</td>';
          echo '<td>0</td>';
          echo '</tr>';
          echo '<th>Round 1</th>';
          



        }
      ?>  
     </table>
 <!--PLACE BETWEEN-->
         <div>

            <br> 
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
          </div>







 <!--LOG OUT-->
       
          <button id="logout_button"><a href="logout.php">LOG OUT</a></button>
        
 
 </body>
</html>
<?php
  //function used above 
    function count_attack($hero1, $hero2)
    {
    $times = $hero1['Times'];
    $strenght = $hero1['Attack Strenght'];
    $add1 = $hero1['+/-'];
    $addition = $hero1['Addition'];
    $add2 = $hero1['Hit Attempt'];
    $addition2 = $hero1['Add'];
    $ac = $hero1['Armour Class'];
    $i = 1;
    $attacks = [0];
    do{
    $att = random_int(1,$strenght);
    array_push($attacks, $att);  
    $i++;
    } while($i <= $times);
    $attack = [0];
    do{
    if(isset($attack)){ 
    $attack += array_shift($attacks);
    }
    } while(count($attacks) > 0);
    if($add1 === '+') {
    $attack += $addition;
    } else {
    $attack -= $addition;  
    } 
    $attack_roll = random_int(1,20);
    switch($add2){
      case '+':
        $attack_roll += $addition2;
        break;
      case '-':
        $attack_roll -= $addition2;
        break;
    }
    }

 ?>