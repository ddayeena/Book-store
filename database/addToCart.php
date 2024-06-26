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
    die(json_encode(['error' => 'Connection failed: ' . $conn->connect_error]));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    $user_id = $data['user_id'];
    $book_id = $data['book_id'];
    $price = $data['price'];

    $sql = "SELECT id, total_price FROM cart WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $cart = $result->fetch_assoc();

    if (!$cart) {
        //якщо кошика немає тоді створити новий
        $sql = "INSERT INTO cart (user_id, total_price) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("id", $user_id, $price);
        $stmt->execute();
        $cart_id = $stmt->insert_id;
    } else {
        //якщо кошик існує то взяти його ID і поточний total_price
        $cart_id = $cart['id'];
        $current_total_price = $cart['total_price'];
    }

    $sql = "INSERT INTO cart_details (cart_id, book_id) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $cart_id, $book_id);
    if ($stmt->execute()) {
        echo json_encode(['message' => 'Книга додана до кошика']);
    } else {
        echo json_encode(['error' => 'Помилка при додаванні книги до кошика']);
    }

    //оновити total_price в таблиці cart
    if (isset($current_total_price)) {
        $new_total_price = $current_total_price +  $price;
        $sql = "UPDATE cart SET total_price = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("di", $new_total_price, $cart_id);
        $stmt->execute();
    }
}

$stmt->close();
$conn->close();
?>
