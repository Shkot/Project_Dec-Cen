<?php
// Подключение к базе данных
include 'connection_db.php';

// Получение username из сессии
session_start();
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];

    // Получение user_id по username
    $sql_user_id = "SELECT user_id FROM users WHERE username=?";
    $stmt_user_id = $conn->prepare($sql_user_id);
    $stmt_user_id->bind_param("s", $username);
    $stmt_user_id->execute();
    $result_user_id = $stmt_user_id->get_result();

    if ($result_user_id->num_rows > 0) {
        $row_user_id = $result_user_id->fetch_assoc();
        $user_id = $row_user_id["user_id"];

        // Получение данных из формы
        $child_first_name = $_POST['child_first_name'];
        $child_second_name = $_POST['child_second_name'];
        $child_date_of_birth = $_POST['child_date_of_birth'];
        $child_gender = $_POST['child_gender'];

        // Проверка наличия данных
        if(empty($child_first_name) || empty($child_second_name) || empty($child_date_of_birth) || empty($child_gender)) {
            echo "Пожалуйста, заполните все поля.";
            exit();
        }

        // Запрос для добавления нового ребенка
        $sql_add_child = "INSERT INTO children (parent_id, first_name, second_name, date_of_birth, gender) VALUES (?, ?, ?, ?, ?)";
        $stmt_add_child = $conn->prepare($sql_add_child);
        $stmt_add_child->bind_param("issss", $user_id, $child_first_name, $child_second_name, $child_date_of_birth, $child_gender);

        // Выполнение запроса
        if ($stmt_add_child->execute()) {
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
            Данные ребенка успешно добавлены. </a>
            <button onclick="history.go(-1);" style=" margin: 15px; width: 200px; height: 60px; border: none; text-decoration: none; background: #a9def8; font-size: 1.2em; border: 1px solid #000; border-radius: 3px; display: flex; align-items: center; justify-content: center; color: #000; font: 14px / 1.6 "Comfortaa";"> 
            Вернуться на страницу личного кабинета </button>
            </div>
            </body>
            </html>';
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
            Ошибка при добавлении данных ребенка. </a>
            <button onclick="history.go(-1);" style=" margin: 15px; width: 200px; height: 60px; border: none; text-decoration: none; background: #a9def8; font-size: 1.2em; border: 1px solid #000; border-radius: 3px; display: flex; align-items: center; justify-content: center; color: #000; font: 14px / 1.6 "Comfortaa";"> 
            Вернуться на страницу личного кабинета </button>
            </div>
            </body>
            </html>' . $conn->error;
        }

        // Закрытие подготовленного запроса
        $stmt_add_child->close();
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
        Ошибка: Не удалось найти пользователя с таким username. </a>
        <button onclick="history.go(-1);" style=" margin: 15px; width: 200px; height: 60px; border: none; text-decoration: none; background: #a9def8; font-size: 1.2em; border: 1px solid #000; border-radius: 3px; display: flex; align-items: center; justify-content: center; color: #000; font: 14px / 1.6 "Comfortaa";"> 
        Вернуться на страницу личного кабинета </button>
        </div>
        </body>
        </html>';
    }

    // Закрытие подготовленного запроса и соединения с базой данных
    $stmt_user_id->close();
    $conn->close();
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
    Ошибка: Не удалось получить username из сессии. </a>
    <button onclick="history.go(-1);" style=" margin: 15px; width: 200px; height: 60px; border: none; text-decoration: none; background: #a9def8; font-size: 1.2em; border: 1px solid #000; border-radius: 3px; display: flex; align-items: center; justify-content: center; color: #000; font: 14px / 1.6 "Comfortaa";"> 
    Вернуться на страницу личного кабинета </button>
    </div>
    </body>
    </html>';
}
?>
