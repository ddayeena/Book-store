<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "bookstore";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT book.id, book.name, 
        book.author, book.description, 
        book.price, book.img_src, 
        book.is_new, genre.name AS genre_name FROM book
        JOIN genre ON book.genre_id = genre.id";
$result = $conn->query($sql);
$books = array();

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $books[] = $row;
    }
} else {
    echo json_encode([]);
}

$conn->close();

echo json_encode($books);
?>