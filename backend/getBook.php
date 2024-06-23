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

$id = intval($_GET['id']);
$sql = "SELECT 
        book.id, 
        book.name, 
        book.author, 
        book.description, 
        book.price, 
        book.img_src, 
        genre.name AS genre_name
        FROM book 
        JOIN genre ON book.genre_id = genre.id 
        WHERE book.id = ?;";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);

$stmt->execute();
$result = $stmt->get_result();

$book = null;

if ($result->num_rows > 0) {
    $book = $result->fetch_assoc();
}

$conn->close();

echo json_encode($book);
?>
