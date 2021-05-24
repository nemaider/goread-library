<?php
    session_start();
    


   if(!isset($_SESSION['logged']) || $_SESSION['permission'] == 'reader'){
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




<br>
<table cellpadding="5" border="1">
    <tr class="db-info">
    <td><b>Author</b></td>
    <td><b>Title</b></td>
    <td><b>Category</b></td>
    <td><b>Price</b></td>
    <td><b>Amount</b></td>
    <td><b>Options</b></td>

<tr><form action="add.php" method="POST">

    <td>
        <div class="field">
            <input name="author" type="text" placeholder="author">
        </div>
    </td>
    <td>
        <div class="field">
            <input name="title" type="text" placeholder="title">
        </div>
    </td>
    <td>
        <div class="field">
            <input name="category" type="text" placeholder="category">
        </div>
    </td>
    <td>
        <div class="field">
            <input name="price" type="number" placeholder="price">
        </div>
    </td>
    <td>
        <div class="field">
            <input name="amount" type="number" placeholder="amount">
        </div>
    </td>

    <td>
        <button style="margin-top: 0px; height: 0px;">Add</button>
    </td>
    
</form></tr>


</table>

     


     


</div>


</body>


</html>