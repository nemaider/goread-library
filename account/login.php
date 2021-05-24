<?php 

   session_start();

   if((isset($_SESSION['logged'])) && ($_SESSION['logged']==true)){
      header('Location: /../goread/library/page.php');
      exit();
   }

if($_POST){

   $path = $_SERVER['DOCUMENT_ROOT'];
   include($path.'/goread/phpmodules/connect.php');
   @$login = $_POST['login'];
   @$password = $_POST['password'];

   $login = htmlentities($login, ENT_QUOTES, "UTF-8");
   $password = htmlentities($password, ENT_QUOTES, "UTF-8");

   $query = "SELECT * FROM users WHERE login='$login' AND password='$password'";
   
   if($result = mysqli_query($conn, $query)){
      $exist = $result->num_rows;

      if($exist > 0){ // found min one record in db
         $row = $result->fetch_assoc();
         $_SESSION['logged']=true;
         $_SESSION['username']= $row['login'];
         $_SESSION['permission'] = $row['permission'];

         unset($_SESSION['login_error']);
         header("Location: /../goread/library/page.php");
         exit();
      } else {
         $_SESSION['login_error'] = '<span style="color:red">Nieprawidłowy login lub hasło!</span>';
         header('Location: /../goread/account/login.php');
         exit();
      }


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
            LOGIN
         </div>
         <form action="login.php" method="POST">
            <div class="field">
               <div class="fas fa-envelope"></div>
               <input type="text" name="login" placeholder="Username">
            </div>
            <div class="field">
               <div class="fas fa-lock"></div>
               <input type="password" name="password" placeholder="Password">
            </div>
            <?php 
               if(isset($_SESSION['login_error'])){
                  echo $_SESSION['login_error'];
                  unset($_SESSION['login_error']);
               }
            ?>
            <button onclick="">Login</button>
            <div class="link">
               Not a member?
               <a href="/goread/account/register.php">Create an account</a><br/>
               Back to <a href="/goread/index.html">home page</a>
            </div>
         </form>
      </div>

   </body>
</html>