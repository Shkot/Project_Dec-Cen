<?php
// Подключение к базе данных
include 'connection_db.php';

// Получение данных из формы
$event_name = $_POST['event_name'];
$event_date = $_POST['event_date'];
$event_time = $_POST['event_time'];

// Проверка наличия данных
if(empty($event_name) || empty($event_date) || empty($event_time)) {
    echo "Пожалуйста, заполните все поля.";
    exit();
}

// Получение user_id из сессии
session_start();
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $sql_user_id = "SELECT user_id FROM users WHERE username='$username'";
    $result_user_id = $conn->query($sql_user_id);

    if ($result_user_id->num_rows > 0) {
        $row_user_id = $result_user_id->fetch_assoc();
        $user_id = $row_user_id["user_id"];

        // Запрос для добавления нового события
        $sql_add_event = "INSERT INTO events (user_id, event, event_date, event_time) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql_add_event);
        $stmt->bind_param("isss", $user_id, $event_name, $event_date, $event_time);

        // Выполнение запроса
        if ($stmt->execute()) {
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
            Событие успешно добавлено. </a>
            <button onclick="history.go(-1);" style=" margin: 15px; width: 200px; height: 60px; border: none; text-decoration: none; background: #a9def8; font-size: 1.2em; border: 1px solid #000; border-radius: 3px; display: flex; align-items: center; justify-content: center; color: #000; font: 14px / 1.6 "Comfortaa";"> 
            Вернуться на страницу личного кабинета </button>
            </div>
            </body>
            </html>';
        } else {
            echo "Ошибка при добавлении события: " . $conn->error;
        }

        // Закрытие подготовленного запроса
        $stmt->close();
    } else {
        echo "Ошибка: Не удалось получить идентификатор пользователя.";
    }
} else {
    echo "Ошибка: Не удалось получить username из сессии.";
}

// Закрытие соединения с базой данных
$conn->close();
?>