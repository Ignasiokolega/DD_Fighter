<?php
session_start();
if (isset($_SESSION["status"]) && $_SESSION["status"] === true) {
  header('Location: DD_fight.php');
  exit();
  if ($_SESSION["err_character"]) {
    echo $_SESSION["err_character"];
    unset($_SESSION);
  }  
}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>D&D Fight Simple Fight Executor</title>
    <link rel="styleheet" href="style.css">
 </head>
  <body>
    <h1>Welcome to the D&D fighter!</h1>

      Sign in!
      <form id="log_in" action="log_in.php" method="post" >
        <sup class="asterisk">*</sup> Login: <br/>
        <input name="username" type="text" minlength="5" autocomplete="on" required><br/>
        <sup class="asterisk">*</sup> Password:<br/>
        <input name="password" type="password" minlength="8" required><br/>
        <input name="submit" type="submit" value = "Log in"><br/>
      </form>
<?php
if(isset($_SESSION["login_error"])){
  echo $_SESSION["login_error"];
  unset($_SESSION["login_error"]);
}
?>

      <form action="sign_up.php" method="post">
        <br/><br/><br/><br/>
        Don't have an account already? No worries!
        <br/>
        <input type="submit" value="Sign up now!">
      </form>
  </body>
</html>