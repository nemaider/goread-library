<?php
    session_start();
    


   if(!isset($_SESSION['logged'])){
    header('Location: /../goread/account/login.php');
    $_SESSION['login_error'] = '<span style="color:red">Zaloguj się do serwisu!</span>';
    exit();
 }



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
            $_SESSION['id_user'] = $row['id_user'];
            echo '<span class="text">Your balance is: </span><span class="text" style="color: green">'.$balance.' $</span><br><br>';

            if(isset($_SESSION['buy_info'])){
                echo $_SESSION['buy_info'];
                unset($_SESSION['buy_info']);
            }
        }

        echo '<p class="text">Books that you can buy in our library: </p>';
        $query = "SELECT * FROM books WHERE amount>0 AND price<'$balance'";

        if($result = mysqli_query($conn, $query)){
            $exist = $result->num_rows;
      
            if($exist > 0){ // found min one record in db

   

               echo '<br><table cellpadding=5 border=1>
               <tr class="db-info">
               <td><b>Book id</b></td>
               <td><b>Author</b></td>
               <td><b>Title</b></td>
               <td><b>Category</b></td>
               <td><b>Price</b></td>
               <td><b>Amount</b></td>
               <td><b>Options</b></td>';

              

               echo '</tr><br>';

                if($_SESSION['permission']=="reader"){

                   while($row = $result->fetch_assoc()) {
                    echo '<tr><td class="db-subinfo">'.$row['id_book'].'</td><td class="db-subinfo">'.$row['author'].'</td><td class="db-subinfo">'.$row['title'].'</td>
                    <td class="db-subinfo">'.$row['category'].'</td><td class="db-subinfo">'.$row['price'].'</td><td class="db-subinfo">'.$row['amount'].'</td><td>'
                    .'<a href="/goread/library/buy.php?book='.$row['id_book'].'&price='.$row['price'].'&username='.$_SESSION['username'].'">Buy</a>
                    </td></tr>';
                  } 
                } else {
                    while($row = $result->fetch_assoc()) {
                        echo '<tr><td class="db-subinfo">'.$row['id_book'].'</td><td class="db-subinfo">'.$row['author'].'</td><td class="db-subinfo">'.$row['title'].'</td><td class="db-subinfo">'.$row['category'].'</td><td class="db-subinfo">'.$row['price'].'</td><td class="db-subinfo">'.$row['amount'].'</td><td>'
                        .'<a href="/goread/library/edit-page.php?id_book='.$row['id_book'].'&author='.$row['author'].'&title='.$row['title'].'&category='.$row['category'].'&price='.$row['price'].'&amount='.$row['amount'].'">Modify</a></td><td>'
                        .'<a href="/goread/library/delete.php?id_book='.$row['id_book'].'">Delete</a></td></tr>';
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