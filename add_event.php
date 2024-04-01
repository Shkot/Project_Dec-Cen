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
            echo "Событие успешно добавлено.";
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