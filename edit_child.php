<?php
session_start();
include 'connection_db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Проверяем, все ли данные о ребенке переданы
    if (empty($_POST["child_first_name"]) || empty($_POST["child_second_name"]) || empty($_POST["child_dob"]) || empty($_POST["child_gender"])) {
        echo "Ошибка: Не все данные о ребенке были переданы.";
        exit();
    }

    // Получаем данные из формы
    $child_first_name = $_POST["child_first_name"];
    $child_second_name = $_POST["child_second_name"];
    $child_dob = $_POST["child_dob"];
    $child_gender = $_POST["child_gender"];

    // Получаем ID родителя
    $username = $_SESSION["username"];
    $sql_user_id = "SELECT user_id FROM users WHERE username='$username'";
    $result_user_id = $conn->query($sql_user_id);
    if ($result_user_id->num_rows > 0) {
        $row_user_id = $result_user_id->fetch_assoc();
        $parent_id = $row_user_id["user_id"];

        // Вставляем данные о новом ребенке в таблицу children
        $sql_insert_child = "INSERT INTO children (parent_id, first_name, second_name, date_of_birth, gender) VALUES ('$parent_id', '$child_first_name', '$child_second_name', '$child_dob', '$child_gender')";
        if ($conn->query($sql_insert_child) === TRUE) {
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
            Ребенок успешно добавлен. </a>
            <button onclick="history.go(-1);" style=" margin: 15px; width: 200px; height: 60px; border: none; text-decoration: none; background: #a9def8; font-size: 1.2em; border: 1px solid #000; border-radius: 3px; display: flex; align-items: center; justify-content: center; color: #000; font: 14px / 1.6 "Comfortaa";"> 
            Вернуться на страницу личного кабинета </button>
            </div>
            </body>
            </html>';
        } else {
            echo "Ошибка при добавлении ребенка: " . $conn->error;
        }
    } else {
        echo "Ошибка: Пользователь не найден.";
    }
} else {
    echo "Ошибка: Неверный метод запроса.";
}

$conn->close();
?>
