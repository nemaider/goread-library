<?php 

session_start();

if(!isset($_SESSION['logged'])){
    header('Location: /../goread/account/login.php');
    $_SESSION['login_error'] = '<span style="color:red">Zaloguj się do serwisu!</span>';
    exit();
 }


 $path = $_SERVER['DOCUMENT_ROOT'];
    include($path.'/goread/phpmodules/connect.php');


    $author = $_POST['author'];
    $title = $_POST['title'];
    $category = $_POST['category'];
    $price = $_POST['price'];
    $amount = $_POST['amount'];



               
    $sql = "INSERT INTO books (author, title, category, price, amount) VALUES ('$author', '$title', '$category', '$price', '$amount')";

    if($_POST){
            if (mysqli_query($conn, $sql)) {
            header('Location: /goread/library/page.php?refresh');
        } else {
            header('Location: /goread/library/page.php?error');	
        }
    }

?>