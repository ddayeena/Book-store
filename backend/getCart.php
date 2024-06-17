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

$user_id = $_GET['user_id'];

$sql = "SELECT cart.id AS cart_id,
        cart.user_id,
        cart.total_price,
        cart_details.id AS cart_details_id,
        cart_details.book_id,
        COUNT(cart_details.book_id) AS quantity,
        book.price,
        book.name,
        book.img_src,
        book.author
        FROM cart
        JOIN cart_details ON cart.id = cart_details.cart_id
        JOIN book ON cart_details.book_id = book.id
        WHERE cart.user_id = ?
        GROUP BY cart_details.book_id";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);

$stmt->execute();
$result = $stmt->get_result();

$cart_items = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $cart_items[] = $row;
        $total_price = $row['total_price'];
    }
}

$stmt->close();
$conn->close();

echo json_encode(['cart_items' => $cart_items, 'total_price' => $total_price]);
?>
