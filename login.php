<?php
session_start(); // Начинаем сессию

include 'connection_db.php'; // Подключение к базе данных

// Обработка данных формы
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["login"])) { // Проверяем, была ли нажата кнопка входа
        // Получаем данные из формы
        $username = $_POST["username"];
        $password = $_POST["password"];

        // Защита от SQL-инъекций
        $username = $conn->real_escape_string($username);

        // Запрос к базе данных для получения хеша пароля
        $sql = "SELECT password FROM users WHERE username='$username'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $hashed_password = $row["password"];

            // Проверяем соответствие хешей
            if (password_verify($password, $hashed_password)) {
                // Если пароль верный, сохраняем имя пользователя в сессии
                $_SESSION["username"] = $username;
                header("Location: LK.php"); // Перенаправляем пользователя на страницу приветствия
                exit();
            } else {
                echo "Неверное имя пользователя или пароль.";
            }
        } else {
            echo "Пользователь с таким именем не найден.";
        }
    }
}

$conn->close();
?>
