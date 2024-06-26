<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "bookstore";

$user_id = $_GET['user_id'];
$order_id = $_GET['order_id'];

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql_items = "SELECT 
                book.id as book_id,
                book.name AS book_name,
                book.author AS book_author,
                book.price AS book_price,
                book.img_src,
                COUNT(order_details.book_id) AS quantity 
             FROM orders
             JOIN order_details ON orders.id = order_details.order_id
             JOIN book ON order_details.book_id = book.id
             WHERE orders.user_id = ? AND orders.id = ?
             GROUP BY order_details.book_id";

$stmt_items = $conn->prepare($sql_items);
$stmt_items->bind_param("ii", $user_id, $order_id);
$stmt_items->execute();
$result_items = $stmt_items->get_result();

$order_items = [];

if ($result_items->num_rows > 0) {
    while ($row = $result_items->fetch_assoc()) {
        $order_items[] = $row;
    }
}

$stmt_items->close();

$sql_details = "SELECT 
                  orders.order_date,
                  orders.total_price,
                  orders.delivery_id,
                  orders.status,
                  orders.payment_method,
                  delivery.town,
                  delivery.street,
                  delivery.street_number,
                  delivery.type,
                  user.name AS user_name
               FROM orders
               JOIN order_details ON orders.id = order_details.order_id
               JOIN delivery ON orders.delivery_id = delivery.id
               JOIN user ON orders.user_id = user.id
               WHERE orders.user_id = ? AND order_details.order_id = ?
               GROUP BY orders.id";

$stmt_details = $conn->prepare($sql_details);
$stmt_details->bind_param("ii", $user_id, $order_id);
$stmt_details->execute();
$result_details = $stmt_details->get_result();

$order_details = null;

if ($result_details->num_rows > 0) {
    $order_details = $result_details->fetch_assoc();
}

$stmt_details->close();

$conn->close();

echo json_encode(['order_items' => $order_items, 'order_details' => $order_details]);
?>
