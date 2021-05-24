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

<p class="text">Books in our library: </p>

    

        <?php
        $authors_query = "SELECT DISTINCT author FROM books WHERE amount>0";
        $authors_result = mysqli_query($conn, $authors_query);

        $title_query = "SELECT DISTINCT title FROM books WHERE amount>0";
        $title_result = mysqli_query($conn, $title_query);

        $category_query = "SELECT DISTINCT category FROM books WHERE amount>0";
        $category_result = mysqli_query($conn, $category_query);




        echo '<form action="page.php" method="POST">';

        echo '<label class="text">Author: </label>
        <select name="author">
        <option>none</option>';

        while($row = $authors_result->fetch_assoc()){
            echo '<option>'.$row['author'].'</option>';
        }
        echo '</select>';

        echo '<label class="text"> Title: </label>
        <select name="title">
        <option>none</option>';

        while($row = $title_result->fetch_assoc()){
            echo '<option>'.$row['title'].'</option>';
        }
        echo '</select>';

        echo '<label class="text"> Category: </label>
        <select name="category">
        <option>none</option>';

        while($row = $category_result->fetch_assoc()){
            echo '<option>'.$row['category'].'</option>';
        }
        echo '</select>';
   
        echo '<label class="text"> Max price: </label>
        <input type="range" name="price" id="price" min="10" max="300" value="200"/> 
        <span style="color: green; text-size: 18px;">Value: <span id="demo"></span> </span>';
        
   
        echo '<button>Filter</button>
       </form>';

       $query = "SELECT * FROM books WHERE amount > 0";

        if($_POST){
            $p_author = $_POST['author'];
            $p_title = $_POST['title'];
            $p_category = $_POST['category'];
            $p_price = $_POST['price'];

            if($p_author != "none")
                $query .= " AND author='$p_author'";

            if($p_title != "none")
                $query .= " AND title='$p_title'";

            if($p_category != "none")
                $query .= " AND category='$p_category'";

            if($p_price != "none")
                $query .= " AND price<'$p_price'";

        }



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
               <td><b>Amount</b></td>';

               if($_SESSION['permission']=="admin") {
                   echo '<td><b>Options</b></td>';
               }

               echo '</tr><br>';

                if($_SESSION['permission']=="reader"){

                   while($row = $result->fetch_assoc()) {
                    echo '<tr><td class="db-subinfo">'.$row['id_book'].'</td><td class="db-subinfo">'.$row['author'].'</td><td class="db-subinfo">'.$row['title'].'</td><td class="db-subinfo">'.$row['category'].'</td><td class="db-subinfo">'.$row['price'].'</td><td class="db-subinfo">'.$row['amount'].'</td></tr>';
                  } 
                } else {
                    while($row = $result->fetch_assoc()) {
                        echo '<tr><td class="db-subinfo">'.$row['id_book'].'</td><td class="db-subinfo">'.$row['author'].'</td><td class="db-subinfo">'.$row['title'].'</td><td class="db-subinfo">'.$row['category'].'</td><td class="db-subinfo">'.$row['price'].'</td><td class="db-subinfo">'.$row['amount'].'</td><td>'
                        .'<a href="/goread/library/edit-page.php?id_book='.$row['id_book'].'&author='.$row['author'].'&title='.$row['title'].'&category='.$row['category'].'&price='.$row['price'].'&amount='.$row['amount'].'">Modify</a></td><td>'
                        .'<a href="/goread/library/delete.php?id_book='.$row['id_book'].'">Delete</a></td></tr>';
                    } 
                }
      

            } else {
               echo '<p class="text">No records in database! </p>';
            }


            echo "</table>";
      
      
         }
     ?>

     


     


</div>

<script>
var slider = document.getElementById("price");
var output = document.getElementById("demo");
output.innerHTML = slider.value;

slider.oninput = function() {
  output.innerHTML = this.value;
}
</script>

</body>


</html>