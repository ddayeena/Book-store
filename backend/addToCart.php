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
    $quantity = $data['quantity'];
    $unit_price = $data['unit_price'];

    $sql = "SELECT id FROM cart WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $cart = $result->fetch_assoc();

    if (!$cart) {
        //якщо кошика немає тоді створити новий
        $sql = "INSERT INTO cart (user_id) VALUES (?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $cart_id = $stmt->insert_id;
    } else {
        //якщо кошик існує то взяти його ID
        $cart_id = $cart['id'];
    }

    $sql = "SELECT quantity FROM cart_details WHERE cart_id = ? AND book_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $cart_id, $book_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $check_quantity = $result->fetch_assoc();

    if ($check_quantity) {
        //якщо книга вже в кошику то збільшити кількість
        $new_quantity = $check_quantity['quantity'] + $quantity;
        $sql = "UPDATE cart_details SET quantity = ? WHERE cart_id = ? AND book_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iii", $new_quantity, $cart_id, $book_id);
        if ($stmt->execute()) {
            echo json_encode(['message' => 'Кількість книги оновлено в кошику']);
        } else {
            echo json_encode(['error' => 'Помилка при оновленні кількості книги в кошику']);
        }
    } else {
        //якщо книги немає в кошику тоді додати новий запис
        $sql = "INSERT INTO cart_details (cart_id, book_id, quantity, unit_price) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iiid", $cart_id, $book_id, $quantity, $unit_price);
        if ($stmt->execute()) {
            echo json_encode(['message' => 'Книга додана до кошика']);
        } else {
            echo json_encode(['error' => 'Помилка при додаванні книги до кошика']);
        }
    }
}
$stmt->close();
$conn->close();
?>