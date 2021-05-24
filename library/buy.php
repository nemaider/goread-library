<?php 

session_start();

if(!isset($_SESSION['logged'])){
    header('Location: /../goread/account/login.php');
    $_SESSION['login_error'] = '<span style="color:red">Zaloguj się do serwisu!</span>';
    exit();
 }


 $path = $_SERVER['DOCUMENT_ROOT'];
    include($path.'/goread/phpmodules/connect.php');

$book_id = $_GET['book'];
$price = $_GET['price'];
$username = $_GET['username'];

$id_user = $_SESSION['id_user'];

$query = "UPDATE users SET balance = balance - '$price' WHERE login='$username' AND id_user='$id_user'"; // setting new balance after the book is bought

if (mysqli_query($conn, $query)) {
    echo "<p>Dodano pomyślnie nowy rekord</p>";
    header('Location: /../goread/library/buy-page.php?refresh');
} else {
    echo "<p>Niepowodzenie!</p>";
    header('Location: /../goread/library/buy-page.php?error');	
}


$query = "UPDATE books SET amount = amount - 1 WHERE id_book='$book_id'"; // decrease amount value by 1

if (mysqli_query($conn, $query)) {
    echo "<p>Dodano pomyślnie nowy rekord</p>";
    header('Location: /../goread/library/buy-page.php?refresh');
} else {
    echo "<p>Niepowodzenie!</p>";
    header('Location: /../goread/library/buy-page.php?error');	
}

//getting actual time and parsing to another date type
$time = new DateTime();
$d=strtotime("+1 Seconds");
$time = date("Y-m-d H:i:s", $d);

$query = "INSERT INTO bought (id_book, id_user, day) VALUES ('$book_id', '$id_user', '$time')";

if (mysqli_query($conn, $query)) {
    echo "<p>Dodano pomyślnie nowy rekord</p>";
    header('Location: /../goread/library/buy-page.php?refresh');
    $_SESSION['buy_info'] = '<span class="text" style="color: #00a63f">The book has been purchased successfully</span>';
} else {
    echo "<p>Niepowodzenie!</p>";
    header('Location: /../goread/library/buy-page.php?error');	
}


?>