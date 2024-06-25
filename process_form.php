<?php
include 'connection_db.php'; // Подключение к базе данных

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Получение данных из формы
    $author = $_POST['author'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    // Проверка данных на ошибки и подготовка запроса
    if (!empty($author) && !empty($email) && !empty($subject) && !empty($message)) {
        $sql = "INSERT INTO messages (author, email, subject, message) VALUES (?, ?, ?, ?)";

        // Подготовка и выполнение запроса
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("ssss", $author, $email, $subject, $message);
            
            if ($stmt->execute()) {
                // Перенаправление на ту же страницу с параметром "message_sent"
                header("Location: index.php?message_sent=1");
                exit();
            } else {
                echo "Ошибка: " . $stmt->error;
            }

            $stmt->close();
        } else {
            echo "Ошибка подготовки запроса: " . $conn->error;
        }
    } else {
        echo "Пожалуйста, заполните все поля формы.";
    }

    $conn->close();
}
?>