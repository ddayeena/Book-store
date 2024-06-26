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

$genre_id = isset($_GET['genre_id']) ? intval($_GET['genre_id']) : 0;

if ($genre_id <= 0) {
    echo json_encode(["error" => "Invalid genre_id"]);
    exit;
}

$sql = "SELECT id, name, author, description, price, img_src FROM book WHERE genre_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $genre_id);
$stmt->execute();
$result = $stmt->get_result();

$books = array();

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $books[] = $row;
    }
} else {
    echo json_encode([]);
    exit;
}

$conn->close();

echo json_encode($books);
?>
