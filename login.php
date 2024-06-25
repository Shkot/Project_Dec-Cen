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
        $sql = "SELECT password, role FROM users WHERE username='$username'";

        //$sql = "SELECT id, username, role FROM users WHERE username = '$username' AND password = '$password'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $hashed_password = $row["password"];
            $role = $row["role"];

            // Проверяем соответствие хешей
            if (password_verify($password, $hashed_password)) {
                // Если пароль верный, сохраняем имя пользователя в сессии
                $_SESSION["username"] = $username;
                $_SESSION["role"] = $role;
                
            if ($role === 'admin') {
                header("Location: index_admin.php"); // Перенаправляем пользователя на страницу приветствия
                exit();
            } else {
                header("Location: LK.php"); // Перенаправляем пользователя на страницу приветствия
                        exit();
            }
            } else {
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
                <div style="
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    margin-top: 40vh;
                    flex-direction: column;">
                <a style="
                    font-size: 25px;
                    color: #000000;
                    text-align: center;"> 
                Неверное имя пользователя или пароль. </a>
                <button onclick="history.go(-1);" style="
                    margin: 15px;
                    width: 200px;
                    height: 60px;
                    border: none;
                    text-decoration: none;
                    background: #a9def8;
                    font-size: 1.2em;
                    border: 1px solid #000;
                    border-radius: 3px;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    color: #000;
                    font: 14px / 1.6 "Comfortaa";"> 
                Вернуться на главную страницу </button>
                </div>
                </body>
                </html>';
            }
        } else {
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
            <div style="
                display: flex;
                justify-content: center;
                align-items: center;
                margin-top: 40vh;
                flex-direction: column;">
            <a style="
                font-size: 25px;
                color: #000000;
                text-align: center;"> 
                Пользователь с таким именем не найден. </a>
            <button onclick="history.go(-1);" style="
                margin: 15px;
                width: 200px;
                height: 60px;
                border: none;
                text-decoration: none;
                background: #a9def8;
                font-size: 1.2em;
                border: 1px solid #000;
                border-radius: 3px;
                display: flex;
                align-items: center;
                justify-content: center;
                color: #000;
                font: 14px / 1.6 "Comfortaa";"> 
            Вернуться на главную страницу </button>
            </div>
            </body>
            </html>';
            
        }
    }
}

$conn->close();
?>
