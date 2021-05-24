<?php 

   session_start();

   if((isset($_SESSION['logged'])) && ($_SESSION['logged']==true)){
      header('Location: /../goread/library/page.php');
      exit();
   }

   $path = $_SERVER['DOCUMENT_ROOT'];
   include($path.'/goread/phpmodules/connect.php');

   @$login = $_POST['login'];
   @$password = $_POST['password'];

   $login = htmlentities($login, ENT_QUOTES, "UTF-8");
   $password = htmlentities($password, ENT_QUOTES, "UTF-8");

   $sql = "INSERT INTO users (login, password, balance) VALUES ('$login', '$password', 1000)";
   
   

   if($_POST){

      if(mysqli_query($conn, $sql)){
         unset($_SESSION['register_error']);
         header('Location: /../goread/account/login.php');
         exit();
      } else {
         $_SESSION['register_error'] = '<span style="color:red">Konto już istnieje w systemie!</span>';
         header('Location: /../goread/account/register.php');
         exit();
      }
   } 






?>

<html lang="en" dir="ltr">
   <head>
      <meta charset="utf-8">
      <title>GORead library</title>
      <link rel="stylesheet" href="LoginStyle.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
   </head>
   <body>
      <div class="login-form">
         <div class="text">
            REGISTER
         </div>
         <form action="register.php" method="POST">
            <div class="field">
               <div class="fas fa-envelope"></div>
               <input type="text" name="login" placeholder="Username">
            </div>
            <div class="field">
               <div class="fas fa-lock"></div>
               <input type="password" name="password" placeholder="Password">
            </div>
            <?php
               if(isset($_SESSION['register_error'])){
                  echo $_SESSION['register_error'];
                  unset($_SESSION['register_error']);   
               }
            ?>
            <button>Create account</button>
            <div class="link">
               Already have an account?
               <a href="/goread/account/login.php">Login</a>
            </div>
         </form>
      </div>

   </body>
</html>