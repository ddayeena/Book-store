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
    //перевірка наявності обов'язкових даних
    if (empty($_POST['name']) || empty($_POST['author']) || empty($_POST['description']) || empty($_POST['price']) || empty($_POST['genre']) || empty($_FILES['image'])) {
        die(json_encode(['error' => 'Не всі необхідні дані були надіслані.']));
    }

    $name = $_POST['name'];
    $author = $_POST['author'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $genre = $_POST['genre'];
    $isNew = isset($_POST['isNew']) ? $_POST['isNew'] : 0;

    $genres = [
        'Детективи' => "detective",
        'Фентезі' => "fantasy",
        'Трилери та жахи' => "thrillers",
        'Романтична проза' => "love_novels",
        'Комікси' => "comics"
    ];
    $target_dir = __DIR__ . "/../src/assets/photo_books/" . ($genres[$genre] ?? '') . "/";
    

    //перевірка наявності директорії і створення її за потреби
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    //перевірка та переміщення зображення на сервер
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    //перевірка, чи файл є зображенням
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if ($check === false) {
        die(json_encode(['error' => 'Файл не є зображенням.']));
    }

    //перевірка розміру файлу
    if ($_FILES["image"]["size"] > 500000) {
        die(json_encode(['error' => 'Файл зображення занадто великий.']));
    }

    //дозволені формати файлів
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        die(json_encode(['error' => 'Дозволені лише JPG, JPEG, PNG та GIF файли.']));
    }

    //збереження зображення
    if (!move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
        die(json_encode(['error' => 'Сталася помилка при завантаженні зображення.']));
    }

    $img_src = "src/assets/photo_books/" . ($genres[$genre] ?? '') . "/" . basename($_FILES["image"]["name"]);
   

    $genre_sql = "SELECT id FROM genre WHERE name = ?";
    $genre_stmt = $conn->prepare($genre_sql);
    $genre_stmt->bind_param("s", $genre);
    $genre_stmt->execute();
    $genre_result = $genre_stmt->get_result();

    if ($genre_result->num_rows > 0) {
        $genre_row = $genre_result->fetch_assoc();
        $genre_id = $genre_row['id'];
    } 

    //вставка книги в таблицю book 
    $sql = "INSERT INTO book(name, author, description, price, genre_id, img_src, is_new) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssdisi", $name, $author, $description, $price, $genre_id, $img_src, $isNew);

    if ($stmt->execute()) {
        echo json_encode(['message' => 'Книга успішно додана.']);
    } else {
        echo json_encode(['error' => 'Помилка при додаванні книги: ' . $stmt->error]);
    }

    $stmt->close();
    $genre_stmt->close();
    if (isset($insert_genre_stmt)) {
        $insert_genre_stmt->close();
    }
    $conn->close();
}
?>
