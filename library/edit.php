<?php 

session_start();

if(!isset($_SESSION['logged'])){
    header('Location: /../goread/account/login.php');
    $_SESSION['login_error'] = '<span style="color:red">Zaloguj się do serwisu!</span>';
    exit();
 }


 $path = $_SERVER['DOCUMENT_ROOT'];
    include($path.'/goread/phpmodules/connect.php');


    $id_book = $_POST['id_book'];
    $author = $_POST['author'];
    $title = $_POST['title'];
    $category = $_POST['category'];
    $price = $_POST['price'];
    $amount = $_POST['amount'];



               
    $sql = "UPDATE books SET author='$author', title='$title', category='$category', price='$price', amount='$amount' WHERE id_book='$id_book'";
    $result = mysqli_query($conn, $sql);

    if($_POST){
            if (mysqli_query($conn, $sql)) {
            header('Location: /goread/library/page.php?refresh');
        } else {
            header('Location: /goread/library/page.php?error');	
        }
    }

?>