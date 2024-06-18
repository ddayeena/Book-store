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

$cart_details_id = $_GET['cart_details_id']; 

$sql = "SELECT cart_id, book_id FROM cart_details WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $cart_details_id);
$stmt->execute();

$result = $stmt->get_result();
if ($row = $result->fetch_assoc()) {
    $cart_id = $row['cart_id'];
    $book_id=$row['book_id'];
}
$stmt->close();

if (!$cart_id) {
    echo json_encode(['message' => 'Помилка отримання даних про кошик']);
    $conn->close();
    exit();
}
$sql ="SELECT price FROM book WHERE id = ?;";
$stmt=$conn->prepare($sql);
$stmt->bind_param("i",$book_id);
$stmt->execute();
$result=$stmt->get_result();
if ($row = $result->fetch_assoc()) {
    $price = $row['price'];
}
$sql = "SELECT  COUNT(*) AS book_count FROM cart_details WHERE cart_id = ? AND book_id=?;";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii",$cart_id, $book_id);
$stmt->execute();
$result=$stmt->get_result();
if ($row = $result->fetch_assoc()) {
    $book_count = $row['book_count'];
}
//видалення запису з бази даних
$sql = "DELETE FROM cart_details WHERE book_id = ? AND cart_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii",$book_id, $cart_id);

if ($stmt->execute()) {
    //оновлення загальної суми кошика
    $old_price = $book_count*$price;
    $sql = "UPDATE cart SET total_price = total_price - ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("di", $old_price, $cart_id);

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
