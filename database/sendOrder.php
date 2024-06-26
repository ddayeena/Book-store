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
    $order_id=$data['order_id'];
    $status = 'Доставлено';

    $sql = "UPDATE orders SET status = ? WHERE id = ?;";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $status, $order_id);
    if ($stmt->execute()) {
        echo json_encode(['message' => 'Товар доставлено']);
    } else {
        echo json_encode(['error' => 'Помилка при оновлені статусу']);
    }
}
$stmt->close();
$conn->close();
?>
