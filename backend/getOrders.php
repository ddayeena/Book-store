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

$sql = "SELECT orders.id AS order_id,
        orders.user_id,
        orders.order_date,
        orders.total_price,
        orders.delivery_id,
        orders.status,
        orders.payment_method,
        order_details.id AS order_details_id,
        order_details.book_id,
        COUNT(order_details.book_id) AS quantity,
        book.price,
        book.name,
        book.img_src,
        book.author
        FROM orders
        JOIN order_details ON orders.id = order_details.order_id
        JOIN book ON order_details.book_id = book.id
        WHERE orders.user_id = ?
        GROUP BY order_details.book_id";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);

$stmt->execute();
$result = $stmt->get_result();

$orders = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $orders[] = $row;
    }
}

$stmt->close();
$conn->close();

echo json_encode(['orders' => $orders]);
?>
