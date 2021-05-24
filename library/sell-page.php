<?php
    session_start();
    
    // if(isset($_SESSION['logged']) && $_SESSION['logged']==true) {
    //     echo $_SESSION['logged'];
        
    // }

   if(!isset($_SESSION['logged'])){
    header('Location: /../goread/account/login.php');
    $_SESSION['login_error'] = '<span style="color:red">Zaloguj się do serwisu!</span>';
    exit();
 }

//  if($_POST){
//      $logout = $_POST['action'];
//      if($logout=="logout"){
//          unset($_SESSION['logged']);
//          $_SESSION['login_error'] = '<span style="color:red">Zaloguj się do serwisu!</span>';
//          header('Location: /../goread/account/login.php');
//          exit();
//      }
//  }

 $path = $_SERVER['DOCUMENT_ROOT'];
   include($path.'/goread/phpmodules/connect.php');
?>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GORead library</title>
    <link rel="stylesheet" href="/goread/styles.css">
    <link rel="stylesheet" href="/goread/library/PageStyle.css">
    <link
    rel="stylesheet"
    href="https://use.fontawesome.com/releases/v5.14.0/css/all.css"
    integrity="sha384-HzLeBuhoNPvSl5KYnjx0BT+WB0QEEqLprO+NBkkk5gbc67FTaL7XIGa2w1L0Xbgc"
    crossorigin="anonymous"/>
</head>

<html>

<body>
<!-- Navbar section -->
<nav class="navbar">
    <div class="navbar__container">
        <a href="/goread/index.html" id="navbar__logo">GORead</a>
        <div class="navbar__toggle" id="mobile-menu">
            <span class="bar"></span>
            <span class="bar"></span>
            <span class="bar"></span>
        </div>
        <ul class="navbar__menu">
            <li class="navbar__item">
                <a href="/goread/library/my-profile.php" class="navbar__links">My profile</a>
            </li>
            <li class="navbar__item">
                <a href="/goread/index.html#home" class="navbar__links" id="home-page">Home</a>
            </li>
            <li class="navbar__item">
                <a href="/goread/index.html#about" class="navbar__links" id="about-page">About</a>
            </li>
            <li class="navbar__item">
                <a href="/goread/index.html#services" class="navbar__links" id="services-page">Services</a>
            </li>
            <li class="navbar__btn">
                <a href="/goread/account/logout.php" class="button" id="signup">Log out</a>
            </li>
        </ul>
    </div>
</nav> 
 
<div class="top-options">
<div class="link" style="background-color: #151515; text-align: left; margin: 0px; font-size: 50px;">
    <a href="/goread/library/page.php">&#8678;</a> 
</div>
<?php 

     if($_SESSION['permission'] == 'admin'){
         echo '<br><a href="/goread/library/add-page.php" ><button style="width: 150px !important;">Add</button></a>';
     }
    ?>
    <a href="/goread/library/borrow-page.php" ><button style="width: 150px !important;">Borrow</button></a>
    <a href="/goread/library/return-page.php" ><button style="width: 150px !important;">Return</button></a>
    <a href="/goread/library/buy-page.php" ><button style="width: 150px !important;">Buy</button></a>
    <a href="/goread/library/sell-page.php" ><button style="width: 150px !important;">Sell</button></a>
</div>


<div class="body-content">





        <?php
        $login = $_SESSION['username'];
        $query = "SELECT balance, id_user FROM users WHERE login='$login'";

        if($result = mysqli_query($conn, $query)){
            $row = $result->fetch_assoc();
            $balance = $row['balance'];
            $id_user = $row['id_user'];
            echo '<span class="text">Your balance is: </span><span class="text" style="color: green">'.$balance.' $</span><br><br>';

            if(isset($_SESSION['sell_info'])){
                echo $_SESSION['sell_info'];
                unset($_SESSION['sell_info']);
            }
        }

        echo '<p class="text">Books that you can sell in our library: </p>';
        $query2 = "SELECT * FROM bought WHERE id_user='$id_user'"; //select all bought books for chosen user

        $query = "SELECT * FROM books";

        if($result = mysqli_query($conn, $query)){
            $exist = $result->num_rows;
            
            if($exist > 0){ // found min one record in db
            
                $result2 = mysqli_query($conn, $query2);
            //    $row = $result->fetch_assoc();

            //    $row = mysqli_fetch_row($result)


            //    $_SESSION['logged']=true;
            //    $_SESSION['username']= $row['login'];
            //    $_SESSION['permission'] = $row['permission'];
                

               echo '<br><table cellpadding=5 border=1>
               <tr class="db-info">
               <td><b>Purchase id</b></td>
               <td><b>Author</b></td>
               <td><b>Title</b></td>
               <td><b>Category</b></td>
               <td><b>Price</b></td>
               <td><b>Date of purchase</b></td>
               <td><b>Options</b></td>';

               if($_SESSION['permission']=="admin") {
                   echo '<td><b>Options</b></td>';
               }

               echo '</tr><br>';

                if($_SESSION['permission']=="reader"){

                
                   while($row2 = $result2->fetch_assoc()) {
                        $result = mysqli_query($conn, $query);
                        
                        for ($i=0; $i<$exist; $i++){
                        $row = $result->fetch_assoc();
                            if($row2['id_book'] == $row['id_book']) {
                                
                                echo '<tr><td class="db-subinfo">'.$row2['id_buy'].'</td><td class="db-subinfo">'.$row['author'].'</td><td class="db-subinfo">'.$row['title'].'</td>
                                <td class="db-subinfo">'.$row['category'].'</td><td class="db-subinfo">'.$row['price'].'</td><td class="db-subinfo">'.$row2['day'].'</td><td>'
                                .'<a href="/goread/library/sell.php?bought='.$row2['id_buy'].'&price='.$row['price'].'&username='.$_SESSION['username'].'&book_id='.$row2['id_book'].'">Sell</a>
                                </td></tr>';
                                
                            }
                       }
                     } 
                } 
      

            } else {
               echo '<p class="text" style="color: red">Cannot find any book for you, please check your balance account</p>';
            }


            echo "</table>";
      
      
         }
     ?>

     


     


</div>


</body>


</html>