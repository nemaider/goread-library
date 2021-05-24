<?php 

session_start();

if(!isset($_SESSION['logged'])){
    header('Location: /../goread/account/login.php');
    $_SESSION['login_error'] = '<span style="color:red">Zaloguj się do serwisu!</span>';
    exit();
 }


 $path = $_SERVER['DOCUMENT_ROOT'];
    include($path.'/goread/phpmodules/connect.php');


    $id_book = $_GET['id_book'];




               
    $sql = "DELETE FROM books where id_book='$id_book'";
    mysqli_query($conn,$sql);

    if($_GET){
            if (mysqli_query($conn, $sql)) {
            header('Location: /goread/library/page.php?refresh');
        } else {
            header('Location: /goread/library/page.php?error');	
        }
    }

?>