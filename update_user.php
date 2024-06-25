<?php
// Подключение к базе данных
include 'connection_db.php';

// Проверка метода запроса
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Инициализация переменных текущих данных пользователя
    session_start();
    $username = $_SESSION['username']; // Предполагается, что текущий логин пользователя хранится в сессии

    // Обработка изменения данных
    if (isset($_POST['update_field'])) {
        $update_field = $_POST['update_field'];
        $new_value = '';

        switch ($update_field) {
            case 'username':
                if (isset($_POST['new_username']) && !empty($_POST['new_username'])) {
                    $new_value = $_POST['new_username'];
                    $sql = "UPDATE users SET username='$new_value' WHERE username='$username'";
                } else {
                    $sql = ''; // Если поле не заполнено, установить $sql в пустую строку
                }
                break;
            case 'name':
                if (isset($_POST['new_name']) && !empty($_POST['new_name'])) {
                    $new_value = $_POST['new_name'];
                    $sql = "UPDATE users SET name='$new_value' WHERE username='$username'";
                } else {
                    $sql = ''; // Если поле не заполнено, установить $sql в пустую строку
                }
                break;
            case 'familiya':
                if (isset($_POST['new_familiya']) && !empty($_POST['new_familiya'])) {
                    $new_value = $_POST['new_familiya'];
                    $sql = "UPDATE users SET familiya='$new_value' WHERE username='$username'";
                } else {
                    $sql = ''; // Если поле не заполнено, установить $sql в пустую строку
                }
                break;
            case 'otchestvo':
                if (isset($_POST['new_otchestvo']) && !empty($_POST['new_otchestvo'])) {
                    $new_value = $_POST['new_otchestvo'];
                    $sql = "UPDATE users SET otchestvo='$new_value' WHERE username='$username'";
                } else {
                    $sql = ''; // Если поле не заполнено, установить $sql в пустую строку
                }
                break;
            case 'phone':
                if (isset($_POST['new_phone']) && !empty($_POST['new_phone'])) {
                    $new_value = $_POST['new_phone'];
                    $sql = "UPDATE users SET phone='$new_value' WHERE username='$username'";
                } else {
                    $sql = ''; // Если поле не заполнено, установить $sql в пустую строку
                }
                break;
            default:
                $sql = ''; // В случае, если $update_field не соответствует ожидаемым значениям, установить $sql в пустую строку
                break;
        }

        if ($sql && $conn->query($sql) === TRUE) {
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
            Данные успешно обновлены. </a>
            <button onclick="history.go(-1);" style=" margin: 15px; width: 200px; height: 60px; border: none; text-decoration: none; background: #a9def8; font-size: 1.2em; border: 1px solid #000; border-radius: 3px; display: flex; align-items: center; justify-content: center; color: #000; font: 14px / 1.6 "Comfortaa";"> 
            Вернуться на страницу личного кабинета </button>
            </div>
            </body>
            </html>';
            if ($update_field === 'username') {
                $_SESSION['username'] = $new_value; // Обновляем текущий логин пользователя в сессии
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
            <div style="display: flex; justify-content: center; align-items: center; margin-top: 40vh; flex-direction: column;">
            <a style="font-size: 25px; color: #000000; text-align: center;"> 
            Ошибка при обновлении данных: </a>
            <button onclick="history.go(-1);" style=" margin: 15px; width: 200px; height: 60px; border: none; text-decoration: none; background: #a9def8; font-size: 1.2em; border: 1px solid #000; border-radius: 3px; display: flex; align-items: center; justify-content: center; color: #000; font: 14px / 1.6 "Comfortaa";"> 
            Вернуться на страницу личного кабинета </button>
            </div>
            </body>
            </html>' . $conn->error;
        }
    }
}
?>