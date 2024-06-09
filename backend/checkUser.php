<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');

$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "bookstore";

// Підключення до бази даних
$conn = new mysqli($servername, $username, $password, $dbname);

// Перевірка з'єднання
if ($conn->connect_error) {
    die(json_encode(["message" => "Connection failed: " . $conn->connect_error]));
}

// Отримання даних з POST-запиту
$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['name']) && isset($data['password']) && isset($data['email'])) {
    $name = $conn->real_escape_string($data['name']);
    $password = $conn->real_escape_string($data['password']);
    $email = $conn->real_escape_string($data['email']);

    // Підготовка та виконання запиту до бази даних
    $sql = "SELECT * FROM user WHERE name='$name' AND password='$password' AND email='$email'";
    $result = $conn->query($sql);

    // Перевірка чи знайдено користувача
    if ($result->num_rows > 0) {
        echo json_encode(["message" => "Користувач знайдений"]);
    } else {
        echo json_encode(["message" => "Користувача не знайдено"]);
    }
} else {
    echo json_encode(["message" => "Неправильні вхідні дані"]);
}

// Закриття з'єднання з базою даних
$conn->close();
?>
