<?php
  session_start();
    //If you're not logged in, you're going to index.php
  if ($_SESSION['status'] != true || !isset($_SESSION["status"])){
    header('Location: index.php');
    exit();
  }
  /*If at least one of your name for existing characters
    And checking in database give you information, 
    that name with given user id don't exist, you will get informed, 
  */
  if (isset($_SESSION['err_2_characters'])){
    echo $_SESSION['err_2_characters'];
    unset($_SESSION['err_2_characters']);
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
          
    <!--GREETING USER AND GIVING THEM THEIR EMAIL-->
      <p>Hello, <?=$_SESSION["username"]?>! <br>
      You are successfully logged into your account! <br>
      Your e-mail: <?=$_SESSION["email"]?> </p>
      <br>
    <!--INFO ABOUT SUCCESSFUL DELETING-->   
      <?php 
        if(isset($_SESSION["deleted_character"])) {
          echo "<p>".$_SESSION["deleted_character"]."</p>";
        }
        /*if you try to create two characters with same name
          you won't create second one and you will get something like that information:
         'You can't create character with same name as other of your characters' 
        */
        if (isset($_SESSION['err_name'])){
          echo "<p>".$_SESSION['err_name']."</p>";
          unset($_SESSION['err_name']);
        } 
        /*if user account is not in database,
          It will send him do index, and unset status,
          to make sure they will use real accounts 
        */  
        if (isset($_SESSION["err_character"])) {
          unset($_SESSION['status']);
          header('index.php');
          exit();
        }
          
      ?>
      <br>

        
        
        
        

            <!--INFO TELLING USER HE SUCCESSFULLY CREATED CHARACTER-->        
          <?php
            if(isset( $_SESSION["completed_character"])){
              echo "I see you have created your character. You can just use it down below.";
              unset($_SESSION["completed_character"]);
              }
            //If you deleted character, you can ensure yourself, that this character is deleted.     
            if(isset( $_SESSION["deleted_character"])){
              echo "I see you have deleted your character";
              unset($_SESSION["deleted_character"]);
              }
          ?>
          
    
            <!--GIVING INFO ABOUT POSIBBILITY OF CREATING NEW CHARACTER-->      
            <h2><p> Do you want  to add D&D character? No problem. Just fill up the form</p></h2>

            <!--START OF THE FORM, GIVING YOUR CHARACTER NAME-->      
            <form action="new_dd_character.php" method="post">
              NAME:   
                <input type="text" name="name" required placeholder = "Name">

                <?php 
                  //checking, if there is any bug
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
                $var = ['-5','-4','-3','-2','-1','0','1','2','3','4','5'];
                $var_look = ['-5','-4','-3','-2','-1','+0','+1','+2','+3','+4','+5'];
                $e = 0;
                do{  
                $i = 0;
                echo $strings2[$e].":   ";  
                echo "<select name=" . $strings1[$e] . ">";
                do{
                echo "<option value=" . '"' . $var[$i] . '">' . $var_look[$i] . "</option>";
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
              DICES: <br>
                <input type="number" name="number_of_dices" required placeholder = "1" min="1" max="10">d 
                <input type="number" name="dice" required placeholder = "4" min="1" max="100">
                <select name="as_bonus">
                  <?php 
                  $as_options = [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79,80,81,82,83,84,85,86,87,88,89,90,91,92,93,94,95,96,97,98,99,100];
                  for($i = 0; $i <= 99; $i++ ){
                    echo "<option value=" . '"-' . $as_options[$i] . '"' . ">-" . $as_options[$i] . '</option>';
                    echo "<option value=" . '"' . $as_options[$i] . '"' . ">+" . $as_options[$i] . '</option>'; 
                  }
                  ?>
                </select> <br>
              ATTACK ROLL BONUS: <br>
                <select name="ar_bonus" class='select'>
                  <?php 
                  $ar_options = ['-10','-9','-8','-7','-6','-5','-4','-3','-2','-1','+0','+1','+2','+3','+4','+5','+6','+7','+8','+9','+10'];
                  $i = 0;
                  do {
                  echo "<option value=" . '"' . $ar_options[$i] . '"' . ">" . $ar_options[$i] . '</option>'; 
                  $i ++;  
                  } while ($i <= 20);
                  ?>
                </select>
                <br>
                <input type="submit" name="checkbox" value ="Click it when you finish">
              </form>
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
                    if($header === 'Strenght' OR $header === 'Dexterity' OR $header === 'Constitution' OR $header === 'Intelligence' OR $header === 'Wisdom' OR $header === 'Charisma'){
                      if($content >= 0){
                        echo "<td>+".$content."</td>";
                      } else {
                        echo "<td>".$content."</td>";
                      }  
                    } else {
                    echo "<td>".$content."</td>";
                    }
                    echo "</tr>";
                    }
                  unset($_SESSION['data']);  
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
              <!--TODO--> 
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
          <input type='int'  name='max_hp1' required placeholder = '20' min='1' max='560'> 
          <br>
          <input type='text' name='name2' required placeholder ='John'>  
          <input type='int'  name='max_hp2' required placeholder = '20' min='1' max='560'> 
          <br>
          <input type='submit' name='submit' value='I have choosen'>   <br>       
        
         <?php
          if(isset($_SESSION['hero1']) AND isset($_SESSION['hero2'])){
            $hp1 = $_SESSION['hp1'];
            $hp2 = $_SESSION['hp2'];
            $h1 = $_SESSION['hero1'];
            $h2 = $_SESSION['hero2'];
            unset($_SESSION['hero2']);
            unset($_SESSION['hero1']);
            fight($h1, $h2, $hp1, $hp2);
          }
         ?>  
         <br> 
         <br> 
    <!--LOG OUT-->
        
            <button id="logout_button"><a href="logout.php">LOG OUT</a></button>

  </body> 
 </html>
<?php
  function fight($h1 , $h2, $hp1, $hp2) {
  //To '\n' work
    
  //=====Units=====//

  Class Unit {
  public string $name;
  public int $max_hp;
  public int $number_of_dices;
  public int $dice;
  public int $as_bonus; 
  public int $ar_bonus; 
  public int $current_hp;
  public bool $ac;

  function __construct
  ($name, $max_hp, $number_of_dices, $dice, $as_bonus, $ar_bonus, $current_hp, $ac)
  {
    $this->name = $name;
    $this->max_hp = $max_hp;
    $this->number_of_dices = $number_of_dices;
    $this->dice = $dice;
    $this->as_bonus = $as_bonus;  
    $this->ar_bonus = $ar_bonus; 
    $this->current_hp = $max_hp;
    $this->ac = $ac;
  }

  function attack(Unit $target){

    /*First, we must see if this attack can hit the target*/
    $hit = false;
    $attack_roll = random_int(1,20);
    if ($attack_roll === 1){
      return $this->name . ' tried damage '. $target->name .". This hit didn't cause anything." . "<br>";
      
    } elseif ($attack_roll === 20){
      $hit = true;
    }
    if (!$hit){
      $attack_roll += $this-> ar_bonus;
      $target_AC = $target->ac;
      if ($attack_roll >= $target_AC){
        $hit = true;
      } else {
        return $this->name . ' tried damage'. $target->name .". This hit didn't cause anything." . "<br>";
      }
    }
    
    /*Now must prepare randomized hit power*/
      $damage = 0;
      for ($i = 0; $i < $this->number_of_dices; $i++) {
        $damage += random_int(1, $this->dice);
      }
      $damage += $this->as_bonus;
      
      /*applying attack*/
          $target->current_hp -= $damage;
      // if hp is below 0 or less, target is dead
      if ($target->current_hp <= 0){
        return "$target->name is dead."; //target is dead
      } else {
        // if hp didn't drop to 0, target lives
        return $this->name ." dealt $damage damage to ".$target->name.". ". $target->name . " has now ". $target->current_hp ." HP."  . "<br>";
      }
    } 
  }
  $hero1 = new Unit($h1['Name'], $hp1, $h1['Number of Dices'], $h1['Dice'], $h1['Attack Strenght Bonus'], $h1['Attack Roll bonus'], $hp1, $h1['Armour Class']);
  $hero2 = new Unit($h2['Name'], $hp2, $h2['Number of Dices'], $h2['Dice'], $h2['Attack Strenght Bonus'], $h2['Attack Roll bonus'], $hp2, $h2['Armour Class']);

  do{
  echo $hero1->attack($hero2);
  if($hero2 -> current_hp <= 0) {
  return $hero1-> name . ' win!';
  } else {
  echo $hero2->attack($hero1);
  if($hero1 -> current_hp <= 0) {
    return $hero2-> name . ' win!';
    }
  }
  }while($hero1 -> current_hp >= 1 AND $hero2 -> current_hp >= 1 );
  } 
  ?>  