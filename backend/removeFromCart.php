<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');

$servername = "127.0.0.1";
$username = "root";
$password = "";    
$dbname = "bookstore";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$cart_details_id = $_GET['book_id']; 

$sql = "SELECT cart_id, unit_price, quantity FROM cart_details WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $cart_details_id);
$stmt->execute();

$result = $stmt->get_result();
if ($row = $result->fetch_assoc()) {
    $cart_id = $row['cart_id'];
    $unit_price = $row['unit_price'];
    $quantity = $row['quantity'];
}
$stmt->close();

if (!$cart_id) {
    echo json_encode(['message' => 'Помилка отримання даних про кошик']);
    $conn->close();
    exit();
}

//видалення запису з бази даних
$sql = "DELETE FROM cart_details WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $cart_details_id);

if ($stmt->execute()) {
    $book_total_price = $unit_price * $quantity;
    //оновлення загальної суми кошика
    $sql = "UPDATE cart SET total_price = total_price - ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("di", $book_total_price, $cart_id);

    if ($stmt->execute()) {
        echo json_encode(['message' => 'Книга видалена з кошика']);
    } else {
        echo json_encode(['message' => 'Помилка оновлення загальної суми']);
    }
} else {
    echo json_encode(['message' => 'Помилка видалення книги з кошика']);
}

$stmt->close();
$conn->close();
?>
