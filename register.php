<?php
include 'connection_db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $name = $_POST['name']; // Добавляем обработку поля "name"
    $phone = $_POST['phone']; // Добавляем обработку поля "phone"

    // Check if the connection is valid
    if ($conn === false) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Prepare and execute the SELECT query
    $check_stmt = $conn->prepare("SELECT user_id FROM users WHERE username = ?");
    if ($check_stmt === false) {
        die("Prepare failed: " . $conn->error);
    }
    
    $check_stmt->bind_param("s", $username);
    $check_stmt->execute();
    $check_stmt->store_result();
    
    if ($check_stmt->num_rows > 0) {
        echo '<!DOCTYPE html>
        <html lang="ru">
        <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/main.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Comfortaa:wght@300..700&display=swap" rel="stylesheet">
        </head>
        <body>
        <div style="display: flex; justify-content: center; align-items: center; margin-top: 40vh; flex-direction: column;">
        <a style="font-size: 25px; color: #000000; text-align: center;"> 
        Пользователь с таким именем уже существует! </a>
        <button onclick="history.go(-1);" style=" margin: 15px; width: 200px; height: 60px; border: none; text-decoration: none; background: #a9def8; font-size: 1.2em; border: 1px solid #000; border-radius: 3px; display: flex; align-items: center; justify-content: center; color: #000; font: 14px / 1.6 "Comfortaa";"> 
        Вернуться на страницу личного кабинета </button>
        </div>
        </body>
        </html>';
        exit;
    }
    $check_stmt->close();

    // Prepare and execute the INSERT query
    $insert_stmt = $conn->prepare("INSERT INTO users (username, password, name, phone) VALUES (?, ?, ?, ?)");
    if ($insert_stmt === false) {
        die("Prepare failed: " . $conn->error);
    }
    
    $insert_stmt->bind_param("ssss", $username, $password, $name, $phone);
    if ($insert_stmt->execute()) {
        header("Location: index.php?registration_success=1");
        exit();
    } else {
        echo "Ошибка при регистрации: " . $insert_stmt->error;
    }
    $insert_stmt->close();
}
?>
