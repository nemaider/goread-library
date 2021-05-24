<?php 

session_start();

if(!isset($_SESSION['logged'])){
    header('Location: /../goread/account/login.php');
    $_SESSION['login_error'] = '<span style="color:red">Zaloguj się do serwisu!</span>';
    exit();
 }


 $path = $_SERVER['DOCUMENT_ROOT'];
    include($path.'/goread/phpmodules/connect.php');

$book_id = $_GET['book_id'];
$borrow_id = $_GET['borrow'];
$price = $_GET['price'];
$username = $_GET['username'];

$id_user = $_SESSION['id_user'];

$query = "UPDATE users SET balance = balance + '$price' WHERE login='$username' AND id_user='$id_user'"; // setting new balance after the book is returned

if (mysqli_query($conn, $query)) {
    echo "<p>Dodano pomyślnie nowy rekord</p>";
    header('Location: /../goread/library/return-page.php?refresh');
} else {
    echo "<p>Niepowodzenie!</p>";
    header('Location: /../goread/library/return-page.php?error_balance');	
}


$query = "UPDATE books SET amount = amount + 1 WHERE id_book='$book_id'"; // increase amount value by 1

if (mysqli_query($conn, $query)) {
    echo "<p>Dodano pomyślnie nowy rekord</p>";
    header('Location: /../goread/library/return-page.php?refresh');
} else {
    echo "<p>Niepowodzenie!</p>";
    header('Location: /../goread/library/return-page.php?error_book');	
}



$query = "DELETE FROM borrows WHERE id_borrow='$borrow_id'";

if (mysqli_query($conn, $query)) {
    echo "<p>Dodano pomyślnie nowy rekord</p>";
    header('Location: /../goread/library/return-page.php?refresh');
    $_SESSION['return_info'] = '<span class="text" style="color: #00a63f">The book has been returned successfully</span>';
} else {
    echo "<p>Niepowodzenie!</p>";
    header('Location: /../goread/library/return-page.php?error_delete');	
}


?>