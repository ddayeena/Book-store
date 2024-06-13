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
$sql = "SELECT id, name, author, description, price, img_src FROM book WHERE id = $id";
$result = $conn->query($sql);

$book = null;

if ($result->num_rows > 0) {
    $book = $result->fetch_assoc();
}

$conn->close();

echo json_encode($book);
?>