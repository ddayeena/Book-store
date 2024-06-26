<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bookstore";


$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(['error' => 'Connection failed: ' . $conn->connect_error]));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);

    //перевірка наявності обов'язкових даних
    if (empty($data['id']) || empty($data['name']) || empty($data['author']) || empty($data['description']) || empty($data['price']) || empty($data['genre'])) {
        die(json_encode(['error' => 'Не всі необхідні дані були надіслані.']));
    }
    $id = $data['id'];
    $name = $data['name'];
    $author = $data['author'];
    $description = $data['description'];
    $price = $data['price'];
    $genre = $data['genre'];
    $is_new = isset($data['is_new']) ? $data['is_new'] : 0;

    //отримання id жанру
    $genre_sql = "SELECT id FROM genre WHERE name = ?";
    $genre_stmt = $conn->prepare($genre_sql);
    $genre_stmt->bind_param("s", $genre);
    $genre_stmt->execute();
    $genre_result = $genre_stmt->get_result();

    if ($genre_result->num_rows > 0) {
        $genre_row = $genre_result->fetch_assoc();
        $genre_id = $genre_row['id'];
    } 
    
    $sql = "UPDATE book SET name = ?, author = ?, description = ?, price = ?, genre_id = ?, is_new = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssdiii", $name, $author, $description, $price, $genre_id, $is_new, $id);

    if ($stmt->execute()) {
        echo json_encode(['message' => 'Книга успішно оновлена.']);
    } else {
        echo json_encode(['error' => 'Помилка при оновленні книги: ' . $stmt->error]);
    }

    $stmt->close();
    $genre_stmt->close();
    $conn->close();
}

?>
