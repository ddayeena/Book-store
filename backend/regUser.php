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
    die(json_encode(["message" => "Connection failed: " . $conn->connect_error]));
}

$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['name']) && isset($data['password']) && isset($data['email'])) {
    $name = $conn->real_escape_string($data['name']);
    $password = $conn->real_escape_string($data['password']);
    $email = $conn->real_escape_string($data['email']);
    
    if (strlen($name) < 3) {
        echo json_encode(["message" => "Логін має бути більше 2 символів"]);
        $conn->close();
        exit();
    }

    if (strlen($name) > 20) {
        echo json_encode(["message" => "Логін має бути менше 20 символів"]);
        $conn->close();
        exit();
    }

    if (strlen($password) < 6) {
        echo json_encode(["message" => "Пароль має бути більше 5 символів"]);
        $conn->close();
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(["message" => "Некоректний формат email"]);
        $conn->close();
        exit();
    }

    $checkUser = "SELECT * FROM user WHERE name='$name' OR email='$email'";
    $result = $conn->query($checkUser);

    if ($result->num_rows > 0) {
        echo json_encode(["message" => "Логін або email вже існує"]);
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO user (name, password, email) VALUES ('$name', '$hashed_password', '$email')";
        if ($conn->query($sql) === TRUE) {
            $userId = $conn->insert_id;
            $sql1 = "SELECT created_at FROM user WHERE id='$userId'";
            $result1 = $conn->query($sql1);
            $created_at = null;
            if ($result1->num_rows > 0) {
                $row = $result1->fetch_assoc();
                $created_at = $row['created_at'];  
            }
            $user = [
                'id' => $userId,
                'name' => $name,
                'password' => $hashed_password,
                'email' => $email,
                'created_at' => $created_at
            ];
            $token = bin2hex(random_bytes(16));
            echo json_encode(["message" => "Користувач зареєстрований успішно", "token" => $token, "user" => $user]);
        } else {
            echo json_encode(["message" => "Помилка при реєстрації: " . $conn->error]);
        }
    }
} else {
    echo json_encode(["message" => "Неправильні вхідні дані"]);
}

$conn->close();
?>
